<?php
class User_v2_info extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getUsers($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'users_v2', $id, $headers);
    }

    public function create($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('POST', 'users_v2', $form_data, $headers);
    }

    public function update($api_token,$form_data){
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'users_v2', $form_data, $headers);
    }

    public function edit($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'users_v2', $id, $headers);
    }

    public function delete($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'users_v2', $id, $headers);
    }

    public function activate($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'users_active_v2', $id, $headers);
    }

    public function deactivate($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'users_deactive_v2', $id, $headers);
    }

    public function permissions($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'user_permisson_v2', $id, $headers);
    }
}
?>