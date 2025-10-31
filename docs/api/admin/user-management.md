# 管理后台 - 用户管理API

::: tip 路由前缀
所有接口使用 `/admin` 前缀
:::

## 用户管理

### 用户列表

```http
GET /admin/users
```

**权限**：`user.view`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `keyword`: 搜索关键词（手机号/昵称/邮箱）
- `status`: 状态（active/disabled）
- `level_id`: 用户等级ID
- `tag_ids`: 标签ID数组
- `register_start`: 注册开始日期
- `register_end`: 注册结束日期

### 用户详情

```http
GET /admin/users/{id}
```

**权限**：`user.view`

### 更新用户

```http
PUT /admin/users/{id}
```

**权限**：`user.manage`

**请求参数**：
- `nickname`: 昵称
- `mobile`: 手机号
- `email`: 邮箱
- `level_id`: 用户等级
- `status`: 状态

### 启用/禁用用户

```http
POST /admin/users/{id}/toggle-status
```

**权限**：`user.manage`

### 调整用户余额

```http
POST /admin/users/{id}/adjust-balance
```

**权限**：`user.manage`

**请求参数**：
- `amount`: 调整金额（正数为增加，负数为扣除）
- `type`: 类型（recharge/refund/adjustment/admin）
- `remark`: 备注

---

## 用户订单

### 用户订单列表

```http
GET /admin/users/{id}/orders
```

**权限**：`user.view`

### 用户订单统计

```http
GET /admin/users/{id}/order-stats
```

**权限**：`user.view`

**返回**：订单总数、订单总金额、平均客单价等

---

## 用户资产

### 余额明细

```http
GET /admin/users/{id}/balance-logs
```

**权限**：`user.view`

### 余额汇总

```http
GET /admin/users/{id}/balance-summary
```

**权限**：`user.view`

### 积分汇总

```http
GET /admin/users/{id}/points-summary
```

**权限**：`user.view`

---

## 用户地址

### 用户地址列表

```http
GET /admin/users/{id}/addresses
```

**权限**：`user.view`

### 更新用户地址

```http
PUT /admin/users/{id}/addresses/{addressId}
```

**权限**：`user.manage`

### 设置默认地址

```http
POST /admin/users/{id}/addresses/{addressId}/set-default
```

**权限**：`user.manage`

### 删除用户地址

```http
DELETE /admin/users/{id}/addresses/{addressId}
```

**权限**：`user.manage`

---

## 用户售后

### 用户退款统计

```http
GET /admin/users/{id}/refund-stats
```

**权限**：`user.view`

### 用户退款列表

```http
GET /admin/users/{id}/refunds
```

**权限**：`user.view`

---

## 用户评价

### 用户评价统计

```http
GET /admin/users/{id}/review-stats
```

**权限**：`user.view`

### 用户评价列表

```http
GET /admin/users/{id}/reviews
```

**权限**：`user.view`

---

## 用户日志

### 用户操作日志

```http
GET /admin/users/{id}/operation-logs
```

**权限**：`user.view`

**说明**：用户自己的操作记录（下单、评价等）

### 管理员操作日志

```http
GET /admin/users/{id}/admin-operation-logs
```

**权限**：`user.view`

**说明**：管理员对该用户的操作记录（修改资料、调整余额等）

---

## 用户安全

### 登录日志

```http
GET /admin/users/{id}/login-logs
```

**权限**：`user.view`

### 设备列表

```http
GET /admin/users/{id}/devices
```

**权限**：`user.view`

### 强制下线设备

```http
POST /admin/users/{id}/devices/{deviceId}/force-offline
```

**权限**：`user.manage`

### 重置支付密码

```http
POST /admin/users/{id}/reset-payment-password
```

**权限**：`user.manage`

---

## 用户标签管理

### 标签列表

```http
GET /admin/user-tags
```

**权限**：`customer.user-tags.index`

### 创建标签

```http
POST /admin/user-tags
```

**权限**：`customer.user-tags.index`

**请求参数**：
- `name`: 标签名称
- `category`: 分类
- `color`: 颜色
- `description`: 描述

### 标签详情

```http
GET /admin/user-tags/{id}
```

**权限**：`customer.user-tags.index`

### 更新标签

```http
PUT /admin/user-tags/{id}
```

**权限**：`customer.user-tags.index`

### 删除标签

```http
DELETE /admin/user-tags/{id}
```

**权限**：`customer.user-tags.index`

### 标签分类列表

```http
GET /admin/user-tags/categories/list
```

**权限**：`customer.user-tags.index`

### 标签下的用户

```http
GET /admin/user-tags/{id}/users
```

**权限**：`customer.user-tags.index`

### 打标签

```http
POST /admin/user-tags/{id}/assign
```

**权限**：`customer.user-tags.index`

**请求参数**：
- `user_ids`: 用户ID数组

### 批量打标签

```http
POST /admin/user-tags/assign-batch
```

**权限**：`customer.user-tags.index`

**请求参数**：
- `user_ids`: 用户ID数组
- `tag_ids`: 标签ID数组

### 移除标签

```http
DELETE /admin/user-tags/remove-tag
```

**权限**：`customer.user-tags.index`

**请求参数**：
- `user_id`: 用户ID
- `tag_id`: 标签ID

---

## 用户分群管理

### 分群列表

```http
GET /admin/user-segments
```

**权限**：`customer.user-segments.index`

### 创建分群

```http
POST /admin/user-segments
```

**权限**：`customer.user-segments.index`

**请求参数**：
- `name`: 分群名称
- `type`: 类型（manual/rule/rfm）
- `rules`: 规则配置（规则分群时使用）
- `description`: 描述

