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
     * Story related bug summary table.
     *
     * @param  int    $productID
     * @param  int    $moduleID
     * @access public
     * @return void
     */
    public function storyLinkedBug($productID = 0, $moduleID = 0)
    {
        $products = $this->loadModel('product')->getPairs('', 0, '', 'all');
        if(!$productID) $productID = key($products);

        $this->app->loadLang('bug');
        $this->view->title     = $this->lang->report->storyLinkedBug;
        $this->view->products  = $products;
        $this->view->modules   = array(0 => '/') + $this->loadModel('tree')->getOptionMenu($productID, 'story', 0, 'all');
        $this->view->productID = $productID;
        $this->view->moduleID  = $moduleID;
        $this->view->stories   = $this->report->getStoryBugs($productID, $moduleID);
        $this->view->submenu   = 'test';
        $this->display();
    }
}
