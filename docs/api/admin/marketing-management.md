# 管理后台 - 营销管理API

::: tip 路由前缀
所有接口使用 `/admin` 前缀
:::

## 优惠券管理

### 优惠券模板列表

```http
GET /admin/coupons
```

**权限**：`marketing.manage`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `keyword`: 搜索关键词
- `type`: 类型（fixed/percent/free_shipping）
- `status`: 状态（active/inactive/expired）

### 创建优惠券模板

```http
POST /admin/coupons
```

**权限**：`marketing.manage`

**请求参数**：
- `name`: 优惠券名称
- `type`: 类型（fixed/percent/free_shipping）
- `discount_value`: 折扣值
- `min_amount`: 最低使用金额
- `total_quantity`: 发行总量
- `per_user_limit`: 每用户限领数量
- `start_time`: 开始时间
- `end_time`: 结束时间
- `applicable_products`: 适用商品（可选）
- `applicable_categories`: 适用分类（可选）

### 优惠券详情

```http
GET /admin/coupons/{id}
```

**权限**：`marketing.manage`

### 更新优惠券

```http
PUT /admin/coupons/{id}
```

**权限**：`marketing.manage`

### 删除优惠券

```http
DELETE /admin/coupons/{id}
```

**权限**：`marketing.manage`

### 启用/禁用优惠券

```http
PUT /admin/coupons/{id}/status
POST /admin/coupons/{id}/toggle-status
```

**权限**：`marketing.manage`

**说明**：两个接口功能相同，保留兼容

---

### 发放优惠券（单个用户）

```http
POST /admin/coupons/{id}/grant
```

**权限**：`marketing.manage`

**请求参数**：
- `user_id`: 用户ID
- `quantity`: 数量

### 批量发放优惠券

```http
POST /admin/coupons/{id}/grant-batch
```

**权限**：`marketing.manage`

**请求参数**：
- `user_ids`: 用户ID数组
- `quantity`: 每人数量

### 优惠券统计

```http
GET /admin/coupons/{id}/stats
```

**权限**：`marketing.manage`

**返回**：
- 发行总量
- 已领取数量
- 已使用数量
- 使用率

---

## 用户优惠券管理

### 用户优惠券列表

```http
GET /admin/user-coupons
GET /admin/users/{userId}/coupons
```

**权限**：`marketing.manage` 或 `user.manage`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `user_id`: 用户ID
- `coupon_id`: 优惠券ID
- `status`: 状态（unused/used/expired）

### 发放优惠券给用户

```http
POST /admin/users/{userId}/coupons
POST /admin/users/{userId}/coupons/grant
```

**权限**：`user.manage`

**请求参数**：
- `coupon_id`: 优惠券ID
- `quantity`: 数量

### 作废用户优惠券

```http
POST /admin/user-coupons/{id}/revoke
```

**权限**：`marketing.manage` 或 `user.manage`

**说明**：强制作废用户已领取的优惠券

### 用户优惠券统计

```http
GET /admin/users/{userId}/coupons/stats
```

**权限**：`user.manage`

---

## 营销插件管理

### 营销插件列表

```http
GET /admin/marketing-plugins
```

**权限**：`marketing.manage`

### 营销插件统计

```http
GET /admin/marketing-plugins/statistics
```

**权限**：`marketing.manage`

**返回**：插件总数、启用数、使用次数等

### 营销插件详情

```http
GET /admin/marketing-plugins/{id}
```

**权限**：`marketing.manage`

### 创建营销插件

```http
POST /admin/marketing-plugins
```

**权限**：`marketing.manage`

### 更新营销插件

```http
PUT /admin/marketing-plugins/{id}
```

**权限**：`marketing.manage`

### 删除营销插件

```http
DELETE /admin/marketing-plugins/{id}
```

**权限**：`marketing.manage`

### 启用插件

```http
POST /admin/marketing-plugins/{id}/enable
POST /admin/marketing-plugins/{id}/toggle-status
```

**权限**：`marketing.manage`

### 禁用插件

```http
POST /admin/marketing-plugins/{id}/disable
```

**权限**：`marketing.manage`

### 上传营销插件

```http
POST /admin/marketing-plugins/upload
```

**权限**：`marketing.manage`

**请求参数**：
- `file`: 插件ZIP包

### 卸载营销插件

```http
DELETE /admin/marketing-plugins/{id}/uninstall
```

**权限**：`marketing.manage`

**说明**：卸载并删除插件文件

### 插件使用记录

```http
GET /admin/marketing-plugins/{id}/usage-logs
```

**权限**：`marketing.manage`

### 获取插件配置

```http
GET /admin/marketing-plugins/{id}/config
```

**权限**：`marketing.manage`

### 保存插件配置

```http
POST /admin/marketing-plugins/{id}/config
```

**权限**：`marketing.manage`

**说明**：每个插件有自己的配置项（TCALS规则等）

---

## 秒杀活动管理

