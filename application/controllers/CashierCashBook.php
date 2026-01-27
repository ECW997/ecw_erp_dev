<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierCashBook extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Shiftinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        // Get all shifts for dropdown
        $shifts_response = $this->Shiftinfo->getAllCashierLog($this->api_token, []);
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['shifts'] = $shifts_response;

        $this->load->view('Cashier/CashBook', $result);
    }

    public function getCashBook($shiftId) {
        $response = $this->Shiftinfo->getCashBook($this->api_token, $shiftId);
        echo json_encode($response);
    }

    public function getAllCashierLog() {
        $response = $this->Shiftinfo->getAllCashierLog($this->api_token, $this->input->get());
        echo json_encode($response);
    }

    public function getCashBookByDateRange() {
        $fromDate = $this->input->post('from_date');
        $toDate = $this->input->post('to_date');
        
        if (!$fromDate || !$toDate) {
            echo json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'From date and to date are required'
            ]);
            return;
        }
        
        $response = $this->Shiftinfo->getCashBookByDateRange($this->api_token, $fromDate, $toDate);
        echo json_encode($response);
    }
}

