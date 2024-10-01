<?php
$lang->conference->common         = '音视频';
$lang->conference->admin          = '音视频参数设置';
$lang->conference->notset         = '未设置';
$lang->conference->settings       = '音视频参数配置';
$lang->conference->enabled        = '会议功能';
$lang->conference->enabledTip     = '开启会议功能';
$lang->conference->serverAddr     = '音视频服务器地址';
$lang->conference->serverAddrTip  = '';
$lang->conference->apiPort        = '音视频 API 端口';
$lang->conference->apiPortOwtTip  = '默认为 3004';
$lang->conference->apiPortSrsTip  = '默认为 1985';
$lang->conference->mgmtPort       = 'OWT 管理端口';
$lang->conference->mgmtPortTip    = '默认为 3300';
$lang->conference->rtcPort        = 'SRS 信令端口';
$lang->conference->rtcPortTip     = '默认为 1989';
$lang->conference->https          = '是否启用 HTTPS';
$lang->conference->httpsTip       = 'SRS 默认部署关闭 HTTPS';
$lang->conference->serviceId      = 'OWT ID';
$lang->conference->serviceIdTip   = '';
$lang->conference->serviceKey     = 'OWT 密钥';
$lang->conference->serviceKeyTip  = '';
$lang->conference->configGuideTip = '';
$lang->conference->backendTypeTip = '';

$lang->conference->setupTitle       = '音视频服务器部署指南';
$lang->conference->setupDescription = '喧喧提供音频会议功能，需要部署额外的音视频服务端。音视频服务器端分为 OWT 和 SRS ，推荐使用 SRS 音视频服务端。';
$lang->conference->setupDoc         = '部署文档';
$lang->conference->configDoc        = '配置文档';
$lang->conference->download         = '下载地址';
$lang->conference->srsSetupTitle    = 'SRS 音视频服务端';
$lang->conference->owtSetupTitle    = 'OWT 音视频服务端';


$lang->conference->backend = new stdclass();
$lang->conference->backend->type  = '后端类型';
$lang->conference->backend->types = array('owt' => 'OWT', 'srs' => 'SRS');

$lang->conference->inputError = new stdClass();
$lang->conference->inputError->serviceId        = 'OWT ID 不能为空';
$lang->conference->inputError->serviceKey       = 'OWT 密钥不能为空';
$lang->conference->inputError->serverAddr       = '服务器地址不能为空';
$lang->conference->inputError->apiPort          = 'API 端口不能为空';
$lang->conference->inputError->mgmtPort         = 'OWT 管理端口不能为空';
$lang->conference->inputError->rtcPort          = '信令端口不能为空';
$lang->conference->inputError->resolutionWidth  = '请填写分辨率宽度';
$lang->conference->inputError->resolutionHeight = '请填写分辨率高度';

$lang->conference->server = '服务配置';
$lang->conference->video  = '视频配置';

$lang->conference->resolutionWidth     = '分辨率宽度';
$lang->conference->resolutionWidthTip  = '单位：像素，建议值：最低 320 最高 1280';
$lang->conference->resolutionHeight    = '分辨率高度';
$lang->conference->resolutionHeightTip = '单位：像素，建议值：最低 240 最高 720';

$lang->conference->placeholder                   = new stdClass();
$lang->conference->placeholder->resolutionWidth  = '640';
$lang->conference->placeholder->resolutionHeight = '480';
