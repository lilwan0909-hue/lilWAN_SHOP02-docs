# 营销插件示例库

本目录包含完整的营销插件示例，帮助开发者快速上手插件开发。

## 示例列表

### 1. 简单折扣（⭐ 简单）

**目录**: `simple-discount/`

**功能**: 全场9折优惠，订单满50元即可享受

**复杂度**: ⭐ 简单

**代码量**: ~120行

**学习要点**:
- 实现基本的插件接口
- 使用PricingContext
- 简单的条件判断
- 折扣金额计算

**适合人群**: 新手开发者

**文件结构**:
```
simple-discount/
├── plugin.json
├── tcals.json
├── src/Plugin.php
└── README.md
```

---

### 2. 生日优惠券（⭐⭐⭐ 中等）

**目录**: `birthday-coupon/`

**功能**: 用户生日月份享受20元优惠券，每月限用1次

**复杂度**: ⭐⭐⭐ 中等

**代码量**: ~250行

**学习要点**:
- 数据库查询和操作
- 用户身份验证
- 日期处理（生日月份判断）
- 使用记录管理
- 错误处理

**适合人群**: 有一定经验的开发者

**文件结构**:
```
birthday-coupon/
├── plugin.json
├── tcals.json
├── permissions.json
├── src/Plugin.php
├── migrations/
│   ├── 001_create_usage_table.sql
│   └── rollback/
└── README.md
```

**数据库**: 需要 `plugin_birthday_coupon_usage` 表

---

### 3. 限时秒杀（⭐⭐⭐⭐⭐ 复杂）

**目录**: `flash-sale/`

**状态**: 待补充

**功能**: 
- 限时特价
- 库存管理
- 并发控制
- 前端管理界面

**复杂度**: ⭐⭐⭐⭐⭐ 复杂

**预估代码量**: ~500行

**学习要点**:
- 高并发处理
- Redis缓存
- 事务和锁
- 前端Vue组件
- Hook事件

**适合人群**: 高级开发者

---

## 使用指南

### 快速开始

#### 1. 选择合适的示例

- **新手**: 从 `simple-discount` 开始
- **进阶**: 学习 `birthday-coupon`
- **高级**: 研究 `flash-sale`（待补充）

#### 2. 查看README

每个示例都有详细的README文档：
- 功能说明
- 学习要点
- 代码解析
- 测试指南
- 扩展思路

#### 3. 安装测试

```bash
# 进入示例目录
cd resources/plugin-examples/simple-discount

# 打包
zip -r simple-discount.zip . -x ".DS_Store"

# 上传到后台测试
```

---

## 学习路径

### 阶段一：基础（1-2小时）

**学习目标**: 掌握插件基本结构和接口

**推荐示例**: `simple-discount`

**学习内容**:
1. 插件文件结构
2. MarketingPluginInterface接口
3. PricingContext使用
4. 基础折扣计算

**练习任务**:
- 修改折扣比例（8折、7.5折）
- 调整最低消费金额
- 添加用户等级限制

---

### 阶段二：进阶（3-4小时）

**学习目标**: 掌握数据库操作和复杂逻辑

**推荐示例**: `birthday-coupon`

**学习内容**:
1. 数据库迁移
2. 数据库查询和插入
3. 日期时间处理
4. 权限配置
5. 错误处理

**练习任务**:
- 添加使用统计功能
- 实现手动发放功能
- 添加生日提醒通知

---

### 阶段三：高级（1-2天）

**学习目标**: 掌握复杂业务和高并发

**推荐示例**: `flash-sale`（待补充）

**学习内容**:
1. 高并发处理
2. Redis缓存
3. 分布式锁
4. 前端动态加载
5. Hook事件系统

**练习任务**:
- 实现秒杀抢购
- 优化并发性能
- 添加监控告警

---

## 代码对比

### 简单 vs 中等 vs 复杂

| 特性 | 简单 | 中等 | 复杂 |
|-----|------|------|------|
| **文件数** | 4 | 7 | 15+ |
| **代码量** | ~120行 | ~250行 | ~500行 |
| **数据库** | 无 | 1表 | 3+表 |
| **前端** | 无 | 无 | Vue组件 |
| **权限** | 无 | 基础 | 完整 |
| **测试** | 基础 | 中等 | 完整 |

---

## 常见问题

### Q1: 示例可以直接用于生产环境吗？

**A**: 不建议。示例代码是为了教学目的，生产环境需要：
- 完善的错误处理
- 完整的测试覆盖
- 性能优化
- 安全加固

### Q2: 如何修改示例代码？

**A**: 
1. 复制示例到新目录
2. 修改 `plugin.json` 中的 code 和 name
3. 修改插件类的命名空间
4. 实现你的业务逻辑

### Q3: 示例之间可以组合吗？

**A**: 可以。插件系统支持多个插件同时工作，参考：
- `getStackingRule()`: 设置叠加规则
- `getMutuallyExclusivePlugins()`: 设置互斥插件

### Q4: 如何调试示例代码？

**A**: 
```php
use Illuminate\Support\Facades\Log;

Log::info('Debug info', [
    'context' => $context->toArray(),
    'result' => $result,
]);
```

查看日志：`storage/logs/laravel.log`

---

## 获取帮助

### 📚 文档
- [快速开始](../../docs/plugin-development/01-快速开始.md)
- [TCALS配置](../../docs/plugin-development/03-TCALS配置.md)
- [插件接口](../../docs/plugin-development/04-插件接口.md)

### 🔧 工具
- CLI脚手架：`php artisan marketing:make-plugin`
- 插件模板：`resources/plugin-templates/`

### 💬 社区
- GitHub Issues
- 开发者论坛

---

## 贡献指南

欢迎贡献新的示例插件！

**要求**:
1. 代码符合规范
2. 包含完整的README
3. 代码有详细注释
4. 提供测试用例

---

**版本**: v1.0  
**最后更新**: 2025-10-28  
**维护团队**: lilWAN Development Team

