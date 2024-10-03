<?php
class myStakeholder extends stakeholder
{
    /**
     * Get expected list data.
     *
     * @param  string $browseType
     * @param  string orderBy
     * @param  int recTotal
     * @param  int recPerPage
     * @param  int pageID
     * @access public
     * @return void
     */
    public function expectation($browseType = 'all', $param = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->config->stakeholder->search['params']['userID']['values'] = $this->stakeholder->getStakeholderUsers();

        /* Build the search form. */
        $queryID   = ($browseType == 'bysearch') ? (int)$param : 0;
        $actionURL = $this->createLink('stakeholder', 'expectation', "browseType=bysearch&queryID=myQueryID");
        $this->stakeholder->buildSearchForm($actionURL, $queryID);

        $this->app->loadClass('pager', true);
        $pager   = pager::init($recTotal, $recPerPage, $pageID);
        $expects = $this->stakeholder->getExpectList($browseType, $queryID, $orderBy, $pager);

        $this->view->title      = $this->lang->stakeholder->common . $this->lang->colon . $this->lang->stakeholder->expectation;
        $this->view->position[] = $this->lang->stakeholder->view;

        $this->view->pager        = $pager;
        $this->view->recTotal     = $recTotal;
        $this->view->recPerPage   = $recPerPage;
        $this->view->pageID       = $pageID;
        $this->view->param        = $param;
        $this->view->orderBy      = $orderBy;
        $this->view->browseType   = $browseType;
        $this->view->expects      = $expects;
        $this->view->users        = $this->loadModel('user')->getPairs('noletter|noclosed');

        $this->display();
    }
}
