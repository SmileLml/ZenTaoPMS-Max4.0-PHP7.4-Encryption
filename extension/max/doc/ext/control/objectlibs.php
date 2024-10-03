<?php
class myDoc extends doc
{

    /**
     * Show libs for product or project.
     *
     * @param  string $type
     * @param  int    $objectID  projectID|productID
     * @param  int    $libID
     * @param  int    $docID
     * @param  int    $version
     * @param  int    $appendLib
     * @access public
     * @return void
     */
    public function objectLibs($type, $objectID = 0, $libID = 0, $docID = 0, $version = 0, $appendLib = 0)
    {
        $this->view->practiceApprovers  = $this->loadModel('assetlib')->getApproveUsers('practice');
        $this->view->componentApprovers = $this->loadModel('assetlib')->getApproveUsers('component');
        $this->view->practiceLibs       = $this->assetlib->getPairs('practice');
        $this->view->componentLibs      = $this->assetlib->getPairs('component');
        parent::objectLibs($type, $objectID, $libID, $docID, $version, $appendLib);
    }
}
