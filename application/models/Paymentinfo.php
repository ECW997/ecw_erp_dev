<?php
class Paymentinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_customer_v1', $form_data, $headers);
    }

    public function getOutstandingInvoicesByCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_outstanding_invoices_v1', $form_data, $headers);
    }
    public function insertORUpdatePayment($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'payment_v1', $form_data, $headers);
    }
    public function updatePayment($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'payment_v1', $form_data, $headers);
    }
    public function getAllocatedPayments($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_allocated_payments_v1', $form_data, $headers);
    }
    
}