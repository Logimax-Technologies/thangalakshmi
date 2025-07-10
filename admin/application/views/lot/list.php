  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Lot
            <small>Manage your Lot(s)</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Lot</a></li>
            <li class="active">Lot Inward</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box box-primary">
			    <div class="box-header with-border">
                  <h3 class="box-title">Lot List</h3>  <span id="total_product" class="badge bg-green"></span>  
                  <div class="pull-right">
                  	 <a class="btn btn-success pull-right" id="add_lot" href="<?php echo base_url('index.php/admin_ret_lot/lot_inward/add');?>" ><i class="fa fa-plus-circle"></i> Add</a> 
				  </div>
                </div>
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
				   </div>
				   <div class="row">
					   <div class="form-group">
						  <div class="col-md-2">
							<div class="pull-left">
							    <div class="form-group"> 
								<button class="btn btn-default btn_date_range" id="ltInward-dt-btn">
								<span  style="display:none;" id="lt_date1"></span>
								<span  style="display:none;" id="lt_date2"></span>
								<i class="fa fa-calendar"></i> Date range picker
								<i class="fa fa-caret-down"></i>
								</button>
								</div>
							</div>						
						  </div>	
						 <!--<?php if($this->session->userdata('branch_settings')==1){?>
							<div class="col-md-2">
								<div class="form-group" >
									<label>Received Branch </label>
									<select id="rcvd_branch" class="form-control branch_filter"></select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group" >
									<label>Filter Branch </label>
									<select id="filter_branch" class="form-control branch_filter"></select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group" >
									<button type="button" id="br_copy" class="btn btn-info">Branch Copy</button>   
								</div>
							</div>
						 <?php }?>-->
						</div>
					</div>
                  <div class="table-responsive">
	                 <table id="lot_inward_list" class="table table-bordered table-striped text-center">
	                    <thead>
	                     <tr>
	                        <th width="5%">Lot No</th>                                        
	                        <th width="5%">Lot Date</th>
	                        <th width="5%">Lot From</th>
	                        <th width="5%">REF NO</th>
	                        <th width="3%">karigar</th>
	                        <th width="5%">Recd Pcs</th>
	                        <th width="5%">Recd Wt</th>
	                        <th width="5%">Tagged Pcs</th>                
	                        <th width="5%">Tagged Wt</th>
	                        <th width="1%"></th>  
	                        <th width="5%">Blc Pcs</th>
	                        <th width="5%">Blc Wt</th>
	                        <th width="15%">Action</th>
	                      </tr>
	                    </thead> 
	                 </table>
                  </div>
                </div><!-- /.box-body -->
                <div class="overlay" style="display:none">
				  <i class="fa fa-refresh fa-spin"></i>
				</div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<!-- modal -->      
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Product</h4>
      </div>
      <div class="modal-body">
               <strong>Are you sure! You want to delete this Product?</strong>
      </div>
      <div class="modal-footer">
      	<a href="#" class="btn btn-danger btn-confirm" >Delete</a>
        <button type="button" class="btn btn-warning btn-cancel" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- / modal -->    