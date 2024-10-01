<?php
class imConference extends model
{
    /**
     * Get conference by the id of chat.
     *
     * @param  string $chatID
     * @access public
     * @return object
     */
    public function getByChatID($chatID)
    {
        return $this->dao->select('*')->from(TABLE_IM_CONFERENCE)->where('cgid')->eq($chatID)->fetch();
    }

    /**
     * Get conferences by the id of chats.
     *
     * @param  array  $chatIDs
     * @access public
     * @return array
     */
    public function getByChatIDs($chatIDs)
    {
        return $this->dao->select('*')->from(TABLE_IM_CONFERENCE)
            ->where('cgid')->in($chatIDs)
            ->fetchAll();
    }

    /**
     * Get conference by the id of room.
     *
     * @param  string $roomID
     * @access public
     * @return object
     */
    public function getByRoomID($roomID)
    {
        return $this->dao->select('*')->from(TABLE_IM_CONFERENCE)->where('rid')->eq($roomID)->fetch();
    }

    /**
     * Get conference by user id.
     *
     * @param  int    $userID
     * @access public
     * @return array
     */
    public function getByUserID($userID)
    {
        $userChats = $this->loadModel('im')->chat->getListByUserID($userID);

        $chatIDs = array();
        foreach($userChats as $chat) $chatIDs[] = $chat->gid;

        return $this->getByChatIDs($chatIDs);
    }

    /**
     * Create or activate a conference.
     *
     * @param  string         $chatID
     * @param  string         $invitee
     * @param  int            $userID
     * @access public
     * @return object|boolean
     */
    public function create($chatID, $invitee, $userID)
    {
        $this->loadModel('conference');

        $date = helper::now();
        $conference = $this->getByChatID($chatID);

        if(!empty($conference)) $room = $this->conference->getRoom($conference->rid);
        if(!empty($conference) && !empty($room))
        {
            if($conference->status == 'open')
            {
                $participantAddition = $this->addParticipant($chatID, $userID);
                if(!$participantAddition) return $conference;

                $conference->participants = $participantAddition;
                $this->saveAction($conference->rid, 'join', $userID);
                return $conference;
            }
            $conference->status       = 'open';
            $conference->participants = "$userID";
            $conference->openedDate   = helper::now();
            $conference->openedBy     = $userID;
            $conference->invitee      = $invitee;
            $this->dao->update(TABLE_IM_CONFERENCE)
                ->set('status')->eq($conference->status)
                ->set('participants')->eq($conference->participants)
                ->set('openedDate')->eq($conference->openedDate)
                ->set('openedBy')->eq($conference->openedBy)
                ->set('invitee')->eq($conference->invitee)
                ->where('id')->eq($conference->id)
                ->exec();
        }
        else
        {
            $rid = str_replace('&', '-', $chatID);
            $conferenceConfig = $this->conference->getConfiguration();
            if(!isset($conferenceConfig->backendtype) || $conferenceConfig->backendtype == 'owt')
            {
                $roomInfo = $this->conference->createRoom($chatID);
                $rid = $roomInfo->id;
                if(empty($roomInfo)) return false;
            }

            $conferenceData = new stdClass();
            $conferenceData->cgid         = $chatID;
            $conferenceData->rid          = $rid;
            $conferenceData->status       = 'open';
            $conferenceData->participants = "$userID";
            $conferenceData->openedBy     = (int)$userID;
            $conferenceData->openedDate   = $date;
            $conferenceData->invitee      = $invitee;

            if(empty($conference)) $this->dao->insert(TABLE_IM_CONFERENCE)->data($conferenceData)->exec();
            else                   $this->dao->update(TABLE_IM_CONFERENCE)->data($conferenceData)->where('cgid')->eq($chatID)->exec();

            $conference = $conferenceData;
        }

        $this->saveAction($conference->rid, 'create', $userID);

        if(dao::isError()) return false;
        return $conference;
    }

