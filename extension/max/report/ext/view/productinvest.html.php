<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<style>
#mainContent > .side-col.col-lg{width: 235px}
.hide-sidebar #sidebar{width: 0 !important}
.c-count {width: 120px;}
#conditions {display: flex;}
#conditions .condition-options {margin-left: 16px;}
</style>
<div id='mainContent' class='main-row'>
  <div class='side-col col-lg' id='sidebar'>
    <?php include $app->getModuleRoot() . 'report/view/blockreportlist.html.php';?>
  </div>
  <div class='main-col'>
    <?php if(empty($investData)):?>
    <div class="cell">
      <div class="table-empty-tip">
        <p><span class="text-muted"><?php echo $lang->error->noData;?></span></p>
      </div>
    </div>
    <?php else:?>
    <div class='cell'>
      <div class='panel'>
        <div class="panel-heading">
          <div class="panel-title">
            <div id='conditions'>
              <div><?php echo $title;?></div>
              <div class='condition-options'>
                <div class="checkbox-primary inline-block">
                  <input type="checkbox" name="closedProduct" value="closedProduct" id="closedProduct" <?php if(strpos($conditions, 'closedProduct') !== false) echo "checked='checked'"?> />
                  <label for="closedProduct"><?php echo $lang->report->closedProduct?></label>
                </div>
              </div>
            </div>
          </div>
          <nav class="panel-actions btn-toolbar"></nav>
        </div>
        <div data-ride='table'>
          <table class='table table-condensed table-striped table-bordered table-fixed no-margin' id='productList'>
            <thead>
              <tr class='text-center'>
                <th class='c-name text-left'><?php echo $lang->product->name;?></th>
                <th class='c-count'><?php echo $lang->report->projects;?></th>
                <th class="c-count"><?php echo $lang->report->storyConsumed;?></th>
                <th class="c-count"><?php echo $lang->report->taskConsumed;?></th>
                <th class="c-count"><?php echo $lang->report->bugConsumed;?></th>
                <th class="c-count"><?php echo $lang->report->caseConsumed;?></th>
                <th class="c-count"><?php echo $lang->report->totalConsumed;?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($investData as $invest):?>
              <tr class="text-center">
                <td><div class='text-ellipsis text-left' title='<?php echo $invest->name;?>'><?php echo $invest->name?></div></td>
                <td><?php echo $invest->projectCount;?></td>
                <td><?php echo $invest->storyConsumed;?></td>
                <td><?php echo $invest->taskConsumed;?></td>
                <td><?php echo $invest->bugConsumed;?></td>
                <td><?php echo $invest->caseConsumed;?></td>
                <td><?php echo $invest->totalConsumed;?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php endif;?>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
