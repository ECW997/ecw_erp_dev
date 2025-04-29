<?php
class Mapinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function getMapPdf($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_map_pdf_v1', $form_data, $headers);
    }

}