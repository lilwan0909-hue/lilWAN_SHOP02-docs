# 商城API - 购物车与订单

::: tip 路由前缀
所有接口使用 `/api/v1` 前缀，需要认证
:::

## 购物车管理

::: warning 频率限制
购物车接口限流：60次/分钟
:::

### 购物车列表

```http
GET /api/v1/cart
```

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "items": [
      {
        "id": 1,
        "sku_id": 101,
        "product_name": "商品名称",
        "sku_name": "红色;M",
        "price": 99.99,
        "quantity": 2,
        "selected": true,
        "stock": 100,
        "cover_image": "https://xxx.com/cover.jpg"
      }
    ],
    "total_price": 199.98,
    "selected_count": 1
  }
}
```

### 添加到购物车

```http
POST /api/v1/cart
```

**请求参数**：
- `sku_id`: SKU ID
- `quantity`: 数量

### 更新购物车商品数量

```http
PUT /api/v1/cart/{skuId}
```

**请求参数**：
- `quantity`: 新数量

### 删除购物车商品

```http
DELETE /api/v1/cart
```

**请求参数**：
- `sku_ids`: SKU ID数组

### 切换选中状态

```http
POST /api/v1/cart/toggle-select
```

**请求参数**：
- `sku_id`: SKU ID

### 全选/取消全选

```http
POST /api/v1/cart/select-all
```

**请求参数**：
- `selected`: 是否全选（true/false）

### 清空购物车

```http
DELETE /api/v1/cart/clear
```

**说明**：清空所有购物车商品

### 购物车校验

```http
POST /api/v1/cart/validate
```

**说明**：校验购物车商品（库存、价格、下架状态）

**返回**：
- 有效商品
- 无效商品（库存不足、已下架等）

---

## 订单管理

::: warning 频率限制
订单接口限流：30次/分钟
:::

### 订单确认页

```http
GET /api/v1/orders/checkout
```

**查询参数**：
- `sku_ids`: SKU ID数组（购物车结算）
- `sku_id`: SKU ID（立即购买）
- `quantity`: 数量（立即购买）

**返回**：
- 商品信息
- 收货地址
- 可用优惠券
- 运费
- 应付金额

---

### 创建订单

```http
POST /api/v1/orders
```

**请求参数**：
- `address_id`: 收货地址ID
- `items`: 商品项数组
  - `sku_id`: SKU ID
  - `quantity`: 数量
- `coupon_id`: 优惠券ID（可选）
- `remark`: 备注（可选）
- `payment_method`: 支付方式

**示例**：
```json
{
  "address_id": 1,
  "items": [
    { "sku_id": 101, "quantity": 2 },
    { "sku_id": 102, "quantity": 1 }
  ],
  "coupon_id": 5,
  "remark": "尽快发货",
  "payment_method": "wechat"
}
```

**成功响应**：
```json
{
  "code": 0,
  "message": "订单创建成功",
  "data": {
    "order_id": 1001,
    "order_no": "202510310001",
    "total_amount": 299.97,
    "pay_amount": 279.97,
    "payment_deadline": "2025-10-31 16:00:00"
  }
}
```

---

### 取消订单

```http
POST /api/v1/orders/{orderId}/cancel
```

**请求参数**：
- `reason`: 取消原因

**说明**：仅未支付订单可取消

---

### 确认收货

```http
POST /api/v1/orders/{orderId}/confirm-receipt
```

**说明**：确认收到货物

---

### 查询物流

```http
GET /api/v1/orders/{orderId}/express-track
```

**返回**：
- 物流公司
- 快递单号
- 物流轨迹

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "company": "顺丰速运",
    "tracking_number": "SF1234567890",
    "tracks": [
      {
        "time": "2025-10-31 10:00:00",
        "status": "已签收",
        "description": "您的快递已签收，感谢使用顺丰"
      },
      {
        "time": "2025-10-31 08:00:00",
        "status": "派送中",
        "description": "快递小哥正在配送"
      }
    ]
  }
}
```

---

## 订单支付

::: warning 频率限制
支付接口严格限流：10次/分钟
:::

### 支付订单

```http
POST /api/v1/orders/{orderId}/pay
```

**请求参数**：
- `payment_method`: 支付方式（wechat/alipay/balance）
- `payment_password`: 支付密码（余额支付时必填）

**成功响应**：
```json
{
  "code": 0,
  "message": "支付成功",
  "data": {
    "payment_no": "PAY202510310001",
    "pay_url": "https://xxx.com/pay/...",
    "qr_code": "data:image/png;base64,..."
  }
}
```

**说明**：
- 微信/支付宝支付：返回支付链接或二维码
- 余额支付：直接扣款并返回成功

---

## 支付回调（无需认证）

### 支付宝支付回调

```http
POST /api/v1/payment/alipay/callback
```

**说明**：支付宝异步通知接口，由支付宝服务器调用

### 微信支付回调

```http
POST /api/v1/payment/wechat/callback
```

**说明**：微信支付异步通知接口，由微信服务器调用

