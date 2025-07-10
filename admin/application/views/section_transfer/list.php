
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
       <!-- Content Header (Page header) -->
       <section class="content-header">
         <h1>
           Section Transfer List
           <small></small>
         </h1>
         <ol class="breadcrumb">
           <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
           <li><a href="#">Inventory</a></li>
           <li class="active">Section transfer list</li>
         </ol>
       </section>

       <!-- Main content -->
       <section class="content">
         <div class="row">
           <div class="col-xs-12">
          
             <div class="box box-primary">
               <div class="box-body">
               <div class="row">
                       <div class="col-md-12">
                           <div class="col-md-6">  
                               <div class="box box-primary">  
                                   <div class="box-body"> 
                                       <div class="row">
                                           <?php if($this->session->userdata('branch_settings')==1 && $this->session->userdata('id_branch')==0){?>
                                           <div class="col-md-4"> 
                                               <div class="form-group tagged">
                                                   <label>Select Branch<span class="error">*</span></label>
                                                   <select id="branch_select" class="form-control branch_filter" reqiured></select>
                                               </div> 
                                           </div> 
                                           <?php }else{?>
                                               <input type="hidden" id="branch_filter"  value="<?php echo $this->session->userdata('id_branch') ?>"> 
                                               <input type="hidden" id="branch_name"  value="<?php echo $this->session->userdata('branch_name') ?>"> 
                                           <?php }?> 
                                           <div class="col-md-4"> 
                                               <div class="form-group tagged">
                                                   <label>Select Section</label>
                                                   <select id="select_frm_section" class="form-control" style="width:100%;"></select>
                                               </div> 
                                           </div>
                                           <div class="col-md-4"> 
                                               <div class="form-group tagged">
                                                   <label></label>
                                                   <input class="form-control" type="text" name="tag_code" id="tag_code" placeholder="Search Tag Code">
                                               </div> 
                                           </div>
                                           </div>
                                           <div class="row"> 
                                           <div class="col-md-4"> 
                                               <div class="form-group tagged">
                                                   <label></label>
                                                   <input class="form-control" type="text" name="tag_code_old" id="tag_code_old" placeholder="Search Old Tag Id">
                                               </div> 
                                           </div>
                                           <div class="col-md-4"> 
                                               <div class="form-group tagged">
                                                   <label></label>
                                                    <input type="text" id="est_no" class="form-control" style="width:100%;" placeholder="Estimation No."/>
                                               </div> 
                                           </div>
                                           <div class="col-md-2"> 
                                               <label></label>
                                                   <div class="form-group">
                                                       <button type="button" id="section_tag_search" class="btn btn-info">Search</button>   
                                                   </div>
                                           </div>
                                       </div>
                                       <!-- <div class="row" id="delete_row">
                                           <div class="col-md-2"> 
                                               <label></label>
                                                   <div class="form-group">
                                                       <button type="button" id="delete_product_mapping" class="btn btn-danger">Delete</button>   
                                                   </div>
                                           </div>
                                       </div> -->
                                   </div>
                               </div> 
                           </div>
                           
                           <div class="col-md-6">  
                               <div class="box box-primary">  
                                   <div class="box-body"> 
                                        
                                       <div class="row">
                                           <div class="col-md-4"> 
                                               <div class="form-group tagged">
                                                   <label>Select Section</label>
                                                   <select id="select_to_section" class="form-control" style="width:100%;"></select>
                                               </div> 
                                           </div>
                                           <div class="col-md-2"> 
                                               <label></label>
                                                   <div class="form-group">
                                                       <button type="button" id="section_transfer" class="btn btn-success">Transfer</button>   
                                                   </div>
                                           </div>
                                       </div>
                                   </div>
                               </div> 
                           </div>
                       </div>
                  </div> 
               
                <div class="table-responsive">
                 <table id="section_trans_list" class="table table-bordered table-striped text-center">
                   <thead>
                     <tr>
                       <th><label class="checkbox-inline"><input type="checkbox" id="select_all" name="select_all" value="all"/>All</label></th>
                       <th>Branch</th>
                       <th>Tag Code</th>
                       <th>Old Tag Id</th>
                       <th>Section Name</th>
                       <th>Product Name</th>
                       <th>Pcs</th>
                       <th>Gwt</th>
                       <th>Nwt</th>
                     </tr>
                    </thead>
                    <tbody>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="font-weight:bold;">TOTAL</td>
                      <td>:</td>
                      <td  style="font-weight:bold;" class="pcs"></td>
                      <td  style="font-weight:bold;" class="grs_wt"></td>
                      <td  style="font-weight:bold;" class="net_wt"></td>
                    </tbody>
                 </table>
                 </div> 
                
               </div><!-- /.box-body -->
                <div class="overlay" style="display:none">
                 <i class="fa fa-refresh fa-spin"></i>
               </div>
             </div><!-- /.box -->
           </div><!-- /.col -->
         </div><!-- /.row -->
       </section><!-- /.content -->
     </div><!-- /.content-wrapper -->
     




