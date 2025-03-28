<?php
class Alertinfo extends CI_Model{
    public function get_alert_data()
    {
        $company_branch_id = $_SESSION['branch_id'];
        $sale_person_id = $_SESSION['sale_person_id'];

        $sql = "SELECT `inquiry_number`
                FROM `tbl_customer_inquiry` 
                WHERE `tbl_customer_inquiry`.`status` = 1 
                AND `tbl_customer_inquiry`.`second_followup_reminder_status` = '1'
                AND `tbl_customer_inquiry`.`salesperson_id` = $sale_person_id
                AND `tbl_customer_inquiry`.`company_branch_id` = ?";

        $query = $this->db->query($sql, array($company_branch_id));
        $result = $query->result_array();

        $response = [
            'refollowupcount' => count($result),
            'inquiry_numbers' => array_column($result, 'inquiry_number')
        ];
        echo json_encode($response);
    }

    public function get_today_active_second_alert_data()
    {
        $company_branch_id = $_SESSION['branch_id'];
        $sale_person_id = $_SESSION['sale_person_id'];
        $currentDate = date('Y-m-d H:i:s');

        $sql = "
            SELECT inquiry_number
            FROM tbl_customer_inquiry
            WHERE status = '1' 
            AND first_follow_up = '1'
            AND second_follow_up = '0'
            AND third_follow_up = '0'
            AND cancel_status = '0'
            AND salesperson_id = ?
            AND company_branch_id = ?
            AND DATE(first_followup_datetime) = DATE_SUB(CURDATE(), INTERVAL 3 DAY)
        ";

        $query = $this->db->query($sql, array($sale_person_id, $company_branch_id));
        $result = $query->result_array();

        $response = [
            'second_active_followupcount' => count($result),
            'second_active_inquiry_numbers' => array_column($result, 'inquiry_number')
        ];
        echo json_encode($response);
    }

    public function get_today_active_first_alert_data()
    {
        $company_branch_id = $_SESSION['branch_id'];
        $sale_person_id = $_SESSION['sale_person_id'];
        $currentDate = date('Y-m-d H:i:s');

        $sql = "
            SELECT inquiry_number
            FROM tbl_customer_inquiry
            WHERE status = '1' 
            AND first_follow_up = '0'
            AND second_follow_up = '0'
            AND third_follow_up = '0'
            AND cancel_status = '0'
            AND salesperson_id = ?
            AND company_branch_id = ?
        ";

        $query = $this->db->query($sql, array($sale_person_id, $company_branch_id));
        $result = $query->result_array();

        $response = [
            'first_active_followupcount' => count($result),
            'first_active_inquiry_numbers' => array_column($result, 'inquiry_number')
        ];
        echo json_encode($response);
    }
}