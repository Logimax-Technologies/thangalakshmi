var ctrl_page = path.route.split('/');



let inr_format = Intl.NumberFormat('en-IN');



var pre_img_resource=[];



var pre_img_files=[];







var deleted=0;//to store table _length when delete button clicked (gift table)



var rows_added=0;//to store table length after a row added (gift table)



var deleted_array=[];//to store the deleted rows id (gift table)



		



		



$(document).ready(function() {



    



    



    	$('#join_day').on("change", function(e) {







		      if(this.value!='' && this.value!=0) 



		      {



	        



				var from_date = $('#account_list1').text();



				var to_date  = $('#account_list2').text();



				var id_customer=$("#id_customer").val();



				var id_scheme=$('#id_scheme').val();



				var id_branch = $("#id_branch").val();



				//get_scheme_acc_list(from_date,to_date,id_branch,id_customer);



				get_scheme_acc_list(from_date,to_date,id_branch,id_customer,id_scheme);



		      	 



			  }



			}); 



			



    



	// gift_issued_list(ctrl_page[2]);



	$('#acc_join').submit(function(e)  {		



		$('#submit').prop('disabled', true);  



	});







	$(document).on('click', ".rate_fix_warning", function(e) {



		$.toaster({ priority : 'warning', title : 'Closing Warning', message : ''+"</br>You cannot close account without fixing rate. Kindly fix rate to close this scheme account.." });



	});



	



	//get_group_list();



	



     $("#account_name").on('keypress', function (event) {



				  var regex = new RegExp("^[a-zA-Z _ \r\s]+$");



          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);



          if (!regex.test(key)) {



             event.preventDefault();



			 alert('Account name must contain alphabets only')







             return false;



          }



       });



  



	customers = [];



		schCodes = [];



	//get_Schemegroup



	



	if(ctrl_page[1]=='edit')



	{



	    $("#button_otp").hide();



	     gift_issued_list(ctrl_page[2]);



	     



	      var table_rows = $('#chart_gift_creation_tbl tbody tr').length;



				  rows_added = $('#chart_gift_creation_tbl tbody tr').length;



				



				 $("#table_row_length").val(table_rows);



					



					for(var i=1;i<=table_rows;i++)



					{



						get_gift_names(i);



					}



	}



	



	if(ctrl_page[0] == 'account' && ctrl_page[1] == 'add')



	{



	    $(".hasgift").css("display", "none");



	    $("#otp_txt_box").hide();



			get_otpstatus_for_gift();



	    //$('#start_date').prop('disabled', true);



	    



	    



	}



	



	$("#button_otp").on('click',function()



			{



				$("#otp_txt_box").hide();



				var mobile_data=$("#mobile_number").val();



				if(mobile_data=="")



				{



					$.toaster({ priority : 'warning', title : 'Warning', message : ''+"</br> Please enter valid customer .."});



					$("#button_otp").attr("disabled",true);



				}



				else



				{



				$('#verify_otp_modal').modal('show');



				}







			});



	



	    $("#issue_gift").on('click',function(){



	        $(".show_gifts").css("display", "block");



    	});



    	



    	$("#issue_prize").on('click',function(){



	        $(".show_prizes").css("display", "block");



    	});



	



	    $('#gift_list').select2().on("change", function(e) {



		      if(this.value!='')



		      {



		      	$('#gift_val').val(this.value);



		      	



		      	 



			  }



		});  



			



	



		//get)closed branch name//HH



	if(ctrl_page[1]=='close')



	{



	    get_employee_name();



		if(ctrl_page[0]=='account')



		{



			if(ctrl_page[2]!='scheme')



			{



					get_cls_branchname();



			}else{



			    calculate_closing_balance();



			}



		}



	}







//webcam upload, #AD On:20-12-2022,Cd:CLin,Up:AB



	



	if(ctrl_page[1]=='close'  &&  ctrl_page[2]=='scheme' )



    {



    	   Webcam.set({



    		width: 290,



    		height: 190,



    		image_format: 'jpg',



    		jpeg_quality: 90



    	});



    	Webcam.attach( '#my_camera' );



    	



    	$("#imageModal").setShortcutKey(17 , 73 , function() {



    		take_snapshot('pre_images');



    	} );



    }



    



    $('#imageModal  #update_img').on('click', function(){



    	$('#imageModal').modal('toggle');				



    	$('#image_closeing').val(encodeURIComponent(JSON.stringify(pre_img_resource)));	 



    });  







//webcam upload ends....	



	



	if(ctrl_page[1]=='add')



	{



	    



	    $("#mobile_number").on("keyup",function(e){ 



	       



    		var customer = $("#mobile_number").val();



    		 if(customer.length==0)



			{



				var filterval="blur(8px)";



					   



					//	$("#gift_list").attr('disabled',true);



					//	$("#prize_details").attr('disabled',true);



						$('#gift_articles').css('filter',filterval);



						$('#gift_articles').css('pointer-events','none');



						$("#button_otp").show();



					



			}



    		if(customer.length >= 2) { 



    			getSearchCustomers(customer);



    		}



    	}); 



    	    



        function getSearchCustomers(searchTxt)



        {



            my_Date = new Date();



            $.ajax({



            url: base_url+'index.php/admin_manage/getCustomersBySearch/?nocache=' + my_Date.getUTCSeconds(),             



            dataType: "json", 



            method: "POST", 



            data: {'searchTxt': searchTxt}, 



            success: function (data) {



            $( "#mobile_number" ).autocomplete(



            {



            source: data,



            select: function(e, i)



            { 



                e.preventDefault();



                $("#mobile_number" ).val(i.item.label);



    	    	$("#id_customer").val(i.item.value);



    	    	$("#txt_mobile").val(i.item.mobile);//lines added by durga - 19/12/2022 from here #gift otp



						$("#txt_mobile").attr("disabled",true);//lines added by durga - 19/12/2022 from here #gift otp



						$("#button_otp").attr("disabled",false);//lines added by durga - 19/12/2022 ends here



    	    	get_customer_detail(i.item.value);



            },



            change: function (event, ui) {



            if (ui.item === null)



            {



                $("#mobile_number" ).val('');



    	    	$("#id_customer").val('');



            }



            },



            response: function(e, i) {



            // ui.content is the array that's about to be sent to the response callback.



            if(searchTxt != "")



            {



                if (i.content.length === 0) {



                    var filterval="blur(8px)";    //lines added by durga - 19/12/2022 from here #gift otp



					$('#gift_articles').css('filter',filterval);



					$('#gift_articles').css('pointer-events','none');



				//	$("#gift_list").attr('disabled',true);



				//	$("#prize_details").attr('disabled',true);



				//	$("#button_otp").attr('disabled',true);



					$("#button_otp").show(); 



                alert('Please Enter a valid Number');



                }



               



            }



            else



            {



                



            }



            },



            minLength: 3,



            });



            }



            });



        }







	     /*console.log(customerListArr);



		$.each(customerListArr, function(key, val)



		{



			customerList.push({'label' : val.mobile+'  '+val.name, 'value' : val.id});



		});*/



       



	/*	$( "#mobile_number" ).autocomplete(



		{







		source: customerList,



		select: function(e, i)



		{



		console.log("successfully");



		e.preventDefault();



		$("#mobile_number" ).val(i.item.label);



		$("#id_customer").val(i.item.value);



		var id_customer=$('#id_customer').val();



		 if($("#mobile_number" ).val().length>0)



		 {



			get_customer_detail(id_customer);







		 }







		},



		response: function(e, i) {



            // ui.content is the array that's about to be sent to the response callback.



            if (i.content.length === 0) {



               alert('Please Enter a valid Number');



               $('#mobile_number').val('');



            } 



        },



		 minLength: 4,



		});*/



	}



	



	if(ctrl_page[1]=='scheme_group' && (ctrl_page[2]=='add' || ctrl_page[2]=='edit') )



	{ 



			 var dateToday = new Date();	



		    



			$('#date_add').datepicker({



               format: 'dd-mm-yyyy',



                  "setValue": new Date(),



                  "autoclose": true



              



            }).datepicker("setDate");



			



			$('#date_update').datepicker({



               format: 'dd-mm-yyyy',



                  "setValue": new Date(),



                  "autoclose": true



              



            }).datepicker("setDate");



			



			get_schemename();



			



	}



	else if(ctrl_page[1]=='scheme_group' && ctrl_page[2]=='edit'){



		get_schemename();



	}



	else if(ctrl_page[0]=='account' && (ctrl_page[1]=='add' || ctrl_page[1]=='edit')){



		get_emp_branchwise();   //Get Branch wise emp name in Scheme Join Page admin //



		//get_gift_names();



	}



	



	if(ctrl_page[1]=='scheme_group' && ctrl_page[2]=='list')



	{



		get_group_list();



	}



// enable & disable save button//hh	



 if(ctrl_page[1]=='scheme_group' && (ctrl_page[2]=='add')){



     //$('#group').prop('disabled', true); old 05-12-2022



	 



	 $('#group').prop('disabled', false); // New 05-12-2022



 }	



 		else if(ctrl_page[2]=='add' || ctrl_page[2]=='edit'){



	 $('#group').prop('disabled', false);



	}



// enable & disable save button//hh		



 	



 	



		$('#group_code').on('blur onchange',function(){



        var group_code=this.value;



        check_groupcode(group_code);



    });



	// scheme group//







	if(ctrl_page[1]=='scheme_reg' && ctrl_page[2]=='list')



	{



		



		// existing scheme reg// 



		 



			if(ctrl_page[3])



			 {



				 $('#filtered_status').val(ctrl_page[3]);



			 }



		// existing scheme reg// 



		



			



			initialize_branch_list("sel_branch");



			



			



			



			



	



			console.log(ctrl_page[1]);



			



			get_request_list();



			$('#sel_branch').select2().on("change", function(e) {



		      if(this.value!='')



		      {



		      	status =  $('#filtered_status').val();



		      	get_request_list('','',this.value,status);



		      	 



			  }



			});  



			$('#filtered_status').on('change', function() {



		 	  if(this.value == 1){



		 	      $("#reject").css("display", "none");



		 	      $("#approve").css("display", "none");



		 	      $("#revert").css("display", "block");



		 	  }else{



		 	      $("#reject").css("display", "block");



		 	      $("#approve").css("display", "block");



		 	      $("#revert").css("display", "none");



		 	  }



		 	  get_request_list('','','',this.value);



		 	});



		 	



		 	$('#payment_list1').empty();



            $('#payment_list2').empty();



            $('#payment_list1').text(moment().startOf('month').format('YYYY-MM-DD'));



             $('#payment_list2').text(moment().endOf('month').format('YYYY-MM-DD'));







			$('#reqList-dt-btn').daterangepicker(



            {



	              ranges: {



	                'Today': [moment(), moment()],



	                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],



	                'Last 7 Days': [moment().subtract(6, 'days'), moment()],



	                'Last 30 Days': [moment().subtract(29, 'days'), moment()],



	                'This Month': [moment().startOf('month'), moment().endOf('month')],



	                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]



	              },



	              startDate: moment().subtract(29, 'days'),



	              endDate: moment()



	            },



	        function (start, end) {



	          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));



	               $('#payment_list1').text(start.format('YYYY-MM-DD'));



                $('#payment_list2').text(end.format('YYYY-MM-DD'));       



	             get_request_list(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),'',$('#filtered_status').val())



	          }



	        );



	        



			$("input[name='upd_status_btn']:radio").change(function(){



				if($("input[name='reg_request_id[]']:checked").val())



				{



				 	var selected = [];



				 	var approve=false;



					$("#scheme_reg_list tbody tr").each(function(index, value){



						if($(value).find("input[name='reg_request_id[]']:checked").is(":checked")){



				var firstPayment_amt=$(value).find(".firstPayment_amt").val();



				var scheme_type=$(value).find(".scheme_type").val();



			var firstPayamt_payable=$(value).find(".firstPayamt_payable").val();



							



			if(scheme_type==3 && firstPayment_amt=='' && firstPayamt_payable==1)



			{



				alert('Please Enter a first Installment Payment Amount');



				approve=false;



				 $('input[name=upd_status_btn]').removeAttr('checked');







			}



			else



			{



				approve=true;



			}











							transData = { 'id_reg_request'   : $(value).find(".id_reg_request").val(),



										  'remark'  : $(value).find(".remark").val(),						



										  'id_scheme'  : $(value).find(".id_scheme").val(),					



										  'id_branch'  : $(value).find(".id_branch").val(),				



										  'scheme_acc_number'  : $(value).find(".chit_no").val(),



										  'scheme_group_code'  :  $(value).find(".scheme_group_code").val(),



										  'group_code'  :  $(value).find(".group_code").val(),



										  'id_customer'  : $(value).find(".id_customer").val(),



										  'ac_name'  : $(value).find(".ac_name").val(),					



										  'mobile'  : $(value).find(".mobile").val(),	



										  'email'  : $(value).find(".email").val(),



										  'added_by'  : $(value).find(".added_by").val(),



										   'pan_no'  : $(value).find(".pan_no").val(),



										    'firstPayment_amt'  : $(value).find(".firstPayment_amt").val(),



										    'paid_installments'  : $(value).find(".paid_installments").val(),



										  'balance_amount'  : $(value).find(".balance_amount").val(),



										  'balance_weight'  : $(value).find(".balance_weight").val(),



										  'last_paid_weight'  : $(value).find(".last_paid_weight").val(),



										  'last_paid_chances'  : $(value).find(".last_paid_chances").val(),



										  'last_paid_date'  : $(value).find(".last_paid_date").val(),



							}







							



							selected.push(transData);	



				 		}



					})



					req_status = $("input[name='upd_status_btn']:checked").val();



					req_data = selected;



					console.log(req_data);



			    	if(approve==true)



					{



					update_request_status(req_status,req_data);



					}		



				}



		   });



		



	} 



   



     $("#block_payment").bootstrapSwitch();	



 $("#show_gift_article").bootstrapSwitch();	



 



 $('#show_gift_article').on('switchChange.bootstrapSwitch', function (event, state) {







        var x=1;



        var y=0;



        if($("#show_gift_article").is(':checked')) {



          $("#show_gift_article").val(x);



        } else {



          $("#show_gift_article").val(y);



        }



    });



     







    //to show Closed Acc detail







	$(document).on('click', "a.closed_ac_detail", function(e) {







       e.preventDefault();







		







		$('.closed_acc_detail').html(closedAccDetail($(this).data('id')));







		  $('#clsd_acc_detail').modal('show', {backdrop: 'static'});







	});







     



	  $('#close_save').click(function(event){



	  if($('#remark_close').val()==''){



	  	 msg='<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert">&times;</a><strong>Warning!</strong> Enter comment.</div>';				



				$("div.overlay").css("display", "none");



				$('#error-msg').html(msg);



	  	return false;



	  }



	  return true;



    });	



	



	



	$( "#add_benefits,#add_charges").focus(function() {



 		 $('.close_actionBtns').css("display","block");



	});



	



	



	/*	function calculate_closing_balance()



	{



	    var closing_benefits=0;



	    var closing_deductions=0;



	    if($('#add_benefits').val()=='')



    	{



    	    $('#add_benefits').val(parseFloat('0').toFixed(2));		



    	}



    	if($('#add_charges').val()=='')



    	{



    	    $('#add_charges').val(parseFloat('0').toFixed(2));		



    	}



    



    	if( $('#sch_typ').val()==0)



    	{



        	var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



        



        	if(parseInt($('#paid_installments').val())>=parseInt($('#apply_benefit_min_ins').val()))



        	{



        	    closing_benefits=($('#firstPayDisc_value').val()*$('#paid_installments').val());



        	    



        	    console.log(closing_benefits);



        	}



        	else if($('#paid_installments').val()!=$('#total_installments').val())



        	{



        	    c_bal=parseFloat(c_bal-($('#firstPayDisc_value').val()*$('#paid_installments').val()));



        	    closing_deductions=($('#firstPayDisc_value').val()*$('#paid_installments').val());



        	    cus_paid_amount=$('#customer_payment_amount').val();



        	    $('#cus_paid_amount').val(parseFloat(cus_paid_amount)-parseFloat(closing_deductions));



        	   



        	}



        	console.log(closing_benefits);



            	$('#closing_balance').val(parseFloat(c_bal).toFixed(2));



            	



    	}



    	// Closing balance should be stored as weight //H



    	else if($('#sch_typ').val()==3 && ($('#flexi_sch_typ').val()==1 ||  $('#flexi_sch_typ').val()==5))



    	{



    	    var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



        	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));		



    	}



    	else if($('#sch_typ').val()!=0 && $('#add_benefits').val()!='')



    	{



        	if($('#fixed_wgtschamt').val()==0 && $('#add_benefits').val()!='0.00')



        	{



            	var c_bal = (parseFloat($('#closing_weight').val()) + (parseFloat($('#add_benefits').val())/parseFloat($('#metal_rate').val())));



            	var c_amt = (parseFloat($('#closing_amount').val()) + parseFloat($('#add_benefits').val()));



            	var add_benefits = parseFloat($('#add_benefits').val()).toFixed(3);	



            	$('#calc_blc').attr('disabled', 'disabled');				



        	}



        	if($('#fixed_wgtschwgt').val()==1 && $('#add_benefits').val()!='0.00')



        	{



            	var c_bal =(parseFloat($('#closing_weight').val()) + parseFloat($('#add_benefits').val()));	



            	var c_amt = (parseFloat($('#closing_amount').val()) + (parseFloat($('#add_benefits').val())*parseFloat($('#metal_rate').val())));



            	var add_benefits = parseFloat($('#add_benefits').val()).toFixed(3);



            	$('#calc_blc').attr('disabled', 'disabled');



        	}



        	if((($('#fixed_wgtschwgt').val()==1 || $('#fixed_wgtschamt').val()==0) && $('#add_benefits').val()!='0.00'))



        	{



            	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));   	   	



            	$('#closing_amt').val(parseFloat(c_amt).toFixed(3));   	   	



            	$('#add_benefit').val(add_benefits);  



        	}



    	}



    	$('#closing_deductions').val(parseFloat(closing_deductions).toFixed(2));



        $('#closing_benefits').val(parseFloat(closing_benefits).toFixed(2));



    	$('#remark_close').css("display","block");



    	$('.close_actionBtns').css("display","block");



    	$('#close_actionBtns').css("display","block");



	}



	 */



	 



	function oldcalculate_closing_balance()



	{



	    var closing_benefits=0;



	    var closing_deductions=0;



	    if($('#add_benefits').val()=='')



    	{



    	    $('#add_benefits').val(parseFloat('0').toFixed(2));		



    	}



    	if($('#add_charges').val()=='')



    	{



    	    $('#add_charges').val(parseFloat('0').toFixed(2));		



    	}



    



    	if( $('#sch_typ').val()==0)



    	{



        	var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#scheme_detections').val()) + parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



            



        	if(parseInt($('#paid_installments').val())>=parseInt($('#apply_benefit_min_ins').val()))



        	{



        	    closing_benefits=($('#firstPayDisc_value').val()*$('#paid_installments').val());



        	    



        	    console.log(closing_benefits);



        	}



        	else if($('#paid_installments').val()!=$('#total_installments').val())



        	{



        	    c_bal=parseFloat(c_bal-($('#firstPayDisc_value').val()*$('#paid_installments').val()));



        	    closing_deductions=($('#firstPayDisc_value').val()*$('#paid_installments').val());



        	    cus_paid_amount=$('#closing_paid_amt').val();



        	    $('#cus_paid_amount').val(parseFloat(cus_paid_amount)-parseFloat(closing_deductions));



        	   



        	}



        	console.log(c_bal);



            	$('#closing_balance').val(parseFloat(c_bal).toFixed(2));



            	//$('#closing_amount').val(parseFloat(c_bal).toFixed(2));



            	



    	}



    	// Closing balance should be stored as weight //H



    	else if($('#sch_typ').val()==3 && ($('#flexi_sch_typ').val()==5))



    	{



    	    var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#scheme_detections').val()) + parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



        	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));		



    	}



    	else if($('#sch_typ').val()==3 && ($('#flexi_sch_typ').val()==1 && $('#one_time_premium').val()==0))



    	{



    	    var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



        	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));		



    	}



    	else if($('#sch_typ').val()!=0 && $('#add_benefits').val()!='')



    	{



    	    //for weight scheme calculate amount



    	    if($('#closing_wgt_amount').val() > 0 && $('#fixed_wgtschamt').val() == 0 && $('#fixed_wgtschwgt').val() != 1)



    	    {



    	        var wgt_amt = ((parseFloat($('#closing_wgt_amount').val()) + parseFloat($('#add_benefits').val()))-parseFloat($('#add_charges').val()));



    	    }else{



    	        var wgt_amt = (parseFloat($('#closing_wgt_amount').val()) -parseFloat($('#add_charges').val()));



    	    }



    	    $('#closing_wgt_amount').val(wgt_amt);



    	    



        	if($('#fixed_wgtschamt').val()==0 && $('#add_benefits').val()!='0.00')



        	{



            	var c_bal = (parseFloat($('#closing_weight').val()) + (parseFloat($('#add_benefits').val())/parseFloat($('#metal_rate').val())));



            	var c_amt = (parseFloat($('#closing_amount').val()) + parseFloat($('#add_benefits').val()));



            	var add_benefits = parseFloat($('#add_benefits').val()).toFixed(3);	



            	$('#calc_blc').attr('disabled', 'disabled');				



        	}



        	if($('#fixed_wgtschwgt').val()==1 && $('#add_benefits').val()!='0.00')



        	{



            	var c_bal =(parseFloat($('#closing_weight').val()) + parseFloat($('#add_benefits').val()));	



            	var c_amt = (parseFloat($('#closing_amount').val()) + (parseFloat($('#add_benefits').val())*parseFloat($('#metal_rate').val())));



            	var add_benefits = parseFloat($('#add_benefits').val()).toFixed(3);



            	$('#calc_blc').attr('disabled', 'disabled');



        	}



        	if((($('#fixed_wgtschwgt').val()==1 || $('#fixed_wgtschamt').val()==0) && $('#add_benefits').val()!='0.00'))



        	{



            	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));   	   	



            	$('#closing_amt').val(parseFloat(c_amt).toFixed(3));   	   	



            	$('#add_benefit').val(add_benefits);  



        	}



    	}



    	$('#closing_deductions').val(parseFloat(closing_deductions).toFixed(2));



        $('#closing_benefits').val(parseFloat(closing_benefits).toFixed(2));



    	$('#remark_close').css("display","block");



    	$('.close_actionBtns').css("display","block");



    	$('#close_actionBtns').css("display","block");



	}



	



	



	function calculate_closing_balance()



	{



	   



	    var closing_benefits=0;



	    var closing_deductions=0;



	    if($('#add_benefits').val()=='')



    	{



    	    $('#add_benefits').val(parseFloat('0').toFixed(2));		



    	}



    	if($('#add_charges').val()=='')



    	{



    	    $('#add_charges').val(parseFloat('0').toFixed(2));		



    	}



    



    	if( $('#sch_typ').val()==0)



    	{



        	var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#scheme_detections').val()) + parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



            



        	if(parseInt($('#paid_installments').val())>=parseInt($('#apply_benefit_min_ins').val()))



        	{



        	    closing_benefits=($('#firstPayDisc_value').val()*$('#paid_installments').val());



        	    



        	    console.log(closing_benefits);



        	}



        	else if($('#paid_installments').val()!=$('#total_installments').val())



        	{



        	    c_bal=parseFloat(c_bal-($('#firstPayDisc_value').val()*$('#paid_installments').val()));



        	    closing_deductions=($('#firstPayDisc_value').val()*$('#paid_installments').val());



        	    cus_paid_amount=$('#closing_paid_amt').val();



        	    $('#cus_paid_amount').val(parseFloat(cus_paid_amount)-parseFloat(closing_deductions));



        	   



        	}



        	console.log(c_bal);



            	$('#closing_balance').val(parseFloat(c_bal).toFixed(2));



            	//$('#closing_amount').val(parseFloat(c_bal).toFixed(2));



            	



    	}



    	// Closing balance should be stored as weight //H



    	else if($('#sch_typ').val()==3 && ($('#flexi_sch_typ').val()==5))



    	{



    	    var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#scheme_detections').val()) + parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



        	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));		



    	}



    /*	else if($('#sch_typ').val()==3 && ($('#flexi_sch_typ').val()==1 && $('#one_time_premium').val()==0))



    	{



    	    var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val()) + parseFloat($('#add_benefits').val())) - (parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));



        	$('#closing_balance').val(parseFloat(c_bal).toFixed(3));		



    	} */



    	else if($('#sch_typ').val()!=0 && $('#add_benefits').val()!=''){



        



        //for addtional benefits & detection new code update....



        



        var addBenefitAmtType   = $('#fixed_wgtschamt').val();   //value = 0



        var addBenefitWgtType   = $('#fixed_wgtschwgt').val();   //value = 1



        var sch_type            = $('#sch_typ').val();



        var flexSch_type        = $('#flexi_sch_typ').val();



        var wgt_convert         = $('#wgt_convert').val();



        var add_benefit         = parseFloat($('#add_benefits').val());



        var add_detection       = parseFloat($('#add_charges').val());



        var closing_balance     = parseFloat($('#closing_balance').val());



        var closing_wgt_amount  = parseFloat($('#closing_wgt_amount').val());



        var metal_rate          = parseFloat($('#metal_rate').val());







        



        if( add_detection != '0.00' || (add_benefit != '0.00' && (addBenefitAmtType == 0 || addBenefitWgtType == 1)) ){



            



            //For all type of amount schemes...  //take closing_balance field



            if( sch_type == 0 || sch_type == 3 && (flexSch_type == 1 || flexSch_type == 6 || (flexSch_type == 2  && wgt_convert == 2)) ){



   



                var c_amt = '0.00';



                if(addBenefitAmtType == 0 && addBenefitAmtType != ''){



                    alert($('#closing_balance').val());



                    alert(add_benefit);



                    alert(add_detection);



                    //for add benefit as amount...



                    var c_bal = closing_balance + add_benefit - add_detection ;



                    



                }else if(addBenefitWgtType == 1 && addBenefitWgtType != ''){



                    //for add benefit as weight...



                    var c_bal = closing_balance + (add_benefit * metal_rate) - add_detection ;



                    



                }else{



                   //for only detection... 



                    var c_bal = closing_balance - add_detection ;



                }



                    



            }



            



            //for all type of weight schemes...  //take closing_balance field for weight and closing_wgt_amount field for amt



            



           else if( sch_type == 1 || sch_type == 2 || sch_type == 3 && (flexSch_type == 3 || flexSch_type == 4 || flexSch_type == 5 || flexSch_type == 7 || (flexSch_type == 2  && (wgt_convert == 0 || wgt_convert == 1))) ){



           



               if(addBenefitAmtType == 0 && addBenefitAmtType != ''){



                    //for add benefit as amount...



                    var c_bal = closing_balance + (add_benefit / metal_rate) - (add_detection / metal_rate) ;



                    var c_amt = closing_wgt_amount + add_benefit - add_detection;



               }else if(addBenefitWgtType == 1 && addBenefitWgtType != ''){



                    //for add benefit as weight...



                    var c_bal = closing_balance + add_benefit - (add_detection / metal_rate) ;



                    var c_amt = closing_wgt_amount + (add_benefit * metal_rate) - add_detection ;



                }else{



                   //for only detection... 



                    var c_bal = closing_balance - (add_detection / metal_rate) ;



                    var c_amt = closing_wgt_amount - add_detection ;



                }



                



            }



            



            $('#closing_balance').val(parseFloat(c_bal).toFixed(3));   	   	 //for all scheme...



            $('#closing_wgt_amount').val(parseFloat(c_amt).toFixed(3));      // amt for wgt scheme alone...



        



        }



        



    	}







    	$('#closing_deductions').val(parseFloat(closing_deductions).toFixed(2));



        $('#closing_benefits').val(parseFloat(closing_benefits).toFixed(2));



    	$('#remark_close').css("display","block");



    	$('.close_actionBtns').css("display","block");



    	$('#close_actionBtns').css("display","block");



	}



	 



	 



	$('#calc_blc').click(function(event){



        calculate_closing_balance();



	});



	 



	// add_benefits weight or amount



	 



	 if($('#sch_typ').val()!=0 || $('#sch_typ').val()!=3)



	 { 



		 $("#fixed_wgtschamt").prop("checked","checked");



		 $("#fixed_wgtschamt").val(0);



		 $('#add_benefits').val('0.00');



		 $('#wgt_symbol').hide();



	 }



	 



	   $("input[name='account[add_benefixed]']:radio").change(function () {







			 var closing_amt=$('#closing_amt').val();



		      var closing_weight=$('#closing_weight').val();	



	  



		   if($("#fixed_wgtschamt").is(':checked'))



		   {



			   $("#fixed_wgtschamt").val(0);



			    $('#fixed_wgtschwgt').val('');



			    $('#add_benefits').val('0.00');



				$('#wgt_symbol').hide();



				$('#curren_symbol').show();



			  $('#calc_blc').attr('disabled', false);



			   $('#closing_amount').val(closing_amt);



			   $('#closing_balance').val(closing_weight);



				



		   }







		   else if($("#fixed_wgtschwgt").is(':checked'))



		   {



		        $('#fixed_wgtschwgt').val(1);



				$("#fixed_wgtschamt").val('');



				$("#add_benefits").val('0.00');



				$('#wgt_symbol').show();



				$('#curren_symbol').hide();



				$('#calc_blc').attr('disabled', false);



				 $('#closing_amount').val(closing_amt);



			    $('#closing_balance').val(closing_weight);



		   }







    });



    



     $("#add_charges").keyup(function () {



        var closing_amt=$('#closing_amt').val();



		var closing_weight=$('#closing_weight').val();	



		$('#closing_amount').val(closing_amt);



		$('#closing_balance').val(closing_weight);



     });



	 



	$('#clear_blc').click(function(event){



		



       var closing_amt=$('#closing_amt').val();



       var closing_weight=$('#closing_weight').val();



	   $('#add_benefits').val('0.00');



	   $('#add_charges').val('0.00');



	   $('#closing_amount').val(closing_amt);



	   $('#closing_balance').val(closing_weight);



	   $('#calc_blc').attr('disabled', false);



		



	});



	 



	 



	 



	 



	 



	 // add_benefits weight or amount 



	 



	 



	 



	 



	 



	 







    function closedAccDetail(id)







	{







		var transaction="";







		$("div.overlay").css("display", "block");







			$.ajax({







				  url:base_url+ "index.php/account/closed/view/"+id+"?nocache=" + my_Date.getUTCSeconds(),







				







				 dataType:"JSON",







				 type:"POST",







				 async:false,







				 success:function(data){







			







				 transaction  = "<table class='table table-bordered trans'><tr><th>Customer Name</th><td>"+data.name+"</td></tr><tr><th>Customer Mobile</th><td>"+data.mobile+"</td></tr><tr><th>Account Name</th><td>"+data.account_name+"</td></tr><tr><th>Account No.</th><td>"+data.code+'-'+(data.scheme_acc_number!=''?data.scheme_acc_number:'Not Allocated')+"</td></tr><tr><th>Start Date</th><td>"+data.start_date+"</td></tr><tr><th>Closed Date</th><td>"+data.closing_date+"</td></tr><tr><th>Closed Employee</th><td>"+data.employee_closed+"</tr></td><tr><th>Scheme Name</th><td>"+data.scheme_name+"</td></tr><tr><th>Scheme Type</th><td>"+data.scheme_type+"</td></tr><tr><th>Amount Payable</th><td>"+data.sch_amt+"</td></tr><tr><th>Total Paid Installments</th><td>"+data.paid_installments+'/'+data.total_installments+"</td></tr><tr><th>Total Paid</th><td>"+data.total_paid+"</td></tr>"+(data.total_installments==data.paid_installments ? "<tr><th>Scheme Benefits</th><td>"+data.interest+"</td></tr>" :'')+"<tr><th>Additional Benefits</th><td>"+data.additional_benefits+"</td></tr><tr><th>Detections/Tax</th><td>"+data.tax+"</td></tr><tr><th>Bank Charges</th><td>"+data.bank_chgs+"</td></tr><tr><th>Additional Charges</th><td>"+data.closing_add_chgs+"</td></tr>"+(data.sch_typ==1 ? "<tr><th>Closing Weight</th><td>"+data.closing_balance+' g'+"</td></tr>" :"<tr><th>Closing Balance</th><td>"+data.closing_balance+"</td></tr>")+"<tr><th>Closed Request By</th><td>"+data.closed_by+" ("+data.closedBy+")</td></tr><tr><th>OTP Verified Mobile</th><td>"+data.otp_verified_mob+"</td></tr><tr><th>Closing Comments</th><td><span class='label bg-yellow'>"+data.remark_close+"</span></td></tr>"+



				                "<tr><th>Closing Image</th><td>"+(data.img_path ? "<img src="+base_url+data.img_path+">": "-" )+"</td></tr>"+



				                "</table>" ;







					return transaction;







						$("div.overlay").css("display", "none");







						  },







						  error:function(error)  







						  {







							 $("div.overlay").css("display", "none"); 







						  }	 







			  });







			   $("div.overlay").css("display", "none"); 







			return transaction;	







			







	}















     







     if(ctrl_page[1] == 'new')







	{



			  var date = new Date();



			  



		    var firstDay  = new Date(date.getFullYear(), date.getMonth(),date.getDate() - 6, 1); 



		



			var from_date =  firstDay.getFullYear()+'-'+(firstDay.getMonth()+1)+'-'+firstDay.getDate();



	



			var to_date=(date.getFullYear()+"-"+(date.getMonth() + 1)+"-"+date.getDate());



	$('#account_list1').empty();



	$('#account_list2').empty();



	



	var id_customer=$("#id_customer").val();



	var id_scheme=$('#id_scheme').val();



	var id_branch = $("#id_branch").val();



	 //get_scheme_acc_list(from_date,to_date);



	 get_scheme_acc_list(from_date,to_date,id_branch,id_customer,id_scheme);



	$('#account_list1').text(moment().startOf('month').format('YYYY-MM-DD'));



	$('#account_list2').text(moment().endOf('month').format('YYYY-MM-DD'));	



	$('#account-dt-btn').daterangepicker(







            {







              ranges: {







                'Today': [moment(), moment()],







                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],







                'Last 7 Days': [moment().subtract(6, 'days'), moment()],







                'Last 30 Days': [moment().subtract(29, 'days'), moment()],







                'This Month': [moment().startOf('month'), moment().endOf('month')],







                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]







              },







              startDate: moment().subtract(29, 'days'),







              endDate: moment()







            },







        function (start, end) {







          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));



          	    var id_branch=$('#id_branch').val();



				var id_customer=$('#id_customer').val();



				var id_scheme=$('#id_scheme').val();



              //get_scheme_acc_list(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),id_branch,id_customer)			 



              get_scheme_acc_list(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),id_branch,id_customer,id_scheme);



			  $('#account_list1').text(start.format('YYYY-MM-DD'));



			  $('#account_list2').text(end.format('YYYY-MM-DD')); 







          }







        );   







}







