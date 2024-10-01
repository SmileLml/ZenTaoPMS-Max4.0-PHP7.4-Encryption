<?php
$lang->navIcons['traincourse'] = "<i class='icon icon-college'></i>";

$lang->traincourse = new stdclass();
$lang->traincourse->common = '學堂';

$lang->mainNav->traincourse = "{$lang->navIcons['traincourse']} {$lang->traincourse->common}|traincourse|browse|";

$lang->searchLang = '搜索';

$lang->traincourse->menu = new stdclass();
$lang->traincourse->menu->browse = array('link' => '課程|traincourse|browse', 'alias' => 'create,edit,view,viewcourse,viewchapter');
$lang->traincourse->menu->admin  = array('link' => '後台|traincourse|admin', 'alias' => 'create,edit,browsecategory,managecourse,createcourse,editchapter,managechapter');

$lang->traincourse->menuOrder[5]  = 'browse';
$lang->traincourse->menuOrder[10] = 'admin';
