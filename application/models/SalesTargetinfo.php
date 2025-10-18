<?php
class SalesTargetinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function salesTargetDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'sales_target_v1', $id, $headers);
    }



}