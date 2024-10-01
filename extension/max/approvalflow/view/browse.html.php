<?php
/**
 * The browse view file of release module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     release
 * @version     $Id: browse.html.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php
    foreach($lang->approvalflow->typeList as $typeKey => $typeName)
    {
        echo html::a(inlink('browse', "type=$typeKey"), "<span class='text'>$typeName</span>", '', "class='btn btn-link" . ($typeKey == $type ? ' btn-active-text' : '') . "'");
    }
    ?>
  </div>
  <div class="btn-toolbar pull-right">
    <?php common::printLink('approvalflow', 'role', '', "<i class='icon icon-team'> </i><span class='text'>" . $lang->approvalflow->roleList . '</span>', '', "class='btn btn-link'");?>
    <?php common::printLink('approvalflow', 'create', "type=$type", "<i class='icon icon-plus'></i> " . $lang->approvalflow->create, '', "class='btn btn-primary'");?>
  </div>
</div>
<div id="mainContent" class='main-table'>
  <?php if(empty($flows)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->approvalflow->noFlow;?></span>
      <?php echo html::a($this->createLink('approvalflow', 'create', "type=$type"), "<i class='icon icon-plus'></i> " . $lang->approvalflow->create, '', "class='btn btn-info'");?>
    </p>
  </div>
  <?php else:?>
  <table class="table" id='flowList'>
    <thead>
      <tr>
        <th class='c-id'><?php echo $lang->approvalflow->id;?></th>
        <th class="c-name"><?php echo $lang->approvalflow->name;?></th>
        <th><?php echo $lang->approvalflow->desc;?></th>
        <th class="w-160px"><?php echo $lang->approvalflow->createdDate;?></th>
        <th class="c-user"><?php echo $lang->approvalflow->createdBy;?></th>
        <th class='c-actions-3 text-center'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($flows as $flow):?>
      <tr>
        <td><?php echo html::a(inlink('view', "flowID=$flow->id"), sprintf('%03d', $flow->id));?></td>
        <td class='text-ellipsis'><?php echo html::a(inlink('view', "flowID=$flow->id"), $flow->name, '', "title='$flow->name'");?></td>
        <td class='text-ellipsis' title='<?php echo $flow->desc?>'><?php echo $flow->desc;?></td>
        <td title='<?php echo $flow->createdDate?>'><?php echo $flow->createdDate;?></td>
        <td class='text-ellipsis' title='<?php echo zget($users, $flow->createdBy, '');?>'><?php echo zget($users, $flow->createdBy, '');?></td>
        <td class='c-actions'>
          <?php
          common::printIcon('approvalflow', 'edit', "flowID=$flow->id", $flow, 'list');
          common::printIcon('approvalflow', 'design', "flowID=$flow->id", $flow, 'list', 'treemap');
          common::printIcon('approvalflow', 'delete', "flowID=$flow->id", $flow, 'list', 'remove', 'hiddenwin');
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <?php endif;?>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
