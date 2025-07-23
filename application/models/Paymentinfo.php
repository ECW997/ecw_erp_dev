<?php
class Paymentinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getPaymentById($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'payment_v1', $id, $headers);
    }
    public function getDraftReceiptNO($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_draft_receiptno_v1', $form_data, $headers);
    }
    public function getCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_customer_v1', $form_data, $headers);
    }

    public function getOutstandingInvoicesByCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_outstanding_invoices_v1', $form_data, $headers);
    }
    public function getJobCardsByCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_jobcards_by_customer_v1', $form_data, $headers);
    }
    public function createReceipt($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'payment_v1', $form_data, $headers);
    }
    public function getPayDetails($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_payment_details_v1', $form_data, $headers);
    }
    public function getPayAllocationDetails($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_payment_allocation_details_v1', $form_data, $headers);
    }
    public function insertORUpdatePayment($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'payment_v1', $form_data, $headers);
    }
    public function verifyPayment($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'payment_v1', $form_data, $headers);
    }

    public function deletePayment($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'delete_payment_v1', $form_data, $headers);
    }
    public function getReceiptPdfDetails($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_Receipt_pdf_v1', $form_data, $headers);
    }
    public function cancelPayment($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cancel_payment_v1', $form_data, $headers);
    }
}