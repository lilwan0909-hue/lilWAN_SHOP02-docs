# 分页说明

## 📋 概述

lilWAN_SHOP02 API 为列表类接口提供统一的分页机制，基于 Laravel Eloquent 分页器实现。

---

## 🎯 请求参数

列表类接口支持分页查询，使用以下查询参数:

| 参数 | 类型 | 默认值 | 范围 | 说明 |
|------|------|--------|------|------|
| `page` | integer | 1 | ≥ 1 | 当前页码（从 1 开始） |
| `per_page` | integer | 15 | 1-100 | 每页数据量 |

### 请求示例

```http
GET /api/v1/products?page=2&per_page=20
Authorization: Bearer {token}
```

```bash
curl -X GET "http://localhost:8081/api/v1/products?page=2&per_page=20" \
  -H "Authorization: Bearer {token}"
```

---

## 📤 响应格式

### 成功响应结构

```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "data": [
      {
        "id": 21,
        "name": "商品名称",
        "price": 99.99,
        // ... 其他字段
      },
      // ... 更多数据
    ],
    "current_page": 2,
    "per_page": 20,
    "total": 156,
    "last_page": 8,
    "from": 21,
    "to": 40
  },
  "timestamp": 1730361234
}
```

### 分页字段说明

| 字段 | 类型 | 说明 |
|------|------|------|
| `data` | array | 当前页数据列表 |
| `current_page` | integer | 当前页码 |
| `per_page` | integer | 每页数量 |
| `total` | integer | 总记录数 |
| `last_page` | integer | 最后一页页码 |
| `from` | integer | 当前页起始记录序号（全局位置） |
| `to` | integer | 当前页结束记录序号（全局位置） |

### 空列表响应

当没有数据时，返回空数组:

```json
{
  "code": 0,
  "message": "获取成功",
  "data": {
    "data": [],
    "current_page": 1,
    "per_page": 15,
    "total": 0,
    "last_page": 1,
    "from": null,
    "to": null
  },
  "timestamp": 1730361234
}
```

---

## 💻 后端实现

### 基本用法

```php
use App\Http\Responses\ApiResponse;
use App\Models\ProductSpu;

public function index(Request $request)
{
    $perPage = $request->input('per_page', 15); // 默认 15 条/页
    
    $products = ProductSpu::query()
        ->where('status', ProductSpu::STATUS_ON_SALE)
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
        
    return ApiResponse::paginate($products, '获取商品列表成功');
}
```

### 高级用法

#### 1. 带搜索条件的分页

```php
public function index(Request $request)
{
    $products = ProductSpu::query()
        ->when($request->keyword, function ($query, $keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
        })
        ->when($request->category_id, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->when($request->min_price, function ($query, $minPrice) {
            $query->where('price', '>=', $minPrice);
        })
        ->when($request->max_price, function ($query, $maxPrice) {
            $query->where('price', '<=', $maxPrice);
        })
        ->orderBy($request->input('sort_by', 'created_at'), $request->input('sort_order', 'desc'))
        ->paginate($request->input('per_page', 15));
        
    return ApiResponse::paginate($products, '获取商品列表成功');
}
```

#### 2. 关联关系的分页

```php
public function index(Request $request)
{
    $orders = Order::query()
        ->with(['user:id,nickname,mobile', 'items.sku'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate($request->input('per_page', 15));
        
    return ApiResponse::paginate($orders, '获取订单列表成功');
}
```

#### 3. API Resource 格式化

```php
use App\Http\Resources\ProductResource;

public function index(Request $request)
{
    $products = ProductSpu::query()
        ->orderBy('created_at', 'desc')
        ->paginate($request->input('per_page', 15));
        
    // 使用 Resource 格式化每个项目
    $products->getCollection()->transform(function ($product) {
        return new ProductResource($product);
    });
        
    return ApiResponse::paginate($products, '获取商品列表成功');
}
```

---

## 🎨 前端实现（Vue Arco Pro）

### Arco Table 组件集成

```vue
<template>
  <a-table
    :columns="columns"
    :data="dataList"
    :loading="loading"
    :pagination="pagination"
    @page-change="onPageChange"
    @page-size-change="onPageSizeChange"
  />
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { getProductList } from '@/api/product';

const loading = ref(false);
const dataList = ref<Product[]>([]);

const pagination = reactive({
  current: 1,
  pageSize: 15,
  total: 0,
  showTotal: true,
  showPageSize: true,
  pageSizeOptions: [10, 15, 20, 50, 100],
});

const fetchData = async () => {
  loading.value = true;
  try {
    const res = await getProductList({
      page: pagination.current,
      per_page: pagination.pageSize,
      // ... 其他查询参数
    });
    
    dataList.value = res.data;
    pagination.total = res.total;
  } catch (error) {
    // 错误已由 interceptor 处理
  } finally {
    loading.value = false;
  }
};

const onPageChange = (page: number) => {
  pagination.current = page;
  fetchData();
};

const onPageSizeChange = (pageSize: number) => {
  pagination.pageSize = pageSize;
  pagination.current = 1; // 重置到第一页
  fetchData();
};

onMounted(() => {
  fetchData();
});
</script>
```

