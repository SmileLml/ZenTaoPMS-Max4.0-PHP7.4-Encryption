<?php
global $app, $config;
/* Feedback */
$lang->resource->feedback = new stdclass();
$lang->resource->feedback->index             = 'index';
$lang->resource->feedback->create            = 'create';
$lang->resource->feedback->edit              = 'edit';
$lang->resource->feedback->editOthers        = 'editOthers';
$lang->resource->feedback->view              = 'view';
$lang->resource->feedback->admin             = 'browse';
$lang->resource->feedback->adminView         = 'adminView';
//$lang->resource->feedback->browse          = 'nonRDBrowse';
$lang->resource->feedback->assignTo          = 'assignAction';
$lang->resource->feedback->toTask            = 'toTask';
$lang->resource->feedback->toTodo            = 'toTodo';
$lang->resource->feedback->toBug             = 'toBug';
$lang->resource->feedback->toStory           = 'toStory';
$lang->resource->feedback->toTicket          = 'toTicket';
if($config->URAndSR or (defined('IN_UPGRADE') and IN_UPGRADE)) $lang->resource->feedback->toUserStory = 'toUserStory';
$lang->resource->feedback->review            = 'reviewAction';
$lang->resource->feedback->comment           = 'comment';
$lang->resource->feedback->reply             = 'reply';
$lang->resource->feedback->ask               = 'ask';
$lang->resource->feedback->close             = 'closeAction';
$lang->resource->feedback->delete            = 'delete';
$lang->resource->feedback->activate          = 'activate';
$lang->resource->feedback->export            = 'exportAction';
$lang->resource->feedback->batchEdit         = 'batchEdit';
$lang->resource->feedback->batchClose        = 'batchClose';
$lang->resource->feedback->batchReview       = 'batchReview';
$lang->resource->feedback->batchAssignTo     = 'batchAssignTo';
$lang->resource->feedback->batchChangeModule = 'batchChangeModule';
$lang->resource->feedback->products          = 'products';
$lang->resource->feedback->manageProduct     = 'manageProduct';
$lang->resource->feedback->import            = 'import';
$lang->resource->feedback->exportTemplate    = 'exportTemplate';
$lang->resource->feedback->syncProduct       = 'syncProduct';
$lang->resource->feedback->productSetting    = 'productSetting';

/* Faq. */
$lang->resource->faq = new stdclass();
$lang->resource->faq->browse = 'browse';
$lang->resource->faq->create = 'create';
$lang->resource->faq->edit   = 'edit';
$lang->resource->faq->delete = 'delete';

$lang->resource->ticket = new stdclass();
$lang->resource->ticket->index          = 'index';
$lang->resource->ticket->create         = 'create';
$lang->resource->ticket->edit           = 'edit';
$lang->resource->ticket->view           = 'view';
$lang->resource->ticket->browse         = 'browse';
$lang->resource->ticket->assignTo       = 'assign';
$lang->resource->ticket->createBug      = 'createBug';
$lang->resource->ticket->createStory    = 'createStory';
$lang->resource->ticket->start          = 'start';
$lang->resource->ticket->finish         = 'finish';
$lang->resource->ticket->close          = 'close';
$lang->resource->ticket->activate       = 'activate';
$lang->resource->ticket->delete         = 'delete';
$lang->resource->ticket->exportTemplate = 'exportTemplate';
$lang->resource->ticket->import         = 'import';
$lang->resource->ticket->export         = 'exportAction';
$lang->resource->ticket->batchEdit      = 'batchEdit';
$lang->resource->ticket->batchClose     = 'batchClose';
$lang->resource->ticket->batchActivate  = 'batchActivate';
$lang->resource->ticket->batchFinish    = 'batchFinish';
$lang->resource->ticket->batchAssignTo  = 'batchAssignTo';
$lang->resource->ticket->syncProduct    = 'syncProduct';