if(ctrl_page[1] == 'close')



{



	get_closed_acc_list();



	if($('#enable_closing_otp').val()==0)



	{



    	$('#otp').prop('disabled',true);



    	$('#send_otp').prop('disabled',true);



    	$('#verify_otp').prop('disabled',true);  



   



	}



	



	else



	{



    	$('#otp').prop('disabled',false);



    	$('#send_otp').prop('disabled',false);



    	$('#verify_otp').prop('disabled',false); 



        $('#close_save').prop('disabled',false); //disabled hh//



	}



	



	$('#closed_list1').empty();



	$('#closed_list2').empty();



	$('#closed_list1').text(moment().startOf('month').format('YYYY-MM-DD'));



	$('#closed_list2').text(moment().endOf('month').format('YYYY-MM-DD'));	



	$('#closed-acc-dt-btn').daterangepicker(



            {



              ranges: {



                'Today': [moment(), moment()],



                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],



                'Last 7 Days': [moment().subtract(6, 'days'), moment()],



                'Last 30 Days': [moment().subtract(29, 'days'), moment()],



                'This Month': [moment().startOf('month'), moment().endOf('month')],



                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]



              },



              startDate: moment().subtract(29, 'days'),



              endDate: moment()



            },



        function (start, end) {



          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));



                     



             get_closed_acc_list(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))



			 



			  $('#closed_list1').text(start.format('YYYY-MM-DD'));



			  $('#closed_list2').text(end.format('YYYY-MM-DD')); 



          }



        );   



}







