<?php $currentMethod = $this->app->getMethodName();?>
<?php $activeClass = (strpos(",browse,managebook,catalog,edit", ",{$this->methodName},") !== 'false' && isset($currentLib->id) && $currentLib->id == $libID) ? 'active' : '';?>
  <?php $serials  = $this->doc->computeSN($libID); ?>
  <?php $nodeList = $this->doc->getBookStructure($libID);?>
  <ul data-name="docsTree" data-ride="tree" data-initial-state="preserve" id='modules' class="tree">
    <?php foreach($nodeList as $nodeInfo):?>
    <?php $serial = $nodeInfo->type != 'book' ? zget($nodeInfo->id, $serials, '') : '';?>
    <?php if($nodeInfo->parent != 0) continue;?>
    <?php $activeClass = (isset($doc->id) && $doc->id == $nodeInfo->id) ? 'active' : '';?>
    <?php $chapterNode = $nodeInfo->type == 'article' ? 'chapterNode' : '';?>
      <li <?php echo "class='open $activeClass $chapterNode can-sort'";?> data-id=<?php echo $nodeInfo->id;?>>
        <?php if($nodeInfo->type == 'chapter'):?>
        <?php if($app->methodName == 'objectlibs'):?>
        <div class='tree-group'>
          <span class='module-name'><?php echo "<a title='{$nodeInfo->title}' class='sort-module'>{$nodeInfo->title}</a>";?></span>
          <?php if(common::hasPriv('doc', 'edit') or common::hasPriv('doc', 'catalog')):?>
          <div class='tree-actions'>
            <?php
            if(common::hasPriv('doc', 'edit')) echo html::a(helper::createLink('doc', 'edit', "nodeID=$nodeInfo->id&comment=false&objectType=$type&objectID=$objectID&libID=$libID"), "<i class='icon icon-edit'></i>", '', "title={$this->lang->doc->editChapter}");
            if(common::hasPriv('doc', 'catalog')) echo html::a(helper::createLink('doc', 'catalog', "libID=$libID&nodeID=$nodeInfo->id"), "<i class='icon icon-split'></i>", '', "title={$this->lang->doc->catalogAction}");
            ?>
          </div>
          <?php endif;?>
        </div>
        <?php else:?>
        <?php echo "<a title='{$nodeInfo->title}' class='sort-module'>{$nodeInfo->title}</a>";?>
        <?php endif;?>
        <?php elseif($nodeInfo->type == 'article'):?>
        <?php if($currentMethod == 'tablecontents'):?>
        <span class="tail-info"><?php echo zget($users, $nodeInfo->editedBy) . ' &nbsp;' . $nodeInfo->editedDate;?></span>
        <?php endif;?>
        <?php echo "<span class='item doc-title'>{$serial} " . html::a(helper::createLink('doc', 'objectLibs', "type=book&objectID=0&libID=$libID&docID={$nodeInfo->id}"), "<i class='icon icon-file-text text-muted'></i> &nbsp;" . $nodeInfo->title, '', "title='{$nodeInfo->title}'") . '</span>';?>
        <?php endif;?>
        <?php if(!empty($nodeInfo->children)) $this->doc->getFrontCatalog($nodeInfo->children, $serials, isset($doc->id) ? $doc->id : 0);?>
      </li>
    <?php endforeach;?>
  </ul>
