<style type="text/css">

   	hr {   margin-bottom: 8px!important;

    margin-top: 8px!important;}

   

   </style>   

      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">
      
        
      	<section class="content">
         
          <div class="row">
            <div class="col-xs-12">
           <?php if($access==1){?>
              <div class="box box-primary" style="background: #ECF0F5">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Dashboard 
            <small>Control panel</small>
          </h1>
        </section>

        <div class="col-md-12">

        	<div class="row">
 			
        			
        			<div class="col-md-4">


						   <?php if($this->session->userdata('branch_settings')==1){?>
							<br/>
							<div class="form-group">
								<label>Select Branch &nbsp;&nbsp;</label>
								<select id="branch_select" class="form-control" style="width:150px;" ></select>
								<input id="id_branch" name="scheme[id_branch]" type="hidden" value=""/>
							</div>
								
							<?php }?>
		             
        			
        			</div>
 

        	</div>

        	 
        	

        </div>

      

        <!-- Main content -->

        <section class="content">

          <!-- Small boxes (Stat box) -->

          <div class="row">

             <div class="col-lg-3 col-xs-6">

               <div class="info-box  bg-purple">

                <span class="info-box-icon"><i class="fa fa-group"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Wallet Accounts</span>

                  <span class="info-box-number"><?php echo $wallets;  ?></span>

                

                  	 <a style="color: white"  href="<?php echo base_url('index.php/wallet/account/list');?>" class="small-box-footer">Create Wallet A/c <i class="fa fa-arrow-circle-right"></i></a>

	                <a style="color: white" href="<?php echo base_url('index.php/wallet/transaction/list');?>" class="small-box-footer">Wallet Transaction <i class="fa fa-plus-circle"></i></a>
                  	
                

                 	


                </div><!-- /.info-box-content -->

              </div><!-- /.info-box -->

            </div><!-- ./col --> 

            <div id="payments">

             <div class="col-lg-3 col-xs-6">

              <div class="info-box bg-green">

                <span class="info-box-icon"><i class="fa fa-paypal"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Payments</span>

                  <span class="info-box-number" id="test"><?php echo $payment['month']['paid']; ?></span>

                  <div class="progress">

                    <div class="progress-bar" style="width: <?php echo $payment['paid_avg']?>%"></div>

                  </div>

                  <span class="progress-description">

                    <?php echo $payment['paid_avg'];?>% in 30 Days

                  </span>

                </div><!-- /.info-box-content -->

              </div><!-- /.info-box -->

            </div><!-- ./col -->

        </div>

            <div id="accounts">


             <div class="col-lg-3 col-xs-6" >

               <div class="info-box bg-aqua">

                <span class="info-box-icon"><i class="fa fa-group"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Accounts</span>

                  <span class="info-box-number" id="all_reg"><?php echo $account['all_reg']; ?></span>

                  <div class="progress">

                    <div class="progress-bar" style="width: <?php echo $account['increase']?>%"></div>

                  </div>

                  <span class="progress-description">

                    <?php echo $account['increase'];?>% in 30 Days

                  </span>

                </div><!-- /.info-box-content -->

              </div><!-- /.info-box -->

            </div><!-- ./col -->
            	
            </div>


           <div class="col-lg-3 col-xs-6">

         

              <!-- /.info-box --> 

              <div class="info-box bg-yellow">

                <span class="info-box-icon"><i class="ion ion-person-add"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Customers</span>

                  <span class="info-box-number"><?php echo $customer['all_reg']; ?></span>

                  <div class="progress">

                    <div class="progress-bar" style="width: <?php echo $customer['increase']?>%"></div>

                  </div>

                  <span class="progress-description">

                    <?php echo $customer['increase'];?>% in 30 Days

                  </span>

                </div><!-- /.info-box-content -->

              </div><!-- /.info-box -->

            </div><!-- ./col -->

        

           

                

          </div><!-- /.row -->

          

          <!-- main row -->

            <div class="row" >

            	<div class="col-md-3"><!--/ payments -->

            		<div class="box box-success">

		                <div class="box-header">

		                  <h3 class="box-title">Inter Wallet </h3>

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                  <table class="table table-condensed">

		                    <tr>

		                      <th>Payments</th>

		                      <th>Credit</th>

		                      <th>Redeem</th>

		                     

		                    </tr>

							 <tr>                     

		                      <td>Today</td>

		                      <td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/t'); ?>"><span class="badge bg-green" id="t_trans"><?php echo $inter_wallet['t_trans']; ?></span></a></td>

		                        <td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/tr'); ?>"><span class="badge bg-green" id="t_redeem_trans"><?php echo $inter_wallet['t_redeem_trans']; ?></span></a></td>

		                     

		                    </tr>

		                    <tr>                     

		                      <td>Yesterday</td>

		                      <td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/y'); ?>"><span class="badge bg-green" id="y_trans"><?php echo $inter_wallet['y_trans']; ?></span></a></td>

		                       <td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/yr'); ?>"><span class="badge bg-green" id="y_redeem_trans"><?php echo $inter_wallet['y_redeem_trans']; ?></span></a></td>

		                     

		                    </tr> 

		                   

		                    <tr>

		                    	<td>This Week</td>

		                    	<td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/twr')?>"><span class="badge bg-green" id="tw_trans"><?php echo $inter_wallet['tw_trans']; ?></span></a></td>

		                    	<td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/tw')?>"><span class="badge bg-green" id="tw_redeem_trans"><?php echo $inter_wallet['tw_redeem_trans']; ?></span></a></td>

		                    

		                    </tr>     

		                    <tr>

		                    	<td>This Month</td>

		                    	<td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/tm'); ?>"><span class="badge bg-green" id="tm_trans"><?php echo $inter_wallet['tm_trans']; ?></span></a></td>

		                    	<td><a href="<?php echo base_url('index.php/reports/inter_wallet_detail/tmr'); ?>"><span class="badge bg-green" id="tm_redeem_trans"><?php echo $inter_wallet['tm_redeem_trans']; ?></span></a></td>

		                    	

		                    

		                    </tr>

		                  

		                    

		                  </table>

		                </div><!-- /.box-body --><br>

		                <div class="box ">

		              <div class="box-header">

		                  <h3 class="box-title">Wallet customers</h3>

		                 

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	<tr>

		                        <td>Registered</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/inter_wallet_wc'); ?>"><span class="badge bg-green"><?php echo $inter_wallet_accounts; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Not Registered</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/inter_wallet_woc'); ?>"><span class="badge bg-green" ><?php echo $inter_wallet_accounts_woc; ?></span></a></td> 

		                      </tr>  

		                	

		                	</table>

		                </div>

		             </div>

