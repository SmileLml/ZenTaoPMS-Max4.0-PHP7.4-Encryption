<?php
helper::importControl('user');
class myuser extends user
{
    public function batchCreate($deptID = 0)
    {
        $properties = array();
        if(function_exists('ioncube_license_properties')) $properties = ioncube_license_properties();
        if($this->config->edition != 'open' and isset($properties['user']))
        {
            $rndCount  = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)->where('deleted')->eq(0)->andWhere('visions')->like('%rnd%')->fetch('count');
            $liteCount = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)->where('deleted')->eq(0)->andWhere('visions')->eq('lite')->fetch('count');
            $maxRND    = $properties['user']['value'] <= $rndCount;
            $maxLites  = $properties['lite']['value'] <= $liteCount;
            if($maxRND and $maxLites and $this->config->vision == 'rnd')
            {
                echo js::alert($this->lang->user->noticeUserLimit);
                echo js::locate('back');
                return;
            }
            if($maxLites and $maxRND and $this->config->vision == 'lite')
            {
                echo js::alert($this->lang->user->noticeFeedbackUserLimit);
                echo js::locate('back');
                return;
            }

            $this->view->userAddWarning = $this->user->getAddUserWarning(10);

            if($_POST)
            {
                foreach($this->post->account as $i => $account)
                {
                    if(empty($account)) continue;
                    if(join(',', $_POST['visions'][$i]) == 'ditto') $_POST['visions'][$i] = $_POST['visions'][($i - 1)];
                    if(join(',', $_POST['visions'][$i]) != 'lite')
                    {
                        if(!$maxRND)
                        {
                            $rndCount++;
                            if($properties['user']['value'] <= $rndCount) $maxRND = true;
                        }
                        else
                        {
                            $_POST['account'][$i] = '';
                        }
                    }

                    if(join(',', $_POST['visions'][$i]) == 'lite')
                    {
                        if(!$maxLites)
                        {
                            $liteCount++;
                            if($properties['lite']['value'] <= $liteCount) $maxLites = true;
                        }
                        else
                        {
                            $_POST['account'][$i] = '';
                        }
                    }
                }
            }
        }

        $this->view->properties = $properties;
        return parent::batchCreate($deptID);
    }
}
