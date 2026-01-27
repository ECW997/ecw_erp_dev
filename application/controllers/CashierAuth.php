<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierAuth extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Authinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function authorize() {
        // Log authorization attempt
        log_cashier_transaction('auth', 'authorize', null, [], [], true, 'Cashier authorization attempt');

        $response = $this->Authinfo->authorize($this->api_token);

        if ($response) {
            // Store cashier session in session
            if (isset($response['data']) && $response['status']) {
                $this->session->set_userdata('cashier_session', $response['data']);
                $this->session->set_userdata('cashier_authorized', true);
                log_cashier_transaction('auth', 'authorize', null, ['status' => 'authorized'], [], true, 'Cashier authorized successfully');
            } else {
                log_cashier_transaction('auth', 'authorize', null, [], [], false, 'Cashier authorization failed');
            }
            echo json_encode($response);
        } else {
            log_cashier_transaction('auth', 'authorize', null, [], [], false, 'Cashier authorization failed: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function checkSession() {
        // Log session check (light logging, not all checks)
        $response = $this->Authinfo->checkSession($this->api_token);
        echo json_encode($response);
    }

    public function logout() {
        $close_shift = $this->input->post('close_shift') == 'true';
        
        // Log logout attempt
        log_cashier_transaction('auth', 'logout', null, ['close_shift' => $close_shift], [], true, 'Cashier logout attempt');
        
        $response = $this->Authinfo->logout($this->api_token, $close_shift);

        if ($response) {
            // Clear cashier session
            $this->session->unset_userdata('cashier_session');
            $this->session->unset_userdata('cashier_authorized');
            log_cashier_transaction('auth', 'logout', null, ['close_shift' => $close_shift], [], true, 'Cashier logged out successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('auth', 'logout', null, ['close_shift' => $close_shift], [], false, 'Cashier logout failed: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }
}

