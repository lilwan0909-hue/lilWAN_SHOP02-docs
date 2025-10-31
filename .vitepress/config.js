import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'lilWAN_SHOP02 开发文档',
  description: '完整的插件开发指南与 API 文档 - lilWAN Shop',
  base: '/lilWAN_SHOP02-docs/',
  ignoreDeadLinks: true,
  
  themeConfig: {
    logo: '/logo.svg',
    
    nav: [
      { text: '插件开发', link: '/plugin-development/' },
      { text: '示例', link: '/examples/' },
      { text: 'API文档', link: '/docs/api/overview' },
      { 
        text: '相关链接',
        items: [
          { text: 'GitHub', link: 'https://github.com/your-org/lilWAN_SHOP02' },
          { text: '问题反馈', link: 'https://github.com/your-org/lilWAN_SHOP02/issues' }
        ]
      }
    ],
    
    sidebar: {
      '/plugin-development/': [
        {
          text: '入门',
          collapsed: false,
          items: [
            { text: '快速开始', link: '/plugin-development/01-快速开始' },
            { text: '插件结构', link: '/plugin-development/02-插件结构' }
          ]
        },
        {
          text: '核心概念',
          collapsed: false,
          items: [
            { text: 'TCALS配置', link: '/plugin-development/03-TCALS配置' },
            { text: '插件接口', link: '/plugin-development/04-插件接口' },
            { text: '数据库迁移', link: '/plugin-development/05-数据库迁移' },
            { text: '前端开发', link: '/plugin-development/06-前端开发' }
          ]
        },
        {
          text: '进阶',
          collapsed: false,
          items: [
            { text: '权限系统', link: '/plugin-development/07-权限系统' },
            { text: 'Hook事件', link: '/plugin-development/08-Hook事件' },
            { text: '测试指南', link: '/plugin-development/09-测试指南' }
          ]
        },
        {
          text: '其他',
          collapsed: false,
          items: [
            { text: '发布上线', link: '/plugin-development/10-发布上线' },
            { text: '最佳实践', link: '/plugin-development/11-最佳实践' },
            { text: 'FAQ', link: '/plugin-development/12-FAQ' }
          ]
        }
      ],
      
      '/examples/': [
        {
          text: '示例插件',
          items: [
            { text: '概览', link: '/examples/' },
            { text: '简单折扣', link: '/examples/simple-discount' },
            { text: '生日优惠券', link: '/examples/birthday-coupon' },
            { text: '限时秒杀', link: '/examples/flash-sale' }
          ]
        }
      ],
      
      '/docs/api/': [
        {
          text: 'API 概览',
          collapsed: false,
          items: [
            { text: '接口规范总览', link: '/docs/api/overview' },
            { text: 'Apifox 导入与使用指南', link: '/docs/api/apifox-guide' }
          ]
        },
        {
          text: '开发指南',
          collapsed: false,
          items: [
            { text: '认证说明', link: '/docs/api/guidelines/authentication' },
            { text: '错误处理规范', link: '/docs/api/guidelines/error-handling' },
            { text: '常见错误码使用指南', link: '/docs/api/guidelines/error-codes' },
            { text: '前端错误提示规范', link: '/docs/api/guidelines/frontend-errors' },
            { text: '分页说明', link: '/docs/api/guidelines/pagination' }
          ]
        },
        {
          text: '管理后台API（/admin）',
          collapsed: false,
          items: [
            { text: '完整接口清单', link: '/docs/api/admin-api-reference' },
            { text: '用户管理', link: '/docs/api/admin/user-management' },
            { text: '系统管理', link: '/docs/api/admin/system-management' },
            { text: '营销管理', link: '/docs/api/admin/marketing-management' },
            { text: '财务管理', link: '/docs/api/admin/finance-management' },
            { text: 'CMS内容管理', link: '/docs/api/admin/cms-management' }
          ]
        },
        {
          text: '商城API（/api/v1）',
          collapsed: false,
          items: [
            { text: '认证管理', link: '/docs/api/mall/authentication' },
            { text: '用户中心', link: '/docs/api/mall/user-center' },
            { text: '商品浏览', link: '/docs/api/mall/product-browsing' },
            { text: '购物车与订单', link: '/docs/api/mall/cart-order' },
            { text: '营销活动', link: '/docs/api/mall/marketing-activities' },
            { text: '系统配置', link: '/docs/api/mall/system-config' }
          ]
        }
      ]
    },
    
    socialLinks: [
      { icon: 'github', link: 'https://github.com/your-org/lilWAN_SHOP02' }
    ],
    
    search: {
      provider: 'local'
    },
    
    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2025 lilWAN Development Team'
    },
    
    editLink: {
      pattern: 'https://github.com/your-org/lilWAN_SHOP02/edit/main/docs/:path',
      text: '在 GitHub 上编辑此页'
    },
    
    lastUpdated: {
      text: '最后更新于',
      formatOptions: {
        dateStyle: 'full',
        timeStyle: 'medium'
      }
    }
  },
  
  markdown: {
    lineNumbers: true
  }
})

