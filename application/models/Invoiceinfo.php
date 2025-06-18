<?php
class Invoiceinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function getCustomerDetails($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'customer_details_v1', $id, $headers);
    }


}