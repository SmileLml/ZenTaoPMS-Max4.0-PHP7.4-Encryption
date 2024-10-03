<?php
class myStakeholder extends stakeholder
{
	/**
     * Add expect.
     *
     * @access public
     * @return void
    */
    public function createExpect()
    {
        if($_POST)
        {
            $expectID = $this->stakeholder->expect();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $actionID = $this->loadModel('action')->create('expect', $expectID, 'Opened');
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inLink('expectation')));
        }

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->createExpect;
        $this->view->position[] = $this->lang->stakeholder->createExpect;

        $this->view->users = $this->stakeholder->getStakeholderUsers();

        $this->display();
    }
}
