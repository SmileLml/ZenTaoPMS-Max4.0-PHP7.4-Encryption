<?php
$config->story->datatable->fieldList['status']['width'] = '80';

if($config->URAndSR)
{
    $config->story->datatable->fieldList['SRS']['title']    = 'SR';
    $config->story->datatable->fieldList['SRS']['fixed']    = 'no';
    $config->story->datatable->fieldList['SRS']['width']    = '50';
    $config->story->datatable->fieldList['SRS']['required'] = 'no';
    $config->story->datatable->fieldList['SRS']['sort']     = 'no';

    $config->story->datatable->fieldList['URS']['title']    = 'UR';
    $config->story->datatable->fieldList['URS']['fixed']    = 'no';
    $config->story->datatable->fieldList['URS']['width']    = '50';
    $config->story->datatable->fieldList['URS']['required'] = 'no';
    $config->story->datatable->fieldList['URS']['sort']     = 'no';
}
