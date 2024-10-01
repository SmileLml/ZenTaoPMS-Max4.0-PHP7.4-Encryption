<?php
global $config;
$lang->admin->property = new stdclass();
$lang->admin->property->companyName = '公司名稱';
$lang->admin->property->startDate   = '授權時間';
$lang->admin->property->expireDate  = '到期時間';
if($config->visions != ',lite,') $lang->admin->property->user = '研發用戶人數';
$lang->admin->property->lite        = '迅捷版用戶人數';
$lang->admin->property->ip          = '授權IP';
$lang->admin->property->mac         = '授權MAC';
$lang->admin->property->domain      = '授權域名';
