<?php
public function getHasFeedbackPriv($pager = null)
{
    return $this->loadExtension('feedback')->getHasFeedbackPriv($pager);
}

public function getPairs($params = '', $usersToAppended = '', $maxCount = 0, $accounts = '')
{
    return $this->loadExtension('feedback')->getPairs($params, $usersToAppended, $maxCount, $accounts);
}

public function getProductViewUsers($productID)
{
    return $this->loadExtension('feedback')->getProductViewUsers($productID);
}
