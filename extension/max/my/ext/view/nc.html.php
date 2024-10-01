<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('browseType', $browseType);?>
<?php js::set('mode', $mode);?>
<?php js::set('total', $pager->recTotal);?>
<?php js::set('rawMethod', $app->rawMethod);?>
<style>
.c-severity {width: 100px}
.c-date {width: 110px;}
[lang^=zh] .c-date {width: 100px;}
</style>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php $recTotalLabel = " <span class='label label-light label-badge'>{$pager->recTotal}</span>";?>
    <?php if($app->rawMethod == 'contribute'):?>
    <?php echo html::a(inlink($app->rawMethod, "mode=$mode&browseType=createdByMe"),  "<span class='text'>{$lang->my->createdByMe}</span>"  . ($browseType == 'createdByMe'  ? $recTotalLabel : '') , '', "class='btn btn-link createdByMe'");?>
    <?php echo html::a(inlink($app->rawMethod, "mode=$mode&browseType=resolvedByMe"), "<span class='text'>{$lang->my->resolvedByMe}</span>" . ($browseType == 'resolvedByMe' ? $recTotalLabel : '') , '', "class='btn btn-link resolvedByMe'");?>
    <?php echo html::a(inlink($app->rawMethod, "mode=$mode&browseType=closedByMe"),   "<span class='text'>{$lang->my->closedByMe}</span>"   . ($browseType == 'closedByMe'   ? $recTotalLabel : '') , '', "class='btn btn-link closedByMe'");?>
    <?php echo html::a(inlink($app->rawMethod, "mode=$mode&browseType=assignedBy"),   "<span class='text'>{$lang->my->assignedByMe}</span>" . ($browseType == 'assignedBy'   ? $recTotalLabel : '') , '', "class='btn btn-link assignedBy'");?>
    <?php endif;?>
    <?php if($app->rawMethod == 'work'):?>
    <?php echo html::a(inlink($app->rawMethod, "mode=auditplan&browseType=mychecking"), "<span class='text'>{$lang->my->auditplan}</span>" . ($browseType == 'assignedBy'   ? $recTotalLabel : '') , '', "class='btn btn-link assignedBy'");?>
    <?php echo html::a(inlink($app->rawMethod, "mode=$mode&browseType=assignedToMe"), "<span class='text'>{$lang->my->nc}</span>" . ($browseType == 'assignedToMe'  ? $recTotalLabel : '') , '', "class='btn btn-link assignedToMe btn-active-text'");?>
    <?php endif;?>
  </div>
</div>
<div id="mainContent" class='main-table'>
  <?php if(empty($ncs)):?>
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
        <tr>
          <th class='c-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
          <th class='c-name text-left'><?php common::printOrderLink('title', $orderBy, $vars, $lang->my->ncName);?></th>
          <th class='text-left c-project'><?php common::printOrderLink('project', $orderBy, $vars, $lang->my->projects);?></th>
          <th class='c-severity'><?php common::printOrderLink('severity', $orderBy, $vars, $lang->my->ncSeverity);?></th>
          <th class='c-status'><?php common::printOrderLink('status', $orderBy, $vars, $lang->my->ncStatus);?></th>
          <th class='c-user'><?php common::printOrderLink('createdBy', $orderBy, $vars, $lang->my->ncCreatedBy);?></th>
          <th class='c-date'><?php common::printOrderLink('createdDate', $orderBy, $vars, $lang->my->ncCreatedDate);?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($ncs as $nc):?>
        <?php $from = (isset($nc->model) and $nc->model == 'scrum') ? 'execution' : 'project';?>
        <?php $ncLink = $this->createLink('nc', 'view', "ncID=$nc->id&from=$from", '', '', $nc->project);?>
        <tr>
          <td><?php echo $nc->id;?></td>
          <td class='text-left' title="<?php echo $nc->title;?>"><?php echo html::a($ncLink, $nc->title);?></td>
          <td class='text-left' title="<?php echo zget($projects, $nc->project);?>"><?php echo zget($projects, $nc->project);?></td>
          <td class='c-severity'><span class='severity-<?php echo $nc->severity;?>'><?php echo zget($lang->nc->severityList, $nc->severity);?></span></td>
          <td><?php echo zget($lang->nc->statusList, $nc->status);?></td>
          <td><?php echo zget($users, $nc->createdBy);?></td>
          <td><?php echo substr($nc->createdDate, 0, 10);?></td>
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
<script>
$('.' + browseType).addClass('btn-active-text');
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
