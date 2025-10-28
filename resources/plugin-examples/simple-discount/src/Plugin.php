<?php

namespace Plugins\SimpleDiscount;

use App\Contracts\Marketing\MarketingPluginInterface;
use App\Services\Marketing\PricingContext;

/**
 * 简单折扣插件示例
 * 
 * 功能：全场9折优惠
 * 复杂度：⭐ 简单
 * 
 * 学习要点：
 * 1. 实现基本的插件接口
 * 2. 使用PricingContext获取订单信息
 * 3. 简单的条件判断
 * 4. 折扣金额计算
 * 
 * @author lilWAN Development Team
 * @version 1.0.0
 */
class Plugin implements MarketingPluginInterface
{
    /**
     * 获取插件代码
     * 
     * @return string
     */
    public function getCode(): string
    {
        return 'simple-discount';
    }

    /**
     * 获取插件名称
     * 
     * @return string
     */
    public function getName(): string
    {
        return '全场9折';
    }

    /**
     * 获取结算步骤
     * 
     * @return int 2-商品级优惠
     */
    public function getSettlementStep(): int
    {
        return 2; // 商品级优惠
    }

    /**
     * 检查插件是否可用
     * 
     * 学习要点：
     * - 按照成本从低到高的顺序检查
     * - 使用早返回（early return）
     * - 不要在此方法中修改任何状态
     * 
     * @param PricingContext $context
     * @return bool
     */
    public function isApplicable(PricingContext $context): bool
    {
        // 订单金额必须大于等于50元
        if ($context->currentAmount < 50) {
            return false;
        }

        return true;
    }

    /**
     * 计算折扣金额
     * 
     * 学习要点：
     * - 9折 = 优惠10%
     * - discount_amount 必须是正数
     * - 必须返回所有3个必需的键
     * 
     * @param PricingContext $context
     * @return array
     */
    public function calculate(PricingContext $context): array
    {
        // 9折 = 优惠10%
        $discountAmount = $context->currentAmount * 0.1;

        // 确保折扣金额不超过当前金额（防御性编程）
        $discountAmount = min($discountAmount, $context->currentAmount);

        return [
            'discount_amount' => $discountAmount,
            'items' => [], // 订单级折扣，不涉及具体商品
            'metadata' => [
                'discount_rate' => 0.9,
                'discount_percent' => 10,
                'plugin' => $this->getCode(),
            ],
        ];
    }

    /**
     * 获取优先级
     * 
     * @return int 数字越大优先级越高
     */
    public function getPriority(): int
    {
        return 100; // 默认优先级
    }

    /**
     * 获取叠加规则
     * 
     * @return string stack-可叠加 | mutex-互斥 | choose_best-择优
     */
    public function getStackingRule(): string
    {
        return 'stack'; // 可与其他优惠叠加
    }

    /**
     * 获取互斥插件列表
     * 
     * @return array
     */
    public function getMutuallyExclusivePlugins(): array
    {
        return []; // 不与任何插件互斥
    }
}

