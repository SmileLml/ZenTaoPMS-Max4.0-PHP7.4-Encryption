<?php
/**
 * The edit view of assetlib module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     assetlib
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div class="main-content" id="mainCentent">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->assetlib->editIssue;?></h2>
    </div>
    <form method="post" class="main-form form-ajax" enctype="multipart/form-data" id="issueForm">
      <table class="table table-form">
        <tbody>
          <tr>
            <th><?php echo $lang->issue->type;?></th>
            <td class="required"><?php echo html::select('type', $lang->issue->typeList, $issue->type, 'class="form-control chosen"');?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->title;?></th>
            <td class="required"><?php echo html::input('title', $issue->title, 'class="form-control"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->severity;?></th>
            <td class="required"><?php echo html::select('severity', $lang->issue->severityList, $issue->severity, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->pri;?></th>
            <td><?php echo html::select('pri', $lang->issue->priList, $issue->pri, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->desc;?></th>
            <td colspan="2"><?php echo html::textarea('desc', $issue->desc, 'row="6"');?></td>
          </tr>
          <tr>
            <td colspan='3' class='text-center form-actions'><?php echo html::submitButton() . html::backButton();?></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