### API 请求封装

```typescript
// src/api/product.ts
import axios from 'axios';

export interface PaginationParams {
  page?: number;
  per_page?: number;
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  per_page: number;
  total: number;
  last_page: number;
  from: number | null;
  to: number | null;
}

export function getProductList(params: PaginationParams & { keyword?: string }) {
  return axios.get<PaginatedResponse<Product>>('/api/v1/products', { params });
}
```

---

## 🚀 性能优化建议

### 1. 避免大量数据分页

```php
// ❌ 不推荐：允许过大的 per_page
$perPage = $request->input('per_page', 15);
$products = ProductSpu::paginate($perPage);

// ✅ 推荐：限制最大值
$perPage = min($request->input('per_page', 15), 100);
$products = ProductSpu::paginate($perPage);
```

### 2. 使用索引优化排序

```php
// ❌ 性能差：未索引字段排序
$products = ProductSpu::orderBy('price', 'desc')->paginate(15);

// ✅ 推荐：为 price 字段添加索引
Schema::table('product_spus', function (Blueprint $table) {
    $table->index('price');
});
```

### 3. 使用 Cursor 分页（大数据集）

对于超大数据集（百万级），推荐使用 Cursor 分页:

```php
// 适用于无需显示总页数的场景
$products = ProductSpu::query()
    ->orderBy('id')
    ->cursorPaginate(15);
    
return ApiResponse::success($products, '获取商品列表成功');
```

### 4. 避免 N+1 查询

```php
// ❌ 错误：N+1 查询
$orders = Order::paginate(15);
// 在视图中访问 $order->user 会产生额外查询

// ✅ 正确：使用 Eager Loading
$orders = Order::with('user', 'items.sku')->paginate(15);
```

---

## 🧪 测试示例

### Feature Test

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ProductSpu;

class ProductListTest extends TestCase
{
    /** @test */
    public function it_returns_paginated_products()
    {
        // 准备 50 条数据
        ProductSpu::factory()->count(50)->create();
        
        $response = $this->getJson('/api/v1/products?page=2&per_page=20');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'message',
                'data' => [
                    'data',
                    'current_page',
                    'per_page',
                    'total',
                    'last_page',
                    'from',
                    'to',
                ],
                'timestamp',
            ])
            ->assertJson([
                'code' => 0,
                'data' => [
                    'current_page' => 2,
                    'per_page' => 20,
                    'total' => 50,
                    'last_page' => 3,
                    'from' => 21,
                    'to' => 40,
                ],
            ]);
            
        $this->assertCount(20, $response->json('data.data'));
    }
    
    /** @test */
    public function it_limits_max_per_page_to_100()
    {
        ProductSpu::factory()->count(200)->create();
        
        $response = $this->getJson('/api/v1/products?per_page=500');
        
        $response->assertStatus(200);
        $this->assertLessThanOrEqual(100, $response->json('data.per_page'));
    }
}
```

---

## 📚 常见问题

### Q1: 如何获取所有数据（不分页）?

**A**: 使用 `get()` 方法而非 `paginate()`:

```php
$products = ProductSpu::all(); // 小数据集
return ApiResponse::success($products);
```

但注意: 对于大数据集，强烈建议使用分页避免内存溢出。

### Q2: 如何自定义分页参数名?

**A**: 当前 API 固定使用 `page` 和 `per_page`，暂不支持自定义。

### Q3: 如何处理超出范围的页码?

**A**: Laravel 会自动返回最后一页的数据:

```php
// 请求 page=999（超出范围）
// 响应: current_page = 8（最后一页）
```

### Q4: 分页数据如何排序?

**A**: 使用 `orderBy()` 方法:

```php
$products = ProductSpu::orderBy('price', 'desc')->paginate(15);
```

### Q5: 如何实现无限滚动加载?

**A**: 前端累加 `page` 参数，后端正常返回分页数据:

```typescript
const loadMore = async () => {
  pagination.current++;
  const res = await getProductList({
    page: pagination.current,
    per_page: 20,
  });
  dataList.value.push(...res.data); // 追加数据
};
```

---

## 📚 相关文档

- [API 概览](/api/overview)
- [错误处理规范](/api/guidelines/error-handling)
- [Laravel 分页文档](https://laravel.com/docs/11.x/pagination)

---

::: tip 提示
分页参数会影响查询性能，建议为常用的排序字段添加数据库索引。
:::

