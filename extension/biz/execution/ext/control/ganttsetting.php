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
     * Show relation of execution.
     *
     * @param  int    $executionID
     * @access public
     * @return void
     */
    public function ganttSetting($executionID = 0)
    {
        $this->loadModel('setting');
        $account  = $this->app->user->account;
        $isBranch = false;

        if(!empty($_POST))
        {
            if($account == 'guest') return $this->send(array('result' => 'fail', 'target' => $target, 'message' => 'guest.'));
            if(!isset($_POST['showBranch'])) $this->post->showBranch = 0;

            $this->setting->setItem("$account.execution$executionID.gantt.showID", $this->post->showID);
            $this->setting->setItem("$account.execution$executionID.gantt.showBranch", $this->post->showBranch);

            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => 'dao error.'));
            return $this->send(array('result' => 'success', 'locate' => 'parent', 'message' => $this->lang->saveSuccess));
        }

        $showID     = $this->setting->getItem("owner=$account&module=execution$executionID&section=gantt&key=showID");
        $showBranch = $this->setting->getItem("owner=$account&module=execution$executionID&section=gantt&key=showBranch");

        $branchs = $this->execution->getBranches($executionID);
        if($branchs)
        {
            $branchProducts  = $this->execution->getBranchByProduct(array_keys($branchs));
            if($branchProducts) $isBranch = true;
        }

        $this->view->title      = $this->lang->execution->common . $this->lang->colon . $this->lang->execution->ganttSetting;
        $this->view->position[] = $this->lang->execution->ganttSetting;

        $this->view->showID     = $showID == '' ? 1 : $showID;
        $this->view->showBranch = $showBranch == '' ? 1 : $showBranch;
        $this->view->isBranch   = $isBranch;

        $this->display();
    }
}
