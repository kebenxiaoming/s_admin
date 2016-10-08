/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : s_admin

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2016-10-08 13:50:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for darling_menu_url
-- ----------------------------
DROP TABLE IF EXISTS `darling_menu_url`;
CREATE TABLE `darling_menu_url` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_show` tinyint(4) NOT NULL COMMENT '是否在sidebar里出现',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '在线状态，还是下线状态，即可用，不可用。',
  `shortcut_allowed` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许快捷访问',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `menu_desc` varchar(255) DEFAULT NULL,
  `father_menu` int(11) NOT NULL DEFAULT '0' COMMENT '上一级菜单',
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menu_url` (`menu_url`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';

-- ----------------------------
-- Records of darling_menu_url
-- ----------------------------
INSERT INTO `darling_menu_url` VALUES ('1', '首页', 'Index/index', '1', '0', '1', '1', '0', '后台首页', '0');
INSERT INTO `darling_menu_url` VALUES ('2', '账号列表', 'User/index', '1', '1', '1', '1', '0', '账号列表', '0');
INSERT INTO `darling_menu_url` VALUES ('3', '修改账号', 'User/edit', '1', '0', '1', '0', '0', '修改账号', '2');
INSERT INTO `darling_menu_url` VALUES ('4', '新建账号', 'User/add', '1', '0', '1', '1', '0', '新建账号', '2');
INSERT INTO `darling_menu_url` VALUES ('5', '个人信息', 'User/profile', '1', '0', '1', '1', '0', '个人信息', '0');
INSERT INTO `darling_menu_url` VALUES ('6', '账号组成员', 'User/showGroup', '1', '0', '1', '0', '0', '显示账号组详情及该组成员', '7');
INSERT INTO `darling_menu_url` VALUES ('7', '账号组管理', 'Group/index', '1', '1', '1', '1', '4', '增加管理员', '0');
INSERT INTO `darling_menu_url` VALUES ('8', '修改账号组', 'Group/edit', '1', '0', '1', '0', '0', '修改账号组', '7');
INSERT INTO `darling_menu_url` VALUES ('9', '新建账号组', 'Group/add', '1', '0', '1', '1', '0', '新建账号组', '7');
INSERT INTO `darling_menu_url` VALUES ('10', '权限管理', 'Group/group_role', '1', '1', '1', '1', '3', '用户权限依赖于账号组的权限', '0');
INSERT INTO `darling_menu_url` VALUES ('11', '菜单模块', 'Module/index', '1', '1', '1', '1', '0', '菜单里的模块', '0');
INSERT INTO `darling_menu_url` VALUES ('12', '编辑菜单模块', 'Module/edit', '1', '0', '1', '0', '0', '编辑模块', '11');
INSERT INTO `darling_menu_url` VALUES ('13', '添加菜单模块', 'Module/add', '1', '0', '1', '1', '0', '添加菜单模块', '11');
INSERT INTO `darling_menu_url` VALUES ('14', '功能列表', 'Menu/index', '1', '1', '1', '1', '0', '菜单功能及可访问的链接', '0');
INSERT INTO `darling_menu_url` VALUES ('15', '增加功能', 'Menu/add', '1', '0', '1', '1', '0', '增加功能', '14');
INSERT INTO `darling_menu_url` VALUES ('16', '功能修改', 'Menu/edit', '1', '0', '1', '0', '0', '修改功能', '14');
INSERT INTO `darling_menu_url` VALUES ('17', '设置模板', '/panel/set.php', '1', '0', '1', '1', '0', '设置模板', '0');
INSERT INTO `darling_menu_url` VALUES ('19', '菜单链接列表', '/panel/module.php', '1', '0', '1', '0', '0', '显示模块详情及该模块下的菜单', '11');
INSERT INTO `darling_menu_url` VALUES ('20', '登入', 'Login/index', '1', '0', '1', '1', '0', '登入页面', '0');
INSERT INTO `darling_menu_url` VALUES ('21', '操作记录', 'Syslog/index', '1', '1', '1', '1', '2', '用户操作的历史行为', '0');
INSERT INTO `darling_menu_url` VALUES ('22', '系统信息', 'System/index', '1', '1', '1', '1', '0', '显示系统相关信息', '0');
INSERT INTO `darling_menu_url` VALUES ('23', '文件上传', 'File/upload', '8', '1', '1', '1', '1', '文件上传控制', '0');
INSERT INTO `darling_menu_url` VALUES ('24', '测试列表', 'Test/index', '8', '1', '1', '1', '0', '呵呵呵', '0');

-- ----------------------------
-- Table structure for darling_module
-- ----------------------------
DROP TABLE IF EXISTS `darling_module`;
CREATE TABLE `darling_module` (
  `module_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_url` varchar(128) NOT NULL,
  `module_sort` int(11) unsigned NOT NULL DEFAULT '1',
  `module_desc` varchar(255) DEFAULT NULL,
  `module_icon` varchar(32) DEFAULT 'icon-th' COMMENT '菜单模块图标',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '模块是否在线',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='菜单模块';

-- ----------------------------
-- Records of darling_module
-- ----------------------------
INSERT INTO `darling_module` VALUES ('1', '网站管理', 'Index/index', '1', '配置网站的相关信息', 'icon-th', '1');
INSERT INTO `darling_module` VALUES ('8', '测试模块', 'Test/index', '2', '啦啦', 'icon-th', '1');

-- ----------------------------
-- Table structure for darling_system
-- ----------------------------
DROP TABLE IF EXISTS `darling_system`;
CREATE TABLE `darling_system` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';

-- ----------------------------
-- Records of darling_system
-- ----------------------------
INSERT INTO `darling_system` VALUES ('timezone', '\"Asia/Shanghai\"');

-- ----------------------------
-- Table structure for darling_sys_log
-- ----------------------------
DROP TABLE IF EXISTS `darling_sys_log`;
CREATE TABLE `darling_sys_log` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `action` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL COMMENT '操作了哪个类的对象',
  `class_obj` varchar(32) NOT NULL COMMENT '操作的对象是谁，可能为对象的ID',
  `result` text NOT NULL COMMENT '操作的结果',
  `op_time` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_time` (`op_time`),
  KEY `class_name` (`class_name`)
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of darling_sys_log
-- ----------------------------
INSERT INTO `darling_sys_log` VALUES ('283', 'admin', 'MODIFY', 'UserGroup', '4', '{\"group_id\":\"4\",\"group_role\":\"1,5,8,11\"}', '1475203109');
INSERT INTO `darling_sys_log` VALUES ('284', 'admin', 'MODIFY', 'UserGroup', '4', '{\"group_id\":\"4\",\"group_role\":\"1,5,8\"}', '1475203115');
INSERT INTO `darling_sys_log` VALUES ('285', 'admin', 'ADD', 'UserGroup', '1', '{\"group_name\":\"adf\",\"group_desc\":\"adfsa\",\"group_role\":\"1,5,17,18,22,23,24,25\",\"owner_id\":1}', '1475203599');
INSERT INTO `darling_sys_log` VALUES ('286', 'admin', 'MODIFY', 'Module', '4', '{\"module_id\":4,\"module_name\":\"\\u4ea7\\u54c1\\u7ba1\\u7406\",\"module_url\":\"\\/product\\/index.php\",\"module_sort\":\"2\",\"module_desc\":\"\\u4ea7\\u54c1\\u7ba1\\u7406\"}', '1475206034');
INSERT INTO `darling_sys_log` VALUES ('287', 'admin', 'MODIFY', 'Module', '6', '{\"module_id\":\"6\",\"module_name\":\"\\u8bbe\\u8ba1\\u5e08\\u7ba1\\u740611\",\"module_url\":\"\\/designer\\/index,php\",\"module_sort\":\"2\",\"module_desc\":\"\\u8bbe\\u8ba1\\u5e08\\u7ba1\\u7406\"}', '1475206401');
INSERT INTO `darling_sys_log` VALUES ('288', 'admin', 'MODIFY', 'Module', '6', '{\"module_id\":\"6\",\"module_name\":\"\\u8bbe\\u8ba1\\u5e08\\u7ba1\\u7406\",\"module_url\":\"\\/designer\\/index,php\",\"module_sort\":\"2\",\"module_desc\":\"\\u8bbe\\u8ba1\\u5e08\\u7ba1\\u7406\"}', '1475206409');
INSERT INTO `darling_sys_log` VALUES ('289', 'admin', 'ADD', 'Module', '1', '{\"module_name\":\"sfsadf\",\"module_url\":\"Module\\/add\",\"module_sort\":\"12\",\"module_desc\":\"aqefdasqrd\"}', '1475206884');
INSERT INTO `darling_sys_log` VALUES ('290', 'admin', 'DEL', 'Module', '9', '{\"module_id\":9,\"module_name\":\"sfsadf\",\"module_url\":\"Module\\/add\",\"module_sort\":12,\"module_desc\":\"aqefdasqrd\",\"module_icon\":\"icon-th\",\"online\":1}', '1475206889');
INSERT INTO `darling_sys_log` VALUES ('291', 'admin', 'MODIFY', 'MenuUrl', '123', '{\"menu_name\":\"\\u8054\\u7edc\\u8be6\\u60c5\",\"menu_url\":\"Contact\\/show\",\"module_id\":\"7\",\"is_show\":\"0\",\"father_menu\":\"0\",\"online\":\"1\",\"shortcut_allowed\":\"0\",\"sort\":\"0\",\"menu_desc\":\"\\u663e\\u793a\\u8054\\u7edc\\u8be6\\u60c5\\u963f\\u9053\\u592b\",\"menu_id\":123}', '1475215593');
INSERT INTO `darling_sys_log` VALUES ('292', 'admin', 'MODIFY', 'MenuUrl', '123', '{\"menu_name\":\"\\u8054\\u7edc\\u8be6\\u60c5\",\"menu_url\":\"Contact\\/show\",\"module_id\":\"7\",\"is_show\":\"0\",\"father_menu\":\"0\",\"online\":\"1\",\"shortcut_allowed\":\"0\",\"sort\":\"0\",\"menu_desc\":\"\\u663e\\u793a\\u8054\\u7edc\\u8be6\\u60c5\",\"menu_id\":123}', '1475215600');
INSERT INTO `darling_sys_log` VALUES ('293', 'admin', 'ADD', 'MenuUrl', '1', '{\"menu_name\":\"\\u6d4b\\u8bd5\",\"menu_url\":\"Test\\/index\",\"module_id\":\"6\",\"is_show\":\"1\",\"father_menu\":\"0\",\"shortcut_allowed\":\"0\",\"sort\":\"0\",\"menu_desc\":\"\\u5566\\u5566\\u5566\"}', '1475215979');
INSERT INTO `darling_sys_log` VALUES ('294', 'admin', 'MODIFY', 'MenuUrl', '124', '{\"menu_name\":\"\\u6d4b\\u8bd5\",\"menu_url\":\"Test\\/index\",\"module_id\":\"6\",\"is_show\":\"1\",\"father_menu\":\"0\",\"online\":\"1\",\"shortcut_allowed\":\"0\",\"sort\":\"0\",\"menu_desc\":\"\\u5566\\u5566\\u5566sdf\",\"menu_id\":124}', '1475215991');
INSERT INTO `darling_sys_log` VALUES ('295', 'admin', 'DEL', 'MenuUrl', '124', '{\"menu_id\":124,\"menu_name\":\"\\u6d4b\\u8bd5\",\"menu_url\":\"Test\\/index\",\"module_id\":6,\"is_show\":1,\"online\":1,\"shortcut_allowed\":0,\"sort\":0,\"menu_desc\":\"\\u5566\\u5566\\u5566sdf\",\"father_menu\":0}', '1475216017');
INSERT INTO `darling_sys_log` VALUES ('296', 'admin', 'DEL', 'Module', '6', '{\"module_id\":6,\"module_name\":\"\\u8bbe\\u8ba1\\u5e08\\u7ba1\\u7406\",\"module_url\":\"\\/designer\\/index,php\",\"module_sort\":2,\"module_desc\":\"\\u8bbe\\u8ba1\\u5e08\\u7ba1\\u7406\",\"module_icon\":\"icon-font\",\"online\":1}', '1475216048');
INSERT INTO `darling_sys_log` VALUES ('297', 'admin', 'DEL', 'Module', '7', '{\"module_id\":7,\"module_name\":\"\\u8054\\u7edc\\u7ba1\\u7406\",\"module_url\":\"\\/contact\\/index.php\",\"module_sort\":1,\"module_desc\":\"\\u8054\\u7edc\\u7ba1\\u7406\",\"module_icon\":\"icon-headphones\",\"online\":1}', '1475216052');
INSERT INTO `darling_sys_log` VALUES ('298', 'admin', 'DEL', 'Module', '5', '{\"module_id\":5,\"module_name\":\"\\u7ecf\\u9500\\u5546\\u7ba1\\u7406\",\"module_url\":\"\\/dealer\\/index.php\",\"module_sort\":1,\"module_desc\":\"\\u7ecf\\u9500\\u5546\\u7ba1\\u7406\",\"module_icon\":\"icon-user\",\"online\":1}', '1475216055');
INSERT INTO `darling_sys_log` VALUES ('299', 'admin', 'DEL', 'Module', '4', '{\"module_id\":4,\"module_name\":\"\\u4ea7\\u54c1\\u7ba1\\u7406\",\"module_url\":\"\\/product\\/index.php\",\"module_sort\":2,\"module_desc\":\"\\u4ea7\\u54c1\\u7ba1\\u7406\",\"module_icon\":\"icon-align-justify\",\"online\":1}', '1475216059');
INSERT INTO `darling_sys_log` VALUES ('300', 'admin', 'MODIFY', 'Module', '1', '{\"module_id\":\"1\",\"module_name\":\"\\u7f51\\u7ad9\\u7ba1\\u7406\",\"module_url\":\"Index\\/index\",\"module_sort\":\"1\",\"module_desc\":\"\\u914d\\u7f6e\\u7f51\\u7ad9\\u7684\\u76f8\\u5173\\u4fe1\\u606f\"}', '1475216070');
INSERT INTO `darling_sys_log` VALUES ('301', 'admin', 'ADD', 'Module', '1', '{\"module_name\":\"\\u6d4b\\u8bd5\\u6a21\\u5757\",\"module_url\":\"Test\\/index\",\"module_sort\":\"2\",\"module_desc\":\"\\u5566\\u5566\"}', '1475216127');
INSERT INTO `darling_sys_log` VALUES ('302', 'admin', 'ADD', 'MenuUrl', '1', '{\"menu_name\":\"\\u6d4b\\u8bd5\\u5217\\u8868\",\"menu_url\":\"Test\\/index\",\"module_id\":\"8\",\"is_show\":\"1\",\"father_menu\":\"0\",\"shortcut_allowed\":\"1\",\"sort\":\"0\",\"menu_desc\":\"\\u5475\\u5475\\u5475\"}', '1475216224');
INSERT INTO `darling_sys_log` VALUES ('303', 'admin', 'MODIFY', 'UserGroup', '1', '{\"group_id\":1,\"group_role\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,117,125\"}', '1475216233');
INSERT INTO `darling_sys_log` VALUES ('304', 'admin', 'MODIFY', 'MenuUrl', '117', '{\"menu_name\":\"\\u6587\\u4ef6\\u4e0a\\u4f20\",\"menu_url\":\"File\\/upload\",\"module_id\":\"8\",\"is_show\":\"1\",\"father_menu\":\"0\",\"online\":\"1\",\"shortcut_allowed\":\"1\",\"sort\":\"1\",\"menu_desc\":\"\\u6587\\u4ef6\\u4e0a\\u4f20\\u63a7\\u5236\",\"menu_id\":117}', '1475216258');
INSERT INTO `darling_sys_log` VALUES ('305', 'admin', 'MODIFY', 'UserGroup', '1', '{\"group_name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\\u7ec4\",\"group_desc\":\"\\u4e07\\u80fd\\u7684\\u4e0d\\u662f\\u795e\\uff0c\\u662f\\u7a0b\\u5e8f\\u5458bbb\",\"group_id\":1}', '1475216542');
INSERT INTO `darling_sys_log` VALUES ('306', 'admin', 'MODIFY', 'UserGroup', '1', '{\"group_name\":\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\\u7ec4\",\"group_desc\":\"\\u4e07\\u80fd\\u7684\\u4e0d\\u662f\\u795e\\uff0c\\u662f\\u7a0b\\u5e8f\\u5458\\uff0c\\u54c8\\u54c8\\u54c8\",\"group_id\":1}', '1475216553');
INSERT INTO `darling_sys_log` VALUES ('307', 'admin', 'ADD', 'UserGroup', '1', '{\"group_name\":\"\\u6d4b\\u8bd5\\u8d26\\u53f7\\u7ec4\",\"group_desc\":\"\\u5566\\u5566\\u5566\\u5566\",\"group_role\":\"1,5,17,18,22,23,24,25\",\"owner_id\":1}', '1475216632');
INSERT INTO `darling_sys_log` VALUES ('308', 'admin', 'MODIFY', 'MenuUrl', '3', '{\"menu_name\":\"\\u4fee\\u6539\\u8d26\\u53f7\",\"menu_url\":\"User\\/edit\",\"module_id\":\"1\",\"is_show\":\"0\",\"father_menu\":\"2\",\"online\":\"1\",\"shortcut_allowed\":\"0\",\"sort\":\"0\",\"menu_desc\":\"\\u4fee\\u6539\\u8d26\\u53f7\",\"menu_id\":3}', '1475905662');
INSERT INTO `darling_sys_log` VALUES ('309', 'admin', 'MODIFY', 'User', '1', '{\"user_id\":\"26\",\"user_name\":\"demo\",\"real_name\":\"sunny\",\"mobile\":\"15812345678\",\"email\":\"yuwenqi@osadmin.org\",\"user_desc\":\"\\u9ed8\\u8ba4\\u7528\\u6237\\u7ec4\\u6210\\u5458\",\"user_group\":\"1\"}', '1475905681');
INSERT INTO `darling_sys_log` VALUES ('310', 'admin', 'LOGIN', 'User', '1', '{\"IP\":\"192.168.18.130\"}', '1475905772');

-- ----------------------------
-- Table structure for darling_user
-- ----------------------------
DROP TABLE IF EXISTS `darling_user`;
CREATE TABLE `darling_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_desc` varchar(255) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `login_ip` varchar(32) DEFAULT NULL,
  `user_group` int(11) NOT NULL COMMENT ' 账号组：1:超级管理员；3：经销商管理；4：设计师',
  `template` varchar(32) NOT NULL DEFAULT 'default' COMMENT '主题模板',
  `shortcuts` text COMMENT '快捷菜单',
  `show_quicknote` int(11) NOT NULL DEFAULT '0' COMMENT '是否显示quicknote',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='后台用户';

-- ----------------------------
-- Records of darling_user
-- ----------------------------
INSERT INTO `darling_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'SomewhereYu', '13800138001', 'admin@osadmin.org', '初始的超级管理员!', '1475905772', '1', '192.168.18.130', '1', 'schoolpainting', '10,105', '0');
INSERT INTO `darling_user` VALUES ('26', 'demo', 'e10adc3949ba59abbe56e057f20f883e', 'sunny', '15812345678', 'yuwenqi@osadmin.org', '默认用户组成员', '1468824260', '1', '192.168.18.113', '1', 'schoolpainting', '', '0');

-- ----------------------------
-- Table structure for darling_user_group
-- ----------------------------
DROP TABLE IF EXISTS `darling_user_group`;
CREATE TABLE `darling_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初始权限为1,5,17,18,22,23,24,25',
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `OWNER` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='账号组';

-- ----------------------------
-- Records of darling_user_group
-- ----------------------------
INSERT INTO `darling_user_group` VALUES ('1', '超级管理员组', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,117,125', '1', '万能的不是神，是程序员，哈哈哈');
INSERT INTO `darling_user_group` VALUES ('3', '经销商管理员', '1,5,108,112,113,122,109,114,115,123', '1', '经销商管理员权限');
INSERT INTO `darling_user_group` VALUES ('5', '测试账号组', '1,5,17,18,22,23,24,25', '1', '啦啦啦啦');
