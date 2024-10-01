<?php
$lang->devops->menu->code   = array('link' => "{$lang->repo->common}|repo|browse|repoID=%s", 'alias' => 'view,revision,log,blame,showsynccommit');
$lang->devops->menu->review = array('link' => 'Review|repo|review|repoID=%s', 'subModule' => 'bug', 'alias' => 'diff');
$lang->devops->menuOrder[6] = 'review';

$lang->devops->menu->review['subMenu'] = new stdClass();
$lang->devops->menu->review['subMenu']->review = array('link' => "Review List|repo|review|repoID=%s", 'subModule' => 'bug');
$lang->devops->menu->review['subMenu']->diff   = array('link' => "Compare|repo|diff|repoID=%s");
