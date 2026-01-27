<?php
class Reportinfo extends CI_Model{

    public function dailySummary($api_token, $date) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_report_daily_summary_v1', ['date' => $date], $headers);
    }

    public function paymentSummary($api_token, $start_date, $end_date) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_report_payment_summary_v1', [
            'start_date' => $start_date,
            'end_date' => $end_date
        ], $headers);
    }

    public function discrepancy($api_token, $shift_id = null, $start_date = null, $end_date = null) {
        $headers = get_api_headers($api_token);
        $params = [];
        if ($shift_id) $params['shift_id'] = $shift_id;
        if ($start_date) $params['start_date'] = $start_date;
        if ($end_date) $params['end_date'] = $end_date;
        return call_api('GET', 'cashier_report_discrepancy_v1', $params, $headers);
    }

    public function cashOutSummary($api_token, $shift_id = null, $start_date = null, $end_date = null) {
        $headers = get_api_headers($api_token);
        $params = [];
        if ($shift_id) $params['shift_id'] = $shift_id;
        if ($start_date) $params['start_date'] = $start_date;
        if ($end_date) $params['end_date'] = $end_date;
        return call_api('GET', 'cashier_report_cash_out_summary_v1', $params, $headers);
    }

    public function outstandingIous($api_token, $shift_id = null) {
        $headers = get_api_headers($api_token);
        $params = $shift_id ? ['shift_id' => $shift_id] : [];
        return call_api('GET', 'cashier_report_outstanding_ious_v1', $params, $headers);
    }
}

