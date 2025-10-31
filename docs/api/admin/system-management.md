# 管理后台 - 系统管理API

::: tip 路由前缀
所有接口使用 `/admin` 前缀
:::

## 管理员管理

### 管理员列表

```http
GET /admin/admins
```

**权限**：`admin.manage`

### 创建管理员

```http
POST /admin/admins
```

**权限**：`admin.manage`

**请求参数**：
- `username`: 用户名
- `password`: 密码
- `email`: 邮箱
- `name`: 姓名
- `role_ids`: 角色ID数组

### 管理员详情

```http
GET /admin/admins/{id}
```

**权限**：`admin.manage`

### 更新管理员

```http
PUT /admin/admins/{id}
```

**权限**：`admin.manage`

### 删除管理员

```http
DELETE /admin/admins/{id}
```

**权限**：`admin.manage`

### 重置管理员密码

```http
POST /admin/admins/{id}/reset-password
```

**权限**：`admin.manage`

### 分配角色

```http
POST /admin/admins/{id}/assign-roles
```

**权限**：`admin.manage`

**请求参数**：
- `role_ids`: 角色ID数组

---

## 角色管理

### 角色列表

```http
GET /admin/roles
```

**权限**：`role.manage`

### 创建角色

```http
POST /admin/roles
```

**权限**：`role.manage`

**请求参数**：
- `name`: 角色名称
- `slug`: 角色标识
- `description`: 描述

### 角色详情

```http
GET /admin/roles/{id}
```

**权限**：`role.manage`

### 更新角色

```http
PUT /admin/roles/{id}
```

**权限**：`role.manage`

### 删除角色

```http
DELETE /admin/roles/{id}
```

**权限**：`role.manage`

### 分配权限

```http
POST /admin/roles/{id}/assign-permissions
```

**权限**：`role.manage`

**请求参数**：
- `permission_ids`: 权限ID数组

---

## 权限管理

### 权限列表

```http
GET /admin/permissions
```

**权限**：`permission.view`

### 权限详细列表

```http
GET /admin/permissions/list
```

**权限**：`permission.manage`

### 创建权限

```http
POST /admin/permissions
```

**权限**：`permission.manage`

**请求参数**：
- `name`: 权限名称
- `slug`: 权限标识
- `group`: 权限分组
- `description`: 描述

### 权限详情

```http
GET /admin/permissions/{id}
```

**权限**：`permission.manage`

### 更新权限

```http
PUT /admin/permissions/{id}
```

**权限**：`permission.manage`

### 删除权限

```http
DELETE /admin/permissions/{id}
```

**权限**：`permission.manage`

### 权限分组列表

```http
GET /admin/permissions/groups/list
```

**权限**：`permission.manage`

### 批量创建权限

```http
POST /admin/permissions/batch
```

**权限**：`permission.manage`

**请求参数**：
- `permissions`: 权限数组

---

## 菜单管理

### 获取当前用户菜单

```http
GET /admin/user-menus
```

**权限**：无需特殊权限（根据用户角色自动返回）

**说明**：前端导航使用，返回当前用户有权限访问的菜单树

### 菜单列表

```http
GET /admin/menus
```

**权限**：`menu.manage`

### 创建菜单

```http
POST /admin/menus
```

**权限**：`menu.manage`

**请求参数**：
- `parent_id`: 父菜单ID（顶级菜单为null）
- `title`: 菜单标题
- `name`: 菜单名称
- `path`: 路由路径
- `component`: 组件路径
- `icon`: 图标
- `sort`: 排序
- `hidden`: 是否隐藏
- `permission`: 权限标识

### 菜单详情

```http
GET /admin/menus/{id}
```

**权限**：`menu.manage`

### 更新菜单

```http
PUT /admin/menus/{id}
```

**权限**：`menu.manage`

### 删除菜单

```http
DELETE /admin/menus/{id}
```

**权限**：`menu.manage`

### 批量删除菜单

```http
POST /admin/menus/batch-delete
```

**权限**：`menu.manage`

**请求参数**：
- `ids`: 菜单ID数组

---

## 文件上传

### 上传图片

```http
POST /admin/upload/image
```

**权限**：需要认证

**请求参数**：
- `file`: 图片文件（multipart/form-data）

**支持格式**：jpg、jpeg、png、gif、webp

### 上传LOGO

