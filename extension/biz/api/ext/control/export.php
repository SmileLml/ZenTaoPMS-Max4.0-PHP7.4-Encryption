<?php
class api extends control
{
    public function export($apiID, $version = 0, $release = 0)
    {
        $api   = $this->api->getLibById($apiID, $version, $release);
        $libID = $api->lib;

        if($_POST)
        {
            $this->post->set('libID', $libID);
            $this->post->set('apiID', $apiID);
            $this->post->set('kind', 'api');
            return $this->fetch('file', 'api2Word', $_POST);
        }

        $this->app->loadLang('file');

        $libs = $this->loadModel('doc')->getApiLibs();
        $lib  = zget($libs, $libID, array());

        $this->view->title    = $this->lang->export;
        $this->view->fileName = zget($lib, 'name', '');
        $this->view->apiID    = $apiID;
        $this->display();
    }
}
