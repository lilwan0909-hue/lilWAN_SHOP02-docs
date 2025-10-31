# 商城API - 商品浏览

::: tip 路由前缀
所有接口使用 `/api/v1` 前缀，无需认证
:::

## 商品列表

### 获取商品列表

```http
GET /api/v1/products
```

**查询参数**：
- `page`: 页码（默认1）
- `per_page`: 每页数量（默认15）
- `keyword`: 搜索关键词
- `category_id`: 分类ID
- `min_price`: 最低价格
- `max_price`: 最高价格
- `sort_by`: 排序字段（price/sales/created_at）
- `sort_order`: 排序方式（asc/desc）

**成功响应**：
```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "data": [
      {
        "id": 1,
        "name": "商品名称",
        "price": 99.99,
        "market_price": 199.99,
        "cover_image": "https://xxx.com/cover.jpg",
        "sales": 1000,
        "stock": 999
      }
    ],
    "current_page": 1,
    "per_page": 15,
    "total": 156,
    "last_page": 11
  }
}
```

---

### 搜索商品

```http
GET /api/v1/products/search
```

**查询参数**：
- `keyword`: 搜索关键词（必填）
- `page`: 页码
- `per_page`: 每页数量

**说明**：全文搜索商品（商品名称、描述、标签）

---

### 热销商品

```http
GET /api/v1/products/hot
```

**查询参数**：
- `limit`: 返回数量（默认10）

**返回**：按销量排序的热销商品

---

### 新品推荐

```http
GET /api/v1/products/new
```

**查询参数**：
- `limit`: 返回数量（默认10）

**返回**：按上架时间排序的新品

---

### 商品详情

```http
GET /api/v1/products/{id}
```

**成功响应**：
```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "id": 1,
    "name": "商品名称",
    "price": 99.99,
    "market_price": 199.99,
    "cover_image": "https://xxx.com/cover.jpg",
    "images": ["https://xxx.com/1.jpg", "https://xxx.com/2.jpg"],
    "description": "商品描述",
    "sales": 1000,
    "stock": 999,
    "category": {
      "id": 1,
      "name": "分类名称"
    },
    "specs": [
      {
        "name": "颜色",
        "values": ["红色", "蓝色"]
      },
      {
        "name": "尺寸",
        "values": ["S", "M", "L"]
      }
    ],
    "skus": [
      {
        "id": 1,
        "specs": "红色;S",
        "price": 99.99,
        "stock": 100
      }
    ]
  }
}
```

---

## 商品收藏（需要登录）

### 收藏/取消收藏商品

```http
POST /api/v1/products/{id}/favorite
```

**说明**：切换收藏状态（已收藏则取消，未收藏则添加）

**成功响应**：
```json
{
  "code": 0,
  "message": "收藏成功",
  "data": {
    "is_favorited": true
  }
}
```

---

## 商品分类

### 分类列表

```http
GET /api/v1/categories
```

**返回**：分类树形结构

**成功响应**：
```json
{
  "code": 0,
  "data": [
    {
      "id": 1,
      "name": "服装",
      "icon": "https://xxx.com/icon.png",
      "children": [
        {
          "id": 2,
          "name": "男装"
        },
        {
          "id": 3,
          "name": "女装"
        }
      ]
    }
  ]
}
```

---

### 分类下的商品

```http
GET /api/v1/categories/{id}/products
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `sort_by`: 排序字段
- `sort_order`: 排序方式

**返回**：指定分类下的商品列表（支持分页）