```http
POST /admin/upload/logo
```

**权限**：需要认证

### 上传图标

```http
POST /admin/upload/icon
```

**权限**：需要认证

### 上传文件

```http
POST /admin/upload/file
```

**权限**：需要认证

**说明**：通用文件上传（Excel、PDF等）

---

## 系统设置

### 获取所有设置

```http
GET /admin/settings
```

**权限**：`setting.manage`

### 获取单项设置

```http
GET /admin/settings/{key}
```

**权限**：`setting.manage`

**示例**：
- `GET /admin/settings/site_name` - 获取网站名称
- `GET /admin/settings/seo` - 获取SEO设置

### 更新设置

```http
PUT /admin/settings
```

**权限**：`setting.manage`

**请求参数**：
- `settings`: 设置键值对对象

**示例**：
```json
{
  "settings": {
    "site_name": "lilWAN商城",
    "site_description": "现代化电商平台",
    "contact_email": "admin@example.com"
  }
}
```

### 清除缓存

```http
POST /admin/settings/clear-cache
```

**权限**：`setting.manage`

### 测试Redis连接

```http
POST /admin/settings/test-redis
```

**权限**：`setting.manage`

### 队列状态

```http
GET /admin/settings/queue-status
```

**权限**：`setting.manage`

**返回**：队列任务数量、失败任务等

---

## 敏感词管理

### 敏感词列表

```http
GET /admin/sensitive-words
```

**权限**：`setting.manage`

### 添加敏感词

```http
POST /admin/sensitive-words
```

**权限**：`setting.manage`

**请求参数**：
- `word`: 敏感词
- `level`: 等级（low/medium/high）
- `replace_word`: 替换词（可选）

### 更新敏感词

```http
PUT /admin/sensitive-words/{id}
```

**权限**：`setting.manage`

### 删除敏感词

```http
DELETE /admin/sensitive-words/{id}
```

**权限**：`setting.manage`

### 批量导入敏感词

```http
POST /admin/sensitive-words/batch-import
```

**权限**：`setting.manage`

**请求参数**：
- `words`: 敏感词数组（每行一个）

### 批量删除敏感词

```http
POST /admin/sensitive-words/batch-delete
```

**权限**：`setting.manage`

**请求参数**：
- `ids`: 敏感词ID数组

### 测试敏感词检测

```http
POST /admin/sensitive-words/test
```

**权限**：`setting.manage`

**请求参数**：
- `content`: 待检测内容

**返回**：检测结果、命中的敏感词

---

## 协议管理

### 协议列表

```http
GET /admin/protocols
```

**权限**：`setting.protocol`

**说明**：用户协议、隐私政策、退换货政策等

### 协议详情

```http
GET /admin/protocols/{id}
```

**权限**：`setting.protocol`

### 更新协议

```http
PUT /admin/protocols/{id}
```

**权限**：`setting.protocol`

**请求参数**：
- `title`: 标题
- `content`: 内容（富文本）
- `version`: 版本号

### 启用/禁用协议

```http
POST /admin/protocols/{id}/toggle-status
```

**权限**：`setting.protocol`

### 协议版本列表

```http
GET /admin/protocols/{id}/versions
```

**权限**：`setting.protocol`

**说明**：协议修改历史

### 协议版本详情

```http
GET /admin/protocols/{id}/versions/{versionId}
```

**权限**：`setting.protocol`

### 对比协议版本

```http
POST /admin/protocols/{id}/compare-versions
```

**权限**：`setting.protocol`

**请求参数**：
- `version1`: 版本1
- `version2`: 版本2

**返回**：差异对比结果

---

## 友情链接管理

### 友情链接列表

```http
GET /admin/friend-links
```

**权限**：`content.link`

### 创建友情链接

```http
POST /admin/friend-links
```

**权限**：`content.link`

**请求参数**：
- `title`: 标题
- `url`: 链接地址
- `logo`: LOGO图片
- `category`: 分类
- `platform`: 平台（all/pc/mobile）
- `sort`: 排序
- `status`: 状态（enabled/disabled）

### 友情链接详情

```http
GET /admin/friend-links/{id}
```

**权限**：`content.link`

### 更新友情链接

```http
PUT /admin/friend-links/{id}
```

**权限**：`content.link`

### 删除友情链接

```http
DELETE /admin/friend-links/{id}
```

**权限**：`content.link`

