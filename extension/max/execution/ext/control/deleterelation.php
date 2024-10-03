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
class execution extends control
{
    public function deleteRelation($id, $executionID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->execution->gantt->confirmDelete, inlink('deleteRelation', "id=$id&executionID=$executionID&confirm=yes")));
        }
        else
        {
            $this->execution->deleteRelation($id);
            die(js::locate(inlink('relation', "executionID=$executionID"), 'parent'));
        }
    }
}
