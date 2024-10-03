<?php
/**
 * The model file of traincourse module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Mengyi Liu <liumengyi@cnezsoft.com>
 * @package     task
 * @version     $Id: control.php 5106 2022-02-08 17:15:54Z $
 * @link        https://www.zentao.net
 */
class traincourseModel extends model
{
    /**
     * Get courseList.
     *
     * @param  string $browseType
     * @param  int    $categoryID
     * @param  string $orderBy
     * @param  int    $queryID
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getCourseList($browseType, $categoryID, $orderBy, $queryID, $pager)
    {
        $browseType = ($browseType == 'byModule' and $this->session->courseBrowseType and $this->session->courseBrowseType != 'bySearch') ? $this->session->courseBrowseType : $browseType;
        $categories = $categoryID ? $this->getChildCategoryID($categoryID) : '0';

        $doingList  = array();
        $doneList   = array();
        $waitList   = array();
        $courseList = array();

        $doingList = $this->getRecordPairs('doing');
        $doneList  = $this->getRecordPairs('done');
        if(in_array($browseType, array('doing', 'done')))
        {
            $courseList = $this->getRecordPairs($browseType);
        }
        elseif(in_array($browseType, array('wait', 'all', 'bySearch', 'byModule')))
        {
            $doingDoneList = array_keys($doingList + $doneList);
            $allList       = $this->dao->select('id')->from(TABLE_TRAINCOURSE)->fetchPairs();
            $waitList      = array_diff($allList, $doingDoneList);
            $courseList    = $waitList;
        }

        if($browseType == 'bySearch')
        {
            $courses = $this->getSearchCourses($queryID, $pager);
        }
        else
        {
            $courses = $this->dao->select('*')->from(TABLE_TRAINCOURSE)
                ->where('deleted')->eq(0)
                ->andWhere('status')->eq('online')
                ->beginIF($categoryID)->andWhere('category')->in($categories)
                ->beginIF(in_array($browseType, array('doing', 'done', 'wait')))->andWhere('id')->in($courseList)->fi()
                ->orderBy($orderBy)
                ->page($pager)
                ->fetchAll('id');
        }

        foreach($courses as $course)
        {
            if(in_array($browseType, array('donig', 'done', 'wait')))
            {
                $course->progress = $browseType;
            }
            else
            {
                if(isset($doingList[$course->id])) $course->progress = 'doing';
                if(isset($waitList[$course->id]))  $course->progress = 'wait';
                if(isset($doneList[$course->id]))  $course->progress = 'done';
            }

            $course->articleCount = $this->getArticleCount($course->id);
            $course->doneCount    = count($this->getRecordPairs('done', 'chapter', $course->id));
        }

        return $courses;
    }

    /**
     * Get child category id pairs.
     *
     * @param  int    $categroyID
     * @access public
     * @return array
     */
    public function getChildCategoryID($categoryID)
    {
        if($categoryID == 0) return array();

        $category = $this->getCategoryByID((int)$categoryID);
        if(empty($category)) return array();

        return $this->dao->select('id')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->andWhere('path')->like($category->path . '%')
            ->fetchPairs();
    }

    /**
     * Get list for manage.
     *
     * @param  string  $browseType
     * @param  int     $moduleID
     * @param  string  $orderBy
     * @param  object  $pager
     * @access public
     * @return array
     */
    public function getList4Manage($browseType, $categoryID, $orderBy, $pager)
    {
        $browseType = ($browseType == 'bymodule' and $this->session->courseManageBrowseType and $this->session->courseManageBrowseType != 'bysearch') ? $this->session->courseManageBrowseType : $browseType;
        $categories = $categoryID ? $this->getAllCategoryChildID($categoryID) : '0';

        $courses = $this->dao->select('*')->from(TABLE_TRAINCOURSE)
            ->where('deleted')->eq(0)
            ->beginIF($categoryID)->andWhere('category')->in($categories)->fi()
            ->beginIF($browseType == 'createdbyme')->andWhere('createdBy')->in($this->app->user->account)->fi()
            ->beginIf($browseType == 'offline')->andWhere('status')->eq($browseType)->fi()
            ->beginIf($browseType == 'online')->andWhere('status')->eq($browseType)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        return $courses;
    }

    /**
     * Get a course by id.
     *
     * @param  int    $courseID
     * @access public
     * @return object
     */
    public function getById($courseID)
    {
        $course = $this->dao->select('*')->from(TABLE_TRAINCOURSE)->where('id')->eq($courseID)->fetch();
        return $this->loadModel('file')->replaceImgURL($course, 'desc');
    }

    /**
     * Get course pairs.
     *
     * @param  string   $skill
     * @access public
     * @return array
     */
    public function getPairs()
    {
        $courses = $this->dao->select('id, name')->from(TABLE_TRAINCOURSE)
            ->where('deleted')->eq(0)
            ->fetchPairs();

        return $courses;
    }

    /**
     * Get a chapter by id.
     *
     * @param  int    $chapterID
     * @access public
     * @return object
     */
    public function getChapterById($chapterID)
    {
        $chapter = $this->dao->select('*')->from(TABLE_TRAINCONTENTS)->where('id')->eq($chapterID)->fetch();
        $chapter = $this->loadModel('file')->replaceImgURL($chapter, 'content');
        $file    = $this->loadModel('file')->getByObject('traincontents', $chapterID);
        if($chapterID != 0 and !empty($file)) $chapter->files = $file;

        return $chapter;
    }

    /**
     * Get category info by id.
     *
     * @param  int    $categoryID
     * @access public
     * @return bool|object
     */
    public function getCategoryByID($categoryID)
    {
        $category = $this->dao->select('*')->from(TABLE_TRAINCATEGORY)->where('id')->eq($categoryID)->fetch();

        if(!$category) return false;

        return $category;
    }

    /**
     * Get pairs chapter.
     *▫
     * @param  int    $courseID
     * @param  string $type
     * @param  string $orderBy
     * @access public
     * @return array
     */
    public function getChapterPairs($courseID, $type = '', $orderBy = 'id_desc')
    {
        return $this->dao->select('id, name')->from(TABLE_TRAINCONTENTS)
            ->where('deleted')->eq(0)
            ->beginIF(!empty($courseID))->andWhere('course')->eq($courseID)
            ->beginIF(!empty($type))->andWhere('type')->eq($type)
            ->orderBy($orderBy)
            ->fetchPairs();
    }

    /**
     * Get chapter children.
     *
     * @param  int    $courseID
     * @param  int    $nodeID
     * @param  string $sql
     * @access public
     * @return array
     */
    public function getChapterChildren($courseID, $nodeID = 0, $sql = '')
    {
        return $this->dao->select('*')->from(TABLE_TRAINCONTENTS)
            ->where('deleted')->eq(0)
            ->andWhere('course')->eq($courseID)
            ->beginIF(empty($nodeID) || $nodeID != 'all')->andWhere('parent')->eq($nodeID)->fi()
            ->beginIF(!empty($sql))->andWhere($sql)->fi()
            ->orderBy('`order`')
            ->fetchAll('id');
    }

    /**
     * Get chapter status.
     *
     * @param  int    $chapterID
     * @param  str    $account
     * @access public
     * @return string
     */
    public function getChapterStatus($objectID, $account = '')
    {
        $account = empty($account) ? $this->app->user->account : $account;
        return $this->dao->select('status')->from(TABLE_TRAINRECORDS)
            ->where('objectID')->eq($objectID)
            ->andWhere('objectType')->eq('chapter')
            ->andWhere('user')->eq($account)
            ->fetch('status');
    }