### 批量删除友情链接

```http
POST /admin/friend-links/batch-delete
```

**权限**：`content.link`

### 启用/禁用友情链接

```http
POST /admin/friend-links/{id}/toggle-status
```

**权限**：`content.link`

### 批量更新排序

```http
POST /admin/friend-links/batch-update-sort
```

**权限**：`content.link`

### 获取分类选项

```http
GET /admin/friend-links/options/categories
```

**权限**：`content.link`

### 获取平台选项

```http
GET /admin/friend-links/options/platforms
```

**权限**：`content.link`

---

## 快捷导航管理

### 快捷导航列表

```http
GET /admin/quick-navigations
```

**权限**：`content.navigation`

### 创建快捷导航

```http
POST /admin/quick-navigations
```

**权限**：`content.navigation`

**请求参数**：
- `title`: 标题
- `icon`: 图标
- `event_type`: 事件类型（page/url/miniprogram）
- `event_value`: 事件值
- `platform`: 平台（all/h5/weapp/alipay）
- `sort`: 排序

### 快捷导航详情

```http
GET /admin/quick-navigations/{id}
```

**权限**：`content.navigation`

### 更新快捷导航

```http
PUT /admin/quick-navigations/{id}
```

**权限**：`content.navigation`

### 删除快捷导航

```http
DELETE /admin/quick-navigations/{id}
```

**权限**：`content.navigation`

### 批量删除快捷导航

```http
POST /admin/quick-navigations/batch-delete
```

**权限**：`content.navigation`

### 启用/禁用快捷导航

```http
POST /admin/quick-navigations/{id}/toggle-status
```

**权限**：`content.navigation`

### 批量更新排序

```http
POST /admin/quick-navigations/batch-update-sort
```

**权限**：`content.navigation`

### 获取事件类型选项

```http
GET /admin/quick-navigations/options/event-types
```

**权限**：`content.navigation`

### 获取平台选项

```http
GET /admin/quick-navigations/options/platforms
```

**权限**：`content.navigation`

---

## 字典管理

### 字典列表

```http
GET /admin/dictionaries
```

**权限**：`dict.manage`

### 创建字典

```http
POST /admin/dictionaries
```

**权限**：`dict.manage`

**请求参数**：
- `code`: 字典编码
- `name`: 字典名称
- `description`: 描述

### 字典详情

```http
GET /admin/dictionaries/{id}
```

**权限**：`dict.manage`

### 更新字典

```http
PUT /admin/dictionaries/{id}
```

**权限**：`dict.manage`

### 删除字典

```http
DELETE /admin/dictionaries/{id}
```

**权限**：`dict.manage`

---

### 字典项列表

```http
GET /admin/dictionaries/{dictId}/items
```

**权限**：`dict.manage`

### 创建字典项

```http
POST /admin/dictionaries/{dictId}/items
```

**权限**：`dict.manage`

**请求参数**：
- `value`: 字典值
- `label`: 字典标签
- `sort`: 排序

### 更新字典项

```http
PUT /admin/dictionaries/{dictId}/items/{itemId}
```

**权限**：`dict.manage`

### 删除字典项

```http
DELETE /admin/dictionaries/{dictId}/items/{itemId}
```

**权限**：`dict.manage`

### 根据编码获取字典

```http
GET /admin/dictionaries/code/{code}
```

**权限**：`dict.manage`

**说明**：前台可用，用于获取字典数据

---

## 支付配置

### 支付配置列表

```http
GET /admin/payment-configs
```

**权限**：`setting.manage`

### 获取支付配置

```http
GET /admin/payment-configs/{type}
```

**权限**：`setting.manage`

**支持类型**：
- `alipay` - 支付宝
- `wechat` - 微信支付
- `balance` - 余额支付

### 更新支付配置

```http
PUT /admin/payment-configs/{type}
```

**权限**：`setting.manage`

**请求参数**（支付宝示例）：
- `app_id`: 应用ID
- `public_key`: 支付宝公钥
- `private_key`: 应用私钥
- `notify_url`: 异步通知地址

### 测试支付配置

```http
POST /admin/payment-configs/{type}/test
```

**权限**：`setting.manage`

**说明**：测试支付配置是否正确

---

## 物流配置

### 物流公司列表

```http
GET /admin/logistics-companies
```

**权限**：`setting.manage`

