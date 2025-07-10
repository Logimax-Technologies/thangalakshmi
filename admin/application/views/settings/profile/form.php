      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Profile 
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('index.php/settings/profile/list');?>">Master</a></li>
            <li class="active">Profile</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
     
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Profile - <?php echo ( $profile['id_profile']!=NULL?'Edit' :'Add'); ?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="">
				<?php echo form_open((  $profile['id_profile']!=NULL &&  $profile['id_profile']>0 ?'settings/profile/update/'.$profile['id_profile']:'settings/profile/save')) ?> 
				  <div class="row">
				 	<div class="form-group">
                       <label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Profile Name</label>
                       <div class="col-md-4">
                       	 <input type="text" class="form-control" id="profile_name" name="profile[profile_name]" value="<?php echo set_value('$profile[profile_name]',$profile['profile_name']); ?>" placeholder="eg: Admin" required="true"> 	
                  <p class="help-block"></p>
                       	
                       </div>
                    </div>
				 </div><br>				
				 <div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 "> Scheme Close Rights</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[allow_acc_closing]" value="1" <?php if($profile['allow_acc_closing'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[allow_acc_closing]" value="0" <?php if($profile['allow_acc_closing'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div>
				</br>
				
				
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 "> Is OTP Required for Login</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[req_otplogin]" value="1" <?php if($profile['req_otplogin'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[req_otplogin]" value="0" <?php if($profile['req_otplogin'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Show Pending Download</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[show_pending_download]" value="1" <?php if($profile['show_pending_download'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[show_pending_download]" value="0" <?php if($profile['show_pending_download'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Show Cart Items</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[show_cart]" value="1" <?php if($profile['show_cart'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[show_cart]" value="0" <?php if($profile['show_cart'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Allow Bill Cancel</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[allow_bill_cancel]" value="1" <?php if($profile['allow_bill_cancel'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[allow_bill_cancel]" value="0" <?php if($profile['allow_bill_cancel'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">OTP Bill Cancel</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[bill_cancel_otp]" value="1" <?php if($profile['bill_cancel_otp'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[bill_cancel_otp]" value="0" <?php if($profile['bill_cancel_otp'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">OTP For Credit</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[credit_sales_otp_req]" value="1" <?php if($profile['credit_sales_otp_req'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[credit_sales_otp_req]" value="0" <?php if($profile['credit_sales_otp_req'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Allow Branch Trasnfer Cancel</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[allow_branch_transfer_cancel]" value="1" <?php if($profile['allow_branch_transfer_cancel'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[allow_branch_transfer_cancel]" value="0" <?php if($profile['allow_branch_transfer_cancel'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				<div class="row">                          
                	<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Allow Bill Type</label>                           
                	<div class="col-md-6">  
                		<div class="col-md-3">                            
                			<input type="radio" name="profile[allow_bill_type]" value="1" <?php if($profile['allow_bill_type'] == 1){ ?> checked="true" <?php } ?> >  Normal                       
                		</div> 
                		<div class="col-md-3">                           
                			<input type="radio" name="profile[allow_bill_type]" value="2" <?php if($profile['allow_bill_type'] == 2){ ?> checked="true" <?php } ?>  >  EDA                         
                		</div>  
                		<div class="col-md-3">                           
                			<input type="radio" name="profile[allow_bill_type]" value="3" <?php if($profile['allow_bill_type'] == 3){ ?> checked="true" <?php } ?>  >  All                         
                		</div>                        
                											
                		<p class="help-block"></p>                        
                	</div>                       
                </div></br>

				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Device Wise Login</label>                           
					<div class="col-md-6">  
						<div class="col-md-3">                            
							<input type="radio" name="profile[device_wise_login]" value="1" <?php if($profile['device_wise_login'] == 1){ ?> checked="true" <?php } ?> >  Yes                          
						</div> 
						<div class="col-md-3">                           
							<input type="radio" name="profile[device_wise_login]" value="0" <?php if($profile['device_wise_login'] == 0){ ?> checked="true" <?php } ?>  >  No                          
						</div>                         
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
				
				<div class="row">                          
					<label for="chargeseme_name" class="col-md-2 col-md-offset-1 ">Branch Transfer Option</label>                           
					<div class="col-md-8">  
						<div class="col-md-8">                            
							<input type="checkbox" id="tag_transfer" name="profile[tag_transfer]" <?php if($profile['tag_transfer'] == 1){ ?> checked="true" value="1" <?php } else {?> value="0" <?php } ?> >Tag &nbsp;<input type="checkbox" id="non_tag_transfer" name="profile[non_tag_transfer]" <?php if($profile['non_tag_transfer'] == 1){ ?> checked="true" value="1" <?php } else {?> value="0" <?php } ?>  >Non-Tag &nbsp;<input type="checkbox" name="profile[purchase_item_transfer]" id="purchase_item_transfer" <?php if($profile['purchase_item_transfer'] == 1){ ?> checked="true" value="1" <?php } else {?>  value="0" <?php } ?> >Purchase Item &nbsp;<input type="checkbox" name="profile[packaging_item_transfer]" id="packaging_item_transfer" <?php if($profile['packaging_item_transfer'] == 1){ ?> checked="true" value="1" <?php } else {?> value="0" <?php } ?> >Packaging Items
						</div> 
					                       
						                                  
						<p class="help-block"></p>                        
					</div>                       
				</div></br>
				
		
 
	
				
				<br/>      
				 <div class="row col-xs-12">
				   <div class="box box-default"><br/>
					  <div class="col-xs-offset-5">
						<button type="submit" class="btn btn-primary">Save</button> 
						<button type="button" class="btn btn-default btn-cancel">Cancel</button>
						
					  </div> <br/>
					</div>
				  </div>      
				        	
               </form>              	              	
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
         

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->