# 商城API - 认证管理

::: tip 路由前缀
所有接口使用 `/api/v1` 前缀
:::

## 用户认证（无需登录）

### 用户注册

```http
POST /api/v1/auth/register
```

**请求参数**：
- `mobile`: 手机号（必填）
- `password`: 密码（必填，6-20位）
- `code`: 验证码（必填）
- `nickname`: 昵称（可选）
- `invite_code`: 邀请码（可选）

**成功响应**：
```json
{
  "code": 0,
  "message": "注册成功",
  "data": {
    "token": "1|xxx...",
    "user": {
      "id": 1,
      "mobile": "13800138000",
      "nickname": "用户xxx",
      "avatar": null
    }
  }
}
```

---

### 用户登录

```http
POST /api/v1/auth/login
```

**请求参数**：
- `mobile`: 手机号（必填）
- `password`: 密码（必填）

**成功响应**：
```json
{
  "code": 0,
  "message": "登录成功",
  "data": {
    "token": "1|xxx...",
    "user": {
      "id": 1,
      "mobile": "13800138000",
      "nickname": "张三",
      "avatar": "https://xxx.com/avatar.jpg",
      "level": {
        "id": 1,
        "name": "普通会员"
      }
    }
  }
}
```

---

## 用户认证（需要登录）

::: warning 认证要求
以下接口需要在请求头中携带 Token：
```
Authorization: Bearer {token}
```
:::

### 刷新Token

```http
POST /api/v1/auth/refresh
```

**说明**：刷新当前Token（未来功能，当前版本未实现）

### 获取当前用户信息

```http
GET /api/v1/auth/me
```

**成功响应**：
```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "id": 1,
    "mobile": "13800138000",
    "nickname": "张三",
    "avatar": "https://xxx.com/avatar.jpg",
    "email": "zhangsan@example.com",
    "balance": 1000.00,
    "points": 500,
    "level": {
      "id": 1,
      "name": "普通会员"
    }
  }
}
```

### 用户登出

```http
POST /api/v1/auth/logout
```

**说明**：登出后Token失效

**成功响应**：
```json
{
  "code": 0,
  "message": "登出成功",
  "data": null
}
```

