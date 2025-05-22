<?php
class Media_libraryinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    public function media_libraryInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'media_library_v1', $form_data, $headers);
    }

}