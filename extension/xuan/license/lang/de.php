<?php
$lang->license->common               = 'License';
$lang->license->licenseUnavailable   = 'License unavailable';
$lang->license->licenseExpired       = 'License expired';
$lang->license->status               = 'Status';
$lang->license->licensedTo           = 'Licensed to';
$lang->license->unlimited            = 'Unlimited';
$lang->license->userLimit            = 'User limit';
$lang->license->startDate            = 'Effective date';
$lang->license->expireDate           = 'Expire date';
$lang->license->upgrade              = 'Upgrade';
$lang->license->upgradeUrl           = 'https://xuanim.com/license-browse.html';
$lang->license->userLimitText        = '%s members';
$lang->license->permissions          = 'Permissions';
$lang->license->conferencePermission = 'Conference';
$lang->license->conferenceLimited    = '3 participants per conference';
$lang->license->uploadLicense        = 'Upload license';

$lang->license->error = new stdclass();
$lang->license->error->licenseDir  = 'License directory <pre> %s</pre> not writable.';
$lang->license->error->licenseFile = 'License file not writable, please execute <pre>sudo chmod -R o=wrx %s</pre> on your server and retry.';
$lang->license->error->badPackage  = 'Bad license package.';
$lang->license->error->copyFail    = 'Installation failed, please proceed manually.';

$lang->license->statusList = array();
$lang->license->statusList['unavailable'] = 'Unavailable';
$lang->license->statusList['waiting']     = 'Waiting';
$lang->license->statusList['effective']   = 'Effective';
$lang->license->statusList['expired']     = 'Expired';
