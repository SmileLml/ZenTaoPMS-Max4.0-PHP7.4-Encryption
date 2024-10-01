<?php
global $lang, $app;
$app->loadLang('bug');
$config->excel = new stdclass();
$config->excel->editor['task']    = array('desc');
$config->excel->editor['story']   = array('spec', 'verify');
$config->excel->editor['bug']     = array('steps');
$config->excel->editor['project'] = array('desc');

$config->excel->width          = new stdclass();
$config->excel->width->short   = 16;
$config->excel->width->middle  = 26;
$config->excel->width->long    = 41;

$config->excel->autoWidths   = array('stepDesc', 'stepExpect', 'plan', 'branch', 'spec', 'verify', 'source', 'sourceNote', 'keywords', 'pri', 'estimate', 'consumed', 'left', 'status', 'stage', 'taskCountAB', 'bugCountAB', 'caseCountAB', 'openedBy', 'openedDate', 'assignedTo', 'assignedDate', 'mailto', 'reviewedBy', 'reviewedDate', 'closedBy', 'closedDate', 'closedReason', 'lastEditedBy', 'lastEditedDate', 'childStories', 'linkStories', 'duplicateStory', 'deadline','pri');
$config->excel->titleFields  = array('name', 'title', 'product', 'module', 'project', 'execution', 'story', 'plan', 'startTime');
$config->excel->shortFields  = array();

$config->excel->sysDataField = array('module', 'project', 'execution', 'plan', 'build', 'branch', 'assignedTo', 'story', 'task', 'openedBuild', 'reviewedBy', 'needReview', 'product', 'notify', 'public', 'mailto');

$config->excel->testcase = new stdclass();
$config->excel->testcase->initField['stepDesc']   = "1. \n2. \n3. ";
$config->excel->testcase->initField['stepExpect'] = "1. \n2. \n3. ";

$config->excel->caselib = new stdclass();
$config->excel->caselib->initField['stepDesc']   = "1. \n2. \n3. ";
$config->excel->caselib->initField['stepExpect'] = "1. \n2. \n3. ";

$config->excel->bug = new stdclass();
$config->excel->bug->initField['steps']       = str_replace(array('<p>', '</p>'), array('', "\n"), $lang->bug->tplStep . $lang->bug->tplResult . $lang->bug->tplExpect);
$config->excel->bug->initField['openedBuild'] = $lang->trunk . '(#trunk)';

$config->excel->freeze           = new stdclass();
$config->excel->freeze->testcase = 'title';
$config->excel->freeze->bug      = 'title';
$config->excel->freeze->task     = 'name';
$config->excel->freeze->story    = 'title';
$config->excel->freeze->tree     = 'title';
$config->excel->freeze->todo     = 'name';
$config->excel->freeze->leave    = 'id';
$config->excel->freeze->makeup   = 'id';
$config->excel->freeze->overtime = 'id';

$config->excel->dateField  = array('deadline', 'estStarted', 'realStarted');

$config->excel->noAutoFilter    = array('tree');
$config->excel->isShowSystemTab = array('tree');

$config->excel->requiredFieldModule = array('task', 'bug', 'testcase', 'story', 'feedback');
