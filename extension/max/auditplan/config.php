<?php
$config->auditplan = new stdclass();
$config->auditplan->editor = new stdclass();
$config->auditplan->editor->create   = array('id' => 'comment', 'tools' => 'simpleTools');
$config->auditplan->editor->edit     = array('id' => 'comment', 'tools' => 'simpleTools');
$config->auditplan->editor->assignto = array('id' => 'comment', 'tools' => 'simpleTools');

$config->auditplan->datatable = new stdclass();
$config->auditplan->datatable->defaultField = array('id', 'objectID', 'execution', 'objectType', 'status', 'assignedTo', 'checkDate', 'realCheckDate', 'nc', 'actions');

$config->auditplan->datatable->fieldList['id']['title']    = 'idAB';
$config->auditplan->datatable->fieldList['id']['fixed']    = 'left';
$config->auditplan->datatable->fieldList['id']['width']    = '70';
$config->auditplan->datatable->fieldList['id']['required'] = 'yes';

$config->auditplan->datatable->fieldList['process']['title']    = 'process';
$config->auditplan->datatable->fieldList['process']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['process']['width']    = '100';
$config->auditplan->datatable->fieldList['process']['required'] = 'no';

$config->auditplan->datatable->fieldList['processType']['title']    = 'processType';
$config->auditplan->datatable->fieldList['processType']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['processType']['width']    = '95';
$config->auditplan->datatable->fieldList['processType']['required'] = 'no';

$config->auditplan->datatable->fieldList['objectID']['title']    = 'objectID';
$config->auditplan->datatable->fieldList['objectID']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['objectID']['width']    = 'auto';
$config->auditplan->datatable->fieldList['objectID']['required'] = 'no';

$config->auditplan->datatable->fieldList['execution']['title']    = 'execution';
$config->auditplan->datatable->fieldList['execution']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['execution']['width']    = '100';
$config->auditplan->datatable->fieldList['execution']['required'] = 'no';

$config->auditplan->datatable->fieldList['objectType']['title']    = 'objectType';
$config->auditplan->datatable->fieldList['objectType']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['objectType']['width']    = '95';
$config->auditplan->datatable->fieldList['objectType']['required'] = 'no';

$config->auditplan->datatable->fieldList['status']['title']    = 'status';
$config->auditplan->datatable->fieldList['status']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['status']['width']    = '60';
$config->auditplan->datatable->fieldList['status']['required'] = 'no';

$config->auditplan->datatable->fieldList['createdBy']['title']    = 'createdBy';
$config->auditplan->datatable->fieldList['createdBy']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['createdBy']['width']    = '80';
$config->auditplan->datatable->fieldList['createdBy']['required'] = 'no';

$config->auditplan->datatable->fieldList['assignedTo']['title']    = 'assignedTo';
$config->auditplan->datatable->fieldList['assignedTo']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['assignedTo']['width']    = '120';
$config->auditplan->datatable->fieldList['assignedTo']['required'] = 'no';

$config->auditplan->datatable->fieldList['checkDate']['title']    = 'checkDate';
$config->auditplan->datatable->fieldList['checkDate']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['checkDate']['width']    = '100';
$config->auditplan->datatable->fieldList['checkDate']['required'] = 'no';

$config->auditplan->datatable->fieldList['realCheckDate']['title']    = 'realCheckDate';
$config->auditplan->datatable->fieldList['realCheckDate']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['realCheckDate']['width']    = '100';
$config->auditplan->datatable->fieldList['realCheckDate']['required'] = 'no';

$config->auditplan->datatable->fieldList['nc']['title']    = 'nc';
$config->auditplan->datatable->fieldList['nc']['fixed']    = 'no';
$config->auditplan->datatable->fieldList['nc']['width']    = '80';
$config->auditplan->datatable->fieldList['nc']['required'] = 'no';
$config->auditplan->datatable->fieldList['nc']['sort']     = 'no';

$config->auditplan->datatable->fieldList['actions']['title']    = 'actions';
$config->auditplan->datatable->fieldList['actions']['fixed']    = 'right';
$config->auditplan->datatable->fieldList['actions']['width']    = '148';
$config->auditplan->datatable->fieldList['actions']['required'] = 'yes';