$lang->resource->custom->libreoffice = 'libreOffice';

/* User */
$lang->resource->user->export        = 'export';
$lang->resource->user->exportTemplate = 'exportTemplate';

$lang->user->methodOrder[90] = 'export';
$lang->user->methodOrder[95] = 'exportTemplate';

/* Attend */
$lang->resource->attend = new stdclass();
$lang->resource->attend->department       = 'department';
$lang->resource->attend->company          = 'company';
$lang->resource->attend->browseReview     = 'browseReview';
$lang->resource->attend->review           = 'review';
$lang->resource->attend->export           = 'exportAction';
$lang->resource->attend->stat             = 'reportAction';
$lang->resource->attend->saveStat         = 'saveStatAction';
$lang->resource->attend->exportStat       = 'exportStat';
$lang->resource->attend->detail           = 'detailAction';
$lang->resource->attend->exportDetail     = 'exportDetail';
$lang->resource->attend->settings         = 'settings';
$lang->resource->attend->personalSettings = 'personalSettings';
$lang->resource->attend->setManager       = 'setManager';

$lang->resource->attend->personal         = 'personal';
$lang->resource->attend->edit             = 'editAction';

$lang->attend->methodOrder[5]  = 'department';
$lang->attend->methodOrder[10] = 'company';
$lang->attend->methodOrder[15] = 'browseReview';
$lang->attend->methodOrder[20] = 'review';
$lang->attend->methodOrder[25] = 'export';
$lang->attend->methodOrder[30] = 'stat';
$lang->attend->methodOrder[35] = 'saveStat';
$lang->attend->methodOrder[40] = 'exportStat';
$lang->attend->methodOrder[45] = 'detail';
$lang->attend->methodOrder[60] = 'exportDetail';
$lang->attend->methodOrder[65] = 'settings';
$lang->attend->methodOrder[70] = 'personalSettings';
$lang->attend->methodOrder[75] = 'setManager';

$lang->attend->methodOrder[80] = 'personal';
$lang->attend->methodOrder[85] = 'edit';

/* Holiday */
$lang->resource->holiday = new stdclass();
$lang->resource->holiday->create = 'createAction';
$lang->resource->holiday->edit   = 'editAction';
$lang->resource->holiday->delete = 'deleteAction';

$lang->resource->holiday->browse = 'browse';

$lang->holiday->methodOrder[0]  = 'browse';
$lang->holiday->methodOrder[5]  = 'create';
$lang->holiday->methodOrder[10] = 'edit';
$lang->holiday->methodOrder[15] = 'delete';

/* Leave */
$lang->resource->leave = new stdclass();
$lang->resource->leave->browseReview   = 'browseReview';
$lang->resource->leave->company        = 'companyAction';
$lang->resource->leave->review         = 'reviewAction';
$lang->resource->leave->export         = 'exportAction';
$lang->resource->leave->setReviewer    = 'setReviewerAction';
$lang->resource->leave->personalAnnual = 'personalAnnual';

$lang->resource->leave->personal     = 'personal';
$lang->resource->leave->create       = 'createAction';
$lang->resource->leave->edit         = 'editAction';
$lang->resource->leave->delete       = 'deleteAction';
$lang->resource->leave->view         = 'viewAction';
$lang->resource->leave->switchstatus = 'switchstatus';
$lang->resource->leave->back         = 'backAction';

$lang->leave->methodOrder[0]  = 'browseReview';
$lang->leave->methodOrder[5]  = 'company';
$lang->leave->methodOrder[10] = 'review';
$lang->leave->methodOrder[15] = 'export';
$lang->leave->methodOrder[20] = 'setReviewer';
$lang->leave->methodOrder[25] = 'personalAnnual';

