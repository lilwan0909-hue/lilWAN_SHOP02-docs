# 简单折扣插件

## 插件信息

- **插件代码**: simple-discount
- **插件名称**: 全场9折
- **插件类型**: discount（折扣类）
- **版本**: 1.0.0
- **复杂度**: ⭐ 简单
- **代码量**: ~120行

## 功能说明

全场9折优惠，订单金额满50元即可享受。

## 学习要点

### 1. 实现基本的插件接口

所有插件必须实现 `MarketingPluginInterface` 接口的8个方法：

```php
public function getCode(): string;
public function getName(): string;
public function getSettlementStep(): int;
public function isApplicable(PricingContext $context): bool;
public function calculate(PricingContext $context): array;
public function getPriority(): int;
public function getStackingRule(): string;
public function getMutuallyExclusivePlugins(): array;
```

### 2. 使用PricingContext

`PricingContext` 对象包含订单和用户信息：

```php
$context->items;           // 购物车商品项
$context->user;            // 用户对象
$context->currentAmount;   // 当前金额
$context->originalAmount;  // 原始金额
```

### 3. 简单的条件判断

```php
public function isApplicable(PricingContext $context): bool
{
    // 订单金额必须≥50元
    if ($context->currentAmount < 50) {
        return false;
    }
    return true;
}
```

### 4. 折扣金额计算

```php
public function calculate(PricingContext $context): array
{
    // 9折 = 优惠10%
    $discountAmount = $context->currentAmount * 0.1;
    
    return [
        'discount_amount' => $discountAmount,
        'items' => [],
        'metadata' => ['discount_rate' => 0.9],
    ];
}
```

## 代码结构

```
simple-discount/
├── plugin.json      # 插件元数据
├── tcals.json       # TCALS配置
├── src/
│   └── Plugin.php   # 插件主类
└── README.md        # 说明文档
```

## 安装方法

### 1. 打包插件

```bash
cd resources/plugin-examples/simple-discount
zip -r simple-discount.zip . -x ".DS_Store"
```

### 2. 上传插件

- 进入管理后台
- 营销管理 -> 插件管理
- 点击"上传插件"
- 选择 `simple-discount.zip`

### 3. 启用插件

- 在插件列表中找到"全场9折"
- 点击"启用"

## 测试

### 测试用例1：订单金额 < 50元

```
订单金额：30元
预期结果：不享受折扣
```

### 测试用例2：订单金额 = 50元

```
订单金额：50元
预期结果：优惠5元，实付45元
```

### 测试用例3：订单金额 > 50元

```
订单金额：100元
预期结果：优惠10元，实付90元
```

## TCALS配置解析

### Trigger（触发器）

```json
{
  "type": "checkout"
}
```

**说明**: 在结算时触发

### Condition（条件）

```json
{
  "logic": "AND",
  "rules": [
    {
      "type": "order_amount",
      "min_amount": 50
    }
  ]
}
```

**说明**: 订单金额≥50元

### Action（动作）

```json
{
  "type": "discount_percent",
  "value": 10
}
```

**说明**: 10%折扣（9折）

### Limit（限制）

```json
[
  {
    "type": "usage_count",
    "max_count": 100000
  }
]
```

**说明**: 总使用次数10万次

### Settlement（结算）

```json
{
  "step": 2,
  "stacking_rule": "stack",
  "mutex_with": []
}
```

**说明**: 
- 步骤2：商品级优惠
- 可叠加：可与其他优惠同时使用
- 不互斥：不与任何插件互斥

## 扩展思路

### 1. 添加时间限制

```php
public function isApplicable(PricingContext $context): bool
{
    // 检查活动时间
    $now = now();
    if ($now->lt('2025-01-01') || $now->gt('2025-12-31')) {
        return false;
    }
    
    // 检查订单金额
    if ($context->currentAmount < 50) {
        return false;
    }
    
    return true;
}
```

### 2. 添加用户等级限制

```php
public function isApplicable(PricingContext $context): bool
{
    // 只有VIP用户可用
    if (!$context->user || $context->user->level !== 'vip') {
        return false;
    }
    
    // 检查订单金额
    if ($context->currentAmount < 50) {
        return false;
    }
    
    return true;
}
```

### 3. 添加商品分类限制

```php
public function calculate(PricingContext $context): array
{
    $discountAmount = 0;
    $affectedItems = [];
    
    // 只对特定分类商品打折
    foreach ($context->items as $item) {
        if ($item['category_id'] === 1) {
            $itemDiscount = $item['price'] * $item['quantity'] * 0.1;
            $discountAmount += $itemDiscount;
            
            $affectedItems[] = [
                'product_id' => $item['product_id'],
                'discount' => $itemDiscount,
            ];
        }
    }
    
    return [
        'discount_amount' => $discountAmount,
        'items' => $affectedItems,
        'metadata' => ['discount_rate' => 0.9],
    ];
}
```

### 4. 调整折扣比例

修改 `calculate()` 方法中的折扣比例：

```php
// 8折（优惠20%）
$discountAmount = $context->currentAmount * 0.2;

// 7.5折（优惠25%）
$discountAmount = $context->currentAmount * 0.25;
```

## 常见问题

### Q1: 插件不生效？

**A**: 检查以下几点：
1. 插件是否已启用
2. 订单金额是否≥50元
3. 查看日志：`storage/logs/laravel.log`

### Q2: 如何调试？

**A**: 在 `calculate()` 方法中添加日志：

```php
use Illuminate\Support\Facades\Log;

public function calculate(PricingContext $context): array
{
    Log::info('Simple discount calculating', [
        'current_amount' => $context->currentAmount,
    ]);
    
    // ...
}
```

### Q3: 如何修改折扣条件？

**A**: 修改 `isApplicable()` 方法和 `tcals.json` 中的条件配置。

## 版本历史

- **1.0.0** (2025-10-28): 初始版本

## 作者

lilWAN Development Team

## 许可证

MIT License

