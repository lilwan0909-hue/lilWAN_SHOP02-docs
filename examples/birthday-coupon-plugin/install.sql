-- 生日券发放记录表
CREATE TABLE IF NOT EXISTS `plugin_birthday_coupon_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` bigint unsigned NOT NULL COMMENT '用户ID',
  `user_name` varchar(100) DEFAULT NULL COMMENT '用户名',
  `coupon_id` bigint unsigned NOT NULL COMMENT '优惠券ID',
  `coupon_name` varchar(100) DEFAULT NULL COMMENT '优惠券名称',
  `coupon_amount` decimal(10,2) DEFAULT 0.00 COMMENT '优惠券金额',
  `sent_at` timestamp NOT NULL COMMENT '发放时间',
  `birthday` date DEFAULT NULL COMMENT '用户生日',
  `status` varchar(20) DEFAULT 'sent' COMMENT '状态: sent-已发放, used-已使用, expired-已过期',
  `used_at` timestamp NULL DEFAULT NULL COMMENT '使用时间',
  `order_id` bigint unsigned DEFAULT NULL COMMENT '使用订单ID',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_coupon_id` (`coupon_id`),
  KEY `idx_sent_at` (`sent_at`),
  KEY `idx_status` (`status`),
  KEY `idx_birthday` (`birthday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='生日券发放记录表';

-- 生日券统计表
CREATE TABLE IF NOT EXISTS `plugin_birthday_coupon_statistics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `date` date NOT NULL COMMENT '日期',
  `sent_count` int DEFAULT 0 COMMENT '发放数量',
  `used_count` int DEFAULT 0 COMMENT '使用数量',
  `expired_count` int DEFAULT 0 COMMENT '过期数量',
  `total_amount` decimal(12,2) DEFAULT 0.00 COMMENT '发放总金额',
  `used_amount` decimal(12,2) DEFAULT 0.00 COMMENT '使用总金额',
  `gmv` decimal(12,2) DEFAULT 0.00 COMMENT '带来的GMV',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_date` (`date`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='生日券统计表';

