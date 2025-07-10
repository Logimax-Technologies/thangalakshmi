<?php
    if( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Ret_section_transfer_model extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
        }

    // General Functions
    public function insertData($data,$table)
    {
    	$insert_flag = 0;
		$insert_flag = $this->db->insert($table, $data);
		return ($insert_flag == 1 ? $this->db->insert_id(): 0);
	}
	public function updateData($data, $id_field, $id_value, $table)
    {    
	    $edit_flag = 0;
	    $this->db->where($id_field, $id_value);
		$edit_flag = $this->db->update($table,$data);
		return ($edit_flag==1?$id_value:0);
	}	 
	public function deleteData($id_field,$id_value,$table)
    {
        $this->db->where($id_field, $id_value);
        $status= $this->db->delete($table); 
		return $status;
	}


    
    function getBranchDayClosingData($id_branch)
    {
        $sql = $this->db->query("SELECT id_branch,is_day_closed,entry_date from ret_day_closing where id_branch=".$id_branch); 
        return $sql->row_array();
    }

    function getSectionTags($data)
    {
        

        $dCData=$this->getBranchDayClosingData($data['id_branch']);
        
        if(empty($data['est_no'])){

        
        $sql = $this->db->query("SELECT t.tag_id,t.tag_code,t.id_section,t.product_id,t.current_branch as id_branch,
        
        sec.section_name,p.product_name,br.name as branch_name,

        t.piece,t.gross_wt,t.net_wt,t.old_tag_id

        FROM ret_taging t 

        LEFT join ret_section sec on sec.id_section = t.id_section

        LEFT JOIN ret_product_master p on p.pro_id = t.product_id

        LEFT JOIN branch br on br.id_branch = t.current_branch

        where t.tag_status=0 and t.id_section is not null
        
        ".($data['id_section']!='' && $data['id_section'] > 0 ? "and t.id_section=".$data['id_section']."" : "")."
        
        ".($data['id_branch']!='' && $data['id_branch'] > 0 ? "and t.current_branch=".($data['id_branch'])."":'')."
        
        ".($data['old_tag_id']!='' ? "and t.old_tag_id = '".($data['old_tag_id'])."'":'')."

        ".($data['tag_code']!=''  ? "and t.tag_code = '".($data['tag_code'])."'":'')."
        
        ".($data['est_no'] !='' && $data['est_no'] > 0 ? " AND est.esti_for = 2 AND date(est.estimation_datetime)='".$dCData['entry_date']."' AND est.esti_no=".$data['est_no']."":"")."");
        
        }else{
            $sql = $this->db->query("SELECT t.tag_id,t.tag_code,t.id_section,t.product_id,t.current_branch as id_branch,
        
        sec.section_name,p.product_name,br.name as branch_name,

        t.piece,t.gross_wt,t.net_wt,t.old_tag_id

        FROM ret_taging t 

        LEFT join ret_section sec on sec.id_section = t.id_section

        LEFT JOIN ret_product_master p on p.pro_id = t.product_id

        LEFT JOIN branch br on br.id_branch = t.current_branch

        LEFT JOIN ret_estimation_items estitms on estitms.tag_id = t.tag_id

        LEFT JOIN ret_estimation est on est.estimation_id = estitms.esti_id

        where t.tag_status=0 and t.id_section is not null
        
        ".($data['id_section']!='' && $data['id_section'] > 0 ? "and t.id_section=".$data['id_section']."" : "")."
        
        ".($data['id_branch']!='' && $data['id_branch'] > 0 ? "and t.current_branch=".($data['id_branch'])."":'')."
        
        ".($data['old_tag_id']!='' ? "and t.old_tag_id = '".($data['old_tag_id'])."'":'')."

        ".($data['tag_code']!=''  ? "and t.tag_code = '".($data['tag_code'])."'":'')."
        
        ".($data['est_no'] !='' && $data['est_no'] > 0 ? " AND est.esti_for = 2 AND date(est.estimation_datetime)='".$dCData['entry_date']."' AND est.esti_no=".$data['est_no']."":"")."");

        }
        //print_r($this->db->last_query());exit;

        return $sql->result_array();
    
    }
    
}

?>