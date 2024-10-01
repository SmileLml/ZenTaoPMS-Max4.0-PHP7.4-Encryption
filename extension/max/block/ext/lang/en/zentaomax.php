<?php
$lang->block->default['waterfall']['project']['1']['title']  = 'Project General Report';
$lang->block->default['waterfall']['project']['1']['block']  = 'waterfallgeneralreport';
$lang->block->default['waterfall']['project']['1']['source'] = 'project';
$lang->block->default['waterfall']['project']['1']['grid']   = 8;

$lang->block->default['waterfall']['project']['2']['title']  = 'Estimate';
$lang->block->default['waterfall']['project']['2']['block']  = 'waterfallestimate';
$lang->block->default['waterfall']['project']['2']['source'] = 'project';
$lang->block->default['waterfall']['project']['2']['grid']   = 4;

$lang->block->default['waterfall']['project']['3']['title']  = 'Project Weekly';
$lang->block->default['waterfall']['project']['3']['block']  = 'waterfallreport';
$lang->block->default['waterfall']['project']['3']['source'] = 'project';
$lang->block->default['waterfall']['project']['3']['grid']   = 8;

$lang->block->default['waterfall']['project']['4']['title']  = 'Progress Chart';
$lang->block->default['waterfall']['project']['4']['block']  = 'waterfallprogress';
$lang->block->default['waterfall']['project']['4']['grid']   = 4;

$lang->block->default['waterfall']['project']['5']['title']  = 'Project Issue';
$lang->block->default['waterfall']['project']['5']['block']  = 'waterfallissue';
$lang->block->default['waterfall']['project']['5']['source'] = 'project';
$lang->block->default['waterfall']['project']['5']['grid']   = 8;

$lang->block->default['waterfall']['project']['5']['params']['type']    = 'all';
$lang->block->default['waterfall']['project']['5']['params']['count']   = '15';
$lang->block->default['waterfall']['project']['5']['params']['orderBy'] = 'id_desc';

$lang->block->default['waterfall']['project']['7']['title']  = 'Project Risk';
$lang->block->default['waterfall']['project']['7']['block']  = 'waterfallrisk';
$lang->block->default['waterfall']['project']['7']['source'] = 'project';
$lang->block->default['waterfall']['project']['7']['grid']   = 8;

$lang->block->default['waterfall']['project']['7']['params']['type']    = 'all';
$lang->block->default['waterfall']['project']['7']['params']['count']   = '15';
$lang->block->default['waterfall']['project']['7']['params']['orderBy'] = 'id_desc';

$lang->block->default['scrum']['project']['10']['title']  = 'Project Issue';
$lang->block->default['scrum']['project']['10']['block']  = 'waterfallissue';
$lang->block->default['scrum']['project']['10']['source'] = 'project';
$lang->block->default['scrum']['project']['10']['grid']   = 8;

$lang->block->default['scrum']['project']['10']['params']['type']    = 'all';
$lang->block->default['scrum']['project']['10']['params']['count']   = '15';
$lang->block->default['scrum']['project']['10']['params']['orderBy'] = 'id_desc';

$lang->block->default['scrum']['project']['11']['title']  = 'Project Risk';
$lang->block->default['scrum']['project']['11']['block']  = 'waterfallrisk';
$lang->block->default['scrum']['project']['11']['source'] = 'project';
$lang->block->default['scrum']['project']['11']['grid']   = 8;

$lang->block->default['scrum']['project']['11']['params']['type']    = 'all';
$lang->block->default['scrum']['project']['11']['params']['count']   = '15';
$lang->block->default['scrum']['project']['11']['params']['orderBy'] = 'id_desc';

$lang->block->modules['waterfall']['index']->availableBlocks->waterfallreport        = 'Project Week Report';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallgeneralreport = 'Project General Report';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallestimate      = 'Estimate';
$lang->block->modules['waterfall']['index']->availableBlocks->waterfallprogress      = 'Progress';
if(helper::hasFeature('waterfall_issue')) $lang->block->modules['waterfall']['index']->availableBlocks->waterfallissue = 'Project Issue';
if(helper::hasFeature('waterfall_risk'))  $lang->block->modules['waterfall']['index']->availableBlocks->waterfallrisk  = 'Project Risk';

if(helper::hasFeature('scrum_issue')) $lang->block->modules['scrum']['index']->availableBlocks->scrumissue = 'Project Issue';
if(helper::hasFeature('scrum_risk'))  $lang->block->modules['scrum']['index']->availableBlocks->scrumrisk  = 'Project Risk';
