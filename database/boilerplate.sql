/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : boilerplate

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-15 20:54:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `history`
-- ----------------------------
DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assets` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `history_type_id_foreign` (`type_id`),
  KEY `history_user_id_foreign` (`user_id`),
  CONSTRAINT `history_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `history_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of history
-- ----------------------------
INSERT INTO `history` VALUES ('1', '1', '1', '4', 'plus', 'bg-green', 'trans(\"history.backend.users.created\") <strong>{user}</strong>', '{\"user_link\":[\"admin.access.user.show\",\"huang zhengjie\",4]}', '2017-10-15 12:18:27', '2017-10-15 12:18:27');
INSERT INTO `history` VALUES ('2', '1', '1', '4', 'trash', 'bg-maroon', 'trans(\"history.backend.users.deleted\") <strong>{user}</strong>', '{\"user_link\":[\"admin.access.user.show\",\"huang zhengjie\",4]}', '2017-10-15 12:19:25', '2017-10-15 12:19:25');
INSERT INTO `history` VALUES ('3', '1', '1', '4', 'refresh', 'bg-aqua', 'trans(\"history.backend.users.restored\") <strong>{user}</strong>', '{\"user_link\":[\"admin.access.user.show\",\"huang zhengjie\",4]}', '2017-10-15 12:19:41', '2017-10-15 12:19:41');

-- ----------------------------
-- Table structure for `history_types`
-- ----------------------------
DROP TABLE IF EXISTS `history_types`;
CREATE TABLE `history_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of history_types
-- ----------------------------
INSERT INTO `history_types` VALUES ('1', 'User', '2017-10-15 03:42:11', '2017-10-15 03:42:11');
INSERT INTO `history_types` VALUES ('2', 'Role', '2017-10-15 03:42:11', '2017-10-15 03:42:11');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'view-backend', 'View Backend', '2017-10-15 03:42:10', '2017-10-15 03:42:10');

-- ----------------------------
-- Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1', '2');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `all` tinyint(1) NOT NULL DEFAULT '0',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Administrator', '1', '1', '2017-10-15 03:42:10', '2017-10-15 03:42:10');
INSERT INTO `roles` VALUES ('2', 'Executive', '0', '2', '2017-10-15 03:42:10', '2017-10-15 03:42:10');
INSERT INTO `roles` VALUES ('3', 'User', '0', '3', '2017-10-15 03:42:10', '2017-10-15 03:42:10');

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1', '1');
INSERT INTO `role_user` VALUES ('2', '2', '2');
INSERT INTO `role_user` VALUES ('3', '3', '3');
INSERT INTO `role_user` VALUES ('4', '4', '1');

-- ----------------------------
-- Table structure for `sessions`
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for `social_logins`
-- ----------------------------
DROP TABLE IF EXISTS `social_logins`;
CREATE TABLE `social_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `provider` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_logins_user_id_foreign` (`user_id`),
  CONSTRAINT `social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of social_logins
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `confirmation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Admin', 'Istrator', 'admin@admin.com', '$2y$10$lKVKC0oHYX9lzGqx2gz78e0A6ZF1IbwmLzj8MBgwKOttfVQ3agLre', '1', '7306ec90bd4a98b63204b13121dfe416', '1', 'cM64ZOnjLsGokFXRHcoIEbpiIkvif0wzvDs70L053DBrjMfZO5oiEASBL479', '2017-10-15 03:42:09', '2017-10-15 03:42:09', null);
INSERT INTO `users` VALUES ('2', 'Backend', 'User', 'executive@executive.com', '$2y$10$T/3DNauuQJv9TfwQUsRbreCuymVqZsjnpLZiMGyqsVJC.Fuz3RieG', '1', '516d1935eb0a78ded4443fac214f369f', '1', 'Q533alTtEtjPF1VlVesCsUv40S1Z8OM2vhaUffMK47PIvKscvLsAemWt2i7u', '2017-10-15 03:42:09', '2017-10-15 03:42:09', null);
INSERT INTO `users` VALUES ('3', 'Default1', 'User', 'user@user.com', '$2y$10$fVmGGg3lgLaLkPCbMnfmHOayi.nh8R499zH77Ca7XoeMzh4yJpCHK', '1', '1e4b9cf8db0732adad7d851078621ebc', '1', 'pgXqLty9TcITmYBzXfsk4XAk0d1xRrhoRpAKrbqpztOK87eX0FQnZhEYgBgH', '2017-10-15 03:42:09', '2017-10-15 10:02:44', null);
INSERT INTO `users` VALUES ('4', 'huang', 'zhengjie', 'huangzhengjie@dingtalk.com', '$2y$10$K2j7WhL1vmkR9HQirI4DkeJxh6kED6KX4iHPkOXyP8yN7GnvgcNke', '1', '7db33247558203f76902f209aa73c31c', '1', null, '2017-10-15 12:18:27', '2017-10-15 12:19:40', null);
