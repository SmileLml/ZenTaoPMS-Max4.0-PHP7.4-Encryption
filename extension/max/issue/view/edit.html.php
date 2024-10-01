<?php
/**
 * The edit view of issue module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @package     issue
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<div class="main-content" id="mainCentent">
  <div class="panel-heading">
    <strong><?php echo $lang->issue->edit;?></strong>
  </div>
  <div class="panel-body">
    <form method="post" class="main-form form-ajax" enctype="multipart/form-data" id="issueForm">
      <table class="table table-form">
        <tbody>
          <tr>
            <th><?php echo $lang->issue->type;?></th>
            <td class="required"><?php echo html::select('type', $lang->issue->typeList, $issue->type, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->title;?></th>
            <td class="required"><?php echo html::input('title', $issue->title, 'class="form-control"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->risk;?></th>
            <td class="riskBox"><?php echo html::select('risk', $risks, $issue->risk, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->severity;?></th>
            <td class="required"><?php echo html::select('severity', $lang->issue->severityList, $issue->severity, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->project;?></th>
            <td><?php echo html::select('project', $projectList, $issue->project, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->task->execution;?></th>
            <td class='executionBox'><?php echo html::select('execution', $executions, $issue->execution, "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->pri;?></th>
            <td><?php echo html::select('pri', $lang->issue->priList, $issue->pri, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->deadline;?></th>
            <td><?php echo html::input('deadline', $issue->deadline, 'class="form-control form-date"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $teamMembers, $issue->assignedTo, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->owner;?></th>
            <td><?php echo html::select('owner', $teamMembers, $issue->owner, 'class="form-control chosen"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->issue->desc;?></th>
            <td colspan='2'><?php echo html::textarea('desc', $issue->desc, 'row="6"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->files;?></th>
            <td><?php echo $this->fetch('file', 'buildform');?></td>
          </tr>
          <tr>
            <td colspan='3' class='text-center form-actions'><?php echo html::submitButton() . html::backButton($lang->goback, "data-app='{$app->tab}'");?></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<?php js::set('projectID',   $issue->project);?>
<?php js::set('executionID', $issue->execution);?>
<?php js::set('risk',        $issue->risk);?>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
