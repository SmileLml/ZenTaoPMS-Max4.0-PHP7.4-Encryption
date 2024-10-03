<?php
class feedbackStory extends storyModel
{
    /**
     * Create story from feedback.
     *
     * @param  int    $executionID
     * @param  int    $bugID
     * @param  string $from
     * @access public
     * @return array|bool
     */
    public function create($executionID = 0, $bugID = 0, $from = '', $extra = '')
    {
        $result = parent::create($executionID, $bugID, $from, $extra);

        if($result)
        {
            $storyID    = $result['id'];
            $type       = $this->post->type;

            /* If story is from feedback, record action for feedback and add files to story from feedback. */
            if($this->post->feedback)
            {
                $feedbackID = $this->post->feedback;

                $feedback = new stdclass();
                $feedback->status        = 'commenting';
                $feedback->result        = $storyID;
                $feedback->processedBy   = $this->app->user->account;
                $feedback->processedDate = helper::now();
                $feedback->solution      = $type == 'story' ? 'tostory' : 'touserstory';

                $this->dao->update(TABLE_FEEDBACK)->data($feedback)->where('id')->eq($feedbackID)->exec();

                $actionID = $this->loadModel('action')->create('feedback', $feedbackID, $type == 'story' ? 'ToStory' : 'ToUserStory', '', $storyID);

                $feedbackFiles = $this->loadModel('file')->getByObject('feedback', $feedbackID);
                if($feedbackFiles)
                {
                    foreach($feedbackFiles as $feedbackFile)
                    {
                        unset($feedbackFile->id);
                        $feedbackFile->objectType = 'story';
                        $feedbackFile->objectID   = $storyID;
                        $this->dao->insert(TABLE_FILE)->data($feedbackFile, 'webPath,realPath')->exec();
                    }
                }
            }

            /* If story is from feedback, record action for feedback and add files to story from feedback. */
            if($this->post->ticket)
            {
                $ticketID = $this->post->ticket;

                $ticket = new stdClass();
                $ticket->ticketId   = $ticketID;
                $ticket->objectId   = $storyID;
                $ticket->objectType = 'story';

                $this->dao->insert(TABLE_TICKETRELATION)->data($ticket)->exec();

                $actionID = $this->loadModel('action')->create('ticket', $ticketID, 'ToStory', '', $storyID);
            }

            return $result;
        }
        return false;
    }

    /**
     * Get story by id.
     *
     * @param  int    $storyID
     * @param  int    $version
     * @param  int    $setImgSize
     * @access public
     * @return object
     */
    public function getById($storyID, $version = 0, $setImgSize = false)
    {
        $story = parent::getById($storyID, $version, $setImgSize);

        if(!empty($story->feedback))
        {
            $feedback = $this->loadModel('feedback')->getById($story->feedback);
            $story->feedbackTitle = $feedback->title;
        }

        return $story;
    }
}
