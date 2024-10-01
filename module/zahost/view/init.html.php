<?php

/**
 * The view file of zahost module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Ke zhao <zhaoke@cnezsoft.com>
 * @package     automation
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php'; ?>
<?php js::set('hostID', $hostID) ?>
<?php js::set('zahostLang', $lang->zahost); ?>
<div id='mainContent' class='main-content'>
  <div class='main-col main-content'>
    <div class='center-block'>
      <div class='main-header'>
        <h2><?php echo $lang->zahost->init->title; ?></h2>
      </div>

      <div class="host-desc-container">
        <h4><?php echo $lang->zahost->init->descTitle; ?></h4>
        <div>
          <span class='dot-symbol'></span>
          <span class='zahost-init-desc'>
            <textarea style="display:none;" id="initBash"><?php echo $initBash; ?></textarea>
            <?php echo sprintf($lang->zahost->init->initDesc, $initBash, "<button type='button' class='btn btn-info btn-mini btn-init-copy'><i class='icon-common-copy icon-copy' title='" . $lang->zahost->copy .  "'></i></button>"); ?>
          </span>
        </div>
        <div id="statusContainer">
        </div>
      </div>

      <div class="text-center host-action">
        <button type='button' id='checkServiceStatus' class='btn btn-info margin-top-18'><?php echo $lang->zahost->init->checkStatus; ?></button>
      </div>
    </div>
  </div>
</div>
<?php include $app->getModuleRoot() . 'common/view/successmodal.html.php';?>
<?php include '../../common/view/footer.html.php'; ?>
