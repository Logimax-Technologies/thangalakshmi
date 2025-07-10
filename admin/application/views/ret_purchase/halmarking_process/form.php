      <!-- Content Wrapper. Contains page content -->
    <style>
    	.remove-btn{
			margin-top: -168px;
		    margin-left: -38px;
		    background-color: #e51712 !important;
		    border: none;
		    color: white !important;
		}
		
		
    </style>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       

        <!-- Main content -->
        <section class="content order">

          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Halmarking Issue</h3>
            </div>
            <div class="box-body">
             <!-- form container --> 
	             <!-- form -->
				<form id="qc_entry_form">
				<div class="row">
				    <div class="col-md-12">
				        <div class="col-md-2">
    	                     <div class="form-group">
    	                       <label>PO Ref No</label>
    							    <select class="form-control" id="select_po_ref_no"></select>
    	                     </div> 
				        </div>
				        <div class="col-md-2">
    	                     <div class="form-group">
    	                       <label>Select Karigar</label>
    							    <select class="form-control" id="select_karigar"></select>
    	                     </div> 
				        </div>
				         <div class="col-md-2">
				            <div class="form-group">
				                <br>
				                <button id="halmarking_issue" type="button" class="btn btn-primary" >UPDATE</button>
				            </div>
				        </div>
				    </div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
					    <div class="table-responsive">
                         <h4>Item Details</h4>
						 <table id="item_detail" class="table table-bordered table-striped">
							<thead style="text-transform:uppercase;">
							     
						          <tr>
						            <th width="5%;"><label class="checkbox-inline"><input type="checkbox" id="select_all" name="select_all" value="all"/>All</label></th> 
						            <th width="5%;">Karigar</th> 
						            <th width="5%;">Product</th> 
						            <th width="5%;">Design</th> 
						            <th width="5%;">Sub Design</th> 
						            <th width="5%;">Pcs</th> 
						            <th width="5%;">Gwt</th> 
						            <th width="5%;">Lwt</th> 
						            <th width="5%;">Nwt</th> 
						          </tr>
					         </thead>
					         <tbody></tbody>
					         <tfoot><tr style="font-weight:bold;"><td colspan="5" style="text-align: center;">TOTAL</td><td class="total_pcs"></td><td class="total_gwt"></td><td class="total_lwt"></td><td class="total_nwt"></td></tr></tfoot>
						</table>
					    </div>
					</div> 
				</div>	
				<p class="help-block"></p>
 
				  <?php echo form_close();?>
	           </div>  
	            
	           <div class="overlay" style="display:none">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>
	       </div>  
        </section>
</div>


<div class="modal fade" id="cus_stoneModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:72%;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Stone</h4>
			</div>
			<div class="modal-body">
    			<div class="row">
    			        <input type="hidden" id="activeRow">
    					<table id="estimation_stone_cus_item_details" class="table table-bordered table-striped text-center">
        					<thead>
            					<tr>
                					<th width="15%">#</th>
                					<th width="15%">Stone</th>
                					<th width="5%">Pcs</th>   
                					<th width="22%">Wt</th>
                					<th width="12%">Rate</th>
                					<th width="15%">Amount</th>
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
			<button type="button" id="remove_stone_details" class="btn btn-success">Save</button>
			<button type="button" id="close_stone_details" class="btn btn-warning" data-dismiss="modal">Close</button>
		  </div>
		</div>
	</div>
</div>
            
