<?php
$lang->approval->common   = '審批';
$lang->approval->node     = '審批節點';
$lang->approval->reviewer = '審批人';
$lang->approval->ccer     = '抄送人';
$lang->approval->progress = '審批進度';
$lang->approval->noResult = '未評審';

$lang->approval->reviewDesc = new stdclass();
$lang->approval->reviewDesc->start = '由 <strong>$actor</strong> 發起審批申請 <span class="text-muted">$date</span>' . "\n";
$lang->approval->reviewDesc->pass  = '由 <strong>$actor</strong> 審批，結果為<span class="result pass">已通過</span> <span class="text-muted">$date</span>' . "\n";
$lang->approval->reviewDesc->fail  = '由 <strong>$actor</strong> 審批，結果為<span class="result fail">不通過</span> <span class="text-muted">$date</span>' . "\n";
$lang->approval->reviewDesc->doing = '由 <strong>$actor</strong> 審批，正在<span class="result reviewing">審批中</span> <span class="text-muted">$date</span>' . "\n";
$lang->approval->reviewDesc->wait  = '<strong>$actor</strong> <span class="text-muted">待審批</span>' . "\n";
$lang->approval->reviewDesc->cc    = '抄送給 <strong>$actor</strong>' . "\n";

$lang->approval->reviewDesc->autoReject      = '已設置自動拒絶' . "\n";
$lang->approval->reviewDesc->autoPass        = '已設置自動同意' . "\n";
$lang->approval->reviewDesc->autoRejected    = '已經自動拒絶' . "\n";
$lang->approval->reviewDesc->autoPassed      = '已經自動同意' . "\n";
$lang->approval->reviewDesc->pass4NoReviewer = '未選定評審人，根據配置自動通過' . "\n";

$lang->approval->notice = new stdclass();
$lang->approval->notice->orSign       = '(一人通過即可)';
$lang->approval->notice->times        = '第%s次提交';
$lang->approval->notice->approvalTime = '已評審%s';
$lang->approval->notice->day          = '天';
$lang->approval->notice->hour         = '小時';

$lang->approval->currentResult = '當前節點審批結果';
$lang->approval->currentNode   = '當前節點';

$lang->approval->statusList = array();
$lang->approval->statusList['wait']  = '未開始';
$lang->approval->statusList['doing'] = '進行中';
$lang->approval->statusList['done']  = '已完成';

$lang->approval->resultList = array();
$lang->approval->resultList['pass'] = '通過';
$lang->approval->resultList['fail'] = '拒絶';

$lang->approval->mailResultList = array();
$lang->approval->mailResultList['pass']   = '通過';
$lang->approval->mailResultList['fail']   = '拒絶';
$lang->approval->mailResultList['ignore'] = '撤回';

$lang->approval->nodeList = array();
$lang->approval->nodeList['cc']     = '抄送';
$lang->approval->nodeList['review'] = '審批';
$lang->approval->nodeList['doing']  = '審批中';
