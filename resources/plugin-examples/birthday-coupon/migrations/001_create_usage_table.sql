-- Migration: Create birthday coupon usage table
-- Plugin: birthday-coupon
-- Version: 1.0.0

CREATE TABLE IF NOT EXISTS `plugin_birthday_coupon_usage` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL COMMENT '用户ID',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '折扣金额',
  `used_month` varchar(7) NOT NULL COMMENT '使用月份(YYYY-MM)',
  `order_id` bigint unsigned DEFAULT NULL COMMENT '订单ID',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `used_month` (`used_month`),
  UNIQUE KEY `user_month` (`user_id`, `used_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='插件-生日优惠券使用记录表';

