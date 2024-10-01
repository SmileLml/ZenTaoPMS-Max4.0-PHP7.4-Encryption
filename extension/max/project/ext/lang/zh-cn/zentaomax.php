<?php
$lang->project->approval = '审批';
$lang->project->previous = '上一步';

$lang->project->approvalflow = new stdclass();
$lang->project->approvalflow->flow   = '审批流程';
$lang->project->approvalflow->object = '审批对象';

$lang->project->approvalflow->objectList[''] = '';
$lang->project->approvalflow->objectList['stage'] = '阶段';
$lang->project->approvalflow->objectList['task']  = '任务';

$lang->project->copyProjectConfirm   = '完善项目信息';
$lang->project->executionInfoConfirm = '完善迭代信息';
$lang->project->stageInfoConfirm     = '完善阶段信息';

$lang->project->executionInfoTips = '为了避免重复，请修改迭代名称和迭代代号，设置计划开始时间和计划完成时间。';

$lang->project->chosenProductStage = '请为 “%s” 产品选择要复制的对应产品的阶段 产品：%s';
$lang->project->notCopyStage       = '不复制';
$lang->project->completeCopy       = '复制完成';

$lang->project->copyProject->code               = '『' . $lang->executionCommon . '』代号不可重复需要修改';
$lang->project->copyProject->select             = '选择要复制的项目';
$lang->project->copyProject->confirmData        = '确认要复制的数据';
$lang->project->copyProject->improveData        = '完善新项目的数据';
$lang->project->copyProject->completeData       = '完成项目复制';
$lang->project->copyProject->selectPlz          = '请选择要复制的项目';
$lang->project->copyProject->cancel             = '取消复制';
$lang->project->copyProject->all                = '全部数据';
$lang->project->copyProject->basic              = '基础数据';
$lang->project->copyProject->allList            = array('项目自身的数据', '项目所包含的%s', '项目和%s的文档目录', '项目%s所包含的任务', 'QA质量保证计划', '过程裁剪设置', '团队成员安排与权限');
$lang->project->copyProject->toComplete         = '去完善';
$lang->project->copyProject->selectProjectPlz   = '请选择项目';
$lang->project->copyProject->confirmCopyDataTip = '请确认要复制的数据：';
$lang->project->copyProject->basicInfo          = '项目数据（所属项目集，项目名称，项目代号，所属产品）';
$lang->project->copyProject->selectProgram      = '请选择项目集';
$lang->project->copyProject->sprint             = '迭代';

global $config;
if($config->systemMode == 'light') $lang->project->copyProject->basicInfo = '项目数据（项目名称，项目代号，所属产品）';