/*-- Coded by ARVK --*/















	var fewSeconds = 90;







$('#send_otp').click(function(event) {







		







	



		if($("input[name='account[closed_by]']:checked").val()==1)



		{



			var nom_mobile=$("#nominee_mobile").val();



			var nom_name=$("#nominee_name").val();



			if(nom_mobile!='' && nom_name!='')



			{



				var btn = $(this);







				btn.prop('disabled', true);







				setTimeout(function(){







				btn.prop('disabled', false);







				btn.prop('value', 'Resend OTP');







				}, fewSeconds*1000);



				close_acc_otp();



			}



			else 



			{



				if(nom_mobile=='')



				{



					$.toaster({ priority : 'warning', title : 'Nominee Details ', message : ''+"</br>Enter valid Nominee Mobile Number"});



					$("#nominee_mobile").focus();



				}



				else if(nom_name=='')



				{



					$.toaster({ priority : 'warning', title : 'Nominee Details ', message : ''+"</br>Enter valid Nominee Name"});



					$("#nominee_name").focus();



				}



				else if(nom_mobile =='' && nom_name =='')



				{



					$.toaster({ priority : 'warning', title : 'Nominee Details ', message : ''+"</br>Enter valid Nominee Name and Mobile number "});



					$("#nominee_name").focus();



				}



			



			}







		}



		else



		{



			var btn = $(this);







			btn.prop('disabled', true);







			setTimeout(function(){







			btn.prop('disabled', false);







			btn.prop('value', 'Resend OTP');







			}, fewSeconds*1000);



			close_acc_otp();



		}



      	







    	







    });



//refferal report







$( "#referal_code" ).on( "blur", function(event) {



		if($("#referal_code").val() != "")



		{



			event.preventDefault();



			var codes=$("#referal_code").val();



			var referalcode=$("#referalcode_val").val();			



			if(codes!=referalcode){



			   checkreferalcode(codes);



			}else{



				$('#referal_code').val('');



				alert("If We Enter Wrong Referal Code");



				



			}



			



		}



		



});



	



	function checkreferalcode(codes)



	{  



			var id_customer=$("#id_customer").val();



			$('.overlay').css('display','block');



			$.ajax({



			  type: 'POST',



			   data:{'referal_code':codes,'id_customer':id_customer},



			  url:  base_url+'index.php/admin_manage/referralcode_check',



			  dataType: 'json',



			  success: function(data) {



				$('.overlay').css('display','none');



			   	if(data.status==0)



				{



				   alert(data.msg);



				   $('#referal_code').val('');



				   $('#referal_code').attr("placeholder", data.msg);			



					return false;



				}	



			  },



		  	 







			});



	}











//refferal report



	







    $('#verify_otp').click(function(event) {







    	







    	$(this).prop('disabled','disabled');







    	verify_close_acc_otp();	







    });















/*-- / Coded by ARVK --*/







     







	$('#select_all').click(function(event) {







		$("tbody tr td input[type='checkbox']").prop('checked', $(this).prop('checked'));







      event.stopPropagation();







    });







   /* $("tbody tr td input[type='checkbox']").click(function(event) {







		$("#select_all").prop('checked', $(this).prop('checked'));







      	event.stopPropagation();







    }); */







	







	//for confirm closing active account







	$(document).on('click', "a.confirm-close", function(e) {







       e.preventDefault();







        var link=$(this).data('href');   







        







       $('#confirm-close').find('.btn-confirm').attr('href',link);







    });







    







   //for reverting close account 







    $(document).on('click', "a.confirm-revert", function(e) {







       e.preventDefault();







        var link=$(this).data('href');   







        







       $('#confirm-revert').find('.btn-confirm').attr('href',link);







    });







   







	$('#confirm-delete .btn-cancel').on('click', function(e) {







		







		$('.btn-confirm').attr('href',"#");







	}); 







	







	







	if($('#start_date').length>0)







	{







		$('#start_date').datepicker({







               format: 'dd-mm-yyyy'







                })







            .on('changeDate', function(ev){







            $(this).datepicker('hide');







            });



	}



	



	if($('#maturity_date').length>0)



	{



		$('#maturity_date').datepicker({



               format: 'dd-mm-yyyy'



                })



            .on('changeDate', function(ev){



            $(this).datepicker('hide');



            });



	}







	$('#last_paid_date').datepicker({







	   format: 'dd-mm-yyyy'







		})







    .on('changeDate', function(ev){







	   $(this).datepicker('hide');







	});















	







	if($('#close_date').length>0)







	{







		$('#close_date').datepicker({







               format: 'dd-mm-yyyy'







                })







            .on('changeDate', function(ev){







            	







              







            $(this).datepicker('hide');







            });







	}	







	







	if($("#is_opening").length>0)







	{







		 prev_bal_edit();







		 $('#is_opening').on('change', function() {







		 	  prev_bal_edit();		 	  







		 });







	}







		







	







	if($('#customer_select').length>0)







	{







		get_customers();







	}







	if($('#scheme').length>0)







	{







		get_schemes();







	}



	



	if($('#emp_select').length>0)







	{







		get_employee_name();







	}







	















	 $('#scheme').on('change', function() {







	 	



 	    get_scheme_detail(this.value);



 	    



 	 /*if(this.value!='')



 	    {



 	         get_group_name(this.value);    // get_groupname for new sch join //hh



 	    }*/



 	    



 	   







	}); 







	







	







	$('.btn-acc-close').click(function (e) {







       e.preventDefault();







        var link=$(this).data('href');







       $('#confirm-close').find('.btn-confirm').attr('href',link);















   });







   







   $("input[name='account[closed_by]']:radio").change(function () 



		{



			var closed_by = $("input[name='account[closed_by]']:checked").val();



			if(closed_by==1)



			{



				$("#nominee_mobile").prop("disabled",false);



				$("#nominee_name").prop("disabled",false);



				var nominee=$("#nominee_mobile").val();



				if(nominee=='')



				{



					$.toaster({ priority : 'warning', title : 'Nominee Details ', message : ''+"</br>Enter valid Nominee Mobile Number and name "});



					



					$("#nominee_mobile").focus();



				}



			}



			else



			{



				$("#nominee_mobile").prop("disabled",true);



				$("#nominee_name").prop("disabled",true);



			}



			



		}



		);















	/*	$('#nominee_mobile').blur(function () {







		   if($(this).val().length==10)







		   {







		   		$('#otp').prop('disabled',false);







		        $('#send_otp').prop('disabled',false);







		        $('#verify_otp').prop('disabled',false);







		   }







		   else







		   {







		   	    $('#otp').prop('disabled',true);







		        $('#send_otp').prop('disabled',true);







		        $('#verify_otp').prop('disabled',true);







		        $(this).val('');







		   }







    });   */















//****allow only numeric value and '.' start****







	







	$("#add_charges").keypress(function (e){







		  var charCode = (e.which) ? e.which : e.keyCode;







		  if (charCode != 46 &&(charCode > 31 && (charCode < 48 || charCode > 57)))







		  {







			return false;







		  }







    });







    







    $("#detections").keypress(function (e){







		  var charCode = (e.which) ? e.which : e.keyCode;







		  if (charCode != 46 &&(charCode > 31 && (charCode < 48 || charCode > 57)))







		  {







			return false;







		  }







    });







//****allow only numeric value and '.' end****























//**** 0 to 0.00 Start****















$('#add_charges').on('keyup',function(){







    	







    	if($('#add_charges').val()=='0')// || $('#add_charges').val()=='0')







   	   {







	   	$('#add_charges').val(parseFloat('0').toFixed(2));	







	   }







   	   







   });







   







   $('#detections').on('keyup',function(){







    	







    	if($('#detections').val()=='0')// || $('#detections').val()=='0')







   	   {







	   	$('#detections').val(parseFloat('0').toFixed(2));	







	   }







   	   







   });







//**** 0 to 0.00 end****























//****Benefits and Detections calculation start****







    







    $('#add_charges').on('blur',function(){







    	







    	if($('#add_charges').val()=='')







   	   {







	   	$('#add_charges').val(parseFloat(0).toFixed(2));







	   }







    	







   });







 







    $('#add_charges').on('change blur onfocus',function(){







    	







    	if($('#add_charges').val()!='' && $('#sch_typ').val()==0)







   	   {







	   	var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val())) - (parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));







   	   







   	   	$('#closing_balance').val(parseFloat(c_bal).toFixed(2));







	   }







    	







   });







   







   $('#detections').on('change blur onfocus',function(){















   	   	if($('#detections').val()!='' && $('#sch_typ').val()==0)







   	   {







	   	var c_bal = (parseFloat($('#closing_amount').val()) + parseFloat($('#benefits').val())) - (parseFloat($('#detections').val()) + parseFloat($('#bank_chgs').val()) + parseFloat($('#add_charges').val()));







   	   







   	   	$('#closing_balance').val(parseFloat(c_bal).toFixed(2));







	   }







   });







   







//****Benefits and Detections calculation end****















// scheme group //



//get_group_list();















});















function get_customers()







{







	$(".overlay").css('display','block');







	$.ajax({







		type: 'GET',







		url: base_url+'index.php/customer/get_customers',







		dataType:'json',







		success:function(data){







		  var id_customer =  $('#id_customer').val();







		   $.each(data, function (key, item) {







			   		$('#customer_select').append(







						$("<option></option>")







						  .attr("value", item.id)







						  .text(item.mobile+' '+item.name )



					);







			});







			







			$("#customer_select").select2({







			    placeholder: "Enter mobile number",







			    allowClear: true







			});







				







			$("#customer_select").select2("val",(id_customer!='' && id_customer>0?id_customer:''));







			 $(".overlay").css("display", "none");	







		}







	});







}















 //on selecting drawee account







   $('#customer_select')







        .on("change", function(e) {







          //console.log("change val=" + this.value);







         







          if(this.value!='')







          {







          	 $("#id_customer").val(this.value);







		  	 get_customer_detail(this.value);







		  }







		







		  







   });















function get_schemes()



{



	$(".overlay").css('display','block');



	$.ajax({



		type: 'GET',



		url: base_url+'index.php/scheme/get_schemes',



		dataType:'json',



		success:function(data){



				var selectid=$('#scheme_val').val();



					schCodes = data;



					console.log(schCodes);



					$.each(data, function (key, data) {



						var name=(data.name.concat(data.active==0 ?  '(Inactive)' :''));



                        $('#scheme').append(



                        $("<option></option>")



                        .attr("value", data.id_scheme)



                        .text(name)



                        );



					});



			$("#scheme").select2({



			    placeholder: "Enter scheme",



			    allowClear: true



			});



			$("#scheme").select2("val",(selectid!=null && selectid>0?selectid:''));



		$(".overlay").css('display','none');	



		}



	});



}







$('#scheme').on('change', function() { 



 	if($('#scheme').val() != null){



 		var scheme = schCodes.filter(function(schCode) { 



          return schCode.id_scheme == $('#scheme').val() ;



        }); 



        console.log(scheme[0].is_pan_required);



        $('#pan_req_amt').val(scheme[0].pan_req_amt);



        $('#is_pan_required').val(scheme[0].is_pan_required);



        $('#get_amt_in_schjoin').val(scheme[0].get_amt_in_schjoin);



        if(scheme[0].is_pan_required == '1'){



            $('div#panimage').css('display','block');



		    $('div#pan_number').css('display','block');



		    $('#bank-file-input').prop('required',true);



            $('#pan_no').prop('required',true);



            $('#pan_no').prop('minlength',10); 



        }else{



            $('div#panimage').css('display','none');



		    $('div#pan_number').css('display','none');



		    $('#bank-file-input').prop('required',false);



           $('#pan_no').prop('required',false);  



           $('#pan_no').prop('minlength',0); 



        } 



        



        if((scheme[0].get_amt_in_schjoin) == 1){



            $('#get_amt').css('display','block');



        }



 	}



	    



});	











function  get_customer_detail(id)







{







	$.ajax({







		type:'GET',







		 url:base_url+'index.php/customer/get_customer/'+id,







		 dataType:'json',







		 success:function(data){







		 	







		    //console.log(data);







		    set_customer(data);







		 	







		 }







	});







}































function  get_scheme_detail(id)







{







	 my_Date = new Date();







	$.ajax({







		type:'GET',







		 url:base_url+'index.php/scheme/get_scheme/'+id+'/'+my_Date.getUTCSeconds(),







		 dataType:'json',







		 cache:false,







		 success:function(data){







		 	if(data.sch_limit_value!=null && data.sch_limit==1)



		    {



					



		    	if(data.sch_joined_acc>=data.sch_limit_value)



			    {



			    	alert('maximum scheme group limit reached');



			    	window.location.reload(true); 



			    }



		    }



    



            if(data.sch_type==3 && (data.flexible_sch_type==1 || data.flexible_sch_type==2) && $('#get_amt_in_schjoin').val() == 1 )



            {



                $('#firstPayment_amt').prop('required',true);



                $('#flx_denomintion').val(data.flx_denomintion);



                $('#min_amount').val(data.min_amount);



                $('#max_amount').val(data.max_amount);



            }else



            {



                 $('#firstPayment_amt').prop('required',false);



            }







		 	set_scheme(data);







		 	$("#scheme_type").val(data.scheme_type);







		 	prev_bal_edit();

            //lines added by Durga (Gopal Code) 08.05.2023 starts here
           if( data.get_amt_in_schjoin==1  && data.firstPayamt_as_payamt==1 || data.firstPayamt_maxpayable==1)
    		{
               
                pan_req_amt=Math.trunc( data.pan_req_amt );
                
                var firstpayment_amt = $('#firstPayment_amt').val()
            
                if(firstpayment_amt >= pan_req_amt && pan_req_amt!=0 && data.is_pan_required==1)
    			{
    
                    $('#pan_number').show()
                    $('#panimage').show()
                    
                }
    			else
    			{
                    $('#pan_number').hide()
                    $('#panimage').hide()
    
                }
    
            }

             //lines added by Durga (Gopal Code) 08.05.2023 ends here


		 }

        





	});







}







$('#firstPayment_amt').on('change',function(){



    var pay_amt=$(this).val();



    var flx_denomintion=parseInt($('#flx_denomintion').val());



    var min_amount=parseInt($('#min_amount').val());



    var max_amount=parseInt($('#max_amount').val());



    var pan_req_amt = parseInt($('#pan_req_amt').val());



    var is_pan_required = parseInt($('#is_pan_required').val());



   



    



    if(flx_denomintion!='')



    {



        if((pay_amt>=min_amount) && (pay_amt<=max_amount))



		   {



		           if((pay_amt%flx_denomintion)!=0)



		           {



		              alert('Please Enter a Amount in Multiples of '+flx_denomintion+'');



		              $("#firstPayment_amt").val('');



		           }else



		           {



		               $validAmt=true;



		           }



		   }



		   else



		   {



		       alert('Your Amount Shold be Minimum'+min_amount+' and Maximum '+max_amount+'');



		        $("#firstPayment_amt").val('');



		   }



    }



    



    if(is_pan_required == 1 || is_pan_required == 2){



        



      if(pan_req_amt != 0 && pan_req_amt != '' && pan_req_amt != null && pay_amt >= pan_req_amt){



		$('div#panimage').css('display','block');



		$('div#pan_number').css('display','block');



		$('#bank-file-input').prop('required',true);



		$('#pan_no').prop('required',true);



        $('#pan_no').prop('minlength',10); 



	 }else{



	    $('div#panimage').css('display','none'); 



	    $('div#pan_number').css('display','none'); 



        $('#bank-file-input').prop('required',false);



	    $('#pan_no').prop('required',false);  



        $('#pan_no').prop('minlength',0); 



	 } 



	 



    }



    



     



    



    



});







function prev_bal_edit()







{







	var scheme_type = $("#scheme_type").val();















	if($("#is_opening").prop('checked')==true)







	{







		if(scheme_type=="Weight")







		{







			$("#paid_installments").prop('disabled', false);







			$("#balance_amount").prop('disabled', false);







			$("#last_paid_date").prop('disabled', false);







			$("#balance_weight").prop('disabled', false);







			$("#last_paid_weight").prop('disabled', false);







			$("#last_paid_chances").prop('disabled', false);







		}







		else if(scheme_type=="Amount to Weight")







		{







			$("#paid_installments").prop('disabled', false);







			$("#balance_amount").prop('disabled', false);







			$("#last_paid_date").prop('disabled', false);







			$("#balance_weight").prop('disabled', false);







			$("#last_paid_weight").prop('disabled', false);







			$("#last_paid_chances").prop('disabled', false);







		}







		else if(scheme_type=="Amount")







		{







			$("#paid_installments").prop('disabled', false);







			$("#balance_amount").prop('disabled', false);







			$("#last_paid_date").prop('disabled', false);







			$("#balance_weight").prop('disabled', true);







			$("#last_paid_weight").prop('disabled', true);







			$("#last_paid_chances").prop('disabled', true);







		}







		else







		{







			$("#paid_installments").prop('disabled', true);







			$("#balance_amount").prop('disabled', true);







			$("#last_paid_date").prop('disabled', true);







			$("#balance_weight").prop('disabled', true);







			$("#last_paid_weight").prop('disabled', true);







			$("#last_paid_chances").prop('disabled', true);







		}







	}	







	else







	{







		$("#paid_installments").prop('disabled', true);







		$("#balance_amount").prop('disabled', true);







		$("#last_paid_date").prop('disabled', true);







		$("#balance_weight").prop('disabled', true);







		$("#last_paid_weight").prop('disabled', true);







		$("#last_paid_chances").prop('disabled', true);







	}







}















function set_customer(data)







