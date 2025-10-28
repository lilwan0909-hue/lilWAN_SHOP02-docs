# 营销插件开发文档

欢迎使用营销插件开发文档！本文档将帮助您快速上手插件开发。

## 快速导航

### 🚀 入门指南
- [快速开始](./01-快速开始.md) - 5分钟创建第一个插件
- [插件结构](./02-插件结构.md) - 了解插件目录结构
- [TCALS配置](./03-TCALS配置.md) - 掌握规则配置

### 📚 核心概念
- [插件接口](./04-插件接口.md) - 必须实现的接口
- [数据库迁移](./05-数据库迁移.md) - 管理插件数据库
- [前端开发](./06-前端开发.md) - 创建管理页面
- [权限系统](./07-权限系统.md) - 配置权限控制
- [Hook事件](./08-Hook事件.md) - 使用生命周期钩子

### 🔧 开发指南
- [测试指南](./09-测试指南.md) - 编写单元测试
- [发布上线](./10-发布上线.md) - 打包和发布插件
- [最佳实践](./11-最佳实践.md) - 编码规范和技巧
- [FAQ](./12-FAQ.md) - 常见问题解答

---

## 什么是营销插件？

营销插件是一种**可热插拔的营销功能模块**，用于实现各种促销活动：

- ✅ **优惠券系统**
- ✅ **满减满折**
- ✅ **第N件折扣**
- ✅ **会员折扣**
- ✅ **积分抵扣**
- ✅ **限时秒杀**
- ✅ 更多自定义营销...

---

## 核心特性

### 🔌 即插即用
- 无需修改核心代码
- 上传即可启用
- 禁用不影响系统

### 🎯 TCALS规则引擎
- **Trigger**: 触发器（何时触发）
- **Condition**: 条件（满足什么条件）
- **Action**: 动作（执行什么操作）
- **Limit**: 限制（有什么限制）
- **Settlement**: 结算（在哪个步骤）

### 🚀 CLI脚手架
```bash
php artisan marketing:make-plugin my-plugin --with-frontend
```
5分钟生成完整插件骨架！

### 📦 完整生态
- 插件模板（简单/中等/复杂）
- 示例插件库
- 完整开发文档
- 测试工具

---

## 快速开始

### 1. 生成插件

```bash
php artisan marketing:make-plugin my-discount \
  --name="我的折扣" \
  --type=discount \
  --step=2
```

### 2. 编辑逻辑

编辑 `storage/app/plugins/my-discount/src/Plugin.php`：

```php
public function calculate(PricingContext $context): array
{
    $discountAmount = $context->currentAmount * 0.1; // 10%折扣
    
    return [
        'discount_amount' => $discountAmount,
        'items' => [],
        'metadata' => ['rate' => 0.1],
    ];
}
```

### 3. 打包上传

```bash
cd storage/app/plugins/my-discount
zip -r my-discount.zip .
```

上传到后台：营销管理 -> 插件管理 -> 上传插件

### 4. 启用测试

启用插件后，创建订单测试折扣是否生效。

详细步骤请查看：[快速开始](./01-快速开始.md)

---

## 插件结构

```
my-plugin/
├── plugin.json          # 插件元数据 ⭐
├── tcals.json           # TCALS规则配置 ⭐
├── permissions.json     # 权限配置（可选）
├── menus.json           # 菜单配置（可选）
├── config.json          # 插件配置（可选）
├── src/
│   └── Plugin.php       # 插件主类 ⭐
├── migrations/          # 数据库迁移（可选）
│   ├── 001_create_table.sql
│   └── rollback/
│       └── 001_drop_table.sql
├── frontend/            # 前端代码（可选）
│   ├── src/
│   └── package.json
└── README.md            # 说明文档
```

详细说明请查看：[插件结构](./02-插件结构.md)

---

## 菜单配置 (menus.json)

### 基本格式

```json
{
  "menus": [
    {
      "name": "my-plugin-management",
      "title": "我的插件",
      "path": "/marketing/my-plugin",
      "icon": "icon-gift",
      "component": "marketing/my-plugin",
      "sort": 100,
      "permission": "plugin:my-plugin:view"
    }
  ]
}
```

### 字段说明

| 字段 | 类型 | 必填 | 说明 |
|------|------|------|------|
| `name` | string | ✅ | 菜单唯一标识（通常为 `{插件代码}-management`） |
| `title` | string | ✅ | 菜单显示名称 |
| `path` | string | ✅ | 路由路径（格式：`/marketing/{插件代码}`） |
| `icon` | string | ❌ | 菜单图标（Arco Design 图标名称，如 `icon-gift`） |
| `component` | string | ✅ | **组件路径（格式：`marketing/{插件代码}`）** ⚠️ 重要 |
| `sort` | number | ❌ | 排序权重（数字越大越靠后，默认100） |
| `permission` | string | ❌ | 权限标识（格式：`plugin:{插件代码}:view`） |

