# 管理后台 - 财务管理API

::: tip 路由前缀
所有接口使用 `/admin/finance` 前缀
:::

## 财务账户管理

### 账户列表

```http
GET /admin/finance/accounts
```

**说明**：查看所有财务账户（平台账户、商户账户等）

**返回**：
- 账户ID
- 账户类型
- 账户余额
- 可用余额
- 冻结金额

### 账户详情

```http
GET /admin/finance/accounts/{id}
```

**返回**：
- 账户信息
- 余额详情
- 近期流水汇总

---

## 财务流水管理

### 流水列表

```http
GET /admin/finance/flows
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `account_id`: 账户ID
- `type`: 流水类型（income/expense）
- `category`: 流水分类（order/refund/withdrawal/adjustment）
- `start_date`: 开始日期
- `end_date`: 结束日期

**返回**：
- 流水列表
- 收入总额
- 支出总额
- 净流入

### 流水详情

```http
GET /admin/finance/flows/{id}
```

**返回**：
- 流水信息
- 关联订单/退款等业务数据

---

## 对账管理

### 对账单列表

```http
GET /admin/finance/reconciliations
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `status`: 状态（pending/success/failed）
- `channel`: 支付渠道（alipay/wechat/balance）
- `start_date`: 开始日期
- `end_date`: 结束日期

### 手动触发对账

```http
POST /admin/finance/reconciliations
```

**请求参数**：
- `channel`: 支付渠道
- `date`: 对账日期

**说明**：手动触发对账任务，通常由定时任务自动执行

### 对账单详情

```http
GET /admin/finance/reconciliations/{id}
```

**返回**：
- 对账单基本信息
- 对账结果
- 差异明细（如有）

---

## 发票管理

### 发票列表

```http
GET /admin/finance/invoices
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `status`: 状态（pending/issued/cancelled）
- `type`: 类型（personal/company）
- `order_no`: 订单号
- `start_date`: 开始日期
- `end_date`: 结束日期

### 发票详情

```http
GET /admin/finance/invoices/{id}
```

**返回**：
- 发票信息
- 关联订单
- 开票记录

### 开具发票

```http
POST /admin/finance/invoices/{id}/issue
```

**请求参数**：
- `invoice_no`: 发票号码
- `tax_no`: 税号
- `issue_date`: 开票日期
- `remark`: 备注

### 作废发票

```http
POST /admin/finance/invoices/{id}/cancel
```

**请求参数**：
- `reason`: 作废原因

---

## 提现管理

### 提现列表

```http
GET /admin/finance/withdrawals
```

**查询参数**：
- `page`: 页码
- `per_page`: 每页数量
- `status`: 状态（pending/processing/success/failed）
- `user_id`: 用户ID
- `start_date`: 开始日期
- `end_date`: 结束日期

### 提现详情

```http
GET /admin/finance/withdrawals/{id}
```

**返回**：
- 提现信息
- 用户信息
- 银行卡信息
- 审核记录

### 审核提现

```http
POST /admin/finance/withdrawals/{id}/audit
```

**请求参数**：
- `status`: 审核结果（approved/rejected）
- `remark`: 备注

**说明**：审核通过后进入"处理中"状态

### 完成提现

```http
POST /admin/finance/withdrawals/{id}/complete
```

**请求参数**：
- `transaction_no`: 交易流水号（第三方支付平台）
- `remark`: 备注

**说明**：实际打款完成后调用

---

## 财务统计

### 财务统计概览

```http
GET /admin/finance/statistics
```

**查询参数**：
- `start_date`: 开始日期
- `end_date`: 结束日期

**返回**：
- 总收入
- 总支出
- 待结算金额
- 提现金额
- 退款金额
- 利润

