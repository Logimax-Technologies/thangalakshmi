<!-- Content Wrapper. Contains page content -->
      <style>
      	.remove-btn {
      		margin-top: -168px;
      		margin-left: -38px;
      		background-color: #e51712 !important;
      		border: none;
      		color: white !important;
      	}
      </style>
      <div class="content-wrapper">
      	<!-- Content Header (Page header) -->
      	<section class="content-header">
      		<h1>
      			Pure Weight to Amount Conversion 
      		</h1>
      	</section>

      	<!-- Main content -->
      	<section class="content product">

      		<!-- Default box -->
      		<div class="box box-primary">
      			<div class="box-header with-border">
      				<div class="box-tools pull-right">
      					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
      					<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      				</div>
      			</div>
      			<div class="box-body">
      				<div class="row">


      					<form id="supplier_rate_cut">
      						<div class="container">
      							<div class="col-12">

      								<div class="row">
      									<div class="col-xs-2">
      										<label type="text">Cost Center</label>
      									</div>

      									<div class="col-xs-2">
      										<select class="form-control" style="width:100%" id="branch_select" disabled></select>
      										<input type="hidden" name=supplier_rate_cut[id_branch] id="id_branch">
      									</div>

      								</div><br />
      									<div class="row">
      									<div class="col-xs-2">
      										<label type="text">Metal</label>
      									</div>
      									<div class="col-xs-2">
      										<select class="form-control" name=supplier_rate_cut[id_metal] placeholder="Weight" type="number" id="select_metal"></select>


      									</div>
      								</div>
      								<div class="row">
      									<div class="row">
      										<label style="margin-left:430px">Weight Balance</label> <strong><span class="weight_bln_type"></span></strong>
      										<label style="margin-left:95px">Amount Balance</label><strong><span class="amt_bln_type"></span></strong>
      									</div>


      								</div>
      								<div class="row">
      									<div class="col-xs-2">
      										<div class="form-group">
      											<div class="input-group ">
      												<label type="text">Supplier</label>
      											</div>
      										</div>

      									</div>
      									<div class="col-xs-2">
      										<div class="form-group">
      											<div class="input-group ">
      												<select class="form-control" name=supplier_rate_cut[id_karigar] style="width:100%" id="select_karigar"></select>

      											</div>
      										</div>
      									</div>

      									<div class="col-sm-2">
      										<div class="form-group">
      											<div class="input-group ">
      												<input class="form-control" id='wt_balance' type="number" placeholder="Weight" readonly>
      												<input class="form-control" id='wt_balance_type' type="hidden" placeholder="Weight">
      											</div>
      										</div>
      									</div>


      									<div class="col-xs-2">
      										<input class="form-control" type="number" id="amt_balance" placeholder="Amount" readonly>
      									</div>
      								</div></br>
      								<div class="row" style="display:none;">
      									<div class="col-sm-2">
      										<input type="radio" value="1" name="supplier_rate_cut[rate_cut_type]" id="amt_to_wt" ></input>
      										<label for="amt_to_wt">Amount to Weight</label>

      									</div>
      									<div class="col-md-2">

      										<input type="radio" value="2" name="supplier_rate_cut[rate_cut_type]" id="wt_to_amt" checked></input>
      										<label for="wt_to_amt">Weight to Amount</label>

      									</div>
      								</div>
      							
      								<!-- Amount to Weight -->
      								<div class="type1_amt" style="display:none">
      									<div class="row">
      										<div class="col-xs-2">
      											<label type="text">Amount</label>
      										</div>
      										<div class="col-xs-2">
      											<input class="form-control src_amount " name=supplier_rate_cut[type1_amt] placeholder="Amount" type="number"></input>

      										</div>
      									</div></br>
      								</div>
      								<div class="type2_wt" >
      									<div class="row">
      										<div class="col-xs-2">
      											<label type="text">Weight</label>
      										</div>
      										<div class="col-xs-2">
      											<input class="form-control src_weight" name=supplier_rate_cut[type2_wt] placeholder="Weight" type="number"></input>
      										</div>
      									</div></br>
      								</div>
      								<div class="row">
      									<div class="col-xs-2">
      										<label type="text">Rate</label>
      									</div>
      									<div class="col-xs-2">
      										<input class="form-control src_rate" name=supplier_rate_cut[src_rate] placeholder="Rate" type="number"></input>

      									</div>
      								</div></br>
      								<div class="type1_wt" style="display:none">
      									<div class="row">
      										<div class="col-xs-2">
      											<label type="text">Weight</label>
      										</div>
      										<div class="col-xs-2">
      											<input class="form-control type1_wt" placeholder="Weight" id="src_weight" name=supplier_rate_cut[type1_wt] type="number" readonly></input>
      										</div>
      									</div></br>
      								</div>
      								<div class="type2_amt" >
      									<div class="row">
      										<div class="col-xs-2">
      											<label type="text">Amount</label>
      										</div>
      										<div class="col-xs-2">
      											<input class="form-control type2_amt" placeholder="Amount" id="src_amount" name=supplier_rate_cut[type2_amt] type="number" readonly></input>
      										</div>
      									</div></br>
      								</div>

      								<div class="row">
      									<div class="col-xs-2">
      										<label type="text">Remark</label>
      									</div>
      									<div class="col-xs-4">
      										<textarea rows="5" cols="10" name=supplier_rate_cut[src_remark] class="form-control" placeholder="Enter Here....." type="text"></textarea rows="30">

      									</div>
      								</div></br>
      						</div>
      						<div class="row">
      							<div class="box box-default"><br />
      								<div class="col-xs-offset-5">
      									<button type="button" id="supplier_rate_cut_submit" class="btn btn-primary">Save</button>
      									<button type="button" class="btn btn-default btn-cancel">Cancel</button>

      								</div> <br />
      							</div>
      						</div>
      					</div>
						<div class="overlay" style="display:none">
      						<i class="fa fa-refresh fa-spin"></i>
      					</div>
	</form>


      				</div>
      	</section>

      </div>