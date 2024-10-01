<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <div class="page-title">
      <span class="label label-id"><?php echo $doc->id?></span>
      <span class="text" title="<?php echo $doc->title;?>"><?php echo $doc->title;?></span>
    </div>
  </div>
</div>
<div id="mainContent" class="main-row">
  <div class="main-col col-8">
    <div class="cell">
      <div class="detail">
        <div class="detail-title"><?php echo $lang->baseline->articleView;?></div>
        <div class="detail-content article-content">
        <?php echo $doc->content?>
        </div>
      </div>
    </div>
    <div class="cell">
      <div class="detail">
        <div class="detail-title"><?php echo $lang->book->keywords;?></div>
        <div class="detail-content article-content">
        <?php echo $doc->keywords;?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
