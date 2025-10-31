# 常见错误码使用指南

## 📋 概述

本文档为后端开发者提供错误码的正确使用方法，确保 API 响应的一致性和可维护性。

---

## 🎯 核心原则

### 1. 统一使用 ErrorCode 常量

```php
// ✅ 正确
throw new BusinessException('商品不存在', ErrorCode::PRODUCT_NOT_FOUND);

// ❌ 错误：硬编码数字
throw new BusinessException('商品不存在', 3001);
```

### 2. 使用 BusinessException 而非 Exception

```php
// ✅ 正确：业务异常
if ($product->stock < $quantity) {
    throw new BusinessException('库存不足', ErrorCode::SKU_OUT_OF_STOCK);
}

// ❌ 错误：通用异常（前端无法友好提示）
if ($product->stock < $quantity) {
    throw new \Exception('库存不足');
}
```

### 3. 善用自定义异常类

```php
// ✅ 推荐：使用模块专属异常类
throw ProductException::notFound();
throw OrderException::alreadyPaid();
throw CouponException::expired();

// ⚠️ 可接受：直接使用 BusinessException
throw new BusinessException('商品不存在', ErrorCode::PRODUCT_NOT_FOUND);
```

---

## 📊 错误码完整列表

### 通用错误码 (0, 4000-4099)

| 错误码 | 常量 | 说明 | HTTP 状态码 |
|--------|------|------|------------|
| `0` | `SUCCESS` | 成功 | 200 |
| `4000` | `VALIDATION_ERROR` | 参数验证失败 | 200 |
| `4001` | `UNAUTHORIZED` | 未授权/未登录 | 200 |
| `4002` | `FORBIDDEN` | 权限不足 | 200 |
| `4003` | `NOT_FOUND` | 资源不存在 | 200 |
| `4004` | `TOO_MANY_REQUESTS` | 请求过于频繁 | 200 |
| `5000` | `SERVER_ERROR` | 服务器内部错误 | 200 |

**使用示例**:

```php
// 全局异常处理器会自动处理 ModelNotFoundException
$product = ProductSpu::findOrFail($id); // 找不到时返回 4003

// 手动抛出授权异常
if (!$user->hasPermission('product.delete')) {
    throw new BusinessException('权限不足', ErrorCode::FORBIDDEN);
}
```

---

### 用户相关错误码 (2000-2999)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `2001` | `USER_NOT_FOUND` | 用户不存在 |
| `2002` | `USER_ALREADY_EXISTS` | 用户已存在（注册重复） |
| `2003` | `INVALID_CREDENTIALS` | 账号或密码错误 |
| `2004` | `USER_DISABLED` | 用户已被禁用 |
| `2005` | `USER_NOT_VERIFIED` | 用户未验证 |
| `2006` | `INVALID_VERIFICATION_CODE` | 验证码错误 |
| `2007` | `PASSWORD_INCORRECT` | 密码错误 |
| `2008` | `INSUFFICIENT_BALANCE` | 余额不足 |

**使用示例**:

```php
// 登录验证
$user = User::where('mobile', $request->mobile)->first();
if (!$user || !Hash::check($request->password, $user->password)) {
    throw new BusinessException('账号或密码错误', ErrorCode::INVALID_CREDENTIALS);
}

// 账户状态检查
if ($user->status === User::STATUS_DISABLED) {
    throw new BusinessException('用户已被禁用', ErrorCode::USER_DISABLED);
}
```

---

### 商品相关错误码 (3000-3999)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `3001` | `PRODUCT_NOT_FOUND` | 商品不存在 |
| `3002` | `PRODUCT_OUT_OF_STOCK` | 商品售罄 |
| `3003` | `PRODUCT_OFFLINE` | 商品已下架 |
| `3004` | `SKU_NOT_FOUND` | SKU 不存在 |
| `3005` | `SKU_OUT_OF_STOCK` | SKU 库存不足 |
| `3006` | `INVALID_PRODUCT_QUANTITY` | 商品数量无效 |
| `3007` | `PRODUCT_SPEC_NAME_EXISTS` | 规格名称已存在 |
| `3008` | `PRODUCT_SPEC_VALUE_EMPTY` | 规格值为空 |

**使用示例**:

```php
// 库存检查
if ($sku->stock < $quantity) {
    throw ProductException::insufficientStock("库存不足，当前仅剩 {$sku->stock} 件");
}

// 商品状态检查
if ($product->status !== ProductSpu::STATUS_ON_SALE) {
    throw new BusinessException('商品已下架', ErrorCode::PRODUCT_OFFLINE);
}
```

---

### 订单相关错误码 (4100-4199)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `4101` | `ORDER_NOT_FOUND` | 订单不存在 |
| `4102` | `ORDER_ALREADY_PAID` | 订单已支付 |
| `4103` | `ORDER_ALREADY_CANCELLED` | 订单已取消 |
| `4104` | `ORDER_CANNOT_CANCEL` | 订单无法取消 |
| `4105` | `ORDER_CANNOT_REFUND` | 订单无法退款 |
| `4106` | `INVALID_ORDER_STATUS` | 订单状态错误 |