    /**
     * Get courses option menu.
     *
     * @param  int     $courseID
     * @param  bool    $removeRoot
     * @param  int     $rejectChapterID
     * @param  string  $objectType chapter|category
     * @access public
     * @return array
     */
    public function getOptionMenu($courseID = 0, $removeRoot = false, $rejectChapterID = 0, $objectType = 'chapter')
    {
        /* First, get all catalogues. */
        $treeMenu = array();
        $orderBy  = 'parent desc, `order`, id';
        if($objectType == 'chapter') $catalogues = $this->getChapters($courseID, $objectType, $orderBy);
        if($objectType != 'chapter') $catalogues = $this->getAllCategory($orderBy);

        /* Cycle them, build the select control.  */
        foreach($catalogues as $catalogue)
        {
            $origins = explode(',', $catalogue->path);
            if(!empty($rejectChapterID) && in_array($rejectChapterID, $origins) && count($origins) > 3) continue;

            $catalogueTitle = '';
            foreach($origins as $origin)
            {
                if(empty($origin)) continue;
                $catalogueTitle .= $catalogues[$origin]->name . '/';
            }

            $catalogueTitle  = rtrim($catalogueTitle, '/');
            $catalogueTitle .= "|$catalogue->id\n";

            if(isset($treeMenu[$catalogue->id]) and !empty($treeMenu[$catalogue->id]) and $rejectChapterID != $catalogue->id)
            {
                if(isset($treeMenu[$catalogue->parent]))
                {
                    $treeMenu[$catalogue->parent] .= $catalogueTitle;
                }
                else
                {
                    $treeMenu[$catalogue->parent] = $catalogueTitle;;
                }

                $treeMenu[$catalogue->parent] .= $treeMenu[$catalogue->id];
            }
            elseif($rejectChapterID != $catalogue->id)
            {
                if(isset($treeMenu[$catalogue->parent]) and !empty($treeMenu[$catalogue->parent]))
                {
                    $treeMenu[$catalogue->parent] .= $catalogueTitle;
                }
                else
                {
                    $treeMenu[$catalogue->parent] = $catalogueTitle;
                }
            }
        }

        $topMenu = @array_pop($treeMenu);
        $topMenu = explode("\n", trim($topMenu));
        if(!$removeRoot) $lastMenu[] = '/';

        foreach($topMenu as $menu)
        {
            if(!strpos($menu, '|')) continue;

            $menu        = explode('|', $menu);
            $label       = array_shift($menu);
            $catalogueID = array_pop($menu);

            $lastMenu[$catalogueID] = $label;
        }

        if(!isset($lastMenu)) $lastMenu = array();
        return $lastMenu;
    }

    /**
     * Get admin catalog.
     *
     * @param  int     $courseID
     * @param  int     $nodeID
     * @param  array   $serials
     * @param  bool    $action
     * @param  int     $chapterID
     * @access public
     * @return void
     */
    public function getAdminChapter($courseID, $nodeID, $serials, $action = true, $chapterID = 0)
    {
        $catalog = '';
        $course  = $this->getById($courseID);
        $node    = $this->getChapterById($nodeID);
        if(!$node)
        {
            $node = new stdclass();
            $node->id    = $course->id;
            $node->name  = $course->name;
            $node->type  = 'course';
        }

        $active = '';
        if(!empty($chapterID) && $chapterID == $nodeID) $active =  'active';

        $children = $this->getChapterChildren($courseID, $nodeID);
        if($node->type != 'course') $serial = $serials[$nodeID];
        //if(empty($node->parent)) $serial = '';

        $anchor = "name='node{$node->id}' id='node{$node->id}' title='{$this->lang->edit}'";

        /* Set title. */
        if($node->type == 'course' or $node->type == 'chapter')  $titleLink = $node->name;
        if($node->type == 'video') $titleLink = html::a(helper::createLink('traincourse', 'viewchapter', "node=$node->id"), $node->name, '', "title='$node->name'");

        /* Print action btn. */
        $editLink    = commonModel::hasPriv('traincourse', 'editchapter')    ? html::a(helper::createLink('traincourse', 'editChapter', "nodeID=$node->id"), "<i class='icon-common-edit icon-edit'></i>", '', $anchor) : '';
        $delLink     = commonModel::hasPriv('traincourse', 'deletechapter')  ? html::a(helper::createLink('traincourse', 'deleteChapter', "nodeID=$node->id"), "<i class='icon-common-delete icon-trash'></i>", "hiddenwin", "title='{$this->lang->delete}'") : '';
        $catalogLink = commonModel::hasPriv('traincourse', 'managechapter') ? html::a(helper::createLink('traincourse', 'manageChapter', "courseID=$courseID&nodeID=$node->id"),"<i class='icon-traincourse-manageCourse icon-plus'></i>" , '', "title='{$this->lang->traincourse->manageChapter}'") : '';
        $moveLink    = commonModel::hasPriv('traincourse', 'sortchapter')    ? html::a('javascript:;', "<i class='icon-move'></i>", '', "class='sort sort-handle'") : '';

        $childrenHtml = '';
        if($children)
        {
            $childrenHtml .= '<dl>';
            foreach($children as $child) $childrenHtml .=  $this->getAdminChapter($courseID, $child->id, $serials, $action, $chapterID);
            $childrenHtml .= '</dl>';
        }

        /* Add status icon. */
        if(!empty($nodeID))
        {
            $status     = $this->getChapterStatus($nodeID) == 'done' ? 'checked' : '';
            $statusHtml = '';
            if(!$action) $statusHtml = "<div class='checkbox-primary $status'><label></label></div>";
        }

        /* Compute duration. */
        $durationHtml = '';
        if($node->type == 'video' and !$action)
        {
            $extension = '';
            if(!empty($node->files))
            {
                $file = reset($node->files);
                $extension = $file->extension;
            }

            $durationHtml .= "<span>";
            if(!empty($chapterID) && $chapterID == $nodeID)
            {
                $sign = '';
                if($extension == 'mp4') $sign = '/';
            }
            $durationHtml .= "</span>";
        }


        if(($this->app->moduleName == 'traincourse' and $this->app->methodName == 'view') || !$action) $editLink = $catalogLink = $delLink = $moveLink = '';
        if($node->type == 'course')  $catalog .= $childrenHtml;
        if($node->type == 'chapter') $catalog .= "<dd class='catalog chapter' data-id='" . $node->id . "'><strong class='flex'><span class='order labelBlock'>" . $serial . "</span><span class='text-ellipsis' title='$node->name'>" . $titleLink . '</span></strong><span class="actions">' . $editLink . $catalogLink . $delLink . $moveLink . '</span>' . $childrenHtml . '</dd>';
        if($node->type == 'video') $catalog .= "<dd class='catalog article $active' data-id='" . $node->id . "'><span class='flex'>" . $statusHtml . "<span class='radio-primary'><span class='order'>" . $serial . '</span>&nbsp;' . $titleLink . '</span> ' . '<span class="actions">' . $editLink . $delLink . $moveLink . '</span></span>' . $durationHtml . $childrenHtml . '</dd>';

        return $catalog;

    }

    /**
     * Sec to time.
     *
     * @param  int    $times
     * @access public
     * @return string
     */
    public function secToTime($times = 0)
    {
        $result = '00:00:00';
        if($times > 0)
        {
            $hour   = floor($times / 3600);
            $minute = floor(($times - 3600 * $hour) / 60);
            $second = floor((($times - 3600 * $hour) - 60 * $minute) % 60);
            $result = sprintf("%02d", $hour) . ':' . sprintf("%02d", $minute) . ':' . sprintf("%02d", $second);
        }

        return $result;
    }

    /**
     * Get id list of a module's childs.
     *
     * @param  int     $moduleID
     * @access public
     * @return array
     */
    public function getAllCategoryChildID($moduleID)
    {
        if($moduleID == 0) return array();

        $module = $this->getCategoryById((int)$moduleID);
        if(empty($module)) return array();

        return $this->dao->select('id')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->andWhere('path')->like($module->path . '%')
            ->fetchPairs();
    }

