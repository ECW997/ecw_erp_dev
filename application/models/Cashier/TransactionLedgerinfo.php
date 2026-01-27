<?php
class TransactionLedgerinfo extends CI_Model{

    public function getTransactionLedgers($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_transaction_ledger_v1', $form_data, $headers);
    }

    public function getTransactionById($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_transaction_ledger_v1', $id, $headers);
    }

    public function getByShift($api_token, $shiftId) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/transaction_ledger/by_shift/{shiftId}
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/transaction_ledger/by_shift/' . $shiftId;
        return $this->make_api_call('GET', $url, [], $headers);
    }

    private function make_api_call($method, $url, $data, $headers) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'GET') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function getReversals($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'transaction_ledger_reversals_v1', [], $headers);
    }

    /**
     * Get paginated transaction ledger for DataTables server-side processing
     */
    public function getTransactionLedgersDatatable($api_token, $datatable_params) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_transaction_ledger_datatable_v1', $datatable_params, $headers);
    }

    /**
     * Reverse a transaction
     */
    public function reverseTransaction($api_token, $id, $reversal_reason) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/transaction_ledger/' . $id . '/reverse';
        
        $data = ['reversal_reason' => $reversal_reason];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    /**
     * Get unsynced approved payments (payments not yet in transaction ledger)
     */
    public function getUnsyncedPayments($api_token, $shift_id) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/transaction_ledger/unsynced-payments';
        
        $data = ['shift_id' => $shift_id];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    /**
     * Sync selected payments to transaction ledger
     */
    public function syncPayments($api_token, $shift_id, $receipt_ids) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/transaction_ledger/sync-payments';
        
        $data = [
            'shift_id' => $shift_id,
            'receipt_ids' => $receipt_ids
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return json_decode($response, true);
    }
}

