# Apifox 导入与使用指南

## 📋 为什么选择 Apifox？

Apifox = Postman + Swagger + Mock + JMeter

**优势**:
- ✅ 集成了 Postman、Swagger、Mock 的功能
- ✅ 可视化接口设计和文档
- ✅ 自动生成请求代码（支持多语言）
- ✅ 团队协作（免费版支持 5 人）
- ✅ 可导出为 Markdown、HTML 等格式

---

## 🚀 快速开始

### 阶段1: 导入 Postman 集合（1-2天）

#### 步骤1: 导入现有 Postman 集合

1. **下载并安装 Apifox**
   - 官网: [https://apifox.com](https://apifox.com)
   - 支持 Windows、macOS、Linux、Web 版

2. **创建项目**
   - 打开 Apifox
   - 点击 "新建项目"
   - 项目名称: `lilWAN_SHOP02 API`
   - 项目类型: RESTful API

3. **导入 Postman 集合**
   - 点击 "导入" → "Postman"
   - 选择文件: `postman/lilWAN_SHOP02_API.postman_collection.json`
   - 导入成功后，所有接口会自动分类

#### 步骤2: 整理接口分类

建议的目录结构:

```
lilWAN_SHOP02 API
├── 管理后台（路由前缀: /admin）
│   ├── 认证管理（登录、登出、权限）
│   ├── 用户管理（CRUD、列表、详情、标签、分组）
│   ├── 商品管理（CRUD、SKU、规格）
│   ├── 订单管理（列表、详情、状态流转）
│   ├── 营销管理（优惠券、秒杀、拼团、满减）
│   ├── 系统设置（配置、权限、角色、字典）
│   └── 内容管理（文章、页面、广告）
└── 商城移动端（路由前缀: /api/v1）
    ├── 用户认证（注册、登录、登出）
    ├── 商品浏览（列表、搜索、详情）
    ├── 购物车管理
    ├── 订单流程（下单、支付、物流）
    ├── 营销活动（优惠券、秒杀、拼团）
    └── 用户中心（个人信息、收货地址、订单列表）
```

::: warning 重要提示
项目使用两套不同的路由前缀：
- **管理后台**：`/admin/*`（Vue Arco Pro）
- **商城移动端**：`/api/v1/*`（Taro 多端）

在 Apifox 中请分开两个文件夹整理，避免混淆！
:::

#### 步骤3: 补充接口文档

为每个接口补充以下信息:

1. **请求说明**
   - 接口描述
   - 业务场景
   - 权限要求

2. **请求示例**
   - 请求参数说明
   - 字段类型和验证规则
   - 示例值

3. **响应示例**
   - 成功响应（成功、失败）
   - 错误码说明
   - 业务逻辑说明

4. **标记开发状态**
   - ✅ **稳定版**: 功能完整，可直接使用
   - ⚠️ **Beta版**: 功能可用，部分细节待完善
   - 🔧 **开发中**: 接口存在，核心功能未完成
   - 🚫 **计划中**: 接口未实现

---

### 阶段2: 集成 VitePress（可选，7天）

#### 目标: 将 API 文档同步到项目文档站点

#### 方法1: 从 Apifox 导出 Markdown

1. **导出接口文档**
   - 在 Apifox 中选择 "导出" → "Markdown"
   - 选择导出范围（全部/部分模块）
   - 保存到: `lilWAN_SHOP02-docs/docs/api/modules/`

2. **同步到 VitePress**
   ```bash
   # 导出的 Markdown 文件放到对应目录
   lilWAN_SHOP02-docs/docs/api/
   ├── overview.md（API 概览）
   ├── guidelines/（开发指南）
   │   ├── authentication.md（认证说明）
   │   ├── error-handling.md（错误处理）
   │   ├── pagination.md（分页说明）
   │   └── ...
   └── modules/（接口模块）
       ├── product.md（商品接口）
       ├── order.md（订单接口）
       ├── user.md（用户接口）
       └── ...
   ```

3. **配置 VitePress 侧边栏**
   - 已在 `.vitepress/config.js` 中配置
   - 添加新模块时更新侧边栏配置

#### 方法2: 使用 Apifox Web 链接（推荐短期）

1. **发布 API 文档到云端**
   - 在 Apifox 中点击 "分享" → "在线分享"
   - 生成公开访问链接
   - 可设置访问密码

2. **在 VitePress 中嵌入链接**
   - 在 `overview.md` 中添加 Apifox 链接
   - 优点: 实时同步，无需手动导出
   - 缺点: 依赖 Apifox 服务

---

## 🛠️ Apifox 使用技巧

### 1. 环境变量管理

创建多个环境（开发、测试、生产），**注意路由前缀差异**:

```json
// 开发环境 - 管理后台
{
  "base_url": "http://localhost:8081/admin",
  "admin_token": ""
}

// 开发环境 - 商城移动端
{
  "base_url": "http://localhost:8081/api/v1",
  "user_token": ""
}

// 测试环境 - 管理后台
{
  "base_url": "https://test-api.lilwan-shop.com/admin",
  "admin_token": ""
}

// 测试环境 - 商城移动端
{
  "base_url": "https://test-api.lilwan-shop.com/api/v1",
  "user_token": ""
}
```

::: tip 建议
在 Apifox 中创建两个环境分组：
- **管理后台环境**（使用 `/admin` 前缀）
- **商城移动端环境**（使用 `/api/v1` 前缀）

这样可以快速切换不同端的接口调试。
:::

### 2. 自动化 Token 管理

在登录接口的 "后置操作" 中添加脚本:

```javascript
// 自动保存 token 到环境变量
const res = pm.response.json();
if (res.code === 0) {
  pm.environment.set("token", res.data.token);
  console.log("Token 已自动保存:", res.data.token);
}
```

在其他接口的 "前置操作" 中:

```javascript
// 自动从环境变量读取 token
const token = pm.environment.get("token");
pm.request.headers.add({
  key: "Authorization",
  value: `Bearer ${token}`
});
```

### 3. Mock 数据

为接口添加 Mock 规则:

```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "id": "@integer(1, 10000)",
    "name": "@cname",
    "mobile": "@phone",
    "email": "@email",
    "created_at": "@datetime"
  }
}
```

### 4. 接口测试用例

为关键接口创建测试用例:

```javascript
// 测试用例示例
pm.test("状态码为 200", function () {
  pm.response.to.have.status(200);
});

pm.test("返回数据格式正确", function () {
  const res = pm.response.json();
  pm.expect(res).to.have.property('code');
  pm.expect(res).to.have.property('message');
  pm.expect(res).to.have.property('data');
});

pm.test("业务逻辑正确", function () {
  const res = pm.response.json();
  pm.expect(res.code).to.equal(0);
});
```

---

## 📝 文档化策略

### 方案A: 全部文档化（推荐 ⭐⭐⭐⭐⭐）

**做法**:
1. 将所有接口简要文档化
2. 用状态标签标注开发状态

**标签体系**:
- ✅ **稳定版** - 可直接使用
- ⚠️ **Beta版** - 接口可用，但追求细节待完善（当前行为：立即标记为成功，不真正追款）
- 🔧 **开发中** - 接口存在，"功能开发中"提示
- 🚫 **计划中** - 接口未实现

**优点**:
- ✅ 前端能够看到完整的 API 全貌
- ✅ 明确哪些功能可用，哪些待完善
- ✅ 避免前端重复复询问

**示例文档**:

```markdown
## 商品列表

**✅ 稳定版** - 可直接使用

GET /api/v1/products?page=1&per_page=15

## 订单退款

**⚠️ Beta版** - 接口可用，但退款逻辑尚未对接支付网关

当前行为：立即标记为成功，不真正退款

POST /api/v1/orders/{id}/refund

## 结算下单

**🔧  开发中** - 功能开发中"提示

POST /api/v1/orders

## 拼团活动

**🚫 计划中** - 接口未实现

GET /api/v1/group-buy/activities
```

---

## ✅ 检查清单

### Apifox 整理完成标准:

- [ ] 所有接口已导入并分类
- [ ] 每个接口都有请求参数说明
- [ ] 每个接口都有响应示例（成功/失败）
- [ ] 关键接口标注了错误码
- [ ] 使用状态标签标注开发进度
- [ ] 配置了环境变量（开发/测试/生产）
- [ ] 登录接口配置了自动保存 Token 脚本

### VitePress 同步完成标准:

- [ ] API 概览文档已创建
- [ ] 开发指南文档已完善（认证、错误处理、分页）
- [ ] 模块接口文档已从 Apifox 导出
- [ ] VitePress 侧边栏配置正确
- [ ] 文档可本地预览无误
- [ ] （可选）文档已部署到线上

---

## 🔧 常见问题

### Q1: Apifox 导入 Postman 集合失败？

**A**: 
- 确保 Postman 集合格式正确（v2.1.0）
- 尝试先在 Postman 中导出最新版本
- 检查 JSON 文件是否有语法错误

### Q2: 如何团队协作？

**A**: 
- Apifox 云端版支持团队协作（免费版 5 人）
- 邀请团队成员加入项目
- 实时同步接口变更

### Q3: 如何导出 Markdown？

**A**: 
- 选择模块 → 右键 → "导出" → "Markdown"
- 选择导出范围和格式
- 保存到 VitePress 对应目录

### Q4: 导出的 Markdown 格式不理想？

**A**: 
- Apifox 导出的 Markdown 可能需要手动调整
- 建议先导出一个接口，测试格式
- 根据 VitePress 样式调整 Markdown 结构

---

## 📚 参考资源

- **Apifox 官网**: [https://apifox.com](https://apifox.com)
- **Apifox 文档**: [https://apifox.com/help](https://apifox.com/help)
- **Postman 集合位置**: `postman/lilWAN_SHOP02_API.postman_collection.json`
- **VitePress 文档目录**: `lilWAN_SHOP02-docs/docs/api/`

---

::: tip 建议
优先使用 Apifox 整理接口文档，VitePress 集成可以后续渐进式完善。重要的是让团队能够快速查看和调试接口。
:::

