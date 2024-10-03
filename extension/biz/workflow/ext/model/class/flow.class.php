<?php
class flowWorkflow extends workflowModel
{
    /**
     * Get Apps.
     *
     * @param  string $exclude
     * @param  bool   $splitProject
     * @access public
     * @return array
     */
    public function getApps($exclude = 'admin', $splitProject = true)
    {
        $apps = array('');
        $menu = commonModel::getMainNavList($this->app->rawModule);
        foreach($menu as $menuItem)
        {
            if(empty($menuItem->title)) continue;
            if($exclude && strpos(",$exclude,", ",$menuItem->code,") !== false) continue;
            if($menuItem->code == 'project' and $splitProject)
            {
                if(isset($this->lang->scrum->menu)) $apps['scrum'] = $this->lang->project->common . '/' . $this->lang->workflow->scrum;
                if(isset($this->lang->waterfall->menu)) $apps['waterfall'] = $this->lang->project->common . '/' . $this->lang->workflow->waterfall;

                if($this->config->vision == 'lite')
                {
                    $apps['project'] = $this->lang->project->common;
                    unset($apps['scrum'], $apps['waterfall'], $apps['kanban']);
                }
            }
            else
            {
                $apps[$menuItem->code] = trim(strip_tags($menuItem->title));
            }
        }
        return $apps;
    }

    /**
     * Get menus of an app.
     *
     * @param  string $app
     * @param  string $exclude
     * @access public
     * @return array
     */
    public function getAppMenus($app, $exclude = '')
    {
        $menus = array('');
        if(empty($app)) return $menus;
        if($app == 'kanban') return $menus;

        if($this->config->vision == 'lite' and $app == 'project') $app = 'kanban';

        $customPrimaryFlow = $this->dao->select('id')->from(TABLE_WORKFLOW)
            ->where('module')->eq($app)
            ->andWhere('type')->eq('flow')
            ->andWhere('status')->eq('normal')
            ->andWhere('buildin')->eq('0')
            ->andWhere('navigator')->eq('primary')
            ->andWhere('vision')->eq($this->config->vision)
            ->fetch();

        $this->app->loadLang($app);

        if(empty($customPrimaryFlow) && isset($this->lang->$app->menuOrder) && (is_array($this->lang->$app->menuOrder) or is_object($this->lang->$app->menuOrder)))
        {
            ksort($this->lang->$app->menuOrder);
            foreach($this->lang->$app->menuOrder as $module)
            {
                if($exclude && strpos(",{$exclude},", ",{$module},") !== false) continue;

                if(isset($this->lang->$app->menu->$module))
                {
                    $menuItem = $this->lang->$app->menu->$module;

                    if(is_string($menuItem)) $label = substr($menuItem, 0, strpos($menuItem, '|'));
                    if(is_array($menuItem))
                    {
                        if(!isset($menuItem['link'])) continue;
                        $link = $menuItem['link'];
                        $label = substr($link, 0, strpos($link, '|'));
                    }
                    if($module == 'bysearch')
                    {
                        $this->app->loadLang('search');
                        $label = $this->lang->search->common;
                    }
                    if(empty($label)) continue;
                    if(strpos($label, '@') !== false) continue;

                    $menus[$module] = $label;
                }
            }
        }
        else
        {
            $flows = $this->dao->select('id,app,position,module,name')->from(TABLE_WORKFLOW)
                ->where('app')->eq($app)
                ->andWhere('buildin')->eq(0)
                ->andWhere('status')->eq('normal')
                ->andWhere('type')->eq('flow')
                ->orderBy('id')
                ->fetchAll('id');
            $currentFlowName = $this->dao->select('id,app,position,module,name')->from(TABLE_WORKFLOW)->where('module')->eq($app)->fetch('name');

            $orders[$app] = 5;
            $positions = array();
            $flowPairs = array();
            $unsorts   = array();
            foreach($flows as $flow)
            {
                $flowPairs[$flow->module] = $flow->name;

                $position  = $flow->position;
                $direction = strpos($position, 'after') === 0 ? 'after' : 'before';
                $position  = substr($position, strlen($direction));

                if(isset($orders[$position]))
                {
                    if($direction == 'after')  $orders[$flow->module] = $orders[$position] + '0.1';
                    if($direction == 'before') $orders[$flow->module] = $orders[$position] - '0.1';
                    $result  = $this->reorderMenu($unsorts, $orders);
                    $orders  = $result['orders'];
                    $unsorts = $result['unsorts'];
                }
                else
                {
                    $unsorts[$position][$flow->module] = $direction;
                }
            }

            asort($orders);
            $menus = array();
            foreach($orders as $flowModule => $order)
            {
                if($exclude && strpos(",{$exclude},", ",{$flowModule},") !== false) continue;
                $menus[$flowModule] = $flowModule == $app ? $currentFlowName : $flowPairs[$flowModule];
            }
        }

        return $menus;
    }

