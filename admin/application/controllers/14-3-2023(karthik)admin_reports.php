<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_reports extends CI_Controller
{
	const PAY_MODEL	="payment_model";
	const DAS_MODEL	="dashboard_model";
	const ACC_MODEL	="account_model";
	const LOG_MODEL	="log_model";
	const MAIL_MODEL = "email_model";
    const ADM_MODEL = "chitadmin_model";  
	const SMS_MODEL = "admin_usersms_model";
	const SET_MODEL	="admin_settings_model"; 
	const REP_VIEW	="reports/";
	const LOG_VIEW	="log/";
	function __construct()
	{
		parent::__construct();  
		ini_set('date.timezone', 'Asia/Calcutta');
		$this->load->model(self::PAY_MODEL);
		$this->load->model(self::LOG_MODEL);
		$this->load->model(self::ACC_MODEL);
		$this->load->model(self::DAS_MODEL);
		$this->load->model(self::MAIL_MODEL);
		$this->load->model(self::SET_MODEL);
		$this->load->model(self::ADM_MODEL);
		$this->load->model(self::SMS_MODEL);
		$this->load->model("admin_report_model");
		$this->load->model('sms_model');
		if(!$this->session->userdata('is_logged'))
		{
			redirect('admin/login');
		}
	  $this->branch_settings =  $this->session->userdata('branch_settings');
	}	
	//payment status 0 -> pending, 1 -> success, 2 -> rejected, -1 -> failure
	function payment_due_list()
	{
		$model=	self::PAY_MODEL;
		$data['accounts']=$this->$model->get_payment_dues_details();			
		$data['main_content'] = self::REP_VIEW.'payment_due';
        $this->load->view('layout/template', $data);
	}
	function payment_details()
	{
		$model=	self::PAY_MODEL;
		//$data['accounts']=$this->$model->get_payment_report();			
	    $data['main_content'] = self::REP_VIEW.'payment_report';
        $this->load->view('layout/template', $data);
	}
	function ajax_customer_payment_details()
	{
		$id_branch=$this->input->post('id_branch');
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$model=	self::PAY_MODEL;
		//print_r($id_branch);exit;
		$data['accounts']=$this->$model->get_payment_report($id_branch);			
	    echo json_encode($data);
	}
	function payment_employee_wise()
	{
		$model=	self::PAY_MODEL;
		$data['accounts']=$this->$model->get_payment_employee();			
	    $data['main_content'] = self::REP_VIEW.'employee_report';
	    //echo "<pre>"; print_r($data);exit; echo "<pre>";
         $this->load->view('layout/template', $data);		
	}
	function payment_employee()
	{
			$model=	self::PAY_MODEL;
			$id_branch=$this->input->post('id_branch');
			$data['employee']=$this->$model->get_employee_name($id_branch);
			echo json_encode($data);
	}
	function ajax_payment_list()
	{
			$id_emp=$this->input->post('id_emp');
		   $from_date=$this->input->post('from_date');
		   $to_date=$this->input->post('to_date');
			$id_branch=$this->input->post('id_branch');
	        $model=	self::PAY_MODEL;
	        $data['payments']=$this->$model->get_payment_list($from_date,$to_date,$id_branch,$id_emp); //hh
	        echo json_encode($data);
	}
	function payment_schemewise()
	{
		$model=	self::PAY_MODEL;
		//$data['payments']=$this->$model->total_paid_unpaid();
	    $data['main_content'] = self::REP_VIEW.'payment_schemewise';
        $this->load->view('layout/template', $data);
	}
	function payment_schemewise_detail()
	{
		$id_branch=$this->input->post('id_branch');
		$from = date('Y-m-d',strtotime($this->input->post('from_date')));
	    $to = date('Y-m-d',strtotime($this->input->post('to_date')));
		$model=	self::PAY_MODEL;
		$data['payments']=$this->$model->total_paid_unpaid($from,$to,$id_branch);	
		echo json_encode($data);
	}
/* Coded by ARVK */	
	function payment_datewise()
	{
		$model=	self::PAY_MODEL;
		$payments = $this->$model->payment_datewise(date('Y-m-d'));
		$data['payments'] = $payments['collection_report'];
		$data['opening_balance'] = ($payments['collection_total']?$payments['collection_total']:0.00);
	    $data['main_content'] = self::REP_VIEW.'payment_date_wise';
        //echo "<pre>";print_r($data);echo "</pre>";
		$this->load->view('layout/template', $data);
	}
	function payment_datewise_ajax()
	{
		$model=	self::PAY_MODEL;
		$date = date('Y-m-d',strtotime(str_replace("/","-",$this->input->post('date'))));
	    //echo "<pre>";print_r($date);echo "</pre>";
		$payments = $this->$model->payment_datewise($date);
	    $data['payments'] = $payments['collection_report'];
		$data['opening_balance'] = ($payments['collection_total']?$payments['collection_total']:0.00);
	    echo json_encode($data);
	}
/* / Coded by ARVK */
	function accounts_schemewise()
	{
		$model=	self::DAS_MODEL;
		$this->load->model($model);
		//$data['accounts']=$this->$model->schemewise_accounts();			
	    $data['main_content'] = self::REP_VIEW.'accounts_schemewise';
        $this->load->view('layout/template', $data);
	}
	function accounts_schemewise_detail()
	{
			$id_branch=$this->input->post('id_branch');
		$model=	self::DAS_MODEL;
		$this->load->model($model);
		$data['accounts']=$this->$model->schemewise_accounts($id_branch);	
		echo json_encode($data);		
	}
	function scheme_account_report($id_scheme_account)
	{
		$acc_model=self::ACC_MODEL;
		$pay_model=self::PAY_MODEL;
		$this->load->model($acc_model);
		$this->load->model($pay_model);
		$account['customer'] = $this->$acc_model->get_account_detail($id_scheme_account);
		$account['payment']  = $this->$pay_model->get_account_payment($id_scheme_account);
		$data['account']=$account;
	// echo "<pre>"; print_r($data);exit; echo "<pre>";
		$data['main_content'] = self::REP_VIEW.'payment_accountwise';
        $this->load->view('layout/template', $data);
	}
	function payment_by_range()
	{
		$model=	self::PAY_MODEL;
		$data['accounts']=$this->$model->get_payment_dues_details();			
		$data['main_content'] = self::REP_VIEW.'payment_list';
        $this->load->view('layout/template', $data);
	}
	function failed_payments()
	{
	    $data['main_content'] = self::REP_VIEW.'payment_failures';
        $this->load->view('layout/template', $data);		
	}
	function failed_data()
	{
		$model=	self::PAY_MODEL;	
		$this->load->model($model);
		$data = $this->$model->failed_payments();
		echo json_encode($data);	
	}
	function payment_date_range()
	{ 
	    $from = date('Y-m-d',strtotime($this->input->post('from_date')));
	    $to = date('Y-m-d',strtotime($this->input->post('to_date')));
	    $status = $this->input->post('p_status');
        $mode = $this->input->post('p_mode');
		$model=	self::PAY_MODEL;	
		$this->load->model($model);
		$data = $this->$model->paymentByDateRange($from,$to,$status,$mode);
		echo json_encode($data);		
	}	
	//payment modewise report
	function payment_modewise()
	{
		$model=	self::PAY_MODEL;
		$this->load->model($model);
		$data['modewise']=$this->$model->get_payment_modewise();			
	    $data['main_content'] = self::REP_VIEW.'payment_modewise';
        $this->load->view('layout/template', $data);
	}
	//log report
	function log($type="",$id="")
	{
		$model=self::LOG_MODEL;
		$set=self::SET_MODEL;
		switch($type)
		{
			case 'List':
					    $data['main_content'] = self::LOG_VIEW.'list';
      				    $this->load->view('layout/template', $data);
				break;
			case 'View':
						$data['main_content'] = self::LOG_VIEW.'view_list';
      				    $this->load->view('layout/template', $data);
				break;
			case 'Detail':
							if(!empty($_POST))
							  	{
									$range['from_date']  =date('Y-m-d',strtotime($this->input->post('from_date')));
									$range['to_date']  =date('Y-m-d',strtotime($this->input->post('to_date')));
									$logs 	= $this->$model->get_log_detail_range($range['from_date'],$range['to_date']);
								}
								else
								{
									$logs 	= $this->$model->log_detail('get','','');
								}
							$data	=	array(
											'logs' => $logs
											);
						echo json_encode($data);
					break;
			default:
			$access = $this->$set->get_access('log/list');
				if(!empty($_POST))
					{
						$range['from_date'] = $this->input->post('from_date');
						$range['to_date']   = $this->input->post('to_date');
						$logs 				= $this->$model->get_log_range($range['from_date'],$range['to_date']);
					}
					else
					{
						$logs 	= $this->$model->log('get','','');
					}
				$data	=	array(
								'access' => $access,
								'logs' => $logs
								);
							//	echo $this->db->last_query();
			echo json_encode($data);
			break;
		}
	}
//  new reports   
//   payment_by_daterange
	function payment_by_daterange()
	{
		$data['main_content'] = self::REP_VIEW.'payment_daterange';
        $this->load->view('layout/template', $data);
	}
	
	
    
	function payment_list_daterange()
	{      
	      	$model =	self::PAY_MODEL;
		 	$set_model=self::SET_MODEL;
		  	if(!empty($_POST))
		  	{
				$range['from_date']  = $this->input->post('from_date');
				$range['to_date']  = $this->input->post('to_date');
				$range['type']  = $this->input->post('type');
				$range['limit']  = $this->input->post('limit');
				$range['id']  = $this->input->post('id');
				$range['id_employee']  = $this->input->post('id_employee');
				$range['acc']  = $this->input->post('acc');
				$payment_list=$this->$model->payment_list_daterange($range['from_date'],$range['to_date'],$range['type'],$range['limit'],$range['id'],$range['id_employee'],$range['acc']);		
			
			$data = array();
			$i=1;
			foreach($payment_list as $payment){
			$sgst = sprintf("%.3f",$payment['sgst']);
			$cgst = sprintf("%.3f",$payment['cgst']);
			$total_gst = sprintf("%.3f",$sgst+$cgst);
					if($payment['gst_type']==0 && $payment['gst_setting']==1)
					{					
					 $pay = $payment['payment_amount']-$total_gst;
				    }
				    if($payment['discountAmt']!=0.00)
				    {
				      $pay=$payment['payment_amount']-$payment['discountAmt'];
				    }
				    else
				    {
				         $pay=$payment['payment_amount'];
				    }
		  $data['account'][]= array(
   	          	'id_payment' 			=> (isset($payment['id_payment'])?$payment['id_payment']:0),
   	            'sno' 	=> (isset($i)?$i:0),
   	          	'account_name' 	=> (isset($payment['account_name'])?$payment['account_name']:0),
   	          	'act_amount' 	=> (isset($payment['act_amount'])?$payment['act_amount']:0),
   	          	'name' 	=> (isset($payment['name'])?$payment['name']:null),
   	          	'payment_ref_number' 	=> (isset($payment['payment_ref_number'])?$payment['payment_ref_number']:'-'),
   	          	'id_transaction' 	=> (isset($payment['id_transaction'])?$payment['id_transaction']:'-'),
   	          	'card_no' 	=> (isset($payment['card_no'])?$payment['card_no']:'-'),
   	          	'scheme_acc_number' 	=> (isset($payment['scheme_acc_number'])?$payment['scheme_acc_number']:0),
   	          	'group_code' 	=> (isset($payment['group_code'])?$payment['group_code']:0), 
   	          	'has_lucky_draw' 	=> (isset($payment['has_lucky_draw'])?$payment['has_lucky_draw']:0), 
   	          	'is_lucky_draw' 	=> (isset($payment['is_lucky_draw'])?$payment['is_lucky_draw']:0), 
   	          	'due_type' 	=> (isset($payment['due_type'])?$payment['due_type']:null),
   	          	'code' 	=> (isset($payment['code'])?$payment['code']:0),   	         
   	          	'scheme_type' 	=> (isset($payment['scheme_type'])?$payment['scheme_type']:null),   	          	
   	          	'payment_amount' => (($payment['gst_type']==0 && $payment['gst_setting']==1) ?$pay:$pay),
   	          	'discountAmt' =>    $payment['discountAmt'],
				'amount' => (isset($payment['amount'])?$payment['amount']:0),
   	          	'incentive' 	=> (isset($payment['incentive'])?$payment['incentive']:'-'),
   	          	'metal_rate' 	=> (isset($payment['metal_rate'])?$payment['metal_rate']:0),
   	          	'metal_weight' 	=> (isset($payment['metal_weight'])?$payment['metal_weight']:'-'), 
   	          	'date_payment' 	=> (isset($payment['date_payment'])?$payment['date_payment']:0),
   	          	'emp_code' 	=> (isset($payment['emp_code'])?$payment['emp_code']:0),
   	          	'payment_type' 	=> (isset($payment['payment_type'])?$payment['payment_type']:0),
   	          	'paid_installments' => (isset($payment['paid_installments'])?$payment['paid_installments']:0),
   	          	'gst_type'      => (isset($payment['gst_type'])?$payment['gst_type']:0),
   	          	'gst' 	        => (isset($payment['gst'])?$payment['gst']:0),
   	          	'gst_setting' 	=> (isset($payment['gst_setting'])?$payment['gst_setting']:0),
   	          	'payment_mode' 	=> (isset($payment['payment_mode'])?$payment['payment_mode']:null),
   	          	'bank_name' 	=> (isset($payment['bank_name'])?$payment['bank_name']:0),
   	          	'receipt_no' 	=> (isset($payment['receipt_no'])?$payment['receipt_no']:null),
   	          	'payment_status'=> (isset($payment['payment_status'])?$payment['payment_status']:0),
   	          	'id_status' 	=> (isset($payment['id_status'])?$payment['id_status']:0),
   	          	'status_color' 	=> (isset($payment['status_color'])?$payment['status_color']:0),
   	          	'sgst' 	=> (isset($sgst)?$sgst:0),
   	          	'cgst' 	=> (isset($cgst)?$cgst:0),
   	          	'total_gst' => (isset($total_gst)?$total_gst:0) 
   	          );
		 $i++;
		} 
	 }

	 if(count($data)>0){
		 $data['gst_number']=$payment_list[0]['gst_number'];
		 	echo json_encode($data);}
	 else{  
	 echo json_encode($data);}
	}
// paymode_wise_list
function payment_modewise_data()
{
	    $data['main_content'] = self::REP_VIEW.'payment_modewise_list';
        $this->load->view('layout/template', $data);
}
function payment_modewise_list()
{
	$model=	self::PAY_MODEL;
	$this->load->model($model);	
	if(!empty($_POST))
		  	{
				$range['from_date']  = $this->input->post('from_date');
				$range['to_date']  = $this->input->post('to_date');
				$range['type']  = $this->input->post('type');
				$range['limit']  = $this->input->post('limit');
				$range['id']  = $this->input->post('id');
				$paymodewise=$this->$model->get_modewise_list($range['from_date'],$range['to_date'],$range['type'],$range['limit'],$range['id']);
			$data = array();
			$i=1;
			foreach($paymodewise as $payment){
    			$sgst = sprintf("%.3f",$payment['sgst']);
    			$cgst = sprintf("%.3f",$payment['cgst']);
    			$total_gst = sprintf("%.3f",$sgst+$cgst);
				if($payment['gst_type']==0 && $payment['gst_setting']==1 )
				{					
					 $pay= $payment['payment_amount']-$total_gst;
			    }
    		    $data['account'][]= array(
       	          	'sno' 			 => $i,
       	          	'payment_amount' => (($payment['gst_type']==0 && $payment['gst_setting']==1)?$pay:$payment['payment_amount']),
       	          	'mode_name' 	 => (isset($payment['mode_name'])?$payment['mode_name']:null),   	         
    				'gst_setting' 	 => (isset($payment['gst_setting'])?$payment['gst_setting']:null),
    				'sgst' 	         => (isset($sgst)?$sgst:0),
       	          	'cgst' 			 => (isset($cgst)?$cgst:0),
       	          	'total_gst' 	 => (isset($total_gst)?$total_gst:0),
    			);
    			$i++;
    		} 
	}
	 if(count($data)>0){
		 $data['gst_number']=$paymodewise[0]['gst_number'];
		 	echo json_encode($data);}
	 else{  
	 echo json_encode($data);}
}
// payment_datewise_schemedata
		function payment_datewise_data()
		{
			$data['main_content'] = self::REP_VIEW.'paymentschem_datewise';
			$this->load->view('layout/template', $data);
		}
    function payment_datewise_list()
	{
		$model=	self::PAY_MODEL;
		$date = date('Y-m-d',strtotime(str_replace("/","-",$this->input->post('date'))));		
		$paydatewise = $this->$model->payment_datewise_list($date);
		$data = array();
		foreach($paydatewise as $payment){
			$sgst  = sprintf("%.3f",$payment['sgst']);
			$cgst  = sprintf("%.3f",$payment['cgst']);
			$total_gst = sprintf("%.3f",$sgst+$cgst);
			if($payment['gst_type']==0 && $payment['gst_setting']==1 )
			{					
				 $pay= $payment['payment_amount']-$total_gst;
		    }
			$data['account'][]= array(
   	          	'date_payment' 	=> (isset($payment['date_payment'])?$payment['date_payment']:0),
   	          	'code' 			=> (isset($payment['code'])?$payment['code']:0),
				'payment_mode' 	 => (isset($payment['payment_mode'])?$payment['payment_mode']:null),
				'branch_name' 	 => (isset($payment['name'])?$payment['name']:null),
				'id_transaction' 	 => (isset($payment['id_transaction'])?$payment['id_transaction']:null),
   	          	'receipt' 	=> (isset($payment['receipt'])?$payment['receipt']:0), 
				'payment_amount' => (($payment['gst_type']==0 && $payment['gst_setting']==1)?$pay:$payment['payment_amount']),
				'gst_setting' 	=> (isset($payment['gst_setting'])?$payment['gst_setting']:null),
				'sgst' 	         => (isset($sgst)?$sgst:0),
   	          	'cgst' 			 => (isset($cgst)?$cgst:0),
   	          	'total_gst' 	 => (isset($total_gst)?$total_gst:0));
				} 
		//echo "<pre>";print_r($data);echo "</pre>";exit;
		$data['mode_wise'] = $this->$model->payment_datewise_by_mode($date);
        if(count($data)>0){
            $data['gst_number']=$paydatewise[0]['gst_number'];
            echo json_encode($data);
        }
        else{  
            echo json_encode($data);
        }
	}
//   paydatewise_schcoll_data
	 function paydatewise_schemecoll_data()
	{
		$data['main_content'] = self::REP_VIEW.'payment_datewise_schcoll';
		$this->load->view('layout/template', $data);
	}
	function paydatewise_schemecoll_list()
	{
		$model=	self::PAY_MODEL;
		$date = date('Y-m-d',strtotime(str_replace("/","-",$this->input->post('date'))));
		$items = $this->$model->paydatewise_schemecoll($date);
		//echo "<pre>";print_r($items);echo "</pre>";exit;		
		$data=array();
		foreach($items as $payment)
		{
				$data['account'][] =array(
						'scheme_name'=>($payment['scheme_name']?$payment['scheme_name']:0.00),
						'branch_name'=>($payment['branch']?$payment['branch']:"-"),
						'group_code'=>($payment['group_code']?$payment['group_code']:0.00),
						'has_lucky_draw'=>($payment['has_lucky_draw']?$payment['has_lucky_draw']:0.00),
						'is_lucky_draw'=>($payment['is_lucky_draw']?$payment['is_lucky_draw']:0.00),
						'opening_bal'=>($payment['opening_bal']?$payment['opening_bal']:0.00),
						'collection'=>($payment['collection']?$payment['collection']:0.00),
						'incentive'=>($payment['incentive']?$payment['incentive']:0.00),
						'paid' =>  ($payment['paid']?$payment['paid']:0),
						'cancel_payment'=>($payment['cancel_payment']?$payment['cancel_payment']:0),
						'charge'=>($payment['charge']?$payment['charge']:0.00),
						'closing_balance'=>($payment['closing_balance']?$payment['closing_balance']:0.00),	
						'gst_setting'=>($payment['gst_setting']?$payment['gst_setting']:0.00)	
				);
		}
//echo "<pre>";print_r($data);echo "</pre>";exit;			
	 if(count($data)>0){
		 $data['gst_number']=$items[0]['gst_number'];
		 	echo json_encode($data);}
	 else{  
	 echo json_encode($data);}
	}
	// payment outstanding 
	function payment_outstanding()
	{
		$data['main_content'] = self::REP_VIEW.'payment_outstanding';
        $this->load->view('layout/template', $data);
	}
	function payment_outstanding_list()
	{      
	      	$model =	self::PAY_MODEL;
		 	$set_model=self::SET_MODEL;
		  	if(!empty($_POST))
		  	{
				$date = date('Y-m-d',strtotime(str_replace("/","-",$this->input->post('date'))));
				$payment_list=$this->$model->payment_outlist($date);
				//echo "<pre>";print_r($payment_list);echo "</pre>";exit;
			$data = array();	
			$i=1;
			foreach($payment_list as $payment){
					$due_count = $payment['total_installments']- $payment['paid_installments'];
		  $data['account'][]= array(
   	            'sno' 	=> (isset($i)?$i:0),
   	          	'code' 	=> (isset($payment['code'])?$payment['code']:0),
   	          	'group_code' 	=> (isset($payment['group_code'])?$payment['group_code']:0),
   	          	'is_lucky_draw' 	=> (isset($payment['is_lucky_draw'])?$payment['is_lucky_draw']:0),
   	          	'has_lucky_draw' 	=> (isset($payment['has_lucky_draw'])?$payment['has_lucky_draw']:0),
   	          	'scheme_acc_number' 	=> (isset($payment['scheme_acc_number'])?$payment['scheme_acc_number']:0),
   	          	'name' 	=> (isset($payment['name'])?$payment['name']:null),
   	          	'total_installments'=> (isset($payment['total_installments'])?$payment['total_installments']:null),
   	          	'paid_installments'=> (isset($payment['paid_installments'])?$payment['paid_installments']:null),
   	          	'total_paid_amount'=> (isset($payment['total_paid_amount'])?$payment['total_paid_amount']:0.00),
   	          	'total_paid_weight'=> (isset($payment['total_paid_weight'])?$payment['total_paid_weight']:0.00),
   	          	'amount' 	     => (isset($payment['amount'])?$payment['amount']:0),
   	          	'joined_date' => (isset($payment['joined_date'])?$payment['joined_date']:null),
				'due_count' => (isset($due_count)?$due_count :0),
   	          	'mobile' 	=> (isset($payment['mobile'])?$payment['mobile']:0),
   	          	'last_paid_date' 	=> (isset($payment['last_paid_date'])?$payment['last_paid_date']:0),
   	          	'gst_setting' 	=> (isset($payment['gst_setting'])?$payment['gst_setting']:0)
   	          );
		 $i++;
		} 
	 }
	//echo "<pre>";print_r($data);echo "</pre>";exit;
	 if(count($data)>0){
		 $data['gst_number']=$payment_list[0]['gst_number'];
		 	echo json_encode($data);}
	 else{  
	 echo json_encode($data);}
	}
	//refferal report
	function employee_ref_success()
	{	
		$model=	self::PAY_MODEL;		
		$data['main_content'] = self::REP_VIEW.'employee_ref_success';
        $this->load->view('layout/template', $data);
	}
function employee_ref_success_list($id="")
	{
		$model=	self::PAY_MODEL;
				if(!empty($_POST))
			  	{
					$range['from_date']  = $this->input->post('from_date');
					$range['to_date']  = $this->input->post('to_date');
					$data['accounts']=$this->$model->get_empreff_report_by_range($range['from_date'],$range['to_date'],'');
				}
				else
				{
					$data['accounts']=$this->$model->get_empreff_report();	 
				}
	    echo json_encode($data);		
	}  
	 /*function emp_referral_account($id_employee)
	{
		$acc_model=self::ACC_MODEL;
		$pay_model=self::PAY_MODEL;
		$data['accounts']  = $this->$pay_model->empreferral_account($id_employee);
		$data['main_content'] = self::REP_VIEW.'refferal_report';
        $this->load->view('layout/template', $data);
	} */
	function emp_referral_account($referal_code)
	{
		$acc_model=self::ACC_MODEL;
		$pay_model=self::PAY_MODEL; 
		$data['accounts']  = $this->$pay_model->empreferral_account($referal_code);
		$data['main_content'] = self::REP_VIEW.'refferal_report';
        $this->load->view('layout/template', $data);
	}
	//emp_reff_end
	//cus_reff_begin
	function cus_ref_success()
	{	
		$model=	self::PAY_MODEL;
		$data['main_content'] = self::REP_VIEW.'cus_reff_report';
        $this->load->view('layout/template', $data);
	}
	function cus_ref_success_list()
	{	
		$model=	self::PAY_MODEL;
		if(!empty($_POST))
			  	{
					$range['from_date']  = $this->input->post('from_date');
					$range['to_date']  = $this->input->post('to_date');
				   $data['accounts']=$this->$model->get_cusreff_report_by_range($range['from_date'],$range['to_date']);
				}
				else
				{
					$data['accounts']=$this->$model->get_cus_ref_success();	 
				}
	    echo json_encode($data);
	}
	function cus_refferl_account($mobile)
	{
		$acc_model=self::ACC_MODEL;
		$pay_model=self::PAY_MODEL;
		$data['accounts']  = $this->$pay_model->cus_refferl_account($mobile);
		$data['main_content'] = self::REP_VIEW.'cus_refferal_report_rec';
        $this->load->view('layout/template', $data);
	}
	function getscheme_name()
	{
		$model=	self::PAY_MODEL;
		$data = $this->$model->get_scheme_list();
		echo json_encode($data);
	}
	// Employee Referral report
	function get_employee_details()
	{ 
		$model=	self::PAY_MODEL;
		$ids=$this->input->post('emp');
		$refrecord=array();
			if(!empty($ids) && count($ids)>0 && $ids!=NULL)
			{
					foreach($ids as $id_employee){
					   $refrecord[]=$this->$model->get_empreport($id_employee);
					}	
			$data['records']= $refrecord;
			$this->load->helper(array('dompdf', 'file'));
	        $dompdf = new DOMPDF();
			$html = $this->load->view('include/report_referral', $data,true);
		    $dompdf->load_html($html); 
			$dompdf->set_paper("a4", "portriat" );
			$dompdf->render();
			$dompdf->stream("referral.pdf",array('Attachment'=>0));
		 }else {
	   	  $this->session->set_flashdata('chit_alert',array('message'=> 'Unable to proceed the requested operation...','class'=>'danger','title'=>'Scheme account number generate'));
	   }
	}
	function customer_enquiry()
	{
	    $data['main_content'] = self::REP_VIEW.'customer_enquiry'; 
        $this->load->view('layout/template', $data); 	
	}
	function ajax_enquiry_list()
	{   
	    $set=self::SET_MODEL;
		if(!empty($_POST))
		{
			$range['from_date']  = $this->input->post('from_date');
			$range['to_date']  = $this->input->post('to_date');
			$range['status']  = $this->input->post('status');
			$range['type']  = $this->input->post('type');
			$data['enquiry']=$this->admin_report_model->get_customerenquiry_by_date($range['from_date'],$range['to_date'],$range['status'],$range['type']);
		}
		else
		{
			$data['enquiry']=$this->admin_report_model->get_customerenquiry(); 
		}
		$data['query'] = $this->db->last_query();
		$data['access'] = $this->$set->get_access('reports/customer_enquiry');
		echo json_encode($data);
	}
 	function enquiry($type="",$id="",$status="")
	{   
		switch($type)
		{
			case 'UpdateStatus':
					$data = $this->admin_report_model->update_enqStatus($_POST); 
			    	echo json_encode($data);
				break;
			case 'View':
			    	$data = $this->admin_report_model->get_custEnqStatus($id); 
			    	echo json_encode($data);
				break;
			default:
			break;
		}
	} 
	function interWalletTrans_list()
	{ 
		$data['main_content'] = self::REP_VIEW.'interWalletTrans';
        $this->load->view('layout/template', $data);		
	}
	/*public function ajax_interWallet_trans()
	{
		$model_name = self::SET_MODEL; 
		if(!empty($_POST))
		{
			$data['trans'] = $this->$model_name->get_interWallet_trans_by_Filter($this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('searchTerm'),$this->input->post('filterBy'));
		}
		else
		{
			$data['trans'] = $this->$model_name->get_interWallet_trans(); 
		}		
		echo json_encode($data);
	}*/
	public function ajax_interWallet_trans()
	{
		$model_name = self::SET_MODEL; 
			$from_date=$this->input->post('from_date');
			$to_date=$this->input->post('to_date');
			$searchTerm=$this->input->post('searchTerm');
			$filterBy=$this->input->post('filterBy');
			$id_branch=$this->input->post('id_branch');
		if($from_date!='' || $to_date!='' || $searchTerm!='' || $filterBy!='' || $id_branch!='')
		{
			$data['trans'] = $this->$model_name->get_interWallet_trans_by_Filter($from_date,$to_date,$searchTerm,$filterBy,$id_branch);
		}
		else
		{
			$id_branch=$this->input->post('id_branch');
			$data['trans'] = $this->$model_name->get_interWallet_trans($id_branch); 
		}		
		echo json_encode($data);
	}
	function cancel_payment()
	{	
		$pay_model=self::PAY_MODEL;
		$txns = $_POST;
		for($i=0 ;$i <sizeof($txns['id_payment']);$i++){
		    $id_payment=$txns['id_payment'][$i];
			 $pay_status_array= array(
	 			       	'payment_status'	=>  4
	 			       );
			$status  = $this->$pay_model->payment_cancel('update',$id_payment,$pay_status_array);
			$payment  = $this->$pay_model->paymentDB('get',$id_payment);
    		if($status)
    		{	
    		    if($pay_status_array['payment_status'] == 4){ // Update payment as Canceled in transacition table
			        if($this->config->item('integrationType') == 2){
			            $pay_status_array['id_payment'] = $status['updateID'];
			            $this->load->model('syncapi_model');
			            $this->syncapi_model->updPayStatusInTrans($pay_status_array);
			        }
			    } 
    			$pay_status_array= array(
    	 			       	'id_payment'	=>  (isset($status['updateID'])?$status['updateID']: NULL), 	
    	 			       	'id_status_msg' 	=> 4, 
    	 			       	'charges' 			=>  (isset($payment['payment_amount'])?$payment['payment_amount']:NULL),
    	 			       	'id_employee' 		=>  $this->session->userdata('uid'),
    	 			       	'date_upd'			=>  date('Y-m-d H:i:s')
    	 			       );
    				$status  = $this->$pay_model->payment_statusDB('insert',$id_payment,$pay_status_array);  
    		}
		} 
		echo TRUE;
	}
	public function employee_account()
	{
		$model=	self::ACC_MODEL;
		$data['accounts']=$this->$model->get_all_account();
	    $data['main_content'] = self::REP_VIEW.'employee_account_wise';
	 	//echo "<pre>"; print_r($data);exit;
        $this->load->view('layout/template', $data);
	}
	public function ajax_get_emp_account_list($id="")
	{
		$set_model= self::SET_MODEL;
		$model=	self::PAY_MODEL;
		if(!empty($_POST))
			  	{
					$range['from_date']  = $this->input->post('from_date');
					$range['to_date']  = $this->input->post('to_date');
					$range['id_branch']  = $this->input->post('id_branch');
					$range['id_employee']  = $this->input->post('id_employee');
					$items=$this->$model->get_all_emp_account_by_range($range['from_date'],$range['to_date'],$range['id_branch'],$range['id_employee'],'','');
				}
				echo json_encode($items);
	}
//end of new reports
//Employee wise payment summary
	function employee_wise_summary()
	{
		$model=	self::PAY_MODEL;
	    $data['main_content'] = self::REP_VIEW.'employee_summary';
	    //echo "<pre>"; print_r($data);exit; echo "<pre>";
         $this->load->view('layout/template', $data);		
	}
	function employee_collection()
	{
	    	$model=	self::PAY_MODEL;
	    	$from_date=$this->input->post('from_date');
	    	$to_date=$this->input->post('to_date');
	    	$id_branch=$this->input->post('id_branch');
	    	$id_emp=$this->input->post('id_emp');
	    	$data['payments']=$this->$model->payment_employee_summary($from_date,$to_date,$id_branch,$id_emp);
	       echo json_encode($data);
	   //  echo"<pre>";	print_r($data);exit;
	}
//Employee wise payment summary
//mob no,ref no,clientid,sch A/c no wise filter & change options in inter table Data's // 
// Customer Reg& transaction records  // HH		
	public function inter_table()
	{
		$model=	self::PAY_MODEL;
	    $data['main_content'] = self::REP_VIEW.'inter_table_rep/inter_table';
	 	//print_r($data);exit;
        $this->load->view('layout/template', $data);
	}
	function intertable_list()
	{
		$model =	self::PAY_MODEL;
		$range['cus']  = $this->input->post('cus');
		$mobile=$_POST['mobile'];	
	    $clientid=$_POST['clientid'];
	    $ref_no=$_POST['ref_no'];
	    $group_code=$_POST['group_code'];
	 // $scheme_ac_no=$_POST['scheme_ac_no'];
		$data = $this->$model->get_intertable_list($mobile,$clientid,$ref_no,$group_code,$range['cus']);
		echo json_encode($data);
	}
	function intertable_translist()
	{
		  $model =	self::PAY_MODEL;
		  $range['cus']  = $this->input->post('cus');
	      $client_id=$_POST['client_id'];
	      $ref_no=$_POST['ref_no'];
	      $data = $this->$model->get_intertable_translist($client_id,$ref_no,$range['cus']);
	    //echo"<pre>";	print_r($data);exit;
		  echo json_encode($data);
	}
	function update_cusdatas()
	{
		$model = self::PAY_MODEL;
		$postData = $_POST['postData'];
		$res = 0;
		foreach($postData as $data){
            $result = $this->$model->update_cusdata($data['id_customer_reg'],$data['mobile'],$data['scheme_ac_no'],$data['group_code']);
            $this->session->set_flashdata('chit_alert',array('message'=> count($res).' Customer Datas is updated successfully...','class'=>'success','title'=>'Customer Reg'));
			if($result == TRUE){
				$res = $res+1;
			}
			else {
	   	  $this->session->set_flashdata('chit_alert',array('message'=> 'Not Updated Check Your Mobile Number...','class'=>'danger','title'=>'Customer Reg'));
	   }
		}
		echo json_encode($res);
	}	
//mob no,ref no,clientid,sch A/c no wise filter & change options in inter table Data's // 
// Customer Reg& transaction records  // HH	
    /** msg 91 report functions
	 * Reference : https://docs.msg91.com/collection/msg91-api-integration/5/pages/139
	 * 1 - Promotional route , 4 - transactional route
	*/ 
	function msg91_log(){			
		$data['main_content'] = self::REP_VIEW.'msg91_purchase_report';
        $this->load->view('layout/template',$data);
	}
    function getCreditHistory(){
        $authkey = $this->admin_report_model->getmsg91AuthKey();
        if($authkey != NULL){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://control.msg91.com/api/credit_history.php?authkey=".$authkey,
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
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }
        }
    }
    function checkBalance($type){
        $authkey = $this->admin_report_model->getmsg91AuthKey();
        //$type = 1;
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
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }
        }
    }
    function msg91_delivReport($type=""){
        switch($type){
            case 'List' :
        		$data['main_content'] = self::REP_VIEW.'msg91_delivery_report';
                $this->load->view('layout/template',$data);
            break;
            case 'ajax_report' : 
                    $resut = $this->admin_report_model->getmsg91DelivryStat($_POST['from_date'],$_POST['to_date']);
                    echo json_encode($resut);
            break;
        }
	}
    //end of msg91 reports
