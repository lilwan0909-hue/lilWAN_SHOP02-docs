# 认证说明

## 认证机制概览

lilWAN_SHOP02 API 使用 **Laravel Sanctum** 实现的 **Bearer Token** 认证机制。

## 认证流程

### 1. 用户登录

调用登录接口获取访问令牌：

```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "mobile": "13800138000",
  "password": "123456"
}
```

**成功响应**：

```json
{
  "code": 0,
  "message": "登录成功",
  "data": {
    "token": "1|abcdefghijklmnopqrstuvwxyz1234567890",
    "user": {
      "id": 1,
      "mobile": "13800138000",
      "nickname": "张三",
      "avatar": "https://example.com/avatar.jpg"
    }
  },
  "timestamp": 1730361234
}
```

### 2. 存储 Token

前端需妥善存储 Token：

- **Web 端**：推荐使用 `localStorage` 或 `sessionStorage`
- **移动端**：使用平台安全存储（如 iOS Keychain、Android EncryptedSharedPreferences）
- **小程序**：使用 `wx.setStorageSync()` 等平台 API

::: warning 安全提示
- 禁止将 Token 存储在 Cookie 中（易受 CSRF 攻击）
- 避免在 URL 中传递 Token
- 定期检查 Token 有效性
:::

### 3. 携带 Token 请求

在后续 API 请求的 HTTP Header 中携带 Token：

```http
GET /api/v1/user/profile
Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz1234567890
```

### 4. Token 验证

后端中间件会自动验证 Token：

- **有效**：正常处理请求
- **无效/过期**：返回 `401 Unauthorized`

**错误响应示例**：

```json
{
  "code": 4001,
  "message": "未授权，请先登录",
  "data": null,
  "timestamp": 1730361234,
  "trace_id": "550e8400-e29b-41d4-a716-446655440000",
  "error_info": {
    "title": "认证错误",
    "suggestion": "Token 无效或已过期，请重新登录"
  }
}
```

### 5. 用户登出

调用登出接口销毁 Token：

```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

**成功响应**：

```json
{
  "code": 0,
  "message": "登出成功",
  "data": null,
  "timestamp": 1730361234
}
```

登出后，前端应清除本地存储的 Token。

## Token 生命周期

### 有效期

- **默认有效期**：30 天
- **无操作有效期**：无限制（只要不过期，Token 持续有效）

### 刷新策略

**当前版本**（v1.0.0）：暂无自动刷新机制

**未来计划**（v1.1.0）：
- 实现 `refresh_token` 机制
- 支持静默刷新（无需用户重新登录）

### 失效场景

Token 在以下情况下会失效：

1. **主动登出**：调用 `/api/v1/auth/logout` 接口
2. **过期**：超过有效期（30 天）
3. **主动撤销**：管理员手动撤销用户 Token
4. **安全原因**：检测到异常行为（如密码修改、账号冻结）

## 前端实现建议

### Axios 拦截器（Vue/React）

```typescript
import axios from 'axios';

// 请求拦截器：自动注入 Token
axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// 响应拦截器：处理认证错误
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token 无效或过期，清除本地存储并跳转登录
      localStorage.removeItem('token');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);
```

### Taro 跨端封装（H5/小程序）

```typescript
import Taro from '@tarojs/taro';

// 封装请求函数
export function request<T>(options: Taro.request.Option): Promise<T> {
  const token = Taro.getStorageSync('token');
  
  return Taro.request({
    ...options,
    header: {
      ...options.header,
      Authorization: token ? `Bearer ${token}` : '',
    },
  }).then((res) => {
    const { code, message, data } = res.data;
    
    if (code === 0) {
      return data;
    } else if (code === 4001) {
      // 认证失败，清除 Token 并跳转登录
      Taro.removeStorageSync('token');
      Taro.navigateTo({ url: '/pages/login/index' });
      throw new Error(message);
    } else {
      throw new Error(message);
    }
  });
}
```

## 安全最佳实践

### 1. HTTPS 传输

生产环境必须使用 HTTPS，防止 Token 被中间人窃取。

### 2. Token 存储

- ✅ **推荐**：使用平台安全存储（localStorage、Keychain、EncryptedSharedPreferences）
- ❌ **禁止**：存储在 Cookie、URL、localStorage（如果有 XSS 风险）

### 3. Token 泄漏防护

- 定期检查 Token 有效性
- 重要操作（如修改密码、绑定手机）需二次验证
- 异常登录检测（如异地登录提醒）

### 4. 前端防护

- 实施 CSP（Content Security Policy）策略
- 防范 XSS 攻击（过滤用户输入）
- 避免在控制台打印 Token

### 5. 后端防护

- 限制单用户同时在线 Token 数量（防止账号共享）
- 实施速率限制（防止暴力破解）
- 记录关键操作日志（用于审计）

## 多端认证同步

### 单端登录模式

同一账号在多个设备登录时，新登录会使旧 Token 失效。

**实现方式**：
- 登录时撤销该用户的所有旧 Token
- 只保留最新的 Token

### 多端共存模式（未来规划）

允许同一账号在多个设备同时登录。

**实现方式**：
- 每个设备独立 Token
- 用户可在"设备管理"页面查看并撤销设备

## 管理员认证

管理员后台认证机制与商城端一致，均使用 Bearer Token。

**差异点**：

1. **权限验证**：管理员接口会额外检查用户角色和权限
2. **速率限制**：管理员接口限流额度更高（300 次/分钟）
3. **Token 有效期**：可配置为更短（如 7 天），提升安全性

## 常见问题

### Q1: Token 过期后如何处理？

**A**: 当前版本需要用户重新登录。未来版本会支持 `refresh_token` 机制，实现静默刷新。

### Q2: 如何实现"记住我"功能？

**A**: 前端可根据用户选择决定 Token 存储方式：
- 选中"记住我"：存储到 `localStorage`（持久化）
- 未选中：存储到 `sessionStorage`（关闭浏览器失效）

### Q3: 多设备登录如何处理？

**A**: 当前版本为单端登录模式，新登录会使旧设备 Token 失效。

### Q4: 如何防止 Token 被盗用？

**A**: 
- 使用 HTTPS 传输
- 绑定设备指纹（如 User-Agent、IP）
- 实施异常检测（如异地登录提醒）
- 重要操作需二次验证

### Q5: Token 存储在哪里最安全？

**A**: 
- **Web 端**：`localStorage`（前提是无 XSS 漏洞）
- **移动端**：平台安全存储（Keychain、EncryptedSharedPreferences）
- **小程序**：平台 Storage API（已加密）

## 相关文档

- [错误处理规范](/api/guidelines/error-handling)
- [前端错误提示规范](/api/guidelines/frontend-errors)
- [常见错误码使用指南](/api/guidelines/error-codes)

---

::: tip 提示
认证机制会随着项目迭代持续优化，请关注文档更新。
:::

