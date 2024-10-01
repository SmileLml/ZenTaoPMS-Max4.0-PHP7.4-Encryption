<?php
$lang->custom->execution       = '看板';
$lang->custom->closedExecution = '已關閉' . $lang->custom->execution;
$lang->custom->notice->readOnlyOfExecution = "禁止修改後，已關閉{$lang->custom->execution}下的任務、日誌以及關聯目標都禁止修改。";

$lang->custom->moduleName['execution'] = $lang->custom->execution;

$lang->custom->object = array();
$lang->custom->object['execution'] = $lang->custom->execution;
$lang->custom->object['story']     = $lang->SRCommon;
$lang->custom->object['task']      = '任務';
$lang->custom->object['todo']      = '待辦';
$lang->custom->object['user']      = '用戶';
$lang->custom->object['block']     = '區塊';

$lang->custom->menuOrder = array();
$lang->custom->menuOrder[10] = 'execution';
$lang->custom->menuOrder[15] = 'story';
$lang->custom->menuOrder[20] = 'task';
$lang->custom->menuOrder[25] = 'todo';
$lang->custom->menuOrder[30] = 'user';
$lang->custom->menuOrder[35] = 'block';

$lang->custom->task = new stdClass();
$lang->custom->task->fields['priList']  = '優先順序';
$lang->custom->task->fields['typeList'] = '類型';

$lang->custom->story = new stdClass();
$lang->custom->story->fields['priList']          = '優先順序';
$lang->custom->story->fields['reasonList']       = '關閉原因';
$lang->custom->story->fields['statusList']       = '狀態';
$lang->custom->story->fields['reviewRules']      = '評審規則';
$lang->custom->story->fields['reviewResultList'] = '評審結果';
$lang->custom->story->fields['review']           = '評審流程';

$lang->custom->system = array('required');
