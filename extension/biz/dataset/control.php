<?php
/**
 * The control file of dataset module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dept
 * @version     $Id: control.php 4157 2013-01-20 07:09:42Z wwccss $
 * @link        http://www.zentao.net
 */
class dataset extends control
{
    /**
     * Browse page.
     *
     * @param  string $type interal|custom
     * @access public
     * @return void
     */
    public function browse($type = 'internal')
    {
        $this->view->tables = $this->dataset->getList($type);
        $this->view->title  = $this->lang->dataset->common;
        $this->view->type   = $type;
        $this->display();
    }

    /**
     * View page.
     *
     * @param  string $key
     * @access public
     * @return void
     */
    public function view($key)
    {
        $table = $this->dataset->getTableInfo($key);

        $this->view->type  = 'data';
        $this->view->table = $table;
        $this->view->rows  = $this->dataset->getTableData($table->schema, 'id_desc', 100);
        $this->view->title = $table->name;
        $this->display();
    }

    /**
     * Ajax get filters
     *
     * @param array $datasets
     * @access public
     * @return array
     */
    public function ajaxGetFilters($datasets)
    {
        $datasets = explode(',', $datasets);
        $filters  = $this->dataset->getFilters($datasets);
        echo json_encode($filters);
    }

    /**
     * Create dataset.
     *
     * @param string $dataset
     * @access public
     * @return void
     */
    public function create($dataset = '')
    {
        if(!empty($_POST))
        {
            $datasetID = $this->dataset->create();
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('dataset', $datasetID, 'opened');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('dataset', 'browse', "type=custom")));
        }

        $this->view->title = $this->lang->dataset->create;
        $this->display();
    }

    /**
     * Edit dataset.
     *
     * @param int $datasetID
     * @access public
     * @return void
     */
    public function edit($datasetID)
    {
        if(!empty($_POST))
        {
            $this->dataset->update($datasetID);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('dataset', $datasetID, 'updated');

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('dataset', 'browse', "type=custom")));
        }

        $allTypeOptions = array();
        $dataset = $this->dataset->getByID($datasetID);
        foreach($dataset->fieldSettings as $field => $setting)
        {
            if($setting->object) $allTypeOptions[$setting->object] = $this->dataset->getTypeOptions($setting->object);
        }

        $this->view->dataset = $dataset;
        $this->view->allTypeOptions = $allTypeOptions;
        $this->view->title = $this->lang->dataset->edit;
        $this->display();
    }

    /**
     * Ajax query, get fields and result.
     *
     * @access public
     * @return void
     */
    public function ajaxQuery()
    {
        $sql  = $this->post->sql;
        $vars = array();

        if(preg_match_all("/[\$]+[a-z.A-Z]+/", $sql, $out))
        {
            foreach($out[0] as $match)
            {
                $var = explode('.', $match);
                if(count($var) != 2) return $this->send(array('result' => 'fail', 'message' => $this->lang->dataset->varError));
                $vars[] = substr($match, 1);
            }
        }

        $filters  = $this->dataset->getVarFilters($vars);
        $querySQL = $sql;
        foreach($filters as $filter)
        {
            $key = empty($filter->options) ? '' : key($filter->options);
            $querySQL = str_replace('$' . $filter->var, "'$key'", $querySQL);
        }
        $this->app->loadClass('sqlparser', true);
        $parser = new sqlparser($querySQL);

        if(count($parser->statements) == 0) return $this->send(array('result' => 'fail', 'message' => $this->lang->dataset->empty));
        if(count($parser->statements) > 1) return $this->send(array('result' => 'fail', 'message' => $this->lang->dataset->onlyOne));
        $statement = $parser->statements[0];

        if($statement instanceof PhpMyAdmin\SqlParser\Statements\SelectStatement == false)
        {
            return $this->send(array('result' => 'fail', 'message' => $this->lang->dataset->onlySelect));
        }

        /* Check fields. */
        $fields = array();
        foreach($statement->expr as $expr)
        {
            if($expr->expr == '*') return $this->send(array('result' => 'fail', 'message' => $this->lang->dataset->noStar));
            $fields[] = $expr->alias ? $expr->alias : $expr->expr;
        }

        /* Limit 100. */
        if(!$statement->limit)
        {
            $limit = new stdclass();
            $limit->offset   = 0;
            $limit->rowCount = 100;
            $statement->limit = $limit;
        }
        else
        {
            $statement->limit->rowCount = 100;
        }

        $sql = $statement->build();

        try {
            $rows = $this->dbh->query($sql)->fetchAll();
        }
        catch(Exception $e)
        {
            return $this->send(array('result' => 'fail', 'message' => $e));
        }

        return $this->send(array('result' => 'success', 'rows' => $rows, 'fields' => $fields, 'filters' => $filters));
    }

    public function ajaxGetTypeOptions($objectName)
    {
        $options = $this->dataset->getTypeOptions($objectName);
        return $this->send(array('result' => 'success', 'options' => $options));
    }

    /**
     * Delete a dataset.
     *
     * @param  int    $datasetID
     * @param  string $confirm  yes|no
     * @param  string $from taskkanban
     * @access public
     * @return void
     */
    public function delete($datasetID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->dataset->confirmDelete, inlink('delete', "id=$datasetID&confirm=yes")));
        }
        else
        {
            $this->dataset->delete(TABLE_DATASET, $datasetID);

            if(isonlybody()) return print(js::reload('parent.parent'));

            $locateLink = $this->session->datasetList ? $this->session->datasetList : inlink('browse', "type=custom");
            return print(js::locate($locateLink, 'parent'));
        }
    }
}
