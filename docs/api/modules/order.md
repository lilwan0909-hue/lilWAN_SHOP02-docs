# 订单管理接口

::: warning 待完善
本文档为占位文件，接口详情请通过以下方式查看：
1. 导入 Postman 集合到 Apifox：`postman/lilWAN_SHOP02_API.postman_collection.json`
2. 在 Apifox 中查看完整的接口文档、请求示例和响应说明
3. 后续会从 Apifox 导出 Markdown 补充到此处
:::

## 接口列表

### 订单管理

- `GET /api/v1/orders` - 获取订单列表
- `GET /api/v1/orders/{id}` - 获取订单详情
- `POST /api/v1/orders` - 创建订单
- `PUT /api/v1/orders/{id}/cancel` - 取消订单
- `PUT /api/v1/orders/{id}/confirm` - 确认收货

---

### 订单支付

- `POST /api/v1/orders/{id}/pay` - 支付订单
- `GET /api/v1/orders/{id}/pay/status` - 查询支付状态

---

### 订单退款

- `POST /api/v1/orders/{id}/refund` - 申请退款
- `GET /api/v1/refunds` - 获取退款列表
- `GET /api/v1/refunds/{id}` - 获取退款详情

---

## 相关文档

- [分页说明](/docs/api/guidelines/pagination)
- [错误码使用指南](/docs/api/guidelines/error-codes)

---

::: tip 完善计划
待 Apifox 整理完成后，将从 Apifox 导出详细文档补充到本页面。
:::

