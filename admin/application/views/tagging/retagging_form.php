 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	        Re-Tagging Process
	  </h1>
	  
	</section>

	<!-- Main content -->
	<section class="content">
	  <div class="row">
	    <div class="col-xs-12">
	       <div class="box box-primary">
	         <div class="box-body">  
			   <div class="row">
					<div class="col-xs-12">
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
						  
					<?php } ?>  
					</div>
			   </div></br>
			   
			   
			    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  
                                <div class="box box-primary">  
                                    <div class="box-body"> 
                                        <div class="box-header with-border">
                                        </div>
                                        <div class="row">
                                           <div class="col-md-3"> 
                        						<?php if($this->session->userdata('branch_settings')==1 && $this->session->userdata('id_branch')==0){?>
                        						<div class="form-group tagged">
                        							<label>Select Branch</label>
                        							<select id="branch_select" class="form-control branch_filter" style="width:100%;" disabled></select>
                        							<input type="hidden" id="id_branch"  value="1"> 
                        						</div> 
                        						<?php }else{?>
                        							<input type="hidden" id="id_branch"  value="1"> 
                        						<?php }?> 
                        					</div>  
                        					
                        					<div class="col-md-3">
                        					    <label>Type</label>
                        					    <select class="form-control" id="report_type">
                        					        <option value="1">Sales Return</option>
                        					        <option value="3">Partly Sale</option>
                        					        <option value="4">Old Metal</option>
                        					        <option value="5">Non Tag Return</option>
                        					    </select>
                        					</div>
                        					
                        					
                        					<div class="col-md-2"> 
                        						<label></label>
                        						<div class="form-group">
                        							<button type="button" id="retag_search" class="btn btn-info">Search</button>   
                        						</div>
                        					</div>
					
                                        </div>
                                    
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="col-md-6">  
                                <div class="box box-primary">  
                                    <div class="box-body"> 
                                         <div class="box-header with-border">
                                        </div><!-- /.box-header -->
                                        <div class="row">
                                            <div class="col-md-3">
                        					    <label>Select Process</label>
                        					    <select class="form-control" id="tag_process">
                        					        <option value="1">Add to ReTag</option>
                        					        <option value="2">Other Issue</option>
                        					        <option value="4">Add to Non Tag</option>
                        					        <option value="5">Accounts Stock</option>
                        					    </select>
                        					</div>
                                            
                                            
                                            <div class="col-md-3 category" style="display:none;"> 
                        				        <label>Select Category</label>
                        					    <select class="form-control" id="select_category" style="width:100%;"></select>
                        					</div>
                        					
                        					<div class="col-md-3 purity" style="display:none;"> 
                        				        <label>Select Purity</label>
                        					    <select class="form-control" id="select_purity" style="width:100%;"></select>
                        					</div>
                        					
                                            <div class="col-md-3 product" style="display:none;"> 
                        				        <label>Select Product</label>
                        					    <select class="form-control" id="prod_select" style="width:100%;"></select>
                        					</div>
                        					<div class="col-md-3 design" style="display:none;"> 
                        				        <label>Select Design</label>
                        					    <select class="form-control" id="des_select" style="width:100%;"></select>
                        					</div>
                        					<div class="col-md-3 sub_design" style="display:none;"> 
                        				        <label>Select Sub Design</label>
                        					    <select class="form-control" id="sub_des_select" style="width:100%;"></select>
                        					</div>
                                					
                                			<div class="col-md-3"> 
                        						<label></label>
                        						<div class="form-group">
                        						    <button type="button" id="create_retag" class="btn btn-primary" >Save</button> 
                        						</div>
                        					</div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                   </div> 
                   
		  
	           <div class="row retag_details">
	               <div class="col-md-12">
	               	<div class="table-responsive">
	                 <table id="retagging_list" class="table table-bordered table-striped text-center">
	                    <thead>
						    <tr> 
                            	<th width="5%"><label class="checkbox-inline"><input type="checkbox" id="select_all" name="select_all" value="all"/>All</label></th>     
                            	<th>Branch</th>
                            	<th>Bill No</th>
                            	<th>Bill Date</th>
                            	<th>Tag Code</th>
                            	<th>Product</th>
                            	<th>Design</th>
                            	<th>Gross Wt(g)</th>
                            	<th>Net Wt(g)</th>
                            	<th>Amount</th>
                            </tr>
	                    </thead> 
	                     <tbody> 
	                </tbody>
						   
	                 </table>
	              </div>
	               </div>
	           </div></br>
	           
	           <div class="row non_tag" style="display:none;">
	               <div class="col-md-12">
	               	<div class="table-responsive">
	                 <table id="non_tag_list" class="table table-bordered table-striped text-center">
	                    <thead>
						    <tr> 
                            	<th width="5%"><label class="checkbox-inline"><input type="checkbox" id="non_tag_select_all" name="select_all" value="all"/>All</label></th>     
                            	<th>Branch</th>
                            	<th>Bill No</th>
                            	<th>Bill Date</th>
                            	<th>Product</th>
                            	<th>Design</th>
                            	<th>Gross Wt(g)</th>
                            	<th>Net Wt(g)</th>
                            	<th>Amount</th>
                            </tr>
	                    </thead> 
	                     <tbody> 
	                </tbody>
						   
	                 </table>
	              </div>
	               </div>
	           </div></br>
	           
	           <div class="row partly_sale_details" style="display:none;">
	               <div class="col-md-12">
	               	<div class="table-responsive">
	                 <table id="partly_sale_list" class="table table-bordered table-striped text-center">
	                    <thead>
						    <tr> 
                            	<th width="10%"><label class="checkbox-inline"><input type="checkbox" id="select_all_tag" name="select_all" value="all"/>Tag Code</label></th>     
                            	<th>Branch</th>
                            	<th>Bill No</th>
                            	<th>Bill Date</th>
                            	<th>Product</th>
                            	<th>Design</th>
                            	<th>Sub Design</th>
                            	<th>Gross Wt(g)</th>
                            	<th>Sold Wt(g)</th>
                            	<th>Bal Wt(g)</th>
                            </tr>
	                    </thead> 
	                     <tbody> 
	                </tbody>
						   
	                 </table>
	              </div>
	               </div>
	           </div>
	           
	           <div class="row old_metal_details" style="display:none;">
	               <div class="col-md-12">
	               	<div class="table-responsive">
	                 <table id="old_metal_sale_list" class="table table-bordered table-striped text-center">
	                    <thead>
						     <tr> 
                            	<th width="10%"><label class="checkbox-inline"><input type="checkbox" id="select_all_old_metal" name="select_all" value="all"/>All</label></th>     
                            	<th>Branch</th>
                            	<th>Bill No</th>
                            	<th>Bill Date</th>
                            	<th>Category</th>						   
                            	<th>Gross Wt(g)</th>
                            	<th>Net Wt(g)</th>
                            	<th>Purity</th>
                            </tr>
	                    </thead> 
	                     <tbody> 
	                </tbody>
						   
	                 </table>
	              </div>
	               </div>
	           </div>
	           
	           	<div class="row">
				    <div class="col-sm-12" align="center">
						<button type="button" class="btn btn-default btn-cancel">Cancel</button>
				    </div>
				</div>
	     
	        </div><!-- /.box-body -->
	        <div class="overlay" style="display:none">
			  <i class="fa fa-refresh fa-spin"></i>
			</div>
	      </div>
	    </div><!-- /.col -->
	  </div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
      

