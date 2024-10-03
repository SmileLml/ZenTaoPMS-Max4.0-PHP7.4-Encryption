<?php
class exportbase extends control
{
    /**
     * Init for word
     *
     * @access public
     * @return void
     */
    public function init()
    {
        // post content: kind(string), exportFields(array), fields(array), rows(array), tableName(string), style(array), header(array).
        $this->app->loadClass('phpword', true);
        $this->kind            = $this->post->kind;
        $this->libID           = $this->post->libID;
        $this->docID           = $this->post->docID;
        $this->exportedChapter = $this->post->chapter;
        $this->exportedArticle = $this->post->currentArticle == 'current' && $this->post->docID;
        $this->phpWord         = new \PhpOffice\PhpWord\PhpWord();
        $this->htmlDom         = new simple_html_dom();
        $this->section         = $this->phpWord->addSection();
        $this->exportFields    = $this->config->word->{$this->kind}->exportFields;
        $this->host            = 'http://' . $this->server->http_host;
        foreach($this->config->word->size->titles as $id => $title) $this->addTitleStyle($id);

        $this->loadModel('file');
        $this->filePath = $this->file->savePath;
        $this->sysURL   = common::getSysURL();
        $this->order    = 0;

        $this->phpWord->addParagraphStyle('pStyle', array('spacing' => 100));
        $this->initialState = array(
            'phpword_object' => &$this->phpWord,
            'base_root' => $this->host,
            'base_path' => '/',

            'current_style' => array('size' => '11'),
            'parents' => array(0 => 'body'),
            'list_depth' => 0,
            'context' => 'section',
            'pseudo_list' => TRUE,
            'pseudo_list_indicator_font_name' => 'Wingdings',
            'pseudo_list_indicator_font_size' => '7',
            'pseudo_list_indicator_character' => 'l',
            'table_allowed' => TRUE,
            'treat_div_as_paragraph' => TRUE,

            'style_sheet' => htmltodocx_styles_example()
        );

        //打开时自动重新计算字段
        if(!$this->exportedArticle) $this->phpWord->getSettings()->setUpdateFields(true);

        //关闭拼写和语法检查，大内容文档可以提高打开速度
        $this->phpWord->getSettings()->setHideGrammaticalErrors(true);
        $this->phpWord->getSettings()->setHideSpellingErrors(true);

        //文档设置
        // $properties = $this->phpWord->getDocInfo();
        // $properties->setCreator('zentao');//作者
        // $properties->setTitle('title');//标题
        // $properties->setSubject('subject');//主题

        //设置页码
        $footer = $this->section->addFooter();
        $footer->addPreserveText('{PAGE} / {NUMPAGES}', [
            'bold' => true,//粗体
        ], [
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END,//对其方式
        ]);

        unset($_GET['onlybody']);
    }

    public function createWord($module, $step = 1, $order = 0)
    {
        $this->createTitle($module, $step, $order);
        if(isset($this->chapters[$module->id]) and $module->type != 'article')
        {
            foreach($this->chapters[$module->id] as $subModule)
            {
                $order = $this->getNextOrder($this->order, $step + 1);
                $this->createWord($subModule, $step + 1, $order);
            }
        }
    }

    public function createTitle($module, $step, $order)
    {
        if($module->type == 'chapter')
        {
            $this->section->addTitle($order . " " . $module->title, $step + 1);
            $this->section->addTextBreak(1);
        }
        elseif($module->type == 'article')
        {
            $this->createContent($this->articles[$module->parent][$module->id], $step, $order);
        }
    }

    public function createContent($article, $step, $order)
    {
        if(empty($article)) return;
        $content  = $article;

        foreach($this->exportFields as $exportField)
        {
            $fieldName = $exportField;
            $style = zget($this->config->word->{$this->kind}->style, $exportField, '');

            if($style == 'title')
            {
                $fieldContent = $order . ' ' . $content->$fieldName;
                $this->section->addTitle($fieldContent, $step + 1);
                $this->section->addTextBreak();
            }
            elseif($style == 'showImage')
            {
                $fieldContent = isset($content->$fieldName) ? $content->$fieldName : '';
                if(empty($fieldContent)) continue;

                $fieldContent = preg_replace_callback('/<img(.+)src\s*=\s*[\"\']([^\"\']+)[\"\'](.*)\/>/Ui', array(&$this, 'checkFileExist'), $content->$fieldName);
                if(preg_match('/^[a-z0-9]+/', $fieldContent)) $fieldContent = "<br />" . $fieldContent;

                /* Process special character */
                $fieldContent = html_entity_decode($fieldContent);
                $fieldContent = str_replace('&', '', $fieldContent);

                /* Process markdown */
                if(isset($article->contentType) && $article->contentType == 'markdown')
                {
                    $fieldContent = commonModel::processMarkdown($fieldContent);
                    $fieldContent = preg_replace('/th>/i', 'td>', $fieldContent);
                    $fieldContent = preg_replace('/<tbody>|<\/tbody>/i', '', $fieldContent);
                    $fieldContent = preg_replace('/<thead>|<\/thead>/i', '', $fieldContent);
                }

                $this->htmlDom->load('<html><body>' . $fieldContent . '</body></html>');
                $htmlDomArray = $this->htmlDom->find('html',0)->children();
                htmltodocx_insert_html($this->section, $htmlDomArray[0]->nodes, $this->initialState);
                $this->htmlDom->clear();
                $this->section->addTextBreak();
            }
            elseif($fieldName == 'files')
            {
                $this->formatFiles($content);
            }
            else
            {
                $textRun = $this->section->createTextRun('pStyle');
                $textRun->addText($this->fields[$fieldName] . "：", array('bold' => true));
                $textRun->addText($content->$fieldName, null);
            }
        }
        $this->section->addTextBreak();
    }

