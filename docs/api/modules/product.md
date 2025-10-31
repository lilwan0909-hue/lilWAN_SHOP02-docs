# 商品管理接口

::: warning 待完善
本文档为占位文件，接口详情请通过以下方式查看：
1. 导入 Postman 集合到 Apifox：`postman/lilWAN_SHOP02_API.postman_collection.json`
2. 在 Apifox 中查看完整的接口文档、请求示例和响应说明
3. 后续会从 Apifox 导出 Markdown 补充到此处
:::

## 接口列表

### 商品列表

```
GET /api/v1/products
```

**查询参数**:
- `page`: 页码
- `per_page`: 每页数量
- `keyword`: 搜索关键词
- `category_id`: 分类ID
- `min_price`: 最低价格
- `max_price`: 最高价格
- `sort_by`: 排序字段（price, sales, created_at）
- `sort_order`: 排序方式（asc, desc）

---

### 商品详情

```
GET /api/v1/products/{id}
```

---

### 商品分类

- `GET /api/v1/categories` - 获取分类列表
- `GET /api/v1/categories/{id}` - 获取分类详情
- `GET /api/v1/categories/{id}/products` - 获取分类下的商品

---

## 相关文档

- [分页说明](/docs/api/guidelines/pagination)
- [错误码使用指南](/docs/api/guidelines/error-codes)

---

::: tip 完善计划
待 Apifox 整理完成后，将从 Apifox 导出详细文档补充到本页面。
:::

