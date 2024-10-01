<?php
if(isset($flowAction)) $action = $flowAction;   // The view method has the $flowAction property instead of the $action property.
if($action->open == 'modal')
{
    include '../../common/view/header.modal.html.php';
}
else
{
    if(isset($lang->apps->{$flow->app}))
    {
        include $this->app->getModuleRoot($flow->app) . 'common/view/header.html.php';
    }
    else
    {
        include $app->getModuleRoot() . 'common/view/header.html.php';
    }
}

if(!empty($flow->css))   css::internal($flow->css);
if(!empty($action->css)) css::internal($action->css);
js::set('buildin', $flow->buildin);