    /**
     * Resort Menu
     *
     * @param  array    $unsorts
     * @param  array    $orders
     * @access public
     * @return array
     */
    public function reorderMenu($unsorts, $orders)
    {
        foreach($unsorts as $position => $flowModules)
        {
            if(isset($orders[$position]))
            {
                foreach($flowModules as $flowModule => $direction)
                {
                    $order = $orders[$position];
                    $step  = (is_numeric($order) and strpos($order, '.') === false) ? '0.1' : '0.01';
                    if($direction == 'after')  $orders[$flowModule] = $orders[$position] + $step;
                    if($direction == 'before') $orders[$flowModule] = $orders[$position] - $step;
                }
                unset($unsorts[$position]);

                $result  = $this->reorderMenu($unsorts, $orders);
                $orders  = $result['orders'];
                $unsorts = $result['unsorts'];
            }
        }

        return array('orders' => $orders, 'unsorts' => $unsorts);
    }

    /**
     * Get build in modules.
     * This function is used to check if the code of an user defined module is exist.
     *
     * @param  string $root
     * @access public
     * @return array
     */
    public function getBuildinModules($root = '', $rootType = '')
    {
        if(!$root) $root = $this->app->getModuleRoot();

        $modules = array();
        $handle  = opendir($root);
        if($handle)
        {
            while(($dir = readdir($handle)) !== false)
            {
                if($dir == '.' || $dir == '..') continue;
                $dirPath = $root . DIRECTORY_SEPARATOR . $dir;
                if(is_dir($dirPath))
                {
                    $dir = strtolower($dir);
                    $modules[$dir] = $dir;
                }
            }
            closedir($handle);
        }
        $modules['parent'] = 'parent';
        $modules['sub']    = 'sub';
        return $modules;
    }

    /**
     * Get all used apps of flow.
     *
     * @access public
     * @return array
     */
    public function getFlowApps()
    {
        return $this->dao->select('app')->from(TABLE_WORKFLOW)->where('app')->ne('')->orderBy('id')->fetchPairs();
    }