<!--Added Division by ARVK-->		                	
		                

		              </div><!-- /.box -->

            	</div><!--/ payments -->       	

        		<div id="payment_details">
        			


            	<div class="col-md-3"><!--/ payments -->

            		<div class="box box-success" >

		                <div class="box-header" >

		                  <h3 class="box-title">Total Payments</h3>

		                  <div class="pull-right">

		                  	 <a href="<?php echo base_url('index.php/reports/detail/all_pay_status'); ?>"><span class="label bg-green" id="tot_pay"><?php echo $payment['all_pay']['paid']; ?></span></a>

		                  </div>

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                  <table class="table table-condensed">

		                    <tr>

		                      <th>Payments</th>

		                      <th>Paid</th>

		                     

		                    </tr>

							 <tr>                     

		                      <td>Today</td>

		                      <td><a href="<?php echo base_url('index.php/reports/detail/payment/t'); ?>"><span class="badge bg-green" id="t_paid"><?php echo $payment['today']['paid']; ?></span></a></td>

		                     

		                    </tr>

		                    <tr>                     

		                      <td>Yesterday</td>

		                      <td><a href="<?php echo base_url('index.php/reports/detail/payment/y'); ?>"><span class="badge bg-green" id="y_paid"><?php echo $payment['yesterday']['paid']; ?></span></a></td>

		                     

		                    </tr> 

		                   

		                    <tr>

		                    	<td>This Week</td>

		                    	<td><a href="<?php echo base_url('index.php/reports/detail/payment/tw')?>"><span class="badge bg-green" id="tw_paid"><?php echo $payment['week']['paid']; ?></span></a></td>

		                    

		                    </tr>     

		                    <tr>

		                    	<td>This Month</td>

		                    	<td><a href="<?php echo base_url('index.php/reports/detail/payment/tm'); ?>"><span class="badge bg-green"  id="tm_paid"><?php echo $payment['month']['paid']; ?></span></a></td>

		                    

		                    </tr>