### 秒杀活动列表

```http
GET /admin/seckills
GET /admin/seckill-activities
```

**权限**：`marketing.manage`

**说明**：两个接口功能相同，保留兼容

### 创建秒杀活动

```http
POST /admin/seckills
POST /admin/seckill-activities
```

**权限**：`marketing.manage`

**请求参数**：
- `name`: 活动名称
- `product_id`: 商品ID
- `sku_id`: SKU ID
- `seckill_price`: 秒杀价格
- `seckill_stock`: 秒杀库存
- `start_time`: 开始时间
- `end_time`: 结束时间
- `per_user_limit`: 每人限购数量

### 秒杀活动详情

```http
GET /admin/seckills/{id}
GET /admin/seckill-activities/{id}
```

**权限**：`marketing.manage`

### 更新秒杀活动

```http
PUT /admin/seckills/{id}
PUT /admin/seckill-activities/{id}
```

**权限**：`marketing.manage`

### 删除秒杀活动

```http
DELETE /admin/seckills/{id}
DELETE /admin/seckill-activities/{id}
```

**权限**：`marketing.manage`

### 更新秒杀状态

```http
PUT /admin/seckills/{id}/status
PUT /admin/seckill-activities/{id}/status
```

**权限**：`marketing.manage`

**请求参数**：
- `status`: 状态（active/inactive）

### 秒杀订单列表

```http
GET /admin/seckills/{id}/orders
GET /admin/seckill-activities/{id}/orders
```

**权限**：`marketing.manage`

### 秒杀活动统计

```http
GET /admin/seckills/{id}/statistics
GET /admin/seckill-activities/{id}/statistics
```

**权限**：`marketing.manage`

**返回**：
- 参与人数
- 成交订单
- 成交金额
- 转化率

---

## 拼团活动管理

### 拼团活动列表

```http
GET /admin/group-buys
GET /admin/group-buy-activities
```

**权限**：`marketing.manage`

### 创建拼团活动

```http
POST /admin/group-buys
POST /admin/group-buy-activities
```

**权限**：`marketing.manage`

**请求参数**：
- `name`: 活动名称
- `product_id`: 商品ID
- `sku_id`: SKU ID
- `group_price`: 拼团价格
- `required_count`: 成团人数
- `time_limit`: 拼团时限（小时）
- `start_time`: 开始时间
- `end_time`: 结束时间

### 拼团活动详情

```http
GET /admin/group-buys/{id}
GET /admin/group-buy-activities/{id}
```

**权限**：`marketing.manage`

### 更新拼团活动

```http
PUT /admin/group-buys/{id}
PUT /admin/group-buy-activities/{id}
```

**权限**：`marketing.manage`

### 删除拼团活动

```http
DELETE /admin/group-buys/{id}
DELETE /admin/group-buy-activities/{id}
```

**权限**：`marketing.manage`

### 更新拼团状态

```http
PUT /admin/group-buys/{id}/status
PUT /admin/group-buy-activities/{id}/status
```

**权限**：`marketing.manage`

### 拼团团队列表

```http
GET /admin/group-buys/{id}/teams
GET /admin/group-buy-activities/{id}/teams
```

**权限**：`marketing.manage`

**返回**：所有拼团团队（进行中、成功、失败）

### 拼团活动统计

```http
GET /admin/group-buys/{id}/statistics
GET /admin/group-buy-activities/{id}/statistics
```

**权限**：`marketing.manage`

**返回**：
- 开团数量
- 成团数量
- 参与人数
- 成交金额
- 成团率

---

## 满减活动管理

### 满减活动列表

```http
GET /admin/full-reduces
GET /admin/full-reduce-activities
```

**权限**：`marketing.manage`

### 创建满减活动

```http
POST /admin/full-reduces
POST /admin/full-reduce-activities
```

**权限**：`marketing.manage`

**请求参数**：
- `name`: 活动名称
- `min_amount`: 满减金额条件
- `discount_amount`: 减免金额
- `start_time`: 开始时间
- `end_time`: 结束时间
- `applicable_products`: 适用商品（可选）
- `applicable_categories`: 适用分类（可选）

### 满减活动详情

```http
GET /admin/full-reduces/{id}
GET /admin/full-reduce-activities/{id}
```

**权限**：`marketing.manage`

### 更新满减活动

```http
PUT /admin/full-reduces/{id}
PUT /admin/full-reduce-activities/{id}
```

**权限**：`marketing.manage`

### 删除满减活动

```http
DELETE /admin/full-reduces/{id}
DELETE /admin/full-reduce-activities/{id}
```

**权限**：`marketing.manage`

### 更新满减状态

```http
PUT /admin/full-reduces/{id}/status
PUT /admin/full-reduce-activities/{id}/status
```

**权限**：`marketing.manage`

### 满减活动统计

```http
GET /admin/full-reduce-activities/{id}/statistics
```

**权限**：`marketing.manage`

### 批量导入满减活动

