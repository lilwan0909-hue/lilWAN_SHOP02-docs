# 认证管理接口

::: warning 待完善
本文档为占位文件，接口详情请通过以下方式查看：
1. 导入 Postman 集合到 Apifox：`postman/lilWAN_SHOP02_API.postman_collection.json`
2. 在 Apifox 中查看完整的接口文档、请求示例和响应说明
3. 后续会从 Apifox 导出 Markdown 补充到此处
:::

## 接口列表

### 用户注册

```
POST /api/v1/auth/register
```

**请求参数**:
- `mobile`: 手机号（必填）
- `password`: 密码（必填，6-20位）
- `code`: 验证码（必填）

**成功响应**:
```json
{
  "code": 0,
  "message": "注册成功",
  "data": {
    "token": "1|xxx...",
    "user": {
      "id": 1,
      "mobile": "13800138000",
      "nickname": "用户xxx"
    }
  }
}
```

---

### 用户登录

```
POST /api/v1/auth/login
```

**请求参数**:
- `mobile`: 手机号（必填）
- `password`: 密码（必填）

**成功响应**:
```json
{
  "code": 0,
  "message": "登录成功",
  "data": {
    "token": "1|xxx...",
    "user": {
      "id": 1,
      "mobile": "13800138000",
      "nickname": "张三"
    }
  }
}
```

---

### 用户登出

```
POST /api/v1/auth/logout
```

**请求头**:
```
Authorization: Bearer {token}
```

**成功响应**:
```json
{
  "code": 0,
  "message": "登出成功",
  "data": null
}
```

---

## 相关文档

- [认证说明](/docs/api/guidelines/authentication)
- [错误处理规范](/docs/api/guidelines/error-handling)

---

::: tip 完善计划
待 Apifox 整理完成后，将从 Apifox 导出详细文档补充到本页面。
:::

