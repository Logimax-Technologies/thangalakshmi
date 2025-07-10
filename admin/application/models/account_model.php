<?php

if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model

{

	const ACC_TABLE 		= "scheme_account";

	const CUSREG_TABLE			= "customer_reg";

	const TRANS_TABLE		= "transaction";

	const CUS_TABLE			= "customer";

	const SCH_TABLE			= "scheme";

	const PAY_TABLE			= "payment";

	const REG_TABLE			= "registration";

	const ADD_TABLE			= "address";

	const SYNC_TABLE		= "sync_log";

	const OTP_TABLE			= "otp";

	const ISSU_TABLE        = "gift_issued";

	const SCHGROUP_TABLE    = "scheme_group";

	const BRANCH   			 = "branch";

	function __construct()

    {

        parent::__construct();

    }

    public function updateData($data, $id_field, $id_value, $table)

    {    

	    $edit_flag = 0;

	    $this->db->where($id_field, $id_value);

		$edit_flag = $this->db->update($table,$data);

		return ($edit_flag==1?$id_value:0);

	}

    function account_empty_record()

    {

		$data=array(

			'id_scheme_account'	=> 0,

			'mobile'            => "",

            'acc_number'        => "",

			'id_scheme'			=> 0,

			'id_customer'		=> 0,

			'scheme_acc_number'	=> NULL,

			'customer'	        => NULL,

			'account_name'		=> NULL,

			'cus_name'          => NULL,

			'ref_no'			=> NULL,

			'scheme_type' 		=> NULL,

			'paid_installments'	=> 0,	

			'is_opening'		=> 0,

			'balance_amount'	=> '0.00',

			'balance_weight'	=> '0.000',

			'last_paid_weight'	=> '0.000',

			'last_paid_chances'	=> 0,

			'last_paid_date'	=> NULL,

			'start_date'		=> date('d-m-Y'),

			'maturity_date'		=> NULL,

			'employee_approved'	=> 0,	

			'active'			=> 1,	

			'disable_payment'	=> 0,	

			'is_new'			=> 'Y',	

			'is_refferal_by'	=>NULL,

			'referal_code'		=>NULL,

			'remark_open'		=> NULL,

			'show_gift_article'	=> 0,

			'id_branch'		    => NULL,

			'id_employee'       =>NULL,

			'firstPayment_amt'  =>NULL,

			'get_amt_in_schjoin'=> NULL ,

			'maturity_type'		=> NULL, 

			'total_installments'		=> NULL, 

			'acc_number'		=> NULL, 

			'mobile'		=> NULL ,

			'has_gift'        =>1,

			'pan_no'   => NULL,

			'aadhaar_no' => NULL

		//	'get_amt_in_schjoin'=>$this->get_amt_in_schjoinsettings()

	);

		return $data;

	}

	public function get_maturity_days($id)

	{

	   $sql="SELECT maturity_days FROM scheme WHERE id_scheme =$id";

	   $data=	$this->db->query($sql);

	   return $data->row()->maturity_days;

	}

	function getActiveAccounts($id="")

	{

		if($id!=NULL)

		{  

			$sql="Select

					  sa.id_scheme_account,sa.scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sa.ref_no,sa.account_name,sa.start_date,c.is_new,

					  s.scheme_name,sa.is_new,s.code,if(s.scheme_type=0,'Amount','Weight')as scheme_type,s.total_installments,s.max_chance,s.max_weight,s.amount,c.mobile,if(sa.active =1,'Active','Inactive') as active,sa.date_add

					From

					  ".self::ACC_TABLE." sa

					Left Join ".self::CUS_TABLE." c On (sa.id_customer=c.id_customer)

					Left Join ".self::SCHGROUP_TABLE." sg On (sa.id_scheme=sg.id_scheme)

					Left Join ".self::SCH_TABLE." s On (s.id_scheme=sa.id_scheme)

					Where  (sa.active=1 And sa.is_closed=0 And c.active =1) And sa.id_scheme_account=".$id;

					return $this->db->query($sql)->row_array();

		}

		else

		{

			$sql="Select

					  sa.id_scheme_account,sa.scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sa.ref_no,sa.account_name,sa.start_date,c.is_new,

					  		sg.end_date as end_date,

					  s.scheme_name,sa.is_new,s.code,if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,s.total_installments,s.max_chance,s.max_weight,s.amount,c.mobile,if(sa.active =1,'Active','Inactive') as active,sa.date_add

					From

					  ".self::ACC_TABLE." sa

					Left Join ".self::CUS_TABLE." c On (sa.id_customer=c.id_customer)

					Left Join ".self::SCH_TABLE." s On (s.id_scheme=sa.id_scheme)

					Where  sa.active=1 And sa.is_closed=0 And c.active =1";

						return $this->db->query($sql)->result_array();

		}

	}

	// function getAmountSchemeAccounts($id="")

	// {

	// 	if($id!=NULL)

	// 	{  

	// 		$sql="Select

	// 				  sa.id_scheme_account,IFNULL(sa.scheme_acc_number,'Not Allocated') as scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sa.ref_no,sa.account_name,sa.start_date,c.is_new,

	// 				  s.scheme_name,sa.is_new,s.code,if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,s.total_installments,s.max_chance,s.max_weight,s.amount,c.mobile,if(sa.active =1,'Active','Inactive') as active,sa.date_add

	// 				From

	// 				  ".self::ACC_TABLE." sa

	// 				Left Join ".self::CUS_TABLE." c On (sa.id_customer=c.id_customer)

	// 				Left Join ".self::SCH_TABLE." s On (s.id_scheme=sa.id_scheme)

	// 				Where  (sa.active=1 And sa.is_closed=0 And c.active =1) And (s.scheme_type=0 or s.scheme_type=1 or s.scheme_type=2 or s.scheme_type=3 ) And sa.id_scheme_account=".$id;

	// 				return $this->db->query($sql)->row_array();

	// 	}

	// 	else

	// 	{

	// 		$sql="Select

	// 				  sa.id_scheme_account,IFNULL(sa.scheme_acc_number,'Not Allocated') as scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sa.ref_no,sa.account_name,sa.start_date,c.is_new,

	// 				  s.scheme_name,sa.is_new,s.code,if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,s.total_installments,s.max_chance,s.max_weight,s.amount,c.mobile,if(sa.active =1,'Active','Inactive') as active,sa.date_add

	// 				From

	// 				  ".self::ACC_TABLE." sa

	// 				Left Join ".self::CUS_TABLE." c On (sa.id_customer=c.id_customer)

	// 				Left Join ".self::SCH_TABLE." s On (s.id_scheme=sa.id_scheme)

	// 				Where  sa.active=1 And sa.is_closed=0 And c.active =1 And (s.scheme_type=0 or s.scheme_type=1 or s.scheme_type=2 or s.scheme_type=3 )";

	// 					return $this->db->query($sql)->result_array();

	// 	}

	// }

	function getAmountSchemeAccounts($id="")

	{

	$id_scheme = $this->input->post('id_scheme');

	//old code 05-12-2022 if(cs.has_lucky_draw=1 && s.is_lucky_draw = 1,concat(concat(ifnull(sa.group_code,''),' ',ifnull(sa.scheme_acc_number,'Not Allocated')),' - ',s.code ),concat(s.code,' ',ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number,

	

	//New code 05-12-2022 if(cs.has_lucky_draw=1 && s.is_lucky_draw = 1,concat(concat(ifnull(sa.group_code,''),'-',ifnull(sa.start_year,''),ifnull(sa.scheme_acc_number,'Not Allocated')),' - ',s.code ),concat(s.code,' ',ifnull(sa.start_year,''),ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number,

	

	

		if($id!=NULL)

		{  

			$sql="Select

					  sa.id_scheme_account,

					 if(cs.has_lucky_draw=1 && s.is_lucky_draw = 1,concat(concat(ifnull(sa.group_code,''),'-',ifnull(sa.start_year,''),ifnull(sa.scheme_acc_number,'Not Allocated')),' - ',s.code ),concat(s.code,' ',ifnull(sa.start_year,''),ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number,

					  IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) asname,sa.ref_no,sa.account_name,c.is_new,sg.group_code,c.mobile,

					  s.scheme_name,sa.is_new,s.code,if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,s.total_installments,s.max_chance,s.max_weight,s.amount,c.mobile,if(sa.active =1,'Active','Inactive') as active,sa.date_add

					From

					  ".self::ACC_TABLE." sa

					Left Join ".self::CUS_TABLE." c On (sa.id_customer=c.id_customer)

						Left Join ".self::SCHGROUP_TABLE." sg On (sa.id_scheme=sg.id_scheme)

					Left Join ".self::SCH_TABLE." s On (s.id_scheme=sa.id_scheme)

					Join chit_settings cs

					Where  (sa.active=1 And sa.is_closed=0 And c.active =1) And (s.scheme_type=0 or s.scheme_type=1 or s.scheme_type=2 or s.scheme_type=3 ) And sa.id_scheme_account=".$id;

					return $this->db->query($sql)->row_array();

		}

		else

		{

		//old code 05-12-2022 if(cs.has_lucky_draw=1 && s.is_lucky_draw = 1,concat(concat(ifnull(sa.group_code,''),' ',ifnull(sa.scheme_acc_number,'Not Allocated')),' - ',s.code ),concat(s.code,' ',ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number,

		

		

		//New code 05-12-2022 if(cs.has_lucky_draw=1 && s.is_lucky_draw = 1,concat(concat(ifnull(sa.group_code,''),'-',ifnull(sa.start_year,''),'-',ifnull(sa.scheme_acc_number,'Not Allocated')),'-',s.code ),concat(s.code,'-',ifnull(sa.start_year,''),'-',ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number,	

			$branchWiseLogin=$this->session->userdata('branchWiseLogin');

			$is_branchwise_cus_reg=$this->session->userdata('is_branchwise_cus_reg');

			$id_branch=$this->session->userdata('id_branch');

			$uid=$this->session->userdata('uid');

			$sql="Select

					  sa.id_scheme_account,

					 if(cs.has_lucky_draw=1 && s.is_lucky_draw = 1,concat(concat(ifnull(sa.group_code,''),' ',ifnull(sa.scheme_acc_number,'Not Allocated')),' - ',s.code ),concat(s.code,' ',ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number,

					  IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sa.ref_no,sa.account_name,sa.start_date,sg.group_code,sg.end_date,c.is_new,c.mobile,

					  s.scheme_name,sa.is_new,s.code,if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,s.total_installments,s.max_chance,s.max_weight,s.amount,c.mobile,if(sa.active =1,'Active','Inactive') as active,sa.date_add

					From

					  ".self::ACC_TABLE." sa

					Left Join ".self::CUS_TABLE." c On (sa.id_customer=c.id_customer)

						Left Join ".self::SCHGROUP_TABLE." sg On (sa.id_scheme=sg.id_scheme)

					Left Join ".self::SCH_TABLE." s On (s.id_scheme=sa.id_scheme)

						left join ".self::BRANCH." b on (b.id_branch=sa.id_branch)

					Join chit_settings cs

					Where  sa.active=1 And sa.is_closed=0 ".($id_scheme!='' ? "and sa.id_scheme=".$id_scheme."":'')." And c.active =1 And  (s.scheme_type=0 or s.scheme_type=1 or s.scheme_type=2 or s.scheme_type=3 ) 

					".($uid!=1?($branchWiseLogin==1||$is_branchwise_cus_reg?($id_branch!='' ?"and b.id_branch=".$id_branch." or b.show_to_all=1":''):''):'')."

					";

						return $this->db->query($sql)->result_array();

		}

	}

	function set_registration_record($id_customer,$id_scheme,$id_register)

    {

		$data=array(

		    'id_register'		=> $id_register,

			'id_scheme_account'	=> 0,

			'id_scheme'			=> $id_scheme,

			'id_customer'		=> $id_customer,

			'account_name'		=> NULL,

			'ref_no'			=> NULL,

			'paid_installments'			=> 0,

			'start_date'		=> date('d-m-Y'),

			'employee_approved'	=> 0,	

			'remark_open'		=> NULL

		);

		return $data;

	}

	/*  //Generate 10 digit Account number random

	function account_number_generator()

	{

	  $query = $this->db->query("SELECT LPAD(round(rand() * 1000000000),10,0) as myCode

								FROM scheme_account

								HAVING myCode NOT IN (SELECT scheme_acc_number FROM scheme_account) limit 0,1");

		if($query->num_rows()==0){

			$query = $this->db->query("SELECT LPAD(round(rand() * 1000000000),10,0) as myCode");

		}

		return $query->row()->myCode;

	}*/

	//Generate account number 

	function account_number_generator($id_scheme,$branch,$ac_group_code)

	{

	  $lastno=$this->get_schAccount_no($id_scheme,$branch,$ac_group_code);

	  //print_r($this->db->last_query());exit;

	  if($lastno!=NULL)

		{

		  	$number = (int) $lastno;

		  	$number++;

			$schAc_number=str_pad($number, 5, '0', STR_PAD_LEFT);;

				//print_r($schAc_number);exit;

    		return $schAc_number;

		}

		else

		{

				$schAc_number=str_pad('1', 5, '0', STR_PAD_LEFT);;

    		return $schAc_number;

		}

	}



	 function get_schAccount_no($id_scheme,$branch,$ac_group_code)    
    {
        /* 
            scheme_wise_acc_no settings done by HH
            0 - Common,
            1 - Common with branch wise,
            2 - Scheme-wise,
            3 - Scheme-wise with branch wise
            For value 2,3 if lucky draw is enabled in schemes means have to generate group wise account number
        */
        $data = $this->get_settings(); 
        $id_company=$this->session->userdata('id_company');
        $company_settings=$this->session->userdata('company_settings');
        
        //group wise for lucky draw scheme....
        
          $sql_lucky = $this->db->query("SELECT is_lucky_draw,max_members FROM scheme WHERE id_scheme=".$id_scheme);
        
        $luckyDraw = $sql_lucky->row_array();
        
    
        
        
        if($data['branch_settings']==1){ // Branch Enabled
        
        if($luckyDraw['is_lucky_draw'] == 1 && $luckyDraw['max_members'] > 0 ){
            $sqlGrp = $this->db->query("SELECT group_code FROM scheme_group WHERE status = 1 and id_branch = ".$branch."  and id_scheme=".$id_scheme);
            $grpCode = $sqlGrp->row()->group_code;		
        }else{
            $grpCode ="";
        }
        
            if($data['scheme_wise_acc_no'] == 1 && $branch > 0){ // 1 - Common with branch wise,
                 $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                 left join customer c on c.id_customer= sa.id_customer
                 WHERE sa.id_branch=".$branch." 
                 ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                 ".($id_company!=0 && $company_settings == 1? "and c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }
            else if($data['scheme_wise_acc_no'] == 2){ // 2 - Scheme-wise
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." 
                ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? "and c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC "; 
            //print_r($sql);exit;
            }
            else if($data['scheme_wise_acc_no'] == 3){ // 3 - Scheme-wise with branch wise
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." AND sa.id_branch=".$branch." 
                ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? "and c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC "; 
            //print_r($sql);exit;
            }
            else if($data['scheme_wise_acc_no'] == 4)
            {
                $res = $this->db->query("SELECT date(fin_year_from) as fin_date FROM `ret_financial_year` where fin_status = 1");
               $financial_year = $res->row()->fin_date;
        
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE date(start_date) BETWEEN '".$financial_year."' AND DATE(CURDATE())
                ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? " AND c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }
            else if($data['scheme_wise_acc_no'] == 5) // financial year with scheme wise
            {
                $res = $this->db->query("SELECT date(fin_year_from) as fin_date FROM `ret_financial_year` where fin_status = 1");
                $financial_year = $res->row()->fin_date;
                
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." and date(sa.start_date) BETWEEN '".$financial_year."' AND DATE(CURDATE())
                ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? " AND c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }
            else if($data['scheme_wise_acc_no'] == 6) // financial year with scheme & branch wise
            {
                $res = $this->db->query("SELECT date(fin_year_from) as fin_date FROM `ret_financial_year` where fin_status = 1");
                $financial_year = $res->row()->fin_date;
                
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." and date(sa.start_date) BETWEEN '".$financial_year."' AND DATE(CURDATE()) and sa.id_branch=".$branch."
                ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? " AND c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
                
                //print_r($sql);exit;
            }
            else{ // If other cases fails,generate common account number
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                ".($ac_group_code!=null && $ac_group_code !=''? "WHERE sa.group_code='".$ac_group_code."'" :'WHERE sa.added_by != 6')."
                ".($id_company!=0 && $company_settings == 1 && $ac_group_code!=null && $ac_group_code !=''? "AND c.id_company=".$id_company."" :"WHERE c.id_company=".$id_company)."
                ORDER BY id_scheme_account DESC ";
            }
        }else{
            
            if($luckyDraw['is_lucky_draw'] == 1 && $luckyDraw['max_members'] > 0 ){
                $sqlGrp = $this->db->query("SELECT group_code FROM scheme_group WHERE status = 1 and id_branch = ".$branch."  and id_scheme=".$id_scheme);
                $grpCode = $sqlGrp->row()->group_code;		
            }else{
                $grpCode ="";
            }
            if($data['scheme_wise_acc_no'] == 0){ // 0 - Common
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                ".($ac_group_code!=null && $ac_group_code !=''? "WHERE sa.group_code='".$ac_group_code."'" :'WHERE sa.added_by != 6')."
                ".($id_company!=0 && $company_settings == 1 && $ac_group_code!=null && $ac_group_code !=''? "AND c.id_company=".$id_company."" :"WHERE c.id_company=".$id_company)."
                ORDER BY id_scheme_account DESC ";
            }
            else if($data['scheme_wise_acc_no'] == 2){ // 2 - Scheme-wise
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." 
                ".($ac_group_code!=null && $ac_group_code !=''? "and sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? "and c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }
            
            else if($data['scheme_wise_acc_no'] == 4)
            {
                $res = $this->db->query("SELECT date(fin_year_from) as fin_date FROM `ret_financial_year` where fin_status = 1");
                $financial_year = $res->row()->fin_date;
               
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE date(start_date) BETWEEN '".$financial_year."' AND DATE(CURDATE())
                 ".($ac_group_code!=null && $ac_group_code !=''? "and sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? " AND c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }
             else if($data['scheme_wise_acc_no'] == 5) // financial year with scheme wise
            {
                $res = $this->db->query("SELECT date(fin_year_from) as fin_date FROM `ret_financial_year` where fin_status = 1");
                $financial_year = $res->row()->fin_date;
               
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." and date(sa.start_date) BETWEEN '".$financial_year."' AND DATE(CURDATE())
                 ".($ac_group_code!=null && $ac_group_code !=''? "and sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? " AND c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }else if($data['scheme_wise_acc_no'] == 6) // financial year with scheme & branch wise
            {
                $res = $this->db->query("SELECT date(fin_year_from) as fin_date FROM `ret_financial_year` where fin_status = 1");
                $financial_year = $res->row()->fin_date;
                
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                WHERE sa.id_scheme=".$id_scheme." and date(sa.start_date) BETWEEN '".$financial_year."' AND DATE(CURDATE()) and sa.id_branch=".$branch."
                ".($ac_group_code!=null && $ac_group_code !=''? "AND sa.group_code='".$ac_group_code."'" :'')."
                ".($id_company!=0 && $company_settings == 1? " AND c.id_company=".$id_company."" :'')." ORDER BY id_scheme_account DESC ";
            }
            
            else{ // If other cases fails,generate common account number
                $sql = "SELECT max(sa.scheme_acc_number) as lastSchAcc_no FROM scheme_account sa 
                left join customer c on c.id_customer= sa.id_customer
                ".($ac_group_code!=null && $ac_group_code !=''? "WHERE sa.group_code='".$ac_group_code."'" :'WHERE sa.added_by != 6')."
                ".($id_company!=0 && $company_settings == 1 && $ac_group_code!=null && $ac_group_code !=''? "AND c.id_company=".$id_company."" :"WHERE c.id_company=".$id_company)."
                ORDER BY id_scheme_account DESC ";
            } 
        } 
        
        //print_r($this->db->last_query());exit;
        return $this->db->query($sql)->row()->lastSchAcc_no;		
    }

	//check reference exists

	function is_refno_exists($ref_no,$schid)

	{

		$this->db->select('ref_no');

		$this->db->where('scheme_acc_number', $ref_no); 

		$this->db->where('id_scheme', $schid); 

		$status=$this->db->get(self::ACC_TABLE);

		if($status->num_rows()>0)

		{

			 return TRUE;

		}

	}

	//get scheme_account by customer

	function is_uniqueCode_exists($id_customer)

	{

		$this->db->select('ref_no');

		$this->db->where('id_customer', $id_customer); 

		$status=$this->db->get(self::ACC_TABLE);

		if($status->num_rows()>0)

		{

			if($status->row()->ref_no=="")

			{

			   return FALSE;	

			}

			else

			{

			   return TRUE;

			}

		}

	}

	function updateUniqueCode($data,$id_customer)

	{

		$this->db->where('id_customer',$id_customer);

		$status=$this->db->update(self::ACC_TABLE,$data);

		return $status;

	}

//for scheme join sms and mail

	function get_customer_acc($id_scheme_acc)

	{

		$accounts=$this->db->query("select

							  sc.id_scheme,maturity_type,s.id_scheme_account,s.id_branch as branch,c.id_branch as cus_reg_branch,sc.code, s.group_code as group_code,sc.sync_scheme_code,

							  if(cs.has_lucky_draw=1 && sc.is_lucky_draw = 1,concat(ifnull(s.group_code,''),'',ifnull(s.scheme_acc_number,'Not allocated')),concat(ifnull(sc.code,''),' ',ifnull(s.scheme_acc_number,'Not allocated'))) as scheme_acc_number,

								  IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,c.firstname,ifnull(s.account_name,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname))) as account_name,s.start_date,c.is_new,c.email,sc.min_amount, sc.max_amount,  							  

							  sc.scheme_type, flexible_sch_type,

							  sc.scheme_name,s.is_new,sc.code,sc.total_installments,sc.max_chance,sc.payment_chances,sc.max_weight,sc.min_weight,

							  sc.amount,c.mobile,if(s.active =1,'Active','Inactive') as active,s.date_add,cs.currency_name,cs.currency_symbol,cs.custom_entry_date,cs.edit_custom_entry_date

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							join chit_settings cs 

							where  s.is_closed=0 and s.id_scheme_account =".$id_scheme_acc);

		return $accounts->row_array();

	}	

	// for all active and not closed records

	function get_all_account()

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,s.scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,s.account_name,s.start_date,c.is_new,c.id_customer,

							  sc.scheme_name,s.is_new,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,sc.max_weight,sc.amount,c.mobile,if(s.active =1,'Active','Inactive') as active,s.date_add

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							where  s.is_closed=0");

		return $accounts->result_array();

	}	

	function get_customer_accounts($id_customer)

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,s.scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,ifnull(s.account_name,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname))) as account_name,s.start_date,c.is_new,

								c.id_branch as cus_ref_branch,s.id_branch as sch_join_branch,

							  sc.scheme_name,s.is_new,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,sc.max_weight,sc.amount,c.mobile,if(s.active =1,'Active','Inactive') as active,s.date_add

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							where  s.is_closed=0 and c.id_customer =".$id_customer);

							//print_r($this->db->last_query());exit;

		return $accounts->result_array();

	}

/*-- Coded by ARVK --*/			 

	function sch_acc_count()

	{

		$sql = "SELECT id_scheme_account FROM scheme_account";

		return $this->db->query($sql)->num_rows();

	}	

	function company_details()

	{

	    $company_settings = $this->session->userdata('company_settings');

        $id_company = $this->session->userdata('id_company');

		$sql = "SELECT * FROM company ".($id_company!='' &&  $company_settings == 1? " WHERE id_company='".$id_company."'":'')."";

		return $this->db->query($sql)->row_array();

	}	

	function otp_insert($data)

	{

		$status = $this->db->insert(self::OTP_TABLE,$data);

		return $status;

	}	

	function otp_update($data,$id)

	{

		$this->db->where('id_sch_acc',$id);

		$status=$this->db->update(self::OTP_TABLE,$data);

		return $status;

	}	

	function otp_select($id)

	{

		$this->db->select('id_sch_acc');

		$this->db->where('id_sch_acc',$id);

		$status=$this->db->get(self::OTP_TABLE);

		if($status->num_rows()>0)

		{

			 return TRUE;

		}

	}	

	function otp_code_select($id)

	{

		$this->db->select('*');

		$this->db->where('id_sch_acc',$id);

		$status=$this->db->get(self::OTP_TABLE);

		return $status->row_array();

	}	

/*-- / Coded by ARVK --*/	

	function get_all_account_details()

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,

							  s.scheme_acc_number,

							  IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name, 					                              

							  c.id_customer,

							  s.ref_no,

							  s.account_name,

							   DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date,

							  c.is_new,

							  sc.scheme_name,

							  s.is_new,

							  sc.code,

							  if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,

							  sc.total_installments,

							  sc.max_chance,

							  sc.max_weight,

							  sc.amount,

							  c.mobile,

							  if(s.active =1,'Active','Inactive') as active,

							  s.date_add,

							  is_opening,

							  IFNULL(cur_pay.curpay_install,0) +  IF(s.is_opening=1, IF(Date_Format(Current_Date(),'%Y%m')=Date_Format(s.last_paid_date,'%Y%m'),1,0),0) AS curpay_install,

							  IFNULL(cur_pay.curpay_amount,0) AS curpay_amount,

							  IFNULL(cur_pay.curpay_weight,0) +  IF(s.is_opening=1 and sc.scheme_type = 1, IF(Date_Format(Current_Date(),'%Y%m')=Date_Format(s.last_paid_date,'%Y%m'),IFNULL(s.last_paid_weight,0),0),0) AS curpay_weight,

							  IFNULL(total_pay.totalpay_install,0) + IF(s.is_opening=1,IFNULL(s.paid_installments,0),0) AS totalpay_install,

							  IFNULL(total_pay.totalpay_amount,0) + IF(s.is_opening=1,IFNULL(s.balance_amount,0),0) AS totalpay_amount,

							  IFNULL(total_pay.totalpay_weight,0) + IF(s.is_opening=1 and sc.scheme_type = 1,IFNULL(balance_weight,0),0) AS totalpay_weight,

							  (IFNULL(cur_pay.chances,0) + IF(Date_Format(Current_Date(),'%Y%m')=Date_Format(s.last_paid_date,'%Y%m'),(s.last_paid_chances),0)) as  chances_used

							FROM

							  ".self::ACC_TABLE." s

							LEFT JOIN ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							LEFT JOIN ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							LEFT JOIN (SELECT id_scheme_account,IFNULL(COUNT(DISTINCT(DATE_FORMAT(date_payment,'%Y%m'))),0) AS curpay_install, SUM(IFNULL(payment_amount,0)) AS curpay_amount, SUM(IFNULL(metal_weight,0)) AS curpay_weight,IFNULL(COUNT(DATE_FORMAT(date_payment,'%Y%m')),0) AS chances FROM ".self::PAY_TABLE." WHERE (payment_status = 0 OR payment_status = 1) AND DATE_FORMAT(date_payment,'%Y%m') = DATE_FORMAT(CURDATE(),'%Y%m') GROUP BY id_scheme_account) AS cur_pay ON cur_pay.id_scheme_account = s.id_scheme_account

							LEFT JOIN (SELECT id_scheme_account,COUNT(DISTINCT(DATE_FORMAT(date_payment,'%Y%m'))) AS totalpay_install, SUM(IFNULL(payment_amount,0)) AS totalpay_amount, SUM(IFNULL(metal_weight,0)) AS totalpay_weight FROM ".self::PAY_TABLE." WHERE (payment_status = 0 OR payment_status = 1) GROUP BY id_scheme_account) AS total_pay ON total_pay.id_scheme_account = s.id_scheme_account

							where  s.is_closed=0

							GROUP BY s.id_scheme_account

							");

		return $accounts->result_array();

	}	

	function get_export_data($filter="",$from_date="",$to_date="")

	{

		$sql="select

							  s.id_scheme_account,s.ref_no,concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,c.mobile,s.start_date,sc.code,s.date_add

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							where s.active=1 and s.is_closed=0 ";

	  switch($filter){

	  	case 0:

	  	         if($from_date!=NULL and $to_date!=NULL)

					{

						$sql=$sql." AND (date(s.date_add) BETWEEN '".$from_date."' AND '".$to_date."') ";

					}

					else

					{

						$sql=$sql." And date(s.date_add) ='".$from_date."'";

					}

	  		break;

	  		case 1:

				  	if($from_date!=NULL and $to_date!=NULL)

				  	{

						$sql=$sql." AND (date(s.date_add)  BETWEEN '".$from_date."' AND '".$to_date."') And s.ref_no IS Not Null";

					}

					else

					{

						$sql=$sql." And date(s.date_add) ='".$from_date."' And  s.ref_no IS Not Null";

					}

	  		break;

	  	case 2:

	  				if($from_date!=NULL and $to_date!=NULL)

					{

						$sql=$sql." AND (date(s.date_add)  BETWEEN '".$from_date."' AND '".$to_date."') And s.ref_no IS NULL";

					}

					else

					{

						$sql=$sql." And date(s.date_add) ='".$from_date."' And s.ref_no IS NULL";

					}

	  		break;

	  	  }					

		return $this->db->query($sql)->result_array();					

	}

//for getting closing request from customer	

	function get_closing_request()

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,s.scheme_acc_number,concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,s.ref_no,s.account_name,s.start_date,sc.one_time_premium,

							  sc.scheme_name,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,sc.amount,c.mobile,

							  (if(s.paid_installments is null,0,s.paid_installments) + if(count(distinct month(p.date_payment)) is null,0,count(distinct month(p.date_payment)))) as paid_installments,

      (if(sc.total_installments is null,0,sc.total_installments) -     (if(s.paid_installments is null,0,s.paid_installments) + if(count(distinct month(p.date_payment)) is null,0,count(distinct month(p.date_payment))))) as pending_installments,

       sc.max_chance,sc.amount,c.mobile,

       if(sc.scheme_type=0,(if(s.balance_amount IS NULL,0,s.balance_amount))+if(sum(p.payment_amount) is null,0,sum(p.payment_amount)),'0.00') as closing_amount,

             if(sc.scheme_type=0,(if(s.balance_amount IS NULL,0,s.balance_amount))+if(sum(p.payment_amount) is null,0,sum(p.payment_amount)),(if(s.balance_weight IS NULL,0,s.balance_weight))+if(sum(p.metal_weight) is null,0,sum(p.metal_weight))) as closing_balance,

       remark_close

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							left join ".self::PAY_TABLE." p on (s.id_scheme_account=p.id_scheme_account)						

							where s.req_close=1 and s.active=1 and s.is_closed=0

							group by s.id_scheme_account ");

		return $accounts->result_array();

	}

/* -- Coded by ARVK -- */

	//for single closed account detail		

	

	//sa.deduction,sa.id_branch, updated code for query staring 05-12-2022	

	 function get_closed_account_by_id($id)

	{

		$account=$this->db->query("select

			sa.deduction,sa.id_branch,sa.id_scheme_account,IFNULL(sa.scheme_acc_number,'Not Allocated') as scheme_acc_number,s.total_installments,

			concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,cs.has_lucky_draw,s.is_lucky_draw,IFNULL(sa.group_code,'')as scheme_group_code,

			IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ IFNULL(if(s.scheme_type = 1 and s.min_weight != s.max_weight , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues)),0), if(s.scheme_type = 1 and s.min_weight != s.max_weight , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues))) ,0)

  as paid_installments,

		c.mobile,sa.account_name,c.nominee_name,c.nominee_mobile,s.scheme_name,			

			 if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight',if(s.scheme_type=3,'FLEXIBLE_AMOUNT','Amount To Weight')))as scheme_type,							  

			s.amount as sch_amt,s.scheme_type as sch_typ,s.code,

			 IFNULL(Date_format(sa.start_date,'%d-%m%-%Y'),'-') as start_date,						  

			 IFNULL(Date_format(sa.closing_date,'%d-%m%-%Y'),'-') as closing_date,		

			(if(sa.balance_amount IS NULL,0,sa.balance_amount))+if(sum(p.payment_amount) is null,0,sum(p.payment_amount)) as total_paid,

			if(s.interest=1,s.total_interest,'0.00') as interest,if(s.tax=1,s.total_tax,'0.00') as tax,

			 if(sum(p.add_charges)!='',sum(p.add_charges),'-') as bank_chgs,

			sa.closing_add_chgs,IFNULL(sa.additional_benefits,0.00) as additional_benefits,

			if(s.scheme_type=0,CONCAT(cs.currency_symbol,' ',(sa.closing_balance)),sa.closing_balance) as closing_balance,

			if(sa.closed_by=1,sa.rep_name,concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')))as closed_by,

			if(sa.closed_by=1,'Nominee','Self')as closedBy,sa.employee_closed,

				(select concat (e.firstname,' ',if(e.lastname!=Null,e.lastname,''))

				from employee e where id_employee=sa.employee_closed) as emp_name,

			if(sa.remark_close!='',sa.remark_close,'-')as remark_close,

			if(sa.closed_by=1,sa.rep_mobile,c.mobile)as otp_verified_mob,cs.currency_symbol,

			s.emp_incentive_closing,s.id_scheme,s.closing_incentive_based_on,sa.id_employee,s.apply_benefit_min_ins

					from  ".self::ACC_TABLE." sa

					left join ".self::CUS_TABLE." c on (sa.id_customer=c.id_customer)

					left join ".self::SCH_TABLE." s on (sa.id_scheme=s.id_scheme)

					left join ".self::PAY_TABLE." p on (sa.id_scheme_account=p.id_scheme_account)

					join chit_settings cs

					where sa.active=0 and sa.is_closed=1 and p.payment_status=1 and sa.id_scheme_account=".$id);

//print_r($this->db->last_query());exit;

			return $account->row_array();

	}

