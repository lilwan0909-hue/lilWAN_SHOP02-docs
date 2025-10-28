# 生日优惠券插件

## 插件信息

- **插件代码**: birthday-coupon
- **插件名称**: 生日优惠券
- **插件类型**: coupon（优惠券类）
- **版本**: 1.0.0
- **复杂度**: ⭐⭐⭐ 中等
- **代码量**: ~250行

## 功能说明

用户在生日月份下单，订单金额满100元可享受20元优惠，每月限用1次。

## 学习要点

### 1. 数据库操作

**查询使用记录**:
```php
private function hasUsedThisMonth(int $userId): bool
{
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    $count = DB::table('plugin_birthday_coupon_usage')
        ->where('user_id', $userId)
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->count();

    return $count > 0;
}
```

**记录使用**:
```php
private function recordUsage(int $userId, float $discountAmount): void
{
    DB::table('plugin_birthday_coupon_usage')->insert([
        'user_id' => $userId,
        'discount_amount' => $discountAmount,
        'used_month' => now()->format('Y-m'),
        'created_at' => now(),
    ]);
}
```

### 2. 用户身份验证

```php
public function isApplicable(PricingContext $context): bool
{
    // 检查用户是否登录
    if (!$context->user) {
        return false;
    }

    // 检查用户是否有生日信息
    if (!$context->user->birthday) {
        return false;
    }
    
    // ...
}
```

### 3. 日期处理

**检查生日月份**:
```php
private function isInBirthdayMonth($user): bool
{
    $now = now();
    $birthday = \Carbon\Carbon::parse($user->birthday);

    return $now->month === $birthday->month;
}
```

### 4. 错误处理

```php
try {
    $this->recordUsage($userId, $discountAmount);
    
    Log::info('Birthday coupon used', [
        'user_id' => $userId,
        'discount_amount' => $discountAmount,
    ]);
} catch (\Exception $e) {
    Log::error('Failed to record usage', [
        'error' => $e->getMessage(),
    ]);
}
```

## 数据库结构

```sql
CREATE TABLE `plugin_birthday_coupon_usage` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL COMMENT '用户ID',
  `discount_amount` decimal(10,2) NOT NULL COMMENT '折扣金额',
  `used_month` varchar(7) NOT NULL COMMENT '使用月份(YYYY-MM)',
  `order_id` bigint unsigned DEFAULT NULL COMMENT '订单ID',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_month` (`user_id`, `used_month`)
);
```

**字段说明**:
- `user_id`: 用户ID
- `discount_amount`: 使用的折扣金额
- `used_month`: 使用月份（YYYY-MM格式）
- `order_id`: 关联的订单ID（可选）

**索引说明**:
- `user_month`: 联合唯一索引，确保每用户每月只能使用一次

## 安装方法

### 1. 打包插件

```bash
cd resources/plugin-examples/birthday-coupon
zip -r birthday-coupon.zip . -x ".DS_Store"
```

### 2. 上传并启用

- 管理后台 -> 营销管理 -> 插件管理 -> 上传插件
- 选择 `birthday-coupon.zip`
- 启用插件（数据库迁移会自动执行）

## 测试

### 前置条件

1. 创建测试用户
2. 设置用户生日（确保生日月份是当前月）

```sql
UPDATE users SET birthday = '1990-10-15' WHERE id = 1;
```

### 测试用例1：正常使用

```
用户：ID=1，生日=1990-10-15
当前月份：10月
订单金额：100元
预期结果：优惠20元，实付80元
```

### 测试用例2：非生日月份

```
用户：ID=1，生日=1990-10-15
当前月份：11月
预期结果：不享受优惠
```

### 测试用例3：已使用过

```
用户：ID=1，生日=1990-10-15
当前月份：10月
本月已使用：是
预期结果：不享受优惠
```

### 测试用例4：金额不足

```
用户：ID=1，生日=1990-10-15
当前月份：10月
订单金额：50元
预期结果：不享受优惠
```

## 代码结构

```
birthday-coupon/
├── plugin.json          # 插件元数据
├── tcals.json           # TCALS配置
├── permissions.json     # 权限配置
├── src/
│   └── Plugin.php       # 插件主类
├── migrations/          # 数据库迁移
│   ├── 001_create_usage_table.sql
│   └── rollback/
│       └── 001_drop_usage_table.sql
└── README.md            # 说明文档
```

## 扩展思路

### 1. 生日周优惠

修改 `isInBirthdayMonth()` 方法：

```php
private function isInBirthdayWeek($user): bool
{
    $now = now();
    $birthday = \Carbon\Carbon::parse($user->birthday)->setYear($now->year);
    
    return $now->between(
        $birthday->copy()->subDays(3),
        $birthday->copy()->addDays(3)
    );
}
```

### 2. 根据年龄调整优惠

```php
public function calculate(PricingContext $context): array
{
    $age = now()->diffInYears($context->user->birthday);
    
    // 年龄越大优惠越多
    $discountAmount = min($age, 50); // 最高50元
    
    // ...
}
```

### 3. 发送生日祝福通知

```php
private function sendBirthdayWish(int $userId): void
{
    // 发送邮件或站内消息
    // Notification::send($user, new BirthdayWishNotification());
}
```

### 4. 统计功能

查询本月使用情况：

```php
public function getMonthlyStats(): array
{
    return DB::table('plugin_birthday_coupon_usage')
        ->select(
            DB::raw('COUNT(*) as total_uses'),
            DB::raw('SUM(discount_amount) as total_discount')
        )
        ->where('used_month', now()->format('Y-m'))
        ->first();
}
```

## 常见问题

### Q1: 用户如何查看是否可用？

**A**: 可以在用户中心显示生日优惠券状态。

### Q2: 如何手动发放？

**A**: 实现管理后台功能，直接插入使用记录（设置为未使用状态）。

### Q3: 如何处理时区问题？

**A**: 使用Laravel的时区配置，确保所有日期计算基于统一时区。

## 版本历史

- **1.0.0** (2025-10-28): 初始版本

## 作者

lilWAN Development Team

## 许可证

MIT License

