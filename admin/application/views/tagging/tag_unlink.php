<!-- Content Wrapper. Contains page content -->
<style>
    .remove-btn{
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
        Tag Unlink
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
         <!-- form container -->
          <div class="row">
            <div class="col-sm-12"> 
                <!-- Lot Details Start Here -->
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
                            <?php if($this->session->userdata('branch_settings')==1){?>
                             <div class="col-md-2">
                                 <div class="form-group">
                                     <label><a data-toggle="tooltip" title="Branch" >Select Branch</a><span class="error">*</span></label>
                                     <select id="branch_select" class="form-control" required style="width:100%;"></select>
                                </div>
                             </div>
                             <?php }?>
                             <div class="col-md-2">
                                     <div class="form-group">
                                         <label><a  data-toggle="tooltip" title="Enter Lot">Search Tag Code</a></label>
                                         <input type="text" class="form-control tag_unlink" id="tag_unlink" placeholder="Enter Tag Code"></input>
                                    </div>
                             </div>
                             
                             
                             
                 </div> 	
                 <p class="help-block"></p>			 
            </div>	<!--/ Col --> 
        </div>	 <!--/ row -->
        <div class="table-responsive">
                 <table id="tagging_unlink_list" class="table table-bordered table-striped text-center">
                    <thead>
                      <tr>
                        <th width="5%"><label class="checkbox-inline"><input type="checkbox" id="select_all" name="select_all" value="all"/>All</label></th>     
                        <th width="5%">Tag Code</th>
                        <th width="5%">Lot No</th>
                        <th width="5%">Product Name</th>
                        <th width="5%">Design Name</th>
                        <th width="5%">Sub Design Name</th>
                        <th width="5%">Gross Wgt</th>
                        <th width="10%">Net Wgt</th>
                        <th width="10%">Order No</th>
                        <th width="10%">Order Weight</th>
                        <th width="5%">status</th>
                      </tr>
                    </thead> 
                    <tbody></tbody>
                 </table>
              </div>		

           <p class="help-block"> </p> 
             <div class="row">
               <div class="box box-default"><br/>
                  <div class="col-xs-offset-5">
                    <button type="submit"  class="btn btn-primary" id="tag_unlink_submit">Save All</button> 
                    <button type="button" class="btn btn-default btn-cancel">Cancel</button>
                  </div> <br/>
                </div>
              </div> 
            </div> 
            <div class="overlay" style="display:none">
              <i class="fa fa-refresh fa-spin"></i>
            </div>

             <!-- /form -->
          </div>
         </section>
 
</div>