/* /-- Coded by ARVK -- */

	//for all closed account

	 function get_all_closed_account()

	{

		$branchWiseLogin=$this->session->userdata('branchWiseLogin');

		$is_branchwise_cus_reg=$this->session->userdata('is_branchwise_cus_reg');

			$id_branch=$this->session->userdata('id_branch');

			$uid=$this->session->userdata('uid');

			$company_settings=$this->session->userdata('company_settings');

			$id_company=$this->session->userdata('id_company');

		$accounts=$this->db->query("select s.closing_amount,IFNULL(s.closing_weight,'-') as closing_weight,

							  sc.firstPayDisc_value,s.id_scheme_account,sc.code,IFNULL(s.group_code,'')as scheme_group_code,
							  
							 if(cs.scheme_wise_acc_no=3,IF(s.scheme_acc_number is null,concat(b.short_name,sc.code,'-Not Allocated'),concat(b.short_name,sc.code,'-',s.scheme_acc_number)),IF(s.scheme_acc_number is null,'Not Allocated',concat(sc.code,'-',ifnull(concat(s.start_year,'-'),''),s.scheme_acc_number))) as scheme_acc_number,
							  
							  cs.has_lucky_draw,cs.scheme_wise_acc_no,

							  concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,s.is_utilized as is_utilized,

                             s.id_branch,b.name as branchname,

                                (SELECT b.name FROM branch b WHERE b.id_branch = s.closing_id_branch) as Closing_id_branch,

							  s.ref_no, s.closing_add_chgs, s.account_name,

							  IFNULL(Date_format(s.start_date,'%d-%m%-%Y'),'-') as start_date,

							  IFNULL(Date_format(s.closing_date,'%d-%m%-%Y'),'-') as closing_date,

                             if(sc.scheme_type=0 or (sc.scheme_type=3 and sc.flexible_sch_type=1),CONCAT(cs.currency_symbol,' ',s.closing_amount),CONCAT(s.closing_balance,' ',' g')) as closing_balance,

					          e.firstname as employee_closed,

                                c.added_by,sc.scheme_name,sc.code,

							  if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight',if(sc.scheme_type=3,'FLEXIBLE_AMOUNT','Amount To Weight')))as scheme_type,

							  FORMAT(if(sc.scheme_type=1,CONCAT('max ',sc.max_weight,' g/month'),if(sc.scheme_type=3 && sc.max_amount!=0,sc.max_amount,if(sc.scheme_type=3 && sc.max_amount=0,(sc.max_weight*(SELECT m.goldrate_22ct FROM metal_rates m  order by id_metalrates Desc LIMIT 1)),sc.amount))),2) as amount,sc.total_installments,sc.max_chance,c.mobile,

							  IF(sc.scheme_type=1,sc.max_weight,sc.amount) as total_payamt,sc.free_payment,

							  IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 and sc.payment_chances=1) , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues))) ,0)as oldpaid_installments,

							  IFNULL((select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(paymnt.date_payment,'%Y%m')), sum(paymnt.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 and sc.payment_chances=1), COUNT(Distinct Date_Format(paymnt.date_payment,'%Y%m')), sum(paymnt.no_of_dues))) ,0) from payment paymnt where paymnt.payment_status=1 and paymnt.id_scheme_account=p.id_scheme_account group by paymnt.id_scheme_account),0)

					as paid_installments,

                                sum(p.payment_amount) as pay_amount,sum(p.act_amount) as act_amount,s.additional_benefits,s.closing_add_chgs,IFNULL(p.discountAmt,0)as discountAmt,s.closing_add_chgs,sc.show_ins_type

							from

							  ".self::ACC_TABLE." s

                            left join employee e ON (e.id_employee = s.employee_closed) 

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

					    	left join ".self::PAY_TABLE." p on (p.id_scheme_account=s.id_scheme_account)

							left join ".self::BRANCH." b on (b.id_branch=s.id_branch)

							join chit_settings cs

							where s.active=0 ".($id_company!=0 && $company_settings == 1? "and c.id_company=".$id_company."" :'')." and s.is_closed=1 ".($uid!=1 ? ($branchWiseLogin==1||$is_branchwise_cus_reg==1? ($id_branch!='' ?  " and( s.id_branch=".$id_branch." or b.show_to_all=1 )":''):''):'')." group by s.id_scheme_account");

