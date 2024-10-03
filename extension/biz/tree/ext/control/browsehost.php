<?php
/**
 * The control file of tree of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jiangxiu Peng <pengjiangxiu@cnezsoft.com>
 * @package     ops
 * @version     $Id$
 * @link        http://www.zentao.net
 */
helper::importControl('tree');
class mytree extends tree
{
    public function browseHost($moduleID)
    {
        $this->lang->navGroup->tree = 'ops';
        array_push($this->lang->noMenuModule, 'tree');

        $this->view->title      = $this->lang->tree->groupMaintenance;
        $this->view->position[] = $this->lang->tree->groupMaintenance;

        $this->view->moduleID  = $moduleID;
        $this->view->tree      = $this->tree->getHostStructure();
        $this->view->parents   = $this->tree->getParents($moduleID);
        $this->view->sons      = $this->tree->getHostSons($moduleID);

        $this->display();
    }
}
