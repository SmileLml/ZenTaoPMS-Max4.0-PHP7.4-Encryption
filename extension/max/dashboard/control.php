<?php
/**
 * The control file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: model.php 5086 2013-07-10 02:25:22Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class dashboard extends control
{
    /**
     * Browse dashboards.
     *
     * @param string $orderBy
     * @param int $recTotal
     * @param int $recPerPage
     * @param int $pageID
     * @access public
     * @return void
     */
    public function browse($browseType = 'all', $param = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->loadModel('tree');
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $moduleID = $browseType == 'bymodule' ? $param : 0;

        $this->view->title      = $this->lang->dashboard->common;
        $this->view->browseType = $browseType;
        $this->view->param      = $param;
        $this->view->orderBy    = $orderBy;
        $this->view->moduleID   = $moduleID;
        $this->view->moduleName = $moduleID ? $this->dao->findByID($moduleID)->from(TABLE_MODULE)->fetch('name') : $this->lang->dashboard->allModule;
        $this->view->moduleTree = $this->tree->getTreeMenu(0, 'dashboard', 0, array('treeModel', 'createDashboardLink'));;
        $this->view->dashboards = $this->dashboard->getList($moduleID, $orderBy, $pager);
        $this->view->pager      = $pager;
        $this->display();
    }

    /**
     * Browse dashboards.
     *
     * @param string $orderBy
     * @param int $recTotal
     * @param int $recPerPage
     * @param int $pageID
     * @access public
     * @return void
     */
    public function browseReport($browseType = 'all', $param = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->loadModel('tree');
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $moduleID = $browseType == 'bymodule' ? $param : 0;

        $this->view->title      = $this->lang->bi->dashboard;
        $this->view->browseType = $browseType;
        $this->view->param      = $param;
        $this->view->orderBy    = $orderBy;
        $this->view->moduleID   = $moduleID;
        $this->view->moduleName = $moduleID ? $this->dao->findByID($moduleID)->from(TABLE_MODULE)->fetch('name') : $this->lang->dashboard->allModule;
        $this->view->moduleTree = $this->tree->getTreeMenu(0, 'dashboard', 0, array('treeModel', 'createDashboardLink'));;
        $this->view->dashboards = $this->dashboard->getList($moduleID, $orderBy, $pager);
        $this->view->pager      = $pager;
        $this->display();
    }

    /**
     * Create dashboard.
     *
     * @access public
     * @return void
     */
    public function create()
    {
        if(!empty($_POST))
        {
            $dashboardID = $this->dashboard->create();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('dashboard', $dashboardID, 'opened');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('dashboard', 'design', "dashboardID=$dashboardID")));
        }

        $this->view->modulePairs = $this->loadModel('tree')->getOptionMenu(0, 'dashboard', $startModuleID = 0);
        $this->view->title       = $this->lang->dashboard->create;
        $this->display();
    }

    /**
     * Edit dashboard.
     *
     * @param  int $dashboardID
     * @access public
     * @return void
     */
    public function edit($dashboardID)
    {
        if(!empty($_POST))
        {
            $this->dashboard->update($dashboardID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('dashboard', $dashboardID, 'edited');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('dashboard', 'browse')));
        }

        $dashboard = $this->dashboard->getByID($dashboardID, true);

        $this->view->dashboard   = $dashboard;
        $this->view->modulePairs = $this->loadModel('tree')->getOptionMenu(0, 'dashboard', $startModuleID = 0);
        $this->view->title       = $this->lang->dashboard->edit;
        $this->display();
    }

    /**
     * Design dashboard.
     *
     * @param  int $dashboardID
     * @access public
     * @return void
     */
    public function design($dashboardID)
    {
        if(!empty($_POST))
        {
            $this->dashboard->update($dashboardID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('dashboard', $dashboardID, 'designed');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('dashboard', 'view', "id=$dashboardID")));
        }
        $this->app->loadLang('dataset');

        $dashboard = $this->dashboard->getByID($dashboardID, true);
        $filters   = $this->loadModel('dataset')->getFilters($dashboard->datasets);

        /* Options. */
        $sysOptions = array();
        foreach($dashboard->filters as $filter)
        {
            if(isset($filters['option'][$filter->field]))
            {
                $type = $filters['option'][$filter->field]['type'];
                if($type != 'option') $sysOptions[$type] = array();
            }
        }
        list($sysOptions, $defaults) = $this->dataset->getSysOptions($sysOptions);

        $this->view->dashboard  = $dashboard;
        $this->view->datasets   = $this->dao->select('id,name')->from(TABLE_DATASET)->where('deleted')->eq(0)->fetchPairs('id');
        $this->view->charts     = $this->loadModel('chart')->getList();
        $this->view->filters    = $filters;
        $this->view->sysOptions = (Object)$sysOptions;
        $this->view->defaults   = (Object)$defaults;
        $this->view->title      = $this->lang->dashboard->design;
        $this->display();
    }

    /**
     * Ajax get filters
     *
     * @param string $datasets
     * @access public
     * @return void
     */
    public function ajaxGetFilters($datasets)
    {
        $datasets = explode(',', $datasets);
        echo json_encode($this->loadModel('dataset')->getFilters($datasets));
    }

    /**
     * Ajax set info
     *
     * @access public
     * @return void
     */
    public function ajaxSetInfo($dashboardID)
    {
        $this->dashboard->setInfo($dashboardID, $this->post->values, $this->post->title, $this->post->desc);
    }

    /**
     * View dashboard.
     *
     * @param  int $dashboardID
     * @access public
     * @return void
     */
    public function view($dashboardID)
    {
        $this->app->loadLang('dataset');

        $dashboard = $this->dashboard->getByID($dashboardID, true);
        $filters   = $this->loadModel('dataset')->getFilters($dashboard->datasets);

        /* Options. */
        $sysOptions = array();
        foreach($dashboard->filters as $filter)
        {
            if(isset($filters['option'][$filter->field]))
            {
                $type = $filters['option'][$filter->field]['type'];
                if($type != 'option') $sysOptions[$type] = array();
            }
        }
        list($sysOptions, $defaults) = $this->dataset->getSysOptions($sysOptions);

        $this->view->dashboard  = $dashboard;
        $this->view->filters    = $filters;
        $this->view->sysOptions = (Object)$sysOptions;
        $this->view->defaults   = (Object)$defaults;
        $this->view->title      = $dashboard->name;
        $this->display();
    }

    /**
     * Ajax get layout.
     *
     * @param int $dashboardID
     * @access public
     * @return void
     */
    public function ajaxGetLayout($dashboardID)
    {
        $dashboard = $this->dashboard->getByID($dashboardID);
        $users = $this->loadModel('user')->getPairs('noletter');
        $data = $this->dashboard->getLayoutData($dashboard->layout, $this->post->filters, $users, $this->post->filters);
        echo json_encode($data);
    }

    /**
     * Delete a dashboard.
     *
     * @param  int    $dashboardID
     * @param  string $confirm  yes|no
     * @param  string $from taskkanban
     * @access public
     * @return void
     */
    public function delete($dashboardID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->dashboard->confirmDelete, inlink('delete', "id=$dashboardID&confirm=yes")));
        }
        else
        {
            $this->dashboard->delete(TABLE_DASHBOARD, $dashboardID);

            if($this->viewType == 'json') return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));

            if(isonlybody()) return print(js::reload('parent.parent'));

            $locateLink = $this->session->dashboardList ? $this->session->dashboardList : inlink('browse');
            return print(js::locate($locateLink, 'parent'));
        }
    }
}
