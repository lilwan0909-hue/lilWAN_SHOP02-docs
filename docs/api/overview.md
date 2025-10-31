# API 概览

## 欢迎使用 lilWAN_SHOP02 API

lilWAN_SHOP02 是一个现代化的 B2C 自营电商平台（规划扩展为 B2B2C 多商户平台），提供完整的 RESTful API 接口。

## 基础信息

### 接口地址

本项目 API 分为两个部分，使用不同的路由前缀：

#### 1. 管理后台 API

**路由前缀**：`/admin`

**开发环境**
```
http://localhost:8081/admin
```

**生产环境**（待定）
```
https://api.lilwan-shop.com/admin
```

**使用端**：Vue Arco Pro 管理后台

#### 2. 商城 API（移动端）

**路由前缀**：`/api/v1`

**开发环境**
```
http://localhost:8081/api/v1
```

**生产环境**（待定）
```
https://api.lilwan-shop.com/api/v1
```

**使用端**：Taro 多端应用（H5/微信小程序/支付宝小程序/APP）

---

::: warning 注意路由前缀差异
- 管理后台接口使用 `/admin` 前缀
- 商城移动端接口使用 `/api/v1` 前缀
- 两者使用相同的认证机制（Bearer Token），但权限体系不同
:::

## 统一响应结构

所有 API 接口返回的数据遵循统一的 JSON 格式：

### 成功响应

```json
{
  "code": 0,
  "message": "操作成功",
  "data": {
    // 业务数据
  },
  "timestamp": 1730361234
}
```

### 错误响应

```json
{
  "code": 4001,
  "message": "用户名或密码错误",
  "data": null,
  "timestamp": 1730361234,
  "trace_id": "550e8400-e29b-41d4-a716-446655440000",
  "error_info": {
    "title": "认证错误",
    "suggestion": "请检查用户名和密码是否正确，或联系管理员重置密码"
  }
}
```

### 字段说明

| 字段 | 类型 | 说明 |
|------|------|------|
| `code` | integer | 状态码，0 表示成功，非 0 表示错误 |
| `message` | string | 响应消息，成功时为操作提示，失败时为错误说明 |
| `data` | any | 业务数据，成功时返回具体数据，失败时为 null |
| `timestamp` | integer | 响应时间戳（Unix 时间戳） |
| `trace_id` | string | 请求追踪ID（仅错误响应时返回，用于问题排查） |
| `error_info` | object | 错误详情（仅错误响应时返回） |
| `error_info.title` | string | 错误标题（分类） |
| `error_info.suggestion` | string | 错误建议（帮助用户解决问题） |

## 认证机制

### Bearer Token

API 使用 **Bearer Token** 进行认证（基于 Laravel Sanctum）。

#### 获取 Token

根据使用端调用对应的登录接口：

**管理后台登录**：
```http
POST /admin/auth/login
Content-Type: application/json

{
  "username": "admin",
  "password": "123456"
}
```

