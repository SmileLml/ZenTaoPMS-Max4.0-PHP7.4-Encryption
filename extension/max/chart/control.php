<?php
/**
 * The control file of chart module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chart
 * @version     $Id: model.php 5086 2013-07-10 02:25:22Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
class chart extends control
{
    /**
     * Browse charts.
     *
     * @param string $orderBy
     * @param int $recTotal
     * @param int $recPerPage
     * @param int $pageID
     * @access public
     * @return void
     */
    public function browse($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Load pager and get tracks. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->title  = $this->lang->chart->common;
        $this->view->charts = $this->chart->getList($orderBy, $pager);
        $this->view->pager  = $pager;
        $this->display();
    }

    /**
     * Create chart.
     *
     * @param string $dataset
     * @access public
     * @return void
     */
    public function create($dataset = '')
    {
        if(!empty($_POST))
        {
            $chartID = $this->chart->create();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('chart', $chartID, 'opened');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('chart', 'design', "chartID=$chartID")));
        }

        $this->loadModel('dataset');

        $datasets = array('' => ' ');
        foreach($this->lang->dataset->tables as $key => $table) $datasets[$key] = $table['name'];
        $customDatasets = $this->dataset->getList('custom');
        foreach($customDatasets as $dataset)
        {
            $datasets[$dataset['code']] = $dataset['name'];
        }

        $this->view->dataset  = '';
        $this->view->datasets = $datasets;
        $this->view->title    = $this->lang->chart->create;
        $this->display();
    }

    /**
     * Edit chart.
     *
     * @param  int $chartID
     * @access public
     * @return void
     */
    public function edit($chartID)
    {
        if(!empty($_POST))
        {
            $this->chart->update($chartID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('chart', $chartID, 'edited');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('chart', 'browse')));
        }

        $this->loadModel('dataset');

        $datasets = array();
        foreach($this->lang->dataset->tables as $key => $table) $datasets[$key] = $table['name'];

        $customDatasets = $this->dataset->getList('custom');
        foreach($customDatasets as $dataset)
        {
            $datasets[$dataset['code']] = $dataset['name'];
        }

        $chart = $this->chart->getByID($chartID);

        $this->view->chart    = $chart;
        $this->view->datasets = $datasets;
        $this->view->title    = $this->lang->chart->edit;
        $this->display();
    }

    /**
     * Design chart.
     *
     * @param  int $chartID
     * @access public
     * @return void
     */
    public function design($chartID)
    {
        if(!empty($_POST))
        {
            $this->chart->update($chartID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('chart', $chartID, 'designed');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('chart', 'browse')));
        }

        $this->loadModel('dataset');

        $datasets = array();
        foreach($this->lang->dataset->tables as $key => $table) $datasets[$key] = $table['name'];

        $customDatasets = $this->dataset->getList('custom');
        foreach($customDatasets as $dataset)
        {
            $datasets[$dataset['code']] = $dataset['name'];
        }

        $chart = $this->chart->getByID($chartID);

        /* Filters. */
        $chart->filters = $this->chart->setFilters($chart->filters);
        $ds = array();
        foreach($chart->filters as $filter)
        {
            $objectFields = explode('.', $filter->field);
            $ds[$objectFields[0]] = $objectFields[0];
        }
        $filters = $this->loadModel('dataset')->getFilters($ds);

        /* Options. */
        $sysOptions = array();
        foreach($chart->filters as $filter)
        {
            if(isset($filters['option'][$filter->field]))
            {
                $type = $filters['option'][$filter->field]['type'];
                if($type != 'option') $sysOptions[$type] = array();
            }
        }
        list($sysOptions, $defaults) = $this->dataset->getSysOptions($sysOptions);

        $fields = array();
        if($chart->dataset)
        {
            $info   = $this->loadModel('dataset')->getTableInfo($chart->dataset);
            $fields = $this->chart->getFields($info);
        }

        /* Remove deleted fields.*/
        $settings = !empty($chart->settings) ? json_decode($chart->settings) : array();
        foreach($settings as $type => $setting)
        {
            foreach($setting as $key => $settingField)
            {
                if(!isset($fields[$settingField->field])) unset($settings->$type[$key]);
            }
        }
        $chart->settings = json_encode($settings);
        /* Fix bug #28551. */
        if($chart->settings == '[]') $chart->settings = '{"group":[],"column":[],"filter":[]}';

        $this->view->data       = array();
        $this->view->chart      = $chart;
        $this->view->datasets   = $datasets;
        $this->view->fields     = $fields;
        $this->view->title      = $this->lang->chart->design;
        $this->view->filters    = $filters;
        $this->view->sysOptions = (Object)$sysOptions;
        $this->view->defaults   = (Object)$defaults;
        $this->display();
    }

    /**
     * Ajax get fields.
     *
     * @param  string $dataset
     * @access public
     * @return void
     */
    public function ajaxGetFields($dataset)
    {
        $info   = $this->loadModel('dataset')->getTableInfo($dataset);
        $fields = $this->chart->getFields($info);
        echo json_encode($fields);
    }

    /**
     * Ajax gen chart.
     *
     * @access public
     * @return void
     */
    public function ajaxGenChart()
    {
        $dataset      = $this->post->dataset;
        $type         = $this->post->type;
        $settings     = $this->post->settings;
        $filterValues = $this->post->filterValues ? $this->post->filterValues : array();

        $filter = isset($settings['filter']) ? $settings['filter'] : array();
        $group  = isset($settings['group'])  ? $settings['group']  : array();

        /* Line data must be ordered by time. */
        if($type == 'line')
        {
            $order = array(array('value' => $settings['xaxis'][0]['field'], 'sort' => 'asc'));
        }
        else
        {
            $order = isset($settings['order']) ? $settings['order'] : array();
        }

        if(strpos($type, 'Report') === false)
        {
            $table = $this->loadModel('dataset')->getTableInfo($dataset);
            $rows  = $this->chart->getData($table->schema, $filter, $filterValues, $group, $order, 1000);
        }

        $users = $this->loadModel('user')->getPairs('noletter');
        switch($type)
        {
            case 'table':
                $data = $this->chart->genTable($dataset, $settings, $rows, $users);
                break;
            case 'line':
                $data = $this->chart->genLine($dataset, $settings, $rows, $users);
                break;
            case 'bar':
                $data = $this->chart->genBar($dataset, $settings, $rows, $users);
                break;
            case 'pie':
                $data = $this->chart->genPie($dataset, $settings, $rows, $users);
                break;
            case 'testingReport':
            case 'buildTestingReport':
                if(!$filterValues['build.id'])
                {
                    $filters = array('project' => array(), 'execution' => array(), 'build' => array());
                    list($sysOptions, $defaults) = $this->loadModel('dataset')->getSysOptions($filters);

                    $filterValues['project.id']   = $defaults['project'];
                    $filterValues['execution.id'] = $defaults['execution'];
                    $filterValues['build.id']     = $defaults['build'];
                }
                $data = $this->chart->genTestingReport($type, $filterValues);
                break;
            case 'executionTestingReport':
                if(!$filterValues['execution.id'])
                {
                    $filters = array('project' => array(), 'execution' => array());
                    list($sysOptions, $defaults) = $this->loadModel('dataset')->getSysOptions($filters);

                    $filterValues['project.id']   = $defaults['project'];
                    $filterValues['execution.id'] = $defaults['execution'];
                }
                $data = $this->chart->genTestingReport($type, $filterValues);
                break;
            case 'projectTestingReport':
                if(!$filterValues['project.id'])
                {
                    $filters = array('project' => array());
                    list($sysOptions, $defaults) = $this->loadModel('dataset')->getSysOptions($filters);

                    $filterValues['project.id']   = $defaults['project'];
                }
                $data = $this->chart->genTestingReport($type, $filterValues);
                break;
            case 'dailyTestingReport':
                if(!$filterValues['build.id'])
                {
                    $filters = array('project' => array(), 'execution' => array(), 'build' => array());
                    list($sysOptions, $defaults) = $this->loadModel('dataset')->getSysOptions($filters);

                    $filterValues['project.id']   = $defaults['project'];
                    $filterValues['execution.id'] = $defaults['execution'];
                    $filterValues['build.id']     = $defaults['build'];
                }
                $data = $this->chart->genTestingReport($type, $filterValues);
                break;
        }

        echo json_encode($data);
    }

    /**
     * Delete a chart.
     *
     * @param  int    $chartID
     * @param  string $confirm  yes|no
     * @param  string $from taskkanban
     * @access public
     * @return void
     */
    public function delete($chartID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->chart->confirmDelete, inlink('delete', "id=$chartID&confirm=yes")));
        }
        else
        {
            $this->chart->delete(TABLE_CHART, $chartID);

            if(isonlybody()) return print(js::reload('parent.parent'));

            $locateLink = $this->session->chartList ? $this->session->chartList : inlink('browse');
            return print(js::locate($locateLink, 'parent'));
        }
    }

    /**
     * Ajax get options.
     *
     * @param string $field
     * @param int    $val
     * @access public
     * @return void
     */
    public function ajaxGetOptions($field, $val, $filters)
    {
        $filters = explode(',', $filters);

        $allOptions = array();
        $defaults   = array();
        switch($field)
        {
            case 'project.id':
            case 'project':
                $options = array();

                $this->loadModel('execution');
                $executions    = array();
                $projectIdList = explode(',', $val);
                foreach($projectIdList as $projectID)
                {
                    $es = $this->execution->getPairs($projectID);
                    foreach($es as $k => $e) $executions[$k] = $e;
                }

                foreach($executions as $key => $execution) $options[] = array('value' => (string)$key, 'label' => $execution);

                //$defaults['execution']   = count($executions) > 0 ? (string)$this->execution->saveState(0, $executions) : '';
                $defaults['execution']   = '';
                $allOptions['execution'] = $options;
            case 'execution.id':
            case 'execution':
                $options = array();
                $executionIdList = $field == 'execution.id' ? $val : $defaults['execution'];

                $this->loadModel('build');
                $builds = array();
                foreach(explode(',', $executionIdList) as $executionID)
                {
                    $bs = $this->build->getExecutionBuilds($executionID);
                    foreach($bs as $b) $builds[$b->id] = $b->name;
                }
                foreach($builds as $key => $build) $options[] = array('value' => (string)$key, 'label' => $build);

                //$defaults['build']   = (string)key($builds);
                $defaults['build']   = '';
                $allOptions['build'] = $options;
            case 'build.id':
            case 'build':
                $options = array();
                $buildIdList = $field == 'build.id' ? $val : $defaults['build'];
                $modules = array();
                $testtasks   = array();

                if(in_array('build', $filters) or in_array('build.id', $filters))
                {
                    if(!empty($buildIdList)) $testtasks = $this->dao->select('id')->from(TABLE_TESTTASK)->where('build')->in($buildIdList)->fetchAll('id');
                }
                else if(in_array('execution', $filters) or in_array('execution.id', $filters))
                {
                    if(!empty($executionIdList)) $testtasks = $this->dao->select('id')->from(TABLE_TESTTASK)->where('execution')->in($executionIdList)->fetchAll('id');
                }
                else
                {
                    if(!empty($projectIdList)) $testtasks = $this->dao->select('id')->from(TABLE_TESTTASK)->where('project')->in($projectIdList)->fetchAll('id');
                }

                if(!empty($testtasks))
                {
                    $moduleIdList = $this->dao->select('distinct module')->from(TABLE_CASE)->alias('t1')
                        ->leftJoin(TABLE_TESTRUN)->alias('t2')
                        ->on('t1.id = t2.case')
                        ->where('t2.task')->in(array_keys($testtasks))
                        ->fetchPairs();
                    $modules    = $this->dao->select('id, name, path, branch')->from(TABLE_MODULE)->where('id')->in($moduleIdList)->andWhere('deleted')->eq(0)->fetchAll('path');
                    $allModules = $this->dao->select('id, name')->from(TABLE_MODULE)->where('id')->in(join(array_keys($modules)))->andWhere('deleted')->eq(0)->fetchPairs('id', 'name');
                    $moduleTree = new stdclass();
                    foreach($modules as $module)
                    {
                        $paths = explode(',', trim($module->path, ','));
                        $this->loadModel('dataset')->genTreeOptions($moduleTree, $allModules, $paths);
                    }

                    $options = isset($moduleTree->children) ? $moduleTree->children : array();
                }

                //$defaults['casemodule']   = empty($modules) ? '' : (string)key($modules);
                $defaults['casemodule']   = '';
                $allOptions['casemodule'] = $options;
                break;
        }

        echo json_encode((Object)array('options' => $allOptions, 'defaults' => $defaults));
    }
}
