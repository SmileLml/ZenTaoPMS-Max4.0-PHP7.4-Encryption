<?php
/**
 * The model file of lieu module of Ranzhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <chujilu@cnezsoft.com>
 * @package     lieu
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class lieuModel extends model
{
    public function __construct($appName = '')
    {
        parent::__construct($appName);
        $this->loadModel('attend');
    }

    /**
     * Get lieu By id. 
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getById($id)
    {
        return $this->dao->select('*')->from(TABLE_LIEU)->where('id')->eq($id)->fetch();
    }

    /**
     * Get lieu list. 
     * 
     * @param  string $type 
     * @param  string $year 
     * @param  string $month 
     * @param  string $account 
     * @param  string $dept 
     * @param  string $status 
     * @param  string $orderBy
     * @access public
     * @return array
     */
    public function getList($type = 'personal', $year = '', $month = '', $account = '', $dept = '', $status = '', $orderBy = 'id_desc')
    {
        $date = '';
        if($year)  
        {
            if(!$month) $date = "$year-%";
            if($month)  $date = "$year-$month-%";
        }
        else
        {
            if($month) $date = "%-$month-%";
        }

        $lieuList = $this->dao->select('t1.*, t2.realname, t2.dept')
            ->from(TABLE_LIEU)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on("t1.createdBy=t2.account")
            ->where(1)
            ->beginIf($date)
            ->andWhere('t1.begin', true)->like($date)
            ->orWhere('t1.end')->like($date)
            ->markRight(1)
            ->fi()
            ->beginIf($account != '')->andWhere('t1.createdBy')->eq($account)->fi()
            ->beginIf($dept != '')->andWhere('t2.dept')->in($dept)->fi()
            ->beginIf($status != '')->andWhere('t1.status')->eq($status)->fi()
            ->beginIf($type == 'browseReview')->andWhere('t1.status')->eq('wait')->fi()
            ->beginIf($type == 'company')->andWhere('t1.status')->ne('draft')->fi()
            ->orderBy("t2.dept,t1.{$orderBy}")
            ->fetchAll();
        $this->session->set('lieuQueryCondition', $this->dao->get());

        return $this->processStatus($lieuList);
    }

    /**
     * Process status of lieu list. 
     * 
     * @param  array  $lieuList 
     * @access public
     * @return array 
     */
    public function processStatus($lieuList, $record = null)
    {
        $users    = $this->loadModel('user')->getDeptPairs();
        $managers = $this->user->getUserManagerPairs();
        foreach($lieuList as $lieu)
        {
            $lieu->statusLabel = zget($this->lang->lieu->statusList, $lieu->status);

            if($lieu->status == 'wait')
            {
                $reviewer = $this->getReviewedBy();
                if(!$reviewer) 
                {
                    $reviewer = trim(zget($managers, $lieu->createdBy, ''), ',');
                }
                if($reviewer) $lieu->statusLabel = zget($users, $reviewer) . $this->lang->lieu->statusList['doing'];
            }
        }

        return $lieuList;
    }

    /**
     * Get lieu by date and account.
     * 
     * @param  string    $date 
     * @param  string    $account 
     * @access public
     * @return object
     */
    public function getByDate($date, $account)
    {
        $lieus = $this->dao->select('*')->from(TABLE_LIEU)->where('begin')->le($date)->andWhere('end')->ge($date)->andWhere('createdBy')->eq($account)->fetchAll();
        if(count($lieus) == 1) return current($lieus);
        return null;
    }

    /**
     * Get all month of lieu's begin.
     * 
     * @param  string $type
     * @access public
     * @return array
     */
    public function getAllMonth($type)
    {
        $monthList = array();
        $dateList  = $this->dao->select('begin')->from(TABLE_LIEU)
            ->beginIF($type == 'personal')->where('createdBy')->eq($this->app->user->account)->fi()
            ->beginIF($type == 'company')->where('status')->ne('draft')->fi()
            ->groupBy('begin')
            ->orderBy('begin_desc')
            ->fetchAll('begin');
        foreach($dateList as $date)
        {
            $year  = substr($date->begin, 0, 4);
            $month = substr($date->begin, 5, 2);
            if(!isset($monthList[$year][$month])) $monthList[$year][$month] = $month;
        }
        return $monthList;
    }

    /**
     * Get reviewed by. 
     * 
     * @access public
     * @return string
     */
    public function getReviewedBy()
    {
        return !isset($this->config->lieu->reviewedBy) ? (!isset($this->config->attend->reviewedBy) ? '' : $this->config->attend->reviewedBy) : $this->config->lieu->reviewedBy;
    }

    /**
     * Create lieu.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $lieu = fixer::input('post')
            ->add('status', 'wait')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->join('overtime', ',')
            ->join('trip', ',')
            ->get();

        $lieu->overtime = isset($lieu->overtime) ? ',' . trim($lieu->overtime, ',') . ',' : '';
        $lieu->trip     = isset($lieu->trip) ? ',' . trim($lieu->trip, ',') . ',' : '';
        if(isset($lieu->begin) and $lieu->begin != '') $lieu->year = substr($lieu->begin, 0, 4);

        $return = $this->checkDate($lieu);
        if($return['result'] == 'fail') return $return;

        if(!$this->post->overtime && !$this->post->trip) dao::$errors['overtime'] = $this->lang->lieu->bothEmpty;

        $this->dao->insert(TABLE_LIEU)->data($lieu)->autoCheck()
            ->batchCheck($this->config->lieu->require->create, 'notempty')
            ->check('end', 'ge', $lieu->begin)
            ->exec();

        return $this->dao->lastInsertID();
    }

    /**
     * Update lieu.
     * 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function update($id)
    {
        $oldLieu = $this->getById($id);

        $lieu = fixer::input('post')
            ->remove('status')
            ->remove('createdBy')
            ->remove('createdDate')
            ->join('overtime', ',')
            ->join('trip', ',')
            ->get();

        $lieu->overtime = isset($lieu->overtime) ? ',' . trim($lieu->overtime, ',') . ',' : '';
        $lieu->trip     = isset($lieu->trip) ? ',' . trim($lieu->trip, ',') . ',' : '';
        if(isset($lieu->begin) and $lieu->begin != '') $lieu->year = substr($lieu->begin, 0, 4);
        if($oldLieu->status == 'reject') $lieu->status = 'wait';

        $return = $this->checkDate($lieu, $id);
        if($return['result'] == 'fail') return $return;

        if(!$this->post->overtime && !$this->post->trip) dao::$errors['overtime'] = $this->lang->lieu->bothEmpty;

        $this->dao->update(TABLE_LIEU)->data($lieu)->autoCheck()
            ->batchCheck($this->config->lieu->require->edit, 'notempty')
            ->check('end', 'ge', $lieu->begin)
            ->where('id')->eq($id)
            ->exec();

        return commonModel::createChanges($oldLieu, $lieu);
    }

    /**
     * Compare liue hours and overtime hours. 
     * 
     * @access public
     * @return bool | array 
     */
    public function checkHours()
    {
        if(!$this->post->overtime && !$this->post->trip) return true;

        if(!function_exists('bccomp') or !function_exists('bcadd')) return array('result' => 'fail', 'message' => $this->lang->lieu->nobcmath);

        $totalHours = 0;
        if($this->post->overtime)
        {
            $overtimes = $this->loadModel('overtime')->getByIdList($this->post->overtime);
            foreach($overtimes as $overtime) $totalHours = bcadd($totalHours, $overtime->hours);
        }
        if($this->post->trip)
        {
            $this->app->loadModuleConfig('attend');
            $trips = $this->loadModel('trip')->getByIdList($this->post->trip);
            foreach($trips as $trip)
            {
                $hours = round((strtotime("{$trip->end} {$trip->finish}") - strtotime("{$trip->begin} {$trip->start}")) / 3600, 2);
                if($hours > $this->config->attend->workingHours) $hours = $this->config->attend->workingHours;
                $totalHours = bcadd($totalHours, $hours);
            }
        }
        
        if(bccomp($this->post->hours, $totalHours, 2) === 1) return array('result' => 'fail', 'message' => array('hours' => sprintf($this->lang->lieu->wrongHours, $totalHours)));

        return true;
    }

    /**
     * Check date.
     * 
     * @param  object    $data 
     * @param  int       $id
     * @access public
     * @return array
     */
    public function checkDate($date, $id = 0) 
    {
        //if(substr($date->begin, 0, 7) != substr($date->end, 0, 7)) return array('result' => 'fail', 'message' => $this->lang->lieu->sameMonth);
        if("$date->end $date->finish" <= "$date->begin $date->start") return array('result' => 'fail', 'message' => $this->lang->lieu->wrongEnd);

        $existLieu = $this->checkLieu($date, $this->app->user->account, $id);
        if(!empty($existLieu)) return array('result' => 'fail', 'message' => sprintf($this->lang->lieu->unique, implode(', ', $existLieu)));  

        $existLeave = $this->loadModel('leave')->checkLeave($date, $this->app->user->account);
        if(!empty($existLeave)) return array('result' => 'fail', 'message' => sprintf($this->lang->leave->unique, implode(', ', $existLeave)));  
        
        $existMakeup = $this->loadModel('makeup')->checkMakeup($date, $this->app->user->account);
        if(!empty($existMakeup)) return array('result' => 'fail', 'message' => sprintf($this->lang->makeup->unique, implode(', ', $existMakeup))); 

        $existOvertime = $this->loadModel('overtime')->checkOvertime($date, $this->app->user->account);
        if(!empty($existOvertime)) return array('result' => 'fail', 'message' => sprintf($this->lang->overtime->unique, implode(', ', $existOvertime))); 

        $existTrip = $this->loadModel('trip')->checkTrip('trip', $date, $this->app->user->account); 
        if(!empty($existTrip)) return array('result' => 'fail', 'message' => sprintf($this->lang->trip->unique, implode(', ', $existTrip))); 

        $this->app->loadLang('egress', '');
        $existEgress = $this->trip->checkTrip('egress', $date, $this->app->user->account); 
        if(!empty($existEgress)) return array('result' => 'fail', 'message' => sprintf($this->lang->egress->unique, implode(', ', $existEgress)));

        return array('result' => 'success');
    }

    /**
     * Check lieu unique.
     * 
     * @param  int    $currentLieu 
     * @param  string $account 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function checkLieu($currentLieu = null, $account = '', $id = 0)
    {
        $beginTime  = date('Y-m-d H:i:s', strtotime($currentLieu->begin . ' ' . $currentLieu->start));
        $endTime    = date('Y-m-d H:i:s', strtotime($currentLieu->end   . ' ' . $currentLieu->finish));
        $lieuList   = $this->getList('personal', '', '', $account);
        $existLieu  = array();
        foreach($lieuList as $lieu)
        {
            if($lieu->id == $id) continue;
            if($lieu->status == 'reject') continue;

            $begin = $lieu->begin . ' ' . $lieu->start;
            $end   = $lieu->end   . ' ' . $lieu->finish;
            if(($beginTime > $begin && $beginTime < $end) 
                || ($endTime > $begin && $endTime < $end) 
                || ($beginTime <= $begin && $endTime >= $end))
            {
                $existLieu[] = substr($begin, 0, 16) . ' ~ ' . substr($end, 0, 16);
            }
        }
        return $existLieu;
    }

    /**
     * delete lieu.
     * 
     * @param  int    $id 
     * @access public
     * @return bool
     */
    public function delete($id, $null = null)
    {
        $oldLieu = $this->getById($id);
        $this->dao->delete()->from(TABLE_LIEU)->where('id')->eq($id)->exec();

        if(!dao::isError())
        {
            $oldDates = range(strtotime($oldLieu->begin), strtotime($oldLieu->end), 60*60*24);
            $this->loadModel('attend')->batchUpdate($oldDates, $oldLieu->createdBy, '');
        }

        return !dao::isError();
    }

    /**
     * Review lieu.
     * 
     * @param  int    $id 
     * @param  string $status 
     * @access public
     * @return bool
     */
    public function review($id, $status)
    {
        if(!isset($this->lang->lieu->statusList[$status])) return false;

        $data = new stdclass();
        $data->status       = $status;
        $data->reviewedBy   = $this->app->user->account;
        $data->reviewedDate = helper::now();

        $this->dao->update(TABLE_LIEU)->data($data)->autoCheck()->where('id')->eq($id)->exec();

        if(!dao::isError() and $status == 'pass')
        {
            $lieu  = $this->getById($id);
            $dates = range(strtotime($lieu->begin), strtotime($lieu->end), 60 * 60 * 24);
            $this->loadModel('attend')->batchUpdate($dates, $lieu->createdBy, 'lieu', '', $lieu);
        }

        return !dao::isError();
    }

    /**
     * Get status for the date.
     * 
     * @param  string    $date 
     * @param  string    $account 
     * @access public
     * @return string|bool
     */
    public function isLieu($date, $account)
    {
        static $lieuList = array();
        if(!isset($lieuList[$account])) $lieuList[$account] = $this->getList($type = '', $year = '', $month = '', $account, $dept = '', 'pass');

        foreach($lieuList[$account] as $lieu)
        {
            if(strtotime($date) >= strtotime($lieu->begin) and strtotime($date) <= strtotime($lieu->end)) return true;
        }
        return false;
    }
}
