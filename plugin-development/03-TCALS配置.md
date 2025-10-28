# TCALS配置详解

## 什么是TCALS？

TCALS是营销插件的规则配置模型：

- **T**rigger（触发器）: 什么时候触发
- **C**ondition（条件）: 满足什么条件
- **A**ction（动作）: 执行什么操作
- **L**imit（限制）: 有什么限制
- **S**ettlement（结算）: 在哪个步骤结算

```
用户行为 → Trigger → Condition → Action → Limit → Settlement
           ↓          ↓          ↓        ↓        ↓
         结算触发   订单>100   10%折扣  每人限3次  步骤2
```

---

## 配置文件结构

`tcals.json` 文件示例：

```json
{
  "trigger": {
    "type": "checkout",
    "description": "结算时触发"
  },
  "conditions": {
    "logic": "AND",
    "rules": [
      {
        "type": "order_amount",
        "min_amount": 100,
        "description": "订单≥100元"
      }
    ]
  },
  "action": {
    "type": "discount_percent",
    "value": 10,
    "description": "10%折扣"
  },
  "limits": [
    {
      "type": "usage_count",
      "max_count": 10000
    }
  ],
  "settlement": {
    "step": 2,
    "stacking_rule": "stack",
    "mutex_with": []
  }
}
```

---

## Trigger（触发器）

### 可用类型

| 类型 | 说明 | 使用场景 |
|-----|------|---------|
| `checkout` | 结算时触发 | 大部分营销活动 |
| `product_view` | 商品浏览时触发 | 浏览即送券 |
| `cart_view` | 查看购物车时触发 | 提醒用户 |

### 配置示例

**结算触发**:
```json
{
  "trigger": {
    "type": "checkout"
  }
}
```

**商品浏览触发**:
```json
{
  "trigger": {
    "type": "product_view",
    "product_ids": [1, 2, 3]
  }
}
```

---

## Condition（条件）

### 逻辑操作符

- `AND`: 所有条件都必须满足
- `OR`: 任一条件满足即可

### 可用条件类型

#### 1. order_amount（订单金额）

```json
{
  "type": "order_amount",
  "min_amount": 100,
  "max_amount": 1000,
  "description": "订单金额100-1000元"
}
```

#### 2. product_category（商品分类）

```json
{
  "type": "product_category",
  "category_ids": [1, 2, 3],
  "description": "指定分类商品"
}
```

#### 3. user_level（用户等级）

```json
{
  "type": "user_level",
  "levels": ["vip", "svip"],
  "description": "VIP用户专享"
}
```

#### 4. time_range（时间范围）

```json
{
  "type": "time_range",
  "start_time": "2025-01-01 00:00:00",
  "end_time": "2025-12-31 23:59:59",
  "description": "活动时间"
}
```

### AND逻辑示例

所有条件都必须满足：

```json
{
  "conditions": {
    "logic": "AND",
    "rules": [
      {
        "type": "order_amount",
        "min_amount": 100
      },
      {
        "type": "user_level",
        "levels": ["vip"]
      }
    ]
  }
}
```

### OR逻辑示例

任一条件满足即可：

```json
{
  "conditions": {
    "logic": "OR",
    "rules": [
      {
        "type": "order_amount",
        "min_amount": 200
      },
      {
        "type": "user_level",
        "levels": ["svip"]
      }
    ]
  }
}
```

**含义**: 订单≥200元 OR 用户是SVIP

---

## Action（动作）

### 可用动作类型

#### 1. discount_fixed（固定金额折扣）

```json
{
  "action": {
    "type": "discount_fixed",
    "value": 20,
    "description": "减20元"
  }
}
```

#### 2. discount_percent（百分比折扣）

```json
{
  "action": {
    "type": "discount_percent",
    "value": 10,
    "description": "9折（优惠10%）"
  }
}
```

#### 3. free_shipping（免运费）

```json
{
  "action": {
    "type": "free_shipping",
    "description": "包邮"
  }
}
```

---

## Limit（限制）

### 可用限制类型

#### 1. usage_count（总使用次数）

