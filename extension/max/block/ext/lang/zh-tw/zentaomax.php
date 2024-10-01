<?php
$lang->block->default['waterfall']['project']['1']['title']  = '項目總體進展';
$lang->block->default['waterfall']['project']['1']['block']  = 'waterfallgeneralreport';
$lang->block->default['waterfall']['project']['1']['source'] = 'project';
$lang->block->default['waterfall']['project']['1']['grid']   = 8;

$lang->block->default['waterfall']['project']['2']['title']  = '估算';
$lang->block->default['waterfall']['project']['2']['block']  = 'waterfallestimate';
$lang->block->default['waterfall']['project']['2']['source'] = 'project';
$lang->block->default['waterfall']['project']['2']['grid']   = 4;

$lang->block->default['waterfall']['project']['3']['title']  = '項目周報';
$lang->block->default['waterfall']['project']['3']['block']  = 'waterfallreport';
$lang->block->default['waterfall']['project']['3']['source'] = 'project';
$lang->block->default['waterfall']['project']['3']['grid']   = 8;

$lang->block->default['waterfall']['project']['4']['title']  = '到目前為止項目進展趨勢圖';
$lang->block->default['waterfall']['project']['4']['block']  = 'waterfallprogress';
$lang->block->default['waterfall']['project']['4']['grid']   = 4;

$lang->block->default['waterfall']['project']['5']['title']  = '項目問題';
$lang->block->default['waterfall']['project']['5']['block']  = 'waterfallissue';
$lang->block->default['waterfall']['project']['5']['source'] = 'project';
$lang->block->default['waterfall']['project']['5']['grid']   = 8;

$lang->block->default['waterfall']['project']['5']['params']['type']    = 'all';
$lang->block->default['waterfall']['project']['5']['params']['count']   = '15';
$lang->block->default['waterfall']['project']['5']['params']['orderBy'] = 'id_desc';

$lang->block->default['waterfall']['project']['7']['title']  = '項目風險';
$lang->block->default['waterfall']['project']['7']['block']  = 'waterfallrisk';
$lang->block->default['waterfall']['project']['7']['source'] = 'project';
$lang->block->default['waterfall']['project']['7']['grid']   = 8;

$lang->block->default['waterfall']['project']['7']['params']['type']    = 'all';
$lang->block->default['waterfall']['project']['7']['params']['count']   = '15';
$lang->block->default['waterfall']['project']['7']['params']['orderBy'] = 'id_desc';

$lang->block->default['scrum']['project']['10']['title']  = '項目問題';
$lang->block->default['scrum']['project']['10']['block']  = 'scrumissue';
$lang->block->default['scrum']['project']['10']['source'] = 'project';
$lang->block->default['scrum']['project']['10']['grid']   = 8;

$lang->block->default['scrum']['project']['10']['params']['type']    = 'all';
$lang->block->default['scrum']['project']['10']['params']['count']   = '15';
$lang->block->default['scrum']['project']['10']['params']['orderBy'] = 'id_desc';

$lang->block->default['scrum']['project']['11']['title']  = '項目風險';
$lang->block->default['scrum']['project']['11']['block']  = 'scrumrisk';
$lang->block->default['scrum']['project']['11']['source'] = 'project';
$lang->block->default['scrum']['project']['11']['grid']   = 8;

$lang->block->default['scrum']['project']['11']['params']['type']    = 'all';
$lang->block->default['scrum']['project']['11']['params']['count']   = '15';
$lang->block->default['scrum']['project']['11']['params']['orderBy'] = 'id_desc';

$lang->block->modules['waterfall']['index']->availableBlocks->waterfallreport        = '項目周報';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallgeneralreport = '項目總體進展';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallestimate      = '估算';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallprogress      = '到目前為止項目進展趨勢圖';
if(helper::hasFeature('waterfall_issue')) $lang->block->modules['waterfall']['index']->availableBlocks->waterfallissue = '項目問題';
if(helper::hasFeature('waterfall_risk'))  $lang->block->modules['waterfall']['index']->availableBlocks->waterfallrisk  = '項目風險';

if(helper::hasFeature('scrum_issue')) $lang->block->modules['scrum']['index']->availableBlocks->scrumissue = '項目問題';
if(helper::hasFeature('scrum_risk'))  $lang->block->modules['scrum']['index']->availableBlocks->scrumrisk  = '項目風險';
