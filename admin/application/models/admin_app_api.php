<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Retail Admin app api's
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
require(APPPATH.'libraries/REST_Controller.php');

class Admin_app_api extends REST_Controller
{
	const ADM_MODEL = "ret_app_api_model";
	function __construct()
	{
		parent::__construct();
		$this->response->format = 'json';
		$this->load->model(self::ADM_MODEL);
		$this->load->model('services_model');
		$this->load->model('email_model');
		$this->load->model('sms_model');
		$this->load->model('ret_app_api_model');
		ini_set('date.timezone', 'Asia/Calcutta');
		// Android
		$this->current_android_version= "1.0.0";
		$this->new_android_version = "1.0.1";
		// iOS
		$this->current_ios_version= "1.0.0";
		$this->new_ios_version = "1.0.1";
	}

	/**
	* General functions
	*/
    //funtion to get post values
    function get_values()
    {
		return (array)json_decode(file_get_contents('php://input'));

	}

	//array sorting
	function array_sort($array, $on, $order=SORT_ASC){
		$new_array = array();
		$sortable_array = array();
		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}
			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}
			foreach ($sortable_array as $k => $v) {
				//$new_array[$k] = $array[$k];
				$new_array[] = $array[$k];
			}
		}
		return $new_array;
	}

	public function __encrypt($str)
	{
		return base64_encode($str);
	}

	/**
	* CRM Admin app api's
	*/

	function getVersion_get()
	{
	   	$version['android'] = $this->current_android_version;
	   	$version['new_android_ver'] = $this->new_android_version;
	   	$version['ios'] = $this->current_ios_version;
	   	$version['new_ios_ver'] = $this->new_ios_version;
		$version['comp'] = $this->ret_app_api_model->company_details();
		$version['settings'] = $this->ret_app_api_model->getChitSettings();
		$version['mode'] = $version['comp']['maintenance_mode'];
		$version['text'] = $version['comp']['maintenance_text']; //maintaince text
		$version['msg'] =  "New version available."; //New version text
		$version['showpopup'] = 0;
		$version['popupimg'] = "";
		$this->response($version,200);
	}


	/* Start of Master Function */
	function getBranchList_get(){
		$model = self::ADM_MODEL;
		$result = $this->$model->getBranches("list");
		$this->response($result,200);
	}

	function getBranchEmployees_get(){
		$model = self::ADM_MODEL;
		$result = $this->$model->getBranchEmployees($this->get('id_branch'));
		echo json_encode($result);
	}
	
	function getCustBySearch_post(){
		$model = self::ADM_MODEL;
		$postdata = $this->get_values();
		$data = $this->$model->getAvailableCustomers($postdata['searchTxt']);	 
		echo json_encode($data);
	}

	function getCurrencyAndSettings_post(){
		$model = self::ADM_MODEL;
		$postdata = $this->get_values();
		$result = $this->$model->currencyAndSettings($postdata['id_branch']);
		$this->response($result,200);
	}
	/* End of Master Function */


	/* Start Of Login Functions	*/

	function checkDevice() {
	// RETURNS 0 for desktop, 1 for mobile, 2 for tablets
	  if (is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"))) {
	    return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "tablet")) ? 2 : 1 ;
	  } else {
	    return 0;
	  }
	}

	function verifyLoginOTP_post()
	{
		$model = self::ADM_MODEL;
		$this->load->model("log_model");
		$this->load->model("chitadmin_model");
		$this->load->model("admin_settings_model");
		$postdata = $this->get_values();
		$username 	= $postdata['username'];
		$userpwd  	= $postdata['password'];
		$input_otp  = $postdata['input_otp'];
		$employee 	= $this->$model->get_emp_by_username($username);
		$company 	= $this->admin_settings_model->get_company();
		$branch_set = $this->chitadmin_model->branch_settings();
		$otp 		= $this->$model->select_otp($input_otp);
		$login_data['is_verified']	= '1';
		$login_data['verified_time']= date("Y-m-d H:i:s");
		$status 	= $this->$model->otp_update($login_data,$otp['id_otp']);
		if( $postdata['input_otp'] ==  $postdata['sys_otp'])
		{
			if(time() >= $postdata['sys_otp_exp'])
			{
				$result = array('result'=>FALSE ,'msg'=>'OTP has been expired');
			}
			else
			{
				if($employee['id_branch'] > 0){
					$branch_data  = $this->admin_settings_model->get_branch_by_id($employee['id_branch']);
					$branch_name = $branch_data['name'];
				} else{
					$branch_name = "";
				}
				$deviceType = $this->checkDevice();
				$menus = $this->$model->getUserMenus($employee['id_employee']);
				$log_data = array(
									'id_employee'   => $employee['id_employee'],
									'login_on'      => date("Y-m-d H:i:s"),
									'id_otp'		=> $otp['id_otp'],
									'ip_address'    => NULL,
									'device_type'   => ($deviceType==0 ? "DESKTOP":($deviceType==1 ? "MOBILE":($deviceType==2 ? "TABLET":"DESKTOP")))
								 );
				$log = $this->log_model->log("insert","",$log_data);
				$data = array(
					'username'  		=> $employee['username'],
					'uid'       		=> $employee['id_employee'],
					'profile'   		=> $employee['id_profile'],
					'emp_code'   		=> $employee['emp_code'],
					'is_logged' 		=> true,
					'id_log'    		=> $log['insertID'],
					'logged_on' 		=> date("Y-m-d H:i:s"),
					'currency_symbol'	=> $company['currency_symbol'],
					'mob_code'			=> $company['mob_code'],
					'mob_no_len'		=> $company['mob_no_len'],
					'branch_settings'   => $branch_set['branch_settings'],
					'filerbybranch'	    =>($branch_set['branch_settings']==1 ?$employee['id_branch']==0 ?'0' :'1' :'nobranch'),
					'id_branch'   		=> $employee['id_branch'],
					'branch_name'  		=> $branch_name,
					'branchWiseLogin'   => $branch_set['branchWiseLogin'],
					'is_branchwise_cus_reg' => $branch_set['is_branchwise_cus_reg'],
					'is_branchwise_rate'   	=> $branch_set['is_branchwise_rate']
				);
				$result = array('result' => TRUE, 'type' => 'logged', 'msg' => 'Logged In successfully...', 'empdata' => $data, 'menus' => $menus);
				$this->response($result, 200);
			}
		}
		else
		{
			$result=array('result'=> FALSE ,'msg'=>'Invalid OTP');
		}
		$this->response($result, 200);
	}

	//to check the mobile number already registered
	function isNumberRegistered($data)
	{
		$model = self::ADM_MODEL;
		$mobile = $data['mobile'];
		$email =  $data['email'];
	    $m_exist =	$this->$model->isMobileExists($mobile);
	    //$e_exist =	$this->$model->clientEmail($email);
	    $e_exist =	FALSE;
	    $limit= $this->services_model->limitDB('get','1');
		$count= $this->services_model->customer_count();
		$limit_exceed = 0;
		if($limit['limit_cust']==1 && $count >= $limit['cust_max_count'])
		{
			$limit_exceed = 1;
		}
		$is_reg = ($m_exist ? TRUE : ($e_exist ? TRUE : FALSE));
		$result = array(
							'is_reg' => $is_reg,
							'msg'	 => ($is_reg ? ($m_exist && $e_exist)?"Mobile and Email already registered":($m_exist ?"Mobile already registered":"E-mail already Registered" ): ($limit_exceed == 1 ? 'Temporarily New user registration is unavailable, Kindly contact Customer care...' : FALSE))
						);
		return $result;
	}

	public function authenticate_post()
	{
		$this->load->model("log_model");
		$this->load->model("chitadmin_model");
		$this->load->model("admin_settings_model");
		$model = self::ADM_MODEL;
		$postdata = $this->get_values();
		$username = $postdata['username'];
		$userpwd  = $postdata['password'];
		$id_branch= $postdata['id_branch'];
		if ($username != '' && $userpwd != '')
		{
			$employee	= $this->$model->isValidLogin($username,$this->__encrypt($userpwd));
			/*$emp_id   = $this->$model->authenticate_user_id($username,$userpwd);
			/$employee = $this->$model->get_emp_by_username($username);*/
			$company 	= $this->admin_settings_model->get_company();
			$branch_set = $this->chitadmin_model->branch_settings();
			$finance    = $this->admin_settings_model->get_financial_data();
			$deviceType = $this->checkDevice();
			//Login Branches
			$branch_id  = array(explode(',',$employee['login_branches']));
			$branch_login = true;
			if($branch_set['login_branch']==1)
			{
				if($branch_id[0][0] == 0){
					$branch_login=true;
				}else{
					foreach($branch_id[0] as $branch)
					{
						if($branch == $id_branch)
						{
							$branch_login=true;
							break;
						}else{
							$branch_login=FALSE;
						}
					}
				}
			}
			if($id_branch > 0){
				$branch_data  = $this->admin_settings_model->get_branch_by_id($id_branch);
				$branch_name = $branch_data['name'];
			} else{
				$branch_name = "";
			}

			//Login Branches

			if($branch_login)
			{
				if($employee['is_valid'])
				{
					if($employee['id_profile'] == 1 || $employee['id_profile'] == 2 || $employee['id_profile'] == 3)
					{
						if($employee['req_otplogin'] == 1){ // Profile wise OTP required
							$loginOTP_exp = $this->$model->loginOTP_exp();
							$mobile	  =	$employee['mobile'];
							$firstname=	$employee['firstname'];
							$OTP = mt_rand(100001,999999);
							$message="Your OTP for Admin Panel Login is ".$OTP."  Will expire within ". $loginOTP_exp." Sec. ";
							$this->chitadmin_model->send_sms($mobile,$message);
							$otp['sys_otp_exp '] = date("Y-m-d H:i:s");
							$otp['otp'] = $OTP;
							$status=$this->ret_app_api_model->insertData($otp,'otp');
							$result = array('result' => TRUE, 'type' => 'otp','msg' => 'OTP has been sent', 'otp' => $otp, 'mobile' => $mobile);
							$this->response($result, 200);
						}
						else{
							$menus = $this->$model->getUserMenus($employee['id_employee']);
							$log_data = array(
									'id_employee'   => $employee['id_employee'],
							        'id_branch'   	=> $id_branch == 0 ? NULL:$id_branch,
									'login_on'      => date("Y-m-d H:i:s"),
									'ip_address'    => $this->session->userdata('ip_address'),
									'device_type'   => ($deviceType==0 ? "DESKTOP":($deviceType==1 ? "MOBILE":($deviceType==2 ? "TABLET":"DESKTOP")))
								 );
							$log = $this->log_model->log("insert","",$log_data);
							$data = array(
								'fin_year_code'    	=> $finance['fin_year_code'],
								'username'  		=> $employee['username'],
								'uid'       		=> $employee['id_employee'],
								'profile'   		=> $employee['id_profile'],
								'emp_code'   		=> $employee['emp_code'],
								'is_logged' 		=> true,
								'id_log'    		=> $log['insertID'],
								'logged_on' 		=> date("Y-m-d H:i:s"),
								'currency_symbol'	=> $company['currency_symbol'],
								'mob_code'			=> $company['mob_code'],
								'mob_no_len'		=> $company['mob_no_len'],
								'branch_settings'   => $branch_set['branch_settings'],
								'filerbybranch'	    => ($branch_set['branch_settings']==1 ?$employee['id_branch']==0 ?'0' :'1' :'nobranch'),
								'id_branch'   		=> $id_branch == 0 ? '':$id_branch,
								'branch_name'  		=> $branch_name,
								'branchWiseLogin'   	=> $branch_set['branchWiseLogin'],
								'is_branchwise_cus_reg' => $branch_set['is_branchwise_cus_reg'],
								'is_branchwise_rate'   	=> $branch_set['is_branchwise_rate'],
								'menus' => $menus
							);
							$result = array('result' => TRUE, 'type' => 'logged', 'msg' => 'Logged In successfully...', 'empdata' => $data);
							$this->response($result, 200);
						}
					}
					else
					{
						if($branch_set['isOTPReqToLogin']==1 )
						{
							$loginOTP_exp = $this->$model->loginOTP_exp();
							$mobile	  =	$employee['mobile'];
							$firstname=	$employee['firstname'];
							$OTP = mt_rand(100001,999999);
							$message="Your OTP for Admin Panel Login is ".$OTP."  Will expire within ". $loginOTP_exp." Sec. ";
							$this->chitadmin_model->send_sms($mobile,$message);
							$otp['sys_otp_exp'] = date("Y-m-d H:i:s");
							$otp['otp'] = $OTP;
							$status=$this->ret_app_api_model->insertData($otp,'otp');
							$result = array('result' => TRUE, 'type' => 'otp', 'msg' => 'OTP has been sent', 'otp' => $otp, 'mobile' => $mobile);
							$this->response($result, 200);
						}
						else
						{
							$menus = $this->$model->getUserMenus($employee['id_employee']);
							$log_data = array(
									'id_employee'   => $employee['id_employee'],
							        'id_branch'   	=> $id_branch == 0 ? NULL:$id_branch,
									'login_on'      => date("Y-m-d H:i:s"),
									'ip_address'    => $this->session->userdata('ip_address'),
									'device_type'   => ($deviceType==0 ? "DESKTOP":($deviceType==1 ? "MOBILE":($deviceType==2 ? "TABLET":"DESKTOP")))
								 );
							$log = $this->log_model->log("insert","",$log_data);
							$data = array(
							'username'  		=> $employee['username'],
							'uid'       		=> $employee['id_employee'],
							'profile'   		=> $employee['id_profile'],
							'emp_code'   		=> $employee['emp_code'],
							'is_logged' 		=> true,
							'id_log'    		=> $log['insertID'],
							'logged_on' 		=> date("Y-m-d H:i:s"),
							'currency_symbol'	=> $company['currency_symbol'],
							'mob_code'			=> $company['mob_code'],
							'mob_no_len'		=> $company['mob_no_len'],
							'branch_settings'   => $branch_set['branch_settings'],
							'filerbybranch'	    =>($branch_set['branch_settings']==1 ?$employee['id_branch']==0 ?'0' :'1' :'nobranch'),
							'id_branch'   		=> $employee['id_branch'],
							'branch_name'  		=> $branch_name,
							'branchWiseLogin'   	=> $branch_set['branchWiseLogin'],
							'is_branchwise_cus_reg' => $branch_set['is_branchwise_cus_reg'],
							'is_branchwise_rate'   	=> $branch_set['is_branchwise_rate'],
							'menus' => $menus
							);
							$result = array('result' => TRUE, 'type' => 'logged', 'msg' => 'Logged In successfully...', 'empdata' => $data);
							$this->response($result, 200);
						}
					}
				}
				else
				{
					$result=array('result'=> FALSE ,'msg'=>'Invalid Username or Password');
					$this->response($result, 200);
				}
			}
			else
			{
				$result=array('result'=> FALSE ,'msg'=>'Invalid Branch');
				$this->response($result, 200);
			}
		}
		else
		{
			$result=array('result'=> FALSE ,'msg'=>'Username and Password are required');
			$this->response($result, 200);
		}

	}
	// End of Login Functions

	/* Start of Customer Master functions */
	function createCustomer_post()
	{
		$model = self::ADM_MODEL;
		$data = $this->get_values();
		$result ='';
		$is_already_reg = $this->isNumberRegistered($data);
		if($is_already_reg['is_reg']){ // Already registered
			$res = array("msg"=>$is_already_reg['msg'],"status"=>FALSE);
			$this->response($res,200);
		}
		$customer = array(
						'info'=>array(
							'firstname' => ucwords($data['firstname']),
							'lastname'  => ucfirst($data['lastname']),
							'gender'	=> $data['gender'],
							'cus_type'  => $data['cus_type'],
							'mobile'    => $data['mobile'],
							'email'     => $data['email'],
							'passwd'    => $this->__encrypt($data['mobile']),
							'active'    => 1,
						    'date_add'  => date('Y-m-d H:i:s'),
						    'added_by'  => 4,	// Retail App
							'id_employee' 	=> (isset($data['id_employee'])?$data['id_employee']:NULL),
							'id_branch' 	=> (isset($data['id_branch'])?$data['id_branch']:NULL),
							'id_village' 	=> (isset($data['id_village'])?$data['id_village']:NULL),
							'date_of_birth' => (isset($data['date_of_birth'])?$data['date_of_birth']:NULL),
							'date_of_wed' 	=> (isset($data['date_of_wed'])?$data['date_of_wed']:NULL),
							'send_promo_sms'=> (isset($data['send_promo_sms'])?$data['send_promo_sms']:0),
							'is_vip' 		=> (isset($data['is_vip'])?$data['is_vip']:0),
							'religion' 		=> (isset($data['religion'])?$data['religion']:0),
							'pan'	 		=> (isset($data['pan'])?$data['pan']:NULL),
							'gst_number'	=> (isset($data['gst_number'])?$data['gst_number']:NULL),
							'nominee_name'	=> (isset($data['nominee_name'])?$data['nominee_name']:NULL),
							'nominee_relationship'	=> (isset($data['nominee_relationship'])?$data['nominee_relationship']:NULL),
							'nominee_mobile'=> (isset($data['nominee_mobile'])?$data['nominee_mobile']:NULL),
							'voterid'		=> (isset($data['voterid'])?$data['voterid']:NULL),
							'rationcard'	=> (isset($data['rationcard'])?$data['rationcard']:NULL),
							'comments'		=> (isset($data['comments'])?$data['comments']:NULL),
							),
							'address'=>array(
								'address1'			=>	(isset($data['address1'])?$data['address1']:NULL),
								'address2'			=>	(isset($data['address2'])?$data['address2']:NULL),
								'id_country'		=>	(isset($data['id_country'])?$data['id_country']:NULL),
								'id_state'			=>	(isset($data['id_state'])?$data['id_state']:NULL),
								'id_city'			=>	(isset($data['id_city'])?$data['id_city']:NULL),
								'pincode'			=>	(isset($data['pincode'])?$data['pincode']:NULL)
							)
						 );
		$this->db->trans_begin();
		$status = $this->$model->insert_customer($customer);
		if($this->db->trans_status()==TRUE)
		{
			$wallet_acc =  $this->$model->wallet_accno_generator();
			if($wallet_acc['wallet_account_type']==1){
				$this->wallet_account_create($status['insertID'],$data['mobile']);
				}
			$id = $status['insertID'];
			if($this->db->trans_status() == TRUE ){
				$log_data = array(
						'id_log'     => $data['id_log'],
						'event_date' => date("Y-m-d H:i:s"),
						'module'     => 'Customer',
						'operation'  => 'Add',
						'record'     => $status['insertID'],
						'remark'     => 'Customer added successfully',
						'event_through'     => 3, // 1 - Web admin, 2 - CRM mobile admin, 3 - Retail mobile admin
					 );

				$this->$model->insertData($log_data,'log_detail');
				$this->db->trans_commit();
				$serviceID = 1;
				  $company = $this->$model->company_details();
				  $service = $this->services_model->checkService($serviceID);
					if($service['sms'] == 1)
					{
						$data =$this->services_model->get_SMS_data($serviceID,$id);
						$mobile =$data['mobile'];
						$message = $data['message'];
						if($this->config->item('sms_gateway') == '1'){
						    $this->sms_model->sendSMS_MSG91($mobile,$message);
		        		}
		        		elseif($this->config->item('sms_gateway') == '2'){
		        	        $this->sms_model->sendSMS_Nettyfish($mobile,$message,'trans');
		        		}
					}
					if($service['serv_whatsapp'] == 1){
	            	    $this->services_model->send_whatsApp_message($mobile,$message);
	                }
					if($service['email'] == 1 && $customer['email'] != '')
					{
						$to =$customer['email'];
						$data['name'] = $customer['firstname'];
						$data['mobile'] = $customer['mobile'];
						$data['passwd'] = $this->__decrypt($customer['passwd']);
						$data['company_details']=$company;
						$data['type'] = 3;
						$subject = "Reg: ".$this->comp['company_name']." saving scheme registration";
						$message = $this->load->view('include/emailAccount',$data,true);
						$sendEmail = $this->email_model->send_email($to,$subject,$message);
					}
				$result = array('status'=> TRUE, 'msg'=>'Customer registered successfully.');
			}
			else
			{
				$this->db->trans_rollback();
				$result = array( "status" =>FALSE, "msg" => "Unable to proceed your request,please try again..");
			}
		}
		else
		{
			$result = array( "status" =>FALSE, "msg" => "Unable to proceed your request");
		}

		$this->response($result,200);
	}

	function sync_existing_data($mobile,$id_customer,$id_branch)
	{
	   $this->load->model('registration_model');
	   $data['id_customer'] = $id_customer;
	   $data['id_branch'] = $id_branch;
	   $data['branchWise'] = 0;
	   $data['mobile'] = $mobile;
	   $res = $this->registration_model->insExisAcByMobile($data);
	   if(sizeof($res) > 0)
	   {
	   		$payData = $this->registration_model->syncPayData($res);
	   	    if(sizeof($payData['succeedIds']) > 0 || $payData['no_records'] > 0){
				$status = $this->registration_model->updateInterTableStatus($res,$payData['succeedIds']);
				if($status === TRUE)
				{
					/*echo $this->db->_error_message();
					echo $this->db->last_query();*/
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

	function updateCustomer_post()
	{
		$result = array();
		$model = self::ADM_MODEL;
		$data = $this->get_values();
		$id_customer = $data['id_customer'];
		$myDate = date('Y-m-d H:i:s');
		$customer = array(
						'firstname' => ucwords($data['firstname']),
						'lastname'  => ucfirst($data['lastname']),
						'title'  	=> $data['title'],
						'gender'	=> $data['gender'],
						'cus_type'  => $data['cus_type'],
						'email'     => $data['email'],
						'passwd'    => $this->__encrypt($data['mobile']),
						'active'    => $data['active'],
					    'date_upd'  => date('Y-m-d H:i:s'),
						'id_employee' 	=> (isset($data['id_employee'])?$data['id_employee']:NULL),
						'id_branch' 	=> (isset($data['id_branch'])?$data['id_branch']:NULL),
						'id_village' 	=> (isset($data['id_village'])?$data['id_village']:NULL),
						'date_of_birth' => (isset($data['date_of_birth'])?$data['date_of_birth']:NULL),
						'date_of_wed' 	=> (isset($data['date_of_wed'])?$data['date_of_wed']:NULL),
						'send_promo_sms'=> (isset($data['send_promo_sms'])?$data['send_promo_sms']:0),
						'is_vip' 		=> (isset($data['is_vip'])?$data['is_vip']:0),
						'religion' 		=> (isset($data['religion'])?$data['religion']:0),
						'pan'	 		=> (isset($data['pan'])?$data['pan']:NULL),
						'gst_number'	=> (isset($data['gst_number'])?$data['gst_number']:NULL),
						'nominee_name'	=> (isset($data['nominee_name'])?$data['nominee_name']:NULL),
						'nominee_relationship'	=> (isset($data['nominee_relationship'])?$data['nominee_relationship']:NULL),
						'nominee_mobile'=> (isset($data['nominee_mobile'])?$data['nominee_mobile']:NULL),
						'voterid'		=> (isset($data['voterid'])?$data['voterid']:NULL),
						'rationcard'	=> (isset($data['rationcard'])?$data['rationcard']:NULL),
						'comments'		=> (isset($data['comments'])?$data['comments']:NULL),
					);
		$customer['date_upd'] = $myDate;
		$address = array(
						'address1' 	  => ucfirst($data['address1']),
						'address2' 	  => ucfirst($data['address2']),
						'id_country'  => $data['id_country'],
						'id_state'    => $data['id_state'],
						'id_city' 	  => $data['id_city'],
						'pincode' 	  => $data['pincode']
						);
		$this->db->trans_begin();
		$cflag = $this->$model->updateData($customer,"id_customer",$id_customer,"customer");
		$isExists = $this->$model->isAddressExist($id_customer);
		if($isExists)
		{
			$address['date_upd'] = $myDate;
			$aflag = $this->$model->updateData($address,"id_customer",$id_customer,"address");
		}
		else
		{
		  $address['id_customer'] = $id_customer;
		  $address['date_add'] = $myDate;
		  $aflag = $this->$model->insertData($address,"address");
		}
		if($cflag)
		{
			if($this->db->trans_status() == TRUE ){
				$log_data = array(
							'id_log'     => $data['id_log'],
							'event_date' => date("Y-m-d H:i:s"),
							'module'     => 'Customer',
							'operation'  => 'Edit',
							'record'     => $id_customer,
							'remark'     => 'Customer edited successfully',
							'event_through'     => 3, // 1 - Web admin, 2 - CRM mobile admin, 3 - Retail mobile admin
						 );
				$this->$model->insertData($log_data,'log_detail');
				$this->db->trans_commit();
				$result = array('status'=> TRUE,'msg' => "Customer updated successfully");
			}
			else
			{
				$this->db->trans_rollback();
				$result = array('status' => FALSE, 'msg' => 'Unable to proceed the request');
			}
			$this->response($result,200);
		}
	}

	public function getVillages_get()
	{
		$model = self::ADM_MODEL;
		$id_village = "";
		$result = $this->$model->getVillageData($id_village);
		//$this->response($result,200);
		echo json_encode($result);
	}

	function getCountry_get()
	{
		$model = self::ADM_MODEL;
		$result = $this->$model->get_country();
		//$this->response($result,200);
		echo json_encode($result);
	}

	function getState_get()
	{
		$model = self::ADM_MODEL;
		$result = $this->$model->get_state($this->get('id_country'));
		//$this->response($result,200);
		echo json_encode($result);
	}

	function getCity_get()
	{
		$model = self::ADM_MODEL;
		$result = $this->$model->get_city($this->get('id_state'));
		//$this->response($result,200);
		echo json_encode($result);
	}
	
	function getAllTaxGroupItems_get(){
		$model = self::ADM_MODEL;
		$data = $this->$model->getAllTaxGroupItems();	  
		echo json_encode($data);
	}
	
	/* End of Customer Master functions */


	/* Start of Catalog functions */
	function getCategories_post()
	{
		$model = self::ADM_MODEL;
		$data = $this->get_values();
		$result = $this->$model->getCategories($data['type'],$data['last_id']);
		$this->response($result,200);
	}

	function getProducts_post()
	{
		$model = self::ADM_MODEL;
		$data = $this->get_values();
		$result = $this->$model->getProducts($data['type'],$data['id_category'],$data['last_id']);
		$this->response($result,200);
	}

	function getDesigns_post()
	{
		$model = self::ADM_MODEL;
		$data = $this->get_values();
		$result = $this->$model->getDesigns($data['type'],$data['id_product'],$data['last_id']);
		$this->response($result,200);
	}
	/* End of Catalog functions */
	
	
	/* Start of Estimation functions */
	function getTaggingBySearch_post(){ 
		$model = self::ADM_MODEL;
		$data = $this->get_values();
		$tagData = $this->$model->getTaggingBySearch($data['searchTxt'],$data['searchField'],$data['id_branch']);	   
		$result['tagData'] = $tagData;
		if(sizeof($tagData)>0){
			if($tagData['tag_status'] == 0){
				$result['msg'] =  "";	
				$result['status'] =  true;	
			}else{
				$tagCode = $tagData['tag_code'];
				$result['msg'] =  ($tagData['tag_status'] == 1 ? $tagCode." Sold Out" : ($tagData['tag_status'] == 2 ? $tagCode." Deleted" : ($tagData['tag_status'] == 3 ? $tagCode." marked as Other Issue": ($tagData['tag_status'] == 4 ? $tagCode." is in-transit":$tagData['tag_status'] == 5 ? $tagCode." Removed from stock":""))));	
				$result['status'] =  false;	
			}			
		}else{
			$result['msg'] =  ($data['searchField'] == "tag_code" ? "Tag code ".$data['searchTxt']: "Tag")." Not found...";	
			$result['status'] =  false;	
		}
		$this->response($result,200);
	}
	
	 function getNonTagItems_post(){
	 	$model = self::ADM_MODEL;
		$data = $this->get_values();
		$result = $this->$model->getNonTagItems($data['id_branch']);
		$this->response($result,200);
	 }
	 
	 function getHomeStock_post(){ // Partly Sold Item balance
	 	$model = self::ADM_MODEL;
		$data = $this->get_values();  
		$homeStock = $this->$model->getHomeStock($data['type'],$data['searchTxt'],$data['searchField'],$data['id_branch']);	
		if($data['type'] == 'all'){
			$result = $homeStock;
		}else{
			$result['homeStock'] = $homeStock;
			if(sizeof($homeStock)>0){
				if($homeStock['tag_status'] == 0){
					$result['msg'] =  "";	
					$result['status'] =  true;	
				}else{
					$tagCode = $homeStock['tag_code'];
					$result['msg'] =  $tagCode." Sold Out";	
					$result['status'] =  false;	
				}			
			}else{
				$result['msg'] =  ($data['searchField'] == "tag_code" ? "Tag code ".$data['searchTxt']: "Tag")." Not found...";	
				$result['status'] =  false;	
			}  
		} 
		$this->response($result,200);
	 }
	 
	 function getStones_get(){
	 	$model = self::ADM_MODEL;
		$result = $this->$model->getStones($this->get('type'));
		$this->response($result,200);
	 }
	 
	 function createEstimation_post(){
	 	$model = self::ADM_MODEL;
	 	$this->load->model("admin_settings_model");
		$addData = $this->get_values(); 
	  	$dCData = $this->$model->getBranchDayClosingData($addData['id_branch']);
		if(sizeof($dCData) > 0){
			$estimation_datetime = ($dCData['entry_date'] == date("Y-m-d") ? date("Y-m-d H:i:s") : $dCData['entry_date'].' '.date("H:i:s"));
			$esti_no = $this->$model->generateEstiNo($dCData['entry_date']);
			$data = array(
				'estimation_datetime'	=> $estimation_datetime,
				'esti_no'				=> $esti_no,
				'esti_for'				=> (isset($addData['esti_for']) ? $addData['esti_for'] :1 ),
				'cus_id'				=> (!empty($addData['cus_id']) ? $addData['cus_id'] :NULL ),
				'has_converted_order'   => 0,
				'total_cost'			=> (!empty($addData['total_cost']) ? $addData['total_cost'] : 0 ),
				'created_time'	  		=> date("Y-m-d H:i:s"),
				'created_by'      		=> $addData['id_employee'],
				'id_branch'      		=> $addData['id_branch']
			);
			$this->db->trans_begin();
			$insId = $this->$model->insertData($data,'ret_estimation');
			if($insId){
				// Tag 
				if($addData['is_tag']  && sizeof($addData['tag']) > 0){
					$arrayEstTags = array();
					foreach($addData['tag'] as $estTag){
						 $arrayEstTags = array(
							'esti_id'              => $insId, 
							'tag_id'               => $estTag->tag_id, 
							'item_type'            => 0, 
							'product_id'           => $estTag->product_id, 
							'purity'               => $estTag->purity, 
							'size'                 => ($estTag->size!='' ? $estTag->size: NULL), 
							'piece'                => $estTag->piece, 
							'less_wt'              => (!empty($estTag->less_wt) ? $estTag->less_wt:NULL), 
							'net_wt'               => $estTag->net_wt, 
							'gross_wt'             => (isset($estTag->gross_wt) ? (!empty($estTag->gross_wt) ?$estTag->gross_wt:NULL) : $estTag->gross_wt), 
							'calculation_based_on' => $estTag->calculation_based_on,
							'wastage_percent'      => $estTag->retail_max_wastage_percent, 
							'mc_value'             => ($estTag->mc_value!='' ? $estTag->mc_value:NULL), 
							'mc_type'              => $estTag->mc_type, 
							'item_cost'            => $estTag->sales_value,
							'item_total_tax'       => $estTag->tax_price,
							'market_rate_cost'     => $estTag->market_sales_value,
							'market_rate_tax'      =>  $estTag->market_tax_price,
							'is_partial'           => ($estTag->is_partial!='' ? $estTag->is_partial:0),
							'id_orderdetails'      => ($estTag->id_orderdetails!='' ? $estTag->id_orderdetails:NULL),
							'orderno'              => ($estTag->order_no!='' ? $estTag->order_no:NULL)
						);
						if(!empty($arrayEstTags)){
							$tagInsert = $this->$model->insertData($arrayEstTags,'ret_estimation_items'); 
						}
					} 
				}
				// Non Tag 
				if($addData['is_non_tag']  && sizeof($addData['non_tag']) > 0){
					$arrayestNonTag = array();
					foreach($addData['non_tag'] as $estNonTag)
					{
						$arrayestNonTag =  array(
							'esti_id' 			   => $insId, 
							'design_id'            => $estNonTag->design, 
							'item_type' 		   => 1, 
							'product_id'           => ($estNonTag->pro_id!='' ? $estNonTag->pro_id:''), 
				 //Required 'purity'               => $estNonTag->purity,
							'size'                 => ($estNonTag->size!='' ?$estNonTag->size :NULL), 
							'piece'                => ($estNonTag->piece!=''?$estNonTag->piece:NULL), 
							'less_wt'              => ($estNonTag->less_wt!='' ?$estNonTag->less_wt :NULL),
							'net_wt'               => $estNonTag->net_wt, 
							'gross_wt'             => $estNonTag->gross_wt,
							'mc_type'              => ($estNonTag->mc_type!='' ?  $estNonTag->mc_type:1),  
							'calculation_based_on' => ($estNonTag->calculation_based_on!='' ? $estNonTag->calculation_based_on:NULL), 
							'wastage_percent'      => $estNonTag->retail_max_wastage_percent, 
							'mc_value'             => ($estNonTag->mc_value!='' ? $estNonTag->mc_value:NULL),
							'item_cost'            => $estNonTag->sales_value,
							'is_non_tag'           => 1,
							'item_total_tax'       => $estNonTag->tax_price,
							'market_rate_cost'     => $estNonTag->market_sales_value,
							'market_rate_tax'      => $estNonTag->market_tax_price
						); 
						if(!empty($arrayestNonTag))
						{
							$tagInsert = $this->$model->insertData($arrayestNonTag,'ret_estimation_items');
							if($estNonTag->stone_details)
							{
								foreach($estNonTag->stone_details as $stone)
								{
									$stone_data = array(
													'est_id'        =>$insId,
													'est_item_id'   =>$tagInsert,
													'pieces'        =>$stone->stone_pcs,
													'wt'            =>$stone->stone_wt,
													'stone_id'      =>$stone->stone_id,
													'price'         =>$stone->stone_price
												  );
									$stoneInsert = $this->$model->insertData($stone_data,'ret_estimation_item_stones');
								}										
							}
						}
					}
				}
				// Home Bill
				if($addData['is_home_bill']  && sizeof($addData['home_bill']) > 0){
					$arrayhome_bill = array();
					foreach($addData['home_bill'] as $home_bill)
					{
						$arrayhome_bill = array(
							'esti_id'               => $insId, 
							'item_type'             => 2,
							'design_id'            	=> $home_bill->design_id, 
							'product_id'            => $home_bill->pro_id, 
							'tag_id'                =>($home_bill->tag_id!='' ? $home_bill->tag_id:NULL),
							'purity'                =>($home_bill->purity!='' ? $home_bill->purity:NULL),
							'size'                  =>($home_bill->size!='' ? $home_bill->size:NULL), 
							'piece'                 =>($home_bill->piece!='' ?$home_bill->piece:NULL), 
							'less_wt'               =>($home_bill->less_wt!=''?$home_bill->less_wt:NULL),
							'net_wt'                => $home_bill->net_wt, 
							'mc_type'               =>($home_bill->mc_type!='' ?  $home_bill->mc_type:1),
							'gross_wt'              => $home_bill->gross_wt, 
							'calculation_based_on'  =>($home_bill->calculation_based_on!='' ? $home_bill->calculation_based_on:NULL), 
							'wastage_percent'       => $home_bill->retail_max_wastage_percent, 
							'mc_value'              =>($home_bill->mc_value!='' ? $home_bill->mc_value:NULL),
							'item_cost'             => $home_bill->sales_value,
							'item_total_tax'      	=> $home_bill->tax_price,
							'market_rate_cost'      => $home_bill->market_sales_value,
							'market_rate_tax'       => $home_bill->market_tax_price,
						); 
						if(!empty($arrayhome_bill))
						{
							$tagInsert = $this->$model->insertData($arrayhome_bill,'ret_estimation_items'); 
							if($home_bill->stone_details)
							{
								foreach($home_bill->stone_details as $stone)
								{
									$stone_data = array(
										'est_id'        =>$insId,
										'est_item_id'   =>$tagInsert,
										'pieces'        =>$stone->stone_pcs,
										'wt'            =>$stone->stone_wt,
										'stone_id'      =>$stone->stone_id,
										'price'         =>$stone->stone_price
									);
									$stoneInsert = $this->$model->insertData($stone_data,'ret_estimation_item_stones');
								}										
							}
						}
					}
				}
				// Old Metal
				if($addData['is_old_metal'] && sizeof($addData['old_metal']) > 0){
					$arrayOldMatel = array();
					foreach($addData['old_metal'] as $oldMetal)
					{
						$arrayOldMatel = array(
							'est_id'            => $insId, 
							'id_category'       => $oldMetal->id_category, 
							'purpose'           => $oldMetal->id_purpose, 
							'gross_wt'          => $oldMetal->gross_wt, 
							'dust_wt'           => (!empty($oldMetal->dust_wt)? $oldMetal->dust_wt:NULL),
							'stone_wt'          => (!empty($oldMetal->stone_wt) ? $oldMetal->stone_wt:NULL),
							'net_wt'            => $oldMetal->net_wt,
							'wastage_percent'   => $oldMetal->wastage, 
							'wastage_wt'   		=> $oldMetal->wastage_wt, 
							'rate_per_gram'     => $oldMetal->rate, 
							'amount'            => $oldMetal->amount
						); 
						if(!empty($arrayOldMatel))
						{
							$tagInsert = $this->$model->insertData($arrayOldMatel,'ret_estimation_old_metal_sale_details'); 
							if($oldMetal->stone_details)
							{
								foreach($oldMetal->stone_details as $stone)
								{
									$stone_data = array(
											'est_id'                =>$insId,
											'est_old_metal_sale_id' =>$tagInsert,
											'pieces'                =>$stone->stone_pcs,
											'wt'                    =>$stone->stone_wt,
											'stone_id'              =>$stone->stone_id,
											'price'                 =>$stone->stone_price
										);
									$stoneInsert = $this->$model->insertData($stone_data,'ret_esti_old_metal_stone_details');
								}									
							}
						}
					}
				}				
			}
			if($this->db->trans_status()===TRUE)
			{
				$this->db->trans_commit();
				$log_data = array(
	                'id_log'        => $addData['id_log'],
	                'event_date'    => date("Y-m-d H:i:s"),
	                'module'        => 'Estimation',
	                'operation'     => 'Add',
	                'record'        =>  $insId,  
	                'remark'        => 'Record added successfully'
                );
                //$log = $this->log_model->log("insert","",$log_data);
				$return_data = array('msg'=>'Estimation No '.$esti_no.' created successfully','status'=>true,'type'=>1,'id'=>$insId); 
			}
			else
			{
				$this->db->trans_rollback();
				$return_data = array('msg'=>'Unable to proceed the requested process','status'=>false,'type'=>1,'id'=>'');
			} 
			echo json_encode($return_data);
		}else{ 
			$return_data = array('msg'=>'Kindly update Day closing data to add estimation','status'=>false,'type'=>1,'id'=>'');
			echo json_encode($return_data);
		}  
				
	 }
	 
	/* End of Estimation functions */














	//join scheme

	function createAccount_post()
	{
		$model = "mobileapi_model";
		$this->load->model($model);
		$data = $this->get_values();
    	$flag = FALSE;
		$scheme_acc_number  ='';
		$result ='';
		$is_referral_by = NULL;
        /*$cus = $this->$model->get_customerByID($data['id_customer']);
        $settings = $this->$model->is_branchwise_cus_reg();

			if($settings['branch_settings']==1)
			{
				if($settings['is_branchwise_cus_reg']==1)
				{
					$id_branch  = $cus['id_branch'];

				}
				else if($settings['branchWiseLogin']==1)
				{
					$id_branch=$this->config->item('pay_branchId');
				}
				else
				{
					$id_branch  = (isset($data['id_branch'])?$data['id_branch']:NULL);
				}

			}
		else{
			$id_branch =NULL;
		}*/
        $id_branch  = (isset($data['id_branch'])?$data['id_branch']:NULL);
		$schAcc = array(
						 'id_customer'       => $data['id_customer'],
						 'id_scheme'         => $data['id_scheme'],
						 'start_date'        => date('Y-m-d H:i:s'),
						 'group_code'        => $data['group_code'],
						 'scheme_acc_number' =>	($data['is_new'] == 'N' ? $data['scheme_acc_number'] : NULL),
						 'account_name'      => ucwords($data['account_name']),
						 'is_new'		     => $data['is_new'],
						 'active'            => 1,
						 'date_add'          => date('Y-m-d H:i:s'),
						 'added_by' 		 => 2,
						 'id_branch'         => $id_branch,
						// "is_referral_by" 	 => $is_referral_by,
						 'referal_code' 	 => (isset($data['referal_code'])?$data['referal_code']:NULL),
						 'pan_no'		     => ($data['pan_no'] != null ? strtoupper($data['pan_no']): NULL)
						);

		if(isset($data['is_new']) &&  $data['is_new'] =='N')
		{
			if($data['regExistingReqOtp'] == 0){
				$schAcc['id_scheme_group'] = (!empty($data['id_scheme_group'])?$data['id_scheme_group']:'');
				$isAccNoExist = $this->scheme_modal->verify_existing($schAcc);
				if(!$isAccNoExist)
				{
					$scheme_acc  = array("id_scheme" => ($data['id_scheme']!=''?$data['id_scheme']:0),
					                	"id_customer" =>  $data['id_customer'],
					                	"scheme_acc_number" => ($data['scheme_acc_number']!=''? $data['scheme_acc_number']:NULL),
					                	"ac_name" => ($data['account_name']!=''?$data['account_name']:NULL),
										 "id_branch" => $id_branch,
					                	"id_employee" => NULL,
					                	'added_by' 		 => 2,
					                	"date_add" => date('Y-m-d H:i:s'),
					                	"id_scheme_group" => (isset($data['id_scheme_group'])?$data['id_scheme_group']:NULL),
					                	'pan_no'		     => ($data['pan_no'] != null ? strtoupper($data['pan_no']): NULL),
					                	"status" => 0 // processing
					             	);
				  $status =	$this->scheme_modal->join_existing($scheme_acc);
				  if($status['status'])
				  {
				  	$result = array( "status" =>TRUE, "msg" => 'Kindly wait for your scheme activation, once activated you will be notified');
				  }
				  else
				  {
				  	$result = array( "status" =>FALSE, "msg" => 'Unable to proceed your request..');
				  }
				}
				else
				{
					if($isAccNoExist['table'] == 'scheme_account'){
						$msg = 'Your account already exist, Please contact customer care to proceed your request';
					}else{
						$msg = 'You have already sent request for this account... Please wait until we verify your account. Check dashboard for status.';
					}
					$result = array( "status" =>FALSE, "msg" => $msg);
				}
			}else{
				$result = $this->join_existing_byacc($schAcc);
			}
			$this->response($result,200);

		}else{ // New account joining
            $this->db->trans_begin();

            if($data['referal_code']!='')
			{

				if($data['referal_code']!= $data['mobile'])
				{
					$referral = $this->scheme_modal->checkreferral_code($data['referal_code'],$data['id_customer']);

					if($referral['status'] == false)
					{
						$this->db->trans_rollback();
						$result =array('status'=>FALSE,'msg'=> $referral['msg']);
						$this->response($result,200);
					}
					else
					{
						$is_referral_by = (strtoupper($referral['is_referral_by']) == 'CUS' ? 0 :(strtoupper($referral['is_referral_by']) == 'EMP'?1:NULL));
					}
				}
				else
				{
					$result =array('status'=>FALSE,'msg'=>'Invalid Referral code');
						$this->response($result,200);
				}

			}

            $schAcc['is_refferal_by'] = $is_referral_by;
            $status = $this->$model->insert_schemeAcc($schAcc);
            $flash_msg = '';



            if($status['sch_data']['free_payment'] == 1)
            {
                $pay_insert_data = $this->mobileapi_model->free_payment_data($status['sch_data'],$status['insertID']);
                if($status['sch_data']['receipt_no_set'] == 1){
                    $pay_insert_data['receipt_no'] = $this->generate_receipt_no();
                }

                $pay_add_status = $this->payment_modal->addPayment($pay_insert_data);
                $flash_msg = 'As Free Installment offer, 1st installment of your scheme credited successfully. Kindly pay your 2nd installment';

                $scheme_acc_no=$this->$model->accno_generatorset();
                if($scheme_acc_no['status']==1 && $scheme_acc_no['schemeacc_no_set']==0)
                {
                      $scheme_acc_number=$this->$model->account_number_generator($schAcc['id_scheme']);
                    if($scheme_acc_number!=NULL)
                    {
                        $updateData['scheme_acc_number']=$scheme_acc_number;
                    }
                    $updSchAc = $this->$model->update_account($updateData,$status['insertID']);
                }
            }


            if($this->db->trans_status()===TRUE)
            {
                $this->db->trans_commit();
                $schData1 = $this->$model->get_schemeaccount_detail($status['insertID']);
                $this->load->model("scheme_modal");
                $schData = $this->scheme_modal->getJoinedScheme($status['insertID']);

                $serviceID = 2;
                $service = $this->services_model->checkService($serviceID);

                $company = $this->$model->company_details();

                if($service['sms'] == 1)
                {
                    $id=$status['insertID'];
                    $data =$this->services_model->get_SMS_data($serviceID,$id);
                    $mobile =$data['mobile'];
                    $message = $data['message'];
                    if($this->config->item('sms_gateway') == '1'){
					    $this->sms_model->sendSMS_MSG91($mobile,$message);
	        		}
	        		elseif($this->config->item('sms_gateway') == '2'){
	        	        $this->sms_model->sendSMS_Nettyfish($mobile,$message,'trans');
	        		}
				}
				if($service['serv_whatsapp'] == 1){
            	    $this->services_model->send_whatsApp_message($mobile,$message);
                }

                if($service['email'] == 1 && isset($schData[0]['email']) && $schData[0]['email'] != '')
                {
                    $data['schData'] = $schData[0];
                    $data['company'] =$company;
                    $data['type'] = 1;
                    $to = $schData[0]['email'];
                    $subject = "Reg.  ".$this->comp['company_name']." scheme joining";
                    $message = $this->load->view('include/emailScheme',$data,true);
                    $sendEmail = $this->email_model->send_email($to,$subject,$message);
                }

                $result = array('status'=> TRUE, 'msg'=>'Saving Scheme added to your account.','chit' =>$schData1[0],'free_pay' =>$flash_msg);
            }
            else{
                $this->db->trans_rollback();
                $result = array( "status" =>FALSE, "msg" => "Unable to proceed your request");
            }
        }


		$this->response($result,200);
	}

	function wallet_account_create($cus_id,$mobile)
	{
	$this->load->model('services_model');
	$this->load->model('email_model');
	$model = self::ADM_MODEL;
	$wallet_acc_no =  $this->services_model->get_wallet_acc_number();
	$insertData=array(
				   'id_customer' 	   => (isset($cus_id) && $cus_id!=''? $cus_id:NULL),
				   'id_employee' 	   =>  2,
				   'wallet_acc_number' => (isset($wallet_acc_no)?$wallet_acc_no:NULL),
				   'issued_date' 	   => date('y-m-d H:i:s'),
				   'remark' 		    => "Credits",
				   'active'		        => 1
				   );
		   //inserting data
		   $status = $this->services_model->walletacc_insert($insertData);
		   $wallAcc = $this->services_model->get_walletacc($status['insertID']);
		   //$this->$model->insChitwallet($status['insertID'],$mobile,$cus_id);
		   if($status)
			{
				 $serviceID = 8;
				 $service =  $this->services_model->checkService($serviceID);
				 $id =$status['insertID'];
						$data =$this->services_model->get_SMS_data($serviceID,$status['insertID']);
						$mobile =$data['mobile'];
						$message = $data['message'];
					if($service['sms'] == 1)
					{
						if($this->config->item('sms_gateway') == '1'){
                		    $this->sms_model->sendSMS_MSG91($mobile,$message);
                		}
                		elseif($this->config->item('sms_gateway') == '2'){
                	        $this->sms_model->sendSMS_Nettyfish($mobile,$message,'trans');
                		}
					}
					if($service['serv_whatsapp'] == 1){
                	  $this->services_model->send_whatsApp_message($mobile,$message);
                    }
			}
	}


	//to get customer data
	function customerSchemes_post()
	{
		$data = $this->get_values();
		$model = self::ADM_MODEL;
		$result['cusSchemes'] = array();
		$result['isValid'] = FALSE;
		$res = $this->$model->get_customerByMobile($data['cusmobile'],$data['emp_branch'],$data['branch_settings']);
		$result['customer'] = $res;
		if(sizeof($res)>0){
			$result['isValid'] = TRUE;
			$schemeAcc = $this->$model->get_payment_details($res['id_customer'],$res['id_branch']);
			$result['cusSchemes'] = $this->array_sort($schemeAcc['chits'], 'allow_pay',SORT_DESC);
		}
		$this->response($result,200);
	}

	//to get customer data
	function getCusByMobile_post()
	{
		$data = $this->get_values();
		$res = array();
		$model = self::ADM_MODEL;
		$res['cus'] = $this->$model->cusByMobileBranchWise($data['cusmobile'],$data['emp_branch'],$data['branch_settings']);
		if(!empty($res['cus'])){
			$res['status']= TRUE;
		}else{
			$res['status']= FALSE;
		}
		$this->response($res,200);
	}

	function getScheme_get()
	{
		$show_referral=true;
		$model = self::ADM_MODEL;
		$scheme = $this->$model->get_scheme($this->get('id_scheme'),$this->get('id_customer'));
		$cus_single=$scheme['cusbenefitscrt_type'];
		$emp_single=$scheme['empbenefitscrt_type'];
		$cus_ref_code=$scheme['cus_ref_code'];
		$emp_ref_code=$scheme['emp_ref_code'];

		if($cus_single==0 && $emp_single==0)
		{
			if($cus_ref_code!='' && $emp_ref_code!='')
			{

				$show_referral=false;
			}
			else if($cus_ref_code=='' && $emp_ref_code=='')
			{

				$show_referral=true;
			}
			else if($cus_ref_code!='' || $emp_ref_code!='')
			{
				$show_referral=true;
			}
			else{
				return $show_referral;
			}
		}


		$groups = $this->scheme_modal->get_groups($this->get('id_scheme'));
		$allow_unpaid =$this->scheme_modal->allowUnpaid();	//allow customer not paid single installment
		$allow_multiple = $this->scheme_modal->allowMultipleChits(); //allow multiple chits for customer

		$allowNewsch = $this->scheme_modal->allowNewscheme_join(); //allow New scheme join to customer
		$unpaid = $this->scheme_modal->check_unpaid_schemes($this->get('id_customer'));
		$unClosedAcc = $this->scheme_modal->hasUnclosedAccounts($this->get('id_customer'));
		$result ='';
		if($allowNewsch == TRUE){
			if($allow_multiple == TRUE )
			{
				if($allow_unpaid == TRUE)
				{
					$allow_join = array('status'=> TRUE);
				}
				else
				{
					if($unpaid == TRUE)
					{
						$allow_join = array('status'=> FALSE, 'msg' => 'You can\'t join now, as you have scheme accounts without single payment, make payments for unpaid before joining new scheme' );
					}
					else
					{
						$allow_join = array('status'=> TRUE);
					}
				}
			}
			else
			{
				if($unClosedAcc == TRUE)
				{
					$allow_join = array('status'=> FALSE, 'msg' => 'You have unclosed chits, kindly contact customer care and close to join new scheme.' );
				}
				else
				{
					$allow_join = array('status'=> TRUE);
				}
			}
			$allow_join = array('status'=> TRUE);

		}else
		{
			$allow_join = array('status'=> FALSE, 'msg' => 'Kindly visit our showroom for new scheme enrollment....' );
		}

		$weights = array();
		$weights_data = $this->$model->get_weights();

		foreach($weights_data as $weight)
		{
			$weights[]=array(
								'weight'    => $weight['weight']
							);
		}
		$result = array('scheme' => $scheme,'show_referral' => $show_referral,'allow_join' => $allow_join,'weights' => $weights,'groups'=>$groups);
		$this->response($result,200);
	}

	function paymentHistory_get()
	{
		$model = self::ADM_MODEL;
		$payments = $this->$model->get_paymenthistory($this->get('mobile'),$this->get('id_employee'));
		$this->response($payments,200);
	}


	// branch name list
	public function get_branch_get()
	{
		$model = self::ADM_MODEL;
		$data=$this->$model->get_branch($this->get('emp_branch'),$this->get('id_profile'));
	    echo json_encode($data);
	}





}
?>
