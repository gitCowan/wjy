/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50536
Source Host           : localhost:3306
Source Database       : wpan

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2016-12-16 10:22:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wp_pay
-- ----------------------------
DROP TABLE IF EXISTS `wp_pay`;
CREATE TABLE `wp_pay` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `partner` varchar(200) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pid` varchar(100) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `appid` varchar(100) DEFAULT NULL,
  `appsecret` varchar(100) DEFAULT NULL,
  `zfopen` int(10) DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wp_pay
-- ----------------------------
INSERT INTO `wp_pay` VALUES ('1', 'ytfpay', '', '', '云通付', null, '', '0', '', '', '2');
INSERT INTO `wp_pay` VALUES ('2', 'beecloud', '', '', '在线支付', null, '', '0', '', '', '2');
INSERT INTO `wp_pay` VALUES ('3', 'Wxpay', '', '', '微信支付', null, '', '1', '', '', '2');
