ALTER TABLE `zt_im_chat` ADD `mergedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `editedDate`;
ALTER TABLE `zt_im_chat` ADD `mergedChats` text NOT NULL DEFAULT '' AFTER `pinnedMessages`;

