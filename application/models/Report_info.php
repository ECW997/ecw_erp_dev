<?php
class Report_info extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
    }

    // public function getReport($api_token, $endpoint, $form_data = [], $method = 'GET') {
    //     $headers = get_api_headers($api_token);
    //     return call_api($method, $endpoint, $form_data, $headers);
    // }

    public function getCustomer($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_customer_v1', $form_data, $headers);
    }

    // public function getAllOutstandingInvoices($api_token, $form_data) {
    //     return $this->getReport($api_token, 'get_all_outstanding_invoices_v1', $form_data, 'GET');
    // }

    public function getAllOutstandingInvoices($api_token, $form_data) {
        $filters = [];
        if (!empty($form_data['date_from'])) {
            $filters['date_from'] = $form_data['date_from'];
        }
        if (!empty($form_data['date_to'])) {
            $filters['date_to'] = $form_data['date_to'];
        }
        if (!empty($form_data['customer_id'])) {
            $filters['customer_id'] = $form_data['customer_id'];
        }
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_all_outstanding_invoices_v1', $filters, $headers);
    }



    public function getDailySalesSummary($api_token, $form_data) {
        $filters = [];
        if (!empty($form_data['date_from'])) {
            $filters['date_from'] = $form_data['date_from'];
        }
        if (!empty($form_data['date_to'])) {
            $filters['date_to'] = $form_data['date_to'];
        }
        $headers = get_api_headers($api_token);
        return call_api('POST', 'invoiceAmountSummary_v1', $filters, $headers);
    }



      public function getInvoiceDetailSummary($api_token, $form_data) {
        $filters = [];
        if (!empty($form_data['date_from'])) {
            $filters['date_from'] = $form_data['date_from'];
        }
        if (!empty($form_data['date_to'])) {
            $filters['date_to'] = $form_data['date_to'];
        }
        $headers = get_api_headers($api_token);
        return call_api('POST', 'invoiceDetailsSummary_v1', $filters, $headers);
    }
}

