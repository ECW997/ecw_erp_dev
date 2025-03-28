<?php 
class CheckDublicateinfo extends CI_Model{
    public function is_duplicate($column_name, $tablename, $input_value) {
        $this->db->where($column_name, $input_value);
        $this->db->where('status', '1');
        $query = $this->db->get($tablename);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>