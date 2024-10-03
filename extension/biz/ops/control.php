<?php
/**
 * The control file of ops of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jiangxiu Peng <pengjiangxiu@cnezsoft.com>
 * @package     ops
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class ops extends control
{
    /**
     * Index. 
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate($this->createLink('deploy', 'browse'));
    }

    public function setting($module = 'serverroom', $field = 'provider', $currentLang = '')
    {
        if($field == 'osVersion') $field = 'linux';

        $fieldList = $field . 'List';
        if($_POST)
        {
            $this->loadModel('custom');
            $lang = $_POST['lang'];
            $this->custom->deleteItems("lang=$lang&module=$module&section=$fieldList");
            foreach($_POST['keys'] as $index => $key)
            {
                $key    = htmlspecialchars($key);
                $value  = htmlspecialchars($_POST['values'][$index]);
                $system = htmlspecialchars($_POST['systems'][$index]);

                $this->custom->setItem("{$lang}.$module.$fieldList.{$key}.{$system}", $value);
            }
            if(dao::isError()) die(js::error(dao::getError()));
            $target = isonlybody() ? 'parent.parent' : 'parent';
            $lang   = str_replace('-', '_', $lang);
            die(js::locate($this->createLink('ops', 'setting', "module=$module&field=$field&lang=$lang"), $target));
        }

        $this->app->loadLang('custom');
        $this->app->loadLang($module);

        if(empty($currentLang)) $currentLang = str_replace('-', '_', $this->app->getClientLang());

        $this->view->title = $this->lang->ops->setting;
        $this->view->position[] = $this->lang->ops->setting;

        $this->view->module      = $module;
        $this->view->field       = $field;
        $this->view->fieldList   = $fieldList;
        $this->view->currentLang = $currentLang;
        $this->display();
    }
}
