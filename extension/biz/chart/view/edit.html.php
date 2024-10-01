<?php
/**
 * The edit view file of chart of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chart
 * @version     $Id: browse.html.php 5096 2013-07-11 07:02:43Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2>
        <?php echo $lang->chart->edit;?>
      </h2>
    </div>
    <form class='form-ajax' method='post'>
      <table class="table table-form">
        <tr>
          <th class='w-100px'><?php echo $lang->chart->name;?></th>
          <td class='required'><?php echo html::input('name', $chart->name, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->chart->desc;?></th>
          <td colspan='2'><?php echo html::textarea('desc', $chart->desc, "class='form-control' rows=5");?></td>
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
