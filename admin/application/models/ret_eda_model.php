<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ret_eda_model extends CI_Model
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
	
	function checkNonTagItemExist($data){
		$r = array("status" => FALSE);
        $sql = "SELECT id_nontag_item FROM ret_nontag_item WHERE product=".$data['id_product']." ".($data['id_design']!='' ? " and design=".$data['id_design']."" :'')." AND branch=".$data['id_branch']; 		
        
        $res = $this->db->query($sql);
		if($res->num_rows() > 0){
			$r = array("status" => TRUE, "id_nontag_item" => $res->row()->id_nontag_item); 
		}else{
			$r = array("status" => FALSE, "id_nontag_item" => ""); 
		} 
		return $r;
	}
	function updateNTData($data,$arith){ 
		$sql = "UPDATE ret_nontag_item SET no_of_piece=(no_of_piece".$arith." ".$data['no_of_piece']."),gross_wt=(gross_wt".$arith." ".$data['gross_wt']."),net_wt=(net_wt".$arith." ".$data['net_wt']."),updated_by=".$data['updated_by'].",updated_on='".$data['updated_on']."' WHERE id_nontag_item=".$data['id_nontag_item'];  
		$status = $this->db->query($sql);
		return $status;
	}
	
	public function get_eda_list()
	{
	}
	function ajax_getEdaList($id_branch)
    {
		$from_date 	= date("Y-m-d");
		$to_date 	= date("Y-m-d");
        $return_data=array();
		if($id_branch!='' && $id_branch>0)
        {
            $data=$this->getBranchDayClosingData($id_branch);
        }else{
            $id_branch = 1;
            $data=$this->getBranchDayClosingData($id_branch);
        }
		$uid=$this->session->userdata('uid');
		$sql = $this->db->query("SELECT estimation_id, esti_no,cus.mobile,
					date_format(estimation_datetime, '%d-%m-%Y %H:%i') as estimation_datetime, 
					firstname, pro.edasalesamt as total_cost, if(esti_for = 1,'Customer','Branch Transfer') as esti_for,IFNULL(bill.bill_id,old_bill.bill_id) as bill_id,
					IFNULL(bill.bill_no,old_bill.bill_no) as bill_no,
					IFNULL(pro.product_name,'') as product_name, est.estimate_final_amt, is_eda_approved
					
					FROM ret_estimation as est 
					LEFT JOIN customer as cus ON cus.id_customer = est.cus_id 
					
					LEFT JOIN (SELECT e.esti_id,b.bill_id,b.bill_no
					FROM ret_estimation_items e 
					LEFT JOIN ret_bill_details d ON d.esti_item_id=e.est_item_id
					LEFT JOIN ret_billing b ON b.bill_id=d.bill_id
					WHERE b.bill_status=1
					GROUP by b.bill_id) as bill ON bill.esti_id=est.estimation_id
					
					LEFT JOIN (SELECT sum(item_cost - item_total_tax) as edasalesamt, GROUP_CONCAT(concat(m.metal),'-',p.product_name)  as product_name,e.esti_id
					FROM ret_estimation_items e 
					LEFT JOIN ret_product_master p ON p.pro_id=e.product_id
					LEFT JOIN ret_category c ON c.id_ret_category=p.cat_id
					LEFT JOIN metal m ON m.id_metal=c.id_metal
					GROUP by e.esti_id) as pro ON pro.esti_id=est.estimation_id
					
					LEFT JOIN (SELECT s.est_id,b.bill_id,b.bill_no
					FROM ret_estimation_old_metal_sale_details s
					LEFT JOIN ret_bill_old_metal_sale_details old ON old.esti_old_metal_sale_id=s.old_metal_sale_id
					LEFT JOIN ret_billing b ON b.bill_id=old.bill_id
					WHERE b.bill_status=1
					GROUP by b.bill_id) as old_bill ON old_bill.est_id=est.estimation_id
					WHERE ".(($id_branch==0 || $id_branch=='') ? " date(estimation_datetime) = '".date("Y-m-d")."' " : " date(estimation_datetime) = '".$data['entry_date']."' ")." 
				
					".($id_branch!=0 && $id_branch!='' ? " and est.id_branch=".$id_branch."" :'')."
					AND is_eda = 1 AND (is_eda_approved = 0 || is_eda_approved = 1)
					ORDER BY est.estimation_id desc ");
           // echo $this->db->last_query();exit;
			$result= $sql->result_array();
			foreach($result as $item)
			{
				$return_data[]=$item;
			}
			return $return_data;
	}
	function getBranchDayClosingData($id_branch)
    {
	    $sql = $this->db->query("SELECT id_branch,is_day_closed,entry_date from ret_day_closing where id_branch=".$id_branch);  
	    return $sql->row_array();
	}
	
	function getEstDetails($estId)
	{
	    $sql = $this->db->query("SELECT est_item_id, itm.esti_id, itm.tag_id, est.id_branch, is_non_tag, product_id, design_id, id_sub_design, 
	                            ifnull(piece,0) as piece, ifnull(less_wt,0) as less_wt, ifnull(net_wt, 0) as net_wt, gross_wt, est.est_date  
	                            FROM ret_estimation_items itm 
	                            LEFT JOIN ret_estimation as est ON est.estimation_id = itm.esti_id  
	                            WHERE itm. esti_id = '".$estId."' AND est.is_eda_approved = 0");
	    $result = $sql->result_array();
	    
	   foreach($result as $rkey => $rval){
	        if(!empty($rval['tag_id'])){
	            $tag_query = $this->db->query("SELECT * FROM `ret_estimation_items` as estitm 
	                            LEFT JOIN ret_estimation as est ON est.estimation_id = estitm.esti_id
	                            LEFT JOIN ret_taging tag ON tag.tag_id = estitm.tag_id
	                            WHERE tag.tag_id = '".$rval['tag_id']."' and tag.tag_status = 10");
	           //echo $this->db->last_query();exit;
	           if($tag_query->num_rows() > 0){
	               //echo $this->db->last_query();exit;
	               unset($result[$rkey]);
	           }
	        }
	    }
	    
	    return $result; 
	}
	
}
?>