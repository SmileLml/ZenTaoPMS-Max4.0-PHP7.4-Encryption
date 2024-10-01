<?php
public function isClickable($makeup, $action)
{
    return $this->loadExtension('oa')->isClickable($makeup, $action);
}

public function getList($type = 'personal', $year = '', $month = '', $account = '', $dept = '', $status = '', $orderBy = 'id_desc')
{
    return $this->loadExtension('oa')->getList($type, $year, $month, $account, $dept, $status, $orderBy);
}

public function getReviewedBy($account = '')
{
    return $this->loadExtension('oa')->getReviewedBy($account);
}
