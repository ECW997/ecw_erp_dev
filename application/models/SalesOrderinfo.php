<?php
class SalesOrderinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function SalesOrderInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'sales_order_v1', $form_data, $headers);
    }
    public function getSalesOrderById($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'sales_order_v1', $id, $headers);
    }
    public function SalesOrderUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'sales_order_v1', $form_data, $headers);
    }
    public function SalesOrderDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'sales_order_v1', $id, $headers);
    }
   

}