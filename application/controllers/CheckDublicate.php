<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CheckDublicate extends CI_Controller {
    public function check_duplicate() {
        $this->load->model('CheckDublicateinfo');

        $input_value = $this->input->post('input_value'); 
        $tablename = $this->input->post('tablename'); 
        $column_name = $this->input->post('column_name'); 

        $is_duplicate = $this->CheckDublicateinfo->is_duplicate($column_name, $tablename, $input_value);

        if ($is_duplicate) {
            echo json_encode(['status' => 'error', 'message' => 'Duplicate entry found']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'No duplicate found']);
        }
    }
}