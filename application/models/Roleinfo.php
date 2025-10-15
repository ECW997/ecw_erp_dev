<?php
class Roleinfo extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getUserRoles($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'roles_v2', $id, $headers);
    }

    public function create($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('POST', 'roles_v2', $form_data, $headers);
    }

    public function update($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'roles_v2', $form_data, $headers);
    }

    public function edit($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'roles_v2', $id, $headers);
    }

    public function delete($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'roles_v2', $id, $headers);
    }

    public function permissions($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'roles_permissions_v2', $id, $headers);
    }

    public function updatePermission($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'roles_permissions_update_v2', $form_data, $headers);
    }
}
?>