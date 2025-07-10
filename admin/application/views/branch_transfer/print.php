<html><head>
		<meta charset="utf-8">
		<title>Branch Copy - <?php echo $btrans[0]['branch_trans_code'];?></title>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bt_ack.css">
		<!--	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/receipt_temp.css">-->
		<style type="text/css">
		body, html {
		margin-bottom:0
		}		
		 span { display: inline-block; }
	</style>
</head><body style="marign-top:-5px;">
<span class="PDFReceipt">
			<div>
            <table class="meta" style=  "align=center;width:100%">
                    <tr>
                    <td style="text-align:center !important;"><img width="30%" style="color:red"  src="<?php echo base_url();?>assets/img/receipt_logo.png"></td>
                    </tr>
             </table>
             <table style="width:150%">
                    <tr>
						<td style="font-size:11px !important;width:50%;">
							<span style="padding-right:5px">CIN   : U51398TN2008PTC068066 &nbsp;</span><br>
                            <span>GSTIN : 33AAMCS0459A1ZO &nbsp;</span>

                        </td>
                        <td style="font-size:11px !important;text-align:right">
							<span>TRANS ID :&nbsp; <?php echo $btrans[0]['branch_transfer_id'];?></span><br>
                            <span>CODE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $btrans[0]['branch_trans_code'];?></span><br>
                            <span>DATE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							:&nbsp;&nbsp;<?php echo $btrans[0]['created_time'];?></span><br>
                            <span>FROM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							:&nbsp;&nbsp;<?php echo $btrans[0]['from_branch'];?></span><br>
                            <span>TO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							:&nbsp;&nbsp;<?php echo $btrans[0]['to_branch'];?></span>

                     </td>
                        
           </table>
           </div>


					
		    <div class="" align="center" style="margin-left:-40px;">
				<h2>BRANCH TRASNFER RECEIPT </h2>
			</div><br>
