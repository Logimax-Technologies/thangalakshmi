<link rel="stylesheet" href="<?php echo base_url();?>assets/css/cockpit.css">
<!-- Content Wrapper. Contains page content -->
<div class="row order_details">
	<div class="col-md-12 col-xs-12 container-row">
		<div class="col-md-12 col-xs-12 box-items no-paddingwidth">
			<div class="col-md-12 col-xs-12 new_customer no-paddingwidth">
				<div class="col-md-12 col-xs-12 item-heading">
				    CUSTOMER ORDER
				</div>
				<div class="col-md-12">
				    	<div class="col-md-6 container-table">
    						<table class="table table-bordered" id="cus_order_details">
    							<thead>
                                <tr>
    								<th >BRANCH</th>
    								<th >CUSTOMER</th>
    								<th >PRODUCT</th>
    								<th >GRAMS/PCS</th>
    								<th >STATUS</th>
    							</tr>
    							</thead>
    							<tbody></tbody>
                                <tfoot >
                                    <td class="numbers" style="font-weight:bold;">Total</td>
                                    <td class="numbers"></td>
                                    <td class="total_pcs" style="font-weight:bold;">0.000</td>
                                </tfoot>
    						</table>
    					</div>
				</div>
				
					<div class="col-md-12">
				    
					<div class="col-md-12 col-xs-12 no-paddingwidth container-table">
						<table class="table table-bordered" id="customer_order_table">
							<thead>
                            <tr>
                                    <th  style="text-align:center">BRANCH</th>
                                    <th colspan="2" style="text-align:center">ALLOCATION</th>
                                    <th colspan="3" style="text-align:center">KARIGAR STATUS</th>
                                    <th colspan="4" style="text-align:center">CUSTOMER STATUS</th>
							</tr>
							<tr>
							    <th></th>
							    <th>PENDING<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>ALLOCATED <span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>PENDING<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>DELIVERED<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>OVER DUE<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>PENDING<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>DEL READY<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>DELIVERED<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							    <th>OVER DUE<span style="font-size: 12px;font-weight: normal;"><br>(GRMS/PCS)</span></th>
							</tr>
							</thead>
							<tbody>
							</tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td class="numbers">0.00</td>
                                <td class="numbers">0.000</td>
                                <td class="numbers">0.000</td>
                                <td class="numbers">0</td>
                            </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	