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
    public function editHost($moduleID)
    {
        if(!empty($_POST))
        {
            $this->tree->update($moduleID);
            echo js::alert($this->lang->tree->successSave);
            die(js::reload('parent'));
        }

        $module = $this->tree->getById($moduleID);

        $this->view->module     = $this->tree->getById($moduleID);
        $this->view->optionMenu = $this->tree->getOptionMenu(0,'host');

        $childs = $this->tree->getAllChildId($moduleID);
        foreach($childs as $childModuleID) unset($this->view->optionMenu[$childModuleID]);

        $this->display();
    }
}
