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
     * Product roadmap.
     *
     * @param  string $conditions
     * @access public
     * @return void
     */
    public function roadmap($conditions = '')
    {
        $this->app->loadConfig('productplan');
        $roadmaps = $this->report->getRoadmaps($conditions);

        $this->view->title      = $this->lang->report->roadmap;
        $this->view->position[] = $this->lang->report->roadmap;
        $this->view->products   = $roadmaps['products'];
        $this->view->plans      = $roadmaps['plans'];
        $this->view->submenu    = 'product';
        $this->view->conditions = $conditions;
        $this->display();
    }
}
