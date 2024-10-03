<?php
class feedbackUser extends userModel
{
    /**
     * Get has feedback priv.
     *
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getHasFeedbackPriv($pager = null)
    {
        $groups = $this->dao->select('`group`')->from(TABLE_GROUPPRIV)->where('module')->eq('feedback')->andWhere('method')->eq('create')->fetchPairs('group', 'group');
        return $this->dao->select('distinct t1.account,t1.realname,t1.feedback')->from(TABLE_USER)->alias('t1')
            ->leftJoin(TABLE_USERGROUP)->alias('t2')->on('t1.account=t2.account')
            ->where('t1.deleted')->eq(0)
            ->andWhere('t1.visions', true)->eq('lite')
            ->orWhere('t2.`group`')->in($groups)
            ->markRight(1)
            ->andWhere('t1.account')->notIN(trim($this->app->company->admins, ','))
            ->orderBy('t1.account')
            ->page($pager, 't1.account')
            ->fetchAll('account');
    }

    /**
     * Get user pairs.
     *
     * @param  string $params
     * @param  string $usersToAppended
     * @param  int    $maxCount
     * @param  string $accounts
     * @access public
     * @return array
     */
    public function getPairs($params = '', $usersToAppended = '', $maxCount = 0, $accounts = '')
    {
        if(defined('TUTORIAL')) return $this->loadModel('tutorial')->getUserPairs();
        /* Set the query fields and orderBy condition.
         *
         * If there's xxfirst in the params, use INSTR function to get the position of role fields in a order string,
         * thus to make sure users of this role at first.
         */
        $fields = 'id, account, realname, deleted';
        $type   = (strpos($params, 'outside') === false) ? 'inside' : 'outside';
        if(strpos($params, 'pofirst') !== false) $fields .= ", INSTR(',pd,po,', role) AS roleOrder";
        if(strpos($params, 'pdfirst') !== false) $fields .= ", INSTR(',po,pd,', role) AS roleOrder";
        if(strpos($params, 'qafirst') !== false) $fields .= ", INSTR(',qd,qa,', role) AS roleOrder";
        if(strpos($params, 'qdfirst') !== false) $fields .= ", INSTR(',qa,qd,', role) AS roleOrder";
        if(strpos($params, 'pmfirst') !== false) $fields .= ", INSTR(',td,pm,', role) AS roleOrder";
        if(strpos($params, 'devfirst')!== false) $fields .= ", INSTR(',td,pm,qd,qa,dev,', role) AS roleOrder";
        $orderBy = strpos($params, 'first') !== false ? 'roleOrder DESC, account' : 'account';

        $keyField = strpos($params, 'useid') !== false ? 'id' : 'account';

        /* Get raw records. */
        $this->app->loadConfig('user');
        unset($this->config->user->moreLink);

        $users = $this->dao->select($fields)->from(TABLE_USER)
            ->where('1')
            ->beginIF(strpos($params, 'all') === false)->andWhere('type')->eq($type)->fi()
            ->beginIF($accounts)->andWhere('account')->in($accounts)->fi()
            ->beginIF(strpos($params, 'nodeleted') !== false or empty($this->config->user->showDeleted))->andWhere('deleted')->eq('0')->fi()
            ->beginIF(strpos($params, 'nofeedback') !== false)->andWhere('visions')->ne('lite')->fi()
            ->beginIF($accounts)->andWhere('account')->in($accounts)->fi()
            ->beginIF($this->config->vision and !in_array($this->app->rawModule, array('kanban', 'feedback')))->andWhere("CONCAT(',', visions, ',')")->like("%,{$this->config->vision},%")->fi()
            ->orderBy($orderBy)
            ->beginIF($maxCount)->limit($maxCount)->fi()
            ->fetchAll($keyField);

        if($maxCount and $maxCount == count($users))
        {
            if(is_array($usersToAppended)) $usersToAppended = join(',', $usersToAppended);
            $moreLinkParams = "params={$params}&usersToAppended={$usersToAppended}";

            $moreLink  = helper::createLink('user', 'ajaxGetMore');
            $moreLink .= strpos($moreLink, '?') === false ? '?' : '&';
            $moreLink .= "params=" . base64_encode($moreLinkParams);
            $this->config->user->moreLink = $moreLink;
        }

        if($usersToAppended) $users += $this->dao->select($fields)->from(TABLE_USER)->where('account')->in($usersToAppended)->fetchAll($keyField);

        /* Cycle the user records to append the first letter of his account. */
        foreach($users as $account => $user)
        {
            if(strpos($params, 'showid') !== false)
            {
                $users[$account] = $user->id;
            }
            else
            {
                $firstLetter = ucfirst(mb_substr($user->account, 0, 1)) . ':';
                if(strpos($params, 'noletter') !== false or !empty($this->config->isINT)) $firstLetter = '';
                $users[$account] =  $firstLetter . (($user->deleted and strpos($params, 'realname') === false) ? $user->account : ($user->realname ? $user->realname : $user->account));
            }
        }

        /* Append empty, closed, and guest users. */
        if(strpos($params, 'noempty')   === false) $users = array('' => '') + $users;
        if(strpos($params, 'noclosed')  === false) $users = $users + array('closed' => 'Closed');
        if(strpos($params, 'withguest') !== false) $users = $users + array('guest' => 'Guest');

        return $users;
    }

    /**
     * Get product users from user view.
     *
     * @param  int    $productID
     * @access public
     * @return array
     */
    public function getProductViewUsers($productID)
    {
        return $this->dao->select('account')->from(TABLE_USERVIEW)->where("CONCAT(',', `products`, ',')")->like("%,{$productID},%")->fetchPairs('account', 'account');
    }
}