    /**
     * Get category menu.
     *
     * @param  string $type
     * @access public
     * @return string
     */
    public function getTreeMenu($type = 'traincourse')
    {
        $lastMenu = '';

        $categoryMenu = array();
        $funcLink     = 'createCourseLink';

        $stmt = $this->dbh->query($this->buildMenuQuery(0, 'trainskill', 0));
        while($module = $stmt->fetch()) $this->buildTree($categoryMenu, $module, $type, array('traincourseModel', $funcLink));
        ksort($categoryMenu);
        $lastMenu .= array_shift($categoryMenu);

        if($lastMenu) $lastMenu = "<ul id='modules' class='tree' data-ride='category' data-name='category-{$type}'>$lastMenu</ul>\n";

        return $lastMenu;
    }

    /**
     * Get the id => name pairs of some categories.
     *
     * @param  string $orderBy
     * @access public
     * @return array
     */
    public function getCategoryPairs($orderBy)
    {
        return $this->dao->select('id,name')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->orderBy($orderBy)
            ->fetchPairs();
    }

    /**
     * Get the category menu in <ul><ol> type.
     *
     * @param  string   $type           the category type
     * @param  int      $startCategoryID  the start category
     * @param  string   $userFunc       which function to be called to create the link
     * @access public
     * @return string   the html code of the category menu.
     */
    public function getCategoryTreeMenu($type = 'trainskill', $startCategoryID = 0, $userFunc = '')
    {
        $categoryMenu = array();
        $categories   = array();
        $stmt = $this->dbh->query($this->buildCategoryQuery($type, $startCategoryID));
        while($category = $stmt->fetch())
        {
            $categories[$category->id] = $category;
        }
        $categories = $this->process($categories, $type);
        foreach($categories as $category)
        {
            $linkHtml = call_user_func($userFunc, $type, $category);

            if(isset($categoryMenu[$category->id]) and !empty($categoryMenu[$category->id]))
            {
                if(!isset($categoryMenu[$category->parent])) $categoryMenu[$category->parent] = '';
                $categoryMenu[$category->parent] .= "<li>$linkHtml";
                $categoryMenu[$category->parent] .= "<ul>".$categoryMenu[$category->id]."</ul>\n";
            }
            else
            {
                if(isset($categoryMenu[$category->parent]) and !empty($categoryMenu[$category->parent]))
                {
                    $categoryMenu[$category->parent] .= "<li>$linkHtml\n";
                }
                else
                {
                    $categoryMenu[$category->parent] = "<li>$linkHtml\n";
                }
            }
            $categoryMenu[$category->parent] .= "</li>\n";
        }

        $lastMenu = @array_pop($categoryMenu);
        if($lastMenu) $lastMenu = "<ul class='tree'>" . $lastMenu . "</ul>\n";
        return $lastMenu;
    }

    /**
     * Get children categories of one category.
     *
     * @param  int    $categoryID
     * @access public
     * @return array
     */
    public function getCategoryChildren($categoryID)
    {
        return $this->dao->select('*')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->andWhere('parent')->eq((int)$categoryID)
            ->orderBy('`order`')
            ->fetchAll('id');
    }

    /**
     * Get origin of a category.
     *
     * @param  int     $categoryID
     * @access public
     * @return array
     */
    public function getCategoryOrigin($categoryID)
    {
        if($categoryID == 0) return array();

        $path = $this->dao->select('path')->from(TABLE_TRAINCATEGORY)->where('id')->eq((int)$categoryID)->fetch('path');
        $path = trim($path, ',');
        if(!$path) return array();

        return $this->dao->select('*')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->andWhere('id')->in($path)
            ->fetchAll('id');
    }

    /**
     * Get id list of a category family.
     *
     * @param  int      $categoryID
     * @access public
     * @return array
     */
    public function getCategoryFamily($categoryID)
    {
        if($categoryID == 0) return array();
        $categories = $this->getCategoryById($categoryID);

        if($categories)
        {
            return $this->dao->select('id')->from(TABLE_TRAINCATEGORY)
                ->where('deleted')->eq('0')
                ->andWhere('path')->like($categories->path . '%')
                ->fetchPairs();
        }
        else
        {
            return $this->dao->select('id')->from(TABLE_TRAINCATEGORY)
                ->where('deleted')->eq('0')
                ->fetchPairs();
        }
    }

    /**
     * Get active chapter id.
     *
     * @param  int    $courseID
     * @param  string $account
     * @access public
     * @return int
     */
    public function getActiveChapterID($courseID, $account = '')
    {
        $account = empty($account) ? $this->app->user->account : $account;

        $chapterList = $this->getChapterPairs($courseID, 'video', '`order`');

        $doneChapterList = $this->dao->select('id, name')->from(TABLE_TRAINCONTENTS)->alias('t1')
            ->leftJoin(TABLE_TRAINRECORDS)->alias('t2')->on('t1.id = t2.objectId')
            ->where('t1.course')->eq($courseID)
            ->andWhere('objectType')->eq('chapter')
            ->andWhere('status')->eq('done')
            ->andWhere('user')->eq($account)
            ->fetchPairs();

       return empty($doneChapterList) ? '' : key(array_diff($chapterList, $doneChapterList));
    }

    /**
     * Get number of learned.
     *
     * @param  int    $courseID
     * @access public
     * @return int
     */
    public function getNumberOfLearned($courseID)
    {
        $learned = $this->dao->select('user')->from(TABLE_TRAINRECORDS)
            ->where('objectID')->eq($courseID)
            ->fetchAll('user');
        return count($learned);
    }

    /**
      * Get next chapter id.
      *
      * @param  int    $courseID
      * @param  int    $chapterID
      * @access public
      * @return string|int
      */
    public function getNextChapterID($courseID, $chapterID)
    {
        $nextChapterID = '';
        $queue = $this->getChapterSort($courseID, 0);
        if(!empty($queue))
        {
            $current = array_search($chapterID, $queue);
            if($current == (count($queue) - 1))
            {
                $nextChapterID = 'end';
            }
            else
            {
                $nextChapterID = $queue[$current + 1];
            }
        }

        return $nextChapterID;
    }

    /**
     * Get children.
     *
     * @param  int    $courseID
     * @param  int    $nodeID
     * @param  string $sql
     * @access public
     * @return array
     */
    public function getChildren($courseID, $nodeID = 0, $sql = '')
    {
        return $this->dao->select('*')->from(TABLE_TRAINCONTENTS)
            ->where('deleted')->eq(0)
            ->andWhere('course')->eq($courseID)
            ->beginIF(empty($nodeID) || $nodeID != 'all')->andWhere('parent')->eq($nodeID)->fi()
            ->beginIF(!empty($sql))->andWhere($sql)->fi()
            ->orderBy('`order`, id')
            ->fetchAll('id');
    }

    /**
     * Remove repeat.
     *
     * @param  int    $courseID
     * @param  int    $nodeID
     * @access public
     * @return array
     */
    public function getChapterSort($courseID, $nodeID)
    {
        $queue    = array();
        $node     = $this->getChapterById($nodeID);
        $children = $this->getChildren($courseID, $nodeID);

        if(!empty($children))
        {
            foreach($children as $chapter)
            {
                if($chapter->type == 'video') $queue[] = $chapter->id;
                $chapterIDList = $this->getChapterSort($courseID, $chapter->id);
                if(!empty($chapterIDList))
                {
                    foreach($chapterIDList as $chapterID) $queue[] = $chapterID;
                }
            }
        }

        return $queue;
    }

