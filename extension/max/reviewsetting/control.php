<?php
/**
 * The control file of reviewsetting module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Qiyu Xie <xieqiyu@easycorp.ltd>
 * @package     reviewsetting
 * @version     $Id: control.php 5107 2020-09-09 09:46:12Z xieqiyu@easycorp.ltd $
 * @link        http://www.zentao.net
 */
class reviewsetting extends control
{
    /**
     * Configure version Numbers for various objects.
     * @param string  $object
     * @access public
     * @return void
     */
    public function version($object = 'PP')
    {
        $this->app->loadLang('baseline');
        $this->app->loadLang('reviewcl');
        unset($this->lang->baseline->objectList['']);

        $setting = $this->loadModel('setting');

        $owner   = 'system';
        $module  = 'company';
        $section = 'version';

        if($_POST)
        {
            $data = fixer::input('post')->get();
            if($data->object)
            {
                $unitGroup = array_chunk($data->unit, 4);

                foreach ($unitGroup as $key => $unit)
                {
                    if($unit[0] == 'fixed' && trim($unit[1]) == false) unset($unitGroup[$key]);
                    if(empty($unit[0])) unset($unitGroup[$key]);
                }
                $data->unit = $unitGroup;
                $setting->setItem("{$owner}.{$module}.{$section}.{$data->object}", json_encode($data));
            }
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('reviewsetting', 'version', 'object='.$data->object )));
        }

        $result = $setting->getItem("owner={$owner}&module={$module}&section={$section}&key={$object}");

        $this->view->title       = $this->lang->reviewsetting->setting . $this->lang->reviewsetting->version;
        $this->view->joint       = $this->lang->reviewsetting->joint;
        $this->view->object      = $object;
        $this->view->result      = json_decode($result);
        $this->view->objectType  = $this->lang->baseline->objectList;
        $this->view->versionForm = $this->lang->reviewsetting->versionForm;
        $this->display();
    }

    public function reviewer($object = 'PP')
    {
        $this->app->loadLang('user');
        $this->app->loadLang('baseline');
        $this->app->loadLang('reviewcl');
        unset($this->lang->baseline->objectList['']);

        if(strtolower($this->server->request_method) == "post")
        {
            $role = $this->post->role;
            if($role) $role = trim(implode($role, ','), ',');
            $this->loadModel('setting')->setItem("system.reviewsetting.reviewer.{$object}", $role);

            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('reviewsetting', 'reviewer', "object=$object")));
        }

        $this->view->title      = $this->lang->reviewsetting->setting . $this->lang->reviewsetting->reviewer;
        $this->view->object     = $object;
        $this->view->roleList   = isset($this->config->reviewsetting->reviewer->$object) ? $this->config->reviewsetting->reviewer->$object : '';
        $this->view->objectType = $this->lang->baseline->objectList;
        $this->display();
    }
}
