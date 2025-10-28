# 营销插件开发文档

> lilWAN Shop 营销插件系统完整开发文档

[![Documentation](https://img.shields.io/badge/docs-VitePress-3eaf7c.svg)](https://vitepress.dev/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## 📚 在线文档

访问在线文档：**[https://lilwan0909-hue.github.io/lilWAN_SHOP02-docs/](https://lilwan0909-hue.github.io/lilWAN_SHOP02-docs/)**

## ✨ 特性

- 🚀 **极速开发** - 5分钟创建插件，30分钟完成开发
- 🔌 **即插即用** - 热插拔设计，上传即可启用
- 🎯 **TCALS引擎** - 强大的规则引擎
- 📦 **完整生态** - 模板、示例、文档、工具

## 🎯 快速开始

### CLI生成插件

```bash
php artisan marketing:make-plugin my-discount \
  --name="我的折扣" \
  --type=discount \
  --step=2
```

### 实现插件逻辑

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

## 📖 文档结构

- **入门指南**
  - 快速开始
  - 插件结构
  
- **核心概念**
  - TCALS配置详解
  - 插件接口文档
  - 数据库迁移
  - 前端开发
  
- **示例插件**
  - 简单折扣（⭐ 简单）
  - 生日优惠券（⭐⭐⭐ 中等）
  - 限时秒杀（⭐⭐⭐⭐⭐ 复杂）

## 🛠️ 本地开发

### 安装依赖

```bash
npm install
```

### 启动开发服务器

```bash
npm run docs:dev
```

访问 http://localhost:5173

### 构建生产版本

```bash
npm run docs:build
```

## 📦 示例插件

完整的示例插件代码位于 `resources/plugin-examples/` 目录：

- **simple-discount** - 全场9折优惠（~120行）
- **birthday-coupon** - 生日月专享优惠券（~250行）

## 🤝 贡献

欢迎贡献文档和示例！

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 开启 Pull Request

## 📄 许可证

本文档采用 [MIT](LICENSE) 许可证。

## 🔗 相关链接

- [VitePress](https://vitepress.dev/) - 文档框架
- [问题反馈](https://github.com/lilwan0909-hue/lilWAN_SHOP02-docs/issues)

---

**维护团队**: lilWAN Development Team  
**最后更新**: 2025-10-28
