<?php include $app->getModuleRoot() . 'common/view/header.html.php'?>
<style>
.search-list{width: 400px; max-width: 500px; min-width: 200px;}
#dropMenu.has-search-text{width: 400px; max-width: 500px; min-width: 200px;}
#dropMenu .list-group{width: 400px; max-width: 410px;}
#dropMenu>.search-box{max-width: 400px;}
#dropMenu .col-footer{width: 400px;}
</style>

  <div id="mainMenu" class="clearfix">
    <div class="btn-toolbar pull-left">
      <div class="btn-group angle-btn">
        <div class="btn-group">
          <?php if(empty($reviewInfo)):?>
          <button data-toggle="dropdown" type="button" class="btn btn-limit" id="currentItem" title="<?php echo $lang->reviewissue->searchReview;?>" style="border-radius: 2px;"><?php echo $lang->reviewissue->searchReview;?>
          <?php else:?>
          <button data-toggle="dropdown" type="button" class="btn btn-limit" id="currentItem" title="<?php echo $reviewInfo->title;?>" style="border-radius: 2px;"><?php echo $reviewInfo->title;?>
          <?php endif;?>
          <span class="caret"></span>
          </button>
          <div id="dropMenu" class="dropdown-menu search-list load-indicator" data-ride="searchList" data-url="<?php echo $this->createLink('reviewissue', 'ajaxGetReview',"project=$projectID&reviewID=$reviewID&status=$status");?>">
            <div class="input-control search-box has-icon-left has-icon-right search-example">
              <input type="search" class="form-control search-input empty">
              <label class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label>
              <a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a>
            </div>
          </div>
        </div>
      </div>
      <?php
      foreach($lang->reviewissue->browseStatus as $type => $label)
      {
          $active = $type == $status ? 'btn-active-text' : '';
          echo html::a($this->createLink('reviewissue', 'issue', "project=$projectID&reviewID=$reviewID&status=$type"),  "<span class='text'>" . $label . '</span> ' . ($status == $type ? "<span class='label label-light label-badge'>{$pager->recTotal}</span>" : ''), '',"class='btn btn-link $active'");
      }
      ?>
      </div>
    <div class="pull-right"><?php echo $lang->pageActions;?></div>
  </div>
  <div id="mainContent" class="main-row">
    <div class="main-col">
      <?php if(empty($issueList)):?>
      <div class="table-empty-tip">
        <p>
          <span class="text-muted"><?php echo $lang->noData;?></span>
        </p>
      </div>
      <?php else:?>
      <div class="main-table">
        <table class='table has-sort-head table-fixed' id="issueTable">
            <?php $vars = "project=$projectID&reviewID=$reviewID&status=$status&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
          <thead>
            <tr>
              <th class="c-id w-60px"><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB)?></th>
              <th class="w-220px"><?php common::printOrderLink('title', $orderBy, $vars, $this->lang->reviewissue->title)?></th>
              <th class="w-220px"><?php common::printOrderLink('review', $orderBy, $vars, $this->lang->reviewissue->review)?></th>
              <th class="w-220px"><?php common::printOrderLink('opinion', $orderBy, $vars, $this->lang->reviewissue->opinion)?></th>
              <th class="w-120px"><?php common::printOrderLink('status', $orderBy, $vars, $this->lang->reviewissue->status)?></th>
              <th class="w-120px"><?php common::printOrderLink('type', $orderBy, $vars, $this->lang->reviewissue->type)?></th>
              <th class="w-120px"><?php common::printOrderLink('createdBy', $orderBy, $vars, $this->lang->reviewissue->createdBy)?></th>
              <th class="w-120px"><?php common::printOrderLink('createdDate', $orderBy, $vars, $this->lang->reviewissue->createdDate)?></th>
              <th class="text-center w-160px"><?php echo $lang->actions;?></th>
            </tr>
          </thead>
          <tbody class="sortable" id="issueTableList">
            <?php foreach($issueList as $issue):?>
              <tr data-id="<?php echo $issue->id;?>">
                <td class="text-left text-ellipsis"><?php echo $issue->id;?></td>
                <td class="text-left text-ellipsis"><?php echo html::a($this->createLink('reviewissue', 'view', "issueID=$issue->id"), $issue->title, '', "title='$issue->title'");?></td>
                <td class="text-left text-ellipsis"><?php echo html::a($this->createLink('reviewissue', 'view', "issueID=$issue->id"), $issue->reviewtitle, '', "title='$issue->reviewtitle'");?></td>
                <td class="text-left text-ellipsis"><?php echo $issue->opinion;?></td>
                <td class="text-left"><?php echo zget($this->lang->reviewissue->statusList, $issue->status);?></td>
                <td class="text-left"><?php echo zget($this->lang->reviewissue->issueType, $issue->type);?></td>
                <td class="text-left"><?php echo zget($users, $issue->createdBy);?></td>
                <td class="text-left"><?php echo $issue->createdDate;?></td>
                <td class="text-center c-actions">
                  <?php
                  $hide   = '';
                  $active = '';
                  $close  = '';
                  if($issue->status == 'active') $active = $close = 'disabled';
                  if($issue->status == 'resolved') $hide = 'disabled';
                  if($issue->status == 'closed') $hide = $close = 'disabled';
                  js::set('confirmActive', $lang->reviewissue->confirmActive);
                  js::set('confirmClose', $lang->reviewissue->confirmClose);
                  $activeURL = $this->createLink('reviewissue', 'updateStatus', "issueID=$issue->id&status=active");
                  $closedURL = $this->createLink('reviewissue', 'updateStatus', "issueID=$issue->id&status=closed");

                  common::printIcon('reviewissue', 'edit', "project=$projectID&issueID=$issue->id", $issue, 'list');
                  common::printIcon('reviewissue', 'resolved', "project=$projectID&issueID=$issue->id&status=resolved", $issue, 'list', 'checked', '', 'iframe ' . $hide, true, "data-width=30%");
                  echo html::a("javascript:ajaxDelete(\"$closedURL\", \"getList\", confirmClose)", '<i class="icon-bug-activate icon-off"></i>', '', "title='{$lang->reviewissue->close}' class='btn $close'");
                  echo html::a("javascript:ajaxDelete(\"$activeURL\", \"getList\", confirmActive)", '<i class="icon-bug-activate icon-magic"></i>', '', "title='{$lang->reviewissue->activation}' class='btn $active'");
                  common::printIcon('reviewissue', 'delete', "issueID=$issue->id&project=$projectID&confirm=no", $issue, 'list', 'trash', 'hiddenwin');
                  ?>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <div class="table-footer">
          <?php $pager->show('right', 'pagerjs');?>
        </div>
      </div>
      <?php endif;?>
    </div>
  </div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php'?>
