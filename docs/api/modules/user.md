# 用户管理接口

::: warning 待完善
本文档为占位文件，接口详情请通过以下方式查看：
1. 导入 Postman 集合到 Apifox：`postman/lilWAN_SHOP02_API.postman_collection.json`
2. 在 Apifox 中查看完整的接口文档、请求示例和响应说明
3. 后续会从 Apifox 导出 Markdown 补充到此处
:::

## 接口列表

### 获取当前用户信息

```
GET /api/v1/user/profile
```

### 更新用户信息

```
PUT /api/v1/user/profile
```

### 修改密码

```
PUT /api/v1/user/password
```

### 收货地址管理

- `GET /api/v1/user/addresses` - 获取收货地址列表
- `POST /api/v1/user/addresses` - 添加收货地址
- `PUT /api/v1/user/addresses/{id}` - 更新收货地址
- `DELETE /api/v1/user/addresses/{id}` - 删除收货地址
- `PUT /api/v1/user/addresses/{id}/default` - 设为默认地址

---

## 相关文档

- [认证说明](/docs/api/guidelines/authentication)
- [错误码使用指南](/docs/api/guidelines/error-codes)

---

::: tip 完善计划
待 Apifox 整理完成后，将从 Apifox 导出详细文档补充到本页面。
:::

