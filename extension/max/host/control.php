<?php
/**
 * The control file of host of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jiangxiu Peng <pengjiangxiu@cnezsoft.com>
 * @package     ops
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class host extends control
{
    /**
     * View host.
     *
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function browse($browseType = 'all', $param = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $browseType = strtolower($browseType);
        $param      = (int)$param;

        $this->app->session->set('hostList', $this->app->getURI(true));
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $hostList = $this->host->getList($browseType, $param, $orderBy, $pager);
        $rooms    = $this->loadModel('serverroom')->getPairs();
        $accounts = $this->loadModel('account')->getPairs();
        $groups   = array('', '') + $this->loadModel('tree')->getOptionMenu(0, 'host');

        /* Build the search form. */
        $actionURL = $this->createLink('host', 'browse', "browseType=bySearch&queryID=myQueryID");
        $this->config->host->search['actionURL'] = $actionURL;
        $this->config->host->search['queryID']   = $param;
        $this->config->host->search['onMenuBar'] = 'no';
        $this->config->host->search['params']['serverRoom']['values'] = $rooms;
        $this->config->host->search['params']['group']['values'] = $groups;
        $this->loadModel('search')->setSearchParams($this->config->host->search);

        $this->loadModel('tree');
        $this->view->title      = $this->lang->host->common;
        $this->view->hostList   = $hostList;
        $this->view->pager      = $pager;
        $this->view->accounts   = $accounts;
        $this->view->rooms      = $rooms;
        $this->view->param      = $param;
        $this->view->orderBy    = $orderBy;
        $this->view->browseType = $browseType;
        $this->view->moduleTree = $this->tree->getHostTreeMenu();
        $this->view->optionMenu = $groups;

        $this->view->position[] = $this->lang->host->common;

        $this->display();
    }

    /**
     * Create host.
     *
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $id = $this->host->create();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->defaultParams = array(
            'zap' => '8085',
            'pri'       => '100',
            'bridgeID'  => 'br0',
        );

        $this->view->title      = $this->lang->host->create;
        $this->view->position[] = html::a($this->createLink('host', 'browse'), $this->lang->host->common);
        $this->view->position[] = $this->lang->host->create;

        $this->view->rooms      = $this->loadModel('serverroom')->getPairs();
        $this->view->accounts   = $this->loadModel('account')->getPairs();
        $this->view->optionMenu = $this->loadModel('tree')->getOptionMenu(0, 'host');

        $this->display();
    }

    /**
     * Create host.
     *
     * @access public
     * @return void
     */
    public function edit($id)
    {
        if($_POST)
        {
            $changes = $this->host->update($id);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if($changes)
            {
                $actionID = $this->loadModel('action')->create('host', $id, 'Edited');
                if(!empty($changes)) $this->action->logHistory($actionID, $changes);
            }

            if(isonlybody()) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => 'parent'));

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->accounts   = $this->loadModel('account')->getPairs();
        $this->view->title      = $this->lang->host->edit;
        $this->view->position[] = html::a($this->createLink('host', 'browse'), $this->lang->host->common);
        $this->view->position[] = $this->lang->host->edit;

        $this->view->host       = $this->host->getById($id);
        $this->view->accounts   = $this->loadModel('account')->getPairs();
        $this->view->rooms      = $this->loadModel('serverroom')->getPairs();
        $this->view->optionMenu = $this->loadModel('tree')->getOptionMenu(0, 'host');

        $this->display();
    }

    public function view($id)
    {
        $this->view->title      = $this->lang->host->view;
        $this->view->position[] = html::a($this->createLink('host', 'browse'), $this->lang->host->common);
        $this->view->position[] = $this->lang->host->view;

        $this->view->host       = $this->host->getById($id);
        $this->view->rooms      = $this->loadModel('serverroom')->getPairs();
        $this->view->actions    = $this->loadModel('action')->getList('host', $id);
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->view->optionMenu = $this->loadModel('tree')->getOptionMenu(0, 'host');
        $this->display();
    }

    public function delete($id, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->host->confirmDelete, inlink('delete', "id=$id&confirm=yes")));
        }

        $this->dao->update(TABLE_HOST)->set('deleted')->eq(1)->where('id')->eq($id)->exec();
        $this->loadModel('action')->create('host', $id, 'deleted', '', $extra = ACTIONMODEL::CAN_UNDELETED);

        /* if ajax request, send result. */
        if($this->server->ajax)
        {
            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
            }
            else
            {
                $response['result']  = 'success';
                $response['message'] = '';
            }
            $this->send($response);
        }

        if(isonlybody())die(js::reload('parent.parent'));
        die(js::locate($this->createLink('host', 'browse'), 'parent'));
    }

    public function changeStatus($id, $hostID, $status)
    {
        $hostStatus = $status == 'offline' ? 'online' : 'offline';
        $reasonKey  = $hostStatus . 'Reason';
        $reason     = $this->lang->host->{$reasonKey};
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $postData = fixer::input('post')->get();
            if(empty($postData->reason))
            {
                dao::$errors['submit'][] = sprintf($this->lang->error->notempty, $reason);
                die(js::error(dao::getError()));
            }

            $this->host->updateStatus($hostID, $hostStatus);

            $this->loadModel('action')->create('host', $id, $hostStatus, $postData->reason);
            if(isonlybody()) die(js::reload('parent.parent'));
            die(js::reload('parent'));
        }

        $this->view->title  = $this->lang->host->{$hostStatus};
        $this->view->reason = $reason;
        $this->display();
    }

    public function treemap($type = 'serverroom')
    {
        $this->view->title = $this->lang->host->treemapList[$type];
        $this->view->position[] = html::a(inlink('browse'), $this->lang->host->common);
        $this->view->position[] = $this->lang->host->treemapList[$type];

        /* Build the search form. */
        $actionURL = $this->createLink('host', 'browse', "browseType=bySearch&queryID=myQueryID");
        $this->config->host->search['actionURL'] = $actionURL;
        $this->config->host->search['queryID']   = 0;
        $this->config->host->search['onMenuBar'] = 'no';
        $this->config->host->search['params']['serverRoom']['values'] = $this->loadModel('serverroom')->getPairs();
        $this->config->host->search['params']['group']['values'] = $this->loadModel('tree')->getOptionMenu(0, 'host');
        $this->loadModel('search')->setSearchParams($this->config->host->search);

        $func = "get{$type}Treemap";
        $this->view->treemap = $this->host->$func();
        $this->view->type    = $type;
        $this->display();
    }

    public function ajaxGetByModule($moduleIdList, $defaultHosts = '')
    {
        $hosts = $this->host->getPairs($moduleIdList);
        die(html::select('hosts[]', $hosts, $defaultHosts, "class='form-control chosen' multiple"));
    }

    public function ajaxGetByService($serviceID)
    {
        $hosts = $serviceID ? $this->host->getPairsByService($serviceID) : $this->host->getPairs();
        $hosts = array(0 => '') + $hosts;
        die(html::select('hosts[]', $hosts, '', "class='form-control chosen' multiple"));
    }

    public function ajaxGetOSVersion($field)
    {
        die(html::select('osVersion', $this->lang->host->{$field . 'List'}, '', "class='form-control chosen'"));
    }
}
