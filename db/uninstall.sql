DELETE FROM `zt_grouppriv` WHERE `module` = 'company' AND `method` = 'effort';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'export';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'view';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'edit';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'batchCreate';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'delete';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'createForObject';
DELETE FROM `zt_grouppriv` WHERE `module` = 'my' AND `method` = 'effort';
DELETE FROM `zt_grouppriv` WHERE `module` = 'project' AND `method` = 'effort';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'user' AND `method` = 'effort';

DELETE FROM `zt_grouppriv` WHERE `module` = 'todo' AND `method` = 'calendar';
DELETE FROM `zt_grouppriv` WHERE `module` = 'effort' AND `method` = 'calendar';
DELETE FROM `zt_grouppriv` WHERE `module` = 'project' AND `method` = 'calendar';
DELETE FROM `zt_grouppriv` WHERE `module` = 'user' AND `method` = 'effortcalendar';
DELETE FROM `zt_grouppriv` WHERE `module` = 'user' AND `method` = 'todocalendar';
DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'bug' AND `method` = 'exportTemplet';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'bug' AND `method` = 'exportTemplet';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'bug' AND `method` = 'import';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'bug' AND `method` = 'import';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'bug' AND `method` = 'showImport';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'bug' AND `method` = 'showImport';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'task' AND `method` = 'exportTemplet';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'task' AND `method` = 'exportTemplet';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'task' AND `method` = 'import';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'task' AND `method` = 'import';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'task' AND `method` = 'showImport';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'task' AND `method` = 'showImport';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'story' AND `method` = 'exportTemplet';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'story' AND `method` = 'exportTemplet';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'story' AND `method` = 'import';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'story' AND `method` = 'import';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'story' AND `method` = 'showImport';
DELETE FROM `zt_grouppriv` WHERE `group` = 4 AND `module` = 'story' AND `method` = 'showImport';
DROP TABLE `zt_relationoftasks`;
DELETE FROM `zt_grouppriv` WHERE `module` = 'project' AND `method` = 'gantt';
DELETE FROM `zt_grouppriv` WHERE `module` = 'project' AND `method` = 'relation';

DELETE FROM `zt_grouppriv` WHERE `group` = 1 AND `module` = 'project' AND `method` = 'deleterelation';
DELETE FROM `zt_grouppriv` WHERE `module` = 'report' AND `method` = 'build';
DELETE FROM `zt_grouppriv` WHERE `module` = 'report' AND `method` = 'testcase';
DELETE FROM `zt_grouppriv` WHERE `module` = 'report' AND `method` = 'workSummary';
DROP TABLE IF EXISTS `zt_report`;
DELETE FROM `zt_grouppriv` WHERE `module` = 'report' AND `method` = 'export';