//Kyc Approval Data status filter with date picker//hh
    	function kycdata_list() 
	{
	   $data['main_content'] = self::REP_VIEW.'kyc_table_data/kyc_data';
        $this->load->view('layout/template', $data); 
	}	
       function kycapproval_data(){
            $model=	self::PAY_MODEL;
            $setmodel=self::SET_MODEL;
		if(!empty($_POST)){
			$range['from_date']  = $this->input->post('from_date');
			$range['to_date']  = $this->input->post('to_date');
			$range['status']  = $this->input->post('status');
			$range['type']  = $this->input->post('type');
            if($range['from_date']!=""){
           	    $data=$this->$model->get_kycdata_range($range['from_date'],$range['to_date'],$range['status'],$range['type']);
            }else{
    			$data=$this->$model->get_kycdata($range['status'],$range['type']);
    			echo json_encode($data);
            }
		}
    }
      function update_kyc()
      {
        $model = self::PAY_MODEL;
        $kycdata   = $this->input->post('kyc_data');
        $kyc_type = $this->input->post('kyc_type');
        $res = 0;
        foreach($kycdata as $data){
            $employee= $this->session->userdata('uid');
            $updatedata = array(  "status"          => $data['status'],
                                  "emp_verified_by" => $employee,
                                  "last_update"     => date('Y-m-d H:i:s'),
                                );
            if($kyc_type == 1)
            {
                    $result = $this->$model->updatekyc($updatedata,$data['id_kyc'],$data['cus']);
                    if($result['verified_kycs']==3){
                      $update = array(  "kyc_status"      =>1,);
                      $result = $this->$model->updatekyccus($update,$data['cus']);
                 	}
                    if($result == TRUE){
                        $res = $res+1;
                    }
            }else if($kyc_type == 2){
                $result = $this->$model->updateAgentkyc($updatedata,$data['id_kyc'],$data['cus']);
                    if($result['verified_kycs']==3){
                      $update = array("kyc_status" =>1,);
                      $result = $this->$model->updatekycAgentStatus($update,$data['cus']);
                 	}
                    if($result == TRUE){
                        $res = $res+1;
                    }
            }
        }
        if($kycdata[0]['status']==3)
        {
           $this->session->set_flashdata('chit_alert',array('message'=> count($res).' KYC records Rejected...','class'=>'danger','title'=>'Kyc Data'));
        }
        else if($kycdata[0]['status']==2){
            $this->session->set_flashdata('chit_alert',array('message'=> count($res).' KYC records Verified successfully...','class'=>'warning','title'=>'Kyc Data'));
        }
        else
        {
            $this->session->set_flashdata('chit_alert',array('message'=> count($res).'KYC records updated successfully...','class'=>'success','title'=>'Kyc Data'));
        }
        echo json_encode($res);
      }
    //Kyc Approval Data status filter with date picker//hh
      //Plan 2 and Plan 3 Scheme Enquiry Data with date picker//hh
    	function sch_enquirt_list() 
	   {
	       $data['main_content'] = self::REP_VIEW.'sch_enquiry_list/sch_enquiry';
           $this->load->view('layout/template', $data); 
	    }	
  	    function schenquiry_list()
	   {
		    $model =	self::PAY_MODEL;
			if(!empty($_POST))
		{
			$range['from_date']  = $this->input->post('from_date');
			$range['to_date']  = $this->input->post('to_date');
	        $data = $this->$model->get_sch_enq_list_by_date($range['from_date'],$range['to_date']);
		}
		else
		{
		     $data = $this->$model->get_sch_enq_list();
		}
		//print_r($data);exit;
		echo json_encode($data);
	}
  //Plan 2 and Plan 3 Scheme Enquiry Data with date picker// 
  //Purchase Payment - Akshaya Thiruthiyai Spl updt//HH
	function get_purchase_payment()
	{
		$data['main_content'] = self::REP_VIEW.'purchase_history';
		$this->load->view('layout/template', $data); 
	}
	public function ajax_get_customers_list()
	{
		$mobile = $this->input->post('mobile');
		$model_name = self::PAY_MODEL;
		$cus_data = $this->$model_name->ajax_get_customers_list($mobile);
		echo json_encode($cus_data);
	}
	function ajax_get_purchase_payment()
	{
		$model=	self::PAY_MODEL; 
		$from_date  = $this->input->post('from_date');
		$to_date     = $this->input->post('to_date');
		$id_purch_customer     = $this->input->post('id_purch_customer');
		$mobile     = $this->input->post('mobile');
		$data = $this->$model->ajax_get_purchase_payment($from_date,$to_date,$id_purch_customer,$mobile);
		echo json_encode($data);
	}
	function generateotp()
	{
		$model 	  =	self::PAY_MODEL;
		$account  = self::ACC_MODEL; 
		$this->comp = $this->$account->company_details(); 
		$mobile     = $this->input->post('mobile');
		$id_purch_customer     = $this->input->post('id_purch_customer'); 
		$chkmobno   = $this->$model->get_purchasecustomer($mobile);
		$mobile		= $chkmobno['mobile'];
		$firstname	= $chkmobno['firstname'];
		$OTP = mt_rand(100000, 999999);
		$this->session->set_userdata('OTP',$OTP);
		$message = "Hi ".$firstname.", OTP for Akshaya Tritiya booking closure is :  ".$OTP."  from ".$this->comp['company_name']."";
		if($this->config->item('sms_gateway') == '1'){
			$sms_data = $this->sms_model->sendSMS_MSG91($mobile,$message,'','');
		}
		elseif($this->config->item('sms_gateway') == '2'){
			$sms_data = $this->sms_model->sendSMS_Nettyfish($mobile,$message,'trans');	
		} 
		$chkmobno = array('result'=>3 ,'msg'=>'"OTP Sent Successfully','otp'=>$OTP);
		echo json_encode($chkmobno); 
	}
	function verify_otp()
	{
		if($this->session->userdata('OTP') == $this->input->post('otp'))
		{
			$data=array('result'=>1 ,'msg'=>'OTP Verified successfully');
		}
		else
		{
			$data=array('result'=>6 ,'msg'=>'Invalid OTP');
		}
		echo json_encode($data);
	} 
	public function purch_delivered()
	{
		$model =	self::PAY_MODEL; 
		$id_purch_payment     = $this->input->post('id_purch_payment');
		$value= $this->$model->get_purchase_pay($id_purch_payment);
		$id_purch_payment = $value['id_purch_payment'];
		if($this->session->userdata('OTP') == $this->input->post('otp'))
		{
			$this->session->unset_userdata('OTP');
			$insArr = array(  
			    "delivery_remark"    => $this->input->post('delivery_remark'),
			   	"is_delivered"	     => 1,
			   	'delivery_verif_otp' => $_POST['otp']
			   ); 
			$status = $this->$model->add_remark($insArr,$value['id_purch_payment']); 
		}
	}
      //otp when purchase the jewel for AT special//
  //Purchase Payment - Akshaya Thiruthiyai Spl updt//
    
    // Payment Online/offline collection // HH
		function payments_on_off_collection_data()
		{

			$data['main_content'] = self::REP_VIEW.'payment_off_on_collection';

			$this->load->view('layout/template', $data);
		}

	
