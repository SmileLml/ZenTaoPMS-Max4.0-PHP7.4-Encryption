<?php
class zentaobizUser extends userModel
{
    public function checkBizUserLimit($type = 'user')
    {
        if(!function_exists('ioncube_license_properties')) return false;

        $properties = ioncube_license_properties();
        if(empty($properties[$type]['value'])) return false;

        $user = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->beginIF($type == 'user')->andWhere("visions")->like('%rnd%')->fi()
            ->beginIF($type == 'lite')->andWhere("visions")->eq('lite')->fi()
            ->fetch();
        return $user->count >= $properties[$type]['value'];
    }

    public function getBizUserLimit($type = 'user')
    {
        if(!function_exists('ioncube_license_properties')) return false;

        $properties = ioncube_license_properties();
        if(empty($properties[$type]['value'])) return false;

        return $properties[$type]['value'];
    }

    /**
     * Get add user waring by limit number.
     *
     * @param int $limit
     * @access public
     * @return void
     */
    public function getAddUserWarning($limit)
    {
        if(!function_exists('ioncube_license_properties')) return false;

        $properties = ioncube_license_properties();
        if(empty($properties['user']['value'])) return false;

        $rndCount  = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)->where('deleted')->eq(0)->andWhere('visions')->like('%rnd%')->fetch('count');
        $liteCount = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)->where('deleted')->eq(0)->andWhere('visions')->eq('lite')->fetch('count');

        $userAddWarning = '';
        $leftRND  = $properties['user']['value'] - $rndCount;
        $leftLite = $properties['lite']['value'] - $liteCount;
        if($leftRND >= $limit and $leftLite < $limit)
        {
            $userAddWarning = sprintf($this->lang->user->liteUserAddWarning, $leftLite);
        }
        elseif($leftLite >= $limit and $leftRND < $limit)
        {
            $userAddWarning = sprintf($this->lang->user->rndUserAddWarning, $leftRND);
        }
        elseif($leftRND < $limit and $leftLite < $limit)
        {
            $userAddWarning = sprintf($this->lang->user->userAddWarning, $leftRND, $leftLite);
        }

        return $userAddWarning;
    }
}
