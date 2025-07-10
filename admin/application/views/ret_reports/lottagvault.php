  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
               
               <div class="box box-primary">
                 <div class="box-body">  
                	   	<div class="box box-info stock_details">
						<div class="box-header with-border">
						 <div class="col-md-3">  <h3 class="box-title">Lot Vs Tagged Vault</h3> </div>
						    
						    <div class="col-md-2"> 
						        <input type="text" class="form-control" id="lotno" placeholder="Lot No" value="" >  
							</div>
							<div class="col-md-2"> 
								<select id="karigar" class="form-control" style="width:100%;"></select>
							</div>
							<div class="col-md-2"> 
								<div class="form-group">    
			
									<?php   
										$fromdt = date("d/m/Y");
										$todt = date("d/m/Y");
								    ?>
		                   		    <input type="text" class="form-control pull-right dateRangePicker" id="dt_range" placeholder="From Date -  To Date" value="<?php echo $fromdt.' - '.$todt?>" readonly="">  
								</div> 
							</div>
							 <div class="col-md-2"> 
                                 <div class="form-group">
                                     <button type="button" id="lotvstageed_issue" class="btn btn-info">Search</button>   
                                 </div>
                             </div>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						  </div>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="box-body">
								   <div class="table-responsive">
									  <table id="lotvstag_list" class="table table-bordered table-striped text-center">
										 <thead>
										 <!--<tr class="tablerow">
            							  	<th colspan="3"></th>
            							  	<th colspan="7">Lot Created</th>
            								<th colspan="7">Tagged</th>
            								<th colspan="7">Balance</th>
            		                      </tr>-->
                        				  <tr>
            							    <th>Lot No</th>
            							    <th>Karigar</th>
            							    <th>Item</th>
            							    <th>Lot Date</th>

            							    <th>Lot Pcs</th>
            							    <th>Lot Grs Wt</th>
            							    <th>Lot Net Wt</th>
            							    <th>Lot Dia Pcs</th>
            							    <th>Lot Dia Wt</th>
            							    <th>Lot Stone Pcs</th>
            							    <th>Lot Stone Wt</th>

											<th>Tag Pcs</th>
            							    <th>Tag Grs Wt</th>
            							    <th>Tag Net Wt</th>
            							    <th>Tag Dia Pcs</th>
            							    <th>Tag Dia Wt</th>
            							    <th>Tag Stone Pcs</th>
            							    <th>Tag Stone Wt</th>

            							    <th>Tag Pcs</th>
            							    <th>Tag Grs Wt</th>
            							    <th>Tag Net Wt</th>
            							    <th>Tag Dia Pcs</th>
            							    <th>Tag Dia Wt</th>
            							    <th>Tag Stone Pcs</th>
            							    <th>Tag Stone Wt</th>
            							    
            							  </tr>
		                            </thead> 
		                             <tbody></tbody>
		                             <tfoot></tfoot>
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

