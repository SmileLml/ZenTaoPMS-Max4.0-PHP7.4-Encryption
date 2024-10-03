<?php
class zentaomaxExecution extends executionModel
{
    /**
     * Get taskes by search.
     *
     * @param  string $condition
     * @param  object $pager
     * @param  string $orderBy
     * @access public
     * @return array
     */
    public function getSearchTasks($condition, $pager, $orderBy)
    {
        $taskIdList = $this->dao->select('id')
            ->from(TABLE_TASK)
            ->where($condition)
            ->andWhere('deleted')->eq(0)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        $tasks = $this->dao->select('t1.*, t2.id AS storyID, t2.title AS storyTitle, t2.product, t2.branch, t2.version AS latestStoryVersion, t2.status AS storyStatus, t3.realname AS assignedToRealName, t4.name AS designName, t4.version AS latestDesignVersion')
             ->from(TABLE_TASK)->alias('t1')
             ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story = t2.id')
             ->leftJoin(TABLE_USER)->alias('t3')->on('t1.assignedTo = t3.account')
             ->leftJoin(TABLE_DESIGN)->alias('t4')->on('t1.design = t4.id')
             ->where('t1.deleted')->eq(0)
             ->andWhere('t1.id')->in(array_keys($taskIdList))
             ->orderBy($orderBy)
             ->fetchAll('id');

        if(empty($tasks)) return array();

        $taskTeam = $this->dao->select('*')->from(TABLE_TASKTEAM)->where('task')->in(array_keys($tasks))->fetchGroup('task');
        if(!empty($taskTeam))
        {
            foreach($taskTeam as $taskID => $team) $tasks[$taskID]->team = $team;
        }

        $parents = array();
        foreach($tasks as $task)
        {
            if($task->parent > 0) $parents[$task->parent] = $task->parent;
        }
        $parents = $this->dao->select('*')->from(TABLE_TASK)->where('id')->in($parents)->fetchAll('id');

        foreach($tasks as $task)
        {
            if($task->parent > 0)
            {
                if(isset($tasks[$task->parent]))
                {
                    $tasks[$task->parent]->children[$task->id] = $task;
                    unset($tasks[$task->id]);
                }
                else
                {
                    $parent = $parents[$task->parent];
                    $task->parentName = $parent->name;
                }
            }
        }
        return $this->loadModel('task')->processTasks($tasks);
    }
}
