<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_api_headers')) {
    function get_api_headers($api_token) {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json'
        ];
        if ($api_token) {
            $headers[] = 'Authorization: Bearer ' . $api_token;
        }
        return $headers;
    }
}

if (!function_exists('get_current_user_active_shift')) {
    /**
     * Get the current logged-in user's active shift
     * Returns shift data if active shift exists, null otherwise
     */
    function get_current_user_active_shift($api_token) {
        $CI =& get_instance();
        $CI->load->model('Cashier/Shiftinfo');
        
        $response = $CI->Shiftinfo->checkCashierShift($api_token, []);
        
        if (isset($response['status']) && $response['status'] === true && isset($response['shift'])) {
            return $response['shift'];
        }
        
        return null;
    }
}

if (!function_exists('require_active_shift')) {
    /**
     * Check if current user has an active shift
     * Returns shift data if exists, outputs error JSON and exits if not
     */
    function require_active_shift($api_token) {
        $shift = get_current_user_active_shift($api_token);
        
        if (!$shift) {
            echo json_encode([
                'status' => false,
                'message' => 'No active shift found. Please open a cashier shift first.',
                'code' => 403
            ]);
            exit;
        }
        
        return $shift;
    }
}


if (!function_exists('call_api')) {
    function call_api($method, $endpoint, $data = [], $headers = []) {
        $CI =& get_instance();
        $CI->config->load('api_config');  
        $base_url = $CI->config->item('api_base_url');
        $endpoints = $CI->config->item('api_endpoints');

        // Check if endpoint is a full URL (starts with http:// or https://)
        if (strpos($endpoint, 'http://') === 0 || strpos($endpoint, 'https://') === 0) {
            $url = $endpoint;
        } elseif (!isset($endpoints[$endpoint])) {
            // If not found in endpoints config, treat as direct path
            $url = $base_url . $endpoint;
        } else {
            $url = $base_url . $endpoints[$endpoint];
        }

        // Handle GET requests
        if (($method === 'GET')) {
            // Check if URL contains {id} or {shiftId} placeholder - replace it first
            if (is_array($data)) {
                if (isset($data['id']) && strpos($url, '{id}') !== false) {
                    $url = str_replace('{id}', $data['id'], $url);
                    unset($data['id']);
                }
                if (isset($data['shift_id']) && strpos($url, '{shiftId}') !== false) {
                    $url = str_replace('{shiftId}', $data['shift_id'], $url);
                    unset($data['shift_id']);
                }
                if (isset($data['shiftId']) && strpos($url, '{shiftId}') !== false) {
                    $url = str_replace('{shiftId}', $data['shiftId'], $url);
                    unset($data['shiftId']);
                }
            }
            
            // If data is array with query params, build query string
            if (is_array($data) && !empty($data) && !isset($data['id'])) {
                $queryString = http_build_query($data);
                if (!empty($queryString)) {
                    $url .= '?' . $queryString;
                }
            } 
            // If data is a string/number (ID), append to URL (if no placeholder was replaced)
            elseif (!empty($data) && !is_array($data)) {
                if (strpos($url, '{id}') === false && strpos($url, '{shiftId}') === false) {
                    $url .= '/' . $data;
                }
            }
            // If data is array with ID, append ID then query string (if no placeholder was replaced)
            elseif (is_array($data) && isset($data['id'])) {
                $id = $data['id'];
                unset($data['id']);
                if (strpos($url, '{id}') === false) {
                    $url .= '/' . $id;
                }
                if (!empty($data)) {
                    $queryString = http_build_query($data);
                    if (!empty($queryString)) {
                        $url .= '?' . $queryString;
                    }
                }
            }
        }
        
        // Handle PUT requests
        if (($method === 'PUT') && !empty($data)) {
            $id = $data['recordID'] ?? ($data['id'] ?? null);
            
            if ($id) {
                // Check if URL contains {id} placeholder - replace it
                if (strpos($url, '{id}') !== false) {
                    $url = str_replace('{id}', $id, $url);
                } else {
                    // Check for nested action routes (e.g., update_opening_balance, verify, etc.)
                    // These are handled in individual model methods that construct full URLs
                    $url .= '/' . $id;
                }
            }

            if(isset($data['status'])){
                $url .= '/'.$data['status'];
            }
        }

        // Handle DELETE requests
        if (($method === 'DELETE') && !empty($data)) {
            if (is_array($data) && isset($data['id'])) {
                $url .= '/' . $data['id'];
            } else {
                $url .= '/' . $data;
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } elseif ($method === 'GET') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }  

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return json_decode($response, true);
    }
}


if (!function_exists('auth_check')) {
    function auth_check() {
        $CI =& get_instance();
        $api_token = $CI->session->userdata('api_token');

        // if (!$api_token) {
        //     $CI->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
        //     redirect('Welcome/Logout');
        //     exit;
        // }

        $CI->load->model('Authinfo');
        $response = $CI->Authinfo->validateToken($api_token);

        // if (!$response || !$response['status']) {
        //     $CI->session->set_flashdata(['res' => '401', 'msg' => 'Session expired or invalid token']);
        //     redirect('Welcome/Logout');
        //     exit;
        // }
        return [
            'api_token' => $api_token,
            'user' => $response['user'] ?? null, 
        ];
    }
}

