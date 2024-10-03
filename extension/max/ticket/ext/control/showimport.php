<?php
/**
 * The model file of excel module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     excel
 * @link        https://www.zentao.net
 */
helper::importControl('ticket');
class myticket extends ticket
{
    /**
     * Show import.
     *
     * @param  int    $pagerID
     * @param  int    $maxImport
     * @param  string $insert
     * @access public
     * @return void
     */
    public function showImport($pagerID = 1, $maxImport = 0, $insert = '')
    {
        $this->loadModel('transfer');

        if($_POST)
        {
            $this->ticket->createFromImport();

            if($this->post->isEndPage) $locate = inlink('browse');

            return print(js::locate($locate, 'parent'));
        }

        $ticketData = $this->transfer->readExcel('ticket', $pagerID, $insert);

        if(!empty(current($ticketData->datas)->id)) 
        {
            echo js::alert($this->lang->ticket->importReload);
            $browseLink = $this->session->ticketList ? $this->session->ticketList : $this->createlink('ticket', 'browse');
            return print(js::locate($browseLink));
        }

        $title = $this->lang->ticket->common . $this->lang->colon . $this->lang->ticket->showImport;

        $this->view->title     = $title;
        $this->view->datas     = $ticketData;
        $this->view->backLink  = inlink('browse');

        $this->display();
    }
}
