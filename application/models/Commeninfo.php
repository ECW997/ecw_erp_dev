<?php
class Commeninfo extends CI_Model{
    public function Getmenuprivilege(){
        $userID=$_SESSION['userid'];

        $menuprivilegearray=array();
    
        $sql="SELECT `idtbl_menu_list`, `menu` FROM `tbl_menu_list` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));
        
        foreach($respond->result() as $row){
            $menucheckID=$row->idtbl_menu_list;
            $menuname=str_replace(" ","_",$row->menu);
            
            $sqlprivilegecheck="SELECT `add`, `edit`, `statuschange`, `remove`,`approve`,`all_followup`, `access_status`, `tbl_menu_list_idtbl_menu_list` FROM `tbl_user_privilege` WHERE `tbl_user_idtbl_user`=? AND `tbl_menu_list_idtbl_menu_list`=? AND `status`=?";
            $respondprivilegecheck=$this->db->query($sqlprivilegecheck, array($userID, $menucheckID, 1));
            
            if($respondprivilegecheck->num_rows()>0){
                $objmenu=new stdClass();
                $objmenu->add=$respondprivilegecheck->row(0)->add;
                $objmenu->edit=$respondprivilegecheck->row(0)->edit;
                $objmenu->statuschange=$respondprivilegecheck->row(0)->statuschange;
                $objmenu->remove=$respondprivilegecheck->row(0)->remove;
                $objmenu->approve=$respondprivilegecheck->row(0)->approve;
                $objmenu->all_followup=$respondprivilegecheck->row(0)->all_followup;
                $objmenu->access_status=$respondprivilegecheck->row(0)->access_status;
                $objmenu->menuid=$respondprivilegecheck->row(0)->tbl_menu_list_idtbl_menu_list;
                array_push($menuprivilegearray, $objmenu);
            }
        }

        return $menuprivilegearray;
    }
}