    /**
     * Get flow list.
     *
     * @param  string $mode     browse | bysearch
     * @param  string $type     flow | type
     * @param  string $status   wait | normal | pause
     * @param  string $parent
     * @param  string $app      crm | oa | proj | doc | cash | team | hr | psi | flow | ameba
     * @param  string $orderBy
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getList($mode = 'browse', $type = 'flow', $status = 'normal', $parent = '', $app = '', $orderBy = 'id_desc', $pager = null)
    {
        if($this->session->workflowQuery == false) $this->session->set('workflowQuery', ' 1 = 1');
        $workflowQuery = $this->loadModel('search')->replaceDynamic($this->session->workflowQuery);

        return $this->dao->select('*')->from(TABLE_WORKFLOW)
            ->where('vision')->eq($this->config->vision)
            ->beginIF($type)->andWhere('type')->eq($type)->fi()
            ->beginIF($type == 'table' && $parent)->andWhere('parent')->eq($parent)->fi()
            ->beginIF($type == 'flow' && $app)->andWhere('app')->eq($app)->fi()
            ->beginIF($type == 'flow' && $status && $status != 'unused')->andWhere('status')->eq($status)->fi()
            ->beginIF($type == 'flow' && $status == 'unused')->andWhere('status')->in('wait,pause')->fi()
            ->beginIF($mode == 'bysearch')->andWhere($workflowQuery)->fi()
            ->beginIF($this->config->systemMode == 'light')->andWhere('module')->notin('program')->fi()
            ->beginIF($this->config->visions == ',lite,')->andWhere('module')->notin('feedback')->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        foreach($flows as $flow)
        {
            if($this->config->vision == 'rnd' and $flow->module == 'story')  $flow->name = $this->lang->story->common;
            if($this->config->vision == 'lite' and $flow->module == 'story') $flow->name = $this->lang->story->common;
        }

        return $flows;
    }

    /**
     * Sort module menu.
     *
     * @param  string    $app
     * @param  string    $module
     * @param  string    $position
     * @param  string    $positionModule
     * @param  array     $buildInModules
     * @access public
     * @return bool
     */
    public function sortModuleMenu($app, $module, $position, $positionModule, $buildInModules = array())
    {
        if($app != $module)
        {
            $this->app->loadLang($app);
            if(!isset($this->lang->{$app}->menu)) return true;

            $menus = $this->lang->{$app}->menu;
        }
        else
        {
            $menus = $this->lang->mainNav;
            $app   = 'mainNav';
        }

        $this->loadModel('custom');
        if(empty($buildInModules)) $buildInModules = $this->getBuildinModules();

        if(!isset($this->lang->{$app}->menuOrder)) $this->lang->{$app}->menuOrder = array();
        foreach($menus as $moduleName => $moduleMenu)
        {
            if($app == 'mainNav' && $moduleName == 'menuOrder') continue;

            if(!in_array($moduleName, $this->lang->{$app}->menuOrder)) $this->lang->{$app}->menuOrder[] = $moduleName;
        }

        ksort($this->lang->{$app}->menuOrder);

        $moduleKey = array_search($module, $this->lang->{$app}->menuOrder);
        if($moduleKey) unset($this->lang->{$app}->menuOrder[$moduleKey]);

        $i = 5;
        foreach($this->lang->{$app}->menuOrder as $moduleMenu)
        {
            if($moduleMenu == $positionModule)
            {
                if($position == 'before')
                {
                    $system = isset($buildInModules[$module]);
                    $this->custom->setItem("all.{$app}.menuOrder.{$i}.{$system}", $module);

                    $i += 5;
                    $system = isset($buildInModules[$moduleMenu]);
                    $this->custom->setItem("all.{$app}.menuOrder.{$i}.{$system}", $moduleMenu);
                }
                elseif($position == 'after')
                {
                    $system = isset($buildInModules[$moduleMenu]);
                    $this->custom->setItem("all.{$app}.menuOrder.{$i}.{$system}", $moduleMenu);

                    $i += 5;
                    $system = isset($buildInModules[$module]);
                    $this->custom->setItem("all.{$app}.menuOrder.{$i}.{$system}", $module);
                }
            }
            else
            {
                $system = isset($buildInModules[$moduleMenu]);
                $this->custom->setItem("all.{$app}.menuOrder.{$i}.{$system}", $moduleMenu);
            }

            $i += 5;
        }
        return !dao::isError();
    }

    /**
     * Disable approval of a flow.
     *
     * @param  string $module
     * @access public
     * @return bool
     */
    public function disableApproval($module)
    {
        $this->app->loadConfig('workflowaction');
        $flow = $this->getByModule($module);
        if($flow->approval == 'enabled')
        {
            $approval = $this->dao->select('*')->from($flow->table)
                ->where('deleted')->eq('0')
                ->andWhere('reviewStatus')->eq('doing')
                ->beginIF($module == 'caselib')->andWhere('type')->eq('library')->fi()
                ->beginIF($module == 'testsuite')->andWhere('type')->in('public,private')->fi()
                ->beginIF($module == 'execution')->andWhere('type')->eq('sprint')->fi()
                ->beginIF($module == 'project')->andWhere('type')->eq('project')->fi()
                ->beginIF($module == 'program')->andWhere('type')->eq('program')->fi()
                ->fetchAll();

            if($approval) return array('result' => 'fail', 'message' => $this->lang->workflowapproval->tips->processesInProgress);

            $this->dao->update(TABLE_WORKFLOW)->set('approval')->eq('disabled')->where('module')->eq($module)->exec();
            $this->dao->update(TABLE_WORKFLOWACTION)->set('status')->eq('disable')->where('module')->eq($module)->andWhere('action')->in($this->config->workflowaction->approval->actions)->exec();
        }
        return array('result' => 'success');
    }
}
