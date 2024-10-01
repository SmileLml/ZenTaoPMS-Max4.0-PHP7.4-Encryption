<?php
/**
 * The outputList of activity module of ZenTaoQC.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Qiyu Xie <xieqiyu@cnezsoft.com>
 * @package     activity
 * @version     $Id: outputlist.html.php 935 2020-09-09 07:49:24Z $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div class="main-content" id="mainCentent">
  <div class="modal-header">
    <strong><?php echo $lang->activity->outputList;?></strong>
  </div>
  <div class="modal-body" style="max-height: 528px; overflow: visible;">
    <div class="detail">
      <?php if($outputList):?>
        <?php foreach($outputList as $key => $value):?>
          <p>
            <?php echo html::a($this->createLink('zoutput', 'view',   "id=$key"), $key.'. '.$value);?>
            <?php echo html::a($this->createLink('zoutput', 'edit',   "id=$key"), '<i class="icon-edit"></i>',  '', "title={$lang->activity->edit}");?>
            <?php echo html::a($this->createLink('zoutput', 'delete', "id=$key"), '<i class="icon-close"></i>', '', "title={$lang->activity->delete} class='deleter'");?>
          </p>
          <?php endforeach;?>
        <?php else:?>
          <div class="text-center"><?php echo $lang->noData;?></div>
        <?php endif;?>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
