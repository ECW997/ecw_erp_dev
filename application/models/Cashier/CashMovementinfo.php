<?php
class CashMovementinfo extends CI_Model{

    public function getCashMovements($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_cash_movement_v1', [], $headers);
    }

    public function createCashMovement($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_cash_movement_v1', $form_data, $headers);
    }

    public function approveCashMovement($api_token, $id, $action = 'approve', $additional_data = []) {
        $headers = get_api_headers($api_token);
        $data = [
            'recordID' => $id,
            'action' => $action // 'approve' or 'cancel'
        ];
        
        // Merge additional data (e.g., cancel_reason)
        if (!empty($additional_data)) {
            $data = array_merge($data, $additional_data);
        }
        
        return call_api('PUT', 'cashier_cash_movement_v1', $data, $headers);
    }

    public function getCashMovementById($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_cash_movement_v1', $id, $headers);
    }

    public function updateCashMovement($api_token, $id, $form_data) {
        $headers = get_api_headers($api_token);
        // PUT request: include ID in data array as 'recordID' (following same pattern as approveCashMovement)
        $data = array_merge(['recordID' => $id], $form_data);
        return call_api('PUT', 'cashier_cash_movement_v1', $data, $headers);
    }

    public function deleteCashMovement($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'cashier_cash_movement_v1', $id, $headers);
    }

    /**
     * Get sources filtered by movement type
     */
    public function getSources($api_token, $movement_type) {
        $headers = get_api_headers($api_token);
        $params = ['movement_type' => $movement_type];
        return call_api('GET', 'cashier_cash_movement_sources_v1', $params, $headers);
    }

    /**
     * Get all payment categories
     */
    public function getPaymentCategories($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_cash_movement_payment_categories_v1', [], $headers);
    }

    /**
     * Get supplier jobs by supplier ID
     */
    public function getSupplierJobsBySupplier($api_token, $supplier_id) {
        $headers = get_api_headers($api_token);
        // Helper will append /{supplier_id} to /v1/cashier/supplier-jobs/by-supplier
        return call_api('GET', 'cashier_supplier_jobs_by_supplier_v1', $supplier_id, $headers);
    }

    /**
     * Get supplier jobs with advances for a supplier
     */
    public function getSupplierJobsWithAdvances($api_token, $supplier_id) {
        $headers = get_api_headers($api_token);
        // Build full URL manually for nested path: /v1/cashier/supplier-jobs/by-supplier/{supplier_id}/with-advances
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $endpoints = $CI->config->item('api_endpoints');
        $url = $base_url . $endpoints['cashier_supplier_jobs_with_advances_v1'] . '/' . $supplier_id . '/with-advances';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Create new supplier job
     */
    public function createSupplierJob($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_supplier_jobs_create_v1', $form_data, $headers);
    }

    /**
     * Update supplier job
     */
    public function updateSupplierJob($api_token, $id, $form_data) {
        $headers = get_api_headers($api_token);
        // PUT request: include ID in data array as 'recordID' (following same pattern as updateCashMovement)
        $data = array_merge(['recordID' => $id], $form_data);
        return call_api('PUT', 'cashier_supplier_jobs_update_v1', $data, $headers);
    }

    /**
     * Get advance payments by supplier job
     */
    public function getAdvancePaymentsByJob($api_token, $job_id) {
        $headers = get_api_headers($api_token);
        // Build full URL manually for nested path: /v1/cashier/supplier-jobs/{job_id}/advances
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $endpoints = $CI->config->item('api_endpoints');
        $url = $base_url . $endpoints['cashier_supplier_jobs_advances_v1'] . '/' . $job_id . '/advances';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function checkCashierShift($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_v1', $form_data, $headers);
    }

    /**
     * Get paginated cash movements for DataTables server-side processing
     * Handles large datasets (10,000+ records) efficiently
     */
    public function getCashMovementsDatatable($api_token, $datatable_params) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_cash_movement_datatable_v1', $datatable_params, $headers);
    }

    /**
     * Get regular suppliers with pagination support (for Select2 AJAX)
     */
    public function getSuppliers($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        // params should contain: ['search' => 'term', 'page' => 1]
        return call_api('GET', 'cashier_cash_movement_suppliers_v1', $params, $headers);
    }

    /**
     * Get outsource suppliers with pagination support (for Select2 AJAX)
     */
    public function getOutsourceSuppliers($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        // params should contain: ['search' => 'term', 'page' => 1]
        return call_api('GET', 'cashier_cash_movement_outsource_suppliers_v1', $params, $headers);
    }

    /**
     * Get all payees for dropdown
     */
    public function getPayees($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        // params should contain: ['search' => 'term'] for filtering
        return call_api('GET', 'cashier_payee_masters_v1', $params, $headers);
    }

    /**
     * Create a new payee
     */
    public function createPayee($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_payee_masters_create_v1', $form_data, $headers);
    }
}