$lang->leave->methodOrder[30] = 'personal';
$lang->leave->methodOrder[35] = 'create';
$lang->leave->methodOrder[40] = 'edit';
$lang->leave->methodOrder[45] = 'delete';
$lang->leave->methodOrder[50] = 'view';
$lang->leave->methodOrder[55] = 'switchstatus';
$lang->leave->methodOrder[60] = 'back';

/* Makeup */
$lang->resource->makeup = new stdclass();
$lang->resource->makeup->browseReview = 'browseReview';
$lang->resource->makeup->company      = 'companyAction';
$lang->resource->makeup->review       = 'reviewAction';
$lang->resource->makeup->export       = 'exportAction';
$lang->resource->makeup->setReviewer  = 'setReviewerAction';

$lang->resource->makeup->personal     = 'personal';
$lang->resource->makeup->create       = 'createAction';
$lang->resource->makeup->edit         = 'editAction';
$lang->resource->makeup->view         = 'viewAction';
$lang->resource->makeup->delete       = 'deleteAction';
$lang->resource->makeup->switchstatus = 'switchstatus';

$lang->makeup->methodOrder[0]  = 'browseReview';
$lang->makeup->methodOrder[5]  = 'company';
$lang->makeup->methodOrder[10] = 'review';
$lang->makeup->methodOrder[15] = 'export';
$lang->makeup->methodOrder[20] = 'setReviewer';

$lang->makeup->methodOrder[25]  = 'personal';
$lang->makeup->methodOrder[30]  = 'create';
$lang->makeup->methodOrder[35] = 'edit';
$lang->makeup->methodOrder[40] = 'view';
$lang->makeup->methodOrder[45] = 'delete';
$lang->makeup->methodOrder[50] = 'switchstatus';

/* Overtime */
$lang->resource->overtime = new stdclass();
$lang->resource->overtime->browseReview = 'browseReview';
$lang->resource->overtime->company      = 'companyAction';
$lang->resource->overtime->review       = 'reviewAction';
$lang->resource->overtime->export       = 'exportAction';
$lang->resource->overtime->setReviewer  = 'setReviewerAction';

$lang->resource->overtime->personal     = 'personal';
$lang->resource->overtime->create       = 'createAction';
$lang->resource->overtime->edit         = 'editAction';
$lang->resource->overtime->view         = 'viewAction';
$lang->resource->overtime->delete       = 'deleteAction';
$lang->resource->overtime->switchstatus = 'switchstatus';

$lang->overtime->methodOrder[0]  = 'browseReview';
$lang->overtime->methodOrder[5]  = 'company';
$lang->overtime->methodOrder[10] = 'review';
$lang->overtime->methodOrder[15] = 'export';
$lang->overtime->methodOrder[20] = 'setReviewer';

$lang->overtime->methodOrder[25]  = 'personal';
$lang->overtime->methodOrder[30]  = 'create';
$lang->overtime->methodOrder[35] = 'edit';
$lang->overtime->methodOrder[40] = 'view';
$lang->overtime->methodOrder[45] = 'delete';
$lang->overtime->methodOrder[50] = 'switchstatus';

/* Lieu */
$lang->resource->lieu = new stdclass();
$lang->resource->lieu->company      = 'companyAction';
$lang->resource->lieu->browseReview = 'browseReviewAction';
$lang->resource->lieu->review       = 'reviewAction';
$lang->resource->lieu->setReviewer  = 'setReviewerAction';

$lang->resource->lieu->personal     = 'personal';
$lang->resource->lieu->create       = 'createAction';
$lang->resource->lieu->edit         = 'editAction';
$lang->resource->lieu->delete       = 'deleteAction';
$lang->resource->lieu->view         = 'viewAction';
$lang->resource->lieu->switchstatus = 'switchstatus';

$lang->lieu->methodOrder[0]  = 'company';
$lang->lieu->methodOrder[5]  = 'browseReview';
$lang->lieu->methodOrder[10] = 'review';
$lang->lieu->methodOrder[15] = 'setReviewer';

