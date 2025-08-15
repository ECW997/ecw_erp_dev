<?php
class Invoiceinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    public function getJobcardNumbers($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_jobcard_number_v1', $form_data, $headers);
    }
    
   public function fetchJobCardDetails($api_token, $id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_card_v1', $id, $headers);
    }
    public function getDirectSalesItem($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_direct_sales_item_v1', $form_data, $headers);
    }
    public function getDirectSalesItemDetails($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'getDirectSalesItemDetails_v1', $id, $headers);
    }
    public function getCustomerDetails($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'customer_details_v1', $id, $headers);
    }
    public function insertInvoice($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'invoice_v1', $form_data, $headers);
    }
    public function getInvoiceById($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'invoice_v1', $form_data, $headers);
    }
    public function updateInvoice($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'invoice_v1', $form_data, $headers);
    }

    public function getInvoiceNo($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_invoice_number_v1', $form_data, $headers);
    }
    
    public function approveInvoice($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'approve_invoice_v1', $form_data, $headers);
    }

    public function cancelInvoice($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'cancel_invoice_v1', $form_data, $headers);
    }

    public function deleteInvoice($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'invoice_v1', $id, $headers);
    }

    public function getAdvancePayments($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_pay_allocation_receipt_v1', $form_data, $headers);
    }

    public function getInvoicePdfDetails($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_invoice_pdf_v1', $form_data, $headers);
    }

    public function insertNewItem($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'item_v1', $form_data, $headers);
    }

    public function searchCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'search_customer_v1', $form_data, $headers);
    }

}