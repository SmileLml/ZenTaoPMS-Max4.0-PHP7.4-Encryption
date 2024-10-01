<?php
/**
 * The lang file of calendar module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     calendar
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->company->calendar       = 'Effort';
$lang->company->todo           = 'Todo';
$lang->company->selectDept     = 'Select department';
$lang->company->date           = 'Date';
$lang->company->allDept        = 'All Dept';
$lang->company->to             = 'to';
$lang->company->user           = 'User';
$lang->company->dept           = 'Dept';
$lang->company->show           = 'Show';
$lang->company->userType       = 'Type';
$lang->company->effortCalendar = 'Effort';
$lang->company->todoCalendar   = 'Todo Calendar';
$lang->company->beginDate      = 'Begin';
$lang->company->endDate        = 'End';
$lang->company->companyTodo    = 'Company Todo';
$lang->company->todoList       = 'Company Todos';
$lang->company->effortList     = 'Company Efforts';
$lang->company->allTodo        = 'All Todos';

$lang->company->showUsers['all']       = 'All Users';
$lang->company->showUsers['logged']    = 'Logged Member';
$lang->company->showUsers['notLogged'] = 'Not Logged Member';

$lang->company->userTypes['']        = '';
$lang->company->userTypes['inside']  = 'Inside';
$lang->company->userTypes['outside'] = 'Outside';

if(!isset($lang->company->effort)) $lang->company->effort = new stdclass();
$lang->company->effort->selectDate      = 'Date';
$lang->company->effort->executionSelect = $lang->executionCommon;
$lang->company->effort->productSelect   = $lang->productCommon;
$lang->company->effort->userSelect      = 'User';
$lang->company->effort->view            = 'View';

$lang->company->currentDept = 'Current Dept';
$lang->company->noDept      = 'No Dept';

$lang->company->pageUserCount = 'There are %s users on this page';