    /**
     * Close a conference.
     *
     * @param  string  $chatID
     * @param  int     $userID
     * @access public
     * @return boolean
     */
    public function close($chatID, $userID)
    {
        $conference = $this->getByChatID($chatID);
        if($conference->status == 'closed') return true;

        $this->dao->update(TABLE_IM_CONFERENCE)
            ->set('status')->eq('closed')
            ->set('participants')->eq('')
            ->where('id')->eq($conference->id)
            ->exec();

        $this->saveAction($conference->rid, 'close', $userID);
        $this->loadModel('conference')->deleteRoom($conference->rid);

        return !dao::isError();
    }

    /**
     * Add invitee into a conference.
     *
     * @param  string        $chatID
     * @param  array         $newInvitee
     * @access public
     * @return string|boolean
     */
    public function addInvitee($chatID, $newInvitee) {
        $conference = $this->getByChatID($chatID);
        if($conference->status == 'closed') return false;

        $invitee = explode(',', $conference->invitee);
        $invitee = array_filter($invitee);
        $invitee = array_merge($invitee, $newInvitee);
        $invitee = array_unique($invitee);
        $invitee = implode(',', $invitee);

        $this->dao->update(TABLE_IM_CONFERENCE)
            ->set('invitee')->eq($invitee)
            ->where('id')->eq($conference->id)
            ->exec();

        if(dao::isError()) return false;
        return $invitee;
    }

    /**
     * Add participant into a conference.
     *
     * @param  string        $chatID
     * @param  int           $userID
     * @access public
     * @return string|boolean
     */
    public function addParticipant($chatID, $userID)
    {
        $conference = $this->getByChatID($chatID);
        if($conference->status == 'closed') return false;

        $participants = explode(',', $conference->participants);
        $participants = array_filter($participants);

        if(!$this->isUnlimitedParticipants() && count($participants) > 2) return false;

        $participants[] = $userID;
        $participants = array_unique($participants);
        $participants = implode(',', $participants);

        $this->dao->update(TABLE_IM_CONFERENCE)
            ->set('participants')->eq($participants)
            ->where('id')->eq($conference->id)
            ->exec();

        if(dao::isError()) return false;
        return $participants;
    }

    /**
     * Remove participant from a conference.
     *
     * @param  string        $chatID
     * @param  int           $userID
     * @access public
     * @return array|boolean
     */
    public function removeParticipant($chatID, $userID)
    {
        $conference = $this->getByChatID($chatID);
        if($conference->participants == '') return false;

        $participants = explode(',', $conference->participants);
        $participants = array_diff($participants, array($userID));
        $participants = implode(',', $participants);

        $this->dao->update(TABLE_IM_CONFERENCE)
            ->set('participants')->eq($participants)
            ->where('id')->eq($conference->id)
            ->exec();

        if(dao::isError()) return false;
        return $participants;
    }

    /**
     * Get conference actions since last close.
     *
     * @param  object $conference
     * @param  string $type
     * @access public
     * @return boolean
     */
    public function getActions($conference, $type = '')
    {
        $actions = $this->dao->select('*')->from(TABLE_IM_CONFERENCEACTION)
            ->where('rid')->eq($conference->rid)
            ->andWhere('date')->gt($conference->openedDate)
            ->beginIF($type)->andWhere('type')->eq($type)->fi()
            ->orderBy('id')
            ->fetchAll();

        if(!empty($actions))
        {
            foreach($actions as $action)
            {
                $action->user = (int)$action->user;
                $action->date = strtotime($action->date);
                $action->room = $action->rid;
                unset($action->rid);
            }
        }

        if(dao::isError()) return false;
        return $actions;
    }

    /**
     * Save a conference action.
     *
     * @param  string         $roomID
     * @param  string         $type
     * @param  int            $userID
     * @param  string         $device
     * @access public
     * @return object|boolean
     */
    public function saveAction($roomID, $type, $userID, $device = 'default', $data = '')
    {
        $action = new stdClass();
        $action->rid    = $roomID;
        $action->type   = $type;
        $action->user   = $userID;
        $action->device = $device;
        $action->date   = helper::now();
        $action->data   = $data;
        $this->dao->insert(TABLE_IM_CONFERENCEACTION)->data($action)->exec();

        if(dao::isError()) return false;

        $action->room = $action->rid;
        $action->date = strtotime($action->date);
        return $action;
    }

