<?php
/**
 * The control file of reviewcl module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Qiyu Xie <xieqiyu@easycorp.ltd>
 * @package     reviewcl
 * @version     $Id: control.php 5107 2020-09-09 09:46:12Z xieqiyu@easycorp.ltd $
 * @link        http://www.zentao.net
 */
class reviewcl extends control
{
    public function __construct($module = '', $method = '')
    {
        parent::__construct($module, $method);
        $this->loadModel('baseline');
    }

    /**
     * Browse reviewcls.
     *
     * @param  string $object PP|QAP|CMP|ITP|URS|SRS|HLDS|DDS|DBDS|ADS|Code|ITTC|STP|STTC|UM
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function browse($object = 'PP', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session for review check list. */
        $this->session->set('reviewcl', $this->app->getURI(true));

        /* Init pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $recPerPage, $pageID);

        $this->view->title      = $this->lang->reviewcl->common;
        $this->view->position[] = $this->lang->reviewcl->common;

        $this->view->reviewcls = $this->reviewcl->getList($object, $orderBy, $pager);
        $this->view->object    = $object;
        $this->view->orderBy   = $orderBy;
        $this->view->pager     = $pager;
        $this->view->users     = $this->loadModel('user')->getPairs('noclosedo|noletter');
        $this->display();
    }

    /**
     * Create a reviewcl.
     *
     * @param  string $object
     * @access public
     * @return void
     */
    public function create($object = '')
    {
        if($_POST)
        {
            $reviewclID = $this->reviewcl->create();

            if(!dao::isError())
            {
                $reviewcl = $this->reviewcl->getByID($reviewclID);

                $this->loadModel('action')->create('reviewcl', $reviewclID, 'Opened');
                $response['result']  = 'success';
                $response['message'] = $this->lang->saveSuccess;
                $response['locate']  = inlink('browse', "object=$reviewcl->object");
                return $this->send($response);
            }

            $response['result']  = 'fail';
            $response['message'] = dao::getError();
            return $this->send($response);
        }

        $this->view->title      = $this->lang->reviewcl->create;
        $this->view->position[] = $this->lang->reviewcl->create;

        $this->view->object     = $object;

        $this->display();
    }

    /**
     * Batch create reviewcls.
     *
     * @param  string $object
     * @access public
     * @return void
     */
    public function batchCreate($object = '')
    {
        if($_POST)
        {
            $this->reviewcl->batchCreate();

            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;
            $response['locate']  = inlink('browse', "object=");

            return $this->send($response);
        }

        $this->view->title      = $this->lang->reviewcl->batchCreate;
        $this->view->position[] = $this->lang->reviewcl->batchCreate;
        $this->view->object     = $object;

        $this->display();
    }

    /**
     * Edit a reviewcl.
     *
     * @param  int    $reviewclID
     * @access public
     * @return void
     */
    public function edit($reviewclID = 0)
    {
        if($_POST)
        {
            $changes = $this->reviewcl->update($reviewclID);

            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }

            if(!empty($changes))
            {
                $actionID = $this->loadModel('action')->create('reviewcl', $reviewclID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }

            $response['result']  = 'success';
            $response['message'] = $this->lang->saveSuccess;
            $response['locate']  = $this->createLink('reviewcl', 'view', "id=$reviewclID");
            return $this->send($response);
        }

        $this->view->title      = $this->lang->reviewcl->edit;
        $this->view->position[] = $this->lang->reviewcl->edit;

        $this->view->reviewcl = $this->reviewcl->getByID($reviewclID);

        $this->display();
    }

    /**
     * Delete a reviewcl.
     *
     * @param  int    $reviewclID
     * @param  string $confirm
     * @access public
     * @return void
     */
    public function delete($reviewclID = 0, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->reviewcl->confirmDelete, inlink('delete', "reviewclID=$reviewclID&confirm=yes")));
        }
        else
        {
            $this->reviewcl->delete(TABLE_REVIEWCL, $reviewclID);

            die(js::locate($this->session->reviewcl, 'parent'));
        }
    }

    /**
     * View a reviewcl.
     *
     * @param  int    $reviewclID
     * @access public
     * @return void
     */
    public function view($reviewclID = 0)
    {
        $this->view->title    = $this->lang->reviewcl->view;

        $this->view->reviewcl = $this->reviewcl->getByID($reviewclID);
        $this->view->actions  = $this->loadModel('action')->getList('reviewcl', $reviewclID);
        $this->view->users    = $this->loadModel('user')->getPairs('noclosedo|noletter');

        $this->display();
    }
}