### 分群详情

```http
GET /admin/user-segments/{id}
```

**权限**：`customer.user-segments.index`

### 更新分群

```http
PUT /admin/user-segments/{id}
```

**权限**：`customer.user-segments.index`

### 删除分群

```http
DELETE /admin/user-segments/{id}
```

**权限**：`customer.user-segments.index`

### 分群用户列表

```http
GET /admin/user-segments/{id}/users
```

**权限**：`customer.user-segments.index`

### 添加用户到分群

```http
POST /admin/user-segments/{id}/add-users
```

**权限**：`customer.user-segments.index`

**请求参数**：
- `user_ids`: 用户ID数组

### 从分群移除用户

```http
POST /admin/user-segments/{id}/remove-users
```

**权限**：`customer.user-segments.index`

**请求参数**：
- `user_ids`: 用户ID数组

### 刷新规则分群

```http
POST /admin/user-segments/{id}/refresh
```

**权限**：`customer.user-segments.index`

**说明**：重新计算规则分群，更新用户列表

### 创建RFM分群

```http
POST /admin/user-segments/rfm
```

**权限**：`customer.user-segments.index`

**说明**：根据RFM模型（最近购买、购买频率、购买金额）自动分群

### 导出分群用户

```http
POST /admin/user-segments/{id}/export
```

**权限**：`customer.user-segments.index`

---

## 用户等级管理

### 用户等级列表

```http
GET /admin/user-levels
```

**权限**：`customer.user-levels.index`

### 创建用户等级

```http
POST /admin/user-levels
```

**权限**：`customer.user-levels.index`

**请求参数**：
- `name`: 等级名称
- `level`: 等级数值
- `upgrade_condition`: 升级条件
- `benefits`: 等级权益
- `icon`: 等级图标

### 用户等级详情

```http
GET /admin/user-levels/{id}
```

**权限**：`customer.user-levels.index`

### 更新用户等级

```http
PUT /admin/user-levels/{id}
```

**权限**：`customer.user-levels.index`

### 删除用户等级

```http
DELETE /admin/user-levels/{id}
```

**权限**：`customer.user-levels.index`

### 启用/禁用用户等级

```http
POST /admin/user-levels/{id}/toggle-status
```

**权限**：`customer.user-levels.index`

### 更新等级排序

```http
POST /admin/user-levels/update-sort
```

**权限**：`customer.user-levels.index`

---

## 用户统计分析

### 用户概览统计

```http
GET /admin/user-stats/overview
```

**权限**：`user.stats`

**返回**：
- 总用户数
- 今日新增
- 活跃用户
- 用户留存率

### 用户增长趋势

```http
GET /admin/user-stats/growth-trend
```

**权限**：`user.stats`

**查询参数**：
- `start_date`: 开始日期
- `end_date`: 结束日期
- `granularity`: 粒度（day/week/month）

### 用户活跃数据

```http
GET /admin/user-stats/active-data
```

**权限**：`user.stats`

### 用户价值分析

```http
GET /admin/user-stats/value-analysis
```

**权限**：`user.stats`

**说明**：用户价值分层（高价值、中价值、低价值）

### 用户资产使用情况

```http
GET /admin/user-stats/asset-usage
```

**权限**：`user.stats`

**返回**：余额、积分的使用统计

---

## 合规管理

### 账号注销申请列表

```http
GET /admin/user-cancel-requests
```

**权限**：`customer.compliance.index`

### 账号注销统计

```http
GET /admin/user-cancel-requests/statistics
```

**权限**：`customer.compliance.index`

### 账号注销详情

```http
GET /admin/user-cancel-requests/{id}
```

**权限**：`customer.compliance.index`

### 审核账号注销

```http
POST /admin/user-cancel-requests/{id}/review
```

**权限**：`customer.compliance.index`

**请求参数**：
- `status`: 审核结果（approved/rejected）
- `remark`: 备注

### 拒绝账号注销

```http
POST /admin/user-cancel-requests/{id}/reject
```

**权限**：`customer.compliance.index`

---

### 数据导出申请列表

```http
GET /admin/user-data-export-requests
```

**权限**：`customer.compliance.index`

### 数据导出统计

```http
GET /admin/user-data-export-requests/statistics
```

**权限**：`customer.compliance.index`

### 数据导出详情

```http
GET /admin/user-data-export-requests/{id}
```

**权限**：`customer.compliance.index`

### 处理数据导出

```http
POST /admin/user-data-export-requests/{id}/process
```

**权限**：`customer.compliance.index`

### 下载导出数据

```http
GET /admin/user-data-export-requests/{id}/download
```

**权限**：`customer.compliance.index`

---

### 消息退订列表

```http
GET /admin/user-message-unsubscribe
```

**权限**：`customer.compliance.index`

### 消息退订统计

```http
GET /admin/user-message-unsubscribe/statistics
```

**权限**：`customer.compliance.index`

### 消息退订趋势

```http
GET /admin/user-message-unsubscribe/trend
```

**权限**：`customer.compliance.index`

### 导出退订记录

```http
GET /admin/user-message-unsubscribe/export
```

**权限**：`customer.compliance.index`

### 批量删除退订记录

```http
POST /admin/user-message-unsubscribe/batch-destroy
```

**权限**：`customer.compliance.index`

### 获取用户退订记录

```http
GET /admin/user-message-unsubscribe/{userId}/user
```

**权限**：`customer.compliance.index`

### 删除退订记录

```http
DELETE /admin/user-message-unsubscribe/{id}
```

**权限**：`customer.compliance.index`

