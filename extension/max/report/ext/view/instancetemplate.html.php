<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php
js::set('programID', $programID);
js::set('templateID', $template->id);
?>
<div id='mainContent' class='main-row'>
  <div class='side-col col-lg' id='sidebar'>
    <?php include './blockreportlist.html.php';?>
  </div>
  <div class='main-col'>
    <div class='cell'>
      <div class='input-group'>
        <span class='input-group-addon'><?php echo $lang->report->history;?></span>
        <?php echo html::select('report', $reports, $reportID, "class='form-control chosen'");?>
      </div>
    </div>
    <div class='cell'>
      <div class='panel'>
        <?php if($parseContent == 'yes' and !$reportID):?>
        <div class="panel-heading">
          <div class="panel-title"><?php echo $lang->measurement->tips->view;?></div>
          <nav class="panel-actions btn-toolbar">
            <?php echo html::commonButton($lang->save, "id='saveReportBtn'",  "btn btn-primary btn-sm");?>
          </nav>
        </div>
        <?php endif;?>

        <?php if($parseContent == 'no'):?>
        <div class='panel-heading'>
          <form class="load-indicator main-form" id="paramsForm" method='post'>
            <i class="icon icon-exclamation-sign icon-rotate-180"></i>
            <span class="text-muted"><?php echo $lang->measurement->tips->click2SetParams;?></span>
            <div id='paramValues'>
            </div>
            <nav class="panel-actions btn-toolbar">
              <?php echo html::hidden('parseContent', 'yes') . html::submitButton($lang->measurement->tips->view, "", "btn btn-secondary btn-sm");?>
            </nav>
          </form>
        </div>
        <?php else:?>
        <div class='panel-body'>
          <form class="load-indicator main-form form-ajax"  method='post'>
            <div class='hidden'>
              <?php
              if(!empty($params))
              {
                  foreach($params as $controlID => $param)
                  {
                      foreach($param as $varName => $varValue) echo html::hidden("params[$controlID][$varName]", $varValue);
                  }
              }
              echo html::hidden('parseContent', 'yes') . html::hidden('saveReport', 'yes') . html::submitButton($lang->save);
              ?>
            </div>
            <div class="modal fade" id="reportNameModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only"><?php $lang->close;?></span></button>
                    <h4 class="modal-title" id='holderModalTitle'><?php echo $lang->report->setName?></h4>
                  </div>
                  <div class="modal-body">
                    <table class='table table-form'>
                      <tbody>
                        <tr>
                          <th><?php echo $lang->report->name;?></th>
                          <td><?php echo html::input('name', '', "class='form-control'");?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang->close;?></button>
                    <button type="button" class="btn btn-primary" id='modalSaveBtn'><?php echo $lang->save;?></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <?php endif;?>
        <div class='panel-body'> <?php echo $content;?> </div>
      </div>
    </div>
  </div>
</div>
<?php if($parseContent == 'yes'):?>
<script>
$(document).on('click', '#saveReportBtn', function()
{
    $('#reportNameModal').modal('show');
});
$(document).on('click', '#modalSaveBtn', function()
{
    $('#reportNameModal').modal('hide');
    $('#submit').click();
});
$(document).on('change', '#report', function()
{
    var reportID = $('#report').val();
    var link = createLink('report', 'instanceTemplate', "program=" + programID + "&templateID=" + templateID + "&reportID=" + reportID);
    location.href = link;
})
</script>
<?php endif;?>

<?php if($parseContent == 'no') include '../../../measurement/view/paramformmodal.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
