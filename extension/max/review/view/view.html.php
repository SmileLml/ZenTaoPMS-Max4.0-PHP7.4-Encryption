<?php
/**
 * The view file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: view.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php $browseLink = $this->session->reviewList ? $this->session->reviewList : inlink('browse', "project=$review->project");?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <div class="page-title">
      <span class="label label-id"><?php echo $review->id?></span>
      <span class="text"><?php echo $review->title;?></span>
      <?php if($review->deleted):?>
      <span class='label label-danger'><?php echo $lang->review->deleted;?></span>
      <?php endif; ?>
    </div>
  </div>
</div>
<div id="mainContent" class="main-row">
  <div class="main-col col-8">
    <div class='cell'>
      <div class="detail">
        <div class="detail-title"><?php echo $lang->review->auditOpinion;?></div>
        <div class="detail-content article-content">
          <?php echo !empty($auditOpinion) ? $auditOpinion : "<div class='text-center text-muted'>" . $lang->noData . '</div>';?>
        </div>
      </div>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $review->files, 'fieldset' => 'true', 'object' => $review));?>
    </div>
    <div class='cell'><?php include $app->getModuleRoot() . 'common/view/action.html.php';?></div>
    <div class='main-actions'>
      <div class="btn-toolbar">
        <?php $params = "reviewID=$review->id"; ?>
        <?php common::printBack($browseLink);?>
        <div class='divider'></div>
        <?php
        if(isset($pendingReviews[$review->id]) and !$review->deleted)
        {
            common::printIcon('review', 'assess', $params, $review, 'button', 'glasses');
        }
        common::printIcon('approval', 'progress', "approval=$approval->id", $review, 'button', 'list-alt', '', 'iframe', true);
        if(!$review->deleted)
        {
            common::printIcon('review', 'edit', $params, $review);
            common::printIcon('review', 'delete', $params, $review, 'button', 'trash', 'hiddenwin');
        }
        ?>
      </div>
    </div>
  </div>
  <div class="side-col col-4">
    <div class="cell">
      <div class='detail'>
        <div class='detail-title'><?php echo $lang->review->basicInfo;?></div>
        <div class='detail-content'>
          <table class='table table-data'>
            <tbody>
              <tr>
                <th class='w-100px'><?php echo $lang->review->object;?></th>
                <td><?php echo zget($lang->baseline->objectList, $review->category);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->version;?></th>
                <td><?php echo $review->version;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->status;?></th>
                <td><?php echo zget($lang->review->statusList, $review->status);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->reviewedBy;?></th>
                <td><?php $reviewer = explode(',', str_replace(' ', '', $review->reviewedBy)); foreach($reviewer as $account) echo ' ' . zget($users, $account);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->auditedBy;?></th>
                <td><?php echo zget($users, $review->auditedBy);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->deadline;?></th>
                <td><?php echo $review->deadline;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->createdBy;?></th>
                <td><?php echo zget($users, $review->createdBy);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->review->createdDate;?></th>
                <td><?php echo $review->createdDate;?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
