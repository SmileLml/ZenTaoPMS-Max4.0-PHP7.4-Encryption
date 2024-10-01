<?php
$lang->devops->menu->code   = array('link' => "{$lang->repo->common}|repo|browse|repoID=%s", 'alias' => 'view,revision,log,blame,showsynccommit');
$lang->devops->menu->review = array('link' => '评审|repo|review|repoID=%s', 'subModule' => 'bug', 'alias' => 'diff');
$lang->devops->menuOrder[6] = 'review';

$lang->devops->menu->review['subMenu'] = new stdClass();
$lang->devops->menu->review['subMenu']->review = array('link' => "列表|repo|review|repoID=%s", 'subModule' => 'bug');
$lang->devops->menu->review['subMenu']->diff   = array('link' => "对比|repo|diff|repoID=%s");
