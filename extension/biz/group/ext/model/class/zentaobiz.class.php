<?php
class zentaobizGroup extends groupModel
{
    public function create()
    {
        if(!empty($this->app->user->feedback) or $this->cookie->feedbackView)
        {
            $_POST['developer'] = 0;
        }

        return parent::create();
    }

    public function getPairs($projectID = 0)
    {
        if(!empty($this->app->user->feedback) or $this->cookie->feedbackView)
        {
            return $this->dao->select('id, name')->from(TABLE_GROUP)
                ->where('developer')->eq('0')
                ->andWhere('vision')->eq($this->config->vision)
                ->andWhere('project')->eq($projectID)
                ->fetchPairs();
        }

        return $this->dao->select('id, name')->from(TABLE_GROUP)
            ->where('developer')->eq('1')
            ->andWhere('vision')->eq($this->config->vision)
            ->andWhere('project')->eq($projectID)
            ->fetchPairs();
    }
}
