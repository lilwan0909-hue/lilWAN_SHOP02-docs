# 商城API - 系统配置

::: tip 路由前缀
所有接口使用 `/api/v1` 前缀，无需认证
:::

## 系统设置

### 获取公开配置

```http
GET /api/v1/system/settings
```

**返回**：
- 网站名称
- 网站LOGO
- 客服电话
- 营业时间
- 支付方式列表
- 配送说明
- ...其他公开配置

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "site_name": "lilWAN商城",
    "site_logo": "https://xxx.com/logo.png",
    "customer_service_phone": "400-123-4567",
    "business_hours": "9:00-18:00",
    "payment_methods": ["wechat", "alipay", "balance"],
    "min_order_amount": 10.00
  }
}
```

---

## 敏感词检测

### 检测敏感词

```http
POST /api/v1/system/sensitive-word/check
```

**请求参数**：
- `content`: 待检测内容

**返回**：
- `has_sensitive`: 是否包含敏感词
- `words`: 命中的敏感词数组

### 过滤敏感词

```http
POST /api/v1/system/sensitive-word/filter
```

**请求参数**：
- `content`: 待过滤内容

**返回**：
- `filtered_content`: 过滤后的内容（敏感词已替换为***）

---

## 协议管理

### 获取所有启用的协议

```http
GET /api/v1/protocols
```

**返回**：用户协议、隐私政策、退换货政策等

**成功响应**：
```json
{
  "code": 0,
  "data": [
    {
      "id": 1,
      "type": "user_agreement",
      "title": "用户协议",
      "version": "v1.0"
    },
    {
      "id": 2,
      "type": "privacy_policy",
      "title": "隐私政策",
      "version": "v1.2"
    }
  ]
}
```

### 根据类型获取协议内容

```http
GET /api/v1/protocols/{type}
```

**类型**：
- `user_agreement` - 用户协议
- `privacy_policy` - 隐私政策
- `return_policy` - 退换货政策
- `delivery_policy` - 配送政策

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "id": 1,
    "type": "user_agreement",
    "title": "用户协议",
    "content": "协议内容...",
    "version": "v1.0",
    "updated_at": "2025-10-01 00:00:00"
  }
}
```

---

## 友情链接

### 友情链接列表

```http
GET /api/v1/friend-links
```

**查询参数**：
- `platform`: 平台（all/pc/mobile）

**返回**：启用的友情链接列表

### 记录点击统计

```http
POST /api/v1/friend-links/{id}/click
```

**说明**：用户点击友情链接时调用，用于统计

---

## 快捷导航

### 快捷导航列表

```http
GET /api/v1/quick-navigations
```

**查询参数**：
- `platform`: 平台（all/h5/weapp/alipay）

**返回**：首页快捷导航入口

**成功响应**：
```json
{
  "code": 0,
  "data": [
    {
      "id": 1,
      "title": "每日签到",
      "icon": "https://xxx.com/icon.png",
      "event_type": "page",
      "event_value": "/pages/checkin/index",
      "badge": 1
    }
  ]
}
```

### 记录点击统计

```http
POST /api/v1/quick-navigations/{id}/click
```

---

## 用户配置

### 验证用户名

```http
POST /api/v1/user-config/validate-username
```

**请求参数**：
- `username`: 用户名

**返回**：
- `valid`: 是否有效
- `message`: 提示信息

### 获取用户名规则

```http
GET /api/v1/user-config/username-rules
```

**返回**：
- 最小长度
- 最大长度
- 允许字符
- 敏感词检查

