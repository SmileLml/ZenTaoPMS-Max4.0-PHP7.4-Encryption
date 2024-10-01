<?php if($type != 'book'):?>
  <?php
  $oldDir = getcwd();
  chdir($app->getModuleRoot() . 'doc/view');
  include './edit.html.php';
  chdir($oldDir);
  ?>
<?php else:?>
  <?php js::set('noticeAcl', $lang->doc->noticeAcl['doc']);?>
  <?php $optionMenu = $this->doc->getBookOptionMenu($doc->lib);?>
  <?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
  <?php $spliter = (empty($this->app->user->feedback) && !$this->cookie->feedbackView && $app->tab == 'doc') ? true : false;?>
  <div class="main-row fade" id="mainRow">
    <div class="main-col" data-min-width="400">
      <div class="cell<?php if($browseType == 'bysearch') echo ' show';?>" id="queryBox"></div>
      <div class="panel block-files block-sm no-margin">
        <div class="panel-heading">
          <div class="panel-title font-normal">
            <i class="icon icon-book text-muted"></i>
            <?php echo $doc->title . " <i class='icon-angle-right'></i> " . ($doc->type == 'article' ? $lang->doc->edit : $lang->doc->editChapter) ;?>
          </div>
          <nav class="panel-actions btn-toolbar">
            <div class="btn-group">
            </div>
          </nav>
        </div>
        <div class='panel-body'>
          <?php if($doc->contentType == 'html')     include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
          <?php if($doc->contentType == 'markdown') include $app->getModuleRoot() . 'common/view/markdown.html.php';?>
          <form class='load-indicator main-form form-ajax' method='post' enctype='multipart/form-data' id='dataform'>
            <table class='table table-form'>
              <tr>
                <th><?php echo $lang->doc->chapter;?></th>
                <td>
                  <?php echo html::hidden('lib', $doc->lib)?>
                  <span><?php echo html::select('parent', $optionMenu, $doc->parent, "class='form-control chosen'");?></span>
                </td><td></td>
              </tr>
              <tr>
                <th><?php echo $doc->type == 'article' ? $lang->doc->title : $lang->doc->chapterName;?></th>
                <td colspan='2'><?php echo html::input('title', $doc->title, "class='form-control' autocomplete='off' required");?></td>
              </tr>
              <tr>
                <th><?php echo $lang->doc->keywords;?></th>
                <td colspan='2'><?php echo html::input('keywords', $doc->keywords, "class='form-control' autocomplete='off' placeholder='{$lang->doc->keywordsTips}'");?></td>
              </tr>
              <?php if($doc->type == 'article'):?>
              <tr id='contentBox' <?php if($doc->type == 'url') echo "class='hidden'"?>>
                <th><?php echo $lang->doc->content;?></th>
                <td colspan='2'><?php echo html::textarea('content', $doc->type == 'url' ? '' : htmlspecialchars($doc->content), "style='width:100%; height:200px'");?></td>
              </tr>
              <tr id='fileBox'>
                <th><?php echo $lang->doc->files;?></th>
                <td colspan='2'><?php echo $this->fetch('file', 'buildform');?></td>
              </tr>
              <?php endif;?>
              <tr>
                <td colspan='3' class='text-center form-actions'>
                  <?php
                  echo html::hidden('editedDate', $doc->editedDate);
                  echo html::hidden('contentType', $doc->contentType);
                  echo html::hidden('type', $doc->type);
                  echo html::hidden('acl', 'open');
                  echo html::submitButton();
                  echo html::backButton();
                  ?>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
<?php endif;?>
