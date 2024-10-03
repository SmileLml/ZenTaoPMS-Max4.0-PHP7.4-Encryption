<?php
class feedbackTask extends taskModel
{
    /**
     * Create task from feedback.
     *
     * @param  int    $executionID
     * @access public
     * @return int|bool
     */
    public function create($executionID = 0, $bugID = 0)
    {
        $feedbackID = $this->post->feedback;
        $tasksID = parent::create($executionID, $bugID);

        if($tasksID)
        {
            /* If task is from feedback, record action for feedback. */
            if($feedbackID > 0)
            {
                foreach($tasksID as $taskID)
                {
                    $taskID = $taskID['id'];
                    $feedback = new stdclass();
                    $feedback->status        = 'commenting';
                    $feedback->result        = $taskID;
                    $feedback->processedBy   = $this->app->user->account;
                    $feedback->processedDate = helper::now();
                    $feedback->solution      = 'totask';

                    $this->dao->update(TABLE_FEEDBACK)->data($feedback)->where('id')->eq($feedbackID)->exec();

                    $actionID = $this->loadModel('action')->create('feedback', $feedbackID, 'ToTask', '', $taskID);

                    $feedbackFiles = $this->loadModel('file')->getByObject('feedback', $feedbackID);
                    if($feedbackFiles)
                    {
                        foreach($feedbackFiles as $feedbackFile)
                        {
                            unset($feedbackFile->id);
                            $feedbackFile->objectType = 'task';
                            $feedbackFile->objectID   = $taskID;
                            $this->dao->insert(TABLE_FILE)->data($feedbackFile, 'webPath,realPath')->exec();
                        }
                    }
                }
            }
            return $tasksID;
        }
        return false;
    }
}
