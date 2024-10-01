<?php
/**
 * The performable file of kanban module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yue Ma <mayue@easycorp.ltd>
 * @package     kanban
 * @version     $Id: performable.html.php 935 2022-01-1 14:20:24Z $
 * @link        https://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<style>
.c-title {width:150px !important}
</style>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2><i class='icon icon-cog-outline'></i> <?php echo $lang->execution->ganttSetting;?></h2>
    </div>
    <form class='main-form form-ajax' method='post' enctype='multipart/form-data' id='dataform'>
      <table class='table table-form'>
        <tr>
          <th class='c-title'><?php echo $lang->execution->gantt->showID;?></th>
          <td><?php echo nl2br(html::radio('showID', $lang->execution->gantt->showList, $showID));?></td>
        </tr>
        <?php if($isBranch):?>
        <tr>
          <th class='c-title'><?php echo $lang->execution->gantt->showBranch;?></th>
          <td><?php echo nl2br(html::radio('showBranch', $lang->execution->gantt->showList, $showBranch));?></td>
        </tr>
        <?php endif;?>
        <tr>
          <td colspan='2' class='text-center form-actions'>
            <?php echo html::submitButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
