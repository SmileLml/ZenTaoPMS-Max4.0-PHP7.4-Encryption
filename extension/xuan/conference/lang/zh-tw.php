<?php
$lang->conference->common         = '音視頻';
$lang->conference->admin          = '音視頻參數設置';
$lang->conference->notset         = '未設置';
$lang->conference->settings       = '音視頻參數配置';
$lang->conference->enabled        = '會議功能';
$lang->conference->enabledTip     = '開啟會議功能';
$lang->conference->serverAddr     = '音視頻伺服器地址';
$lang->conference->serverAddrTip  = '';
$lang->conference->apiPort        = '音視頻 API 連接埠';
$lang->conference->apiPortOwtTip  = '預設為 3004';
$lang->conference->apiPortSrsTip  = '預設為 1985';
$lang->conference->mgmtPort       = 'OWT 管理連接埠';
$lang->conference->mgmtPortTip    = '預設為 3300';
$lang->conference->rtcPort        = 'SRS 信令連接埠';
$lang->conference->rtcPortTip     = '預設為 1989';
$lang->conference->https          = '是否啟用 HTTPS';
$lang->conference->httpsTip       = 'SRS 預設部署關閉 HTTPS';
$lang->conference->serviceId      = 'OWT ID';
$lang->conference->serviceIdTip   = '';
$lang->conference->serviceKey     = 'OWT 密鑰';
$lang->conference->serviceKeyTip  = '';
$lang->conference->configGuideTip = '';
$lang->conference->backendTypeTip = '';

$lang->conference->setupTitle       = '音視頻伺服器部署指南';
$lang->conference->setupDescription = '喧喧提供音頻會議功能，需要部署額外的音視頻服務端。音視頻伺服器端分為 OWT 和 SRS ，推薦使用 SRS 音視頻服務端。';
$lang->conference->setupDoc         = '部署文檔';
$lang->conference->configDoc        = '配置文檔';
$lang->conference->download         = '下載地址';
$lang->conference->srsSetupTitle    = 'SRS 音視頻服務端';
$lang->conference->owtSetupTitle    = 'OWT 音視頻服務端';


$lang->conference->backend = new stdclass();
$lang->conference->backend->type  = '後端類型';
$lang->conference->backend->types = array('owt' => 'OWT', 'srs' => 'SRS');

$lang->conference->inputError = new stdClass();
$lang->conference->inputError->serviceId        = 'OWT ID 不能為空';
$lang->conference->inputError->serviceKey       = 'OWT 密鑰不能為空';
$lang->conference->inputError->serverAddr       = '伺服器地址不能為空';
$lang->conference->inputError->apiPort          = 'API 連接埠不能為空';
$lang->conference->inputError->mgmtPort         = 'OWT 管理連接埠不能為空';
$lang->conference->inputError->rtcPort          = '信令連接埠不能為空';
$lang->conference->inputError->resolutionWidth  = '請填寫分辨率寬度';
$lang->conference->inputError->resolutionHeight = '請填寫分辨率高度';

$lang->conference->server = '服務配置';
$lang->conference->video  = '視頻配置';

$lang->conference->resolutionWidth     = '分辨率寬度';
$lang->conference->resolutionWidthTip  = '單位：像素，建議值：最低 320 最高 1280';
$lang->conference->resolutionHeight    = '分辨率高度';
$lang->conference->resolutionHeightTip = '單位：像素，建議值：最低 240 最高 720';

$lang->conference->placeholder                   = new stdClass();
$lang->conference->placeholder->resolutionWidth  = '640';
$lang->conference->placeholder->resolutionHeight = '480';
