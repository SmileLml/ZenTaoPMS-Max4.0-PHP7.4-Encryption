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
class hostTree extends treeModel
{
    public function getHostTreeMenu()
    {
        $menu = "<ul id='modules' class='tree' data-ride='tree'>";
        /* tree menu. */
        $treeMenu = array();
        $stmt = $this->dao->select('*')->from(TABLE_MODULE)
            ->where('type')->eq('host')
            ->andWhere('deleted')->eq(0)
            ->orderBy('grade_desc,id_asc')
            ->query();

        while($module = $stmt->fetch())
        {    
            /* if not manage, ignore unused modules. */
            $this->buildTree($treeMenu, $module, '', array('hostTree', 'createHostLink'), '');
        }

        $tree  = isset($treeMenu[0]) ? $treeMenu[0] : '';
        $menu .= $tree . '</li>';

        $menu .= '</ul>';
        return $menu;
    }

    public function getHostStructure()
    {
        $stmt = $this->dao->select('*')->from(TABLE_MODULE)
            ->where('type')->eq('host')
            ->andWhere('deleted')->eq(0)
            ->orderBy('grade_desc,order_asc,id_asc')
            ->query();

        $hosttrees  = $this->getDataStructure($stmt, 'host');
        return $hosttrees;
    }

    public function getHostSons($moduleID)
    {
        $sons = $this->dao->select('*')->from(TABLE_MODULE)
            ->where('parent')->eq($moduleID)
            ->andWhere('deleted')->eq('0')
            ->andWhere('type')->eq('host')
            ->orderBy('order')
            ->fetchAll();

        return $sons;
    }

    /**  
     * Create link of a host.
     * 
     * @param  object   $module 
     * @access public
     * @return string
     */
    public static function createHostLink($type, $module)
    {
        $linkHtml = html::a(helper::createLink('host', 'browse', "browseType=bymodule&param={$module->id}"), $module->name, '_self', "id='module{$module->id}'");
        return $linkHtml;
    }
}
