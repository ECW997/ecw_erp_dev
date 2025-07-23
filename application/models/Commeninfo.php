<?php
class Commeninfo extends CI_Model{

    public function getMenuPrivilege($api_token, $params = [])
    {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'menu_privilege_v1', $params, $headers);
    }

}