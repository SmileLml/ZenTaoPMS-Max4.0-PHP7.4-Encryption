<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2><?php echo $lang->chart->create;?></h2>
    </div>
    <form method='post' target='hiddenwin' id='dataform' class="form-ajax">
      <table class='table table-form'>
        <tr>
          <th class='thWidth'><?php echo $lang->chart->name;?></th>
          <td class='w-400px'>
            <?php echo html::input('name', '', "class='form-control'");?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->chart->type;?></th>
          <td>
            <?php echo html::select('type', $lang->chart->typeList, 'table', "class='chosen form-control'");?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->chart->dataset;?></th>
          <td>
            <?php echo html::select('dataset', $datasets, $dataset, "class='chosen form-control'");?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->chart->desc;?></th>
          <td><?php echo html::textarea('desc', '', "rows='7' class='form-control'");?></td>
        </tr>
        <tr>
          <td></td>
          <td class='form-actions'>
            <?php echo html::submitButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
