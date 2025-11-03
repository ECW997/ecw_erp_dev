<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierDebitor extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('CashierDebitorinfo');
        
        $auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index() {
        $this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));

        $this->load->view('cashier_debtor_list', $result);
    }

    public function debtorInsertUpdate() {
        $recordOption = $this->input->post('recordOption'); // 1 = Add, 2 = Update
        
        $form_data = [
            'date' => $this->input->post('date'),
            'job_no' => $this->input->post('job_no'),
            'sale_person' => $this->input->post('sale_person'),
            'customer_name' => $this->input->post('customer_name'),
            'phone_no' => $this->input->post('phone_no'),
            'vehicle_no' => $this->input->post('vehicle_no'),
            'vehicle_type' => $this->input->post('vehicle_type'),
            'inv_amount' => $this->input->post('inv_amount'),
            'advance_amount' => $this->input->post('advance_amount'),
            'balance_amount' => $this->input->post('balance_amount'),
            'number_of_days' => $this->input->post('number_of_days'),
            'approved_by' => $this->input->post('approved_by'),
            'recordID' => $this->input->post('debtor_id')
        ];

        if ($recordOption == '1') {
            $response = $this->CashierDebitorinfo->debtorInsert($this->api_token, $form_data);
        } else {
            $response = $this->CashierDebitorinfo->debtorUpdate($this->api_token, $form_data);
        }

        if ($response) {
            echo json_encode($response);
        } else {
            $this->session->set_flashdata(['res' => '204', 'msg' => 'No Response from Server!']);
            redirect('CashierDebitor');
        }
    }

    public function debtorEdit($id) {
        $response = $this->CashierDebitorinfo->debtorEdit($this->api_token, $id);
        echo json_encode($response);
    }

    public function debtorDetailsList() {
        $modalOption = $this->input->get('modalOption', true) ?: '1';
        $editcheck = $this->input->get('editcheck');
        $statuscheck = $this->input->get('statuscheck');
        $deletecheck = $this->input->get('deletecheck');

        $response = $this->CashierDebitorinfo->debtorDetailsList($this->api_token);

        $data['data'] = $response;
        $data['modalOption'] = $modalOption;
        $data['editcheck'] = $editcheck;
        $data['statuscheck'] = $statuscheck;
        $data['deletecheck'] = $deletecheck;

        $html = $this->load->view('components/table/debtor_table', $data, true);
        echo ($html);
    }

    public function debtorDelete($id) {
        $response = $this->CashierDebitorinfo->debtorDelete($this->api_token, $id);

        if ($response) {
            echo json_encode($response);
        } else {
            $this->session->set_flashdata(['res' => '204', 'msg' => 'No Response from Server!']);
            redirect('CashierDebitor');
        }
    }

    public function debtorTransferToCredit() {
        $debtor_id = $this->input->post('debtor_id');
        $settlement_date = $this->input->post('settlement_date');
        $payment_details = $this->input->post('payment_details');

        $form_data = [
            'recordID' => $debtor_id,
            'settlement_date' => $settlement_date,
            'payment_details' => $payment_details
        ];

        $response = $this->CashierDebitorinfo->debtorTransferToCredit($this->api_token, $form_data);

        if ($response) {
            echo json_encode($response);
        } else {
            $this->session->set_flashdata(['res' => '204', 'msg' => 'No Response from Server!']);
            redirect('CashierDebitor');
        }
    }
}
