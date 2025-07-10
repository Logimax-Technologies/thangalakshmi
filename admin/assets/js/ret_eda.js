var path =  url_params();
var ctrl_page 		= path.route.split('/');
$(document).ready(function() {
	var path =  url_params();
	$('#status').bootstrapSwitch();
    $(window).scroll(function() {    // this will work when your window scrolled.
		var height = $(window).scrollTop();  //getting the scrolling height of window
		if(height  > 300) {
			$(".stickyBlk").css({"position": "fixed"});
		} else{
			$(".stickyBlk").css({"position": "static"});
		}
	}); 
	switch(ctrl_page[1]) {
	 	case 'eda':
			switch(ctrl_page[2]) {
				case 'list':				 	
					get_eda_list();
					$('#branch_select').on('change',function(){
						get_eda_list();
					});
				break;
		}
	}
	
});
$(document).on("click", ".approve_eda", function() {
	let estimation_id 	= $(this).closest('tr').find(".estimation_id").val();
	let estimate_final_amt 	= $(this).closest('tr').find(".estimate_final_amt").val();
	console.log("estimation_id",estimation_id);
	console.log("estimate_final_amt",estimate_final_amt);
	if(parseFloat(estimation_id) > 0) {
		$("#esti_id").val(estimation_id);
		$("#estimate_final_amt").val(estimate_final_amt);
		$("#confirm-approve").modal('show');
	}
});
$(document).on("click", ".reject_eda", function() {
	let estimation_id 	= $(this).closest('tr').find(".estimation_id").val();
	console.log("estimation_id",estimation_id);
	if(parseFloat(estimation_id) > 0) {
		$("#esti_reject_id").val(estimation_id);
		$("#confirm-reject").modal('show');
	}
});
$(document).on("click", ".btn-approve", function() {
	let esti_id = $("#esti_id").val();
	let estimate_final_amt = $.trim($("#estimate_final_amt").val()) == '' ? 0 : $("#estimate_final_amt").val();
	if(parseFloat(esti_id) > 0) {
		$("#confirm-approve").modal('hide');
		my_Date = new Date();
		$("div.overlay").css("display", "block"); 
		$.ajax({
			url:base_url+"index.php/admin_ret_eda/eda/update?nocache=" + my_Date.getUTCSeconds(),
			dataType:"JSON",
			type:"POST",
			data:{'esti_id': esti_id, 'estimate_final_amt': estimate_final_amt, 'type' : 1},
			success:function(data){
				get_eda_list();
				$("div.overlay").css("display", "none"); 
				if(data.status == true) {
					$.toaster({ priority : 'success', title : 'Warning!', message : ''+"</br>"+'Estimation approved successfully...'});
				}
				else
				{
				    $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+data.message});
				}
			},
			error:function(error)  {
				$("div.overlay").css("display", "none"); 
			}	 
		});
	}
});
$(document).on("click", ".btn-reject", function() {
	let esti_id = $("#esti_reject_id").val();
	if(parseFloat(esti_id) > 0) {
		$("#confirm-reject").modal('hide');
		my_Date = new Date();
		$("div.overlay").css("display", "block"); 
		$.ajax({
			url:base_url+"index.php/admin_ret_eda/eda/update?nocache=" + my_Date.getUTCSeconds(),
			dataType:"JSON",
			type:"POST",
			data:{'esti_id': esti_id, 'type' : 2},
			success:function(data){
				get_eda_list();
				$("div.overlay").css("display", "none"); 
				if(data.status == true) {
					$.toaster({ priority : 'success', title : 'Warning!', message : ''+"</br>"+'Estimation rejected successfully...'});
				}else
				{
				    $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+data.message});
				}
			},
			error:function(error)  {
				$("div.overlay").css("display", "none"); 
			}	 
		});
	}
});
function get_eda_list() {
	my_Date = new Date();
	$("div.overlay").css("display", "block"); 
	$.ajax({
		url:base_url+"index.php/admin_ret_eda/eda/ajax?nocache=" + my_Date.getUTCSeconds(),
		dataType:"JSON",
		type:"POST",
		data:{'id_branch':(($('#branch_select').val()!='' && $('#branch_select').val()!='' && $('#branch_select').val()!=undefined) ? $('#branch_select').val():$('#branch_filter').val())},
		success:function(data){
			set_eda_list(data);
			$("div.overlay").css("display", "none"); 
		},
		error:function(error)  {
			$("div.overlay").css("display", "none"); 
		}	 
	});
}
/**
 * 
 * Updated By : Vivek, Updated On : 07-09-22
 * Added excel and print buttons. Given discount field
 */
