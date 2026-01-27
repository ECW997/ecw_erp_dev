<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Payment extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Paymentinfo');
		$this->load->model('CashierShiftinfo');
		$this->load->model('Companyinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function index(){
		$this->load->model('Commeninfo');
		$check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['check_cashier_shift'] = $check_cashier_shift_response;

		// $status = isset($check_cashier_shift_response['status']) ? $check_cashier_shift_response['status'] : false;
		// $code   = isset($check_cashier_shift_response['code']) ? $check_cashier_shift_response['code'] : 0;
		// $is_opening_approved = $check_cashier_shift_response['shift']['opening_approved_at'] == null ? false : true;

		// if ($status === true && $code == 200) {
		// 	// if($is_opening_approved){
		// 	// 	$this->load->view('paymentList', $result);
		// 	// }else{
		// 	// 	$this->load->view('components/modal/cashier/background_layout', $result);
		// 	// }
		// 	$this->load->view('paymentList', $result);
		// } elseif ($status === true && $code == 403) {
		// 	$this->load->view('components/modal/cashier/background_layout', $result);
		// } else {
		// 	$this->load->view('components/modal/cashier/background_layout', $result);
		// }

		$this->load->view('paymentList', $result);
	}
	
	public function paymentDetailIndex($id = null, $series_type = null){
		$this->load->model('Commeninfo');
		$check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);

		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
 		$result['check_cashier_shift'] = $check_cashier_shift_response;
		$result['company_bank'] = $this->Companyinfo->getCompanyBank($this->api_token)['data'];
		
		// $status = isset($check_cashier_shift_response['status']) ? $check_cashier_shift_response['status'] : false;
		// $code   = isset($check_cashier_shift_response['code']) ? $check_cashier_shift_response['code'] : 0;
		// $is_opening_approved = $check_cashier_shift_response['shift']['opening_approved_at'] == null ? false : true;
		$branch_id = $this->session->userdata('branch_id');
		$customer_id = $this->input->get('customer_id'); 
		$customer_name = $this->input->get('customer_name');
		$jobcard_no = $this->input->get('jobcard_no');

        if ($id !== null) {
			$result['customerId'] = null;
			$result['customerName'] = null;
			$result['jobCardNo'] = null;
			$result['draft_receipt_no'] = null;
			$result['payment_main_data'] = $this->Paymentinfo->getPaymentById($this->api_token,$id,['series_type' => $series_type])['data']['header'];
			$result['payment_detail_data'] = $this->Paymentinfo->getPaymentById($this->api_token,$id,['series_type' => $series_type])['data']['details'];
			$result['payment_allocation_detail_data'] = $this->Paymentinfo->getPaymentById($this->api_token,$id,['series_type' => $series_type])['data']['allocated_details_group'];
			$result['is_edit'] = true;
        }else{
			$result['customerId'] = $customer_id;
			$result['customerName'] = $customer_name;
			$result['jobCardNo'] = $jobcard_no;
			$result['draft_receipt_no'] = $this->Paymentinfo->getDraftReceiptNO($this->api_token,'1')['data'];
			$result['payment_main_data'] = null;
            $result['payment_detail_data'] = null;
            $result['is_edit'] = false;
		}

		// if ($status === true && $code == 200) {
		// 	// if($is_opening_approved){
		// 	// 	$this->load->view('payment', $result);
		// 	// }else{
		// 	// 	$this->load->view('components/modal/cashier/background_layout', $result);
		// 	// }

		// 	$this->load->view('payment', $result);
		// } elseif ($status === true && $code == 403) {
		// 	$this->load->view('components/modal/cashier/background_layout', $result);
		// } else {
		// 	$this->load->view('components/modal/cashier/background_layout', $result);
		// }

		
		$this->load->view('payment', $result);
	}

	public function generateDraftReceiptNo($seriesType) {
		$response = $this->Paymentinfo->getDraftReceiptNO($this->api_token,$seriesType);
		
		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
			redirect('Payment');
		}
	}

	public function getCustomer(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Paymentinfo->getCustomer($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function getOutstandingInvoicesByCustomer($id, $series_type = null) {
        $response = $this->Paymentinfo->getOutstandingInvoicesByCustomer($this->api_token,$id,['series_type' => $series_type]);
		echo json_encode($response);
    }

	public function getJobCardsByCustomer($id, $series_type = null) {
        $response = $this->Paymentinfo->getJobCardsByCustomer($this->api_token,$id,['series_type' => $series_type]);
		echo json_encode($response);
    }

	public function createReceipt() {
		$form_data = [
            'draft_receipt_no' => $this->input->post('draft_receipt_no'),
			'date' => $this->input->post('date'),
			'customer_id' => $this->input->post('customer_id'),
			'payment_by' => $this->input->post('payment_by'),
			'payment_note' => $this->input->post('payment_note'),
			'payment_type' => $this->input->post('payment_type'),
			'payment_series' => $this->input->post('payment_series'),
			'branch_id' => $this->input->post('branch_id'),
			'company_id' => $this->input->post('company_id'),
			'payment_data' => $this->input->post('payment_data'),
			'allocation_data' => $this->input->post('allocation_data'),
        ];
		
		$response = $this->Paymentinfo->createReceipt($this->api_token,$form_data);
	
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function getPayDetails($id, $series_type = null) {
        $response = $this->Paymentinfo->getPayDetails($this->api_token,$id,['series_type' => $series_type]);
		echo json_encode($response);
    }

	public function getPayAllocationDetails($id, $series_type = null) {
        $response = $this->Paymentinfo->getPayAllocationDetails($this->api_token,$id,['series_type' => $series_type]);
		echo json_encode($response);
    }

	public function insertORUpdatePayment() {
		$form_data = [
            'payment_date' => $this->input->post('payment_date'),
			'invoice_id' => $this->input->post('invoice_id'),
			'payment_option' => $this->input->post('payment_option'),
			'payment' => $this->input->post('payment'),
			'cheque_number' => $this->input->post('cheque_number'),
			'bank_reference' => $this->input->post('bank_reference'),
			'allocateBankDate' => $this->input->post('allocateBankDate'),
			'allocateChequeDate' => $this->input->post('allocateChequeDate'),
			'branch_id' => $this->input->post('branch_id'),
			'company_id' => $this->input->post('company_id'),
        ];
		
		$response = $this->Paymentinfo->insertORUpdatePayment($this->api_token,$form_data);
	
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function verifyPayment() {
		$form_data = [
			'recordID' => $this->input->post('recordID'),
			'payment_note' => $this->input->post('payment_note'),
			'payment_series' => $this->input->post('payment_series'),
        ];
		$response = $this->Paymentinfo->verifyPayment($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function deletePayment($id,$table,$series_id) {
		$form_data = [
					'id' => $id,
					'table' => $table,
					'series_id' => $series_id
		];

		$response = $this->Paymentinfo->deletePayment($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function paymentReceiptPDF(){
		// Start output buffering and clear any previous output
		if (ob_get_level()) {
			ob_end_clean();
		}
		ob_start();
		
		$this->load->model('Invoiceinfo');
		$this->load->helper('doc_access_helper');
		$id=$this->input->get('receipt_id');
		$series_type=$this->input->get('series_id');
        $response=$this->Paymentinfo->getReceiptPdfDetails($this->api_token,$id,['series_type' => $series_type]);

		if (!$response['status'] || $response['code'] != 200) {
			ob_end_clean();
			show_error('Failed to fetch Payment data');
		}

		$pdf_data = [
			'header' => $response['data']['pay_header'],  
    		'invoices' => $response['data']['details'], 		
		];

		$payment_type = $pdf_data['header']['payment_type'];
		$upload_dir = FCPATH . 'uploads/';
    	if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

		$this->load->library('Pdf');
    	$customPaper = [0, 0, 382.84, 380.84];

		$receipt_pdf = new Pdf();
		$receipt_pdf->setPaper($customPaper);
		$receipt_pdf->set_option('defaultFont', 'Helvetica');
		$receipt_pdf->set_option('isRemoteEnabled', true);
		

		$receiptView = ($payment_type == 'JobCard')
			? ($series_type == 1 ? 'components/pdf/advance_receipt_pdf' : 'components/pdf/advance_receipt_v2_pdf')
			: ($series_type == 1 ? 'components/pdf/payment_receipt_pdf' : 'components/pdf/payment_receipt_v2_1_pdf');

		$receipt_html = $this->load->view($receiptView, $pdf_data, TRUE);

		$receipt_pdf->loadHtml($receipt_html);
    	$receipt_pdf->render();

		$receipt_path = $upload_dir . 'temp_receipt.pdf';
		file_put_contents($receipt_path, $receipt_pdf->output());

		if ($payment_type == 'Invoice') {
			$invoice_id = $pdf_data['invoices'][0]['invoice_id'];
			$inv_response = $this->Invoiceinfo->getInvoicePdfDetails($this->api_token, $invoice_id, ['series_type' => $series_type]);

			if (!$inv_response['status'] || $inv_response['code'] != 200) {
				show_error('Failed to fetch Invoice data');
			}

			$invoice_data = [
				'main_data'          => $inv_response['data']['main_data'][0],
				'details_data'       => $inv_response['data']['details_data'],
				'extra_charge_data'  => $inv_response['data']['extra_charge_data'],
				'total_paid_for_ref' => $inv_response['data']['total_paid_for_ref'],
			];

			$invoiceView = ($invoice_data['main_data']['series_type'] == '1')
				? 'components/pdf/job_invoice_pdf'
				: 'components/pdf/job_invoice_v2_pdf';

			$invoice_pdf = new Pdf();
			$invoice_pdf->setPaper($customPaper);
			$invoice_pdf->set_option('defaultFont', 'Helvetica');
			$invoice_pdf->set_option('isRemoteEnabled', true);

			$invoice_html = $this->load->view($invoiceView, $invoice_data, TRUE);
			$invoice_pdf->loadHtml($invoice_html);
			$invoice_pdf->render();

			$invoice_path = $upload_dir . 'temp_invoice.pdf';
			file_put_contents($invoice_path, $invoice_pdf->output());

			// Get job card information for logging
			$real_jobcard_id = $invoice_data['main_data']['real_jobcard_id'] ?? null;
			$real_jobcard_no = $invoice_data['main_data']['real_jobcard_no'] ?? '';

			// Log print operation for receipt
			$branch_id = $this->session->userdata('branch_id');
			$company_id = $this->session->userdata('company_id');
			$receipt_remarks = 'Receipt printed with invoice (Series: ' . $series_type;
			if (!empty($real_jobcard_no)) {
				$receipt_remarks .= ', Job Card: ' . $real_jobcard_no;
			}
			$receipt_remarks .= ')';
			
			log_document_print('payment', $id, [
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'remarks' => $receipt_remarks
			]);

			// Log print operation for invoice
			$invoice_remarks = 'Invoice printed with receipt (Series: ' . $series_type;
			if (!empty($real_jobcard_no)) {
				$invoice_remarks .= ', Job Card: ' . $real_jobcard_no;
			}
			$invoice_remarks .= ')';
			
			log_document_print('invoice', $invoice_id, [
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'remarks' => $invoice_remarks
			]);

			// Generate gate pass PDF
			$gate_pass_payment_type = $invoice_data['main_data']['payment_type'] ?? 1;
			$invoice_number = $invoice_data['main_data']['invoice_number'] ?? '';
			$credit_type = ($gate_pass_payment_type == 1) ? 'Non-Credit' : 'Credit';

			if ($real_jobcard_id) {
				// Check if gate pass already exists for this job card (active records)
				$existing_logs = get_document_access_logs('gatepass_out', $real_jobcard_id, [
					'status' => 'active'
				]);
				
				$has_active_gate_pass = false;
				if ($existing_logs['status'] && $existing_logs['code'] == 200) {
					// API is paginated: actual rows are in ['data']['data']
					$logs_payload = $existing_logs['data'] ?? [];
					$logs_data = isset($logs_payload['data']) ? $logs_payload['data'] : $logs_payload;

					// Check if there are any active records
					if (is_array($logs_data) && count($logs_data) > 0) {
						$active_logs = array_filter($logs_data, function($log) {
							return isset($log['status']) && $log['status'] === 'active';
						});
						
						if (count($active_logs) > 0) {
							// Active gate pass exists - skip gate pass generation
							$has_active_gate_pass = true;
						}
					}
				}

				if (!$has_active_gate_pass) {
					// No active gate pass - proceed with generation
					// Flag to indicate whether this print should be marked as DUPLICATE on the PDF
					$is_duplicate = false;
					
					// Check for duplicate gate passes (non-active records)
					$all_logs = get_document_access_logs('gatepass_out', $real_jobcard_id, []);
					if ($all_logs['status'] && $all_logs['code'] == 200) {
						$all_payload = $all_logs['data'] ?? [];
						$all_data = isset($all_payload['data']) ? $all_payload['data'] : $all_payload;

						if (is_array($all_data) && count($all_data) > 0) {
							// At least one historical record exists (could be inactive/deleted)
							$is_duplicate = true;
						}
					}

					$gate_pass_data = [
						'main_data' => $invoice_data['main_data'],
						'is_duplicate' => $is_duplicate
					];

					$gate_pass_pdf = new Pdf();
					$gate_pass_pdf->setPaper($customPaper);
					$gate_pass_pdf->set_option('defaultFont', 'Helvetica');
					$gate_pass_pdf->set_option('isRemoteEnabled', true);

					if ($gate_pass_payment_type == 1) {
						$gate_pass_html = $this->load->view('components/pdf/gate_pass_out_noncredit_pdf', $gate_pass_data, TRUE);
					} else {
						$gate_pass_html = $this->load->view('components/pdf/gate_pass_out_credit_pdf', $gate_pass_data, TRUE);
					}

					$gate_pass_pdf->loadHtml($gate_pass_html);
					$gate_pass_pdf->render();

					$gate_pass_path = $upload_dir . 'temp_gate_pass.pdf';
					file_put_contents($gate_pass_path, $gate_pass_pdf->output());

					// Merge all PDFs: receipt + invoice + gate pass
					ob_end_clean(); // Clear output buffer before PDF merge
					$this->load->library('Fpdf_fpdi');
					$merged_filename = $pdf_data['header']['receipt_number'] . '_with_invoice_gatepass.pdf';
					$this->fpdf_fpdi->merge([$receipt_path, $invoice_path, $gate_pass_path], $merged_filename, 'I');

					// Log print operation for gate pass
					$gate_pass_remarks = 'Gate pass out printed (Series: ' . $series_type . ', Type: ' . $credit_type . ', Job Card: ' . $real_jobcard_no;
					if (!empty($invoice_number)) {
						$gate_pass_remarks .= ', Invoice No: ' . $invoice_number;
					}
					$gate_pass_remarks .= ')';
					
					log_document_print('gatepass_out', $real_jobcard_id, [
						'branch_id' => $branch_id,
						'company_id' => $company_id,
						'remarks' => $gate_pass_remarks
					]);

					// Remove temporary files
					if (file_exists($receipt_path)) unlink($receipt_path);
					if (file_exists($invoice_path)) unlink($invoice_path);
					if (file_exists($gate_pass_path)) unlink($gate_pass_path);
				} else {
					// Active gate pass exists - merge receipt + invoice without gate pass
					ob_end_clean(); // Clear output buffer before PDF merge
					$this->load->library('Fpdf_fpdi');
					$merged_filename = $pdf_data['header']['receipt_number'] . '_with_invoice.pdf';
					$this->fpdf_fpdi->merge([$receipt_path, $invoice_path], $merged_filename, 'I');

					// Remove temporary files
					if (file_exists($receipt_path)) unlink($receipt_path);
					if (file_exists($invoice_path)) unlink($invoice_path);
				}
			} else {
				// No job card ID, just merge receipt + invoice without gate pass
				ob_end_clean(); // Clear output buffer before PDF merge
				$this->load->library('Fpdf_fpdi');
				$merged_filename = $pdf_data['header']['receipt_number'] . '_with_invoice.pdf';
				$this->fpdf_fpdi->merge([$receipt_path, $invoice_path], $merged_filename, 'I');

				// Remove temporary files
				if (file_exists($receipt_path)) unlink($receipt_path);
				if (file_exists($invoice_path)) unlink($invoice_path);
			}

		} else {
			ob_end_clean(); // Clear output buffer before PDF stream
			$receipt_pdf->stream($pdf_data['header']['receipt_number'] . '.pdf', ['Attachment' => 0]);
			if (file_exists($receipt_path)) unlink($receipt_path);
			
			// Get job card information for logging (from invoices/details if available)
			$real_jobcard_no = '';
			if (!empty($pdf_data['header'])) {
				$real_jobcard_no = $pdf_data['header']['jobcard_no'];
			}
			
			// Log print operation for receipt
			$branch_id = $this->session->userdata('branch_id');
			$company_id = $this->session->userdata('company_id');
			$receipt_remarks = 'Receipt printed (Series: ' . $series_type . ', Type: ' . $payment_type;
			if (!empty($real_jobcard_no)) {
				$receipt_remarks .= ', Job Card: ' . $real_jobcard_no;
			}
			$receipt_remarks .= ')';
			
			log_document_print('payment', $id, [
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'remarks' => $receipt_remarks
			]);
		}
	}

	public function advancePaymentPDF2(){
		$this->load->model('Invoiceinfo');
		$id=$this->input->get('receipt_id');
		$series_type=$this->input->get('series_id');
        $response=$this->Paymentinfo->getReceiptPdfDetails($this->api_token,$id,['series_type' => $series_type]);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch Payment data');
		}

		$pdf_data = [
			'header' => $response['data']['pay_header'],  
    		'invoices' => $response['data']['details'], 		
		];

		$payment_type = $pdf_data['header']['payment_type'];
		$upload_dir = FCPATH . 'uploads/';
    	if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

		$this->load->library('Pdf');
    	$customPaper = [0, 0, 382.84, 380.84];

		$receipt_pdf = new Pdf();
		$receipt_pdf->setPaper($customPaper);
		$receipt_pdf->set_option('defaultFont', 'Helvetica');
		$receipt_pdf->set_option('isRemoteEnabled', true);

		$receiptView = (
		$series_type == 1
			? 'components/pdf/advance_receipt_pdf'
			: 'components/pdf/advance_receipt_v3_pdf'
		);

		$receipt_html = $this->load->view($receiptView, $pdf_data, TRUE);

		$receipt_pdf->loadHtml($receipt_html);
    	$receipt_pdf->render();

		$receipt_path = $upload_dir . 'temp_receipt.pdf';
		file_put_contents($receipt_path, $receipt_pdf->output());

		if ($payment_type == 'Invoice') {
			$invoice_id = $pdf_data['invoices'][0]['invoice_id'];
			$inv_response = $this->Invoiceinfo->getInvoicePdfDetails($this->api_token, $invoice_id, ['series_type' => $series_type]);

			if (!$inv_response['status'] || $inv_response['code'] != 200) {
				show_error('Failed to fetch Invoice data');
			}

			$invoice_data = [
				'main_data'          => $inv_response['data']['main_data'][0],
				'details_data'       => $inv_response['data']['details_data'],
				'extra_charge_data'  => $inv_response['data']['extra_charge_data'],
				'total_paid_for_ref' => $inv_response['data']['total_paid_for_ref'],
			];

			$invoiceView = ($invoice_data['main_data']['series_type'] == '1')
				? 'components/pdf/job_invoice_pdf'
				: 'components/pdf/job_invoice_v2_pdf';

			$invoice_pdf = new Pdf();
			$invoice_pdf->setPaper($customPaper);
			$invoice_pdf->set_option('defaultFont', 'Helvetica');
			$invoice_pdf->set_option('isRemoteEnabled', true);

			$invoice_html = $this->load->view($invoiceView, $invoice_data, TRUE);
			$invoice_pdf->loadHtml($invoice_html);
			$invoice_pdf->render();

			$invoice_path = $upload_dir . 'temp_invoice.pdf';
			file_put_contents($invoice_path, $invoice_pdf->output());

			// Merge PDFs using FPDI
			$this->load->library('Fpdf_fpdi');
			$merged_filename = $pdf_data['header']['receipt_number'] . '_with_invoice.pdf';
			$this->fpdf_fpdi->merge([$receipt_path, $invoice_path], $merged_filename, 'I');

			// Remove temporary files
			if (file_exists($receipt_path)) unlink($receipt_path);
			if (file_exists($invoice_path)) unlink($invoice_path);

		} else {
			$receipt_pdf->stream($pdf_data['header']['receipt_number'] . '.pdf', ['Attachment' => 0]);
			if (file_exists($receipt_path)) unlink($receipt_path);
		}
	}

	public function paymentReceiptV2PDF(){
		$this->load->helper('doc_access_helper');
		$id=$this->input->get('receipt_id');
		$type=$this->input->get('type');

		$form_data = [
			'id' => $id,
			'type' => $type,
		];
        $response=$this->Paymentinfo->getReceiptV2PdfDetails($this->api_token,$form_data);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch Payment data');
		}

		$pdf_data = [
			'header' => $response['data']['pay_header'],  
    		'invoices' => $response['data']['details'], 		
		];

		$this->load->library('Pdf');

		$customPaper = array(0, 0, 382.84, 380.84); 
		// $customPaper = array(0, 0, 227, 1000);
		$this->pdf->setPaper($customPaper);    
		$this->pdf->set_option('defaultFont', 'Helvetica');           
		$this->pdf->set_option('isRemoteEnabled', true); 

		$html = $this->load->view('components/pdf/payment_receipt_v2_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream('receipt.pdf', ['Attachment' => 0]);
		
		// Log print operation for receipt
		$branch_id = $this->session->userdata('branch_id');
		$company_id = $this->session->userdata('company_id');
		log_document_print('payment', $id, [
			'branch_id' => $branch_id,
			'company_id' => $company_id,
			'remarks' => 'Receipt V2 printed (Type: ' . $type . ')'
		]);
	}


	public function paymentReceiptV3PDF(){
		$this->load->helper('doc_access_helper');
		$id=$this->input->get('receipt_id');
		$type=$this->input->get('type');

		$form_data = [
			'id' => $id,
			'type' => $type,
		];
        $response=$this->Paymentinfo->getReceiptV2PdfDetails($this->api_token,$form_data);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch Payment data');
		}

		$pdf_data = [
			'header' => $response['data']['pay_header'],  
    		'invoices' => $response['data']['details'], 		
		];

			$this->load->library('Pdf');

			$customPaper = array(0, 0, 382.84, 380.84); 
			// $customPaper = array(0, 0, 396, 396); 
			$this->pdf->setPaper($customPaper);    
			$this->pdf->set_option('defaultFont', 'Helvetica');           
			$this->pdf->set_option('isRemoteEnabled', true); 

			$html = $this->load->view('components/pdf/payment_receipt_v3_pdf', $pdf_data, TRUE);

			$this->pdf->loadHtml($html);
			$this->pdf->render();
			$this->pdf->stream('receipt.pdf', ['Attachment' => 0]  
			);
			// Log print operation for receipt
			$branch_id = $this->session->userdata('branch_id');
			$company_id = $this->session->userdata('company_id');
			log_document_print('payment', $id, [
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'remarks' => 'Receipt V3 printed (Type: ' . $type . ')'
			]);
	}

	public function cancelPayment($id, $series) {
		$form_data = [
			'id' => $id,
			'series' => $series,
		];

		$response = $this->Paymentinfo->cancelPayment($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }
	
}