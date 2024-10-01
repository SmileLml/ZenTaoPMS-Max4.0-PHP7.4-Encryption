<?php
global $config;
$lang->admin->property = new stdclass();
$lang->admin->property->companyName = '公司名称';
$lang->admin->property->startDate   = '授权时间';
$lang->admin->property->expireDate  = '到期时间';
if($config->visions != ',lite,') $lang->admin->property->user = '研发用户人数';
$lang->admin->property->lite        = '迅捷版用户人数';
$lang->admin->property->ip          = '授权IP';
$lang->admin->property->mac         = '授权MAC';
$lang->admin->property->domain      = '授权域名';
