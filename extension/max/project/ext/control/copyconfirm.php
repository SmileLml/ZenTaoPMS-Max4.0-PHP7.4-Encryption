<?php
class project extends control
{
    /**
     * Copy project confirm.
     *
     * @param  int    $copyProjectID
     * @param  string $products
     *
     * @access public
     * @return void
     */
    public function copyConfirm($copyProjectID, $products = '')
    {
        $this->loadModel('programplan');
        $project = $this->project->getByID($copyProjectID);

        if($_POST)
        {
            /* Get the data from the post. */
            $postData = fixer::input('post')->get();

            $projectData = $postData->project;
            $model       = $project->model;
            $projectData['products']  = isset($postData->products) ? $postData->products : array();
            $projectData['plans']     = isset($postData->plans) ? $postData->plans : array();
            $projectData['whitelist'] = isset($postData->whitelist) ? $postData->whitelist : array();
            $projectData['branch']    = isset($postData->branch) ? $postData->branch : array();
            $projectData['division']  = isset($project->division) ? $project->division : 0;
            unset($postData->project);
            unset($postData->products);
            unset($postData->plans);
            unset($postData->whitelist);
            $execution = $postData;
            $_POST     = $projectData;
            if($model == 'waterfall')
            {
                $copiedProjectProducts = $this->loadModel('product')->getProductPairsByProject($project->id);
                $products = $this->product->getByIdList(array_keys($execution->names));
                $showProduct = !(count($copiedProjectProducts) <= 1 and count($products) == 1);
                foreach($execution->names as $productID => $names)
                {
                    if(!$this->programplan->checkNameUnique($names)) dao::$errors['message'][] = ($showProduct ? $products[$productID]->name . ': ' : '') . $this->lang->programplan->error->sameName;
                    if(array_sum($execution->percents[$productID]) > 100) dao::$errors['message'][] = ($showProduct ? $products[$productID]->name . ': ' : '') . $this->lang->programplan->error->percentOver;
                }
            }
            else
            {
                if(!$this->programplan->checkNameUnique($execution->names)) dao::$errors['message'][] = $this->lang->programplan->error->sameName;
            }
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $projectID = $this->project->saveCopyProject($copyProjectID, $model, $execution);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('project', 'index', "projectID=$projectID")));
        }

        $this->loadModel('stage');
        $this->loadModel('execution');
        $this->loadModel('user');

        $copyExecutions = $this->execution->getList($project->id);

        /* Sort execution. */
        $executionIdList = array();
        $executionStats  = $this->execution->getStatData($project->id, 'all');
        foreach($executionStats as $execution)
        {
            $executionIdList[$execution->id] = $execution->id;
            if(!empty($execution->children))
            {
                foreach($execution->children as $child) $executionIdList[$child->id] = $child->id;
            }
        }

        if($project->model == 'waterfall')
        {
            $oldProductPairs   = $this->loadModel('product')->getProductPairsByProject($project->id);
            $productExecutions = $this->dao->select('project,product')->from(TABLE_PROJECTPRODUCT)->where('product')->in(array_keys($oldProductPairs))->andWhere('project')->in(array_keys($copyExecutions))->fetchGroup('product', 'project');

            $productIdList = array();
            foreach(explode(',', $products) as $productID)
            {
                $productID = (int)$productID;
                if(empty($productID)) continue;

                $productIdList[] = $productID;
            }

            $executionGroupIdList = array();
            foreach($productExecutions as $productID => $executions)
            {
                foreach($executionIdList as $stageID)
                {
                    if(!isset($executions[$stageID])) continue;

                    $executionGroupIdList[$productID][$stageID] = $stageID;
                    unset($executionIdList[$stageID]);
                }
            }

            $executionIdList = array();
            $productPairs    = array();
            if($productIdList)
            {
                $products = $this->loadModel('product')->getByIdList($productIdList);
                foreach($products as $product)
                {
                    $productPairs[$product->id] = $product->name;
                    $executionIdList[$product->id] = isset($executionGroupIdList[$product->id]) ? $executionGroupIdList[$product->id] : reset($executionGroupIdList);
                }
            }

            $this->view->oldProductPairs = $oldProductPairs;
            $this->view->productPairs    = $productPairs;
        }

        $this->view->title           = $this->lang->project->executionInfoConfirm;
        $this->view->project         = $project;
        $this->view->executions      = $copyExecutions;
        $this->view->executionIdList = $executionIdList;
        $this->view->users           = $this->user->getPairs('noclosed|nodeleted');
        $this->view->copyProjectID   = $copyProjectID;

        $this->display();
    }
}
