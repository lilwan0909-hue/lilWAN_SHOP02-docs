# 错误处理规范

## 📋 目标

统一后端 API 响应格式,确保:
1. 所有 API 返回结构一致
2. 错误信息清晰,包含标题和建议
3. HTTP 状态码统一为 200,错误通过 code 字段区分
4. 响应包含时间戳,便于调试和日志追踪

---

## 🎯 标准响应格式

### 成功响应

```json
{
  "code": 0,
  "message": "操作成功",
  "data": {
    // 业务数据
  },
  "timestamp": 1730361234
}
```

### 错误响应

```json
{
  "code": 4001,
  "message": "用户名或密码错误",
  "data": null,
  "timestamp": 1730361234,
  "trace_id": "550e8400-e29b-41d4-a716-446655440000",
  "error_info": {
    "title": "认证错误",
    "suggestion": "请检查用户名和密码是否正确，或联系管理员重置密码"
  }
}
```

### 验证错误响应

```json
{
  "code": 4000,
  "message": "参数验证失败",
  "data": {
    "errors": {
      "name": ["名称不能为空"],
      "price": ["价格必须大于0"]
    }
  },
  "timestamp": 1730361234,
  "error_info": {
    "title": "数据验证失败",
    "suggestion": "请检查输入的数据是否正确"
  }
}
```

---

## 💻 使用方法

### 1. 使用 ApiResponse 类

**基本用法**:

```php
use App\Http\Responses\ApiResponse;
use App\Constants\ErrorCode;

// 成功响应
return ApiResponse::success($data, '操作成功');

// 错误响应
return ApiResponse::error('操作失败', ErrorCode::ERROR);

// 分页响应
$products = Product::paginate(15);
return ApiResponse::paginate($products, '获取商品列表成功');

// 验证错误
return ApiResponse::validationError($errors, '参数验证失败');

// 未授权
return ApiResponse::unauthorized('请先登录');

// 权限不足
return ApiResponse::forbidden('权限不足');

// 资源不存在
return ApiResponse::notFound('资源不存在');
```

### 2. 在控制器中使用

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Constants\ErrorCode;
use App\Http\Requests\CreateProductRequest;
use App\Models\ProductSpu;

class ProductController extends Controller
{
    /**
     * 获取商品列表
     */
    public function index(Request $request)
    {
        $products = ProductSpu::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->paginate($request->input('per_page', 15));
            
        return ApiResponse::paginate($products, '获取商品列表成功');
    }
    
    /**
     * 获取商品详情
     */
    public function show($id)
    {
        $product = ProductSpu::findOrFail($id);
        return ApiResponse::success($product, '获取商品详情成功');
    }
    
    /**
     * 创建商品
     */
    public function store(CreateProductRequest $request)
    {
        $product = ProductSpu::create($request->validated());
        return ApiResponse::success($product, '商品创建成功');
    }
    
    /**
     * 删除商品
     */
    public function destroy($id)
    {
        $product = ProductSpu::findOrFail($id);
        
        // 检查是否有订单
        if ($product->orders()->exists()) {
            throw new BusinessException(
                '商品已有订单，无法删除',
                ErrorCode::PRODUCT_HAS_ORDERS
            );
        }
        
        $product->delete();
        return ApiResponse::success(null, '商品删除成功');
    }
}
```

### 3. 使用 BusinessException 抛出异常

```php
use App\Exceptions\BusinessException;
use App\Constants\ErrorCode;

// 基本用法
if ($product->stock < $quantity) {
    throw new BusinessException('库存不足', ErrorCode::SKU_OUT_OF_STOCK);
}

// 带数据的异常
if ($sku->stock < $quantity) {
    throw new BusinessException(
        message: "库存不足，当前仅剩 {$sku->stock} 件",
        errorCode: ErrorCode::SKU_OUT_OF_STOCK,
        data: [
            'requested' => $quantity,
            'available' => $sku->stock,
            'sku_id' => $sku->id,
        ]
    );
}

// 使用自定义异常类（推荐）
throw ProductException::notFound();
throw OrderException::alreadyPaid();
throw CouponException::expired();
```

---

## 🚫 禁止行为

### 1. 禁止直接使用 response()->json()

```php
// ❌ 错误
public function index()
{
    $data = Product::all();
    return response()->json([
        'code' => 0,
        'data' => $data,
    ]);
}

