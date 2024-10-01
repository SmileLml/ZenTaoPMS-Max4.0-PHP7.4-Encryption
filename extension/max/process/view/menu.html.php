<?php
$this->app->loadLang('process');
$this->app->loadLang('activity');
$this->app->loadLang('zoutput');
$this->app->loadLang('classify');
js::set('moduleName', $this->app->moduleName);
?>
<?php if(common::hasPriv('process', 'browse')) echo html::a($this->createLink('process', 'browse', "browseType=$model"), '<span class="text">' . $lang->process->list. '</span>', '', "class='btn btn-link processTab'");?>
<?php if(common::hasPriv('activity', 'browse')) echo html::a($this->createLink('activity', 'browse'), '<span class="text">' . $lang->activity->browse . '</span>', '', "class='btn btn-link activityTab'");?>
<?php if(common::hasPriv('zoutput', 'browse')) echo html::a($this->createLink('zoutput', 'browse'), '<span class="text">' . $lang->zoutput->browse . '</span>', '', "class='btn btn-link zoutputTab'");?>
<?php if(common::hasPriv('classify', 'browse')) echo html::a($this->createLink('classify', 'browse'), '<span class="text">' . $lang->classify->browse . '</span>', '', "class='btn btn-link classifyTab'");?>
<script>
$('#mainMenu .' + moduleName + 'Tab').addClass('btn-active-text');
</script>
