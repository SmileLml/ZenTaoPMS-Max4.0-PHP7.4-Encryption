<?php
/**
 * The control file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     execution
 * @version     $Id$
 * @link        http://www.zentao.net
 */
public function computeTaskEffort()
{
    return $this->loadExtension('effort')->computeTaskEffort();
}

public function getTaskEffort($execution = '')
{
    return $this->loadExtension('effort')->getTaskEffort($execution);
}
