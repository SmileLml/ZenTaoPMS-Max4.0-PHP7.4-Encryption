<?php
class zentaobizTree extends treeModel
{
    /**
     * delete module.
     *
     * @param mixed $moduleID
     * @param mixed $null
     * @access public
     * @return void
     */
    public function delete($moduleID, $null = null)
    {
        if(!empty($this->app->user->feedback) or $this->cookie->feedbackView)
        {
            $module = $this->getById($moduleID);
            if($module->type != 'doc') return false;
        }
        return parent::delete($moduleID);
    }

    /**
     * Get feedback tree menu.
     *
     * @param  string $userFunc
     *
     * @access public
     * @return string
     */
    public function getFeedbackTreeMenu($userFunc = '')
    {
        $menu = "<ul id='modules' class='tree' data-ride='tree' data-name='tree-feedback'>";

        /* Get module according to product. */
        $products = $this->loadModel('feedback')->getGrantProducts();

        $syncConfig = json_decode($this->config->global->syncProduct, true);
        $syncConfig = isset($syncConfig['feedback']) ? $syncConfig['feedback'] : array();
        $productNum = count($products);
        $productID  = $this->session->feedbackProduct;
        if($productID and isset($products[$productID])) $products = array($productID => $products[$productID]);

        /* Create module tree.*/
        foreach($products as $id => $product)
        {
            $feedbackProductLink = helper::createLink('feedback', $this->config->vision == 'lite' ? 'browse' : 'admin', "browseType=byProduct&param=$id");
            if($productNum >= 1) $menu .= "<li>" . html::a($feedbackProductLink, $product, '_self', "id='product$id' title=$product");
            $type = isset($syncConfig[$id]) ? 'story,feedback' : 'feedback';

            /* tree menu. */
            $tree = '';
            $treeMenu = array();
            $query = $this->dao->select('*')->from(TABLE_MODULE)
                ->where('root')->eq($id)
                ->andWhere('type')->in($type)
                ->andWhere('deleted')->eq(0)
                ->orderBy('grade desc, `order`, type')
                ->get();
            $stmt = $this->dbh->query($query);
            while($module = $stmt->fetch())
            {
                /* If is merged add story module.*/
                if($module->type == 'story' and $module->grade > $syncConfig[$id]) continue;

                /* If not manage, ignore unused modules. */
                $this->buildTree($treeMenu, $module, 'feedback', $userFunc, '');
            }
            $tree .= isset($treeMenu[0]) ? $treeMenu[0] : '';

            if($productNum >= 1) $tree = "<ul>" . $tree . "</ul>\n</li>";
            $menu .= $tree;
        }

        $menu .= '</ul>';
        return $menu;
    }

    /**
     * Get ticket tree menu.
     *
     * @param  string $userFunc
     *
     * @access public
     * @return string
     */
    public function getTicketTreeMenu($userFunc = '')
    {
        $menu = "<ul id='modules' class='tree' data-ride='tree' data-name='tree-ticket'>";

        /* Get module according to product. */
        $products = $this->loadModel('feedback')->getGrantProducts();

        $syncConfig = json_decode($this->config->global->syncProduct, true);
        $syncConfig = isset($syncConfig['ticket']) ? $syncConfig['ticket'] : array();
        $productNum = count($products);
        $productID  = $this->session->ticketProduct;
        if($productID and isset($products[$productID])) $products = array($productID => $products[$productID]);

        /* Create module tree.*/
        foreach($products as $id => $product)
        {
            $ticketProductLink = helper::createLink('ticket', 'browse', "browseType=byProduct&param=$id");
            if($productNum >= 1) $menu .= "<li>" . html::a($ticketProductLink, $product, '_self', "id='product$id' title=$product");
            $type = isset($syncConfig[$id]) ? 'story,ticket' : 'ticket';

            /* tree menu. */
            $tree = '';
            $treeMenu = array();
            $query = $this->dao->select('*')->from(TABLE_MODULE)
                ->where('root')->eq($id)
                ->andWhere('type')->in($type)
                ->andWhere('deleted')->eq(0)
                ->orderBy('grade desc, `order`, type')
                ->get();
            $stmt = $this->dbh->query($query);
            while($module = $stmt->fetch())
            {
                /* If is merged add story module.*/
                if($module->type == 'story' and $module->grade > $syncConfig[$id]) continue;

                /* If not manage, ignore unused modules. */
                $this->buildTree($treeMenu, $module, 'ticket', $userFunc, '');
            }
            $tree .= isset($treeMenu[0]) ? $treeMenu[0] : '';

            if($productNum >= 1) $tree = "<ul>" . $tree . "</ul>\n</li>";
            $menu .= $tree;
        }

        $menu .= '</ul>';
        return $menu;
    }
}
