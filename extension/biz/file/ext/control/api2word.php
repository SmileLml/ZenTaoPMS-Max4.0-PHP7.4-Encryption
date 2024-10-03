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
    public function api2Word()
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

            $this->section->addTitle($headerName, 1);
            $this->section->addTextBreak(2);
        }

        if($_POST['scope'] == 'single')
        {
            // Single article
            $article = $this->articles = $this->dao->select('api.*,doc.name as libName,module.name as moduleName')->from(TABLE_API)->alias('api')
                ->leftJoin(TABLE_DOCLIB)->alias('doc')->on('api.lib = doc.id')
                ->leftJoin(TABLE_MODULE)->alias('module')->on('api.module = module.id')
                ->where('api.id')->eq($this->post->apiID)
                ->fetch();

            $article = $this->loadModel('api')->buildExportAPI($article);
            $this->createContent($article, 1, '');
        }
        else
        {
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

    public function createTitle($module, $step, $order)
    {
        if($module->type == 'api')
        {
            $this->section->addTitle($order . " " . $module->title, $step + 1);
            $this->section->addTextBreak(1);
        }
        elseif($module->type == 'article')
        {
            $this->createContent($this->articles[$module->parent][$module->id], $step, $order);
        }
    }

    public function getExportData()
    {
        $this->tops = $this->dao->select('id,root as lib,path,name as title,type,parent,grade,`order`')->from(TABLE_MODULE)
            ->where('root')->eq($this->post->libID)
            ->andWhere('type')->eq('api')
            ->andWhere('deleted')->eq('0')
            ->andWhere('parent')->eq(0)
            ->orderBy("grade,`order`")
            ->fetchAll();

        /* Make data. */
        $this->articles = $this->dao->select('api.*,doc.name as libName,module.name as moduleName')->from(TABLE_API)->alias('api')
            ->leftJoin(TABLE_DOCLIB)->alias('doc')->on('api.lib = doc.id')
            ->leftJoin(TABLE_MODULE)->alias('module')->on('api.module = module.id')
            ->where('api.lib')->eq($this->post->libID)
            ->fetchGroup('module', 'id');

        $this->loadModel('api');
        $this->chapters = array();
        foreach($this->articles as $parent => $articles)
        {
            foreach($articles as $articleID => $article)
            {
                $article = $this->api->buildExportAPI($article);
                $article->type = 'article';
                $article->parent = $parent;

                $this->chapters[$parent][$article->id] = $article;
            }
        }
    }
}