    /**
     * Get a course structure.
     *
     * @param  int    $courseID
     * @access public
     * @return void
     */
    public function getCourseStructure($courseID)
    {
        $stmt = $this->dbh->query($this->dao->select('id, course, type, path, `order`, parent, name')->from(TABLE_TRAINCONTENTS)->where('course')->eq($courseID)->andWhere('deleted')->eq(0)->orderBy('`order`, id')->get());

        $parent = array();
        while($node = $stmt->fetch())
        {
            if(!isset($parent)) $parent = array();

            if(isset($parent[$node->id]))
            {
                $node->children = $parent[$node->id]->children;
                unset($parent[$node->id]);
            }
            if(!isset($parent[$node->parent])) $parent[$node->parent] = new stdclass();
            $parent[$node->parent]->children[] = $node;
        }

        $nodeList = array();
        foreach($parent as $node)
        {
            foreach($node->children as $children)
            {
                if($children->parent != 0 && !empty($nodeList))
                {
                    foreach($nodeList as $firstChildren)
                    {
                        if($firstChildren->id == $children->parent) $firstChildren->children[] = $children;
                    }
                }
                $nodeList[] = $children;
            }
        }

        return $nodeList;
    }

    /**
     * Get front catalog.
     *
     * @param int     $nodes
     * @param int     $serials
     * @param int     $articleID
     * @access public
     * @return void
     */
    public function getFrontCatalog($nodes, $serials, $articleID = 0)
    {
        echo '<ul>';
        foreach($nodes as $childNode)
        {
            $serial = $childNode->type != 'course' ? $serials[$childNode->id] : '';
            $class = "class='open'";
            if($articleID && $articleID == $childNode->id) $class = "class='open active'";
            echo "<li $class>";

            if($this->app->methodName == 'editchapter')
            {
                echo "<span class='item'>{$serial} " . html::a(helper::createLink('traincourse', 'editChapter', "chapterID=$childNode->id"), $childNode->name) . '</span>';
            }
            else
            {
                if($childNode->type == 'chapter')
                {
                    echo "<span class='item'>{$serial} {$childNode->name}</span>";
                }
                elseif($childNode->type == 'video')
                {
                    echo "<span class='item'>{$serial} " . html::a(helper::createLink('traincourse', 'view', "chapterID=$childNode->id"), $childNode->name) . '</span>';
                }
            }

            if(!empty($childNode->children)) $this->getFrontCatalog($childNode->children, $serials, $articleID);
            echo '</li>';
        }
        echo '</ul>';
    }

    /**
     * Get record pairs.
     *
     * @param  string $status
     * @param  string $objectType
     * @param  int    $courseId
     * @access public
     * @return array
     */
    public function getRecordPairs($status, $objectType = 'course', $courseID = 0)
    {
        $chapterIDList = $objectType == 'chapter' ? $this->dao->select('id')->from(TABLE_TRAINCONTENTS)->where('deleted')->eq(0)->andWhere('course')->eq($courseID)->andWhere('type')->eq('video')->fetchPairs() : array();
        return $this->dao->select('objectId,objectId')->from(TABLE_TRAINRECORDS)
            ->where('objectType')->eq($objectType)
            ->andWhere('status')->eq($status)
            ->andWhere('user')->eq($this->app->user->account)
            ->beginIF($objectType == 'chapter' and isset($chapterIDList))->andWhere('objectId')->in($chapterIDList)->fi()
            ->fetchPairs();
    }

    /**
     * Create course.
     *
     * @access public
     * @return bool|int
     */
    public function createCourse()
    {
        $now    = helper::now();
        $course = fixer::input('post')
            ->add('createdBy', $this->app->user->account)
            ->add('createdDate', $now)
            ->add('editedDate', $now)
            ->add('status', 'offline')
            ->stripTags($this->config->traincourse->editor->createcourse['id'], $this->config->allowedTags)
            ->join('post', ',')
            ->remove('uid')
            ->get();
        $course->name = trim($course->name);

        $course = $this->loadModel('file')->processImgURL($course, $this->config->traincourse->editor->createcourse['id'], $this->post->uid);
        $this->dao->insert(TABLE_TRAINCOURSE)->data($course)->batchcheck($this->config->traincourse->create->requiredFields, 'notempty')->exec();

        if(!dao::isError())
        {
            $courseID = $this->dao->lastInsertID();

            $this->file->updateObjectID($this->post->uid, $courseID, 'traincourse');
            $this->file->saveUpload('traincourse', $courseID);

            return $courseID;
        }

        return false;
    }

    /**
     * Update a course.
     *
     * @param  int    $courseID
     * @access public
     * @return void
     */
    public function updateCourse($courseID)
    {
        $oldCourse = $this->getByID($courseID);

        $now    = date('Y-m-d', time());
        $course = fixer::input('post')
            ->add('editedBy', $this->app->user->account)
            ->add('editedDate', $now)
            ->add('createdBy', $oldCourse->createdBy)
            ->add('createdDate', $oldCourse->createdDate)
            ->add('status', $oldCourse->status)
            ->add('deleted', '0')
            ->stripTags($this->config->traincourse->editor->editcourse['id'], $this->config->allowedTags)
            ->remove('uid')
            ->get();

        $course = $this->loadModel('file')->processImgURL($course, $this->config->traincourse->editor->editcourse['id'], $this->post->uid);
        $this->dao->update(TABLE_TRAINCOURSE)->data($course)->batchcheck($this->config->traincourse->edit->requiredFields, 'notempty')->where('id')->eq($courseID)->exec();

        if(!dao::isError())
        {
            $this->file->updateObjectID($this->post->uid, $courseID, 'traincourse');
            return commonModel::createChanges($oldCourse, $course);
        }
    }

    /**
     * Get file by courseID.
     *
     * @param  int    $courseID
     * @param  string $extra
     * @access public
     * @return array
     */
    public function getFileByCourseID($courseID = 0, $extra = '')
    {
        if(empty($courseID)) return '';
        return $this->dao->select('*')->from(TABLE_FILE)
            ->where('objectType')->eq('traincourse')
            ->andWhere('objectID')->eq($courseID)
            ->beginIF(!empty($extra))->andWhere('extra')->eq($extra)->fi()
            ->fetchAll();
    }

    /**
     * Manage chapters.
     *
     * @param  int    $courseID
     * @param  int    $parentNodeID
     * @access public
     * @return bool
     */
    public function manageChapter($courseID, $parentNodeID = 0)
    {
        if($parentNodeID) $parentNode = $this->getChapterById($parentNodeID);

        /* Init the catalogue object. */
        $now  = helper::now();
        $node = new stdclass();
        $node->course = $courseID;
        $node->parent = $parentNodeID ? $parentNode->id : 0;

        $nodeContent = new stdclass();

        foreach($this->post->name as $key => $nodeTitle)
        {
            if(empty($nodeTitle)) continue;

            $node->desc  = $_POST['desc'][$key];
            if(isset($_POST['name'][0])) $key++;

            $mode = $_POST['mode'][$key];

            /* First, save the child without path field. */
            $node->name  = $nodeTitle;
            $node->type  = $_POST['type'][$key];
            $node->order = $_POST['order'][$key];

            if($mode == 'new')
            {
                $node->createdBy   = $this->app->user->account;
                $node->createdDate = $now;

                $this->dao->insert(TABLE_TRAINCONTENTS)->data($node)->exec();

                /* After saving, update it's path. */
                $nodeID   = $this->dao->lastInsertID();
                $nodePath = $parentNodeID ? $parentNode->path . "$nodeID," : ",$nodeID,";
                $this->dao->update(TABLE_TRAINCONTENTS)->set('path')->eq($nodePath)->where('id')->eq($nodeID)->exec();
            }
            else
            {
                $nodeID = $key;
                $node->editedBy   = $this->app->user->account;
                $node->editedDate = $now;
                $this->dao->update(TABLE_TRAINCONTENTS)->data($node)->autoCheck()->where('id')->eq($nodeID)->exec();
            }
        }

        return !dao::isError();
    }

