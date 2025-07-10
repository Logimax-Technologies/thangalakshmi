<style>
  	/* CSS for Drill-down */
  	.drill-collapsed {
	    display: none;
	}
	.drill-close {
	    display: none;
	}
	.drill-open {
	    display: block;
	}
	.drill-detail {
	    background:#fdfdfd
	}
	/* .CSS for Drill-down */
  </style>
     <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Purchase Return
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box box-primary">
                 <div class="box-body">  
                  <div class="row">
				  	<div class="col-md-12">  
	                  <div class="box box-default">  
	                   <div class="box-body">  
						   <div class="row">
								
								<div class="col-md-2"> 
								     <label></label>
    								 <div class="form-group">
                                          <button class="btn btn-default btn_date_range"  id="rpt_date_picker">
                                                    <i class="fa fa-calendar"></i> Date range picker
                                                    <i class="fa fa-caret-down"></i>
                                            </button>
                                                <span style="display:none;" id="rpt_from_date"></span>
                                                <span style="display:none;" id="rpt_to_date"></span>
                                         </div><!-- /.form group -->
                                </div>
                                
                                <div class="col-md-2"> 
									<label>Report Type</label>
									<select id="grn_report_type" class="form-control" style="width:100%;">
									     <option value="1">Summary</option>
									     <option value="2" selected>Detailed</option>
									</select>
								</div>
								
								<div class="col-md-2"> 
                                	<label>Select category</label>
                                	<select id="category" style="width: 100%;"></select>
                                </div>

								<div class="col-md-2"> 
									<label>Select Karigar</label>
									<select id="karigar" class="form-control" style="width:100%;"></select>
								</div>
								<div class="col-md-2"> 
									<label>Type</label>
									<select id="bill_type" class="form-control" style="width:100%;">
									    <option value="0">All</option>
									     <option value="1">Inter State</option>
									     <option value="2">Intra State</option>
									</select>
								</div>
								<div class="col-md-2"> 
									<label></label>
									<div class="form-group">
										<button type="button" id="purchase_return_search" class="btn btn-info">Search</button>   
									</div>
								</div>
							</div>
						 </div>
	                   </div> 
	                  </div> 
                   </div> 
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
				   </div>
				   	<div class="box box-info stock_details">
						<div class="box-body">
							<div class="row">
								<div class="box-body">
								   <div class="table-responsive">
                                    <table id="purchase_return" class="table table-bordered table-striped text-center" style="text-transform:uppercase;">
										 <thead>
                                         <tr>
										     <th>Ref No</th>
                                            <th>Invoice Date</th>
                                            <th>Karigar</th>
                                            <th >Address</th>
                                            <th >State</th>
                                            <th >GST NO</th>
                                            <th >PAN NO</th>
                                            <th >Category</th>
                                            <th >Gwt</th>
                                            <th >Nwt</th>
                                            <th >DIAWT</th>
                                            <th >DIA Amount</th>
                                            <th >taxable amt</th>
                                            <th >Tax (%)</th>
                                            <th >cgst</th>
                                            <th >sgst</th>
                                            <th >igst</th>
                                            <th >Tax</th>
                                            <th >TDS %</th>
                                            <th >TDS</th>
                                            <th >TCS %</th>
                                            <th >TCS</th>
                                            <?php foreach($charges as $val)
                                            {?>
                                                 <th><?php echo $val['name_charge'];?></th>
                                            <?}
                                            ?>
                                           
                                            <th>charges cgst</th>
                                            <th>charges sgst</th>
                                            <th>charges igst</th>
                                            <th>charges tds %</th>
                                            <th>charges tds</th>
                                            <th>discount</th>
                                            <th>round off</th>
                                            <th>total</th>
										 </tr>
					                    </thead><tbody></tbody>
					                    
									 </table>
								  </div>
								</div> 
							</div> 
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

<div class="modal fade" id="stone_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	    <div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Stone Details</h4>
		</div>
		<div class="modal-body">
			<div>
			<table id="stone_details" class="table table-bordered table-striped text-center">
				<thead>
				<tr>
				<th>Stone Name</th>
				<th>Stone Pcs</th>
				<th>Weight</th>
				<th>Rate</th>
				<th>Amount</th>
				</tr>
				</thead> 
				<tbody>
				</tbody>										
			</table>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
