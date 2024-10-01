<?php
$lang->try    = ' Trial';
$lang->maxName   = ' Max';
$lang->expireDate   = "Expire on %s";
$lang->forever   = "Vĩnh viễn";
$lang->unlimited = "Không giới hạn";
$lang->licensedUser = "User Licensed: %s";

$lang->searchObjects['feedback']   = 'Phản hồi';
$lang->searchObjects['ticket']     = 'Ticket';
$lang->searchObjects['service']    = 'Dịch vụ';
$lang->searchObjects['deploy']     = 'Triển khai';
$lang->searchObjects['deploystep'] = 'Triển khai bước';

$lang->noticeBizLimited = "<div style='float:left;color:red' id='userLimited'>The number of users has exceeded that of the licensed. Vui lòng contact us at Renee@easysoft.ltd, or xóa users.</div>";

$lang->admin->subMenu->sso->libreoffice = array('link' => 'Office|custom|libreoffice');
$lang->admin->subMenuOrder->sso[10] = 'libreoffice';

$lang->nonRDMenu = new stdclass();
$lang->nonRDMenu->my    = 'Calendar|my|calendar|';
//$lang->nonRDMenu->doc   = 'Document|doc|alllibs|';
$lang->nonRDMenu->feedback = 'Feedback|feedback|browse|';
$lang->nonRDMenu->faq   = 'FAQ|faq|browse|';
$lang->nonRDMenu->oa    = 'OA|attend|personal|';
$lang->nonRDMenu->company  = $lang->menu->company;

if(!empty($_SESSION['user']->feedback) or !empty($_COOKIE['feedbackView']))
{
 $lang->menu = $lang->nonRDMenu;
 $lang->menuOrder = array();
 $lang->menuOrder[5]  = 'my';
 $lang->menuOrder[10] = 'oa';
 $lang->menuOrder[15] = 'feedback';
 $lang->menuOrder[16] = 'faq';
 //$lang->menuOrder[20] = 'doc';
 $lang->menuOrder[25] = 'company';
}
