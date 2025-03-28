<?php
class MainJobCategoryinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function mainJobCategoryInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'main_job_category_v1', $form_data, $headers);
    }

    public function mainJobCategoryEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'main_job_category_v1', $id, $headers);
    }

    public function mainJobCategoryUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'main_job_category_v1', $form_data, $headers);
    }

    public function mainJobCategoryStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'main_job_category_status_v1', $form_data, $headers);
    }

    public function mainJobCategoryDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'main_job_category_v1', $id, $headers);
    }

}