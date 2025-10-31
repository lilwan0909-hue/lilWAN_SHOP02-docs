---
layout: home

hero:
  name: lilWAN_SHOP02
  text: 现代化 B2C 自营电商平台开发文档
  tagline: Laravel + Vue + Taro 全栈解决方案
  actions:
    - theme: brand
      text: 插件开发指南
      link: /plugin-development/01-快速开始
    - theme: brand
      text: API 文档
      link: /docs/api/overview
    - theme: alt
      text: 查看示例
      link: /examples/
  image:
    src: /hero-image.svg
    alt: lilWAN_SHOP02 电商系统

features:
  - icon: 🏗️
    title: 现代化架构
    details: 后端 Laravel API + PC 端 Blade SSR + 管理后台 Vue Arco Pro + 移动端 Taro 多端
  - icon: 🔌
    title: 插件化营销
    details: TCALS 规则引擎，支持优惠券、秒杀、拼团、满减等营销活动热插拔
  - icon: 📱
    title: 多端支持
    details: Taro 一次编码，编译为 H5、微信小程序、支付宝小程序、APP 等多端应用
  - icon: 🎨
    title: 主题系统
    details: PC 端 Blade 主题包，移动端动态组件加载，主题可热插拔
  - icon: 🛡️
    title: 统一 API 规范
    details: 标准响应格式、错误码体系、认证机制、分页规范，前后端完全同步
  - icon: 📚
    title: 完整文档
    details: 插件开发指南、API 接口文档、开发规范、最佳实践，覆盖全流程
---

## 文档导航

### 📖 插件开发

构建强大的营销功能插件：

- [快速开始](/plugin-development/01-快速开始) - 5 分钟生成插件骨架
- [TCALS 配置](/plugin-development/03-TCALS配置) - 规则引擎详解
- [插件接口](/plugin-development/04-插件接口) - 核心接口说明
- [示例插件](/examples/) - 从简单到复杂的实战案例

### 🔌 API 接口

完整的 API 开发规范：

- [API 概览](/docs/api/overview) - 接口基础信息、响应结构
- [认证说明](/docs/api/guidelines/authentication) - Token 认证机制
- [错误处理规范](/docs/api/guidelines/error-handling) - 统一错误响应
- [Apifox 导入指南](/docs/api/apifox-guide) - 接口文档管理

### 🎯 项目特色

#### 🏗️ 四端架构

- **后端 API**：Laravel 11.32 + MySQL 8.0.35+
- **PC 前台**：Blade SSR + Bootstrap 5.3.3
- **管理后台**：Vue 3 + Arco Design Pro + Vite 5.x
- **移动端**：Taro 4.0.8 + NutUI 4.3.19（H5/小程序/APP）

#### 🚀 核心特性

- **插件化营销引擎**：TCALS 模型，支持触发器、条件、动作、限制、结算
- **动态菜单系统**：零路由配置，菜单基于数据库动态生成
- **SPU/SKU 商品体系**：标准商品、虚拟商品、服务商品支持
- **主题系统**：PC 端 Blade 主题包，移动端动态组件加载

## API 路由说明

### 管理后台 API

**路由前缀**：`/admin`

```bash
# 管理员登录
POST /admin/auth/login

# 商品管理
GET /admin/products
POST /admin/products
PUT /admin/products/{id}

# 订单管理
GET /admin/orders
GET /admin/orders/{id}
```

**认证方式**：Bearer Token（Laravel Sanctum）  
**使用端**：Vue Arco Pro 管理后台

### 商城 API（移动端 + H5）

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

**认证方式**：Bearer Token（Laravel Sanctum）  
**使用端**：Taro 多端应用（H5/小程序/APP）

---

## 快速示例

### 开发营销插件

```bash
# 1. 生成插件骨架
php artisan marketing:make-plugin my-discount \
  --name="我的折扣" \
  --type=discount

# 2. 编辑插件逻辑
cd storage/app/plugins/my-discount
vim src/Plugin.php

# 3. 打包上传到管理后台
zip -r my-discount.zip .
```

### 调用商城 API

```typescript
// Taro 移动端调用
import Taro from '@tarojs/taro';

const res = await Taro.request({
  url: 'https://api.yourdomain.com/api/v1/products',
  method: 'GET',
  header: {
    Authorization: `Bearer ${token}`
  }
});
```

## 技术栈

<div class="tech-stack">
  <div class="tech-item">
    <strong>后端</strong>
    <ul>
      <li>PHP 8.3+</li>
      <li>Laravel 11.32</li>
      <li>MySQL 8.0.35+</li>
    </ul>
  </div>
  
  <div class="tech-item">
    <strong>前端</strong>
    <ul>
      <li>Vue 3.5+</li>
      <li>Vite 5.x</li>
      <li>Arco Design Pro</li>
    </ul>
  </div>
  
  <div class="tech-item">
    <strong>工具</strong>
    <ul>
      <li>CLI脚手架</li>
      <li>插件模板</li>
      <li>Apifox/Postman</li>
    </ul>
  </div>
</div>

<style>
.examples-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1rem;
  margin: 2rem 0;
}

.example-card {
  border: 1px solid var(--vp-c-divider);
  border-radius: 8px;
  padding: 1.5rem;
  text-decoration: none;
  transition: all 0.3s;
}

.example-card:hover {
  border-color: var(--vp-c-brand);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.example-card h3 {
  margin: 0 0 0.5rem 0;
  color: var(--vp-c-text-1);
}

.example-card p {
  margin: 0 0 1rem 0;
  color: var(--vp-c-text-2);
  font-size: 0.9rem;
}

.example-card .tag {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  background: var(--vp-c-brand-soft);
  color: var(--vp-c-brand);
  border-radius: 4px;
  font-size: 0.85rem;
}

.tech-stack {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
  margin: 2rem 0;
}

.tech-item strong {
  display: block;
  margin-bottom: 0.5rem;
  color: var(--vp-c-brand);
}

.tech-item ul {
  margin: 0;
  padding-left: 1.5rem;
}

.tech-item li {
  margin: 0.25rem 0;
}
</style>

