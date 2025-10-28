<?php

namespace Plugins\BirthdayCoupon;

use App\Contracts\Marketing\MarketingPluginInterface;
use App\Services\Marketing\PricingContext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * 生日优惠券插件
 * 
 * 功能：用户生日月份享受20元优惠券
 * 复杂度：⭐⭐⭐ 中等
 * 
 * 学习要点：
 * 1. 数据库查询和操作
 * 2. 用户身份验证
 * 3. 复杂的条件判断（生日月份）
 * 4. 使用记录管理
 * 5. 事务处理
 * 
 * @author lilWAN Development Team
 * @version 1.0.0
 */
class Plugin implements MarketingPluginInterface
{
    public function getCode(): string
    {
        return 'birthday-coupon';
    }

    public function getName(): string
    {
        return '生日优惠券';
    }

    public function getSettlementStep(): int
    {
        return 2; // 商品级优惠
    }

    /**
     * 检查插件是否可用
     * 
     * 学习要点：
     * 1. 检查用户登录状态
     * 2. 验证用户生日信息
     * 3. 检查是否在生日月份
     * 4. 查询使用记录
     * 
     * @param PricingContext $context
     * @return bool
     */
    public function isApplicable(PricingContext $context): bool
    {
        // 1. 检查用户是否登录
        if (!$context->user) {
            return false;
        }

        // 2. 检查用户是否有生日信息
        if (!$context->user->birthday) {
            return false;
        }

        // 3. 检查是否在生日月份
        if (!$this->isInBirthdayMonth($context->user)) {
            return false;
        }

        // 4. 检查订单金额
        if ($context->currentAmount < 100) {
            return false;
        }

        // 5. 检查本月是否已使用
        if ($this->hasUsedThisMonth($context->user->id)) {
            return false;
        }

        return true;
    }

    /**
     * 计算折扣金额
     * 
     * 学习要点：
     * 1. 固定金额折扣
     * 2. 记录使用信息
     * 3. 错误处理
     * 
     * @param PricingContext $context
     * @return array
     */
    public function calculate(PricingContext $context): array
    {
        $userId = $context->user->id;
        $discountAmount = 20.0; // 固定20元

        // 不能超过当前金额
        $discountAmount = min($discountAmount, $context->currentAmount);

        try {
            // 记录使用信息
            $this->recordUsage($userId, $discountAmount);

            Log::info('Birthday coupon used', [
                'user_id' => $userId,
                'discount_amount' => $discountAmount,
                'birthday' => $context->user->birthday,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to record birthday coupon usage', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'discount_amount' => $discountAmount,
            'items' => [],
            'metadata' => [
                'coupon_type' => 'birthday',
                'user_id' => $userId,
                'birthday' => $context->user->birthday,
                'plugin' => $this->getCode(),
            ],
        ];
    }

    public function getPriority(): int
    {
        return 150; // 较高优先级（生日特权）
    }

    public function getStackingRule(): string
    {
        return 'stack'; // 可与其他优惠叠加
    }

    public function getMutuallyExclusivePlugins(): array
    {
        return []; // 不与任何插件互斥
    }

    /**
     * 检查是否在生日月份
     * 
     * 学习要点：
     * - 使用Carbon处理日期
     * - 比较月份
     * 
     * @param \App\Models\User $user
     * @return bool
     */
    private function isInBirthdayMonth($user): bool
    {
        $now = now();
        $birthday = \Carbon\Carbon::parse($user->birthday);

        return $now->month === $birthday->month;
    }

    /**
     * 检查本月是否已使用
     * 
     * 学习要点：
     * - 数据库查询
     * - 日期范围过滤
     * 
     * @param int $userId
     * @return bool
     */
    private function hasUsedThisMonth(int $userId): bool
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $count = DB::table('plugin_birthday_coupon_usage')
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return $count > 0;
    }

    /**
     * 记录使用信息
     * 
     * 学习要点：
     * - 数据库插入
     * - 使用now()获取当前时间
     * 
     * @param int $userId
     * @param float $discountAmount
     * @return void
     */
    private function recordUsage(int $userId, float $discountAmount): void
    {
        DB::table('plugin_birthday_coupon_usage')->insert([
            'user_id' => $userId,
            'discount_amount' => $discountAmount,
            'used_month' => now()->format('Y-m'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

