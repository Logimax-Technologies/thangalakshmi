  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Scheme Details
            <small></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Masters</a></li>
            <li class="active">Scheme Account</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
           
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Scheme Account List</h3>      
                           
                </div><!-- /.box-header -->
                <div class="box-body">
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
                 <div class="responsive">
                  <table id="sch_acc_list" class="table table-bordered table-striped text-center grid">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Account.No</th>                        
                        <th>Customer</th> 
                         <th>Mobile</th>                       
                        <th>Scheme Code</th>
						<th>Type</th>
                        <th>Start Date</th>
                        <th>Total Installment</th> 
                        <th>Installment Payable</th>
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
                     	if(isset($accounts)) { 
                                		
                     	 foreach($accounts as $account)
						{
                      ?>
                       <tr>
                         <td><?php echo $account['id_scheme_account'];?></td>
                       	 <td><?php echo $account['scheme_acc_number'];?></td>
                       	 <td><?php echo $account['name'];?></td>
                       	 <td><?php echo $account['mobile'];?></td>
                       	 <td><?php echo $account['code'];?></td>                       	 
                         <td><?php echo $account['scheme_type'];?></td>
						 <td><?php echo date("d-m-Y",strtotime($account['start_date']));?></td>
						   <td><?php echo $account['total_installments'];?></td>
                       	 <td><?php echo ($account['scheme_type'] == 'Amount' ? "Rs. ".$account['amount']: "max ".$account['max_weight']." g/month");?></td>
                       
                       	 
                      
                       	
                       </tr>
                       <?php } } ?>
                    </tbody>
                 <!--   <tfoot>
                      <tr>
                        
                      </tr>
                    </tfoot> -->
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      

