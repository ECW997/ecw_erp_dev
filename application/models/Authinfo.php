<?php
class Authinfo extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function login($form_data) {
        $headers = get_api_headers('');
        return call_api('POST', 'login', $form_data, $headers);
    }

    public function validateToken($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'auth_check', '', $headers);
    }

     public function Logout($api_token) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'logout', '', $headers);
    }
}
?>