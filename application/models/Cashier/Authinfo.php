<?php
class Authinfo extends CI_Model{

    public function authorize($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cashier_auth_authorize_v1', [], $headers);
    }

    public function checkSession($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_auth_session_v1', [], $headers);
    }

    public function logout($api_token, $close_shift = false) {
        $headers = get_api_headers($api_token);
        $data = $close_shift ? ['close_shift' => true] : [];
        return call_api('POST', 'cashier_auth_logout_v1', $data, $headers);
    }
}

