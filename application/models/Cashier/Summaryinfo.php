<?php
class Summaryinfo extends CI_Model{

    public function getShiftSummaries($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_summary_v1', $form_data, $headers);
    }

    public function getSummaryById($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_summary_v1', $id, $headers);
    }

    public function getShiftSummariesDatatable($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_shift_summary_datatable_v1', $form_data, $headers);
    }

    /**
     * Get cash book summary for a shift (saved from database)
     */
    public function getCashBookSummary($api_token, $shiftId) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/cash_book_summary
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shiftId . '/cash_book_summary';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    /**
     * Get calculated cash book summary (real-time calculation)
     */
    public function getCalculatedSummary($api_token, $shiftId) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/summary
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shiftId . '/summary';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    /**
     * Save cash book summary (create or update)
     */
    public function saveCashBookSummary($api_token, $shiftId) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/shift/{id}/cash_book_summary
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/shift/' . $shiftId . '/cash_book_summary';
        return $this->make_api_call('POST', $url, [], $headers);
    }

    /**
     * Helper method to make API calls with full URL (for nested routes)
     */
    private function make_api_call($method, $url, $data, $headers) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'GET') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($curlError) {
            return ['status' => false, 'message' => 'CURL Error: ' . $curlError, 'code' => 500];
        }
        
        $result = json_decode($response, true);
        if (!$result) {
            return ['status' => false, 'message' => 'Failed to decode response. HTTP Code: ' . $httpCode . ', Response: ' . substr($response, 0, 200), 'code' => $httpCode];
        }
        return $result;
    }
}