function payments_on_off_collection_list()
	{

		$model=	self::PAY_MODEL;

		$date = date('Y-m-d',strtotime(str_replace("/","-",$this->input->post('date'))));		
		$paydatewise = $this->$model->payments_on_off_collection_list($date);
		$data = array();
		foreach($paydatewise as $payment){
			
			$sgst  = sprintf("%.3f",$payment['sgst']);
			$cgst  = sprintf("%.3f",$payment['cgst']);
			$total_gst = sprintf("%.3f",$sgst+$cgst);
			 
				if($payment['gst_type']==0 && $payment['gst_setting']==1 )
				{					
					 $pay= $payment['payment_amount']-$total_gst;
			    }
			
						
			$data['account'][]= array(
   	          	'date_payment' 	=> (isset($payment['date_payment'])?$payment['date_payment']:0),
   	          	'code' 			=> (isset($payment['code'])?$payment['code']:0),
				'payment_mode' 	 => (isset($payment['payment_mode'])?$payment['payment_mode']:null),
   	          	'receipt' 	=> (isset($payment['receipt'])?$payment['receipt']:0), 
				'payment_amount' => (($payment['gst_type']==0 && $payment['gst_setting']==1)?$pay:$payment['payment_amount']),
				'payment_type' 	 => (isset($payment['payment_type'])?$payment['payment_type']:null),
				'gst_setting' 	=> (isset($payment['gst_setting'])?$payment['gst_setting']:null),
				'sgst' 	         => (isset($sgst)?$sgst:0),
   	          	'cgst' 			 => (isset($cgst)?$cgst:0),
   	          	'total_gst' 	 => (isset($total_gst)?$total_gst:0));
				} 
		//echo "<pre>";print_r($data);echo "</pre>";exit;		
				
        if(count($data)>0){
		 $data['gst_number']=$paydatewise[0]['gst_number'];
		 	echo json_encode($data);}
	 else{  
	 echo json_encode($data);}
	}
	
	 // Payment Online/offline collection //
	 
	  //Autodebit subscription Status Report//HH
    function get_autodebit_subscription()
	{
		$data['main_content'] = self::REP_VIEW.'autodebit_subscription_report';
		$this->load->view('layout/template', $data); 
	}
	
	public function ajax_get_customers_lists()
	{
		$mobile = $this->input->post('mobile');
		$model_name = self::PAY_MODEL;
		$cus_data = $this->$model_name->ajax_get_customers_lists($mobile);
		echo json_encode($cus_data);
	}

	function ajax_get_autodebit_subscription()
	{
		$model=	self::PAY_MODEL; 
		$from_date  = $this->input->post('from_date');
		$to_date     = $this->input->post('to_date');
		$id_customer    = $this->input->post('id_customer');
		$mobile     = $this->input->post('mobile');
		$data = $this->$model->ajax_get_autodebit_subscription($from_date,$to_date,$id_customer,$mobile);
		echo json_encode($data);
	}
	
   //Autodebit subscription Status Report//
   
   
   	//Get Branch wise emp name in Scheme Join Page admin //HH
	function branchwise_employee()
	{
		    $model=	self::PAY_MODEL;
			$set_model= self::SET_MODEL;
	        $data['profile']=$this->session->userdata('profile');
			$branch=$this->session->userdata('id_branch');
		//	print_r($branch);exit;
			$data['employee']=$this->$model->get_branchwise_emp($branch);
			echo json_encode($data);
			
	}
	
	
	
	//Scheme Wise Opening and closing
    function collection_report()
    {
        $data['main_content'] = self::REP_VIEW.'collection_report';
        $this->load->view('layout/template', $data);
    }
    
    function scheme_daily_collection_details()
    {
        $model=	self::PAY_MODEL;
        $from_date=$this->input->post('from_date');
        $to_date=$this->input->post('to_date');
        $id_branch=$this->input->post('id_branch');
        
        $schemes = $this->$model->get_active_scheme();
        
         foreach($schemes as $scheme)
         {
                 $preBlc = $this->$model->getScheme_Opening_blc_details($scheme['id_scheme'],$from_date,$id_branch);
                 
                 if(sizeof($today['collection'])==0)
                 {
                     $op_blc_amt=0;
                     $op_blc_weight=0;
                     $op_blc_bonus=0;
                 }
                 else
                 {
                     //echo "<pre>";print_r($preBlc);exit;
                     $op_blc_amt = $preBlc['collection']['today_collection_amt']+$preBlc['previous_blc']['balance_amount']-$preBlc['closed']['closing_paid_amt']+$preBlc['closed']['closing_add_chgs'];
                     $op_blc_weight=$preBlc['closing_balance_wgt']+$preBlc['collection']['today_collection_wgt']+$preBlc['previous_blc']['balance_weight']-($preBlc['closed']['scheme_type']==2 || $preBlc['closed']['scheme_type']==3 ? $preBlc['closed']['closing_balance']:0);
                     $op_blc_bonus=$preBlc['closing_bonus_amt']+$preBlc['collection']['today_bonus_amt']-$preBlc['closed']['today_bonus_detuction']-$preBlc['closed']['closing_benefits'];
                 }
    	         
    	        $today = $this->$model->get_today_collection_details($from_date,$to_date,$scheme['id_scheme'],$id_branch); 
    	        //echo "<pre>";print_r($today);exit;
                if(sizeof($today['collection'])==0)
                {
                $today['collection']['today_collection_amt'] = 0;
                $today['collection']['today_bonus_amt'] = 0;
                $today['collection']['today_collection_wgt'] = 0;
                }
                
               /* if(sizeof($today['closed'])==0)
                {
                    $today['closed']['today_closing_amount'] = 0;
                    $today['closed']['today_closing_weight'] = 0;
                    $today['closed']['today_bonus_detuction'] = 0;
                }*/
               
                $closing_balance_amt=$op_blc_amt+$today['collection']['today_collection_amt']+$today['previous_blc']['balance_amount']-$today['closed']['closing_paid_amt']+$today['closed']['closing_add_chgs'];
                $closing_balance_wgt=$op_blc_weight+$today['collection']['today_collection_wgt']+$today['previous_blc']['balance_weight']-($today['closed']['scheme_type']==2 || $today['closed']['scheme_type']==3 ? $today['closed']['closing_balance']:0);
                $closing_bonus_amt=$op_blc_bonus+$today['collection']['today_bonus_amt']-$today['closed']['today_bonus_detuction']-$today['closed']['closing_benefits'];
        
    
                $data[]= array(
                'opening_blc_amt' 	    => $op_blc_amt,
                'opening_blc_wgt' 	    => number_format($op_blc_weight,3,'.',''),
                'opening_bonus_amt' 	=> $op_blc_bonus,
                'today_collection_amt' 	=> $today['collection']['today_collection_amt'],
                'today_bonus_amt' 	    => $today['collection']['today_bonus_amt'],
                'today_collection_wgt' 	=> $today['collection']['today_collection_wgt'],
                'today_closed_amount' 	=> number_format($today['closed']['closing_paid_amt'],2,'.',''),
                'today_closed_weight' 	=> number_format(($today['closed']['scheme_type']==2 || $today['closed']['scheme_type']==3 ? $today['closed']['closing_balance']:0),3,'.',''),
                'today_bonus_deduction' => number_format($today['closed']['today_bonus_detuction'],2,'.',''),
                'closing_balance_amt'	=> number_format($closing_balance_amt, 2, '.', ''),
                'closing_balance_wgt'	=> number_format($closing_balance_wgt,3, '.', ''),
                'closing_bonus_amt'	    => number_format($closing_bonus_amt, 2, '.', ''),
                'id_scheme'             => $scheme['id_scheme'],
                'scheme_name'           => $scheme['scheme_name'],
                ); 
    	         
         }
        //echo "<pre>";print_r($data);exit;
        echo json_encode($data);
    }
    //Scheme Wise Opening and closing
    
    
    //closed A/C report with date picker, cost center based branch fillter//HH
	function closed_account_list() 
	{
	  	 $data['main_content'] = self::REP_VIEW.'closed_acc_report' ;
        $this->load->view('layout/template', $data); 
	}	
 
        
    function closedaccount_list()
    {
        $model=	self::ACC_MODEL;
        $model=	self::PAY_MODEL;
        $range['from_date']  = $this->input->post('from_date');
        $range['to_date']  = $this->input->post('to_date');
        $range['id_branch']  = $this->input->post('id_branch');
        $range['id_employee']  = $this->input->post('id_employee');
        $range['close_id_branch']  = $this->input->post('close_id_branch');
        $data = $this->$model->get_all_closed_account_by_date($range['from_date'],$range['to_date'],$range['id_employee'],$range['close_id_branch']);
        echo json_encode($data);
    } 	
   //closed A/C report with date picker, cost center based branch fillter//
   
   function customer_account_details($type="")
    {
        $model=	self::PAY_MODEL;
		switch($type)
		{
			case 'list': 
					$data['main_content'] = self::REP_VIEW.'customer_account_details';
        			$this->load->view('layout/template', $data);
				break;
			case 'ajax': 
			        $from_date=$this->input->post('from_date');
		            $to_date=$this->input->post('to_date');
					$data=$this->$model->get_customer_account_details($from_date,$to_date); 
					echo json_encode($data);
			break;
		}
    }
    
     //Online Payment Report
    function online_payment_report($type="")
	{            
        $data['main_content'] = self::REP_VIEW.'online_payment_report';
        $this->load->view('layout/template', $data);
	}
	function get_online_payment_report()
	{
		$model =	self::PAY_MODEL;
		$range['from_date']=$this->input->post("from_date");
		$range['to_date']=$this->input->post("to_date");
		$list=$this->$model->get_online_payment_report_date($_POST);
		echo json_encode($list);	
	}
	
		function get_payment_status()
	{
	    $model =	self::PAY_MODEL;
		$list=$this->$model->get_payment_status();
		echo json_encode($list);
	}
	
	
	 function old_metal_report($type="")
	{   
		$model=	self::PAY_MODEL;
		switch($type)
		{
			case 'list':
					$data['main_content'] = self::REP_VIEW.'old_metal_report';
        			$this->load->view('layout/template', $data);
			break;
			case 'ajax': 
					$list=$this->$model->get_old_metal_report($_POST); 
				  	$access = $this->admin_settings_model->get_access('reports/old_metal_report');
			        $data = array(
			        					'list'  => $list,
										'access'=> $access
			        				);  
					echo json_encode($data);
				break;
		}
	    
    }  
    
    function payment_cancel_list()
    {
	    $data['main_content'] = self::REP_VIEW.'payment_cancel_report';
        $this->load->view('layout/template', $data);
    }
      
      function paymentcancel_list()

	{      

	    $model =	self::PAY_MODEL;

	   if(!empty($_POST))
		{

				$range['from_date']  = $this->input->post('from_date');

				$range['to_date']  = $this->input->post('to_date');

				$data=$this->$model->paymentcancel_list_range($range['from_date'],$range['to_date']);

			//print_r($data);exit;
		    
		}
		else
		{
		     $data = $this->$model->get_cancel_payment();
		}
		//print_r($data);exit;
		echo json_encode($data);

	}
    
    
    
    	// Scheme source wise report  --- scheme wise payment details report with mode wise + online & showroom collection report
	
	function scheme_payment_daterange()
	{
		$data['main_content'] = self::REP_VIEW.'scheme_payment_daterange';
        $this->load->view('layout/template', $data);
	}
	
	/* function scheme_payment_list_daterange()
    {
        $data=array();
        $model =	self::PAY_MODEL;
        $set_model=self::SET_MODEL;
        if(!empty($_POST))
        {
        $range['from_date']  = $this->input->post('from_date');
        $range['to_date']  = $this->input->post('to_date');
        $range['id_classfication']  = $this->input->post('id_classfication');
        $range['id_scheme']  = $this->input->post('id_scheme');
        $range['pay_mode']  = $this->input->post('pay_mode');
        $range['id_branch']  = $this->input->post('id_branch');
        $range['mode']  = $this->input->post('mode');
        $data['schemes']=$this->$model->sheme_payment_list_daterange($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
        $data['mode_wise']=$this->$model->get_Scheme_Payment_ModeWiseummaryDetails($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
        $data['mode_wise_sum'] = $this->$model->payment_summary_modewise_data($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
        foreach($data[mode_wise_sum]['offline'] as $key=>$value){
            $offline[] = $value['offline_amt'];
        }
        $data['offline_total'] = round(array_sum($offline),2);
        
        foreach($data[mode_wise_sum]['online'] as $key=>$value){
            $online[] = $value['online_amt'];
        }
        $data['online_total'] = round(array_sum($online),2);
            
        }
        echo json_encode($data);
    }
    
    function payment_summary_modewise(){
        
        $model =	self::PAY_MODEL;
        $data=array();
        
       // print_r($_POST);exit;
        if(!empty($_POST))
        {
        $range['from_date']  = $this->input->post('from_date');
        $range['to_date']  = $this->input->post('to_date');
        $range['id_classfication']  = $this->input->post('id_classfication');
        $range['id_scheme']  = $this->input->post('id_scheme');
        $range['pay_mode']  = $this->input->post('pay_mode');
        $range['id_branch']  = $this->input->post('id_branch');
         $range['mode']  = $this->input->post('mode');

        $data['mode_wise'] = $this->$model->payment_summary_modewise_data($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
        foreach($data[mode_wise]['offline'] as $key=>$value){
            $offline[] = $value['offline_amt'];
        }
        $data['offline_total'] = array_sum($offline);
        
        foreach($data[mode_wise]['online'] as $key=>$value){
            $online[] = $value['online_amt'];
        }
        $data['online_total'] = array_sum($online);
   
        }
        
        echo json_encode($data);
    }
    
    	function ajax_getPayModeList()
	{
	    $this->load->model("payment_model");

        $data = $this->payment_model->ajax_getPayModeList();		

        echo json_encode($data);
	} */  
	
	
	
	function scheme_payment_list_daterange()
    {
        $data=array();
        $model =	self::PAY_MODEL;
        $set_model=self::SET_MODEL;
        if(!empty($_POST))
        {
        $range['from_date']  = $this->input->post('from_date');
        $range['to_date']  = $this->input->post('to_date');
        $range['id_classfication']  = $this->input->post('id_classfication');
        $range['id_scheme']  = $this->input->post('id_scheme');
        $range['pay_mode']  = $this->input->post('pay_mode');
        $range['id_branch']  = $this->input->post('id_branch');
        $range['mode']  = $this->input->post('mode');
        $data['schemes']=$this->$model->sheme_payment_list_daterange($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);
		foreach($data['schemes'] as $key=>$value){
            $amount=[];
			$weight=[];
			foreach($value as $key1=>$value1){
				// print_r($value1);exit;
				$amount[] = $value1['amount'];
				$weight[] = $value1['metal_weight'];
			}
			$data['schemes_sum'][$key]['count'] = count($value);
			$data['schemes_sum'][$key]['total_amount'] = round(array_sum($amount),2);
			$data['schemes_sum'][$key]['total_weight'] = round(array_sum($weight),3);
        }		
        
        $data['mode_wise']=$this->$model->get_Scheme_Payment_ModeWiseummaryDetails($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
        $data['mode_wise_sum'] = $this->$model->payment_summary_modewise_data($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
        foreach($data[mode_wise_sum]['offline'] as $key=>$value){
            $offline[] = $value['offline_amt'];
        }
        $data['offline_total'] = round(array_sum($offline),2);
        
        foreach($data[mode_wise_sum]['online'] as $key=>$value){
            $online[] = $value['online_amt'];
        }
        $data['online_total'] = round(array_sum($online),2);
            
        }

        echo json_encode($data);
    }
    
    function payment_summary_modewise(){
        
        $model =	self::PAY_MODEL;
        $data=array();
        
       // print_r($_POST);exit;
        if(!empty($_POST))
        {
        $range['from_date']  = $this->input->post('from_date');
        $range['to_date']  = $this->input->post('to_date');
        $range['id_classfication']  = $this->input->post('id_classfication');
        $range['id_scheme']  = $this->input->post('id_scheme');
        $range['pay_mode']  = $this->input->post('pay_mode');
        $range['id_branch']  = $this->input->post('id_branch');
         $range['mode']  = $this->input->post('mode');

        $data['mode_wise'] = $this->$model->payment_summary_modewise_data($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']);		
        
		$get_count_mode= $this->$model->get_count_mode($range['from_date'],$range['to_date'],$range['id_classfication'],$range['id_scheme'],$range['pay_mode'],$range['id_branch'],$range['mode']); 
       

		foreach($data[mode_wise]['offline'] as $key=>$value){
			$data['mode_summary']['offline'][$value['payment_mode_name']][]=$value;
        }
		foreach($data[mode_wise]['online'] as $key=>$value){
			$data['mode_summary']['online'][$value['payment_mode_name']][]=$value;
        }
		foreach($data[mode_wise]['admin_app'] as $key=>$value){
			$data['mode_summary']['admin_app'][$value['payment_mode_name']][]=$value;
        }

		foreach($get_count_mode as $key=>$value){
			$mode_count[$value['payment_through'].'_count']=$value['payment_count'];
			$mode_count[$value['payment_through'].'_total']=$value['payment_amount'];
        }
		$data['online_count'] = $mode_count['online_count'] != NULL ? $mode_count['online_count'] : 0 ;
		$data['offline_count'] = $mode_count['offline_count'] != NULL ? $mode_count['offline_count'] : 0 ;
		$data['admin_app_count'] = $mode_count['admin_app_count'] != NULL ? $mode_count['admin_app_count'] : 0 ;

		$data['online_total'] = $mode_count['online_total'] != NULL ? $mode_count['online_total'] : 0 ;
		$data['offline_total'] = $mode_count['offline_total'] != NULL ? $mode_count['offline_total'] : 0 ;
		$data['admin_app_total'] = $mode_count['admin_app_total'] != NULL ? $mode_count['admin_app_total'] : 0 ;
        }

        
        echo json_encode($data);
    }
	
	
    
    // Scheme source wise report  --- scheme wise payment details report with mode wise + online & showroom collection report  -->END

    
    
    // gift issued report -->START
    
    
    function get_gift_report()
	{
		$data['main_content'] = self::REP_VIEW.'gift_report';
        $this->load->view('layout/template', $data);
	}
	
	function ajax_gift_report()
	{
	    $this->load->model("admin_report_model");
	    
	    //print_r($_POST);exit;
	    
		if(!empty($_POST))
        {
            $range['from_date']  = $this->input->post('from_date');
            $range['to_date']  = $this->input->post('to_date');
            $range['id_branch']  = $this->input->post('id_branch');
            $data['gift'] = $this->admin_report_model->get_gift_list($range['from_date'],$range['to_date'],$range['id_branch']);		
        }
        
        echo json_encode($data);
	}
	

    
    //gift issued report  -->END
	
}
?>