
<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_ret_section_transfer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        ini_set('date.timezone', 'Asia/Calcutta');
        $this->load->model('ret_section_transfer_model');
        $this->load->model('admin_settings_model');
        $this->load->model("log_model");

        if(!$this->session->userdata('is_logged'))
        {
            redirect('admin/login');
        }
        elseif($this->session->userdata('access_time_from') != NULL && $this->session->userdata('access_time_from') != "")
        {
            $now = time(); 
            $from = $this->session->userdata('access_time_from'); 
            $to = $this->session->userdata('access_time_to');  
            $allowedAccess = ($now > $from && $now < $to) ? TRUE : FALSE ;
            if($allowedAccess == FALSE){
                $this->session->set_flashdata('login_errMsg','Exceeded allowed access time!!');
                redirect('chit_admin/logout');	
            }			
        }
    }

    public function index()
	{	

	}	

    public function ret_section_transfer($type="")
    {
        $model = "ret_section_transfer_model";

        switch($type)
        {
            case 'list':
                $data['main_content'] = "section_transfer/list" ;
                $this->load->view('layout/template', $data);
            break;
            
            case 'getSectionTags':
                $data = $this->$model->getSectionTags($_POST);	 
                echo json_encode($data);
            break;   
            
            case 'save':
                    //echo "<pre>";print_r($_POST);exit;
                    //$addData = $_POST['trans_data'];
                    $transfer_to_section  = $_POST['trans_to_section'];
                    $branch = $_POST['id_branch'];

                
                    $dCData = $this->admin_settings_model->getBranchDayClosingData($branch);
					$datetime = ($dCData['entry_date'] == date("Y-m-d") ? date("Y-m-d H:i:s") : $dCData['entry_date']);
                        $this->db->trans_begin();
                    foreach($_POST['trans_data'] as $key => $val)
                    {
                        $tag_data['id_section'] = $transfer_to_section;
                        
                        $this->$model->updateData($tag_data,'tag_id',$val['tag_id'],'ret_taging');
                        //print_r($this->db->last_query());exit;

                        $secTags = array(

                            'tag_id'          =>    $val['tag_id'],
                            'from_branch'     =>    NULL,
                            'to_branch'       =>    $val['id_branch'],
                            'from_section'    =>    $val['trans_from_section'],
                            'to_section'      =>    $transfer_to_section,
                            'created_by'	  =>    $this->session->userdata('uid'),
                            'created_on'	  =>    date('Y-m-d H:i:s'),
                            'status'          =>    0, 
                            'date'            =>    $datetime,
                        );
                        $status = $this->$model->insertData($secTags,'ret_section_tag_status_log');

                    }
                    if($this->db->trans_status()===TRUE)
		             {
					 	$this->db->trans_commit();
					 	$this->session->set_flashdata('chit_alert',array('message'=>'Tag Transfered successfully','class'=>'success','title'=>'Section Transfer'));
					 	$return_data=array('message'=>'Tag transfer successfully','status'=>true);
					 	echo json_encode($return_data);
					 }
					 else
					 {
					 	$this->db->trans_rollback();						 	
					 	$this->session->set_flashdata('chit_alert',array('message'=>'Unable to proceed the requested process','class'=>'danger','title'=>'Section Transfer'));
					 	$return_data=array('message'=>'Unable to proceed the requested process','status'=>false);
					 	echo json_encode($return_data);
					 }
            break;    
        }

    }
}
?>
