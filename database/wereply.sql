/*
Navicat MySQL Data Transfer

Source Server         : 120.76.74.76
Source Server Version : 50635
Source Host           : 120.76.74.76:3306
Source Database       : wereply

Target Server Type    : MYSQL
Target Server Version : 50635
File Encoding         : 65001

Date: 2017-10-31 14:52:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(16) NOT NULL COMMENT '登录账号',
  `passwd` varchar(255) NOT NULL COMMENT '密码',
  `appid` varchar(62) NOT NULL,
  `appsecret` varchar(62) NOT NULL,
  `normal_access_token` varchar(256) NOT NULL DEFAULT '' COMMENT '基础令牌',
  `web_access_token` varchar(256) NOT NULL DEFAULT '' COMMENT '网页令牌',
  `normal_expires` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '基础令牌过期时间',
  `web_expires` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '网页令牌过期时间',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='微信账号';

-- ----------------------------
-- Table structure for call_interface_log
-- ----------------------------
DROP TABLE IF EXISTS `call_interface_log`;
CREATE TABLE `call_interface_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL COMMENT '日期',
  `account_id` int(10) unsigned NOT NULL COMMENT '账号id',
  `get_user_list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '获取用户列表次数',
  `send_kf_msg` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送客服消息次数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `day` (`day`,`account_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` varchar(100) NOT NULL COMMENT '文件微信标识',
  `url` varchar(255) NOT NULL COMMENT '文件url地址',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `media` (`media_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for follow_reply
-- ----------------------------
DROP TABLE IF EXISTS `follow_reply`;
CREATE TABLE `follow_reply` (
  `account_id` int(10) unsigned NOT NULL COMMENT '账号id',
  `contents` text NOT NULL,
  `msg_type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '消息类型1文本 2图片 3图文',
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='关注回复';

-- ----------------------------
-- Table structure for follow_tick
-- ----------------------------
DROP TABLE IF EXISTS `follow_tick`;
CREATE TABLE `follow_tick` (
  `account_id` int(10) unsigned NOT NULL COMMENT '账号id',
  `customer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '客服id',
  `send_offset` int(10) unsigned NOT NULL DEFAULT '60' COMMENT '定时发送偏移时间（单位秒）',
  `msgtype` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '定时发送消息类型',
  `contents` text NOT NULL COMMENT '定时发送内容',
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='关注定时发送客服消息';

-- ----------------------------
-- Table structure for group_send
-- ----------------------------
DROP TABLE IF EXISTS `group_send`;
CREATE TABLE `group_send` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL COMMENT '账号id',
  `msg_type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '消息类型1文本 2图片 3图文',
  `contents` text NOT NULL COMMENT '群发内容',
  `success_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '成功次数',
  `failed_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '失败次数',
  `start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始发送时间',
  `complete_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '完成时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0未开始，1进行中，2完成',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='关注回复';

-- ----------------------------
-- Table structure for task_logs
-- ----------------------------
DROP TABLE IF EXISTS `task_logs`;
CREATE TABLE `task_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL COMMENT '任务id',
  `level` char(16) NOT NULL DEFAULT 'DEBUG' COMMENT '日志级别',
  `infos` text NOT NULL COMMENT '日志内容',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10503 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for ticksend
-- ----------------------------
DROP TABLE IF EXISTS `ticksend`;
CREATE TABLE `ticksend` (
  `account_id` int(10) unsigned NOT NULL COMMENT '账号id',
  `send_time` int(10) unsigned NOT NULL COMMENT '发送时间',
  `openid` varchar(64) NOT NULL COMMENT '微信id',
  `msgtype` tinyint(2) unsigned NOT NULL COMMENT '发送消息类型',
  `contents` text NOT NULL COMMENT '发送内容',
  PRIMARY KEY (`account_id`,`send_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='定时发送任务';

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