**商城用户登录**：
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "mobile": "13800138000",
  "password": "123456"
}
```

成功响应（两者格式一致）：

```json
{
  "code": 0,
  "message": "登录成功",
  "data": {
    "token": "1|abcdefghijklmnopqrstuvwxyz1234567890",
    "user": {
      "id": 1,
      "mobile": "13800138000",
      "nickname": "张三"
    }
  }
}
```

#### 使用 Token

在后续请求的 HTTP Header 中携带 Token（格式相同）：

**管理后台**：
```http
GET /admin/products
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz1234567890
```

**商城 API**：
```http
GET /api/v1/user/profile
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz1234567890
```

#### Token 生命周期

- **有效期**：30 天（可配置）
- **刷新**：目前无自动刷新机制，过期后需重新登录
- **注销**：
  - 管理后台：`POST /admin/auth/logout`
  - 商城 API：`POST /api/v1/auth/logout`

## 常见错误码

完整的错误码列表请参阅 [常见错误码使用指南](/api/guidelines/error-codes)。

### 常见错误码速查

| 错误码 | 说明 |
|--------|------|
| 0 | 成功 |
| 4000 | 参数错误 |
| 4001 | 认证失败 |
| 4002 | 权限不足 |
| 4003 | 资源不存在 |
| 4004 | 请求频率超限 |
| 5000 | 服务器内部错误 |

## 分页说明

### 请求参数

列表类接口支持分页查询，使用以下查询参数：

| 参数 | 类型 | 默认值 | 说明 |
|------|------|--------|------|
| `page` | integer | 1 | 当前页码（从 1 开始） |
| `per_page` | integer | 15 | 每页数据量（范围：1-100） |

示例：

```http
GET /api/v1/products?page=2&per_page=20
```

### 响应结构

```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "data": [
      // 数据列表
    ],
    "current_page": 2,
    "per_page": 20,
    "total": 156,
    "last_page": 8,
    "from": 21,
    "to": 40
  }
}
```

分页字段说明：

| 字段 | 类型 | 说明 |
|------|------|------|
| `data` | array | 当前页数据列表 |
| `current_page` | integer | 当前页码 |
| `per_page` | integer | 每页数量 |
| `total` | integer | 总记录数 |
| `last_page` | integer | 最后一页页码 |
| `from` | integer | 当前页起始记录序号 |
| `to` | integer | 当前页结束记录序号 |

## 速率限制

为保障服务稳定性，API 实施了请求速率限制：

| 用户类型 | 限制规则 |
|---------|---------|
| 游客（未认证） | 60 次/分钟 |
| 认证用户 | 120 次/分钟 |
| 管理员 | 300 次/分钟 |

超出限制时返回：

```json
{
  "code": 4004,
  "message": "请求过于频繁，请稍后再试",
  "data": null
}
```

响应头会包含限流信息：

```
X-RateLimit-Limit: 120
X-RateLimit-Remaining: 0
X-RateLimit-Reset: 1730361294
```

## 时区与时间格式

### 时区

所有时间均采用 **UTC+8（北京时间）**。

### 时间戳格式

- 接口返回：**Unix 时间戳**（秒级，如 `1730361234`）
- 日期时间字符串：**ISO 8601 格式**（如 `2025-10-31T14:30:00+08:00`）

## 接口模块

API 按业务模块和使用端组织：

### 管理后台模块（`/admin`）

- **认证管理** - 管理员登录、登出、权限验证
- **商品管理** - 商品 CRUD、SKU 管理、库存管理
- **订单管理** - 订单列表、详情、发货、退款审核
- **用户管理** - 用户列表、标签、分组、数据导出
- **营销管理** - 优惠券发放、秒杀活动配置、拼团设置
- **系统设置** - 支付配置、物流设置、权限管理、菜单配置
- **内容管理** - 文章发布、广告位管理、页面配置

### 商城模块（`/api/v1`）

- [认证管理](/api/modules/authentication) - 用户注册、登录、登出
- [用户管理](/api/modules/user) - 用户信息、收货地址、账号安全
- [商品管理](/api/modules/product) - 商品浏览、搜索、详情、收藏
- [订单管理](/api/modules/order) - 下单、支付、物流查询、确认收货
- [营销管理](/api/modules/marketing) - 优惠券领取、秒杀参与、拼团

## 开发指南

### 最佳实践

- [错误处理规范](/api/guidelines/error-handling)
- [前端错误提示规范](/api/guidelines/frontend-errors)
- [认证与授权](/api/guidelines/authentication)
- [分页查询](/api/guidelines/pagination)

### 调试工具

推荐使用以下工具进行 API 调试：

1. **Apifox**（推荐）
   - 导入项目提供的 Postman 集合
   - 完整的接口文档、Mock 和测试功能
   - 文件位置：`postman/lilWAN_SHOP02_API.postman_collection.json`

2. **Postman**
   - 支持环境变量和脚本自动化
   - 集合已包含自动 Token 设置

3. **cURL**
   - 命令行快速测试
   - 适合 CI/CD 集成

## 更新日志

### v1.0.0（2025-10-31）

- 🎉 初始版本发布
- ✅ 统一响应结构（`code / message / data / timestamp`）
- ✅ 全局错误处理与友好提示
- ✅ Bearer Token 认证机制
- ✅ 分页与速率限制
- ✅ 核心业务模块接口（认证、用户、商品、订单、营销）

## 联系我们

- **GitHub Issues**: [提交问题](https://github.com/your-org/lilWAN_SHOP02/issues)
- **技术支持**: support@lilwan-shop.com
- **文档维护**: lilWAN Development Team

---

::: tip 提示
本文档与项目代码同步更新。如发现文档与实际接口不一致，请优先以最新代码为准，并提交 Issue 告知我们。
:::