$lang->lieu->methodOrder[20]  = 'personal';
$lang->lieu->methodOrder[25]  = 'create';
$lang->lieu->methodOrder[30] = 'edit';
$lang->lieu->methodOrder[35] = 'delete';
$lang->lieu->methodOrder[40] = 'view';
$lang->lieu->methodOrder[45] = 'switchstatus';

/* Ops */
$lang->resource->tree->editHost = 'editHost';
$lang->resource->tree->browsehost = 'groupMaintenance';

$lang->tree->methodOrder[35] = 'editHost';
$lang->host->methodOrder[40] = 'groupMaintenance';

$lang->resource->ops = new stdclass();
$lang->resource->ops->index    = 'index';
$lang->resource->ops->setting  = 'setting';

$lang->ops->methodOrder[5]  = 'index';
$lang->ops->methodOrder[10] = 'setting';

$lang->resource->host = new stdclass();
$lang->resource->host->browse       = 'browse';
$lang->resource->host->create       = 'create';
$lang->resource->host->edit         = 'editAction';
$lang->resource->host->view         = 'view';
$lang->resource->host->delete       = 'deleteAction';
$lang->resource->host->changeStatus = 'changeStatus';
$lang->resource->host->treemap      = 'treemap';

$lang->host->methodOrder[5]  = 'browse';
$lang->host->methodOrder[10] = 'create';
$lang->host->methodOrder[15] = 'edit';
$lang->host->methodOrder[20] = 'view';
$lang->host->methodOrder[25] = 'delete';
$lang->host->methodOrder[30] = 'changeStatus';
$lang->host->methodOrder[35] = 'treemap';

$lang->resource->serverroom = new stdclass();
$lang->resource->serverroom->browse = 'browse';
$lang->resource->serverroom->create = 'create';
$lang->resource->serverroom->edit   = 'editAction';
$lang->resource->serverroom->view   = 'view';
$lang->resource->serverroom->delete = 'delete';

$lang->serverroom->methodOrder[5]  = 'browse';
$lang->serverroom->methodOrder[10] = 'create';
$lang->serverroom->methodOrder[15] = 'edit';
$lang->serverroom->methodOrder[20] = 'view';
$lang->serverroom->methodOrder[25] = 'delete';

$lang->resource->account = new stdclass();
$lang->resource->account->browse       = 'browse';
$lang->resource->account->create       = 'create';
$lang->resource->account->edit         = 'editAction';
$lang->resource->account->view         = 'view';
$lang->resource->account->delete       = 'deleteAction';

$lang->account = new stdclass();
$lang->account->methodOrder[5]  = 'browse';
$lang->account->methodOrder[10] = 'create';
$lang->account->methodOrder[15] = 'edit';
$lang->account->methodOrder[20] = 'view';
$lang->account->methodOrder[25] = 'delete';

$lang->resource->domain = new stdclass();
$lang->resource->domain->browse       = 'browse';
$lang->resource->domain->create       = 'create';
$lang->resource->domain->edit         = 'editAction';
$lang->resource->domain->view         = 'view';
$lang->resource->domain->delete       = 'deleteAction';

$lang->domain = new stdclass();
$lang->domain->methodOrder[5]  = 'browse';
$lang->domain->methodOrder[10] = 'create';
$lang->domain->methodOrder[15] = 'edit';
$lang->domain->methodOrder[20] = 'view';
$lang->domain->methodOrder[25] = 'delete';


$lang->resource->service = new stdclass();
$lang->resource->service->index  = 'index';
$lang->resource->service->create = 'create';
$lang->resource->service->edit   = 'edit';
$lang->resource->service->view   = 'view';
$lang->resource->service->delete = 'delete';
$lang->resource->service->manage = 'manage';
$lang->resource->service->browse = 'browse';

