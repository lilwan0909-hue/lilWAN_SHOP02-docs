<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

return [
    /**
     * 插件安装时执行
     * 
     * @param \App\Models\MarketingPlugin $plugin
     */
    'onInstall' => function ($plugin) {
        Log::info("生日券插件安装：{$plugin->name}");
        
        // 1. 创建数据表（通过install.sql自动执行）
        // 2. 初始化配置
        // 3. 注册定时任务
        
        // 示例：注册每日检查生日用户的定时任务
        // Artisan::call('schedule:run');
    },

    /**
     * 插件启用时执行
     * 
     * @param \App\Models\MarketingPlugin $plugin
     */
    'onEnable' => function ($plugin) {
        Log::info("生日券插件启用：{$plugin->name}");
        
        // 1. 启动定时任务
        // 2. 注册事件监听
        
        // 示例：注册生日检查任务
        // Event::listen('user:birthday', function ($user) {
        //     // 发放生日券
        // });
    },

    /**
     * 插件禁用时执行
     * 
     * @param \App\Models\MarketingPlugin $plugin
     */
    'onDisable' => function ($plugin) {
        Log::info("生日券插件禁用：{$plugin->name}");
        
        // 1. 停止定时任务
        // 2. 注销事件监听
        
        // 注意：不要删除数据，只是停止功能
    },

    /**
     * 插件卸载时执行
     * 
     * @param \App\Models\MarketingPlugin $plugin
     */
    'onUninstall' => function ($plugin) {
        Log::info("生日券插件卸载：{$plugin->name}");
        
        // 1. 清理定时任务
        // 2. 清理事件监听
        // 3. 删除数据表（通过uninstall.sql自动执行）
        
        // 可选：询问用户是否删除历史数据
    },
];

