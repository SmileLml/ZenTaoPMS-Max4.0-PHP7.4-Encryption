<?php
class zentaobizFile extends fileModel
{
    public function convertOffice($file, $type = '')
    {
        if(!$this->config->file->libreOfficeTurnon) return false;

        $sofficePath = $this->config->file->sofficePath;
        if(empty($sofficePath) or !file_exists($sofficePath)) return false;

        $fileName = basename($file->realPath);
        if(($position = strpos($fileName, ".{$file->extension}")) !== false) $fileName = substr($fileName, 0, $position);
        $convertPath = $this->app->getCacheRoot() . 'convertoffice/' . $fileName . $file->size;
        if(!is_dir($convertPath)) mkdir($convertPath, 0777, true);
        if(empty($type)) $type = strpos('xlsx|xls', $file->extension) !== false ? 'html' : 'pdf';
        $convertedFile = $convertPath . '/' . $fileName . '.' . $type;
        if(file_exists($convertedFile)) return  $convertedFile;

        $filterType = $type;
        if($type == 'html' and strpos('xlsx|xls', $file->extension) !== false) $filterType = 'html:"XHTML Calc File:UTF8"';
        if($type == 'txt') $filterType = 'txt:"Text (encoded):UTF8"';

        set_time_limit(0);
        session_write_close();

        $lockFile = dirname($convertPath) . '/lock';
        if(file_exists($lockFile) and (time() - filemtime($lockFile)) <= 60 * 30) return false;

        touch($lockFile);
        ob_start();
        if(strtoupper(PHP_OS) == 'WINNT')
        {
            $cmd = "SET HOME=" . dirname($convertPath) . "\n $sofficePath --invisible --headless --convert-to $filterType --outdir $convertPath {$file->realPath} 2>&1";
            $batFile = $convertPath . '/' . $fileName . '.bat';
            file_put_contents($batFile, $cmd);
            echo system("start /b $batFile", $result);
            unlink($batFile);
        }
        else
        {
            echo system("HOME=" . dirname($convertPath) . ";export HOME;$sofficePath --invisible --headless --convert-to $filterType --outdir $convertPath {$file->realPath} 2>&1", $return);
        }
        $message = ob_get_contents();
        ob_end_clean();
        unlink($lockFile);

        if(!file_exists($convertedFile))
        {
            $this->app->saveError('E_LIBREOFFICE', $message, __FILE__, __LINE__);
            return false;
        }

        if($type == 'html')
        {
            $handle = fopen($convertedFile, "r");
            $processedLines = '';
            if($handle)
            {
                while(!feof($handle))
                {
                    $line = fgets($handle);
                    if(strpos($line, '</head><body') !== false) $line = preg_replace('/<\/head><body [^>]*>.*<table/Ui', "</head><body><table", $line);
                    $processedLines .= $line;
                }
                fclose($handle);
            }
            if($processedLines)file_put_contents($convertedFile, $processedLines);
        }

        return $convertedFile;
    }

    public function getCollaboraDiscovery($collaboraPath = '')
    {
        if(empty($collaboraPath) and !empty($this->config->file->collaboraPath)) $collaboraPath = $this->config->file->collaboraPath;
        if(empty($collaboraPath)) return array();

        $discovery = commonModel::http(trim($collaboraPath, '/') . '/hosting/discovery');
        preg_match_all('|<action(.+)/>|', $discovery, $results);

        $files = array();
        foreach($results[1] as $key => $action)
        {
            preg_match_all('|ext="([^"]*)"|', $action, $output);
            if($output[1]) $extension = $output[1][0];
            if(empty($extension)) continue;

            preg_match_all('|name="([^"]*)"|', $action, $output);
            if($output[1]) $name = $output[1][0];

            preg_match_all('|urlsrc="([^"]*)"|', $action, $output);
            if($output[1]) $urlsrc = $output[1][0];

            $files[$extension]['action'] = $name;
            $files[$extension]['urlsrc'] = $urlsrc;
        }
        return $files;
    }

    public function getFileInfo4Wopi($file, $canEdit = false)
    {
        $fileInfo = array();
        if(file_exists($file->realPath))
        {
            $contents = file_get_contents($file->realPath);
            $SHA256   = base64_encode(hash('sha256', $contents, true));

            $fileName = $file->title;
            if(!preg_match("/\.{$file->extension}$/", $fileName)) $fileName .= '.' . $file->extension;

            $fileInfo['BaseFileName']    = $fileName;
            $fileInfo['OwnerId']         = $file->addedBy;
            $fileInfo['UserId']          = $this->app->user->account;
            $fileInfo['UserFriendlyName']= $this->app->user->realname;
            $fileInfo['Size']            = filesize($file->realPath);
            $fileInfo['SHA256']          = $SHA256;
            $fileInfo['UserCanWrite']    = $canEdit;
            $fileInfo['LastModifiedTime']= date('Y-m-d\TH:i:s\Z', filemtime($file->realPath));
        }

        return json_encode($fileInfo);
    }
}
