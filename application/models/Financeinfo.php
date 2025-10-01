<?php
class Financeinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function jobOptionInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'job_option_v1', $form_data, $headers);
    }
    public function jobOptionEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_option_v1', $id, $headers);
    }
    public function jobOptionUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'job_option_v1', $form_data, $headers);
    }
    public function getOptionGroup($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_optiongroup_v1', $form_data, $headers);
    }
    public function jobOptionDetailsList($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_option_details_list_v1', $id, $headers);
    }
    public function jobOptionStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'job_option_status_v1', $form_data, $headers);
    }
    public function jobOptionDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'job_option_v1', $id, $headers);
    }
   

}