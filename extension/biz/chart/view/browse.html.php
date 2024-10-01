<?php
/**
 * The browse view file of chart module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dataset
 * @version     $Id: browse.html.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/tablesorter.html.php';?>
<div id='mainMenu' class='clearfix'>
  <div class="btn-toolbar pull-right">
    <?php common::printLink('chart', 'create', '', '<i class="icon icon-plus"></i> ' . $lang->chart->create, '', 'class="btn btn-primary"');?>
  </div>
</div>
<div id="mainContent" class='main-table'>
  <table class="table" id='chartList'>
    <thead>
      <tr>
        <th class="w-id"><?php echo $lang->chart->id;?></th>
        <th class="w-250px"><?php echo $lang->chart->name;?></th>
        <th class="w-250px"><?php echo $lang->chart->type;?></th>
        <th class="c-desc"><?php echo $lang->chart->desc;?></th>
        <th class="c-actions"><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($charts as $chart):?>
      <tr>
        <td><?php echo html::a(inlink('design', "id=$chart->id"), $chart->id);?></td>
        <td><?php echo html::a(inlink('design', "id=$chart->id"), $chart->name);?></td>
        <td><?php echo zget($lang->chart->typeList, $chart->type, $chart->type);?></td>
        <td title='<?php echo $chart->desc;?>'><?php echo $chart->desc;?></td>
        <td class='c-actions'>
          <?php common::printIcon('chart', 'design', "id=$chart->id", $chart, 'list', 'backend');?>
          <?php common::printIcon('chart', 'edit', "id=$chart->id", $chart, 'list');?>
          <?php common::printIcon('chart', 'delete', "id=$chart->id", $chart, 'list', 'trash', 'hiddenwin');?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'>
    <?php $pager->show('right', 'pagerjs');?>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
