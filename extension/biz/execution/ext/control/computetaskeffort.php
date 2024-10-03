<?php
/**
 * The control file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Guangming Sun <sunguangming@cnezsoft.com>
 * @package     execution
 * @version     $Id$
 * @link        http://www.zentao.net
 */
helper::importControl('execution');
class myexecution extends execution
{
    /**
     * TaskLeft
     *
     * @param  int    $executionID
     * @param  string $groupBy
     * @access public
     * @return void
     */
    public function computeTaskEffort($reload = 'no')
    {
        $this->execution->computeTaskEffort();
        if($reload == 'yes') die(js::reload('parent'));
        echo 'success';
    }
}
