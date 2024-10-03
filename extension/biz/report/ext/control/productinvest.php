<?php
/**
 * The control file of report module of zentaopms.
 *
 * @copyright   copyright 2009-2020 青岛易软天创网络科技有限公司(qingdao nature easy soft network technology co,ltd, www.cnezsoft.com)
 * @license     zpl (http://zpl.pub/page/zplv12.html)
 * @author      chunsheng wang <chunsheng@cnezsoft.com>
 * @package     report
 * @link        https://www.zentao.net
 */
helper::importControl('report');
class myReport extends report
{
    /**
     * Product invest report.
     *
     * @access public
     * @return void
     */
    public function productInvest($conditions = '')
    {
        $this->app->loadLang('story');
        $this->app->loadLang('product');
        $this->app->loadLang('productplan');

        $this->view->title      = $this->lang->report->productInvest;
        $this->view->investData = $this->report->getProductInvest($conditions);
        $this->view->submenu    = 'product';
        $this->view->conditions = $conditions;
        $this->display();
    }
}
