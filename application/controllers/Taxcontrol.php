<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Taxcontrol extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Taxcontrolinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
        $this->load->model('Taxcontrolinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('taxcontrol', $result);
	}

    public function Taxcontrolinsertupdate() {
		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'tax_name' => $this->input->post('tax_name'),
			'tax_date' => $this->input->post('tax_date'),
			'rate' => $this->input->post('rate'),
			'effective_from' => $this->input->post('effective_from'),
			'recordID' => $this->input->post('recordID'),
        ];

		$response='';
		if($recordOption == '1'){
			$response = $this->Taxcontrolinfo->Taxcontrolinsertupdate($this->api_token,$form_data);
		}else{
			$response = $this->Taxcontrolinfo->Taxcontrolupdate($this->api_token,$form_data);
		}

		if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
        	redirect('Taxcontrol');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Taxcontrol');
		}
    }

	public function Taxcontroledit($id) {
        $response = $this->Taxcontrolinfo->Taxcontroledit($this->api_token,$id);
		echo json_encode($response);
    }


	public function Taxcontrolstatus($id, $status) {
		$form_data = [
			'recordID' => $id,
			'status' => $status,
		];

		$response = $this->Taxcontrolinfo->Taxcontrolstatus($this->api_token, $form_data);

		 if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('Taxcontrol');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Taxcontrol');
        }
	}

	public function TaxcontrolDelete($id) {
        $response = $this->Taxcontrolinfo->TaxcontrolDelete($this->api_token,$id);


		echo json_encode($response);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('Taxcontrol');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Taxcontrol');
        }
    }


	
   
}