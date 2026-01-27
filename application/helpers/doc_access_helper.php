<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Document Access Helper
 * Functions to log document print/access operations
 */

/**
 * Log document print operation
 * 
 * @param string $doc_type Type of document: 'jobcard', 'invoice', 'payment', 'gatepass'
 * @param int $reference_id ID of the document (jobcard_id, invoice_id, payment_id, gatepass_id)
 * @param array $additional_data Additional data like branch_id, company_id, remarks
 * @return array Response array with status and message
 */
function log_document_print($doc_type, $reference_id, $additional_data = []) {
    $CI =& get_instance();
    
    // Load the DocAccess model
    $CI->load->model('DocAccessinfo');
    
    // Prepare form data
    $form_data = [
        'doc_access_type' => $doc_type,
        'reference_id' => $reference_id,
        'status' => 'active',
        'branch_id' => $additional_data['branch_id'] ?? null,
        'company_id' => $additional_data['company_id'] ?? null,
        'remarks' => $additional_data['remarks'] ?? null,
    ];
    
    // Get API token from session or auth
    $auth_info = auth_check();
    $api_token = $auth_info['api_token'] ?? null;
    
    if (!$api_token) {
        return [
            'status' => false,
            'message' => 'Authentication required',
            'code' => 401
        ];
    }
    
    // Call the model method to log the print
    $response = $CI->DocAccessinfo->logDocumentPrint($api_token, $form_data);
    
    return $response;
}

/**
 * Get document access logs
 * 
 * @param string $doc_type Type of document (optional)
 * @param int $reference_id Reference ID (optional)
 * @param array $filters Additional filters
 * @return array Response array with logs
 */
function get_document_access_logs($doc_type = null, $reference_id = null, $filters = []) {
    $CI =& get_instance();
    $CI->load->model('DocAccessinfo');
    
    $auth_info = auth_check();
    $api_token = $auth_info['api_token'] ?? null;
    
    if (!$api_token) {
        return [
            'status' => false,
            'message' => 'Authentication required',
            'code' => 401
        ];
    }
    
    $form_data = array_merge([
        'doc_access_type' => $doc_type,
        'reference_id' => $reference_id,
    ], $filters);
    
    $response = $CI->DocAccessinfo->getDocumentAccessLogs($api_token, $form_data);
    
    return $response;
}

