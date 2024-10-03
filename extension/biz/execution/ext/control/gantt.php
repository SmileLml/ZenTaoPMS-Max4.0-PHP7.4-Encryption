<?php
/**
 * The control file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     execution
 * @version     $Id$
 * @link        http://www.zentao.net
 */
helper::importControl('execution');
class myexecution extends execution
{
    /**
     * Gantt
     *
     * @param  int    $executionID
     * @param  string $type
     * @param  string $orderBy
     * @access public
     * @return void
     */
    public function gantt($executionID, $type = '', $orderBy = '')
    {
        $this->app->loadLang('task');
        $this->app->loadLang('programplan');

        if(empty($type))
        {
            $type = $this->cookie->ganttType;
            if(empty($type)) $type = 'type';
            if($this->config->vision == 'lite') $type = 'assignedTo';
        }
        setcookie('ganttType', $type, $this->config->cookieLife, $this->config->webRoot, '', false, true);

        $execution   = $this->commonAction($executionID);
        $executionID = $execution->id;
        $this->execution->setMenu($executionID);

        $users    = $this->loadModel('user')->getPairs('noletter');
        $userList = array();
        foreach($users as $account => $realname)
        {
            $user = array();
            $user['key']   = $account;
            $user['label'] = $realname;
            $userList[]    = $user;
        }
        $this->view->userList = $userList;

        $executionData = $this->execution->getDataForGantt($executionID, $type, $orderBy);
        /* The header and position. */
        $this->view->title      = $this->lang->execution->common . $this->lang->colon . $this->lang->execution->gantt->common;
        $this->view->position[] = $this->lang->execution->gantt->common;
        $this->view->executionID   = $executionID;
        $this->view->executionName = $execution->name;
        $this->view->execution     = $execution;
        $this->view->executionData = $executionData;
        $this->view->project       = $this->execution->getByID($execution->project);
        $this->view->ganttType     = $type;
        $this->view->orderBy       = $orderBy;
        $this->display();
    }
}
