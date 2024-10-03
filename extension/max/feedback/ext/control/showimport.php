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
helper::importControl('feedback');
class myfeedback extends feedback
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
            $this->feedback->createFromImport();

            if($this->post->isEndPage) $locate = inlink('admin');

            return print(js::locate($locate, 'parent'));
        }

        $feedbackData = $this->transfer->readExcel('feedback', $pagerID, $insert);

        $title = $this->lang->feedback->common . $this->lang->colon . $this->lang->feedback->showImport;

        $this->view->title     = $title;
        $this->view->datas     = $feedbackData;
        $this->view->backLink  = inlink('admin');

        $this->display();
    }
}
