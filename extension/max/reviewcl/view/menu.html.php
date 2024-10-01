<?php 
$this->app->loadLang('reviewcl');
$this->app->loadLang('reviewsetting');
js::set('methodName', $this->app->methodName);
?>
<?php if(common::hasPriv('reviewcl', 'browse')) echo html::a($this->createLink('reviewcl', 'browse', "object=$object"), '<span class="text">' . $lang->reviewcl->browse . '</span>', '', "class='btn btn-link browseTab'");?>
<?php if(common::hasPriv('reviewsetting', 'version')) echo html::a($this->createLink('reviewsetting', 'version', "object=$object"), '<span class="text">' . $lang->reviewsetting->version. '</span>', '', "class='btn btn-link versionTab'");?>
<script>
$('#mainMenu .' + methodName + 'Tab').addClass('btn-active-text');
</script>
