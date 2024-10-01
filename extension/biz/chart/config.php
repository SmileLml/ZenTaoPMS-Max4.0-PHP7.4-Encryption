<?php
$config->chart->create = new stdclass();
$config->chart->create->requiredFields = 'name,type,dataset';

$config->chart->settings = array();
$config->chart->settings['table']         = array('group' => array('allowed' => 'number,string,option', 'type' => 'select', 'multiple' => true), 'column' => array('allowed' => 'any', 'multiple' => true, 'type' => 'formula', 'required' => true));
$config->chart->settings['line']          = array('xaxis' => array('allowed' => 'date,datetime', 'type' => 'time'), 'yaxis' => array('allowed' => 'number', 'type' => 'formula', 'multiple' => true, 'multiple' => true));
$config->chart->settings['bar']           = array('xaxis' => array('allowed' => 'number,string,option', 'type' => 'select'), 'yaxis' => array('allowed' => 'number', 'type' => 'formula', 'multiple' => true));
$config->chart->settings['pie']           = array('group' => array('allowed' => 'number,string,option', 'type' => 'select'), 'metric' => array('allowed' => 'number', 'type' => 'formula'));
$config->chart->settings['testingReport'] = array('field' => array('type' => 'td'));
