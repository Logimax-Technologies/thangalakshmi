<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_report_model extends CI_Model
{ 
	
	function __construct()
    {
        parent::__construct();
    }
    
    function get_customerenquiry() 
    {
       $sql="select ce.id_enquiry,ce.ticket_no,ce.name,ce.mobile,ce.email,ce.date_add,ce.title,ce.comments,ce.status,ce.enq_from,
       IF(coin_type = 1, 'With Neck', IF(coin_type = 2, 'Without Neck', IFNULL(coin_type,'-'))) as coin_type, IFNULL(gram,'-') as gram, IFNULL(product_name,'-') as product_name FROM cust_enquiry ce
       LEFT JOIN cust_enquiry_product cep on cep.id_enquiry = ce.id_enquiry";
       //print_r($sql);exit;
       return $this->db->query($sql)->result_array();
    }
    
    function get_customerenquiry_by_date($from_date,$to_date,$status,$type) 
    {
       $sql= "select address,chit_acc_number,comments,date_add,date_of_birth,date_of_wed,email,enq_from,id_customer,ce.id_enquiry,mobile,name,profession,status,ticket_no,title,type ,(select enq_description from cust_enquiry_status ces where ces.id_enquiry=ce.id_enquiry order by ces.id_cusenq_status desc limit 1) as last_narration,
       IF(coin_type = 1, 'With Neck', IF(coin_type = 2, 'Without Neck', IFNULL(coin_type,'-'))) as coin_type, IFNULL(gram,'-') as gram, IFNULL(product_name,'-') as product_name FROM cust_enquiry ce
       LEFT JOIN cust_enquiry_product cep on cep.id_enquiry = ce.id_enquiry";
       if($from_date != ''){
           $sql=$sql." Where ".($status!=''?'status='.$status.' and' : '')." ".($type!=''?'type='.$type.' and' : '')." (date(date_add) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')";
       }
       elseif($status != '' && $type != ''){
           $sql=$sql." Where ".($status!=''?'status='.$status.' and' : '')." ".($type!=''?'type='.$type : '');
       } 
       else{
           $sql=$sql." ".($status!=''?'Where status='.$status : '')." ".($type!=''?'Where type='.$type : '');
       } 
       //print_r($sql);exit;
       return $this->db->query($sql)->result_array();
    }	
    
    function get_custEnqStatus($id) 
    {
       $sql="select concat(e.firstname,' ',e.lastname) as emp_name,`id_cusenq_status`, ces.`id_employee`, ifnull(internal_status,'-') as internal_status, `enq_status` as status, `enq_description`, date_format(ces.date_add,'%d-%m-%Y %H:%i:%s') as date_add
       FROM cust_enquiry_status ces
       LEFT JOIN employee e on e.id_employee = ces.id_employee
       Where id_enquiry=".$id;  
       return $this->db->query($sql)->result_array();
    }
    
    function update_enqStatus($data) 
    {
       $status = FALSE;
       $this->db->where("id_enquiry", $data['id_enquiry']);
       $parent = $this->db->update("cust_enquiry",array('status'=>$data['enq_status']));
       if($parent){
           $insdata = array(
                        'id_employee'       => $this->session->userdata('uid'),
                        'enq_status'        => $data['enq_status'],
                        'enq_description'   => $data['enq_description'],
                        'internal_status'   => $data['internal_status'],
                        'id_enquiry'        => $data['id_enquiry'],
                        'date_add'          => date('Y-m-d H:i:s')
                        );
           $status = $this->db->insert("cust_enquiry_status",$insdata);
       }
	   return	array('status'=>$status,'insertID'=>($status == TRUE ? $this->db->insert_id():''));
    }
    
    // MSG 91 report functions
    function getmsg91AuthKey(){
        $sql = $this->db->query("select msg91_authkey from chit_settings where id_chit_settings=1");
        return $sql->row('msg91_authkey');
    }
    
    function checkBalance($type){
        $sql = $this->db->query("select msg91_authkey from chit_settings where id_chit_settings=1");
        $authkey = $sql->row('msg91_authkey');
        if($authkey != NULL){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://control.msg91.com/api/balance.php?authkey=".$authkey."&type=".$type,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
              //return "cURL Error #:" . $err;
            } else {
              return $response;
            }
        }
    }
    
    // Msg 91 delivery report
    function getmsg91DelivryStat($from_date,$to_date){
        $sql = $this->db->query("SELECT `id_msg91_status`,request_id,date_format(`date`,'%d-%m-%Y %H:%i:%s') as date,`receiver`,`description` FROM `msg91_delivery_status` where (date(date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')");
        return $sql->result_array();
    }
    
    
    /*function get_gift_list($from_date,$to_date,$id_branch){
        
        $branch_settings=$this->session->userdata('branch_settings');
        $branchWiseLogin=$this->session->userdata('branchWiseLogin');
        $uid=$this->session->userdata('uid');
        
	    $sql = "SELECT g.id_gift_issued as id,CONCAT(c.firstname,' ',IFNULL(c.lastname,'')) as cus_name,c.mobile,CONCAT(s.code,'-',RIGHT(YEAR(start_date),2),'-',sa.scheme_acc_number) as account_no,
	            date(sa.start_date) as joined_date,date(g.date_issued) as issued_date,g.gift_desc,SUM(p.payment_amount) as payment_amount,COUNT(p.id_payment) as paid_installment,IF(g.status = 1,'Issued',IF(g.status = 2,'Deducted','-')) as status
                FROM `gift_issued` g 
                LEFT JOIN scheme_account sa on (sa.id_scheme_account = g.id_scheme_account)
                LEFT JOIN customer c ON (c.id_customer = sa.id_customer)
                LEFT JOIN scheme s  ON (s.id_scheme = sa.id_scheme)
                LEFT JOIN payment p ON (p.id_scheme_account = sa.id_scheme_account AND p.payment_status = 1)
                LEFT JOIN branch b ON (b.id_branch = sa.id_branch)
                Where (date(sa.start_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')
				".($uid!=1 ? ($branchWiseLogin==1 ? ($id_branch!='' ? " and (sa.id_branch=".$id_branch." or b.show_to_all=1)":''):''):'')." 
        		".($id_branch!='' && $id_branch>0 ? " and sa.id_branch=".$id_branch."" :'')."
                group by g.id_scheme_account";
      // echo $sql;exit;
     
        $result = $this->db->query($sql)->result_array();
        
        return $result;
    }*/
    
     function get_gift_list($from_date,$to_date,$id_branch,$id_metal,$id_scheme,$id_gift)
     {
        
        $branch_settings=$this->session->userdata('branch_settings');
        $branchWiseLogin=$this->session->userdata('branchWiseLogin');
        $uid=$this->session->userdata('uid');
        $id_employee=$this->input->post('id_employee');
        $sql = "SELECT s.scheme_name,
        sa.id_scheme_account as sc_ac_id,
        g.id_gift_issued as id,
        CONCAT(c.firstname,' ',IFNULL(c.lastname,'')) as cus_name,
        c.mobile,
        CONCAT(s.code,'-',RIGHT(YEAR(start_date),2),'-',sa.scheme_acc_number) as account_no,
        date_format(sa.start_date,'%d-%m-%Y') as joined_date,
        date_format(g.date_issued,'%d-%m-%Y') as issued_date,
      
      
        g.gift_desc,
        ifnull(g.quantity,0) as quantity,
        ifnull(gt.net_weight,0) as weightforoneqt,
        ifnull(g.quantity,0)*ifnull(gt.net_weight,0) as tot_weight,
        mt.metal as metal_name,
        mt.id_metal,
        (select count(pay.id_payment)   from payment pay left join scheme_account sca on pay.id_scheme_account=sca.id_scheme_account where sca.id_scheme_account=sa.id_scheme_account)as paid_installment ,
        (select IFNULL(sum(pay.payment_amount),'0')   from payment pay left join scheme_account sca on pay.id_scheme_account=sca.id_scheme_account where sca.id_scheme_account=sa.id_scheme_account)as payment_amount ,
        IFNULL((select id_employee from payment
         where id_scheme_account=sa.id_scheme_account
         
          group by id_scheme_account ORDER BY date_payment ASC),0) as pay_id_employee,
        IFNULL((select concat(e.firstname,' ',IFNULL(e.lastname,'')) from employee e 
        left join payment pp on pp.id_employee=e.id_employee 
        where pp.id_scheme_account=sa.id_scheme_account
       
         group by pp.id_scheme_account order by pp.date_payment asc),'-') as pay_emp_name,
         concat(emp.firstname,' ',IFNULL(emp.lastname,'')) as gift_id_emp_name,
         g.id_employee as gift_id_employee,
        IF(g.status = 1,'Issued',IF(g.status = 2,'Deducted','-')) as status
        FROM `gift_issued` g
        left JOIN scheme_account sa on (sa.id_scheme_account = g.id_scheme_account)
        left join payment payment on payment.id_scheme_account=g.id_scheme_account
        LEFT JOIN customer c ON (c.id_customer = sa.id_customer)
        LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme)
        left join employee emp on emp.id_employee=g.id_employee
        LEFT JOIN branch b ON (b.id_branch = sa.id_branch) 
        left join gifts gt on gt.id_gift=g.id_gift
        left join metal mt on mt.id_metal=gt.metal
        Where (date(g.date_issued) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')
        ".($uid!=1 ? ($branchWiseLogin==1 ? ($id_branch!='' ? " and (sa.id_branch=".$id_branch." or b.show_to_all=1)":''):''):'')." 
        ".($id_branch!='' && $id_branch>0 ? " and sa.id_branch=".$id_branch."" :'')."
        ".($id_metal!='' && $id_metal>0 ? " and gt.metal=".$id_metal."" :'')."
        ".($id_employee!='' && $id_employee>0 ? " and g.id_employee=".$id_employee."" :'')."
        ".($id_scheme!='' && $id_scheme>0 ? " and sa.id_scheme=".$id_scheme."" :'')."
        ".($id_gift!='' && $id_gift>0 ? " and g.id_gift=".$id_gift."" :'')."
        and g.type=1 and payment.payment_status=1
        group by g.id_gift_issued				
        ORDER BY sa.start_date asc,s.code asc";
        //echo $sql;exit;
     
        $result = $this->db->query($sql)->result_array();
		
		foreach($result as $r)
        {
            $return_data[$r['scheme_name']][]=$r;
        }
		
		//print_r($return_data);exit;
        
        return $return_data;
    }
	
	function gift_summary($from_date,$to_date,$id_branch,$id_metal,$id_scheme,$id_gift)

	{

	    

				$branch_settings=$this->session->userdata('branch_settings');

				$branchWiseLogin=$this->session->userdata('branchWiseLogin');

				$uid=$this->session->userdata('uid');

				

				$sql = "SELECT g.gift_name,s.scheme_name,COUNT(gi.id_gift) as issued_count, (COUNT(gi.id_gift)* g.net_weight) as total_weight

						FROM `gift_issued` gi 

						LEFT JOIN scheme_account sa on (sa.id_scheme_account = gi.id_scheme_account) 

						LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme) 

						LEFT JOIN gifts g ON (g.id_gift = gi.id_gift)

						LEFT JOIN branch b ON (b.id_branch = sa.id_branch)

					

						Where (date(gi.date_issued) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')

						".($uid!=1 ? ($branchWiseLogin==1 ? ($id_branch!='' ? " and (sa.id_branch=".$id_branch." or b.show_to_all=1)":''):''):'')." 

						".($id_branch!='' && $id_branch>0 ? " and sa.id_branch=".$id_branch."" :'')."

						".($id_metal!='' && $id_metal>0 ? " and g.metal=".$id_metal."" :'')."

						".($id_scheme!='' && $id_scheme>0 ? " and sa.id_scheme=".$id_scheme."" :'')."

						".($id_gift!='' && $id_gift>0 ? " and g.id_gift=".$id_gift."" :'')."

						and gi.status = 1 and g.gift_name is not null

						group by g.gift_name,s.scheme_name

						ORDER BY g.gift_name asc";

						//print_r($sql);exit;

				$result = $this->db->query($sql)->result_array();

				

				foreach($result as $r)

				{

					$return_data[$r['scheme_name']][]=$r;

				}

				

				

				

				return $return_data;

				

			   }
    
    
	
}
?>