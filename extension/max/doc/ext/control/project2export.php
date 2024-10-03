<?php
helper::importControl('doc');
class mydoc extends control
{
    public function project2export($libID, $docID)
    {
        $project = $this->doc->getLibByID($libID);
        if($_POST)
        {
            $this->post->set('libID', $libID);
            $this->post->set('docID', $docID);
            $this->post->set('currentArticle', $this->post->chapter);
            $this->post->set('kind', 'project');
            $this->post->set('fileName', $this->post->fileName);
            $this->fetch('file', 'doc2word', $_POST);
            die();
        }

        $this->view->docID    = $docID;
        $this->view->data     = $project;
        $this->view->title    = $this->lang->export;
        $this->view->kind     = 'project';
        $this->view->chapters = array(
            'current' => $this->lang->doc->export->currentDoc,
            'all'     => $this->lang->doc->export->allDoc
        );
        $this->display('doc', 'doc2export');
    }
}
