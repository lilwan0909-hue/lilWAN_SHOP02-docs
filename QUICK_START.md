# 快速开始 🚀

5分钟部署文档网站到GitHub Pages！

## 一键部署（命令版）

```bash
# 1. 在GitHub创建新仓库（名为 lilWAN_SHOP02-docs，公开）

# 2. 复制仓库到你的工作目录
cp -r /tmp/lilWAN_SHOP02-docs ~/projects/lilWAN_SHOP02-docs
cd ~/projects/lilWAN_SHOP02-docs

# 3. 连接远程仓库（替换为你的GitHub用户名）
git remote add origin git@github.com:your-username/lilWAN_SHOP02-docs.git

# 4. 推送代码
git push -u origin main

# 5. 在GitHub启用Actions权限
# 访问: https://github.com/your-username/lilWAN_SHOP02-docs/settings/actions
# 选择: Read and write permissions
# 勾选: Allow GitHub Actions to create and approve pull requests

# 6. 等待自动部署（1-2分钟）

# 7. 访问你的文档网站
# https://your-username.github.io/lilWAN_SHOP02-docs/
```

## 详细步骤

### Step 1: 创建GitHub仓库

1. 访问 https://github.com/new
2. Repository name: `lilWAN_SHOP02-docs`
3. **Public** ✓
4. 不勾选 `Add a README file`
5. Create repository

### Step 2: 复制文档到工作目录

```bash
cp -r /tmp/lilWAN_SHOP02-docs ~/projects/lilWAN_SHOP02-docs
cd ~/projects/lilWAN_SHOP02-docs
```

### Step 3: 连接并推送

```bash
# 使用SSH（推荐，需要配置SSH密钥）
git remote add origin git@github.com:your-username/lilWAN_SHOP02-docs.git

# 或使用HTTPS（需要输入用户名和密码）
# git remote add origin https://github.com/your-username/lilWAN_SHOP02-docs.git

# 推送
git push -u origin main
```

### Step 4: 配置GitHub Actions权限

1. 访问: `https://github.com/your-username/lilWAN_SHOP02-docs/settings/actions`
2. **Workflow permissions** → **Read and write permissions**
3. 勾选 **Allow GitHub Actions to create and approve pull requests**
4. Save

### Step 5: 配置GitHub Pages（自动）

推送后，GitHub Actions会自动运行并部署。

查看进度：
- 访问 `https://github.com/your-username/lilWAN_SHOP02-docs/actions`
- 等待绿色✓

### Step 6: 访问文档

```
https://your-username.github.io/lilWAN_SHOP02-docs/
```

## 本地预览

在推送前先本地预览：

```bash
cd ~/projects/lilWAN_SHOP02-docs
npm install
npm run docs:dev
```

访问 http://localhost:5173

## 更新文档

```bash
cd ~/projects/lilWAN_SHOP02-docs

# 编辑文档...

git add .
git commit -m "docs: 更新内容"
git push

# 等待1-2分钟，网站自动更新
```

## 故障排查

### 问题：Actions运行失败

**原因**: 权限不足

**解决**: 
1. 进入 Settings → Actions → General
2. 选择 **Read and write permissions**
3. 重新运行workflow

### 问题：404错误

**原因**: base路径配置错误

**解决**: 
检查 `.vitepress/config.js`:
```javascript
base: '/lilWAN_SHOP02-docs/',  // 必须是仓库名
```

### 问题：样式丢失

**原因**: 资源路径错误

**解决**: 
确认 `base` 配置正确，清理缓存重新构建：
```bash
rm -rf .vitepress/cache .vitepress/dist
npm run docs:build
```

## SSH密钥配置（首次使用）

如果使用SSH方式推送，需要配置SSH密钥：

```bash
# 1. 生成密钥（如果已有则跳过）
ssh-keygen -t ed25519 -C "your_email@example.com"

# 2. 复制公钥
cat ~/.ssh/id_ed25519.pub

# 3. 添加到GitHub
# 访问: https://github.com/settings/ssh/new
# 粘贴公钥内容，保存
```

## 完成 ✅

现在你的文档已经在线了！

- 📖 在线文档: `https://your-username.github.io/lilWAN_SHOP02-docs/`
- 🔧 本地开发: `npm run docs:dev`
- 📝 更新文档: `git push`（自动部署）

---

**更多帮助**: 查看 [DEPLOYMENT.md](./DEPLOYMENT.md) 获取完整部署文档

