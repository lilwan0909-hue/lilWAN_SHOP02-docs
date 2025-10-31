# 商城API - 用户中心

::: tip 路由前缀
所有接口使用 `/api/v1` 前缀，需要认证
:::

## 用户资料管理

### 获取用户资料

```http
GET /api/v1/user/profile
```

**成功响应**：
```json
{
  "code": 0,
  "data": {
    "id": 1,
    "mobile": "13800138000",
    "nickname": "张三",
    "avatar": "https://xxx.com/avatar.jpg",
    "email": "zhangsan@example.com",
    "gender": 1,
    "birthday": "1990-01-01",
    "level": {
      "id": 1,
      "name": "普通会员"
    }
  }
}
```

### 更新用户资料

```http
PUT /api/v1/user/profile
```

**请求参数**：
- `nickname`: 昵称
- `email`: 邮箱
- `gender`: 性别（0-未知/1-男/2-女）
- `birthday`: 生日

### 更新头像

```http
PUT /api/v1/user/avatar
```

**请求参数**：
- `avatar`: 头像文件（multipart/form-data）

### 修改密码

```http
PUT /api/v1/user/password
```

**请求参数**：
- `old_password`: 原密码
- `new_password`: 新密码
- `confirm_password`: 确认密码

---

## 用户资产

### 获取余额

```http
GET /api/v1/user/balance
```

**返回**：
- 余额
- 冻结金额
- 可用余额

### 获取积分

```http
GET /api/v1/user/points
```

**返回**：
- 总积分
- 可用积分
- 冻结积分

---

## 收货地址管理

### 地址列表

```http
GET /api/v1/addresses
```

**成功响应**：
```json
{
  "code": 0,
  "data": [
    {
      "id": 1,
      "consignee": "张三",
      "mobile": "13800138000",
      "province": "广东省",
      "city": "深圳市",
      "district": "南山区",
      "address": "科技园xx路xx号",
      "is_default": true
    }
  ]
}
```

### 添加地址

```http
POST /api/v1/addresses
```

**请求参数**：
- `consignee`: 收货人
- `mobile`: 手机号
- `province`: 省份
- `city`: 城市
- `district`: 区县
- `address`: 详细地址
- `is_default`: 是否默认（可选）

### 地址详情

```http
GET /api/v1/addresses/{id}
```

### 更新地址

```http
PUT /api/v1/addresses/{id}
```

### 删除地址

```http
DELETE /api/v1/addresses/{id}
```

### 设为默认地址

```http
POST /api/v1/addresses/{id}/default
```

---

## 支付密码管理

### 支付密码状态

```http
GET /api/v1/user/payment-password/status
```

**返回**：
- `is_set`: 是否已设置支付密码
- `locked_until`: 锁定到期时间（如已锁定）

### 设置支付密码

```http
POST /api/v1/user/payment-password/set
```

**请求参数**：
- `password`: 支付密码（6位数字）
- `confirm_password`: 确认密码

**说明**：首次设置支付密码

### 重置支付密码

```http
POST /api/v1/user/payment-password/reset
```

**请求参数**：
- `mobile`: 手机号
- `code`: 验证码
- `new_password`: 新密码
- `confirm_password`: 确认密码

**说明**：忘记密码时使用

### 修改支付密码

```http
POST /api/v1/user/payment-password/change
```

**请求参数**：
- `old_password`: 原密码
- `new_password`: 新密码
- `confirm_password`: 确认密码

### 验证支付密码

```http
POST /api/v1/user/payment-password/verify
```

**请求参数**：
- `password`: 支付密码

**说明**：用于验证支付密码是否正确

---

## 登录安全管理

### 登录日志

```http
GET /api/v1/user/login-logs
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量

**返回**：
- 登录时间
- 登录IP
- 登录设备
- 登录地点

### 设备列表

```http
GET /api/v1/user/devices
```

**返回**：当前账号的所有登录设备

### 信任设备

```http
POST /api/v1/user/devices/{deviceId}/trust
```

**说明**：标记设备为受信任设备，跳过二次验证

### 移除设备

```http
DELETE /api/v1/user/devices/{deviceId}
```

**说明**：移除设备，该设备的Token失效

---

## 合规管理

### 获取账号注销申请

```http
GET /api/v1/user/compliance/cancel-request
```

**返回**：当前用户的账号注销申请状态

### 申请注销账号

```http
POST /api/v1/user/compliance/cancel-request
```

**请求参数**：
- `reason`: 注销原因
- `password`: 登录密码（确认身份）

**说明**：提交账号注销申请，需管理员审核

### 取消注销申请

```http
DELETE /api/v1/user/compliance/cancel-request
```

**说明**：撤销注销申请

---

### 数据导出申请列表

```http
GET /api/v1/user/compliance/export-requests
```

**返回**：用户的数据导出申请列表

### 申请导出个人数据

```http
POST /api/v1/user/compliance/export-request
```

**说明**：申请导出个人数据（订单、评价、地址等）

### 下载导出数据

```http
GET /api/v1/user/compliance/export-request/{requestId}/download
```

**说明**：下载已生成的数据包

---

### 获取消息订阅设置

```http
GET /api/v1/user/compliance/message-settings
```

**返回**：
- 订单消息
- 营销消息
- 系统通知
- ...各类消息的订阅状态

### 更新消息订阅设置

```http
PUT /api/v1/user/compliance/message-settings
```

**请求参数**：
- `type`: 消息类型
- `enabled`: 是否启用

### 批量更新消息订阅

```http
PUT /api/v1/user/compliance/message-settings/batch
```

**请求参数**：
- `settings`: 设置数组

**示例**：
```json
{
  "settings": [
    { "type": "order", "enabled": true },
    { "type": "marketing", "enabled": false }
  ]
}
```

