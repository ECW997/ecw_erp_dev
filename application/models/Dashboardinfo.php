<?php
class Dashboardinfo extends CI_Model{


    public function GetTotalFoodCost(){
        $factoryid=$this->input->post('factoryid');
        $departmentid=$this->input->post('departmentid');

        $this->db->select('SUM(total) AS total_sum');
        $this->db->from('tbl_visitor_food_request_details');
        $this->db->join('tbl_visitor_food_request', 'tbl_visitor_food_request.idtbl_visitor_food_request = tbl_visitor_food_request_details.tbl_visitor_food_request_idtbl_visitor_food_request');
        $this->db->where('tbl_visitor_food_request.tbl_factory_idtbl_factory', $factoryid);
        $this->db->where('tbl_visitor_food_request.tbl_department_idtbl_department', $departmentid);
        $this->db->where('tbl_visitor_food_request.status', 1);
        $this->db->where('tbl_visitor_food_request.aprovel_status', 2);
        $this->db->where('tbl_visitor_food_request.hr_aprovel_status', 2);
        // $this->db->group_by('tbl_visitor_food_request_idtbl_visitor_food_request');

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->foodcost=$respond->row(0)->total_sum;
      
        echo json_encode($obj);
    }

    public function getTransportBudgetDetails(){
        $factoryid=$this->input->post('factory');
        $departmentid=$this->input->post('department');

        $this->db->select('tbl_department_budget_idtbl_department_budget');
        $this->db->from('tbl_transport_request');
        $this->db->where('status', 1);
        $this->db->where('aprovel_status', 2);
        $this->db->where('hr_aprovel_status', 2);
        $this->db->where('tbl_factory_idtbl_factory',  $factoryid);
        $this->db->where('tbl_department_idtbl_department', $departmentid);
        $this->db->group_by('tbl_factory_idtbl_factory');
        $this->db->group_by('tbl_department_idtbl_department');

        $respond1=$this->db->get();

        $budgetid=$respond1->row(0)->tbl_department_budget_idtbl_department_budget;

        $this->db->select('*');
        $this->db->from('tbl_department_budget');
        $this->db->where('status', 1);
        $this->db->where('aprovel_status', 1);
        $this->db->where('hr_aprovel_status', 1);
        $this->db->where('sattle_status', 1);
        $this->db->where('tbl_budget_type_idtbl_budget_type', 2);
        $this->db->where('idtbl_department_budget',  $budgetid);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->budget=$respond->row(0)->budget;
        $obj->usage=$respond->row(0)->used_amount;
        $obj->balance=$respond->row(0)->balance_amount;

        echo json_encode($obj);
    }
}