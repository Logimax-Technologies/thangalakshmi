<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
	        Add New Item
		</h1>
		<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
		<li class="active">Add New Item</li>
		</ol>
	</section>
<!-- Default box -->
<section class="content">
        
<?php echo form_open_multipart(( $other['id_other_item'] != NULL && $other['id_other_item'] > 0 ? 'admin_ret_other_inventory/other_inventory/update/'.$other['id_other_item']:'admin_ret_other_inventory/other_inventory/save')); ?>
		
		
		 <div class="box">
			<div class="box-header with-border">
              <h3 class="box-title">Add New Item</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div> 
            <div class="box-body">

			     <!-- form -->

				    <div class='row'>
				        <div class="col-md-12">
				            <div align="left"  style="background: #f5f5f5">
                        		<ul class="nav nav-tabs" id="billing-tab">
                        	      	<li class="active"><a id="tab_items" href="#item_details" data-toggle="tab">ITEM DETAILS</a></li>
                        		  	<li id="tab_tot_summary"><a href="#reorder_details" data-toggle="tab">REORDER DETAILS</a></li>
                        	    </ul>
                        	</div>
                        	
                        	<div class="tab-content">
                        		<div class="tab-pane active" id="item_details">
                		                <div class="box-body" align="center">
                		                    <div class="col-md-8">
                		                        <div class="row">
                		                            <div class="col-md-12">
                		                                <div class='col-md-6'>
                            					            <div class='form-group'>
                            					                <label>Item For<span class="error"> *</span></label>
                            									<select  class="form-control" name="other[item_for]" id="itemfor"  style="width:100%;"></select>
                            						            <input id="item_for"  type="hidden"  value="<?php echo set_value('other[item_for]',isset($other['item_for'])?$other['item_for']:NULL); ?>" required/>	            
                            								</div>
                            					        </div>
                            					        <div class="col-md-6">
                            						    	<div class='form-group'>
                            						           <label>Name<span class="error"> *</span></label>
                            								   <input id="name"  class="form-control" name="other[name]" type="text" required="true" placeholder="Enter The Name" value="<?php echo set_value('other[name]',isset($other['name'])?$other['name']:NULL); ?>" autocomplete="off"/>							                
                            						       </div> 
                            						    </div>
                		                            </div>
                		                        </div>
                		                        
                		                        <div class="row">
                		                            <div class="col-md-12">
                		                                <div class='col-md-6'>
                            					            <div class='form-group'>
                            					                <label>Select Size<span class="error">*</span></label>
                            									<select  class="form-control" id="select_size"  name="other[id_size]"  style="width:100%;" required></select>
                            						            <input id="id_inv_size" type="hidden"  value="<?php echo set_value('other[id_inv_size]',isset($other['id_inv_size'])?$other['id_inv_size']:NULL); ?>" />						            
                            								</div>
                            					        </div>
                            					        <div class='col-md-2' style="display:none;">
                            					            <div class='form-group'>
                            					                <label>Select Uom<span class="error">*</span></label>
                            									<select  class="form-control" id="select_uom"  name="other[id_uom]"  style="width:100%;"></select>
                            						            <input id="id_uom" type="hidden"  value="<?php echo set_value('other[purchase_id_uom]',isset($other['purchase_id_uom'])?$other['purchase_id_uom']:NULL); ?>" autocomplete="off"/>						            
                            								</div>
                            					        </div>
                            					        <div class='col-md-6'>
                            					            <div class='form-group'>
                            					                <label>Issue Preference<span class="error">*</span></label>
                            									<select  class="form-control"  name="other[issue_preference]"  style="width:100%;">
                            									    <option value="1" <?php echo ($other['issue_preference']==1 ? 'selected' :'')?>>FIFO</option>
                            									    <option value="2" <?php echo ($other['issue_preference']==2 ? 'selected' :'')?>>FILO</option>
                            									</select>
                            								</div>
                            					        </div>
                		                            </div>
                		                        </div>
                		                    </div>
                    					   <div class="col-md-2">
                                                    <p class="help-block"></p>
                                                    <input id="other_item_img" name="other[other_item_img]" accept="image/*" type="file" >
                                                    <img src="<?php echo(isset($other['item_image'])? base_url().'assets/img/other_inventory/'.$other['sku_id'].'/'.$other['item_image']: base_url().('assets/img/no_image.png')); ?>" class="img-thumbnail" id="other_item_img_preview" style="width:304px;height:100%;" alt="other inventory image">                      
                                                </div>
                                            </div>
                        		</div>
                        		<div class="tab-pane" id="reorder_details">
                		                <div class="box-body" align="center">
                		                    <div class="row">
                                                <div class="col-md-6">
                                                    <table id="total_items" class="table table-bordered table-striped text-center" >
                                                        <thead>
                                                            <tr>
                                                            <th>Branch</th>
                                                            <th>Min Pcs</th>
                                                            <th>Max Pcs</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            if(sizeof($reorder_details)>0)
                                                            {
                                                               foreach($reorder_details as $key => $val)
                                                               {?>
                                                                <tr>
                                                                    <td><?php echo $val['branch_name'];?><input type="hidden" class="form-control id_branch"  name="pieces[<?php echo $key;?>][id_branch]" value=<?php echo $val['id_branch']?> ></td>
                                                                    <td><input type="number" class="form-control min_pcs" name="pieces[<?php echo $key;?>][min_pcs]" value=<?php echo $val['min_pcs']?> placeholder="Enter Min Pcs"></td>
                                                                    <td><input type="number" class="form-control max_pcs" name="pieces[<?php echo $key;?>][max_pcs]" value=<?php echo $val['max_pcs']?> placeholder="Enter Max Pcs"></td>
                                                                </tr>      
                                                               <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                		                </div>
                        		 </div>
                    		</div>
				            
				        </div>	
                    </div>
		<div class="row">
		   <div class="box box-default"><br/>
			  <div class="col-xs-offset-5">
				<button type="submit"  class="btn btn-primary">save</button> 
				<button type="button" class="btn btn-default btn-cancel">Cancel</button>
				</div> <br/>
			</div>
		  </div> 			
        </div>
</section>
</div>


<script type="text/javascript">

var other_id ="<?php echo $other['id_other_item']; ?>";

</script> 


     