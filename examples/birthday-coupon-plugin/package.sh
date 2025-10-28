#!/bin/bash

# 生日券插件打包脚本
# 用法: ./package.sh

PLUGIN_NAME="birthday-coupon-plugin"
VERSION="1.0.0"
OUTPUT_FILE="${PLUGIN_NAME}-v${VERSION}.zip"

echo "======================================"
echo " 生日券插件打包工具"
echo "======================================"
echo ""
echo "插件名称: ${PLUGIN_NAME}"
echo "版本号: ${VERSION}"
echo "输出文件: ${OUTPUT_FILE}"
echo ""

# 检查必需文件
echo "检查必需文件..."
REQUIRED_FILES=("plugin.json" "tcals.json" "config.json")
for file in "${REQUIRED_FILES[@]}"; do
    if [ ! -f "$file" ]; then
        echo "❌ 错误: 缺少必需文件 $file"
        exit 1
    fi
    echo "✅ $file"
done

# 检查可选文件
OPTIONAL_FILES=("menus.json" "hooks.php" "install.sql" "uninstall.sql" "README.md")
for file in "${OPTIONAL_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file (可选)"
    else
        echo "⚠️  $file (可选，未找到)"
    fi
done

echo ""
echo "开始打包..."

# 删除旧的ZIP文件
if [ -f "$OUTPUT_FILE" ]; then
    rm "$OUTPUT_FILE"
    echo "已删除旧文件: $OUTPUT_FILE"
fi

# 打包所有文件
zip -r "$OUTPUT_FILE" . -x "*.sh" -x "*.zip" -x ".git/*" -x ".DS_Store"

if [ $? -eq 0 ]; then
    echo ""
    echo "======================================"
    echo "✅ 打包成功！"
    echo "======================================"
    echo ""
    echo "输出文件: ${OUTPUT_FILE}"
    echo "文件大小: $(du -h ${OUTPUT_FILE} | cut -f1)"
    echo ""
    echo "下一步："
    echo "1. 登录管理后台"
    echo "2. 进入【营销管理】→【营销插件】"
    echo "3. 点击【上传插件】"
    echo "4. 选择 ${OUTPUT_FILE} 上传"
    echo ""
else
    echo ""
    echo "❌ 打包失败"
    exit 1
fi

