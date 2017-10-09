/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50632
 Source Host           : localhost
 Source Database       : phpkit

 Target Server Type    : MySQL
 Target Server Version : 50632
 File Encoding         : utf-8

 Date: 10/09/2017 18:24:06 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `addon_auth`
-- ----------------------------
DROP TABLE IF EXISTS `addon_auth`;
CREATE TABLE `addon_auth` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Title` char(20) NOT NULL DEFAULT '',
  `AuthCode` char(80) NOT NULL DEFAULT '',
  `GroupId` int(10) NOT NULL DEFAULT '0',
  `Status` tinyint(1) unsigned zerofill DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`Id`),
  KEY `pid` (`GroupId`)
) ENGINE=MyISAM AUTO_INCREMENT=4516 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台权限列表';

-- ----------------------------
--  Records of `addon_auth`
-- ----------------------------
BEGIN;
INSERT INTO `addon_auth` VALUES ('4508', '系统菜单分组', 'system-admin-menu-group/index', '1006', '1'), ('4509', '系统菜单', 'system-admin-menu/index', '1006', '1'), ('4510', '权限组', 'addon-auth-group/index', '1006', '1'), ('4511', '权限列表', 'addon-auth/index', '1006', '1'), ('4512', 'CRUD 模型', 'scaffold/index', '1006', '1'), ('4513', '商户管理', 'system-store/index', '1006', '1'), ('4514', '后台用户管理', 'system-store-user/index', '1006', '1'), ('4515', '会员列表', 'member/index', '1007', '1');
COMMIT;

-- ----------------------------
--  Table structure for `addon_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `addon_auth_group`;
CREATE TABLE `addon_auth_group` (
  `Id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `Title` char(100) NOT NULL DEFAULT '',
  `OrderBy` int(11) DEFAULT '255' COMMENT '排序',
  `Ico` varchar(255) DEFAULT '' COMMENT '对应图标',
  `Status` tinyint(1) DEFAULT '1',
  `Cate` varchar(255) DEFAULT '' COMMENT '分类',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=1008 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='权限组';

-- ----------------------------
--  Records of `addon_auth_group`
-- ----------------------------
BEGIN;
INSERT INTO `addon_auth_group` VALUES ('1006', '系统管理', '255', '', '1', 'system'), ('1007', '会员管理', '255', '', '1', 'user');
COMMIT;

-- ----------------------------
--  Table structure for `addon_auth_user`
-- ----------------------------
DROP TABLE IF EXISTS `addon_auth_user`;
CREATE TABLE `addon_auth_user` (
  `UserId` int(8) unsigned NOT NULL DEFAULT '0',
  `RoleId` int(11) NOT NULL COMMENT '权限ids',
  PRIMARY KEY (`UserId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户属于那个用户组';

-- ----------------------------
--  Records of `addon_auth_user`
-- ----------------------------
BEGIN;
INSERT INTO `addon_auth_user` VALUES ('132', '241');
COMMIT;

-- ----------------------------
--  Table structure for `addon_auth_user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `addon_auth_user_roles`;
CREATE TABLE `addon_auth_user_roles` (
  `Id` int(8) unsigned NOT NULL DEFAULT '0',
  `AuthIds` text NOT NULL COMMENT '权限ids',
  `RoleName` varchar(255) NOT NULL COMMENT '组名',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户权限组';

-- ----------------------------
--  Records of `addon_auth_user_roles`
-- ----------------------------
BEGIN;
INSERT INTO `addon_auth_user_roles` VALUES ('241', '4508,4509,4510,4511,4512,4513,4514,4515', '小温的测试');
COMMIT;

-- ----------------------------
--  Table structure for `system_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `system_admin_menu`;
CREATE TABLE `system_admin_menu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `Url` varchar(300) NOT NULL COMMENT '链接',
  `Name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `OrderBy` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `Pid` int(11) NOT NULL DEFAULT '0' COMMENT '组Id',
  `ActiveMenu` varchar(50) DEFAULT NULL,
  `Code` varchar(50) NOT NULL COMMENT '链接代码',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `system_admin_menu`
-- ----------------------------
BEGIN;
INSERT INTO `system_admin_menu` VALUES ('1', '/phpkit-admin/system-admin-menu/index', '系统菜单', '2', '1', '', 'system-admin-menu'), ('2', '/phpkit-admin/addon-auth/index', '权限列表', '3', '1', '', 'addon-auth'), ('3', '/phpkit-admin/addon-auth-group/index', '权限组', '2', '1', '', 'addon-auth-group'), ('4', '/phpkit-admin/scaffold/index', 'CRUD模型', '999', '1', '', 'scaffold'), ('5', '/phpkit-admin/system-store/index', '商户管理', '999', '1', '', 'system-store'), ('6', '/phpkit-admin/system-store-user/index', '后台用户', '999', '1', '', 'system-store-user'), ('7', '/phpkit-admin/system-admin-menu-group/index', '系统菜单分组', '1', '1', '', 'system-admin-menu-group'), ('8', '/phpkit-admin/addon-auth-user-roles/index', '用户组', '6', '1', '', 'addon-auth-user-roles'), ('9', '/phpkit-admin/cache/index', '缓存管理', '999', '1', '', 'cache'), ('10', '/phpkit-admin/system-dict/index', '字典管理', '999', '1', '', 'system-dict');
COMMIT;

-- ----------------------------
--  Table structure for `system_admin_menu_group`
-- ----------------------------
DROP TABLE IF EXISTS `system_admin_menu_group`;
CREATE TABLE `system_admin_menu_group` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `MenuIcon` varchar(300) NOT NULL COMMENT '菜单图标',
  `Name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `OrderBy` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `system_admin_menu_group`
-- ----------------------------
BEGIN;
INSERT INTO `system_admin_menu_group` VALUES ('1', 'fa-asterisk', '系统', '1');
COMMIT;

-- ----------------------------
--  Table structure for `system_admin_menu_user`
-- ----------------------------
DROP TABLE IF EXISTS `system_admin_menu_user`;
CREATE TABLE `system_admin_menu_user` (
  `MenuIds` text NOT NULL COMMENT '名称',
  `UserId` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `system_admin_menu_user`
-- ----------------------------
BEGIN;
INSERT INTO `system_admin_menu_user` VALUES ('系统', '1'), ('7,1,3,2,8,4,5,6', '131');
COMMIT;

-- ----------------------------
--  Table structure for `system_dict`
-- ----------------------------
DROP TABLE IF EXISTS `system_dict`;
CREATE TABLE `system_dict` (
  `name` varchar(200) NOT NULL COMMENT '名字',
  `value` text COMMENT '配置',
  `remark` varchar(225) DEFAULT NULL COMMENT '备注',
  `addtime` int(11) DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `system_dict`
-- ----------------------------
BEGIN;
INSERT INTO `system_dict` VALUES ('allow_tags', '\"<b>,<p>,<a><img>,<span>,<h3>,<h1>,<h2>,<h4>,<strong>\"', '写用的tags', '1478856828'), ('apps', '{\"0\":{\"name\":\"\\u6559\\u80b2pc\",\"domain\":\"http:\\/\\/www.boxphp.com\"},\"2\":{\"name\":\"\\u6559\\u80b2wap\",\"domain\":\"http:\\/\\/m.jiaoyu.com\"},\"3\":{\"name\":\"\\u767b\\u5f55\\u7cfb\\u7edf\",\"domain\":\"http:\\/\\/login.jiaoyu.com\"}}', '项目', '0'), ('ask_array', '{\"10\":10,\"20\":15,\"30\":25,\"100\":62}', '回答数', '1473066624'), ('auth_cate', '{\"system\":{\"ico\":\"fa fa-cogs\",\"name\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"color\":\"btn-success\"},\"edu\":{\"ico\":\"glyphicon glyphicon-education\",\"name\":\"\\u6559\\u80b2\\u7cfb\\u7edf\",\"color\":\"btn-info\"},\"sns\":{\"ico\":\"fa fa-tasks\",\"name\":\"\\u793e\\u533a\",\"color\":\"btn-warning\"},\"signal\":{\"ico\":\"fa fa-signal\",\"name\":\"\\u8fd0\\u8425\",\"color\":\"btn-primary\"}}', '权限分组', '1461317105'), ('blocks_type', '{\"none\":\"\\u539f\\u6837\\u8f93\\u51fa\",\"image\":\"\\u56fe\\u6587\\u7a0b\\u5e8f\",\"widget\":\"widget\\u7a0b\\u5e8f\",\"PHP\":\"PHP\\u7a0b\\u5e8f\",\"topic\":\"\\u6587\\u7ae0\\u5217\\u8868\"}', '区块类型', '1473737955'), ('cate_type', '{\"doc\":\"\\u9ed1\\u76d2\\u5b50\\u6587\\u6863\"}', '分类类型', '1458976182'), ('comment_type', '{\"ask\":{\"type\":\"ask\",\"model\":\"SnsTopic\",\"url\":\"\\/Ask\\/ask_show\\/topic_id\\/\"},\"subject_order\":{\"type\":\"subject_order\",\"model\":\"EduSubjectOrder\",\"url\":\"\\/Ask\\/ask_show\\/topic_id\\/\"},\"doc\":{\"type\":\"doc\",\"model\":\"SnsTopic\",\"url\":\"\\/Index\\/show\\/topic_id\\/\"},\"group\":{\"type\":\"group\",\"model\":\"SnsTopic\",\"url\":\"\\/Index\\/detail\\/topic_id\\/\"}}', '评论', '0'), ('drive_from', '{\"1\":\"pc\\u7aef\",\"2\":\"\\u5fae\\u4fe1\\u7aef\",\"3\":\"iphone \\u5ba2\\u6237\\u7aef\",\"4\":\"\\u5b89\\u5353\\u5ba2\\u6237\\u7aef\",\"5\":\"\\u624b\\u673a\\u6d4f\\u89c8\\u5668\"}', '来源', '1474881330'), ('exams_type', '{\"autopage\":\"\\u968f\\u673a\\u7ec4\\u5377\",\"selfpage\":\"\\u624b\\u5de5\\u7ec4\\u5377\",\"module_exam\":\"\\u7ae0\\u8282\\u7ec3\\u4e60\",\"knows_exam\":\"\\u5c0f\\u8282\\u7ec3\\u4e60\"}', '', '1473950593'), ('FieldsdisplayType', '{\"1\":\"\\u5355\\u884c\\u6587\\u672c\",\"2\":\"\\u591a\\u884c\\u6587\\u672c\",\"3\":\"\\u4e0b\\u62c9\\u6846\",\"4\":\"\\u5355\\u9009\\u6846\",\"5\":\"\\u591a\\u9009\\u6846\",\"6\":\"\\u8303\\u56f4\\u578b\",\"7\":\"\\u4e0a\\u4f20\\u6309\\u94ae\",\"8\":\"\\u591a\\u6587\\u4ef6\\u4e0a\\u4f20\\u63a7\\u4ef6\",\"9\":\"smarty html\"}', '字段显示类型', '1471780483'), ('FieldvalueType', '{\"none\":\"\\u5b57\\u7b26\\u578b\",\"integer\":\"\\u6574\\u6570\\u578b\",\"numeric\":\"\\u6570\\u5b57\\u578b\",\"ip\":\"IP\",\"phone\":\"\\u624b\\u673a\\u53f7\",\"emailaddress\":\"\\u90ae\\u7bb1\"}', '字段数组类型', '1471780323'), ('finance_type', '{\"recharge\":\"\\u5728\\u7ebf\\u5145\\u503c\\u554a\",\"subject\":\"\\u5f00\\u901a\\u8bfe\\u7a0b\",\"ask\":\"\\u8d2d\\u4e70\\u7b54\\u9898\\u6570\"}', '财务统计收入来源', '1459147465'), ('gender', '{\"1\":\"\\u7537\",\"2\":\"\\u5973\",\"3\":\"\\u4fdd\\u5bc6\"}', '性别', '1467859418'), ('group_type', '{\"group\":\"\\u7fa4\\u7ec4\",\"doc\":\"\\u6587\\u6863\",\"eduGroup\":\"\\u7f16\\u7a0b\\u7fa4\\u7ec4\",\"ask\":\"\\u95ee\\u7b54\"}', '帖子类型', '1478248849'), ('group_url', '{\"group\":\"snsm\",\"doc\":\"doc\",\"ask\":\"ask\"}', '帖子分类对应的模块', '1461169965'), ('SyncLogin', '{\"qq\":{\"text\":\"QQ\\u767b\\u5f55\",\"status\":1},\"sina\":{\"text\":\"\\u65b0\\u6d6a\\u767b\\u5f55\",\"status\":1},\"weixin\":{\"text\":\"\\u5fae\\u4fe1\\u767b\\u5f55\",\"status\":0},\"weixin2\":{\"text\":\"\\u5fae\\u4fe1\\u5173\\u6ce8\\u767b\\u5f55\",\"status\":1}}', '第方登录', '1477900702'), ('user_tag', '{\"10\":\"\\u8d44\\u6df1\\u4eba\\u571f\",\"1000\":\"\\u5b66\\u6e234\"}', '用户等级', '1472285952');
COMMIT;

-- ----------------------------
--  Table structure for `system_store`
-- ----------------------------
DROP TABLE IF EXISTS `system_store`;
CREATE TABLE `system_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(200) NOT NULL,
  `store_name` varchar(225) DEFAULT NULL COMMENT '商店名',
  `created` int(11) DEFAULT NULL COMMENT '录入时间',
  `isOpen` int(2) DEFAULT '1',
  `photo` varchar(50) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=208 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `system_store`
-- ----------------------------
BEGIN;
INSERT INTO `system_store` VALUES ('140', 'logo', 'er你好', null, '1', null, null, null), ('207', 'logo', 'wen3', null, '1', null, null, null);
COMMIT;

-- ----------------------------
--  Table structure for `system_store_user`
-- ----------------------------
DROP TABLE IF EXISTS `system_store_user`;
CREATE TABLE `system_store_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(225) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `store_id` int(11) DEFAULT '0' COMMENT '商家ID 商家的管理员',
  `status` int(11) DEFAULT '1' COMMENT '状态  1正常  0为锁定',
  `pasttime` int(11) NOT NULL,
  `pid` int(11) DEFAULT '0' COMMENT '上线',
  `img` varchar(225) DEFAULT NULL COMMENT '头像',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `system_store_user`
-- ----------------------------
BEGIN;
INSERT INTO `system_store_user` VALUES ('132', 'test', '68c7f78d53fc6cb65ba5aae6f44c4036', '140', '1', '1496313189', '0', ''), ('131', 'wen190', 'e10adc3949ba59abbe56e057f20f883e', '140', '1', '1477819971', '132', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
