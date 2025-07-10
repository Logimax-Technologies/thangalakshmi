<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Services extends CI_Controller {
	const VIEW_FOLDER = 'chitscheme/';
	const SERV_MODEL = 'services_modal';
	const API_MODEL = 'syncapi_model';
	public function __construct()
    {
        parent::__construct();
		ini_set('date.timezone', 'Asia/Kolkata');  
		$this->load->model('payment_modal'); 
		$this->load->model('services_modal'); 
		$this->load->model('email_model'); 
		$this->load->model('sms_model'); 
		$this->load->model('login_model');
		$this->comp = $this->login_model->company_details();
		if($this->config->item("integrationType") == 5){ // Do customer registration in offline
            $this->load->model("integration_model");
		}
		//default payment status 
		$this->payment_status = array(
										'pending'   => 7,
										'awaiting'  => 2,
										'success'   => 1,
										'failure'   => 3,
										'cancel'    => 4
									  );
    }
    
    /* Cashfree Gateway Payment Functions */
    
    public function cashfreeStatusNotify($id_pg){  
        $log_path = 'log/cashfree/'.date("Y-m-d").'.txt';  
		$postdata = "\n".date('d-m-Y H:i:s')." \n POST : ".json_encode($_POST,true);
		file_put_contents($log_path,$postdata,FILE_APPEND | LOCK_EX);
    	if(!empty($_POST)){ 
			 $paymentgateway = $this->payment_modal->getGateway($id_pg); 
	    	 $secretKey  = $paymentgateway['param_1'];	//secret Key should be provided here. 
	    	 $signature     = stripslashes($_POST["signature"]);
			 $orderId       = $_POST["orderId"];
			 $orderAmount   = $_POST["orderAmount"];
			 $referenceId   = $_POST["referenceId"];
			 $txStatus      = $_POST["txStatus"];
			 $paymentMode   = $_POST["paymentMode"];
			 $txMsg         = $_POST["txMsg"];
			 $txTime        = $_POST["txTime"]; 
			 $data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime; 
			 $hash_hmac = hash_hmac('sha256', $data, $secretKey, true) ; 
			 $computedSignature = base64_encode($hash_hmac);  
		 	 $updateData = array("mode"       => ($paymentMode== "CREDIT_CARD" ? "CC":($paymentMode == "DEBIT_CARD" ? "DC":($paymentMode == "NET_BANKING" ? "NB":$paymentMode))), 
	        					"cardnum"	  => NULL ,
	        					"field9"      => $txMsg."[".$txTime."]", // remark
	        					"bank_ref_num"=> $referenceId ,
	        					"mihpayid"	  => $referenceId ,
	        					"txnid"       => $orderId,
	        					"amount"      => $orderAmount,
	        					"signature"   => $signature
	            				);  
			if($computedSignature == $signature){
			    $pay = $this->payment_modal->getStatusByTxnId($orderId);
			    $l2 = " \n computedSignature == signature ".json_encode($pay,true);
			    file_put_contents($log_path,$l2,FILE_APPEND | LOCK_EX); 
		        if($pay['payment_status'] != 1 && $pay['payment_status'] != 2)
		        { 
	            	if($txStatus === "SUCCESS")
	    			{ 
	    				$response = $this->payment_success($updateData,4);
	    			}    		
	    			else
	    			{
	    				$response = array("data" =>$_POST,"errMsg" => 'Status  Other than success. Received Status : '.$txStatus); 
	    			}
		        } 
		    	else
		    	{
		           $response = array("data" =>$_POST,"errMsg" => 'Already status Updated. Status : '.$pay['payment_status']); 
		    	}
			}
			else
	    	{
	           $response = array("data" =>$_POST,"errMsg" => 'Signeture mismatch. Signature : '.$computedSignature); 
	    	}
		    // Write log	
			$ldata = "\n".date('d-m-Y H:i:s')." \n Result : ".json_encode($response,true);
			file_put_contents($log_path,$ldata,FILE_APPEND | LOCK_EX);
			echo json_encode($response);
		}else{
		    // Write log	 
			$ldata = "\n".date('d-m-Y H:i:s')." \n Result : Empty Post Data ";
			file_put_contents($log_path,$ldata,FILE_APPEND | LOCK_EX);
			echo "Empty Post Data";
		}
	}
    public function payment_success($payData = "", $gateway = "")
    {
        $response = [];
        if($gateway == ""){
            $payData = $_POST;
        } 
		/* print_r($payData);
		print_r($gateway);
		exit; */
	    $serv_model= self::SERV_MODEL; 
	    if(!empty($payData['txnid']) && $payData['txnid'] != NULL){
    	    $amount =0;
       	    $remark ='';
            $id_transaction = $payData['txnid'];
            $transData = array();
            $pay = $this->payment_modal->getWalletPaymentContent($id_transaction);
			$approval_type = $this->config->item('auto_pay_approval');
    		$updateData = array(
    						"bank_name"			 =>	(isset($payData['issuing_bank']) ? $payData['issuing_bank'] : NULL),
    						"payment_mode"       => (isset($payData['mode']) ? $payData['mode'] : NULL),
    						"card_no"			 => (isset($payData['mode']) && ($payData['mode'] == 'CC' || $payData['mode'] == 'DC') ? $payData['cardnum'] :NULL ),
    						"payu_id"             => (isset($payData['mihpayid']) ? $payData['mihpayid'] : NULL),
    						"payment_ref_number" => (isset($payData['bank_ref_num']) ? $payData['bank_ref_num'] : NULL ),
    						"remark"             => $payData['field9']." - cfnotifyurl",
    						"payment_status"     => ( $approval_type == 1 ||  $approval_type == 2 ? $this->payment_status['success']:$this->payment_status['awaiting']) //status - 0 (pending), will change to 1 after approved at backend
    					); 
    		//print_r($updateData);die;
    		$payment = $this->payment_modal->updateGatewayResponse($updateData,$id_transaction);
    	    $serviceID = 7;
    		$service = $this->services_modal->checkService($serviceID);
    		if($payment['status'] == true)
    		{
    			$payDatas = $this->payment_modal->get_paymenMailData(isset($payment['id_payment'])?$payment['id_payment']:'');
    		    if( $approval_type == 1 ||  $approval_type == 2 || $approval_type == 3){
    		        if($pay['allow_referral'] == 1){
    				    $ref_data	=	$this->payment_modal->get_refdata($pay['id_scheme_account']);
    					$ischkref	=	$this->payment_modal->get_ischkrefamtadd($pay['id_scheme_account']);	
    			 		if($ref_data['ref_benifitadd_ins_type'] == 1 && $ref_data['referal_code'] != '' && ($ref_data['ref_benifitadd_ins'] == $ref_data['paid_installments']) && $ischkref == TRUE){	
    						$this->insert_referral_data($ref_data['id_scheme_account'],$ref_data);
    					}else if($ref_data['ref_benifitadd_ins_type'] == 0 && $ref_data['referal_code'] != '' && $ischkref == TRUE){
    						$this->insert_referral_data($ref_data['id_scheme_account'],$ref_data);
    					}
    			 	}
    			 	$payIds = $this->payment_modal->getPayIds($id_transaction);
    				if(sizeof($payIds) > 0)
    				{
    					foreach ($payIds as $pay)
    					{
    						$updData = array("last_payment_on" => NULL);
							$this->payment_modal->updData($updData,'id_customer',$payIds[0]['id_customer'],'customer'); 	
    					    if($this->config->item("integrationType") == 5){ // Generate A/C No and Receipt No
            					$this->generateAcNoOrReceiptNo($pay);
            				}
    					    // Generate receipt number
    						if($pay['receipt_no_set'] == 1 && ($approval_type == 1 ||  $approval_type == 2 || $approval_type == 3) )
    						{  
    							if($pay['scheme_wise_receipt']==1)
    							{
    							    $data['receipt_no'] = $this->generate_receipt_no($pay['id_scheme']);
    							}
    							else
    							{
    							    $data['receipt_no'] = $this->generate_receipt_no();
    							}
    							$payment['status'] = $this->payment_modal->update_receipt($pay['id_payment'],$data);
    						}
    						// Generate account  number
    						if($pay['schemeacc_no_set'] == 0 )
    						{
    							if($pay['scheme_acc_number'] == '' ||  $pay['scheme_acc_number'] == null)
    							{
    								$scheme_acc_number = $this->payment_modal->account_number_generator($pay['id_scheme'],$pay['id_branch'],'');
    								if($scheme_acc_number != NULL && $scheme_acc_number !="Not Allocated"){
    									$schData['scheme_acc_number'] = $scheme_acc_number;
    								}
    								$updSchAc = $this->payment_modal->update_account($schData,$pay['id_scheme_account']);
    							}
    						}
    						//Update First Payment Amount In Scheme Account
        					 if(($approval_type == 1 || $approval_type == 2 || $approval_type == 3) && ($pay['firstPayamt_payable']==1 || $pay['firstPayamt_as_payamt']==1) && ($pay['firstPayment_amt'] == '' ||  $pay['firstPayment_amt'] == null))
    						 {
    							$firstPayment_amt = array(
    							    'firstPayment_amt' => $pay['payment_amount']
    							); 
    							$status = $this->payment_modal->update_account($firstPayment_amt,$pay['id_scheme_account']);	
    						 }
    						// Insert Data in Intermediate table
    						 if($approval_type == 2 || $approval_type == 3 && ($this->config->item('integrationType') == 2 || $this->config->item('integrationType') == 3))
    						 {
    						    /* if($pay['edit_custom_entry_date']==1)
    							{
    									$receipt['custom_entry_date']=$pay['custom_entry_date'];
    									$payment['status'] = $this->payment_modal->update_receipt($pay['id_payment'],$receipt);
    							}*/
    							$this->insert_common_data($pay['id_payment']);
    						 }
    					}
    				}
    		    }
    			 if($service['sms'] == 1)
    			{
    				$id=$payment['id_payment'];
    				$data =$this->$serv_model->get_SMS_data($serviceID,$id);
    				$mobile =$data['mobile'];
    				$message = $data['message'];
    				if($this->config->item('sms_gateway') == '1'){
		    		    $this->sms_model->sendSMS_MSG91($mobile,$message);		
		    		}
		    		elseif($this->config->item('sms_gateway') == '2'){
		    	        $this->sms_model->sendSMS_Nettyfish($mobile,$message,'trans');	
		    		}
    			}
    			if($service['email'] == 1 && isset($payDatas[0]['email']) && $payDatas[0]['email'] != '')
    			{
    				$to = $payDatas[0]['email'];
    				$subject = "Reg - ".$this->comp['company_name']." payment for the purchase plan";
    				$data['payData'] = $payDatas[0];
    				$data['type'] = 3;
    				$data['company_details'] = $this->comp;
    				$message = $this->load->view('include/emailPayment',$data,true);
    				$sendEmail = $this->email_model->send_email($to,$subject,$message,"","");
    			}
				if($gateway == 2  || $gateway == 4){ 
					$response = array("successMsg" => 'Transaction ID: '.$payData['txnid'].' for the amount INR. '.$payData['amount'].' is paid successfully. Thanks for your payment with '.$this->comp['company_name'].'');
				}else{
					$response = array("successMsg" => 'Payment successful. Thanks for your payment with '.$this->comp['company_name'].'');
				}
    		}
    		else
    		{
    			$response = array("errMsg" => 'Error in updating the database.Please contact administrator at your earliest convenience.');  
    		}
	    }
	    return $response;
    }
    //To insert payment and registration details in intermediate table
	function insert_common_data($id_payment)
	{
		$model = self::API_MODEL;
		$this->load->model($model);
		//getting payment detail
		$pay_data = $this->$model->getPaymentByID($id_payment);	
		//storing temp values
		$ref_no = $pay_data[0]['ref_no'];
		$id_scheme_account = $pay_data[0]['id_scheme_account']; 
		$isCusRegExists = $this->$model->checkCusRegExists($id_scheme_account,$ref_no);
		if(!$isCusRegExists['status']){
		     $reg = $this->$model->getCustomerByID($id_scheme_account);	
             //insert customer registration detail
             if($reg)
             {
            	$reg[0]['record_to']= 1 ;
            	$reg[0]['is_registered_online']= 2 ;  // 2 - online record
            	$reg[0]['ref_no']		= $ref_no;
            	$status = $this->$model->insert_CustomerReg($reg[0]);
             }	
		}
		$isTranExists = $this->$model->checkTransExists($ref_no);
		if(!$isTranExists)
		{
            //insert payment detail
            $pay_data[0]['record_to'] = 1;	
            $pay_data[0]['payment_type'] = 1;	// 1 - online 
            $status =	$this->$model->insert_transaction($pay_data[0]); 
		}
		//echo $this->db->last_query();exit;
		return true;
	}
	function insert_referral_data($id_scheme_account,$referral_data)
	{ 
		$status=FALSE;			
		$serviceID=16;
		if($referral_data['referal_code']!='' && $referral_data['is_refferal_by']==1){			
		  $data = $this->payment_modal->get_empreferrals_datas($id_scheme_account);
		}else if($referral_data['referal_code']!='' && $referral_data['is_refferal_by']==0){			
			$data = $this->payment_modal->get_cusreferrals_datas($id_scheme_account);
		}	
		if(!empty($data))
		{			
			if($data['referal_code']!='' && $data['referal_value']!=''  &&  $data['id_wallet_account']!=''){
			// insert wallet transaction data //
							$wallet_data = array(
							'id_wallet_account' => $data['id_wallet_account'],
							'date_transaction' =>  date("Y-m-d H:i:s"),
							'transaction_type' =>  0,
							'value'            => $data['referal_value'],
							'description'      => 'Referral Benefits - '.$data['cusname'].' ref no. '.$data['id_scheme_account']
							);
				$status =$this->payment_modal->wallet_transactionDB($wallet_data);
				  if($status)
				  {
				  		// Update credit flag in customer table
					  	/* is_refbenefit_crt = 0 -> already  benefit credited  & 1-> yet to credit benefits' */					 		
					  	if($referral_data['is_refferal_by']==0 && $data['cusbenefitscrt_type']==0 && ($data['schrefbenifit_secadd']==0 || $data['schrefbenifit_secadd']==1) ){
							// customer referal - single  
							$this->payment_modal->update_customer_only(array('is_refbenefit_crt_cus'=>0),$chkreferral['id_customer']);
						}else if($referral_data['is_refferal_by']==0 && $data['cusbenefitscrt_type']==1 && $data['schrefbenifit_secadd']==1){
							// customer referal - multiple  
							$this->payment_modal->update_customer_only(array('is_refbenefit_crt_cus'=>1),$chkreferral['id_customer']);
						}else if($referral_data['is_refferal_by']==1 && $data['empbenefitscrt_type']==0 && ($data['schrefbenifit_secadd']==0 || $data['schrefbenifit_secadd']==1)){	
							 // emp referal - single  					
							$this->payment_modal->update_customer_only(array('is_refbenefit_crt_emp'=>0),$chkreferral['id_customer']);
						}else if($referral_data['is_refferal_by']==1 && $data['empbenefitscrt_type']==1 && $data['schrefbenifit_secadd']==1){	
							// emp referal - single  			
							$this->payment_modal->update_customer_only(array('is_refbenefit_crt_emp'=>1),$chkreferral['id_customer']);
						}
				  } 
				  $service = $this->services_modal->checkService($serviceID);
				  if($service['sms'] == 1 && $data['mobile']){
				       $sms_data =$this->services_modal->get_SMS_data($serviceID,$data['id_scheme_account']);  
				       if($this->config->item('sms_gateway') == '1'){
			    		  $this->sms_model->sendSMS_MSG91($sms_data['mobile'],$sms_data['message']);		
			    	   }
			    	   elseif($this->config->item('sms_gateway') == '2'){
			    	      $this->sms_model->sendSMS_Nettyfish($sms_data['mobile'],$sms_data['message'],'trans');	
			    	   }
				  }
				 }
		}
	}
	
	/**	* 
	*	Khimji integration API call functions 
	* 	1. Generate AcountNo Or ReceiptNo	* 
    */
	function generateAcNoOrReceiptNo($pay){		
           $postData = array(
					    "transactionType"=> 2,
					    "tranUniqueId"	=> $pay['offline_tran_uniqueid'],
					    "branchCode"	=> $pay['warehouse'],
					    "paymentDetail"	=> array(
											"paymentType" 		=> 9,
											"paymentTypeName" 	=> "Online",
											"amount" 			=> $pay['payment_amount'],
											"authorizationNo" 	=> $pay['payment_amount'],
											"narration" 		=> $pay['payment_type']."-".$pay['payment_mode'],
											"originalAmt" 		=> $pay['payment_amount'],
											"transationAmt" 	=> $pay['payment_amount'],
											"marchantCharges" 	=> 0.00,
											"cardChargesAmount" => 0.00,
											"cardChargesPercentage" => 0
											)
					);
						
            $is_new_ac = ($pay['scheme_acc_number'] != "" && $pay['scheme_acc_number'] != NULL ? FALSE : TRUE);
            if(!$is_new_ac){ // Account number already generated
                $postData["orderNo"] = $pay['scheme_acc_number'];
		    }
		    
           $response = $this->integration_model->khimji_curl('app/v1/saveSchemeOrInstallmentDetails',$postData);
           if($response['status'] == TRUE){
               	$resData = $response['data']->data; 
               	if($resData->errorCode == 0){ // $resData->status == TRUE && 
               		if(isset($resData->result->orderNo)){
						$acData = array(
									 'scheme_acc_number'=> $resData->result->orderNo,
									 'date_upd'			=> date("Y-m-d H:i:s")
									 );
						$this->payment_modal->updData($acData,'id_scheme_account',$pay['id_scheme_account'],'scheme_account');
						$payData = array(
									 'receipt_no'	=> $resData->result->orderNo,
									 'date_upd'		=> date("Y-m-d H:i:s")
									 );
						$this->payment_modal->updData($payData,'id_payment',$pay['id_payment'],'payment');
		    			return true;						
					}
					if(isset($resData->result->installmentNo)){
						$payData = array(
									 'receipt_no'	=> $resData->result->installmentNo,
									 'date_upd'		=> date("Y-m-d H:i:s")
									 );
						$this->payment_modal->updData($payData,'id_payment',$pay['id_payment'],'payment');
						return true;
					}
                }
           }
           // Write log in case of API call failure
	       if (!file_exists('log/khimji')) {
	            mkdir('log/khimji', 0777, true);
	        }
	        $log_path = 'log/khimji/'.date("Y-m-d").'.txt';  
	        $logData = "\n".date('d-m-Y H:i:s')."\n API : app/v1/saveSchemeOrInstallmentDetails \n Response : ".json_encode($response,true);
		    file_put_contents($log_path,$logData,FILE_APPEND | LOCK_EX);
		    return true;
               
	}
	// .Khimji integration API call functions
	
	
	/* .Cashfree Gateway Payment Functions */
	
	public function atomPayStatus(){  
        $log_path = 'log/atom/hook/'.date("Y-m-d").'.txt';  
		$postdata = "\n".date('d-m-Y H:i:s')." \n POST : ".json_encode($_POST,true);
		file_put_contents($log_path,$postdata,FILE_APPEND | LOCK_EX);
    	if(!empty($_POST)){
            /*
            // Callback Response  
            POST : {"MerchantID":"98490","MerchantTxnID":"1636466192618a7e10186ca","AMT":"5000.00","VERIFIED":"SUCCESS","BID":"131339430933","BankName":"Hdfc Bank","AtomTxnId":"11000062483554","Discriminator":"UP","Surcharge":"0.00","CardNumber":"","TxnDate":"2021-11-09 19:27:21","CustomerAccNo":"1234567891234567","Clientcode":"123"}
            Discriminator - Possible Values
                NB - Net banking
                CC - Credit Cards
                DC - Debit Card
                MX - American Express Cards
            VERIFIED - Transaction Status SUCCESS / FAILED
            */
            
            $updateData = array("mode"        => $_POST['Discriminator'], 
                                "cardnum"	  => $_POST['CardNumber'] ,
                                "field9"      => $_POST['VERIFIED']."[".$_POST['TxnDate']."]", // remark
                                "bank_ref_num"=> $_POST['BID'] ,
                                "mihpayid"	  => $_POST['AtomTxnId'],
                                "txnid"       => $_POST['MerchantTxnID'],
                                "amount"      => $_POST['AMT'],
                                "issuing_bank"=> $_POST['BankName']
                                );  
            
            $pay = $this->payment_modal->getStatusByTxnId($_POST['MerchantTxnID']);
            $l2 = " \n Update Data ".json_encode($updateData,true);
            file_put_contents($log_path,$l2,FILE_APPEND | LOCK_EX); 
            if($pay['payment_status'] != 1 && $pay['payment_status'] != 2)
            { 
                if($_POST['VERIFIED'] === "SUCCESS")
                { 
                    $response = $this->payment_success($updateData,5);
                }  
                else if($_POST['VERIFIED'] === "FAILED")
                { 
                    $response = $this->payment_failure($updateData,5);
                }
                else
                {
                    $response = array("data" =>$_POST,"errMsg" => 'Status  Other than success. Received Status : '.$data['VERIFIED']); 
                }
            } 
            else
            {
                $response = array("data" =>$_POST,"errMsg" => 'Already status Updated. Status : '.$pay['payment_status']); 
            }
            
            // Write log	
            $ldata = "\n".date('d-m-Y H:i:s')." \n Result : ".json_encode($response,true);
            file_put_contents($log_path,$ldata,FILE_APPEND | LOCK_EX);
            echo json_encode($response);
        }else{
            // Write log	 
            $ldata = "\n".date('d-m-Y H:i:s')." \n Result : Empty Post Data ";
            file_put_contents($log_path,$ldata,FILE_APPEND | LOCK_EX);
            echo "Empty Post Data";
        }
    }
    
    public function payment_failure($payData = "", $gateway = "")
    {
        if($gateway == ""){
            $payData = $_POST;
        } 
		//echo"<pre>"; print_r($payData);exit
        if(!empty($payData['txnid']) && $payData['txnid'] != NULL){
    	     $serv_model= self::SERV_MODEL;
    		 $updateData = array(
    						"bank_name"			 =>	(isset($payData['issuing_bank']) ? $payData['issuing_bank'] : NULL),
    						"payment_mode"       => (isset($payData['mode']) ? $payData['mode'] : NULL),
    						"card_no"			 => (isset($payData['mode']) && ($payData['mode'] == 'CC' || $payData['mode'] == 'DC') ? $payData['cardnum'] :NULL ),
    						"payu_id"             => (isset($payData['mihpayid']) ? $payData['mihpayid'] : NULL),
    						"remark"             => (isset($payData['field9']) ? $payData['field9'] : NULL),
    						"payment_ref_number" => (isset($payData['bank_ref_num']) ? $payData['bank_ref_num'] : NULL ),
    						"payment_status"     => $this->payment_status['failure']
    					);
    		$payment = $this->payment_modal->updateGatewayResponse($updateData,$payData['txnid']);
    		$payData = $this->payment_modal->get_paymenMailData(isset($payment['id_payment'])?$payment['id_payment']:'');
    		//$payData = $this->registration_model->get_cusData($this->session->userdata('username'));
    		$serviceID = 7;
    		$service = $this->services_modal->checkService($serviceID);
    		if($service['sms'] == 1)
    		{
				$id=$payment['id_payment'];
				$data =$this->$serv_model->get_SMS_data($serviceID,$id);
				$mobile =$data['mobile'];
				$message = $data['message'];
				if($this->config->item('sms_gateway') == '1'){
	    		    $this->sms_model->sendSMS_MSG91($mobile,$message,'',$service['dlt_te_id']);		
	    		}
	    		elseif($this->config->item('sms_gateway') == '2'){
	    	        $this->sms_model->sendSMS_Nettyfish($mobile,$message,'trans');	
	    		}
    		}
    		if($service['email'] == 1 && isset($payData[0]['email']) && $payData[0]['email'] != '')
    		{
    			$to = $payData[0]['email'];
    			$subject = "Reg - ".$this->comp['company_name']." payment for the purchase plan";
    			$data['payData'] = $payData[0];
    			$data['type'] = 3;
    			$data['company_details'] = $this->comp;
    			$message = $this->load->view('include/emailPayment',$data,true);
    			$sendEmail = $this->email_model->send_email($to,$subject,$message,"","");	
    		}
    		$scheme_failure = array("errMsg" => 'Payment failure.Please try again later');
    		//$this->session->set_flashdata($scheme_failure);
    		//redirect("/paymt");
        }else{
            $scheme_success = array("errMsg" => 'Payment failure.Error in updating the database.Please contact administrator for status.');
			//$this->session->set_flashdata($scheme_success);
			//redirect("/paymt");
        }
        return $scheme_success;
	}
	 
	function sleep_test($sec){
	    echo date('h:i:s') . "<br>";
        //sleep
        sleep($sec);
        //start again
        echo date('h:i:s');
	}
}	
?>