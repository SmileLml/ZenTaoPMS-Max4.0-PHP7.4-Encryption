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
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2>
        <?php echo $lang->approvalflow->create;?>
      </h2>
    </div>
    <form class='form-ajax' method='post'>
      <table class="table table-form">
        <tr>
          <th class='w-100px'><?php echo $lang->approvalflow->type;?></th>
          <td><?php echo html::select('type', $lang->approvalflow->typeList, $type, "class='form-control chosen'");?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->approvalflow->name;?></th>
          <td class='required'><?php echo html::input('name', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->approvalflow->desc;?></th>
          <td colspan='2'><?php echo html::textarea('desc', '', "class='form-control' rows=5");?></td>
        </tr>
        <tr>
          <th></th>
          <td class='form-actions text-left'>
            <?php echo html::submitButton();?>
            <?php echo html::backButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
