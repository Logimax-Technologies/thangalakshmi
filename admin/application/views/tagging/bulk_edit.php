<!-- Content Wrapper. Contains page content -->
<style>
    .remove-btn{
    margin-top: -168px;
    margin-left: -38px;
    background-color: #e51712 !important;
    border: none;
    color: white !important;
    }
    #attribute_block {
    display: none;
    }
    #mc_va_block {
    padding-bottom: 20px;
    }
    .apply_filter_row {
    padding: 0px;
    }
    .submit_button {
    text-align: center;
    }
	.bulk_tag_upd_remove_attribute {
	margin-left: 5px;
	}
    small.alert {
        font-size: 0.8em;
        padding: 0.5em;
        color: #a94442;
        font-weight: bold;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Tagging
            <small>Tag</small>
        </h1>
        
    </section>
    <!-- Main content -->
    <section class="content product">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h4>Filter Details</h4>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <!-- form container -->
                <div class="row">
                    
                    <div class="col-sm-12">
                        
                        <!-- Lot Details Start Here -->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Choose field to update <span class="error">*</span></label>
                                    <select id="bulk_edit_options" name="bulk_edit_options" class="form-control" required>
                                        <option>--Select--</option>
                                        <option value="1">MC</option>
                                        <option value="2">VA</option>
                                        <option value="3">Gross Weight</option>
                                        <option value="4">Pcs</option>
                                        <option value="5">Purity</option>
                                        <option value="6">MRP Price</option>
                                        <option value="7">Attributes</option>
                                        <option value="8">Size</option>
                                        <option value="9">Image</option>
                                        <option value="10">Charges</option>
                                        <option value="11">HUID</option>
                                        <option value="12">Old Tag Id</option>
                                    </select>
                                    <p class="tag_update_text text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><a data-toggle="tooltip" title="Branch">Select Branch</a><span class="error">*</span></label>
                                    <select id="branch_select" class="form-control" required></select>
                                    <input id="id_branch" name="id_branch" type="hidden" />
                                </div>
                            </div>
                            <div class="col-md-2 filter_block bulk_edit_tag_code">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="Enter Design">Tag Code</a>  </label>
                                    <input class="form-control" type="text" name="be_tag_code" id="be_tag_code" placeholder="Enter Tag Code">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="Enter Product">Select Product</a>  </label>
                                    <select id="prod_select" class="form-control" style="width:100%;"></select>
                                    <input type="hidden" id="id_product" name="">
                                </div>
                            </div>
                            <div class="col-md-2 bulk_edit_product">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="Enter Design">Select Design</a>  </label>
                                    <select class="form-control" id="des_select" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="col-md-2 bulk_edit_design">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="Enter Design">Select Sub Design</a>  </label>
                                    <select class="form-control" id="sub_des_select" style="width:100%;"></select>
                                </div>
                            </div>
                         </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">  
                             <div class="col-md-2 bulk_edit_sub_design">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="Enter Design">From Days</a>  </label>
                                    <input type="number" class="form-control" id="form_days" placeholder="Enter The Form Days.">
                                </div>
                            </div>
                            
                            <div class="col-md-2 bulk_edit_mc_type">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="Enter Design">To Days</a>  </label>
                                    <input type="number" class="form-control" id="to_days" placeholder="Enter The To Days.">
                                </div>
                            </div>
                            
                            <div class="col-md-2 mcva_filters">
                                <label><a data-toggle="tooltip" title="MC Type">MC TYpe</a></label>
                                <div class="form-group">
                                    <select id="mc_type" class="form-control">
                                        <option value="">-Select MC Type-</option>
                                        <option value="2">Per Gram</option>
                                        <option value="1">Per Piece</option>
                                    </select>
                                    <input type="hidden" id="id_mc_type" name="">
                                </div>
                            </div>
                            <div class="col-md-2" id="edit_was_per" >
                                <label><a data-toggle="tooltip" title="Wastage Percentage">Wastage Percentage</a></label>
                                <input type="number" class="form-control" id="old_mc_per" placeholder="Wastage Percentage" >
                            </div>
                            
                            <div class="col-md-2 mcva_filters bulk_edit_from_weight">
                                <div class="form-group">
                                    <label><a  data-toggle="tooltip" title="From Weight">From weight</a>  </label>
                                    <input class="form-control" type="number" name="from_weight" id="from_weight" placeholder="Enter From Weight">
                                </div>
                            </div>
                            <div class="col-md-2 mcva_filters bulk_edit_to_weight">
                                <label><a  data-toggle="tooltip" title="From Weight">To weight</a>  </label>
                                <div class="form-group">
                                    <input class="form-control" type="number" name="to_weight" id="to_weight" placeholder="Enter To Weight">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2 mcva_filters bulk_edit_mc" id="edit_mc_value" >
                                <label><a data-toggle="tooltip" title="Making Charge">Making Charge</a></label>
                                <input type="number" class="form-control" id="old_mc_value" placeholder="Making Charge Value" >
                            </div>
                            <div class="col-md-2">
                                <label></label>
                                <div class="form-group">
                                    <button class="btn btn-primary" id="get_tag_details" >Apply Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        <p class="help-block"></p>
                  
                    <!--/ Col --> 
                </div>
                <!--/ row -->
                <h4>Edit Details</h4>
                <div class="row editable_block" id="editable_block" style="display: none;">
                    <div class="col-sm-12">
                        <div class="row" id="mc_va_block">
                            <div class="col-md-2 mc_type_block">
                                <div class="form-group">
                                    <label>Update MC Type</label>
                                    <select class="form-control" id="update_mc_type">
                                        <option value="">Change MC Type</option>
                                        <option value="2">Mc Per Gram</option>
                                        <option value="1">Mc Per Piece</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 va_block bulk_edit_wastage">
                                <div class="form-group">
                                    <label>Update Wastage(%)</label>
                                    <input type="hidden" id="metal_rate" name="">
                                    <input class="form-control" id="wastage_percent" name="tagging[retail_max_wastage_percent]" type="number"  step=any  placeholder="Enter wastage percentage." />
                                </div>
                            </div>
                            <div class="col-md-2 mc_value_block">
                                <div class="form-group">
                                    <label>Update MC Value</label>
                                    <input class="form-control" id="mc_value" name="tagging[tag_mc_value]" type="number"  step=any  placeholder="Making Charge"/>
                                </div>
                            </div>
                            
                            <div class="col-md-2 mrp_value_block">
                                    <div class="form-group">
                                        <label>Enter MRP Rate</label>
                                        <input class="form-control" id="be_mrp_value" name="tagging[mrp_value]" type="number"  step=any  placeholder="Enter MRP" />
                                    </div>
                                </div>
                                <div class="col-md-2 gross_wt_block">
                                    <div class="form-group">
                                        <label>Gross Wt</label>
                                        <input class="form-control" id="be_gross_wt" name="tagging[gross_wt]" type="number"  step=any  placeholder="Enter Gross Wt" />
                                    </div>
                                </div>
                                <div class="col-md-2 less_wt_block">
                                    <div class="form-group">
                                        <label>Less Wt</label>
                                        <div class="input-group ">
                                            <input class="form-control" id="be_less_wt" name="tagging[less_wt]" type="number"  step=any readonly />
                                            <span class="input-group-addon input-sm add_tag_edit_lwt" >+</span>
                                            <input type="hidden" id="tag_edit_stone_details"> 
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 net_wt_block">
                                    <div class="form-group">
                                        <label>Net Wt</label>
                                        <input class="form-control" id="be_net_wt" name="tagging[net_wt]" type="number"  step=any  readonly />
                                    </div>
                                </div>
                                <div class="col-md-2 pcs_block">
                                    <div class="form-group">
                                        <label>PCS</label>
                                        <input class="form-control" id="be_pcs" name="tagging[pcs]" type="number"  step=any  placeholder="Enter Pcs" />
                                    </div>
                                </div>
                               
                                <div class="col-md-2 purity_block">
                                    <div class="form-group">
                                        <label>Purity</label>
                                        <select class="form-control" id="be_purity" name="tagging[purity]" ></select>
                                    </div>
                                </div>
                                <div class="col-md-2 size_block">
                                    <div class="form-group">
                                        <label>Size</label>
                                        <select class="form-control" id="be_size" name="tagging[size]" ></select>
                                    </div>
                                </div>
                            
                            <div class="col-sm-2 image_block">
                                <label>Image</label>
                                <div>
                                    <input type="hidden" id="custom_active_id">
                                    <div id="tag_img" data-img='[]'></div>
                                        <input type="hidden" class="form-control" id="tag_img_copy"/>
                                        <input type="hidden" class="form-control" id="tag_img_default"/>
                                        <input type="hidden" class="form-control" id="tag_images"/>
                                        <a href="#" onclick="update_image_upload();" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
   
                            <div class="col-md-2" style="display: none;">
                                <div class="form-group">
                                    <label>Update Design</label>
                                    <input class="form-control" id="tag_design_no" name="tagging[designno]" type="text"  placeholder="Enter Design Code" autocomplete="off"/>
                                    <input class="form-control" id="design_id" name="tagging[design_id]" type="hidden"/>
                                </div>
                            </div>
                        </div>
                        <p class="help-block"></p>
                        <div class="row attribute_block" id="attribute_block">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Choose</label>
                                    <select class="form-control" id="attribute_type">
                                        <option value="1">Add Attribute</option>
                                        <option value="2">Delete Attribute</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="update_attribute_block">
                                <legend>
                                    <i>Add Attributes</i><button id="update_tag_add_attribute" type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add attribute</button>
                                    <p class="help-block"></p>
                                </legend>
                                <table id="bulk_edit_attribute_detail" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Attributes</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <p class="help-block"></p>
                        <div class="row charges_block" id="charges_block">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Choose</label>
                                    <select class="form-control" id="charge_type">
                                        <option value="1">Add Charges</option>
                                        <option value="2">Delete Charges</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="update_charges_block">
                                <legend>
                                    <i>Add Charges</i><button id="update_update_add_charges" type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add Charges</button>
                                    <p class="help-block"></p>
                                </legend>
                                <table id="bulk_edit_charge_detail" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Charges</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <p class="help-block"></p>
                        <div class="col-md-2 huid_block">
                            <div class="form-group">
                                <label>HUID 1</label>
                                <input class="form-control" id="blk_huid" name="tagging[blk_huid]" type="text"  placeholder="Enter HUID 1" />
                                <small class="alert">Update with no value will clear HUID 1</small>
                            </div>
                        </div>
                        <div class="col-md-2 huid_block">
                            <div class="form-group">
                            <label>HUID 2</label>
                                <input class="form-control" id="blk_huid2" name="tagging[blk_huid2]" type="text"  placeholder="Enter HUID 2" />
                                <small class="alert">Update with no value will clear HUID 2</small>
                            </div>
                        </div>
                        <p class="help-block"></p>
                        <div class="col-md-2 old_tag_id_block">
                            <div class="form-group">
                                <label>Old Tag Id</label>
                                <input class="form-control" id="blk_old_tag" name="tagging[blk_old_tag]" type="text"  placeholder="Enter Old Tag Id" />
                                <small class="alert">Update with no value will clear old tag</small>
                            </div>
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <!--/ Col --> 
                </div>
                <!--/ row -->
                <p class="help-block"> </p>
                <div class="table-responsive">
                    <table id="tagging_list" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th><label class="checkbox-inline"><input type="checkbox" id="select_all" name="select_all" value="all"/>All</label></th>
                                <th>Tag Code</th>
                                <th>Old Tag Code</th>
                                <th>Tag Image</th>
                                <th>Product</th>
                                <th>Design</th>
                                <th>Sub Design</th>
                                <th>Tag Date</th>
                                <th>Pcs</th>
                                <th>GWT(g)</th>
                                <th>LWT(g)</th>
                                <th>NWT(g)</th>
                                <th>Wastage(%)</th>
                                <th>MC Type</th>
                                <th>MC value</th>
                                <th>Amount</th>
                                <th>Charges</th>
                                <th>Attributes</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <p class="help-block"> </p>
                <div class="col-md-12 submit_button">
                    <div class="form-group">
                        <button class="btn btn-info" id="otp_submit">Submit</button>
                    </div>
                </div>
            </div>
            <div class="overlay" style="display:none">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </section>
</div>
<div id="otp_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" id="close_modal" class="close" >&times;</button>
                <h3 id="myModalLabel">Mobile Number Verification</h3>
            </div>
            <div class="modal-body">
                <p>Please enter the code sent to your mobile number</p>
                <div>
                    <label style="display:inline; margin:5px" for="otp">Enter Code:</label>
                    <input  style="display:inline; width:30%; margin:5px" type="number" id="tag_otp" name="tag_otp" value="" class="form-control" required/>
                    <input style="margin-left:1%" type="submit" value="Verify" id="bulk_edit" style="background-color:#0079C0"  class="button btn btn-primary btn-large" />
                    <span id="OTPloader"><img src="<?php echo base_url()?>assets/img/loader.gif" ></span>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="resendotp" value="Resend OTP" class="resendotp">  </input>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bulk_edit_charges_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Weight Range</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p class="help-block"></p>
                    </legend>
                    <table id="bulk_edit_charges_detail" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Charges Name</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bulk_edit_attributes_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Attributes</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p class="help-block"></p>
                    </legend>
                    <table id="bulk_edit_table_attr_detail" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Attribute Name</th>
                                <th>Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" style="width:60%;">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Add Image</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-8">
                          <label>Note - Click Snapshot Button To Take Your Images Screen Shot</label>
                      </div>
                      <div class="col-md-4">
                          <input type="button" value="Take Snapshot" onClick="take_snapshot('pre_images')"
                              class="btn btn-warning" id="snap_shots"><br>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-3"></div>
                      <div class="col-md-6" id="my_camera"></div>
                      <input type="hidden" name="image" class="image-tag">
                      <div class="col-md-3"></div>
                  </div>
              </div>
              <div class="row" id="image_lot_list" style="display:none;">
                  <div class="col-md-12" style="font-weight:bold;">Lot Images List</div>
              </div><br>
              <div class="row">
                  <div class="col-md-12" id="uploadArea_p_stn"></div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" id="update_img" class="btn btn-success">Save</button>
              <button type="button" id="close_stone_details" class="btn btn-warning"
                  data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
      
<div class="modal fade" id="imageModal_bulk_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" style="width:60%;">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Image Preview</h4>
          </div>
          <div class="modal-body">
			  <div class="row">
              	<div id="order_images" style="margin-top: 2%;"></div>
			  </div>
          </div>
          <div class="modal-footer">
              </br>
              <button type="button" id="update_img_bulk" class="btn btn-success">Save</button>
              <button type="button" id="close_stone_details" class="btn btn-warning"
                  data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<!--  custom items-->
<div class="modal fade" id="cus_stoneModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:80%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Stone</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="stone_active_row" value="0">
					<table id="estimation_stone_cus_item_details" class="table table-bordered table-striped text-center">
    					<thead>
        					<tr>
            					<th>LWT</th>
            					<th>Type</th>
            					<th>Name</th>
            					<th>Pcs</th>   
            					<th>Wt</th>
            					<th>Cal.Type</th>
            					<th>Rate</th>
            					<th>Amount</th>
            					<th>Action</th>
        					</tr>
    					</thead> 
    					<tbody></tbody>										
    					<tfoot>
    					<tr></tr>
    					</tfoot>
					</table>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" id="update_tag_edit_stone_details" class="btn btn-success">Save</button>
			<button type="button" id="close_stone_details" class="btn btn-warning" data-dismiss="modal">Close</button>
		  </div>
		</div>
	</div>
</div>
