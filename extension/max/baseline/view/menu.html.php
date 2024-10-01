<?php 
js::set('methodName', $this->app->methodName);
?>
<?php if(common::hasPriv('baseline', 'template')) echo html::a($this->createLink('baseline', 'template'), '<span class="text">' . $lang->baseline->template . '</span>', '', "class='btn btn-link templateTab'");?>
<?php if(common::hasPriv('baseline', 'catalog')) echo html::a($this->createLink('baseline', 'catalog'), '<span class="text">' . $lang->baseline->catalog . '</span>', '', "class='btn btn-link catalogTab'");?>
<script>
$('#mainMenu .' + methodName + 'Tab').addClass('btn-active-text');
</script>
