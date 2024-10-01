<?php
/**
 * The browse of assetlib module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian <tianshujie@easycorp.ltd>
 * @package     assetlib
 * @version     $Id: browse.html.php 4903 2021-07-02 09:37:59Z $
 * @link        https://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . "common/view/header.html.php"?>
<?php if($canSort) include $app->getModuleRoot() . "common/view/sortable.html.php"?>
<?php js::set('objectType', $objectType);?>
<?php js::set('browseLink', $browseLink);?>
<?php $label = "{$objectType}NoFeature";?>
<?php $class = helper::hasFeature($objectType) ? '' : 'disabled';?>
<?php $extra = helper::hasFeature($objectType) ? '' : "data-toggle='tooltip' data-placement='bottom' title='{$lang->assetlib->$label}'";?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toobar pull-left">
    <?php echo html::a($this->createLink('assetlib', $browseLink), "<span class='text'>{$lang->assetlib->all}</span>", '', "class='btn btn-link btn-active-text'");?>
  </div>
  <div class="btn-toolbar pull-right">
    <?php common::printLink('assetlib', $createMethod, '', "<i class='icon icon-plus'></i>" . $lang->assetlib->{$createMethod}, '', "class='btn btn-primary $class' $extra");?>
  </div>
</div>
<div id="mainContent" class="main-table">
  <?php if(empty($libs)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->noData;?></span>
      <?php if(common::hasPriv('assetlib', $createMethod)):?>
      <?php echo html::a($this->createLink('assetlib', $createMethod), "<i class='icon icon-plus'></i> " . $lang->assetlib->{$createMethod}, '', "class='btn btn-info $class' $extra");?>
      <?php endif;?>
    </p>
  </div>
  <?php else:?>
  <table class="table has-sort-head" id='libList'>
    <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
    <thead>
      <tr>
        <th class='text-left c-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->assetlib->id);?></th>
        <th class='c-order' data-flex='false' title='<?php echo $this->lang->assetlib->sort?>'><?php echo $this->lang->assetlib->sort?></th>
        <th><?php common::printOrderLink('name', $orderBy, $vars, $lang->assetlib->name);?></th>
        <th class='c-desc'><?php echo $lang->assetlib->desc;?></th>
        <th class='c-createdBy'><?php common::printOrderLink('createdBy', $orderBy, $vars, $lang->assetlib->createdBy);?></th>
        <th class='c-actions-1'><?php echo $lang->actions?></th>
      </tr>
    </thead>
    <tbody class='sortable'>
      <?php $this->loadModel('file');?>
      <?php foreach($libs as $lib):?>
      <?php $lib = $this->file->replaceImgURL($lib, 'desc');?>
      <tr data-id='<?php echo $lib->id;?>'>
        <td><?php echo sprintf('%03d',$lib->id);?></td>
        <td class='sort-handler c-sort' title='' style=''><i class='icon-move'></td>
        <td class='c-name'><?php echo html::a($this->createLink('assetlib', $objectType, "libID=$lib->id"), $lib->name);?></td>
        <td  class='text-left content'>
          <?php $desc = trim(strip_tags(str_replace(array('</p>', '<br />', '<br>', '<br/>'), "\n", str_replace(array("\n    ", "\r"), '', $lib->desc)), '<img>'));?>
          <div title='<?php echo $desc;?>'><?php echo nl2br($desc);?></div>
        </td>
        <td><?php echo zget($users, $lib->createdBy);?></td>
        <td class='c-actions'>
          <?php common::printIcon('assetlib', $editMethod, "id=$lib->id", $lib, 'list', 'edit');?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'>
    <?php $pager->show('right', 'pagerjs');?>
  </div>
  <?php endif;?>
</div>
<?php include $app->getModuleRoot() . "common/view/footer.html.php"?>
