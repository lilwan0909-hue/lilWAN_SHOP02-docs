# 文档开发指南

本文档使用 VitePress 构建。

## 本地开发

### 安装依赖

```bash
cd docs
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

构建产物位于 `.vitepress/dist/`

### 预览生产版本

```bash
npm run docs:preview
```

## 部署到GitHub Pages

### 自动部署

推送到 `main` 分支后，GitHub Actions 会自动构建并部署文档。

### 手动部署

1. 构建文档
```bash
npm run docs:build
```

2. 进入构建产物目录
```bash
cd .vitepress/dist
```

3. 初始化git并推送到gh-pages分支
```bash
git init
git add -A
git commit -m 'deploy'
git push -f git@github.com:用户名/仓库名.git main:gh-pages
```

## 配置GitHub Pages

1. 进入仓库设置
2. 左侧菜单选择 "Pages"
3. Source 选择 "GitHub Actions"
4. 保存

## 文档结构

```
docs/
├── .vitepress/
│   ├── config.js          # VitePress配置
│   └── dist/              # 构建产物（忽略）
├── plugin-development/    # 插件开发文档
│   ├── README.md
│   ├── 01-快速开始.md
│   ├── 03-TCALS配置.md
│   └── 04-插件接口.md
├── examples/              # 示例插件
│   ├── index.md
│   ├── simple-discount.md
│   └── birthday-coupon.md
├── index.md               # 首页
├── package.json
└── README-DEV.md          # 本文件
```

## 编写文档

### Markdown 支持

VitePress 支持扩展的 Markdown 语法：

- 代码块高亮
- 自定义容器（tip, warning, danger等）
- 行号显示
- 代码组
- 导入代码片段

### 示例

#### 提示框

```md
::: tip 提示
这是一个提示
:::

::: warning 警告
这是一个警告
:::

::: danger 危险
这是一个危险提示
:::
```

#### 代码块

````md
```php{2,4-6}
<?php

class Plugin implements MarketingPluginInterface
{
    public function getCode(): string
    {
        return 'my-plugin';
    }
}
```
````

## 配置说明

### base路径

在 `.vitepress/config.js` 中配置：

```js
export default defineConfig({
  base: '/仓库名/',  // GitHub Pages部署时需要设置
  // ...
})
```

### 侧边栏

在 `.vitepress/config.js` 的 `themeConfig.sidebar` 中配置。

### 导航栏

在 `.vitepress/config.js` 的 `themeConfig.nav` 中配置。

## 常见问题

### Q: 本地开发时样式不正常？

A: 检查 base 配置，本地开发时可以设置为 `/`。

### Q: 部署后404？

A: 检查 base 配置是否与仓库名匹配。

### Q: 图片无法显示？

A: 图片应放在 `docs/public/` 目录下，引用时使用 `/image.png`。

## 更多信息

- [VitePress 官方文档](https://vitepress.dev/)
- [GitHub Pages 文档](https://docs.github.com/pages)

