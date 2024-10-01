<?php
$action = $this->getById($actionID);
if($action->objectType == 'user')
{
    $user = $this->dao->select('*')->from(TABLE_USER)->where('id')->eq($action->objectID)->fetch();
    if($this->loadModel('user')->checkBizUserLimit($user->visions == 'lite' ? 'lite' : 'user'))
    {
        if($user->visions != 'lite') die(js::alert($this->lang->user->noticeUserLimit));
        if($user->visions == 'lite') die(js::alert($this->lang->user->noticeFeedbackUserLimit));
    }
}
