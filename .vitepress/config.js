import { defineConfig } from 'vitepress'

export default defineConfig({
  title: '营销插件开发文档',
  description: '完整的插件开发指南 - lilWAN Shop',
  base: '/lilWAN_SHOP02-docs/',
  
  themeConfig: {
    logo: '/logo.svg',
    
    nav: [
      { text: '指南', link: '/plugin-development/' },
      { text: '示例', link: '/examples/' },
      { text: 'API', link: '/plugin-development/04-插件接口' },
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

