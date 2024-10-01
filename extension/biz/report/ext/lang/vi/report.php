<?php
$lang->report->testcase          = 'Báo cáo tình huống';
$lang->report->casesrun          = 'Báo cáo chạy tình huống';
$lang->report->build             = 'Báo cáo bản dựng';
$lang->report->workSummary       = 'Nhiệm vụ hoàn thành';
$lang->report->bugSummary        = 'Giải pháp Bug';
$lang->report->roadmap           = 'Lộ trình '.$lang->productCommon;
$lang->report->storyLinkedBug    = 'Liên kết Bugs - câu chuyện';
$lang->report->workAssignSummary = 'Bàn giao nhiệm vụ';
$lang->report->bugAssignSummary  = 'Bàn giao Bugs';
$lang->report->productInvest     = 'Product Investment';

$lang->report->taskFinishedDate = 'Ngày hoàn thành nhiệm vụ';
$lang->report->taskConsumed     = 'Tổng thời lượng nhiệm vụ';
$lang->report->projectConsumed  = 'Tổng thời lượng dự án';
$lang->report->userConsumed     = 'Tổng thời lượng người dùng';
$lang->report->bugResolvedDate  = 'Bug được giải quyết Date';
$lang->report->bugAssignedDate  = 'Bug Assigned Date';
$lang->report->taskAssignedDate = 'Task Assigned Date';
$lang->report->projects         = 'Projects';
$lang->report->storyConsumed    = $lang->SRCommon . ' Consumed';
$lang->report->taskConsumed     = 'Task Consumed';
$lang->report->bugConsumed      = 'Bug Consumed';
$lang->report->caseConsumed     = 'Case Consumed';
$lang->report->totalConsumed    = 'Total Consumed';

if(helper::hasFeature('product_roadmap')) $lang->reportList->product->lists[20] = 'Lộ trình '.$lang->productCommon . '|report|roadmap';
$lang->reportList->product->lists[25] = $lang->productCommon . ' Investment|report|productInvest';
$lang->reportList->test->lists[20] = 'Báo cáo tình huống|report|testcase';
$lang->reportList->test->lists[25] = 'Báo cáo chạy tình huống|report|casesrun';
$lang->reportList->test->lists[30] = 'Báo cáo bản dựng|report|build';
$lang->reportList->test->lists[35] = 'Câu chuyện Bugs liên kết|report|storylinkedbug';
$lang->reportList->staff->lists[20]   = 'Nhiệm vụ hoàn thành|report|worksummary';
$lang->reportList->staff->lists[25]   = 'Bàn giao nhiệm vụ|report|workAssignSummary';
$lang->reportList->staff->lists[30]   = 'Giải pháp Bug|report|bugsummary';
$lang->reportList->staff->lists[35]   = 'Bàn giao Bug|report|bugAssignSummary';

$lang->report->product = 'Tên '.$lang->productCommon;
$lang->report->module     = 'Module';
$lang->report->buildTitle = 'Bản dựng';
$lang->report->severity   = 'Mức độ';
$lang->report->bugType    = 'Loại';
$lang->report->bugStatus  = 'Tình trạng';
$lang->report->delay      = 'Tạm ngưng';
$lang->report->day        = 'ngày';
$lang->report->plan       = 'Kế hoạch';
$lang->report->future     = 'TBD';

$lang->report->case     = new stdclass();
$lang->report->case->total = 'Tổng';
$lang->report->case->run   = 'Chạy';
$lang->report->case->passRate = 'Phần trăm';;
$lang->report->case->name  = 'Tên';

$lang->report->bugTypeList['codeerror']   = 'code';
$lang->report->bugTypeList['interface']   = 'interface';
$lang->report->bugTypeList['config']   = 'config';
$lang->report->bugTypeList['install']  = 'install';
$lang->report->bugTypeList['security'] = 'security';
$lang->report->bugTypeList['performance'] = 'performace';
$lang->report->bugTypeList['standard'] = 'standard';
$lang->report->bugTypeList['automation']  = 'automation';
$lang->report->bugTypeList['others']   = 'others';

$lang->report->bug     = new stdclass();
$lang->report->bug->total = 'Tổng';
$lang->report->bug->title = 'Tiêu đề Bug';
$lang->report->bug->story = 'Câu chuyện';
$lang->report->bug->status   = 'Tình trạng';
