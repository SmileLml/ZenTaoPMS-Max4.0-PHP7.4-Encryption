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
     * Version statistics table.
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function build($productID = 0)
    {
        $this->app->loadLang('bug');

        $products = $this->loadModel('product')->getPairs('', 0, '', 'all');
        if(!$productID) $productID = key($products);

        $projectID = $this->lang->navGroup->report == 'project' ? $this->session->project : 0;
        $buildBugs = $this->report->getBuildBugs($productID);

        $this->view->title     = $this->lang->report->build;
        $this->view->products  = $products;
        $this->view->productID = $productID;
        $this->view->bugs      = $buildBugs['bugs'];
        $this->view->summary   = $buildBugs['summary'];
        $this->view->projects  = $this->loadModel('product')->getProjectPairsByProduct($productID);
        $this->view->builds    = $this->loadModel('build')->getBuildPairs($productID, 'all', '');
        $this->view->submenu   = 'test';
        $this->display();
    }
}