    /**
     * Manage children of one category.
     *
     * @param  string $type
     * @param  int    $parent
     * @param  object $children
     * @access public
     * @return bool
     */
    public function manageCategoryChildren($type, $parent, $children)
    {
        /* Get parent. */
        $parent = $this->getCategoryByID($parent);

        /* Init the category object. */
        $category = new stdclass();
        $category->parent = $parent ? $parent->id : 0;
        $category->grade  = $parent ? $parent->grade + 1 : 1;

        $i = 1;
        foreach($children as $key => $categoryName)
        {
            if(empty($categoryName)) continue;
            $order = $i * 10;

            /* First, save the child without path field. */
            $category->name  = strip_tags(trim($categoryName));
            $category->order = $order;
            $mode = $this->post->mode[$key];

            if($mode == 'new')
            {
                unset($category->id);
                $this->dao->insert(TABLE_TRAINCATEGORY)->data($category)->exec();

                /* After saving, update it's path. */
                $categoryID   = $this->dao->lastInsertID();
                $categoryPath = $parent ? $parent->path . $categoryID . ',' : ",$categoryID,";
                $this->dao->update(TABLE_TRAINCATEGORY)
                    ->set('path')->eq($categoryPath)
                    ->where('id')->eq($categoryID)
                    ->exec();
            }
            else
            {
                $categoryID = $key;
                $this->dao->update(TABLE_TRAINCATEGORY)
                    ->set('name')->eq(strip_tags(trim($categoryName)))
                    ->set('order')->eq($order)
                    ->where('id')->eq($categoryID)
                    ->exec();
            }
            $i ++;
        }

        return !dao::isError();
    }

    /**
     * Update a category.
     *
     * @param  int     $categoryID
     * @access public
     * @return void
     */
    public function updateCategory($categoryID)
    {
        $category = fixer::input('post')->get();

        $category->name = strip_tags(trim($category->name));

        $parent = $this->getCategoryById($this->post->parent);
        $category->grade = $parent ? $parent->grade + 1 : 1;

        $this->dao->update(TABLE_TRAINCATEGORY)
            ->data($category, $skip = 'uid')
            ->autoCheck()
            ->check('name', 'notempty')
            ->where('id')->eq($categoryID)
            ->exec();

        $this->fixPath($categoryID, 'category');

        return !dao::isError();
    }


    /**
     * Update chapter.
     *
     * @param  int    $chapterID
     * @access public
     * @return string
     */
    public function updateChapter($chapterID)
    {
        $now  = helper::now();

        $oldChapter = $this->getChapterById($chapterID);

        $chapter = fixer::input('post')
            ->stripTags($this->config->traincourse->editor->editChapter['id'], $this->config->allowedTags)
            ->setDefault('editedBy', $this->app->user->account)
            ->setDefault('editedDate', $now)
            ->setIF($this->post->type === 'chapter', 'desc', '' )
            ->remove('uid')
            ->get();

        $chapter = $this->loadModel('file')->processImgURL($chapter, $this->config->traincourse->editor->editChapter['id'], $this->post->uid);

        $this->dao->update(TABLE_TRAINCONTENTS)->data($chapter)->autoCheck()->batchCheck('title', 'notempty')->where('id')->eq($chapterID)->exec();

        if(!dao::isError())
        {
            $this->file->updateObjectID($this->post->uid, $chapterID, 'chapter');
        }

        if($oldChapter->parent != $chapter->parent) $this->fixPath($oldChapter->course, 'chapter');
    }

    /**
     * Build the sql query.
     *
     * @param  int    $rootID
     * @param  string $type
     * @param  int    $startCategory
     * @access public
     * @return object
     */
    public function buildMenuQuery($rootID, $type, $startCategory)
    {
        /* Set the start module. */
        $startCategoryPath = '';
        if($startCategory > 0)
        {
            $startCategory = $this->getCategoryById($startCategory);
            if($startCategory) $startCategoryPath = $startCategory->path . '%';
        }

        return $this->dao->select('*')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->beginIF($startCategoryPath)->andWhere('path')->like($startCategoryPath)->fi()
            ->orderBy('grade desc')
            ->get();
    }

    /**
     * Build category.
     *
     * @param  object  $categoryMenu
     * @param  int     $module
     * @param  string  $type
     * @param  sting   $userFunc
     * @access public
     * @return void
     */
    public function buildTree(& $categoryMenu, $module, $type, $userFunc)
    {
        $linkHtml = call_user_func($userFunc, $module);

        if(isset($categoryMenu[$module->id]) and !empty($categoryMenu[$module->id]))
        {
            if(!isset($categoryMenu[$module->parent])) $categoryMenu[$module->parent] = '';
            $categoryMenu[$module->parent] .= "<li class='closed' title='$module->name'>$linkHtml";
            $categoryMenu[$module->parent] .= "<ul>" . $categoryMenu[$module->id] . "</ul>\n";
        }
        else
        {
            if(!isset($categoryMenu[$module->parent])) $categoryMenu[$module->parent] = "";
            $categoryMenu[$module->parent] .= "<li title='$module->name'>$linkHtml\n";
        }
        $categoryMenu[$module->parent] .= "</li>\n";
    }

    /**
     * Change status.
     *
     * @param  int    $courseID
     * @param  string $status
     * @access public
     * @return bool
     */
    public function changeStatus($courseID, $status)
    {
        $this->dao->update(TABLE_TRAINCOURSE)->set('status')->eq($status)->where('id')->eq($courseID)->exec();
        return dao::isError();
    }

    /**
     * Check account whether finished the course.
     *
     * @param  int    $chapterID
     * @param  string $account
     * @access public
     * @return void
     */
    public function changeCourseRecordStatus($courseID, $account = '')
    {
        $account = $account ? $account : $this->app->user->account;

        $chapterList      = $this->getChapterPairs($courseID, 'video');
        $finishedChapters = $this->dao->select('*')->from(TABLE_TRAINRECORDS)->where('objectID')->in(array_keys($chapterList))->andWhere('objectType')->eq('chapter')->andWhere('user')->eq($account)->andWhere('status')->eq('done')->fetchAll();

        $course = new stdclass();
        $course->user       = $account;
        $course->objectID   = $courseID;
        $course->objectType = 'course';

        if(count($finishedChapters) == 0)
        {
            $course->status = 'wait';
        }
        elseif(count($finishedChapters) == count($chapterList))
        {
            $course->status = 'done';
        }
        else
        {
            $course->status = 'doing';
        }

        $this->dao->replace(TABLE_TRAINRECORDS)->data($course)->exec();
    }

    /**
     * Create the manage link.
     *
     * @param  object         $category
     * @access public
     * @return string
     */
    public static function createManageCategoryLink($type, $category)
    {
        global $lang;

        /* Set the class of children link. */

        $linkHtml  = $category->name;
        $linkHtml .= ' ' . html::a(helper::createLink('traincourse', 'browseCategory', "type=editchapter&category={$category->id}"), "<i class='icon-common-edit icon-edit'></i>", '', "class='ajax' title='{$lang->traincourse->editCategory}'");
        $linkHtml .= ' ' . html::a(helper::createLink('traincourse', 'browseCategory', "type=trainskill&category={$category->id}&root=0"), "<i class='icon-common-create icon-split'></i>", '', "class='ajax' title='{$lang->traincourse->categoryChildren}'");
        $linkHtml .= ' ' . (!empty($category->major) ? html::a('#', $lang->delete, "disabled='disabled'") : html::a(helper::createLink('traincourse', 'deleteCategory',   "category={$category->id}"), "<i class='icon-common-delete icon-trash'></i>", '', "target='hiddenwin'"));

        return $linkHtml;
    }

