<?php
$lang->try          = ' 试用';
$lang->maxName      = '旗舰版';
$lang->expireDate   = "到期时间：%s";
$lang->forever      = "永久授权";
$lang->unlimited    = "不限人数";
$lang->licensedUser = "授权人数：%s";
$lang->liteName     = '迅捷VIP版';

$lang->chart     = new stdclass();
$lang->dashboard = new stdclass();
$lang->dataset   = new stdclass();

$lang->chart->common     = '图表';
$lang->dashboard->common = '仪表盘';
$lang->dataset->common   = '数据集';

$lang->searchObjects['feedback']   = '反馈';
$lang->searchObjects['ticket']     = '工单';
$lang->searchObjects['service']    = '服务';
$lang->searchObjects['deploy']     = '上线';
$lang->searchObjects['deploystep'] = '上线步骤';

$lang->mainNav->menuOrder[60] = 'oa';
$lang->mainNav->menuOrder[65] = 'ops';
$lang->mainNav->menuOrder[70] = 'feedback';
$lang->mainNav->menuOrder[75] = 'traincourse';
$lang->mainNav->menuOrder[80] = 'workflow';
$lang->mainNav->menuOrder[85] = 'admin';

$lang->noticeBizLimited = "<div style='float:left;color:red' id='bizUserLimited'>已经超出企业版授权人数限制。请联系：4006-8899-23，或者删除用户。</div>";

$lang->admin->menu->system['subMenu']->libreoffice = array('link' => 'Office|custom|libreoffice');

if(isset($lang->admin->menu->xuanxuan))
{
    $lang->admin->menu->xuanxuan['subModule']           = 'client,setting,conference';
    $lang->admin->menu->xuanxuan['subMenu']->conference = array('link' => '音视频|conference|admin');
    $lang->admin->menu->xuanxuan['menuOrder'][7]        = 'conference';
    $lang->navGroup->conference                         = 'admin';
}

$lang->doc->menu->book    = array('link' => "{$lang->doc->wiki}|doc|tableContents|type=book", 'alias' => 'book,managebook,catalog');
$lang->doc->menuOrder[40] = 'book';
$lang->doc->menu->book['subMenu'] = new stdclass();

$lang->ops->webMenu = new stdclass();
$lang->ops->webMenu->deploy     = array('link' => '上线|deploy|browse|', 'alias' => 'create,edit,view');
$lang->ops->webMenu->host       = array('link' => '主机|host|browse|', 'alias' => 'create,edit,view,treemap', 'subModule' => 'tree');
$lang->ops->webMenu->serverroom = array('link' => '机房|serverroom|browse|', 'alias' => 'create,edit,view');
$lang->ops->webMenu->service    = array('link' => '服务|service|manage|', 'alias' => 'create,edit,view,browse');

$lang->ops->webMenuOrder[5]  = 'deploy';
$lang->ops->webMenuOrder[10] = 'host';
$lang->ops->webMenuOrder[15] = 'serverroom';
$lang->ops->webMenuOrder[20] = 'service';

$lang->deploy->webMenu     = $lang->ops->webMenu;
$lang->host->webMenu       = $lang->ops->webMenu;
$lang->serverroom->webMenu = $lang->ops->webMenu;
$lang->service->webMenu    = $lang->ops->webMenu;

$lang->deploy->webMenuOrder     = $lang->ops->webMenuOrder;
$lang->host->webMenuOrder       = $lang->ops->webMenuOrder;
$lang->serverroom->webMenuOrder = $lang->ops->webMenuOrder;
$lang->service->webMenuOrder    = $lang->ops->webMenuOrder;

$lang->oa->webMenu = new stdclass();
$lang->oa->webMenu->attend   = array('link' => '考勤|attend|personal|', 'subModule' => 'attend');
$lang->oa->webMenu->leave    = array('link' => '请假|leave|personal|', 'alias' => 'browse', 'subModule' => 'leave');
$lang->oa->webMenu->makeup   = array('link' => '补班|makeup|personal|', 'alias' => 'create,edit,view,browse', 'subModule' => 'makeup');
$lang->oa->webMenu->overtime = array('link' => '加班|overtime|personal|', 'subModule' => 'overtime');
$lang->oa->webMenu->lieu     = array('link' => '调休|lieu|personal|', 'subModule' => 'lieu');

