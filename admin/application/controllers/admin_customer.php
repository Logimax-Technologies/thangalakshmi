<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_customer extends CI_Controller
{
	
	const CUS_MODEL	="customer_model";
	const ADM_MODEL	="chitadmin_model";
	const SET_MODEL = 'admin_settings_model';
	const WALL_MODEL = 'wallet_model';
	const LOG_MODEL = "log_model";
	const SMS_MODEL = "admin_usersms_model";
	const MAIL_MODEL = "email_model";
	const CUS_VIEW ="master/customer/";
	const CUS_IMG_PATH = 'assets/img/customer/';
	const DEF_CUS_IMG_PATH = 'assets/img/default.png/';
	const DEF_IMG_PATH = 'assets/img/no_image.png/';
	const CUS_IMG= 'customer.jpg';
	const PAN_IMG = 'pan.jpg';
	const RATION_IMG = 'rationcard.jpg';
	const VOTERID_IMG = 'voterid.jpg';
	
	function __construct()
	{
		parent::__construct();
		ini_set('date.timezone', 'Asia/Calcutta');
		$this->load->model(self::CUS_MODEL);
		$this->load->model(self::ADM_MODEL);
		$this->load->model(self::SET_MODEL);
		$this->load->model(self::WALL_MODEL);
		$this->load->model(self::LOG_MODEL);
		$this->load->model(self::MAIL_MODEL);
		$this->load->model(self::SMS_MODEL);
		$this->load->model("sms_model");
		if(!$this->session->userdata('is_logged'))
		{
			redirect('admin/login');
		}
			
		$access = $this->admin_settings_model->get_access('customer');
		if ($access['view']==0)
		 {
			redirect('admin/dashboard');
		}
	}
		
	public function index()
	{	
		$this->cus_list();
	}
	
	public function check_multiple_chits()
	{
		$model_name=self::ADM_MODEL;
		$allowed = $this->$model_name->allow_multiple_chit();
		return $allowed['allow_join_multiple'];	
	}
	
    public function ajax_get_customers()
	{
		$model_name=self::CUS_MODEL;
		$multiple_chit = $this->check_multiple_chits();
       
			if($multiple_chit == 1)
			{
				$cus_data=$this->$model_name->ajax_get_all_customers();
			}	
			else
			{
				$cus_data=$this->$model_name->ajax_get_unallocated_customers();
			}
	       $customers =$cus_data;
		echo json_encode($customers);
		//echo "<pre>" print_r($customers);exit; echo "<pre>";;
	}
	
//	public function ajax_get_customer($cus_name,$id)
	public function ajax_get_customer($id)
	{
		$model_name=self::CUS_MODEL;	
		
		$customer=$this->$model_name->get_customer($id);
		
		echo json_encode($customer);
	}
	
	public function cus_list($msg="")
	{
		$model_name=self::CUS_MODEL;
		
		$data['message']=$msg;
				
/*$cus_data=$this->$model_name->get_all_customers();
	
		
		if($cus_data)
		{
			$data['customers']=$cus_data;
		}*/
			
		$data['main_content'] = self::CUS_VIEW.'list';
		 $data['entry_date']=$this->admin_settings_model->settingsDB('get','','');
//	 echo"<pre>";	print_r($data);exit;
	    $this->load->view('layout/template', $data);
	}
	
	public function ajax_customers()
	{
		$model_name=self::CUS_MODEL;
		$set_model=self::SET_MODEL;
		$data['access'] = $this->$set_model->get_access('customer');
		$range['from_date']  = $this->input->post('from_date');
		$range['to_date']  = $this->input->post('to_date');
		$range['id_branch']  = $this->input->post('id_branch');
		$range['id_village']  = $this->input->post('id_village');
		if($range['from_date']!=''&&$range['to_date']!='')
		{
		   
			$data['customer']=$this->$model_name->get_customers_by_date($range['from_date'],$range['to_date'],$range['id_branch']);
		}
		else
		{
			$data['customer']=$this->$model_name->get_all_customers('',$range['id_branch'],$range['id_village']); 
		}
		
		echo json_encode($data);
	}
	function birthday($birthday) {
	    $age = date_create($birthday)->diff(date_create('today'))->y;
	    return $age;
	}
	
	//Open form
	public function cus_form($type="",$id="")
	{
		$model=self::CUS_MODEL;
		switch($type)
		{
			case 'Add':
	
/*-- Coded by ARVK --*/				
						$set_model=self::SET_MODEL;
						$limit= $this->$set_model->limitDB('get','1');
						$count= $this->$model->customer_count();
						//print_r($count);exit;
						
						if($limit['limit_cust']==1)
						{
							
							if($count < $limit['cust_max_count'])
							{
							
								$data['customer']= $this->$model->empty_record();
								$data['customer']['cus_img_path']	= self::CUS_IMG_PATH."../default.png";
								$data['customer']['pan_path']		= self::CUS_IMG_PATH."../no_image.png";
								$data['customer']['voterid_path']	= self::CUS_IMG_PATH."../no_image.png";
								$data['customer']['rationcard_path'] = self::CUS_IMG_PATH."../no_image.png";
								$data['customer'] ['cus_img' ]       =NULL;
								$data['customer'] ['age' ]     		=NULL;
								$data['main_content'] = self::CUS_VIEW."form" ;
								$this->load->view('layout/template', $data);
								
							}else
							{
													 	
						 	$this->session->set_flashdata('chit_alert',array('message'=>'Customer creation limit exceeded, Kindly contact Super Admin...','class'=>'danger','title'=>'Customer creation'));
						 	redirect('customer');
							}
							
						}else
						{
								$data['customer']= $this->$model->empty_record();
								$data['customer']['cus_img_path']	= self::CUS_IMG_PATH."../default.png";
								$data['customer']['pan_path']		= self::CUS_IMG_PATH."../no_image.png";
								$data['customer']['voterid_path']	= self::CUS_IMG_PATH."../no_image.png";
								$data['customer']['rationcard_path'] = self::CUS_IMG_PATH."../no_image.png";
								$data['customer'] ['cus_img' ]       =NULL;
								$data['customer'] ['age' ]     		=NULL;
								$data['main_content'] = self::CUS_VIEW."form" ;
								$this->load->view('layout/template', $data);
						}
						
/*--/ Coded by ARVK --*/
		
				break;
			case 'Edit':
				   $cus= $this->$model->get_cust($id);
				// echo "<pre>";print_r($cus);echo "</pre>";exit; 
				   $age=$this->birthday($cus['date_of_birth']);
				   
				   $data['customer']= array(
					   			'id_customer'		=>  (isset($cus['id_customer'])?$cus['id_customer']: NULL), 
					   			'firstname'			=>  (isset($cus['firstname'])?$cus['firstname']: NULL), 
				       			'lastname' 			=>  (isset($cus['lastname'])?$cus['lastname']: NULL), 
								'id_branch'		=>  (isset($cus['id_branch'])?$cus['id_branch']: NULL), 
								'religion'		=>  (isset($cus['religion'])?$cus['religion']: NULL), 
                                'post_office'		=>  (isset($cus['post_office'])?$cus['post_office']: NULL),
                                'taluk'		=>  (isset($cus['taluk'])?$cus['taluk']: NULL),
                                'id_village'		=>  (isset($cus['id_village'])?$cus['id_village']: NULL),
								'date_of_birth'		=>	(isset($cus['date_of_birth']) && $cus['date_of_birth'] != '' ? date('d/m/Y',strtotime(str_replace("/","-",$cus['date_of_birth']))): NULL), 	
								'date_of_wed'		=>	(isset($cus['date_of_wed']) && $cus['date_of_wed'] != '' ? date('d/m/Y',strtotime(str_replace("/","-",$cus['date_of_wed']))): NULL), 
								'gst_number'				=>	(isset($cus['gst_number'])?$cus['gst_number']: NULL), 
								'email'				=>	(isset($cus['email'])?$cus['email']: NULL), 
								'gender'			=>	(isset($cus['gender'])?$cus['gender']: NULL),
								'cus_type'			=>	$cus['cus_type'],
								'mobile'			=>	(isset($cus['mobile'])?$cus['mobile']: NULL), 
								'phone'				=>	(isset($cus['phone'])?$cus['phone']: NULL),
								'title'				=>	(isset($cus['title'])?$cus['title']: NULL),
								'age'				=>	(isset($age)?$age: NULL),
								'nominee_name'			=>	(isset($cus['nominee_name'])?$cus['nominee_name']: NULL),
				       			
				       			'nominee_relationship'		=>	(isset($cus['nominee_relationship'])?$cus['nominee_relationship']: NULL),
				       			'nominee_mobile'	=>	(isset($cus['nominee_mobile'])?$cus['nominee_mobile']: NULL), 
								'pan'				=>	(isset($cus['pan'])?$cus['pan']: NULL), 	
								'pan_proof'			=>	(isset($cus['pan_proof']) && $cus['pan_proof'] != NULL ? $cus['pan_proof']: self::DEF_IMG_PATH), 
								'voterid'			=>	(isset($cus['voterid'])?$cus['voterid']: NULL), 
								'voterid_proof'		=>	(isset($cus['voterid_proof']) && $cus['voterid_proof'] != NULL ? $cus['voterid_proof']: self::DEF_IMG_PATH), 
								'rationcard'		=>	(isset($cus['rationcard'])?$cus['rationcard']: NULL), 
								'rationcard_proof'	=>	(isset($cus['rationcard_proof']) && $cus['rationcard_proof'] != NULL ?$cus['rationcard_proof']: self::DEF_IMG_PATH), 	
								'comments'			=>	(isset($cus['comments'])?$cus['comments']: NULL), 	
								'username'			=>	(isset($cus['username'])?$cus['username']: NULL), 
								'passwd'			=>	(isset($cus['passwd'])?$cus['passwd']: NULL), 
								'active'			=>	(isset($cus['active'])?$cus['active']: 0),
								'is_cus_synced'		=>  (isset($cus['is_cus_synced'])?$cus['is_cus_synced']: 0),
								'id_country'		=>	(isset($cus['id_country'])?$cus['id_country']:0),
							    'id_state' 			=>	(isset($cus['id_state'])?$cus['id_state']:0),
							'id_city'			=>	(isset($cus['id_city'])?$cus['id_city']:0),			
							'company_name'			=>	(isset($cus['company_name'])?$cus['company_name']:NULL),
							'address1'			=>	(isset($cus['address1'])?$cus['address1']:NULL),
							'address2'			=>	(isset($cus['address2'])?$cus['address2']:NULL),
							'address3'			=>	(isset($cus['address3'])?$cus['address3']:NULL),
							'pincode'			=>	(isset($cus['pincode'])?$cus['pincode']:NULL),
							'cus_img'           =>  (isset($cus['cus_img']) && $cus['cus_img'] != NULL ? $cus['cus_img']: self::DEF_CUS_IMG_PATH),
							'id_profession'	    	=>  (isset($cus['id_profession'])?$cus['id_profession']: NULL),
							'aadharid'	    	=>  (isset($cus['aadharid'])?$cus['aadharid']: NULL)
					);
				   
				   
			         
			   
				   if(is_dir(self::CUS_IMG_PATH.$id))
				   {
				   	  
						$cus_img=self::CUS_IMG_PATH.$id."/".self:: CUS_IMG;
				   	    $pan_img=self::CUS_IMG_PATH.$id."/".self:: PAN_IMG;
				   	    $voter_img=self::CUS_IMG_PATH.$id."/".self:: VOTERID_IMG;
				   	    $ration_img=self::CUS_IMG_PATH.$id."/".self:: RATION_IMG;
				   	    if(file_exists($cus_img))
				   	    {
							$data['customer']['cus_img_path']		= $cus_img;
						}
				   		  
				   		 if(file_exists($pan_img))
				   	    {
							$data['customer']['pan_path']		= $pan_img;
						}
				   		  if(file_exists($voter_img))
				   	    {
							$data['customer']['voterid_path']		= $voter_img;
						}
				   		  if(file_exists($ration_img))
				   	    {
							$data['customer']['rationcard_path']		= $ration_img;
						}
				   		 
				   }
				   
				   
			       $data['main_content'] = self::CUS_VIEW."form" ;
				   $this->load->view('layout/template', $data);
				break;
			
		}
	}
	
	function sync_existing_data($mobile,$id_customer,$id_branch)
	{   
	   $data['id_customer'] = $id_customer;  
	   $data['id_branch'] = $id_branch;  
	   $data['branch_code'] = ($id_branch > 0 && $this->config->item("integrationType") == 4 ? $this->customer_model->getBranchCode() : NULL);  
	   $data['branchWise'] = 0;  
	   $data['mobile'] = $mobile;  
	   $res = $this->customer_model->insExisAcByMobile($data);  
	   //echo $this->db->last_query();exit;
	   if(sizeof($res) > 0)
	   {
	   		$payData = $this->customer_model->syncPayData($res);  
	   	    if(sizeof($payData['succeedIds']) > 0 || $payData['no_records'] > 0){
				$status = $this->customer_model->updateInterTableStatus($res,$payData['succeedIds']);
				if($status === TRUE)
				{
					return array("status" => TRUE, "msg" => "Purchase Plan registered successfully"); 
				}
				else{
					return array("status" => FALSE, "msg" => "Error in updating intermediate tables");
				}
			}
			else
			{
				return array("status" => FALSE, "msg" => "Error in updating payment tables");
			}
	   }
	   else
	   {
	   		return array("status" => FALSE, "msg" => "No records to update in scheme account tables");
	   } 
	}
	
	//db transactions
    public function cus_post($type="",$id="")
	{
		$model=self::CUS_MODEL;
		$setmodel=self::SET_MODEL;
		switch($type)
		{
			case 'Add':
			       $cus = $this->input->post('customer');
			    //   $entry_date = $this->admin_settings_model->settingsDB('get','','');
			    if($cus['id_branch']!='')
			    {
			         $branch_date = $this->customer_model->get_entrydate($cus['id_branch']); // Taken from ret_day_closing  table branch wise //HH
			         if($branch_date['edit_custom_entry_date']==1)
			         {
			             $entry_date=$entry_date['custom_entry_date'];
			         }
			    }else{
			        $entry_date=NULL;
			    }
			    
			       $cus_data = array(
			       		'info'=>array(
			       			'firstname'			=>  (isset($cus['firstname'])?ucfirst($cus['firstname']): NULL), 
			       			'lastname' 			=>  (isset($cus['lastname'])?ucfirst($cus['lastname']): NULL),
							'id_branch'	    	=>  (isset($cus['id_branch'])?$cus['id_branch']: NULL), 
							'id_village'		=>  ($cus['id_village']!='' ?$cus['id_village'] :NULL), 
							'id_employee' 	    =>  $this->session->userdata('uid'),
							'date_of_birth'		=>	(isset($cus['date_of_birth']) && $cus['date_of_birth']!=''? date('Y-m-d',strtotime(str_replace("/","-",$cus['date_of_birth']))): NULL), 	
							'date_of_wed'		=>	(isset($cus['date_of_wed']) && $cus['date_of_wed']!=''? date('Y-m-d',strtotime(str_replace("/","-",$cus['date_of_wed']))): NULL),  
							'gst_number'		=>	(isset($cus['gst_number'])?$cus['gst_number']: NULL), 
							'email'				=>	(isset($cus['email'])?$cus['email']: NULL), 
							'mobile'			=>	(isset($cus['mobile'])?$cus['mobile']: NULL), 
							'gender'			=>	(isset($cus['gender'])?$cus['gender']: '-1'),
							'cus_type'			=>	(isset($cus['cus_type'])?$cus['cus_type']: '1'),
							'phone'				=>	(isset($cus['phone'])?$cus['phone']: NULL),
							'nominee_name'		=>	(isset($cus['nominee_name'])?$cus['nominee_name']: NULL),			       			
			       			'nominee_relationship'		=>	(isset($cus['nominee_relationship'])?$cus['nominee_relationship']: NULL),
			       			'nominee_mobile'	=>	(isset($cus['nominee_mobile'])?$cus['nominee_mobile']: NULL), 
							'cus_img'			=>	 NULL, 	
							'pan'				=>	(isset($cus['pan'])?$cus['pan']: NULL), 	
							/* 'pan_proof'			=>	NULL,  */
							'voterid'			=>	(isset($cus['voterid'])?$cus['voterid']: NULL), 
							/* 'voterid_proof'		=>	 NULL,  */
							'rationcard'		=>	(isset($cus['rationcard'])?$cus['rationcard']: NULL), 
							/* 'rationcard_proof'	=>	NULL, 	 */
							'comments'			=>	(isset($cus['comments'])?$cus['comments']: NULL), 	
							'username'			=>	(isset($cus['username'])?$cus['username']: NULL), 
							'passwd'			=>	(isset($cus['passwd'])?$this->$model->__encrypt($cus['passwd']): NULL), 
							'active'			=>	(isset($cus['active'])?$cus['active']: 1),
							'date_add'			=>   date("Y-m-d H:i:s") ,
						//	'custom_entry_date'	=>	(isset($cus['custom_entry_date'])? date('Y-m-d',strtotime(str_replace("/","-",$cus['custom_entry_date']))): NULL), 
					//		'custom_entry_date'   =>($entry_date[0]['edit_custom_entry_date']==1 ? $entry_date[0]['custom_entry_date']:NULL),
							'custom_entry_date'   =>$entry_date,
							'added_by'			=> 1,
							'id_profession'	    	=>  (isset($cus['id_profession'])?$cus['id_profession']: NULL),
							'aadharid'	    	=>  (isset($cus['aadharid'])?$cus['aadharid']: NULL)
			       		),
			       		
			       		'address'				=>array(
			       			'id_country'		=>	(isset($cus['country'])?$cus['country']:NULL),
							'id_state' 			=>	(isset($cus['state'])?$cus['state']:NULL),
							'id_city'			=>	(isset($cus['city'])?$cus['city']:NULL),					
							'company_name'		=>	($cus['cus_type']==2 ? $cus['firstname']:NULL),
							'address1'			=>	(isset($cus['address1'])?$cus['address1']:NULL),
							'address2'			=>	(isset($cus['address2'])?$cus['address2']:NULL),
							'address3'			=>	(isset($cus['address3'])?$cus['address3']:NULL),
							'pincode'			=>	(isset($cus['pincode'])?$cus['pincode']:NULL),	
							'active'			=>	(isset($cus['active'])?$cus['active']: 0),							
							'date_add'			=>	date("Y-m-d H:i:s")
			       		)
			       );
			       
			       // echo "<pre>";print_r($cus_data);echo "</pre>";exit;  
                   $this->db->trans_begin();
                   $cus_id=  $this->$model->insert_customer($cus_data);
                   if($cus_id > 0){
                        // Sync Existing Data					
                        if($this->config->item("integrationType") == 3 || $this->config->item("autoSyncExisting") == 1){
                            $syncData = $this->sync_existing_data($cus_data['info']['mobile'],$cus_id, $cus_data['info']['id_branch']);
                        }
                        // Create wallet account
                        $wallet_acc =  $this->$setmodel->settingsDB('get','','');
                        if($wallet_acc[0]['wallet_account_type']==1){
                           $this->wallet_account_create($cus_id,$cus_data['info']['mobile']);
                        }
                        
                        
                //webcam upload, #AD On:20-12-2022,Cd:CLin,Up:AB --->starts
                
                        $p_ImgData  = json_decode(rawurldecode($cus['cus_img'])); 
						$precious=$p_ImgData[0];
						if(sizeof($p_ImgData) > 0){ 
							$_FILES['cus_img']    =  array();
							$imgFile = $this->base64ToFile($precious->src);
							$_FILES['cus_img'] = $imgFile;
						} 
				
				//webcam upload ends...
				
                        // Upload image
                        if(isset($_FILES['cus_img']['name']) || isset($_FILES['pan_proof']['name']) || isset($_FILES['voterid_proof']['name']) || isset($_FILES['rationcard_proof']['name'] ))	
                        { 
                              $this->set_image($cus_id); 
                        }
                   } 
				   if($this->db->trans_status()===TRUE)
	               {
				 	 $this->db->trans_commit();
				 	
				 	 $this->session->set_flashdata('chit_alert',array('message'=>'Customer record added successfully','class'=>'success','title'=>'Create Customer'));
				 	 redirect('account/add');
				   }
				   else
				   {
                        $this->db->trans_rollback();						 	
                        $this->session->set_flashdata('chit_alert',array('message'=>'Unable to proceed the requested process','class'=>'danger','title'=>'Create Customer'));
                        redirect('customer');
				   }
				break;
			case 'Edit':
				 $cus=$this->input->post('customer');
		         $pwd_check=$this->$model->check_password($id,$cus['passwd']); 
		         //echo "<pre>";print_r($cus);exit;
			     $cus_data = array(
			       		'info' => array(
			       			'firstname'			=>  (isset($cus['firstname'])?$cus['firstname']: NULL), 
			       			'lastname' 			=>  (isset($cus['lastname'])?$cus['lastname']: NULL), 
							'id_branch'		=>  (isset($cus['id_branch'])?$cus['id_branch']: NULL), 
							'religion'		=>  (!empty($cus['religion'])?$cus['religion']: NULL), 
						    'id_village'		=>  ($cus['id_village']!='' ?$cus['id_village'] :NULL), 
							'date_of_birth'		=>	(isset($cus['date_of_birth']) && $cus['date_of_birth']!=''? date('Y-m-d',strtotime(str_replace("/","-",$cus['date_of_birth']))): NULL), 	
							'date_of_wed'		=>	(isset($cus['date_of_wed']) && $cus['date_of_wed']!=''? date('Y-m-d',strtotime(str_replace("/","-",$cus['date_of_wed']))): NULL),  
							'gst_number'				=>	(isset($cus['gst_number'])?$cus['gst_number']: NULL), 
							'email'				=>	(isset($cus['email'])?$cus['email']: NULL), 
							'mobile'			=>	(isset($cus['mobile'])?$cus['mobile']: NULL), 
							'gender'			=>	(isset($cus['gender'])?$cus['gender']: '-1'), 
							'cus_type'			=>	$cus['cus_type'],
							'phone'				=>	(isset($cus['phone'])?$cus['phone']: NULL),
							'nominee_name'			=>	(isset($cus['nominee_name'])?$cus['nominee_name']: NULL),
			       			'nominee_relationship'		=>	(isset($cus['nominee_relationship'])?$cus['nominee_relationship']: NULL),
			       			'nominee_mobile'	=>	(isset($cus['nominee_mobile'])?$cus['nominee_mobile']: NULL), 
							/* 	'cus_img'			=> (isset($cus['cus_img'])? $cus['cus_img']: (isset($cus['customer_img']) && $cus['customer_img'] != NULL ? $cus['customer_img'] : NULL )),  */	
							'pan'				=>	(isset($cus['pan'])?$cus['pan']: NULL), 	
							/* 'pan_proof'			=>	(isset($cus['pan_proof'])?$cus['pan_proof']: (isset($cus['pan_img']) && $cus['pan_img'] != NULL ? $cus['pan_img'] : NULL)),  */
							'voterid'			=>	(isset($cus['voterid'])?$cus['voterid']: NULL), 
							/* 'voterid_proof'		=>	(isset($cus['voterid_proof'])?$cus['voterid_proof']: (isset($cus['voter_img']) && $cus['voter_img'] != NULL ? $cus['voter_img'] : NULL)),  */
							'rationcard'		=>	(isset($cus['rationcard'])?$cus['rationcard']: NULL), 
							/* 	'rationcard_proof'	=>	(isset($cus['rationcard_proof'])?$cus['rationcard_proof']: (isset($cus['ration_img']) && $cus['ration_img'] != NULL ? $cus['ration_img'] : NULL)), 	 */
							'comments'			=>	(isset($cus['comments'])?$cus['comments']: NULL), 	
							'username'			=>	(isset($cus['username'])?$cus['username']: NULL), 
							'passwd'			=>	(isset($cus['passwd'])?($pwd_check == TRUE ? $cus['passwd']:$this->$model->__encrypt($cus['passwd'])): NULL), 
							'active'			=>	(isset($cus['active'])?$cus['active']: 0),
							'date_upd'			=>   date("Y-m-d H:i:s"),
							'id_profession'	    	=>  (isset($cus['id_profession'])?$cus['id_profession']: NULL),
							'aadharid'	    	=>  (isset($cus['aadharid'])?$cus['aadharid']: NULL)
			       		),
			       		
							'address'				=> array(
			       			'id_country'		=>	(isset($cus['country'])?$cus['country']:NULL),
							'id_state' 			=>	(isset($cus['state'])?$cus['state']:NULL),
							'id_city'			=>	(isset($cus['city'])?$cus['city']:NULL),
							'company_name'		=>	($cus['cus_type']==2 ?$cus['firstname'] :NULL),
							'address1'			=>	(isset($cus['address1'])?$cus['address1']:NULL),
							'address2'			=>	(isset($cus['address2'])?$cus['address2']:NULL),
							'address3'			=>	(isset($cus['address3'])?$cus['address3']:NULL),
							'pincode'			=>	(isset($cus['pincode'])?$cus['pincode']:NULL),	
							'active'			=>	(isset($cus['active'])?$cus['active']: 0),							
							'date_upd'			=>	date("Y-m-d H:i:s")
			       		)
			       );
			              
                    $this->db->trans_begin();
                    //echo "<pre>";print_r($cus_data);exit;
                    $cus_id = $this->$model->update_customer($cus_data,$id);
                    if( $id > 0)
                    {
                        // Sync Existing Data					
                        if($this->config->item("integrationType") == 3 || $this->config->item("autoSyncExisting") == 1){
                            $syncData = $this->sync_existing_data($cus_data['info']['mobile'],$id, $cus_data['info']['id_branch']);
                        }
                        
                   //webcam upload, #AD On:20-12-2022,Cd:CLin,Up:AB     
                        $p_ImgData  = json_decode(rawurldecode($cus['cus_img'])); 
						$precious=$p_ImgData[0];
						if(sizeof($p_ImgData) > 0){ 
							$_FILES['cus_img']    =  array();
							$imgFile = $this->base64ToFile($precious->src);
							$_FILES['cus_img'] = $imgFile;
						}
                        
                    //webcam upload ends...
                    
                        // upload image
                        if(isset($_FILES['cus_img']['name']) || isset($_FILES['pan_proof']['name']) || isset($_FILES['voterid_proof']['name']) || isset($_FILES['rationcard_proof']['name'] ))
                        {				   
                           $this->set_image($id);
                        }
                    } 
                    
                    if($this->db->trans_status()===TRUE)
                    {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('chit_alert',array('message'=>'Customer record modified successfully','class'=>'success','title'=>'Edit Customer'));
                        redirect('customer');
                    }
                    else
                    {
                        $this->db->trans_rollback();						 	
                        $this->session->set_flashdata('chit_alert',array('message'=>'Unable to proceed the requested process','class'=>'danger','title'=>'Edit Customer'));
                        redirect('customer');
                    }
				break;
			case 'Delete':
				$acc = $this->$model->check_acc_records($id);
				
					$pay = $this->$model->check_pay_records($id);
					
					if($acc == TRUE || $pay == TRUE)
					{
					    if($pay == TRUE )
                        {
							$this->session->set_flashdata('chit_alert', array('message' => 'Unable to proceed your request, Check whether payment entry exists for this customer','class' => 'danger','title'=>'Delete Scheme'));
						}
						else
						{   $this->session->set_flashdata('chit_alert', array('message' => 'Unable to proceed your request, Check whether savings scheme account is assigned for this customer','class' => 'danger','title'=>'Delete Scheme'));
							
						}	                         						
						
					}	
					else
					{
						 $this->db->trans_begin();
					
				        $this->$model->delete_customer($id);
				     
				   
						   if( $this->db->trans_status()===TRUE)
						   {
							  //Remove image and its folder
							
							  if(is_dir(self::CUS_IMG_PATH.$id))
							  {
								   $this->rrmdir(self::CUS_IMG_PATH.$id);
							  }	 
								
							  $this->db->trans_commit();
							  $this->session->set_flashdata('chit_alert', array('message' => 'Customer deleted successfully','class' => 'success','title'=>'Delete Customer'));
							  
							 
						   }			  
						   else
						   {
							 $this->db->trans_rollback();
							 $this->session->set_flashdata('chit_alert', array('message' => 'Unable to proceed your request','class' => 'danger','title'=>'Delete Customer'));
						   }
					}
						 redirect('customer');	
				break;
			
		}
	}
	 
	 function check_username($username)
	 {
	 	$model_name=self::CUS_MODEL;	
	 	$is_taken=$this->$model_name->username_available($username);
	 	if($is_taken)
	 	{
			$this->session->set_flashdata('chit_alert', array('message' => 'User name already taken, Please try another name','class' => 'danger','title'=>'Check Username Available'));
			
		 }
		
		echo $is_taken;
	 	
	 }
	 
	 function check_mobile()
	 {	 			
		$mobile=$this->input->post('mobile');	
		$id_customer =$this->input->post('id_customer');	
		
		$model_name=self::CUS_MODEL;	
		
		if($id_customer)
		{
			$available=$this->$model_name->mobile_available($mobile,$id_customer);
		}	
		else
		{
			$available=$this->$model_name->mobile_available($mobile);
		}	
		
		
					
		if($available)
		{
			
			echo 1;	
		}
		else
		{
			echo 0;
		}
		
	 	
	 } 
	 
	 function check_email()
	 {
		
			$email=$this->input->post('email');	
			$id_customer =$this->input->post('id_customer');	
			$model_name=self::CUS_MODEL;	
			 if($id_customer)
			{
				$available=$this->$model_name->email_available($email,$id_customer);
			}	
			else
			{
				 $available=$this->$model_name->email_available($email);
			}	
			if($available)
			{
				
				echo TRUE;	
			}
			else
			{
				echo FALSE;
			}
		
	 	
	 }
	 
	function upload_img__($field,$img_path,$filename)
	{
		
		
		if (!is_dir($img_path)) {
		    mkdir($img_path, 0777, TRUE);
			
		}
	
		if ($_FILES && $_FILES[$field]["tmp_name"] !="") {
       //print_r($_FILES);
		   	list($w, $h) = getimagesize($_FILES[$field]["tmp_name"]);
		     	/* calculate new image size with ratio */
		     $width = 900;
			 $height = 900;
			 $ratio = max($width/$w, $height/$h);
			 $h = ceil($height / $ratio);
			 $x = ($w - $width / $ratio) / 2;
			 $w = ceil($width / $ratio);
			 /* new file name */
			 $path = trim($img_path).$filename;
	
			 /* read binary data from image file */
			 $imgString = file_get_contents($_FILES[$field]['tmp_name']);
		
			 /* create image from string */
			 $image = imagecreatefromstring($imgString);
			 $tmp = imagecreatetruecolor($width, $height);
			 imagecopyresampled($tmp, $image,
			0, 0,
			$x, 0,
			$width, $height,
			$w, $h);
			 /* Save image */
			 switch ($_FILES[$field]['type']) {
			case 'image/jpeg':
			 imagejpeg($tmp, $path, 60);
			 break;
			case 'image/png':
			 imagepng($tmp, $path, 0);
			 break;
			case 'image/gif':
			 imagegif($tmp, $path);
			 break;
			default:
			 exit;
			 break;
			 }
			 $file_name = $path;
			     imagedestroy($image);
			     imagedestroy($tmp);
			     
			 }   
	} 
	
 function upload_img( $outputImage,$dst, $img)
	{	
	if (($img_info = getimagesize($img)) === FALSE)
	{
		// die("Image not found or not an image");
		return false;
	}
	$width = $img_info[0];
	$height = $img_info[1];
	
	switch ($img_info[2]) {
	  case IMAGETYPE_GIF  : $src = imagecreatefromgif($img);
	  						$tmp = imagecreatetruecolor($width, $height);
	  						$kek=imagecolorallocate($tmp, 255, 255, 255);
				      		imagefill($tmp,0,0,$kek);
	  						break;
	  case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); 
	  						$tmp = imagecreatetruecolor($width, $height);
	 						break;
	  case IMAGETYPE_PNG  : $src = imagecreatefrompng($img);
						    $tmp = imagecreatetruecolor($width, $height);
	  						$kek=imagecolorallocate($tmp, 255, 255, 255);
				     		imagefill($tmp,0,0,$kek);
				     		break;
	  default : //die("Unknown filetype");	
	  return false;
	  }		
	 
	  imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);
	  imagejpeg($tmp, $dst);
	
	}
