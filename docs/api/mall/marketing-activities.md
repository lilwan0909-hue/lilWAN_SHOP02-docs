# 商城API - 营销活动

::: tip 路由前缀
所有接口使用 `/api/v1` 前缀，需要认证
:::

## 优惠券

### 我的优惠券列表

```http
GET /api/v1/user/coupons
```

**查询参数**：
- `status`: 状态（unused/used/expired）
- `page`: 页码
- `per_page`: 每页数量

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "data": [
      {
        "id": 1,
        "coupon_name": "满100减20",
        "discount_value": 20.00,
        "min_amount": 100.00,
        "expire_time": "2025-11-30 23:59:59",
        "status": "unused"
      }
    ],
    "total": 5
  }
}
```

### 优惠券详情

```http
GET /api/v1/user/coupons/{id}
```

### 领取优惠券

```http
POST /api/v1/user/coupons/claim
```

**请求参数**：
- `coupon_id`: 优惠券模板ID

**说明**：用户主动领取优惠券

### 获取订单可用优惠券

```http
POST /api/v1/user/coupons/available
```

**请求参数**：
- `items`: 商品项数组
  - `sku_id`: SKU ID
  - `quantity`: 数量

**返回**：当前订单可用的优惠券列表

### 优惠券统计

```http
GET /api/v1/user/coupons/stats
```

**返回**：
- 未使用优惠券数量
- 已使用优惠券数量
- 已过期优惠券数量

---

## 营销活动

### 获取可用营销活动

```http
GET /api/v1/marketing/available
```

**查询参数**：
- `type`: 活动类型（coupon/seckill/group_buy/full_reduce）

**返回**：当前进行中的所有营销活动

---

### 校验营销活动

```http
POST /api/v1/marketing/validate
```

**请求参数**：
- `plugin_code`: 插件编码
- `items`: 商品项数组

**返回**：活动是否可用、优惠金额等

---

## 秒杀活动

### 秒杀活动列表

```http
GET /api/v1/seckills
```

**查询参数**：
- `status`: 状态（upcoming/ongoing/ended）
- `page`: 页码
- `per_page`: 每页数量

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "data": [
      {
        "id": 1,
        "name": "限时秒杀",
        "product_name": "商品名称",
        "seckill_price": 49.99,
        "original_price": 99.99,
        "stock": 100,
        "start_time": "2025-10-31 10:00:00",
        "end_time": "2025-10-31 12:00:00",
        "status": "ongoing"
      }
    ]
  }
}
```

### 秒杀系统状态

```http
GET /api/v1/seckills/status
```

**返回**：秒杀系统总体状态（进行中的场次）

### 秒杀活动详情

```http
GET /api/v1/seckills/{id}
```

### 参与秒杀

```http
POST /api/v1/seckills/items/{itemId}/buy
```

**请求参数**：
- `quantity`: 购买数量
- `address_id`: 收货地址ID

**说明**：秒杀商品直接下单，无需加购物车

### 我的秒杀订单

```http
GET /api/v1/seckills/my-orders
```

### 取消秒杀订单

```http
POST /api/v1/seckills/orders/{orderId}/cancel
```

---

## 拼团活动

### 拼团活动列表

```http
GET /api/v1/group-buys
```

