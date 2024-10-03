<?php
/**
 * The control file of my module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     my
 * @version     $Id$
 * @link        http://www.zentao.net
 */
helper::importControl('my');
class mymy extends my
{
    /**
     * My todos.
     *
     * @param  string $type
     * @param  string $account
     * @param  string $status
     * @access public
     * @return void
     */
    public function effort($type = 'today', $orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $type = strtolower($type);
        $this->lang->my->menu->effort['subModule'] = 'my';

        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('effortList', $uri);
        $this->session->set('effortType', $type);

        /* Set the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* The header and position. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->effort;
        $this->view->position[] = $this->lang->my->effort;

        $this->loadModel('effort');

        $this->loadModel('datatable');
        $this->config->effort->datatable->defaultField[] = 'actions';
        $this->config->effort->datatable->fieldList['actions']['title']    = 'actions';
        $this->config->effort->datatable->fieldList['actions']['fixed']    = 'right';
        $this->config->effort->datatable->fieldList['actions']['width']    = '90';
        $this->config->effort->datatable->fieldList['actions']['required'] = 'yes';

        /* Assign. */
        list($begin, $end)   = $this->effort->parseDate($type);
        $this->view->efforts = $this->effort->getList($begin, $end, $this->app->user->account, $product = 0, $execution = 0, $dept = 0, $orderBy, $pager);
        $this->view->date    = (int)$type == 0 ? date(DT_DATE1, time()) : substr($type, 0, 4) . '-' . substr($type, 4, 2) . '-' . substr($type, 6, 2);
        $this->view->type    = is_numeric($type) ? 'bydate' : $type;
        $this->view->account = $this->app->user->account;
        $this->view->pager   = $pager;
        $this->view->orderBy = $orderBy;

        $this->display();
    }
}