$lang->service->methodOrder[5]  = 'index';
$lang->service->methodOrder[10] = 'create';
$lang->service->methodOrder[15] = 'edit';
$lang->service->methodOrder[20] = 'view';
$lang->service->methodOrder[25] = 'delete';
$lang->service->methodOrder[30] = 'manage';
$lang->service->methodOrder[35] = 'browse';

$lang->resource->deploy = new stdclass();
$lang->resource->deploy->browse           = 'browse';
$lang->resource->deploy->create           = 'create';
$lang->resource->deploy->edit             = 'editAction';
$lang->resource->deploy->delete           = 'deleteAction';
$lang->resource->deploy->activate         = 'activateAction';
$lang->resource->deploy->finish           = 'finishAction';
$lang->resource->deploy->scope            = 'scope';
$lang->resource->deploy->manageScope      = 'manageScope';
$lang->resource->deploy->view             = 'view';
$lang->resource->deploy->cases            = 'casesAction';
$lang->resource->deploy->linkCases        = 'linkCases';
$lang->resource->deploy->unlinkCase       = 'unlinkCase';
$lang->resource->deploy->batchUnlinkCases = 'batchUnlinkCases';
$lang->resource->deploy->steps            = 'steps';
$lang->resource->deploy->manageStep       = 'manageStep';
$lang->resource->deploy->finishStep       = 'finishStep';
$lang->resource->deploy->assignTo         = 'assignAction';
$lang->resource->deploy->viewStep         = 'viewStep';
$lang->resource->deploy->editStep         = 'editStep';
$lang->resource->deploy->deleteStep       = 'deleteStep';

$lang->service->methodOrder[5]   = 'browse';
$lang->service->methodOrder[10]  = 'create';
$lang->service->methodOrder[15]  = 'edit';
$lang->service->methodOrder[20]  = 'delete';
$lang->service->methodOrder[25]  = 'activate';
$lang->service->methodOrder[30]  = 'finish';
$lang->service->methodOrder[35]  = 'scope';
$lang->service->methodOrder[40]  = 'manageScope';
$lang->service->methodOrder[45]  = 'view';
$lang->service->methodOrder[50]  = 'cases';
$lang->service->methodOrder[55]  = 'linkCases';
$lang->service->methodOrder[60]  = 'unlinkCase';
$lang->service->methodOrder[65]  = 'batchUnlinkCases';
$lang->service->methodOrder[70]  = 'steps';
$lang->service->methodOrder[75]  = 'manageStep';
$lang->service->methodOrder[80]  = 'finishStep';
$lang->service->methodOrder[85]  = 'assignTo';
$lang->service->methodOrder[90]  = 'viewStep';
$lang->service->methodOrder[95]  = 'editStep';
$lang->service->methodOrder[100] = 'deleteStep';

$lang->resource->testtask->runDeployCase     = 'runDeployCase';
$lang->resource->testtask->deployCaseResults = 'deployCaseResults';

$lang->resource->doc->diff             = 'diffAction';
$lang->resource->doc->manageBook       = 'manageBook';
$lang->resource->doc->catalog          = 'catalogAction';
$lang->resource->doc->wiki2export      = 'wiki2export';
$lang->resource->doc->product2export   = 'product2export';
$lang->resource->doc->execution2export = 'execution2export';
$lang->resource->doc->project2export   = 'project2export';
$lang->resource->doc->custom2export    = 'custom2export';

$lang->resource->my->review = 'review';

$lang->resource->conference = new stdclass();
$lang->resource->conference->admin = 'admin';

/* Train Course. */
$lang->resource->traincourse = new stdclass();
$lang->resource->traincourse->browse = 'browse';
$lang->resource->traincourse->viewCourse = 'viewCourse';
$lang->resource->traincourse->viewChapter = 'viewChapter';
$lang->resource->traincourse->admin = 'admin';
/*
$lang->resource->traincourse->browseCategory = 'browseCategory';
$lang->resource->traincourse->categoryChildren = 'categoryChildren';
$lang->resource->traincourse->editCategory = 'editCategory';
$lang->resource->traincourse->deleteCategory = 'deleteCategory';
$lang->resource->traincourse->createCourse = 'createCourse';
$lang->resource->traincourse->editCourse = 'editCourse';
$lang->resource->traincourse->manageCourse = 'manageCourse';
 */

