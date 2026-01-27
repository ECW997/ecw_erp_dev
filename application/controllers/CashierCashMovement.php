<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierCashMovement extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/CashMovementinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        // Get cash movements
        $cash_movements_response = $this->CashMovementinfo->getCashMovements($this->api_token);
        
        // Get active shift ID for auto-selection
        $active_shift_id = null;
        if (isset($check_cashier_shift_response['status']) && $check_cashier_shift_response['status'] === true && isset($check_cashier_shift_response['shift']['id'])) {
            $active_shift_id = $check_cashier_shift_response['shift']['id'];
        }
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['cash_movements'] = $cash_movements_response;
        $result['active_shift_id'] = $active_shift_id;

        $this->load->view('Cashier/CashMovement', $result);
    }

    public function getCashMovements() {
        // Allow filtering by any shift (passed as query parameter)
        $shift_id = $this->input->get('shift_id');
        
        // Get cash movements (can be filtered by shift_id if provided)
        $params = [];
        if (!empty($shift_id)) {
            $params['shift_id'] = $shift_id;
        }
        
        $response = $this->CashMovementinfo->getCashMovements($this->api_token);
        echo json_encode($response);
    }

    /**
     * DataTables server-side processing endpoint
     * Handles pagination, sorting, and filtering for large datasets
     */
    public function datatable() {
        // Get all DataTables parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        
        // Optional filters
        $shift_id = $this->input->post('shift_id');
        $movement_type = $this->input->post('movement_type');
        $source_id = $this->input->post('source_id');
        $status = $this->input->post('status');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $include_series2 = $this->input->post('include_series2'); // Include Series 2 when 1
        
        // Prepare parameters
        $datatable_params = [
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'order' => $order,
            'shift_id' => $shift_id,
            'movement_type' => $movement_type,
            'source_id' => $source_id,
            'status' => $status,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'include_series2' => $include_series2 // Pass to API
        ];
        
        $response = $this->CashMovementinfo->getCashMovementsDatatable($this->api_token, $datatable_params);
        echo json_encode($response);
    }

    public function getAvailableShifts() {
        // Get all shifts for current user to populate filter dropdown
        $this->load->model('Cashier/Shiftinfo');
        $response = $this->Shiftinfo->getAllCashierLog($this->api_token, []);
        echo json_encode($response);
    }

    public function checkCashierShift() {
        // Get current user's active shift
        $this->load->model('Cashier/Shiftinfo');
        $response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        echo json_encode($response);
    }

    public function createCashMovement() {
        $this->load->helper('api_helper');
        
        // Get shift_id from form, or auto-use active shift if not provided
        $shift_id = $this->input->post('cashier_shift_id');
        
        // If no shift selected, try to get active shift automatically
        if (empty($shift_id)) {
            $active_shift = get_current_user_active_shift($this->api_token);
            if ($active_shift) {
                $shift_id = $active_shift['id'];
            } else {
                log_cashier_transaction('cash_movement', 'create', null, [], [], false, 'Failed: No shift selected and no active shift found');
                echo json_encode([
                    'status' => false,
                    'message' => 'No shift selected and no active shift found. Please select a shift or open a cashier shift first.',
                    'code' => 400
                ]);
                return;
            }
        }
        
        // Get is_confirm value (Series: 1 = Series 1, 0 = Series 2)
        // Default to 1 (Series 1) if not provided
        $is_confirm = $this->input->post('is_confirm');
        $is_confirm = ($is_confirm !== null && $is_confirm !== '') ? (int)$is_confirm : 1;
        
        // Get account_master_id (for Petty Cash source)
        $account_master_id = $this->input->post('account_master_id');
        $account_master_id = (!empty($account_master_id) && $account_master_id !== '0') ? (int)$account_master_id : null;
        
        // Get source_id and source code
        $source_id = $this->input->post('source_id');
        $source = $this->input->post('source');
        
        // Get payment_category_id and payment_category code
        $payment_category_id = $this->input->post('payment_category_id');
        $payment_category = $this->input->post('payment_category');
        
        // Get advance_payment_type if exists
        $advance_payment_type = $this->input->post('advance_payment_type');
        
        // Get final_payment_type if exists
        $final_payment_type = $this->input->post('final_payment_type');
        
        // Get advance_entry_type if exists
        $advance_entry_type = $this->input->post('advance_entry_type');
        
        // Get pay_cycle_id and schedule_group_text if exists (for automated entry type)
        $pay_cycle_id = $this->input->post('pay_cycle_id');
        $schedule_group_text = $this->input->post('schedule_group_text');
        
        // Get outsource supplier fields if exists
        $supplier_job_id = $this->input->post('supplier_job_id');
        $advance_date = $this->input->post('advance_date');
        $outsource_supplier_id = $this->input->post('outsource_supplier_id');
        
        $form_data = [
            'cashier_shift_id' => $shift_id,
            'movement_type' => $this->input->post('movement_type'),
            'source_id' => $source_id ? (int)$source_id : null, // Required by API
            'source' => $source, // Keep for backward compatibility/logging
            'payment_category_id' => $payment_category_id ? (int)$payment_category_id : null,
            'payment_category' => $payment_category, // Keep for backward compatibility/logging
            'advance_payment_type' => $advance_payment_type ? $advance_payment_type : null,
            'final_payment_type' => $final_payment_type ? $final_payment_type : null,
            'advance_entry_type' => $advance_entry_type ? $advance_entry_type : null,
            'pay_cycle_id' => $pay_cycle_id ? (int)$pay_cycle_id : null,
            'schedule_group_text' => $schedule_group_text ? $schedule_group_text : null,
            'account_master_id' => $account_master_id, // For Petty Cash source
            'is_confirm' => $is_confirm, // Series 1 = 1, Series 2 = 0 (default: 1)
            'payee_master_id' => $this->input->post('payee_master_id') ? (int)$this->input->post('payee_master_id') : null,
            'payee_code' => $this->input->post('payee_code'),
            'payee_name' => $this->input->post('payee_name'),
            'iou_settlement_id' => $this->input->post('iou_settlement_id') ? (int)$this->input->post('iou_settlement_id') : null,
            'amount' => $this->input->post('amount'),
            'payment_type' => $this->input->post('payment_type'),
            'remarks' => $this->input->post('remarks'),
            // Outsource supplier fields
            'supplier_job_id' => $supplier_job_id ? (int)$supplier_job_id : null,
            'advance_date' => $advance_date ? $advance_date : null,
            'outsource_supplier_id' => $outsource_supplier_id ? (int)$outsource_supplier_id : null
        ];
        
        // Handle normalized data arrays
        if ($this->input->post('payees')) {
            $form_data['payees'] = $this->input->post('payees');
        }
        if ($this->input->post('employee_amounts')) {
            $form_data['employee_amounts'] = $this->input->post('employee_amounts');
        }
        if ($this->input->post('supplier_amounts')) {
            $form_data['supplier_amounts'] = $this->input->post('supplier_amounts');
        }
        if ($this->input->post('grn_amounts')) {
            $form_data['grn_amounts'] = $this->input->post('grn_amounts');
        }
        // Convert advance_applicable_year/month to advance_months array format expected by API
        if ($this->input->post('advance_months')) {
            $form_data['advance_months'] = $this->input->post('advance_months');
        } elseif ($this->input->post('advance_applicable_year') && $this->input->post('advance_applicable_month')) {
            // Backward compatibility: convert separate fields to array format
            $form_data['advance_months'] = [[
                'advance_year' => (int)$this->input->post('advance_applicable_year'),
                'advance_month' => (int)$this->input->post('advance_applicable_month')
            ]];
        }
        
        // Handle schedule_groups if exists (for automated entry type)
        if ($this->input->post('schedule_groups')) {
            $form_data['schedule_groups'] = $this->input->post('schedule_groups');
        }

        // Log transaction attempt
        log_cashier_transaction('cash_movement', 'create', null, $form_data, [], true, 'Creating cash movement');

        $response = $this->CashMovementinfo->createCashMovement($this->api_token, $form_data);

        if ($response) {
            // Log successful creation
            $entity_id = isset($response['data']['id']) ? $response['data']['id'] : null;
            log_cashier_transaction('cash_movement', 'create', $entity_id, $form_data, [], true, 'Cash movement created successfully', null);
            echo json_encode($response);
        } else {
            // Log failure
            log_cashier_transaction('cash_movement', 'create', null, $form_data, [], false, 'Server error: No response from API');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function getCashMovement($id) {
        $response = $this->CashMovementinfo->getCashMovementById($this->api_token, $id);
        echo json_encode($response);
    }

    public function updateCashMovement($id) {
        $this->load->helper('api_helper');
        
        // Get shift_id from form, or use existing
        $shift_id = $this->input->post('cashier_shift_id');
        
        // Get is_confirm value (Series: 1 = Series 1, 0 = Series 2)
        $is_confirm = $this->input->post('is_confirm');
        $is_confirm = ($is_confirm !== null && $is_confirm !== '') ? (int)$is_confirm : 1;
        
        // Get account_master_id (for Petty Cash source)
        $account_master_id = $this->input->post('account_master_id');
        $account_master_id = (!empty($account_master_id) && $account_master_id !== '0') ? (int)$account_master_id : null;
        
        // Get source_id and source code
        $source_id = $this->input->post('source_id');
        $source = $this->input->post('source');
        
        // Get payment_category_id and payment_category code
        $payment_category_id = $this->input->post('payment_category_id');
        $payment_category = $this->input->post('payment_category');
        
        // Get advance_payment_type if exists
        $advance_payment_type = $this->input->post('advance_payment_type');
        
        // Get final_payment_type if exists
        $final_payment_type = $this->input->post('final_payment_type');
        
        // Get advance_entry_type if exists
        $advance_entry_type = $this->input->post('advance_entry_type');
        
        // Get pay_cycle_id and schedule_group_text if exists (for automated entry type)
        $pay_cycle_id = $this->input->post('pay_cycle_id');
        $schedule_group_text = $this->input->post('schedule_group_text');
        
        // Get outsource supplier fields if exists
        $supplier_job_id = $this->input->post('supplier_job_id');
        $advance_date = $this->input->post('advance_date');
        $outsource_supplier_id = $this->input->post('outsource_supplier_id');
        
        $form_data = [
            'cashier_shift_id' => $shift_id,
            'movement_type' => $this->input->post('movement_type'),
            'source_id' => $source_id ? (int)$source_id : null, // Required by API
            'source' => $source, // Keep for backward compatibility/logging
            'payment_category_id' => $payment_category_id ? (int)$payment_category_id : null,
            'payment_category' => $payment_category, // Keep for backward compatibility/logging
            'advance_entry_type' => $advance_entry_type ? $advance_entry_type : null,
            'pay_cycle_id' => $pay_cycle_id ? (int)$pay_cycle_id : null,
            'schedule_group_text' => $schedule_group_text ? $schedule_group_text : null,
            'account_master_id' => $account_master_id,
            'is_confirm' => $is_confirm,
            'payee_master_id' => $this->input->post('payee_master_id') ? (int)$this->input->post('payee_master_id') : null,
            'payee_code' => $this->input->post('payee_code'),
            'payee_name' => $this->input->post('payee_name'),
            'iou_settlement_id' => $this->input->post('iou_settlement_id') ? (int)$this->input->post('iou_settlement_id') : null,
            'amount' => $this->input->post('amount'),
            'payment_type' => $this->input->post('payment_type'),
            'remarks' => $this->input->post('remarks'),
            'action' => 'edit', // Explicitly set action to 'edit'
            // Outsource supplier fields
            'supplier_job_id' => $supplier_job_id ? (int)$supplier_job_id : null,
            'advance_date' => $advance_date ? $advance_date : null,
            'outsource_supplier_id' => $outsource_supplier_id ? (int)$outsource_supplier_id : null
        ];
        
        // Handle normalized data arrays
        if ($this->input->post('payees')) {
            $form_data['payees'] = $this->input->post('payees');
        }
        if ($this->input->post('employee_amounts')) {
            $form_data['employee_amounts'] = $this->input->post('employee_amounts');
        }
        if ($this->input->post('supplier_amounts')) {
            $form_data['supplier_amounts'] = $this->input->post('supplier_amounts');
        }
        if ($this->input->post('grn_amounts')) {
            $form_data['grn_amounts'] = $this->input->post('grn_amounts');
        }
        // Convert advance_applicable_year/month to advance_months array format expected by API
        if ($this->input->post('advance_months')) {
            $form_data['advance_months'] = $this->input->post('advance_months');
        } elseif ($this->input->post('advance_applicable_year') && $this->input->post('advance_applicable_month')) {
            // Backward compatibility: convert separate fields to array format
            $form_data['advance_months'] = [[
                'advance_year' => (int)$this->input->post('advance_applicable_year'),
                'advance_month' => (int)$this->input->post('advance_applicable_month')
            ]];
        }
        
        // Handle schedule_groups if exists (for automated entry type)
        if ($this->input->post('schedule_groups')) {
            $form_data['schedule_groups'] = $this->input->post('schedule_groups');
        }

        // Log transaction attempt
        log_cashier_transaction('cash_movement', 'update', $id, $form_data, [], true, 'Updating cash movement');

        $response = $this->CashMovementinfo->updateCashMovement($this->api_token, $id, $form_data);

        if ($response) {
            // Log successful update
            log_cashier_transaction('cash_movement', 'update', $id, $form_data, [], true, 'Cash movement updated successfully', null);
            echo json_encode($response);
        } else {
            // Log failure
            log_cashier_transaction('cash_movement', 'update', $id, $form_data, [], false, 'Server error: No response from API');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function approveCashMovement($id) {
        // Get current data before approval
        $current_response = $this->CashMovementinfo->getCashMovementById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        
        // Log approval attempt
        log_cashier_transaction('cash_movement', 'approve', $id, ['status' => 'approved', 'action' => 'approve'], $current_data, true, 'Approving cash movement');

        $response = $this->CashMovementinfo->approveCashMovement($this->api_token, $id, 'approve');

        if ($response && isset($response['status']) && $response['status']) {
            // Log successful approval
            log_cashier_transaction('cash_movement', 'approve', $id, ['status' => 'approved', 'action' => 'approve'], $current_data, true, 'Cash movement approved successfully');
            echo json_encode($response);
        } else {
            // Log failure
            log_cashier_transaction('cash_movement', 'approve', $id, [], $current_data, false, 'Server error: Failed to approve cash movement');
            echo json_encode($response ?: ['status' => false, 'message' => 'Not Response Server!']);
        }
    }

    public function cancelCashMovementApproval($id) {
        // Get cancel reason from POST data
        $cancel_reason = $this->input->post('cancel_reason');
        
        // Get current data before cancellation
        $current_response = $this->CashMovementinfo->getCashMovementById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        
        // Log cancellation attempt
        log_cashier_transaction('cash_movement', 'cancel', $id, ['status' => 'cancel', 'action' => 'cancel', 'cancel_reason' => $cancel_reason], $current_data, true, 'Cancelling cash movement approval');

        $response = $this->CashMovementinfo->approveCashMovement($this->api_token, $id, 'cancel', ['cancel_reason' => $cancel_reason]);

        if ($response && isset($response['status']) && $response['status']) {
            // Log successful cancellation
            log_cashier_transaction('cash_movement', 'cancel', $id, ['status' => 'pending', 'action' => 'cancel'], $current_data, true, 'Cash movement approval cancelled successfully');
            echo json_encode($response);
        } else {
            // Log failure
            log_cashier_transaction('cash_movement', 'cancel', $id, [], $current_data, false, 'Server error: Failed to cancel cash movement approval');
            echo json_encode($response ?: ['status' => false, 'message' => 'Not Response Server!']);
        }
    }

    public function getCashMovementById($id) {
        $response = $this->CashMovementinfo->getCashMovementById($this->api_token, $id);
        echo json_encode($response);
    }

    public function deleteCashMovement($id) {
        // Get current data before deletion
        $current_response = $this->CashMovementinfo->getCashMovementById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        
        // Log deletion attempt
        log_cashier_transaction('cash_movement', 'delete', $id, [], $current_data, true, 'Deleting cash movement');

        $response = $this->CashMovementinfo->deleteCashMovement($this->api_token, $id);

        if ($response) {
            // Log successful deletion
            log_cashier_transaction('cash_movement', 'delete', $id, [], $current_data, true, 'Cash movement deleted successfully');
            echo json_encode($response);
        } else {
            // Log failure
            log_cashier_transaction('cash_movement', 'delete', $id, [], $current_data, false, 'Failed to delete cash movement');
            echo json_encode($response);
        }
    }

    public function printPettyCashVoucher($id) {
        $this->load->model('Cashier/CashMovementinfo');
        
        // Get cash movement data
        $response = $this->CashMovementinfo->getCashMovementById($this->api_token, $id);
        
        if ($response && isset($response['status']) && $response['status'] && isset($response['data'])) {
            $movement = $response['data'];
            
            // Check source code (normalized structure: source is now an object with 'code' field)
            $sourceCode = null;
            if (isset($movement['source']) && is_array($movement['source'])) {
                $sourceCode = $movement['source']['code'] ?? null;
            } elseif (isset($movement['source_code'])) {
                $sourceCode = $movement['source_code'];
            } elseif (isset($movement['source'])) {
                $sourceCode = $movement['source']; // Fallback for old structure
            }
            
            // Only allow printing for approved petty cash movements
            if ($sourceCode !== 'petty' || $movement['status'] !== 'approved') {
                show_404();
                return;
            }
            
            $data['movement'] = $movement;
            
            $this->load->view('Cashier/PettyCashVoucher', $data);
        } else {
            show_404();
        }
    }

    /**
     * Get regular suppliers from API (with pagination support)
     */
    public function getSuppliers() {
        // Get search term and page from request (Select2 AJAX format)
        $search = $this->input->get('search') ? $this->input->get('search') : '';
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        
        // Prepare parameters for API call
        $params = [];
        if (!empty($search)) {
            $params['search'] = $search;
        }
        if ($page > 1) {
            $params['page'] = $page;
        }
        
        // Call model method to get suppliers
        $response = $this->CashMovementinfo->getSuppliers($this->api_token, $params);
        
        // Return in Select2 AJAX format
        if (isset($response['results']) && isset($response['pagination'])) {
            echo json_encode([
                'results' => $response['results'],
                'pagination' => $response['pagination']
            ]);
        } elseif (isset($response['status']) && $response['status'] && isset($response['results'])) {
            // Fallback for old format
            echo json_encode([
                'results' => $response['results'],
                'pagination' => ['more' => false]
            ]);
        } else {
            echo json_encode([
                'results' => [],
                'pagination' => ['more' => false]
            ]);
        }
    }
    
    /**
     * Get outsource suppliers from API (with pagination support)
     */
    public function getOutsourceSuppliers() {
        // Get search term and page from request (Select2 AJAX format)
        $search = $this->input->get('search') ? $this->input->get('search') : '';
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        
        // Prepare parameters for API call
        $params = [];
        if (!empty($search)) {
            $params['search'] = $search;
        }
        if ($page > 1) {
            $params['page'] = $page;
        }
        
        // Call model method to get outsource suppliers
        $response = $this->CashMovementinfo->getOutsourceSuppliers($this->api_token, $params);
        
        // Return in Select2 AJAX format
        if (isset($response['results']) && isset($response['pagination'])) {
            echo json_encode([
                'results' => $response['results'],
                'pagination' => $response['pagination']
            ]);
        } elseif (isset($response['status']) && $response['status'] && isset($response['results'])) {
            // Fallback for old format
            echo json_encode([
                'results' => $response['results'],
                'pagination' => ['more' => false]
            ]);
        } else {
            echo json_encode([
                'results' => [],
                'pagination' => ['more' => false]
            ]);
        }
    }
    
    public function getEmployees() {
        // Get search term from request (pay profile API uses 'term' parameter)
        $search = $this->input->get('term') ? $this->input->get('term') : ($this->input->get('search') ? $this->input->get('search') : '');
        
        // Get list of employees from Pay Profile API
        $api_url = 'https://pr.ecw.lk/api/pay_profile';
        if (!empty($search)) {
            $api_url .= '?term=' . urlencode($search);
        }
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code === 200 && $response) {
            $api_data = json_decode($response, true);
            
            if (isset($api_data['status']) && $api_data['status'] && isset($api_data['data']) && is_array($api_data['data'])) {
                // Format data for Select2
                $employees = [];
                foreach ($api_data['data'] as $emp) {
                    $emp_no = $emp['emp_no'] ?? '';
                    $emp_name = $emp['emp_name'] ?? '';
                    $epf_no = $emp['epf_no'] ?? '';
                    $displayText = $emp['text'] ?? ($emp_no ? ($emp_no . ' - ' . $emp_name) : $emp_name);
                    
                    $employees[] = [
                        'id' => $emp['id'],
                        'text' => $displayText,
                        'emp_no' => $emp_no,
                        'emp_name' => $emp_name,
                        'employee_no' => $emp_no,
                        'emp_code' => $emp_no,
                        // Map epf_no from API to emp_etfno used in Series determination
                        'emp_etfno' => $epf_no
                    ];
                }
                
                // Return in Select2 AJAX format (pay profile API already handles search, so no pagination needed)
                echo json_encode([
                    'results' => $employees,
                    'pagination' => [
                        'more' => false
                    ]
                ]);
                return;
            }
        }
        
        // Fallback response on error (Select2 format)
        echo json_encode([
            'results' => [],
            'pagination' => [
                'more' => false
            ]
        ]);
    }
    
    // Get employee details (for mark and image)
    public function getEmployeeDetails() {
        $employee_id = $this->input->get('employee_id');
        
        if (!$employee_id) {
            echo json_encode([
                'status' => false,
                'message' => 'Employee ID is required',
                'data' => null
            ]);
            return;
        }
        
        // Call API to get employee details with mark and image
        $api_url = 'https://hrm.ecw.lk/api/get_employee_details?id=' . $employee_id;
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code === 200 && $response) {
            $api_data = json_decode($response, true);
            
            if (isset($api_data['status']) && $api_data['status'] && isset($api_data['data'])) {
                $employee = is_array($api_data['data']) && isset($api_data['data'][0]) ? $api_data['data'][0] : $api_data['data'];
                
                // Return employee details with mark and image
                echo json_encode([
                    'status' => true,
                    'message' => 'Employee details retrieved successfully',
                    'data' => [
                        'mark' => isset($employee['mark']) ? $employee['mark'] : 0, // Get from API or default to 0
                        'image_url' => isset($employee['image_url']) ? $employee['image_url'] : (isset($employee['profile_image']) ? $employee['profile_image'] : null) // Get image from API
                    ]
                ]);
                return;
            }
        }
        
        // Default response if API fails
        echo json_encode([
            'status' => true,
            'message' => 'No additional details found',
            'data' => [
                'mark' => 0,
                'image_url' => null
            ]
        ]);
    }
    
    // Upload employee image (supports file upload and base64 data)
    public function uploadEmployeeImage() {
        header('Content-Type: application/json');
        
        // Check if it's a base64 upload (JSON request)
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (isset($data['image_data']) && !empty($data['image_data'])) {
            // Handle base64 image data
            $imageData = $data['image_data'];
            
            // Extract base64 data (remove data:image/...;base64, prefix if present)
            if (strpos($imageData, ',') !== false) {
                $imageData = explode(',', $imageData)[1];
            }
            
            // Decode base64
            $decodedImage = base64_decode($imageData);
            
            if ($decodedImage === false) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Invalid image data'
                ]);
                return;
            }
            
            // Create upload directory if it doesn't exist
            $uploadDir = FCPATH . 'uploads/cashier/employee_images/temp/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generate unique filename
            $filename = 'emp_' . uniqid() . '_' . time() . '.png';
            $filepath = $uploadDir . $filename;
            
            // Save image
            if (file_put_contents($filepath, $decodedImage)) {
                $imageUrl = base_url('uploads/cashier/employee_images/temp/' . $filename);
                
                echo json_encode([
                    'status' => true,
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'image_url' => $imageUrl,
                        'filename' => $filename
                    ]
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Failed to save image'
                ]);
            }
            return;
        }
        
        // Handle traditional file upload
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode([
                'status' => false,
                'message' => 'No image file uploaded or upload error',
                'data' => null
            ]);
            return;
        }
        
        $config['upload_path'] = './uploads/cashier/employee_images/temp/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = true;
        
        // Create directory if it doesn't exist
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $image_url = base_url('uploads/cashier/employee_images/temp/' . $upload_data['file_name']);
            
            echo json_encode([
                'status' => true,
                'message' => 'Image uploaded successfully',
                'data' => [
                    'image_url' => $image_url,
                    'file_name' => $upload_data['file_name']
                ]
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => $this->upload->display_errors('', ''),
                'data' => null
            ]);
        }
    }
    
    /**
     * Get employees and advance amounts for a given pay cycle + schedule group
     * Uses external API: https://pr.ecw.lk/api/advance/schedule-advance-list?pay_cycle_id=XX&salary_group_id=YY
     */
    public function getEmployeesByScheduleGroup() {
        $pay_cycle_id      = $this->input->get('pay_cycle_id');
        $schedule_group_id = $this->input->get('schedule_group_id'); // UI sends schedule_group_id, API expects salary_group_id
        $series            = $this->input->get('series'); // Series value (0 or 1)
        
        if (empty($pay_cycle_id) || empty($schedule_group_id)) {
            echo json_encode([
                'status'  => false,
                'message' => 'pay_cycle_id and schedule_group_id are required',
                'data'    => []
            ]);
            return;
        }
        
        // Validate series value if provided (must be "0" or "1")
        if ($series !== null && $series !== '' && $series !== '0' && $series !== '1' && $series !== 0 && $series !== 1) {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid series value. Must be 0 or 1.',
                'data'    => []
            ]);
            return;
        }
        
        // Build API URL
        $api_url = 'https://pr.ecw.lk/api/advance/schedule-advance-list?pay_cycle_id=' . urlencode($pay_cycle_id)
                 . '&salary_group_id=' . urlencode($schedule_group_id);
        
        // Add series parameter if provided
        // Map: UI value "1" → API value "1", UI value "0" → API value "2"
        // Note: Check for !== null and !== '' to handle "0" value correctly (empty() treats "0" as empty)
        if ($series !== null && $series !== '') {
            $api_series = ($series === '0' || $series === 0) ? '2' : $series; // Convert "0" to "2", keep "1" as "1"
            $api_url .= '&series=' . urlencode($api_series);
        }
        
        // Call external API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code === 200 && $response) {
            $api_data = json_decode($response, true);
            
            if (isset($api_data['status']) && $api_data['status'] && isset($api_data['data']) && is_array($api_data['data'])) {
                $employees = [];
                
                foreach ($api_data['data'] as $row) {
                    $employees[] = [
                        'employee_id'    => isset($row['employee_id']) ? $row['employee_id'] : null,
                        'employee_name'  => isset($row['emp_name']) ? $row['emp_name'] : '',
                        'employee_code'  => isset($row['emp_no']) ? $row['emp_no'] : '',
                        'amount'         => isset($row['amount']) ? $row['amount'] : 0,
                        // Pass epf_no as emp_etfno so existing Series logic can use it if needed
                        'emp_etfno'      => isset($row['epf_no']) ? $row['epf_no'] : '',
                        // Optional extra fields (not currently used but kept for future)
                        'start_month'    => isset($row['start_month']) ? $row['start_month'] : null,
                        'requested_date' => isset($row['requested_date']) ? $row['requested_date'] : null,
                        'is_paid'        => isset($row['is_paid']) ? $row['is_paid'] : null,
                    ];
                }
                
                echo json_encode([
                    'status'  => true,
                    'message' => 'Employees loaded successfully',
                    'data'    => $employees
                ]);
                return;
            }
        }
        
        // Fallback on error
        echo json_encode([
            'status'  => false,
            'message' => 'Unable to load employees for the selected schedule group',
            'data'    => []
        ]);
    }
    
    // Get GRN Codes from third-party API filtered by supplier
    public function getGrnCodes() {
        // Get search term and supplier_id from request
        $search = $this->input->get('search');
        $supplier_id = $this->input->get('supplier_id');
        $page = $this->input->get('page') ?: 1;
        
        // Validate supplier_id is required
        if (!$supplier_id || $supplier_id === '' || $supplier_id === '0') {
            echo json_encode(['results' => []]);
            return;
        }
        
        // TODO: Replace this URL with the actual third-party API endpoint for GRN codes
        // Example API endpoint - update this to match your third-party API
        $api_url = 'https://api.example.com/grn-codes'; // Replace with actual API URL
        
        // Build query parameters
        $params = [];
        if ($supplier_id) {
            $params[] = 'supplier_id=' . urlencode($supplier_id);
        }
        if ($search) {
            $params[] = 'search=' . urlencode($search);
        }
        if ($page > 1) {
            $params[] = 'page=' . $page;
        }
        
        if (!empty($params)) {
            $api_url .= '?' . implode('&', $params);
        }
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        // Add headers if required by the API
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer YOUR_API_TOKEN',
        //     'Content-Type: application/json'
        // ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $results = [];
        
        if ($http_code === 200 && $response) {
            $data = json_decode($response, true);
            
            // Handle different API response formats
            if (isset($data['data']) && is_array($data['data'])) {
                // Format: {status: true, data: [{id, grn_code, ...}]}
                foreach ($data['data'] as $grn) {
                    $grnCode = isset($grn['grn_code']) ? $grn['grn_code'] : (isset($grn['code']) ? $grn['code'] : '');
                    $grnDescription = isset($grn['description']) ? $grn['description'] : (isset($grn['name']) ? $grn['name'] : '');
                    $displayText = $grnCode . ($grnDescription ? ' - ' . $grnDescription : '');
                    
                    $results[] = [
                        'id' => isset($grn['id']) ? $grn['id'] : $grnCode,
                        'text' => $displayText,
                        'grn_code' => $grnCode,
                        'description' => $grnDescription
                    ];
                }
            } elseif (isset($data['results']) && is_array($data['results'])) {
                // Format: {results: [{id, text, ...}]}
                $results = $data['results'];
            } elseif (is_array($data) && !isset($data['data']) && !isset($data['results'])) {
                // Format: [{id, grn_code, ...}] - direct array
                foreach ($data as $grn) {
                    $grnCode = isset($grn['grn_code']) ? $grn['grn_code'] : (isset($grn['code']) ? $grn['code'] : '');
                    $grnDescription = isset($grn['description']) ? $grn['description'] : (isset($grn['name']) ? $grn['name'] : '');
                    $displayText = $grnCode . ($grnDescription ? ' - ' . $grnDescription : '');
                    
                    $results[] = [
                        'id' => isset($grn['id']) ? $grn['id'] : $grnCode,
                        'text' => $displayText,
                        'grn_code' => $grnCode,
                        'description' => $grnDescription
                    ];
                }
            }
        }
        
        // Return in Select2 format
        echo json_encode(['results' => $results]);
    }

    /**
     * Get sources filtered by movement type
     */
    public function getSources() {
        $movement_type = $this->input->get('movement_type');
        
        // Allow empty movement_type to get all sources (for filter dropdown)
        $response = $this->CashMovementinfo->getSources($this->api_token, $movement_type);
        echo json_encode($response);
    }

    /**
     * Get all payment categories
     */
    public function getPaymentCategories() {
        $response = $this->CashMovementinfo->getPaymentCategories($this->api_token);
        echo json_encode($response);
    }

    /**
     * Get supplier jobs by supplier ID
     */
    public function getSupplierJobsBySupplier($supplier_id) {
        $response = $this->CashMovementinfo->getSupplierJobsBySupplier($this->api_token, $supplier_id);
        echo json_encode($response);
    }

    /**
     * Get supplier jobs with advances for a supplier
     */
    public function getSupplierJobsWithAdvances($supplier_id) {
        $response = $this->CashMovementinfo->getSupplierJobsWithAdvances($this->api_token, $supplier_id);
        echo json_encode($response);
    }

    /**
     * Create new supplier job
     */
    public function createSupplierJob() {
        $account_master_id = $this->input->post('account_master_id');
        // Convert empty string to null
        if ($account_master_id === '' || $account_master_id === null) {
            $account_master_id = null;
        } else {
            $account_master_id = (int) $account_master_id;
        }
        
        $form_data = [
            'supplier_id' => $this->input->post('supplier_id'),
            'job_name' => $this->input->post('job_name'),
            'job_description' => $this->input->post('job_description'),
            'job_value' => $this->input->post('job_value'),
            'job_status' => $this->input->post('job_status'),
            'account_master_id' => $account_master_id,
            'start_date' => $this->input->post('start_date'),
            'expected_completion_date' => $this->input->post('expected_completion_date')
        ];

        $response = $this->CashMovementinfo->createSupplierJob($this->api_token, $form_data);
        echo json_encode($response);
    }

    /**
     * Update supplier job
     */
    public function updateSupplierJob($id) {
        $account_master_id = $this->input->post('account_master_id');
        // Convert empty string to null
        if ($account_master_id === '' || $account_master_id === null) {
            $account_master_id = null;
        } else {
            $account_master_id = (int) $account_master_id;
        }
        
        $form_data = [
            'job_name' => $this->input->post('job_name'),
            'job_description' => $this->input->post('job_description'),
            'job_value' => $this->input->post('job_value'),
            'job_status' => $this->input->post('job_status'),
            'account_master_id' => $account_master_id,
            'start_date' => $this->input->post('start_date'),
            'expected_completion_date' => $this->input->post('expected_completion_date'),
            'actual_completion_date' => $this->input->post('actual_completion_date')
        ];

        $response = $this->CashMovementinfo->updateSupplierJob($this->api_token, $id, $form_data);
        echo json_encode($response);
    }

    /**
     * Get advance payments by supplier job
     */
    public function getAdvancePaymentsByJob($job_id) {
        $response = $this->CashMovementinfo->getAdvancePaymentsByJob($this->api_token, $job_id);
        echo json_encode($response);
    }

    /**
     * Get all payees for dropdown with search support
     */
    public function getPayees() {
        // Get search term from request (Select2 AJAX format)
        $search = $this->input->get('search') ? $this->input->get('search') : '';
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        
        // Prepare parameters for API call
        $params = [];
        if (!empty($search)) {
            $params['search'] = $search;
        }
        if ($page > 1) {
            $params['page'] = $page;
        }
        
        $response = $this->CashMovementinfo->getPayees($this->api_token, $params);
        echo json_encode($response);
    }
    
    /**
     * Get combined list of Employees + Suppliers for dropdown
     * Used when we want to show both types in the same dropdown
     */
    public function getPayeesEmployeesSuppliers() {
        $search = $this->input->get('search') ? $this->input->get('search') : '';
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        
        $results = [];
        
        // 1. Get Employees
        $emp_api_url = 'https://pr.ecw.lk/api/pay_profile';
        if (!empty($search)) {
            $emp_api_url .= '?term=' . urlencode($search);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $emp_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $emp_response = curl_exec($ch);
        $emp_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($emp_http_code === 200 && $emp_response) {
            $emp_data = json_decode($emp_response, true);
            if (isset($emp_data['status']) && $emp_data['status'] && isset($emp_data['data'])) {
                foreach ($emp_data['data'] as $emp) {
                    $results[] = [
                        'id' => $emp['id'], // ⭐ Actual employee ID (numeric)
                        'text' => '👤 ' . ($emp['emp_no'] ?? '') . ' - ' . ($emp['emp_name'] ?? ''),
                        'type' => 'employee',
                        'payee_code' => $emp['emp_no'] ?? '',
                        'payee_name' => $emp['emp_name'] ?? '',
                        'employee_id' => $emp['id'], // Store for backend
                        'epf_no' => $emp['emp_etfno'] ?? ''
                    ];
                }
            }
        }
        
        // 2. Get Suppliers
        $sup_params = ['search' => $search];
        $sup_response = $this->CashMovementinfo->getSuppliers($this->api_token, $sup_params);
        
        if (isset($sup_response['results'])) {
            foreach ($sup_response['results'] as $sup) {
                $results[] = [
                    'id' => $sup['id'], // ⭐ Actual supplier ID (numeric)
                    'text' => '🏢 ' . $sup['text'],
                    'type' => 'supplier',
                    'payee_code' => $sup['supplier_code'] ?? $sup['id'],
                    'payee_name' => $sup['supplier_name'] ?? $sup['text'],
                    'supplier_id' => $sup['id'] // Store for backend
                ];
            }
        }
        
        // 3. Get Payees
        // $payee_params = ['search' => $search];
        // $payee_response = $this->CashMovementinfo->getPayees($this->api_token, $payee_params);
        
        // if (isset($payee_response['data'])) {
        //     foreach ($payee_response['data'] as $payee) {
        //         $results[] = [
        //             'id' => 'PAY_' . $payee['id'],
        //             'text' => '💼 ' . ($payee['text'] ?? ($payee['payee_code'] . ' - ' . $payee['payee_name'])),
        //             'type' => 'payee',
        //             'payee_code' => $payee['payee_code'],
        //             'payee_name' => $payee['payee_name']
        //         ];
        //     }
        // }
        
        // Return in Select2 format
        echo json_encode([
            'results' => $results,
            'pagination' => ['more' => false]
        ]);
    }

    /**
     * Create a new payee
     */
    public function createPayee() {
        $form_data = [
            'payee_name' => $this->input->post('payee_name'),
            'contact_person' => $this->input->post('contact_person'),
            'contact_phone' => $this->input->post('contact_phone'),
            'contact_email' => $this->input->post('contact_email'),
            'address' => $this->input->post('address'),
            'description' => $this->input->post('description')
        ];

        $response = $this->CashMovementinfo->createPayee($this->api_token, $form_data);
        echo json_encode($response);
    }
}

