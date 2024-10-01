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
  <div class="btn-toolbar pull-right">
    <?php common::printLink('approvalflow', 'createRole', '', "<i class='icon icon-plus'></i> " . $lang->approvalflow->role->create, '', "class='btn btn-primary iframe'", '', true);?>
  </div>
  <div class="btn-toolbar">
    <?php common::printBack(inlink('browse'));?>
  </div>
</div>
<div id="mainContent" class='main-table'>
  <?php if(empty($roleList)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->noData;?></span>
    </p>
  </div>
  <?php else:?>
  <table class="table" id='flowList'>
    <thead>
      <tr>
        <th class='c-id'><?php echo $lang->approvalflow->id;?></th>
        <th class="c-date"><?php echo $lang->approvalflow->role->name;?></th>
        <th class="c-date"><?php echo $lang->approvalflow->role->code;?></th>
        <th><?php echo $lang->approvalflow->role->member;?></th>
        <th><?php echo $lang->approvalflow->role->desc;?></th>
        <th class='c-actions-2 text-center'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($roleList as $role):?>
      <?php
        $member = '';
        foreach(explode(',', $role->users) as $account)
        {
            if(!$account) continue;
            $member .= zget($users, $account) . ',';
        }
        $member = trim($member, ',');
      ?>
      <tr>
        <td><?php echo $role->id;?></td>
        <td class='text-ellipsis'><?php echo $role->name;?></td>
        <td class='text-ellipsis'><?php echo $role->code;?></td>
        <td class='text-ellipsis' title=<?php echo $member;?>><?php echo $member;?></td>
        <td class='text-ellipsis'><?php echo $role->desc;?></td>
        <td class='c-actions'>
          <?php
          common::printIcon('approvalflow', 'editRole', "roleID=$role->id", $role, 'list', 'edit', '', 'iframe', 1, '', $lang->approvalflow->role->edit);
          common::printIcon('approvalflow', 'deleteRole', "roleID=$role->id", $role, 'list', 'remove', 'hiddenwin', '', '', '', $lang->approvalflow->role->delete);
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <?php endif;?>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
