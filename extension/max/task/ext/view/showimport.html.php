<?php include $app->getModuleRoot() . 'transfer/view/showimport.html.php';?>
<script>
$(document).ready(function()
{
    setTimeout(function()
    {
        $("th[id='deadline']").after('<th class="w-70px"><?php echo $lang->actions;?></th>');

        $("input[id^='deadline'").each(function(index, value)
        {
            $(this).closest('td').after('<td><a id="'+$(this).attr('id')+'" onclick="delItem(this)"><i class="icon-close"></i></a></td>');
        })
    },
    50);
})

function delItem(val)
{
    $(val).parents('tr').remove();
}
</script>