// ✅ 正确
public function index()
{
    $data = Product::all();
    return ApiResponse::success($data);
}
```

### 2. 禁止硬编码错误码

```php
// ❌ 错误
return ApiResponse::error('用户不存在', 2001);

// ✅ 正确
return ApiResponse::error('用户不存在', ErrorCode::USER_NOT_FOUND);
```

### 3. 禁止直接抛出 Exception

```php
// ❌ 错误：通用异常（前端无法友好提示）
if ($product->stock < $quantity) {
    throw new \Exception('库存不足');
}

// ✅ 正确：业务异常
if ($product->stock < $quantity) {
    throw new BusinessException('库存不足', ErrorCode::SKU_OUT_OF_STOCK);
}
```

### 4. 禁止省略错误信息

```php
// ❌ 错误：消息太模糊
return ApiResponse::error('操作失败', ErrorCode::ERROR);

// ✅ 正确：消息明确
return ApiResponse::error('商品库存不足，无法下单', ErrorCode::SKU_OUT_OF_STOCK);
```

---

## ✅ 最佳实践

### 1. 错误消息要具体

```php
// ❌ 模糊
return ApiResponse::error('操作失败', ErrorCode::ERROR);

// ✅ 具体
return ApiResponse::error('商品已下架，无法购买', ErrorCode::PRODUCT_OFFLINE);
```

### 2. 使用事务确保数据一致性

```php
use Illuminate\Support\Facades\DB;

public function createOrder(Request $request)
{
    try {
        DB::beginTransaction();
        
        // 创建订单
        $order = Order::create([...]);
        
        // 扣减库存
        $product->decrement('stock', $quantity);
        
        DB::commit();
        
        return ApiResponse::success($order, '订单创建成功');
        
    } catch (BusinessException $e) {
        DB::rollBack();
        throw $e; // 重新抛出业务异常
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        Log::error('创建订单失败', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        throw new BusinessException(
            '订单创建失败，请稍后重试',
            ErrorCode::SERVER_ERROR
        );
    }
}
```

### 3. 记录关键操作日志

```php
use Illuminate\Support\Facades\Log;

public function delete($id)
{
    $product = ProductSpu::findOrFail($id);
    
    // 记录删除日志
    Log::info('删除商品', [
        'product_id' => $product->id,
        'product_name' => $product->name,
        'operator' => auth()->user()->id,
    ]);
    
    $product->delete();
    
    return ApiResponse::success(null, '商品删除成功');
}
```

### 4. 让全局异常处理器处理异常

```php
// ✅ 推荐：让全局异常处理器处理
public function destroy(int $id)
{
    $product = ProductSpu::findOrFail($id); // ModelNotFoundException 自动转为 404
    
    if ($product->orders()->exists()) {
        throw ProductException::hasOrders(); // BusinessException 自动处理
    }
    
    $product->delete();
    return ApiResponse::success(message: '删除成功');
}

// ❌ 不推荐：手动 try-catch（除非需要特殊处理）
public function destroy(int $id)
{
    try {
        $product = ProductSpu::findOrFail($id);
        $product->delete();
        return ApiResponse::success(message: '删除成功');
    } catch (\Exception $e) {
        return ApiResponse::error($e->getMessage(), ErrorCode::ERROR);
    }
}
```

---

## 🔍 调试与排查

### trace_id 追踪

所有错误响应都会包含 `trace_id`，用于日志追踪：

1. **前端获取**: 响应 `res.trace_id`（开发环境显示在 Notification）
2. **后端查询**: 通过 trace_id 在日志中搜索完整请求链路
3. **日志上下文**:
   ```php
   Log::withContext([
       'trace_id' => $traceId,
       'request_id' => $request->headers->get('X-Request-Id'),
       'path' => $request->path(),
       'user_id' => optional($request->user())->id,
   ]);
   ```

---

## 📚 参考资料

- **ApiResponse 类源码**: `backend/app/Http/Responses/ApiResponse.php`
- **ErrorCode 常量**: `backend/app/Constants/ErrorCode.php`
- **BusinessException**: `backend/app/Exceptions/BusinessException.php`
- **异常处理**: `backend/app/Exceptions/Handler.php`
- [常见错误码使用指南](/api/guidelines/error-codes)
- [前端错误提示规范](/api/guidelines/frontend-errors)

---

::: tip 提示
全局异常处理器会自动捕获 `BusinessException` 和 `ModelNotFoundException`，并转换为统一的 API 响应格式。控制器中无需手动 try-catch。
:::

