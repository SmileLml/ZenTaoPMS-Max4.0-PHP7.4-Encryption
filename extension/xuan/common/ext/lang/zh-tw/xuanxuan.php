<?php
$lang->xuanxuan = new stdclass();
if($config->vision != 'lite')
{
    $lang->admin->menu->xuanxuan = array('link' => '聊天|admin|xuanxuan', 'subModule' => 'client,setting');
    $lang->admin->menuOrder[6]   = 'xuanxuan';
}

$lang->admin->menu->xuanxuan['subMenu'] = new stdclass();
$lang->admin->menu->xuanxuan['subMenu']->index   = array('link' => '首頁|admin|xuanxuan');
$lang->admin->menu->xuanxuan['subMenu']->setting = array('link' => '參數|setting|xuanxuan');
$lang->admin->menu->xuanxuan['subMenu']->update  = array('link' => '更新|client|browse', 'subModule' => 'client');

$lang->admin->menu->xuanxuan['menuOrder'][0]  = 'index';
$lang->admin->menu->xuanxuan['menuOrder'][5]  = 'setting';
$lang->admin->menu->xuanxuan['menuOrder'][10] = 'update';

global $config;
if($config->edition != 'open')
{
    $lang->admin->menu->xuanxuan['subModule']           = 'client,setting,conference';
    $lang->admin->menu->xuanxuan['subMenu']->conference = array('link' => '音視頻|conference|admin');
    $lang->admin->menu->xuanxuan['menuOrder'][7]        = 'conference';
    $lang->navGroup->conference                         = 'admin';
}

$lang->navGroup->im      = 'admin';
$lang->navGroup->setting = 'admin';
$lang->navGroup->client  = 'admin';

$lang->confirmDelete = '您確定要執行刪除操作嗎？';
