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
$lang->traincourse->createCourse     = '创建课程';
$lang->traincourse->createChapter    = '添加章节';
$lang->traincourse->createCategory   = '新建分类';
$lang->traincourse->viewCourse       = '查看课程';
$lang->traincourse->viewChapter      = '查看章节';
$lang->traincourse->browse           = '课程';
$lang->traincourse->upCourse         = '上线课程';
$lang->traincourse->offCourse        = '下线课程';
$lang->traincourse->manageCourse     = '维护课程';
$lang->traincourse->manageChapter    = '维护章节';
$lang->traincourse->manageCategory   = '维护分类';
$lang->traincourse->editCourse       = '编辑课程';
$lang->traincourse->editChapter      = '编辑章节';
$lang->traincourse->editCategory     = '编辑分类';
$lang->traincourse->browseCategory   = '浏览分类';
$lang->traincourse->categoryChildren = '添加子分类';
$lang->traincourse->changeStatus     = '课程上线/下线';
$lang->traincourse->deleteCourse     = '删除课程';
$lang->traincourse->deleteChapter    = '删除章节';
$lang->traincourse->deleteCategory   = '删除分类';
$lang->traincourse->uploadCourse     = '导入课程';
$lang->traincourse->upload           = '导入';

/* Fields. */
$lang->traincourse->course   = '课程';
$lang->traincourse->admin    = '后台';
$lang->traincourse->category = '分类';
$lang->traincourse->byQuery  = '搜索';

$lang->traincourse->all            = '所有课程';
$lang->traincourse->createdByMe    = '由我创建';
$lang->traincourse->youCould       = '您可以';

$lang->traincourse->courseName  = '课程名称';
$lang->traincourse->courseDesc  = '课程简介';
$lang->traincourse->teacher     = '授课老师';
$lang->traincourse->courseCover = '课程封面';
$lang->traincourse->uploadCover = '添加封面';

$lang->traincourse->id          = '编号';
$lang->traincourse->category    = '所属分类';
$lang->traincourse->name        = '课程名称';
$lang->traincourse->status      = '状态';
$lang->traincourse->desc        = '简介';
$lang->traincourse->createdBy   = '由谁创建';
$lang->traincourse->createdDate = '创建日期';
$lang->traincourse->editedBy    = '由谁编辑';
$lang->traincourse->editedDate  = '编辑日期';

$lang->traincourse->type          = '类型';
$lang->traincourse->chapterName   = '标题';
$lang->traincourse->chapterDesc   = '简介';
$lang->traincourse->parentChapter = '所属章节';
$lang->traincourse->file          = '上传文件';

$lang->traincourse->parentCategory = '上级分类';
$lang->traincourse->categoryName   = '分类名称';

$lang->traincourse->more               = '更多';
$lang->traincourse->noDesc             = '暂无简介。';
$lang->traincourse->noCourses          = '暂时还没有课程。';
$lang->traincourse->noRecommendCourses = '暂无相关的课程推荐。';
$lang->traincourse->noCollectedCourses = '暂时还没有收藏的课程。';
$lang->traincourse->noFinishedCourses  = '暂时还没有完成的课程。';
$lang->traincourse->drag               = '请拖拽文件到此处。';
$lang->traincourse->confirmDelete      = '您确定要删除吗?';
$lang->traincourse->browseTip          = '点击左侧树目录查看课程章节和内容详情，您也可以继续';
$lang->traincourse->addCatalogTip      = '您的课程还没有章节和内容，您可以添加';
$lang->traincourse->noModule           = '<div>您现在还没有分类信息</div>';

$lang->traincourse->statusList = array();
$lang->traincourse->statusList['offline'] = '待上线';
$lang->traincourse->statusList['online']  = '已上线';

$lang->traincourse->progressList = array();
$lang->traincourse->progressList['']      = '';
$lang->traincourse->progressList['wait']  = '未开始';
$lang->traincourse->progressList['doing'] = '正在学习';
$lang->traincourse->progressList['done']  = '已完成';

$lang->traincourse->featureBar = array();
$lang->traincourse->featureBar['admin']['all']     = $lang->traincourse->all;
$lang->traincourse->featureBar['admin']['offline'] = $lang->traincourse->statusList['offline'];
$lang->traincourse->featureBar['admin']['online']  = $lang->traincourse->statusList['online'];

$lang->traincourse->featureBar['browse']['all']   = '全部课程';
$lang->traincourse->featureBar['browse']['wait']  = $lang->traincourse->progressList['wait'];
$lang->traincourse->featureBar['browse']['doing'] = $lang->traincourse->progressList['doing'];
$lang->traincourse->featureBar['browse']['done']  = $lang->traincourse->progressList['done'];

$lang->traincourse->typeList = array();
$lang->traincourse->typeList['chapter'] = '章节';
$lang->traincourse->typeList['video']   = '内容';

$lang->traincourse->allCourses          = '所有课程';
$lang->traincourse->notStart            = '未开始';
$lang->traincourse->inProgress          = '正在学习';
$lang->traincourse->finished            = '已完成';
$lang->traincourse->noNotStartCourses   = '没有未开始的课程';
$lang->traincourse->noInProgressCourses = '没有正在进行的课程';
$lang->traincourse->noFinishedCourses   = '没有已完成的课程';
$lang->traincourse->learnProgress       = '学习进度';
$lang->traincourse->fileNotEmpty        = '文件不能为空。';
$lang->traincourse->onlySupportZIP      = '只支持ZIP格式上传，请转换ZIP格式再上传。';
$lang->traincourse->noYamlFile          = '没有找到YAML文件，请联系禅道客服获取正确的ZIP压缩文件。';
$lang->traincourse->yamlFileError       = '解析YAML文件错误，请联系禅道客服获取正确的ZIP压缩文件。';
$lang->traincourse->playFailed          = '当前视频有误，无法播放，请联系管理员';
$lang->traincourse->confirmClose        = '还有课程未上传完成，点击关闭后将终止上传流程，是否关闭？';

$lang->traincourse->view          = '课程详情';
$lang->traincourse->fullscreen    = '全屏';
$lang->traincourse->retrack       = '收起';
$lang->traincourse->chapter       = '章节';
$lang->traincourse->finish        = '本节学习完成';
$lang->traincourse->next          = '下一章节';
$lang->traincourse->relatedInfo   = '相关信息';
$lang->traincourse->allCourse     = '所有课程';
$lang->traincourse->continueStudy = '继续学习';
$lang->traincourse->beginStudy    = '开始学习';
$lang->traincourse->manage        = '管理课程';
$lang->traincourse->chapterInfo   = '进度：%s/%s';
$lang->traincourse->allVideo      = '共 %s 节';

$lang->traincourse->addFile     = '添加文件';
$lang->traincourse->beginUpload = '开始上传';
