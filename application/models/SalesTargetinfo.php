<?php
class SalesTargetinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getMainJob($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_mainjob_v1', $form_data, $headers);
    }
    public function getSubJob($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_subjob_v1', $form_data, $headers);
    }

    public function subJobCategoryInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'sub_job_category_v1', $form_data, $headers);
    }

    // public function subJobCategoryEdit($api_token,$id) {
    //     $headers = get_api_headers($api_token);
    //     return call_api('GET', 'sub_job_category_v1', $id, $headers);
    // }

    // public function subJobCategoryUpdate($api_token,$form_data) {
    //     $headers = get_api_headers($api_token);
    //     return call_api('PUT', 'sub_job_category_v1', $form_data, $headers);
    // }

    // public function subJobCategoryStatus($api_token,$form_data) {
    //     $headers = get_api_headers($api_token);
    //     return call_api('PUT', 'sub_job_category_status_v1', $form_data, $headers);
    // }

    // public function subJobCategoryDelete($api_token,$form_data) {
    //     $headers = get_api_headers($api_token);
    //     return call_api('DELETE', 'sub_job_category_v1', $form_data, $headers);
    // }


}