$lang->oa->webMenuOrder[5]  = 'attend';
$lang->oa->webMenuOrder[10] = 'leave';
$lang->oa->webMenuOrder[15] = 'makeup';
$lang->oa->webMenuOrder[20] = 'overtime';
$lang->oa->webMenuOrder[25] = 'lieu';

$lang->attend->webMenu    = $lang->oa->webMenu;
$lang->leave->webMenu     = $lang->oa->webMenu;
$lang->makeup->webMenu    = $lang->oa->webMenu;
$lang->overtime->webMenu  = $lang->oa->webMenu;
$lang->lieu->webMenu      = $lang->oa->webMenu;

$lang->attend->webMenuOrder   = $lang->oa->webMenuOrder;
$lang->leave->webMenuOrder    = $lang->oa->webMenuOrder;
$lang->makeup->webMenuOrder   = $lang->oa->webMenuOrder;
$lang->overtime->webMenuOrder = $lang->oa->webMenuOrder;
$lang->lieu->webMenuOrder     = $lang->oa->webMenuOrder;

$lang->feedback->webMenu = new stdclass();
$lang->feedback->webMenu->unclosed   = array('link' => '未关闭|feedback|admin|browseType=unclosed', 'subModule' => 'tree');
$lang->feedback->webMenu->all        = array('link' => '全部|feedback|admin|browseType=all');
$lang->feedback->webMenu->public     = array('link' => '公开|feedback|admin|browseType=public');
$lang->feedback->webMenu->tostory    = array('link' => "转需求|feedback|admin|browseType=tostory");
$lang->feedback->webMenu->totask     = array('link' => '转任务|feedback|admin|browseType=totask');
$lang->feedback->webMenu->tobug      = array('link' => '转Bug|feedback|admin|browseType=tobug');
$lang->feedback->webMenu->totodo     = array('link' => '转待办|feedback|admin|browseType=totodo');
$lang->feedback->webMenu->assigntome = array('link' => '指派给我|feedback|admin|browseType=assigntome');

$lang->feedback->webMenuOrder[5]  = 'unclosed';
$lang->feedback->webMenuOrder[10] = 'all';
$lang->feedback->webMenuOrder[15] = 'public';
$lang->feedback->webMenuOrder[20] = 'tostory';
$lang->feedback->webMenuOrder[25] = 'totask';
$lang->feedback->webMenuOrder[30] = 'tobug';
$lang->feedback->webMenuOrder[35] = 'totodo';
$lang->feedback->webMenuOrder[40] = 'assigntome';

$lang->report->menu->visualization = array('link' => '设计|dataset|browse', 'subModule' => 'dataset,dashboard,chart,tree,report', 'exclude' => 'report-productsummary,report-roadmap,report-productinvest,report-show,report-projectdeviation,report-bugcreate,report-bugassign,report-testcase,report-casesrun,report-build,report-storylinkedbug,report-workload,report-worksummary,report-workassignsummary,report-bugsummary,report-bugassignsummary');
$lang->report->methodOrder[50] = 'visualization';

$lang->report->menu->visualization['subMenu'] = new stdclass();
$lang->report->menu->visualization['subMenu']->dataset   = array('link' => '数据集|dataset|browse', 'subModule' => 'dataset');
$lang->report->menu->visualization['subMenu']->chart     = array('link' => '图表|chart|browse', 'subModule' => 'chart');
$lang->report->menu->visualization['subMenu']->custom    = array('link' => '透视表|report|browsereport', 'alias' => 'custom');
$lang->report->menu->visualization['subMenu']->dashboard = array('link' => '仪表盘|dashboard|browse', 'subModule' => 'dashboard,tree');

$lang->navGroup->chart     = 'report';
$lang->navGroup->dashboard = 'report';
$lang->navGroup->dataset   = 'report';

if(!helper::hasFeature('OA'))          unset($lang->mainNav->oa,          $lang->mainNav->menuOrder[60]);
if(!helper::hasFeature('deploy'))      unset($lang->mainNav->ops,         $lang->mainNav->menuOrder[65]);
if(!helper::hasFeature('traincourse')) unset($lang->mainNav->traincourse, $lang->mainNav->menuOrder[75]);

if(!helper::hasFeature('OA'))     $lang->dividerMenu = str_replace(',oa,',  ',ops,',      $lang->dividerMenu);
if(!helper::hasFeature('deploy')) $lang->dividerMenu = str_replace(',ops,', ',feedback,', $lang->dividerMenu);
