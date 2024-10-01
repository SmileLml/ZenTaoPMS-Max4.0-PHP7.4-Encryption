<?php
$config->traincourse = new stdclass();
$config->traincourse->editor = new stdclass();
$config->traincourse->editor->editchapter  = array('id' => 'desc', 'tools' => 'simpleTools');
$config->traincourse->editor->editcourse   = array('id' => 'desc', 'tools' => 'simpleTools');
$config->traincourse->editor->createcourse = array('id' => 'desc', 'tools' => 'simpleTools');

$config->traincourse->markdown = new stdclass();
$config->traincourse->markdown->edit = array('id' => 'contentMarkdown', 'tools' => 'withchange');

$config->traincourse->create = new stdclass();
$config->traincourse->create->requiredFields = 'name';

$config->traincourse->edit = new stdclass();
$config->traincourse->edit->requiredFields = 'name';

$config->traincourse->uploadPath = 'data' . DIRECTORY_SEPARATOR . 'course' . DIRECTORY_SEPARATOR;

global $lang;
$config->traincourse->search['module']            = 'traincourse';
$config->traincourse->search['fields']['name']    = $lang->traincourse->name;
$config->traincourse->search['fields']['teacher'] = $lang->traincourse->teacher;
$config->traincourse->search['fields']['status']  = $lang->traincourse->status;

$config->traincourse->search['params']['name']    = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->traincourse->search['params']['teacher'] = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->traincourse->search['params']['status']  = array('operator' => '=', 'control' => 'select', 'values' => $lang->traincourse->progressList);
