<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GatePass extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('GatePass/GatePassinfo');
        $this->load->model('Commeninfo');
        $this->load->model('CashierShiftinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    /**
     * Gate Pass List Page
     */
    public function index() {
        $check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		$data['check_cashier_shift'] = $check_cashier_shift_response;
        // Load locations for filters
        $locations_response = $this->GatePassinfo->getLocations($this->api_token, []);
        $data['locations'] = isset($locations_response['data']) ? $locations_response['data'] : [];
        
        // Load menu privileges
        $data['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        
        $this->load->view('GatePass/List', $data);
    }

    /**
     * Vehicle Tracking Dashboard
     */
    public function vehicleTracking() {
        $check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		$data['check_cashier_shift'] = $check_cashier_shift_response;
        // Load locations
        $locations_response = $this->GatePassinfo->getLocations($this->api_token, []);
        $data['locations'] = isset($locations_response['data']) ? $locations_response['data'] : [];
        
        // Load menu privileges
        $data['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        
        $this->load->view('GatePass/VehicleTracking', $data);
    }

    /**
     * Generate Gate Pass Form
     */
    public function generateForm() {
        $job_card_id = $this->input->get('job_card_id');
        $check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		$data['check_cashier_shift'] = $check_cashier_shift_response;
        
        // Load locations
        $locations_response = $this->GatePassinfo->getLocations($this->api_token, []);
        
        // Debug: Log the response
        log_message('debug', 'Gate Pass Locations Response: ' . print_r($locations_response, true));
        
        // Handle locations response - normalize to array format
        $data['locations'] = [];
        $data['default_location_id'] = null;
        
        if (isset($locations_response['status']) && ($locations_response['status'] == true || $locations_response['status'] === 'true' || $locations_response['status'] == 1)) {
            if (isset($locations_response['data'])) {
                $locations_data = $locations_response['data'];
                
                // Convert collection/objects to array
                if (is_array($locations_data)) {
                    // If it's already an array, check if items are objects
                    $normalized_locations = [];
                    foreach ($locations_data as $location) {
                        if (is_object($location)) {
                            // Convert object to array
                            $normalized_locations[] = [
                                'id' => isset($location->id) ? $location->id : (isset($location['id']) ? $location['id'] : null),
                                'location_name' => isset($location->location_name) ? $location->location_name : (isset($location['location_name']) ? $location['location_name'] : ''),
                                'location_code' => isset($location->location_code) ? $location->location_code : (isset($location['location_code']) ? $location['location_code'] : ''),
                                'is_default' => isset($location->is_default) ? $location->is_default : (isset($location['is_default']) ? $location['is_default'] : false),
                            ];
                        } else {
                            // Already an array
                            $normalized_locations[] = $location;
                        }
                    }
                    $data['locations'] = $normalized_locations;
                } elseif (is_object($locations_data) && method_exists($locations_data, 'toArray')) {
                    // Laravel collection - convert to array and normalize
                    $collection_array = $locations_data->toArray();
                    $normalized_locations = [];
                    foreach ($collection_array as $location) {
                        if (is_object($location)) {
                            $normalized_locations[] = [
                                'id' => isset($location->id) ? $location->id : (isset($location['id']) ? $location['id'] : null),
                                'location_name' => isset($location->location_name) ? $location->location_name : (isset($location['location_name']) ? $location['location_name'] : ''),
                                'location_code' => isset($location->location_code) ? $location->location_code : (isset($location['location_code']) ? $location['location_code'] : ''),
                                'is_default' => isset($location->is_default) ? $location->is_default : (isset($location['is_default']) ? $location['is_default'] : false),
                            ];
                        } else {
                            $normalized_locations[] = $location;
                        }
                    }
                    $data['locations'] = $normalized_locations;
                } else {
                    $data['locations'] = [];
                }
            }
            
            $data['default_location_id'] = isset($locations_response['default_location_id']) ? $locations_response['default_location_id'] : null;
        } else {
            // Log error for debugging
            $error_msg = 'Gate Pass: Failed to load locations';
            if (isset($locations_response['message'])) {
                $error_msg .= ' - ' . $locations_response['message'];
            } elseif (isset($locations_response['error'])) {
                $error_msg .= ' - ' . $locations_response['error'];
            }
            log_message('error', $error_msg);
            log_message('error', 'Gate Pass Locations Full Response: ' . print_r($locations_response, true));
            
            // Ensure locations array is initialized even if API call fails
            if (empty($data['locations']) || !is_array($data['locations'])) {
                $data['locations'] = [];
            }
        }
        
        // Ensure locations is always an array (safety check)
        if (empty($data['locations']) || !is_array($data['locations'])) {
            $data['locations'] = [];
        }
        
        // Debug: Log final data
        log_message('debug', 'Gate Pass Final Locations Data: ' . print_r($data['locations'], true));
        log_message('debug', 'Gate Pass Default Location ID: ' . $data['default_location_id']);
        
        // Load job card info if ID provided
        $data['job_card'] = null;
        if ($job_card_id) {
            // Load job card details
            $job_card_response = $this->GatePassinfo->getJobCardDetails($this->api_token, $job_card_id);
            $data['job_card'] = isset($job_card_response['data']) ? $job_card_response['data'] : null;
        }
        
        // Load available types if job card ID provided
        $data['available_types'] = [];
        if ($job_card_id) {
            $types_response = $this->GatePassinfo->getAvailableTypes($this->api_token, $job_card_id);
            $data['available_types'] = isset($types_response['data']) ? $types_response['data'] : [];
        }
        
        // Load transfer purposes from XML
        $data['transfer_purposes'] = $this->loadTransferPurposes();
        
        // Load menu privileges
        $data['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        
        $this->load->view('GatePass/Generate', $data);
    }

    /**
     * Load transfer purposes from XML file
     */
    private function loadTransferPurposes() {
        $xml_file = APPPATH . 'views/GatePass/gate_pass_transfer_purposes.xml';
        $purposes = [];
        
        if (file_exists($xml_file)) {
            $xml = simplexml_load_file($xml_file);
            if ($xml) {
                foreach ($xml->purpose as $purpose) {
                    $purposes[] = [
                        'id' => (string)$purpose['id'],
                        'name' => (string)$purpose
                    ];
                }
            }
        }
        
        // Fallback to default purposes if XML doesn't exist or fails to load
        if (empty($purposes)) {
            $purposes = [
                ['id' => '1', 'name' => 'Repair'],
                ['id' => '2', 'name' => 'Service'],
                ['id' => '3', 'name' => 'Inspection'],
                ['id' => '4', 'name' => 'Maintenance'],
                ['id' => '5', 'name' => 'Testing'],
                ['id' => '6', 'name' => 'Delivery'],
                ['id' => '7', 'name' => 'Pickup'],
                ['id' => '8', 'name' => 'Warranty Work'],
                ['id' => '9', 'name' => 'Customization'],
                ['id' => '10', 'name' => 'Other']
            ];
        }
        
        return $purposes;
    }

    /**
     * View Gate Pass Details
     */
    public function view($id) {
        $gate_pass_response = $this->GatePassinfo->getGatePassById($this->api_token, $id);
        $check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		$data['check_cashier_shift'] = $check_cashier_shift_response;
        
        // Convert array to object if needed
        if (isset($gate_pass_response['data'])) {
            if (is_array($gate_pass_response['data'])) {
                $data['gate_pass'] = json_decode(json_encode($gate_pass_response['data']));
            } else {
                $data['gate_pass'] = $gate_pass_response['data'];
            }
        } else {
            $data['gate_pass'] = null;
        }
        
        // Load menu privileges
        $data['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        
        $this->load->view('GatePass/View', $data);
    }

    // AJAX Methods
    public function getGatePasses() {
        // Get all request parameters (including DataTables server-side parameters)
        $form_data = [
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to'),
            'gate_pass_type' => $this->input->get('gate_pass_type'),
            'pass_category' => $this->input->get('pass_category'),
            'status' => $this->input->get('status'),
            'job_card_id' => $this->input->get('job_card_id'),
            'vehicle_tracking' => $this->input->get('vehicle_tracking'),
            'page' => $this->input->get('page'),
            'per_page' => $this->input->get('per_page'),
            // DataTables server-side parameters
            'draw' => $this->input->get('draw'),
            'start' => $this->input->get('start'),
            'length' => $this->input->get('length'),
            'order' => $this->input->get('order'),
            'search' => $this->input->get('search'),
        ];
        
        $response = $this->GatePassinfo->getGatePasses($this->api_token, $form_data);
        
        // For DataTables server-side, response should be: { draw, recordsTotal, recordsFiltered, data }
        // If response has status wrapper, extract the data part
        if (isset($response['status']) && isset($response['data']) && isset($response['data']['draw'])) {
            // Response is wrapped: { status: true, data: { draw, recordsTotal, ... } }
            // Extract the DataTables format from response.data
            $dataTablesResponse = $response['data'];
        } else {
            // Response is already in DataTables format or direct array
            $dataTablesResponse = $response;
        }
        
        // Output JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($dataTablesResponse));
    }

    public function generateIn() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateIn($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateIn1() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateIn1($this->api_token, $form_data);
        
        // Ensure we always return a valid JSON response
        if ($response === null || $response === false) {
            $response = [
                'status' => false,
                'message' => 'No response from API',
                'code' => 500
            ];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function generateIn2() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateIn2($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateOut() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateOut($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateOut1() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateOut1($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateOut2() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateOut2($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateOut3() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
        ];
        
        $response = $this->GatePassinfo->generateOut3($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateInternal() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'from_location_id' => $this->input->post('from_location_id'),
            'to_location_id' => $this->input->post('to_location_id'),
            'gate_pass_type' => $this->input->post('gate_pass_type'),
        ];
        
        $response = $this->GatePassinfo->generateInternal($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateExternalIn() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
            'external_party_name' => $this->input->post('external_party_name'),
            'external_party_type' => $this->input->post('external_party_type'),
            'external_party_contact' => $this->input->post('external_party_contact'),
            'external_party_address' => $this->input->post('external_party_address'),
            'external_transfer_purpose' => $this->input->post('external_transfer_purpose'),
            'expected_return_date' => $this->input->post('expected_return_date'),
            'company_driver_id' => $this->input->post('company_driver_id'),
            'company_driver_name' => $this->input->post('company_driver_name'),
            'company_driver_contact' => $this->input->post('company_driver_contact'),
            'company_worker_id' => $this->input->post('company_worker_id'),
            'company_worker_name' => $this->input->post('company_worker_name'),
            'company_worker_contact' => $this->input->post('company_worker_contact'),
            'remarks' => $this->input->post('remarks'),
        ];
        
        $response = $this->GatePassinfo->generateExternalIn($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function generateExternalOut() {
        $form_data = [
            'job_card_id' => $this->input->post('job_card_id'),
            'location_id' => $this->input->post('location_id'),
            'external_party_name' => $this->input->post('external_party_name'),
            'external_party_type' => $this->input->post('external_party_type'),
            'external_party_contact' => $this->input->post('external_party_contact'),
            'external_party_address' => $this->input->post('external_party_address'),
            'external_transfer_purpose' => $this->input->post('external_transfer_purpose'),
            'expected_return_date' => $this->input->post('expected_return_date'),
            'company_driver_id' => $this->input->post('company_driver_id'),
            'company_driver_name' => $this->input->post('company_driver_name'),
            'company_driver_contact' => $this->input->post('company_driver_contact'),
            'company_worker_id' => $this->input->post('company_worker_id'),
            'company_worker_name' => $this->input->post('company_worker_name'),
            'company_worker_contact' => $this->input->post('company_worker_contact'),
            'remarks' => $this->input->post('remarks'),
        ];
        
        $response = $this->GatePassinfo->generateExternalOut($this->api_token, $form_data);
        $this->sendJsonResponse($response);
    }

    public function printGatePass($id) {
        $response = $this->GatePassinfo->printGatePass($this->api_token, $id);
        echo json_encode($response);
    }

    /**
     * Check if gate pass can be printed (prevents duplicate prints)
     */
    public function checkPrintAllowed($id) {
        $response = $this->GatePassinfo->checkPrintAllowed($this->api_token, $id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Generate and display Gate Pass PDF
     */
    public function gatePassPDF() {
        $this->load->helper('doc_access_helper');
        $id = $this->input->get('gate_pass_id');
        
        if (!$id) {
            show_error('Gate pass ID is required', 400, 'Missing Parameter');
            return;
        }

        // Get gate pass details (will be refreshed after print with updated last_print_at)
        $response = $this->GatePassinfo->getGatePassById($this->api_token, $id);
        
        if (!$response['status'] || $response['code'] != 200) {
            show_error('Failed to fetch gate pass data: ' . ($response['message'] ?? 'Unknown error'), 400, 'Error');
            return;
        }

        $gate_pass = $response['data'];
        $pdf_data = [
            'gate_pass' => $gate_pass
        ];

        $branch_id = $this->session->userdata('branch_id');
        $company_id = $this->session->userdata('company_id');
        $job_card_id = $gate_pass['job_card_id'] ?? null;
        $gate_pass_number = $gate_pass['gate_pass_number'] ?? '';

        // Flag to indicate whether this print should be marked as DUPLICATE on the PDF
        // Default to false - will be updated from backend API response
        $is_duplicate = false;

        // Log print operation (before PDF generation to ensure it executes)
        $remarks = 'Gate pass printed (Number: ' . $gate_pass_number;
        if ($job_card_id) {
            $remarks .= ', Job Card ID: ' . $job_card_id;
        }
        $remarks .= ')';

        // Call backend API to log print
        $print_response = $this->GatePassinfo->printGatePass($this->api_token, $id);
        
        // If print logging fails, still generate PDF but log error
        if (!isset($print_response['status']) || !$print_response['status']) {
            $error_message = isset($print_response['message']) ? $print_response['message'] : 'Unknown error';
            log_message('error', 'Failed to log gate pass print: ' . $error_message);
        } else {
            // Use duplicate status from backend API response
            // Backend's checkDocAccessStatus() checks BEFORE logging:
            // - If no record exists → is_duplicate = false (first print, no duplicate tag)
            // - If active record exists → blocked (won't reach here)
            // - If last record != 'active' → is_duplicate = true (duplicate print, show duplicate tag)
            if (isset($print_response['is_duplicate'])) {
                $is_duplicate = (bool)$print_response['is_duplicate'];
            }
            
            // Refresh gate pass data to get updated last_print_at after print
            $refresh_response = $this->GatePassinfo->getGatePassById($this->api_token, $id);
            if ($refresh_response['status'] && $refresh_response['code'] == 200) {
                $gate_pass = $refresh_response['data'];
                $pdf_data['gate_pass'] = $gate_pass;
            }
        }
        
        // Pass duplicate flag to PDF (set AFTER getting backend response)
        $pdf_data['is_duplicate'] = $is_duplicate;
        
        // Get actual print time from gate pass (updated after print) or print response
        // Use last_print_at from gate pass (most accurate) or current time as fallback
        $printed_timestamp = null;
        if (isset($gate_pass['last_print_at']) && $gate_pass['last_print_at']) {
            $printed_timestamp = $gate_pass['last_print_at'];
        } elseif (isset($print_response['data']['last_print_at']) && $print_response['data']['last_print_at']) {
            $printed_timestamp = $print_response['data']['last_print_at'];
        } else {
            // Fallback to current time if not available
            $printed_timestamp = date('Y-m-d H:i:s');
        }
        
        // Pass print timestamp to PDF template
        $pdf_data['printed_timestamp'] = $printed_timestamp;
        
        // Determine which PDF template to use based on category and type
        // All PDFs are now in GatePass/pdf/ folder
        $pdf_view = 'GatePass/pdf/main_in'; // Default for MAIN IN
        
        $pass_category = $gate_pass['pass_category'] ?? 'MAIN';
        $gate_pass_type = $gate_pass['gate_pass_type'] ?? 'IN';
        
        if ($pass_category === 'MAIN') {
            if ($gate_pass_type === 'IN') {
                $pdf_view = 'GatePass/pdf/main_in';
            } elseif ($gate_pass_type === 'OUT') {
                // For OUT gate passes, check payment type (credit/non-credit)
                $jobCard = $gate_pass['job_card'] ?? [];
                $payment_type = $jobCard['payment_type'] ?? 1; // Default to 1 (Non-Credit)
                
                // Determine if key release should be included
                $include_key_release = isset($print_response['data']['include_key_release']) ? $print_response['data']['include_key_release'] : false;
                $pdf_data['include_key_release'] = $include_key_release;
                
                // Select template based on payment type
                // payment_type == 1: Non-Credit, payment_type != 1: Credit
                if ($payment_type == 1) {
                    // Non-Credit: Use main_out_noncredit template
                    $pdf_view = 'GatePass/pdf/main_out_noncredit';
                } else {
                    // Credit: Use main_out_credit template
                    $pdf_view = 'GatePass/pdf/main_out_credit';
                }
            }
        } elseif ($pass_category === 'INTERNAL') {
            if ($gate_pass_type === 'TEMP_IN') {
                $pdf_view = 'GatePass/pdf/internal_in';
            } elseif ($gate_pass_type === 'TEMP_OUT') {
                $pdf_view = 'GatePass/pdf/internal_out';
            }
        } elseif ($pass_category === 'EXTERNAL') {
            if ($gate_pass_type === 'TEMP_IN') {
                $pdf_view = 'GatePass/pdf/external_in';
            } elseif ($gate_pass_type === 'TEMP_OUT') {
                $pdf_view = 'GatePass/pdf/external_out';
            }
        }

        // Load PDF library
        $this->load->library('Pdf');
        // Receipt printer dimensions (80mm width, variable height)
        $customPaper = array(0, 0, 382.84, 380.84);
        $this->pdf->setPaper($customPaper);
        $this->pdf->set_option('defaultFont', 'Helvetica');
        $this->pdf->set_option('isRemoteEnabled', true);

        // Load and render PDF
        $html = $this->load->view($pdf_view, $pdf_data, TRUE);
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream('gate_pass_' . $gate_pass_number . '.pdf', ['Attachment' => 0]);
    }

    public function markExternalReturn($id) {
        $response = $this->GatePassinfo->markExternalReturn($this->api_token, $id);
        echo json_encode($response);
    }

    public function getJobCardStatus($jobCardId) {
        $response = $this->GatePassinfo->getJobCardStatus($this->api_token, $jobCardId);
        echo json_encode($response);
    }

    public function getAvailableTypes($jobCardId) {
        $response = $this->GatePassinfo->getAvailableTypes($this->api_token, $jobCardId);
        echo json_encode($response);
    }

    // Job Card Management
    public function getJobcardNumbers() {
        $form_data = [
            'term' => $this->input->get('term'),
            'page' => $this->input->get('page'),
        ];
        
        $response = $this->GatePassinfo->getJobcardNumbers($this->api_token, $form_data);
        echo json_encode($response);
    }

    public function getJobCardDetails() {
        $job_card_id = $this->input->post('job_card_id');
        
        if (!$job_card_id) {
            echo json_encode(['status' => false, 'message' => 'Job card ID is required']);
            return;
        }
        
        $response = $this->GatePassinfo->getJobCardDetails($this->api_token, $job_card_id);
        echo json_encode($response);
    }

    // Location Management
    public function getLocations() {
        $response = $this->GatePassinfo->getLocations($this->api_token, []);
        echo json_encode($response);
    }

    public function createLocation() {
        $form_data = [
            'location_name' => $this->input->post('location_name'),
            'location_code' => $this->input->post('location_code'),
            'description' => $this->input->post('description'),
        ];
        
        $response = $this->GatePassinfo->createLocation($this->api_token, $form_data);
        echo json_encode($response);
    }

    public function updateLocation($id) {
        $form_data = [
            'id' => $id,
            'location_name' => $this->input->post('location_name'),
            'location_code' => $this->input->post('location_code'),
            'description' => $this->input->post('description'),
            'is_active' => $this->input->post('is_active'),
        ];
        
        $response = $this->GatePassinfo->updateLocation($this->api_token, $form_data);
        echo json_encode($response);
    }

    public function deleteLocation($id) {
        $response = $this->GatePassinfo->deleteLocation($this->api_token, $id);
        echo json_encode($response);
    }
    
    /**
     * Helper method to send JSON response
     */
    protected function sendJsonResponse($response) {
        if (!isset($response)) {
            $response = [
                'status' => false,
                'message' => 'No response from API',
                'code' => 500
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Approve a draft gate pass
     */
    public function approveGatePass($id)
    {
        $response = $this->GatePassinfo->approveGatePass($this->api_token, $id);
        $this->sendJsonResponse($response);
    }

    /**
     * Mark latest active doc_access as ignore (allows reprint)
     */
    public function ignoreDocAccess($id)
    {
        $response = $this->GatePassinfo->ignoreDocAccess($this->api_token, $id);
        $this->sendJsonResponse($response);
    }

    /**
     * Create reprint approve request (with reason)
     */
    public function createReprintApproveRequest($id)
    {
        $reason = $this->input->post('reason') ?: $this->input->get_post('reason');
        $response = $this->GatePassinfo->createReprintApproveRequest($this->api_token, $id, $reason ?: '');
        $this->sendJsonResponse($response);
    }

    /**
     * List pending reprint requests (for finance manager)
     */
    public function listReprintRequests()
    {
        $response = $this->GatePassinfo->listReprintRequests($this->api_token);
        $this->sendJsonResponse($response);
    }

    /**
     * Approve a reprint request (finance manager)
     */
    public function approveReprintRequest($requestId)
    {
        $response = $this->GatePassinfo->approveReprintRequest($this->api_token, $requestId);
        $this->sendJsonResponse($response);
    }
}
