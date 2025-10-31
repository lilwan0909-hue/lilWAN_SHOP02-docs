# API 文档

欢迎来到 lilWAN_SHOP02 API 文档中心！

## 📚 文档导航

### 🎯 快速入门

- [接口规范总览](./overview.md) - API 基础信息、响应结构、认证机制
- [Apifox 导入与使用指南](./apifox-guide.md) - 如何使用 Apifox 管理接口文档

### 📖 开发指南

- [认证说明](./guidelines/authentication.md) - Token 认证流程与安全实践
- [错误处理规范](./guidelines/error-handling.md) - 统一错误响应格式
- [常见错误码使用指南](./guidelines/error-codes.md) - 完整错误码列表与使用示例
- [前端错误提示规范](./guidelines/frontend-errors.md) - 前端错误提示设计原则
- [分页说明](./guidelines/pagination.md) - 分页参数与响应格式

### 🔌 接口模块

- [认证管理](./modules/authentication.md) - 注册、登录、登出
- [用户管理](./modules/user.md) - 用户信息、收货地址
- [商品管理](./modules/product.md) - 商品浏览、详情、规格
- [订单管理](./modules/order.md) - 下单、支付、物流
- [营销管理](./modules/marketing.md) - 优惠券、满减、秒杀

---

## 🚨 重要说明：路由前缀差异

本项目 API 分为两个部分，使用**不同的路由前缀**：

### 1. 管理后台 API

**路由前缀**：`/admin`

```bash
# 管理员登录
POST /admin/auth/login

# 商品管理
GET /admin/products
POST /admin/products

# 订单管理
GET /admin/orders
GET /admin/orders/{id}
```

- **使用端**：Vue Arco Pro 管理后台
- **认证方式**：Bearer Token（Laravel Sanctum）
- **权限控制**：基于角色和权限（RBAC）

### 2. 商城 API（移动端）

**路由前缀**：`/api/v1`

```bash
# 用户认证
POST /api/v1/auth/login
POST /api/v1/auth/register

# 商品浏览
GET /api/v1/products
GET /api/v1/products/{id}

# 订单管理
POST /api/v1/orders
GET /api/v1/orders/{id}
```

- **使用端**：Taro 多端应用（H5/微信小程序/支付宝小程序/APP）
- **认证方式**：Bearer Token（Laravel Sanctum）
- **权限控制**：基于用户身份

::: warning 特别注意
两套 API 使用相同的认证机制（Bearer Token），但路由前缀和权限体系完全不同！
- 管理后台：`/admin/*` + RBAC 权限
- 商城移动端：`/api/v1/*` + 用户身份验证

在 Apifox 中调试时，请注意切换正确的环境变量！
:::

---

## 🚀 使用 Apifox 调试接口

### 推荐工作流程

1. **导入 Postman 集合到 Apifox**
   - 文件位置：`postman/lilWAN_SHOP02_API.postman_collection.json`
   - 参考：[Apifox 导入与使用指南](./apifox-guide.md)

2. **配置环境变量**（根据调试端选择）
   
   **管理后台环境**：
   ```json
   {
     "base_url": "http://localhost:8081/admin",
     "admin_token": ""
   }
   ```
   
   **商城移动端环境**：
   ```json
   {
     "base_url": "http://localhost:8081/api/v1",
     "user_token": ""
   }
   ```

3. **登录获取 Token**
   - 管理后台：调用 `POST /admin/auth/login`
   - 商城移动端：调用 `POST /api/v1/auth/login`
   - Apifox 会自动保存 token 到环境变量

4. **调试其他接口**
   - Token 会自动注入到请求头

---

## 📝 文档维护

### 当前状态（2025-10-31）

- ✅ **开发指南文档**：已完成 6 篇核心文档
- ⏳ **模块接口文档**：占位文件已创建，待从 Apifox 导出补充
- ✅ **VitePress 配置**：侧边栏和导航已配置完成

### 下一步计划

1. **短期（1周内）**
   - 导入 Postman 集合到 Apifox
   - 整理接口分类和文档
   - 为每个接口添加请求示例和响应说明

2. **中期（2周内）**
   - 从 Apifox 导出 Markdown
   - 补充到 VitePress 模块文档
   - 完善接口参数和错误码说明

3. **长期（可选）**
   - 部署 VitePress 文档到线上
   - 集成 CI/CD 自动更新文档

---

## 🛠️ 本地预览

启动 VitePress 开发服务器：

```bash
cd /home/lilwan/projects/lilWAN_SHOP02-docs
npm run docs:dev
```

访问：`http://localhost:5173/lilWAN_SHOP02-docs/docs/api/overview`

---

## 📞 反馈与支持

- **GitHub Issues**: 提交问题和建议
- **技术支持**: support@lilwan-shop.com
- **文档维护**: lilWAN Development Team

---

::: tip 提示
本文档与项目代码同步更新。建议收藏 [API 概览](./overview.md) 页面作为快速参考入口。
:::

