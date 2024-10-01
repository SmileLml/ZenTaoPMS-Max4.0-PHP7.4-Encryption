CREATE OR REPLACE VIEW `ztv_projectsummary` AS select `zt_task`.`project` AS `project`,sum(`zt_task`.`estimate`) AS `estimate`,sum(`zt_task`.`consumed`) AS `consumed`,sum(`zt_task`.`left`) AS `left`,count(0) AS `number`,sum(if(((`zt_task`.`status` = 'wait') or (`zt_task`.`status` = 'doing')),1,0)) AS `undone`,sum((`zt_task`.`consumed` + `zt_task`.`left`)) AS `totalReal` from `zt_task` where (`zt_task`.`deleted` = '0') group by `zt_task`.`project`; 
