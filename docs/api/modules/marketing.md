# 营销管理接口

::: warning 待完善
本文档为占位文件，接口详情请通过以下方式查看：
1. 导入 Postman 集合到 Apifox：`postman/lilWAN_SHOP02_API.postman_collection.json`
2. 在 Apifox 中查看完整的接口文档、请求示例和响应说明
3. 后续会从 Apifox 导出 Markdown 补充到此处
:::

## 接口列表

### 优惠券

- `GET /api/v1/coupons` - 获取优惠券列表
- `GET /api/v1/coupons/{id}` - 获取优惠券详情
- `POST /api/v1/coupons/{id}/receive` - 领取优惠券
- `GET /api/v1/user/coupons` - 获取我的优惠券

---

### 秒杀活动

- `GET /api/v1/seckill/activities` - 获取秒杀活动列表
- `GET /api/v1/seckill/activities/{id}` - 获取秒杀活动详情
- `POST /api/v1/seckill/activities/{id}/participate` - 参与秒杀

---

### 拼团活动

- `GET /api/v1/group-buy/activities` - 获取拼团活动列表
- `GET /api/v1/group-buy/activities/{id}` - 获取拼团活动详情
- `POST /api/v1/group-buy/activities/{id}/join` - 参与拼团

---

### 满减活动

- `GET /api/v1/full-reduce/activities` - 获取满减活动列表
- `GET /api/v1/full-reduce/activities/{id}` - 获取满减活动详情

---

## 相关文档

- [分页说明](/docs/api/guidelines/pagination)
- [错误码使用指南](/docs/api/guidelines/error-codes)

---

::: tip 完善计划
待 Apifox 整理完成后，将从 Apifox 导出详细文档补充到本页面。
:::