    /**
     * Create course link.
     *
     * @param  int    $module
     * @access public
     * @return string
     */
    public function createCourseLink($module)
    {
        $method = $this->app->methodName;
        return html::a(helper::createLink('traincourse', $method, "type=byModule&param={$module->id}"), $module->name, '', "id='module{$module->id}'");
    }

    /**
     * Create category.
     *
     * @param  string $courseCategory
     * @access public
     * @return bool|int
     */
    public function createCategory($courseCategory)
    {
        if(empty($courseCategory)) return false;

        $categoryList = explode('/', $courseCategory);
        $categoryID   = 0;
        $path         = ',';
        foreach($categoryList as $index => $categoryName)
        {
            $grade = ++ $index;

            $category = $this->dao->select('*')->from(TABLE_TRAINCATEGORY)
                ->where('name')->eq($categoryName)
                ->andWhere('grade')->eq($grade)
                ->andWhere('parent')->eq($categoryID)
                ->andWhere('deleted')->eq(0)
                ->fetch();

            if($category)
            {
                $categoryID = $category->id;
                $path       = $category->path;
            }
            else
            {
                $category = new stdClass();
                $category->name   = $categoryName;
                $category->parent = $categoryID;
                $category->grade  = $grade;

                $this->dao->insert(TABLE_TRAINCATEGORY)->data($category)->exec();
                if(dao::isError()) return false;

                $categoryID = $this->dao->lastInsertID();
                $path      .= $categoryID . ',';

                $this->dao->update(TABLE_TRAINCATEGORY)
                    ->set('path')->eq($path)
                    ->set('order')->eq($categoryID * 5)
                    ->where('id')->eq($categoryID)
                    ->andWhere('deleted')->eq(0)
                    ->exec();
            }
        }

        return $categoryID;
    }

    /**
     * Import a course.
     *
     * @param  object $courseInfo
     * @param  int    $categoryID
     * @access public
     * @return bool|int
     */
    public function importCourse($courseInfo, $categoryID)
    {
        if(empty($courseInfo) or empty($categoryID)) return false;

        $course = $this->dao->select('*')->from(TABLE_TRAINCOURSE)->where('code')->eq($courseInfo->code)->andWhere('deleted')->eq(0)->fetch();

        $data = new stdClass();
        $data->category = $categoryID;
        $data->name     = $courseInfo->name;
        $data->teacher  = $courseInfo->teacher;
        $data->desc     = $courseInfo->desc;
        if(empty($course))
        {
            $data->code        = $courseInfo->code;
            $data->status      = 'offline';
            $data->createdDate = helper::today();
            $data->createdBy   = $this->app->user->account;

            $this->dao->insert(TABLE_TRAINCOURSE)->data($data)->exec();
            if(dao::isError()) return false;

            $courseID = $this->dao->lastInsertID();
        }
        else
        {
            $courseID = $course->id;

            $data->editedBy   = $this->app->user->account;
            $data->editedDate = helper::now();
            $courseID = $course->id;
            $this->dao->update(TABLE_TRAINCOURSE)->data($data)->where('id')->eq($courseID)->exec();
        }

        $this->uploadFile($courseInfo->cover, 'traincourse', $courseID, $courseInfo->code);
        if(dao::isError()) return false;

        return $courseID;
    }

    /**
     * Import contents.
     *
     * @param  object $contents
     * @param  int    $courseID
     * @param  string $courseCode
     * @param  int    $parentID
     * @param  string $path
     * @access public
     * @return string
     */
    public function importContents($contents, $courseID, $courseCode)
    {
        $existedContents = $this->dao->select('code, id')->from(TABLE_TRAINCONTENTS)->where('course')->eq($courseID)->andWhere('deleted')->eq('0')->fetchPairs();

        $now       = helper::now();
        $account   = $this->app->user->account;
        $chapterID = 0;
        foreach($contents as $content)
        {
            $data = new stdclass();
            $data->name   = $content['name'];
            $data->parent = $content['type'] == 'video' ? $chapterID : 0;
            $data->desc   = $content['desc'];
            $data->type   = $content['type'];

            $code = $content['code'];
            if(isset($existedContents[$code]))
            {
                $contentID = $existedContents[$code];
                if($content['type'] == 'chapter') $chapterID = $contentID;

                $data->path       = $content['type'] == 'video' ? ",$chapterID,$contentID," : ",$contentID,";
                $data->editedBy   = $account;
                $data->editedDate = $now;
                $this->dao->update(TABLE_TRAINCONTENTS)->data($data)->where('id')->eq($contentID)->exec();
            }
            else
            {
                $data->code        = $code;
                $data->course      = $courseID;
                $data->createdDate = $now;
                $data->createdBy   = $account;
                $this->dao->insert(TABLE_TRAINCONTENTS)->data($data)->exec();
                if(dao::isError()) return false;

                $contentID = $this->dao->lastInsertID();
                if($content['type'] == 'chapter') $chapterID = $contentID;

                $path = $content['type'] == 'video' ? ",$chapterID,$contentID," : ",$contentID,";
                $this->dao->update(TABLE_TRAINCONTENTS)->set('path')->eq($path)->set('order')->eq($contentID * 5)->where('id')->eq($contentID)->exec();
            }

            if($content['type'] == 'video') $this->uploadFile($content['file'], 'traincontents', $contentID, $courseCode);
        }

        return !dao::isError();
    }

    /**
     * Upload a file.
     *
     * @param  string $fileName
     * @param  string $objectType
     * @param  int    $objectID
     * @param  string $courseCode
     * @access public
     * @return void
     */
    public function uploadFile($fileName, $objectType, $objectID, $courseCode)
    {
        $this->dao->delete()->from(TABLE_FILE)->where('objectID')->eq($objectID)->andWhere('objectType')->eq($objectType)->exec();

        $file = new stdclass();
        $file->pathname   = $courseCode . DIRECTORY_SEPARATOR . $fileName;
        $file->title      = $fileName;
        $file->extension  = $this->loadModel('file')->getExtension($fileName);
        $file->size       = filesize($this->app->getWwwRoot() . $this->config->traincourse->uploadPath . $courseCode . '/' . $fileName);
        $file->objectType = $objectType;
        $file->objectID   = $objectID;
        $file->addedBy    = $this->app->user->account;
        $file->addedDate  = helper::now();

        $this->dao->insert(TABLE_FILE)->data($file)->exec();
    }

    /**
     * Compute SN.
     *
     * @param  int    $courseID
     * @access public
     * @return void
     */
    public function computeSN($courseID)
    {
        /* Get all children of the startNode. */
        $nodes = $this->dao->select('id, course, parent, `order`, path')->from(TABLE_TRAINCONTENTS)
            ->where('course')->eq($courseID)
            ->andWhere('deleted')->eq(0)
            ->andWhere('type')->in('chapter,video')
            ->orderBy('`order`, id')
            ->fetchAll('id');

        /* Group them by their parent. */
        $groupedNodes = array();
        foreach($nodes as $node) $groupedNodes[$node->parent][$node->id] = $node;

        $serials = array();
        foreach($nodes as $node)
        {
            $path      = explode(',', $node->path);
            $courseID  = $node->course;
            $startNode = $path[1];

            $serial = '';
            foreach($path as $nodeID)
            {
                /* If the node id is empty or is the courseID, skip. */
                if(!$nodeID) continue;

                /* Compute the serial. */
                if(isset($nodes[$nodeID]))
                {
                    $parentID = $nodes[$nodeID]->parent;
                    $brothers = $groupedNodes[$parentID];
                    $serial  .= array_search($nodeID, array_keys($brothers)) + 1 . '.';
                }
            }

            $serials[$node->id] = rtrim($serial, '.');
        }

        return $serials;
    }