//print_r($this->db->last_query());exit;

		return $accounts->result_array();

	}

		// for all active and not closed records chked&updtd emp login branchwise  data show//HH

	function get_all_account_by_range($from_date,$to_date,$date_type)

	{ 

	    //DGS-DCNM -->chit_detail_days

	    

        $branch_settings=$this->session->userdata('branch_settings');

        $is_branchwise_cus_reg=$this->session->userdata('is_branchwise_cus_reg');

        $branch=$this->session->userdata('id_branch');

        $uid=$this->session->userdata('uid');

        $id_customer  = $this->input->post('id_customer');

        $id_branch  = $this->input->post('id_branch');

        $company_settings=$this->session->userdata('company_settings');

        $id_company = $this->session->userdata('id_company');

        

        $join_days  = $this->input->post('join_days');

        $id_scheme=$this->input->post('id_scheme');

        

        

        /*if($this->session->userdata('branch_settings')==1)

        {

        	$id_branch  = $this->input->post('id_branch');

        }

        else{

        		$id_branch = '';

        }*/

		

		//Old Code 05-12-2022  IFNULL(s.scheme_acc_number,'Not Allocated') as scheme_acc_number old code

		

		//New Code 05-12-2022 IF(s.scheme_acc_number is null,'Not Allocated',concat(sc.code,'-',s.start_year,'-',s.scheme_acc_number)) as scheme_acc_number 

		
        //old code 11.05.2023 IF(s.scheme_acc_number is null,'Not Allocated', if(s.start_year is not null,(concat(s.start_year,'-',s.scheme_acc_number)), s.scheme_acc_number)) as scheme_acc_number,
		
	
        $accounts=$this->db->query("select IFNULL(s.start_year,'') as start_year,(select b.short_name from branch b where b.id_branch = s.id_branch) as acc_branch,sc.code,cs.schemeaccNo_displayFrmt,sc.is_lucky_draw,ifnull(s.scheme_acc_number,'Not Allocated') as scheme_acc_number,cs.scheme_wise_acc_no,
  
  
  IFNULL(s.pan_no,c.pan) as pan_no,cs.has_lucky_draw,date(DATE_ADD(start_date, INTERVAL sc.maturity_days DAY)) as maturity_days,Date_Format(max(pay.date_payment),'%d-%m-%Y') as last_paid_date,

        IFNULL(s.group_code,'-') as group_code,s.fixed_metal_rate,s.fixed_wgt,s.referal_code,b.name as branch_name,

        if(s.show_gift_article=1,'Issued','Not Issueed')as gift, 

        

        (select IF(g.status = 1,'Issued',IF(g.status = 2,'Deducted','-')) from gift_issued g join scheme_account sca on g.id_scheme_account=sca.id_scheme_account where g.id_scheme_account=s.id_scheme_account LIMIT 1) as gift_article,



        s.id_scheme_account,

        

        IF(s.scheme_acc_number is null,'Not Allocated',if(cs.scheme_wise_acc_no=3,s.scheme_acc_number, if(s.start_year is not null,(concat(s.start_year,'-',s.scheme_acc_number)), s.scheme_acc_number))) as oldscheme_acc_number,

        cs.scheme_wise_acc_no,b.short_name,

        IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,s.account_name,DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date,c.is_new,s.added_by,concat('C','',c.id_customer) as id_customer,cs.schemeacc_no_set,

        IF(sc.scheme_type=0 OR sc.scheme_type=2,TRIM(sc.amount),IF(sc.scheme_type=1 ,sc.max_weight,if(sc.scheme_type=3,if(flexible_sch_type = 3 ,  sc.max_weight,if(sc.firstPayamt_as_payamt=1,s.firstPayment_amt ,TRIM(sc.min_amount))),0))) as payable,sc.firstPayamt_as_payamt,s.firstPayment_amt,sc.firstPayamt_maxpayable,

        sc.scheme_name,if(s.is_new ='Y','New','Existing') as is_new,sc.code,IF(sc.scheme_type=0,'Amount',IF(sc.scheme_type=1,'Weight',if(sc.scheme_type=2,'Amount to Weight','Flexible'))) AS scheme_type,sc.total_installments,sc.max_chance,sc.max_weight,sc.amount,c.mobile,if(s.active =1,'Active','Inactive') as active,s.date_add,cs.currency_symbol,sc.scheme_type  as scheme_types,sc.one_time_premium,sc.otp_price_fix_type,s.firstPayment_amt,

IFNULL((select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 AND sc.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=s.id_scheme_account group by pay.id_scheme_account),0) as paid_installments,

        s.custom_entry_date,cs.edit_custom_entry_date,

        IFNULL(e.firstname,'-')  as emp_name,sc.show_ins_type, IF(sc.scheme_type = 0, 'Amount', IF(sc.scheme_type = 1,'Weight',IF(sc.scheme_type = 2,'Amount to Weight',IF(sc.scheme_type = 3, 'Flexible','-')))) as scheme_type,sc.flexible_sch_type,

        a.agent_code,CONCAT(a.firstname,' ',a.lastname) as agent_name,s.id_scheme,sc.max_amount,sc.chit_detail_days as show_wallet

        from

        ".self::ACC_TABLE." s

        left join ".self::CUS_TABLE." c on (c.id_customer=s.id_customer)

        left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

        left join ".self::BRANCH." b on (b.id_branch=s.id_branch)

        left join employee e ON (e.emp_code = s.referal_code AND s.referal_code != '')

        left join agent a ON (a.id_agent = s.id_agent)

        left join ".self::PAY_TABLE." pay on (pay.id_scheme_account=s.id_scheme_account  and (pay.payment_status=2 or pay.payment_status=1))

        join chit_settings cs

        Where s.is_closed=0

        ".($id_customer=='' ? " and date(s.start_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."'" :'')."  

        ".($id_customer!='' ? " and s.id_customer=".$id_customer."":'')."

        ".($id_branch!='' && $id_branch!=0 && $branch==0 ? " and s.id_branch=".$id_branch."":'')."

        ".($id_company!='' && $id_company!=0 && $company_settings==1 ? " and c.id_company=".$id_company."":'')."

        ".($id_scheme!='' ? " and s.id_scheme=".$id_scheme."":'')."

        ".($join_days!='' && $join_days!=0? " AND DATEDIFF(CURDATE(),date(s.start_date)) =".$join_days." AND sc.is_digi= 1":'')."

        ".($uid!=1 ? ($branch_settings==1 ? ($id_branch!=0 && $id_branch!='' ? "and s.id_branch=".$id_branch."" : " and (b.show_to_all=1 or b.show_to_all=3)"):'') : ($id_branch!=0 && $id_branch!=''? "and s.id_branch=".$id_branch."" :''))."

        

        group by s.id_scheme_account"); 

       // print_r($this->db->last_query());exit;
        return $accounts->result_array();

	}	

function get_all_closed_accdetails($id)

	{

		$sql="select
							 s.min_amount,s.max_amount,
							  s.id_scheme_account,IFNULL(s.scheme_acc_number,'Not Allocated') as scheme_acc_number,

							  concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,

							  s.ref_no, s.closing_add_chgs, s.account_name,

							  IFNULL(Date_format(s.start_date,'%d-%m%-%Y'),'-') as start_date,

							  IFNULL(Date_format(s.closing_date,'%d-%m%-%Y'),'-') as closing_date,

							  if(sc.scheme_type=0,CONCAT(cs.currency_symbol,' ',s.closing_balance),CONCAT(s.closing_balance,' ',' g')) as closing_balance,

							  c.added_by,sc.scheme_name,sc.code,

							  if(sc.scheme_type=1,CONCAT('max ',sc.max_weight,' g/month'),sc.amount) as amount,

							  if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,c.mobile

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							join chit_settings cs

							where s.active=0 and s.is_closed=1 and c.id_customer=".$id."

							ORDER by s.id_scheme_account DESC Limit 1 ";

		 $account=$this->db->query($sql);	   

		return $account->row_array();

	}

	function get_all_closed_acccount($id)

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,IFNULL(s.scheme_acc_number,'Not Allocated') as scheme_acc_number,

							  concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,

							  s.ref_no, s.closing_add_chgs, s.account_name,

							  IFNULL(Date_format(s.start_date,'%d-%m%-%Y'),'-') as start_date,

							  IFNULL(Date_format(s.closing_date,'%d-%m%-%Y'),'-') as closing_date,

							  if(sc.scheme_type=0 or (sc.scheme_type=3 and sc.flexible_sch_type=1),CONCAT(cs.currency_symbol,' ',s.closing_balance),CONCAT(s.closing_balance,' ',' g')) as closing_balance,

							  c.added_by,sc.scheme_name,sc.code,

							  if(sc.scheme_type=1,CONCAT('max ',sc.max_weight,' g/month'),sc.amount) as amount,

							  if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,c.mobile

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							join chit_settings cs

							where s.active=0 and s.is_closed=1 and c.id_customer=".$id."");

		return $accounts->num_rows();

	} 

	function get_closed_acc_by_range($from_date,$to_date)

	{

	    

	    $company_settings = $this->session->userdata('company_settings');

        $id_company = $this->session->userdata('id_company');

        

			if($this->branch_settings==1){

				$id_branch  = $this->input->post('id_branch');

				$close_id_branch  = $this->input->post('close_id_branch');

				//print_r($close_id_branch);exit;

				}

			else{

			$id_branch = '';}

		    	$id_employee  = $this->input->post('id_employee');

				

				//(old Code  sa.scheme_acc_number) (New code IFNULL(concat(s.code,'-',sa.start_year,'-',sa.scheme_acc_number),'Not Allocated') as scheme_acc_number_

				 

				 //old code 11/05/2023 IFNULL(concat(sc.code,'-',ifnull(concat(s.start_year,'-'),''),s.scheme_acc_number),'Not Allocated') as scheme_acc_number

		$accounts=$this->db->query("select
				
							  s.id_scheme_account,s.closing_amount,IFNULL(s.closing_weight,'-') as closing_weight,

							  if(cs.scheme_wise_acc_no=3,IF(s.scheme_acc_number is null,concat(b.short_name,sc.code,'-Not Allocated'),concat(b.short_name,sc.code,'-',s.scheme_acc_number)),IF(s.scheme_acc_number is null,'Not Allocated',concat(sc.code,'-',ifnull(concat(s.start_year,'-'),''),s.scheme_acc_number))) as scheme_acc_number,
							  cs.scheme_wise_acc_no,

							  ,concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,s.ref_no,s.account_name, e.firstname as employee_closed,IFNULL(Date_format(s.start_date,'%d-%m%-%Y'),'-') as start_date,IFNULL(Date_format(s.closing_date,'%d-%m%-%Y'),'-') as closing_date,if(sc.scheme_type=0 or (sc.scheme_type=3 and sc.flexible_sch_type=1),CONCAT(cs.currency_symbol,' ',s.closing_balance),CONCAT(s.closing_balance,' ',' g')) as closing_balance,c.added_by,

                              s.is_utilized as is_utilized,

                                 s.id_branch,b.name as branchname,

                                (SELECT b.name FROM branch b WHERE b.id_branch = s.closing_id_branch) as Closing_id_branch,

							  sc.scheme_name,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,
							  if(sc.amount!=0,sc.amount,'-') as amount,c.mobile,sc.scheme_type as sch_typ, IF(sc.scheme_type=1,sc.max_weight,sc.amount) as total_payamt,

							  IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 and sc.payment_chances=1) , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues))) ,0)as paid_installments,

                              sum(p.payment_amount) as pay_amount,sum(p.act_amount) as act_amount,s.additional_benefits,s.closing_add_chgs,IFNULL(p.discountAmt,0)as discountAmt,s.closing_add_chgs,sc.free_payment,sc.firstPayDisc_value,sc.show_ins_type,

                             g.status as gift_status,sc.cus_deduct_ins,IFNULL(s.closing_benefits,'-') as closing_benefits, s.closing_interest_val,sc.scheme_type as sch_type,sc.flexible_sch_type

							from

							  ".self::ACC_TABLE." s

							left join employee e ON (e.id_employee = s.employee_closed) 

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							left join ".self::PAY_TABLE." p on (p.id_scheme_account=s.id_scheme_account)

							left join ".self::BRANCH." b on (b.id_branch=s.id_branch)

							left join gift_issued g on (g.id_scheme_account=s.id_scheme_account)

							join chit_settings cs

							 Where ( s.active=0 and s.is_closed=1 and  date(s.closing_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')

                            and p.payment_status=1

							 ".($id_branch!=NULL?' and s.id_branch ='.$id_branch:'')." 

							  ".($close_id_branch!=NULL?' and s.Closing_id_branch ='.$close_id_branch:'')."

							  ".($id_company!='' &&  $company_settings == 1? " and c.id_company='".$id_company."'":'')."

							 ".($id_employee!='' ? " and s.employee_closed='".$id_employee."'":'')." 

							 group by s.id_scheme_account");	

							//print_r($this->db->last_query());exit;

		return $accounts->result_array();

	}

	function get_all_scheme_account($mobile)

	{

	    //DGS-DCNM -->sc.chit_detail_days as show_wallet

	    

		$branchwiselogin=$this->session->userdata('branchWiseLogin');

		$is_branchwise_cus_reg=$this->session->userdata('is_branchwise_cus_reg');

		$id_branch=$this->session->userdata('id_branch');

		$uid=$this->session->userdata('uid');

		$accounts=$this->db->query("select IFNULL(s.pan_no,'-') as pan_no,sc.one_time_premium,sc.otp_price_fix_type,s.firstPayment_amt,sc.rate_select,sc.rate_fix_by,

								sc.code,IFNULL(s.group_code,'')as scheme_group_code,cs.has_lucky_draw, sc.is_lucky_draw,Date_Format(s.start_date,'%Y-%m-%d') as join_date,

							  s.id_scheme_account,IFNULL(s.scheme_acc_number,'Not Allocated') as scheme_acc_number ,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,s.account_name,DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date,c.is_new,s.added_by,concat('C','',c.id_customer) as id_customer,

							  sc.scheme_name,if(s.is_new ='Y','New','Existing') as is_new,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight',if(sc.scheme_type=3,'FLEXIBLE_AMOUNT','Amount To Weight')))as scheme_type,cs.schemeacc_no_set,sc.flexible_sch_type,

							  FORMAT(if(sc.scheme_type=1,sc.max_weight,if(sc.scheme_type=3 && sc.max_amount!=0,sc.max_amount,if(sc.scheme_type=3 && sc.max_amount=0,(sc.max_weight*(SELECT m.goldrate_22ct FROM metal_rates m  order by id_metalrates Desc LIMIT 1)),sc.amount))),2) as amount,

							  if(s.show_gift_article=1,'Issued','Not Issueed')as gift_article,

							  sc.scheme_type  as scheme_types,sc.one_time_premium,sc.otp_price_fix_type,s.firstPayment_amt,

							  sc.total_installments,sc.max_chance,sc.max_weight,c.mobile,if(s.active =1,'Active','Inactive') as active,s.date_add,cs.currency_symbol,

							  (select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 AND sc.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=s.id_scheme_account group by pay.id_scheme_account) as paid_installments,

							  sc.show_ins_type,sc.scheme_type,sc.flexible_sch_type,sc.chit_detail_days as show_wallet

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							left join ".self::PAY_TABLE." pay on (pay.id_scheme_account=s.id_scheme_account  and (pay.payment_status=2 or pay.payment_status=1))

							left join branch b on (b.id_branch=s.id_branch)

							join chit_settings cs

							Where s.is_closed=0 and  ".($uid!=1 ? ($branchwiselogin==1||$is_branchwise_cus_reg?($id_branch!=''? 

								"and s.id_branch=".$id_branch." or b.show_to_all=1 ":'') :'') :($id_branch!=''? 

								"and s.id_branch=".$id_branch:''))." c.mobile like '".$mobile."%' 

							group by s.id_scheme_account");

			//print_r($this->db->last_query());exit;

		return $accounts->result_array();

	}

	function get_pay_detail($id)

	{

		$this->db->select('id_scheme_account,account_name,scheme.amount');

		$this->db->join(self::SCH_TABLE,"scheme_account.id_scheme=scheme.id_scheme");

		$this->db->where('id_scheme_account',$id);

		$pay=$this->db->get(self::ACC_TABLE);

		return $pay->row_array();

	}

	function get_account_numbers()

	{

		$this->db->select('id_scheme_account,account_name,ref_no');

		$this->db->where('closed_by');

		$accounts=$this->db->get(self::ACC_TABLE);

		return $accounts->result_array();

	}

	function get_accounts_range($lower,$upper)

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,s.scheme_acc_number,concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,s.ref_no,s.account_name,s.start_date,c.email,

							  sc.scheme_name,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,sc.total_installments,sc.max_chance,sc.amount,c.mobile,s.id_customer

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							where s.active=1 and s.is_closed=0 and 

							id_scheme_account Between ".$lower." and ".$upper."

							group by s.id_customer");

		return $accounts->result_array();

	}

	function getSchemeAccountByCustomerID($id_customer)

	{

		$this->db->select('id_scheme_account');

		$this->db->where('id_customer',$id_customer);

		$id_scheme_account=$this->db->get(self::ACC_TABLE);

		if($id_scheme_account->num_rows()==1)

		{

		  return $id_scheme_account->row()->id_scheme_account;

		}

		else

		{

		  return 0;

		}

	}

    function get_close_account($id)

    {

        //DGS-DCNM --> DATEDIFF(CURDATE(),date(sa.start_date)) as date_difference,s.restrict_payment,s.scheme_type as sch_type,

        

		//(Old code 05-12-2022 sa.scheme_acc_number)

		

		//New Code 05-12-2022 IFNULL(concat(s.code,'-',sa.start_year,'-',sa.scheme_acc_number),'Not Allocated') as scheme_acc_number,  

        //old code 11/05/2023 IFNULL(concat(s.code,'-',sa.start_year,'-',sa.scheme_acc_number),'Not Allocated') as scheme_acc_number,

		

    	$account=$this->db->query("select  SUM(p.payment_amount) as closing_paidAmt, SUM(p.metal_weight) as closing_paidWgt, DATEDIFF(CURDATE(),date(sa.start_date)) as date_difference,s.restrict_payment,s.scheme_type as sch_type,

    	

    	s.flexible_sch_type,s.apply_benefit_by_chart,sa.is_refferal_by,sa.referal_code,

    	sa.id_scheme_account,c.id_customer,concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,

    	sa.additional_benefits,sa.closing_add_chgs,sa.closing_weight,sa.closing_balance as closing_amount,s.apply_debit_on_preclose,sa.id_scheme,

    	c.cus_img,sa.ref_no,
    	
    	 if(cs.scheme_wise_acc_no=3,if(sa.scheme_acc_number is not NULL && sa.scheme_acc_number!='',concat(br.short_name,s.code,'-',sa.scheme_acc_number),concat(br.short_name,s.code,'- Not Allocated')),IFNULL(concat(s.code,'-',sa.start_year,'-',sa.scheme_acc_number),'Not Allocated')) as scheme_acc_number,
    	
    	sa.account_name,c.nominee_name,c.nominee_mobile,c.firstname,one_time_premium,

    	sa.start_date,s.scheme_name,s.code,c.email,s.min_weight,s.max_weight,

    	if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight',if(scheme_type=2,'Amt to Wgt','FLXEBLE_AMOUNT')))as scheme_type,s.total_installments,s.amount,s.scheme_type as sch_typ,s.wgt_convert,s.apply_benefit_min_ins,

    	ifnull(if(s.interest=1 && s.scheme_type=0,s.total_interest,interest_weight),'0.00') as interest,s.interest_by,

    	if(s.tax=1,s.total_tax,'0.00') as tax,

    	(select IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ IFNULL(if(s.scheme_type = 1 and s.min_weight != s.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(s.scheme_type = 1 and s.min_weight != s.max_weight or s.scheme_type=3, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=p.id_scheme_account group by pay.id_scheme_account)

					   as paid_installments,

    	(s.total_installments -IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ IFNULL(if(s.scheme_type = 1 and s.min_weight != s.max_weight , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues)),0), if(s.scheme_type = 1 and s.min_weight != s.max_weight , COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), sum(p.no_of_dues))) ,0))

    	as pending_installments,

    	sum(CASE

    	WHEN p.due_type = 'PC' THEN 1

    	ELSE 0

    	END )AS pre_close_payments,s.preclose_benefits,

    	(select count(id_scheme_account) from payment where (payment_status=2 or payment_status=7) and id_scheme_account=sa.id_scheme_account) as unapproved_payment,s.allow_preclose,s.preclose_months,IFNULL((select sum(charges) from postdate_payment where id_scheme_account=sa.id_scheme_account),0.00) as bank_chgs,

    	s.max_chance,s.amount,c.mobile,sa.closing_deductions,

    	sum(p.payment_amount) as closing_amount,

    	flexible_sch_type,if(s.scheme_type=0 or s.scheme_type=3 ,if(s.flexible_sch_type = 3 || (s.flexible_sch_type = 2 && s.wgt_store_as = 1), if(sa.balance_weight IS NULL,0,sa.balance_weight)+if(sum(p.metal_weight) is null,0,sum(p.metal_weight)), if(sa.balance_amount IS NULL,0,sa.balance_amount)+if(s.one_time_premium=1 and s.flexible_sch_type=4,sa.fixed_wgt,sum(p.payment_amount)) ),(if(sa.balance_weight IS NULL,0,sa.balance_weight))+if(sum(p.metal_weight) is null,0,sum(p.metal_weight))) as closing_balance,

    	s.payment_chances,

    	IFNULL(sum(p.add_charges),0.00) as charges,

    	sa.remark_close,(select enable_closing_otp from chit_settings) as enable_closing_otp,(select enable_closing_otp from chit_settings) as currency_symbol,

    	s.firstPayDisc_value,sum(p.payment_amount) as cus_paid_amount,sum(p.metal_weight) as cus_paid_weight,sa.fixed_wgt,

    	s.apply_benefit_min_ins,s.emp_refferal,s.emp_deduct_ins,s.agent_refferal,s.agent_deduct_ins

    	from  ".self::ACC_TABLE." sa

    	left join ".self::CUS_TABLE." c on (c.id_customer=sa.id_customer)

    	left join ".self::SCH_TABLE." s on (s.id_scheme=sa.id_scheme)

    	left join ".self::PAY_TABLE." p on (p.id_scheme_account=sa.id_scheme_account)
    	left join (SELECT id_branch,short_name as short_name FROM branch) br on br.id_branch = sa.id_branch

    	join chit_settings cs

    	where sa.active=1 and sa.is_closed=0 and p.payment_status=1 and sa.id_scheme_account=".$id);

    //	print_r($this->db->last_query());exit;

    	return $account->row_array();	

    }

	//Get particular account detail

	function get_account_open($id)

	{
	    // old code 11/05/2023 concat(if(cs.has_lucky_draw=1,sa.group_code,s.code),' ', IFNULL(sa.scheme_acc_number,'Not Allocated')) as scheme_acc_number,

		$sql="SELECT sa.`id_scheme_account`, if(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as customer,c.mobile,c.passwd,s.scheme_name,s.scheme_type,sa.`id_scheme`, sa.`id_customer`, sa.show_gift_article,sa.firstPayment_amt,cs.get_amt_in_schjoin,

		 

		
        if(cs.scheme_wise_acc_no=3,if(sa.scheme_acc_number is not NULL,concat(b.short_name,s.code,'-',sa.scheme_acc_number),concat(b.short_name,s.code,'-Not Allocated')),concat(if(cs.has_lucky_draw=1,sa.group_code,s.code),' ', IFNULL(sa.scheme_acc_number,'Not Allocated'))) as scheme_acc_number,
		 

		 sa.`id_branch`,

				sa.`is_refferal_by`,sa.`referal_code`,cs.`schemeacc_no_set`,IFNULL(sa.scheme_acc_number,'Not Allocated')as acc_number,

				

				if(cs.has_lucky_draw=1,sa.group_code,s.code) as code,

				

		`account_name`, sa.`is_new`,IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ IFNULL(if(s.scheme_type = 1 and s.min_weight != s.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(s.scheme_type = 1 and s.min_weight != s.max_weight or s.scheme_type=3, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0)

  as `paid_installments`,sa.paid_installments as previous_paid,c.email, 

        DATE_FORMAT(maturity_date, '%d-%m-%Y') as maturity_date, 

		DATE_FORMAT(start_date, '%d-%m-%Y') as start_date, `employee_approved`, `remark_open`

		, `is_opening`,`balance_amount`,`balance_weight`,`last_paid_date`, `last_paid_weight`,`last_paid_chances`,sa.active,s.amount,

		IF(s.scheme_type=0 OR s.scheme_type=2,s.amount,IF(s.scheme_type=1 ,CONCAT('max ',s.max_weight,' g/month'),if(s.scheme_type=3,if(flexible_sch_type = 3 ,  CONCAT('max ',s.max_weight,' g/month'),if(s.firstPayamt_as_payamt=1,sa.firstPayment_amt ,s.min_amount)),0))) as payable,

                    a.address1 as address1,

                    a.address2 as address2,

                    a.address3 as address3,st.name as state,ct.name as city,cy.name as country,a.pincode

		FROM (`".self::ACC_TABLE."` sa)

		JOIN chit_settings cs 

		LEFT JOIN customer c ON (sa.id_customer=c.id_customer)

		LEFT JOIN scheme s ON (sa.id_scheme=s.id_scheme) 

		LEFT JOIN ".self::PAY_TABLE." pay on (pay.id_scheme_account=sa.id_scheme_account  and (pay.payment_status=2 or pay.payment_status=1))
        
        left join branch b on b.id_branch=sa.id_branch
		left join address  a on(a.id_customer=c.id_customer)

        left join country cy on (a.id_country=cy.id_country)

        left join state st on (a.id_state=st.id_state)

        left join city ct on (a.id_city=ct.id_city)

        left join village v on v.id_village=c.id_village

		WHERE sa.`id_scheme_account` =".$id;

		 $account=$this->db->query($sql);	   

//print_r($sql);exit;

		return $account->row_array();	

	}

	function get_account_detail($id_scheme_account)

	{

		//old code 05-12-2022 (select sum(pay.payment_amount) from payment pay where pay.payment_status=1 and pay.id_scheme_account=p.id_scheme_account group by pay.id_scheme_account) as closing_amount,

		

		//New code cls.classification_name

		//New Code 05-12-2022 ((select sum(pay.payment_amount) from payment pay where pay.payment_status=1 and pay.id_scheme_account=p.id_scheme_account group by pay.id_scheme_account)+(ifnull((if(IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ if(s.scheme_type = 1, COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), SUM(p.no_of_dues)), if(s.scheme_type = 1, COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), SUM(p.no_of_dues))),0)=s.total_installments,if(s.scheme_type=0,if(s.interest=1,s.total_interest,'0.00'),if(s.interest=1,s.interest_weight,'0.000')),0.00)+sa.additional_benefits),'0.00'))-ifnull((sa.closing_add_chgs+ifnull(sum(p.add_charges),'0.00')+if(s.tax=1,s.total_tax,'0.00')),0.00) )as closing_amount,
        //old code 11.05.2023 IFNULL(concat(s.code,'-',sa.start_year,'-',sa.scheme_acc_number),'Not Allocated') as scheme_acc_number,




		$sql="SELECT IFNULL(sa.start_year,'') as start_year,(select b.short_name from branch b where b.id_branch = sa.id_branch) as acc_branch,s.code,cs.schemeaccNo_displayFrmt,s.is_lucky_draw,ifnull(sa.scheme_acc_number,'Not Allocated') as scheme_acc_number,cs.scheme_wise_acc_no,

		
		            s.min_amount,s.max_amount,
		

		            c.id_customer,sa.remark_open,sa.is_closed,

		            s.one_time_premium,s.description,cls.classification_name,

					c.cus_img,chit.bill_id,b.bill_no,Date_Format(sa.closing_date,'%d-%m-%Y') as closing_date,

					s.scheme_name,s.code,cs.has_lucky_draw,sa.closing_balance as closing_balance,s.otp_price_fixing,sa.fixed_metal_rate,DATE_FORMAT(sa.fixed_rate_on,'%d-%m-%Y') as fixed_rate_on,sa.firstPayment_amt,IFNULL(sa.fixed_wgt,0) as fixed_wgt,IFNULL(sa.fixed_metal_rate,0) as fixed_metal_rate,

					IFNULL(sa.group_code,'')as group_code,s.code,

					if(cs.has_lucky_draw=1,concat(concat(ifnull(sa.group_code,''),' ',ifnull(sa.scheme_acc_number,'Not Allocated')),' - ',s.code ),concat(s.code,ifnull(sa.scheme_acc_number,'Not Allcoated')))as scheme_acc_number1,

					IFNULL(if(cs.scheme_wise_acc_no=3,sa.scheme_acc_number,concat(s.code,'-',sa.start_year,'-',sa.scheme_acc_number)),'Not Allocated') as oldscheme_acc_number,
					
					ifnull((sa.closing_add_chgs+ifnull(sum(p.add_charges),'0.00')+if(s.tax=1,s.total_tax,'0.00')),0.00)as deductions,

					ifnull((if(IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ if(s.scheme_type = 1, COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), SUM(p.no_of_dues)), if(s.scheme_type = 1, COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), SUM(p.no_of_dues))),0)=s.total_installments,if(s.scheme_type=0,if(s.interest=1,s.total_interest,'0.00'),if(s.interest=1,s.interest_weight,'0.000')),0.00)+sa.additional_benefits),'0.00') as benefits,					

					if(sa.is_closed=1 AND sa.active=0,CONCAT('Closed on',' ',Date_Format(sa.closing_date,'%d-%m-%Y')),'Active')  as status,sa.is_closed,

					sa.account_name,

					ifnull(c.firstname,concat(c.firstname,' ',c.lastname))as customer_name,

					c.mobile,

					DATE_FORMAT(sa.`start_date`,'%d-%m-%Y') as start_date,

                    if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight',if(s.scheme_type=2,'Amount to Weight',if(s.flexible_sch_type=2,'Flexible Amount',IF(s.flexible_sch_type = 3 , 'Flexible Weight','Flexible'))))) as scheme_type,

					s.code as scheme_code,

					s.total_installments,s.max_weight,s.maturity_installment,s.maturity_days,IFNULL(DATE_FORMAT(sa.maturity_date,'%d-%m-%Y'),'') as maturity_date,

					 IF(s.scheme_type=0 OR s.scheme_type=2,s.amount,IF(s.scheme_type=1 ,CONCAT('max ',s.max_weight,' g/month'),if(s.scheme_type=3,if(flexible_sch_type = 3 ,  CONCAT('max ',s.max_weight,' g/month'),if(s.firstPayamt_as_payamt=1,sa.firstPayment_amt ,s.min_amount)),0))) as payable,

					a.address1 as address1,

					a.address2 as address2,

					a.address3 as address3,st.name as state,ct.name as city,cy.name as country,a.pincode,

					if(sa.balance_amount is null,0,sa.balance_amount) as balance_amount,

					if(sa.balance_weight is null,0,sa.balance_weight) as balance_weight,

					s.scheme_type as type,s.amount,s.flexible_sch_type,((select sum(pay.payment_amount) from payment pay where pay.payment_status=1 and pay.id_scheme_account=p.id_scheme_account group by pay.id_scheme_account)+(ifnull((if(IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ if(s.scheme_type = 1, COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), SUM(p.no_of_dues)), if(s.scheme_type = 1, COUNT(Distinct Date_Format(p.date_payment,'%Y%m')), SUM(p.no_of_dues))),0)=s.total_installments,if(s.scheme_type=0,if(s.interest=1,s.total_interest,'0.00'),if(s.interest=1,s.interest_weight,'0.000')),0.00)+sa.additional_benefits),'0.00'))-ifnull((sa.closing_add_chgs+ifnull(sum(p.add_charges),'0.00')+if(s.tax=1,s.total_tax,'0.00')),0.00) )as closing_amount,

					cs.currency_name,

                    cs.currency_symbol,

                    sa.paid_installments as ins,

				    paid.paid_ins as oldpaid_installments,

				    IFNULL((select IFNULL(IF(sa.is_opening=1,IFNULL(sa.paid_installments,0)+ IFNULL(if(s.scheme_type = 1 and s.min_weight != s.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(s.scheme_type = 1 and s.min_weight != s.max_weight or (s.scheme_type=3 AND s.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=sa.id_scheme_account group by pay.id_scheme_account),0) as paid_installments,IFNULL(v.village_name,'') as village_name,

				    classification_name,flexible_sch_type,s.min_weight,

				    br.branch,br.address1 as brn_address1,br.address2 as brn_address2,br.state as brn_state, br.city as brn_city,br.country as brn_country,br.pincode as brn_pincode,

				    bil.pur_ref_no,p.receipt_no,

				    p.payment_amount,IFNULL(sa.pan_no,c.pan) as pan_no,s.show_ins_type,c.email,cs.scheme_wise_acc_no,br.short_name


				from customer c

					left join address  a on(a.id_customer=c.id_customer)

					left join country cy on (a.id_country=cy.id_country)

					left join state st on (a.id_state=st.id_state)

					left join city ct on (a.id_city=ct.id_city)

					left join village v on v.id_village=c.id_village

					left join scheme_account sa on(sa.id_customer=c.id_customer)

					left join scheme s on(s.id_scheme=sa.id_scheme)

					left join sch_classify cls on cls.id_classification = s.id_classification

					left join ret_billing_chit_utilization chit on chit.scheme_account_id=sa.id_scheme_account

                    left JOIN ret_billing b on b.bill_id=chit.bill_id

					left join payment p on(sa.id_scheme_account=p.id_scheme_account and p.payment_status=1)

					left join (

					        SELECT pom.id_payment,bill_no,pur_ref_no from ret_billing bill  

					            LEFT JOIN payment_old_metal pom on pom.bill_id = bill.bill_id

					) bil on bil.id_payment = p.id_payment

					left join (

					        SELECT id_branch,brn.name as branch,address1,address2,sta.name as state,cit.name as city,co.name as country,pincode,short_name as short_name

                            FROM `branch` brn

                                left join country co on (brn.id_country=co.id_country)

                                left join state sta on (brn.id_state=sta.id_state)

                                left join city cit on (brn.id_city=cit.id_city)

					) br on br.id_branch = sa.id_branch

					left join ( select sch.id_scheme_account , 

						IFNULL(IF(sch.is_opening=1,IFNULL(sch.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight , COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 and sc.payment_chances=1) , COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0)as paid_ins

					 From payment pay Left Join scheme_account sch on(pay.id_scheme_account=sch.id_scheme_account) 

					Left Join scheme sc on(sc.id_scheme=sch.id_scheme) Where (pay.payment_status=2 or pay.payment_status=1) Group By sch.id_scheme_account) paid on (sa.id_scheme_account=paid.id_scheme_account ) 

					join chit_settings cs

				WHERE sa.id_scheme_account='$id_scheme_account' group by sa.id_scheme_account";

			//	 echo $sql;exit;

		$account=$this->db->query($sql);	   

		return $account->row_array();	

	}

	function get_ac_paid_details($id_scheme_account)

	{  

	    $this->db->query("SET @a:=0");

		$sql = "SELECT

		          @a := @a + 1 as ins,

				  p.id_payment,p.gst,p.gst_type,concat(ifnull(concat(p.receipt_year,'-'),''),p.receipt_no) as receipt_no,

				  DATE_FORMAT(p.date_payment,'%d-%m-%y') as date_payment,is_print_taken,sa.group_code,

				  p.id_scheme_account,

				  p.metal_rate,

				  (IFNULL(p.payment_amount,0)+IFNULL(p.old_metal_amount,0)) as payment_amount,

				  if(p.added_by=3,p.payment_type,p.payment_mode) as payment_mode,p.metal_weight,if(p.remark = '','-',p.remark) as remark

				FROM payment p

				left join scheme_account sa on sa.id_scheme_account=p.id_scheme_account

				 WHERE p.id_scheme_account = ".$id_scheme_account." AND p.payment_status=1 AND receipt_no is not null";

				

		$payments = $this->db->query($sql);

	    return $payments->result_array();

	}

	function insert_sync($data)

	{

		$status = $this->db->insert(self::SYNC_TABLE,$data);

		return $status;

	}

	function insert_account($data)

	{   

		//$data['scheme_acc_number']=NULL;

		/* Coded by ARVK*/				

		$sql_scheme = $this->db->query("select s.approvalReqForFP,receipt_no_set, s.free_payment, s.amount, s.scheme_type, s.min_weight, s.max_weight, c.company_name, c.short_code  ,s.gst,s.gst_type

	  			from scheme s join company c

	  			join chit_settings cs		

	  			where s.id_scheme=".$data['id_scheme']);

	  	$sch_data = $sql_scheme->row_array();

/* / Coded by ARVK*/

		 $flag=$this->db->insert(self::ACC_TABLE,$data);

		 $status = array('status' => $flag,'sch_data' => $sch_data,

		                  'insertID' => $this->db->insert_id());

		return $status;

	}

	//returns last insert id

	function import_insert_account($data)

	{   

		/*$scheme_acc_number=$this->account_number_generator($data['id_scheme']);

		if($scheme_acc_number!=NULL)

		{

			$data['scheme_acc_number']=$scheme_acc_number;

		}*/

		$status=$this->db->insert(self::ACC_TABLE,$data);

		return ($status?$this->db->insert_id():$status);

	}

	function update_account($data,$id)

	{

		$this->db->where('id_scheme_account',$id);

		$status=$this->db->update(self::ACC_TABLE,$data);

		return $status;

	}

	 //acc no & clientid upd to cus reg tab//HH

		function update_cusreg($data,$id)

	   {

        $this->db->where('id_scheme_account',$id);

		$status=$this->db->update(self::CUSREG_TABLE,array('scheme_ac_no' => $data['scheme_acc_number'],'group_code' => $data['sync_scheme_code'],'clientid' => $data['ref_no']));

		  //  print_r($this->db->last_query());exit;

     	return $status;

         }

       //acc no upd to cus reg tab//

//Receipt no upd to Trans tab//HH

		function update_trans($data,$id)

	{

		$this->db->where('id_scheme_account',$id); 

		$status=$this->db->update(self::TRANS_TABLE,array('client_id' => $data['ref_no']));

		//print_r($this->db->last_query());exit;

		return $status;

	}

	//Receipt no upd to Trans tab//

	function update_reg_status($data,$id)

	{

		$this->db->where('id_register',$id);

		$status=$this->db->update(self::REG_TABLE,$data);

		return $status;

	}

function delete_account($id)

	{

		$data=$this->check_payment($id);

		if($data['status']==1)

		{

			$this->backupRecTobeDeleted("id_scheme_account",$id,"scheme_account","deleted_scheme_account");

			$this->db->where('id_scheme_account',$id);

			$status=$this->db->delete(self::ACC_TABLE);

			//print_r($this->db->last_query());exit;

			$status=array("status" => 1);

		}

		else

		{

			$status=array("status" => 0);

		}

		return $status;

	}

	function check_payment($id)

	{

		$query =$this->db->query("SELECT p.id_scheme_account FROM payment p where p.id_scheme_account=".$id."");

		if($query->num_rows()>0)

		{

			   return array("status" => 0);

		}

		else

		{

			   return array("status" => 1);

		}

	}

	//delete associated payments

	function delete_payment($data,$id)

	{

		$this->backupRecTobeDeleted("id_scheme_account",$id,"payment","deleted_payments");

		$this->db->where('id_scheme_account',$id);

		$status=$this->db->delete(self::PAY_TABLE,$data);

		return $status;

	}

	public function backupRecTobeDeleted($where_field,$value,$from_table,$to_table)

	{		

		$this->db->where($where_field,$value);

		$payments = $this->db->get($from_table);

        foreach ($payments->result() as $row) {

        	if ($this->db->table_exists($to_table)) {

		        // table exists (Your query)

		        $this->db->insert($to_table,$row);

		    }else{

				// Create table

			}

              

        }

	}

	function get_registration_details()

	{

		$registration=$this->db->query("select

					  id_register,

					  concat(c.firstname,' ',c.lastname) as name,c.mobile,ct.name as city,

					  s.code,if(s.scheme_type=0,'Amount',if(s.scheme_type=1,'Weight','Amount to Weight'))as scheme_type,s.amount,

					  r.id_customer,r.id_scheme,date_register,c.profile_complete

					from ".self::REG_TABLE." r

					left join ".self::CUS_TABLE." c on (r.id_customer=c.id_customer)

					left join ".self::SCH_TABLE." s on (r.id_scheme=s.id_scheme)

					left join ".self::ADD_TABLE." a on (c.id_customer=a.id_customer)

					left join city ct on (a.id_city=ct.id_city)

					where r.is_approved=0");

		return $registration->result_array();

	}

	//to get id_scheme_account by id_payment

	function getSchemeAccountByPayment($id_payment)

	{

		$sql="Select

				  sa.id_scheme_account

			From payment p

			Left join scheme_account sa On (p.id_scheme_account = sa.id_scheme_account)

			Where p.id_payment='$id_payment';";

		$account=$this->db->query($sql);	   

		return $account->row_array();

	}

	//ref_no in scheme_account

	function clientid_exists($id_scheme_account)

	{		

		$sql = "select ref_no from scheme_account where id_scheme_account = ".$id_scheme_account;

		$account = $this->db->query($sql);	

		if($account->num_rows()>0 && $account->row()->ref_no != '')

		{

			return array("status" => TRUE, "client_id" => $account->row()->ref_no );

		}

		else

		{

			return array("status" => FALSE);

		}	

	}

	/*function branchname_list()

    {		

		$id_branch = $this->session->userdata('id_branch');	

		if( $id_branch !='' )

		{

			$branch=$this->db->query("SELECT b.name,b.id_branch FROM branch b Where id_branch=".$id_branch);	

		}

		else

		{

			$branch=$this->db->query("SELECT b.name,b.id_branch FROM branch b");

		}

		return $branch->result_array();	

	}*/	

    function branchname_list()

    {		

		$id_branch = $this->session->userdata('id_branch');	

		//$id_branch = 0;

		if($id_branch !='' && $id_branch !=0)

		{

			$branch=$this->db->query("SELECT b.is_ho,b.name,b.id_branch,b.branch_type,b.id_country,b.id_state FROM branch b Where b.active=1 and id_branch=".$id_branch);	

		}

		else

		{

			$branch=$this->db->query("SELECT b.is_ho,b.name,b.id_branch,b.branch_type,b.id_country,b.id_state FROM branch b Where b.active=1");

		}

		//print_r($this->db->last_query());exit;

		return $branch->result_array();	

	}

	function get_rptnosettings()

	{

		$sql="Select c.receipt_no_set FROM chit_settings c where c.id_chit_settings = 1";

		return $this->db->query($sql)->row()->receipt_no_set;

	}

	function get_accnosettings()

	{

		$sql="Select c.schemeacc_no_set FROM chit_settings c where c.id_chit_settings = 1";

		return $this->db->query($sql)->row()->schemeacc_no_set;

	}

	function get_amt_in_schjoinsettings()

	{

		$sql="Select c.get_amt_in_schjoin FROM chit_settings c where c.id_chit_settings = 1";

		return $this->db->query($sql)->row()->get_amt_in_schjoin;

	}

	function get_schemegroupsettings()

	{

		$sql="Select c.has_lucky_draw FROM chit_settings c where c.id_chit_settings = 1";

		return $this->db->query($sql)->row()->has_lucky_draw;

	}

	function update_schemeaccno($id,$data)

	{	$this->db->where('id_scheme_account',$id);

		$status=$this->db->update(self::ACC_TABLE,$data);

		return $status;

	}

	// referrals code chk validate //

	  function checkreferral_code($mbi){

		 $query =$this->db->query("SELECT c.mobile as mobile 

									FROM customer c where c.mobile=".$mbi."");

		   if($query->num_rows()>0){			

					return TRUE;

			}else{

			$query=$this->db->query("SELECT e.id_employee as id_employee 

								FROM employee e where id_employee=".$mbi."");

		   if($query->num_rows()>0){			   

			   return TRUE;

		   }else{

			  return FALSE;;

		  } 

		}

	  }

	/*function available_refcode($data){

	 $query=$this->db->query("SELECT c.referal_code 

				FROM customer c 

				where c.id_customer=".$data['id_customer']." and c.referal_code='".$data['referal_code']."'");

	   if($query->num_rows()>0){

		   return TRUE;		   

	   }else{

		   $this->db->where('id_customer',$data['id_customer']); 		  

		 $updaterefcode =  $this->db->update('customer',array('referal_code'=>$data['referal_code']));

		  return TRUE;	

	   }

	}*/

	function available_refcode($data)

	{

	if($data['is_refferal_by']==0 && $data['cus_single']==0)

	{

		$query=$this->db->query("SELECT c.cus_ref_code 

				FROM customer c 

				where c.id_customer=".$data['id_customer']." and c.cus_ref_code='".$data['referal_code']."'");

			if($query->num_rows()>0)

	 	 	 {

		  	 return TRUE;		   

	  		 }

	  		 else

	  		 {

	  		 	 $this->db->where('id_customer',$data['id_customer']); 		  

				 $updaterefcode =  $this->db->update('customer',array('cus_ref_code'=>$data['referal_code']));

		 			 return TRUE;	

	  		 }

	}

	else if($data['is_refferal_by']==1 && $data['emp_single']==0)

	{

		$query=$this->db->query("SELECT c.emp_ref_code 

				FROM customer c 

				where c.id_customer=".$data['id_customer']." and c.emp_ref_code='".$data['referal_code']."'");

			if($query->num_rows()>0)

	 	 	 {

		  	 return TRUE;		   

	  		 }

	  		 else

	  		 {

	  		 	 $this->db->where('id_customer',$data['id_customer']); 		  

				 $updaterefcode =  $this->db->update('customer',array('emp_ref_code'=>$data['referal_code']));

		 			 return TRUE;	

	  		 }

	}

	else if( $data['is_refferal_by']==0||$data['is_refferal_by']==1 && ($data['cus_single']==1&&$data['emp_single']==1))

	{

		 $this->db->where('id_customer',$data['id_customer']); 		  

				 $updaterefcode =  $this->db->update('customer',array('cus_ref_code'=>$data['cus_ref_code'],'emp_ref_code'=>$data['emp_ref_code']));

		 			 return TRUE;	

	}

	}

 public function get_settings()

	 {

	     $sql="select * from chit_settings";

	     $result=$this->db->query($sql);

	     return $result->row_array();

	 }

	public function veriflyreferral_code($mbi) 

			{

			    $company_settings = $this->session->userdata('company_settings');

                $id_company = $this->session->userdata('id_company');

				$referral_code= strlen((string)$mbi);

				$data=$this->get_settings();

				if($referral_code>6)

				{

			

					$status=$this->db->query("SELECT mobile FROM customer WHERE mobile='".$mbi."'");

		

						

					if($status->num_rows()>0){

 

					    $status=$this->db->query("SELECT mobile FROM employee WHERE mobile='".$mbi."'");

                	    

                				if($status->num_rows()>0 && $data['emp_ref_by']==1)

                				{				

                				  return array("status" => TRUE,'user'=>'EMP');

                				}

                				else

                				{

                				    return array("status" => TRUE,'user'=>'CUS');

                				}

                			}

                			else

                			{

                                $status=$this->db->query("SELECT mobile FROM employee WHERE mobile='".$mbi."'");

                             

                                if($status->num_rows()>0 && $data['emp_ref_by']==1){

                                return array("status" => TRUE,'user'=>'EMP');

                                }

                                return array("status" => FALSE);

                            }

				}

				else

				{





                        $status=$this->db->query("SELECT emp_code FROM employee WHERE emp_code='".$mbi."'");

						if($status->num_rows()>0)

						{		

						return array("status" => TRUE,'user'=>'EMP');

						}

					   return array("status" => FALSE);

				}

				 return array("status" => FALSE);

			}

	/* public function check_refcode($ref_code)

	{

			$this->db->select('mobile');

			$this->db->where('mobile',$ref_code); 

			$status=$this->db->get('customer');

			if($status->num_rows()>0)

			{

				return TRUE;

			}else{

				$this->db->select('mobile');

				$this->db->where('mobile',$ref_code); 

				$status=$this->db->get('employee');

				if($status->num_rows()>0)

				{

					return TRUE;

				}

			}

			return FALSE;

	}*/

		function check_refcode($mbi,$id_customer)

	{

	   		 $company_settings = $this->session->userdata('company_settings');

            $id_company = $this->session->userdata('id_company');

	   		 $isEnteredCodevalid =$this->veriflyreferral_code($mbi);

				if($isEnteredCodevalid['user'] == 'CUS')

				{

					$referal_cod = $this->db->query("select c.id_customer,c.cus_ref_code as referal_code,cs.cusbenefitscrt_type,cs.empbenefitscrt_type  from customer c join chit_settings cs where c.id_customer='".$id_customer."' ".($id_company!='' &&  $company_settings == 1? " and c.id_company='".$id_company."'":'')."");

				}

				else

				{

				$referal_cod = $this->db->query("select c.id_customer,c.emp_ref_code as referal_code,cs.cusbenefitscrt_type,cs.empbenefitscrt_type  from customer c join chit_settings cs where c.id_customer='".$id_customer."' ".($id_company!='' &&  $company_settings == 1? " and c.id_company='".$id_company."'":'')."");	

				}

	   		$referal_code=$referal_cod->row()->referal_code;

	   		$empSingle=$referal_cod->row()->empbenefitscrt_type;

	   		$cusSingle=$referal_cod->row()->cusbenefitscrt_type;

if($referal_code == null || $referal_code == ""){	

	// $isEnteredCodevalid = check whether entered referral code is valid using verify function

	$isEnteredCodevalid = $this->veriflyreferral_code($mbi);

	if($isEnteredCodevalid['status'] == true){

		$result = array('status' => true, 'msg' => 'Valid referal Code' );

	}else{

		$result = array('status' => false, 'msg' => 'Invalid referal Code' );

	}

}else

{

	$checkCusRefCodeType = $this->veriflyreferral_code($referal_code);

		$isEnteredCodevalid = $this->veriflyreferral_code($mbi);

		if($isEnteredCodevalid['status']==0)

		{

		$result = array('status' => false, 'msg' => 'Invalid referal Code' );

		}else

		{

			if($checkCusRefCodeType['user'] == 'CUS')

		{

			$isEnteredCodevalid =$this->veriflyreferral_code($mbi);

			if($isEnteredCodevalid['user']=='CUS')

			{

			if($cusSingle == 0){

			$result = array('status' => false, 'msg' => 'Referal Code Used' );

			}else{

			$isEnteredCodevalid =$this->veriflyreferral_code($mbi);

			if($isEnteredCodevalid['status'] == true){

				$result = array('status' => true, 'msg' => 'Valid referal Code' );

			}else{

				$result = array('status' => false, 'msg' => 'Invalid referal Code' );

			}

		}

			}

			else if($isEnteredCodevalid['user']=='EMP')

			{

			if($empSingle == 0){

			$result = array('status' => false, 'msg' => 'Referal Code Used' );

		}else{

			$isEnteredCodevalid =$this->veriflyreferral_code($mbi);

			if($isEnteredCodevalid['status'] == true){

				$result = array('status' => true, 'msg' => 'Valid referal Code' );

			}else{

				$result = array('status' => false, 'msg' => 'Invalid referal Code' );

			}

		}

			}

	}else if($checkCusRefCodeType['user'] == 'EMP')

	{

		$isEnteredCodevalid =$this->veriflyreferral_code($mbi);

			if($isEnteredCodevalid['user']=='CUS')

			{

				if($cusSingle == 0){

			$result = array('status' => false, 'msg' => 'Referal Code Used' );

		}else{

			$isEnteredCodevalid =$this->veriflyreferral_code($mbi);

			if($isEnteredCodevalid['status'] == true){

				$result = array('status' => true, 'msg' => 'Valid referal Code' );

			}else{

				$result = array('status' => false, 'msg' => 'Invalid referal Code' );

			}

		}

			}

			else

			{

				if($empSingle == 0){

			$result = array('status' => false, 'msg' => 'Referal Code Used' );

		}else{

			if($isEnteredCodevalid['status'] == true){

				$result = array('status' => true, 'msg' => 'Valid referal Code' );

			}else{

				$result = array('status' => false, 'msg' => 'Invalid referal Code' );

			}

		}

			}

	}

		} 

}

		return $result;    

	   }

	function get_requests_range($from_date,$to_date,$status,$id_branch)

{

$qry=$this->db->query("SELECT schReg.is_opening,c.email,schReg.added_by,id_reg_request,if(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sch.id_scheme,

 if(cs.has_lucky_draw = 1 && sch.is_lucky_draw = 1,IFNULL(sg.group_code,''),'') as scheme_group_code ,  sch.is_lucky_draw,cs.has_lucky_draw,schReg.id_scheme_group,c.mobile,if(remark = '','-',remark) as remark,schReg.id_customer,schReg.scheme_acc_number,schReg.ac_name,schReg.id_branch,DATE_FORMAT(schReg.date_add,'%d-%m-%Y') AS date_add,schReg.status,schReg.id_scheme,br.id_branch,br.name as branch_name ,schReg.ac_name AS ac_name ,schReg.pan_no,firstPayamt_maxpayable, IFNULL(schReg.firstPayment_amt,'')as firstPayment_amt,sch.scheme_type, cs.getExisting_balance,schReg.paid_installments,schReg.balance_amount,schReg.balance_weight,schReg.last_paid_weight,schReg.last_paid_chances,IFNULL(schReg.last_paid_date,'')as last_paid_date 

from scheme_reg_request schReg

LEFT JOIN scheme AS sch ON sch.id_scheme = schReg.id_scheme

LEFT JOIN branch AS br ON br.id_branch = schReg.id_branch

LEFT JOIN customer c  ON c.id_customer = schReg.id_customer

LEFT JOIN scheme_group sg ON sg.id_scheme_group = schReg.id_scheme_group

JOIN chit_settings cs 

WHERE   (date(schReg.date_add) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."') ".($status!=3 ? " and schReg.status=".$status."":'')." ".($id_branch!='' ? " and schReg.id_branch=".$id_branch."":'')."");

//print_r($this->db->last_query());exit;

return $qry->result_array();

}

/*	function get_requests_range($from_date,$to_date,$status)

	{

		$qry=$this->db->query("SELECT c.email,schReg.added_by,id_reg_request,if(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sch.id_scheme,

		  if(cs.has_lucky_draw = 1,IFNULL(sg.group_code,''),'') as scheme_group_code , cs.has_lucky_draw,schReg.id_scheme_group,c.mobile,if(remark = '','-',remark) as remark,schReg.id_customer,schReg.scheme_acc_number,schReg.ac_name,schReg.id_branch,DATE_FORMAT(schReg.date_add,'%d-%m-%Y') AS date_add,schReg.status,schReg.id_scheme,br.id_branch,br.name as branch_name ,schReg.ac_name AS ac_name ,schReg.pan_no,firstPayamt_maxpayable, IFNULL(schReg.firstPayment_amt,'')as firstPayment_amt,sch.scheme_type

		from scheme_reg_request schReg

		LEFT JOIN scheme AS sch ON sch.id_scheme = schReg.id_scheme

		LEFT JOIN branch AS br ON br.id_branch = schReg.id_branch

		LEFT JOIN customer c  ON c.id_customer = schReg.id_customer

		LEFT JOIN scheme_group sg ON sg.id_scheme_group = schReg.id_scheme_group

		JOIN chit_settings cs 

		WHERE (date(schReg.date_add) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."') ".($status!=3 ? " and schReg.status=".$status."":'')." ".($id_branch!='' ? " and schReg.id_branch=".$id_branch."":'')."");

	//	print_r($this->db->last_query());exit;

		return $qry->result_array();

	}*/

	function get_existingSchRequests($status)

	{

		$branchWiseLogin=$this->session->userdata('branchWiseLogin');

		$is_branchwise_cus_reg=$this->session->userdata('is_branchwise_cus_reg');

			$id_branch=$this->session->userdata('id_branch');

			$uid=$this->session->userdata('uid');

		$qry=$this->db->query("SELECT schReg.is_opening,c.email,schReg.added_by,id_reg_request,if(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sch.id_scheme,

		  if(cs.has_lucky_draw = 1 && sch.is_lucky_draw = 1,IFNULL(sg.group_code,''),'') as scheme_group_code,cs.has_lucky_draw, sch.is_lucky_draw, schReg.id_scheme_group,c.mobile,if(remark = '','-',remark) as remark,schReg.id_customer,schReg.scheme_acc_number,schReg.ac_name,schReg.id_branch,DATE_FORMAT(schReg.date_add,'%d-%m-%Y') AS date_add,schReg.status,schReg.id_scheme,br.id_branch,br.name as branch_name ,schReg.ac_name AS ac_name,schReg.pan_no,firstPayamt_maxpayable, IFNULL(schReg.firstPayment_amt,'')as firstPayment_amt,sch.scheme_type,

		  cs.getExisting_balance,schReg.paid_installments,schReg.balance_amount,schReg.balance_weight,schReg.last_paid_weight,schReg.last_paid_chances,IFNULL(schReg.last_paid_date,'')as last_paid_date

		from scheme_reg_request schReg

		LEFT JOIN scheme AS sch ON sch.id_scheme = schReg.id_scheme

		LEFT JOIN branch AS br ON br.id_branch = schReg.id_branch

		LEFT JOIN customer c  ON c.id_customer = schReg.id_customer

		LEFT JOIN scheme_group sg ON sg.id_scheme_group = schReg.id_scheme_group

		JOIN chit_settings cs 

		".($status!='3'?"  WHERE schReg.status =".$status :" ".($uid!=1 ? ($branchWiseLogin==1 ||$is_branchwise_cus_reg==1 ? ($id_branch!='' ? " Where br.id_branch=".$id_branch. " or  br.show_to_all=1 ":'') :'') :'')." ")."  ");

	//	print_r($this->db->last_query());exit;

		return $qry->result_array();

	}

		//existingSchRequests//

        function get_existingSchRequests_dashboard($status)

        {

            $branchWiseLogin=$this->session->userdata('branchWiseLogin');

            $id_branch=$this->session->userdata('id_branch');

            $uid=$this->session->userdata('uid');

			$dashboard_branch=$this->session->userdata('dashboard_branch');

            $qry=$this->db->query("SELECT schReg.id_scheme_group,c.email,schReg.added_by,id_reg_request,if(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sch.id_scheme,

             c.mobile,if(remark = '','-',remark) as remark,schReg.id_customer,schReg.scheme_acc_number,schReg.ac_name,schReg.id_branch,DATE_FORMAT(schReg.date_add,'%d-%m-%Y') AS date_add,schReg.status,schReg.id_scheme,br.id_branch,br.name as branch_name ,schReg.ac_name AS ac_name  

            from scheme_reg_request schReg

            LEFT JOIN scheme AS sch ON sch.id_scheme = schReg.id_scheme

            LEFT JOIN branch AS br ON br.id_branch = schReg.id_branch

            LEFT JOIN customer c  ON c.id_customer = schReg.id_customer

            LEFT JOIN scheme_group sg ON sg.id_scheme_group = schReg.id_scheme_group

            JOIN chit_settings cs  ".($dashboard_branch!=0 ? ($status!=3 ? "Where schReg.status=".$status." and schReg.id_branch=".$dashboard_branch : " where schReg.id_branch=".$dashboard_branch) : ($status!=3 ? "where schReg.status=".$status: "") )." ");

			//".($status!=3 ?" Where schReg.status=".$status  : "")." ");

			//($uid!=1 ? ($branchWiseLogin==1 ? ($id_branch!='' ? "Where schReg.id_branch=".$id_branch. " or br.show_to_all=1" :''):''):'')

			//".($dashboard_branch!=0 ? " Where sr.id_branch=".$dashboard_branch :'')."  ".($uid!=1 ? ($branchWiseLogin==1? ($id_branch!='' ?  " and  sr.id_branch=".$id_branch." or b.show_to_all=1 ":''):''):'').""

			//print_r($this->db->last_query());

            $existing_data =0;	

            foreach($qry->result_array() as $row)

            {

                $existing_data +=1;

            }

            return  $existing_data;

        } 

	function get_requests_byBranch($id,$status)

	{

		$qry = $this->db->query("SELECT c.email,schReg.added_by,id_reg_request,schReg.id_scheme_group,if(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,sch.id_scheme,

		  if(cs.has_lucky_draw = 1 && sch.is_lucky_draw = 1,IFNULL(sg.group_code,''),'') as scheme_group_code ,cs.has_lucky_draw, sch.is_lucky_draw, c.mobile,if(remark = '','-',remark) as remark,schReg.id_customer,schReg.scheme_acc_number,schReg.ac_name,schReg.id_branch,DATE_FORMAT(schReg.date_add,'%d-%m-%Y') AS date_add,schReg.status,schReg.id_scheme,br.id_branch,br.name as branch_name ,schReg.ac_name AS ac_name,firstPayamt_maxpayable, IFNULL(schReg.firstPayment_amt,'')as firstPayment_amt,sch.scheme_type,

		  cs.getExisting_balance,schReg.paid_installments,schReg.balance_amount,schReg.balance_weight,schReg.last_paid_weight,schReg.last_paid_chances,IFNULL(schReg.last_paid_date,'')as last_paid_date

		from scheme_reg_request schReg

		LEFT JOIN scheme AS sch ON sch.id_scheme = schReg.id_scheme

		LEFT JOIN branch AS br ON br.id_branch = schReg.id_branch

		LEFT JOIN customer c  ON c.id_customer = schReg.id_customer

		LEFT JOIN scheme_group sg ON sg.id_scheme_group = schReg.id_scheme_group

		JOIN chit_settings cs 

		".($status!='3'?"  WHERE schReg.status =".$status ." and schReg.id_branch=".$id:" WHERE schReg.id_branch=".$id)." ");			

		return $qry->result_array(); 

	}	

	function get_schemes()

	{		

		$qry = $this->db->query("SELECT id_scheme,code from scheme");

		return $qry->result_array();

	}	

	function updateRequest($data,$id)

	{		

		$this->db->where('id_reg_request',$id);

		$status=$this->db->update('scheme_reg_request',$data);

		return $status;		

	}

	function getDevicetokens()

	{

		$sql = $this->db->query("SELECT r.token as token ,c.mobile

									from registered_devices r 

									LEFT JOIN customer c on (c.id_customer=r.id_customer) 

									where c.notification = 1;");

		$token = array_map(function ($value) {

					return  $value['token'];

					}, $sql->result_array());

					$data =$sql->result_array();

		return $data;

	}

	function get_notiContent($id_notification)

     {

		//Declaration of variables

		$message ="";

		$noti_msg = "";

		$noti_footer = "";

		$msg = "";

		$customer_data = array();

		$data = array();

			$resultset = $this->db->query("SELECT noti_name,noti_name, noti_footer,noti_msg from notification where id_notification = '".$id_notification."'");

				foreach($resultset->result() as $row)

				{

					$noti_msg = $row->noti_msg;

					$noti_footer = $row->noti_footer;

					$noti_header=$row->noti_name;

					$data = $row->noti_msg;

				}

			$resultset->free_result();

			/*$field_name_footer = explode('@@', $noti_footer);	

			for($i=1; $i < count($field_name_footer); $i+=2)

			 {

				if(isset($customer_data->$field_name_footer[$i]))

				 { 

					$noti_footer = str_replace("@@".$field_name_footer[$i]."@@",$customer_data->$field_name_footer[$i],$noti_footer);					

				}	

			}

			//Generating Message content

			$field_name = explode('@@', $noti_msg);	

			$a=0;

		foreach($data as $row)

		{

			$customer_data = $row;		

			$msgContent = $noti_msg;

			for($i=1; $i < count($field_name); $i+=2) 

			{	

				if(isset($customer_data[$field_name[$i]])) 

				{

					$msgContent = str_replace("@@".$field_name[$i]."@@",$customer_data[$field_name[$i]],$msgContent);					$data[$a]['message']=$msgContent;

				}

			}	

			unset($msgContent);

			$a++;

		}*/

	 return (array('data'=>$data,'header'=>$noti_header,'footer'=>$noti_footer));

	}

	function getnotificationids($mobile)

	{

		$sql = $this->db->query("SELECT r.uuid as token ,c.mobile

									from registered_devices r 

									LEFT JOIN customer c on (c.id_customer=r.id_customer) 

									where mobile=".$mobile);

		$data =$sql->result_array();

		return $data;

	}

		function checkClientID($id_scheme_account="",$client_id="")

    {	

       if($id_scheme_account == "" && $client_id != ""){

           $sql = "select id_scheme_account,ref_no from scheme_account where ref_no = '$client_id'";

       }else{

           $sql = "select id_scheme_account,ref_no from scheme_account where id_scheme_account = ".$id_scheme_account;

       }

    $account = $this->db->query($sql);	

    if($account->num_rows()>0 && $account->row()->ref_no != '')

    {

    return array("status" => TRUE, "client_id" => $account->row()->ref_no,'id_scheme_account'=>$account->row()->id_scheme_account );

    }

    else

    {

    return array("status" => FALSE);

    }	

    }

    function isPaymentExist($data)

	{

	    if($data['id_branch'] == NULL || $data['id_branch'] == ''){

	        $sql = $this->db->query("select id_scheme_account from scheme_account where id_scheme =".$data['id_scheme']." and id_customer =".$data['id_customer']." and (id_branch is null or id_branch=0) and scheme_acc_number =".$data['scheme_acc_number']);

	    }else{

	        $sql = $this->db->query("select id_scheme_account from scheme_account where id_scheme =".$data['id_scheme']." and id_customer =".$data['id_customer']." and id_branch =".$data['id_branch']." and scheme_acc_number =".$data['scheme_acc_number']);

	    }

	    if($sql->num_rows() > 0){

	        $pay = $this->db->query("select id_payment from payment where id_scheme_account =".$sql->row('id_scheme_account')); 

	        if($pay->num_rows() > 0){

	            return array('status' => true , 'id_scheme_account' => $sql->row('id_scheme_account'));

	        }else{

	            return array('status' => false , 'id_scheme_account' => $sql->row('id_scheme_account'));

	        }

	    }else{

	        return array('status' => false , 'id_scheme_account' => NULL);

	    }

	}  

    function deleteAcc($data,$id)

	{

	    $this->db->where('id_scheme_account',$id);

		$status=$this->db->delete(self::ACC_TABLE,$data);

		return $status;

	}

//get_Schemegroup

	/*	function get_schemegroup($id_branch = "")  

	{  

	    $company_settings = $this->session->userdata('company_settings');

        $id_company = $this->session->userdata('id_company');

		$usr_branch=$this->session->userdata('id_branch');

		$sql="SELECT count(sa.id_scheme_account) as grp_acc_count,s.id_scheme_group, s.id_scheme,s.id_branch,b.name as branch_name, s.group_code,sch.code as scheme_code, DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date, DATE_FORMAT(s.end_date,'%d-%m-%Y') as end_date 		

		FROM scheme_group s

		left join scheme sch on (sch.id_scheme=s.id_scheme)

		left join scheme_account sa on (sa.group_code=s.group_code)

		left join branch b on (b.id_branch=s.id_branch)

	

		".($id_company!='' &&  $company_settings == 1? " where sch.id_company='".$id_company."'":'')."

		";

		if($id_branch != ''){

		   $sql = $sql." and s.id_branch=".$id_branch;

		}else if($usr_branch != '') {

		   $sql = $sql." and s.id_branch=".$usr_branch; 

		} 

		$sql = $sql." GROUP BY sa.group_code";

		//echo $sql;exit;

	   return $this->db->query($sql)->result_array();	 

	} */

	

	

	function get_schemegroup($id_branch = "")  

			{  

				

				$company_settings = $this->session->userdata('company_settings');

				$id_company = $this->session->userdata('id_company');

				$usr_branch=$this->session->userdata('id_branch');

				$sql="SELECT 

				IFNULL((select count(id_scheme_account) from scheme_account where group_code=s.id_scheme_group),0) as grp_acc_count,

				s.id_scheme_group,

				 s.id_scheme,

				 s.id_branch,

				 b.name as branch_name,

				  s.group_code,

				  sch.code as scheme_code, 

				  DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date,

				   DATE_FORMAT(s.end_date,'%d-%m-%Y') as end_date 		

				FROM scheme_group s

				left join scheme sch on (sch.id_scheme=s.id_scheme)

				

				left join branch b on (b.id_branch=s.id_branch)

			

				".($id_company!='' &&  $company_settings == 1? " where sch.id_company='".$id_company."'":'')."

				";

				if($id_branch != '' && $id_branch!=0)

				{

					if($id_company!='' &&  $company_settings == 1)

					{

						$sql = $sql." and s.id_branch=".$id_branch;

					}

					else

					{

						$sql = $sql." where s.id_branch=".$id_branch;

					}

				  

				}

				else if($usr_branch != '') 

				{

					if($id_company!='' &&  $company_settings == 1)

					{

						$sql = $sql." and s.id_branch=".$usr_branch; 

					}

					else

					{

						$sql = $sql." where s.id_branch=".$usr_branch;

					}

				   

				} 

				$sql = $sql." group by s.id_scheme_group";

				//echo $sql;exit;

			   return $this->db->query($sql)->result_array();	 

			}

			

 function group_empty()

    {

		$data=array(

			'id_scheme_group'	  => NULL,

			'id_scheme'=>			NULL,

			'scheme_code'		  => NULL,

			'group_code'		=> NULL,

			'id_branch'		=> NULL,

			'start_date'		=> NULL,

			'end_date'		    => NULL,

			'last_update'      =>NULL,

			 'date_add'         => date('d-m-Y')

		);

		return $data;

	}

	function insert_groupaccount($data)

	{   

		$status=$this->db->insert(self::SCHGROUP_TABLE,$data);		

		//echo $this->db->last_query($status);exit;

		return ($status?$this->db->insert_id():$status);

    }

	function get_groupaccount_details($id)

	{   

		$sql="SELECT s.id_scheme_group, s.id_scheme, s.group_code,sch.code as scheme_code,

		 DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date, DATE_FORMAT(s.end_date,'%d-%m-%Y') as end_date 		

		FROM scheme_group s

		left join scheme sch on (sch.id_scheme=s.id_scheme)

		WHERE s.id_scheme_group=".$id."";

		$account=$this->db->query($sql);	   

		return $account->row_array();	

    }

    function update_groupaccount($data,$id)

	{   

		$this->db->where("id_scheme_group",$id);

		//echo $this->db->last_query($status);exit;

		$status = $this->db->update(self::SCHGROUP_TABLE,$data);

		return	array('status' => $status, 'updateID' => $id);     

    }

	function get_groups()

    {	

        $qry = $this->db->query("SELECT id_scheme_group,group_code from scheme_group");

        return $qry->result_array();

    }

    function code_available($group_code)

    {

        $this->db->select('group_code');

        $this->db->where('group_code', $group_code);

        $status=$this->db->get(self::SCHGROUP_TABLE); 

        if($status->num_rows()>0)

        {

            return TRUE;

        }

    }

    function delete_group($data,$id)

    {

    	$code=$data['group_code'];

 		$this->db->select('group_code');

        $this->db->where('group_code', $code);

        $status=$this->db->get(self::ACC_TABLE); 

 		// print_r($status); exit;

        if($status->num_rows()>0)

        {

 		return FALSE;

        }

        else

        {

        $this->db->where('id_scheme_group',$id);

        $status=$this->db->delete(self::SCHGROUP_TABLE);

	     return TRUE;

            }

    }

    function get_customerenquiry() 

    {

       $sql="select * FROM cust_enquiry ";

       return $this->db->query($sql)->result_array();

    }

    function get_customerenquiry_by_date($from_date,$to_date) 

    {

       $sql="select * FROM cust_enquiry Where (date(date_add) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."')";

       return $this->db->query($sql)->result_array();

    }

	function get_all_scheme_account_list($mobile)

	{    

		$accounts=$this->db->query("select IFNULL(s.pan_no,'-') as pan_no,

								sc.code,IFNULL(s.group_code,'')as group_code,cs.has_lucky_draw, sc.is_lucky_draw,

							  s.id_scheme_account,IFNULL(s.scheme_acc_number,'Not Allocated') as scheme_acc_number ,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,s.account_name,DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date,c.is_new,s.added_by,concat('C','',c.id_customer) as id_customer,

							  sc.scheme_name,if(s.is_new ='Y','New','Existing') as is_new,sc.code,if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight',if(sc.scheme_type=3,'FLEXIBLE_AMOUNT','Amount To Weight')))as scheme_type,cs.schemeacc_no_set,

							  FORMAT(if(sc.scheme_type=1,sc.max_weight,if(sc.scheme_type=3 && sc.max_amount!=0,sc.max_amount,if(sc.scheme_type=3 && sc.max_amount=0,(sc.max_weight*(SELECT m.goldrate_22ct FROM metal_rates m  order by id_metalrates Desc LIMIT 1)),sc.amount))),2) as amount,

							  if(s.show_gift_article=1,'Issued','Not Issueed')as gift_article,

							  sc.scheme_type  as scheme_types,

							  if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight',if(sc.scheme_type=3 && sc.flexible_sch_type=1,'Flx Amount',if(sc.scheme_type=3 && sc.flexible_sch_type=2,'Flx AmtToWgt[Amt]',if(sc.scheme_type=3 && sc.flexible_sch_type=3,'Flx AmtToWgt[Wgt]',if(sc.scheme_type=3 && sc.flexible_sch_type=4,'Flx Wgt [Wgt]','Amount To Weight'))))))as scheme_type,

							  sc.total_installments,sc.max_chance,sc.max_weight,c.mobile,if(s.active =1,'Active','Inactive') as active,s.date_add,cs.currency_symbol,

							 (select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 AND sc.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=s.id_scheme_account group by pay.id_scheme_account) as paid_installments

								from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							left join ".self::PAY_TABLE." pay on (pay.id_scheme_account=s.id_scheme_account  and (pay.payment_status=2 or pay.payment_status=1))

							left join branch b on (b.id_branch=s.id_branch)

							join chit_settings cs

							Where s.is_closed=0 and c.mobile like '".$mobile."%'

							group by s.id_scheme_account");

				//print_r($this->db->last_query());exit;

		return $accounts->result_array();

	}

	function select_otp($otp)

	{

		$this->db->select('*');

		$this->db->where('otp_code',$otp);

		$status=$this->db->get(self::OTP_TABLE);

        //print_r($this->db->last_query());exit;

		return $status->row_array();

	}

	function otp_update_payment($data,$id)

	{

		$this->db->where('id_otp',$id);

		$status=$this->db->update(self::OTP_TABLE,$data);

        //print_r($this->db->last_query());exit;

		return $status;

	}

	function get_scheme_type_closed_account($id_branch,$from_date,$to_date,$type="")

	{

		$accounts=$this->db->query("select

							  s.id_scheme_account,sc.code,IFNULL(s.group_code,'')as scheme_group_code,IFNULL(s.scheme_acc_number,'NOT Allocated')as scheme_acc_number,cs.has_lucky_draw,

							  concat (c.firstname,' ',if(c.lastname!=Null,c.lastname,'')) as name,

							  s.ref_no, s.closing_add_chgs, s.account_name,

							  IFNULL(Date_format(s.start_date,'%d-%m%-%Y'),'-') as start_date,

							  IFNULL(Date_format(s.closing_date,'%d-%m%-%Y'),'-') as closing_date,

							  if(sc.scheme_type=0,CONCAT(cs.currency_symbol,' ',s.closing_amount),s.closing_balance) as closing_balance,

							  c.added_by,sc.scheme_name,sc.code,b.name as branch,

							  if(sc.scheme_type=0,'Amount',if(sc.scheme_type=1,'Weight',if(sc.scheme_type=3,'FLEXIBLE_AMOUNT','Amount To Weight')))as scheme_type,

							  FORMAT(if(sc.scheme_type=1,CONCAT('max ',sc.max_weight,' g/month'),if(sc.scheme_type=3 && sc.max_amount!=0,sc.max_amount,if(sc.scheme_type=3 && sc.max_amount=0,(sc.max_weight*(SELECT m.goldrate_22ct FROM metal_rates m  order by id_metalrates Desc LIMIT 1)),sc.amount))),2) as amount					,sc.total_installments,sc.max_chance,c.mobile

							from

							  ".self::ACC_TABLE." s

							left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

							left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

							LEFT JOIN employee e ON (e.id_employee = s.employee_closed) 

							left join ".self::BRANCH." b on (b.id_branch=e.id_branch)

							join chit_settings cs

							where s.active=0 and s.is_closed=1  and  (date(s.closing_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."') 

							and e.id_branch=".$id_branch." ".($type!='' ? "and sc.scheme_type=".$type."" :'')." ");

		return $accounts->result_array();

	}

 // get_group for new sch join //

   /* function get_group($id_scheme)

        {		

			//$sql = "SELECT * FROM scheme_group";	

			$sql="SELECT s.id_scheme_group, s.id_scheme, s.group_code,sch.code as scheme_code, DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date, DATE_FORMAT(s.end_date,'%d-%m-%Y') as end_date FROM scheme_group s left join scheme sch on (sch.id_scheme=s.id_scheme)where s.id_scheme=".$id_scheme;	

		  //print_r($sql);exit;

			return $this->db->query($sql)->result_array();		

	     }*/

   	//gift count option HH//

   function add_gift($data) 

                      {

                    $status = $this->db->insert(self::ISSU_TABLE,$data);

                    //echo $this->db->last_query();

                   //echo $this->db->_error_message(); 

                    return $status;

                      }

 /*public function get_gift_issued($id)

	{

	   	$qry = $this->db->query("SELECT id_gift_issued,IF(type = 1,'GIFT','PRIZE') as type,id_scheme_account,gift_desc, firstname as id_employee,date_issued,status as gift_status

	    	FROM `gift_issued` 

	    	LEFT JOIN employee ON gift_issued.id_employee = employee.id_employee

	    	where id_scheme_account=".$id); 

	     //print_r($this->db->last_query());exit;

		    return $qry->result_array();

	} */

	

	public function get_gift_issued($id)

	{

		//id_gift,IFNULL(quantity,'-') as quantity, added by Durga 

	   	$qry = $this->db->query("SELECT id_gift_issued,

		IF(type = 1,'GIFT','PRIZE') as type,

		id_scheme_account,

		gift_desc, 

		firstname as id_employee,

		IFNULL(quantity,'-') as quantity,

		id_gift,

		date_issued,

		status as gift_status

	    	FROM `gift_issued` 

	    	LEFT JOIN employee ON gift_issued.id_employee = employee.id_employee

	    	where id_scheme_account=".$id); 

	     //print_r($this->db->last_query());exit;

		    return $qry->result_array();

	}

	 function getAvailableCustomers($SearchTxt){

	     $id_company = $this->session->userdata('id_company');

	     $company_settings = $this->session->userdata('company_settings');

		$data = $this->db->query("SELECT c.mobile,c.id_customer as value, c.id_company,concat(c.firstname,'-',c.mobile) as label,c.id_village,v.village_name,if(c.is_vip=1,'Yes','No') as vip,

			(select count(sa.id_scheme_account) from scheme_account sa where sa.id_customer=c.id_customer) as accounts

			FROM customer c

			left join village v on v.id_village=c.id_village

			WHERE (username like '%".$SearchTxt."%' OR mobile like '%".$SearchTxt."%' 

			OR firstname like '%".$SearchTxt."%')"

			.($id_company!='' && $id_company!=0 && $company_settings==1 ? " and c.id_company=".$id_company."":'').""); 

		

		return $data->result_array();

	}

		function checkSchemeCloseBeiefits($id_scheme)

	{

	    $sql=$this->db->query("SELECT * FROM `emp_closing_incentive` WHERE id_scheme=".$id_scheme."");

	    return $sql->result_array();

	}

	function getMetalRates()

	{

	    $sql=$this->db->query("SELECT m.goldrate_22ct FROM metal_rates m  order by id_metalrates Desc LIMIT 1");

	    return $sql->row_array();

	}

	function get_ClosedBenefitsDetails($id_scheme_account)

	{

	    $sql=$this->db->query("SELECT * FROM `wallet_transaction` WHERE id_sch_ac=".$id_scheme_account."");

	    if($sql->num_rows()>0)

	    {

	        $return_data=array('status'=>true,'wallet_details'=>$sql->row_array());

	    }else{

	        $return_data=array('status'=>false);

	    }

	    return $return_data;

	}

	function get_metal_name()

	{

	    $sql=$this->db->query("SELECT * FROM metal");

	    return $sql->result_array();

	}

	

	function getAccBlcDebitSettings($data){

		$sql = $this->db->query("SELECT deduction_type ,deduction_value FROM `scheme_debit_settings` where (installment_from = ".$data['paid_installments']." or installment_to = ".$data['paid_installments'].") and id_scheme=".$data['id_scheme']);

		return $sql->row_array();

	}

	

	 function get_ratesByJoin($id_scheme_account)

	{

	    $today = date('Y-m-d');

	    $res = $this->db->query("SELECT  DATE_FORMAT(start_date,'%Y-%m-%d') as start_date from scheme_account where id_scheme_account = ".$id_scheme_account);

	    $start_date = $res->row()->start_date;

	    $sql = ("SELECT m.mjdmagoldrate_22ct,m.goldrate_22ct,m.goldrate_24ct FROM metal_rates m

	    WHERE date(m.add_date) BETWEEN '".$start_date."' AND '".$today."' ORDER BY goldrate_22ct ASC LIMIT 1");

		return $this->db->query($sql)->row_array();

	}

	

	function getDiscountByjoin($id_scheme_account,$id_scheme,$start_date)

	{

	    

	    //$start_date = '2022-01-01';

        $current_date = date('Y-m-d');



        $count_months = 1 + ((date('Y', strtotime($current_date)) - date('Y', strtotime($start_date))) * 12) + (date('m', strtotime($current_date)) - date('m', strtotime($start_date)));



	    $sql = "SELECT * FROM `scheme_benefit_deduct_settings` WHERE installment_from <= '".$count_months."' AND installment_to >= '".$count_months."' AND id_scheme = ".$id_scheme;

	    

	    //print_r($sql);exit;

	    $result = $this->db->query($sql);

	    

	    

	    if($result->num_rows > 0)

	    {

	        return $result->row_array();

	    }

	    else{

	    return 0;}

	}

	

	function insert_kyc($data)

    {

		$status = $this->db->insert('kyc',$data); 

		return array('status' => $status, 'insertID' => $this->db->insert_id());

	}

	

	function get_customer_kycDetails($id_customer)

	{

	    $kyc = $this->db->query("SELECT kyc_type,number from kyc where status=2 and id_customer = ".$id_customer);

	    	$kycData = $kyc->result_array();

	    	foreach($kycData as $k){

	    	    if($k['kyc_type'] == 2){

	    	        $result['pan_no'] = $k['number'];

	    	        $result['pan_name'] = $k['name'];

	    	    }

	    	    else if($k['kyc_type'] == 3){

	    	        $result['aadhaar_no'] = $k['number'];

	    	        $result['aadhaar_name'] = $k['name'];

	    	    }

	    	}

	    return $result;

	}

	

	function get_gifts_name()

	{

	    $sql=$this->db->query("SELECT * FROM gifts where status=1");

	    return $sql->result_array();

	}

	

	function getEmpBenefit($id_scheme_account)

	{

	    $sql = $this->db->query("SELECT * FROM wallet_transaction where type=0 and transaction_type=0 and id_sch_ac = ".$id_scheme_account);

	    if($sql->num_rows > 0)

	    {

	        return $sql->row_array();

	    }else{

	        return 0;

	    }

	    

	}

	

	function verifyAgentCode($agent_code)

	{

	    

	    $status=$this->db->query("SELECT id_agent,agent_code FROM agent WHERE agent_code='".$agent_code."'");

						if($status->num_rows()>0)

						{		

						return array("status" => TRUE,'agent' => $status->row_array());

						}

					   return array("status" => FALSE);

					   

	}

	function getAgentBenefit($id_scheme_account)

	{

	    

	    $sql = $this->db->query("SELECT SUM(unsettled_cash_pts) as cash_pts,id_agent,id_scheme_account,cus_loyal_cus_id FROM ly_customer_loyalty_transaction where ly_trans_type=3 and tr_cus_type =4 and id_scheme_account = ".$id_scheme_account);

	    if($sql->num_rows > 0)

	    {

	        return $sql->row_array();

	    }else{

	        return 0;

	    }

	    

	}

	

	function insert_gift_issued($data)

	{

		$status = $this->db->insert('gift_issued',$data);

		

		return $status;

	}	

	function update_gift_issued($data,$id)

	{

		$this->db->where('id_scheme_account',$id);

		$status=$this->db->update('gift_issued',$data);

		return $status;

	}

	

	function is_agent_exist($agent_code){

		$sql=$this->db->query("select * from agent where agent_code =".$agent_code);

		

		if($sql->num_rows() > 0){

			$result =  array("status" => 1 , "msg" => "Agent code exist");

		}else{

			$result =  array("status" => 0 , "msg" => "Agent code doesnot exists.");

		}

		

		return $result;

	}

	

	function getAccBenefitDeduction($data){

		/*	$sql = $this->db->query("SELECT interest_type,interest_value FROM `scheme_benefit_deduct_settings` where (installment_from = ".$data['paid_installments']." or installment_to = ".$data['paid_installments'].") and id_scheme=".$data['id_scheme']);     */

		

		$sql = $this->db->query("SELECT interest_type,interest_value FROM `scheme_benefit_deduct_settings` 

					where ".($data['is_digi']==1 ? "(".$data['date_difference']." BETWEEN installment_from AND installment_to)" :"(installment_from =".$data['paid_installments']." or installment_to =".$data['paid_installments'].")")."

					and id_scheme=".$data['id_scheme']);

					

		if($sql->num_rows() > 0){

			$data = $sql->row_array();

		}else{

		   $data = array('interest_type' => '' ,'interest_value' => ''); 

		}			

			return $data;

			

		}

	

	function get_financialYear()

	{

	    $res = $this->db->query("SELECT fin_year_code FROM `ret_financial_year` where fin_status = 1");

        $financial_year = $res->row()->fin_year_code;

        return $financial_year;

	}

	

	function getCustomerByCode($ref_code)

	{

	    $referEmpData = $this->db->query("SELECT id_customer from customer where mobile =".$ref_code);

            $cus_id = $referEmpData->row()->id_customer;

            $sql1 = $this->db->query("SELECT referal_code,id_scheme_account from scheme_account where referal_code != '' and is_refferal_by = 1 and id_customer=".$cus_id);

            if($sql1->num_rows() > 0)

            {

                return $sql1->row_array();

            }

            else

            {

                return FALSE;

            }

            

	}

	

	//DCNM-DGS closing benefits...

	

	function getPaymentData($data)

	{

		if($data['interest_value'] != ''){

			$res = $this->db->query("SELECT ROUND(SUM((p.metal_weight)*(".$data['interest_value']."/100)*((DATEDIFF(CURDATE(),date(p.date_payment)))/365)),3) as total_day_benefit

								FROM `payment` p

								LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account)

								WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

			$total_day_benefit = $res->row()->total_day_benefit;

			

			//print_r($this->db->last_query());exit;

			return $total_day_benefit;

		}else{

			return 0;

		}

	}

	

	

	//DCNM-DGS chit report pdf...

	

	function get_chit_data($id){

		$sql = $this->db->query("SELECT s.is_digi,COUNT(p.id_payment) as pay_count,sa.id_scheme_account,date(sa.start_date) as join_date,sa.id_branch,s.scheme_name,s.id_scheme,s.restrict_payment,DATEDIFF(CURDATE(),date(sa.start_date)) as date_difference,

		s.total_days_to_pay, DATE_ADD(date(sa.start_date), INTERVAL s.total_days_to_pay DAY) as allow_pay_till, CURDATE() as cur_date, DATE_FORMAT(NOW(),'%d-%m-%Y %H:%i:%s %a') as currentDate_time,

		sa.account_name,sa.scheme_acc_number,CONCAT(c.firstname,' ',IFNULL(c.lastname,'')) as customer_name,c.mobile,s.code as sch_code,b.name as branch_name,

		IFNULL(a.address1,'') as add1,IFNULL(a.address2,'') as add2,IFNULL(a.address3,'') as add3,IFNULL(a.pincode,'') as pincode,ct.name as city,st.name as state,ctry.name as country,s.id_scheme

	

				FROM scheme_account sa

				LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme)

				LEFT JOIN payment p ON (p.id_scheme_account = sa.id_scheme_account AND p.payment_status = 1)

				LEFT JOIN customer c ON (c.id_customer = sa.id_customer)

				LEFT JOIN branch b ON (b.id_branch = sa.id_branch)

				LEFT JOIN address a ON(a.id_customer = c.id_customer)

				LEFT JOIN city ct ON (ct.id_city = a.id_city)

				LEFT JOIN state st ON (st.id_state = a.id_state)

				LEFT JOIN country ctry ON (ctry.id_country = a.id_country)

				WHERE sa.id_scheme_account = ".$id." AND sa.active = 1 AND sa.is_closed = 0 ");

	    		

				

		return $sql->row_array();

		

	}

	

	function get_chit_int($data){

	

	

		$sql = $this->db->query("SELECT interest_type,interest_value, IF(interest_type = 0,'%','INR') as int_symbol 

				FROM `scheme_benefit_deduct_settings` 

				where id_scheme=".$data['id_scheme']." ".($data['restrict_payment']==1 ? "AND ( ".$data['date_difference']." BETWEEN installment_from AND installment_to)" :""));

				

			//	print_r($data);exit;

		$res['int'] = $sql->row_array();

		

		$sql_debit = $this->db->query("SELECT deduction_type ,deduction_value,installment_to FROM `scheme_debit_settings` 

	            where ".($data['is_digi']==1 ? "(".$data['date_difference']." BETWEEN installment_from AND installment_to)" :"(installment_from =".$data['paid_installments']." or installment_to =".$data['paid_installments'].")")."

				and id_scheme=".$data['id_scheme']);

				

		$debit = $sql_debit->row_array();

	

		if($sql->num_rows > 0){

			$sql_tot = $this->db->query("SELECT SUM(p.payment_amount) as total_paid,SUM(p.metal_weight) as saved_wgt, ROUND(SUM((p.metal_weight)*(".$res['int']['interest_value']."/100)*((DATEDIFF(CURDATE(),date(p.date_payment)))/365)),3) as total_benefit,CURDATE() as cur_date, CONCAT(".$res['int']['interest_value'].",' %') as interest,COUNT(id_payment) as pay_count,date(sa.start_date) as join_date,DATE_ADD(date(sa.start_date), INTERVAL s.total_days_to_pay DAY) as allow_pay_till,DATEDIFF(CURDATE(),date(sa.start_date)) as date_difference

			FROM `payment` p  

			LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account)

			LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme)			

			WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

			//print_r($this->db->last_query());exit;

			$res['tot'] = $sql_tot->row_array(); 

		}else{

			$sql_tot = $this->db->query("SELECT SUM(p.payment_amount) as total_paid,SUM(p.metal_weight) as saved_wgt, '' as total_benefit,CURDATE() as cur_date, '' as interest,COUNT(id_payment) as pay_count,date(sa.start_date) as join_date,DATE_ADD(date(sa.start_date), INTERVAL s.total_days_to_pay DAY) as allow_pay_till,DATEDIFF(CURDATE(),date(sa.start_date)) as date_difference

			FROM `payment` p  

			LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account)

			LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme)			

			WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

			//print_r($this->db->last_query());exit;

			$res['tot'] = $sql_tot->row_array(); 

		}

		   

		 if($sql_debit->num_rows > 0 ){

            $sql_tot = $this->db->query("SELECT SUM(ROUND((p.metal_weight)*(".$debit['deduction_value']."/100)* ((DATEDIFF(CURDATE(),date(p.date_payment)))/365) ,3)) as preclose_benefit,

             CONCAT(".$debit['deduction_value'].",' %') as preclose_interest,

             CONCAT(date(sa.start_date),' to ',(DATE_ADD(date(sa.start_date), INTERVAL ".$debit['installment_to']." DAY))) AS preclose_date

             

			FROM `payment` p  

			LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account)

			LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme)			

			WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

			

            $res['preclose_interest'] = $sql_tot->row()->preclose_interest;

            $res['preclose_benefit'] = $sql_tot->row()->preclose_benefit;

            $res['preclose_date'] = $sql_tot->row()->preclose_date;

            



        }else{

            $sql_tot = $this->db->query("SELECT '' as preclose_interest, '' as preclose_benefit, '' as preclose_date

			FROM `payment` p  

			LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account)

			LEFT JOIN scheme s ON (s.id_scheme = sa.id_scheme)			

			WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

			

             $res['preclose_interest'] = $sql_tot->row()->preclose_interest;

            $res['preclose_benefit'] = $sql_tot->row()->preclose_benefit;

            $res['preclose_date'] = $sql_tot->row()->preclose_date;

        }

		return $res; 

	}

	function chit_detail_report($data){

		

		//print_r($data['int']);exit;

		

		if(sizeof($data['int']) > 0){

	

		$sql_sub = $this->db->query("SELECT @a:=@a+1 as sno,date(p.date_payment) as paid_date, p.payment_amount as paid_amt, p.metal_rate, p.metal_weight, (DATEDIFF(CURDATE(),date(p.date_payment))) as days_diff, ROUND((p.metal_weight)*(".$data['int']['interest_value']."/100)*((DATEDIFF(CURDATE(),date(p.date_payment)))/365),3) as pay_int,p.receipt_no FROM `payment` p join (SELECT @a:= 0) a LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account) WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

		$data = $sql_sub->result_array();

	

		}else{

			$sql_sub = $this->db->query("SELECT @a:=@a+1 as sno,date(p.date_payment) as paid_date, p.payment_amount as paid_amt, p.metal_rate, p.metal_weight, (DATEDIFF(CURDATE(),date(p.date_payment))) as days_diff,'-' as pay_int,p.receipt_no  FROM `payment` p join (SELECT @a:= 0) a LEFT JOIN scheme_account sa ON (sa.id_scheme_account = p.id_scheme_account) WHERE sa.id_scheme_account = ".$data['id_scheme_account']." and p.payment_status = 1");

			$data = $sql_sub->result_array();

		}

		

		//print_r($this->db->last_query());exit;

		return $data;



	}

	

	function is_refno_exists_import($ref_no,$sch_id){

         		  $this->db->select('ref_no');

			$this->db->where('scheme_acc_number', $ref_no); 

			$this->db->where('id_scheme', $sch_id); 

			$status=$this->db->get('scheme_account');

			

			

			if($status->num_rows()>0)

			{

				 $result =  1;

			}else{

				$result =  0;

			}



		  return $result;



         

     }

     

     function get_remark_data($from_date,$to_date)

     {

         $sql = $this->db->query("SELECT ag.id_agent as id_employee,ag.firstname as employee_name,c.mobile,c.firstname as name,

         pr.remark,pr.id_scheme_account,DATE_FORMAT(pr.date_created,'%d-%m-%Y') as date_created ,IFNULL(concat(s.code,' ',sa.scheme_acc_number),'Not Allocated') as scheme_acc_number

         from payment_collection_remarks pr

         left join scheme_account sa on sa.id_scheme_account=pr.id_scheme_account

         left join scheme s on s.id_scheme=sa.id_scheme

         left join customer c on c.id_customer = sa.id_customer

         left join agent ag on ag.id_agent=pr.id_agent

         WHERE date(pr.date_created) BETWEEN '".$from_date."' AND '".$to_date."'");

         //echo $this->db->last_query();exit;

         return $sql->result_array();

     }

     

     

    /*SCHEME WISE OUTSTANDING REPORT STARTS */

	function get_all_scheme_account_by_range()

	 { 

		$from_date= $this->input->post('from_date');

		$to_date= $this->input->post('to_date');

		$id_scheme  = $this->input->post('id_scheme');

		$id_branch  = $this->input->post('id_branch');

		$company_settings=$this->session->userdata('company_settings');

		$id_company = $this->session->userdata('id_company');

		$branch=$this->session->userdata('id_branch');

		$group_code=$this->input->post('id_group');

		$is_live=$this->input->post('is_live');

		



		 $accounts=$this->db->query("select IFNULL(s.pan_no,c.pan) as pan_no,cs.has_lucky_draw,Date_Format(max(pay.date_payment),'%d-%m-%Y') as last_paid_date,

		 IFNULL(s.group_code,'') as group_code,s.fixed_metal_rate,s.fixed_wgt,s.referal_code,b.name as branch_name,

		 s.id_scheme_account,IFNULL(concat(sc.code,IFNULL(concat(' ',s.group_code),''),'-',s.scheme_acc_number),'Not Allocated') as scheme_acc_number,IF(c.lastname is null,c.firstname,concat(c.firstname,' ',c.lastname)) as name,s.ref_no,s.account_name,DATE_FORMAT(s.start_date,'%d-%m-%Y') as start_date,IFNULL(DATE_FORMAT(s.closing_date,'%d-%m-%Y'),'-') as closing_date,c.is_new,s.added_by,concat('C','',c.id_customer) as id_customer,cs.schemeacc_no_set,

		 IF(sc.scheme_type=0 OR sc.scheme_type=2,TRIM(sc.amount),IF(sc.scheme_type=1 ,sc.max_weight,if(sc.scheme_type=3,if(flexible_sch_type = 3 ,  sc.max_weight,if(sc.firstPayamt_as_payamt=1,s.firstPayment_amt ,TRIM(sc.min_amount))),0))) as payable,

		 sc.scheme_name,if(s.is_new ='Y','New','Existing') as is_new,sc.code,IF(sc.scheme_type=0,'Amount',IF(sc.scheme_type=1,'Weight',if(sc.scheme_type=2,'Amount to Weight','Flexible'))) AS scheme_type,sc.amount,c.mobile,if(s.active =1 and s.is_closed = 0,'Live','Closed') as active,s.date_add,cs.currency_symbol,sc.scheme_type  as scheme_types,



        IFNULL((select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 AND sc.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=s.id_scheme_account group by pay.id_scheme_account),0) as paid_installments,



		 SUM(IFNULL(pay.payment_amount,0)) AS totalpay_amount, IF(sc.scheme_type = 0, 'Amount', IF(sc.scheme_type = 1,'Weight',IF(sc.scheme_type = 2,'Amount to Weight',IF(sc.scheme_type = 3, 'Flexible','-')))) as scheme_type,sc.flexible_sch_type,SUM(IFNULL(pay.metal_weight,0)) AS total_wgt,

		 

		 if(s.added_by=1,'Admin',if(s.added_by=0,'Web App',if(s.added_by=2,'Mobile App',if(s.added_by=3,'Collection App',if(s.added_by=4,'Retail',if(s.added_by=5,'Sync',if(s.added_by=6,'Import','-'))))))) as joined_thru,

		 

		 ifnull((concat(e.firstname,' - ', e.emp_code)),'-') as joined_emp

		 

		 

		 from

		 ".self::ACC_TABLE." s

		 left join ".self::CUS_TABLE." c on (s.id_customer=c.id_customer)

		 left join ".self::SCH_TABLE." sc on (sc.id_scheme=s.id_scheme)

		 left join ".self::BRANCH." b on (b.id_branch=s.id_branch)

		 left join employee e on (e.id_employee = s.id_employee)

		 left join ".self::PAY_TABLE." pay on (pay.id_scheme_account=s.id_scheme_account  and (pay.payment_status=2 or pay.payment_status=1))

		 join chit_settings cs

		 Where s.scheme_acc_number IS NOT NULL  and s.active=1 and date(s.start_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."'  

		 ".($id_branch!='' && $id_branch!=0 && $branch==0 ? " and s.id_branch=".$id_branch."":'')."

		 ".($id_scheme!='' && $id_scheme!=0  ? " and s.id_scheme=".$id_scheme."":'')."

		 ".($id_company!='' && $id_company!=0 && $company_settings==1 ? " and c.id_company=".$id_company."":'')."

		  ".($is_live!='' ? " and s.is_closed=".$is_live."":'')."



		 ".($group_code!=''  ? " and s.group_code ='".$group_code."'":'')."



		 group by s.id_scheme_account"); 

//		 print_r($this->db->last_query());exit;

		 return $accounts->result_array();

	 }



	 function scheme_summary_data(){

		$from_date= $this->input->post('from_date');

		$to_date= $this->input->post('to_date');

		$id_scheme  = $this->input->post('id_scheme');

		$id_branch  = $this->input->post('id_branch');

		$company_settings=$this->session->userdata('company_settings');

		$id_company = $this->session->userdata('id_company');

		$branch=$this->session->userdata('id_branch');

        	$is_live=$this->input->post('is_live');

		



		 $accounts=$this->db->query("SELECT sc.id_scheme,sc.scheme_name,COUNT(s.id_scheme_account)as scheme_count,sc.is_lucky_draw,SUM(total_pay.totalpay_amount) as paid_amount,SUM((select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 AND sc.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=s.id_scheme_account group by pay.id_scheme_account)) as paid_installments 

		 FROM scheme_account s 

		 LEFT JOIN scheme sc ON sc.id_scheme=s.id_scheme 

		 LEFT JOIN (SELECT id_scheme_account,SUM(IFNULL(payment_amount,0)) AS totalpay_amount FROM payment Where payment_status=1 GROUP BY id_scheme_account ) AS total_pay ON total_pay.id_scheme_account = s.id_scheme_account 



		 Where s.scheme_acc_number IS NOT NULL and s.active=1 and date(s.start_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."'  

		 ".($id_branch!='' && $id_branch!=0 && $branch==0 ? " and s.id_branch=".$id_branch."":'')."

		 ".($id_scheme!='' && $id_scheme!=0  ? " and s.id_scheme=".$id_scheme."":'')."

		  ".($is_live!='' ? " and s.is_closed=".$is_live."":'')."

		 ".($id_company!='' && $id_company!=0 && $company_settings==1 ? " and sc.id_company=".$id_company."":'')."

		 GROUP BY s.id_scheme"); 

		 //print_r($this->db->last_query());exit;

		 return $accounts->result_array();

	 }



	function scheme_group_summary_data($id){

		$from_date= $this->input->post('from_date');

		$to_date= $this->input->post('to_date');

		$id_branch  = $this->input->post('id_branch');

		$company_settings=$this->session->userdata('company_settings');

		$id_company = $this->session->userdata('id_company');

		$branch=$this->session->userdata('id_branch');

		$group_code=$this->input->post('id_group');

	$is_live=$this->input->post('is_live');

		



		 $accounts=$this->db->query("SELECT s.group_code,COUNT(s.group_code) as count,SUM(total_pay.totalpay_amount) as paid_amount,SUM((select IFNULL(IF(s.is_opening=1,IFNULL(s.paid_installments,0)+ IFNULL(if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight, COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues)),0), if(sc.scheme_type = 1 and sc.min_weight != sc.max_weight or (sc.scheme_type=3 AND sc.firstPayamt_as_payamt = 0), COUNT(Distinct Date_Format(pay.date_payment,'%Y%m')), sum(pay.no_of_dues))) ,0) from payment pay where pay.payment_status=1 and pay.id_scheme_account=s.id_scheme_account group by pay.id_scheme_account)) as paid_installments 

		 FROM scheme_account s

		 LEFT JOIN scheme sc ON sc.id_scheme=s.id_scheme

		 LEFT JOIN (SELECT id_scheme_account,SUM(IFNULL(payment_amount,0)) AS totalpay_amount FROM payment Where payment_status=1 GROUP BY id_scheme_account ) AS total_pay ON total_pay.id_scheme_account = s.id_scheme_account 

		 Where s.scheme_acc_number IS NOT NULL and s.active=1 and s.id_scheme= $id and date(s.start_date) BETWEEN '".date('Y-m-d',strtotime($from_date))."' AND '".date('Y-m-d',strtotime($to_date))."'  

		 ".($id_branch!='' && $id_branch!=0 && $branch==0 ? " and s.id_branch=".$id_branch."":'')."

		 ".($id_company!='' && $id_company!=0 && $company_settings==1 ? " and sc.id_company=".$id_company."":'')."

		  ".($is_live!='' ? " and s.is_closed=".$is_live."":'')."

		 ".($group_code!=''  ? " and s.group_code ='".$group_code."'":'')."

		 GROUP BY s.group_code"); 

//		print_r($this->db->last_query());exit;

		$account=$accounts->result_array();



		foreach($account as $r)

        {

			$return_data[$r['group_code']]=$r;

		}

		 return $return_data;

	}

	function is_luckly_draw_scheme($id)

	{

		

		$accounts=$this->db->query("SELECT s.id_scheme, s.scheme_name, s.code,s.is_lucky_draw 

			FROM scheme s where s.visible=1 and s.active=1 and s.id_scheme = $id");

	 

		$account=$accounts->row_array();

		return $account;

	}

	function get_group_scheme_code($id)

	{

		$accounts=$this->db->query("SELECT sg.id_scheme_group,sg.group_code,sg.id_scheme FROM `scheme_group` sg WHERE sg.id_scheme = $id");

		$account=$accounts->result_array();

		return $account;

	}

	

	

	function delete_gift_issued($id,$count)

	{		

		$this->db->where('id_scheme_account', $id);

		$status=$this->db->delete('gift_issued');			

		return $status;

	}

	/* ends */

   

}

?>