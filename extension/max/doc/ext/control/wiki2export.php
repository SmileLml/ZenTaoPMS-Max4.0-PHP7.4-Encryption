<?php
helper::importControl('doc');
class mydoc extends control
{
    public function wiki2export($libID, $docID)
    {
        $book = $this->doc->getLibByID($libID);
        if($_POST)
        {
            $this->post->set('libID', $libID);
            $this->post->set('docID', $docID);
            $this->post->set('currentArticle', $this->post->chapter);
            $this->post->set('kind', 'wiki');
            $this->post->set('fileName', $this->post->fileName);
            $this->fetch('file', 'wiki2word', $_POST);
            die();
        }

        $this->view->docID     = $docID;
        $this->view->data      = $book;
        $this->view->title     = $this->lang->export;
        $this->view->kind      = 'wiki';
        $this->view->chapters  = array(
            'current' => $this->lang->doc->export->currentDoc,
            'all'     => $this->lang->doc->export->allDoc
        );
        $this->display('doc', 'doc2export');
    }
}
