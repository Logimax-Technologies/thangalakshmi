  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reports
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Customer</a></li>
            <li class="active">Customer List</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
           
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Customer List</h3>     
                  <!-- altered by RK - 16/12/2022-->
                <br>
                <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <button class="btn btn-default btn_date_range" id="gift-dt-btn"> 
                      <span  style="display:none;" id="gift_list1"></span>
                      <span  style="display:none;" id="gift_list2"></span>
                      <i class="fa fa-calendar"></i> Date range picker
                      <i class="fa fa-caret-down"></i>
                    </button>
                  </div>  
                </div>        
              </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    
             <!--<div class="row">
			  	<div class="col-md-offset-2 col-md-8">  
	              <div class="box box-default">  
	               <div class="box-body">  
					   <div class="row">
							<div class="col-md-offset-2 col-md-2"> 
								<label></label>
								<div class="form-group">
									<button type="button" id="send_cus_wish" class="btn btn-info">Send Wish</button>   
								</div>
							</div>
						</div>
					 </div>
	               </div> 
	              </div> 
	           </div> -->
              
				<div class="table-responsive">
                  <table class="table table-bordered table-striped text-center grid" id="customer_list">
                    <thead>
                      <tr>
                        <!--<th><label class="checkbox-inline"><input type="checkbox" id="select_all_cus" name="select_all" value="all"/>All</label></th>-->
                        <th>Customer ID</th>
						<th>Customer</th> 
                        <th>Mobile</th>
                        <th>Area</th>
                        <th>D.O.B</th>
                        <th>D.O.W</th>
                        <th>Gold(Gm)</th>
                        <th>Silver(Gm)</th>
                        <th>Active Acc</th>
                        <th>Closed Acc</th>
                      </tr>
                    </thead>
                    <!--<tbody>
                     <?php 
                     	if(isset($accounts)) {                     		
                     	 foreach($accounts as $account)
						{
                      ?>
                       <tr>
                         <td><input type="checkbox" name="id_customer[]" class="id_customer" value="<?php echo $account['id_customer'];?>"><?php echo $account['id_customer'];?></td>
                       	 <td><?php echo $account['id_customer'];?></td>
                       	 <td><?php echo $account['cus_name'];?></td>
                       	 <td><?php echo $account['cus_mobile'];?><input type="hidden" class="cus_mobile" value="<?php echo $account['cus_mobile'];?>"</td>
                       	 <td><?php echo $account['village_name'];?></td>
                       	 <td><?php echo $account['date_of_birth'];?></td>
                       	 <td><?php echo $account['date_of_wed'];?></td>
                       	 <td><?php echo $account['total_gold_wt'];?></td>                       	
                  		 <td><?php echo $account['total_silver_wt']; ?></td>
                  		 <td><?php echo $account['active_acc']; ?></td>
                  		 <td><?php echo $account['closed_count']; ?></td>
                  		
                       </tr>
                       <?php } } 
                       ?>
                    </tbody>-->
                  </table>
				  </div>
                  
                </div><!-- /.box-body -->
                <div class="overlay" style="display:none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      