{







	var ac_name=$('#account_name').val();







	var address=(data.address?data.address:"")+(data.address1?data.address1+", ":"")+(data.city?data.city:"")+(data.pincode?" - "+data.pincode:"");







	var mobile=(data.mobile?data.mobile:"-");







	var img_url=base_url+'assets/img/customer/'+data.id_customer+"/";







	var default_img=base_url+'assets/img/default.png';







	var cus_img_src=(data.cus_img!=null?img_url+data.cus_img:default_img);







    var name=(ac_name==null? (data.firstname?__capitalizeString(data.firstname):"")+" "+(data.lastname?__capitalizeString(data.lastname):""):ac_name);



   



  /* if(ctrl_page[1] == 'add'&& ctrl_page[0] == 'account')







	{



   if(data.referal_code!=null){



      $('#referal_code').val(data.referal_code!=''?data.referal_code:'');



      $('#referalcode_val').val(data.mobile);



     $('div#referalcode').css('display','none');



    }else{



         $('#referalcode_val').val(data.mobile);



         $('div#referalcode').css('display','block');



         $('#referal_code').val('');



      }



	}else if(ctrl_page[1] == 'edit' && ctrl_page[0] == 'account'){



	    



	   $('#referal_code').attr('disabled', true);



	}*/



	



	if(ctrl_page[1] == 'edit' && ctrl_page[0] == 'account'){



	    



	   $('#referal_code').attr('disabled', true);



	}



  



   



	$('#cus_address').text((address?address:"-"));







	$('#cus_mobile').text(mobile);







	$('#cus_img').attr("src", cus_img_src);







	$('#account_name').val(name);







    







}















function set_scheme(data)







{







	var sch_type=data.scheme_type;







	var sch_code=(data.code?data.code:"-");







	var sch_duration=(data.total_installments?data.total_installments:"-");







	var pay_type=(data.payment_type?data.payment_type:"-");







	var amount=(sch_type=='Amount'?data.amount:'0.00')







	var interest=(data.interest?data.interest:"-");







	var tax=(data.tax?data.tax:"-");







	var min_weight=(data.min_weight?data.min_weight:"-");







	var max_weight=(data.max_weight?data.max_weight:"-");







	var min_chance=(data.min_chance?data.min_chance:"-");







	var max_chance=(data.max_chance?data.max_chance:"-");







	















	var html=__label("Scheme Type",sch_type)







	







	html +=__label("Scheme Code",sch_code); 







	







	html +=  __label("Installments",sch_duration);







	html += __label("Payment Type",pay_type);







	if(pay_type="Multiple")







	{







		html += __label("Payment Chance",max_chance); 







		







	







	}







	







	if(sch_type=='Weight')







	{







		html +=  __label("Min Weight",min_weight); 







		html += __label("Max Weight",max_weight); 







	}







	else







	{







		html += __label("Amount",amount);







	}







	







	html += __label("Interest",interest);







	html += __label("Tax",tax) 	







	







	







	$('#sch_content').html(html);







	







}







//get cus mobile no// hh







if(ctrl_page[1]=='new')



{



    get_schemename();



        $('#mobilenumber').on('keyup',function(){



        var mobile=$('#mobilenumber').val();



        



        if(mobile.length==0){



        $("#id_customer").val('');



        }



        });



}







        if(ctrl_page[1]=='new')



        {



               $("#mobilenumber" ).autocomplete({



                source: function( request, response ) 



                {



                var mobile=$("#mobilenumber").val();



                



                my_Date = new Date();



                $.ajax({



        			  url:base_url+ "index.php/admin_customer/ajax_get_customers_list?nocache=" + my_Date.getUTCSeconds(),



                dataType: "json",



                type: 'POST',



                data:{'mobile':mobile},



                success: function( data ) 



                {



                        var data = JSON.stringify(data);



                        data = JSON.parse(data);



                        var cus_list = new Array(data.length);



                        var i = 0;



                        data.forEach(function (entry) {



                        console.log(entry.mobile);



                        var customer= {



                        label: entry.mobile+'  '+entry.firstname,



                        value:entry.id_customer



                        



                        };



                        cus_list[i] = customer;



                        i++;



                        });



                        response(cus_list);



                }



                });



                },



                minLength: 4,



                delay: 300, 



                	select: function(e, i)



		{



		e.preventDefault();



		$("#mobilenumber" ).val(i.item.label);



		$("#id_customer").val(i.item.value);



		//$("#id_scheme_account").val(i.item.id_scheme_account);



		$('.overlay').css('display','block');



		



		if($('#id_customer').val()!='')



		{



		                var from_date = $('#account_list1').text();



						var to_date  = $('#account_list2').text();



						var id_customer=$('#id_customer').val();	



						var id_branch=$('#id_branch').val();	



						var id_scheme=$('#id_scheme').val();



						get_scheme_acc_list(from_date,to_date,id_branch,id_customer,id_scheme);



		}



	







		},



			response: function(e, i) {



            // ui.content is the array that's about to be sent to the response callback.



            if (i.content.length === 0) {



               alert('Please Enter a valid Number');



               $('#mobilenumber').val('');



            } 



        },



                });



        }



     







//scheme account list not closed







