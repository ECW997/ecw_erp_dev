<?php 
class CheckDublicateinfo extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function is_duplicate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'check_dublicate_entry_v1', $form_data, $headers);
    }
}
?>