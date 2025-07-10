<!-- Content Wrapper. Contains page content -->
  <style>
  	.custom-label{
		font-weight: 400;
	}
  </style>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Stock Process
          </h1>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               <div class="box box-primary">
                   
                   <div class="box-header with-border">
                      <div class="pull-right">
                      	<a class="btn btn-success" id="add_tagging" href="<?php echo base_url('index.php/admin_ret_tagging/retagging/add');?>" ><i class="fa fa-plus-circle"></i> Add</a> 
    				  </div>
                   </div>
                
                   
                 <div class="box-body">  
                  <div class="table-responsive">
	                 <table id="process_list" class="table table-bordered table-striped text-center">
	                    <thead>
	                      <tr>
	                        <th width="5%">#</th>
	                        <th width="10%">Date</th>
							<th width="10%">Branch</th>
							<th width="5%">Type</th>
	                        <th width="5%">Process</th>
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
