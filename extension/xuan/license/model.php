<?php
/**
 * The model file of license module of XXB.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     license
 * @version     $Id: model.php 4145 2016-10-14 05:31:16Z liugang $
 * @link        https://xuanim.com
 */
?>
<?php
class licenseModel extends model
{
    /**
     * Get license information
     *
     * @access public
     * @return object
     */
    public function getLisenceInfo()
    {
        $properties = commonModel::getLicenseProperties();
        $info       = new stdClass();

        if($properties === false)
        {
            $info->status = 'unavailable';
        }
        else
        {
            foreach($properties as $propertyName => $perperty)
            {
                $info->$propertyName = $perperty['value'];
            }
            $info->status = $this->getLisenceStatus($info->startDate, $info->expireDate);
            if($info->expireDate == 'All Life') $info->expireDate = '';
        }

        $info->effective = $info->status == 'effective';
        $info->expired   = $info->status == 'expired';
        $info->waiting   = $info->status == 'waiting';
        $info->avaliable = $info->status != 'unavailable';

        return $info;
    }

    /**
     * Get lisence status by given start date and expire date
     *
     * @access public
     * @return string Possible status include: 'waiting', 'effective', 'expired'
     */
    public function getLisenceStatus($startDate, $expireDate)
    {
        if((empty($startDate) && empty($expireDate)) || $expireDate == 'All Life') return 'effective';

        $nowDate = date('Y-m-d', strtotime(helper::now()));
        if(!empty($startDate)) $startDate = date('Y-m-d', strtotime($startDate));
        if(!empty($expireDate)) $expireDate = date('Y-m-d', strtotime($expireDate));

        if(!empty($startDate) && $startDate > $nowDate) return 'waiting';
        if(!empty($expireDate) && $expireDate < $nowDate) return 'expired';
        return 'effective';
    }

    /**
     * Extract uploaded license package.
     *
     * @param  string    $package
     * @access public
     * @return void
     */
    public function extractLicense($package)
    {
        $this->app->loadClass('pclzip', true);

        $zip   = new pclzip($package);
        $files = $zip->listContent();

        $licenseExists = false;
        foreach($files as $file)
        {
            if($file['filename'] == 'xxb/config/license/xxb.php') $licenseExists = true;
        }
        if(!$licenseExists) return array('result' => 'fail', 'message' => $this->lang->license->error->badPackage);

        $packagePath = $this->app->getTmpRoot() . 'license' . DS . basename($package);
        $licenseFile = $packagePath . DS . 'config' . DS . 'license' . DS . 'xxb.php';
        $removePath  = $files[0]['filename'];

        if($zip->extract(PCLZIP_OPT_PATH, $packagePath, PCLZIP_OPT_REMOVE_PATH, $removePath) == 0) return array('result' => 'success', 'message' => $zip->errorInfo(true));

        $licenseRoot = $this->app->getConfigRoot() . 'license' . DS;
        $result      = copy($licenseFile, $licenseRoot . 'xxb.php');
        if($result) return array('result' => 'success', 'message' => $this->lang->setSuccess);

        return array('result' => 'fail', 'message' => $this->lang->license->error->copyFail, 'locate' => helper::createLink('license', 'uploadlicense'));
    }
}
