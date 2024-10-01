<?php
public function create()
{
    return $this->loadExtension('zentaobiz')->create();
}

public function getPairs($projectID = 0)
{
    return $this->loadExtension('zentaobiz')->getPairs($projectID);
}
