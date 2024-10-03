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
     * Bug resolution summary table.
     *
     * @param  int    $dept
     * @param  int    $begin
     * @param  int    $end
     * @access public
     * @return void
     */
    public function bugSummary($dept = 0, $begin = 0 , $end = 0)
    {
        $this->app->loadLang('bug');
        $begin = $begin ? date('Y-m-d', strtotime($begin)) : date('Y-m-d', strtotime('last month', strtotime(date('Y-m',time()) . '-01 00:00:01')));
        $end   = $end   ? date('Y-m-d', strtotime($end))   : date('Y-m-d', strtotime('now'));


        $this->view->title      = $this->lang->report->bugSummary;
        $this->view->position[] = $this->lang->report->bugSummary;

        $this->view->users    = $this->loadModel('user')->getPairs('noletter|noclosed');
        $this->view->depts    = $this->loadModel('dept')->getOptionMenu();
        $this->view->dept     = $dept;
        $this->view->begin    = $begin;
        $this->view->end      = $end;
        $this->view->userBugs = $this->report->getBugSummary($dept, $begin, $end, 'bugsummary');
        $this->view->submenu  = 'staff';
        $this->display();
    }
}
