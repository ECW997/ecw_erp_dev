<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierReport extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Reportinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function dailySummary() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        $date = $this->input->get('date') ?: date('Y-m-d');
        
        // If AJAX request, return JSON
        if ($this->input->is_ajax_request() || $this->input->get('format') === 'json') {
            $response = $this->Reportinfo->dailySummary($this->api_token, $date);
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
        
        // Otherwise, load view
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['date'] = $date;
        $result['daily_summary'] = $this->Reportinfo->dailySummary($this->api_token, $date);

        $this->load->view('Cashier/Report/DailySummary', $result);
    }

    public function paymentSummary() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('-7 days'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['start_date'] = $start_date;
        $result['end_date'] = $end_date;
        $result['payment_summary'] = $this->Reportinfo->paymentSummary($this->api_token, $start_date, $end_date);

        $this->load->view('Cashier/Report/PaymentSummary', $result);
    }

    public function discrepancy() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        $shift_id = $this->input->get('shift_id');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['discrepancy_report'] = $this->Reportinfo->discrepancy($this->api_token, $shift_id, $start_date, $end_date);

        $this->load->view('Cashier/Report/Discrepancy', $result);
    }

    public function cashOutSummary() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        $shift_id = $this->input->get('shift_id');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['cash_out_summary'] = $this->Reportinfo->cashOutSummary($this->api_token, $shift_id, $start_date, $end_date);

        $this->load->view('Cashier/Report/CashOutSummary', $result);
    }

    public function outstandingIous() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        $shift_id = $this->input->get('shift_id');
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['outstanding_ious'] = $this->Reportinfo->outstandingIous($this->api_token, $shift_id);

        $this->load->view('Cashier/Report/OutstandingIous', $result);
    }
}

