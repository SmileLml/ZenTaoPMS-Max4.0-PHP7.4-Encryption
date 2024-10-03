<?php
/**
 * The control file of cmcl module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Qiyu Xie <xieqiyu@easycorp.ltd>
 * @package     cmcl
 * @version     $Id: control.php 5107 2020-09-09 09:46:12Z xieqiyu@easycorp.ltd $
 * @link        http://www.zentao.net
 */
class cmcl extends control
{
    /**
     * Browse cmcls.
     *
     * @param  string $browseType
     * @param  string $param
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function browse($browseType = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $uri = $this->app->getURI(true);
        $this->session->set('cmclList',  $uri);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $this->view->title      = $this->lang->cmcl->common . $this->lang->colon . $this->lang->cmcl->browse;
        $this->view->position[] = $this->lang->cmcl->browse;
        $this->view->cmcls      = $this->cmcl->getList($browseType, $orderBy, $pager);
        $this->view->browseType = $browseType;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');

        $this->display();
    }

    /**
     * Batch create cmcls.
     *
     * @access public
     * @return void
     */
    public function batchCreate()
    {
        if($_POST)
        {
            $this->cmcl->batchCreate();

            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;
            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            $response['locate'] = inlink('browse');
            return $this->send($response);
        }

        $this->view->title      = $this->lang->cmcl->common . $this->lang->colon . $this->lang->cmcl->batchCreate;
        $this->view->position[] = $this->lang->cmcl->batchCreate;

        $this->display();
    }

    /**
     * Edit a cmcl.
     *
     * @param  int    $cmclID
     * @access public
     * @return void
     */
    public function edit($cmclID)
    {
        if($_POST)
        {
            $changes = $this->cmcl->update($cmclID);

            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;
            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            $this->loadModel('action');
            if(!empty($changes))
            {
                $actionID = $this->action->create('cmcl', $cmclID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }

            $response['locate'] = inlink('browse');
            return $this->send($response);
        }

        $this->view->title      = $this->lang->cmcl->common . $this->lang->colon . $this->lang->cmcl->edit;
        $this->view->position[] = $this->lang->cmcl->edit;

        $this->view->cmcl = $this->cmcl->getById($cmclID);
        $this->display();
    }

    /**
     * View a cmcl.
     *
     * @param  int    $cmclID
     * @access public
     * @return void
     */
    public function view($cmclID)
    {
        $this->loadModel('action');

        $this->view->title      = $this->lang->cmcl->common . $this->lang->colon . $this->lang->cmcl->view;
        $this->view->position[] = $this->lang->cmcl->view;

        $this->view->cmcl    = $this->cmcl->getById($cmclID);
        $this->view->actions = $this->action->getList('cmcl', $cmclID);
        $this->view->users   = $this->loadModel('user')->getPairs('noletter');

        $this->display();
    }

    /**
     * Delete a cmcl.
     *
     * @param  int    $cmclID
     * @param  string $confirm
     * @access public
     * @return void
     */
    public function delete($cmclID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->cmcl->confirm, $this->createLink('cmcl', 'delete', "cmcl=$cmclID&confirm=yes"), ''));
        }
        else
        {
            $this->cmcl->delete(TABLE_CMCL, $cmclID);

            die(js::locate(inlink('browse'), 'parent'));
        }
    }
}
