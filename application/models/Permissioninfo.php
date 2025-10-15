<?php
class Permissioninfo extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getAllPermission($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'all_permissions_v2', $id, $headers);
    }

    public function create($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('POST', 'permissions_v2', $form_data, $headers);
    }

    public function update($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'permissions_v2', $form_data, $headers);
    }

    public function edit($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'permissions_v2', $id, $headers);
    }

    public function delete($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'permissions_v2', $id, $headers);
    }
}
?>