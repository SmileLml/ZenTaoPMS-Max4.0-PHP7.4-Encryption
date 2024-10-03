<?php
/**
 * The control file of report module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     report
 * @link        https://www.zentao.net
 */
helper::importControl('report');
class myReport extends report
{
    /**
     * Task assignment summary.
     *
     * @param  date   $begin
     * @param  date   $end
     * @param  int    $dept
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function workAssignSummary($begin = 0, $end = 0, $dept = 0, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadLang('task');
        $begin = $begin ? date('Y-m-d', strtotime($begin)) : date('Y-m-d', strtotime('last month', strtotime(date('Y-m',time()) . '-01 00:00:01')));
        $end   = $end   ? date('Y-m-d', strtotime($end))   : date('Y-m-d', strtotime('now'));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title      = $this->lang->report->workAssignSummary;
        $this->view->position[] = $this->lang->report->workAssignSummary;

        $this->view->users     = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->depts     = $this->loadModel('dept')->getOptionMenu();
        $this->view->projects  = $this->loadModel('execution')->getPairs();
        $this->view->begin     = $begin;
        $this->view->end       = $end;
        $this->view->dept      = $dept;
        $this->view->userTasks = $this->report->getWorkSummary($begin, $end, $dept, 'workassignsummary', $pager);
        $this->view->pager     = $pager;
        $this->view->submenu   = 'staff';
        $this->display();
    }
}