    /**
     * Check if user is occupied.
     *
     * @param  int     $userID
     * @param  string  $fromChat  from which chat check user status
     * @access public
     * @return boolean
     */
    public function isUserOccupied($userID, $fromChat = '')
    {
        $userConferences = $this->getByUserID($userID);
        foreach($userConferences as $conference)
        {
            $participants = explode(',', $conference->participants);
            $participants = array_filter($participants);
            if($conference->status == 'open' && $conference->cgid != $fromChat && in_array($userID, $participants)) return true;
        }
        return false;
    }

    /**
     * Remove user from all related conferences and close if necessary.
     *
     * @param  int  $userID
     * @access public
     * @return void
     */
    public function removeUserFromConferences($userID)
    {
        $conferences = $this->getByUserID($userID);

        foreach($conferences as $conference)
        {
            if(!empty($conference) && $conference->status == 'open')
            {
                $participants = explode(',', $conference->participants);
                $participants = array_filter($participants);
                if(in_array($userID, $participants))
                {
                    if(count($participants) > 1)
                    {
                        $this->removeParticipant($conference->cgid, $userID);
                        $this->saveAction($conference->rid, 'leave', $userID);
                    }
                    else
                    {
                        $this->close($conference->cgid, $userID);
                    }
                }
            }
        }
    }

    /**
     * Try remove user from conference of a chat.
     *
     * @param  string $chatID
     * @param  int    $userID
     * @access public
     * @return object|boolean
     */
    public function removeUserFromChat($chatID, $userID)
    {
        $conference = $this->getByChatID($chatID);
        if(empty($conference) || $conference->status != 'open') return false;

        $participants = explode(',', $conference->participants);
        $participants = array_filter($participants);
        $participants = array_diff($participants, array($userID));

        if(count($participants) == 0)
        {
            $this->close($conference->cgid, $userID);
            return false;
        }

        $participants = implode(',', $participants);
        $conference->participants = $participants;

        return $conference;
    }

    /**
     * Clean conference participants and close conference if needed or return the conference.
     *
     * @param  string         $chatID
     * @param  int            $userID
     * @access public
     * @return object|boolean
     */
    public function cleanConference($chatID, $userID)
    {
        $conference = $this->getByChatID($chatID);
        if(empty($conference)) return false;

        $participants = explode(',', $conference->participants);
        $participants = array_filter($participants);

        $onlineUsers = array_keys($this->loadModel('im')->user->getList('online'));
        $participants = array_intersect($participants, $onlineUsers);

        if(count($participants) == 1 && in_array($userID, $participants))
        {
            $this->close($conference->cgid, $userID);
            return false;
        }

        $participants = implode(',', $participants);
        $conference->participants = $participants;

        return $conference;
    }

    /**
     * Reset status of conferences.
     *
     * @access public
     * @return void
     */
    public function resetStatus()
    {
        $this->dao->update(TABLE_IM_CONFERENCE)
            ->set('status')->eq('closed')
            ->set('participants')->eq('')
            ->exec();
    }

    /**
     * Get open conferences by given chat list.
     *
     * @param  array  $chatList
     * @param  int    $userID
     * @access public
     * @return array
     */
    public function getOpenConferencesByChatList($chatList, $userID, $ignoreActions = false)
    {
        $openConferenceList = array();
        foreach($chatList as $chat)
        {
            $chatConference = $this->cleanConference($chat->gid, $userID);
            if(!empty($chatConference) && $chatConference->status == 'open')
            {
                $actions = $this->getActions($chatConference);
                $chatConference->actions = ($ignoreActions || empty($actions)) ? array() : $actions;

                $chatConference->room       = $chatConference->rid;
                $chatConference->openedBy   = (int)$chatConference->openedBy;
                $chatConference->openedDate = strtotime($chatConference->openedDate);
                unset($chatConference->rid);

                $openConferenceList[] = $chatConference;
            }
        }
        return $openConferenceList;
    }

    /**
     * Check if there is participant limit in license.
     *
     * @access public
     * @return string|bool
     */
    public function isUnlimitedParticipants()
    {
        return extCommonModel::getLicensePropertyValue('unlimitedParticipants');
    }
}
