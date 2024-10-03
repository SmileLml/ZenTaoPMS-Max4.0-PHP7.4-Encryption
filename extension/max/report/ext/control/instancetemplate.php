<?php
class myReport extends report
{
    public function instanceTemplate($programID = 0, $templateID = 0, $reportID = 0)
    {
        $template = $this->loadModel('measurement')->getTemplateByID($templateID);
        $this->report->buildReportList($programID);

        $content      = $template->content;
        $parseContent = 'no';
        if($this->post->parseContent == 'yes')
        {
            $content      = $this->measurement->parseTemplateContent($content);
            $parseContent = $this->post->parseContent;
        }
        if($this->post->saveReport == 'yes')
        {
            $reportID = $this->report->saveMeasReport($programID, $templateID, $content);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'locate' => $this->inlink('instanceTemplate', "program=$programID&templateID=$templateID&reportID=$reportID")));
        }

        if($reportID)
        {
            $report       = $this->report->getMeasReportByID($reportID);
            $content      = $report->content;
            $parseContent = 'yes';
        }

        $this->view->title      = $template->name;
        $this->view->position[] = $template->name;

        $this->view->programID    = $programID;
        $this->view->template     = $template;
        $this->view->reportID     = $reportID;
        $this->view->reports      = $this->report->getMeasReports($programID);
        $this->view->content      = $content;
        $this->view->parseContent = $parseContent;
        $this->view->params       = $this->post->params;
        $this->view->submenu      = 'program';
        $this->view->programID    = $programID;
        $this->display();
    }
}
