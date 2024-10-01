<?php include '../../../common/view/header.modal.html.php';?>
<script>
function setDownloading()
{
    if(navigator.userAgent.toLowerCase().indexOf("opera") > -1) return true;   // Opera don't support, omit it.
    var $fileName = $('#fileName');
    if($fileName.val() === '') $fileName.val('<?php echo $lang->file->untitled;?>');
    $.cookie('downloading', 0);
    time = setInterval("closeWindow()", 300);
    $('#mainContent').addClass('loading');
    return true;
}

function closeWindow()
{
    if($.cookie('downloading') == 1)
    {
        $('#mainContent').removeClass('loading');
        $.closeModal();
        $.cookie('downloading', null);
        clearInterval(time);
    }
}
</script>
<div class='panel'>
  <form target='hiddenwin' method='post' action='<?php echo $this->createLink('api', 'export', "apiID=$apiID");?>'>
    <table class='table table-form'>
      <tr>
        <th class='w-150px'><?php echo $lang->setFileName;?></th>
        <td><?php echo html::input('fileName', $fileName, "class='form-control'")?></td>
      </tr>
      <tr>
        <th class='w-150px'><?php echo $lang->doc->export->fileType?></th>
        <td><?php echo html::select('fileType', ['word'], 0, "class='form-control' disabled")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->doc->export->encode?></th>
        <td><?php echo html::select('encode', ['UTF-8'], 0, "class='form-control' disabled")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->file->exportRange?></th>
        <td><?php echo html::select('scope', $lang->api->exportScope, 'single', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th></th>
        <td><?php echo html::submitButton($lang->export, "onclick='setDownloading();'", 'btn btn-primary');?></td>
      </tr>
    </table>
  </form>
</div>
<iframe name='hiddenwin' class='hidden'></iframe>
<?php include '../../../common/view/footer.modal.html.php';?>
