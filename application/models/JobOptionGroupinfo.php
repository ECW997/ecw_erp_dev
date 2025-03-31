<?php
class JobOptionGroupinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function jobOptionGroupInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'job_option_group_v1', $form_data, $headers);
    }

    public function jobOptionGroupEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_option_group_v1', $id, $headers);
    }

    public function jobOptionGroupDetailsList($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_option_group_details_list_v1', $id, $headers);
    }

    public function jobOptionGroupUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'job_option_group_v1', $form_data, $headers);
    }

    public function jobOptionGroupStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'job_option_group_status_v1', $form_data, $headers);
    }

    public function jobOptionGroupDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'job_option_group_v1', $id, $headers);
    }

}