    public function formatFiles($content)
    {
        if(empty($content->files)) return;
        $this->section->addText($this->lang->word->fileField . ':', array('bold' => true));

        $fileIdList = explode(',', $content->files);
        foreach($fileIdList as $fileID)
        {
            if(empty($fileID)) continue;
            if(!isset($this->files[$fileID])) continue;

            $file = $this->files[$fileID];
            if(in_array($file->extension, $this->config->word->imageExtension))
            {
                if(!file_exists($this->filePath . $file->pathname)) continue;
                $inf = pathinfo($file->pathname);
                if(!isset($inf['extension']) or strtolower($file->extension) != strtolower($inf['extension'])) $file->pathname .= ".{$file->extension}";
                $this->section->addImage($this->filePath . $file->pathname);
                $this->section->addTextBreak();
            }
            else
            {
                $inf = pathinfo($file->title);
                if(!isset($inf['extension']) or strtolower($file->extension) != strtolower($inf['extension'])) $file->title .= ".{$file->extension}";
                $this->section->addLink($this->sysURL . $this->createLink('file', 'download', "fileID={$file->id}", 'html'), $file->title, array('color' => '0000FF', 'underline' => \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE));
            }
        }
    }

    public function addTitleStyle($step)
    {
        $size = isset($this->config->word->size->titles[$step]) ? $this->config->word->size->titles[$step] : 12;
        $this->phpWord->addTitleStyle($step, array('size'=> $size, 'color'=>'010101', 'bold'=>true));
    }

    public function getNextOrder($order, $step)
    {
        $orders = explode('.', $order);
        if(count($orders) + 1 == $step)
        {
            $order .= '.1';
        }
        elseif(count($orders) + 1 > $step)
        {
            $orders[$step - 1] += 1;
            $orders = array_slice($orders, 0, $step);
            $order = join('.', $orders);
        }
        else
        {
            $orders[count($orders) - 1] = end($orders) + 1;
            $order = join('.', $orders);
        }
        $this->order = $order;
        return $order;
    }

    public function checkFileExist($matches)
    {
        $filePath     = $this->app->getWwwRoot();
        $realFilePath = $filePath . strstr($matches[2], 'data');
        if(is_file($realFilePath)) return "<img{$matches[1]}src=\"{$matches[2]}\"{$matches[3]}/>";

        preg_match_all('/^{(\d+)\.\w+}$/', $matches[2], $out);
        if($out[0])
        {
            $file = $this->file->getById($out[1][0]);

            $realFilePath = $this->loadModel('file')->saveAsTempFile($file); // Download file from OSS server, and save to data/upload/.
            if(file_exists($realFilePath))
            {
                $webPath = substr($file->webPath, strlen($this->config->webRoot));
                return "<img{$matches[1]}src=\"{$webPath}\"{$matches[3]}/>";
            }
        }

        $parsedURL = parse_url(htmlspecialchars_decode($matches[2]));
        if(isset($parsedURL['query']))
        {
            parse_str($parsedURL['query'], $parsedQuery);
            if(isset($parsedQuery['pathname']))
            {
                $pathname = $parsedQuery['pathname'];
                $realFilePath = $this->file->savePath . $pathname;
                $webPath      = $this->file->webPath . $pathname;
                if(file_exists($realFilePath))
                {
                    $webPath = str_replace($this->config->webRoot, '', $webPath);
                    return "<img{$matches[1]}src=\"{$webPath}\"{$matches[3]}/>";
                }

                $pathname = substr($pathname, 0, strrpos($pathname, '.'));
                $realFilePath = $this->file->savePath . $pathname;
                $webPath      = $this->file->webPath . $pathname;
                if(file_exists($realFilePath))
                {
                    $webPath = str_replace($this->config->webRoot, '', $webPath);
                    return "<img{$matches[1]}src=\"{$webPath}\"{$matches[3]}/>";
                }
            }
            if(basename($parsedURL['path']) == 'file.php')
            {
                $pathname = $parsedQuery['f'];
                if(strrpos($pathname, '.') !== false) $pathname = substr($pathname, 0, strrpos($pathname, '.'));
                $realFilePath = $this->file->savePath . $pathname;
                $webPath      = $this->file->webPath . $pathname;
                if(file_exists($realFilePath))
                {
                    $webPath = str_replace($this->config->webRoot, '', $webPath);
                    return "<img{$matches[1]}src=\"{$webPath}\"{$matches[3]}/>";
                }
            }
        }

        return '';
    }
}
