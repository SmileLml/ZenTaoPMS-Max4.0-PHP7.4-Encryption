<?php
$lang->project->approval = 'Approval';
$lang->project->previous = 'Previous';

$lang->project->approvalflow = new stdclass();
$lang->project->approvalflow->flow   = 'Approval Flow';
$lang->project->approvalflow->object = 'Apporval Object';

$lang->project->approvalflow->objectList[''] = '';
$lang->project->approvalflow->objectList['stage'] = 'Stage';
$lang->project->approvalflow->objectList['task']  = 'Task';

$lang->project->copyProjectConfirm   = 'Complete Project Information';
$lang->project->executionInfoConfirm = 'Complete Execution Information';
$lang->project->stageInfoConfirm     = 'Complete Stage Information';

$lang->project->executionInfoTips = 'To avoid repetition, modify the execution name and execution code, and set the planned start time and planned finish time.';

$lang->project->chosenProductStage = 'Please select the stage of product "%s" to copy %s';
$lang->project->notCopyStage       = 'Not Copy';
$lang->project->completeCopy       = 'Complete Copy';

$lang->project->copyProject->code               = '『' . $lang->executionCommon . '』Cannot be repeated.';
$lang->project->copyProject->select             = 'Select';
$lang->project->copyProject->confirmData        = 'Confirm';
$lang->project->copyProject->improveData        = 'Improve';
$lang->project->copyProject->completeData       = 'Complete';
$lang->project->copyProject->selectPlz          = 'Please select the project';
$lang->project->copyProject->cancel             = 'Cancel';
$lang->project->copyProject->all                = 'All data';
$lang->project->copyProject->basic              = 'Basic data';
$lang->project->copyProject->allList            = array('Project data', 'The %s', 'Project and %s documentation lib', 'The %s tasks', 'QA', 'Process', 'Team member permissions');
$lang->project->copyProject->toComplete         = 'To complete';
$lang->project->copyProject->selectProjectPlz   = 'Please select the project';
$lang->project->copyProject->confirmCopyDataTip = 'Make sure you want to copy the data:';
$lang->project->copyProject->basicInfo          = 'Project data (program, project name, project code, product)';
$lang->project->copyProject->selectProgram      = 'Please select the program';
$lang->project->copyProject->sprint             = 'Sprint';

global $config;
if($config->systemMode == 'light') $lang->project->copyProject->basicInfo = 'Project data (project name, project code, product)';
