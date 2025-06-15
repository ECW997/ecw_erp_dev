<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Media_library extends CI_Controller {
	protected $api_token;
    protected $auth_user;

	public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Media_libraryinfo');
		
		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('media_library', $result);
	}

	public function media_libraryInsert() {
		// Define maximum allowed file size (50MB in bytes)
		$maxFileSize = 50 * 1024 * 1024; 
		$recordOption = $this->input->post('recordOption');
		
		if (empty($_FILES['design_image']['name'][0]) && $recordOption == '1') {
			$this->session->set_flashdata(['res' => '400', 'msg' => 'No files were selected for upload']);
			redirect('Media_library');
			return;
		}

		// Validate each file's size before processing
		$files = $_FILES['design_image'];
		foreach ($files['size'] as $size) {
			if ($size > $maxFileSize) {
				$this->session->set_flashdata(['res' => '400', 'msg' => 'One or more files exceed the 50MB limit']);
				redirect('Media_library');
				return;
			}
		}


		$form_data = [
			'media_type' => $this->input->post('media_type'),
			'description' => $this->input->post('description'),
			'category' => $this->input->post('category'),
			'is_active' => $this->input->post('is_active'),
			'recordID' => $this->input->post('recordID')
		];
	
		$files = $_FILES['design_image'];
		$curlFiles = [];
		
		for ($i = 0; $i < count($files['name']); $i++) {
			if ($files['error'][$i] === UPLOAD_ERR_OK) {
				$curlFiles["files[$i]"] = new CURLFile( 
					$files['tmp_name'][$i],
					$files['type'][$i],
					$files['name'][$i]
				);
			}
		}
	
		
		$all_form_data = array_merge($form_data, $curlFiles);

		$response='';
		if($recordOption == '1'){
			$response = $this->Media_libraryinfo->media_libraryInsert($this->api_token,$all_form_data);
		}else{
			$response = $this->Media_libraryinfo->media_libraryUpdate($this->api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
        	redirect('Media_library');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Media_library');
		}
    }

	public function Media_libraryEdit($id) {
        $response = $this->Media_libraryinfo->Media_libraryEdit($this->api_token,$id);
		echo json_encode($response);
    }

	public function Media_librarystatus($id, $status) {
        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->Media_libraryinfo->Media_librarystatus($this->api_token,$form_data);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Media_library');
        }
    }


    public function jobOptionDelete($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobOptioninfo->jobOptionDelete($api_token,$id);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }
    
}