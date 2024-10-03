<?php
class myStakeholder extends stakeholder
{
    /**
     * Expect details.
     *
     * @access public
     * @param  int  $expectID
     * @return void
    */
    public function viewExpect($expectID = 0)
    {
        $this->commonAction($expectID, 'expect');
        $expect = $this->stakeholder->getExpectByID($expectID);

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->viewExpect;
        $this->view->position[] = $this->lang->stakeholder->viewExpect;

        $this->view->expect     = $expect;
        $this->view->user       = $this->stakeholder->getByID($expect->userID);
        $this->view->users      = $this->loadModel('user')->getTeamMemberPairs($this->session->project , 'project', 'nodeleted');

        $this->display();
    }
}
