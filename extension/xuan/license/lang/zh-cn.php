<?php
$lang->license->common               = '授权';
$lang->license->licenseUnavailable   = '授权不可用';
$lang->license->licenseExpired       = '授权已过期';
$lang->license->status               = '状态';
$lang->license->licensedTo           = '授权给';
$lang->license->unlimited            = '无限制';
$lang->license->userLimit            = '用户数上限';
$lang->license->startDate            = '生效日期';
$lang->license->expireDate           = '失效日期';
$lang->license->upgrade              = '升级授权';
$lang->license->upgradeUrl           = 'https://xuanim.com/license-browse.html';
$lang->license->userLimitText        = '%s人';
$lang->license->permissions          = '功能权限';
$lang->license->conferencePermission = '会议权限';
$lang->license->conferenceLimited    = '每个会议3人';
$lang->license->uploadLicense        = '上传授权';

$lang->license->error = new stdclass();
$lang->license->error->licenseDir  = '授权文件目录：<pre> %s</pre>不存在或者没有写权限，请创建此目录并开启目录写权限。';
$lang->license->error->licenseFile = '授权文件没有写权限，请到服务器手动执行：<br/> <pre>sudo chmod -R o=wrx %s</pre>后继续操作。';
$lang->license->error->badPackage  = '安装失败，请上传标准的授权包。';
$lang->license->error->copyFail    = '安装失败，请手动安装。';

$lang->license->statusList = array();
$lang->license->statusList['unavailable'] = '不可用';
$lang->license->statusList['waiting']     = '待生效';
$lang->license->statusList['effective']   = '已生效';
$lang->license->statusList['expired']     = '已过期';
