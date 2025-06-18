<?php
class JobOptionValueinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function jobOptionValueInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'job_option_value_v1', $form_data, $headers);
    }

    public function getJobOption($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_job_option_v1', $form_data, $headers);
    }

    public function getJobOptionValue($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_job_option_value_v1', $form_data, $headers);
    }

    public function jobOptionValueEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_option_value_v1', $id, $headers);
    }

    public function jobOptionValueDetailsList($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_option_value_details_list_v1', $id, $headers);
    }

    public function jobOptionValueUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'job_option_value_v1', $form_data, $headers);
    }

    public function jobOptionValueStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'job_option_value_status_v1', $form_data, $headers);
    }

    public function jobOptionValueDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'job_option_value_v1', $id, $headers);
    }

    public function getImagesByCategory($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_images_by_category_v1', $form_data, $headers);
    }

}