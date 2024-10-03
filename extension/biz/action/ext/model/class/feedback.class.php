<?php
class feedbackAction extends actionModel
{
    public function getList($objectType, $objectID)
    {
        $actions = parent::getList($objectType, $objectID);

        $this->loadModel('execution');
        foreach($actions as $action)
        {
            if($action->action == 'fromfeedback')
            {
                $title = $this->dao->select('title')->from(TABLE_FEEDBACK)->where('id')->eq($action->extra)->fetch('title');
                if($title) $action->extra = html::a(helper::createLink('feedback', 'adminview', "feedbackID=$action->extra"), "#$action->extra " . $title, '', "data-app=feedback");
            }
            if($action->objectType == 'feedback' and $action->action == 'totodo')
            {
                $name = $this->dao->select('name')->from(TABLE_TODO)->where('id')->eq($action->extra)->fetch('name');
                if($name) $action->extra = html::a(helper::createLink('todo', 'view', "todoID=$action->extra"), "#$action->extra " . $name);
            }
            if($action->objectType == 'feedback' and $action->action == 'totask')
            {
                $task = $this->dao->select('name,execution')->from(TABLE_TASK)->where('id')->eq($action->extra)->fetch();
                if($task)
                {
                    $execution = $this->execution->getByID($task->execution);
                    $taskLink  = $execution->type == 'kanban' ? helper::createLink('execution', 'kanban', "executionID=$task->execution") : helper::createLink('task', 'view', "task=$action->extra");
                    $action->extra = html::a($taskLink, "#$action->extra " . $task->name, '', $execution->multiple ? "data-app=execution" : "data-app=project");
                }
            }
            if($action->objectType == 'feedback' and ($action->action == 'tostory' or $action->action == 'touserstory'))
            {
                $name = $this->dao->select('title')->from(TABLE_STORY)->where('id')->eq($action->extra)->fetch('title');
                if($name) $action->extra = html::a(helper::createLink('story', 'view', "storyID=$action->extra"), "#$action->extra " . $name);
            }
            if($action->objectType == 'feedback' and $action->action == 'tobug')
            {
                $name = $this->dao->select('title')->from(TABLE_BUG)->where('id')->eq($action->extra)->fetch('title');
                if($name) $action->extra = html::a(helper::createLink('bug', 'view', "storyID=$action->extra"), "#$action->extra " . $name);
            }
            if($action->objectType == 'feedback' and $action->action == 'toticket')
            {
                $name = $this->dao->select('title')->from(TABLE_TICKET)->where('id')->eq($action->extra)->fetch('title');
                if($name) $action->extra = html::a(helper::createLink('ticket', 'view', "ticketID=$action->extra"), "#$action->extra " . $name);
            }
            if($action->objectType == 'feedback' and $action->action == 'closed' and strpos($action->extra ,'repeat') !== false)
            {
                $extra  = explode(':', $action->extra);
                $method = 'adminview';

                if($this->config->vision == 'lite') $method = 'view';

                if(isset($extra[1]))
                {
                    $name = $this->dao->select('title')->from(TABLE_FEEDBACK)->where('id')->eq($extra[1])->fetch('title');

                    $action->extra = zget($this->lang->feedback->closedReasonList, $extra[0]);
                    if(!empty($name)) $action->extra = zget($this->lang->feedback->closedReasonList, $extra[0]) . html::a(helper::createLink('feedback', $method, "feedbackID={$extra[1]}"), "#{$extra[1]} " . $name);
                }
            }

            if($action->action == 'fromticket')
            {
                $title = $this->dao->select('title')->from(TABLE_TICKET)->where('id')->eq($action->extra)->fetch('title');
                if($title) $action->extra = html::a(helper::createLink('ticket', 'view', "ticketID=$action->extra"), "#$action->extra " . $title);
            }
            if($action->objectType == 'ticket' and $action->action == 'tostory')
            {
                $name = $this->dao->select('title')->from(TABLE_STORY)->where('id')->eq($action->extra)->fetch('title');
                if($name) $action->extra = html::a(helper::createLink('story', 'view', "storyID=$action->extra"), "#$action->extra " . $name);
            }
            if($action->objectType == 'ticket' and $action->action == 'tobug')
            {
                $name = $this->dao->select('title')->from(TABLE_BUG)->where('id')->eq($action->extra)->fetch('title');
                if($name) $action->extra = html::a(helper::createLink('bug', 'view', "storyID=$action->extra"), "#$action->extra " . $name);
            }
        }
        return $actions;
    }

    public function getRelatedFields($objectType, $objectID, $actionType = '', $extra = '')
    {
        if($objectType == 'feedback')
        {
            $record = $this->dao->select('product')->from($this->config->objectTables[$objectType])->where('id')->eq($objectID)->fetch();
            return array('product' => ",{$record->product},", 'project' => 0, 'execution' => 0);
        }

        if($objectType == 'ticket')
        {
            $record = $this->dao->select('product')->from($this->config->objectTables[$objectType])->where('id')->eq($objectID)->fetch();
            return array('product' => ",{$record->product},", 'project' => 0, 'execution' => 0);
        }

        return parent::getRelatedFields($objectType, $objectID, $actionType, $extra);
    }

    public function printAction($action, $desc = '')
    {
        $desc = '';
        if(isset($action->from) and $action->from == 'feedback')
        {
            $objectType = $action->objectType;
            $objectID   = $action->objectID;
            $actionType = strtolower($action->action);
            $object     = $this->loadModel($objectType)->getById($objectID);
            $nameField  = zget($this->config->action->objectNameFields, $objectType, '');
            if($object and $nameField)
            {
                $objectDesc = $this->lang->$objectType->common . ' [<strong>' . html::a(helper::createLink($objectType, 'view', "id=$objectID"), $object->$nameField) . '</strong>] ';
                if($action->objectType == 'story' and $action->action == 'reviewed' and strpos($action->extra, ',') !== false)
                {
                    $desc = $this->lang->$objectType->action->rejectreviewed;
                }
                elseif(isset($this->lang->$objectType) && isset($this->lang->$objectType->action->$actionType))
                {
                    $desc = $this->lang->$objectType->action->$actionType;
                }
                elseif(isset($this->lang->action->desc->$actionType))
                {
                    $desc = $this->lang->action->desc->$actionType;
                }
                else
                {
                    $desc = $action->extra ? $this->lang->action->desc->extra : $this->lang->action->desc->common;
                }

                if(!isset($this->lang->$objectType->action)) $this->lang->$objectType->action = new stdclass();
                if(is_array($desc))
                {
                    $desc['main'] = str_replace('$date, ', '$date, ' . $objectDesc, $desc['main']);
                }
                else
                {
                    $desc = str_replace('$date, ', '$date, ' . $objectDesc, $desc);
                }
            }
        }
        return parent::printAction($action, $desc);
    }
}