if (!function_exists('log_cashier_transaction')) {
    /**
     * Log cashier transaction activities for audit trail
     * 
     * @param string $module Module name (shift, cash_movement, adjustment, handover, iou_settlement, etc.)
     * @param string $action Action performed (create, update, approve, delete, verify, close, etc.)
     * @param mixed $entity_id ID of the entity being acted upon
     * @param array $data Data related to the transaction (new values)
     * @param array $old_data Old data (for updates, optional)
     * @param bool $success Whether the operation was successful
     * @param string $message Additional message/remarks
     * @param mixed $user_id User ID performing the action (optional, will use session if not provided)
     * @param mixed $shift_id Shift ID if applicable (optional)
     */
    function log_cashier_transaction($module, $action, $entity_id = null, $data = [], $old_data = [], $success = true, $message = '', $user_id = null, $shift_id = null) {
        $CI =& get_instance();
        
        // Get user information
        $auth_info = auth_check();
        $user = $auth_info['user'];
        $logged_user_id = $user_id ? $user_id : (isset($user['id']) ? $user['id'] : ($_SESSION['userid'] ?? 'unknown'));
        $logged_user_name = isset($user['name']) ? $user['name'] : ($_SESSION['name'] ?? 'Unknown User');
        $branch_id = isset($user['branch_id']) ? $user['branch_id'] : ($_SESSION['branch_id'] ?? null);
        
        // Determine entity type from module
        $entity_type_map = [
            'shift' => 'cashier_shift',
            'cash_movement' => 'cashier_cash_movement',
            'adjustment' => 'cashier_shift_adjustment',
            'handover' => 'cash_handover_log',
            'iou_settlement' => 'iou_settlement',
            'transaction_ledger' => 'cashier_transaction_ledger',
            'shift_summary' => 'cashier_shift_summary'
        ];
        $entity_type = $entity_type_map[$module] ?? $module;
        
        // Extract shift_id from data if not provided
        if (!$shift_id && isset($data['cashier_shift_id'])) {
            $shift_id = $data['cashier_shift_id'];
        } elseif (!$shift_id && isset($data['recordID']) && $module === 'shift') {
            $shift_id = $data['recordID'];
        }
        
        // Build log message
        $log_data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'module' => $module,
            'action' => $action,
            'entity_id' => $entity_id,
            'entity_type' => $entity_type,
            'user_id' => $logged_user_id,
            'user_name' => $logged_user_name,
            'branch_id' => $branch_id,
            'shift_id' => $shift_id,
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'old_data' => $old_data,
            'ip_address' => $CI->input->ip_address(),
            'user_agent' => $CI->input->user_agent()
        ];
        
        // Format log message
        $log_message = sprintf(
            "[CASHIER_TRANSACTION] Module: %s | Action: %s | Entity ID: %s | User: %s (ID: %s) | Success: %s | Message: %s",
            strtoupper($module),
            strtoupper($action),
            $entity_id ?? 'N/A',
            $logged_user_name,
            $logged_user_id,
            $success ? 'YES' : 'NO',
            $message ?: 'No message'
        );
        
        // Add data details if present
        if (!empty($data)) {
            $log_message .= " | Data: " . json_encode($data);
        }
        if (!empty($old_data)) {
            $log_message .= " | Old Data: " . json_encode($old_data);
        }
        
        // Log to CodeIgniter log file
        $log_level = $success ? 'info' : 'error';
        log_message($log_level, $log_message);
        
        // Also store detailed log in JSON format for easier parsing
        $detailed_log = sprintf(
            "[CASHIER_AUDIT] %s\n",
            json_encode($log_data, JSON_PRETTY_PRINT)
        );
        log_message('info', $detailed_log);
        
        // Save to database via API call (non-blocking - don't fail if API call fails)
        try {
            $api_token = $CI->session->userdata('api_token');
            if ($api_token) {
                $headers = get_api_headers($api_token);
                
                // Prepare data for API
                $api_log_data = [
                    'module' => $module,
                    'action' => $action,
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'user_id' => $logged_user_id,
                    'user_name' => $logged_user_name,
                    'branch_id' => $branch_id,
                    'shift_id' => $shift_id,
                    'success' => $success ? 1 : 0,
                    'message' => $message,
                    'data' => !empty($data) ? json_encode($data) : null,
                    'old_data' => !empty($old_data) ? json_encode($old_data) : null,
                    'ip_address' => $CI->input->ip_address(),
                    'user_agent' => $CI->input->user_agent()
                ];
                
                // Try to call API to save log
                // Use @ to suppress errors if endpoint doesn't exist yet
                $response = @call_api('POST', 'cashier_transaction_log_v1', $api_log_data, $headers);
            }
        } catch (\Exception $e) {
            // Silently fail - don't break the main operation if logging fails
            // Only log error if debugging is enabled
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                log_message('debug', 'Failed to save transaction log to database: ' . $e->getMessage());
            }
        }
        
        return true;
    }
}




