# Cashier Module - Complete API Endpoints Summary

## All API Endpoints Created

### Base URL
`/api/v1/cashier`

---

## 1. Shift Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/shift` | Check active shift |
| POST | `/shift` | Start new shift |
| GET | `/shift/{id}` | Get shift details |
| PUT | `/shift/{id}` | Close shift |
| GET | `/shift/get_all_cashier_log` | Get all shift logs |
| PUT | `/shift/{id}/update_opening_balance` | Update opening balance |
| PUT | `/shift/{id}/approve_opening_balance` | Approve opening balance |
| PUT | `/shift/{id}/verify_closing_balance` | Verify closing balance (Accounts) |
| PUT | `/shift/{id}/update_closing_balance` | Update closing balance (Accounts) |

---

## 2. Cash Handover

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/handover` | Get all handover logs |
| GET | `/handover/{id}` | Get single handover |
| PUT | `/handover/{id}` | Update handover amount |
| PUT | `/handover/{id}/verify` | Verify handover (Accounts) |
| GET | `/handover/{id}/voucher` | Generate handover voucher PDF |

---

## 3. Shift Summary

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/shift_summary` | Get all shift summaries |
| GET | `/shift_summary/{id}` | Get single summary |

---

## 4. Transaction Ledger

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/transaction_ledger` | Get all transactions |
| GET | `/transaction_ledger/{id}` | Get single transaction |
| GET | `/transaction_ledger/by_shift/{shiftId}` | Get transactions by shift |
| GET | `/transaction_ledger/reversals` | Get all reversal transactions |

---

## 5. Cash Movements

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/cash_movement` | Get all cash movements |
| POST | `/cash_movement` | Create cash movement (in/out) |
| GET | `/cash_movement/{id}` | Get single movement |
| PUT | `/cash_movement/{id}` | Approve cash out movement |
| DELETE | `/cash_movement/{id}` | Delete movement (IOU cannot be deleted) |

---

## 6. Shift Adjustments

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/shift_adjustment` | Get all adjustments (optional: ?shift_id=X) |
| POST | `/shift_adjustment` | Create adjustment |
| GET | `/shift_adjustment/{id}` | Get single adjustment |
| PUT | `/shift_adjustment/{id}` | Update adjustment |
| DELETE | `/shift_adjustment/{id}` | Delete adjustment |

---

## 7. IOU Settlements

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/iou_settlement` | Get all settlements (optional filters: cash_movement_id, settlement_type) |
| POST | `/iou_settlement` | Create settlement (Accounts only) |
| GET | `/iou_settlement/{id}` | Get single settlement |
| PUT | `/iou_settlement/{id}` | Update settlement |
| DELETE | `/iou_settlement/{id}` | Delete settlement |
| GET | `/iou_settlement/outstanding/list` | Get outstanding IOUs |

---

## 8. Cashier Authorization/Session

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/auth/authorize` | Authorize user as cashier |
| GET | `/auth/session` | Check cashier session status |
| POST | `/auth/logout` | Logout cashier (optional: close_shift=true) |

---

## 9. Reports

| Method | Endpoint | Description | Parameters |
|--------|----------|-------------|------------|
| GET | `/reports/daily_summary` | Daily cashier summary | `date` (required) |
| GET | `/reports/payment_summary` | Payment summary by method | `start_date`, `end_date` (required) |
| GET | `/reports/discrepancy` | Shift discrepancy report | `shift_id` (optional), `start_date`, `end_date` (optional) |
| GET | `/reports/cash_out_summary` | Cash out summary by shift | `shift_id` (optional), `start_date`, `end_date` (optional) |
| GET | `/reports/outstanding_ious` | Outstanding IOUs report | `shift_id` (optional) |

---

## Request/Response Examples

### Start Shift
**POST** `/cashier/shift`
```json
{
    "opening_balance_cash": 5000.00,
    "opening_balance_slips": 0.00,
    "opening_balance_cheques": 0.00
}
```

### Create Adjustment
**POST** `/cashier/shift_adjustment`
```json
{
    "cashier_shift_id": 1,
    "adjustment_type": "correction",
    "amount": -50.00,
    "remarks": "Correction for error"
}
```

### Create IOU Settlement
**POST** `/cashier/iou_settlement`
```json
{
    "cash_movement_id": 5,
    "settlement_type": "cash_return",
    "settlement_amount": 1000.00,
    "settlement_date": "2024-01-15",
    "remarks": "Cash returned by employee"
}
```

### Daily Summary Report
**GET** `/cashier/reports/daily_summary?date=2024-01-15`
```json
{
    "status": true,
    "data": {
        "date": "2024-01-15",
        "totals": {
            "total_shifts": 2,
            "total_invoices": 45,
            "total_sales": 125000.00,
            "cash_total": 75000.00,
            "card_total": 40000.00,
            "cheque_total": 10000.00
        }
    }
}
```

---

## Authentication

All endpoints require JWT authentication via `auth:api` middleware.

Headers required:
```
Authorization: Bearer {token}
Accept: application/json
```

---

## Error Responses

Standard error format:
```json
{
    "status": false,
    "message": "Error description",
    "code": 400
}
```

Common HTTP Status Codes:
- `200` - Success
- `201` - Created
- `400` - Bad Request / Validation Error
- `401` - Unauthorized
- `404` - Not Found
- `500` - Server Error

---

## Notes

1. All monetary values are in decimal format (e.g., `1000.50`)
2. Dates should be in `Y-m-d` format (e.g., `2024-01-15`)
3. All endpoints are branch-scoped (user's branch_id automatically applied)
4. Legacy endpoints still work for backward compatibility

