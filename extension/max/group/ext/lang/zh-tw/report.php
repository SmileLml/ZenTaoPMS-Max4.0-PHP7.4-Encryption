<?php
$lang->resource->report->casesrun          = 'casesrun';
$lang->resource->report->storyLinkedBug    = 'storyLinkedBug';
$lang->resource->report->testcase          = 'testcase';
$lang->resource->report->build             = 'build';
$lang->resource->report->workSummary       = 'workSummary';
$lang->resource->report->roadmap           = 'roadmap';
$lang->resource->report->productInvest     = 'productInvest';
$lang->resource->report->bugSummary        = 'bugSummary';
$lang->resource->report->bugAssignSummary  = 'bugAssignSummary';
$lang->resource->report->workAssignSummary = 'workAssignSummary';

if(!helper::hasFeature('product_roadmap')) unset($lang->resource->report->roadmap);
