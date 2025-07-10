var path =  url_params();
var ctrl_page = path.route.split('/');
$(document).ready(function() {
	
	switch(ctrl_page[1])
	{
		case 'list':
		       	get_log_list();
		$('#log-dt-btn').daterangepicker(
	            {
	              ranges: {
	                'Today': [moment(), moment()],
	                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	                'This Month': [moment().startOf('month'), moment().endOf('month')],
	                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month'									)]
	              },
	              startDate: moment().subtract(29, 'days'),
	              endDate: moment()
	            },
	        function (start, end) {
	          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	                     
	             get_log_list(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
	          }
        );   
		break;
		case 'detail':
		       	 get_logDetail_list();
		       
			  		 $('#log-dt-btn').daterangepicker(
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
		                
		             get_logDetail_list(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
		          }
        ); 
		       
			break;
		
		default:
			break;
	} 
	
});

//functions
function get_log_list(from_date="",to_date="")
{
	my_Date = new Date();
	 $("div.overlay").css("display", "block"); 
	$.ajax({
			  url:base_url+"index.php/log/ajax_list?nocache=" + my_Date.getUTCSeconds(),
			 data: (from_date !='' && to_date !=''? {'from_date':from_date,'to_date':to_date}: ''),
			 dataType:"JSON",
			 type:"POST",
			 success:function(data){
			   			set_log_list(data);
			   			 $("div.overlay").css("display", "none"); 
					  },
					  error:function(error)  
					  {
						 $("div.overlay").css("display", "none"); 
						alert(1);
					  }	 
			      });
}
function set_log_list(data)	
{
   var logs = data.logs;
   console.log(logs);
   var access = data.access;
   
   var oTable = $('#log_list').DataTable();
   $("#total_logs").text(logs.length);
   oTable.clear().draw();
   	 if (logs!= null && logs.length > 0)
	 {
	 	oTable = $('#log_list').dataTable({
				                "bDestroy": true,
				                "bInfo": true,
				                "bFilter": true,
				                "bSort": true,
				                "aaData": logs,
				                "order": [[ 0, "desc" ]],
				                "aoColumns": [{ "mDataProp": "id_log" },
					                { "mDataProp": "emp_name" },
					                { "mDataProp": "login_on" },
					                { "mDataProp": "logout_on" },
					                { "mDataProp": function ( row, type, val, meta ) {
					                	 id= row.id_log;
					                	 url=(access.edit=='1' ? base_url+'index.php/log/detail/'+id : '#' );
					                	        	        return "<a class='btn btn-primary' href='"+url+"'><i class='fa fa-search'></i> View</a>";
					                	}
					               
					            }] 

				            });	
	 }  
	 
}
function get_logDetail_list(from_date="",to_date="")
{
	my_Date = new Date();
	 $("div.overlay").css("display", "block"); 
	$.ajax({
			  url:base_url+"index.php/log/ajax_list_detail?nocache=" + my_Date.getUTCSeconds(),
			 data: (from_date !='' && to_date !=''? {'from_date':from_date,'to_date':to_date}: ''),
			 dataType:"JSON",
			 type:"POST",
			 success:function(data){
			   			set_logDetai_list(data);
			   			 $("div.overlay").css("display", "none"); 
					  },
					  error:function(error)  
					  {
						 $("div.overlay").css("display", "none"); 
						alert(1);
					  }	 
			      });
}
function set_logDetai_list(data)	
{
   var logs = data.logs;
   var oTable = $('#logDetail_list').DataTable();
   $("#total_logs").text(logs.length);
   oTable.clear().draw();
   	 if (logs!= null && logs.length > 0)
	 {
	 	oTable = $('#logDetail_list').dataTable({
				                 "bDestroy": true,
				                "bInfo": true,
				                "bFilter": true,
				                "bSort": true,
				                "aaData": logs,
				                "order": [[ 0, "desc" ]],
				                "aoColumns": [{ "mDataProp": "id_log_detail" },
					                { "mDataProp": "event_date" },
					                { "mDataProp": "module" },
					                { "mDataProp": "operation" },
					                { "mDataProp": "record" },
					                { "mDataProp": "remark" }           
					            ] 

				            });	
	 }  
}