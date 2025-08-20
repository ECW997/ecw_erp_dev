<?php
class Media_libraryinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
  
    public function media_libraryInsert($api_token, $form_data) {
        $headers = [
            'Accept: application/json',
            'Authorization: Bearer ' . $api_token
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.ecw.lk/api/v1/media_library');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function Media_libraryEdit($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'media_library_v1', $form_data, $headers);
    }

    public function media_libraryUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'media_library_v1', $form_data, $headers);
    }

    public function Media_librarystatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'media_library_status_v1', $form_data, $headers);
    }

}