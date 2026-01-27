<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DocAccessinfo extends CI_Model {

    /**
     * Log document print operation
     * 
     * @param string $api_token API authentication token
     * @param array $form_data Form data containing doc_access_type, reference_id, etc.
     * @return array Response array
     */
    public function logDocumentPrint($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'doc_access_v1', $form_data, $headers);
    }

    /**
     * Get document access logs
     * 
     * @param string $api_token API authentication token
     * @param array $form_data Filters (doc_access_type, reference_id, status, etc.)
     * @return array Response array
     */
    public function getDocumentAccessLogs($api_token, $form_data = []) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'doc_access_v1', $form_data, $headers);
    }

    /**
     * Update document access status
     * 
     * @param string $api_token API authentication token
     * @param array $form_data Form data including id and status
     * @return array Response array
     */
    public function updateDocumentAccessStatus($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['id'] ?? null;
        if ($id) {
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/doc_access/' . $id;
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'doc_access_v1', $form_data, $headers);
    }

    /**
     * Delete document access log (soft delete by setting status to 'delete')
     * 
     * @param string $api_token API authentication token
     * @param int $id Document access log ID
     * @return array Response array
     */
    public function deleteDocumentAccess($api_token, $id) {
        $headers = get_api_headers($api_token);
        $form_data = ['id' => $id, 'status' => 'delete'];
        return $this->updateDocumentAccessStatus($api_token, $form_data);
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