function get_scheme_acc_list(from_date="",to_date="",id_branch ="",id_customer="",id_scheme='')







	{



		



		



	my_Date = new Date();



    var type=$('#date_Select').find(":selected").val();



	 $("div.overlay").css("display", "block"); 



    var join_days=$('#join_day').find(":selected").val();



	







	$.ajax({







			  url:base_url+ "index.php/account/get/ajax_account_list?nocache=" + my_Date.getUTCSeconds(),







			 //data: (from_date !='' && to_date !=''? {'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val(),'id_customer':id_customer,'type':type,'join_days':join_days}: ''),



            data: (from_date !='' && to_date !=''? {'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val(),'id_scheme':$('#id_scheme').val(),'id_customer':id_customer,'type':type,'join_days':join_days}: ''),



			 dataType:"JSON",







			 type:"POST",







			 success:function(data){







			   			set_scheme_acc_list(data);



			   			$('body').addClass("sidebar-collapse");







			   			 $("div.overlay").css("display", "none"); 







					  },







					  error:function(error)  







					  {







						 $("div.overlay").css("display", "none"); 







					  }	 







			      });







}















function set_scheme_acc_list(data)



{



	var account 	= data.data;



	console.log(account);



	var access		= data.access;	



	var close_acc	= 1;



	$('#total_accounts').text(account.length);



	if(access.add == '0')



	{



	$('#add').attr('disabled','disabled');



	}



	var oTable = $('#sch_acc_list').DataTable();



	var id_branch=$("#branch_select option:selected").text();



	oTable.clear().draw();



	if (account!= null && account.length > 0)



	{    



    	var schemeacc_no_set= (typeof data.data == 'undefined' ? '' :data.data[0].schemeacc_no_set);



    	// console.log(schemeacc_no_set);



    	if ((schemeacc_no_set==0 || schemeacc_no_set==2))



    	{ 	



        	oTable = $('#sch_acc_list').dataTable({



        	"bDestroy": true,



        	"bInfo": true,



        	"bFilter": true,



        	"bSort": true,



        	"order": [[ 0, "desc" ]],



        	"dom": 'lBfrtip',



        	"buttons" : ['excel','print'],



        	"tableTools": { "buttons": [ { "sExtends": "xls", "oSelectorOpts": { page: 'current' } },{ "sExtends": "pdf", "oSelectorOpts": { page: 'current' } } ] },



        	"aaData": account,



        	"order": [[ 0, "desc" ]],



        	"aoColumns": [



        	{ "mDataProp": function ( row, type, val, meta ) {



        	var url = base_url+'index.php/reports/payment/account/'+row.id_scheme_account;



        	action = '<a href="'+url+'" target="_blank">'+row.id_scheme_account+'</a>';



        	return action;



        	}



        	},



        	{ "mDataProp": "id_customer" },



        	{ "mDataProp": "name" },



        	{ "mDataProp": "mobile" },



        	{ "mDataProp": "branch_name" },



        	{ "mDataProp": "account_name" },



        	{ "mDataProp": function ( row, type, val, meta ){



            	    return row.code;



            	}



        	},







         { "mDataProp": function ( row, type, val, meta ){

	                	if(row.is_lucky_draw == 1){

	                	    return row.scheme_group_code+' '+row.scheme_acc_number;

	                	}

	                	else{ 

    	                	if(row.schemeaccNo_displayFrmt == 0){   //only acc num
	                        
	                            return row.scheme_acc_number;
	                        
    	                    }else if(row.schemeaccNo_displayFrmt == 1){ //based on acc number generation setting
    	                        
    	                        if(row.scheme_wise_acc_no==0){
        							return row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==1){
        							return row.acc_branch+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==2){
        							return row.code+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==3){
        							return row.code+''+row.acc_branch+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==4){
        							return row.start_year+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==5){
        							return row.start_year+''+row.code+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==6){
        							return row.start_year+''+row.code+''+row.acc_branch+'-'+row.scheme_acc_number;
        						}
    	                    }else if(row.schemeaccNo_displayFrmt == 2){  //customised
    	                        return row.scheme_acc_number;
    	                    }

	                	}

	                }},




        	{ "mDataProp": "group_code" },



        	{ "mDataProp": "is_new" },



        	{ "mDataProp": function ( row, type, val, meta ){



        	if(row.edit_custom_entry_date==0){



        	return row.start_date;



        	}



        	else{



        	return row.custom_entry_date;



        	}



        	}},



        //	{ "mDataProp": "maturity_days" },



        	{ "mDataProp": "last_paid_date" },



        	{ "mDataProp": "scheme_type" },



        /*	{ "mDataProp": function ( row, type, val, meta ){



        	    



            	amount=row.currency_symbol+" "+row.amount;



            



            	weight="Max "+row.payable+" g/month";



            



            	if(row.scheme_types == 0 || row.scheme_types == 2 || row.scheme_types == 3 && row.flexible_sch_type == 1 || row.flexible_sch_type == 2)



            	{ 



            	    return amount; 



            	}



            	



            	if(row.scheme_types == 1 || row.scheme_types == 3 && row.flexible_sch_type == 3 || row.flexible_sch_type == 4 || row.flexible_sch_type == 5)



            	{



            	    return weight; 



            	}   



        



        	  }



        	    



        	},   */



        	



        	{ "mDataProp": function ( row, type, val, meta )

			{



        	    



        	    



            	amount=row.currency_symbol+" "+inr_format.format(row.max_amount);



            



            	weight="Max "+row.max_weight+" g/month";



            



                if(row.scheme_types == 2){



            	    return row.currency_symbol+" "+inr_format.format(row.amount);



            	}



            	



            	if(row.scheme_types == 0){



            	    return row.currency_symbol+" "+inr_format.format(row.payable);



            	}



                



            	// if(row.scheme_types == 2 || row.scheme_types == 3 && row.flexible_sch_type == 1 || row.flexible_sch_type == 2)



            	// { 



            	//     return amount; 



            	// }

				// if(row.scheme_types==2)

				// {

				// 	return amount;

				// }

				if(row.scheme_types == 3 && (row.flexible_sch_type == 1 || row.flexible_sch_type == 2))

				{

					

					if((row.firstPayamt_as_payamt==1 || row.firstPayamt_maxpayable==1) && row.firstPayment_amt!='' && row.firstPayment_amt!=null)

					{

						

						return row.currency_symbol+" "+inr_format.format(row.firstPayment_amt);

					}

					else

					{

						return "Max : "+row.currency_symbol+" "+inr_format.format(row.max_amount);

					}

					

				}

            	if(row.scheme_types == 3 && (row.flexible_sch_type == 6 || row.flexible_sch_type == 7))
				{
					return 'Partly Flexible';
				}



            	if(row.scheme_types == 1 || row.scheme_types == 3 && row.flexible_sch_type == 3 || row.flexible_sch_type == 4 || row.flexible_sch_type == 5)



            	{



            	    return weight; 



            	}   



        



        	  }



        	    



        	},



        	



        



        	{ "mDataProp": "pan_no" },



        



        	//{ "mDataProp":"paid_installments"},



        	



        	{ "mDataProp": function ( row, type, val, meta ){



					                



				if(row.show_ins_type == 1){



                    return row.paid_installments+"/"+row.total_installments;



                }else{



                    return row.paid_installments;



                }



					                



			}},



        



        //	{ "mDataProp":"gift_article"},



            



            { "mDataProp": function ( row, type, val, meta ){



				if(row.gift_article!=null && row.gift_article!='')



				{



					return row.gift_article;



				}



				else



				{



					return '-';



				}



			}},



       



        	{ "mDataProp": function ( row, type, val, meta ){



        	active_url =base_url+"index.php/account/status/"+(row.active=='Active'?0:1)+"/"+row.id_scheme_account; 



        	return "<a href='"+active_url+"'><i class='fa "+(row.active=='Active'?'fa-check':'fa-remove')+"' style='color:"+(row.active=='Active'?'green':'red')+"'></i></a>"



        	}



        	},



        	



    //DGS-DCNM...



    	



    	{ "mDataProp": function ( row, type, val, meta ){



					wallet_url = base_url+"index.php/admin_manage/chit_detail_report/"+row.id_scheme_account ; 



				



					if(row.show_wallet > 0 && row.scheme_acc_number != 'Not Allocated'){



						return '<button type="button" class="btn btn-default" data-href="#" data-toggle="modal" data-target="#chit_wallet_screen" onclick="set_chit_wallet_screen('+row.id_scheme_account+')">DIGI WALLET</button>';



					}else{



						return '-';



					}



				}



        	},



//DGS-DCNM...



        	{ "mDataProp": function ( row, type, val, meta ) {



        



								return (row.added_by=='0'?"Web":(row.added_by=='1'?"Admin":(row.added_by=='2'?"Mobile":(row.added_by=='3'?"Admin App":(row.added_by=='4'?"Retail":(row.added_by=='5'?"Sync":(row.added_by=='6'?"Import":"-")))))));



        	}},



        



        	{ "mDataProp": function ( row, type, val, meta ){



        



        	if( row.one_time_premium ==1 && row.firstPayment_amt > 0 && row.otp_price_fix_type == 1 && row.fixed_metal_rate==null){



        	return '<button type="button"  class="btn btn-primary" style="padding: 4px; margin-bottom: -14px;" onClick="otp_model(' + row.id_scheme_account  + ',' + row.mobile +')">Fix Rate</button>';



        	}



        	if( row.fixed_metal_rate!= null){



        



        	return ' Rate Fixed ';



        	}



        	else{



        	return ' - '



        	}



        	}},



            { "mDataProp": function ( row, type, val, meta ) {



                if(row.fixed_wgt > 0){



        	        return row.fixed_wgt;}



        	        else{



        	            return '-';



        	        }



        	   



        	}},



        	{ "mDataProp":"emp_name"},



        	{ "mDataProp":"referal_code"},



        	{ "mDataProp": function ( row, type, val, meta ) {



        	    if(row.agent_code != null){



        	        return row.agent_name+"  "+row.agent_code;



        	    }else{



        	        return '-';



        	    }



        	}},



        	{ "mDataProp": function ( row, type, val, meta ) {



        	id= row.id_scheme_account;



        



        	close_url='';



        	



			print_url=base_url+'index.php/admin_manage/receipt_account/'+id;//15-12-2022(customer detail but)











        	// 09-12-2022 print pass book back start



			print_passbook_url=base_url+'index.php/admin_manage/passbook_print/B/'+id;



			print_passbook_btn='<li><a href="'+print_passbook_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i> Print Passbook</a></li>';



										



        	scheme_receipt_url=(row.one_time_premium==1 && row.otp_price_fix_type == 1 ? base_url+'index.php/admin_manage/get_scheme_receipt/'+id :'#');



        	edit_url=(access.edit=='1' ? base_url+'index.php/account/edit/'+id : '#' );



        	close_url=(close_acc=='1'&& row.paid_installments>=1? (row.one_time_premium==1 && row.otp_price_fix_type == 1 && row.fixed_metal_rate==null ? '#' :base_url+'index.php/account/close/scheme/'+id) :'#' );



        	delete_url=(access.delete=='1' ? base_url+'index.php/account/delete/'+id : '#' );



        	delete_confirm= (access.delete=='1' ?'#confirm-delete':'');



        	action_content='<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu">'+



        	'<li><a href="'+edit_url+'" class="btn-edit"><i class="fa fa-edit" ></i> Edit</a></li>'+



        	



        	'<li>'+(access.allow_acc_closing==1 ? ((row.one_time_premium==1 && row.otp_price_fix_type == 1 && row.fixed_metal_rate==null)?'<a class="rate_fix_warning"><i class="fa fa-close" ></i> Close</a>' :'<a href="'+close_url+'" class="btn-edit"><i class="fa fa-close" ></i> Close</a>') :'')+'</li>'+



			       	



            



            (row.one_time_premium==1 && row.otp_price_fix_type == 1 && row.paid_installments>0 ? '<li><a href="'+scheme_receipt_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i> Print</a></li>' :'')+



            



        	'<li><a href="'+print_passbook_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i>Passbook Print</a></li>'+



			



        	//'<li><a href="#" class="btn-del" data-href="'+delete_url+'" data-toggle="modal" data-target="'+delete_confirm+'"  ><i class="fa fa-trash"></i> Delete</a></li>''; old code 15-12-2022



        	  



			//New code



			



			 '<li><a href="#" class="btn-del" data-href="'+delete_url+'" data-toggle="modal" data-target="'+delete_confirm+'"  ><i class="fa fa-trash"></i> Delete</a></li>' +'<li><a href="'+print_url+'"><i class="fa fa-print"></i> RC Print</a></li>';



        	  



        	return action_content;



        	}



        



        	}] 



        	});			  	 	



	    }







	else



	{



    	oTable = $('#sch_acc_list').dataTable({



    	"bDestroy": true,



    	"bInfo": true,



    	"bFilter": true,



    	"bSort": true,



    	"order": [[ 1, "desc" ]],



    



    	'columnDefs': [{



    	'targets': 0,



    	'searchable':false,



    	'orderable':false,



    	"bSort": true,



    	'className': 'dt-body-center',



    	}],



    	"dom": 'lBfrtip',



    	"buttons" : ['excel','print'],



    	"tableTools": { "buttons": [ { "sExtends": "xls", "oSelectorOpts": { page: 'current' } },{ "sExtends": "pdf", "oSelectorOpts": { page: 'current' } } ] },



    	"aaData": account,



    	"aoColumns": [								



    	{ "mDataProp": function ( row, type, val, meta ) {



    	if((row.scheme_acc_number=='Not Allocated' && row.paid_installments==1 && row.schemeacc_no_set==1)){ 



    



    	return '<input type="checkbox" id="select_ids_'+row.id_scheme_account+'" class="select_ids"  value="'+row.id_scheme_account+'">';	



    	}else{



    



    	return '<input type="hidden" id="select_ids_'+row.id_scheme_account+'" class="select_ids" disabled="true" value="'+row.id_scheme_account+'">';	 



    	}



    	}



    	},						



    



    	{ "mDataProp": function ( row, type, val, meta ) {



    	var url = base_url+'index.php/reports/payment/account/'+row.id_scheme_account;



    	action = '<a href="'+url+'" target="_blank">'+row.id_scheme_account+'</a>';



    	return action;



    	}



    	},



    	{ "mDataProp": "id_customer" },



    	{ "mDataProp": "name" },



    	{ "mDataProp": "mobile" },



    	{ "mDataProp": "branch_name" },



    	{ "mDataProp": "account_name" },



    



    	{ "mDataProp": "code" },







    



    



    { "mDataProp": function ( row, type, val, meta )
			{

			

				if((row.scheme_acc_number=='Not Allocated' && row.paid_installments==1 && row.schemeacc_no_set==1))
				{ 

			

				return '<input  type="number"  id="id_schemeaccount" class="schemeaccount"  disabled="true" value="">';	

				}
				else

				{
					

	                	if(row.is_lucky_draw == 1){

	                	    return row.scheme_group_code+' '+row.scheme_acc_number;

	                	}

	                	else{ 

    	                	if(row.schemeaccNo_displayFrmt == 0){   //only acc num
	                        
	                            return row.scheme_acc_number;
	                        
    	                    }else if(row.schemeaccNo_displayFrmt == 1){ //based on acc number generation setting
    	                        
    	                        if(row.scheme_wise_acc_no==0){
        							return row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==1){
        							return row.acc_branch+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==2){
        							return row.code+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==3){
        							return row.code+''+row.acc_branch+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==4){
        							return row.start_year+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==5){
        							return row.start_year+''+row.code+'-'+row.scheme_acc_number;
        						}else if(row.scheme_wise_acc_no==6){
        							return row.start_year+''+row.code+''+row.acc_branch+'-'+row.scheme_acc_number;
        						}
    	                    }else if(row.schemeaccNo_displayFrmt == 2){  //customised
    	                        return row.scheme_acc_number;
    	                    }

	                	}


				}

			} 

    

    	},



    	{ "mDataProp": "group_code" },



    	{ "mDataProp": "is_new" },



    	{ "mDataProp": function ( row, type, val, meta ){



    	if(row.edit_custom_entry_date==0){



    	return row.start_date;



    	}



    	else{



    	return row.custom_entry_date;



    	}



    	}},



    //	{ "mDataProp": "maturity_days" },



        	{ "mDataProp": "last_paid_date" },



    	{ "mDataProp": "scheme_type" },							



    



    	/*{ "mDataProp": function ( row, type, val, meta ){



    



    	amount=row.currency_symbol+" "+row.amount;



    



    	weight="Max "+row.amount+" g/month";



    



    	if(row.scheme_types == '0')



    



    	{



    



    	return amount;



    



    	}



    



    	else if(row.scheme_types == '1')



    



    	{



    



    	return weight;



    



    	}



    



    	else if(row.scheme_types == '3')



    



    	{



    



    	return amount;



    



    	}



    	else if(row.scheme_types=='2')



    	{



    	return amount;



    	}



    	else(row.scheme_types=='')



    



    	}



    



    	},*/

		{ "mDataProp": function ( row, type, val, meta )

			{



        	    



        	    



            	amount=row.currency_symbol+" "+inr_format.format(row.max_amount);



            



            	weight="Max "+row.max_weight+" g/month";



            



                if(row.scheme_types == 2){



            	    return row.currency_symbol+" "+inr_format.format(row.amount);



            	}



            	



            	if(row.scheme_types == 0){



            	    return row.currency_symbol+" "+inr_format.format(row.payable);



            	}



                



            	// if(row.scheme_types == 2 || row.scheme_types == 3 && row.flexible_sch_type == 1 || row.flexible_sch_type == 2)



            	// { 



            	//     return amount; 



            	// }

				// if(row.scheme_types==2)

				// {

				// 	return amount;

				// }

				if(row.scheme_types == 3 && (row.flexible_sch_type == 1 || row.flexible_sch_type == 2))

				{

					

					if((row.firstPayamt_as_payamt==1 || row.firstPayamt_maxpayable==1 )&& row.firstPayment_amt!='' && row.firstPayment_amt!=null)

					{

						

						return row.currency_symbol+" "+inr_format.format(row.firstPayment_amt);

					}

					else

					{

						return "Max : "+row.currency_symbol+" "+inr_format.format(row.max_amount);

					}

					

				}
				if(row.scheme_types == 3 && (row.flexible_sch_type == 6 || row.flexible_sch_type == 7))
				{
					return 'Partly Flexible';
				}
            	



            	if(row.scheme_types == 1 || row.scheme_types == 3 && row.flexible_sch_type == 3 || row.flexible_sch_type == 4 || row.flexible_sch_type == 5)



            	{



            	    return weight; 



            	}   



        



        	  }



        	    



        	},



        	



    



    	{ "mDataProp": "pan_no" },



    



    	{ "mDataProp":"paid_installments"},



    



    //	{ "mDataProp":"gift_article"},



    



    { "mDataProp": function ( row, type, val, meta ){



				if(row.gift_article!=null && row.gift_article!='')



				{



					return row.gift_article;



				}



				else



				{



					return '-';



				}



			}},











    	{ "mDataProp": function ( row, type, val, meta ){



    	active_url =base_url+"index.php/account/status/"+(row.active=='Active'?0:1)+"/"+row.id_scheme_account; 



    	return "<a href='"+active_url+"'><i class='fa "+(row.active=='Active'?'fa-check':'fa-remove')+"' style='color:"+(row.active=='Active'?'green':'red')+"'></i></a>"



    	}



    	},



    	



    	//DGS-DCNM...



    	



    	{ "mDataProp": function ( row, type, val, meta ){



					wallet_url = base_url+"index.php/admin_manage/chit_detail_report/"+row.id_scheme_account ; 



				



					if(row.show_wallet > 0 && row.scheme_acc_number != 'Not Allocated'){



						return '<button type="button" class="btn btn-default" data-href="#" data-toggle="modal" data-target="#chit_wallet_screen" onclick="set_chit_wallet_screen('+row.id_scheme_account+')">DIGI WALLET</button>';



					}else{



						return '-';



					}



				}



        	},



//DGS-DCNM...



    



    	{ "mDataProp": function ( row, type, val, meta ) {



    



								return (row.added_by=='0'?"Web":(row.added_by=='1'?"Admin":(row.added_by=='2'?"Mobile":(row.added_by=='3'?"Admin App":(row.added_by=='4'?"Retail":(row.added_by=='5'?"Sync":(row.added_by=='6'?"Import":"-")))))));



    	}},



    



    	{ "mDataProp": function ( row, type, val, meta ){



    



    	if( row.one_time_premium ==1 && row.firstPayment_amt > 0 && row.otp_price_fix_type == 1 && row.fixed_metal_rate== null){



    	return '<button type="button"  class="btn btn-primary" style="padding: 4px; margin-bottom: -14px;" onClick="otp_model(' + row.id_scheme_account  + ',' + row.mobile +')">Fix Rate</button>';



    	}



    	if( row.fixed_metal_rate!= null){



    



    	return ' Rate Fixed ';



    	}



    	else{



    	return ' - '



    	}



    



    	}},



    	



    	{ "mDataProp": function ( row, type, val, meta ) {



                if(row.fixed_wgt > 0){



        	        return row.fixed_wgt;}



        	        else{



        	            return '-';



        	        }



        	   



        	}},



        	{ "mDataProp":"emp_name"},



        { "mDataProp":"referal_code"},



    	{ "mDataProp": function ( row, type, val, meta ) {



    	id= row.id_scheme_account;



    



    	close_url='';



    	scheme_receipt_url=(row.one_time_premium==1 && row.otp_price_fix_type == 1 && row.fixed_metal_rate!=null ? base_url+'index.php/admin_manage/get_scheme_receipt/'+id :'#');



    	edit_url=(access.edit=='1' ? base_url+'index.php/account/edit/'+id : '#' );



    	close_url=(close_acc=='1'&& row.paid_installments>=1? (row.one_time_premium==1 && row.otp_price_fix_type == 1 && row.fixed_metal_rate==null ? '#' :base_url+'index.php/account/close/scheme/'+id) :'#' );



    	delete_url=(access.delete=='1' ? base_url+'index.php/account/delete/'+id : '#' );



    	delete_confirm= (access.delete=='1' ?'#confirm-delete':'');



    	action_content='<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu">'+



    	'<li><a href="'+edit_url+'" class="btn-edit"><i class="fa fa-edit" ></i> Edit</a></li>'+



    



    	'<li><a href="'+edit_url+'" class="btn-edit"><i class="fa fa-edit" ></i> Edit</a></li>'+(access.allow_acc_closing==1 ? '<li><a href="'+close_url+'" class="btn-edit"><i class="fa fa-close" ></i> Close</a></li>' :'')+



    	 (row.one_time_premium==1 && row.otp_price_fix_type == 1 && row.fixed_metal_rate!=null ? '<li><a href="'+scheme_receipt_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i> Print</a></li>' :'')+



    	'<li><a href="#" class="btn-del" data-href="'+delete_url+'" data-toggle="modal" data-target="'+delete_confirm+'"  ><i class="fa fa-trash"></i> Delete</a></li>';



    	  



    	return action_content;



    	}



    



    	}] 



    	});			  	 	



    	} 



	}	



}











// scheme account number  manual



  var selectdatas =[];



 



$(document).on('click', '#select_aldata', function(e){



	



	 if($(this).prop("checked") == true){



		 



                $("tbody tr td input[type='checkbox']").prop('checked',true);



				$(".schemeaccount").attr('disabled', false);



            }



            else if($(this).prop("checked") == false)



			{



               



				$(".schemeaccount").val('');



				$(".schemeaccount").attr('disabled', true);



				$("tbody tr td input[type='checkbox']").prop('checked', false);



            }



	



 



});







$(document).on('click', '.select_ids', function(e){



	



 $("#sch_acc_list tbody tr").each(function(index, value) 



	{



			 if(!$(value).find(".select_ids").is(":checked"))



			 { 



				$(value).find(".schemeaccount").empty();			



				$(value).find(".schemeaccount").attr('disabled', true);



				$(value).find(".schemeaccount").val('');



			}



			else if($(value).find(".select_ids").is(":checked"))



			 { 



				$(value).find(".schemeaccount").attr('disabled', false);



			}



		







      });



});







 var selected = [];



 



$(document).on('click', '.conform_sch', function(e){



	



	



   $("#sch_acc_list tbody tr").each(function(index, value) 



	{



			 if(!$(value).find(".select_ids").is(":checked"))



			 { 



				$(value).find(".schemeaccount").empty();			



				$(value).find(".schemeaccount").attr('disabled', true);



			 }



		    else if(($(value).find(".select_ids").is(":checked") && $(value).find(".schemeaccount").val()!=''



			)){



				$("#conform_save").attr('disabled', true);



				  $(value).find(".schemeaccount").attr('disabled', false);



				  



				   var id_scheme_account=$(value).find(".select_ids").val();



				   var scheme_acc_number=$(value).find(".schemeaccount").val();



				   



				   var data = {'id_scheme_account':id_scheme_account, 'scheme_acc_number':scheme_acc_number}; 



				  // var sech = JSON.stringify(data);



				selected.push(data);	



					



			}



		else{



		  



		  msg='<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert">&times;</a><strong>Warning!</strong>Select to proceed</div>';



				



				$("div.overlay").css("display", "none"); 



				        



				        //stop the form from submitting



				         $('#error-msg').html(msg);



		return false;



		  



	  }



		







      });



	  



	  if(selected.length>0){



	  



		$("div.overlay").css("display", "block"); 







		$.ajax({







			  url:base_url+ "index.php/schemeaccount/update",







			  data:{'selected':selected},







			 dataType:"JSON",







			 type:"POST",







			 success:function(data){







			   			 $("div.overlay").css("display", "none"); 



						  location.reload(true);







					  },







					  error:function(error)  







					  {







						 $("div.overlay").css("display", "none"); 







					  }	 







			      });



	  }



	   else{



		  



		  msg='<div class = "alert alert-danger"><a href = "#" class = "close" data-dismiss = "alert">&times;</a><strong>Warning!</strong>Select to proceed</div>';



				



				$("div.overlay").css("display", "none"); 



				        



				        //stop the form from submitting



				         $('#error-msg').html(msg);



		return false;



		  



	  } 



	  



	  



	 });



































//closed scheme account list 







function get_closed_acc_list(from_date="",to_date="",id_branch="",id_employee="",close_id_branch="")







{



     //alert(HH);



     



	//$('body').addClass("sidebar-collapse");







	my_Date = new Date();







		 $("div.overlay").css("display", "block"); 







	$.ajax({







			  url:base_url+ "index.php/account/get/ajax_closed_acc_list?nocache=" + my_Date.getUTCSeconds(),







			// data: (from_date !='' && to_date !=''? {'from_date':from_date,'to_date':to_date,'id_branch':id_branch}: ''),



			   data: (from_date !='' && to_date !=''? {'from_date':from_date,'to_date':to_date,'id_branch':id_branch,'id_employee':id_employee,'close_id_branch':close_id_branch}: ''),







			 dataType:"JSON",







			 type:"POST",







			 success:function(data){



			 console.log(data);







			   			set_closed_acc_list(data);







			   				 $("div.overlay").css("display", "none"); 







					  },







					  error:function(error)  







					  {







						 $("div.overlay").css("display", "none"); 







					  }	 







			      });







}















/*-- Coded by ARVK --*/















function set_closed_acc_list(data)







{







	 var account 	= data.data;







	 var access		= data.access;	







	 var close_acc	= data.close_acc;



	 



	 var is_utilized	= data.is_utilized;







	







	 $('#total_closed_accounts').text(account.length);







	 var oTable = $('#closed_list').DataTable();



	 var from_date = $('#closed_list1').text();



	 var to_date  = $('#closed_list2').text();







	     oTable.clear().draw();







			  	 if (account!= null && account.length > 0)







			  	  {  	







					  	oTable = $('#closed_list').dataTable({







				                "bDestroy": true,







				                "bInfo": true,







				                "bFilter": true,







				                "bSort": true,



				                



                                "dom": 'lBfrtip',



                                



           			            "buttons" : ['excel','print'],



           			            



           			          "tableTools": { "buttons": [ { "sExtends": "xls", "oSelectorOpts": { page: 'current' } },{ "sExtends": "pdf", "oSelectorOpts": { page: 'current' } } ] },







           			             



				                "aaData": account,







				                "order": [[ 0, "desc" ]],







				                "aoColumns": [



				                    



				                    { "mDataProp": function ( row, type, val, meta ){



					                	var chit_url = base_url+'index.php/reports/payment/account/'+row.id_scheme_account;



					                	action = '<a href="'+chit_url+'" target="_blank">'+row.id_scheme_account+'</a>';



					                	return action;



					                }},



				                    







					                { "mDataProp": "name" },







					                { "mDataProp": "mobile" },







					                { "mDataProp": "account_name" },







					                







									 { "mDataProp": function ( row, type, val, meta )
									 {
										if(row.scheme_wise_acc_no==3)
										{
											return row.scheme_acc_number;
										}
										else
										{
											if(row.has_lucky_draw==1){

												return row.scheme_group_code+' '+row.scheme_acc_number;
		
												}
		
												else{
		
													return row.code+'  '+row.scheme_acc_number;
		
												}
										}
					                	

					                }},







					                { "mDataProp": "code" },







					                { "mDataProp": "start_date" },







					                { "mDataProp": "scheme_type" },







									{ "mDataProp": "amount" },







								



									



								







									/*{ "mDataProp": function ( row, type, val, meta ){







										 cls_amt= row.closing_balance;







										 cls_wt= row.closing_weight+" g";







					                	   return (row.scheme_type == 'Amount' ? cls_amt :cls_wt);







					                	   }







					                },*/



                                    { "mDataProp": "employee_closed" },



                                    { "mDataProp": "branchname" },



                                    { "mDataProp": "Closing_id_branch" },



					                { "mDataProp": "closing_date" },



					            //    { "mDataProp": "pay_amount" },



					                { "mDataProp": function ( row, type, val, meta ){



					                



					                    	if(row.show_ins_type == 1){



                                				return row.paid_installments+"/"+row.total_installments;



                                			}else{



                                				return row.paid_installments;



                                			}







					                



					                }},



					                { "mDataProp": function ( row, type, val, meta ){



					                		if(row.paid_installments!=row.total_installments)



					                		{



					                		    var bonus_deduction=parseFloat(row.paid_installments)*parseFloat(row.firstPayDisc_value);



					                		    return parseFloat(row.pay_amount)-parseFloat(bonus_deduction);



					                		}else{



					                		    return row.pay_amount;



					                		}



					                }},



					                



					                 { "mDataProp": "closing_amount" },



					                  { "mDataProp": "closing_weight" },



					                  	{ "mDataProp": "closing_balance" },



                                    



                                   /*  { "mDataProp": function ( row, type, val, meta ){



					                	if(row.scheme_type=='Weight'){



					                	return row.closing_balance+' '+'g';



					                	}



					                	else{



											//console.log(row);



										



					                		return (row.scheme_type=='Amount'?'':'')+' '+row.closing_balance;



					                	}



					                }}, */



					                



					                /*{ "mDataProp": function ( row, type, val, meta ){



					                    



					                    if(row.closing_benefits != undefined && row.closing_benefits != null && row.closing_benefits != '' && row.closing_benefits != 0){



					                        if(row.sch_type == 0 || row.sch_type == 3 && row.flexible_scheme_type == 1){



					                            return 'INR '+ row.closing_benefits+'<br> <span style="color:green;font-weight:bold;">'+ row.closing_interest_val+'</span>' ;



					                        }else{



					                            return row.closing_benefits+' g <br><span style="color:green;font-weight:bold;">'+ row.closing_interest_val +'</span>' ;



					                        }



					                        



					                    }else{



					                        return '-';



					                    }



					                }},*/



					                



					                	{ "mDataProp": function ( row, type, val, meta ){



										if(row.additional_benefits!='' && row.additional_benefits!=null)



										{



											return row.additional_benefits;



										}



										else



										{



											return '-';



										}



									}},



					                



					                



					                { "mDataProp": function ( row, type, val, meta ){



					                	



					                    if(row.gift_status == 0 || row.gift_status == 1){



					                	    



					                	    if(row.paid_installments <= row.cus_deduct_ins){



    					                	   	return '<button type="button"  class="btn btn-primary" style="padding: 4px; margin-bottom: -14px;" onClick="update_gift_status(' + row.id_scheme_account +')">Deduct Gift</button>'; 



    					                    }else{



    					                	    return (row.gift_status == 0 ? 'Not issued' : (row.gift_status == 1 ?'Issued' : '-'));



    					                    }



    					                	



					                	}else if(row.gift_status == 2){



					                	    return 'Deducted';



					                	}else{



					                	    return 'No gifts';



					                	}



    					                	



					                }},



                                    



                                    



					                { "mDataProp": function ( row, type, val, meta ){



					                



					                		return row.closing_add_chgs;



					                



					                }},



					                



					                { "mDataProp": function ( row, type, val, meta ){



					                



					                		return (row.discountAmt * row.paid_installments);



					                



					                }},







					                { "mDataProp": function ( row, type, val, meta ) {







					                	 id= row.id_scheme_account;



                                          is_utilized =row.is_utilized;



					                	 







										 close_url=(access.edit=='1'? base_url+'index.php/account/revert/'+id :'#' );



										 



										  printbtn='';



										  



										  print_invoice_url = base_url+'index.php/account/close/invoice_his_custom/'+id;



										  	 print_url = base_url+'index.php/account/close/scheme_history/'+id;



	                                        printbtn='<li><a href="'+print_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i> Print</a></li>';







					                	 revert_confirm= ('#confirm-revert');



                                                console.log(row);



					                	     if(row.is_utilized=='1'){



					                	         action_content='<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu">'+







					                	 







											'<li><a href="#" class="closed_ac_detail" data-href="#" data-toggle="modal" data-id="'+id+'" data-target="#closed_acc_detail"><i class="fa fa-list-alt"></i> Details</a></li>'+







											







											'<li><a href="#" class="btn-del confirm-revert" data-href="'+close_url+'" data-toggle="modal" data-target="'+revert_confirm+'"  ><i class="fa fa-backward"></i> Revert</a></li>'+



											



											'<li><a href="'+print_url+'" target="_blank" class="btn-edit"><i class="fa fa-search-plus" ></i> Print</a></li>' +



											'<li><a href="'+print_invoice_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i> Close Invoice</a></li>';







													  







					                	return action_content;



					                	     }







					                	 action_content='<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu">'+







					                	 







											'<li><a href="#" class="closed_ac_detail" data-href="#" data-toggle="modal" data-id="'+id+'" data-target="#closed_acc_detail"><i class="fa fa-list-alt"></i> Details</a></li>'+







											







											'<li><a href="#" class="btn-del confirm-revert" data-href="'+close_url+'" data-toggle="modal" data-target="'+revert_confirm+'"  ><i class="fa fa-backward"></i> Revert</a></li>'+



											



											'<li><a href="'+print_url+'" target="_blank" class="btn-edit"><i class="fa fa-search-plus" ></i> Print</a></li>' ;



											//'<li><a href="'+print_invoice_url+'" target="_blank" class="btn-print"><i class="fa fa-print" ></i> Close Invoice</a></li>';







													  







					                	return action_content;







					                	}







					                







					            }] 







				            });			  	 	







					  	 }	







}























function close_acc_otp()







{







					//console.log($("input[name='account[closed_by]']:checked").val());







					 $("div.overlay").css("display", "block");



					 



					 var acc_num = $('#scheme_acc_no').val();







					if($("input[name='account[closed_by]']:checked").val()==0)







					{







						var mobile = $.trim($("#mobile").val());







						var email = $.trim($("#email").val());



						



						var id_customer = $.trim($("#id_customer").val());







						var name = $("#firstname").val();







					}







					else







					{







						var mobile = $.trim($("#nominee_mobile").val());







						var email = $.trim($("#email").val());



						



						var id_customer = $.trim($("#id_customer").val());







						var name = $("#nominee_name").val();







					}







					







						var otp={







							id_sch_acc:$("input[name='account[id_scheme_account]']").val(),







							id_emp:$("input[name='account[employee_closed]']").val(),







							send_resend:($("#send_otp").val()=='Send OTP'?'0':'1'),



							



							acc_num: $('#scheme_acc_no').val()







							







						}







				  		







				  		console.log(otp);







				  		







					$.ajax({















					   url:base_url+"index.php/account/close/otp/"+mobile+"/"+id_customer+"/"+name,







					   type : "POST",







					   data : otp,







					   dataType:'json',







					   success : function(result) {	















						  if(result.result == 1)















						  {		







						  		$('#otp_status').fadeIn();







						  		$("#otp_status").text("OTP Sent Successfully, Kindly verify it by entering in the above Text box.");







						  		$("#otp_status").css("color", 'green');







						  		$("div.overlay").css("display", "none");







						  		$('#otp_status').delay(10000).fadeOut(500);







								







						  }







					   },















					   error : function(error){















						   $("div.overlay").css("display", "none");















						   console.log(error);















					   }















					});







}















function verify_close_acc_otp()







{







					$("div.overlay").css("display", "block");







					







					if($("#otp").val().length==6)







					{







						







						var id_sch_acc = $("input[name='account[id_scheme_account]']").val();







						var otp_entered = $("#otp").val();







						







						//console.log(id_sch_acc);







						$.ajax({















						   	url:base_url+"index.php/account/fetch/otp/"+id_sch_acc+"/"+otp_entered,







						   	type : "POST",







						   	dataType:'json',







					   		success : function(result) {	















								if(result == 1)







								{		







							  		//console.log('success');







							  		$("#close_save").prop('disabled', false);



							  		$("#close_save_print").prop('disabled', false);







							  		$("#otp").prop('disabled','disabled');







							  		$("input[name='account[closedBy]']").val($("input[name='account[closed_by]']:checked").val());







							  		$("input[name='account[closed_by]']").prop('disabled','disabled');







							  		$("#send_otp").hide();







							  		$('#otp_status').fadeIn();







									$("#otp_status").text("OTP verified successfully, Kindly proceed with scheme closing.");







									$("#otp_status").css("color", 'green');







									$("div.overlay").css("display", "none");







                                     $("#close_actionBtns").css("display", "block");   // closed valide hh//



									//$('#otp_status').delay(10000).fadeOut(500);







							  	}







							  	else







							  	{







									$("#verify_otp").prop('disabled',false);







									$("#close_save").prop('disabled','disabled');



									



									$("#close_save_print").prop('disabled','disabled');







							  		$('#otp_status').fadeIn();







									$("#otp_status").text("Incorrect OTP, Kindly enter the correct one.");







									$("#otp_status").css("color", 'red');







									$("div.overlay").css("display", "none");







									$('#otp_status').delay(10000).fadeOut(500);







								}







						   	},















						   	error : function(error){















								$("div.overlay").css("display", "none");















								console.log(error);















						   }















						});







												







						







					}







					else







					{







						$("#verify_otp").prop('disabled',false);







						$('#otp_status').fadeIn();







						$("#otp_status").text("Kindly enter 6 digit OTP to verify.");







						$("#otp_status").css("color", 'red');







						$("div.overlay").css("display", "none");







						$('#otp_status').delay(5000).fadeOut(500);







						







						console.log('I\'m in else');







					}







					







					







}











 //branch_name



 



 



  //closing branch



$('#close_branch_select').select2().on("change", function(e) {



	



	var from_date = $('#closed_list1').text();



	var to_date  = $('#closed_list2').text();



	var close_id_branch=$(this).val();	



	var id_employee=$('#id_employee').val();



	get_closed_acc_list(from_date,to_date,'',id_employee,close_id_branch);



	



	



});



 



     



 $('#branch_select').select2().on("change", function(e) {       



         



           switch(ctrl_page[1])







			{







				case 'new':



				



					



					if(this.value!='')



					{  



						$("#id_branch").val(this.value)



						var from_date = $('#account_list1').text();



						var to_date  = $('#account_list2').text();



						var id_branch=$(this).val();



						var id_customer=$("#id_customer").val();



						var id_scheme=$('#id_scheme').val();



						get_scheme_acc_list(from_date,to_date,id_branch,id_customer,id_scheme);



					}



					 break;



					 



				case 'scheme_group':



				



					if(this.value!='')



					{  



						$("#id_branch").val(this.value);



					get_group_list(this.value);



					}



					 break;



					  



					 



					/* case 'close':



				



					



					if(this.value!='')



					{  



						



						var from_date = $('#closed_list1').text();



						var to_date  = $('#closed_list2').text();



						var id=$(this).val();						



						get_closed_acc_list(from_date,to_date,id);



					}



					 break;*/



					 



					 case 'close':



				



					



					if(this.value!='')



					{  



					if(ctrl_page[0]=='account'){



					if(ctrl_page[2]=='scheme'){



						



						var branch_select_val=e.target.value;



						var test =	$("#id_branch").val(branch_select_val);



							



					}



						



						



					}}



					if(this.value!=''){



						if(ctrl_page[2]!='scheme'){



					



						$('#emp_select').empty();



						var from_date = $('#closed_list1').text();



						var to_date  = $('#closed_list2').text();



						var id=$(this).val();	



						var close_id_branch=$('#close_id_branch').val();



						var id_employee=$('#id_employee').val();



						get_closed_acc_list(from_date,to_date,id,id_employee,close_id_branch);



						get_employee_name(id);



					}



					}



					



					 break;











				case 'add':



					



				  if(this.value!='')



				  {



					 $("#id_branch").val(this.value);



						 



				  }



					 break;	



			}



		



		  



   });



 



// Existing reg request functions 







function get_request_list(from_date="",to_date="",branch="",status="")



{



	my_Date = new Date();



	postData = (from_date !='' && to_date !='' ? {'from_date':from_date,'to_date':to_date,'status':status}: (branch != ''?  {'id_branch':branch,'status':status}:{'status':$('#filtered_status').val()}));



	 $("div.overlay").css("display", "block"); 



	$.ajax({



			  url:base_url+ "index.php/admin_manage/ajax_requests_list?nocache=" + my_Date.getUTCSeconds(),



			 data: (postData),



			 dataType:"JSON",



			 type:"POST",



			 success:function(data){



			 	$('#total_requests').text(data.requests.length);



			   			set_request_list(data);



			   			 $("div.overlay").css("display", "none"); 



					  },



					  error:function(error)  



					  {



						 $("div.overlay").css("display", "none"); 



					  }	 



		  });



}











function set_request_list(data)



{



	$('body').addClass("sidebar-collapse");



	 var accounts = data.requests;



	 var oTable = $('#scheme_reg_list').DataTable();



	 var schemesOptions ='';



	 var branchOptions ='';



	 var GroupOptions = '';



	  var pan_no='';



	  if(data.requests!=''){



var getExisting_balance=data.requests[0]['getExisting_balance'];



 }



 else{



  var getExisting_balance='';



 }







	 $.each(data.branches, function (key, item) {



	 	branchOptions += '<option value="'+item.id_branch+'">'+item.name+'</option>';	   		



	 });



	 $.each(data.schemes, function (key, item) {



	 	schemesOptions += '<option value="'+item.id_scheme+'">'+item.code+'</option>';	   		



	 });



	 $.each(data.groups, function (key, item) {



        GroupOptions += '<option value="'+item.group_code+'">'+item.group_code+'</option>';	  



     });



	     oTable.clear().draw();



			  	if (accounts!= null && accounts.length > 0 && getExisting_balance==1)



			  	  {  	



					 	oTable = $('#scheme_reg_list').dataTable({



				                "bDestroy": true,



				                "bInfo": true,



				                "bFilter": true,



				                "bSort": true,



				                "order": [[ 0, "desc" ]],



				                 "dom": 'lBfrtip',



           			             "buttons" : ['excel','print'],



						      "tableTools": { "buttons": [ { "sExtends": "xls", "oSelectorOpts": { page: 'current' } },{ "sExtends": "pdf", "oSelectorOpts": { page: 'current' } } ] },







				                "aaData": accounts,



				                "aoColumns": [ { "mDataProp": function ( row, type, val, meta ){ 



		                	chekbox='<input type="checkbox" class="id_reg_request" name="reg_request_id[]" value="'+row.id_reg_request+'"/> ' 



		                	if(row.status == 0){



		                	return chekbox+" "+row.id_reg_request;



		                	}



		                	else{



		                	    return row.id_reg_request;



		                	}



		                }},



					                { "mDataProp": "name" },



					                { "mDataProp": "mobile" },



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                    element = '<select class="id_scheme form-control" name="id_scheme">'+schemesOptions+'</select>';



					                	return element+'<input type="hidden" value="'+row.group_code+'"/>';



					                	



					                }},



					                



                                    { "mDataProp": function ( row, type, val,meta ) { 



                                                       element = '<select class="scheme_group_code form-control" name="scheme_group_code">'+GroupOptions+'</select>';



                                                   	return element ;



                                                   	



                                                   }},



                                    



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="chit_no form-control" name="scheme_acc_number" value="'+row.scheme_acc_number+'" type="text" />';



					                	



					                }},







					                 { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="paid_installments form-control" name="paid_installments" value="'+row.paid_installments+'" type="text" />';



					                	



					                }},







					                 { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="balance_amount form-control" name="balance_amount" value="'+row.balance_amount+'" type="text" />';



					                	



					                }},







					                 { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="last_paid_date form-control" name="last_paid_date" id="last_paid_date" value="'+row.last_paid_date+'"  />';



					                	



					                }},







					                 { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="balance_weight form-control" name="balance_weight" value="'+row.balance_weight+'" type="text" />';



					                	



					                }},







					                 { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="last_paid_weight form-control" name="last_paid_weight" value="'+row.last_paid_weight+'" type="text" />';



					                	



					                }},







					                 { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="last_paid_chances form-control" name="last_paid_chances" value="'+row.last_paid_chances+'" type="text" />';



					                	



					                }},



					                



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="firstPayment_amt form-control" name="firstPayment_amt" value="'+(row.firstPayment_amt ==0.00 ? '':row.firstPayment_amt)+'" type="text" required="'+(row.scheme_type==3 ? "true":'')+'" /><input class="scheme_type form-control" name="scheme_type" value="'+(row.scheme_type)+'" type="hidden" /><input class="firstPayamt_payable form-control" name="firstPayamt_payable" value="'+(row.firstPayamt_payable)+'" type="hidden" />';



					                	



					                }},



					                



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="ac_name form-control" name="ac_name" value="'+row.ac_name+'" type="text" />';



					                	



					                }}, 



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                    element = '<select class="id_branch form-control" name="id_branch">'+branchOptions+'</select>';



					                	return element+'<input type="hidden" class="id_customer" value="'+row.id_customer+'"/><input type="hidden" class="pan_no" value="'+row.pan_no+'"/><input type="hidden" class="mobile" value="'+row.mobile+'"/><input type="hidden" class="email" value="'+row.email+'"/><input type="hidden" class="added_by" value="'+row.added_by+'"/>';



					                	



					                }},



					                { "mDataProp": "date_add" },



					                { "mDataProp": function ( row, type, val, meta ) { 



					                  return (row.status == 0? 'Processing' : (row.status == 1?'Approved':'Rejected'));



					                }},



					                 { "mDataProp": function ( row, type, val, meta ) { 



					                	return '<input class="form-control remark" value="'+row.remark+'" name="remark" type="text" />';



					                }



					                }],



					                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {



										 $('td .id_branch', nRow).val(aData['id_branch']);



										 $('td .id_scheme', nRow).val(aData['id_scheme']);



										 $('td .scheme_group_code', nRow).val(aData['scheme_group_code']);



									}







				            });				  	 	



					  	 }



						else



					  	 {



					  	 	Table = $('#scheme_reg_list').dataTable({



				                "bDestroy": true,



				                "bInfo": true,



				                "bFilter": true,



				                "bSort": true,



				                "order": [[ 0, "desc" ]],



				                 "dom": 'lBfrtip',



           			             "buttons" : ['excel','print'],



						      "tableTools": { "buttons": [ { "sExtends": "xls", "oSelectorOpts": { page: 'current' } },{ "sExtends": "pdf", "oSelectorOpts": { page: 'current' } } ] },







				                "aaData": accounts,



				                "aoColumns": [ { "mDataProp": function ( row, type, val, meta ){ 



		                	chekbox='<input type="checkbox" class="id_reg_request" name="reg_request_id[]" value="'+row.id_reg_request+'"/> ' 



		                	if(row.status == 0){



		                	return chekbox+" "+row.id_reg_request;



		                	}



		                	else{



		                	    return row.id_reg_request;



		                	}



		                }},



					                { "mDataProp": "name" },



					                { "mDataProp": "mobile" },



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                    element = '<select class="id_scheme form-control" name="id_scheme">'+schemesOptions+'</select>';



					                	return element+'<input type="hidden" value="'+row.group_code+'"/>';



					                	



					                }},



					                



                                    { "mDataProp": function ( row, type, val,meta ) { 



                                                       element = '<select class="scheme_group_code form-control" name="scheme_group_code">'+GroupOptions+'</select>';



                                                   	return element ;



                                                   	



                                                   }},



                                    



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="chit_no form-control" name="scheme_acc_number" value="'+row.scheme_acc_number+'" type="text" />';



					                	



					                }},







					                 



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="firstPayment_amt form-control" name="firstPayment_amt" value="'+(row.firstPayment_amt ==0.00 ? '':row.firstPayment_amt)+'" type="text" required="'+(row.scheme_type==3 ? "true":'')+'" /><input class="scheme_type form-control" name="scheme_type" value="'+(row.scheme_type)+'" type="hidden" /><input class="firstPayamt_payable form-control" name="firstPayamt_payable" value="'+(row.firstPayamt_payable)+'" type="hidden" />';



					                	



					                }},



					                



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                   return '<input class="ac_name form-control" name="ac_name" value="'+row.ac_name+'" type="text" />';



					                	



					                }}, 



					                { "mDataProp": function ( row, type, val,meta ) { 	



					                    element = '<select class="id_branch form-control" name="id_branch">'+branchOptions+'</select>';



					                	return element+'<input type="hidden" class="id_customer" value="'+row.id_customer+'"/><input type="hidden" class="pan_no" value="'+row.pan_no+'"/><input type="hidden" class="mobile" value="'+row.mobile+'"/><input type="hidden" class="email" value="'+row.email+'"/><input type="hidden" class="added_by" value="'+row.added_by+'"/>';



					                	



					                }},



					                { "mDataProp": "date_add" },



					                { "mDataProp": function ( row, type, val, meta ) { 



					                  return (row.status == 0? 'Processing' : (row.status == 1?'Approved':'Rejected'));



					                }},



					                 { "mDataProp": function ( row, type, val, meta ) { 



					                	return '<input class="form-control remark" value="'+row.remark+'" name="remark" type="text" />';



					                }



					                }],



					                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {



										 $('td .id_branch', nRow).val(aData['id_branch']);



										 $('td .id_scheme', nRow).val(aData['id_scheme']);



										 $('td .scheme_group_code', nRow).val(aData['scheme_group_code']);



									}







				            });		



					  	 }	



					  	 



}



