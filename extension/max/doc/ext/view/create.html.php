<?php $this->app->loadConfig('file');?>
<?php if($docType and strpos($config->doc->officeTypes, $docType) !== false and !empty($config->file->libreOfficeTurnon) and $config->file->convertType == 'collabora'):?>
<?php include $app->getModuleRoot() . 'common/view/header.lite.html.php';?>
<?php js::set('textType', $config->doc->textTypes);?>
<?php js::set('docType', $docType);?>
<?php js::set('fromGlobal', $fromGlobal);?>
<?php js::set('noticeAcl', $lang->doc->noticeAcl['doc']);?>
<div id="mainContent" class="main-content">
  <div class='center-block'>
    <div class='main-header'>
      <h2><?php echo $lang->doc->create;?></h2>
    </div>
    <form class="load-indicator main-form" id="dataform" method='post' target='hiddenwin'>
      <table class='table table-form'>
        <tbody>
          <tr>
            <th class='w-110px'><?php echo $lang->doc->lib;?></th>
            <td> <?php echo html::select('lib', $libs, $libID, "class='form-control chosen' onchange=loadDocModule(this.value)");?> </td><td></td>
          </tr>
          <tr>
            <th><?php echo $lang->doc->module;?></th>
            <td>
              <span id='moduleBox'><?php echo html::select('module', $moduleOptionMenu, $moduleID, "class='form-control chosen'");?></span>
            </td><td></td>
          </tr>
          <tr>
            <th><?php echo $lang->doc->title;?></th>
            <td colspan='2'><?php echo html::input('title', '', "class='form-control' required");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->doc->keywords;?></th>
            <td colspan='2'><?php echo html::input('keywords', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->doclib->control;?></th>
            <td colspan='2'>
              <?php $acl = $lib->acl == 'default' ? 'open' : $lib->acl;?>
              <?php $acl = ($lib->type == 'project' and $acl == 'private') ? 'open' : $acl;?>
              <?php echo html::radio('acl', $lang->doc->aclList, $acl, "onchange='toggleAcl(this.value, \"doc\")'");?>
              <span class='text-info' id='noticeAcl'><?php echo $lang->doc->noticeAcl['doc'][$acl];?></span>
            </td>
          </tr>
          <tr id='whiteListBox' class='hidden'>
            <th><?php echo $lang->doc->whiteList;?></th>
            <td colspan='2'>
              <div class='input-group'>
                <span class='input-group-addon groups-addon'><?php echo $lang->doclib->group?></span>
                <?php echo html::select('groups[]', $groups, '', "class='form-control picker-select' multiple data-drop-direction='top'")?>
              </div>
              <div class='input-group'>
                <span class='input-group-addon'><?php echo $lang->doclib->user?></span>
                <?php echo html::select('users[]', $users, '', "class='form-control picker-select' multiple data-drop-direction='top'")?>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan='3' class='text-center form-actions'>
              <?php echo html::submitButton() . html::hidden('type', $docType) . html::hidden('contentType', 'html');?>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php js::set('docType', $docType);?>
<?php include $app->getModuleRoot() . 'common/view/footer.lite.html.php';?>
<?php else:?>
<?php
$oldDir = getcwd();
chdir($app->getModuleRoot() . 'doc/view');
include './create.html.php';
chdir($oldDir);
?>
<?php endif;?>
