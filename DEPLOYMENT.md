# 部署指南

本文档说明如何将文档部署到GitHub Pages。

## 一、创建GitHub仓库

### 1.1 在GitHub上创建新仓库

1. 登录 [GitHub](https://github.com/)
2. 点击右上角 **+** → **New repository**
3. 填写仓库信息：
   - **Repository name**: `lilWAN_SHOP02-docs`
   - **Description**: 营销插件开发文档
   - **Visibility**: **Public**（必须为公开才能使用免费的GitHub Pages）
4. **不要**勾选 `Add a README file`（我们已经有了）
5. 点击 **Create repository**

### 1.2 连接本地仓库

复制GitHub显示的远程仓库URL（SSH或HTTPS），然后执行：

```bash
cd /tmp/lilWAN_SHOP02-docs
git remote add origin git@github.com:lilwan0909-hue/lilWAN_SHOP02-docs.git
# 或者使用HTTPS
# git remote add origin https://github.com/lilwan0909-hue/lilWAN_SHOP02-docs.git
```

### 1.3 推送代码

```bash
git push -u origin main
```

## 二、配置GitHub Pages

### 2.1 启用GitHub Actions

1. 进入你的仓库页面
2. 点击 **Settings** → **Actions** → **General**
3. 找到 **Workflow permissions**
4. 选择 **Read and write permissions**
5. 勾选 **Allow GitHub Actions to create and approve pull requests**
6. 点击 **Save**

### 2.2 配置Pages

1. 在仓库页面点击 **Settings** → **Pages**
2. **Source** 选择 **GitHub Actions**（如果看不到这个选项，说明Actions workflow还没运行）
3. 等待几分钟，Actions会自动构建并部署

### 2.3 查看部署状态

1. 点击仓库页面的 **Actions** 标签
2. 你会看到一个名为 `Deploy VitePress site to GitHub Pages` 的workflow
3. 等待构建完成（绿色✓）

### 2.4 访问文档

部署成功后，访问：

```
https://your-username.github.io/lilWAN_SHOP02-docs/
```

## 三、更新文档

每次推送到`main`分支时，GitHub Actions会自动重新构建和部署：

```bash
cd /tmp/lilWAN_SHOP02-docs
git add .
git commit -m "docs: 更新文档"
git push
```

等待1-2分钟后，新内容就会上线。

## 四、自定义域名（可选）

### 4.1 配置DNS

如果你有自己的域名（如`docs.example.com`），添加CNAME记录：

```
CNAME  docs  your-username.github.io
```

### 4.2 在GitHub配置

1. 在仓库 **Settings** → **Pages**
2. **Custom domain** 填入 `docs.example.com`
3. 勾选 **Enforce HTTPS**
4. 点击 **Save**

### 4.3 更新VitePress配置

编辑`.vitepress/config.js`：

```javascript
export default {
  base: '/',  // 自定义域名不需要子路径
  // ...其他配置
}
```

提交并推送：

```bash
git add .vitepress/config.js
git commit -m "config: 更新为自定义域名"
git push
```

## 五、故障排查

### 问题1：Actions运行失败

检查`.github/workflows/deploy-docs.yml`配置是否正确。

### 问题2：部署后显示404

1. 确认`.vitepress/config.js`中的`base`路径正确
2. 默认应为：`base: '/lilWAN_SHOP02-docs/'`（仓库名）
3. 自定义域名应为：`base: '/'`

### 问题3：样式丢失

确认`base`路径配置正确，所有资源路径都是相对于`base`的。

### 问题4：权限错误

确认已在 **Settings** → **Actions** → **General** 中启用了 **Read and write permissions**。

## 六、本地预览

在推送前本地预览：

```bash
cd /tmp/lilWAN_SHOP02-docs
npm install
npm run docs:dev
```

访问 http://localhost:5173

## 七、更新仓库地址

在所有文档中将 `your-username` 替换为你的实际GitHub用户名：

```bash
# 更新README.md中的链接
sed -i 's/your-username/actual-username/g' README.md

# 更新其他引用
grep -r "your-username" . --exclude-dir=node_modules
```

提交更改：

```bash
git add .
git commit -m "docs: 更新仓库链接"
git push
```

---

**维护**: lilWAN Development Team  
**更新时间**: 2025-10-28

