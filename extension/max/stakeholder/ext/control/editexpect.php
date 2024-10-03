<?php
class myStakeholder extends stakeholder
{
    /**
     * Edit expect.
     *
     * @param  int  $expectID
     * @access public
     * @return void
    */
    public function editExpect($expectID)
    {
        if($_POST)
        {
            $changes = $this->stakeholder->editExpect($expectID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $actionID = $this->loadModel('action')->create('expect', $expectID, 'Edited');

            $this->action->logHistory($actionID, $changes);
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inLink('expectation')));
        }

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->editExpect;
        $this->view->position[] = $this->lang->stakeholder->editExpect;

        $this->view->users  = $this->stakeholder->getStakeholderUsers();
        $this->view->expect = $this->stakeholder->getExpectByID($expectID);

        $this->display();
    }
}
