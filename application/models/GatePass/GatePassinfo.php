<?php
class GatePassinfo extends CI_Model {

    public function getGatePasses($api_token, $form_data = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'gate_pass_list_v1', $form_data, $headers);
    }

    public function getGatePassById($api_token, $id) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/' . $id;
        return $this->make_api_call('GET', $url, [], $headers);
    }

    public function generateIn($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_in_v1', $form_data, $headers);
    }

    public function generateIn1($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_in_1_v1', $form_data, $headers);
    }

    public function generateIn2($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_in_2_v1', $form_data, $headers);
    }

    public function generateOut($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_out_v1', $form_data, $headers);
    }

    public function generateOut1($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_out_1_v1', $form_data, $headers);
    }

    public function generateOut2($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_out_2_v1', $form_data, $headers);
    }

    public function generateOut3($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_out_3_v1', $form_data, $headers);
    }

    public function generateInternal($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        $response = call_api('POST', 'gate_pass_generate_internal_v1', $form_data, $headers);
        
        // Log for debugging
        if (!$response || (isset($response['status']) && $response['status'] === false)) {
            log_message('error', 'Gate Pass Internal Generation Failed: ' . print_r($response, true));
            log_message('error', 'Gate Pass Internal Form Data: ' . print_r($form_data, true));
        }
        
        return $response;
    }

    public function generateExternalIn($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_external_in_v1', $form_data, $headers);
    }

    public function generateExternalOut($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_generate_external_out_v1', $form_data, $headers);
    }

    public function printGatePass($api_token, $id) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/' . $id . '/print';
        return $this->make_api_call('POST', $url, [], $headers);
    }

    public function checkPrintAllowed($api_token, $id) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/' . $id . '/check-print';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    public function markExternalReturn($api_token, $id) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/' . $id . '/mark-return';
        return $this->make_api_call('POST', $url, [], $headers);
    }

    public function getJobCardStatus($api_token, $jobCardId) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/job-card/' . $jobCardId . '/status';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    public function getAvailableTypes($api_token, $jobCardId) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/job-card/' . $jobCardId . '/available-types';
        return $this->make_api_call('GET', $url, [], $headers);
    }

    // Job Card Management
    public function getJobcardNumbers($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_jobcard_number_v1', $form_data, $headers);
    }

    public function getJobCardDetails($api_token, $jobCardId) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_card_v1', $jobCardId, $headers);
    }

    // Location Management
    public function getLocations($api_token, $form_data = []) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $endpoints = $CI->config->item('api_endpoints');
        
        // Build the full URL
        $url = $base_url . $endpoints['gate_pass_locations_v1'];
        
        // Make direct API call to debug
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        // Log for debugging
        log_message('debug', 'Gate Pass Locations API Call - URL: ' . $url . ', HTTP Code: ' . $http_code . ', Response: ' . $response);
        
        if ($curl_error) {
            log_message('error', 'Gate Pass Locations CURL Error: ' . $curl_error);
        }
        
        return json_decode($response, true);
    }

    public function createLocation($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'gate_pass_locations_create_v1', $form_data, $headers);
    }

    public function updateLocation($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['id'] ?? null;
        unset($form_data['id']);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/locations/' . $id;
        return $this->make_api_call('PUT', $url, $form_data, $headers);
    }

    public function deleteLocation($api_token, $id) {
        $headers = get_api_headers($api_token);
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/gate-pass/locations/' . $id;
        return $this->make_api_call('DELETE', $url, [], $headers);
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
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $decoded_response = json_decode($response, true);
        return $decoded_response ? $decoded_response : ['status' => false, 'message' => 'Invalid response', 'code' => $http_code];
    }
}