<!--
		                   <tr>

		                    	<td>Total Payments</td>

		                    	<td><a href="<?php echo base_url('index.php/reports/detail/payment/all'); ?>"><span class="badge bg-green"><?php echo $payment['all_pay']['paid']; ?></span></a></td>

		                    

		                    </tr>-->

		                   <tr>

		                    	<td>Awaiting Payments</td>

		                    	<td><a href="<?php echo base_url('index.php/reports/detail/awaiting'); ?>"><span class="badge bg-orange"  id="awaiting"><?php echo $payment['awaiting']['awtng_count']; ?></span></a></td>

		                    

		                    </tr>

		                    

		                  </table>

		                </div><!-- /.box-body -->

<!--Added Division by ARVK-->		                	
		                	<div class="box ">

		              <div class="box-header">

		                  <h3 class="box-title">Payment Through</h3>

		                 

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	<tr>

		                        <td>Mobile App</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/payment/MOBILE'); ?>"><span class="badge bg-green" id="thr_m"><?php echo $payment['mob_paid']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Web App</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/payment/WEB'); ?>"><span class="badge bg-green" id="thr_w"><?php echo $payment['web_paid']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Admin</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/payment/ADMIN'); ?>"><span class="badge bg-green" id="thr_a"><?php echo $payment['admin_paid']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	</table>

		                </div>

		             </div> 


<!--  / Added Division by ARVK-->


		              </div><!-- /.box -->

            	</div><!--/ payments --> 

            </div>

            	<div id="accounts_detail">
            		
            		<div class="col-md-3"><!--/ Account -->

            		<div class="box box-info">

		              <div class="box-header">

		                  <h3 class="box-title">Accounts</h3>

		                  <div class="pull-right">

		                  	<a href="<?php echo base_url('index.php/reports/detail/account/all'); ?>"><span class="label bg-aqua" id="all_acc"><?php echo $account['all_reg']; ?></span></a>

		                  </div>

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

							  <tr>

		                        <td>With out payments</td> 

		                        <td><a href="<?php echo base_url('index.php/account/withoutPayment'); ?>"><span class="badge bg-red" id="acc_wo_pay"><?php echo $account['acc_wo_pay']; ?></span></a></td> 

		                      </tr> 

		                      <tr>

		                        <th>Account</th>

		                        <th>Joined</th>		                     

		                      </tr>

							  <tr>

		                        <td>Today</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/t');?>"><span class="badge bg-aqua"  id="today_reg"><?php echo $account['today_reg']; ?></span></a></td> 

		                      </tr> 

		                      <tr>

		                        <td>Yesterday</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/y');?>"><span class="badge bg-aqua" id="yes_reg"><?php echo $account['yes_reg']; ?></span></a></td> 

		                      </tr>     

		                    

		                      <tr>

		                        <td>This Week</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/tw');?>"><span class="badge bg-aqua" id="wk_reg"><?php echo $account['wk_reg']; ?></span></a></td> 

		                      </tr>   

		                      <tr>

		                        <td>This Month</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/tm');?>"><span class="badge bg-aqua" id="m_reg"><?php echo $account['m_reg']; ?></span></a></td> 

		                      </tr>  

		                	

		                	</table>

		                </div>
<!--Added Division by ARVK-->		                	
		                	<div class="box ">

		              <div class="box-header">

		                  <h3 class="box-title">Created Through</h3>

		                 

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	<tr>

		                        <td>Mobile App</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/ma');?>"><span class="badge bg-aqua" id="mob_reg"><?php echo $account['mob']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Web App</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/wa');?>"><span class="badge bg-aqua"  id="w_reg"><?php echo $account['web']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Admin</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/account/a');?>"><span class="badge bg-aqua"  id="a_reg"><?php echo $account['admin']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	</table>

		                </div>

		             </div> 
