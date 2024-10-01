<?php
/**
 * The control file of license module of XXB.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Wenrui LI <liwenrui@easycorp.ltd>
 * @package     license
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php
class license extends control
{
    /**
     * Upload license.
     *
     * @access public
     * @return void
     */
    public function uploadLicense()
    {
        $configRoot  = $this->app->getConfigRoot();
        $licenseRoot = $configRoot . 'license' . DS;

        $this->view->writable    = (!is_dir($licenseRoot) or !is_writable($licenseRoot));
        $this->view->writableTip = sprintf($this->lang->license->error->licenseDir, $licenseRoot);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(empty($_FILES))  $this->send(array('result' => 'fail', 'message' => '' ));

            $tmpName     = $_FILES['file']['tmp_name'];
            $fileName    = $_FILES['file']['name'];
            $package     = basename($fileName, '.zip');
            $packagePath = $this->app->getTmpRoot() . "/package/";

            if(!is_dir($packagePath)) mkdir($packagePath, 0777, true);
            move_uploaded_file($tmpName, $packagePath . $package);

            $result = $this->license->extractLicense($packagePath . $package);

            if($result['result'] == 'success') die(js::alert($result['message']) . js::reload('parent'));
            $this->send($result);
        }

        $this->view->title = $this->lang->license->uploadLicense;
        $this->display();
    }
}
