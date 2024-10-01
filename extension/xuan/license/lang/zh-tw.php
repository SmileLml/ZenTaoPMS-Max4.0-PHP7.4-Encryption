<?php
$lang->license->common               = '授權';
$lang->license->licenseUnavailable   = '授權不可用';
$lang->license->licenseExpired       = '授權已過期';
$lang->license->status               = '狀態';
$lang->license->licensedTo           = '授權給';
$lang->license->unlimited            = '無限制';
$lang->license->userLimit            = '用戶數上限';
$lang->license->startDate            = '生效日期';
$lang->license->expireDate           = '失效日期';
$lang->license->upgrade              = '升級授權';
$lang->license->upgradeUrl           = 'https://xuanim.com/license-browse.html';
$lang->license->userLimitText        = '%s人';
$lang->license->permissions          = '功能權限';
$lang->license->conferencePermission = '會議權限';
$lang->license->conferenceLimited    = '每個會議3人';
$lang->license->uploadLicense        = '上傳授權';

$lang->license->error = new stdclass();
$lang->license->error->licenseDir  = '授權檔案目錄：<pre> %s</pre>不存在或者沒有寫權限，請創建此目錄並開啟目錄寫權限。';
$lang->license->error->licenseFile = '授權檔案沒有寫權限，請到伺服器手動執行：<br/> <pre>sudo chmod -R o=wrx %s</pre>後繼續操作。';
$lang->license->error->badPackage  = '安裝失敗，請上傳標準的授權包。';
$lang->license->error->copyFail    = '安裝失敗，請手動安裝。';

$lang->license->statusList = array();
$lang->license->statusList['unavailable'] = '不可用';
$lang->license->statusList['waiting']     = '待生效';
$lang->license->statusList['effective']   = '已生效';
$lang->license->statusList['expired']     = '已過期';