    /**
     * Get chapters.
     *
     * @param  int     $courseID
     * @access public
     * @return array
     */
    public function getChapters($courseID = 0, $type = 'chapter', $orderBy = 'id_desc')
    {
        return $this->dao->select('*')->from(TABLE_TRAINCONTENTS)
            ->where('deleted')->eq(0)
            ->beginIF(!empty($courseID))->andWhere('course')->eq($courseID)
            ->beginIF(!empty($type))->andWhere('type')->eq($type)
            ->orderBy($orderBy)
            ->fetchAll('id');
    }

    /**
     * Get all categories.
     *
     * @param  string $orderBy
     * @access public
     * @return array
     */
    public function getAllCategory($orderBy = 'id_desc')
    {
        return $this->dao->select('*')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq(0)
            ->orderBy($orderBy)
            ->fetchAll('id');
    }

    /**
     * Finish a chapter.
     *
     * @param  int    $chapterID
     * @param  string $account
     * @param int     $courseID
     * @access public
     * @return void
     */
    public function finishChapter($chapterID, $account = '', $courseID = 0)
    {
        $account = empty($account) ? $this->app->user->account : $account;

        $chapter = new stdclass();
        $chapter->user       = $account;
        $chapter->objectId   = $chapterID;
        $chapter->objectType = 'chapter';
        $chapter->status     = 'done';
        $this->dao->replace(TABLE_TRAINRECORDS)->data($chapter)->exec();

        $this->changeCourseRecordStatus($courseID, $account);
    }

    /**
     * Sort chapter order.
     *
     * @access public
     * @return void
     */
    public function sortChapterOrder()
    {
        $nodes = fixer::input('post')->get();
        foreach($nodes->sort as $id => $order)
        {
            $order = explode('.', $order);
            $num   = end($order);
            $this->dao->update(TABLE_TRAINCONTENTS)->set('`order`')->eq($num)->where('id')->eq($id)->exec();
        }
        return !dao::isError();
    }

    /**
     * Process categories.
     *
     * @param  array  $categories
     * @param  string $type
     * @access public
     * @return array
     */
    public function process($categories = array(), $type = '')
    {
        return $categories;
    }

    /**
     * Get course duration from records.
     *
     * @param  int    $courseID
     * @param  str    $account
     * @access public
     * @return int
     */
    public function getCourseDuration($courseID, $account = '')
    {
        $count = 0;
        $account = empty($account) ? $this->app->user->account : $account;
        $recordList = $this->dao->select('duration')->from(TABLE_TRAINRECORDS)
            ->where('objectID')->eq($courseID)
            ->andWhere('user')->eq($account)
            ->fetchAll();

        foreach($recordList as $record)
        {
            $count += $record->duration;
        }

        return round($count / 3600, 2);
    }

    /**
     * Build the category sql to execute.
     *
     * @param string $type              the category type, for example, dept|forum
     * @param int    $startCategory     the start category id
     * @param int    $root
     * @access public
     * @return string
     */
    public function buildCategoryQuery($startCategory = 0, $root = 0)
    {
        /* Get the start category path according the $startCategory. */
        $startPath = '';
        if($startCategory > 0)
        {
            $startCategory = $this->getCategoryByID($startCategory);
            if($startCategory) $startPath = $startCategory->path . '%';
        }

        return $this->dao->select('*')->from(TABLE_TRAINCATEGORY)
            ->where('deleted')->eq('0')
            ->beginIF($root)->andWhere('root')->eq((int)$root)->fi()
            ->beginIF($startPath)->andWhere('path')->like($startPath)->fi()
            ->orderBy('grade desc,`order` asc')
            ->get();
    }

    /**
     * Fix chapter path.
     *
     * @param  int    $courseID
     * @param  string $type
     * @access public
     * @return void
     */
    public function fixPath($objectID, $type = 'chapter')
    {
        /* Get all nodes grouped by parent. */
        $table = $type == 'chapter' ? TABLE_TRAINCONTENTS : TABLE_TRAINCATEGORY;
        $groupNodes = $this->dao->select('id, parent')->from($table)
            ->where('deleted')->eq(0)
            ->beginIF($type == 'chapter')->andWhere('course')->eq($objectID)->fi()
            ->fetchGroup('parent', 'id');

        $nodes = array();

        /* Cycle the groupNodes until it has no item any more. */
        while(count($groupNodes) > 0)
        {
            /* Record the counts before processing. */
            $oldCounts = count($groupNodes);

            foreach($groupNodes as $parentNodeID => $childNodes)
            {
                /**
                 * If the parentNode doesn't exsit in the nodes, skip it.
                 * If exists, compute it's child nodes.
                 */
                if(!isset($nodes[$parentNodeID]) and $parentNodeID != 0) continue;

                if($parentNodeID == 0)
                {
                    $parentNode = new stdclass();
                    $parentNode->path  = ',';
                }
                else
                {
                    $parentNode = $nodes[$parentNodeID];
                }

                /* Compute it's child nodes. */
                foreach($childNodes as $childNodeID => $childNode)
                {
                    $childNode->path  = $parentNode->path . $childNode->id . ',';

                    /**
                     * Save child node to nodes,
                     * thus the child of child can compute it's grade and path.
                     */
                    $nodes[$childNodeID] = $childNode;
                }

                /* Remove it from the groupNodes.*/
                unset($groupNodes[$parentNodeID]);
            }

            /* If after processing, no node processed, break the cycle. */
            if(count($groupNodes) == $oldCounts) break;
        }

        /* Save nodes to database. */
        foreach($nodes as $node)
        {
            $this->dao->update($table)->data($node)
                ->where('id')->eq($node->id)
                ->exec();
        }
    }

    /**
     * Get article Count.
     *
     * @param  int    $courseID
     * @access public
     * @return string
     */
    public function getArticleCount($courseID)
    {
        $count = $this->dao->select('COUNT(id) AS count')->from(TABLE_TRAINCONTENTS)->where('deleted')->eq('0')->andWhere('course')->eq($courseID)->andWhere('type')->eq('video')->fetch('count');
        return $count;
    }

    /**
     * Delete a course.
     *
     * @param  int    $courseID
     * @access public
     * @return void
     */
    public function deleteCourse($courseID)
    {
        $course   = $this->getById($courseID);
        $savePath = $this->app->getWwwRoot() . $this->config->traincourse->uploadPath;
        $zfile    = $this->app->loadClass('zfile');
        $zfile->removeDir($savePath . $course->code);

        $this->dao->delete()->from(TABLE_TRAINCOURSE)->where('id')->eq($courseID)->exec();

        $contentIDList = $this->dao->select('id')->from(TABLE_TRAINCONTENTS)->where('course')->eq($courseID)->fetchPairs();
        $this->dao->delete()->from(TABLE_TRAINCONTENTS)->where('id')->in($contentIDList)->exec();
        $this->dao->delete()->from(TABLE_FILE)
            ->where('(objectType')->eq('traincourse')
            ->andWhere('objectID')->eq($courseID)
            ->markRight(1)
            ->orWhere('(objectType')->eq('traincontents')
            ->andWhere('objectID')->in($contentIDList)
            ->markRight(1)
            ->exec();

        if(!dao::isError()) $this->deleteCategory($course->category);
    }

