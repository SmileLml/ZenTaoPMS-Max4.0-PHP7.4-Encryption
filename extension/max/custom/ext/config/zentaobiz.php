<?php
$config->custom->canAdd['feedback'] = 'closedReasonList,typeList,priList';
$config->custom->canAdd['ticket']   = 'priList,typeList';

if(!empty($_SESSION['user']->feedback) or !empty($_COOKIE['feedbackView']))
{
    $config->custom->moblieHidden['main'][] = 'ops';

    $config->custom->noModuleMenu['todo']     = 'todo';
    $config->custom->noModuleMenu['my']       = 'my';
    $config->custom->noModuleMenu['feedback'] = 'feedback';
    $config->custom->noModuleMenu['faq']      = 'faq';
}
$config->custom->moblieHidden['my']         = array('changePassword', 'manageContacts', 'profile', 'review');
$config->custom->moblieHidden['oa']         = array('holiday', 'review');
$config->custom->moblieHidden['feedback'][] = 'products';
$config->custom->moblieHidden['ops'][]      = 'setting';

$config->custom->requiredModules[82] = 'feedback';
$config->custom->fieldList['feedback']['create'] = 'module,type,feedbackBy,notifyEmail';
$config->custom->fieldList['feedback']['edit']   = 'module,type,feedbackBy,notifyEmail';

array_splice($config->custom->allFeatures, -2, 0, array('oa', 'ops', 'feedback', 'traincourse', 'workflow'));
