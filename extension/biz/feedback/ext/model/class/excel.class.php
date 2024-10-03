<?php
class excelFeedback extends feedbackModel
{
    /**
     * Set export list value
     *
     * @access public
     * @return void
     */
    public function setListValue()
    {
        $modulesProductMap = $this->dao->select('id, `root`')->from(TABLE_MODULE)
            ->where('type')->eq('feedback')
            ->andWhere('deleted')->eq('0')
            ->fetchAll('id');

        $modules = $this->loadModel('tree')->getOptionMenu(0, 'feedback', 0, 0);

        foreach($modules as $id => $module) $modules[$id] .= "(#$id)";

        $moduleList = array();
        /* Group by module for cascade. */
        foreach($modules as $id => $module)
        {
            if(empty($modulesProductMap[$id]->root)) continue;
            $productID = $modulesProductMap[$id]->root;
            $moduleList[$productID][$id] = $module;
        }

        $this->post->set('moduleList',  ($this->post->fileType == 'xlsx' and $moduleList) ? $moduleList : $modules);
    }
}
