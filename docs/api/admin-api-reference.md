# 管理后台 API 接口清单

::: tip 路由前缀
所有管理后台接口使用 `/admin` 前缀
:::

## 认证说明

- **认证方式**：Bearer Token（Laravel Sanctum）
- **认证中间件**：`admin.auth`
- **权限中间件**：`admin.permission`

---

## 📑 目录

- [认证管理](#认证管理)
- [Dashboard](#dashboard)
- [商品管理](#商品管理)
- [分类管理](#分类管理)
- [规格管理](#规格管理)
- [库存管理](#库存管理)
- [订单管理](#订单管理)
- [用户管理](#用户管理)
- [系统管理](#系统管理)
- [营销管理](#营销管理)
- [财务管理](#财务管理)
- [CMS内容管理](#cms内容管理)

---

## 认证管理

### 登录（无需认证）

```http
POST /admin/auth/login
```

**请求参数**：
- `username`: 用户名
- `password`: 密码

### 获取当前用户信息

```http
GET /admin/auth/me
```

**权限**：需要认证

### 登出

```http
POST /admin/auth/logout
```

### 更新个人资料

```http
PUT /admin/auth/profile
```

### 修改密码

```http
PUT /admin/auth/password
```

---

## Dashboard

### 获取仪表盘指标

```http
GET /admin/dashboard/metrics
```

**返回**：核心业务指标（订单数、销售额、用户数等）

### 订单趋势

```http
GET /admin/dashboard/order-trend
```

### 订单来源分布

```http
GET /admin/dashboard/order-source
```

---

## 商品管理

### 商品列表

```http
GET /admin/products
```

**权限**：`product.view`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `keyword`: 搜索关键词
- `category_id`: 分类ID
- `status`: 状态（on_sale/off_sale/draft）

### 商品详情

```http
GET /admin/products/{id}
```

**权限**：`product.view`

### 创建商品

```http
POST /admin/products
```

**权限**：`product.create`

**请求参数**：
- `name`: 商品名称
- `category_id`: 分类ID
- `price`: 价格
- `stock`: 库存
- `description`: 描述
- `images`: 商品图片
- ...

### 更新商品

```http
PUT /admin/products/{id}
```

**权限**：`product.edit`

### 删除商品

```http
DELETE /admin/products/{id}
```

**权限**：`product.delete`

### 上架/下架商品

```http
POST /admin/products/{id}/toggle-sale
```

**权限**：`product.edit`

### 批量删除商品

```http
POST /admin/products/batch-delete
```

**权限**：`product.delete`

### 批量上架

```http
POST /admin/products/batch-on-sale
```

**权限**：`product.edit`

### 批量下架

```http
POST /admin/products/batch-off-sale
```

**权限**：`product.edit`

### 上传商品图片

```http
POST /admin/products/upload-image
```

**权限**：`product.create`

### 上传商品视频

```http
POST /admin/products/upload-video
```

**权限**：`product.create`

### 验证商品发布

```http
POST /admin/products/{id}/validate-publish
```

**权限**：`product.view`

---

## 虚拟商品管理

### 虚拟卡密列表

```http
GET /admin/virtual-cards
```

**权限**：`product.manage`

### 批量导入卡密

```http
POST /admin/virtual-cards/batch-import
```

**权限**：`product.manage`

### 删除卡密

```http
DELETE /admin/virtual-cards/{id}
```

**权限**：`product.manage`

### 批量删除卡密

```http
POST /admin/virtual-cards/batch-delete
```

**权限**：`product.manage`

### 获取虚拟商品列表

```http
GET /admin/virtual-cards/virtual-products
```

**权限**：`product.manage`

### 卡密统计

```http
GET /admin/virtual-cards/statistics
```

**权限**：`product.manage`

---

## 虚拟发货管理

### 虚拟发货列表

```http
GET /admin/virtual-deliveries
```

**权限**：`order.manage`

### 重试发货

```http
POST /admin/virtual-deliveries/{id}/retry
```

**权限**：`order.manage`

### 重新发送邮件

```http
POST /admin/virtual-deliveries/{id}/resend-email
```

**权限**：`order.manage`

### 标记为已发货

```http
POST /admin/virtual-deliveries/{id}/mark-delivered
```

**权限**：`order.manage`

### 虚拟发货统计

```http
GET /admin/virtual-deliveries/statistics
```

**权限**：`order.manage`

---

## 分类管理

### 分类列表

```http
GET /admin/categories
```

**权限**：`product.manage`

### 创建分类

```http
POST /admin/categories
```

**权限**：`product.manage`

### 分类详情

```http
GET /admin/categories/{id}
```

**权限**：`product.manage`

### 更新分类

```http
PUT /admin/categories/{id}
```

**权限**：`product.manage`

### 删除分类

```http
DELETE /admin/categories/{id}
```

**权限**：`product.manage`

### 分类排序

```http
POST /admin/categories/{id}/sort
```

**权限**：`product.manage`

---

## 规格管理

### 规格列表

```http
GET /admin/product-specs
```

**权限**：`product.manage`

### 创建规格

```http
POST /admin/product-specs
```

**权限**：`product.manage`

### 规格详情

```http
GET /admin/product-specs/{id}
```

**权限**：`product.manage`

### 更新规格

```http
PUT /admin/product-specs/{id}
```

**权限**：`product.manage`

### 删除规格

```http
DELETE /admin/product-specs/{id}
```

**权限**：`product.manage`

### 启用/禁用规格

```http
POST /admin/product-specs/{id}/toggle-status
```

**权限**：`product.manage`

### 更新规格排序

```http
POST /admin/product-specs/update-sort-order
```

**权限**：`product.manage`

### 获取所有启用的规格

```http
GET /admin/product-specs-enabled
```

**权限**：`product.manage`

---

## 规格组管理

### 规格组列表

```http
GET /admin/spec-groups
```

**权限**：`product.manage`

### 获取所有规格组

```http
GET /admin/spec-groups/all
```

**权限**：`product.manage`

### 创建规格组

```http
POST /admin/spec-groups
```

**权限**：`product.manage`

### 规格组详情

```http
GET /admin/spec-groups/{id}
```

**权限**：`product.manage`

### 更新规格组

```http
PUT /admin/spec-groups/{id}
```

**权限**：`product.manage`

### 删除规格组

```http
DELETE /admin/spec-groups/{id}
```

**权限**：`product.manage`

### 启用/禁用规格组

```http
POST /admin/spec-groups/{id}/toggle-status
```

**权限**：`product.manage`

### 添加规格值

```http
POST /admin/spec-groups/{groupId}/values
```

**权限**：`product.manage`

---

## 规格值管理

### 更新规格值

```http
PUT /admin/spec-values/{id}
```

**权限**：`product.manage`

### 删除规格值

```http
DELETE /admin/spec-values/{id}
```

**权限**：`product.manage`

### 批量排序规格值

```http
POST /admin/spec-values/batch-sort
```

**权限**：`product.manage`

---

## 规格模板管理

### 规格模板列表

```http
GET /admin/spec-templates
```

**权限**：`product.manage`

### 创建规格模板

```http
POST /admin/spec-templates
```

**权限**：`product.manage`

### 更新规格模板

```http
PUT /admin/spec-templates/{id}
```

**权限**：`product.manage`

### 删除规格模板

```http
DELETE /admin/spec-templates/{id}
```

**权限**：`product.manage`

### 应用规格模板

```http
POST /admin/spec-templates/{id}/apply
```

**权限**：`product.manage`

**说明**：将规格模板应用到指定商品

---

## SKU管理

### 获取商品规格

```http
GET /admin/products/{spuId}/specs
```

**权限**：`product.edit`

### 生成SKU

```http
POST /admin/products/{spuId}/generate-skus
```

**权限**：`product.edit`

**说明**：根据规格组合自动生成SKU

---

## 库存管理

### 库存列表

```http
GET /admin/inventory
```

**权限**：`product:inventory:list`

### 库存日志

```http
GET /admin/inventory/logs
```

**权限**：`product:inventory:list`

### 调整库存

```http
POST /admin/inventory/{skuId}/adjust
```

**权限**：`product:inventory:adjust`

**请求参数**：
- `quantity`: 调整数量（正数为增加，负数为减少）
- `type`: 调整类型（purchase/return/loss/manual）
- `remark`: 备注

### 批量调整库存

```http
POST /admin/inventory/batch-adjust
```

**权限**：`product:inventory:batch`

### 导出库存

```http
POST /admin/inventory/export
```

**权限**：`product:inventory:export`

---

## 库存预警

### 库存预警列表

```http
GET /admin/stock-alerts
```

**权限**：`product.manage`

### 更新预警阈值

```http
PUT /admin/stock-alerts/{skuId}/threshold
```

**权限**：`product.manage`

### 库存预警详情

```http
GET /admin/stock-alerts/{skuId}/detail
```

**权限**：`product.manage`

### 导出库存预警

```http
POST /admin/stock-alerts/export
```

**权限**：`product.manage`

---

## 库存预警通知

### 预警通知列表

```http
GET /admin/notifications/stock-alerts
```

### 未读预警数量

```http
GET /admin/notifications/stock-alerts/unread-count
```

### 标记为已读

```http
POST /admin/notifications/stock-alerts/mark-read
```

---

## 品牌管理

### 品牌列表

```http
GET /admin/product-brands
```

**权限**：`product.manage`

### 创建品牌

```http
POST /admin/product-brands
```

**权限**：`product.manage`

### 品牌详情

```http
GET /admin/product-brands/{id}
```

**权限**：`product.manage`

### 更新品牌

```http
PUT /admin/product-brands/{id}
```

**权限**：`product.manage`

### 删除品牌

```http
DELETE /admin/product-brands/{id}
```

**权限**：`product.manage`

### 启用/禁用品牌

```http
POST /admin/product-brands/{id}/toggle-status
```

**权限**：`product.manage`

### 获取品牌首字母

```http
GET /admin/product-brands-initials
```

**权限**：`product.manage`

### 获取启用的品牌

```http
GET /admin/product-brands-enabled
```

**权限**：`product.manage`

### 更新品牌排序

```http
POST /admin/product-brands/{id}/sort
```

**权限**：`product.manage`

---

## 商品评价管理

### 评价列表

```http
GET /admin/product-reviews
```

**权限**：`product.manage`

### 评价统计

```http
GET /admin/product-reviews/statistics
```

**权限**：`product.manage`

### 评价详情

```http
GET /admin/product-reviews/{id}
```

**权限**：`product.manage`

### 审核通过

```http
POST /admin/product-reviews/{id}/approve
```

**权限**：`product.manage`

### 审核拒绝

```http
POST /admin/product-reviews/{id}/reject
```

**权限**：`product.manage`

### 回复评价

```http
POST /admin/product-reviews/{id}/reply
```

**权限**：`product.manage`

### 删除评价

```http
DELETE /admin/product-reviews/{id}
```

**权限**：`product.manage`

---

## 订单管理

### 订单列表

```http
GET /admin/orders
```

**权限**：`order.view`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `order_no`: 订单号
- `status`: 订单状态
- `start_date`: 开始日期
- `end_date`: 结束日期

### 订单详情

```http
GET /admin/orders/{id}
```

**权限**：`order.view`

### 更新订单

```http
PUT /admin/orders/{id}
```

**权限**：`order.manage`

### 发货

```http
POST /admin/orders/{id}/ship
```

**权限**：`order.manage`

**请求参数**：
- `logistics_company`: 物流公司
- `tracking_number`: 快递单号

### 取消订单

```http
POST /admin/orders/{id}/cancel
```

**权限**：`order.manage`

### 退款

```http
POST /admin/orders/{id}/refund
```

**权限**：`order.manage`

### 修改收货地址

```http
POST /admin/orders/{id}/edit-address
```

**权限**：`order.manage`

### 发送支付提醒

```http
POST /admin/orders/{id}/payment-reminder
```

**权限**：`order.manage`

### 导出订单

```http
POST /admin/orders/export
```

**权限**：`order.manage`

### 修改订单价格

```http
POST /admin/orders/{id}/edit-price
```

**权限**：`order.operate.edit_price`

**说明**：敏感操作，需要特殊权限

---

## 订单设置

### 获取订单设置

```http
GET /admin/order-settings
```

**权限**：`order.setting`

### 更新订单设置

```http
PUT /admin/order-settings
```

**权限**：`order.setting`

### 获取单项设置

```http
GET /admin/order-settings/{key}
```

**权限**：`order.setting`

### 退货地址列表

```http
GET /admin/order-settings/return-addresses
```

**权限**：`order.setting`

### 获取默认退货地址

```http
GET /admin/order-settings/return-address/default
```

**权限**：`order.setting`

### 创建退货地址

```http
POST /admin/order-settings/return-addresses
```

**权限**：`order.setting`

### 更新退货地址

```http
PUT /admin/order-settings/return-addresses/{addressId}
```

**权限**：`order.setting`

### 删除退货地址

```http
DELETE /admin/order-settings/return-addresses/{addressId}
```

**权限**：`order.setting`

### 设置默认退货地址

```http
POST /admin/order-settings/return-addresses/{addressId}/set-default
```

**权限**：`order.setting`

---

## 售后管理

### 售后列表

```http
GET /admin/refunds
```

**权限**：`order.view`

### 售后详情

```http
GET /admin/refunds/{id}
```

**权限**：`order.view`

### 审核售后申请

```http
POST /admin/refunds/{id}/audit
```

**权限**：`order.manage`

**请求参数**：
- `status`: 审核结果（approved/rejected）
- `remark`: 备注

### 协商

```http
POST /admin/refunds/{id}/negotiate
```

**权限**：`order.manage`

### 确认收到退货

```http
POST /admin/refunds/{id}/confirm-return
```

**权限**：`order.manage`

### 拒绝退货

```http
POST /admin/refunds/{id}/reject-return
```

**权限**：`order.manage`

### 处理退款

```http
POST /admin/refunds/{id}/process-refund
```

**权限**：`order.manage`

---

## 发货管理

### 待发货列表

```http
GET /admin/shipments
```

**权限**：`order.view`

### 待发货数量

```http
GET /admin/shipments/pending-count
```

**权限**：`order.view`

### 发货详情

```http
GET /admin/shipments/{id}
```

**权限**：`order.view`

### 物流追踪

```http
GET /admin/shipments/{id}/track
```

**权限**：`order.view`

### 发货（使用快递）

```http
POST /admin/shipments/ship-with-express
```

**权限**：`order.manage`

### 批量发货

```http
POST /admin/shipments/ship-batch
```

**权限**：`order.manage`

### 修改快递信息

```http
POST /admin/shipments/{id}/update-express
```

**权限**：`order.manage`

### 打印面单

```http
POST /admin/shipments/{id}/print-waybill
```

**权限**：`order.manage`

---

由于接口数量太多，文档太长。我建议分页面创建。让我先完成这部分，再继续创建其他模块（用户管理、系统管理、营销管理、财务管理、CMS等）。

您觉得这样的详细程度可以吗？我可以继续补充剩余的模块。

