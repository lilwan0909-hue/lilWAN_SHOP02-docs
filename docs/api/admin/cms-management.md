# 管理后台 - CMS内容管理API

::: tip 路由前缀
所有接口使用 `/admin/cms` 前缀
:::

## CMS页面管理

### 页面列表

```http
GET /admin/cms/pages
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `status`: 状态（draft/published）
- `keyword`: 搜索关键词

### 创建页面

```http
POST /admin/cms/pages
```

**请求参数**：
- `title`: 页面标题
- `slug`: URL别名
- `content`: 页面内容（JSON配置）
- `seo_title`: SEO标题
- `seo_keywords`: SEO关键词
- `seo_description`: SEO描述
- `status`: 状态（draft/published）

### 更新页面

```http
PUT /admin/cms/pages/{id}
```

### 删除页面

```http
DELETE /admin/cms/pages/{id}
```

### 发布/取消发布页面

```http
POST /admin/cms/pages/{id}/toggle-publish
```

### 设置为首页

```http
POST /admin/cms/pages/{id}/set-home
```

**说明**：将页面设置为商城首页

### 复制页面

```http
POST /admin/cms/pages/{id}/duplicate
```

**说明**：快速复制页面作为新页面模板

---

## 文章管理

### 文章列表

```http
GET /admin/cms/articles
```

**权限**：`article.list`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `category_id`: 分类ID
- `status`: 状态（draft/published）
- `keyword`: 搜索关键词

### 创建文章

```http
POST /admin/cms/articles
```

**权限**：`article.create`

**请求参数**：
- `title`: 文章标题
- `category_id`: 分类ID
- `author`: 作者
- `summary`: 摘要
- `content`: 文章内容（富文本）
- `cover_image`: 封面图片
- `tags`: 标签数组
- `is_featured`: 是否推荐
- `sort`: 排序
- `seo_title`: SEO标题
- `seo_keywords`: SEO关键词
- `seo_description`: SEO描述

### 文章详情

```http
GET /admin/cms/articles/{id}
```

**权限**：`article.list`

### 更新文章

```http
PUT /admin/cms/articles/{id}
```

**权限**：`article.update`

### 删除文章

```http
DELETE /admin/cms/articles/{id}
```

**权限**：`article.delete`

### 批量删除文章

```http
POST /admin/cms/articles/batch-destroy
```

**权限**：`article.delete`

**请求参数**：
- `ids`: 文章ID数组

### 发布文章

```http
POST /admin/cms/articles/{id}/publish
```

**权限**：`article.publish`

### 取消发布文章

```http
POST /admin/cms/articles/{id}/unpublish
```

**权限**：`article.publish`

### 切换推荐状态

```http
POST /admin/cms/articles/{id}/toggle-featured
```

**权限**：`article.update`

### 更新文章排序

```http
POST /admin/cms/articles/{id}/sort
```

**权限**：`article.update`

**请求参数**：
- `sort`: 排序值

---

## 文章分类管理

### 文章分类列表

```http
GET /admin/cms/article-categories
```

**权限**：`article.category.list`

### 创建文章分类

```http
POST /admin/cms/article-categories
```

**权限**：`article.category.create`

**请求参数**：
- `name`: 分类名称
- `slug`: URL别名
- `parent_id`: 父分类ID（顶级分类为null）
- `icon`: 图标
- `description`: 描述
- `sort`: 排序

### 获取启用的分类

```http
GET /admin/cms/article-categories/enabled
```

**权限**：`article.category.list`

**说明**：用于下拉选择框

### 文章分类详情

```http
GET /admin/cms/article-categories/{id}
```

**权限**：`article.category.list`

### 更新文章分类

```http
PUT /admin/cms/article-categories/{id}
```

**权限**：`article.category.update`

### 删除文章分类

```http
DELETE /admin/cms/article-categories/{id}
```

**权限**：`article.category.delete`

### 启用/禁用文章分类

```http
POST /admin/cms/article-categories/{id}/toggle-status
```

**权限**：`article.category.update`

### 更新分类排序

```http
POST /admin/cms/article-categories/{id}/sort
```

**权限**：`article.category.update`

---

## 广告位管理

### 广告位列表

```http
GET /admin/cms/ad-positions
```

**权限**：`ad.position.list`

### 创建广告位

```http
POST /admin/cms/ad-positions
```

**权限**：`ad.position.create`

**请求参数**：
- `name`: 广告位名称
- `code`: 广告位编码（唯一）
- `width`: 宽度
- `height`: 高度
- `description`: 描述

### 获取启用的广告位

```http
GET /admin/cms/ad-positions/enabled
```

**权限**：`ad.position.list`

**说明**：用于下拉选择框

### 广告位详情

```http
GET /admin/cms/ad-positions/{id}
```

**权限**：`ad.position.list`

### 更新广告位

```http
PUT /admin/cms/ad-positions/{id}
```

**权限**：`ad.position.update`

### 删除广告位

```http
DELETE /admin/cms/ad-positions/{id}
```

**权限**：`ad.position.delete`

### 启用/禁用广告位

```http
POST /admin/cms/ad-positions/{id}/toggle-status
```

**权限**：`ad.position.update`

---

## 广告管理

### 广告列表

```http
GET /admin/cms/ads
```

**权限**：`ad.list`

**查询参数**：
- `position_id`: 广告位ID
- `status`: 状态（enabled/disabled）

### 创建广告

```http
POST /admin/cms/ads
```

**权限**：`ad.create`

**请求参数**：
- `position_id`: 广告位ID
- `title`: 广告标题
- `image`: 广告图片
- `link_type`: 链接类型（url/product/category/article）
- `link_value`: 链接值
- `start_time`: 开始时间
- `end_time`: 结束时间
- `sort`: 排序

### 广告详情

```http
GET /admin/cms/ads/{id}
```

**权限**：`ad.list`

### 更新广告

```http
PUT /admin/cms/ads/{id}
```

**权限**：`ad.update`

### 删除广告

```http
DELETE /admin/cms/ads/{id}
```

**权限**：`ad.delete`

### 启用/禁用广告

```http
POST /admin/cms/ads/{id}/toggle-status
```

**权限**：`ad.update`

---

## 导航管理

### 导航列表

```http
GET /admin/cms/navigations
```

**权限**：`navigation.list`

**说明**：PC端导航菜单管理

### 创建导航

```http
POST /admin/cms/navigations
```

**权限**：`navigation.create`

**请求参数**：
- `parent_id`: 父导航ID（顶级导航为null）
- `title`: 导航标题
- `link_type`: 链接类型（page/category/article/custom）
- `link_value`: 链接值
- `icon`: 图标
- `target`: 打开方式（_self/_blank）
- `sort`: 排序

### 导航详情

```http
GET /admin/cms/navigations/{id}
```

**权限**：`navigation.list`

### 更新导航

```http
PUT /admin/cms/navigations/{id}
```

**权限**：`navigation.update`

### 删除导航

```http
DELETE /admin/cms/navigations/{id}
```

**权限**：`navigation.delete`

### 启用/禁用导航

```http
POST /admin/cms/navigations/{id}/toggle-status
```

**权限**：`navigation.update`

---

## 媒体库管理

### 媒体文件列表

```http
GET /admin/cms/media
```

**权限**：`media.list`

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `type`: 文件类型（image/video/audio/document）
- `keyword`: 搜索关键词

### 上传媒体文件

```http
POST /admin/cms/media/upload
```

**权限**：`media.upload`

**请求参数**：
- `file`: 文件（multipart/form-data）
- `folder`: 文件夹（可选）

### 媒体文件详情

```http
GET /admin/cms/media/{id}
```

**权限**：`media.list`

**返回**：
- 文件信息
- 文件大小
- 上传时间
- 访问URL

### 删除媒体文件

```http
DELETE /admin/cms/media/{id}
```

**权限**：`media.delete`

### 批量删除媒体文件

```http
POST /admin/cms/media/batch-destroy
```

**权限**：`media.delete`

**请求参数**：
- `ids`: 文件ID数组

