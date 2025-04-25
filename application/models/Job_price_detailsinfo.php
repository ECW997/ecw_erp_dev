<?php
class Job_price_detailsinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function jobOptionPricingInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'job_option_pricing_v1', $form_data, $headers);
    }
    
    public function jobOptionPricingDetailsList($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_job_option_value_pricing_list_v1', $id, $headers);
    }

    public function jobOptionPricingUpdateDetailsList($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_job_option_value_pricing_edit_v1', $id, $headers);
    }

}