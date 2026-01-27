<?php
class Handoverinfo extends CI_Model{

    public function getHandoverLogs($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_handover_v1', $form_data, $headers);
    }

    public function getHandoverById($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_handover_v1', $id, $headers);
    }

    public function updateHandoverAmount($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'cashier_handover_v1', $form_data, $headers);
    }

    public function verifyHandover($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        $id = $form_data['recordID'] ?? null;
        if ($id) {
            // Construct URL for nested route: /v1/cashier/handover/{id}/verify
            $CI =& get_instance();
            $CI->config->load('api_config');
            $base_url = $CI->config->item('api_base_url');
            $url = $base_url . '/v1/cashier/handover/' . $id . '/verify';
            return $this->make_api_call('PUT', $url, $form_data, $headers);
        }
        return call_api('PUT', 'verify_cash_handover_v1', $form_data, $headers);
    }

    public function generateVoucher($api_token, $id) {
        $headers = get_api_headers($api_token);
        // Construct URL for nested route: /v1/cashier/handover/{id}/voucher
        $CI =& get_instance();
        $CI->config->load('api_config');
        $base_url = $CI->config->item('api_base_url');
        $url = $base_url . '/v1/cashier/handover/' . $id . '/voucher';
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

    public function getHandoverLogsDatatable($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_handover_datatable_v1', $form_data, $headers);
    }
}

