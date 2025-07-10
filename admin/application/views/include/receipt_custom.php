<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Receipt</title>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/cus_receipt.css">
		<!--	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/receipt_temp.css">-->
		
	</head>
	
	<body class="margin">
	<div class="PDF_CusReceipt">
	    <div class="" style="font-weight: 400 !important; font-size:16px !important;" align="center">
						
			</div>
			<?php 
		
			 $total_installment=$records[0]['total_installments'];
             $maturitydate = date('d-m-Y', strtotime("+".$total_installment." months", strtotime($records_sch['start_date'])));
		
            ?>
			<span style="float:right;"><?php echo 'Receipt Date : '.$records[0]['date_payment'];?></span><br/>
		<div class="" align="left">
		

				<?php echo empty($comp_details['company_name']) && !isset($comp_details['company_name']) ?$comp_details['name']:$comp_details['company_name'] ; ?><br/>				
				<?php echo $comp_details['address1'].','; ?>				
				<?php echo $comp_details['address2'].','; ?><br/>
				<?php echo $comp_details['city'].' - '.$comp_details['pincode'].'.'; ?><br/><br/>
				<?php echo 'Maturity Date : '.$maturitydate;?><br/><br/>
			</div>
			<div class="" style="font-weight: 400 !important; font-size:16px !important;" align="center">
				<?php echo $comp_details['name'];?>				
			</div>
			</br>
			<div class="" style="font-weight: 400 !important; font-size:16px !important;" align="center">
				<?php echo $records[0]['scheme_name'];?><hr>				
			</div>
			<div>
			<table class="meta" style="width: 100%" align="center">
				<tr>
					<th><span >MS no</span></th>
					<td><span><?php 
					

					if($records[0]['schemeaccNo_displayFrmt'] == 0){   //only acc num
                        	                        
                        echo $records[0]['scheme_acc_number'];
                    
                    }else if($records[0]['schemeaccNo_displayFrmt'] == 1){ //based on acc number generation setting
                        
                        if($records[0]['scheme_wise_acc_no']==0){
							echo $records[0]['scheme_acc_number'];
						}else if($records[0]['scheme_wise_acc_no']==1){
							echo $records[0]['acc_branch'].'-'.$records[0]['scheme_acc_number'];
						}else if($records[0]['scheme_wise_acc_no']==2){
							echo $records[0]['code'].'-'.$records[0]['scheme_acc_number'];
						}else if($records[0]['scheme_wise_acc_no']==3){
							echo $records[0]['code'].$records[0]['acc_branch'].'-'.$records[0]['scheme_acc_number'];
						}else if($records[0]['scheme_wise_acc_no']==4){
							echo $records[0]['start_year'].'-'.$records[0]['scheme_acc_number'];
						}else if($records[0]['scheme_wise_acc_no']==5){
							echo $records[0]['start_year'].''.$records[0]['code'].'-'.$records[0]['scheme_acc_number'];
						}else if($records[0]['scheme_wise_acc_no']==6){
							echo $records[0]['start_year'].''.$records[0]['code'].''.$records[0]['acc_branch'].'-'.$records[0]['scheme_acc_number'];
						}
                    }else if($records[0]['schemeaccNo_displayFrmt'] == 2){  //customised
                        echo $records[0]['scheme_acc_number'];
                    }
					
					?></span></td>
				</tr>
				<tr>
					<th><span >Receipt No</span></th>
					<td><span ><?php 
					
					if($records[0]['receiptNo_displayFrmt'] == 0){   //only acc num
                        	                        
                        echo $records[0]['receipt_no'];
                    
                    }else if($records[0]['receiptNo_displayFrmt'] == 1){ //based on acc number generation setting
                        
                        if($records[0]['scheme_wise_receipt']==1){
							echo $records[0]['receipt_no'];
						}else if($records[0]['scheme_wise_receipt']==2){
							echo $records[0]['acc_branch'].'-'.$records[0]['receipt_no'];
						}else if($records[0]['scheme_wise_receipt']==3){
							echo $records[0]['code'].'-'.$records[0]['receipt_no'];
						}else if($records[0]['scheme_wise_receipt']==4){
							echo  $records[0]['code'].$records[0]['acc_branch'].'-'.$records[0]['receipt_no'];
						}else if($records[0]['scheme_wise_receipt']==5){
							echo $records[0]['receipt_year'].'-'.$records[0]['receipt_no'];
						}else if($records[0]['scheme_wise_receipt']==6){
							echo $records[0]['receipt_year'].''.$records[0]['code'].''.$records[0]['acc_branch'].'-'.$records[0]['receipt_no'];
						}
                    }else if($records[0]['receiptNo_displayFrmt'] == 2){  //customised
                        echo $records[0]['receipt_no'];
                    }
					
					?></span></td>
				</tr>
				<tr>
					<th><span >Installment No</span></th>
					<td><span><?php echo $records[0]['paid_installments']; ?></span></td>
				</tr>
				<tr>
					<th><span >Gold Rate</span></th>
					<td><span><?php echo $records[0]['metal_rate']; ?></span></td>
				</tr>
				<tr>
					<th><span >Paid Amount</span></th>
					<td><span><?php echo "Rs ".$records[0]['payment_amount']; ?></span></td>
				</tr>
			
				<tr>
					<th><span > Paid Weight</span></th>
					<td><span><?php echo $records[0]['metal_weight'].' g'; ?></span></td>
				</tr> 
				<tr>
					<th><span >Running Weight</span></th>
					<td><span><?php echo $records[0]['total_weight'].' g'; ?></span></td>
				</tr>
				<tr>
					<th><span >Mode</span></th>
					<!--<td><span><?php echo $records[0]['payment_mode']; ?></span></td>-->
					<td>
					    <?php if($records[0]['multi_modes'] == ''){ ?>
    					    <span><?php echo $records[0]['payment_mode']; ?></span>
    					    <br/>
					        <span><?php echo number_format((float)($records[0]['payment_amount']-$records[0]['discountAmt'].' INR '),2, '.', ''); ?></span>
					    <?php }else{ ?>
					        <span><?php echo $records[0]['multi_modes']; ?></span>
					    <?php }?>
					 </td>
				</tr>
				<tr>
					<th><span >Mobile</span></th>
					<td><span><?php echo $records[0]['mobile']; ?></span></td>
				</tr>
			</table><hr>
			</div>
			<div>
				<?php if($records[0]['due_type']=='D') { ?>
					<p align="left">Paid by <?php echo $comp_details['company_name']; ?> for <br/>Mr/Mrs. <?php echo $records[0]['firstname'].(isset($records[0]['firstname'])?', ':''); ?></p>
					<div align="left"><span data-prefix><?php echo $comp_details['currency_symbol']; ?> </span><span style="font-weight: 400 !important; font-size:16px !important;"><?php echo $records[0]['payment_amount']; ?></span></div>
				<?php }else{ ?>
					<p align="left">Received with thanks form <br/>Mr/Mrs. <?php echo $records[0]['firstname'].(isset($records[0]['firstname'])?', ':''); ?></p>
					<div align="left">

						<span ><?php echo $comp_details['currency_symbol']; ?> </span><span style="font-weight: 400 !important; font-size:16px !important;"><?php echo $records[0]['payment_amount']; ?></span>
</div>
				<!-- </tr></span> -->
				<?php } ?>
				
				<p style="font-size:12px !important;"><?php echo ucwords($records[0]['amount_in_words']); ?> Only</p>
							
				<p></p><br/>
				<div style="float:right">For <?php echo empty($comp_details['company_name']) && !isset($comp_details['company_name']) ? $comp_details['name'] :$comp_details['company_name']; ?></div><br/><br/>
				<div style="float:right">Signature</div>
			</div>
		</div>
		<script type="text/javascript"> 
		this.print(); 
		</script> 
	</body>
	
</html>