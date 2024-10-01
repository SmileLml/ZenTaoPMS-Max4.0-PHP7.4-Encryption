<?php
$lang->report->menu->pivotTable['alias'] = 'roadmap,productinvest,show,testcase,build,casesrun,storylinkedbug,worksummary,bugsummary,workassignsummary,bugassignsummary';

$lang->report->menu->pivotTable['subMenu'] = new stdclass();
$lang->report->menu->pivotTable['subMenu']->product = array('link' => "{$lang->product->common}|report|productsummary", 'alias' => 'roadmap,productinvest');
$lang->report->menu->pivotTable['subMenu']->project = array('link' => "{$lang->project->common}|report|projectdeviation");
$lang->report->menu->pivotTable['subMenu']->test    = array('link' => "{$lang->qa->common}|report|bugcreate", 'alias' => 'bugassign,testcase,build,casesrun,storylinkedbug');
$lang->report->menu->pivotTable['subMenu']->staff   = array('link' => "{$lang->system->common}|report|workload", 'alias' => 'worksummary,bugsummary,workassignsummary,bugassignsummary');

$lang->report->menu->pivotTable['menuOrder'][5]  = 'product';
$lang->report->menu->pivotTable['menuOrder'][10] = 'project';
$lang->report->menu->pivotTable['menuOrder'][15] = 'test';
$lang->report->menu->pivotTable['menuOrder'][20] = 'staff';

$lang->report->methodOrder[16] = 'testcase';
$lang->report->methodOrder[17] = 'Bản dựng';
$lang->report->methodOrder[21] = 'workSummary';