function set_image($cus_id)
 {
 	$data=array();
    $img_path=self::CUS_IMG_PATH."/".$cus_id;
		
	if (!is_dir($img_path)) {
		    mkdir($img_path, 0777, TRUE);
			
		}
   	 if($_FILES['cus_img']['name'])
   	 {   
      //  $ext = pathinfo($_FILES['cus_img']['name'], PATHINFO_EXTENSION);
        $img=$_FILES['cus_img']['tmp_name'];
        $path=self::CUS_IMG_PATH.$cus_id."/".self::CUS_IMG;
		$filename = self::CUS_IMG.".jpg";	 	
	 	$this->upload_img('cus_img',$path,$img);	
	 	$data['cus_img']= $filename;	
	 } 
	
	 if($_FILES['pan_proof']['name']!="")
   	 {
		//$ext = pathinfo($_FILES['pan_proof']['name'], PATHINFO_EXTENSION); 
		$img=$_FILES['pan_proof']['tmp_name'];
		$path=self::CUS_IMG_PATH.$cus_id."/".self::PAN_IMG;
		$filename = self::PAN_IMG.".jpg";
   	 	$this->upload_img('pan_proof',$path,$img);
   	 	$data['pan_proof']=$filename;
	 	
	 } 
	 
	 if($_FILES['voterid_proof']['name']!="")
   	 {
		// $ext = pathinfo($_FILES['voterid_proof']['name'], PATHINFO_EXTENSION); 
		$img=$_FILES['voterid_proof']['tmp_name'];
		$path=self::CUS_IMG_PATH.$cus_id."/".self::VOTERID_IMG;
		$filename =self::VOTERID_IMG.".jpg";
   	 	$this->upload_img('voterid_proof',$path,$img);
   	 	$data['voterid_proof']=  $filename;
	 	
	 } 
	 
	 if($_FILES['rationcard_proof']['name']!="")
   	 {
		//$ext = pathinfo($_FILES['rationcard_proof']['name'], PATHINFO_EXTENSION);  
		$img=$_FILES['rationcard_proof']['tmp_name'];
		$path=self::CUS_IMG_PATH.$cus_id."/".self::RATION_IMG;
		$filename = self::RATION_IMG.".jpg";
   	 	$this->upload_img('rationcard_proof',$path,$img );
   	 	$data['rationcard_proof']= $filename ;
	 }
	
 }
	
	function rrmdir($path) {
     // Open the source directory to read in files
        $i = new DirectoryIterator($path);
        foreach($i as $f) {
            if($f->isFile()) {
                unlink($f->getRealPath());
            } else if(!$f->isDot() && $f->isDir()) {
                rrmdir($f->getRealPath());
            }
        }
        rmdir($path);
	}
	
	function profile_status($status,$id)
	{
		$data = array('profile_complete' => $status);
		$model=self::CUS_MODEL;
		$status = $this->$model->update_customer_only($data,$id);
		if($status)
		{
			$this->session->set_flashdata('chit_alert',array('message'=>'Profile status updated as '.($status ? 'complete' : 'incomplete').' successfully.','class'=>'success','title'=>'Profile Status'));			
		}	
		else
		{
			$this->session->set_flashdata('chit_alert',array('message'=>'Unable to proceed the requested operation','class'=>'danger','title'=>'Profile Status'));
		}	
		redirect('customer');
	}	
	
	function customer_status($status,$id)
	{
		$data = array('active' => $status);
		$model=self::CUS_MODEL;
		$status = $this->$model->update_customer_only($data,$id);
		if($status)
		{
			$this->session->set_flashdata('chit_alert',array('message'=>'Customer status updated as '.($status ? 'active' : 'inactive').' successfully.','class'=>'success','title'=>'Customer Status'));			
		}	
		else
		{
			$this->session->set_flashdata('chit_alert',array('message'=>'Unable to proceed the requested operation','class'=>'danger','title'=>'Customer Status'));
		}	
		redirect('customer');
	}
	
	//To download files
	public function download($id,$file)
	 {
	  	$img_path=self::CUS_IMG_PATH.$id."/".$file.".jpg";
	 //load the download helper
		$this->load->helper('download');
		$data = file_get_contents($img_path);
		$name = $file.'_'.$id.'.jpg';
		force_download($name, $data);
		return TRUE;
	}
	
	
	// wallet account insert //
	
	
	function wallet_account_create($cus_id,$mobile)
	{
	
			$set_model   = self::SET_MODEL;
			$wallmodel   = self::WALL_MODEL;
			$log_model   = self::LOG_MODEL;
			$chits_model = self::ADM_MODEL;		
			$sms_model   = self::SMS_MODEL;		
			$mail_model  = self::MAIL_MODEL;		
		
	        $wallet_acc_no =  $this->$wallmodel->get_wallet_acc_number();				
			
			$insertData=array( 
						   'id_customer' 	   => (isset($cus_id) && $cus_id!=''? $cus_id:NULL),
						   'id_employee' 	   =>  $this->session->userdata('uid'),
						   'wallet_acc_number' => (isset($wallet_acc_no)?$wallet_acc_no:NULL),
						   'issued_date' 	   => date('y-m-d H:i:s'),
						   'remark' 		    => "Credits",
						   'active'		        => 1	                        
                           );
			           
			           
			       //inserting data                  
			       $status = $this->$wallmodel->wallet_accountDB("insert","",$insertData);
			       $wallAcc = $this->$wallmodel->wallet_accountDB("get",$status['insertID']);
			       $this->$wallmodel->insChitwallet($status['insertID'],$mobile,$cus_id);
			      
			         if($status)
					{
						    $log_data = array(
												'id_log'     => $this->session->userdata('id_log'),
												'event_date' => date("Y-m-d H:i:s"),
												'module'     => 'Wallet Account',
												'operation'  => 'Add',
												'record'     => $status['insertID'],  
												'remark'     => 'Wallet Account added successfully'
											 );
										 
						 $this->$log_model->log_detail('insert','',$log_data);
						 $serviceID = 8;
			      		 $service =  $this->$set_model->get_service($serviceID);
			       		 $company = $this->$set_model->get_company();
						
							if($service['serv_sms'] == 1)
							{
								 //   '0 - promotion sms , 1 - otp',
		
									 $otp_promotion =1;
									
								$id =$status['insertID'];
								$data =$this->$sms_model->get_SMS_data($serviceID,$id);
								$mobile =$data['mobile'];
								$message = $data['message'];
								
								if($this->config->item('sms_gateway') == '1'){
									 $this->sms_model->sendSMS_MSG91($mobile,$message,$otp_promotion);		
								}
								elseif($this->config->item('sms_gateway') == '2'){
									 $this->sms_model->sendSMS_Nettyfish($mobile,$message,'promo');	
								}
							}
							
							 $email	=   $wallAcc['email'];
							 if($service['serv_email'] == 1  && $email!= '')
								{
									$data['walData'] = $wallAcc;
									$data['company'] = $company;
									$data['type'] = 1;
									$to = $email;
									$subject = "Reg- ".$company['company_name']." saving scheme wallet account creation.";
									$message = $this->load->view('include/emailWallet',$data,true);
									$sendEmail = $this->$mail_model->send_email($to,$subject,$message);
									
							   }
			           
					}
					
			
	
	}
	
	// wallet account insert //
	
	public function get_customer_by_mobile()
	{
		$model_name=self::CUS_MODEL;	
		$mobile=$this->input->post('mobile');
		
		$customer['result']=$this->$model_name->get_customer_by_mobile($mobile);
		
		echo json_encode($customer);
	}
	
	
	public function ajax_get_customers_list()
	{
		
		$mobile = $this->input->post('mobile');
		$id_scheme = $this->input->post('id_scheme');
		
		$model_name=self::CUS_MODEL;
		
		$cus_data=$this->$model_name->ajax_get_customers_list($mobile,$id_scheme);
		
		//	echo "<pre>"; print_r($cus_data);exit;
		
		echo json_encode($cus_data);
	}
	
	public function ajax_get_village()
	{
		$model_name=self::CUS_MODEL;
		$cus_data=$this->$model_name->get_village();
		echo json_encode($cus_data);
	}
	public function cus_profile($type="",$id="")
	{
	    $model=self::CUS_MODEL;
	    switch($type)
		{
		    case 'list':	
		         $data['main_content'] = self::CUS_VIEW."profile" ;
				 $this->load->view('layout/template', $data);
		    break;
		    
		    case 'edit':	
		         $data=$this->$model->Searchcustomer($_POST['searchTxt']);
				 echo json_encode($data);
		    break;
		    
		    case 'update':
		     $cus=$this->input->post('customer');
		    
			        $cus_data=array(
			       		'info'=>array(
			       			'firstname'			=>  (isset($cus['firstname'])?strtoupper($cus['firstname']): NULL), 
			       			'lastname' 			=>  (isset($cus['lastname'])? strtoupper($cus['lastname']): NULL), 
							'id_branch'		    =>  ($this->session->userdata('id_branch')!='' ? $this->session->userdata('id_branch'):NULL),
							'religion'		    =>  (!empty($cus['religion'])?$cus['religion']: NULL), 
						    'id_village'		=>  ($cus['id_village']!='' ?$cus['id_village'] :NULL), 
							'date_of_birth'		=>	(isset($cus['date_of_birth']) && $cus['date_of_birth']!=''? date('Y-m-d',strtotime(str_replace("/","-",$cus['date_of_birth']))): NULL), 	
							'date_of_wed'		=>	(isset($cus['date_of_wed']) && $cus['date_of_wed']!=''? date('Y-m-d',strtotime(str_replace("/","-",$cus['date_of_wed']))): NULL), 	
							'email'				=>	(isset($cus['email'])?$cus['email']: NULL), 
							'gender'			=>	(isset($cus['gender'])?$cus['gender']: '-1'),
							'send_promo_sms'	=>	(isset($cus['send_promo_sms'])?$cus['send_promo_sms']: 0),
							'date_upd'			=>   date("Y-m-d H:i:s") 
			       		),
			       		
							'address'				=> array(
			       			'id_country'		=>	(isset($cus['country'])?$cus['country']:NULL),
							'id_state' 			=>	(isset($cus['state'])?$cus['state']:NULL),
							'id_city'			=>	(isset($cus['city'])?$cus['city']:NULL),
							'company_name'			=>	(isset($cus['company_name'])?$cus['company_name']:NULL),
							'address1'			=>	(isset($cus['address1'])? strtoupper($cus['address1']):NULL),
							'address2'			=>	(isset($cus['address2'])? strtoupper($cus['address2']):NULL),
							'address3'			=>	(isset($cus['address3'])? strtoupper($cus['address3']):NULL),
							'pincode'			=>	(isset($cus['pincode'])?$cus['pincode']:NULL),	
							'active'			=>	(isset($cus['active'])?$cus['active']: 0),							
							'date_upd'			=>	date("Y-m-d H:i:s")
			       		),
			        );
			          
		             
			             
                    $this->db->trans_begin();
                    
                    $cus_id= $this->$model->update_customer($cus_data,$cus['id_customer']);
                  
                    //echo "<pre>"; print_r($this->db->last_query());exit;
                    
                    if($this->db->trans_status()===TRUE)
                    {
                        $log_data = array(
                        	'id_log'        => $this->session->userdata('id_log'),
                        	'event_date'	=> date("Y-m-d H:i:s"),
                        	'module'      	=> 'Customer',
                        	'operation'   	=> 'Edit',
                        	'record'        => $id,  
                        	'remark'       	=> 'Record edited successfully'
                        );
                        $this->log_model->log_detail('insert','',$log_data);
                        $this->db->trans_commit(); 
                        $return_data=array('status'=>true);
                        $this->session->set_flashdata('chit_alert',array('message'=>'Customer record modified successfully','class'=>'success','title'=>'Edit Customer'));
                    }
                    else
                    {
                        $this->db->trans_rollback();	
                        $return_data=array('status'=>false);
                        $this->session->set_flashdata('chit_alert',array('message'=>'Unable to proceed the requested process','class'=>'danger','title'=>'Edit Customer'));
                    }
                    
                    echo json_encode($return_data);
                    
                break;
                    
		}
	}
	
	
	function ajax_getAllActiveAgents(){
	    $model_name=self::CUS_MODEL;
		$agent_select=$this->$model_name->getAllActiveAgents();
		echo json_encode($agent_select);
	}
	
	function allocate_agent_toCuctomers(){
	    $model=self::CUS_MODEL;
     	$cus=$this->input->post('id_customer');
     	$id_agent = $this->input->post('id_agent');
     	$total= count($cus);
     	$total=array();
     	
 	if($total>0)
 	{
 		$this->load->model($model); 
 		
 		$i = 0;
		foreach($cus as $cusid)
		{
			$upd_data = array('id_agent' => $id_agent);
        	$cusData=$this->$model->allocate_agent($upd_data,$cusid);
        	
        	if($this->db->trans_status()===TRUE){
        	    $i++;
        	}else{
        	    $not_allocated[] = $cusid;
        	}
		}
		
		$result = $i;
	
	}     
	
    	if(count($cus) == $i){
    	    echo json_encode(array('status' => 1, 'total' =>count($cus))); 
    	}elseif($i == 0){
    	    echo json_encode(array('status' => 0, 'total' => count($cus),'not_allocated' =>$not_allocated)); 
    	}else{
    	   echo json_encode(array('status' => 2, 'total' => count($cus),'not_allocated' =>$not_allocated));  
    	}
    	
         
	}
//webcam upload, #AD On:20-12-2022,Cd:CLin,Up:AB	
	
	public function base64ToFile($imgBase64){
		$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgBase64)); // might not work on some systems, specify your temp path if system temp dir is not writeable
		$temp_file_path = tempnam(sys_get_temp_dir(), 'tempimg');
		file_put_contents($temp_file_path, $data);
		$image_info = getimagesize($temp_file_path); 
		$imgFile = array(
		     'name' => uniqid().'.'.preg_replace('!\w+/!', '', $image_info['mime']),
		     'tmp_name' => $temp_file_path,
		     'size'  => filesize($temp_file_path),
		     'error' => UPLOAD_ERR_OK,
		     'type'  => $image_info['mime'],
		);
		return $imgFile;
	}	
	
		public function ajax_get_scheme_account_list()
	{
		$model_name=self::CUS_MODEL;

		$scheme_acc_number = $this->input->post('acc_no');
		
		$scheme_code= $this->input->post('scheme_code');
		
		$cus_data=$this->$model_name->ajax_get_scheme_account_list($scheme_code,$scheme_acc_number);
		
		echo json_encode($cus_data);

	}
	
	
}	
?>