```json
{
  "type": "usage_count",
  "max_count": 10000,
  "description": "总共10000次"
}
```

#### 2. user_usage（用户使用次数）

```json
{
  "type": "user_usage",
  "max_per_user": 3,
  "description": "每人限用3次"
}
```

#### 3. time_range（时间范围）

```json
{
  "type": "time_range",
  "start_time": "2025-01-01 00:00:00",
  "end_time": "2025-12-31 23:59:59",
  "description": "活动时间"
}
```

#### 4. stock（库存限制）

```json
{
  "type": "stock",
  "max_stock": 1000,
  "description": "限量1000份"
}
```

### 多个限制

可以同时配置多个限制：

```json
{
  "limits": [
    {
      "type": "usage_count",
      "max_count": 10000
    },
    {
      "type": "user_usage",
      "max_per_user": 1
    },
    {
      "type": "time_range",
      "start_time": "2025-01-01 00:00:00",
      "end_time": "2025-01-31 23:59:59"
    }
  ]
}
```

**含义**: 总共10000次 AND 每人限1次 AND 2025年1月活动

---

## Settlement（结算）

### 配置项

```json
{
  "settlement": {
    "step": 2,
    "stacking_rule": "stack",
    "mutex_with": []
  }
}
```

### step（结算步骤）

| 步骤 | 说明 |
|-----|------|
| 2 | 商品级优惠 |
| 3 | 订单级优惠 |
| 4 | 会员折扣 |
| 5 | 运费计算 |
| 6 | 积分抵扣 |
| 7 | 支付优惠 |

### stacking_rule（叠加规则）

| 规则 | 说明 |
|-----|------|
| `stack` | 可与其他插件叠加 |
| `mutex` | 与指定插件互斥 |
| `choose_best` | 择优（选折扣最大的） |

### mutex_with（互斥插件列表）

```json
{
  "settlement": {
    "stacking_rule": "mutex",
    "mutex_with": ["other-coupon", "full-reduce"]
  }
}
```

**含义**: 不能与 `other-coupon` 和 `full-reduce` 同时使用

---

## 完整示例

### 示例1：满减活动

```json
{
  "trigger": {
    "type": "checkout"
  },
  "conditions": {
    "logic": "AND",
    "rules": [
      {
        "type": "order_amount",
        "min_amount": 200
      }
    ]
  },
  "action": {
    "type": "discount_fixed",
    "value": 30
  },
  "limits": [
    {
      "type": "time_range",
      "start_time": "2025-01-01 00:00:00",
      "end_time": "2025-01-31 23:59:59"
    }
  ],
  "settlement": {
    "step": 3,
    "stacking_rule": "stack",
    "mutex_with": []
  }
}
```

**说明**: 满200减30，1月活动，订单级优惠，可叠加

### 示例2：VIP专享券

```json
{
  "trigger": {
    "type": "checkout"
  },
  "conditions": {
    "logic": "AND",
    "rules": [
      {
        "type": "user_level",
        "levels": ["vip", "svip"]
      },
      {
        "type": "order_amount",
        "min_amount": 100
      }
    ]
  },
  "action": {
    "type": "discount_percent",
    "value": 15
  },
  "limits": [
    {
      "type": "user_usage",
      "max_per_user": 5
    }
  ],
  "settlement": {
    "step": 4,
    "stacking_rule": "stack",
    "mutex_with": []
  }
}
```

**说明**: VIP用户，订单≥100元，享85折，每人限5次

---

## 调试技巧

### 1. 查看日志

```bash
tail -f storage/logs/laravel.log
```

### 2. 测试配置

创建测试订单，观察是否触发。

### 3. 常见问题

| 问题 | 原因 | 解决 |
|-----|------|------|
| 插件不触发 | 条件不满足 | 检查条件配置 |
| 折扣不生效 | 限制超额 | 检查限制配置 |
| 互斥失败 | 配置错误 | 检查mutex_with |

---

## 下一步

- 学习 [插件接口](./04-插件接口.md)
- 查看 [示例插件](../plugin-templates/)
- 阅读 [最佳实践](./11-最佳实践.md)