    /**
     * Delete category.
     *
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function deleteCategory($categoryID)
    {
        $course = $this->dao->select('id')->from(TABLE_TRAINCOURSE)->where('category')->eq($categoryID)->fetch();
        if(!empty($course)) return;

        $childCategory = $this->dao->select('id')->from(TABLE_TRAINCATEGORY)->where('path')->like("%,{$categoryID},%")->andWhere('id')->ne($categoryID)->fetch();
        if(!empty($childCategory)) return;

        $category = $this->getCategoryByID($categoryID);
        $this->dao->delete()->from(TABLE_TRAINCATEGORY)->where('id')->eq($categoryID)->exec();
        if($category->parent) $this->deleteCategory($category->parent);
    }

    /**
     * Build traincourse search form.
     *
     * @param  int    $queryID
     * @param  string $actionURL
     * @access public
     * @return void
     */
    public function buildSearchForm($queryID, $actionURL)
    {
        $this->config->traincourse->search['actionURL'] = $actionURL;
        $this->config->traincourse->search['queryID']   = $queryID;

        $this->loadModel('search')->setSearchParams($this->config->traincourse->search);
    }

    /**
     * Get search courses.
     *
     * @param  int    $queryID
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getSearchCourses($queryID, $pager)
    {
        if($queryID)
        {
            $query = $this->loadModel('search')->getQuery($queryID);
            if($query)
            {
                $this->session->set('traincourseQuery', $query->sql);
                $this->session->set('traincourseForm', $query->form);
            }
            else
            {
                $this->session->set('traincourseQuery', ' 1 = 1');
            }
        }
        else
        {
            if($this->session->traincourseQuery == false) $this->session->set('traincourseQuery', ' 1 = 1');
        }

        $traincourseQuery = $this->session->traincourseQuery;
        $doingList        = $this->getRecordPairs('doing');
        $doneList         = $this->getRecordPairs('done');
        if(strpos($traincourseQuery, "`status` = 'wait'") !== false)
        {
            $doingDoneList    = array_keys($doingList + $doneList);
            $allList          = $this->dao->select('id')->from(TABLE_TRAINCOURSE)->fetchPairs();
            $waitList         = array_diff($allList, $doingDoneList);
            $waitList         = empty($waitList) ? 0 : implode($waitList, ',');
            $traincourseQuery = str_replace("`status` = 'wait'", "`id` in ($waitList)", $traincourseQuery);
        }

        if(strpos($traincourseQuery, "`status` = 'doing'") !== false)
        {
            $doingList        = empty($doingList) ? 0 : implode($doingList, ',');
            $traincourseQuery = str_replace("`status` = 'doing'", "`id` in ($doingList)", $traincourseQuery);
        }

        if(strpos($traincourseQuery, "`status` = 'done'") !== false)
        {
            $doneList         = empty($doneList) ? 0 : implode($doneList, ',');
            $traincourseQuery = str_replace("`status` = 'done'", "`id` in ($doneList)", $traincourseQuery);

        }

        if(strpos($traincourseQuery, "`status` = ''") !== false)
        {
            $traincourseQuery = str_replace("`status` = ''", "1=1", $traincourseQuery);
        }

        return $this->dao->select('*')->from(TABLE_TRAINCOURSE)
            ->where($traincourseQuery)
            ->andWhere('status')->eq('online')
            ->andWhere('deleted')->eq(0)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * get uploaded file from zui.uploader.
     *
     * @param  string $htmlTagName
     * @access public
     * @return array
     */
    public function getUploadFile($htmlTagName = 'file')
    {
        if(!isset($_FILES[$htmlTagName]) || empty($_FILES[$htmlTagName]['name'])) return;

        $this->app->loadClass('purifier', true);
        $config   = HTMLPurifier_Config::createDefault();
        $config->set('Cache.DefinitionImpl', null);
        $purifier = new HTMLPurifier($config);

        extract($_FILES[$htmlTagName]);
        if(!validater::checkFileName($name)) return array();
        if($this->post->name) $name = $this->post->name;

        $file = array();
        $file['id'] = 0;
        $file['extension'] = $this->loadModel('file')->getExtension($name);
        $file['title']     = !empty($_POST['label']) ? htmlspecialchars($_POST['label']) : substr($name, 0, strpos($name, $file['extension']) - 1);
        $file['title']     = $purifier->purify($file['title']);
        $file['size']      = !empty($_POST['size']) ? $_POST['size'] : 0;
        $file['tmpname']   = $tmp_name;
        $file['uuid']      = $_POST['uuid'];
        $file['pathname']  = $this->file->setPathName(0, $file['extension']);
        $file['chunkpath'] = 'chunks' . DS .'f_' . $file['uuid'] . '.' . $file['extension'] . '.part';
        $file['chunks']    = isset($_POST['chunks']) ? intval($_POST['chunks']) : 0;
        $file['chunk']     = isset($_POST['chunk'])  ? intval($_POST['chunk'])  : 0;

        /* Fix for build uuid like '../../'. */
        if(!preg_match('/[a-z0-9_]/i', $file['uuid'])) return false;

        if(stripos($this->config->file->allowed, ',' . $file['extension'] . ',') === false)
        {
            $file['pathname'] = $file['pathname'] . '.notAllowed';
        }

        return $file;
    }

    /**
     * Save uploaded file from zui.uploader.
     *
     * @param  int    $file
     * @param  int    $uid
     * @access public
     * @return array|bool
     */
    public function saveUploadFile($file, $uid)
    {
        $uploadFile = array();

        $tmpFilePath = $this->app->getTmpRoot() . 'uploadfiles/';
        if(!is_dir($tmpFilePath)) mkdir($tmpFilePath, 0777, true);

        $tmpFileSavePath = $tmpFilePath . $uid . '/';
        if(!is_dir($tmpFileSavePath)) mkdir($tmpFileSavePath);

        $fileName = basename($file['pathname']);
        $fileName = strpos($fileName, '.') === false ? $fileName : substr($fileName, 0, strpos($fileName, '.'));
        $file['realpath'] = $tmpFileSavePath . $fileName;

        if($file['chunks'] > 1)
        {
            $tmpFileChunkPath = $tmpFilePath . $file['chunkpath'];
            if(!file_exists($tmpFileChunkPath)) mkdir(dirname($tmpFileChunkPath));

            if($file['chunk'] > 0)
            {
                $fileChunk    = fopen($tmpFileChunkPath, 'a+b');
                $tmpChunkFile = fopen($file['tmpname'], 'rb');
                while($buff = fread($tmpChunkFile, 4069))
                {
                    fwrite($fileChunk, $buff);
                }
                fclose($fileChunk);
                fclose($tmpChunkFile);
            }
            else
            {
                if(!move_uploaded_file($file['tmpname'], $tmpFileChunkPath)) return false;
            }

            if($file['chunk'] == ($file['chunks'] - 1))
            {
                rename($tmpFileChunkPath, $file['realpath'] . '.' . $file['extension']);

                $uploadFile['extension'] = $file['extension'];
                $uploadFile['pathname']  = $file['pathname'];
                $uploadFile['title']     = $file['title'];
                $uploadFile['realpath']  = $file['realpath'] . '.' . $file['extension'];
                $uploadFile['size']      = $file['size'];
                $uploadFile['tmpname']   = $file['tmpname'];
            }
        }
        else
        {
            if(!move_uploaded_file($file['tmpname'], $file['realpath'] . '.' . $file['extension'])) return false;

            $uploadFile['extension'] = $file['extension'];
            $uploadFile['pathname']  = $file['pathname'];
            $uploadFile['title']     = $file['title'];
            $uploadFile['realpath']  = $file['realpath'] . '.' . $file['extension'];
            $uploadFile['size']      = $file['size'];
            $uploadFile['tmpname']   = $file['tmpname'];
        }

        return $uploadFile;
    }

    /**
     * Remove upload image file and session.
     *
     * @access public
     * @return void
     */
    public function removeSession()
    {
        if(!empty($_SESSION['courseFile']))
        {
            $classFile = $this->app->loadClass('zfile');
            $file      = current($_SESSION['courseFile']);
            $realPath  = dirname($file['realpath']);
            if(is_dir($realPath)) $classFile->removeDir($realPath);
            unset($_SESSION['courseFile']);
        }
    }
}
