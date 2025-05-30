<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_api_headers')) {
    function get_api_headers($api_token) {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json'
        ];
        if ($api_token) {
            $headers[] = 'Authorization: Bearer ' . $api_token;
        }
        return $headers;
    }
}


if (!function_exists('call_api')) {
    function call_api($method, $endpoint, $data = [], $headers = []) {
        $CI =& get_instance();
        $CI->config->load('api_config');  
        $base_url = $CI->config->item('api_base_url');
        $endpoints = $CI->config->item('api_endpoints');

        if (!isset($endpoints[$endpoint])) {
            return [
                'status' => false,
                'message' => 'Invalid API endpoint.',
                'code' => 400,
            ];
        }

        $url = $base_url . $endpoints[$endpoint];

        if (($method === 'GET') && !empty($data)) {
            $url .= '/' . $data;
        }
        if (($method === 'PUT') && !empty($data)) {
            $url .= '/' . $data['recordID'];

            if(isset($data['status'])){
                $url .= '/'.$data['status'];
            }
        }

        if (($method === 'DELETE') && !empty($data)) {
            $url .= '/' . $data;
        }

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
        }elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }  

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return json_decode($response, true);
    }

    if (!function_exists('auth_check')) {
        function auth_check() {
            $CI =& get_instance();
            $api_token = $CI->session->userdata('api_token');

            if (!$api_token) {
                $CI->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
                redirect('Welcome/Logout');
                exit;
            }

            $CI->load->model('Authinfo');
            $response = $CI->Authinfo->validateToken($api_token);

            if (!$response || !$response['status']) {
                $CI->session->set_flashdata(['res' => '401', 'msg' => 'Session expired or invalid token']);
                redirect('Welcome/Logout');
                exit;
            }
            return [
                'api_token' => $api_token,
                'user' => $response['user'] ?? null, 
            ];
        }
    }

}




