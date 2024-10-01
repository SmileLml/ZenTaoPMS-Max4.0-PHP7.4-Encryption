<?php
$lang->report->testcase          = 'Case Report';
$lang->report->casesrun          = 'Case Run Report';
$lang->report->build             = 'Build Report';
$lang->report->workSummary       = 'Task Finished Summary';
$lang->report->bugSummary        = 'Bug Solution Summary';
$lang->report->roadmap           = $lang->productCommon . ' Roadmap';
$lang->report->storyLinkedBug    = 'Story Linked Bugs Summary';
$lang->report->workAssignSummary = 'Task Assignment Summary';
$lang->report->bugAssignSummary  = 'Bug Assignment Summary';
$lang->report->productInvest     = $lang->productCommon . ' Investment';

$lang->report->taskFinishedDate  = 'Task Finished Date';
$lang->report->taskConsumed      = 'Task Total Cost';
$lang->report->projectConsumed   = 'Project Total Cost';
$lang->report->executionConsumed = 'Execution Total Cost';
$lang->report->userConsumed      = 'User Total Cost';
$lang->report->bugResolvedDate   = 'Bug Resolved Date';
$lang->report->bugAssignedDate   = 'Bug Assigned Date';
$lang->report->taskAssignedDate  = 'Task Assigned Date';
$lang->report->projects          = 'Projects';
$lang->report->storyConsumed     = $lang->SRCommon . ' Consumed';
$lang->report->taskConsumed      = 'Task Consumed';
$lang->report->bugConsumed       = 'Bug Consumed';
$lang->report->caseConsumed      = 'Case Consumed';
$lang->report->totalConsumed     = 'Total Consumed';

if(helper::hasFeature('product_roadmap')) $lang->reportList->product->lists[20] = $lang->productCommon . ' Roadmap|report|roadmap';
$lang->reportList->product->lists[25] = $lang->productCommon . ' Investment|report|productInvest';
$lang->reportList->test->lists[20]    = 'Case Report|report|testcase';
$lang->reportList->test->lists[25]    = 'Case Run Report|report|casesrun';
$lang->reportList->test->lists[30]    = 'Build Report|report|build';
$lang->reportList->test->lists[35]    = 'Story Linked Bugs|report|storylinkedbug';
$lang->reportList->staff->lists[20]   = 'Task Finished Summary|report|worksummary';
$lang->reportList->staff->lists[25]   = 'Task Assignment Summary|report|workAssignSummary';
$lang->reportList->staff->lists[30]   = 'Bug Solution Summary|report|bugsummary';
$lang->reportList->staff->lists[35]   = 'Bug Assignment Summary|report|bugAssignSummary';

$lang->report->product    = $lang->productCommon . ' Name';
$lang->report->module     = 'Module';
$lang->report->buildTitle = 'Build';
$lang->report->severity   = 'Severity';
$lang->report->bugType    = 'Type';
$lang->report->bugStatus  = 'Status';
$lang->report->delay      = 'Delay';
$lang->report->day        = 'day';
$lang->report->plan       = 'Plan';
$lang->report->future     = 'TBD';

$lang->report->case           = new stdclass();
$lang->report->case->total    = 'Total';
$lang->report->case->run      = 'Run';
$lang->report->case->passRate = 'Percentage';
$lang->report->case->name     = 'Name';

$lang->report->bugTypeList['codeerror']   = 'code';
$lang->report->bugTypeList['interface']   = 'interface';
$lang->report->bugTypeList['config']      = 'config';
$lang->report->bugTypeList['install']     = 'install';
$lang->report->bugTypeList['security']    = 'security';
$lang->report->bugTypeList['performance'] = 'performace';
$lang->report->bugTypeList['standard']    = 'standard';
$lang->report->bugTypeList['automation']  = 'automation';
$lang->report->bugTypeList['others']      = 'others';

$lang->report->bug           = new stdclass();
$lang->report->bug->total    = 'Total';
$lang->report->bug->title    = 'Bug Title';
$lang->report->bug->story    = 'Story';
$lang->report->bug->status   = 'Status';

$lang->report->caseRunDesc = 'Statistics according to the execution times and results of use cases.';
