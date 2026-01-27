<?php
class Shiftinfo extends CI_Model{

    public function checkCashierShift($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_v1', $form_data, $headers);
    }

    public function startCashierShift($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_shift_v1', $form_data, $headers);
    }

    public function closeCashierShift($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'cashier_shift_v1', $form_data, $headers);
    }

    public function getCashierShiftRecDetails($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_v1', $id, $headers);
    }

    public function updateShiftOpeningBalances($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['recordID'] ?? null;
        if ($id) {
            // Construct URL for nested route: /v1/cashier/shift/{id}/update_opening_balance
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/cashier/shift/' . $id . '/update_opening_balance';
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'update_shift_opening_balance_v1', $form_data, $headers);
    }

    public function approveShiftOpeningBalances($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['recordID'] ?? null;
        if ($id) {
            // Construct URL for nested route: /v1/cashier/shift/{id}/approve_opening_balance
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/cashier/shift/' . $id . '/approve_opening_balance';
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'approve_shift_opening_balance_v1', $form_data, $headers);
    }

    public function verifyClosingBalance($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['recordID'] ?? null;
        if ($id) {
            // Construct URL for nested route: /v1/cashier/shift/{id}/verify_closing_balance
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/cashier/shift/' . $id . '/verify_closing_balance';
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'verify_shift_closing_balance_v1', $form_data, $headers);
    }

    public function updateClosingBalance($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['recordID'] ?? null;
        if ($id) {
            // Construct URL for nested route: /v1/cashier/shift/{id}/update_closing_balance
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/cashier/shift/' . $id . '/update_closing_balance';
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'update_shift_closing_balance_v1', $form_data, $headers);
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

    public function getAllCashierLog($api_token, $params = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_all_cashier_log_v1', $params, $headers);
    }

    public function getCurrentBalance($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_current_balance_v1', [], $headers);
    }

    public function getShiftClosingValidation($api_token, $shift_id) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/closing_validation
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shift_id . '/closing_validation';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    public function getDiscrepancyAnalysis($api_token, $shift_id) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/discrepancy_analysis
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shift_id . '/discrepancy_analysis';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    public function getCashBook($api_token, $shift_id) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/cash_book
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shift_id . '/cash_book';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    public function getCashBookByDateRange($api_token, $from_date, $to_date) {
        $headers = get_api_headers($api_token);
        // Construct URL for date range cash book
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/cash_book/date_range';
        $data = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
        return $this->make_api_call('POST', $url, $data, $headers);
    }

    /**
     * Get suggested opening balance from previous shift's closing balance
     */
    public function getSuggestedOpeningBalance($api_token) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/suggested_opening_balance
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/suggested_opening_balance';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    /**
     * Get real-time calculated cash progress for active shift
     */
    public function getRealTimeCashProgress($api_token, $shift_id) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/summary
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shift_id . '/summary';
        return $this->make_api_call('GET', $url, [], $headers);
    }
}

