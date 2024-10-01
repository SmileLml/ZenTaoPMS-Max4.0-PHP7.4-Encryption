<?php include '../../../common/view/header.modal.html.php';?>
<?php $this->app->loadLang('file');?>
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
  <form id="mainContent" target='hiddenwin' method='post' action='<?php echo $this->createLink('doc', $kind.'2export', "libID=$data->id&docID=$docID");?>'>
    <table class='table table-form'>
      <tr>
        <th class='w-150px'><?php echo $lang->doc->export->fileName?></th>
        <td><?php echo html::input('fileName', $data->name, "class='form-control'")?></td>
      </tr>
      <tr>
        <th class='w-150px'><?php echo $lang->doc->export->fileType?></th>
        <td><?php echo html::select('fileType', ['word'], 0, "class='form-control' disabled")?></td>
      </tr>
      <tr>
        <th class='w-150px'><?php echo $lang->doc->export->encode?></th>
        <td><?php echo html::select('encode', ['UTF-8'], 0, "class='form-control' disabled")?></td>
      </tr>
      <tr>
        <th class='w-150px'><?php echo $kind == 'wiki' ? $lang->doc->export->chapter : $lang->doc->export->doc; ?></th>
        <td><?php echo html::select('chapter', $chapters, 0, "class='form-control chosen'")?></td>
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
