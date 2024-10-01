<?php
if($this->config->edition != 'open' and !empty($_POST))
{
    $rndUserLimit  = $this->getBizUserLimit('user');
    $liteUserLimit = $this->getBizUserLimit('lite');
    if($rndUserLimit)
    {
        $rndCount = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->andWhere('visions')->ne('lite')
            ->fetch('count');
        $maxRND = $rndCount >= $rndUserLimit;
    }

    if($liteUserLimit)
    {
        $liteCount = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->andWhere('visions')->eq('lite')
            ->fetch('count');
        $liteMaxUsers = $liteCount >= $liteUserLimit;
    }

    foreach($this->post->add as $i => $add)
    {
        if(empty($add)) continue;

        if(isset($_POST['visions'][$i]) and join(',', $this->post->visions[$i]) != 'lite')
        {
            if(!$maxRND)
            {
                $rndCount++;
                if($rndCount >= $rndUserLimit) $maxRND = true;
            }
            else
            {
                $_POST['add'][$i] = '';
            }
        }

        if(isset($_POST['visions'][$i]) and join(',', $this->post->visions[$i]) == 'lite')
        {
            if(!$liteMaxUsers)
            {
                $liteCount++;
                if($liteCount >= $liteUserLimit) $liteMaxUsers = true;
            }
            else
            {
                $_POST['add'][$i] = '';
            }
        }
    }
}
