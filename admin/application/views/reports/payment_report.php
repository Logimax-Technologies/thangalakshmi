<style type="text/css">
.DTTT_container{
margin-bottom:0 !important;
}
/* th,tr,td{

  border:1px solid;
} */
</style>
  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Payment Report-Pending Dues
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Reports</a></li>
            <li class="active">Pending Dues</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
           
              <div class="box">
              <!--  <div class="box-header">
                  <h3 class="box-title">Pending Dues Payment Report</h3>      
                								
                </div> -->
                <div class="box-body">
                <!-- Alert -->
                <?php 
                	if($this->session->flashdata('chit_alert'))
                	 {
                		$message = $this->session->flashdata('chit_alert');
                ?>
                       <div class="alert alert-<?php echo $message['class']; ?> alert-dismissable">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                    <h4><i class="icon fa fa-check"></i> <?php echo $message['title']; ?>!</h4>
	                    <?php echo $message['message']; ?>
	                  </div>
	                  
	            <?php } ?><br>
	            <div class="row">
	                 
	                 	<div class="col-md-12">
	                 		         <div class="col-md-2" style="">
                                  <div class="form-group">
                                          <div class="input-group">
                                                  <button class="btn btn-default btn_date_range" id="rpt_customer_unpaid">
                                                        <span style="display:none;"  id="rpt_customer_unpaid1"></span>
                                                        <span  style="display:none;"   id="rpt_customer_unpaid2"></span>
                                                        <i class="fa fa-calendar"></i> Date range picker
                                                        <i class="fa fa-caret-down"></i>
                                                  </button>
                                                  <span id="date_range_cus"></span>
                                          </div>
                                </div>
    		                   </div>
		                                  					  
                                <?php if($this->session->userdata('branch_settings')==1){?>							
                                    <div class="col-md-2" style="margin-top:-21px;">									
                                        <div class="form-group" >									
                                            <label>Select Branch </label>									
                                            <select id="branch_select" class="form-control" ></select>									
                                            <input id="id_branch" name="scheme[id_branch]" type="hidden" value=""/>								
                                        </div>							
                                    </div>							
                                <?php }?>   
                                
                                 <div class="col-md-3" style="margin-top:-21px;">									
                                        <div class="form-group" >									
                                            <label>Select Scheme </label>									
                                            <select id="scheme_select" class="form-control" style="width:200px;" ></select>									
                                            <input id="id_scheme" name="scheme[id_branch]" type="hidden" value=""/>								
                                        </div>							
                                    </div>
                                
                            <!--    <div class="col-md-2" style="margin-top:-21px;">
    								<div class="form-group" >
    									<label>Scheme name</label>									
    									<select id="scheme_select" class="form-control" ></select>
    									<input id="id_schemes"  name="id_scheme" type="hidden" value="" />
    								</div>
    						   </div> -->
                            
		                     <div class="col-md-2" style="margin-top:-21px;"> 
									<label></label>
									<div class="form-group">
										<button type="button" id="search_unpaid_list" class="btn btn-info">Search</button>   
									</div>
							    </div>
		                    
		                 </div>
	                 	
		             
	                 </div>
	                 
	                 <div class="box box-info stock_details collapsed-box">
						               <div class="box-header with-border">
						               <h3 class="box-title">Payment Report Pending Dues Summary<span class="summery_description"></span></h3>
						         <div class="box-tools pull-right">
							           <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
						         </div>
						     </div>
					    <div class="box-body collapse" style="display: none;">
					       <div class="row" id="unpaid_payment" style="background: #ecf0f5;">
               

					       </div>
							
						</div>

					</div>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped text-center payreport_customer" id="customer_pay_details" >
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Cus Id</th>
                        <th>Customer</th>
                        <th>Scheme Name</th>
                        <th>Account Name</th>
                        <th>Chit Number</th> 
                        <th>Mobile</th>                     
                        <th>Scheme Code</th>
                        <th>Start Date</th>
                        <th>Last Paid Date</th>
                        <th>Amount Paid</th>
                        <th>Total Installment</th>
                        <th>Paid Installment</th>
                        <th>Unpaid Month</th>
                      
                      </tr>
                    </thead>
                   
                    
                     <tfoot>
                
                    </tfoot>
                  </table>
                 </div>
                </div><!-- /.box-body -->
                <div class="overlay" style="display:none">
                 <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      


<!-- modal -->      
<div class="modal fade" id="pay-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Scheme Payment</h4>
      </div>
      <div class="modal-body">
         <div class="fluid-container">
         	<div class="row">
         		<div class="col-sm-6">
              		<div class="form-group">
      					<label for="">Account Name</label>
      					<input type="hidden" id="acc_id" name="acc_id"/>
		                    <input type='text' id="acc_name" name="acc_name" readonly="true" class="form-control" />
		                 
          			</div>		
	             </div>	   
	             <div class="col-sm-6">
              		<div class="form-group">
      					<label for="">Payment Date</label>
      					<div class='input-group date'>
		                    <input type='text'  id='pay_date' name="pay_date"  class="form-control myDatePicker" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
          			</div>		
	             </div>	   
	         </div>
         </div>    
         <div class="row">
         	<div class="col-sm-6">
          		<div class="form-group">
  					<label for="">Amount</label>
  						<div class="input-group">
  					<span class="input-group-addon">
		                        <span class="fa fa-inr"></span>
		                    </span>
	                <input type='text' id="sch_amount" name="sch_amount" readonly="true" class="form-control" />
	                </div>
      			</div>		
	         </div>	 
	         <div class="col-sm-6">
          		<div class="form-group">
  					<label for="">Payment mode</label>
  						<select id="pay_mode" name="pay_mode" class="form-control">
  							<option value="1">Cash</option>
  							<option value="2">Cheque</option>
  							<option value="3">Credit Card</option>
  							<option value="4">Debit Card</option>  							
  						</select>	              
      			</div>		
	         </div>	 
         </div>
         <div class="row">
         	 <div class="col-sm-12">
          		<div class="form-group">
  					<label for="">Remark</label>
  						<textarea id="pay_remark" name="pay_remark" class="form-control"></textarea>
      			</div>		
	         </div>	 
         </div>
      </div>
      <div class="modal-footer">
      	<a href="#" id="pay_amount" class="btn btn-danger" >Pay</a>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- / modal -->      

