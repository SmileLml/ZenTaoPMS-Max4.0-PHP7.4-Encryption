<?php
helper::importControl('repo');
class myRepo extends repo
{
    /**
     * Show review.
     *
     * @param  int    $repoID
     * @param  string $browseType
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function review($repoID, $browseType = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        if($repoID == 0) $repoID = $this->repo->saveState($repoID);
        $this->commonAction($repoID);

        $browseType = strtolower($browseType);
        $this->app->loadLang('bug');
        $this->repo->setBackSession('list', true);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $bugs = $this->repo->getBugsByRepo($repoID, $browseType, array(), $orderBy, $pager);
        $repo = $this->repo->getRepoById($repoID);

        if($repo->SCM != 'Subversion')
        {
            $revisions = array();
            foreach($bugs as $bug)
            {
                $revisions[] = $bug->v2;
                if(!empty($bug->v1)) $revisions[] = $bug->v1;
            }
            $this->view->historys = $this->dao->select('revision,commit')->from(TABLE_REPOHISTORY)->where('revision')->in($revisions)->andWhere('repo')->eq($repoID)->fetchPairs('revision', 'commit');
        }

        $this->view->repos      = $this->repos;
        $this->view->repoGroup  = $this->repo->getRepoGroup($this->app->tab);
        $this->view->repoID     = $repoID;
        $this->view->repo       = $repo;
        $this->view->bugs       = $bugs;
        $this->view->pager      = $pager;
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->view->title      = $this->lang->repo->review;
        $this->view->browseType = $browseType;
        $this->display();
    }
}
