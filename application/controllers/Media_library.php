<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Media_library extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Media_libraryinfo');
    }

    public function index(){
		$api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}
		
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('media_library', $result);
	}
	public function media_libraryInsert() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$form_data = [
			'media_type' => $this->input->post('media_type'),
			'description' => $this->input->post('description'),
			'category' => $this->input->post('category'),
			'uploaded_by' => $this->session->userdata('user_id'),
			'is_active' => true, 
			'recordID' => $this->input->post('recordID')
		];
	
		$files = $_FILES['design_image'];
		$curlFiles = [];
		
		for ($i = 0; $i < count($files['name']); $i++) {
			if ($files['error'][$i] === UPLOAD_ERR_OK) {
				$curlFiles["files[$i]"] = new CURLFile( // Changed to 'files' to match Laravel expectation
					$files['tmp_name'][$i],
					$files['type'][$i],
					$files['name'][$i]
				);
			}
		}
		
		$postData = array_merge($form_data, $curlFiles);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://devapi.ecw.lk/api/v1/media_upload');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer $api_token",
			'Accept: application/json'
		]);
	
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError = curl_error($ch);
		curl_close($ch);
	
		if ($curlError) {
			$this->session->set_flashdata(['res' => '500', 'msg' => 'CURL Error: ' . $curlError]);
			redirect('Media_library');
			return;
		}
	
		$responseData = json_decode($response, true);
		
		if ($httpCode >= 200 && $httpCode < 300) {
			$this->session->set_flashdata(['res' => '200', 'msg' => 'Media uploaded successfully']);
		} else {
			$errorMsg = $responseData['message'] ?? 'Failed to upload media';
			$this->session->set_flashdata(['res' => $httpCode, 'msg' => $errorMsg]);
		}
	
		redirect('Media_library');

    }
    
}