function update_request_status(status="",data="")



{



	



	my_Date = new Date();



	$("div.overlay").css("display", "block"); 



	$.ajax({



			 url:base_url+ "index.php/admin_manage/update_request?nocache=" + my_Date.getUTCSeconds()+''+my_Date.getUTCMinutes()+''+my_Date.getUTCHours(),



			 data:  {'status':status,'req_data':data},



			 type:"POST",



			 async:false,



			 	  success:function(data){



			            location.reload(false);



			   			$("div.overlay").css("display", "none"); 



				  },



				  error:function(error)  



				  {







				  		console.log(error);



					 $("div.overlay").css("display", "none"); 



				  }	 



		  });



}







function initialize_branch_list(elementID)



{



	



    my_Date = new Date();



	$('.overlay').css('display','block');



	$.ajax({



	  type: 'GET',



	  url:  base_url+'index.php/settings/branches?nocache=' + my_Date.getUTCSeconds(),



	  dataType: 'json',



	   cache:false,



	  success: function(data) {



	      	 $.each(data.branches, function (key, item) {



						   		$('#sync_branch').append(



									$("<option></option>")



									.attr("value", item.id_branch)						  



									  .text(item.name )									  



								);	



						});						



						$("#sync_branch").select2({



						    placeholder: "Branch",



						    allowClear: true



						});



	  	



	  	      $.each(data.branches, function (key, item) {



				$('#'+elementID).append(



					$("<option></option>")



					  .attr("value", item.id_branch)



					  .text(item.name)



					  



				);



				



			});



			



			$("#"+elementID).select2({



			    placeholder: "Select branch",



			    allowClear: true



			});	



				$("#sel_branch").select2("val",'');



			//disable spinner



				$('.overlay').css('display','none');



	  	}



	  });	



}







