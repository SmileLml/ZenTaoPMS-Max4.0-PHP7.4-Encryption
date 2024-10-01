<?php if(isset($action) && $action->buildin && $action->method == 'view'):?>
<script>
$(function()
{
    $('.form-actions a[href*=block]').remove();
})
</script>
<?php endif;?>