<!--  / Added Division by ARVK-->		
		             
		             </div>   

		           </div> 

            	</div>

            	     	

		           

		           <div class="col-md-3"><!--/ Customers -->

            		<div class="box box-warning">

		              <div class="box-header">

		                  <h3 class="box-title">Customers</h3>

		                   <div class="pull-right">

		                  	<a href="<?php echo base_url('index.php/reports/detail/registration/all'); ?>"><span class="label bg-orange"><?php echo $customer['all_reg']; ?></span></a>

		                  </div>

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	  <tr>

		                      	<td>With out Accounts</td>

		                      	<td></td>

		                      	<td><a href="<?php echo base_url('index.php/customer/withoutAccount'); ?>"><span class="badge bg-red"><?php $wc= $customer['wo_acc']; $cl=$closed; echo $data=$wc+$cl; ?></a></span></td>

		                      </tr>
		                      
		                      <tr>

		                        <th>Customers</th>

		                        <th></th>

		                        <th>Registered</th>		                     

		                      </tr>

							  <tr>

		                      	<td>Today</td>

		                      	<td></td>

		                      	<td><a href="<?php echo base_url('index.php/reports/detail/registration/t'); ?>"><span class="badge bg-orange"><?php echo $customer['today_reg']; ?></a></span></td>

		                      </tr>

		                      <tr>

		                      	<td>Yesterday</td>

		                      	<td></td>

		                      	<td><a href="<?php echo base_url('index.php/reports/detail/registration/y'); ?>"><span class="badge bg-orange"><?php echo $customer['yes_reg']; ?></span></a></td>

		                      </tr>     

		                       

		                      <tr>

		                      	<td>This Week</td>

		                      	<td></td>

		                      	<td><a href="<?php echo base_url('index.php/reports/detail/registration/tw'); ?>"><span class="badge bg-orange"><?php echo $customer['wk_reg']; ?></a></span></td>

		                      </tr>       

		                      <tr>

		                      	<td>This Month</td>

		                      	<td></td>

		                      	<td><a href="<?php echo base_url('index.php/reports/detail/registration/tm'); ?>"><span class="badge bg-orange"><?php echo $customer['m_reg']; ?></a></span></td>

		                      </tr>

		                	</table>

		                </div>
<!--Added Division by ARVK-->		                	
		                	<div class="box ">

		              <div class="box-header">

		                  <h3 class="box-title">Registered Through</h3>

		                 

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	<tr>

		                        <td>Mobile App</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/registration/ma');?>"><span class="badge bg-orange"><?php echo $customer['mob']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Web App</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/registration/wa');?>"><span class="badge bg-orange"><?php echo $customer['web']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	<tr>

		                        <td>Admin</td> 

		                        <td><a href="<?php echo base_url('index.php/reports/detail/registration/a');?>"><span class="badge bg-orange"><?php echo $customer['admin']['joined_thro']; ?></span></a></td> 

		                      </tr>  

		                	</table>

		                </div>

		             </div> 
