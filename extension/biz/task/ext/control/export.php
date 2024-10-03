<?php
helper::importControl('task');
class mytask extends task
{
    public function export($executionID, $orderBy, $type)
    {
        $this->loadModel('transfer');
        $this->session->set('taskTransferParams', array('executionID' => $executionID));

        $execution = $this->execution->getById($executionID);

        if(!$execution->multiple) $this->config->task->exportFields = str_replace('execution,', 'project,', $this->config->task->exportFields);

        $allExportFields = $this->config->task->exportFields;
        if($execution->type == 'ops') $allExportFields = str_replace(' story,', '', $allExportFields);

        if($_POST)
        {
            if($this->post->excel == 'excel')
            {
                /* Get users and executions. */
                $users = $this->loadModel('user')->getPairs('noletter');
                $trees = $this->execution->getTree($this->post->executionID);
                $trees = $this->treeToList($trees, $users);
                $this->post->set('exportFields', array('id','title','startTime','assignedTo','pri'));
                $this->post->set('fileType', 'xlsx');
                $this->post->set('fields', $this->lang->task->field);
                $this->post->set('rows', $trees);
                $this->post->set('kind', 'tree');
                unset($_POST['moduleList']);
                unset($_POST['storyList']);
                unset($_POST['priList']);
                unset($_POST['typeList']);
                unset($_POST['listStyle']);
                unset($_POST['extraNum']);
                unset($_POST['excel']);
                $this->fetch('file', 'export2' . $this->post->fileType, $_POST);
            }

            $this->session->set('taskTransferParams', array('executionID' => $executionID));
            /* Get tasks. */
            $tasks = $this->transfer->getQueryDatas('task');
            $tasks = $this->processData4Task($tasks);

            $this->post->set('rows', $tasks);
            $this->loadModel('file');
            $this->fetch('transfer', 'export', 'model=task&params=executionID=' . $executionID);
        }

        $this->app->loadLang('execution');
        $fileName = $this->lang->task->common;
        $executionName = $this->dao->findById($executionID)->from(TABLE_EXECUTION)->fetch('name');
        if(isset($this->lang->execution->featureBar['task'][$type]))
        {
            $browseType = $this->lang->execution->featureBar['task'][$type];
        }
        else
        {
            $browseType = isset($this->lang->execution->statusSelects[$type]) ? $this->lang->execution->statusSelects[$type] : '';
        }

        $this->view->fileName        = $executionName . $this->lang->dash . $browseType . $fileName;
        $this->view->allExportFields = $allExportFields;
        $this->view->customExport    = true;
        $this->view->orderBy         = $orderBy;
        $this->view->type            = $type;
        $this->view->executionID     = $executionID;
        $this->display();
    }

    /**
     * Process data for tasks .
     *
     * @param  array  $datas
     * @access public
     * @return void
     */
    public function processData4Task($datas = array())
    {
        if(empty($datas)) return $datas;
        foreach($datas as $id => $task)
        {
            /* Compute task progress. */
            if($task->consumed == 0 and $task->left == 0)
            {
                $task->progress = 0;
            }
            elseif($task->consumed != 0 and $task->left == 0)
            {
                $task->progress = 100;
            }
            else
            {
                $task->progress = round($task->consumed / ($task->consumed + $task->left), 2) * 100;
            }
            $task->progress .= '%';
        }

        /* Get users and executions. */
        $users = $this->loadModel('user')->getPairs('noletter');

        /* Get team for multiple task. */
        $taskTeam = $this->dao->select('*')->from(TABLE_TASKTEAM)->where('task')->in(array_keys($datas))->fetchGroup('task');

        /* Process multiple task info. */
        if(!empty($taskTeam))
        {
            foreach($taskTeam as $taskID => $team)
            {
                $datas[$taskID]->estimate = '';
                $datas[$taskID]->left     = '';
                $datas[$taskID]->consumed = '';

                foreach($team as $userInfo)
                {
                    $datas[$taskID]->estimate .= zget($users, $userInfo->account) . "(#$userInfo->account)" . ':' . $userInfo->estimate . "\n";
                    $datas[$taskID]->left     .= zget($users, $userInfo->account) . "(#$userInfo->account)" . ':' . $userInfo->left . "\n";
                    $datas[$taskID]->consumed .= zget($users, $userInfo->account) . "(#$userInfo->account)" . ':' . $userInfo->consumed . "\n";
                }
            }
        }

        return $datas;
    }

    /**
     * Tree to list.
     *
     * @param  int    $trees
     * @param  int    $users
     * @access public
     * @return void
     */
    public function treeToList($trees, $users)
    {
        $rows = array();
        foreach($trees as $tree)
        {
            if($tree->type == 'module')
            {
                $rows[] = (object)array('title' => $this->lang->task->module . $tree->name);
                if(isset($tree->children) and !empty($tree->children))
                {
                    foreach($tree->children as $tasks)
                    {
                        $rows[] = (object)array('title' => str_repeat(' ' , 2) . $this->lang->task->taskName . $tasks->title , 'assignedTo' => zget($users, $tasks->assignedTo),'pri' => $tasks->pri, 'id' => $tasks->id);
                        if(isset($tasks->children) and !empty($tasks->children))
                        {
                            foreach($tasks->children as $childrenTasks)
                            {
                                $startTime = $this->dao->select('date')->from(TABLE_ACTION)->where('objectType')->eq('task')->andWhere('objectID')->eq($childrenTasks->id)->andWhere('action')->eq('started')->fetch();
                                $rows[] = (object)array('title' => str_repeat(' ' , 4)  . $this->lang->task->taskName . $childrenTasks->title , 'id' => $childrenTasks->id,'startTime' => isset($startTime->date) ? $startTime->date : '', 'assignedTo' => zget($users, $childrenTasks->assignedTo), 'pri' => $childrenTasks->pri);
                            }
                        }
                    }
                }
            }
        }
        return $rows;
    }
}
