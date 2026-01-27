<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocAccessTypeinfo extends CI_Model {

    /**
     * Get document access type by type name
     * 
     * @param string $api_token API authentication token
     * @param string $doc_access_type Type name: 'jobcard', 'invoice', 'payment', 'gatepass'
     * @return array Response array
     */
    public function getDocAccessTypeByName($api_token, $doc_access_type) {
        $headers = get_api_headers($api_token);
        $form_data = ['doc_access_type' => $doc_access_type];
        return call_api('GET', 'doc_access_type_v1', $form_data, $headers);
    }

    /**
     * Get all document access types
     * 
     * @param string $api_token API authentication token
     * @param array $form_data Additional filters
     * @return array Response array
     */
    public function getAllDocAccessTypes($api_token, $form_data = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'doc_access_type_v1', $form_data, $headers);
    }

    /**
     * Create document access type
     * 
     * @param string $api_token API authentication token
     * @param array $form_data Form data
     * @return array Response array
     */
    public function createDocAccessType($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'doc_access_type_v1', $form_data, $headers);
    }

    /**
     * Update document access type
     * 
     * @param string $api_token API authentication token
     * @param array $form_data Form data including id
     * @return array Response array
     */
    public function updateDocAccessType($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['id'] ?? null;
        if ($id) {
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/doc_access_type/' . $id;
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'doc_access_type_v1', $form_data, $headers);
    }

    /**
     * Make API call
     * 
     * @param string $method HTTP method
     * @param string $url Full URL
     * @param array $data Request data
     * @param array $headers Request headers
     * @return array Response array
     */
    private function make_api_call($method, $url, $data, $headers) {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
        ]);
        
        if ($method === 'POST' || $method === 'PUT') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        return [
            'status' => $http_code >= 200 && $http_code < 300,
            'code' => $http_code,
            'data' => $result['data'] ?? $result,
            'message' => $result['message'] ?? 'Request completed'
        ];
    }
}