<div  class="content-wrapper">
     <div class="box">
            <div class="box-body">
     			<div  class="container-fluid">
    						<div  class="row">
    							<div class="col-xs-12">
    								<div class="table-responsive">
    								    
    								    <?php if($type==2)
    								    {
    								        if($btrans[0]['transfer_item_type']==1)         //TAGGED
    								        {?>
    								          <table id="pp" class="table text-center" style="width:100%">
                                                   <tr>
        												<td style="padding-left:35px"><hr class="detail_dashed" style="width:625px !important"></td>
        											</tr>
    								              <tr>
    								            	<th>S.NO</th>
    								            	<th>TAG CODE</th>
    								            	<th>ITEMS</th>
        											<th>PCS</th>
        											<th >GWT</th>
        											<th >NWT</th>
        										  </tr>
        										  <tr>
        												<td style="padding-left:35px"><hr class="detail_dashed" style="width:625px !important"></td>
        											</tr>
        											 <?php 
                                                        $tot_pcs=0;$tot_gross_wt=0;$tot_sales_value=0;
                                                         $tot_net_wt=0;
                                                        function group_by($key, $data) {
                                                        $result = array();
                                                
                                                        foreach($data as $val) {
                                                            if(array_key_exists($key, $val)){
                                                                $result[$val[$key]][] = $val;
                                                            }else{
                                                                $result[""][] = $val;
                                                            }
                                                        }
                                                    
                                                        return $result;
                                                    }
                                                     $byGroup = group_by("product_name", $btrans); 
                                                     //echo "<pre>";print_r($byGroup);exit;
                                                    foreach($byGroup as $items => $val){
                                                        $i=1;
                                                         
                                                        $pcs=0;$gross_wt=0;$tot_sales_value=0;
                                                       
                                                        $net_wt=0;
    
                                                     
                                                        foreach($val as $items)
                                                        {
                                                            $pcs+=$items['piece'];
                                                            $gross_wt+=$items['gross_wt'];
                                                            $net_wt+=$items['net_wt'];
                                                            $tot_pcs+=$items['piece'];
                                                            $tot_gross_wt+=$items['gross_wt'];
                                                            $tot_net_wt+=$items['net_wt'];
                                                            ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $i;?></td>
                                                                    <td style="text-align:center;"><?php echo $items['tag_code'];?></td>  
                                                                    <td style="text-align:center;"><?php echo $items['product_name'];?></td>
                                                                    <td style="text-align:center;"><?php echo $items['piece'];?></td>
                                                                    <td style="text-align:center;"><?php echo $items['gross_wt'];?></td>
                                                                    <td style="text-align:center;"><?php echo $items['net_wt'];?></td>
                                                                </tr>
                                                            <?php 
                                                            $i++;
                                                        } ?>
                                                        <tr>
                										<td style="padding-left:35px"><hr class="detail_dashed" style="width:615px !important"></td>
                									</tr>
                                                    
                                                        <tr>
                                                            <td style="text-align:center;"></td>
                                                            <td style="text-align:center;"></td>  
                                                            <td style="text-align:center;"><b>SUB TOTAL</b></td>
                                                            <td style="text-align:center;"><?php echo $pcs;?></td>
                                                            <td style="text-align:center;"><?php echo $gross_wt;?></td>
                                                            <td style="text-align:center;"><?php echo $net_wt;?></td>
                                                        </tr>
                                                        <tr>
                										<td style="padding-left:35px"><hr class="detail_dashed" style="width:615px !important"></td>
                									</tr>
                                                    
                                                    <?php  }  ?>
                                                    <tfoot>
                                                        <tr style="font-weight:bold;">
                                                            <td style="text-align:center;"></td>
                                                            <td style="text-align:center;"></td>
                                                            <td style="text-align:center;">TOTAL</td>
                                                            <td style="text-align:center;"><?php echo $tot_pcs;?></td>
                                                            <td style="text-align:center;"><?php echo number_format($tot_gross_wt,'3','.','');?></td>
                                                            <td style="text-align:center;"><?php echo number_format($tot_net_wt,'3','.','');?></td>
                                                        </tr>
                                                        <tr>
                										<td style="padding-left:35px"><hr class="detail_dashed" style="width:615px !important"></td>
                									</tr>
                									</tfoot>
        										</table>
    								        <?php } else if($btrans[0]['transfer_item_type']==2){?>    <!-- NON TAGGED -->
    								            
    								            <table id="pp" class="table text-center">
    								              <tr>
    								            	<th  width="7%;" style="text-align:left;">S.NO</th>
    								            	<th  width="25%;" style="text-align:left;">ITEMS</th>
        											<th  width="20%;" style="text-align:left;">PCS</th>
        											<th  width="20%;" style="text-align:left;">GWT</th>
        										  </tr>
        										  <tr>
        												<td><hr class="detail_dashed"></td>
        											</tr>
        											 <?php 
                                                        $i=1;
                                                        $pcs=0;$gross_wt=0;$tot_sales_value=0;
                                                        foreach($btrans as $items)
                                                        {
                                                            $pcs+=$items['piece'];
                                                            $gross_wt+=$items['gross_wt'];
                                                            ?>
                                                                <tr>
                                                                    <td  width="7%;" style="text-align:left;"><?php echo $i;?></td>
                                                                    <td  width="25%;" style="text-align:left;"><?php echo $items['product_name'];?></td>  
                                                                    <td  width="20%;" style="text-align:left;"><?php echo $items['piece'];?></td>
                                                                    <td width="20%;" style="text-align:left;"><?php echo $items['gross_wt'];?></td>
                                                                </tr>
                                                            <?php 
                                                            $i++;
                                                        }
                                                    ?>
                                                    <tr>
                										<td><hr class="detail_dashed"></td>
                									</tr>
                                                    <tfoot>
                                                        <tr style="font-weight:bold;">
                                                            <td style="text-align:left;"></td>
                                                            <td style="text-align:left;">TOTAL</td>
                                                            <td style="text-align:left;"><?php echo $pcs;?></td>
                                                            <td style="text-align:left;"><?php echo number_format($gross_wt,'3','.','');?></td>
                                                        </tr>
                									</tfoot>
        										</table>
    								            
    								        <?php } else if($btrans[0]['transfer_item_type']==3)  // OLD METAL
    								        {?>
    								            <?php 
    								             if(sizeof($purchase_item_details['old_metal_details'])>0)
    								             {?>
    								                  <br><b><span style="text-align:center;">OLD METAL</span></b>
        								                <table id="pp" class="table text-center">
        								                    <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                            </tr>
        								                    <tr style="text-transform:uppercase;">
                                                                <th width="2%;">S.NO</th>
                                                                <th width="5%;">Type</th>
                                                                <th width="5%;">Bill NO</th>
                                                                <th width="5%;">G.Wt</th>
                                                                <th width="5%;">N.Wt</th>
                                                                <th width="5%;" style="text-align:right;">Value(Rs)</th>
                                                            </tr>
                                                            <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                             </tr>
                                                             <?php 
                                                             $i=1;
                										     $net_wt=0;$gross_wt=0;$amount=0;
                                                             foreach($purchase_item_details['old_metal_details'] as $items)
                                                             {
                                                                    $net_wt+=$items['net_wt'];
                                                                    $gross_wt+=$items['grs_wt'];
                                                                    $amount+=$items['amount'];
                                                                    
                                                                    $tot_net_wt+=$items['net_wt'];
                                                                    $tot_gross_wt+=$items['grs_wt'];
                                                                    $tot_amount+=$items['amount'];
                                                                    ?>
                                                                    <tr style="text-align:center;">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><?php echo $items['item_type'];?></td>  
                                                                        <td><?php echo $items['bill_no'];?></td>  
                                                                        <td><?php echo $items['grs_wt'];?></td>
                                                                        <td><?php echo $items['net_wt'];?></td>
                                                                        <td style="text-align:right;"><?php echo $items['amount'];?></td>
                                                                    </tr>
                                                            <?php 
                                                            $i++;
                                                             }
                                                             ?>
                                                             <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                             </tr>
                                                             <tr style="text-transform:uppercase;">
                                                                <th colspan="3">SUB TOTAL</th>
                                                                <th><?php echo number_format($tot_gross_wt,3,'.','');?></th>
                                                                <th><?php echo number_format($tot_net_wt,3,'.','');?></th>
                                                                <th style="text-align:right;"><?php echo number_format($tot_amount,2,'.','');?></th>
                                                            </tr>
                                                            <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                             </tr>
                                                        </table>
    								             <?php } ?>
    								             
    								               <?php 
    								            if(sizeof($purchase_item_details['sales_return_details'])>0)
    								            {?>
    								                <br><b><span style="text-align:center;">SALES RETURN</span></b>
    								                
    								                <table id="pp" class="table text-center">
    								                    <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                        </tr>
    								                    <tr style="text-transform:uppercase;">
                                                            <th width="2%;">S.NO</th>
                                                            <th width="5%;">Type</th>
                                                            <th width="5%;">G.Wt</th>
                                                            <th width="5%;">N.Wt</th>
                                                            <th width="5%;" style="text-align:right;">Value(Rs)</th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <?php 
                                                         $i=1;
            										     $sales_ret_net_wt=0;$sales_ret_gross_wt=0;$sales_ret_amount=0;
                                                         foreach($purchase_item_details['sales_return_details'] as $items)
                                                         {
                                                                $sales_ret_net_wt+=$items['net_wt'];
                                                                $sales_ret_gross_wt+=$items['grs_wt'];
                                                                $sales_ret_amount+=$items['amount'];
                                                    
                                                                ?>
                                                                <tr style="text-align:center;">
                                                                    <td><?php echo $i;?></td>
                                                                    <td><?php echo $items['product_name'];?></td>  
                                                                    <td><?php echo $items['grs_wt'];?></td>
                                                                    <td><?php echo $items['net_wt'];?></td>
                                                                    <td style="text-align:right;"><?php echo $items['amount'];?></td>
                                                                </tr>
                                                        <?php 
                                                        $i++;
                                                         }
                                                         ?>
                                                         <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <tr style="text-transform:uppercase;">
                                                            <th colspan="2">SUB TOTAL</th>
                                                            <th><?php echo number_format($sales_ret_gross_wt,3,'.','');?></th>
                                                            <th><?php echo number_format($sales_ret_net_wt,3,'.','');?></th>
                                                            <th style="text-align:right;"><?php echo number_format($sales_ret_amount,2,'.','');?></th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                    </table>
    								            <?php }?>
    								            
    								            <?php 
    								            
    								            if(sizeof($purchase_item_details['partly_sales_details'])>0)
    								            {?>
    								                <br><b><span style="text-align:center;">PARTLY SALE</span></b>
    								                
    								                <table id="pp" class="table text-center">
    								                    <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                        </tr>
    								                    <tr style="text-transform:uppercase;">
                                                            <th width="2%;">S.NO</th>
                                                            <th width="5%;">Type</th>
                                                            <th width="5%;">G.Wt</th>
                                                            <th width="5%;">N.Wt</th>
                                                            <th width="5%;" style="text-align:right;">Value(Rs)</th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <?php 
                                                         $i=1;
            										     $net_wt=0;$gross_wt=0;$amount=0;
                                                         foreach($purchase_item_details['partly_sales_details'] as $items)
                                                         {
                                                                $net_wt+=$items['net_wt'];
                                                                $gross_wt+=$items['grs_wt'];
                                                                $amount+=$items['amount'];
                                                       
                                                                ?>
                                                                <tr style="text-align:center;">
                                                                    <td><?php echo $i;?></td>
                                                                    <td><?php echo $items['product_name'];?></td>  
                                                                    <td><?php echo $items['grs_wt'];?></td>
                                                                    <td><?php echo $items['net_wt'];?></td>
                                                                    <td style="text-align:right;"><?php echo $items['amount'];?></td>
                                                                </tr>
                                                        <?php 
                                                        $i++;
                                                         }
                                                         ?>
                                                         <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <tr style="text-transform:uppercase;">
                                                            <th colspan="2">SUB TOTAL</th>
                                                            <th><?php echo number_format($gross_wt,3,'.','');?></th>
                                                            <th><?php echo number_format($net_wt,3,'.','');?></th>
                                                            <th style="text-align:right;"><?php echo number_format($amount,2,'.','');?></th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                    </table>
    								            <?php }
    								            ?>
    								            
    								        <?php }else if($btrans[0]['transfer_item_type']==5)
    								        {?>
    								            <table id="pp" class="table text-center">
                                                    <tr>
                                                        <th  width="7%;" style="text-align:left;">S.NO</th>
                                                        <th  width="10%;" style="text-align:left;">ORDER NO</th>
                                                        <th  width="25%;" style="text-align:left;">ITEMS</th>
                                                        <th  width="20%;" style="text-align:left;">PCS</th>
                                                        <th  width="20%;" style="text-align:left;">GWT</th>
                                                    </tr>
                                                    <tr>
                                                        <td><hr class="sumamry_dashed"></td>
                                                    </tr>
                                                    <?php 
                                                    $i=1;
                                                    $pcs=0;$gross_wt=0;$tot_sales_value=0;
                                                    foreach($btrans as $items)
                                                    {
                                                        $pcs+=$items['totalitems'];
                                                        $gross_wt+=$items['weight'];
                                                        ?>
                                                        <tr>
                                                        <td style="text-align:left;"><?php echo $i;?></td>
                                                        <td style="text-align:left;"><?php echo $items['order_no'];?></td>
                                                        <td style="text-align:left;"><?php echo $items['product_name'];?></td>
                                                        <td style="text-align:left;"><?php echo $items['totalitems'];?></td>
                                                        <td style="text-align:left;"><?php echo $items['weight'];?></td>
                                                        </tr>
                                                        <?php 
                                                        $i++;
                                                    }
                                                    ?>
                                                    <tr>
                                                         <td><hr class="sumamry_dashed"></td>
                                                    </tr>
                                                    <tfoot>
                                                        <tr style="font-weight:bold;">
                                                        <td style="text-align:left;"></td>
                                                        <td style="text-align:left;"></td>
                                                        <td style="text-align:left;">TOTAL</td>
                                                        <td style="text-align:left;"><?php echo $pcs;?></td>
                                                        <td style="text-align:left;"><?php echo number_format($gross_wt,'3','.','');?></td>
                                                        </tr>
                                                    </tfoot>
                                                    <tr>
                                                    <td><hr class="sumamry_dashed"></td>
                                                    </tr>
                                                </table><br>
    								        <?php }
    								        
    								        } else if($type==1){?>
    								        <?php 
    								            if($btrans[0]['transfer_item_type']==1 || $btrans[0]['transfer_item_type']==2)     // TAGGED
    								            {?>
                                                    <table id="pp" class="table text-center">
                                                        <tr>
                                                            <th  width="7%;" style="text-align:left;">S.NO</th>
                                                            <th  width="25%;" style="text-align:left;">ITEMS</th>
                                                            <th  width="20%;" style="text-align:left;">PCS</th>
                                                            <th  width="20%;" style="text-align:left;">GWT</th>
                                                            <th  width="20%;" style="text-align:left;">NWT</th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="sumamry_dashed" style="width:1200% !important;"></td>
                                                         </tr>
                                                    <?php 
                                                    $i=1;
                                                        $pcs=0;$gross_wt=0;$tot_sales_value=0;$net_wt=0;
                                                        foreach($btrans as $items)
                                                        {
                                                            $pcs+=$items['piece'];
                                                            $gross_wt+=$items['gross_wt'];
                                                            $net_wt+=$items['net_wt'];
                                                            ?>
                                                            <tr>
                                                            <td style="text-align:left;"><?php echo $i;?></td>
                                                            <td style="text-align:left;"><?php echo $items['product_name'];?></td>
                                                            <td style="text-align:left;"><?php echo $items['piece'];?></td>
                                                            <td style="text-align:left;"><?php echo $items['gross_wt'];?></td>
                                                            <td style="text-align:left;"><?php echo $items['net_wt'];?></td>
                                                            </tr>
                                                            <?php 
                                                            $i++;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td><hr class="sumamry_dashed" style="width:1200% !important;"></td>
                                                    </tr>
                                                    <tfoot>
                                                        <tr style="font-weight:bold;">
                                                            <td style="text-align:left;"></td>
                                                            <td style="text-align:left;">TOTAL</td>
                                                            <td style="text-align:left;"><?php echo $pcs;?></td>
                                                            <td style="text-align:left;"><?php echo number_format($gross_wt,'3','.','');?></td>
                                                            <td style="text-align:left;"><?php echo number_format($net_wt,'3','.','');?></td>
                                                        </tr>
                                                    </tfoot>
                                                        <tr>
                                                            <td><hr class="sumamry_dashed" style="width:1200% !important;"></td>
                                                        </tr>
                                                    </table><br>
    								            <?php } else if($btrans[0]['transfer_item_type']==3)
    								            {?>
    								            
    								            <?php 
    								            if(sizeof($purchase_item_details['old_metal_details'])>0)
    								            {?>
        								                <br><b><span style="text-align:center;">OLD METAL</span></b>
        								                <table id="pp" class="table text-center">
        								                    <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                            </tr>
        								                    <tr style="text-transform:uppercase;">
                                                                <th width="2%;">S.NO</th>
                                                                <th width="5%;">Type</th>
                                                                <th width="5%;">G.Wt</th>
                                                                <th width="5%;">N.Wt</th>
                                                                <th width="5%;" style="text-align:right;">Value(Rs)</th>
                                                            </tr>
                                                            <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                             </tr>
                                                             <?php 
                                                             $i=1;
                										     $net_wt=0;$gross_wt=0;$amount=0;
                                                             foreach($purchase_item_details['old_metal_details'] as $items)
                                                             {
                                                                    $net_wt+=$items['net_wt'];
                                                                    $gross_wt+=$items['grs_wt'];
                                                                    $amount+=$items['amount'];
                                                                    
                                                                    $tot_net_wt+=$items['net_wt'];
                                                                    $tot_gross_wt+=$items['grs_wt'];
                                                                    $tot_amount+=$items['amount'];
                                                                    ?>
                                                                    <tr style="text-align:center;">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><?php echo $items['item_type'];?></td>  
                                                                        <td><?php echo $items['grs_wt'];?></td>
                                                                        <td><?php echo $items['net_wt'];?></td>
                                                                        <td style="text-align:right;"><?php echo $items['amount'];?></td>
                                                                    </tr>
                                                            <?php 
                                                            $i++;
                                                             }
                                                             ?>
                                                             <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                             </tr>
                                                             <tr style="text-transform:uppercase;">
                                                                <th colspan="2">SUB TOTAL</th>
                                                                <th><?php echo number_format($tot_gross_wt,3,'.','');?></th>
                                                                <th><?php echo number_format($tot_net_wt,3,'.','');?></th>
                                                                <th style="text-align:right;"><?php echo number_format($tot_amount,2,'.','');?></th>
                                                            </tr>
                                                            <tr>
                                                                <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                             </tr>
                                                        </table>
    								            <?php }?>
    								            <?php 
    								            if(sizeof($purchase_item_details['sales_return_details'])>0)
    								            {?>
    								                <br><b><span style="text-align:center;">SALES RETURN</span></b>
    								                
    								                <table id="pp" class="table text-center">
    								                    <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                        </tr>
    								                    <tr style="text-transform:uppercase;">
                                                            <th width="2%;">S.NO</th>
                                                            <th width="5%;">Type</th>
                                                            <th width="5%;">G.Wt</th>
                                                            <th width="5%;">N.Wt</th>
                                                            <th width="5%;" style="text-align:right;">Value(Rs)</th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <?php 
                                                         $i=1;
            										     $sales_ret_net_wt=0;$sales_ret_gross_wt=0;$sales_ret_amount=0;
                                                         foreach($purchase_item_details['sales_return_details'] as $items)
                                                         {
                                                                $sales_ret_net_wt+=$items['net_wt'];
                                                                $sales_ret_gross_wt+=$items['grs_wt'];
                                                                $sales_ret_amount+=$items['amount'];
                                                    
                                                                ?>
                                                                <tr style="text-align:center;">
                                                                    <td><?php echo $i;?></td>
                                                                    <td><?php echo $items['product_name'];?></td>  
                                                                    <td><?php echo $items['grs_wt'];?></td>
                                                                    <td><?php echo $items['net_wt'];?></td>
                                                                    <td style="text-align:right;"><?php echo $items['amount'];?></td>
                                                                </tr>
                                                        <?php 
                                                        $i++;
                                                         }
                                                         ?>
                                                         <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <tr style="text-transform:uppercase;">
                                                            <th colspan="2">SUB TOTAL</th>
                                                            <th><?php echo number_format($sales_ret_gross_wt,3,'.','');?></th>
                                                            <th><?php echo number_format($sales_ret_net_wt,3,'.','');?></th>
                                                            <th style="text-align:right;"><?php echo number_format($sales_ret_amount,2,'.','');?></th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                    </table>
    								            <?php }?>
    								            
    								            <?php 
    								            
    								            if(sizeof($purchase_item_details['partly_sales_details'])>0)
    								            {?>
    								                <br><b><span style="text-align:center;">PARTLY SALE</span></b>
    								                
    								                <table id="pp" class="table text-center">
    								                    <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                        </tr>
    								                    <tr style="text-transform:uppercase;">
                                                            <th width="2%;">S.NO</th>
                                                            <th width="5%;">Type</th>
                                                            <th width="5%;">G.Wt</th>
                                                            <th width="5%;">N.Wt</th>
                                                            <th width="5%;" style="text-align:right;">Value(Rs)</th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <?php 
                                                         $i=1;
            										     $net_wt=0;$gross_wt=0;$amount=0;
                                                         foreach($purchase_item_details['partly_sales_details'] as $items)
                                                         {
                                                                $net_wt+=$items['net_wt'];
                                                                $gross_wt+=$items['grs_wt'];
                                                                $amount+=$items['amount'];
                                                       
                                                                ?>
                                                                <tr style="text-align:center;">
                                                                    <td><?php echo $i;?></td>
                                                                    <td><?php echo $items['product_name'];?></td>  
                                                                    <td><?php echo $items['grs_wt'];?></td>
                                                                    <td><?php echo $items['net_wt'];?></td>
                                                                    <td style="text-align:right;"><?php echo $items['amount'];?></td>
                                                                </tr>
                                                        <?php 
                                                        $i++;
                                                         }
                                                         ?>
                                                         <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                         <tr style="text-transform:uppercase;">
                                                            <th colspan="2">SUB TOTAL</th>
                                                            <th><?php echo number_format($gross_wt,3,'.','');?></th>
                                                            <th><?php echo number_format($net_wt,3,'.','');?></th>
                                                            <th style="text-align:right;"><?php echo number_format($amount,2,'.','');?></th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="old_sumamry_dashed" style="width:700px !important;"></td>
                                                         </tr>
                                                    </table>
    								            <?php }
    								            ?>
    								                
    								            <?php } else if($btrans[0]['transfer_item_type']==4)
    								            { ?>
    								                    <table id="pp" class="table text-center">
                                                        <tr>
                                                            <th  width="7%;" style="text-align:left;">S.NO</th>
                                                            <th  width="25%;" style="text-align:left;">ITEMS</th>
                                                            <th  width="20%;" style="text-align:left;">SIZE</th>
                                                            <th  width="20%;" style="text-align:left;">PCS</th>
                                                        </tr>
                                                        <tr>
                                                            <td><hr class="sumamry_dashed"></td>
                                                         </tr>
                                                    <?php 
                                                    $i=1;
                                                        $pcs=0;
                                                        foreach($btrans as $items)
                                                        {
                                                            $pcs+=$items['no_of_pcs'];
                                                            ?>
                                                            <tr>
                                                            <td style="text-align:left;"><?php echo $i;?></td>
                                                            <td style="text-align:left;"><?php echo $items['item_name'];?></td>
                                                            <td style="text-align:left;"><?php echo $items['size_name'];?></td>
                                                            <td style="text-align:left;"><?php echo $items['no_of_pcs'];?></td>
                                                            </tr>
                                                            <?php 
                                                            $i++;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td><hr class="sumamry_dashed"></td>
                                                    </tr>
                                                    <tfoot>
                                                        <tr style="font-weight:bold;">
                                                            <td style="text-align:left;"></td>
                                                            <td style="text-align:left;">TOTAL</td>
                                                            <td style="text-align:left;"><?php echo $pcs;?></td>
                                                             <td style="text-align:left;"></td>
                                                        </tr>
                                                    </tfoot>
                                                        <tr>
                                                            <td><hr class="sumamry_dashed"></td>
                                                        </tr>
                                                    </table><br>
    								            <?php  } else if($btrans[0]['transfer_item_type']==5){?>
    								                        <table id="pp" class="table text-center">
                                                                <tr>
                                                                    <th  width="7%;" style="text-align:left;">S.NO</th>
                                                                    <th  width="25%;" style="text-align:left;">ITEMS</th>
                                                                    <th  width="20%;" style="text-align:left;">PCS</th>
                                                                    <th  width="20%;" style="text-align:left;">GWT</th>
                                                                </tr>
                                                                <tr>
                                                                    <td><hr class="sumamry_dashed"></td>
                                                                </tr>
                                                                <?php 
                                                                $i=1;
                                                                $pcs=0;$gross_wt=0;$tot_sales_value=0;
                                                                foreach($btrans as $items)
                                                                {
                                                                    $pcs+=$items['totalitems'];
                                                                    $gross_wt+=$items['weight'];
                                                                    ?>
                                                                    <tr>
                                                                    <td style="text-align:left;"><?php echo $i;?></td>
                                                                    <td style="text-align:left;"><?php echo $items['product_name'];?></td>
                                                                    <td style="text-align:left;"><?php echo $items['totalitems'];?></td>
                                                                    <td style="text-align:left;"><?php echo $items['weight'];?></td>
                                                                    </tr>
                                                                    <?php 
                                                                    $i++;
                                                                }
                                                                ?>
                                                                <tr>
                                                                     <td><hr class="sumamry_dashed"></td>
                                                                </tr>
                                                                <tfoot>
                                                                    <tr style="font-weight:bold;">
                                                                    <td style="text-align:left;"></td>
                                                                    <td style="text-align:left;">TOTAL</td>
                                                                    <td style="text-align:left;"><?php echo $pcs;?></td>
                                                                    <td style="text-align:left;"><?php echo number_format($gross_wt,'3','.','');?></td>
                                                                    </tr>
                                                                </tfoot>
                                                                <tr>
                                                                <td><hr class="sumamry_dashed"></td>
                                                                </tr>
                                                            </table><br>
    								            <?php }?>
    								       
    								    <?php }?>
    								</div>
        						</div>	 
        				    </div>
        				   </br></br></br></br>
    				    	<div class="row"style="padding-left:50px">
        				        <label><b>Declaration: Above stock is being transferred to another Branch / Vendor / Head office for internal purpose</b></label></br></br>
                               
        				    </div>
    				        <br><br><br><br>
    				        <div class="row" style="text-transform:uppercase;padding-left:50px">
                            	<label>individual wt verified by</label>
                            	<label style="margin-left:13%;">received by</label>
                            	<label style="margin-left:30%;">approved By</label>
                            </div>
    				    
    		</div>
        </div><!-- /.box-body --> 
     </div><!-- box -->
</div>
 </span>          
</body></html>
