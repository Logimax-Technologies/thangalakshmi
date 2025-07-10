<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		Purchase Details
		</h1>
		<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
		<li class="active">Purchase details</li>
		</ol>
	</section>
     <!-- Default box -->
    <section class="content">
      <form id="inventory_entry">  
		<div class="box">
			<div class="box-header with-border">
              <h3 class="box-title">Supplier Details</h3>
                <div class="box-tools pull-right">
                 <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                 <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

                </div>
            </div> 
            <div class="box-body">
				    <div class='row'>	
                        <div class="col-md-2">
				            <div class='form-group'>
				                <label>Supplier Name<span class="error"> *</span></label>
								<select  class="form-control" name="purchase[id_karigar]" id="select_karigar" required="true" style="width:100%;"></select>
							</div>
				        </div>		
			
                        <div class="col-md-2">
					    	<div class='form-group'>
					           <label>Supplier Bill No<span class="error"></span></label>
							   <input id="sup_refno"  class="form-control" name="purchase[sup_refno]" type="text"  placeholder="Enter Ref No" value="" autocomplete="off"/>							      
							</div>
						</div>
						<div class="col-md-2">
					    	<div class='form-group'>
					           <label>Supplier Bill Date<span class="error"></span></label>
							   <input id="sup_billdate"  class="form-control" name="purchase[sup_billdate]" type="Date"  placeholder="" value="" autocomplete="off"/>							      
							</div>
					    </div>
					    <div class="col-md-2">
					    	<div class='form-group'>
					           <label>Bill Copy<span class="error"></span></label>
							   <input id="pur_bill_img" name="purchase[pur_bill_img]" accept="image/*" type="file" >
							</div>
					    </div>
					</div>
                </div>
                
            <div class="box-header with-border">
                    <h3 class="box-title">Item Details</h3>
            </div> 
            <div class="box-body">
				    <div class='row'>	
                        <div class="col-md-2">
				            <div class='form-group'>
				                <label>Select Item<span class="error"> *</span></label>
								<select  class="form-control" id="select_item"  style="width:100%;"></select>
							</div>
				        </div>		
			
                        <div class="col-md-2">
					    	<div class='form-group'>
					           <label>Quantity<span class="error">*</span></label>
							   <input id="buy_quantity"  class="form-control"  type="text"  placeholder="Quantity" value="" autocomplete="off"/>							      
							</div>
						</div>
						
						<div class="col-md-2">
					    	<div class='form-group'>
					           <label>Rate/Pcs<span class="error">*</span></label>
							   <input id="buy_rate"  class="form-control"  type="text"  placeholder="Rate" value="" autocomplete="off"/>							      
							</div>
						</div>
						
						<div class="col-md-2">
					    	<div class='form-group'>
					           <label>Amount<span class="error">*</span></label>
							   <input id="buy_amount"  class="form-control"  type="text"  placeholder="Amount" readonly value="" autocomplete="off"/>							      
							</div>
						</div>
						
						<div class="col-md-2">
					    	<div class='form-group'>
					           </br>
							   <button id="add_item_info" type="button" class="btn btn-success pull-left"><i class="fa fa-plus"></i> Add item</button>
							</div>
						</div>
						
						
						
					</div>
                </div>   
            
                    <div class="box-body">
                        <div class="row">
                    <table id="pur_details" class="table table-bordered table-striped text-center">
                    <thead>
                      <tr>
					    <th>Item name</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                 	</thead>
                     <tbody>
                     
                     </tbody>
                  </table>
                   </div>

		            <div class="row">
		                <div class="box box-default"><br/>
			                <div class="col-xs-offset-5">
				               <button type="button" id="inventory_submit"  class="btn btn-primary">save</button> 
				               <button type="button" class="btn btn-default btn-cancel">Cancel</button>
				            </div> <br/>
			            </div>
		            </div> 
                    			
            </div>
        </form>
    </section>
</div>





     