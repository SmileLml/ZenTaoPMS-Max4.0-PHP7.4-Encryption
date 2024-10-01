<?php
/**
 * The control file of company module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/datepicker.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/datatable.fix.html.php';?>
<?php js::set('maxCount', $config->maxCount);?>
<?php if(common::checkNotCN()):?>
<style>
#sidebar .form-group .input-group-addon{width:93px;}
#sidebar .form-group #userBox .input-group-addon{padding:5px 32px;}
</style>
<?php endif;?>
<div id='mainMenu' class='clearfix'>
  <div class='btn-toolbar pull-left'>
    <?php
    echo html::a(inlink('calendar'), "<span class='text'>{$lang->company->calendar}</span>", '', "class='btn btn-link' id='calendarTab'");
    echo html::a(inlink('effort', "date=today"),     "<span class='text'>{$lang->effort->todayEfforts}</span>",     '', "class='btn btn-link' id='today'"    );
    echo html::a(inlink('effort', "date=yesterday"), "<span class='text'>{$lang->effort->yesterdayEfforts}</span>", '', "class='btn btn-link' id='yesterday'");
    echo html::a(inlink('effort', "date=thisweek"),  "<span class='text'>{$lang->effort->thisWeekEfforts}</span>",  '', "class='btn btn-link' id='thisweek'" );
    echo html::a(inlink('effort', "date=lastweek"),  "<span class='text'>{$lang->effort->lastWeekEfforts}</span>",  '', "class='btn btn-link' id='lastweek'" );
    echo html::a(inlink('effort', "date=thismonth"), "<span class='text'>{$lang->effort->thisMonthEfforts}</span>", '', "class='btn btn-link' id='thismonth'");
    echo html::a(inlink('effort', "date=lastmonth"), "<span class='text'>{$lang->effort->lastMonthEfforts}</span>", '', "class='btn btn-link' id='lastmonth'");
    echo html::a(inlink('effort', "date=all"),       "<span class='text'>{$lang->effort->periods['all']}</span>",   '', "class='btn btn-link' id='all'"      );
    ?>
  </div>
  <div class='btn-toolbar pull-right'><?php common::printIcon('effort', 'export', "userID=" . ($user ? $user->id : '') . "&orderBy=date_asc", '', 'button', '', '', 'export');?></div>
</div>
<div id="mainContent" class="main-row fade">
  <div class="side-col" id="sidebar">
    <div class="sidebar-toggle"><i class="icon icon-angle-left"></i></div>
    <div class='cell'>
      <form method='post' action='<?php echo $this->createLink('company', 'effort', "date=custom&orderBy=$orderBy")?>'>
        <div class='detail'>
          <div class='detail-content'>
            <div class='form-group'>
              <div class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->userType;?></span>
                <?php echo html::select('userType', $lang->company->userTypes, $userType, 'class="form-control chosen"');?>
              </div>
            </div>
            <div class='form-group'>
              <div class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->dept;?></span>
                <?php if(empty($mainDepts)) $mainDepts = array(0 => '/');?>
                <?php echo html::select('dept', $mainDepts, $dept, "class='form-control chosen' onchange='loadDeptUsers(this.value, \"account\")'");?>
              </div>
            </div>
            <div class='form-group'>
              <div class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->beginDate;?></span>
                <?php echo html::input('begin', $begin, 'class="form-control form-date"');?>
              </div>
            </div>
            <div class='form-group'>
              <div class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->endDate;?></span>
                <?php echo html::input('end', $end, 'class="form-control form-date"');?>
              </div>
            </div>
            <div class='form-group'>
              <div id='productIdBox' class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->product;?></span>
                <?php if($config->vision == 'lite'):?>
                <?php echo html::select('product', $products, $product, 'class="form-control chosen" onchange="loadProductExecutions(this.value)"');?>
                <?php else:?>
                <?php echo html::select('product', $products, $product, 'class="form-control chosen" onchange="loadProductProject(this.value)"');?>
                <?php endif;?>
              </div>
            </div>
            <?php if($config->vision != 'lite'):?>
            <div class='form-group'>
              <div id='projectIdBox' class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->project;?></span>
                <?php echo html::select('project', $projects, $project, 'class="form-control chosen" onchange="loadProductExecutions($(\'#product\').val(), this.value)"');?>
              </div>
            </div>
            <?php endif;?>
            <div class='form-group'>
              <div id='executionIdBox' class='input-group'>
              <span class='input-group-addon'><?php echo $config->vision != 'lite' ? $lang->execution->common : $lang->company->execution;?></span>
                <?php echo html::select('execution', $executions, $execution, 'class="form-control chosen"');?>
              </div>
            </div>
            <div class='form-group'>
              <div id='userBox' class='input-group'>
                <span class='input-group-addon'><?php echo $lang->company->user;?></span>
                <?php echo html::select('user', $users, $account, 'class="form-control chosen"');?>
              </div>
            </div>
            <div class='form-group'><?php echo html::submitButton($lang->company->effort->view);?></div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="main-col">
    <?php
    $datatableId  = $this->moduleName . ucfirst($this->methodName);
    $useDatatable = (isset($this->config->datatable->$datatableId->mode) and $this->config->datatable->$datatableId->mode == 'datatable');
    $vars         = "date=$date&orderBy=%s&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage";

    //if($useDatatable) include $app->getModuleRoot() . 'common/view/datatable.html.php';
    $customFields = $this->datatable->getSetting('company');
    $widths       = $this->datatable->setFixedFieldWidth($customFields);
    $columns      = 0;
    ?>
    <form class='main-table' data-ride='table' method='post' id='effortForm' action='<?php echo $this->createLink('effort', 'batchEdit', "from=browse&userID=" . ($user ? $user->id : ''))?>' <?php if($useDatatable) echo "style='overflow:hidden'"?>>
      <div class="table-responsive">
        <table class='table has-sort-head table-fixed <?php if($useDatatable) echo 'datatable';?>' id='effortList' data-checkable='false' data-fixed-left-width='<?php echo $widths['leftWidth']?>' data-fixed-right-width='<?php echo $widths['rightWidth']?>' data-custom-menu='true' data-checkbox-name='effortIDList[]'>
          <thead>
            <tr>
              <?php
              foreach($customFields as $field)
              {
                  if($field->show)
                  {
                      $this->datatable->printHead($field, $orderBy, $vars, false);
                      $columns++;
                  }
              }
              ?>
              <th></th>
            </tr>
          </thead>
          <?php $times = 0?>
          <?php if($efforts):?>
          <tbody>
            <?php foreach($efforts as $effort):?>
            <tr data-id='<?php echo $effort->id;?>'>
              <?php
              $mode = $useDatatable ? 'datatable' : 'table';
              foreach($customFields as $field) $this->effort->printCell($field, $effort, $mode);
              ?>
              <td></td>
            </tr>
            <?php $times += $effort->consumed;?>
            <?php endforeach;?>
          </tbody>
          <?php endif;?>
        </table>
      </div>
      <?php if($efforts):?>
      <div class='table-footer'>
        <?php if($times):?>
        <span class='table-statistic' style='line-height:28px'><?php printf($lang->company->effort->timeStat, $times);?></span>
        <?php endif;?>
        <?php $pager->show('right', 'pagerjs');?>
      </div>
      <?php endif;?>
    </form>
  </div>
</div>
<script>
$(function()
{
    $('#<?php echo $date;?>').addClass('btn-active-text');
    <?php if($date == 'custom'): ?>
    $('#all').addClass('btn-active-text')
    <?php endif;?>
    <?php if((int)$date != 0):?>
    $('#date').css("font-weight", "bold");
    <?php endif;?>
})
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