$lang->resource->traincourse->deleteCourse = 'deleteCourse';
$lang->resource->traincourse->changeStatus = 'changeStatus';

/*
$lang->resource->traincourse->manageChapter = 'manageChapter';
$lang->resource->traincourse->editChapter = 'editChapter';
$lang->resource->traincourse->deleteChapter = 'deleteChapter';
 */

$lang->resource->traincourse->uploadCourse = 'uploadCourse';

$lang->traincourse->methodOrder[5]   = 'browse';
$lang->traincourse->methodOrder[10]  = 'viewcourse';
$lang->traincourse->methodOrder[15]  = 'viewchapter';
$lang->traincourse->methodOrder[20]  = 'admin';
$lang->traincourse->methodOrder[25]  = 'browseCategory';
$lang->traincourse->methodOrder[30]  = 'categoryChildren';
$lang->traincourse->methodOrder[35]  = 'editCategory';
$lang->traincourse->methodOrder[40]  = 'deleteCategory';
$lang->traincourse->methodOrder[45]  = 'createCourse';
$lang->traincourse->methodOrder[50]  = 'editCourse';
$lang->traincourse->methodOrder[55]  = 'manageCourse';
$lang->traincourse->methodOrder[60]  = 'deleteCourse';
$lang->traincourse->methodOrder[65]  = 'changeStatus';
$lang->traincourse->methodOrder[70]  = 'manageChapter';
$lang->traincourse->methodOrder[75]  = 'editChapter';
$lang->traincourse->methodOrder[80]  = 'deleteChapter';
$lang->traincourse->methodOrder[85]  = 'uploadCourse';

$lang->resource->api->export = 'export';

$lang->moduleOrder[255]  = 'chart';
$lang->resource->chart = new stdclass();
$lang->resource->chart->browse = 'browse';
$lang->resource->chart->create = 'create';
$lang->resource->chart->edit   = 'edit';
$lang->resource->chart->design = 'design';
$lang->resource->chart->delete = 'delete';

$lang->moduleOrder[260]  = 'dataset';
$lang->resource->dataset = new stdclass();
$lang->resource->dataset->browse = 'browse';
$lang->resource->dataset->create = 'create';
$lang->resource->dataset->view   = 'view';
$lang->resource->dataset->edit   = 'edit';
$lang->resource->dataset->delete = 'delete';

$lang->moduleOrder[265]  = 'dashboard';
$lang->resource->dashboard = new stdclass();
$lang->resource->dashboard->browse = 'browse';
$lang->resource->dashboard->create = 'create';
$lang->resource->dashboard->view   = 'view';
$lang->resource->dashboard->design = 'design';
$lang->resource->dashboard->edit   = 'edit';
$lang->resource->dashboard->delete = 'delete';

$inUpgrade = (defined('IN_UPGRADE') and IN_UPGRADE);
if(!$inUpgrade)
{
    if(!helper::hasFeature('OA'))
    {
        unset($lang->resource->attend);
        unset($lang->resource->leave);
        unset($lang->resource->makeup);
        unset($lang->resource->overtime);
        unset($lang->resource->lieu);
    }
    if(!helper::hasFeature('deploy'))
    {
        unset($lang->resource->deploy);
        unset($lang->resource->host);
        unset($lang->resource->vm);
        unset($lang->resource->serverroom);
        unset($lang->resource->service);
        unset($lang->resource->account);
        unset($lang->resource->domain);
        unset($lang->resource->ops);
    }
    if(!helper::hasFeature('traincourse')) unset($lang->resource->traincourse);
}
