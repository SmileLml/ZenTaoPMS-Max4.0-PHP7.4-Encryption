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
    public function doc2Word()
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
            /* Single article. */
            $article = $this->articles = $this->dao->select('t1.id,t1.module,t1.lib,t1.path,t1.title,t1.type,t1.parent,t1.grade,t1.`order`,t2.content,t2.files,t2.type as contentType')->from(TABLE_DOC)->alias('t1')
            ->leftJoin(TABLE_DOCCONTENT)->alias('t2')->on('t1.id=t2.doc && t1.version=t2.version')
            ->where('t1.lib')->eq($this->libID)
            ->andWhere('t1.deleted')->eq('0')
            ->andWhere('t1.type')->in('text,word,ppt,excel,url')
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
            /* All articles. */
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

    public function createTitle($module, $step, $order)
    {
        if($module->type == 'doc')
        {
            $this->section->addTitle($order . " " . $module->title, $step + 1);
            $this->section->addTextBreak(1);
        }
        elseif(in_array($module->type, array('text', 'word', 'ppt', 'excel', 'url')))
        {
            $this->createContent($this->articles[$module->parent][$module->id], $step, $order);    
        }
    }

    public function getExportData()
    {
        $this->tops = $this->dao->select('id,root as lib,path,name as title,type,parent,grade,`order`')->from(TABLE_MODULE)
            ->where('root')->eq($this->libID)
            ->andWhere('type')->eq('doc')
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->eq(0)
            ->orderBy("grade,`order`")
            ->fetchAll();

        $docTops = $this->dao->select('id, lib, path, title, type, parent, grade, `order`')->from(TABLE_DOC)
            ->where('lib')->eq($this->libID)
            ->andWhere('module')->eq('0')
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->eq(0)
            ->orderBy("grade,`order`")
            ->fetchAll();

        if(!empty($docTops)) $this->tops = array_merge($this->tops, $docTops);

        $this->moduleDB = $this->dao->select('id, root as lib, path, name as title, type, parent, grade, `order`')->from(TABLE_MODULE)
            ->where('root')->eq($this->libID)
            ->andWhere('type')->eq('doc')
            ->andWhere('deleted')->eq('0')
            ->orderBy("grade,`order`")
            ->fetchGroup('parent', 'id');

        $this->docDB = $this->dao->select('id, lib, module, path, title, type, parent, grade, acl, users, `groups`, `order`')->from(TABLE_DOC)
            ->where('lib')->eq($this->libID)
            ->andWhere('type')->in('text,word,ppt,excel,url')
            ->andWhere('deleted')->eq('0')
            ->orderBy("grade,`order`")
            ->fetchAll('id');

        /* Check doc priv. */
        $this->loadModel('doc');
        foreach($this->docDB as $docID => $doc)
        {
            if(!$this->doc->checkPrivDoc($doc)) unset($this->docDB[$docID]);
        }

        /* Make data. */
        $this->chapters = array();
        foreach($this->moduleDB as $rootID => $root)
        {
            foreach($this->docDB as $docID => $doc)
            {
                if($doc->module == $rootID)
                {
                    $tmp = new StdClass();
                    $tmp->id     = $this->docDB[$docID]->id;
                    $tmp->lib    = $this->docDB[$docID]->lib;
                    $tmp->title  = $this->docDB[$docID]->title;
                    $tmp->type   = $this->docDB[$docID]->type;
                    $tmp->parent = $this->docDB[$docID]->module;
                    $this->moduleDB[$rootID][$tmp->id] = $tmp;
                }
            }
            
            foreach($root as $subRootID => $subRoot)
            {

                foreach($this->docDB as $subDocID => $subDoc)
                {
                    if($subDoc->module == $subRootID)
                    {
                        $subtmp = new StdClass();
                        $subtmp->id     = $this->docDB[$subDocID]->id;
                        $subtmp->lib    = $this->docDB[$subDocID]->lib;
                        $subtmp->title  = $this->docDB[$subDocID]->title;
                        $subtmp->type   = $this->docDB[$subDocID]->type;
                        $subtmp->parent = $this->docDB[$subDocID]->module;
                        $this->moduleDB[$subRootID][$subtmp->id] = $subtmp;
                    }
                }
            }
        }
        
        $this->chapters = $this->moduleDB;

        $this->articles = $this->dao->select('t1.id,t1.module,t1.lib,t1.path,t1.title,t1.type,t1.parent,t1.grade,t1.`order`,t2.content,t2.files,t2.type as contentType')->from(TABLE_DOC)->alias('t1')
            ->leftJoin(TABLE_DOCCONTENT)->alias('t2')->on('t1.id=t2.doc')
            ->leftJoin(TABLE_MODULE)->alias('t3')->on('t1.module=t3.id')
            ->where('t1.lib')->eq($this->libID)
            ->andWhere('t1.deleted')->eq('0')
            ->andWhere('t1.type')->in('text,word,ppt,excel,url')
            ->beginIF($this->exportedArticle)->andWhere('t1.id')->eq($this->post->docID)->fi()
            ->orderBy("grade,`order`")
            ->fetchGroup('module', 'id');

        $files = '';
        foreach($this->articles as $parent => $articles)
        {
            foreach($articles as $articleID => $article) $files .= $article->files . ',';
        }
        if(!$this->exportedArticle)
        {
            foreach($this->tops as $docID => $doc)
            {
                if(in_array($doc->type, array('text', 'word', 'ppt', 'excel', 'url'))) $this->tops[$docID] = $this->articles[0][$doc->id];
            }
        }

        $files = array_unique(explode(',', $files));
        $this->files = $this->dao->select('id,pathname,title,extension')->from(TABLE_FILE)->where('id')->in($files)->fetchAll('id');
    }
}