**查询参数**：
- `status`: 状态（ongoing/ended）
- `page`: 页码
- `per_page`: 每页数量

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "data": [
      {
        "id": 1,
        "name": "3人拼团",
        "product_name": "商品名称",
        "group_price": 59.99,
        "original_price": 99.99,
        "required_count": 3,
        "current_teams": 10,
        "start_time": "2025-10-31 00:00:00",
        "end_time": "2025-11-30 23:59:59"
      }
    ]
  }
}
```

### 拼团活动详情

```http
GET /api/v1/group-buys/{id}
```

### 发起拼团

```http
POST /api/v1/group-buys/start
```

**请求参数**：
- `activity_id`: 拼团活动ID
- `sku_id`: SKU ID
- `quantity`: 数量
- `address_id`: 收货地址ID

**返回**：
- 团队ID
- 拼团二维码/链接（用于分享）

### 团队详情

```http
GET /api/v1/group-buys/teams/{teamId}
```

**返回**：
- 团队信息
- 成团进度
- 团员列表

### 加入拼团

```http
POST /api/v1/group-buys/teams/{teamId}/join
```

**请求参数**：
- `address_id`: 收货地址ID

### 我的拼团

```http
GET /api/v1/group-buys/my-teams
```

**返回**：我参与的所有拼团

---

## 满减活动

### 满减活动列表

```http
GET /api/v1/full-reduces
```

**成功响应**：
```json
{
  "code": 0,
  "data": [
    {
      "id": 1,
      "name": "满100减20",
      "min_amount": 100.00,
      "discount_amount": 20.00,
      "start_time": "2025-10-31 00:00:00",
      "end_time": "2025-11-30 23:59:59"
    }
  ]
}
```

### 满减活动详情

```http
GET /api/v1/full-reduces/{id}
```

### 计算可用满减

```http
POST /api/v1/full-reduces/calculate
```

**请求参数**：
- `items`: 商品项数组
  - `sku_id`: SKU ID
  - `quantity`: 数量

**返回**：可用的满减活动及优惠金额

### 应用满减

```http
POST /api/v1/full-reduces/apply
```

**请求参数**：
- `activity_id`: 活动ID
- `items`: 商品项数组

**说明**：在下单时应用满减活动

### 满减统计

```http
GET /api/v1/full-reduces/{id}/statistics
```

**返回**：满减活动的使用统计

---

## 售后管理

::: warning 频率限制
售后接口限流：20次/分钟
:::

### 售后列表

```http
GET /api/v1/refunds
```

**查询参数**：
- `status`: 状态（pending/processing/completed/rejected）
- `page`: 页码
- `per_page`: 每页数量

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "data": [
      {
        "id": 1,
        "refund_no": "REF202510310001",
        "order_no": "202510310001",
        "type": "refund_only",
        "amount": 99.99,
        "status": "pending",
        "created_at": "2025-10-31 10:00:00"
      }
    ]
  }
}
```

### 申请售后

```http
POST /api/v1/refunds
```

**请求参数**：
- `order_id`: 订单ID
- `order_item_ids`: 订单项ID数组（退部分商品）
- `type`: 类型（refund_only/return_refund）
- `reason`: 退款原因
- `amount`: 退款金额
- `description`: 详细说明
- `images`: 凭证图片数组（可选）

### 售后详情

```http
GET /api/v1/refunds/{refundId}
```

**返回**：
- 售后信息
- 审核记录
- 物流信息（退货时）

### 填写退货物流

```http
POST /api/v1/refunds/{refundId}/return-express
```

**请求参数**：
- `logistics_company`: 物流公司
- `tracking_number`: 快递单号

**说明**：仅"退货退款"类型需要填写

---

## 发票管理

### 我的发票列表

```http
GET /api/v1/invoices/my
```

**查询参数**：
- `status`: 状态（pending/issued）
- `page`: 页码
- `per_page`: 每页数量

### 申请发票

```http
POST /api/v1/invoices
```

**请求参数**：
- `order_id`: 订单ID
- `type`: 发票类型（personal/company）
- `title`: 发票抬头
- `tax_no`: 税号（企业发票必填）
- `email`: 接收邮箱

---

## 提现管理

### 我的提现记录

```http
GET /api/v1/withdrawals/my
```

**查询参数**：
- `status`: 状态（pending/processing/success/failed）
- `page`: 页码
- `per_page`: 每页数量

### 申请提现

```http
POST /api/v1/withdrawals
```

**请求参数**：
- `amount`: 提现金额
- `bank_name`: 银行名称
- `bank_account`: 银行账号
- `account_name`: 账户名称
- `payment_password`: 支付密码

**说明**：需先设置支付密码

