<?php
helper::importControl('user');
class myuser extends user
{
    public function create($deptID = 0)
    {
        if($this->config->edition != 'open' and !defined('TUTORIAL'))
        {
            $type = $this->config->vision == 'rnd' ? 'user' : 'lite';
            if(isset($_POST['visions'])) $type = join(',', $_POST['visions']) == 'lite' ? 'lite' : 'user';
            $maxRND   = $this->user->checkBizUserLimit('user');
            $maxLites = $this->user->checkBizUserLimit('lite');
            if($maxRND and $maxLites)
            {
                $notice = $type == 'lite' ? $this->lang->user->noticeFeedbackUserLimit : $this->lang->user->noticeUserLimit;

                if(!empty($_POST)) return $this->send(array('result' => 'fail', 'message' => $notice));

                echo js::alert($notice);
                echo js::locate('back');
                return;
            }

            $this->view->userAddWarning = $this->user->getAddUserWarning(1);

            if($_POST)
            {
                if(in_array('rnd', $this->post->visions) and $maxRND) return $this->send(array('result' => 'fail', 'message' => $this->lang->user->noticeUserLimit));
                if($this->post->visions[0] == 'lite' and $maxLites) return $this->send(array('result' => 'fail', 'message' => $this->lang->user->noticeFeedbackUserLimit));
            }
        }
        return parent::create($deptID);
    }
}
