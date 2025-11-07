<?php
class Taxcontrolinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function Taxcontrolinsertupdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'tax_master_v1', $form_data, $headers);
    }

    public function Taxcontroledit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'tax_master_v1', $id, $headers);
    }

    public function Taxcontrolupdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'tax_master_v1', $form_data, $headers);
    }

    public function Taxcontrolstatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'tax_control_status_v1', $form_data, $headers);
    }

    public function TaxcontrolDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'tax_master_v1', $id, $headers);
    }

}