<?php
class CashierTransactionLedgerinfo extends CI_Model{

    public function getTransactionLedgers($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'cashier_shift_transaction_ledger_v1', $form_data, $headers);
    }
}