### 创建物流公司

```http
POST /admin/logistics-companies
```

**权限**：`setting.manage`

**请求参数**：
- `name`: 公司名称
- `code`: 公司编码
- `website`: 官网
- `phone`: 客服电话

### 物流公司详情

```http
GET /admin/logistics-companies/{id}
```

**权限**：`setting.manage`

### 更新物流公司

```http
PUT /admin/logistics-companies/{id}
```

**权限**：`setting.manage`

### 删除物流公司

```http
DELETE /admin/logistics-companies/{id}
```

**权限**：`setting.manage`

### 启用/禁用物流公司

```http
POST /admin/logistics-companies/{id}/toggle-status
```

**权限**：`setting.manage`

---

## 短信配置

### 获取短信配置

```http
GET /admin/sms/config
```

**权限**：`setting.manage`

### 更新短信配置

```http
PUT /admin/sms/config
```

**权限**：`setting.manage`

**请求参数**：
- `provider`: 服务商（aliyun/tencent）
- `access_key`: AccessKey
- `secret_key`: SecretKey
- `sign_name`: 短信签名

---

### 短信模板列表

```http
GET /admin/sms/templates
```

**权限**：`setting.manage`

### 创建短信模板

```http
POST /admin/sms/templates
```

**权限**：`setting.manage`

### 短信模板详情

```http
GET /admin/sms/templates/{id}
```

**权限**：`setting.manage`

### 更新短信模板

```http
PUT /admin/sms/templates/{id}
```

**权限**：`setting.manage`

### 删除短信模板

```http
DELETE /admin/sms/templates/{id}
```

**权限**：`setting.manage`

---

### 短信发送记录

```http
GET /admin/sms/logs
```

**权限**：`setting.manage`

### 测试发送短信

```http
POST /admin/sms/test-send
```

**权限**：`setting.manage`

**请求参数**：
- `mobile`: 手机号
- `template_code`: 模板编码

---

## 邮件配置

### 获取邮件配置

```http
GET /admin/email/config
```

**权限**：`setting.manage`

### 更新邮件配置

```http
PUT /admin/email/config
```

**权限**：`setting.manage`

**请求参数**：
- `driver`: 驱动（smtp/sendmail）
- `host`: SMTP服务器
- `port`: 端口
- `username`: 用户名
- `password`: 密码
- `encryption`: 加密方式（ssl/tls）
- `from_address`: 发件人邮箱
- `from_name`: 发件人名称

---

### 邮件模板列表

```http
GET /admin/email/templates
```

**权限**：`setting.manage`

### 创建邮件模板

```http
POST /admin/email/templates
```

**权限**：`setting.manage`

### 更新邮件模板

```http
PUT /admin/email/templates/{id}
```

**权限**：`setting.manage`

### 删除邮件模板

```http
DELETE /admin/email/templates/{id}
```

**权限**：`setting.manage`

---

### 邮件发送记录

```http
GET /admin/email/logs
```

**权限**：`setting.manage`

### 测试发送邮件

```http
POST /admin/email/test-send
```

**权限**：`setting.manage`

**请求参数**：
- `email`: 收件人邮箱
- `subject`: 主题
- `content`: 内容

---

## 存储配置

### 存储配置列表

```http
GET /admin/storage-configs
```

**权限**：`setting.manage`

### 创建存储配置

```http
POST /admin/storage-configs
```

**权限**：`setting.manage`

**支持类型**：
- `local` - 本地存储
- `oss` - 阿里云OSS
- `qiniu` - 七牛云
- `cos` - 腾讯云COS

### 存储配置详情

```http
GET /admin/storage-configs/{id}
```

**权限**：`setting.manage`

### 更新存储配置

```http
PUT /admin/storage-configs/{id}
```

**权限**：`setting.manage`

### 删除存储配置

```http
DELETE /admin/storage-configs/{id}
```

**权限**：`setting.manage`

---

## 操作日志

### 操作日志列表

```http
GET /admin/operation-logs
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `admin_id`: 管理员ID
- `module`: 模块
- `action`: 操作
- `start_date`: 开始日期
- `end_date`: 结束日期

### 操作日志详情

```http
GET /admin/operation-logs/{id}
```

### 清除操作日志

```http
POST /admin/operation-logs/clear
```

**权限**：`admin.manage`

**说明**：清除历史日志，释放存储空间