```http
POST /admin/full-reduce-activities/batch-import
```

**权限**：`marketing.manage`

---

## 黑名单管理

### 黑名单列表

```http
GET /admin/blacklist
```

**权限**：`marketing.manage`

**查询参数**：
- `type`: 类型（user/ip/device/phone）
- `source`: 来源（manual/auto）
- `keyword`: 搜索关键词

### 黑名单统计

```http
GET /admin/blacklist/statistics
```

**权限**：`marketing.manage`

### 黑名单类型选项

```http
GET /admin/blacklist/type-options
```

**权限**：`marketing.manage`

### 黑名单来源选项

```http
GET /admin/blacklist/source-options
```

**权限**：`marketing.manage`

### 黑名单详情

```http
GET /admin/blacklist/{id}
```

**权限**：`marketing.manage`

### 添加黑名单

```http
POST /admin/blacklist
```

**权限**：`marketing.manage`

**请求参数**：
- `type`: 类型（user/ip/device/phone）
- `value`: 值（用户ID/IP地址/设备ID/手机号）
- `reason`: 原因
- `expired_at`: 过期时间（可选，永久黑名单为null）

### 批量添加黑名单

```http
POST /admin/blacklist/batch
```

**权限**：`marketing.manage`

**请求参数**：
- `items`: 黑名单数组

### 更新黑名单

```http
PUT /admin/blacklist/{id}
```

**权限**：`marketing.manage`

### 解除黑名单

```http
DELETE /admin/blacklist/{id}
```

**权限**：`marketing.manage`

### 批量解除黑名单

```http
POST /admin/blacklist/batch-destroy
```

**权限**：`marketing.manage`

### 检查用户是否在黑名单

```http
POST /admin/blacklist/check-user
```

**权限**：`marketing.manage`

**请求参数**：
- `user_id`: 用户ID

---

## 风控规则管理

### 风控规则列表

```http
GET /admin/risk-rules
```

**权限**：`marketing.manage`

### 风控类型选项

```http
GET /admin/risk-rules/type-options
```

**权限**：`marketing.manage`

**返回**：
- 频繁下单
- 异常退款
- 恶意评价
- 刷单行为
- ...

### 风控动作选项

```http
GET /admin/risk-rules/action-options
```

**权限**：`marketing.manage`

**返回**：
- 警告
- 限制下单
- 加入黑名单
- 冻结账户
- ...

### 获取默认配置

```http
GET /admin/risk-rules/default-config
```

**权限**：`marketing.manage`

### 风控规则详情

```http
GET /admin/risk-rules/{id}
```

**权限**：`marketing.manage`

### 创建风控规则

```http
POST /admin/risk-rules
```

**权限**：`marketing.manage`

**请求参数**：
- `name`: 规则名称
- `type`: 类型
- `conditions`: 条件配置
- `action`: 触发动作
- `priority`: 优先级

### 更新风控规则

```http
PUT /admin/risk-rules/{id}
```

**权限**：`marketing.manage`

### 删除风控规则

```http
DELETE /admin/risk-rules/{id}
```

**权限**：`marketing.manage`

### 启用/禁用风控规则

```http
POST /admin/risk-rules/{id}/toggle-status
```

**权限**：`marketing.manage`

### 批量更新规则状态

```http
POST /admin/risk-rules/batch-status
```

**权限**：`marketing.manage`

**请求参数**：
- `ids`: 规则ID数组
- `status`: 状态（enabled/disabled）

---

## 风险记录管理

### 风险记录列表

```http
GET /admin/risk-records
```

**权限**：`marketing.manage`

**查询参数**：
- `user_id`: 用户ID
- `rule_id`: 规则ID
- `level`: 风险等级（low/medium/high）
- `status`: 处理状态（pending/processed/ignored）

### 风险等级选项

```http
GET /admin/risk-records/level-options
```

**权限**：`marketing.manage`

### 风险状态选项

```http
GET /admin/risk-records/status-options
```

**权限**：`marketing.manage`

### 风险记录详情

```http
GET /admin/risk-records/{id}
```

**权限**：`marketing.manage`

### 处理风险记录

```http
POST /admin/risk-records/{id}/process
```

**权限**：`marketing.manage`

**请求参数**：
- `action`: 处理动作（ignore/warn/restrict/blacklist）
- `remark`: 处理备注

### 批量处理风险记录

```http
POST /admin/risk-records/batch-process
```

**权限**：`marketing.manage`

**请求参数**：
- `ids`: 记录ID数组
- `action`: 处理动作

### 检测用户风险

```http
POST /admin/risk-records/check-user
```

**权限**：`marketing.manage`

**请求参数**：
- `user_id`: 用户ID

**说明**：主动检测用户风险

### 用户风险统计

```http
GET /admin/risk-records/user-statistics
```

**权限**：`marketing.manage`

**查询参数**：
- `user_id`: 用户ID

**返回**：该用户的风险记录统计

