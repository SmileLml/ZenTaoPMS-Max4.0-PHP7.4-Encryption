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
     * Test case statistics table.
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function testcase($productID = 0)
    {
        $products = $this->loadModel('product')->getPairs('', 0, '', 'all');
        if(!$productID) $productID = key($products);

        $this->app->loadLang('testcase');
        $this->view->title     = $this->lang->report->testcase;
        $this->view->products  = $products;
        $this->view->productID = $productID;
        $this->view->modules   = $this->report->getTestcases($productID);
        $this->view->submenu   = 'test';
        $this->display();
    }
}
