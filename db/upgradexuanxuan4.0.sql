ALTER TABLE `zt_im_userdevice` ADD `deviceID` char(40) NOT NULL DEFAULT '' AFTER `device`, ADD `token` char(64) NOT NULL DEFAULT '' AFTER `deviceID`, ADD `validUntil` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `token`;
ALTER TABLE `zt_im_conferenceaction` ADD `device` char(40) NOT NULL DEFAULT 'default' AFTER `date`;