//get_group_list //hh







function get_group_list(branch="",from_date="",to_date="")



{



	my_Date = new Date();



	postData = (from_date !='' && to_date !='' ? {'from_date':from_date,'to_date':to_date}: (branch != ''? {'id_branch':branch}: ''));



	 $("div.overlay").css("display", "block"); 



	$.ajax({



			  url:base_url+ "index.php/account/ajaxscheme_group/list?nocache=" + my_Date.getUTCSeconds(),



			 data: (postData),



			 dataType:"JSON",



			 type:"POST",



			 success:function(data){ 



					



						



			   			set_group_list(data);



			   			 $("div.overlay").css("display", "none"); 



					  },



					  error:function(error)  



					  {



						 $("div.overlay").css("display", "none"); 



					  }	 



		  });



}



 



// scheme group //  



$('#scheme_select').select2().on("change", function(e) 



{    if(this.value!='')



			{  



				



				$("#id_scheme").val((this).value);



				var from_date = $('#account_list1').text();



				var to_date  = $('#account_list2').text();



				var id_customer=$('#id_customer').val();	



				var id_branch=$('#id_branch').val();	



				var id_scheme=$('#id_scheme').val();



				get_scheme_acc_list(from_date,to_date,id_branch,id_customer,id_scheme);



			}



});











$('#branch_select').select2().on("change", function(e) 



{           if(this.value!='')



			{  



			



				$("#id_branch").val((this).value);



			}



});











$('#employee_select').select2().on("change", function(e) 



{           if(this.value!='')



			{  



			



				$("#id_employee").val((this).value);



			}



});







// scheme group //hh  







function set_group_list(data)



{



	



	



	console.log(data);



	$('body').addClass("sidebar-collapse");	 



	 var accounts = data.requests;



	 var access = data.access;



	 console.log(accounts);



	 var oTable = $('#group_list').DataTable();



	     oTable.clear().draw();



			  	 if (accounts!= null && accounts.length > 0)



			  	  {  	



			  	      $("#total_group").text(accounts.length);



					  	oTable = $('#group_list').dataTable({



				                "bDestroy": true,



				                "bInfo": true,



				                "bFilter": true,



				                "bSort": true,



				                "order": [[ 0, "desc" ]],



				                "aaData": accounts,



				                "aoColumns": [ 



					                { "mDataProp": "id_scheme_group" },



					                { "mDataProp": "scheme_code" },



					                { "mDataProp": "branch_name" },



					                { "mDataProp": "group_code" },



					                { "mDataProp": "start_date" },



					                { "mDataProp": "end_date" },



					              



									{ "mDataProp": function ( row, type, val, meta ) {



					                	 id= row.id_scheme_group;



					                	 edit_url=(access.edit=='1' ? base_url+'index.php/account/scheme_group/edit/'+id : '#' );



										 delete_url=(access.delete=='1' ? base_url+'index.php/account/scheme_group/delete/'+id : '#' );







					                	 delete_confirm= (access.delete=='1' ?'#confirm-delete':'');







					                	 action_content='<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button><ul class="dropdown-menu">'+







											'<li><a href="'+edit_url+'" class="btn-edit"><i class="fa fa-edit" ></i> Edit</a></li>'+







									







											'<li><a href="#" class="btn-del" data-href="'+delete_url+'" data-toggle="modal" data-target="'+delete_confirm+'"  ><i class="fa fa-trash"></i> Delete</a></li>';







													  







					                	return action_content;







									}}		



						         



						],				            });			  	 	



					  	



					  	 



             }



}







//get_group_list







function get_schemename()



{



	



	$(".overlay").css('display','block');



	$.ajax({



		type: 'GET',



		url: base_url+'index.php/get/schemename_list',



		dataType:'json',



		success:function(data){



		console.log(data);



		 //var scheme_val =  $('#id_scheme').val();



		 //console.log( $('#id_schemes').val());



		   $.each(data, function (key, item) {



			  



			   		$('#scheme_select').append(



						$("<option></option>")



						.attr("value", item.id_scheme)						  



						  .text(item.code )



						  



					);			   				



				



			});



			



			$("#scheme_select").select2({



			    placeholder: "Select Scheme name",



			    allowClear: true



			});



				//console.log($('#id_scheme').val());



			 //$("#scheme_select").select2("val",(scheme_val!='' && scheme_val>0?scheme_val:''));



			 console.log($('#id_scheme').val());







			 



			  $("#scheme_select").select2("val", ($('#id_scheme').val()!=null?$('#id_scheme').val():''));







			 $(".overlay").css("display", "none");	



		}



	});



}







function check_groupcode(group_code)



{ 



     



    $("div.overlay").css("display", "block");



    $.ajax({



     type: 'POST',



     data:{'group_code':group_code},



     url:  base_url+'index.php/account/check_group',



     dataType: 'json',



     success: function(avail) {



      // console.log(avail); 



      if(avail==1)



      {



      $('#group_code').val('');



      $("#group").prop('disabled', true);



    $('#group_code').attr('placeholder', 'group code already exists')



    }



    else



    {



        $("#group").prop('disabled',false);



    }



     $("div.overlay").css("display", "none"); 



    },



    error:function(error) {



    $("div.overlay").css("display", "none"); 



    }	 	



    });







}



$('#pan_no').on('change',function(){



			



			if($("#pan_no").val() != ""){



				var regexp = /^[a-zA-Z]{5}\d{4}[a-zA-Z]{1}$/;



				if(!regexp.test($("#pan_no").val()))



		    	{



		    		 $("#pan_no").val("");



		    		 alert("Not a valid PAN No.");



		    		 $("#pan_no").focus();



		    		 $isValidPan = false;	



		    	}



			}else{



				alert("Enter valid PAN No.");



				$isValidPan = false;



			}



			



		});















function get_scheme_acc(mobile)







	{



		



   



   



	my_Date = new Date();







// $("div.overlay").css("display", "block"); 







	







	$.ajax({







			  url:base_url+ "index.php/account/get/ajax_account?nocache=" + my_Date.getUTCSeconds(),







			  data:{'mobile':mobile},







			 dataType:"JSON",







			 type:"POST",







			 success:function(data){







			   			set_scheme_acc_list(data);



			   			$('body').addClass("sidebar-collapse");







			   			 $("div.overlay").css("display", "none"); 







					  },







					  error:function(error)  







					  {







						 $("div.overlay").css("display", "none"); 







					  }	 







			      });







}



//gift issue store db option hh//







$('#verify_issue').click(function(event) {



	 var gifts = $('#gift_issued').val();



	 if(gifts != null && gifts != '')



	 {



			$(this).prop('disabled','disabled');



			verify_gift_issued();	



	 }else{



		 $("#err").html("Select Any Gift");



	 }



    });







function verify_gift_issued()







{



                        $("div.overlay").css("display", "block");



                       var id_sch_acc = $("#id_scheme_account").val();







						var issue_entered = $("#gift_issued").val();







						my_Date = new Date();







				            $.ajax({



                             url:base_url+ "index.php/admin_manage/gift_issue?nocache=" + my_Date.getUTCSeconds(),



						   	



						   	type : "POST",



						   	



						   	 data:{'id_sch_acc':id_sch_acc,'issue_entered':issue_entered},







						   	dataType:'json',







					   		success : function(result) {	



                                       



                                          if(result == 1)



						   {



						       



						       $('#status').fadeIn();



						   	$("#status").text("Gift Issued  Successfully,");



                          	//$("#gift_issued").val('');



							//$("#gift_issued").select2("val",'');	 



						  		$("#status").css("color", 'green');



                          	$('#status').delay(5000).fadeOut(500);



                          		//$("#gift_issued").css("display", 'none');



                          			//$("#gift_issued").prop("required", false);



                          		$("#verify_issue").css("display", 'none');



                          			$("div.overlay").css("display", "none");



						                gift_issued_list(ctrl_page[2]);



						  }



						  



						   	},







						 



	error : function(error){



                               	$("div.overlay").css("display", "none");



                                	console.log(error);







						   }



                          });







}







	$('#calc_blc').on('click',function(){



        	$(".close_actionBtns").css("display", 'block');



        		$("#gift_issued").prop("required", true);



        		  $("#gift_issued").css("display", '');



        $("#verify_issue").css("display", '');



         $("#verify_issue").prop('disabled', false);



    });



    //gift issue store db option hh//







 //gift issued list hh //



function gift_issued_list(id)



{



	



	$("div.overlay").css("display", "block"); 



		var oTable = $('#gift_issued_lists').DataTable();



		$.ajax({



				  type: 'GET',



				  url:  base_url+"index.php/admin_manage/get_gift_issued_list?id_scheme_account="+id,



				 dataType: 'json',



				  success: function(data) {



				     



				    if(data.length > 0 ){



            		    $.each(data, function (key, item) {



            			  



                			  /*if(item.type == 'GIFT'){



        				          $("#show_gifts").css("display", 'none');



        				      }



        				      



        				      if(item.type == 'PRIZE'){



        				          $("#show_prizes").css("display", 'none');



        				      } */



        				      



        				      $("#show_gifts").css("display", 'block');



		                      $("#show_prizes").css("display", 'block');



            			});        



				    }



				      



				      



				        oTable = $('#gift_issued_lists').dataTable({



				                "bDestroy": true,



				                "bInfo": true,



				                "bFilter": true,



				                "bSort": true,



				                "aaData":data,



				                "aoColumns": [



							        { "mDataProp": "id_gift_issued" },



							        { "mDataProp": "type" },



								    { "mDataProp": "gift_desc" },



								     { "mDataProp": "quantity" },



								    { "mDataProp": function ( row, type, val, meta ){



                                        return (row.gift_status == 0 ? 'Not issued' : (row.gift_status == 1 ?'Issued' : (row.gift_status == 2 ? 'Deducted' : '-')));



								    }},



								    { "mDataProp": "id_employee" },



								    { "mDataProp":  "date_issued"}



				                ]



					            });



					                



					    $("div.overlay").css("display", "none");           



				  },



			  	  error:function(error)  



				  {



					 $("div.overlay").css("display", "none"); 



				  }	 



	        });	



}







   //gift issued list hh //







 



 // get_groupname for new sch join //hh







/*function get_group_name(id_scheme)



{ 











    	my_Date = new Date();



	$(".overlay").css('display','block');



	$.ajax({



		type: 'POST',



		data:{'id_scheme':id_scheme},



	



		  url:base_url+ "index.php/admin_manage/get_groups?nocache=" + my_Date.getUTCSeconds(),



		dataType:'json',



		success:function(data){ 



			



		 $("#spinner").css('display','none');	







		console.log(data);



		$('#group_select').empty();



		   $.each(data, function (key, item) {



			  



			



			   		$('#group_select').append(



						$("<option></option>")



						.attr("value", item.group_code)						  



						  .text(item.group_code)



						  



					);			   				



				



			});



			



			$("#group_select").select2({



			    placeholder: "Select group code",



			    allowClear: true



			});



				



			 $("#group_select").select2("val", ($('#id_group').val()!=null?$('#id_group').val():''));



			







			 $(".overlay").css("display", "none");	



		}



	});



}











$('#group_select').select2().on("change", function(e){	











  $("#group_code").val($(this).val()); 



 // console.log($(this).val());







});*/







 // get_groupname for new sch join //hh



 



 



  



 function get_employee_name(id_branch='')



{



	//$("#spinner").css('display','none');



	//$(".overlay").css('display','block');



	$.ajax({



		type: 'POST',



		data :{'id_branch':id_branch},



		url: base_url+'index.php/reports/employee_list',



		dataType:'json',



		success:function(data){	



		console.log(data);



		 $("#spinner").css('display','none');



		   $.each(data.employee, function (key, item) {



		   //console.log(item.id_employee);					  	



			   		$('#emp_select').append(



						$("<option></option>")



						.attr("value", item.id_employee)						  



						  .text(item.employee_name )



					);



			});



			$("#emp_select").select2({



			    placeholder: "Select Employee Name ",



			    allowClear: true,



		    });



			 



			 $("#emp_select").select2("val", ($('#id_employee').val()!=null?$('#id_employee').val():''));



			 $(".overlay").css("display", "none");	



		}







	});



}







$('#emp_select').select2().on("change", function(e){					



		if(this.value!='')



		{	 







	



		        $('#id_employee').val(this.value);



		            var from_date = $('#closed_list1').text();



						var to_date  = $('#closed_list2').text();



						var id_branch=$('#id_branch').val();	



						var id_employee=$('#id_employee').val()



						get_closed_acc_list(from_date,to_date,id_branch,id_employee);







		



		}



		



		



});











//Get Branch wise emp name in Scheme Join Page admin //HH



function get_emp_branchwise(login_branches)



{







	$.ajax({



		type: 'GET',



		data :{'login_branches':login_branches},



		url: base_url+'index.php/reports/employee_list_brancwise',



		dataType:'json',



		success:function(data){	



	//	console.log(data);



		// $("#spinner").css('display','none');



		var id_employee =  $('#id_employee').val();



		   $.each(data.employee, function (key, item) {



		  // console.log(item.id_employee);					  	



			   		$('#employee_select').append(



						$("<option></option>")



						.attr("value", item.id_employee)						  



						  .text(item.employee_name )



					);



			});



			$("#employee_select").select2({



			    placeholder: "Select Employee Name ",



			    allowClear: true,



		    });



			 



			// $("#employee_select").select2("val",(id_employee!='' && id_employee>0?id_employee:''));	 



			$("#employee_select").select2("val", ($('#id_employee').val()!=null?$('#id_employee').val():''));



			 $(".overlay").css("display", "none");	



		}







	});



}















//closing branch name//HH



 function get_cls_branchname(){	



		//alert('sa.js');



         	//$(".overlay").css('display','block');	



         	$.ajax({		



             	type: 'GET',		



             	url: base_url+'index.php/branch/branchname_list',		



             	dataType:'json',		



             	success:function(data){	



			//	console.log(data);



            	 	var id_branch =  $('#close_id_branch').val();		   



            	 	$.each(data.branch, function (key, item) {	



					



                	 	$('#close_branch_select').append(						



                	 	$("<option></option>")						



                	 	.attr("value", item.id_branch)						  						  



                	 	.text(item.name )						  					



                	 	);			   											



                 	});						



                 	



					$("#close_branch_select").select2({			    



                	 	placeholder: "Select branch name",			    



                	 	allowClear: true		    



                 	});				 



                 	



                 	    $("#close_branch_select").select2("val",(close_id_branch!='' && close_id_branch>0?close_id_branch:''));	 



						$(".overlay").css("display", "none");			



             	}	



            }); 



        }







//closing branch name//



   



