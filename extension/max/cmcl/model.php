<?php
/**
 * The model file of cmcl module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2020 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Qiyu Xie <xieqiyu@easycorp.ltd>
 * @package     cmcl
 * @version     $Id: model.php 5107 2020-09-09 09:46:12Z xieqiyu@easycorp.ltd $
 * @link        http://www.zentao.net
 */
class cmclModel extends model
{
    /**
     * Update a cmcl.
     *
     * @param  int    $cmclID
     * @access public
     * @return array|bool
     */
    public function update($cmclID)
    {
        $oldCmcl = $this->getByID($cmclID);

        $cmcl = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', helper::today())
            ->get();

        $this->dao->update(TABLE_CMCL)->data($cmcl)->autoCheck()->where('id')->eq((int)$cmclID)->exec();

        if(!dao::isError()) return common::createChanges($oldCmcl, $cmcl);
        return false;
    }

    /**
     * Batch create cmcl.
     *
     * @access public
     * @return bool
     */
    public function batchCreate()
    {
        $data = fixer::input('post')->get();

        $this->loadModel('action');
        foreach($data->title as $i => $title)
        {
            if(!$title && !$data->type[$i]) continue; 

            $cmcl = new stdclass();
            $cmcl->title       = $title;
            $cmcl->type        = $data->type[$i];
            $cmcl->contents    = $data->contents[$i];
            $cmcl->createdBy   = $this->app->user->account;
            $cmcl->createdDate = helper::today();

            $this->dao->insert(TABLE_CMCL)->data($cmcl)->autoCheck()->exec();

            $cmclID = $this->dao->lastInsertID();
            $this->action->create('cmcl', $cmclID, 'Opened');
        }

        return true;
    }

    /**
     * Get cmcl list.
     *
     * @param  string $browseType
     * @param  string $orderBy
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getList($browseType = 'all', $orderBy = 'id_desc', $pager = null)
    {
        $browseType = strtolower($browseType);
        return $this->dao->select('*')->from(TABLE_CMCL)
            ->where('deleted')->eq(0)
            ->beginIF($browseType != 'all')->andWhere('type')->eq($browseType)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchGroup('type');
    }

    /**
     * Get cmcl by list.
     *
     * @param  string $idList
     * @access public
     * @return array
     */
    public function getByList($idList)
    {
        return $this->dao->select('id, contents')->from(TABLE_CMCL)
            ->where('deleted')->eq(0)
            ->andWhere('id')->in($idList)
            ->fetchPairs(); 
    }

    /**
     * Get cmcl by id.
     *
     * @param  string $listID
     * @access public
     * @return array
     */
    public function getByID($cmclID = 0)
    {
        return $this->dao->select('*')->from(TABLE_CMCL)
            ->Where('id')->eq($cmclID)
            ->andWhere('deleted')->eq(0)
            ->fetch();
    }
}