### ⚠️ 重要提示

**component 字段格式**：
- ✅ **正确格式**：`marketing/{插件代码}`
- ❌ **错误格式**：`plugin:{插件代码}/views/index` （旧版本错误格式）

**示例对比**：
```json
// ✅ 正确
{
  "component": "marketing/birthday-coupon"
}

// ❌ 错误
{
  "component": "plugin:birthday-coupon/views/index"
}
```

### 菜单层级

支持二级菜单（可选）：

```json
{
  "menus": [
    {
      "title": "生日券管理",
      "path": "/marketing/birthday-coupon",
      "component": "marketing/birthday-coupon",
      "icon": "icon-gift",
      "order": 10,
      "children": [
        {
          "title": "发券记录",
          "path": "/marketing/birthday-coupon/records",
          "component": "marketing/birthday-coupon/records",
          "order": 1
        },
        {
          "title": "统计分析",
          "path": "/marketing/birthday-coupon/statistics",
          "component": "marketing/birthday-coupon/statistics",
          "order": 2
        }
      ]
    }
  ]
}
```

### 菜单显示规则

1. **插件启用时**：菜单自动显示在左侧导航栏
2. **插件禁用时**：菜单自动隐藏
3. **权限控制**：如果配置了 `permission` 字段，用户必须有相应权限才能看到菜单

### 安装流程

插件上传后，系统会自动：
1. 读取 `menus.json` 文件
2. 在数据库中创建菜单记录
3. 设置 `plugin_code` 关联到当前插件
4. 根据插件状态动态显示/隐藏菜单

### 常见问题

**Q1: 插件启用后菜单不显示？**

检查以下几点：
1. `menus.json` 文件是否存在
2. `component` 字段格式是否正确（使用 `marketing/{插件代码}` 格式）
3. 插件的 `is_system` 字段是否为 1
4. 清除浏览器缓存后刷新页面

**Q2: 如何修改菜单图标？**

修改 `icon` 字段，使用 Arco Design 图标名称，例如：
- `icon-gift`：礼物图标
- `icon-tag`：标签图标
- `icon-fire`：火焰图标
- `icon-star`：星星图标

**Q3: 菜单支持多少级？**

目前支持最多二级菜单（一个父菜单 + 多个子菜单）。

---

## TCALS配置示例

```json
{
  "trigger": {
    "type": "checkout"
  },
  "conditions": {
    "logic": "AND",
    "rules": [
      {
        "type": "order_amount",
        "min_amount": 100
      }
    ]
  },
  "action": {
    "type": "discount_fixed",
    "value": 20
  },
  "limits": [
    {
      "type": "user_usage",
      "max_per_user": 3
    }
  ],
  "settlement": {
    "step": 2,
    "stacking_rule": "stack",
    "mutex_with": []
  }
}
```

**含义**: 结算时，订单≥100元，减20元，每人限3次，商品级优惠

详细说明请查看：[TCALS配置](./03-TCALS配置.md)

---

## 示例插件

### 简单示例（⭐）
- **全场9折**: 基础折扣功能
- **代码量**: ~50行
- **复杂度**: 适合新手

### 中等示例（⭐⭐⭐）
- **生日优惠券**: 包含数据库和权限
- **代码量**: ~200行
- **复杂度**: 适合进阶

### 复杂示例（⭐⭐⭐⭐⭐）
- **限时秒杀**: 完整的秒杀系统
- **代码量**: ~500行
- **复杂度**: 高级开发者

示例代码位置：`storage/app/plugin-templates/`

---

## 开发者体验目标

### 新手开发者
- ⏱️ **5分钟**: 生成插件脚手架
- ⏱️ **30分钟**: 完成第一个简单插件
- ⏱️ **2小时**: 理解完整开发流程

### 熟练开发者
- ⏱️ **1小时**: 开发中等复杂度插件
- ⏱️ **半天**: 开发复杂插件

---

## 技术栈

### 后端
- PHP 8.3+
- Laravel 11.32
- MySQL 8.0.35+

### 前端（可选）
- Vue 3.5+
- Vite 5.x
- Element Plus

### 工具
- CLI脚手架
- 插件模板
- 测试工具

---

## 获取帮助

### 📖 文档
- [完整开发文档](./README.md)
- [API参考](./04-插件接口.md)
- [最佳实践](./11-最佳实践.md)

### 🐛 问题反馈
- GitHub Issues
- 技术支持邮箱

### 💬 社区
- 开发者论坛
- 技术交流群

---

## 许可证

本文档采用 MIT 许可证。

---

**版本**: v1.0  
**最后更新**: 2025-10-28  
**维护团队**: lilWAN Development Team

