<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Map extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Mapinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('map', $result);
	}

    public function getMapPdf()
	{
		$sub_job_category = $this->input->get('sub_job_category');
		$api_url = 'https://devapi.ecw.lk/api/v1/get_map_pdf';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
			'sub_job_category' => $sub_job_category
		]));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/pdf',
			'Content-Type: application/json',
			'Authorization: Bearer ' . $this->api_token
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close($ch);

		if ($httpCode == 200) {
			header("Content-Type: $contentType");
			header("Content-Disposition: inline; filename=Map.pdf");
			echo $response;
		} else {
			echo "Failed to generate PDF. Please try again.";
		}

		exit;
	}

	public function generate_pdf() {
        $html = $this->input->post('html_content');

		$this->load->library('Pdf');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->loadHtml($html, 'UTF-8');
        $this->pdf->render();
        $this->pdf->stream( "Map.pdf", array("Attachment"=>0));

        // Output PDF
        header("Content-type: application/pdf");
        echo $pdf->output();
    }

	public function jobOptionInsertUpdate() {
		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'sub_job_category_id' => $this->input->post('sub_job_category'),
			'option_name' => $this->input->post('option_name'),
			'option_type' => $this->input->post('option_type'),
			'option_group' => $this->input->post('option_group_id'),
            'is_required' => $this->input->post('required_status'),
            'description' => $this->input->post('description'),
            'company_id' => $this->input->post('company_id'),
            'branch_id' => $this->input->post('branch_id'),
			'recordID' => $this->input->post('recordID'),
        ];

	
		$response='';
		if($recordOption == '1'){
			$response = $this->Mapinfo->jobOptionInsert($this->api_token,$form_data);
		}else{
			$response = $this->Mapinfo->jobOptionUpdate($this->api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
		}
    }

    public function jobOptionEdit($id) {
        $response = $this->Mapinfo->jobOptionEdit($this->api_token,$id);

		echo json_encode($response);
    }

    public function jobOptionDetailsList() {
		$sub_id = $this->input->get('sub_id');
		$modalOption = $this->input->get('modalOption', true) ?: '1';
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->Mapinfo->jobOptionDetailsList($this->api_token,$sub_id);

		$data['data'] = $response;
		$data['modalOption'] = $modalOption;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('table_components/job_option_table', $data, true);

		echo ($html);
        echo "<script>console.log('PHP Data:', " . json_encode($data) . ");</script>";
    }

    public function jobOptionStatus($id, $status) {
        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->Mapinfo->jobOptionStatus($this->api_token,$form_data);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }

    public function jobOptionDelete($id) {
        $response = $this->Mapinfo->jobOptionDelete($this->api_token,$id);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }

    
}