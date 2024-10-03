<?php
require_once 'exportbase.php';
class file extends exportbase
{
    /**
     * Export to Word
     *
     * @access public
     * @return void
     */
    public function wiki2Word()
    {
        $this->init();
        $headerName = $this->post->fileName;

        if($headerName)
        {
            $this->phpWord->addParagraphStyle('headerStyle', array('align' => 'center'));
            $this->phpWord->addTitleStyle(1, array('size' => 20, 'color' => '010101', 'bold' => true), array('align' => 'center'));
            $this->phpWord->addTitleStyle(2, array('size' => 16, 'color' => '666666'));
            $this->phpWord->addTitleStyle(3, array('size' => 14, 'italic' => true));
            $this->phpWord->addTitleStyle(4, array('size' => 12));
        }

        if($this->exportedArticle)
        {
            // Single article
            $article = $this->articles = $this->dao->select('t1.id,t1.module,t1.lib,t1.path,t1.title,t1.type,t1.parent,t1.grade,t1.`order`,t2.content,t2.files,t2.type as contentType')->from(TABLE_DOC)->alias('t1')
            ->leftJoin(TABLE_DOCCONTENT)->alias('t2')->on('t1.id=t2.doc && t1.version=t2.version')
            ->where('t1.lib')->eq($this->libID)
            ->andWhere('t1.deleted')->eq('0')
            ->andWhere('t1.type')->in('article')
            ->andWhere('t1.id')->eq($this->post->docID)
            ->fetch();
            array_shift($this->exportFields);
            $this->files = $this->dao->select('id,pathname,title,extension')->from(TABLE_FILE)->where('id')->in($article->files)->fetchAll('id');
            $this->section->addTitle($article->title, 1);
            $this->section->addTextBreak(2);
            $this->createContent($article, 1, '');
        }
        else
        {
            $this->section->addTitle($headerName, 1);
            $this->section->addTextBreak(2);
            // All articles
            $this->getExportData();
            $entry = $this->tops;
            
            $fontStyle12 = array('spaceAfter' => 60, 'size' => 12);
            $this->section->addTOC($fontStyle12);
            $this->section->addPageBreak();
            
            foreach($entry as $top)
            {
                $order = $this->getNextOrder($this->order, 1);
                $this->createWord($top, 1, $order);
            }
        }

        unset($this->htmlDom);
        setcookie('downloading', 1);
        header('Content-Type: application/vnd.ms-word');
        header("Content-Disposition: attachment;filename=\"{$this->post->fileName}.docx\"");
        header('Cache-Control: max-age=0');

        $wordWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        $wordWriter->save('php://output');
        exit;
    }

    public function getExportData()
    {
        $this->tops = $this->dao->select('id,lib,path,title,type,parent,grade,`order`')->from(TABLE_DOC)
            ->where('lib')->eq($this->libID)
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->eq(0)
            ->orderBy("grade,`order`")
            ->fetchAll('id');

        $this->chapters = $this->dao->select('id,lib,path,title,type,parent,grade,`order`')->from(TABLE_DOC)
            ->where('lib')->eq($this->libID)
            ->andWhere('deleted')->eq('0')
            ->beginIF($this->exportedArticle)->andWhere('id')->eq($this->post->docID)->fi()
            ->orderBy("grade,`order`")
            ->fetchGroup('parent', 'id');

        $this->articles = $this->dao->select('t1.id,t1.lib,t1.path,t1.title,t1.type,t1.parent,t1.grade,t1.`order`,t2.content,t2.files,t2.type as contentType')->from(TABLE_DOC)->alias('t1')
            ->leftJoin(TABLE_DOCCONTENT)->alias('t2')->on('t1.id=t2.doc && t1.version=t2.version')
            ->where('t1.lib')->eq($this->libID)
            ->andWhere('t1.deleted')->eq('0')
            ->andWhere('t1.type')->eq('article')
            ->beginIF($this->exportedArticle)->andWhere('t1.id')->eq($this->post->docID)->fi()
            ->orderBy("grade,`order`")
            ->fetchGroup('parent', 'id');

        $files = '';
        foreach($this->articles as $parent => $articles)
        {
            foreach($articles as $articleID => $article) $files .= $article->files . ',';
        }
        
        if(!$this->exportedArticle)
        {
            foreach($this->tops as $docID => $doc)
            {
                if($doc->type == 'article') $this->tops[$docID] = $this->articles[0][$docID];
            }
        }

        $files = array_unique(explode(',', $files));
        $this->files = $this->dao->select('id,pathname,title,extension')->from(TABLE_FILE)->where('id')->in($files)->fetchAll('id');
    }
}
