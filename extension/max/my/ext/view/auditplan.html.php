<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('browseType', $browseType);?>
<?php js::set('mode', $mode);?>
<?php js::set('total', $pager->recTotal);?>
<?php js::set('rawMethod', $app->rawMethod);?>
<style>
.c-actions{width: 180px}
</style>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php $recTotalLabel = " <span class='label label-light label-badge'>{$pager->recTotal}</span>";?>
    <?php echo html::a(inlink($app->rawMethod, "mode=auditplan&browseType=mychecking"), "<span class='text'>{$lang->my->auditplan}</span>" . ($browseType == 'mychecking'   ? $recTotalLabel : '') , '', "class='btn btn-link mychecking btn-active-text'");?>
    <?php echo html::a(inlink($app->rawMethod, "mode=nc&browseType=assignedToMe"), "<span class='text'>{$lang->my->nc}</span>" . ($browseType == 'assignedToMe'  ? $recTotalLabel : '') , '', "class='btn btn-link assignedToMe'");?>
  </div>
</div>
<div id="mainContent" class='main-table'>
  <?php if(empty($auditplans)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->noData;?></span>
    </p>
  </div>
  <?php else:?>
  <form id='myTaskForm' class="main-table table-risk" data-ride="table" method="post">
  <?php $vars = "mode=$mode&browseType=$browseType&param=$param&orderBy=%s&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=$pager->pageID"; ?>
    <table class="table has-sort-head table-fixed" id='projectList'>
      <thead>
        <tr class='text-center'>
          <th class='c-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
          <th class='c-objectID'><?php common::printOrderLink('objectID', $orderBy, $vars, $lang->auditplan->objectID);?></th>
          <th class='c-execution'><?php common::printOrderLink('execution', $orderBy, $vars, $lang->auditplan->execution);?></th>
          <th class='c-objectType'><?php common::printOrderLink('objectType', $orderBy, $vars, $lang->auditplan->objectType);?></th>
          <th class='c-status'><?php common::printOrderLink('status', $orderBy, $vars, $lang->auditplan->status);?></th>
          <th class='c-assignedTo'><?php common::printOrderLink('assignedTo', $orderBy, $vars, $lang->auditplan->assignedTo);?></th>
          <th class='c-checkDate'><?php common::printOrderLink('checkDate', $orderBy, $vars, $lang->auditplan->checkDate);?></th>
          <th class='c-actions'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($auditplans as $id => $auditplan):?>
        <?php
        $class = '';
        $process     = zget($processes, $auditplan->process);
        $processType = zget($this->lang->auditplan, $auditplan->objectType, '');
        $objectType  = $auditplan->objectType == 'activity' ? zget($activities, $auditplan->objectID) : zget($outputs, $auditplan->objectID);
        $execution   = $auditplan->execution ? zget($executions, $auditplan->execution) : '';
        $execution   = $execution ? html::a(helper::createLink('execution', 'task', "executionID=$auditplan->execution"), $execution, '', "title={$execution}") : '';
        $auditplan->ncs = $this->loadModel('auditplan')->getNcCount($auditplan->id);
        if((helper::diffDate(helper::today(), $auditplan->checkDate) > -1) and !helper::isZeroDate($auditplan->checkDate)) $class = 'delayed';
        ?>
        <tr class='text-center'>
          <td><?php echo $auditplan->id;?></td>
          <td title="<?php echo $objectType;?>"><?php echo $objectType;?></td>
          <td title="<?php echo $execution;?>"><?php echo $execution;?></td>
          <td><?php echo $processType;?></td>
          <td class='status-<?php echo $auditplan->status;?>'><?php echo zget($lang->auditplan->statusList, $auditplan->status);?></td>
          <?php
          $assignedClass = '';
          if($auditplan->assignedTo == $app->user->account) $assignedClass = 'assigned-current';
          if(!empty($auditplan->assignedTo) and $auditplan->assignedTo != $app->user->account) $assignedClass = 'assigned-other';
          ?>
          <td class="<?php echo $assignedClass;?>"><?php echo zget($users, $auditplan->assignedTo);?></td>
          <td class='<?php echo $class;?>'><?php echo '<span>' . $auditplan->checkDate . '</span>';?></td>
          <td class='c-actions'><?php
              if($auditplan->status == 'wait' || $auditplan->status == 'checking')
              {
                  common::printIcon('auditplan', 'check', "auditplanID=$auditplan->id&projectID=$auditplan->project", $auditplan, 'list', 'confirm', '', 'iframe', true, '', $this->lang->auditplan->check);
              }
              else
              {
                  common::printIcon('auditplan', 'check', "auditplanID=$auditplan->id&projectID=$projectID", $auditplan, 'list', 'confirm', '', 'disabled');
              }
              common::printIcon('auditplan', 'result', "auditplanID=$auditplan->id", $auditplan, 'list', 'list-alt', '', 'iframe', true);
              if($auditplan->ncs)
              {
                  common::printIcon('auditplan', 'nc', "auditplanID=$auditplan->id", $auditplan, 'list', 'bug', '', 'iframe', true);
              }
              else
              {
                  common::printIcon('auditplan', 'nc', "auditplanID=$auditplan->id", $auditplan, 'list', 'bug', '', 'disabled', true);
              }
              common::printIcon('auditplan', 'edit', "auditplanID=$auditplan->id" . "&from=my", $auditplan, 'list', '', '', 'iframe', true);
              common::printIcon('auditplan', 'delete', "auditplanID=$auditplan->id", $auditplan, 'list', 'trash', 'hiddenwin');
              ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div class='table-footer'>
      <?php $pager->show('right', 'pagerjs');?>
    </div>
  </form>
  <?php endif;?>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
