  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Tagging
            <small>Manage your tag(s)</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tagging</a></li>
            <li class="active">Tag</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box box-primary">
			    <div class="box-header with-border">
                  <h3 class="box-title">Tagging List</h3>  <span id="total_tagging" class="badge bg-green"></span>  
                  <div class="pull-right">
                     <!--<a class="btn btn-warning" id="add_tagging" href="<?php echo base_url('index.php/admin_ret_tagging/tagging/bulk_edit');?>" ><i class="fa fa-edit"></i>Bulk Edit</a>-->
                  	 <a class="btn btn-success" id="add_tagging" href="<?php echo base_url('index.php/admin_ret_tagging/tagging/add');?>" ><i class="fa fa-plus-circle"></i> Add</a> 
				  </div>
                </div>
                 <div class="box-body">  
                   <div class="row">
					   <div class="form-group">
						  <div class="col-md-2">
							<div class="pull-left">
							    <div class="form-group"> 
								<button class="btn btn-default btn_date_range" id="tag-dt-btn">
								<span  style="display:none;" id="tag_date1"></span>
								<span  style="display:none;" id="tag_date2"></span>
								<i class="fa fa-calendar"></i> Date range picker
								<i class="fa fa-caret-down"></i>
								</button>
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
                  <div class="table-responsive">
	                 <table id="tag_list" class="table table-bordered table-striped text-center">
	                    <thead>
	                      <tr>
	                        <th width="5%">Lot ID</th>
	                        <th width="10%">Date</th>
							<th width="10%">Gross Wgt</th>
	                        <th width="10%">Net Wgt</th>
	                        <th width="10%">Less Wgt</th>
	                        <th width="5%">Pieces</th>
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