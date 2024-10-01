<?php
/**
 * The traincourse module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Mengyi Liu <liumengyi@cnezsoft.com>
 * @package     company
 * @version     $Id: zh-cn.php 4129 2022-02-09 08:18:14Z wwccss $
 * @link        http://www.zentao.net
 */

/* Actions. */
$lang->traincourse->createCourse     = 'Create Course';
$lang->traincourse->createChapter    = 'Create Chapter';
$lang->traincourse->createCategory   = 'Create Category';
$lang->traincourse->viewCourse       = 'View Course';
$lang->traincourse->viewChapter      = 'View Chapter';
$lang->traincourse->browse           = 'Course';
$lang->traincourse->upCourse         = 'Up Course';
$lang->traincourse->offCourse        = 'Off Course';
$lang->traincourse->manageCourse     = 'Manage Course';
$lang->traincourse->manageChapter    = 'Manage Chapter';
$lang->traincourse->manageCategory   = 'Manage Category';
$lang->traincourse->editCourse       = 'Edit Course';
$lang->traincourse->editChapter      = 'Edit Chapter';
$lang->traincourse->editCategory     = 'Edit Category';
$lang->traincourse->browseCategory   = 'Browse Category';
$lang->traincourse->categoryChildren = 'Category Children';
$lang->traincourse->changeStatus     = 'Change Status';
$lang->traincourse->deleteCourse     = 'Delete Course';
$lang->traincourse->deleteChapter    = 'Delete Chapter';
$lang->traincourse->deleteCategory   = 'Delete Category';
$lang->traincourse->uploadCourse     = 'Upload Course';
$lang->traincourse->upload           = 'Upload';

/* Fields. */
$lang->traincourse->course   = 'Course';
$lang->traincourse->admin    = 'Admin';
$lang->traincourse->category = 'Category';
$lang->traincourse->byQuery  = 'Search';

$lang->traincourse->all            = 'All Course';
$lang->traincourse->createdByMe    = 'Created By Me';
$lang->traincourse->youCould       = 'You Could';

$lang->traincourse->courseName  = 'Course Name';
$lang->traincourse->courseDesc  = 'Course Desc';
$lang->traincourse->teacher     = 'Teacher';
$lang->traincourse->courseCover = 'Course Cover';
$lang->traincourse->uploadCover = 'Upload Cover';

$lang->traincourse->id          = 'ID';
$lang->traincourse->category    = 'Category';
$lang->traincourse->name        = 'Course Name';
$lang->traincourse->status      = 'Status';
$lang->traincourse->desc        = 'Desc';
$lang->traincourse->createdBy   = 'Create By';
$lang->traincourse->createdDate = 'Create Date';
$lang->traincourse->editedBy    = 'Edited By';
$lang->traincourse->editedDate  = 'Edited Date';

$lang->traincourse->type          = 'Type';
$lang->traincourse->chapterName   = 'Chapter Name';
$lang->traincourse->chapterDesc   = 'Chapter Desc';
$lang->traincourse->parentChapter = 'Parent Chapter';
$lang->traincourse->file          = 'File';

$lang->traincourse->parentCategory = 'Parent Category';
$lang->traincourse->categoryName   = 'Category Name';

$lang->traincourse->more               = 'More';
$lang->traincourse->noDesc             = 'No Desc.';
$lang->traincourse->noCourses          = 'No Course.';
$lang->traincourse->noRecommendCourses = 'No Recommend Courses.';
$lang->traincourse->noCollectedCourses = 'No Collected Courses';
$lang->traincourse->noFinishedCourses  = 'No Finished Courses';
$lang->traincourse->drag               = 'Please drag the file to here.';
$lang->traincourse->confirmDelete      = 'Do you want to delete it?';
$lang->traincourse->browseTip          = 'Click the category menu to view chapters.';
$lang->traincourse->addCatalogTip      = 'Course does not have a chapter, you can create.';
$lang->traincourse->noModule           = '<div>No category information.</div>';

$lang->traincourse->statusList = array();
$lang->traincourse->statusList['offline'] = 'Offline';
$lang->traincourse->statusList['online']  = 'Online';

$lang->traincourse->progressList = array();
$lang->traincourse->progressList['']      = '';
$lang->traincourse->progressList['wait']  = 'Wait';
$lang->traincourse->progressList['doing'] = 'Doing';
$lang->traincourse->progressList['done']  = 'Done';

$lang->traincourse->featureBar = array();
$lang->traincourse->featureBar['admin']['all']     = $lang->traincourse->all;
$lang->traincourse->featureBar['admin']['offline'] = $lang->traincourse->statusList['offline'];
$lang->traincourse->featureBar['admin']['online']  = $lang->traincourse->statusList['online'];

$lang->traincourse->featureBar['browse']['all']   = $lang->traincourse->all;
$lang->traincourse->featureBar['browse']['wait']  = $lang->traincourse->progressList['wait'];
$lang->traincourse->featureBar['browse']['doing'] = $lang->traincourse->progressList['doing'];
$lang->traincourse->featureBar['browse']['done']  = $lang->traincourse->progressList['done'];

$lang->traincourse->typeList = array();
$lang->traincourse->typeList['chapter'] = 'Chapter';
$lang->traincourse->typeList['video']   = 'Article';

$lang->traincourse->allCourses          = 'All Courses';
$lang->traincourse->notStart            = 'Not Start';
$lang->traincourse->inProgress          = 'In Progress';
$lang->traincourse->finished            = 'Finished';
$lang->traincourse->noNotStartCourses   = 'No Not Start Courses';
$lang->traincourse->noInProgressCourses = 'No In Progress Courses';
$lang->traincourse->noFinishedCourses   = 'No Finished Courses';
$lang->traincourse->learnProgress       = 'Learn Progress';
$lang->traincourse->fileNotEmpty        = 'File cannot be empty.';
$lang->traincourse->onlySupportZIP      = 'Only zip format upload is supported. Please convert zip format and upload again.';
$lang->traincourse->noYamlFile          = 'The YAML file is not found, please contact ZenTao customer service to obtain the correct ZIP file.';
$lang->traincourse->yamlFileError       = 'Error in parsing YAML file, please contact ZenTao customer service to obtain the correct ZIP file.';
$lang->traincourse->playFailed          = 'The current video is incorrect and cannot be played. Please contact the administrator';
$lang->traincourse->confirmClose        = 'There are still courses that have not been uploaded. Click Close to terminate the upload process. Do you want to close?';

$lang->traincourse->view          = 'Details';
$lang->traincourse->fullscreen    = 'Fullscreen';
$lang->traincourse->retrack       = 'Retrack';
$lang->traincourse->chapter       = 'Chapter';
$lang->traincourse->finish        = 'Finish';
$lang->traincourse->next          = 'Next Chapter';
$lang->traincourse->relatedInfo   = 'Related Info';
$lang->traincourse->allCourse     = 'All Course';
$lang->traincourse->continueStudy = 'Continue Study';
$lang->traincourse->beginStudy    = 'Begin Study';
$lang->traincourse->manage        = 'Manege Course';
$lang->traincourse->chapterInfo   = 'Progress: %s/%s';
$lang->traincourse->allVideo      = 'In total: %s';

$lang->traincourse->addFile     = 'Add';
$lang->traincourse->beginUpload = 'Upload';