// Rate Fixing based on the Otp  verify//HH



   



     function otp_model(id_scheme_account,mobile)



     {



        my_Date = new Date();



        $.ajax({



            url: base_url+'index.php/admin_manage/rateFixing_otp?nocache=' + my_Date.getUTCSeconds(),



            data :  {'id_scheme_account':id_scheme_account,'mobile':mobile}, 	



            type : "POST",



            dataType: 'json',



            success : function(data) 



            {



                if(data.result==3)



                {



                    $('#otp_model').modal({



                    backdrop: 'static',



                    keyboard: false



                    });



                    $("#id_scheme_account").val(id_scheme_account); 



                    $("#mobile").val(mobile); 



                    $("div.overlay").css("display", "none"); 



                }



            }



        });



     }



    



  



       



       $('#submits').on('click',function(){



  



       var post_data=$('#otp_model').serialize();



       console.log(post_data);



       submit_otp(post_data);



       });



           



    function submit_otp(post_data)



    {  



        var post_otp=$('#otp').val();



	    var mobile = $("#mobile").val();



	    var id_scheme_account = $("#id_scheme_account").val();



              $.ajax({



                url: base_url+'index.php/admin_manage/submit_ratefix/',



                data :{'otp':post_otp, 'sch_ac_no' : $('#scheme_acc_number').val() , 'mobile':mobile,'id_scheme_account':id_scheme_account},



                type:"POST",



	            dataType:"JSON",



	            success:function(data)



                {



                       if(data.success==false)



                       {



                          alert(data.msg);



                           $('#otp').val('');



                       }



                       else



                       {



                          alert(data.msg);



                          window.open(base_url+'index.php/admin_manage/get_scheme_receipt/'+id_scheme_account,'_blank');



                          location.reload(true);



                       }



                    



                }



            });



       }



       



    $('#resendotp').on('click',function()



    {



    var post_data=$('#otp_model').serialize();



    console.log(post_data);



    resend_otp(post_data);



    });



    



     function resend_otp(post_data)



     {  



     var mobile = $("#mobile").val();



	 $.ajax({



		url: base_url+'index.php/admin_manage/rateFixing_otp?nocache=' + my_Date.getUTCSeconds(),



		data :  {'mobile':mobile}, 



		type:"POST",



   	    dataType:"JSON",



	    success:function(data)



                {



			if(data.result==3)



			{



				$('#otp_model').modal({



    				backdrop: 'static',



    				keyboard: false



				});



			}



		  }



	   });



    }



       



     



       function RateFixing_Data()



       {



             var metal_rate=$('#metal_rate').val();



             var scheme_acc_number=$('#scheme_acc_number').val();



             var id_scheme_account=$('#id_scheme_account').val();



              $.ajax({



                url:"https://121.200.48.187/EJAPIS/RateFixing",



               beforeSend: function (xhr) {



                   xhr.setRequestHeader('Authorization', make_base_auth('re0625@ejindia.com','karthik014'));



                },



                



                type : "post",



                data :{'scheme_acc_number':scheme_acc_number,'metal_rate':metal_rate,'id_scheme_account':id_scheme_account},



                dataType: 'json',



                success:function(data)



                {



                    if(data.success==true)



                    {



                        alert(data.msg);



                        location.reload(true);



                    }



                }



            });



       }



       



      function make_base_auth(user, password) {



       var tok = user + ':' + password;



       var hash = btoa(tok);



       return 'Basic ' + hash;



       }



       



    // Rate Fixing based on the Otp  verify//



    



    



   /* function get_gift_names()



	{



		



         	$.ajax({		



             	type: 'GET',		



             	url: base_url+'index.php/admin_manage/loadGiftData',		



             	dataType:'json',		



             	success:function(data){	



				console.log(data);



            	 	var gift_issued =  $('#gift_list').val();		   



            	 	$.each(data, function (key, item) {	



					



                	 	$('#gift_list').append(						



                	 	$("<option></option>")						



                	 	.attr("value", item.gift_name)						  						  



                	 	.text(item.gift_name)						  					



                	 	);			   											



                 	});						



                 	



					$("#gift_list").select2({			    



                	 	placeholder: "Select Gift",			    



                	 	allowClear: true		    



                 	});				 



                 	



                 	    $("#gift_list").select2("val",(gift_issued!='' && gift_issued>0?gift_issued:''));	 



						$(".overlay").css("display", "none");			



             	}	



            }); 



	} */



	



	function get_gift_names(row_index="")



	{



		var table_rows = $('#chart_gift_creation_tbl tbody tr').length;



		



		 	var row_length=$("#table_row_length").val();



			



         	$.ajax({		



             	type: 'GET',		



             	url: base_url+'index.php/admin_manage/loadGiftData',		



             	dataType:'json',		



             	success:function(data){	



					



					







					console.log(data);



            	 	//var gift_issued =  $('#gift_list').val();	



					if(!row_index)



					{	   



						$('#gift_list_'+row_length).append(



							$("<option></option>")



							.attr("value", "")						  						  



							.text("-----Select Gift----")	



						);



						$.each(data, function (key, item) {	



							



							$('#gift_list_'+row_length).append(						



							$("<option></option>")						



							.attr("value", item.id_gift)				  						  



							.text(item.gift_name)							  					



							);			   											



						});		



						



					}	



					else



					{



						



						$('#gift_list_'+row_index).append(



							$("<option></option>")



							.attr("value", "")						  						  



							.text("-----Select Gift----")	



						);



							$.each(data, function (key, item) {	



							



								$('#gift_list_'+row_index).append(						



								$("<option></option>")						



								.attr("value", item.id_gift)						  						  



								.text(item.gift_name)						  					



								);		 											



							});		



							$.ajax({		



								type: 'GET',		



								url: base_url+'index.php/admin_manage/get_gift_issued_list',		



								dataType:'json',



								data:{'id_scheme_account':ctrl_page[2]},	



								success:function(data){	



									var i=1;



									//console.log("gift_list: "+data[0]);



									$.each(data,function(key,item)



									{



										



										if(item.type=='GIFT')



										{



											//alert(item.gift_desc);



											//$('#gift_list_'+i).val(item.gift_desc);



											$('#gift_list_'+i).val(item.id_gift);



											$('#gift_val_'+i).val(item.id_gift);



										}



										i++;



									})



								}



							});



						



						



					}			



                 	



					// $("#gift_list_"+row_length).select2({			    



                	//  	placeholder: "Select Gift",			    



                	//  	allowClear: true		    



                 	// });				 



                 	



                 	    //$("#gift_list_"+row_length).select2("val",(gift_issued!='' && gift_issued>0?gift_issued:''));	 



						$(".overlay").css("display", "none");			



             	}	



            }); 



	}



       



       



    function is_agent_exist(object) {



    



        var agent_code = $('#agent_code').val();







        var mob_regex = /^[6-9]{1}[0-9]{9}$/; 



        



        if(agent_code.length == 10){  



            if (mob_regex.test(agent_code) == false)    {  



                alert( 'Agent code ' + agent_code + ' is not in the correct format!');  



                $('#agent_code').val('');



            }else{



                $.ajax({



            		url: base_url+'index.php/admin_manage/is_agent_exist', 



            		data : {'agent_code' : agent_code},



            		type : 'POST',



            		dataType: 'json',



            		success:function(data){



            			if(data.status == 0){



            				alert(data.msg);



            				$('#agent_code').val('');



            			}



            		}



        	    });



            } 



        }else{  



            alert("Not a valid agent code...");  



            $('#agent_code').val('');



        }



    }   



    



    



    function update_gift_status(id_sch_acc) {



        $.ajax({



            url: base_url+'index.php/admin_manage/update_gift_status', 



            data : {'id_sch_acc' : id_sch_acc},



            type : 'POST',



            dataType: 'json',



            success:function(data){



                if(data == 1){



                    $.toaster({ priority : 'success', title : 'Gift Status', message : ''+"</br> Gift deducted successfully.."});



                    window.location.reload(true); 



                }else{



                    $.toaster({ priority : 'warning', title : 'Gift Deduction', message : ''+"</br> Unable to proceed your request.."});



                }



            }



        });



    



        



    }















//DGS-DCNM







function set_chit_wallet_screen(id){



	



	



	$.ajax({



            url: base_url+'index.php/admin_manage/digi_wallet_screen', 



            data : {'id_sch_acc' : id},



            type : 'POST',



            dataType: 'json',



            success:function(data){



                console.log(data);







				$('#int_td').css('display','block');



				$('#debit_td').css('display','block');



				



				$("#chit_tab tbody").remove(); 



				



				$('#pay_count').html(data.tot.pay_count);



				$('#paid_tot').html("INR "+data.tot.total_paid);



				$('#saved_wgt').html(data.tot.saved_wgt+" gms");



				$('#saved_int').html(data.tot.total_benefit+" gms");



				$('#start_date').html(data.tot.join_date);



				$('#allow_pay_till').html(data.tot.allow_pay_till);



				$('#cur_day').html(data.tot.cur_date);



				$('#interest').html(data.tot.interest);



				$('#days_count').html(data.tot.date_difference);



				$('#redeem_duration').html(data.preclose_date);



				$('#debit_int').html(data.preclose_interest);



				$('#debit_intval').html(data.preclose_benefit +" gms");



				$('#debit_day').html(data.tot.allow_pay_till);



				



				/* if(data.tot.interest != ''){



					$('#int_td').css('display','block');



					$('#happy_td').css('display','block');



					var app = '';



				 app += '<tr><td style="text-align:center">Total interest saved till '+data.tot.cur_date+' <br> Interest : '+data.tot.interest+'</td><td style="text-align:center">'+data.tot.total_benefit+' grms</td>';



				



				app +='</tr><tr><td colspan="2" style="text-align:center">Date Crossed... STAY HAPPY 😀</td></tr>';



				



				$('#chit_tab').append(app);



				}else{



					$('#int_td').css('display','none');



					$('#happy_td').css('display','none');



				} */



				



				if(data.tot.interest == ''){



				    $('#int_td').css('display','none');



					$('#happy_td').css('display','none');



					$('#debit_td').css('display','none');



				}



 



				document.querySelector("#chit_report_link").setAttribute("href", base_url+'index.php/admin_manage/chit_detail_report/'+id);







            }



        });



}







//DGS-DCNM ends....







// 05-12-2022







	$('#add_benefits').keyup(function(event){



        calculate_closing_balance();



	});



	



	



	//webcam upload, #AD On:20-12-2022,Cd:CLin,Up:AB



	



    function take_snapshot(type){



    	//Snap Shots Disables



        	pre_img_resource=[];



    	    pre_img_files=[];



    	  $('#snap_shots').prop('disabled',true);



    		if(type == 'pre_images'){



    			var preview = 'uploadArea_p_stn';



    		}



    		Webcam.snap( function(data_uri) {



    		   $(".image-cust").val(data_uri);



    			pre_img_resource.push({'src':data_uri,'name':(Math.floor(100000 + Math.random() * 900000))+'jpg','is_default':"0"});



    			pre_img_files.push(data_uri); 



    			alert("Your Webcam Images Take Snap Shot Successfullys.");



    		} );



    		



    		



    		



    		



    	setTimeout(function(){      	 	



    		var resource = [];				



    		$('#'+preview+' div').remove();				



    		if(type == 'pre_images'){  				    



    			resource = pre_img_resource;			



    		}			



    		$.each(resource,function(key,item){		  	



    			if(item){  		   			



    			var div = document.createElement("div");			



    			div.setAttribute('class','images'); 			



    			div.setAttribute('id',+key); 			



    			param = {"key":key,"preview":preview,"stone_type":type};					



    			div.innerHTML+= "<span style='float:left;'><a onclick='remove_stn_img("+JSON.stringify(param)+")' style='cursor:pointer;color:inherit;' data-toggle='tooltip' data-placement='bottom' title='Delete This Images'>&nbsp;<i class='fa fa-trash'></i></a></span>&nbsp;&nbsp;<img class='thumbnail' src='" + item.src + "'" +				"style='width: 100px;height: 100px;'/>";  					



    			$('#'+preview).append(div);		   	}		   



    			$('#lot_img_upload').css('display',''); 				



    		});



    		



    		



    		$('#snap_shots').prop('disabled',false);			



    	



    	},1000);  



    }



    



     function remove_stn_img(param)



     {     	 



    	  $('#'+param.preview+' #'+param.key).remove();	



    	  $('#customer_images').val();	



    	  var preview = $('#cus_img_preview');



    	  preview.prop('src','');



    	  preview.css('display','none');



    	  $('#customer_images').val();		



     }











//webcam upload ends....



	



	



	



		//Crated by RK -13/12/2022



				function get_otpstatus_for_gift()



				{



					var mobile_data=$("#mobile_number").val();



						if(mobile_data=="")



						{



							$("#button_otp").attr("disabled",true);



						}



					



					$.ajax({



						



						url: base_url+'index.php/admin_settings/get_otp_giftstatus', 



						



						type : 'POST',



						dataType: 'json',



						success:function(data){



							



							var result=data.general;



							console.log(result);



							var otpval=result.isOTPReqToGift;



							var otpexp=result.giftOTP_exp;//line added by durga 20/12/2022



							



							$('#otp_exp').val(otpexp);//line added by durga 20/12/2022



							$('#otp_value').val(otpval);



							



							var otpvalue=$('#otp_value').val();



							if(mobile_data=="")



							{



								$("#button_otp").attr("disabled",true);



							}



						if(otpvalue==1)



						



						{



						var filterval="blur(8px)";



					//	$("#gift_list").attr('disabled',true);



					//	$("#prize_details").attr('disabled',true);



					   



						$('#gift_articles').css('filter',filterval);



						$('#gift_articles').css('pointer-events','none');



					//	$("#button_otp").attr("disabled",true);



						}



						else



						{



							$("#div_showotp_button").hide();



						}



							



						}



						});



				}















				//send otp button in verify otp modal - gift issue --- starts here



				//var fewSecondsgift = 90;







					$('#send_otp_gift').click(function(event) {



						



						var fewSecondsgift = $('#otp_exp').val();//line added by durga 20/12/2022



						



						$("#send_otp_gift").attr('disabled', true);







						setTimeout(function(){



						 







						 $("#send_otp_gift").attr('disabled', false);







						 



						 



					 }, fewSecondsgift*1000);//line altered by durga 20/12/2022



					 



					 $("#otp_txt_box").val('');//line added by durga 20/12/2022



					 $("#otp_txt_box").show();



				 



					   gift_send_otp();







						







					});



					



					



					



					//send otp button in verify otp modal - gift issue --- ends here



					function gift_send_otp()







					{



						



						$("div.overlay").css("display", "block");



						var cust_id=$("#id_customer").val();



						var mobile = $.trim($("#txt_mobile").val());



						



						$.ajax({



						



							url:base_url+"index.php/admin_manage/sendotp_gift",







							type : "POST",







							data : {mobile:mobile,id_cust:cust_id},







							//dataType:'json',







							success : function(result) {	



							//	alert();



								console.log(result);







							   }







							 });			



					



										 



					



					}



					



					



					$('#verify_otp_gift').click(function(event) {



						



						$("div.overlay").css("display", "block");



						var otp=$("#otp_data").val();



						console.log(otp);



						$.ajax({



							url:base_url+"index.php/admin_manage/verifyotp_gift",







							type : "POST",







							data : {otp:otp},







							dataType:'json',







							success : function(data) {	



								//alert();



								console.log(data.result);



								if(data.result==1)



								{



									{



										$.toaster({ priority : 'success',



										 title : 'Success', message : "OTP verified successfully" });



										var filterval="blur(0px)";



									   



										$('#verify_otp_modal').modal('toggle'); 



										$('#gift_articles').css('filter',filterval);



									//	$("#gift_list").attr("disabled",false);



									//	$("#prize_details").attr("disabled",false);



										$('#gift_articles').css('pointer-events','auto');



										$("#button_otp").hide();



										}







								}



								else if(data.result==5)



								{



									$.toaster({ priority : 'warning',



										 title : 'warning', message : data.msg });







								}



								else if(data.result==6)



								{



									$.toaster({ priority : 'warning',



										 title : 'warning', message : data.msg });







								}



							}











						});







				 });



				 



	



	// created by Durga starts here 13.02.2023



			// Creating Multiple gift chart for CJ 



			$("#add_gift_chart").on("click",function(){ 



				$("#err_msg").text("");



				var delarr_len=deleted_array.length;



				var table_rows = $('#chart_gift_creation_tbl tbody tr').length;



				//if any gift added 



				if(table_rows>0)



				{



					



					// rows_added variable holds total number of rows added including deleted rows



					for(var i=1;i<=rows_added;i++)



					{



						var t=0;



						//deleted_array holds the id of deleted rows



						//checking for whether all the rows are filled with values before adding another row 



						//not necessary to check for deleted rows 



						if(deleted_array.includes(i) === false)



						{



							var value=$("#gift_quantity"+i).val();



							if(value==''|| value==null||value==0)



							{



								//if any row is not filled stop checking and stop the loop



								t=1;



								



								break;



							}



							



						}



						



					}



					//if all rows are filled add new row



					if(t==0)



					{



						create_gift_chart_table();



					}



					else



					{



						//$("#err_msg").text("Please fill all the gift details");



						$.toaster({ priority : 'warning', title : 'Warning', message : ''+



						"</br>Please fill all the Gift Details" });



						



					}



					



				}



				//if no gift added 



				else



				{



					create_gift_chart_table();



				}



				



				



			});



			// function to create row in gift table 



			function create_gift_chart_table()



			{



				//rows_added variable is incremented every row added ,it holds total number of rows added including deleted rows



				rows_added++;



				var i = 1;



				var table_rows = $('#chart_gift_creation_tbl tbody tr').length;



				



					//table_rows=table_rows+1;



					table_rows=rows_added;







					i=table_rows;



				var row = "<tr rowID='" + i + "' id='"+table_rows+"'>"



								+"<td>"



								+"<select required name='gifts' id='gift_list_"+table_rows+"' name='gift_select["+table_rows+"]' class='form-control' onchange='set_selected_value(this.value,"+table_rows+")'></select>"



								//+"<select name='gifts' id='gift_list' class='form-control'></select>"



								+"<input id='gift_val_"+table_rows+"' name='gift_list_data["+table_rows+"]' type='hidden' value=''/>"



								+"</td>"



								+"<td>"



								+"<input type='number' id='gift_quantity"+table_rows+"' name='gift_quantity["+table_rows+"]' required='true' disabled/>"



								+"<td><div><button id='btn_delete_" + table_rows + "' class='delete btn btn-danger'   name='delete'type='button'><i class='fa fa-trash'></i> REMOVE</button></div></td></tr>";



							+"</tr>";



				$('#chart_gift_creation_tbl tbody').append(row);



				



			   //table_row_length hidden input in form for adding and updating in db



				$("#table_row_length").val(table_rows);



				get_gift_names();



			}



			// onchange function for select box in every row



			function set_selected_value(selected,table_rows)



			{



				//quantity input will only be enable if the value selected in dropdown



				if(selected)



				{



					



					$("#gift_val_"+table_rows).val(selected);



					$("#gift_quantity"+table_rows).attr('disabled',false);



					//alert(selected);



				}



				else



				{



					$("#gift_quantity"+table_rows).val("");



					$("#gift_quantity"+table_rows).attr('disabled',true);



				}



				



			}



			$("#chart_gift_creation_tbl").on('click','.delete',function(){



				$(this).closest('tr').remove();



				



				deleted=$('#chart_gift_creation_tbl tbody tr').length;



				var trid = $(this).closest('tr').attr('id');



				//alert(trid);



				deleted_array.push(parseInt(trid));



				console.log(deleted_array);



				console.log("deleted length"+deleted_array.length);



				



				



			});











			// created by Durga ends here 13.02.2023







	



	



	



	