**使用示例**:

```php
// 取消订单前检查
if ($order->status === Order::STATUS_PAID) {
    throw OrderException::alreadyPaid();
}

if ($order->status === Order::STATUS_SHIPPED) {
    throw new BusinessException('订单已发货，无法取消', ErrorCode::ORDER_CANNOT_CANCEL);
}
```

---

### 支付相关错误码 (5000-5099)

#### 基础支付错误 (5001-5010)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `5001` | `PAYMENT_FAILED` | 支付失败 |
| `5002` | `PAYMENT_TIMEOUT` | 支付超时 |
| `5003` | `INVALID_PAYMENT_METHOD` | 支付方式无效 |
| `5004` | `PAYMENT_AMOUNT_MISMATCH` | 支付金额不匹配 |

#### 支付密码错误 (5011-5013)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `5011` | `PAYMENT_PASSWORD_WRONG` | 支付密码错误 |
| `5012` | `PAYMENT_PASSWORD_LOCKED` | 支付密码已锁定 |
| `5013` | `PAYMENT_PASSWORD_NOT_SET` | 未设置支付密码 |

#### 售后退款错误 (5031-5038)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `5031` | `REFUND_NOT_FOUND` | 售后申请不存在 |
| `5032` | `REFUND_ORDER_NOT_SUPPORTED` | 订单不支持售后 |
| `5033` | `REFUND_INVALID_STATUS` | 售后状态错误 |
| `5034` | `REFUND_ALREADY_EXISTS` | 已存在进行中的售后 |
| `5035` | `REFUND_ALREADY_COMPLETED` | 售后已完成 |
| `5036` | `REFUND_INVALID_AMOUNT` | 退款金额错误 |
| `5037` | `REFUND_CANCELLED_ORDER` | 已取消订单不能售后 |
| `5038` | `REFUND_AMOUNT_EXCEEDS_PAID` | 退款金额超过实付 |

#### 提现错误 (5041-5046)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `5041` | `WITHDRAWAL_NOT_FOUND` | 提现申请不存在 |
| `5042` | `WITHDRAWAL_ALREADY_PROCESSED` | 提现已处理 |
| `5043` | `WITHDRAWAL_INSUFFICIENT_BALANCE` | 余额不足 |
| `5044` | `WITHDRAWAL_INVALID_STATUS` | 提现状态错误 |
| `5045` | `WITHDRAWAL_AMOUNT_TOO_SMALL` | 提现金额过小 |
| `5046` | `WITHDRAWAL_AMOUNT_TOO_LARGE` | 提现金额超限 |

#### 发票错误 (5051-5054)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `5051` | `INVOICE_NOT_FOUND` | 发票不存在 |
| `5052` | `INVOICE_ALREADY_ISSUED` | 发票已开具 |
| `5053` | `INVOICE_ORDER_NOT_PAID` | 订单未支付 |
| `5054` | `INVOICE_INVALID_TYPE` | 发票类型无效 |

**使用示例**:

```php
// 支付金额校验
if ($payment->amount != $order->total_amount) {
    throw new BusinessException('支付金额与订单金额不匹配', ErrorCode::PAYMENT_AMOUNT_MISMATCH);
}

// 支付密码验证
if (!Hash::check($request->payment_password, $user->payment_password)) {
    throw PaymentException::wrongPassword($remainingAttempts);
}

// 售后申请检查
if ($order->refunds()->where('status', Refund::STATUS_PROCESSING)->exists()) {
    throw RefundException::alreadyExists();
}

// 提现金额限制
$minAmount = SystemSetting::get('withdrawal_min_amount', 10);
if ($amount < $minAmount) {
    throw new BusinessException("提现金额不能少于 {$minAmount} 元", ErrorCode::WITHDRAWAL_AMOUNT_TOO_SMALL);
}
```

---

### 购物车相关错误码 (6000-6999)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `6001` | `CART_ITEM_NOT_FOUND` | 购物车商品不存在 |
| `6002` | `CART_ITEM_LIMIT_EXCEEDED` | 购物车数量超限 |
| `6003` | `CART_EMPTY` | 购物车为空 |
| `6004` | `CART_PRODUCT_OFFLINE` | 商品已下架 |
| `6005` | `CART_SKU_NOT_FOUND` | 商品规格不存在 |
| `6006` | `CART_INSUFFICIENT_STOCK` | 库存不足 |
| `6007` | `CART_INVALID_QUANTITY` | 商品数量无效 |

**使用示例**:

```php
// 添加购物车前检查
if ($user->cartItems()->count() >= 100) {
    throw new BusinessException('购物车商品数量已达上限', ErrorCode::CART_ITEM_LIMIT_EXCEEDED);
}

// 结算前验证
if ($cart->items->isEmpty()) {
    throw new BusinessException('购物车为空', ErrorCode::CART_EMPTY);
}

foreach ($cart->items as $item) {
    if ($item->sku->stock < $item->quantity) {
        throw new BusinessException("{$item->sku->name} 库存不足", ErrorCode::CART_INSUFFICIENT_STOCK);
    }
}
```

