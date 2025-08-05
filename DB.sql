/*
 Navicat MySQL Data Transfer

 Source Server         : Local Host
 Source Server Type    : MySQL
 Source Server Version : 100419
 Source Host           : localhost:3306
 Source Schema         : sharawani_app

 Target Server Type    : MySQL
 Target Server Version : 100419
 File Encoding         : 65001

 Date: 15/09/2022 13:09:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dictionary
-- ----------------------------
DROP TABLE IF EXISTS `dictionary`;
CREATE TABLE `dictionary`  (
  `KEYWORD` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ARABIC` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `KURDISH` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ENGLISH` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`KEYWORD`) USING BTREE,
  INDEX `KEYWORD`(`KEYWORD`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dictionary
-- ----------------------------

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group`  (
  `GROUP_ID` int NOT NULL AUTO_INCREMENT,
  `GROUP_NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `STATUS_ID` tinyint(1) NOT NULL,
  PRIMARY KEY (`GROUP_ID`) USING BTREE,
  UNIQUE INDEX `GROUP_ID`(`GROUP_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES (1, 'Supper Admin', 1);

-- ----------------------------
-- Table structure for group_permission
-- ----------------------------
DROP TABLE IF EXISTS `group_permission`;
CREATE TABLE `group_permission`  (
  `GROUP_ID` decimal(10, 0) NOT NULL,
  `OPERATION_NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`GROUP_ID`, `OPERATION_NAME`) USING BTREE,
  INDEX `GROUP_ID`(`GROUP_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of group_permission
-- ----------------------------
INSERT INTO `group_permission` VALUES (1, 'admin_dashboard');
INSERT INTO `group_permission` VALUES (1, 'systemconfigration_dictionary');
INSERT INTO `group_permission` VALUES (1, 'user_editprofile');
INSERT INTO `group_permission` VALUES (1, 'user_grouplist');
INSERT INTO `group_permission` VALUES (1, 'user_permission');
INSERT INTO `group_permission` VALUES (1, 'user_userslist');

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `nt_id` int NOT NULL AUTO_INCREMENT,
  `nt_title` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nt_create_date` datetime NOT NULL DEFAULT current_timestamp,
  `nt_status` tinyint(1) NOT NULL DEFAULT 0,
  `nt_link` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nt_us_id` int NOT NULL,
  PRIMARY KEY (`nt_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `OPERATION_CODE` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NAME` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`OPERATION_CODE`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('admin_dashboard', 'Dashboard');
INSERT INTO `permission` VALUES ('systemconfigration_dictionary', 'Translation List');
INSERT INTO `permission` VALUES ('user_editprofile', 'Edit Profile');
INSERT INTO `permission` VALUES ('user_grouplist', 'Group List');
INSERT INTO `permission` VALUES ('user_permission', 'Permission List');
INSERT INTO `permission` VALUES ('user_userslist', 'Users List');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `USER_ID` int NOT NULL AUTO_INCREMENT,
  `LOGIN` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PASSWORD` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '1q2w3e4r5t6y7u8i+66bZU2lGnZFs0jTtzue4A==',
  `NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `FAILED_ATTEMPT_NUM` int NULL DEFAULT NULL,
  `UI_LANGUAGE` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `USER_STATUS_ID` tinyint NOT NULL,
  `user_picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `telephone` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `google_auth` tinyint(1) NULL DEFAULT 0 COMMENT '0 inactive/ 1 active',
  `google_secret_code` varchar(512) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`USER_ID`) USING BTREE,
  INDEX `LOGIN`(`LOGIN`) USING BTREE,
  INDEX `USER_STATUS_ID`(`USER_STATUS_ID`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'yasser', '1q2w3e4r5t6y7u8iP+9BG2mQjm35Qr9wNcI+Jw==', 'yasser kassem', 0, 'ENGLISH', 1, NULL, '0750-782-1578 ', 0, 'AJXVP6BYXMB7K43S');

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group`  (
  `user_id` decimal(10, 0) NOT NULL,
  `group_id` decimal(10, 0) NOT NULL,
  PRIMARY KEY (`user_id`, `group_id`) USING BTREE,
  INDEX `USER_ID`(`user_id`) USING BTREE,
  INDEX `GROUP_ID`(`group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES (1, 1);

-- ----------------------------
-- Table structure for user_status
-- ----------------------------
DROP TABLE IF EXISTS `user_status`;
CREATE TABLE `user_status`  (
  `USER_STATUS_ID` decimal(5, 0) NOT NULL,
  `USER_STATUS` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`USER_STATUS_ID`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of user_status
-- ----------------------------
INSERT INTO `user_status` VALUES (1, 'STATUS_ACTIVE');
INSERT INTO `user_status` VALUES (2, 'STATUS_INACTIVE');
INSERT INTO `user_status` VALUES (3, 'STATUS_DELETED');
INSERT INTO `user_status` VALUES (4, 'STATUS_LOCKED');

SET FOREIGN_KEY_CHECKS = 1;
