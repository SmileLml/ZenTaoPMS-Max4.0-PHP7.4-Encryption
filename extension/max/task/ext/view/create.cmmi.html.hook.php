<?php if($execution->type == 'stage'):?>
<?php
$html  = '<tr>';
$html .= '<th>';
$html .= $lang->task->design;
$html .= '</th>';
$html .= '<td colspan=3>';
$html .= html::select('design', '', '', "class='form-control chosen'");
$html .= '</td>';
$html .= '<tr>';
?>
<script>
$(function()
{
    $('#story').closest('tr').after(<?php echo json_encode($html);?>);
    $('#design').chosen();
})
</script>
<?php endif;?>

<?php js::set('attribute', $execution->attribute);?>
<script>
$(function()
{
    execAttribute = attribute;
    if(attribute == 'request' || attribute == 'review')
    {
        $('#story').closest('tr').hide();
        $("input[name='after'][value='toStoryList']").parent().hide();
        $("input[name='after'][value='continueAdding']").parent().hide();
        $("input[name='after'][value='toTaskList']").prop('checked', true);
        $("input[name='after'][value='toTaskList']").parent().css('margin-left', '0px');
    }
    $('#execution').change(function()
    {
        link = createLink('execution', 'ajaxGetAttribute', "executionID=" + $('#execution').val());
        $.get(link, function(attribute)
        {
            execAttribute = attribute;
            if(attribute == 'request' || attribute == 'review')
            {
                $('#story').closest('tr').hide();
                $("input[name='after'][value='toStoryList']").parent().hide();
                $("input[name='after'][value='continueAdding']").parent().hide();
                $("input[name='after'][value='toTaskList']").prop('checked', true);
                $("input[name='after'][value='toTaskList']").parent().css('margin-left', '0px');
            }
            else
            {
                $('#story').closest('tr').show();
                $("input[name='after'][value='toStoryList']").parent().show();
                $("input[name='after'][value='continueAdding']").parent().show();
                $("input[name='after'][value='continueAdding']").prop('checked', true);
                $("input[name='after'][value='toTaskList']").parent().css('margin-left', '10px');
            }
        });
    })
})
</script>
