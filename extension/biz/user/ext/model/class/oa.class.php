<?php
class oaUser extends userModel
{
    public function getDeptPairs($params = '', $dept = '')
    {
        $users = $this->dao->select('account, realname')->from(TABLE_USER)
            ->where(1)
            ->beginIF(strpos($params, 'nodeleted') !== false)->andWhere('deleted')->eq('0')->fi()
            ->beginIF($dept != 0)->andWhere('dept')->in($dept)->fi()
            ->orderBy('id_asc')
            ->fetchPairs();

        foreach($users as $account => $realname) if($realname == '') $users[$account] = $account;

        /* Append empty users. */
        if(strpos($params, 'noempty') === false) $users = array('' => '') + $users;
        if(strpos($params, 'noclosed') === false) $users = $users + array('closed' => 'Closed');

        return $users;
    }

    public function getUser($account)
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->beginIF(validater::checkEmail($account))->where('email')->eq($account)->fi()
            ->beginIF(!validater::checkEmail($account))->where('account')->eq($account)->fi()
            ->andWhere('deleted')->eq('0')
            ->fetch('', false);
    }

    public function getUserManagerPairs()
    {
        return $this->dao->select('t1.account, t2.manager')->from(TABLE_USER)->alias('t1')
            ->leftJoin(TABLE_DEPT)->alias('t2')->on('t1.dept=t2.id')
            ->where('t1.deleted')->eq('0')
            ->fetchPairs();
    }
}