function set_eda_list(data)	{
   $("div.overlay").css("display", "none"); 
   var estimation = data.list;
   var access = data.access;
   var oTable = $('#eda_list').DataTable();
   $("#total_estimation").text(estimation.length);
    if(access.add == '0')
	 {
		$('#add_estimation').attr('disabled','disabled');
	 }
	 oTable.clear().draw();
   	 if (estimation!= null && estimation.length > 0)
	 {
	 	oTable = $('#eda_list').dataTable({
			"bDestroy": true,
			"bInfo": true,
			"bFilter": true, 
			"bSort": true,
			"order": [[ 0, "desc" ]],
			"dom": 'lBfrtip',
			"buttons": [
				{
				  extend: 'print',
				  footer: true,
				  title: "EDA List",
				},
				{
				   extend:'excel',
				   footer: true,
				   title: "EDA List",
				 }
			],
			"aaData": estimation,
			"aoColumns": [{ "mDataProp": "esti_no" },
						{ "mDataProp": "estimation_datetime" },		
						{ "mDataProp": function ( row, type, val, meta ){
							return row.firstname;
						},
						},
						{ "mDataProp": "mobile" },
						
						{ "mDataProp": function ( row, type, val, meta ){
						    if($('#id_branch').val()==0 || $('#id_branch').val()=='')
						    {
						         return row.product_name;
						    }else{
						        return '-';
						    }
						},
						},
						{ "mDataProp": function ( row, type, val, meta ) {
						   	return "<span class='estimate_total_amt'>"+row.total_cost+"</span>";
					   	}
						},
						{ "mDataProp": function ( row, type, val, meta ) {
							if(row.is_eda_approved == 0) {
								action_content	=	'<input type="number" class="estimate_final_amt form-control" />';
							} else {
								action_content	=	row.estimate_final_amt;
								
							}
						   	return action_content;
					   	}
						},
						{ "mDataProp": function ( row, type, val, meta ) {
							let discount_amt = "-";
							if(row.is_eda_approved == 1) {
								let final_amt = isNaN(row.estimate_final_amt) || row.estimate_final_amt == "" || row.estimate_final_amt == null ? 0 : row.estimate_final_amt;
								discount_amt = parseFloat(parseFloat(row.total_cost) - parseFloat(final_amt)).toFixed(2);
							}
							return "<span class='estimate_discount_amt'>"+discount_amt+"</span>";
					   	}
						},
						{ "mDataProp": function ( row, type, val, meta ) {
							if(row.is_eda_approved == 0) {
								id	= row.estimation_id
								let approve_url		=	(access.add=='1' ? base_url+'index.php/admin_ret_eda/eda/approve/'+id : '#' );
								let reject_url		=	(access.add=='1' ? base_url+'index.php/admin_ret_eda/eda/reject/'+id : '#' );
								let approve_confirm	= 	(access.add=='1' ?'#confirm-approve':'');
								action_content 	= 	'<a href="#" class="btn btn-success approve_eda" data-href='+approve_url+' data-toggle="modal" >Approve</a><input type="hidden" class="estimation_id" value="'+id+'" /> &nbsp; <a href="#" class="btn btn-danger reject_eda" data-href='+reject_url+' data-toggle="modal" >Reject</a>';
							} else {
								action_content = 'Approved';
							}
							return action_content;
						}
					}] 
		});	
	}
}
$(document).on("keyup",".estimate_final_amt", function() {
	let curRow = $(this).closest("tr");
	let estimate_total_amt = curRow.find('.estimate_total_amt').html();
	let estimate_final_amt = $.trim(curRow.find('.estimate_final_amt').val());
	estimate_total_amt = isNaN(estimate_total_amt) || estimate_total_amt == "" ? 0 : estimate_total_amt;
	estimate_final_amt = isNaN(estimate_final_amt) || estimate_final_amt == "" ? 0 : estimate_final_amt;
	let estimate_discount_amt = (parseFloat(estimate_total_amt) - parseFloat(estimate_final_amt)).toFixed(2);
	curRow.find('.estimate_discount_amt').html(estimate_discount_amt);
});