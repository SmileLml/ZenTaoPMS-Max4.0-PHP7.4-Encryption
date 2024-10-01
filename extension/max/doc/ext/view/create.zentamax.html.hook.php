<?php if(isset($from) and $from == 'template'):?>
<?php
$html  = '<tr>';
$html .= '<th>';
$html .= $lang->doc->template;
$html .= '</th>';
$html .= '<td>';
$html .= html::select('template', '', '', "class='form-control chosen' onchange=loadContent(this.value)");
$html .= '</td>';
$html .= '</tr>';
?>

<script>
$('#module').closest('tr').after(<?php echo json_encode($html)?>);
$('#templateType').chosen();
$('#template').chosen();
loadTemplates();

/**
 * Load templates.
 *
 * @access public
 * @return void
 */
function loadTemplates()
{
    var link = createLink('baseline', 'ajaxGetTemplates', 'type=all&from=doc&contentType=html,markdown');
    $.post(link, function(data)
    {
        $('#template').replaceWith(data);
        $('#template_chosen').remove();
        $('#template').chosen();
    })

    $('#contentType').val('text');
    editor['content'].html('');
    $('#contentBox').removeClass('hidden');
    $('.contenthtml').removeClass('hidden');
    $('.contentmarkdown').addClass('hidden');
    $('#urlBox').addClass('hidden');
}

/**
 * Load content.
 *
 * @param  int    $templateID
 * @access public
 * @return void
 */
function loadContent(templateID)
{
    var link = createLink('baseline', 'ajaxGetContent', 'templateID=' + templateID);
    $.post(link, function(data)
    {
        data = JSON.parse(data);
        var type = data.type;
        if(type == 'html') type = 'text';
        $('input[id*=' + type + ']').attr('checked', 'checked');
        toggleEditor(data.type);

        if(data.type == 'html')
        {
            var cmd = editor['content'].edit.cmd;
            editor['content'].html('');
            cmd.inserthtml(data.content);
        }
        else if(data.type == 'markdown')
        {
            markdownEditor['contentMarkdown'].value(data.content);
        }
        else if(data.type == 'url')
        {
            $('#url').val(data.content);
        }
    })
}

/**
 * Toggle editor.
 *
 * @param  string $type
 * @access public
 * @return boolean
 */
function toggleEditor(type)
{
    $('#contentType').val(type);
    if(type == 'html')
    {
        $('#contentBox').removeClass('hidden');
        $('.contenthtml').removeClass('hidden');
        $('.contentmarkdown').addClass('hidden');
        $('#urlBox').addClass('hidden');
    }
    else if(type == 'markdown')
    {
        $('.contentmarkdown').removeClass('hidden');
        $('.contenthtml').addClass('hidden');
        $('#urlBox').addClass('hidden');
    }
    else if(type == 'url')
    {
        $('#urlBox').removeClass('hidden');
        $('#contentBox').addClass('hidden');
    }
    return false;
}
</script>
<?php endif;?>