---

### 优惠券相关错误码 (7000-7999)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `7001` | `COUPON_NOT_FOUND` | 优惠券不存在 |
| `7002` | `COUPON_EXPIRED` | 优惠券已过期 |
| `7003` | `COUPON_OUT_OF_STOCK` | 优惠券已抢完 |
| `7004` | `COUPON_NOT_APPLICABLE` | 优惠券不适用 |
| `7005` | `COUPON_ALREADY_USED` | 优惠券已使用 |

**使用示例**:

```php
// 领取优惠券检查
if ($coupon->end_time < now()) {
    throw CouponException::expired();
}

if ($coupon->total_quantity <= $coupon->received_quantity) {
    throw CouponException::outOfStock();
}

// 使用优惠券检查
$userCoupon = UserCoupon::where('user_id', $user->id)
    ->where('coupon_id', $couponId)
    ->first();

if ($userCoupon->used_at) {
    throw CouponException::alreadyUsed();
}

if ($order->total_amount < $coupon->min_amount) {
    throw CouponException::notApplicable("订单金额未达到优惠券使用条件（满 {$coupon->min_amount} 元）");
}
```

---

### 广告相关错误码 (8000-8999)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `8001` | `AD_POSITION_HAS_RELATED_ADS` | 广告位仍有关联广告 |

**使用示例**:

```php
// 删除广告位前检查
if ($adPosition->ads()->exists()) {
    throw new BusinessException('该广告位仍有关联广告，无法删除', ErrorCode::AD_POSITION_HAS_RELATED_ADS);
}
```

---

### 营销活动相关错误码 (9000-9999)

#### 秒杀活动 (9001-9003)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `9001` | `SECKILL_NOT_STARTED` | 秒杀未开始 |
| `9002` | `SECKILL_ENDED` | 秒杀已结束 |
| `9003` | `SECKILL_SOLD_OUT` | 商品已抢光 |

#### 拼团活动 (9011-9014)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `9011` | `GROUP_BUY_NOT_ACTIVE` | 拼团活动未开始或已结束 |
| `9012` | `GROUP_BUY_ALREADY_PARTICIPATED` | 已参与该拼团 |
| `9013` | `GROUP_BUY_TEAM_FULL` | 该团已满 |
| `9014` | `GROUP_BUY_TEAM_EXPIRED` | 该团已过期 |

#### 满减活动 (9021)

| 错误码 | 常量 | 使用场景 |
|--------|------|---------|
| `9021` | `FULL_REDUCE_NOT_APPLICABLE` | 不满足满减条件 |

**使用示例**:

```php
// 秒杀时间检查
if (now()->lt($seckill->start_time)) {
    throw new BusinessException('秒杀活动未开始', ErrorCode::SECKILL_NOT_STARTED);
}

if (now()->gt($seckill->end_time)) {
    throw new BusinessException('秒杀活动已结束', ErrorCode::SECKILL_ENDED);
}

// 拼团参与检查
if ($groupBuy->participants()->where('user_id', $user->id)->exists()) {
    throw new BusinessException('您已参与该拼团活动', ErrorCode::GROUP_BUY_ALREADY_PARTICIPATED);
}

if ($team->current_count >= $team->required_count) {
    throw new BusinessException('该团已满', ErrorCode::GROUP_BUY_TEAM_FULL);
}

// 满减条件检查
if ($order->goods_amount < $fullReduce->min_amount) {
    throw new BusinessException("不满足满减条件（满 {$fullReduce->min_amount} 元）", ErrorCode::FULL_REDUCE_NOT_APPLICABLE);
}
```

---

## 🛠️ 自定义异常类模板

```php
<?php

declare(strict_types=1);

namespace App\Exceptions\YourModule;

use App\Constants\ErrorCode;
use App\Exceptions\BusinessException;

class YourModuleException extends BusinessException
{
    /**
     * 资源不存在
     */
    public static function notFound(string $message = '资源不存在'): self
    {
        return new self($message, ErrorCode::YOUR_MODULE_NOT_FOUND);
    }

    /**
     * 状态错误
     */
    public static function invalidStatus(string $message = '状态不正确'): self
    {
        return new self($message, ErrorCode::YOUR_MODULE_INVALID_STATUS);
    }

    /**
     * 带数据的异常
     */
    public static function withData(string $message, array $data = []): self
    {
        return new self($message, ErrorCode::YOUR_MODULE_ERROR, $data);
    }
}
```

---

## 📚 相关资源

- **ErrorCode 定义**: `backend/app/Constants/ErrorCode.php`
- **BusinessException**: `backend/app/Exceptions/BusinessException.php`
- **全局异常处理器**: `backend/app/Exceptions/Handler.php`
- **自定义异常目录**: `backend/app/Exceptions/{Module}/`
- [错误处理规范](/api/guidelines/error-handling)
- [前端错误提示规范](/api/guidelines/frontend-errors)

---

::: tip 提示
新增错误码时，请同时更新 `ErrorCode.php`、本文档和前端 `interceptor.ts` 中的 `getErrorInfo()` 函数。
:::