<!--  / Added Division by ARVK-->
		             </div>   

		           </div>   

            </div>

          <!-- /main row -->

               

          <div class="row">

            <div class="col-md-3">

            	<div class="info-box bg-green">

 				<span class="info-box-icon"><i class="ion ion-person-add"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Existing Request</span>

                  <span class="info-box-number" id="e_all_reg"><?php echo $existing_request['all_reg']; ?></span>

                 <div class="progress">

                    <div class="progress-bar" style="width: <?php echo $existing_request['increase']?>%"></div>

                  </div>

                  <span class="progress-description">

                    <?php echo $existing_request['increase'];?>% in 30 Days

                  </span>

                </div><!-- /.info-box-content -->

              </div>


            	<div class="box">

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	<div class="box-header">

		                  <h3 class="box-title">Existing Request</h3>

		                  <div class="pull-right">

		                  	 <a href="<?php echo base_url('index.php/account/scheme_reg/list'); ?>"><span class="label bg-green" id="total_request"><?php echo $existing_request['total_request']; ?></span></a>


		                  </div>

							
							
							<tr>

		                    	<td>Processing Account</td>

		                    	<td><a href="<?php echo base_url('index.php/account/scheme_reg/list/0'); ?>"><span class="badge bg-green" id="exiting_processing"><?php echo$existing_request['exiting_processing']; ?></span></a></td>

		                    

		                    </tr>
		                	
							<tr>

		                    	<td>Approved Account</td>

		                    	<td><a href="<?php echo base_url('index.php/account/scheme_reg/list/1'); ?>"><span class="badge bg-green" id="exiting_approved"><?php echo $existing_request['exiting_approved']; ?></span></a></td>


		                    </tr>
							
							<tr>

		                    	<td>Rejected Account</td>

		                    	<td><a href="<?php echo base_url('index.php/account/scheme_reg/list/2'); ?>"><span class="badge bg-orange" id="exiting_rejected"><?php echo $existing_request['exiting_rejected']; ?></span></a></td>

		                    

		                    </tr>
							
							
							</table>

		                </div>

		             </div>  

		              
            </div>
			
			
						
            
            <div class="col-md-3">
                    <div class="info-box bg-blue">
    
                        <span class="info-box-icon"><i class="fa fa-user-times"></i></span>
        
                        <div class="info-box-content">
        
                          <span class="info-box-text">Closed Accounts</span>
        
                          <span class="info-box-number" id="closed"><?php echo $closed; ?></span>
        
                        </div><!-- /.info-box-content -->
        
                      </div>
          		       <div class="box box-primary">

		              <div class="box-header">

		                  <h3 class="box-title">Accounts</h3>

		                  <div class="pull-right">

		                  	<a href="<?php echo base_url('index.php/reports/detail/closed_acc/all'); ?>"><span class="label bg-blue"><?php echo $closed; ?></span></a>

		                  </div>

		                </div><!-- /.box-header -->

		                <div class="box-body no-padding">

		                	<table class="table table-condensed">

		                	  <tr>

		                        <th>About to Close</th>

		                        <th>Accounts</th>		                     

		                      </tr>

							 

		                        <td>One Installments Remaining</td> 

		                        <td style="text-align: center;"><a href="<?php echo base_url('index.php/reports/detail/close_due/onepending');?>"><span class="badge bg-blue" id="one_pending"><?php echo $one_pending; ?></span></a></td> 

		                      </tr>     

		                    

		                      <tr>

		                        <td>Two Installments Remaining</td> 

		                        <td style="text-align: center;"><a href="<?php echo base_url('index.php/reports/detail/close_due/twopending');?>"><span class="badge bg-blue" id="two_pending"><?php echo  $two_pending; ?></span></a></td> 

		                      </tr>   

		                      <tr>

		                        <td style="color: red;font-weight:bold;">Renewal</td> 

		                        <td style="text-align: center;"><a href="<?php echo base_url('index.php/reports/detail/renewals/all');?>"><span class="badge bg-red"  id="renewal"> <?php echo $renewal; ?></span></a></td> 

		                      </tr>  

		                	</table>

		                </div>
		            </div>
             
	           
	          </div>

          

	         <div class="col-md-3">
	         
	        <!-- Customer Feedback N-->
			 
			   <div class="info-box bg-red">    <!-- Customer Feedback-->

                <span class="info-box-icon"><i class="fa fa-server"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Customer Feedback</span>

                  
               <a href="<?php echo base_url('index.php/reports/customer_enquiry'); ?>"><span style="color: #fff !important" class="info-box-number"><?php echo $feedback_count; ?></span></a>

                </div><!-- /.info-box-content -->

              </div><!-- /.i
	            
				<!-- Customer Feedback-->

	            
	            <!-- /.info-box --> 

              <div class="info-box bg-green">

                <span class="info-box-icon"><i class="fa fa-server"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Schemes</span>

                  
                  <a href="<?php echo base_url('index.php/scheme'); ?>"><span style="color: #fff !important" class="info-box-number"><?php echo $scheme_count; ?></span></a>

                </div><!-- /.info-box-content -->

              </div><!-- /.info-box -->
			  
			  
			 <?php $data=$this->dashboard_model->scheme_group();

            	if($data['has_lucky_draw']==1)
            	{?>


               <div class="info-box bg-green">

                <span class="info-box-icon"><i class="fa fa-server"></i></span>

                <div class="info-box-content">

                  <span class="info-box-text">Schemes Groups</span>

                  
                  <a href="<?php echo base_url('index.php/account/scheme_group/list'); ?>"><span style="color: #fff !important" class="info-box-number"><?php echo $group_count; ?></span></a>

                </div><!-- /.info-box-content -->

              </div>
            	<?php }


               ?>

             </div>





	     </div>
	     <div class="row">
	     	
	    
	        
            <div class="col-md-6">

	          	  <div class="box box-solid bg-teal-gradient">

	                <div class="box-header">

	                  <i class="fa fa-th"></i>

	                  <h3 class="box-title">Rate Graph</h3>

	                  <div class="box-tools pull-right">

	                    <a class="btn bg-teal btn-sm" href="<?php echo base_url('index.php/settings/rate/list');?>"><i class="fa fa-plus-circle"></i> Add rate</a> 

	                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>

	         

	                  </div>

	                </div>

	                <div class="box-body border-radius-none">

	                  <div class="chart" id="rate-chart" style="height: 250px;"></div>

	                </div>

	             </div>     

	        </div> 


          		 

		 </div> 

		           
				
	        
	
        

               

        </section><!-- /.content -->
		
		<div class="overlay"  style="display:none">
			<i class="fa fa-refresh fa-spin"></i>
		</div>

      </div> 
      <?php }?>
      </div> 
      </div> 
      </section>
      </div><!-- /.content-wrapper -->
	  
				
	        

<script>
var branch_id = "<?php echo $this->session->userdata('dashboard_branch');?>";
</script>