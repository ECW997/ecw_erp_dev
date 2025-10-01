<?php
class InvoiceOutstandingReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Report_info');
        $this->load->model('Commeninfo');
        $this->api_token = $this->session->userdata('api_token');
    }


        public function exportPDF() {
        $form_data = $this->input->post(); 
        $result = $this->Report_info->getAllOutstandingInvoices($this->api_token, $form_data);

        $pdf_data = [
            'report' => $result['data'] ?? []
        ];

        $this->load->library('Pdf');
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->set_option('defaultFont', 'Helvetica');
        $this->pdf->set_option('isRemoteEnabled', true);

        $html = $this->load->view('components/pdf/invoice_outstanding_report_pdf', $pdf_data, TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream('invoice_outstanding_report.pdf', ['Attachment' => 0]);
    }



    public function getCustomer(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Report_info->getCustomer($this->api_token,$form_data);
		echo json_encode($response);
	}

    public function index() {
    $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
    $result['report'] = [];
    if ($this->input->method() === 'post') {
        $form_data = $this->input->post();
        $result['report'] = $this->Report_info->getAllOutstandingInvoices($this->api_token, $form_data);
    }
    $this->load->view('invoice_outstanding_report', $result);
}

}