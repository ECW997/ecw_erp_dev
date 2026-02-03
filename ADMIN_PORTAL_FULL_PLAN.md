# Admin Portal - Emergency Actions Module
## Complete Project Plan & Implementation Guide

---

## Table of Contents
1. [Executive Summary](#executive-summary)
2. [Project Overview](#project-overview)
3. [Requirements Analysis](#requirements-analysis)
4. [System Architecture](#system-architecture)
5. [Modular File Structure](#modular-file-structure)
6. [Action Type Registry](#action-type-registry)
7. [Database Design](#database-design)
8. [Implementation Plan](#implementation-plan)
8. [Security & Access Control](#security--access-control)
9. [Testing Strategy](#testing-strategy)
10. [Deployment Plan](#deployment-plan)
11. [User Training & Documentation](#user-training--documentation)
12. [Maintenance & Support](#maintenance--support)
13. [Risk Management](#risk-management)
14. [Timeline & Milestones](#timeline--milestones)
15. [Appendices](#appendices)

---

## Executive Summary

### Purpose
The Admin Portal Emergency Actions Module provides administrators with a secure, audited platform to perform emergency actions when critical issues occur. The system is designed as a unified cancellation action that handles Sales Order Relations and ALL their linked items (Sales Orders, Invoices, Payments, Temp Payments) as one integrated operation.

### Key Objectives
- Provide admin-only emergency action platform for unified cancellation operations
- Implement unified Sales Order Relation Cancellation that handles ALL linked items as one action:
  - Sales Orders (Header & Details)
  - Exclude Sales Orders (Header & Details)
  - Invoices (Header & Details)
  - Exclude Invoices (Header & Details)
  - Payments (Header, Details, Allocations)
  - Temp Payments (Header, Details, Allocations)
- Ensure all linked items are cancelled together in a single transaction (all or nothing)
- Maintain comprehensive audit trail for unified cancellation actions
- Enforce branch-level security for all operations
- Support irreversible emergency actions with proper safeguards

### Business Value
- **Risk Mitigation**: Quick response to critical data issues across multiple modules
- **Compliance**: Complete audit trail for regulatory requirements
- **Data Integrity**: Ensures all related records are handled consistently
- **Security**: Admin-only access with branch restrictions
- **Scalability**: Framework allows adding new emergency action types without major refactoring

---

## Project Overview

### Scope
**Unified Sales Order Relation Cancellation (Current Implementation):**
- **Single Unified Action** that cancels Sales Order Relation and ALL linked items together:
  - Sales Order Relation (main entity)
  - Linked Sales Orders (Header & Details)
  - Linked Exclude Sales Orders (Header & Details)
  - Linked Invoices (Header & Details)
  - Linked Exclude Invoices (Header & Details)
  - Linked Regular Payments (Header, Details, Allocations)
  - Linked Temp Payments (Header, Details, Allocations)
- All items cancelled in one transaction (all or nothing)

**Common Framework:**
- Comprehensive audit logging system
- Admin access control
- Branch verification
- Common UI components
- Common API structure

**Future Phases (Out of Scope for Phase 1):**
- All linked items (sales orders, invoices, payments, temp payments) are cancelled together as one unified action
- Other emergency action types (Phase 4+)
- Approval workflows (future enhancement)
- Email notifications (future enhancement)
- Reversal/undo functionality (by design - irreversible)
- Bulk operations (future enhancement)

### Stakeholders
- **System Administrators**: Primary users
- **IT Department**: Implementation and maintenance
- **Management**: Approval and oversight
- **Audit Team**: Review logs and compliance

---

## Requirements Analysis

### Functional Requirements

#### FR1: Admin Access Control
- **Requirement**: Only users with admin user type IDs can access the module
- **Priority**: Critical
- **Acceptance Criteria**:
  - Non-admin users are redirected to logout
  - Admin check performed on every request
  - User type IDs configurable

#### FR2: Extensible Emergency Action System
- **Requirement**: Support multiple types of emergency actions through a common framework
- **Priority**: Critical
- **Acceptance Criteria**:
  - Action types stored in database with type identifier
  - Common execution framework handles all action types
  - Each action type can have its own cancellation logic
  - Action type can be easily added without major code changes

#### FR2.1: Sales Order Cancellation (Phase 1)
- **Requirement**: Cancel sales order relation and all linked records
- **Priority**: Critical
- **Action Type**: `SALES_ORDER_CANCEL`
- **Acceptance Criteria**:
  - Sales Order Header & Details cancelled
  - Exclude Sales Order Header & Details cancelled
  - All linked invoices cancelled
  - All linked exclude invoices cancelled
  - All linked payments cancelled
  - All linked temp payments cancelled
  - Sales Order Relation marked as cancelled

#### FR2.2: Unified Cancellation Scope
- **Requirement**: System designed to support additional action types
- **Priority**: Medium
- **Future Action Types**:
  - `INVOICE_CANCEL` - Cancel invoice and linked payments
  - `PAYMENT_CANCEL` - Cancel payment and allocations
  - `JOB_CARD_CANCEL` - Cancel job card and all related records
  - (More types can be added as needed)

#### FR3: Branch Verification
- **Requirement**: Users can only perform actions on their branch
- **Priority**: Critical
- **Acceptance Criteria**:
  - Double-check branch before action
  - Branch mismatch prevents action
  - Error message displayed on mismatch

#### FR4: Audit Logging
- **Requirement**: All actions logged with complete details
- **Priority**: Critical
- **Acceptance Criteria**:
  - Action type logged
  - User information logged
  - Branch information logged
  - Reason for action logged
  - Detailed cancellation results logged
  - Timestamp recorded
  - Error messages logged for failures

#### FR5: Verification Before Action
- **Requirement**: Show all linked records before cancellation
- **Priority**: High
- **Acceptance Criteria**:
  - Display sales order details
  - Display linked invoices count
  - Display linked payments count
  - Display linked temp payments count
  - Require confirmation checkbox
  - Require reason input

### Non-Functional Requirements

#### NFR1: Performance
- Response time: < 3 seconds for verification
- Action execution: < 10 seconds for complete cancellation
- Log retrieval: < 2 seconds for paginated results

#### NFR2: Security
- Admin-only access enforced
- Branch-level restrictions
- Transaction safety (rollback on errors)
- SQL injection prevention (using Eloquent/Query Builder)

#### NFR3: Reliability
- 99.9% uptime
- Transaction rollback on errors
- Failed actions logged separately
- No partial cancellations

#### NFR4: Usability
- Intuitive interface
- Clear warnings about irreversible actions
- Detailed verification information
- Easy log viewing and filtering

---

## System Architecture

### Architecture Overview
```
┌─────────────────────────────────────────────────────────────┐
│                    Frontend (CodeIgniter)                    │
│  ┌───────────────────────────────────────────────────────┐  │
│  │  AdminPortal Controller (Common Framework)             │  │
│  │  - Access Control (Common)                             │  │
│  │  - Request Handling (Common)                            │  │
│  │  - View Rendering (Extensible)                         │  │
│  └───────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────┐  │
│  │  AdminPortalinfo Model (Common)                        │  │
│  │  - API Communication                                  │  │
│  └───────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────┐  │
│  │  Views (AdminPortal/) - Common Framework              │  │
│  │  - index.php (Logs List - Common)                      │  │
│  │  - emergency_action_form.php (Extensible)             │  │
│  │  - view_log.php (Common)                                │  │
│  └───────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ HTTP/HTTPS
                            │ (API Calls)
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                 Backend API (Laravel)                       │
│  ┌───────────────────────────────────────────────────────┐ │
│  │  AdminPortalController (Common Framework)               │ │
│  │  - Admin Access Check (Common)                          │ │
│  │  - Branch Verification (Common)                         │ │
│  │  - Emergency Action Execution (Extensible)              │ │
│  │    ├── Sales Order Cancellation (Phase 1)              │ │
│  │    ├── Invoice Cancellation (Phase 2 - Future)         │ │
│  │    └── Payment Cancellation (Phase 3 - Future)         │ │
│  │  - Log Management (Common)                              │ │
│  └───────────────────────────────────────────────────────┘ │
│  ┌───────────────────────────────────────────────────────┐ │
│  │  Models                                                │ │
│  │  - SalesOrderCancellationLog (Phase 1)                    │ │
│  │  - SalesOrderRelation (Phase 1)                         │ │
│  │  - SalesOrderHeader/Detail (Phase 1)                   │ │
│  │  - ExcludeSalesOrderHeader/Detail (Phase 1)            │ │
│  │  - Invoice/InvoiceDetail (Phase 1, Phase 2)            │ │
│  │  - ExcludeInvoice/ExcludeInvoiceDetail (Phase 1)       │ │
│  │  - PayHeader/PayDetails/PayAllocation (Phase 1, Phase 3)│ │
│  └───────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ Database Queries
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                    Database (MySQL)                         │
│  ┌───────────────────────────────────────────────────────┐ │
│  │  Common Tables (All Action Types)                      │ │
│  │  - admin_portal_sales_order_cancellation_logs (Phase 1) │ │
│  │  - admin_portal_settings                               │ │
│  └───────────────────────────────────────────────────────┘ │
│  ┌───────────────────────────────────────────────────────┐ │
│  │  Business Tables (Used by Action Types)                │ │
│  │  - sales_order_relation (Phase 1)                      │ │
│  │  - sales_orders_header/detail (Phase 1)                │ │
│  │  - exclude_sales_orders_header/detail (Phase 1)         │ │
│  │  - inv_header/inv_details (Phase 1, Phase 2)           │ │
│  │  - exclude_inv_header/exclude_inv_details (Phase 1)    │ │
│  │  - pay_header/pay_details/pay_allocation (Phase 1, Phase 3)│ │
│  │  - temp_pay_header/temp_pay_details/temp_pay_allocation│ │
│  └───────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

### Technology Stack
- **Frontend**: CodeIgniter 3.x, jQuery, DataTables, Bootstrap
- **Backend**: Laravel 8.x+, PHP 7.4+
- **Database**: MySQL 5.7+
- **Authentication**: JWT (JSON Web Tokens)
- **API**: RESTful API

### Modular Architecture Principles
- **Separation of Concerns**: Each action type is self-contained
- **Common Framework**: Shared functionality (admin check, branch verification, logging)
- **Action-Specific**: Each action type has its own controller, model, views, and tables
- **Extensibility**: New action types can be added without modifying existing code
- **Consistency**: All action types follow the same pattern and structure

### Action Type Registry

The system uses a configuration file to register all action types:

**`application/config/admin_portal_actions.php`**:
- Defines all available action types
- Maps action types to their controllers, models, and tables
- Controls which action types are enabled
- Provides metadata (icons, descriptions, menu order)

**Benefits**:
- Centralized configuration
- Easy enabling/disabling of action types
- Dynamic menu generation
- Consistent structure across all action types

### Data Flow

#### Common Emergency Action Flow (All Action Types)
```
1. User accesses Admin Portal
   ↓
2. Admin check (Common Framework - Controller Constructor)
   ↓
3. User selects Action Type (e.g., Sales Order Cancellation)
   ↓
4. User enters relevant ID (e.g., Sales Order Relation ID)
   ↓
5. System verifies and loads details (Action-specific)
   ↓
6. User reviews linked records (Action-specific)
   ↓
7. User enters reason and confirms
   ↓
8. System verifies branch match (Common Framework)
   ↓
9. System starts database transaction (Common Framework)
   ↓
10. System executes unified cancellation logic:
    - Cancels Sales Order Relation and ALL linked items together:
      - Sales Orders, Exclude Sales Orders
      - Invoices, Exclude Invoices
      - Payments, Temp Payments
    - All items cancelled in single transaction
   ↓
11. System logs action (Common Framework)
   ↓
12. System commits transaction (Common Framework)
   ↓
13. System returns success response
```

#### Unified Sales Order Relation Cancellation Flow
```
Steps 1-8: Same as Common Flow above
   ↓
9. System starts unified cancellation (single transaction):
   ↓
10. System cancels Sales Order Header & Details
   ↓
11. System cancels Exclude Sales Order Header & Details
   ↓
12. System cancels Linked Invoices & Invoice Details
   ↓
13. System cancels Linked Exclude Invoices & Details
   ↓
14. System cancels Linked Temp Payments (Header, Details, Allocations)
   ↓
15. System cancels Linked Regular Payments (Header, Details, Allocations)
   ↓
16. System cancels Sales Order Relation (Main entity)
   ↓
17. System logs unified action with action_type='SALES_ORDER_RELATION_CANCEL'
    (Log includes all cancelled items: sales orders, invoices, payments, temp payments)
   ↓
18. System commits transaction (all or nothing)
```

**Key Point**: All linked items (sales orders, invoices, payments, temp payments) are cancelled together as ONE unified action, not as separate operations.

---

## Modular File Structure

### Overview
The Admin Portal uses a modular architecture where each emergency action type is implemented as a separate module. This allows for:
- **Easy Addition**: New action types can be added without modifying existing code
- **Clean Separation**: Each action type is self-contained
- **Maintainability**: Changes to one action type don't affect others
- **Scalability**: System can grow to support many action types

### Current Structure (Phase 1)

#### Frontend Structure
```
application/
├── controllers/
│   └── AdminPortal.php                    # Main controller (Common Framework)
├── models/
│   └── AdminPortalinfo.php                # Common API model
└── views/
    └── AdminPortal/
        ├── index.php                      # Main dashboard (Common)
        ├── emergency_action_form.php      # Sales Order Cancellation form
        └── view_log.php                    # Log details (Common)
```

#### Backend Structure
```
app/
├── Http/Controllers/v1/
│   └── AdminPortalController.php          # Main controller (Common Framework)
└── Models/AdminPortal/
    └── SalesOrderCancellationLog.php      # Sales Order Cancellation logs
```

### Recommended Modular Structure (For Future Expansion)

#### Frontend Structure
```
application/
├── controllers/
│   └── AdminPortal/
│       ├── AdminPortal.php                # Main controller (Common)
│       └── Actions/
│           ├── SalesOrderCancellation.php  # Sales Order Cancellation
│           ├── InvoiceCancellation.php    # Invoice Cancellation (Future)
│           └── PaymentCancellation.php    # Payment Cancellation (Future)
├── models/
│   └── AdminPortal/
│       ├── AdminPortalinfo.php            # Common API model
│       └── Actions/
│           ├── SalesOrderCancellationinfo.php
│           ├── InvoiceCancellationinfo.php # Future
│           └── PaymentCancellationinfo.php # Future
└── views/
    └── AdminPortal/
        ├── Common/
        │   ├── index.php                  # Main dashboard
        │   └── view_log.php               # Log details
        └── Actions/
            ├── SalesOrderCancellation/
            │   ├── form.php
            │   └── details.php
            ├── InvoiceCancellation/        # Future
            └── PaymentCancellation/        # Future
```

#### Backend Structure
```
app/
├── Http/Controllers/v1/AdminPortal/
│   ├── AdminPortalController.php          # Common framework
│   └── Actions/
│       ├── SalesOrderCancellationController.php
│       ├── InvoiceCancellationController.php    # Future
│       └── PaymentCancellationController.php    # Future
└── Models/AdminPortal/Actions/
    ├── SalesOrderCancellationLog.php
    ├── InvoiceCancellationLog.php         # Future
    └── PaymentCancellationLog.php         # Future
```

### Action Type Registry

Create a configuration file to register all action types:

**`application/config/admin_portal_actions.php`**:
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['admin_portal_actions'] = [
    'SALES_ORDER_CANCEL' => [
        'name' => 'Sales Order Cancellation',
        'controller' => 'SalesOrderCancellation',
        'model' => 'SalesOrderCancellationinfo',
        'log_model' => 'SalesOrderCancellationLog',
        'table' => 'admin_portal_sales_order_cancellation_logs',
        'enabled' => true,
        'menu_icon' => 'fas fa-shopping-cart',
        'menu_order' => 1
    ],
    'INVOICE_CANCEL' => [
        'name' => 'Invoice Cancellation',
        'controller' => 'InvoiceCancellation',
        'model' => 'InvoiceCancellationinfo',
        'log_model' => 'InvoiceCancellationLog',
        'table' => 'admin_portal_invoice_cancellation_logs',
        'enabled' => false,
        'menu_icon' => 'fas fa-file-invoice',
        'menu_order' => 2
    ],
    'PAYMENT_CANCEL' => [
        'name' => 'Payment Cancellation',
        'controller' => 'PaymentCancellation',
        'model' => 'PaymentCancellationinfo',
        'log_model' => 'PaymentCancellationLog',
        'table' => 'admin_portal_payment_cancellation_logs',
        'enabled' => false,
        'menu_icon' => 'fas fa-money-bill-wave',
        'menu_order' => 3
    ]
];
```

### Benefits of Modular Structure

1. **Isolation**: Each action type is isolated, reducing risk of breaking other features
2. **Team Collaboration**: Different developers can work on different action types simultaneously
3. **Testing**: Each action type can be tested independently
4. **Deployment**: Action types can be enabled/disabled independently
5. **Code Reuse**: Common framework code is reused across all action types
6. **Documentation**: Each action type can have its own documentation

### Migration Path

**Current State**: All code in main AdminPortal files
**Future State**: Modular structure with separate folders for each action type

**Migration Steps**:
1. Keep current structure working
2. Create new modular structure alongside
3. Gradually migrate Sales Order Cancellation to modular structure
4. Test thoroughly
5. Remove old structure once migration complete
6. Use modular structure for all new action types

---

## Database Design

### Tables Created

#### 1. admin_portal_sales_order_cancellation_logs
**Purpose**: Logging table for Sales Order Cancellation emergency actions (Phase 1)

```sql
CREATE TABLE `admin_portal_sales_order_cancellation_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` varchar(50) NOT NULL DEFAULT 'SALES_ORDER_CANCEL' COMMENT 'Action type identifier',
  -- Sales Order Cancellation specific reference fields
  `sales_order_relation_id` int(11) DEFAULT NULL COMMENT 'Reference to sales_order_relation.id',
  `sales_order_header_id` int(11) DEFAULT NULL COMMENT 'Reference to sales_orders_header.id',
  `exclude_sales_order_header_id` int(11) DEFAULT NULL COMMENT 'Reference to exclude_sales_orders_header.id',
  `invoice_id` int(11) DEFAULT NULL COMMENT 'Reference to inv_header.id (if single invoice cancelled)',
  `exclude_invoice_id` int(11) DEFAULT NULL COMMENT 'Reference to exclude_inv_header.id',
  `payment_id` int(11) DEFAULT NULL COMMENT 'Reference to pay_header.id (if single payment cancelled)',
  `temp_payment_id` int(11) DEFAULT NULL COMMENT 'Reference to temp_pay_header.id',
  `job_card_id` int(11) DEFAULT NULL COMMENT 'Reference to job_card.id',
  -- Common fields
  `reason` text NOT NULL COMMENT 'Reason for emergency action',
  `action_details` text DEFAULT NULL COMMENT 'JSON details of what was cancelled/handled',
  `status` varchar(20) NOT NULL DEFAULT 'PENDING' COMMENT 'SUCCESS, FAILED, PENDING',
  `error_message` text DEFAULT NULL COMMENT 'Error message if action failed',
  `user_id` int(11) NOT NULL COMMENT 'Reference to tbl_user.idtbl_user',
  `branch_id` int(11) NOT NULL COMMENT 'Reference to company_branch.id',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_action_type` (`action_type`),
  KEY `idx_sales_order_relation_id` (`sales_order_relation_id`),
  KEY `idx_sales_order_header_id` (`sales_order_header_id`),
  KEY `idx_exclude_sales_order_header_id` (`exclude_sales_order_header_id`),
  KEY `idx_invoice_id` (`invoice_id`),
  KEY `idx_exclude_invoice_id` (`exclude_invoice_id`),
  KEY `idx_payment_id` (`payment_id`),
  KEY `idx_temp_payment_id` (`temp_payment_id`),
  KEY `idx_job_card_id` (`job_card_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_branch_id` (`branch_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Log table for Sales Order Cancellation emergency actions';
```

**Design Notes**:
- Table specifically designed for Sales Order Cancellation logs
- `action_type` field defaults to 'SALES_ORDER_CANCEL' but can be used for variations
- All reference fields are nullable to accommodate different scenarios
- `action_details` JSON field stores complete cancellation details (all cancelled records)
- Indexes added for efficient querying by relation, invoice, payment, user, branch, etc.
- For future action types, separate tables can be created following this pattern:
  - `admin_portal_invoice_cancellation_logs` (Phase 2)
  - `admin_portal_payment_cancellation_logs` (Phase 3)
  - etc.

#### 2. admin_portal_settings
```sql
CREATE TABLE `admin_portal_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Tables Modified by Action Type

#### Sales Order Cancellation (SALES_ORDER_CANCEL) - Phase 1
- `sales_order_relation` - Status set to 'CANCELLED'
- `sales_orders_header` - Status set to 'CANCELLED'
- `sales_orders_detail` - Status set to 'CANCELLED'
- `exclude_sales_orders_header` - Status set to 'CANCELLED'
- `exclude_sales_orders_detail` - Status set to 'CANCELLED'
- `inv_header` - Status set to 'CANCELLED'
- `inv_details` - Status set to 'CANCELLED'
- `exclude_inv_header` - Status set to 'CANCELLED'
- `exclude_inv_details` - Status set to 'CANCELLED'
- `pay_header` - Status set to 'CANCELLED'
- `pay_details` - Status set to 'CANCELLED'
- `pay_allocation` - Status set to 'CANCELLED'
- `temp_pay_header` - Status set to 'CANCELLED'
- `temp_pay_details` - Status set to 'CANCELLED'
- `temp_pay_allocation` - Status set to 'CANCELLED'
- **Log Table**: `admin_portal_sales_order_cancellation_logs`

**Note**: There are no separate cancellation actions for invoices or payments. All linked items are cancelled together as part of the unified Sales Order Relation Cancellation action.

---

## Implementation Plan

### Phase 1: Common Framework Development ✅
**Status**: Completed
- [x] Create common database tables (extensible design)
- [x] Add indexes for performance
- [x] Test table creation script
- [x] Design extensible action type system

### Phase 2: Backend API Development - Common Framework ✅
**Status**: Completed
- [x] Create AdminPortalController (common framework)
- [x] Implement admin access check (common for all actions)
- [x] Implement branch verification (common for all actions)
- [x] Implement common log retrieval system
- [x] Add API routes (extensible structure)
- [x] Create SalesOrderCancellationLog model (Phase 1)

### Phase 3: Sales Order Cancellation Implementation ✅
**Status**: Completed
- [x] Implement sales order details retrieval
- [x] Implement sales order cancellation logic
- [x] Implement temp payment cancellation
- [x] Implement comprehensive cancellation flow
- [x] Test sales order cancellation end-to-end

### Phase 4: Frontend Development - Common Framework ✅
**Status**: Completed
- [x] Create AdminPortal controller (common)
- [x] Create AdminPortalinfo model (common)
- [x] Create index view (logs list - common)
- [x] Create emergency action form view (extensible)
- [x] Create view log details view (common)
- [x] Add API endpoints to config
- [x] Implement DataTables for logs (common)
- [x] Add filtering capabilities (common)

### Phase 5: Integration & Testing
**Status**: In Progress
- [ ] Unit tests for common framework
- [ ] Unit tests for sales order cancellation
- [ ] Integration tests for API
- [ ] Frontend JavaScript testing
- [ ] End-to-end testing (sales order cancellation)
- [ ] Security testing
- [ ] Performance testing
- [ ] Extensibility testing (verify easy addition of new action types)

### Phase 6: Documentation
**Status**: In Progress
- [x] Setup documentation
- [x] Implementation summary
- [x] Temp payments integration guide
- [x] Full project plan (this document)
- [ ] User manual
- [ ] API documentation
- [ ] Developer guide for adding new action types
- [ ] Troubleshooting guide

### Phase 7: Deployment - Phase 1 (Sales Order Cancellation)
**Status**: Pending
- [ ] Database migration
- [ ] Code deployment
- [ ] Configuration setup
- [ ] Menu item creation
- [ ] Admin user type configuration
- [ ] Smoke testing
- [ ] User training

### Phase 8: Post-Deployment & Future Enhancements
**Status**: Pending
- [ ] Monitor logs
- [ ] Collect user feedback
- [ ] Performance monitoring
- [ ] Bug fixes
- [ ] Future enhancements (if needed)
- [ ] Plan Phase 4: Other action types

---

## Security & Access Control

### Access Control Matrix

| User Type | View Logs | Execute Action | View Details |
|-----------|-----------|----------------|--------------|
| Admin     | ✅ Yes    | ✅ Yes         | ✅ Yes       |
| Manager   | ❌ No     | ❌ No          | ❌ No        |
| User      | ❌ No     | ❌ No          | ❌ No        |

### Security Measures

#### 1. Authentication
- JWT token required for all API calls
- Session-based authentication for frontend
- Token validation on every request

#### 2. Authorization
- Admin user type check in controller constructor
- Admin check in API endpoints
- Branch verification before actions

#### 3. Data Protection
- SQL injection prevention (Eloquent/Query Builder)
- XSS prevention (input sanitization)
- CSRF protection (CodeIgniter built-in)
- Input validation on all endpoints

#### 4. Audit Trail
- All actions logged
- User identification in logs
- Timestamp recording
- Error logging

### Branch Restrictions
- Users can only view logs from their branch
- Users can only execute actions on their branch
- Double-check branch match before action
- Branch mismatch returns 403 error

---

## Testing Strategy

### Test Levels

#### 1. Unit Testing
**Backend (Laravel)**
- Admin access check function
- Branch verification function
- Temp payment detection logic
- Cancellation logic for each record type

**Frontend (CodeIgniter)**
- Controller methods
- Model methods
- View rendering

#### 2. Integration Testing
- API endpoint testing
- Database transaction testing
- Error handling testing
- Branch restriction testing

#### 3. System Testing
- End-to-end emergency action flow
- Log viewing and filtering
- Error scenarios
- Performance under load

#### 4. Security Testing
- Unauthorized access attempts
- Branch mismatch attempts
- SQL injection attempts
- XSS attempts

#### 5. User Acceptance Testing
- Admin user workflow
- Error message clarity
- UI/UX evaluation
- Documentation review

### Test Cases

#### TC1: Admin Access Control
- **Test**: Non-admin user tries to access Admin Portal
- **Expected**: Redirected to logout with access denied message

#### TC2: Branch Verification
- **Test**: Admin tries to cancel sales order from different branch
- **Expected**: Action blocked with branch mismatch error

#### TC3: Sales Order Cancellation Execution
- **Test**: Admin cancels sales order relation with all linked records
- **Expected**: All records cancelled, action logged successfully with type 'SALES_ORDER_CANCEL'

#### TC4: Temp Payment Cancellation
- **Test**: Admin cancels sales order with temp payments
- **Expected**: Temp payments cancelled along with other records

#### TC5: Action Type Extensibility
- **Test**: Verify system can handle multiple action types
- **Expected**: Different action types use appropriate reference fields and logic

#### TC6: Common Framework Functionality
- **Test**: Verify common features work across all action types
- **Expected**: Admin check, branch verification, logging work for all types

#### TC7: Transaction Rollback
- **Test**: Error occurs during cancellation
- **Expected**: Transaction rolled back, error logged, no partial cancellation

#### TC8: Log Viewing
- **Test**: Admin views logs with filters (including action type filter)
- **Expected**: Correct logs displayed, filters work properly, action type filter works

#### TC9: Future Action Type Addition
- **Test**: Add new action type (e.g., INVOICE_CANCEL)
- **Expected**: New action type can be added without modifying common framework code

---

## Deployment Plan

### Pre-Deployment Checklist
- [ ] Database backup created
- [ ] Code reviewed and approved
- [ ] Tests passed
- [ ] Documentation complete
- [ ] Admin user types identified
- [ ] Menu item prepared
- [ ] Configuration files updated

### Deployment Steps

#### Step 1: Database Migration
```bash
# Connect to database
mysql -u username -p database_name

# Run SQL script
source database/admin_portal_tables.sql

# Verify tables created
SHOW TABLES LIKE 'admin_portal%';
```

#### Step 2: Backend Deployment
```bash
# Navigate to API directory
cd /path/to/api.ecw.lk

# Pull latest code
git pull origin main

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Verify routes
php artisan route:list | grep admin-portal
```

#### Step 3: Frontend Deployment
```bash
# Navigate to frontend directory
cd /path/to/ecw_erp_dev

# Pull latest code
git pull origin main

# Verify files exist
ls -la application/controllers/AdminPortal.php
ls -la application/models/AdminPortalinfo.php
ls -la application/views/AdminPortal/
```

#### Step 4: Configuration
1. Update admin user types in:
   - `application/controllers/AdminPortal.php` (line 9)
   - `app/Http/Controllers/v1/AdminPortalController.php` (line 18)

2. Add menu item:
   - Menu Name: "Admin Portal"
   - URL: `AdminPortal`
   - Icon: `fas fa-shield-alt`
   - Assign to admin user types only

#### Step 5: Verification
- [ ] Access Admin Portal URL
- [ ] Verify admin check works
- [ ] Test emergency action form
- [ ] Verify logs display
- [ ] Test with non-admin user (should be blocked)

### Rollback Plan
If issues occur:
1. Revert code changes
2. Keep database tables (for audit purposes)
3. Remove menu item
4. Notify users
5. Investigate issues
6. Fix and redeploy

---

## User Training & Documentation

### Training Materials

#### 1. User Manual
- Overview of Admin Portal
- When to use emergency actions
- Step-by-step guide
- Screenshots and examples
- Common scenarios

#### 2. Video Tutorial
- Screen recording of complete workflow
- Explanation of each step
- Warning about irreversible actions

#### 3. Quick Reference Card
- One-page guide
- Key steps
- Important warnings
- Contact information

### Training Sessions
- **Session 1**: Overview and demonstration (30 minutes)
- **Session 2**: Hands-on practice (30 minutes)
- **Session 3**: Q&A and review (15 minutes)

### Documentation Files
- `ADMIN_PORTAL_SETUP.md` - Setup guide
- `ADMIN_PORTAL_SUMMARY.md` - Implementation summary
- `ADMIN_PORTAL_TEMP_PAYMENTS.md` - Temp payments guide
- `ADMIN_PORTAL_FULL_PLAN.md` - This document
- User Manual (to be created)
- API Documentation (to be created)

---

## Maintenance & Support

### Regular Maintenance Tasks

#### Daily
- Monitor error logs
- Check for failed actions
- Review access attempts

#### Weekly
- Review action logs
- Check performance metrics
- Verify backup integrity

#### Monthly
- Analyze usage patterns
- Review security logs
- Update documentation if needed

### Support Procedures

#### Level 1: User Support
- Basic questions
- Access issues
- Usage guidance

#### Level 2: Technical Support
- Bug reports
- Performance issues
- Configuration problems

#### Level 3: Development Team
- Critical bugs
- Feature requests
- System enhancements

### Monitoring & Alerts
- Failed action alerts
- Unauthorized access alerts
- Performance degradation alerts
- Database error alerts

---

## Risk Management

### Identified Risks

#### Risk 1: Accidental Cancellation
- **Probability**: Medium
- **Impact**: High
- **Mitigation**: 
  - Confirmation checkbox required
  - Warning messages displayed
  - Reason required
  - Complete audit trail

#### Risk 2: Unauthorized Access
- **Probability**: Low
- **Impact**: Critical
- **Mitigation**:
  - Admin-only access
  - Branch restrictions
  - Audit logging
  - Regular access reviews

#### Risk 3: Data Corruption
- **Probability**: Low
- **Impact**: Critical
- **Mitigation**:
  - Transaction safety
  - Rollback on errors
  - Database backups
  - Testing before deployment

#### Risk 4: Performance Issues
- **Probability**: Low
- **Impact**: Medium
- **Mitigation**:
  - Database indexes
  - Query optimization
  - Pagination for logs
  - Performance monitoring

#### Risk 5: Incomplete Cancellation
- **Probability**: Low
- **Impact**: High
- **Mitigation**:
  - Transaction wrapping
  - Comprehensive testing
  - Error handling
  - Logging all steps

### Risk Register
| Risk ID | Description | Probability | Impact | Mitigation Status |
|---------|-------------|-------------|--------|-------------------|
| R1 | Accidental Cancellation | Medium | High | ✅ Mitigated |
| R2 | Unauthorized Access | Low | Critical | ✅ Mitigated |
| R3 | Data Corruption | Low | Critical | ✅ Mitigated |
| R4 | Performance Issues | Low | Medium | ✅ Mitigated |
| R5 | Incomplete Cancellation | Low | High | ✅ Mitigated |

---

## Timeline & Milestones

### Project Timeline

#### Week 1: Planning & Design ✅
- Requirements gathering
- Architecture design (common framework)
- Database design (extensible structure)
- **Status**: Completed

#### Week 2: Common Framework Development ✅
- Backend API common framework
- Frontend common components
- Database setup (extensible tables)
- **Status**: Completed

#### Week 3: Sales Order Cancellation Implementation ✅
- Sales order cancellation logic
- Temp payment handling
- Integration with common framework
- **Status**: Completed

#### Week 4: Testing & Documentation
- Unit testing (common framework + sales order cancellation)
- Integration testing
- Documentation completion
- Extensibility testing
- **Status**: In Progress

#### Week 5: Deployment & Training (Phase 1)
- Deployment to staging
- User acceptance testing (sales order cancellation)
- User training
- Production deployment
- **Status**: Pending

#### Future Weeks: Additional Action Types
- Week 6+: Future enhancements (if needed)
- Week 10+: Other action types (Phase 4+)

### Milestones

| Milestone | Description | Target Date | Status |
|-----------|-------------|-------------|--------|
| M1 | Requirements Complete | Week 1 | ✅ Complete |
| M2 | Common Framework Design Complete | Week 1 | ✅ Complete |
| M3 | Database Setup Complete (Extensible) | Week 2 | ✅ Complete |
| M4 | Common Backend Framework Complete | Week 2 | ✅ Complete |
| M5 | Common Frontend Framework Complete | Week 2 | ✅ Complete |
| M6 | Unified Sales Order Relation Cancellation Complete | Week 3 | ✅ Complete |
| M7 | Testing Complete | Week 4 | 🔄 In Progress |
| M8 | Documentation Complete | Week 4 | 🔄 In Progress |
| M9 | Staging Deployment | Week 5 | ⏳ Pending |
| M10 | Production Deployment | Week 5 | ⏳ Pending |
| M11 | User Training Complete | Week 5 | ⏳ Pending |
| M12 | Future Enhancements Planning | Week 6 | ⏳ Pending |

---

## Appendices

### Appendix A: Modular File Structure

#### Current Structure (Phase 1 - Sales Order Cancellation)
```
ecw_erp_dev/
├── application/
│   ├── controllers/
│   │   └── AdminPortal.php                    # Main controller (Common Framework)
│   ├── models/
│   │   └── AdminPortalinfo.php                # Common API model
│   ├── views/
│   │   └── AdminPortal/
│   │       ├── index.php                      # Main dashboard (Common)
│   │       ├── emergency_action_form.php      # Sales Order Cancellation form
│   │       └── view_log.php                    # Log details (Common)
│   └── config/
│       └── api_config.php
├── database/
│   └── admin_portal_tables.sql                # Sales Order Cancellation tables
└── Documentation/
    ├── ADMIN_PORTAL_SETUP.md
    ├── ADMIN_PORTAL_SUMMARY.md
    ├── ADMIN_PORTAL_TEMP_PAYMENTS.md
    ├── ADMIN_PORTAL_FULL_PLAN.md
    └── ADMIN_PORTAL_FILE_STRUCTURE.md

api.ecw.lk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── v1/
│   │           └── AdminPortal/
│   │               └── AdminPortalController.php   # Main controller (Common Framework)
│   └── Models/
│       └── AdminPortal/
│           └── SalesOrderCancellationLog.php
└── routes/
    └── api.php
```

#### Recommended Modular Structure (For Future Action Types)
```
ecw_erp_dev/
├── application/
│   ├── controllers/
│   │   └── AdminPortal/
│   │       ├── AdminPortal.php                # Main controller (Common Framework)
│   │       └── Actions/
│   │           ├── SalesOrderCancellation.php  # Sales Order Cancellation
│   │           ├── InvoiceCancellation.php     # Invoice Cancellation (Future)
│   │           └── PaymentCancellation.php      # Payment Cancellation (Future)
│   ├── models/
│   │   └── AdminPortal/
│   │       ├── AdminPortalinfo.php            # Common API model
│   │       └── Actions/
│   │           ├── SalesOrderCancellationinfo.php
│   │           ├── InvoiceCancellationinfo.php # Future
│   │           └── PaymentCancellationinfo.php # Future
│   ├── views/
│   │   └── AdminPortal/
│   │       ├── Common/
│   │       │   ├── index.php                   # Main dashboard
│   │       │   └── view_log.php               # Log details
│   │       └── Actions/
│   │           ├── SalesOrderCancellation/
│   │           │   ├── form.php
│   │           │   └── details.php
│   │           ├── InvoiceCancellation/        # Future
│   │           └── PaymentCancellation/        # Future
│   └── config/
│       └── api_config.php
├── database/
│   └── admin_portal/
│       ├── sales_order_cancellation_tables.sql
│       ├── invoice_cancellation_tables.sql     # Future
│       └── payment_cancellation_tables.sql     # Future
└── Documentation/

api.ecw.lk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── v1/
│   │           └── AdminPortal/
│   │               └── AdminPortalController.php   # Main controller (Current)
│   │               # Future: Can add more controllers here if needed
│   │               # - LogsController.php
│   │               # - SettingsController.php
│   └── Models/
│       └── AdminPortal/
│           └── SalesOrderCancellationLog.php
└── routes/
    └── api.php
```

**Note**: Current implementation uses a simpler structure. The modular structure above is recommended for future expansion when adding more action types.

### Action Type Registry

The system uses a configuration file (`application/config/admin_portal_actions.php`) to register all action types. This allows:

- **Centralized Management**: All action types in one configuration file
- **Dynamic Menus**: Menu items generated from registry
- **Easy Enable/Disable**: Toggle action types without code changes
- **Metadata Management**: Icons, descriptions, ordering
- **API Endpoint Mapping**: Maps action types to their API endpoints

**Current Registered Action**:
- `SALES_ORDER_RELATION_CANCEL` - Enabled (Unified cancellation of Sales Order Relation and ALL linked items)

**Action Details**:
- Cancels Sales Order Relation (main entity)
- Cancels ALL linked Sales Orders
- Cancels ALL linked Exclude Sales Orders
- Cancels ALL linked Invoices
- Cancels ALL linked Exclude Invoices
- Cancels ALL linked Payments
- Cancels ALL linked Temp Payments

All items are cancelled together in a single unified transaction. There are no separate cancellation actions for individual item types.

### Appendix B: API Endpoints

| Method | Endpoint | Description | Auth Required | Action Type |
|--------|----------|-------------|---------------|-------------|
| GET | `/api/v1/admin-portal/sales-order/{id}` | Get sales order details | ✅ Yes (Admin) | SALES_ORDER_CANCEL |
| GET | `/api/v1/admin-portal/sales-order-relation/{id}` | Get relation details | ✅ Yes (Admin) | SALES_ORDER_CANCEL |
| POST | `/api/v1/admin-portal/emergency-action` | Execute emergency action | ✅ Yes (Admin) | All Types |
| POST | `/api/v1/admin-portal/logs` | Get logs with filters | ✅ Yes (Admin) | All Types |
| GET | `/api/v1/admin-portal/logs/{id}` | Get specific log | ✅ Yes (Admin) | All Types |
| GET | `/api/v1/admin-portal/invoice/{id}` | Get invoice details | ✅ Yes (Admin) | INVOICE_CANCEL (Future) |
| GET | `/api/v1/admin-portal/payment/{id}` | Get payment details | ✅ Yes (Admin) | PAYMENT_CANCEL (Future) |

### Appendix C: Configuration Checklist

- [ ] Admin user type IDs configured in frontend
- [ ] Admin user type IDs configured in backend
- [ ] Menu item created
- [ ] Menu item assigned to admin users only
- [ ] Database tables created
- [ ] API routes registered
- [ ] API endpoints added to config
- [ ] Branch verification tested
- [ ] Access control tested

### Appendix D: Contact Information

**Development Team**
- Lead Developer: [Name]
- Backend Developer: [Name]
- Frontend Developer: [Name]
- QA Engineer: [Name]

**Support Contacts**
- Technical Support: [Email/Phone]
- Emergency Contact: [Email/Phone]
- Project Manager: [Email/Phone]

### Appendix E: Glossary

- **Admin Portal**: Common platform/module for emergency administrative actions
- **Emergency Action**: Irreversible administrative action (cancellation, etc.) performed by admins
- **Action Type**: Type of emergency action (e.g., SALES_ORDER_CANCEL, INVOICE_CANCEL)
- **Common Framework**: Shared infrastructure for emergency actions
- **Unified Cancellation**: Single action that cancels Sales Order Relation and ALL linked items together
- **Sales Order Relation**: Main entity that links sales orders to jobcards
- **Linked Items**: All items cancelled together (sales orders, invoices, payments, temp payments)
- **Temp Payments**: Temporary payment records linked to exclude invoices or jobcards
- **Branch Verification**: Check ensuring users can only act on their branch
- **Audit Log**: Record of all unified cancellation actions performed in the system

### Appendix F: Adding New Action Types - Complete Guide

#### Overview
Each action type should be implemented as a separate module following the established pattern. This ensures clean separation, easy maintenance, and scalability.

#### Step-by-Step Guide for Developers

**1. Define Action Type**
- Choose unique action type identifier (e.g., `INVOICE_CANCEL`, `PAYMENT_CANCEL`)
- Document what records will be affected
- Define cancellation/handling logic
- Identify required database fields

**2. Create Database Tables**
- Create SQL file: `database/admin_portal/{action_name}_cancellation_tables.sql`
- Example: `database/admin_portal/invoice_cancellation_tables.sql`
- Create log table: `admin_portal_invoice_cancellation_logs`
- Add appropriate indexes

**3. Create Backend Model**
- Create: `app/Models/AdminPortal/Actions/InvoiceCancellationLog.php`
- Extend base model if needed
- Define fillable fields
- Add relationships

**4. Create Backend Controller**
- Create: `app/Http/Controllers/v1/AdminPortal/Actions/InvoiceCancellationController.php`
- Implement action-specific methods:
  - `getInvoiceDetails($id)` - Get invoice details for verification
  - `executeCancellation(Request $request)` - Execute cancellation
- Use common framework methods:
  - `checkAdminAccess()` - Admin verification
  - Branch verification logic
  - Transaction handling

**5. Create Frontend Model**
- Create: `application/models/AdminPortal/Actions/InvoiceCancellationinfo.php`
- Add methods for API communication:
  - `getInvoiceDetailsForEmergency()`
  - `executeCancellation()`
  - `getCancellationLogs()`

**6. Create Frontend Controller**
- Create: `application/controllers/AdminPortal/Actions/InvoiceCancellation.php`
- Extend common AdminPortal functionality
- Add action-specific methods:
  - `form()` - Display cancellation form
  - `getInvoiceDetails()` - Get invoice details
  - `executeCancellation()` - Execute cancellation

**7. Create Frontend Views**
- Create folder: `application/views/AdminPortal/Actions/InvoiceCancellation/`
- Create files:
  - `form.php` - Cancellation form
  - `details.php` - Invoice details display

**8. Add API Routes**
- Add to `routes/api.php`:
```php
Route::prefix('admin-portal/actions/invoice-cancellation')->group(function () {
    Route::get('/invoice/{id}', [InvoiceCancellationController::class, 'getInvoiceDetails']);
    Route::post('/execute', [InvoiceCancellationController::class, 'executeCancellation']);
    Route::get('/logs', [InvoiceCancellationController::class, 'getLogs']);
});
```

**9. Add Frontend Routes**
- Add to CodeIgniter routes config or update main AdminPortal controller
- Add menu item for new action type

**10. Update Common Files**
- Add action type to main dashboard (`AdminPortal/index.php`)
- Update API config (`application/config/api_config.php`)
- Add action type filter option

**11. Testing**
- Unit tests for new action type
- Integration tests
- End-to-end tests
- Verify common framework still works
- Test branch restrictions
- Test admin access control

#### Example: Adding Invoice Cancellation (Complete Structure)

**Backend Controller** (`app/Http/Controllers/v1/AdminPortal/Actions/InvoiceCancellationController.php`):
```php
<?php
namespace App\Http\Controllers\v1\AdminPortal\Actions;

use App\Http\Controllers\v1\AdminPortal\AdminPortalController;
use App\Models\AdminPortal\Actions\InvoiceCancellationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceCancellationController extends AdminPortalController
{
    /**
     * Get invoice details for verification
     */
    public function getInvoiceDetails($id)
    {
        // Use parent admin check
        $user = JWTAuth::user();
        if (!$this->checkAdminAccess($user)) {
            return response()->json(['status' => false, 'message' => 'Access Denied'], 403);
        }
        
        // Get invoice details
        $invoice = Invoice::with(['customer', 'details'])->find($id);
        
        // Get linked payments
        $payments = PayHeader::whereHas('allocations', function($query) use ($id) {
            $query->where('invoice_id', $id);
        })->get();
        
        return response()->json([
            'status' => true,
            'data' => [
                'invoice' => $invoice,
                'linked_payments' => $payments
            ]
        ]);
    }
    
    /**
     * Execute invoice cancellation
     */
    public function executeCancellation(Request $request)
    {
        // Use parent admin check and branch verification
        // ... implementation ...
        
        DB::beginTransaction();
        try {
            // Cancel invoice and linked payments
            // ...
            
            // Log using action-specific model
            InvoiceCancellationLog::create([
                'action_type' => 'INVOICE_CANCEL',
                'invoice_id' => $invoiceId,
                'reason' => $request->reason,
                'status' => 'SUCCESS',
                'user_id' => $user->id,
                'branch_id' => $user->branch_id,
                'action_details' => json_encode($cancelledRecords)
            ]);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Invoice cancelled']);
        } catch (\Exception $e) {
            DB::rollBack();
            InvoiceCancellationLog::create([
                'action_type' => 'INVOICE_CANCEL',
                'invoice_id' => $invoiceId,
                'reason' => $request->reason,
                'status' => 'FAILED',
                'error_message' => $e->getMessage(),
                'user_id' => $user->id,
                'branch_id' => $user->branch_id
            ]);
            throw $e;
        }
    }
}
```

**Frontend Controller** (`application/controllers/AdminPortal/Actions/InvoiceCancellation.php`):
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceCancellation extends CI_Controller {
    protected $api_token;
    protected $auth_user;
    protected $admin_user_types = [1];
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('AdminPortal/Actions/InvoiceCancellationinfo');
        $this->load->model('Commeninfo');
        
        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
        
        // Check admin access
        $this->checkAdminAccess();
    }
    
    private function checkAdminAccess() {
        $user_type_id = $this->session->userdata('user_type_id');
        if (!in_array($user_type_id, $this->admin_user_types)) {
            $this->session->set_flashdata(['res' => '403', 'msg' => 'Access Denied: Admin Only']);
            redirect('Welcome/Logout');
            exit;
        }
    }
    
    public function form() {
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        $this->load->view('AdminPortal/Actions/InvoiceCancellation/form', $result);
    }
    
    public function executeCancellation() {
        // Implementation
    }
}
```

#### File Naming Conventions

- **Controllers**: `{ActionName}.php` (PascalCase)
- **Models**: `{ActionName}info.php` (PascalCase + "info")
- **Log Models**: `{ActionName}Log.php` (PascalCase + "Log")
- **Views**: `{action_name}/` (snake_case folder)
- **SQL Files**: `{action_name}_cancellation_tables.sql` (snake_case)

#### Action Type Registry

Create a registry file to manage all action types:

**`application/config/admin_portal_actions.php`**:
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['admin_portal_actions'] = [
    'SALES_ORDER_CANCEL' => [
        'name' => 'Sales Order Cancellation',
        'controller' => 'SalesOrderCancellation',
        'model' => 'SalesOrderCancellationinfo',
        'log_model' => 'SalesOrderCancellationLog',
        'table' => 'admin_portal_sales_order_cancellation_logs',
        'enabled' => true,
        'menu_icon' => 'fas fa-shopping-cart',
        'menu_order' => 1
    ],
    'INVOICE_CANCEL' => [
        'name' => 'Invoice Cancellation',
        'controller' => 'InvoiceCancellation',
        'model' => 'InvoiceCancellationinfo',
        'log_model' => 'InvoiceCancellationLog',
        'table' => 'admin_portal_invoice_cancellation_logs',
        'enabled' => false, // Future
        'menu_icon' => 'fas fa-file-invoice',
        'menu_order' => 2
    ],
    'PAYMENT_CANCEL' => [
        'name' => 'Payment Cancellation',
        'controller' => 'PaymentCancellation',
        'model' => 'PaymentCancellationinfo',
        'log_model' => 'PaymentCancellationLog',
        'table' => 'admin_portal_payment_cancellation_logs',
        'enabled' => false, // Future
        'menu_icon' => 'fas fa-money-bill-wave',
        'menu_order' => 3
    ]
];
```

This registry allows:
- Dynamic menu generation
- Easy enabling/disabling of action types
- Centralized configuration
- Easy addition of new action types

---

## Document Control

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-01-27 | Development Team | Initial full plan document |
| 1.1 | 2026-01-27 | Development Team | Added modular file structure section, action type registry, updated for multiple action types |
| 1.2 | 2026-01-27 | Development Team | Clarified unified cancellation approach - all linked items cancelled together as one action |

---

### Appendix G: Action Type Registry Configuration

The action type registry (`application/config/admin_portal_actions.php`) allows:

1. **Centralized Management**: All action types defined in one place
2. **Dynamic Menus**: Menu items generated from registry
3. **Easy Enable/Disable**: Toggle action types without code changes
4. **Consistent Structure**: All action types follow same pattern
5. **Metadata Management**: Icons, descriptions, ordering in one place

#### Registry Structure
```php
$config['admin_portal_actions'] = [
    'ACTION_TYPE_CODE' => [
        'name' => 'Display Name',
        'description' => 'What this action does',
        'controller' => 'ControllerName',
        'action_method' => 'methodName',
        'model' => 'ModelName',
        'log_model' => 'LogModelName',
        'log_table' => 'table_name',
        'enabled' => true/false,
        'menu_icon' => 'fas fa-icon',
        'menu_order' => 1,
        'requires_id_type' => 'id_field_name',
        'api_endpoints' => [...]
    ]
];
```

#### Using the Registry

**Get Enabled Actions**:
```php
$this->config->load('admin_portal_actions');
$actions = $this->config->item('admin_portal_actions');
$enabled = array_filter($actions, function($a) { return $a['enabled']; });
```

**Get Action Config**:
```php
$config = $this->config->item('admin_portal_actions')['SALES_ORDER_CANCEL'];
```

**Dynamic Menu Generation**:
```php
foreach ($enabled_actions as $type => $config) {
    echo '<a href="' . base_url('AdminPortal/' . $config['action_method']) . '">';
    echo '<i class="' . $config['menu_icon'] . '"></i> ' . $config['name'];
    echo '</a>';
}
```

---

**End of Document**
