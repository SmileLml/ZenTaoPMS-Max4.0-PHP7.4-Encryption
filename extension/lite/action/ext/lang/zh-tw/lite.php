<?php
$lang->action->label->execution = "看板|execution|task|executionID=%s";
$lang->action->label->task      = '任務|task|view|taskID=%s';
$lang->action->label->module    = '目錄|tree|browse|productid=%s&type=story&currentModuleID=0&branch=all';

/* Object type. */
$lang->action->objectTypes['execution'] = '項目' . $lang->executionCommon;

$lang->action->search = new stdclass();
$lang->action->search->objectTypeList['']            = '';
$lang->action->search->objectTypeList['project']     = '項目';
$lang->action->search->objectTypeList['execution']   = '看板';
$lang->action->search->objectTypeList['story']       = "目標";
$lang->action->search->objectTypeList['task']        = '任務';
$lang->action->search->objectTypeList['user']        = '用戶';
$lang->action->search->objectTypeList['doc']         = '文檔';
$lang->action->search->objectTypeList['todo']        = '待辦';

unset($lang->action->dynamicAction->program);
unset($lang->action->dynamicAction->product);
unset($lang->action->dynamicAction->productplan);
unset($lang->action->dynamicAction->release);
unset($lang->action->dynamicAction->build);
unset($lang->action->dynamicAction->bug);
unset($lang->action->dynamicAction->testtask);
unset($lang->action->dynamicAction->case);
unset($lang->action->dynamicAction->testreport);
unset($lang->action->dynamicAction->testsuite);
unset($lang->action->dynamicAction->caselib);
unset($lang->action->dynamicAction->issue);
unset($lang->action->dynamicAction->risk);
unset($lang->action->dynamicAction->opportunity);
unset($lang->action->dynamicAction->researchplan);
unset($lang->action->dynamicAction->researchreport);
unset($lang->action->dynamicAction->meeting);
unset($lang->action->dynamicAction->auditplan);
unset($lang->action->dynamicAction->pssp);
unset($lang->action->dynamicAction->nc);

$lang->action->dynamicAction->task = array();
$lang->action->dynamicAction->task['opened']              = '創建任務';
$lang->action->dynamicAction->task['edited']              = '編輯任務';
$lang->action->dynamicAction->task['commented']           = '備註任務';
$lang->action->dynamicAction->task['assigned']            = '指派任務';
$lang->action->dynamicAction->task['confirmed']           = "確認{$lang->SRCommon}變更";
$lang->action->dynamicAction->task['started']             = '開始任務';
$lang->action->dynamicAction->task['finished']            = '完成任務';
$lang->action->dynamicAction->task['recordestimate']      = '記錄工時';
$lang->action->dynamicAction->task['editestimate']        = '編輯工時';
$lang->action->dynamicAction->task['deleteestimate']      = '刪除工時';
$lang->action->dynamicAction->task['paused']              = '暫停任務';
$lang->action->dynamicAction->task['closed']              = '關閉任務';
$lang->action->dynamicAction->task['canceled']            = '取消任務';
$lang->action->dynamicAction->task['activated']           = '激活任務';
$lang->action->dynamicAction->task['createchildren']      = '創建子任務';
$lang->action->dynamicAction->task['unlinkparenttask']    = '從父任務取消關聯';
$lang->action->dynamicAction->task['deletechildrentask']  = '刪除子任務';
$lang->action->dynamicAction->task['linkparenttask']      = '關聯到父任務';
$lang->action->dynamicAction->task['linkchildtask']       = '關聯子任務';

$lang->action->label->createchildrenstory   = "創建子目標";
$lang->action->label->linkchildstory        = "關聯子目標";
$lang->action->label->unlinkchildrenstory   = "取消關聯子目標";
$lang->action->label->linkparentstory       = "關聯到父目標";
$lang->action->label->unlinkparentstory     = "從父目標取消關聯";
$lang->action->label->deletechildrenstory   = "刪除子目標";

$lang->action->search->label = array();
$lang->action->search->label['']                      = '';
$lang->action->search->label['created']               = $lang->action->label->created;
$lang->action->search->label['opened']                = $lang->action->label->opened;
$lang->action->search->label['changed']               = $lang->action->label->changed;
$lang->action->search->label['edited']                = $lang->action->label->edited;
$lang->action->search->label['assigned']              = $lang->action->label->assigned;
$lang->action->search->label['closed']                = $lang->action->label->closed;
$lang->action->search->label['deleted']               = $lang->action->label->deleted;
$lang->action->search->label['deletedfile']           = $lang->action->label->deletedfile;
$lang->action->search->label['editfile']              = $lang->action->label->editfile;
$lang->action->search->label['erased']                = $lang->action->label->erased;
$lang->action->search->label['undeleted']             = $lang->action->label->undeleted;
$lang->action->search->label['hidden']                = $lang->action->label->hidden;
$lang->action->search->label['commented']             = $lang->action->label->commented;
$lang->action->search->label['activated']             = $lang->action->label->activated;
$lang->action->search->label['reviewed']              = $lang->action->label->reviewed;
$lang->action->search->label['moved']                 = $lang->action->label->moved;
$lang->action->search->label['confirmed']             = $lang->action->label->confirmed;
$lang->action->search->label['totask']                = $lang->action->label->totask;
$lang->action->search->label['changestatus']          = $lang->action->label->changestatus;
$lang->action->search->label['marked']                = $lang->action->label->marked;
$lang->action->search->label['linked2project']        = $lang->action->label->linked2project;
$lang->action->search->label['unlinkedfromproject']   = $lang->action->label->unlinkedfromproject;
$lang->action->search->label['linked2execution']      = $lang->action->label->linked2execution;
$lang->action->search->label['unlinkedfromexecution'] = $lang->action->label->unlinkedfromexecution;
$lang->action->search->label['started']               = $lang->action->label->started;
$lang->action->search->label['restarted']             = $lang->action->label->restarted;
$lang->action->search->label['recordestimate']        = $lang->action->label->recordestimate;
$lang->action->search->label['editestimate']          = $lang->action->label->editestimate;
$lang->action->search->label['canceled']              = $lang->action->label->canceled;
$lang->action->search->label['finished']              = $lang->action->label->finished;
$lang->action->search->label['paused']                = $lang->action->label->paused;
$lang->action->search->label['verified']              = $lang->action->label->verified;
$lang->action->search->label['login']                 = $lang->action->label->login;
$lang->action->search->label['logout']                = $lang->action->label->logout;

$lang->action->desc->createchildrenstory = '$date, 由 <strong>$actor</strong> 創建子目標 <strong>$extra</strong>。' . "\n";
$lang->action->desc->linkchildstory      = '$date, 由 <strong>$actor</strong> 關聯子目標 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkchildrenstory = '$date, 由 <strong>$actor</strong> 移除子目標 <strong>$extra</strong>。' . "\n";
$lang->action->desc->linkparentstory     = '$date, 由 <strong>$actor</strong> 關聯到父目標 <strong>$extra</strong>。' . "\n";
$lang->action->desc->unlinkparentstory   = '$date, 由 <strong>$actor</strong> 從父目標<strong>$extra</strong>取消關聯。' . "\n";
$lang->action->desc->deletechildrenstory = '$date, 由 <strong>$actor</strong> 刪除子目標<strong>$extra</strong>。' . "\n";

$lang->action->executionNoProject = '該項目看板沒有所屬的項目，請先還原項目再還原項目看板';
