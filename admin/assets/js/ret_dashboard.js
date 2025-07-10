var path =  url_params();
var ctrl_page = path.route.split('/');
let curr_symbol = "&#x20B9; ";
$(document).ready(function() 
{
	switch(ctrl_page[1])
	{
		
		case  'dashboard':
		        
				//get_lot_data();	
				//get_tagging_data();
				get_branch_order();
				get_average_bill_value();
                get_branchname();
				var date = new Date();
			    var from_date=(date.getFullYear()+"-"+(date.getMonth() + 1)+"-"+date.getDate());
			    var to_date=(date.getFullYear()+"-"+(date.getMonth() + 1)+"-"+date.getDate());
			    $('#payment_list1').text(from_date);
				$('#payment_list2').text(to_date);
			    $("body").on("click","#tab_livecockpit", function(){
					//retail_dashboard_details(from_date,to_date);
				    get_live_cockpit_dashboard_details();
				});
				
				$("body").on("click","#tab_order_management", function(){
				    get_order_management_details();
				});
				$("body").on("click","#tab_sales", function(){
					let from_date =  $('#payment_list1').text();
					let to_date =  $('#payment_list2').text();
					sales_dashboard_data(from_date,to_date);
				});
				
				$("body").on("click","#tab_sale_gchart", function(){
					// Load the Visualization API and the piechart package.
					google.charts.load('current', {'packages':['corechart', 'bar']});
					  
					// Set a callback to run when the Google Visualization API is loaded.
					google.charts.setOnLoadCallback(get_salesDetails);
				    //get_salesDetails();
				});	
				
				$("body").on("click","#tab_stock_gchart", function(){
					// Load the Visualization API and the piechart package.
					google.charts.load('current', {'packages':['corechart', 'bar']});
					  
					// Set a callback to run when the Google Visualization API is loaded.
					google.charts.setOnLoadCallback(get_stockDetails);
				});	
				
				$("body").on("click","#tab_contract_pricing", function(){
					get_contract_pricing();
				});


			     sales_details(from_date,to_date);
			    /*window.setInterval(function(){
				 if($('.tab-pane.active').attr('id') == "live_cockpit") {
					let from_date =  $('#payment_list1').text();
					let to_date =  $('#payment_list2').text();
					//retail_dashboard_details(from_date,to_date);
					get_live_cockpit_dashboard_details();
				 }
				 if($('.tab-pane.active').attr('id') == "sales") {
					let from_date =  $('#payment_list1').text();
					let to_date =  $('#payment_list2').text();
					sales_dashboard_data(from_date,to_date);
				 }
				 
				  if($('.tab-pane.active').attr('id') == "tab_sale_gchart")				 
				 {		    				 
				     let from_date =  $('#payment_list1').text();						    				 
				     let to_date   =  $('#payment_list2').text();						    			     
				     // Load the Visualization API and the piechart package.
					google.charts.load('current', {'packages':['corechart', 'bar']});
					  
					// Set a callback to run when the Google Visualization API is loaded.
					google.charts.setOnLoadCallback(get_salesDetails);			 				 
				 }
				 
				 if($('.tab-pane.active').attr('id') == "tab_stock_gchart")				 
				 {		    				 
				     let from_date =  $('#payment_list1').text();						    				 
				     let to_date   =  $('#payment_list2').text();						    			     
				     // Load the Visualization API and the piechart package.
					google.charts.load('current', {'packages':['corechart', 'bar']});
					  
					// Set a callback to run when the Google Visualization API is loaded.
					google.charts.setOnLoadCallback(get_stockDetails);			 				 
				 }
				 sales_details(from_date,to_date);
				},60*1000*5);*/
		break;
	 	case 'get_estimation':
	 			var date = new Date();
				var firstDay  = new Date(date.getFullYear(), date.getMonth(),date.getDate() - 0, 1); 
				var from_date =  firstDay.getFullYear()+'-'+(firstDay.getMonth()+1)+'-'+firstDay.getDate();
				var to_date=(date.getDate()+"-"+(date.getMonth() + 1)+"-"+date.getFullYear());			
			    var id_filter=$('#id_filter').val();
			    set_estimation_table(from_date,to_date,id_filter);
			    $('#estimation1').text(from_date);
			    $('#estimation2').text(to_date);
	 	break; 
	}
	
	// -------------
  // - PIE CHART -
  // -------------
if($('#pieChart').get(0) != undefined){
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    {
      value    : 5,
      color    : '#f56954',
      highlight: '#f56954',
      label    : 'Repair'
    },
    /*{
      value    : 500,
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'IE'
    },
    {
      value    : 400,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'FireFox'
    },*/
    {
      value    : 10,
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'Custom'
    },
    /*{
      value    : 300,
      color    : '#3c8dbc',
      highlight: '#3c8dbc',
      label    : 'Opera'
    },*/
    {
      value    : 12,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'Catalog'
    }
  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%> Order'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------
}
	$('#payment_list1').text(moment().format('YYYY-MM-DD'));
	$('#payment_list2').text(moment().format('YYYY-MM-DD'));	
    $('#payment-dt-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
           startDate: moment(),
          endDate: moment()
        },
    function (start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          get_lot_data(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
		  get_tagging_data(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
		  get_branch_order(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
		  retail_dashboard_details(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
		  
		  get_order_management_details(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
		  
		  
		  if($('.tab-pane.active').attr('id') == "sale_gchart") {	    
		    // Load the Visualization API and the piechart package.
			google.charts.load('current', {'packages':['corechart', 'bar']});
			  
			// Set a callback to run when the Google Visualization API is loaded.
			google.charts.setOnLoadCallback(get_salesDetails);
		 }
       
	  $('#payment_list1').text(start.format('YYYY-MM-DD'));
	  $('#payment_list2').text(end.format('YYYY-MM-DD')); 
	  if($('.tab-pane.active').attr('id') == "live_cockpit") {	  
	  	get_live_cockpit_dashboard_details();
	  } else if($('.tab-pane.active').attr('id') == "sales") {
			let from_date =  $('#payment_list1').text();
			let to_date   =  $('#payment_list2').text();
			sales_dashboard_data(from_date,to_date);
	  }
      }
    ); 
        
	$('#estimation_date').daterangepicker(
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
	function (start, end)
	{
		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		var id_filter=$('#id_filter').val();
		set_estimation_table(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'),id_filter)
		$('#estimation1').text(start.format('YYYY-MM-DD'));
		$('#estimation2').text(end.format('YYYY-MM-DD')); 
	}
	);
$("#filter_type").select2({
	placeholder:"Select type",
	allowClear: true
});
	
});
$('#filter_type').on('change',function(){
	if(this.value!='')
	{
		var from_date=$('#estimation1').text();
		var to_date  =$('#estimation2').text();
		var id_branch=$('#id_branch').val();
		$('#id_filter').val(this.value);
		set_estimation_table(from_date,to_date,this.value,id_branch);
	}
	else
	{
		$('#id_filter').val('');
	}
});
$('#branch_select').on('change',function(){
	if(this.value!='')
	{
		var from_date=$('#estimation1').text();
		var to_date  =$('#estimation2').text();
		var id_filter  =$('#id_filter').val();
		$('#id_branch').val(this.value);
		//set_estimation_table(from_date,to_date,id_filter,this.value);
		
    	if($('.tab-pane.active').attr('id') == "live_cockpit") {
			let from_date =  $('#payment_list1').text();
			let to_date =  $('#payment_list2').text();
			//retail_dashboard_details(from_date,to_date);
			
			get_live_cockpit_dashboard_details();
		 }
		 
		
		 
		 if($('.tab-pane.active').attr('id') == "sale_gchart") {	    
		   // Load the Visualization API and the piechart package.
				google.charts.load('current', {'packages':['corechart', 'bar']});
				  
				// Set a callback to run when the Google Visualization API is loaded.
				google.charts.setOnLoadCallback(get_salesDetails);
		 }
		 
		    if($('.tab-pane.active').attr('id') == "stock_and_branch_transfer")
            {
            	let from_date =  $('#payment_list1').text();
            	let to_date   =  $('#payment_list2').text();
            	branch_transfer_details_dashboard_data(from_date,to_date);
            }
	}
	else
	{
		$('#id_branch').val('');
	}
});
function retail_dashboard_details(from_date,to_date)
{
	my_Date = new Date();
	$.ajax({
			 url:base_url+ "index.php/admin_ret_dashboard/get_retail_dashboard_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date},
			 type:"POST",
			 cache:false,
			 success:function(data){ 
				var estimation 	    = data.estimation;
				$('#live_estimation').text(estimation.estimation);
		 	 },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function set_estimation_table(from_date,to_date,filter_type,id_branch)
{
	my_Date = new Date();
	$.ajax({
			 url:base_url+ "index.php/admin_ret_dashboard/get_estimation_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'type':filter_type,'id_branch':id_branch},
			 type:"POST",
			 cache:false,
			 success:function(data){ 
				var estimation 	    = data;
			 var oTable = $('#estimation_list').DataTable();
			 oTable.clear().draw();
			 if (estimation!= null && estimation.length > 0)
			 {  	
				oTable = $('#estimation_list').dataTable({
						"bDestroy": true,
						"bInfo": true,
						"bFilter": true,
						"bSort": true,
						"order": [[ 0, "desc" ]],
						"dom": 'lBfrtip',
						"buttons" : ['excel','print'],
						"tableTools": { "buttons": [ { "sExtends": "xls", "oSelectorOpts": { page: 'current' } },{ "sExtends": "pdf", "oSelectorOpts": { page: 'current' } } ] },
						"aaData"  : estimation,
						"aoColumns": [	{ "mDataProp": "estimation_id" }, 
										{ "mDataProp": "cus_name" },
										{ "mDataProp": "item_type" },
										{ "mDataProp": "sales_wt" },
										{ "mDataProp": "sales_amt" },
										{ "mDataProp": "pur_wt" },
										{ "mDataProp": "item_cost" },
										{ "mDataProp": "chit_amt" },
										{ "mDataProp": "gift_voucher_amt" },
										{ "mDataProp": "discount" },
										{ "mDataProp": "total_cost" },
										],
										"footerCallback": function ( row, data, start, end, display ) {
										var api = this.api(), data;
										// Remove the formatting to get integer data for summation
										var intVal = function ( i ) {
										return typeof i === 'string' ?
										i.replace(/[\$,]/g, '')*1 :
										typeof i === 'number' ?
										i : 0;
										};
										// Total over all pages
										/*total = api
										.column( 10 )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );*/
										// Total over this page
										sales_wt = api
										.column( 3, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										sales_amt = api
										.column( 4, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										pur_wt = api
										.column( 5, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										pur_amt = api
										.column( 6, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										chit_amt = api
										.column( 7, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										gift_amt = api
										.column( 8, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										dis_amt = api
										.column( 9, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										net_amt = api
										.column( 10, { page: 'current'} )
										.data()
										.reduce( function (a, b) {
										return intVal(a) + intVal(b);
										}, 0 );
										// Update footer
										$( api.column( 3 ).footer() ).html(
										'INR '+parseFloat(sales_wt).toFixed(2)
										);
										$( api.column( 4 ).footer() ).html(
										'INR '+parseFloat(sales_amt).toFixed(2)
										);
										$( api.column( 5 ).footer() ).html(
										'INR '+parseFloat(pur_wt).toFixed(2)
										);
										$( api.column( 6 ).footer() ).html(
										'INR '+parseFloat(pur_amt).toFixed(2)
										);
										$( api.column( 7 ).footer() ).html(
										'INR '+parseFloat(chit_amt).toFixed(2)
										);
										$( api.column( 8 ).footer() ).html(
										'INR '+parseFloat(gift_amt).toFixed(2)
										);
										$( api.column( 9 ).footer() ).html(
										'INR '+parseFloat(dis_amt).toFixed(2)
										);
										$( api.column( 10 ).footer() ).html(
										//'$'+pageTotal +' ( $'+ total +')'
										'INR '+parseFloat(net_amt).toFixed(2)
										);
										}
					});			  	 	
				} 
		  },
		  error:function(error)  
		  {
			 $("div.overlay").css("display", "none"); 
		  }	 
	});
	
}
function get_lot_data(from_date="",to_date="")
{
	my_Date = new Date();  
	$.ajax({
	  	  url:base_url+ "index.php/admin_ret_dashboard/ajax_lot_data?nocache=" + my_Date.getUTCSeconds(),
    	 data:{'from_date':from_date,'to_date':to_date},
    	 dataType:"JSON",
    	 type:"POST",
    	 success:function(data){ 
		    console.log(data);
    	 	set_lot_data(data,from_date,to_date); 
    	  },
    	  error:function(error)  
    	  {
    	  $("div.overlay").css("display", "none"); 
    	  }	 
	  });
}
function set_lot_data(data,from_date,to_date)
{
	$('#lot-data tbody').remove();
	$('#grs_wt').text(data.gross_wt);
	$('#net_wt').text(data.net_wt);
    $.each(data['lot'], function (index, element) 
	{ 
		        id_branch = element.id_branch; 
				
    			$('#lot-data').append(
                  $('<tbody><tr>')
				  .append($('<td style="text-align: centre;padding: 5px;">').append(element.branch_name))
                  .append($('<td style="text-align: centre;padding: 5px;">').append(element.lots))
                  .append($('<td style="text-align: centre;padding: 5px;">').append(element.net_weight))
				  .append($('<td style="text-align: centre;padding: 5px;">').append(element.grs_wt))
				   
                );
		     
		 });
}
function get_tagging_data(from_date="",to_date="")
{
	my_Date = new Date();  
	$.ajax({
	  	  url:base_url+ "index.php/admin_ret_dashboard/ajax_tag_data?nocache=" + my_Date.getUTCSeconds(),
    	 data:{'from_date':from_date,'to_date':to_date},
    	 dataType:"JSON",
    	 type:"POST",
    	 success:function(data){ 
		    console.log(data);
    	 	set_tagging_data(data,from_date,to_date); 
    	  },
    	  error:function(error)  
    	  {
    	  $("div.overlay").css("display", "none"); 
    	  }	 
	  });
}
function set_tagging_data(data,from_date,to_date)
{
	$('#tag-data tbody').remove();
	$('#gt').text(data.grs_wt);
	$('#nt').text(data.nt_wt);
    $.each(data['tag'], function (index, element) 
	{ 
		     
    			$('#tag-data').append(
                  $('<tbody><tr>')
				  .append($('<td style="text-align: centre;padding: 5px;">').append(element.branch_name))
                  .append($('<td style="text-align: centre;padding: 5px;">').append(element.tags))
                  .append($('<td style="text-align: centre;padding: 5px;">').append(element.nt))
				  .append($('<td style="text-align: centre;padding: 5px;">').append(element.gt))
				   
                );
		     
		 });
}
function get_live_cockpit_dashboard_details()
{
        let from_date =  $('#payment_list1').text();
		let to_date =  $('#payment_list2').text();
        get_EstimationStatus(from_date,to_date);
		get_BillingStatus(from_date,to_date);
		get_GreentagSalesDetails(from_date,to_date);
		get_metal_purchase_status(from_date,to_date);
		get_CreditSalesDetails(from_date,to_date);
		get_GiftVoucherDetails(from_date,to_date);
		get_BillClassficationDetails(from_date,to_date);
		get_VitrualTagStatus(from_date,to_date);
		get_SalesreturnDetails(from_date,to_date);
		get_BranchTransferDetails(from_date,to_date);
		get_lot_tag_details(from_date,to_date);
		get_OrderDetails(from_date,to_date);
		get_StockDetails(from_date,to_date);
		get_silver_StockDetails(from_date,to_date);
		get_ReorderDetails(from_date,to_date);
		get_KarigarOrderDetails();
		get_CustomerOrderDetails(from_date,to_date);
		get_MetalStockDetails();
		get_RecentBillDetails(from_date,to_date);
		get_cash_abstract_details(from_date,to_date);
		getEstimationDetails(from_date,to_date);
		get_CustomerDetails(from_date,to_date);
		get_stock_details(from_date,to_date);
		get_approval_type();
}
function get_order_management_details()
{
    let from_date =  $('#payment_list1').text();
	let to_date =  $('#payment_list2').text();
	get_customer_order_details(from_date,to_date);
}
function get_EstimationStatus(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_EstimationStatus?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
				if(data != null &&  data.dash_estmation.created !== undefined){
				var estimate_create_url = base_url+'index.php/admin_ret_reports/dashboard_estimation/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
				var estimate_convert_url = base_url+'index.php/admin_ret_reports/dashboard_estimation/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
			        $("#cp_estimation_created").html('<a href='+estimate_create_url+' target="_blank">'+data.dash_estmation.created+'</a>');
				    $("#cp_estimation_converted").html('<a href='+estimate_convert_url+' target="_blank">'+data.dash_estmation.sold+'</a>');
				}
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
/*function get_BillingStatus(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_BillingStatus?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			 
				    var dashboard_goldlist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
				    var dashboard_silverlist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
				    var dashboard_mrplist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/3/' + $('#id_branch').val();
			            $("#cp_sales_bills").html('<a href='+dashboard_goldlist+' target="_blank">' + data.dash_billing.gold_wt+ " g" + '</a>');
					
				        $("#cp_sales_amount").html('<a href='+dashboard_silverlist+' target="_blank">' + data.silver_wt.silver_wt+ " g" + '</a>');
					
					    $("#cp_sales_amount_mrp").html('<a href='+dashboard_mrplist +' target="_blank">' + curr_symbol + data.mrp.mrp + '</a>');
				
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}*/
function get_BillingStatus(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_BillingStatus?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			sales_html=' <tr style="border-bottom: 15px solid transparent;" ><th style=" text-align:left;"  >Metal</th><th style=" text-align:right;"> Pcs</th><th style=" text-align:right;">Weight</th><th style=" text-align:right;">Amount</th> <th style="width:4%"></th></tr>';
				var dashboard_mrplist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/mrp/' + $('#id_branch').val();
                var dashboard_dialist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/daimond/'+ $('#id_branch').val();
			if(data.dash_billing){
 
			
			$.each(data.dash_billing, function (index, element)  { 
				if(element.amt !=0){
					var dashboard_goldlist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/'+element.id_metal+'/' + $('#id_branch').val();
					sales_html +=  '<tr style="border-bottom: 15px solid transparent">'+
					'<td style=" text-align:left;"><b>'+element.metal_code+'  <span class="badge bg-green" id="cp_dia_count" style="font-size:10px">'+element.count+'</span></b></td>'+
					'<td style=" text-align:right;" ><b>'+'<a href='+dashboard_goldlist +' target="_blank">'+element.piece+ "" + '</a>'+'</b></td>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_goldlist+' target="_blank">' + element.wt+ " g" + '</a>'+'</b></td>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_goldlist +' target="_blank">' + curr_symbol +money_format_india(element.amt) + '</b></a>'+'</td>'+
					'<td></td>'+
				'</tr> ';
			}
					});
				}
				if(data.diamond.stone_amt != 0){
					sales_html +=  '<tr style="border-bottom: 15px solid transparent" >'+
					'<td style=" text-align:left;"><b>'+data.diamond.stone_name+'  <span class="badge bg-green" id="cp_dia_count" style="font-size:10px">'+data.diamond.count+'</span></b></th>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_dialist +' target="_blank">'+data.diamond.stone_pieces+ "" + '</a>'+' </b></td>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_dialist +' target="_blank">' + data.diamond.stone_wt+ " CT" + '</a>'+' </b></td>'+
					'<td style=" text-align:right; "><b>'+'<a href='+dashboard_dialist +' target="_blank">' + curr_symbol + money_format_india(data.diamond.stone_amt) + '</a>'+'</b></td>'+
					'<td></td>'+
				'</tr> ';
				}
				if(data.mrp.mrp != 0 ){
				sales_html +=  '<tr style="border-bottom: 15px solid transparent">'+
					'<td style=" text-align:left;"><b> MRP  <span class="badge bg-green" id="cp_dia_count" style="font-size:10px">'+data.mrp.mrp_count+'</span></b></td>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_mrplist +' target="_blank">'+data.mrp.mrp_piece+ "" + '</a>'+'</b></td>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_mrplist+' target="_blank">' + data.mrp.mrp_wt+ " g" + '</a>'+'</b></td>'+
					'<td style=" text-align:right;"><b>'+'<a href='+dashboard_mrplist +' target="_blank">' + curr_symbol + money_format_india(data.mrp.mrp) + '</a>'+'</b></td>'+
					'<td></td>'+
				'</tr> ';
					
				}
				$('#metal_sales').html(sales_html);
			    //    if(data != null &&  data.dash_billing.gold_wt !== undefined){
			    //     /*$("#cp_sales_bills").html(curr_symbol+data.dash_billing.bills);
				//     $("#cp_sales_amount").html(curr_symbol+data.dash_billing.billamount);*/
				//     var dashboard_goldlist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
				//     var dashboard_silverlist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
				//     var dashboard_mrplist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/3/' + $('#id_branch').val();
                //     		    var dashboard_dialist = base_url+'index.php/admin_ret_reports/dashboard_sales/'+from_date+'/'+to_date+'/4/'+ $('#id_branch').val();
			    //         $("#cp_gold_wt").html('<a href='+dashboard_goldlist+' target="_blank">' + data.dash_billing.gold_wt+ " g" + '</a>');
				// 		$("#cp_gold_amt").html('<a href='+dashboard_goldlist +' target="_blank">' + curr_symbol + data.dash_billing.gold_amt + '</a>');
					
				// 		$("#cp_gold_pcs").html('<a href='+dashboard_goldlist +' target="_blank">'+data.dash_billing.gold_piece+ " Pcs" + '</a>');
                        
				// 		$("#cp_gold_count").html(data.dash_billing.gold_count);
						
						
						
				// 		$("#cp_silver_wt").html('<a href='+dashboard_silverlist+' target="_blank">' + data.silver_wt.silver_wt+ " g" + '</a>');
						
				// 		$("#cp_silver_amt").html('<a href='+dashboard_silverlist +' target="_blank">' + curr_symbol + data.silver_wt.silver_amt + '</a>');
					   
				// 		$("#cp_silver_pcs").html('<a href='+dashboard_silverlist +' target="_blank">'+data.silver_wt.silver_piece+ " Pcs" + '</a>');
						
				// 		$("#cp_silver_count").html(data.silver_wt.silver_count);
				// 		$("#cp_dia_wt").html('<a href='+dashboard_dialist +' target="_blank">' + data.diamond.stone_wt+ " CT" + '</a>');
				// 		$("#cp_dia_amt").html('<a href='+dashboard_dialist +' target="_blank">' + curr_symbol + data.diamond.stone_amt + '</a>');
				// 		$("#cp_dia_pcs").html('<a href='+dashboard_dialist +' target="_blank">'+data.diamond.stone_pieces+ " Pcs" + '</a>');
				// 		$("#cp_dia_count").html(data.diamond.count);
						
						
				// 		$("#cp_mrp_amt").html('<a href='+dashboard_mrplist +' target="_blank">' + curr_symbol + data.mrp.mrp + '</a>');
						
				// 		$("#cp_mrp_wt").html('<a href='+dashboard_mrplist+' target="_blank">' + data.mrp.mrp_wt+ " g" + '</a>');
				// 		$("#cp_mrp_pcs").html('<a href='+dashboard_mrplist +' target="_blank">'+data.mrp.mrp_piece+ " Pcs" + '</a>');
						
				// 		$("#cp_mrp_count").html(data.mrp.mrp_count);
			    //    }
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_GreentagSalesDetails(from_date,to_date)
{
	$("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     	url:base_url+ "index.php/admin_ret_dashboard/get_GreentagSalesDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ console.log(data);
			        if(data != null &&  data.dash_greentag.tot_sales_wt !== undefined){
    				    var dashboard_greentag = base_url+'index.php/admin_ret_reports/dashboard_greentag/'+from_date+'/'+to_date+'/' + $('#id_branch').val();
    				
    			        $("#cp_greentag_sales").html('<a href='+dashboard_greentag +' target="_blank">'+data.dash_greentag.tot_sales_wt + " g" + '</a>');
    				    $("#cp_greentag_count").html('<a href='+dashboard_greentag +' target="_blank">'+data.dash_greentag.tot_piece + " Pcs" + '</a>');
    				    $("#cp_greentag_rs").html('<a href='+dashboard_greentag +' target="_blank">'+ curr_symbol +money_format_india(parseFloat(data.dash_greentag.incentive).toFixed(2))+ '</a>');
			        }
				    
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_SalesreturnDetails(from_date,to_date)
{
	$("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     	url:base_url+ "index.php/admin_ret_dashboard/get_SalesReturnDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			      
				    var dashboard_salesreturn = base_url+'index.php/admin_ret_reports/dashboard_salereturn/'+from_date+'/'+to_date+'/' + $('#id_branch').val();
				    if(data != null && data.dash_salesreturn_details.tot_wt !== undefined){
    			        $("#cp_salesreturn_wt").html('<a href='+dashboard_salesreturn +' target="_blank">'+data.dash_salesreturn_details.tot_wt + " g" + '</a>');
    				    $("#cp_salesreturn_pcs").html('<a href='+dashboard_salesreturn +' target="_blank">'+data.dash_salesreturn_details.tot_pcs + " Pcs" + '</a>');
    			      }
				    
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_VitrualTagStatus(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_VitrualTagStatus?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			      if(data != null && data.dash_virturaltag_details.homesale_wt !== undefined){
				    var dashboard_home = base_url+'index.php/admin_ret_reports/dashboard_virtualsales/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
				    var dashboard_partly = base_url+'index.php/admin_ret_reports/dashboard_virtualsales/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
			        $("#cp_virtual_tag_homesale_pcs").html(data.dash_virturaltag_details.homesale_pcs);
				    $("#cp_virtual_tag_homesale_wt").html('<a href='+dashboard_home +' target="_blank">'+data.dash_virturaltag_details.homesale_wt+" g" + '</a>');
				    $("#cp_virtual_tag_tagsplit_pcs").html(data.dash_virturaltag_details.tagsplit_pcs);
				    $("#cp_virtual_tag_tagsplit_wt").html('<a href='+dashboard_partly +' target="_blank">'+data.dash_virturaltag_details.tagsplit_wt+" g" + '</a>');
			      }
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_metal_purchase_status(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_old_metal_purchase?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    $("#old_metal_purchase_gold").html("-");
                    $("#old_metal_purchase_silver").html("-");
                    if(data != null && data.dash_old_metal_purchase !== undefined){
                        $.each(data.dash_old_metal_purchase, function (index, element)  { 
                        let metal_type = element.metal_type;
                        let weight = element.weight;
    					var dashboard_oldmetal_gold = base_url+'index.php/admin_ret_reports/dashboard_oldmetal/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
    					var dashboard_oldmetal_silver = base_url+'index.php/admin_ret_reports/dashboard_oldmetal/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
                        if(metal_type == 1)
                        $("#old_metal_purchase_gold").html('<a href='+dashboard_oldmetal_gold +' target="_blank">'+weight+ " g" + '</a>');
                        if(metal_type == 2)
                        $("#old_metal_purchase_silver").html('<a href='+dashboard_oldmetal_silver +' target="_blank">'+weight+ " g" + '</a>');
                        });
                    }
                    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_CreditSalesDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_CreditSalesDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			      
			    	var dashboard_creditbill = base_url+'index.php/admin_ret_reports/dashboard_creditsales/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
				    var dashboard_received = base_url+'index.php/admin_ret_reports/dashboard_creditsales/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
				    if(data != null && data.dash_credeit_sales.tot_due_amount !== undefined){
                        $("#tot_bill_amt").html('<a href='+dashboard_creditbill +' target="_blank">'+curr_symbol+money_format_india(data.dash_credeit_sales.tot_due_amount) + '</a>');
    				    $("#creditreceived").html('<a href='+dashboard_received +' target="_blank">'+curr_symbol+money_format_india(data.dash_credeit_sales.creditreceived) + '</a>');
    			      }
				    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_GiftVoucherDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_GiftVoucherDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			      if(data != null && data.dash_gift_vouchers.tot_utlized !== undefined){
        				var dashboard_gift_utlized = base_url+'index.php/admin_ret_reports/dashboard_giftcard/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
        				var dashboard_gift_issue = base_url+'index.php/admin_ret_reports/dashboard_giftcard/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
        				var dashboard_gift_sold = base_url+'index.php/admin_ret_reports/dashboard_giftcard/'+from_date+'/'+to_date+'/3/' + $('#id_branch').val();
                            $("#gift_tot_utlized").html('<a href='+dashboard_gift_utlized +' target="_blank">'+curr_symbol+money_format_india(data.dash_gift_vouchers.tot_utlized) + '</a>');
        				    $("#gift_tot_issued").html('<a href='+dashboard_gift_issue +' target="_blank">'+curr_symbol+money_format_india(data.dash_gift_vouchers.tot_issued) + '</a>');
        			    	$("#gift_tot_sold").html('<a href='+dashboard_gift_sold +' target="_blank">'+curr_symbol+money_format_india(data.dash_gift_vouchers.tot_sold) + '</a>');
			      }
			    	$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_BillClassficationDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_BillClassficationDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
			        if(data != null && data.dash_bills_clasfication.newcusbillsale !== undefined){
                        $("#totalnewcusbill").html(data.dash_bills_clasfication.totalnewcusbill);
        				$("#newcisbillsalewt").html(data.dash_bills_clasfication.newcisbillsalewt+" g");
        				$("#newcusbillsale").html(curr_symbol+money_format_india(data.dash_bills_clasfication.newcusbillsale));
        				$("#totaloldcusbill").html(data.dash_bills_clasfication.totaloldcusbill);
        				$("#oldcusbillsalewt").html(data.dash_bills_clasfication.oldcusbillsalewt+" g");
        				$("#oldcusbillsale").html(curr_symbol+money_format_india(data.dash_bills_clasfication.oldcusbillsale));
			        }
    				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_BranchTransferDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_BranchTransferDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    $("#branch_transfer").html("");
                    if(data != null && data.dash_approval_pendings.approvalpending !== undefined){
                        let approval_pending = data.dash_approval_pendings.approvalpending;
                        let download_pending = data.dash_approval_pendings.downloadpending;
                        if(approval_pending > 0 && download_pending > 0) {
                        Morris.Donut({
                            element: 'branch_transfer',
                            data: [
                            {label: "Approval Pending (Pcs)", value: data.dash_approval_pendings.approvalpending},
                            {label: "Download Pending (Pcs)", value: data.dash_approval_pendings.downloadpending}
                            ],
                            colors: [
                            "#ec5550", "#61b15a"
                            ]
                        });
                        }
                        else 
                        {
                            $("#branch_transfer").html('<div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Approval Pending</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+approval_pending+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Download Pending</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+download_pending+'</div></div>');
                        }
                    }
                    $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_lot_tag_details(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_lot_tag_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
				var dashboard_lot = base_url+'index.php/admin_ret_reports/dashboard_lot/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
				var dashboard_tag = base_url+'index.php/admin_ret_reports/dashboard_tag/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
				if(data != null && data.dash_lot_tag_details.lot_wt !== undefined){
                    $("#lot_pcs").html(data.dash_lot_tag_details.lot_pcs);
    				$("#lot_wt").html('<a href='+dashboard_lot +' target="_blank">'+data.dash_lot_tag_details.lot_wt+" g" + '</a>');
    				$("#tagged_pcs").html(data.dash_lot_tag_details.tagged_pcs);
    				$("#tagged_wt").html('<a href='+dashboard_tag +' target="_blank">'+data.dash_lot_tag_details.tagged_wt+" g" + '</a>');
				}
    				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_OrderDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_OrderDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    	$("#orders").html("");
                    	if(data != null && data.dash_orders_details.orderplaced !== undefined){
        				let orderplaced = data.dash_orders_details.orderplaced;
        				let orderreceived = data.dash_orders_details.orderreceived;
        				let ordersincart = data.dash_orders_details.ordersincart;
        				if(orderplaced > 0 && orderreceived > 0 && ordersincart > 0)
        				{
        					Morris.Donut({
        						element: 'orders',
        						data: [
        						  {label: "Placed", value: orderplaced},
        						  {label: "Received", value: orderreceived},
        						  {label: "Cart", value: ordersincart}
        						],
        						colors: [
        							"#f37121", "#8dc688", "#7b4b7d"
        						]
        					});
        				}
        				else
        				{
        					$("#orders").html('<div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Placed</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+orderplaced+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Received</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+orderreceived+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Cart</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+ordersincart+'</div></div>');
        				}
			            }
        				
        				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_StockDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_StockDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    	let g_opening_grosswt = parseFloat(data.dash_stock_details.g_opening_gwt).toFixed(2);
        				let g_sales_grosswt = parseFloat(data.dash_stock_details.g_tot_sales_gwt).toFixed(2);
        				let g_avail_grosswt = parseFloat(data.dash_stock_details.g_available_gwt).toFixed(2);
						let g_inward = parseFloat(data.dash_stock_details.g_inward_gwt).toFixed(2);		
						
						let g_opening_pcs = data.dash_stock_details.g_opening_pcs;
        				let g_tot_sales_pcs = data.dash_stock_details.g_tot_sales_pcs;
        				let g_available_pcs = data.dash_stock_details.g_available_pcs;
						let g_inward_pcs = data.dash_stock_details.g_inward_pcs;
						
        				let g_total_wt = parseFloat(g_opening_grosswt) + parseFloat(g_sales_grosswt) + parseFloat(g_avail_grosswt) + parseFloat(g_inward);
        
        				$("#opening_gwt").html(g_opening_grosswt + " GM / " + g_opening_pcs + " Pcs");
        				$("#tot_sales_gwt").html(g_sales_grosswt + " GM / " + g_tot_sales_pcs + " Pcs");
        				$("#available_gwt").html(g_avail_grosswt + " GM / " + g_available_pcs + " Pcs");
        				$("#tot_inward_gwt").html(g_inward + " GM / " + g_inward_pcs + " Pcs");
        				
        
        				let g_progress_openingwt = 0;
        				let g_progress_saleswt = 0;
        				let g_progress_availwt = 0;
						let g_progress_inward = 0;
						
        
        				if(g_total_wt > 0) {
        					g_progress_openingwt = Math.round((g_opening_grosswt / g_total_wt) * 100);
        					g_progress_saleswt = Math.round((g_sales_grosswt / g_total_wt) * 100);
        					g_progress_availwt = Math.round((g_avail_grosswt / g_total_wt) * 100);
							g_progress_inward = Math.round((g_inward / g_total_wt) * 100);	
        				}
        				
        				$("#progress_opening_gwt").css("width",g_progress_openingwt+"%");
        				$("#progress_tot_sales_gwt").css("width",g_progress_saleswt+"%");
        				$("#progress_available_gwt").css("width",g_progress_availwt+"%");
						$("#progress_tot_inward_gwt").css("width",g_progress_inward+"%");
        				
        				$("#stock_pie").html("");
        
        				if(g_opening_pcs > 0  && g_available_pcs > 0)
        				{
							Morris.Donut({
								element: 'stock_pie',
								data: [
									{label: "Opening (Pcs)", value: g_opening_pcs},
									{label: "Inward (Pcs)", value: g_inward_pcs},
									{label: "Sales (Pcs)", value: g_tot_sales_pcs},
									{label: "Closing (Pcs)", value: g_available_pcs}
								],
								colors: [
									"#3C8DBC", "#DD4B39", "#f39c12" , "#03A65A" 
								]
							});
        				}
        				else
        				{
        					$("#stock_pie").html('</br><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Opening Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+g_opening_pcs+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Sales Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+g_tot_sales_pcs+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Available Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+g_available_pcs+'</div></div>');
        				}
                        $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_silver_StockDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_silver_StockDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    	let s_opening_grosswt = parseFloat(data.dash_stock_details.s_opening_gwt).toFixed(2);
        				let s_sales_grosswt = parseFloat(data.dash_stock_details.s_tot_sales_gwt).toFixed(2);
        				let s_avail_grosswt = parseFloat(data.dash_stock_details.s_available_gwt).toFixed(2);
						let s_inward = parseFloat(data.dash_stock_details.s_inward_gwt).toFixed(2);
						
						let s_opening_pcs = data.dash_stock_details.s_opening_pcs;
        				let s_tot_sales_pcs = data.dash_stock_details.s_tot_sales_pcs;
        				let s_available_pcs = data.dash_stock_details.s_available_pcs;
						let s_inward_pcs = data.dash_stock_details.s_inward_pcs;
        				let s_total_wt = parseFloat(s_opening_grosswt) + parseFloat(s_sales_grosswt) + parseFloat(s_avail_grosswt) + parseFloat(s_inward);
        
        				$("#s_opening_gwt").html(s_opening_grosswt + " GM / " + s_opening_pcs + " Pcs");
        				$("#s_tot_sales_gwt").html(s_sales_grosswt + " GM / " + s_tot_sales_pcs + " Pcs");
        				$("#s_available_gwt").html(s_avail_grosswt + " GM / " + s_available_pcs + " Pcs");
        				$("#s_tot_inward_gwt").html(s_inward + " GM / " +  s_inward_pcs + " Pcs");
        				
        
        				let s_progress_openingwt = 0;
        				let s_progress_saleswt = 0;
        				let s_progress_availwt = 0;
						let s_progress_inward = 0;
						
        
        				if(s_total_wt > 0) {
        					s_progress_openingwt = Math.round((s_opening_grosswt / s_total_wt) * 100);
        					s_progress_saleswt = Math.round((s_sales_grosswt / s_total_wt) * 100);
        					s_progress_availwt = Math.round((s_avail_grosswt / s_total_wt) * 100);
							s_progress_inward = Math.round((s_inward / s_total_wt) * 100);
        					
        				}
        				
        
        				$("#s_progress_opening_gwt").css("width",s_progress_openingwt+"%");
        				$("#s_progress_tot_sales_gwt").css("width",s_progress_saleswt+"%");
        				$("#s_progress_available_gwt").css("width",s_progress_availwt+"%");
						$("#s_progress_tot_inward_gwt").css("width",s_progress_inward+"%");
        				
        				$("#s_stock_pie").html("");
        
        				if(s_opening_pcs > 0  && s_available_pcs > 0)
        				{
							Morris.Donut({
								element: 's_stock_pie',
								data: [
									{label: "Opening (Pcs)", value: s_opening_pcs},
									{label: "Inward (Pcs)", value: s_inward_pcs},
									{label: "Sales (Pcs)", value: s_tot_sales_pcs},
									{label: "Closing (Pcs)", value: s_available_pcs}
								],
								colors: [
									"#3C8DBC", "#DD4B39", "#f39c12" , "#03A65A" 
								]
							});
							
        				}
        				else
        				{
        					$("#s_stock_pie").html('</br><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Opening Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+s_opening_pcs+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Sales Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+s_tot_sales_pcs+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Available Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+s_available_pcs+'</div></div>');
        				}
                        $("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_ReorderDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_ReorderDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    	$("#reorder_items_table tbody").empty();
        				let reorder_items = data.dash_reorder_items;
        
        				let table_value = "";
        				$.each(reorder_items, function (index, element)  {
        					table_value = table_value+'<tr>'+
        					'<td>'+element.product_name+'</td>'+
        					'<td>'+element.design_name+'</td>'+
        					'<td>'+element.weight_name+'</td>'+
        					'<td><label class="label label-success">'+element.available_pcs+'</label></td>'+
        					'<td><label class="label label-info">'+parseFloat(element.min_pcs-element.available_pcs)+'</label></td>'+
        					'</tr>';
        				});
        
        				if(table_value != "") {
        					$("#reorder_items_table tbody").append(table_value);
        				} else {
        					table_value = "<tr><td colspan='5'>No Records found</td></tr>";
        					$("#reorder_items_table tbody").append(table_value);
        				}
        				
        				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
} 
function get_stock_details(from_date,to_date)
{
	//$("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
		 url:base_url+ "index.php/admin_ret_dashboard/get_stock_details?nocache=" + my_Date.getUTCSeconds(),
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 dataType:"JSON",
			 type:"POST",
			
			 cache:false,
			  success:function(data){ 
				$("#metal_stock_items_table tbody").empty();
				let metal = data.stock_details_dashboard;
                var id_branch=$('#id_branch').val();
				
				var table_value="";
				var op_blc_gwt=0;
				var	inw_gwt=0;
				var	br_out_gwt=0;
				var	sold_gwt=0;
				var	closing_gwt=0;
				$.each(metal, function (index, element)  {
					$.each(element, function (ind, val)  {
						let dashboard_stock = base_url+ "index.php/admin_ret_reports/get_stock_detail_list/list"+"/"+from_date+"/"+to_date+"/"+id_branch+"/"+val.id_metal;
					table_value += '<tr>'+
					'<td  style=" text-align:left;" ><b>'+val.metal_name+'</b></td>'+
					'<td style="text-align:right;" ><b><a href='+dashboard_stock+' target="_blank">'+val.op_blc_gwt+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href='+dashboard_stock+' target="_blank">'+val.inw_gwt+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href='+dashboard_stock+' target="_blank">'+val.br_out_gwt+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href='+dashboard_stock+' target="_blank">'+val.sold_gwt+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href='+dashboard_stock+' target="_blank">'+val.closing_gwt+'</a></b></td>'+
					'</tr>';
					op_blc_gwt+=parseFloat(val.op_blc_gwt);
					inw_gwt+=parseFloat(val.inw_gwt);
					br_out_gwt+=parseFloat(val.br_out_gwt);
					sold_gwt+=parseFloat(val.sold_gwt);
					closing_gwt+=parseFloat(val.closing_gwt);
				});
				});
				table_value_total = '<tr>'+
					'<td  style=" text-align:left;" ><b>Total </b></td>'+
					'<td style="text-align:right;" ><b><a href="" target="_blank">'+parseFloat(op_blc_gwt).toFixed(3)+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href="" target="_blank">'+parseFloat(inw_gwt).toFixed(3)+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href="" target="_blank">'+parseFloat(br_out_gwt).toFixed(3)+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href="" target="_blank">'+parseFloat(sold_gwt).toFixed(3)+'</a></b></td>'+
					'<td style="text-align:right;" ><b><a href="" target="_blank">'+parseFloat(closing_gwt).toFixed(3)+'</a></b></td>'+
					'</tr>';
				if(table_value != "") {
					$("#metal_stock_items_table tbody").html(table_value);
					$("#metal_stock_items_table tfoot").html(table_value_total);
				} else {
					table_value = "<tr><td colspan='6'>No Records found</td></tr>";
					$("#metal_stock_items_table tbody").html(table_value);
				}
						
				//		$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
			//	 $("div.overlay").css("display", "none"); 
			table_value = "<tr><td colspan='6'>No Records found</td></tr>";
					$("#metal_stock_items_table tbody").html(table_value);
			  }	 
	});
}
function get_KarigarOrderDetails()
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_KarigarOrderDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    	$("#karigar_today_delivered").html(data.karigar_orders.today_delivered);
        				$("#karigar_today_pending").html(data.karigar_orders.today_pending);
        				$("#karigar_tomm_delivered").html(data.karigar_orders.tm_delivery);
        
        				$("#karigar_pending_delivery").html(data.karigar_orders.over_due_orders);
        				$("#karigar_yet_to_delivery").html(data.karigar_orders.work_in_progress);
        				
        				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_CustomerOrderDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_customerOrderDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
					var dashboard_received = base_url+'index.php/admin_ret_reports/dashboard_customerorder/'+from_date+'/'+to_date+'/1/' + $('#id_branch').val();
					var dashboard_allocated = base_url+'index.php/admin_ret_reports/dashboard_customerorder/'+from_date+'/'+to_date+'/2/' + $('#id_branch').val();
					var dashboard_pending = base_url+'index.php/admin_ret_reports/dashboard_customerorder/'+from_date+'/'+to_date+'/3/' + $('#id_branch').val();
					var dashboard_ready = base_url+'index.php/admin_ret_reports/dashboard_customerorder/'+from_date+'/'+to_date+'/4/' + $('#id_branch').val();
					var dashboard_delivered = base_url+'index.php/admin_ret_reports/dashboard_customerorder/'+from_date+'/'+to_date+'/5/' + $('#id_branch').val();
					if(data != null && data.customer_order.received_piece !== undefined){
					
                    		$("#customer_today_received").html('<a href='+  dashboard_received +' target="_blank" style="color:#ffffff;">'+  data.customer_order.received_piece + '</a>');
            				$("#customer_today_allocated").html('<a href='+  dashboard_allocated +' target="_blank" style="color:#ffffff;">'+ data.customer_order.allocated_piece+ '</a>');
            				$("#customer_today_pending").html('<a href='+  dashboard_pending +' target="_blank" style="color:#ffffff;">'+ data.customer_order.pending_piece+ '</a>');
            				$("#customer_today_ready").html('<a href='+  dashboard_ready +' target="_blank" style="color:#ffffff;">'+ data.customer_order.ready_piece+ '</a>');
            				$("#customer_today_delivered").html('<a href='+  dashboard_delivered +' target="_blank" style="color:#ffffff;">'+ data.customer_order.delivery_piece+ '</a>');
					}
            				
            				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_MetalStockDetails()
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_MetalStockDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                    		$("#stock_total_gold_weight").html("-");
            				$("#stock_total_silver_weight").html("-");
            				$.each(data.stock_metal_details, function (index, element)  { 
            					let metal = element.metal;
            					let weight = element.total_gwt;
            					if(metal == 'GOLD')
            						$("#stock_total_gold_weight").html(weight+ " GM");
            					if(metal == 'SILVER')
            						$("#stock_total_silver_weight").html(weight+ " GM");
            				});
            				
            				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function get_CustomerDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_CustomerDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                        $("#new_customer_table tbody").empty();
        				let customer_details = data.dash_customer_details;
        
        				table_value = "";
        				$.each(customer_details, function (index, element)  {
        					table_value = table_value+'<tr>'+
        					'<td><div>'+element.firstname+'</div><div>'+element.mobile+'</div></td>'+
        					'<td>'+element.branchname+'</td>'+
        					'<td>'+element.jointhrough+'</td>'+
        					'</tr>';
        				});
        
        				if(table_value != "") {
        					$("#new_customer_table tbody").append(table_value);
        				} else {
        					table_value = "<tr><td colspan='3'>No Records found</td></tr>";
        					$("#new_customer_table tbody").append(table_value);
        				}
        				
        				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
} 
function get_RecentBillDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_RecentBillDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                        	$("#recent_bills_table tbody").empty();
            				let bill_details = data.dash_bills_details;
            				bill_details = group_by(bill_details, "branchname");
            				table_value = "";
            
            				$.each(bill_details, function (key, element)  {
            
            					let subArrLength = element.length;
            					table_value = table_value+'<tr>'+
            					'<td rowspan='+subArrLength+'>'+key+'</td>';
            
            					$.each(element, function (index, values)  {
            						table_value = table_value+
            						'<td>'+values.bill_no+'</td>'+
            						'<td>'+values.cusname+'</td>'+
            						'<td>'+values.billtype+'</td>'+
            						'<td>'+values.billamount+'</td>'+
            						'</tr>';
            					});
            
            				});
            
            				if(table_value != "") {
            					$("#recent_bills_table tbody").append(table_value);
            				} else {
            					table_value = "<tr><td colspan='5'>No Records found</td></tr>";
            					$("#recent_bills_table tbody").append(table_value);
            				}
            				
            				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
} 
function get_cash_abstract_details(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_cash_abstract_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                        	let cash_abs = data.dash_cash_abstarct_details;
            				$("#sales_amount").html(money_format_india(cash_abs.sales_amount));
            				$("#sales_total_tax_amount").html(money_format_india(cash_abs.sales_total_tax_amount));
            				$("#sales_return").html(money_format_india(cash_abs.sales_return));
            				$("#sales_return_total_tax_amount").html(money_format_india(cash_abs.sales_return_total_tax_amount));
            				$("#purchase_amount").html(money_format_india(cash_abs.purchase_amount));
            				$("#advance_receipt").html(money_format_india(cash_abs.advance_receipt));
            				$("#credit_sale").html(money_format_india(cash_abs.credit_sale));
            				$("#credit_receipt").html(money_format_india(cash_abs.credit_receipt));
            				$("#handling_charge").html(money_format_india(cash_abs.handling_charge));
            				$("#trans_total").html(money_format_india(cash_abs.trans_total));
            				$("#cash").html(money_format_india(cash_abs.cash));
            				$("#chq").html(money_format_india(cash_abs.chq));
            				$("#card").html(money_format_india(cash_abs.card));
            				$("#nb").html(money_format_india(cash_abs.nb));
            				$("#advadj").html(money_format_india(cash_abs.advadj));
            				$("#chituti").html(money_format_india(cash_abs.chituti));
            				$("#handlingcharge").html(money_format_india(cash_abs.handlingcharge));
            				$("#orderadj").html(money_format_india(cash_abs.orderadj));
            				$("#giftvoucher").html(money_format_india(cash_abs.giftvoucher));
            				$("#roundoff").html(money_format_india(cash_abs.roundoff));
            				$("#paymodes_total").html(money_format_india(cash_abs.paymodes_total));
							$("#advance_deposit").html(money_format_india(cash_abs.advance_deposit));
            				$("#other_expenses").html(money_format_india(cash_abs.other_expense));
            				
            				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
} 
function getEstimationDetails(from_date,to_date)
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/getEstimationDetails?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
                        	$("#estimation_details_table tbody").empty();
            				let estimation_details = data.dash_estimation_details;
            				estimation_details = group_by(estimation_details, "branchname");
            				table_value = "";
            
            				$.each(estimation_details, function (key, element)  {
            
            					let subArrLength = element.length;
            					table_value = table_value+'<tr>'+
            					'<td rowspan='+subArrLength+'>'+key+'</td>';
            
            					$.each(element, function (index, values)  {
            						table_value = table_value+
            						'<td>'+values.esti_no+'</td>'+
            						'<td>'+values.cusname+'</td>'+
            						'<td>'+values.estamount+'</td>'+
            						'<td>'+values.purchase_status+'</td>'+
            						'</tr>';
            					});
            				});
            				
            				if(table_value != "") {
            					$("#estimation_details_table tbody").append(table_value);
            				} else {
            					table_value = "<tr><td colspan='5'>No Records found</td></tr>";
            					$("#estimation_details_table tbody").append(table_value);
            				}
            				
            				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
} 
function retail_dashboard_details_old(from_date,to_date)  // this is old function dont call in any where
{
	my_Date = new Date();
	$.ajax({
			 url:base_url+ "index.php/admin_ret_dashboard/get_retail_dashboard_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date},
			 type:"POST",
			 cache:false,
			 success:function(data){ 
			     
			     if(data != null && data.estimation !== undefined){
				var estimation 	    = data.estimation;
				var billing 	    = data.billing;
				$('#live_estimation').text(estimation.estimation);
				$('#billing').text(billing.billing);
				$("#cp_estimation_created").html(data.dash_estmation.created);
				
				$("#cp_estimation_converted").html(data.dash_estmation.sold);
				$("#cp_sales_bills").html(data.dash_billing.bills);
				
				// $("#cp_sales_amount").html(data.dash_billing.billamount);
				$("#cp_virtual_tag_homesale_pcs").html(data.dash_virturaltag_details.homesale_pcs);
				
				$("#cp_virtual_tag_homesale_wt").html(data.dash_virturaltag_details.homesale_wt+" g");
				$("#cp_virtual_tag_tagsplit_pcs").html(data.dash_virturaltag_details.tagsplit_pcs);
				
				$("#cp_virtual_tag_tagsplit_wt").html(data.dash_virturaltag_details.tagsplit_wt+" g");
				$("#old_metal_purchase_gold").html("-");
				$("#old_metal_purchase_silver").html("-");
				$.each(data.dash_old_metal_purchase, function (index, element)  { 
					let metal_type = element.metal_type;
					let weight = element.weight;
					if(metal_type == 1)
						$("#old_metal_purchase_gold").html(weight+ " g");
					if(metal_type == 2)
						$("#old_metal_purchase_silver").html(weight+ " g");
				});
				$("#tot_bill_amt").html(curr_symbol+data.dash_credeit_sales.tot_bill_amt);
				
				$("#creditreceived").html(curr_symbol+data.dash_credeit_sales.creditreceived);
				$("#gift_tot_utlized").html(curr_symbol+data.dash_gift_vouchers.tot_utlized);
				
				$("#gift_tot_issued").html(curr_symbol+data.dash_gift_vouchers.tot_issued);
				$("#gift_tot_sold").html(curr_symbol+data.dash_gift_vouchers.tot_sold);
				$("#totalnewcusbill").html(data.dash_bills_clasfication.totalnewcusbill);
				
				$("#newcisbillsalewt").html(data.dash_bills_clasfication.newcisbillsalewt+" g");
				$("#newcusbillsale").html(curr_symbol+data.dash_bills_clasfication.newcusbillsale);
				$("#totaloldcusbill").html(data.dash_bills_clasfication.totaloldcusbill);
				
				$("#oldcusbillsalewt").html(data.dash_bills_clasfication.oldcusbillsalewt+" g");
				$("#oldcusbillsale").html(curr_symbol+data.dash_bills_clasfication.oldcusbillsale);
				$("#branch_transfer").html("");
				let approval_pending = data.dash_approval_pendings.approvalpending;
				let download_pending = data.dash_approval_pendings.downloadpending;
				if(approval_pending > 0 && download_pending > 0) {
					Morris.Donut({
						element: 'branch_transfer',
						data: [
						{label: "Approval Pending (Pcs)", value: data.dash_approval_pendings.approvalpending},
						{label: "Download Pending (Pcs)", value: data.dash_approval_pendings.downloadpending}
						],
						colors: [
							"#ec5550", "#61b15a"
						]
					});
				} else {
					$("#branch_transfer").html('<div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Approval Pending</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+approval_pending+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Download Pending</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+download_pending+'</div></div>');
				}
				$("#lot_pcs").html(data.dash_lot_tag_details.lot_pcs);
				
				$("#lot_wt").html(data.dash_lot_tag_details.lot_wt+" g");
				$("#tagged_pcs").html(data.dash_lot_tag_details.tagged_pcs);
				
				$("#tagged_wt").html(data.dash_lot_tag_details.tagged_wt+" g");
				$("#orders").html("");
				let orderplaced = data.dash_orders_details.orderplaced;
				let orderreceived = data.dash_orders_details.orderreceived;
				let ordersincart = data.dash_orders_details.ordersincart;
				if(orderplaced > 0 && orderreceived > 0 && ordersincart > 0)
				{
					Morris.Donut({
						element: 'orders',
						data: [
						  {label: "Placed", value: orderplaced},
						  {label: "Received", value: orderreceived},
						  {label: "Cart", value: ordersincart}
						],
						colors: [
							"#f37121", "#8dc688", "#7b4b7d"
						]
					});
				}
				else
				{
					$("#orders").html('<div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Placed</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+orderplaced+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Received</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+orderreceived+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Cart</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+ordersincart+'</div></div>');
				}
				let opening_grosswt = data.dash_stock_details.opening_gwt;
				let sales_grosswt = data.dash_stock_details.tot_sales_gwt;
				let avail_grosswt = data.dash_stock_details.available_gwt;
				let total_wt = parseFloat(opening_grosswt) + parseFloat(sales_grosswt) + parseFloat(avail_grosswt);
				$("#opening_gwt").html(opening_grosswt);
				$("#tot_sales_gwt").html(sales_grosswt);
				$("#available_gwt").html(avail_grosswt);
				let progress_openingwt = 0;
				let progress_saleswt = 0;
				let progress_availwt = 0;
				if(total_wt > 0) {
					progress_openingwt = Math.round((opening_grosswt / total_wt) * 100);
					progress_saleswt = Math.round((sales_grosswt / total_wt) * 100);
					progress_availwt = Math.round((avail_grosswt / total_wt) * 100);
				}
				$("#opening_gwt").html(opening_grosswt);
				$("#tot_sales_gwt").html(sales_grosswt);
				$("#available_gwt").html(avail_grosswt);
				$("#progress_opening_gwt").css("width",progress_openingwt+"%");
				$("#progress_tot_sales_gwt").css("width",progress_saleswt+"%");
				$("#progress_available_gwt").css("width",progress_availwt+"%");
				let opening_pcs = data.dash_stock_details.opening_pcs;
				let tot_sales_pcs = data.dash_stock_details.tot_sales_pcs;
				let available_pcs = data.dash_stock_details.available_pcs;
				$("#stock_pie").html("");
				if(opening_pcs > 0 && tot_sales_pcs > 0 && available_pcs > 0)
				{
					Morris.Donut({
						element: 'stock_pie',
						data: [
						  {label: "Opening", value: opening_pcs},
						  {label: "Sales", value: tot_sales_pcs},
						  {label: "Available", value: available_pcs}
						],
						colors: [
							"#3C8DBC", "#DD4B39", "#00A65A"
						]
					});
				}
				else
				{
					$("#stock_pie").html('<div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Opening Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+opening_pcs+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Sales Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+tot_sales_pcs+'</div></div><div class="col-md-12 col-xs-12 no-paddingwidth inside-items"><div class="col-md-7 col-xs-7 no-paddingwidth label-text">Available Pcs</div><div class="col-md-5 col-xs-5 no-paddingwidth label-value">'+available_pcs+'</div></div>');
				}
				$("#reorder_items_table tbody").empty();
				let reorder_items = data.dash_reorder_items;
				let table_value = "";
				$.each(reorder_items, function (index, element)  {
					table_value = table_value+'<tr>'+
					'<td>'+element.product_name+'</td>'+
					'<td>'+element.design_name+'</td>'+
					'<td>'+element.weight_name+'</td>'+
					'<td><label class="label label-success">'+element.available_pcs+'</label></td>'+
					'<td><label class="label label-info">'+element.min_pcs+'</label></td>'+
					'</tr>';
				});
				if(table_value != "") {
					$("#reorder_items_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='5'>No Records found</td></tr>";
					$("#reorder_items_table tbody").append(table_value);
				}
				$("#karigar_today_delivered").html(data.karigar_orders.today_delivered);
				$("#karigar_today_pending").html(data.karigar_orders.today_pending);
				$("#karigar_tomm_delivered").html(data.karigar_orders.tm_delivery);
				$("#karigar_pending_delivery").html(data.karigar_orders.over_due_orders);
				$("#karigar_yet_to_delivery").html(data.karigar_orders.work_in_progress);
				$("#customer_today_delivered").html(data.customer_orders.today_delivered);
				$("#customer_today_pending").html(data.customer_orders.today_pending);
				$("#customer_tomm_delivery_ready").html(data.customer_orders.tm_ready_for_delivery);
				$("#customer_tomm_pending").html(data.customer_orders.today_delivered);
				$("#customer_pending_delivery").html(data.customer_orders.over_due_orders);
				$("#customer_yet_to_delivery").html(data.customer_orders.work_in_progress);
				$("#stock_total_gold_weight").html("-");
				$("#stock_total_silver_weight").html("-");
				$.each(data.stock_metal_details, function (index, element)  { 
					let metal = element.metal;
					let weight = element.total_gwt;
					if(metal == 'GOLD')
						$("#stock_total_gold_weight").html(weight+ " GM");
					if(metal == 'SILVER')
						$("#stock_total_silver_weight").html(weight+ " GM");
				});
				$("#new_customer_table tbody").empty();
				let customer_details = data.dash_customer_details;
				table_value = "";
				$.each(customer_details, function (index, element)  {
					table_value = table_value+'<tr>'+
					'<td><div>'+element.firstname+'</div><div>'+element.mobile+'</div></td>'+
					'<td>'+element.branchname+'</td>'+
					'<td>'+element.jointhrough+'</td>'+
					'</tr>';
				});
				if(table_value != "") {
					$("#new_customer_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='3'>No Records found</td></tr>";
					$("#new_customer_table tbody").append(table_value);
				}
				
				$("#recent_bills_table tbody").empty();
				let bill_details = data.dash_bills_details;
				bill_details = group_by(bill_details, "branchname");
				table_value = "";
				$.each(bill_details, function (key, element)  {
					let subArrLength = element.length;
					table_value = table_value+'<tr>'+
					'<td rowspan='+subArrLength+'>'+key+'</td>';
					$.each(element, function (index, values)  {
						table_value = table_value+
						'<td>'+values.bill_no+'</td>'+
						'<td>'+values.cusname+'</td>'+
						'<td>'+values.billtype+'</td>'+
						'<td>'+values.billamount+'</td>'+
						'</tr>';
					});
				});
				if(table_value != "") {
					$("#recent_bills_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='5'>No Records found</td></tr>";
					$("#recent_bills_table tbody").append(table_value);
				}
				let cash_abs = data.dash_cash_abstarct_details;
				$("#sales_amount").html(cash_abs.sales_amount);
				$("#sales_total_tax_amount").html(cash_abs.sales_total_tax_amount);
				$("#sales_return").html(cash_abs.sales_return);
				$("#sales_return_total_tax_amount").html(cash_abs.sales_return_total_tax_amount);
				$("#purchase_amount").html(cash_abs.purchase_amount);
				$("#advance_receipt").html(cash_abs.advance_receipt);
				$("#credit_sale").html(cash_abs.credit_sale);
				$("#credit_receipt").html(cash_abs.credit_receipt);
				$("#handling_charge").html(cash_abs.handling_charge);
				$("#trans_total").html(cash_abs.trans_total);
				$("#cash").html(cash_abs.cash);
				$("#chq").html(cash_abs.chq);
				$("#card").html(cash_abs.card);
				$("#nb").html(cash_abs.nb);
				$("#advadj").html(cash_abs.advadj);
				$("#chituti").html(cash_abs.chituti);
				$("#handlingcharge").html(cash_abs.handlingcharge);
				$("#orderadj").html(cash_abs.orderadj);
				$("#giftvoucher").html(cash_abs.giftvoucher);
				$("#roundoff").html(cash_abs.roundoff);
				$("#paymodes_total").html(cash_abs.paymodes_total);
				$("#estimation_details_table tbody").empty();
				let estimation_details = data.dash_estimation_details;
				estimation_details = group_by(estimation_details, "branchname");
				table_value = "";
				$.each(estimation_details, function (key, element)  {
					let subArrLength = element.length;
					table_value = table_value+'<tr>'+
					'<td rowspan='+subArrLength+'>'+key+'</td>';
					$.each(element, function (index, values)  {
						table_value = table_value+
						'<td>'+values.esti_no+'</td>'+
						'<td>'+values.cusname+'</td>'+
						'<td>'+values.estamount+'</td>'+
						'<td>'+values.purchase_status+'</td>'+
						'</tr>';
					});
				});
				
				if(table_value != "") {
					$("#estimation_details_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='5'>No Records found</td></tr>";
					$("#estimation_details_table tbody").append(table_value);
				}
			     }
		 	 },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
function sales_dashboard_data(from_date, to_date)
{
	my_Date = new Date();
	$.ajax({
			 url:base_url+ "index.php/admin_ret_dashboard/get_SaleBill_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date},
			 type:"POST",
			 cache:false,
			 success:function(data){
				let table_value = "";
				let cw_records = data.categorywise_records;
				let mw_records = data.metalwise_records;
				let pw_records = data.paymentwise_records;
				let category_wise = Array();
				$("#sales_table tbody").empty();
				$.each(cw_records, function (key1, element1)  {
					let branch_name = element1.branch_name;
					let br_wise_details = element1.branchwise_sales_details;
					let br_wise_length = br_wise_details.length;
					if(br_wise_length > 0) {
						let subArrLength = br_wise_length == 0 ? 1 : br_wise_length;
						table_value = table_value+'<tr>'+
						'<td rowspan='+subArrLength+'>'+branch_name+'</td>';
						$.each(br_wise_details, function (bwd_key, bwd_element)  {
							category_wise.push(bwd_element);
							table_value = table_value+
							'<td>'+bwd_element.category_name+'</td>'+
							'<td class="numbers">'+bwd_element.sold_weight+'</td>'+
							'<td class="numbers">'+(bwd_element.green_tag == null ? 0 : bwd_element.green_tag)+'</td>'+
							'</tr>';
						});
					}
				});
				if(table_value != "") {
					$("#sales_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='4'>No Records found</td></tr>";
					$("#sales_table tbody").append(table_value);
				}
			
				category_wise = group_by(category_wise, "category_name");
				console.log("category_wise",category_wise);
				table_value = "";
				$("#payment_wise_table tbody").empty();
				$.each(pw_records, function (key2, element2)  {
					let branch_name = element2.branch_name;
					let pr_wise_details = element2.paymentwise_sales_details;
					let pr_wise_length = pr_wise_details.length;
					if(pr_wise_length > 0) {
						let subArrLength = pr_wise_length == 0 ? 1 : pr_wise_length;
						table_value = table_value+'<tr>'+
						'<td rowspan='+subArrLength+'>'+branch_name+'</td>';
						$.each(pr_wise_details, function (pwd_key, pwd_element)  {
							table_value = table_value+
							'<td>'+pwd_element.payment_mode+'</td>'+
							'<td class="numbers">'+pwd_element.amount+'</td>'+
							'</tr>';
						});
					}
				});
				if(table_value != "") {
					$("#payment_wise_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='3'>No Records found</td></tr>";
					$("#payment_wise_table tbody").append(table_value);
				}
				table_value = "";
				$("#metal_wise_table tbody").empty();
				$.each(mw_records, function (key3, element3)  {
					let branch_name = element3.branch_name;
					let mt_wise_details = element3.metalwise_sales_details;
					let mt_wise_length = mt_wise_details.length;
					if(mt_wise_length > 0) {
						let subArrLength = mt_wise_length == 0 ? 1 : mt_wise_length;
						table_value = table_value+'<tr>'+
						'<td rowspan='+subArrLength+'>'+branch_name+'</td>';
						$.each(mt_wise_details, function (pwd_key, mwd_element)  {
							table_value = table_value+
							'<td>'+mwd_element.metal+'</td>'+
							'<td class="numbers">'+mwd_element.sold_weight+'</td>'+
							'</tr>';
						});
					}
				});
				if(table_value != "") {
					$("#metal_wise_table tbody").append(table_value);
				} else {
					table_value = "<tr><td colspan='3'>No Records found</td></tr>";
					$("#metal_wise_table tbody").append(table_value);
				}
			},
			error:function(error)  
			{
			   $("div.overlay").css("display", "none"); 
			}	 
  });
}
function group_by(objArr, keyname)
{
	let result = objArr.reduce(function (r, a) {
		r[a[keyname]] = r[a[keyname]] || [];
		r[a[keyname]].push(a);
		return r;
	}, Object.create(null));
	return result;
}
function get_branch_order(from_date="",to_date="")
{
	my_Date = new Date();  
	$.ajax({
	  	  url:base_url+ "index.php/admin_ret_dashboard/get_order_data?nocache=" + my_Date.getUTCSeconds(),
		  data:{'from_date':from_date,'to_date':to_date},
    	 dataType:"JSON",
    	 type:"POST",
    	 success:function(data){ 
		    // console.log(data);
            if(data != null && data.order !== undefined){
    	 	    set_branch_order(data,from_date,to_date); 
            }
    	  },
    	  error:function(error)  
    	  {
    	  $("div.overlay").css("display", "none"); 
    	  }	 
	  });
}
function set_branch_order(data,from_date,to_date)
{
	$('#order-data tbody').remove();
	$('#catalog').text(data.tot_catalog);
	$('#custom').text(data.tot_custom);
	$('#repair').text(data.tot_repair);
    $.each(data['order'], function (index, element) 
	{ 
		        id_branch = element.id_branch; 
				
				  $('#order-data').append(
                  $('<tbody><tr>')
				  .append($('<td style="text-align: centre;padding: 5px;">').append(element.branch_name))
                  .append($('<td style="text-align: centre;padding: 5px;">').append(element.catalog))
                  .append($('<td style="text-align: centre;padding: 5px;">').append(element.custom))
				  .append($('<td style="text-align: centre;padding: 5px;">').append(element.repair))
				  );
		 });
}
function sales_details(from_date,to_date)
{
	$('#sale_details tbody').remove();
	$('#tot_bills').text('');
	my_Date = new Date();
	$.ajax({
			 url:base_url+ "index.php/admin_ret_dashboard/get_sales_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date},
			 type:"POST",
			 cache:false,
			 success:function(data){ 
			     
			     if(data.sales_details != undefined){
        				if(data.sales_details.length>0)
        
        				{
        
        					var total_bills=0;
        
        					$.each(data.sales_details, function (index, element) 
        
        					{ 
        
        						total_bills+=parseFloat(element.billing);
        
        						$('#sale_details').append(
        
        						$('<tbody><tr>')
        
        						.append($('<td style="text-align: centre;padding: 5px;">').append(element.branch_name))
        
        						.append($('<td style="text-align: centre;padding: 5px;">').append(element.billing))
        
        						);
        
        					});
        
        					$('#tot_bills').html(total_bills);
        
        				}
				
			     }
		 	 },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
	
}
function get_average_bill_value()
{
	$('#avg_details tbody').remove();
	$('#tot_bills').text('');
	my_Date = new Date();
	$.ajax({
			 url:base_url+ "index.php/admin_ret_dashboard/get_MetalBill_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 type:"POST",
			 cache:false,
			 success:function(data){ 
				if(data.sales_details.length>0)
				{
					var total_bills=0;
					var html='';
					$.each(data.sales_details, function (index, element) 
					{ 
						total_bills+=parseFloat(element.billing);
						var avg_amt=parseFloat(element.sale_amount/element.billing).toFixed(2);
						$('#avg_details').append(
						$('<tbody><tr>')
						.append($('<td style="text-align: centre;padding: 5px;">').append(element.branch_name))
						.append($('<td style="text-align: centre;padding: 5px;">').append(element.metal))
						.append($('<td style="text-align: centre;padding: 5px;">').append(avg_amt))
						);	
					});
					$('#tot_bills').html(total_bills);
				}
		 	 },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
 function get_branchname()
 {	
    $(".overlay").css('display','block');	
    $.ajax({		
    type: 'GET',		
    url: base_url+'index.php/branch/branchname_list',		
    dataType:'json',		
    success:function(data){				 
    var id_branch =  $('#id_branch').val();	
    
     $("#branch_select,.branch_filter").append(						
        $("<option></option>")						
        .attr("value", 0)						  						  
        .text('All' )
    );
    
    $.each(data.branch, function (key, item) {
        $("#branch_select").append(						
            $("<option></option>")						
            .attr("value", item.id_branch)						  						  
            .text(item.name )						  					
        );			   											
    });						
    $("#branch_select").select2({			    
        placeholder: "Select Branch",			    
        allowClear: true		    
    });					
    if($("#branch_select").length || $(".ret_branch").length){
     $("#branch_select").select2("val",(id_branch!='' && id_branch>0?id_branch:''));	 
    }   
    $(".overlay").css("display", "none");			
    }	
    }); 
}
//Order Managent Details
function get_customer_order_details(from_date,to_date)
{
    $("#customer_order_table tbody").empty();
    $("#cus_order_details tbody").empty();
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_customer_order_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			  success:function(data){ 
            var table_value='';      
            var cus_details=''; 
            var total_pcs=0;
            var total_wt=0;
                $.each(data.cus_orders_details,function(key,items){
                    total_pcs+=parseFloat(items.totalitems);
                    total_wt+=parseFloat(items.weight);
                    cus_details+='<tr>'+
                                        '<td>'+items.branch_name+'</td>'+
                                        '<td>'+items.cus_name+'</td>'+
                                        '<td>'+items.product_name+'</td>'+
                                        '<td>'+(items.weight+'/'+items.totalitems)+'</td>'+
                                        '<td>'+items.order_status+'</td>'+
                                 '</tr>'
                });
                $('.total_pcs').html(parseFloat(total_wt).toFixed(3)+'/'+total_pcs);
                $("#cus_order_details tbody ").append(cus_details);
                
        		$.each(data.cus_orders, function (bwd_key, bwd_element)  {	
        		    var pending_url = base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=0&filter_type=1&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    var order_placed_url = base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=3&filter_type=1&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    
        		    var karigar_pending_url = base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=0&filter_type=4&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    var karigar_delivered_url = base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=4&filter_type=7&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    var karigar_over_due_url = base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=3&filter_type=6&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    
        		    var customer_pending_url = base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=3&filter_type=3&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    var customer_delivery_ready_url= base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=4&filter_type=7&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    var customer_delivered_url= base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=5&filter_type=2&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    var customer_over_due_url= base_url+'index.php/admin_ret_reports/order_status/list/?order_staus=3&filter_type=5&id_branch='+bwd_element.order_from+'&from_date='+from_date+'&to_date='+to_date;
        		    
					table_value +='<tr>'+				
    					'<td>'+bwd_element.branch_name+'</td>'+
    					'<td class="numbers"><a href='+pending_url+' target="_blank">'+(bwd_element.allocation_pending_wt+'/'+bwd_element.allocation_pending_pcs)+'</td>'+		
    					'<td class="numbers"><a href='+order_placed_url+' target="_blank">'+(bwd_element.allocation_done_wt+'/'+bwd_element.allocation_done_pcs)+'</td>'+		
    					'<td class="numbers"><a href='+karigar_pending_url+' target="_blank">'+(bwd_element.karigar_pending_wt+'/'+bwd_element.karigar_pending_pcs)+'</a></td>'+
    					'<td class="numbers"><a href='+karigar_delivered_url+' target="_blank">'+(bwd_element.karigar_delivered_wt+'/'+bwd_element.karigar_delivered_pcs)+'</a></td>'+
    					'<td class="numbers"><a href='+karigar_over_due_url+' target="_blank" '+(bwd_element.karigar_over_due_pcs>0 ? 'style="color:red;"' :'')+' >'+(bwd_element.karigar_over_due_wt+'/'+bwd_element.karigar_over_due_pcs)+'</a></td>'+
    					'<td class="numbers"><a href='+customer_pending_url+' target="_blank">'+(bwd_element.cus_pending_wt+'/'+bwd_element.cus_pending_pcs)+'</a></td>'+
    					'<td class="numbers"><a href='+customer_delivery_ready_url+' target="_blank" >'+(bwd_element.cus_delivery_ready_wt+'/'+bwd_element.cus_delivery_ready_pcs)+'</a></td>'+
    					'<td class="numbers"><a href='+customer_delivered_url+' target="_blank">'+(bwd_element.cus_delivered_wt+'/'+bwd_element.cus_delivered_pcs)+'</a></td>'+
    					'<td class="numbers"><a href='+customer_over_due_url+' target="_blank" '+(bwd_element.cus_over_due_pcs>0 ? 'style="color:red;"' :'')+'>'+(bwd_element.cus_over_due_wt+'/'+bwd_element.cus_over_due_pcs)+'</a></td>'+
    					'</tr>';   
					}); 
				$("#customer_order_table tbody").append(table_value);
        		$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
} 
//chart details
function get_salesDetails()
{
    $("div.overlay").css("display", "block"); 
    let from_date =  $('#payment_list1').text();						    				 
	let to_date   =  $('#payment_list2').text();	
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_saleschart_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			 async: false,
			  success:function(saledata){ 
				var currencySymbol = "<i class='fa fa-inr'></i>";
				$('#sale_total_value').html(currencySymbol + saledata.sales_summary.total_sales_amount);
				$('#sales_estimated').html(saledata.sales_summary.total_est);
				$('#sales_returned').html(saledata.sales_summary.total_sales_ret);
				$('#sales_credit').html(saledata.sales_summary.total_credit_issued);
				$('#sales_green_tag').html(saledata.sales_summary.total_green_tag_amt);
				$('#sales_gross_profit').html(currencySymbol + saledata.sales_summary.total_profit_amt);
				
				var data = google.visualization.arrayToDataTable([
					  ['Type', 'No.of.Tags'],
					  ['Billed',  parseInt(saledata.sales_summary.total_est_billed)],
					  ['Non Billed',  parseInt(saledata.sales_summary.total_est) - parseInt(saledata.sales_summary.total_est_billed)],
					]);
					var options = {
					  pieHole: 0.5,
					  pieSliceTextStyle: {
						color: 'black',
					  },
					  legend: 'none',
					  title: 'Estimate Vs Billed',
					  is3D: true
					};
					var chart = new google.visualization.PieChart(document.getElementById('sales_converted'));
					chart.draw(data, options);
					
					
					var sales_branch_data = new google.visualization.DataTable();
					sales_branch_data.addColumn('string', 'Branch');
					sales_branch_data.addColumn('number', 'Sales');
					var row_sale_branch = [];
					$.each( saledata.sales_details.sales_by_branch, function( key, value ) {
						var branch_val = [];
						branch_val[0] = value.branch_name;
						branch_val[1] = parseFloat(value.amount);
						row_sale_branch[key] = branch_val;
					});
					
					sales_branch_data.addRows(row_sale_branch);
					
					var sales_branch_options = {
					  legend: 'none'
					};
					
					var sales_branch_chart = new google.charts.Bar(document.getElementById("sales_by_branch"));
					sales_branch_chart.draw(sales_branch_data, google.charts.Bar.convertOptions(sales_branch_options));
					
				
					
				
					var sales_mode_data = new google.visualization.DataTable();
					sales_mode_data.addColumn('string', 'Mode');
					sales_mode_data.addColumn('number', 'Amount');
					var row_mode_coll = [];
					$.each( saledata.sales_details.sales_by_pay_mode, function( key, value ) {
						var coll_mod_val = [];
						coll_mod_val[0] = value.payment_mode;
						coll_mod_val[1] = parseFloat(value.amount);
						row_mode_coll[key] = coll_mod_val;
					});
					
					sales_mode_data.addRows(row_mode_coll);
					
					var sales_mod_options = {
					  legend: 'none'
					};
					
					var sales_mod_chart = new google.visualization.BarChart(document.getElementById("sales_pay_mode"));
					sales_mod_chart.draw(sales_mode_data, sales_mod_options);
					
					
					var sales_pro_data = new google.visualization.DataTable();
					sales_pro_data.addColumn('string', 'product');
					sales_pro_data.addColumn('number', 'Sales');
					var row_sale_pro = [];
				/*	$.each( saledata.sales_details.sales_by_product, function( key, value ) {
						var pro_val = [];
						pro_val[0] = value.pro_short_name;
						pro_val[1] = parseFloat(value.amount);
						row_sale_pro[key] = pro_val;
					});
					*/
					sales_pro_data.addRows(row_sale_pro);
					
					var sales_pro_options = {
					  legend: 'none',
					  colors: ['red','blue'],
					};
					
					var sales_pro_chart = new google.charts.Bar(document.getElementById("sales_by_product"));
					sales_pro_chart.draw(sales_pro_data, google.charts.Bar.convertOptions(sales_pro_options));
					
					var cus_data = google.visualization.arrayToDataTable([
					  ['Type', 'Visit'],
					  ['New',  parseInt(saledata.sales_summary.total_new_cus)],
					  ['Old',  parseInt(saledata.sales_summary.total_old_cus)],
					]);
					var cus_options = {
					  pieHole: 0.5,
					  pieSliceTextStyle: {
						color: 'black',
					  },
					  legend: 'none',
					  is3D: true,
					  width: '100%', 
					  height: 200
					};
					var chart = new google.visualization.PieChart(document.getElementById('sales_customer_visit'));
					chart.draw(cus_data, cus_options);
					
					
				
            
        		$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
//chart details
//stock chart details
function get_stockDetails()
{
    $("div.overlay").css("display", "block"); 
    let from_date =  $('#payment_list1').text();						    				 
	let to_date   =  $('#payment_list2').text();	
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_stockchart_details?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},
			 type:"POST",
			 cache:false,
			 async: false,
			  success:function(stockdata){ 
				var branch_stock_data = new google.visualization.DataTable();
					branch_stock_data.addColumn('string', 'Branch');
					branch_stock_data.addColumn('number', 'Opening');
					branch_stock_data.addColumn('number', 'Inward');
					branch_stock_data.addColumn('number', 'Sales');
					branch_stock_data.addColumn('number', 'Closing');
					var row_stock_coll = [];
			/*		$.each( stockdata.stock_by_branch, function( key, value ) {
						var stock_val = [];
						stock_val[0] = value.branch_name;
						stock_val[1] = parseInt(value.opening_pcs);
						stock_val[2] = parseInt(value.inw_pcs);
						stock_val[3] = parseInt(value.tot_sales_pcs);
						stock_val[4] = parseInt(value.available_pcs);
						row_stock_coll[key] = stock_val;
					});
					
					branch_stock_data.addRows(row_stock_coll);
					
					var brch_stock_options = {
					  legend: 'none'
					};
					
					var branch_stock_chart = new google.charts.Bar(document.getElementById("stock_by_branch"));
					branch_stock_chart.draw(branch_stock_data, google.charts.Bar.convertOptions(brch_stock_options));
					*/
            
			
					
			/*	var stock_pro_data = new google.visualization.DataTable();
					stock_pro_data.addColumn('string', 'Product');
					stock_pro_data.addColumn('number', 'Stock(Pcs)');
					var row_stock_pro = [];
					$.each( stockdata.stock_by_product, function( key, value ) {
						var pro_val = [];
						pro_val[0] = value.pro_short_name;
						pro_val[1] = parseInt(value.pcs);
						row_stock_pro[key] = pro_val;
					});
					
					stock_pro_data.addRows(row_stock_pro);
					
					var stock_pro_options = {
					  legend: 'none',
					  colors: ['red','blue'],
					};
					
					var stock_pro_chart = new google.charts.Bar(document.getElementById("stock_by_product"));
					stock_pro_chart.draw(stock_pro_data, google.charts.Bar.convertOptions(stock_pro_options));*/
					
				var bt_approval_data = new google.visualization.DataTable();
					bt_approval_data.addColumn('string', 'Branch');
					bt_approval_data.addColumn('number', 'Intransit(Pcs)');
					bt_approval_data.addColumn('number', 'Yet to Approve(Pcs)');
					var row_bt_app = [];
					$.each( stockdata.branch_transfer_details, function( key, value ) {
						var bt_appr_val = [];
						bt_appr_val[0] = value.branch_name;
						bt_appr_val[1] = parseInt(value.intransit_pcs);
						bt_appr_val[2] = parseInt(value.yet_to_approve_pcs);
						row_bt_app[key] = bt_appr_val;
					});
					
					bt_approval_data.addRows(row_bt_app);
					
					var bt_app_options = {
					  legend: 'none'
					};
					
					var bt_appr_chart = new google.visualization.BarChart(document.getElementById("bt_approval_pending"));
					bt_appr_chart.draw(bt_approval_data, bt_app_options);	
			
        		$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}
//stock chart details
function branch_transfer_details_dashboard_data(from_date,to_date) 
{   
    my_Date = new Date();   	
    $.ajax({ 
    url:base_url+ "index.php/admin_ret_dashboard/get_branch_transfer_details?nocache=" + my_Date.getUTCSeconds(),	
    dataType:"JSON",	
    data:{'from_date':from_date,'to_date':to_date,'id_branch':$('#id_branch').val()},			  		 
    type:"POST",			  			  
    cache:false,			  			 
    success:function(data){				  				
        var download_pending=data.branch_transfer_details.download_pending;
        var approved_pending=data.branch_transfer_details.approved_pending;
        if(download_pending.length>0)
        {
            var trHtml='';
            var total_pcs=0;
            var total_gwt=0;
            var total_nwt=0;
            $.each(download_pending,function(key,items){
            total_pcs+=parseFloat(items.tot_pcs);
            total_gwt+=parseFloat(items.tot_gwt);
            var down_branch=$('#id_branch').val();
            var dashboard_bt_download=base_url+'index.php/admin_ret_reports/dashboard_branchtransfer/'+from_date+'/'+to_date+'/2/'+down_branch+'/'+items.product_id;
            trHtml+='<tr>'
            +'<td><a href='+dashboard_bt_download+' target="_blank">'+items.product_name+'</td>'
            +'<td>'+items.from_branch_name+'</td>'
            +'<td>'+items.to_branch_name+'</td>'
            +'<td>'+items.tot_pcs+'</td>'
            +'<td>'+items.tot_gwt+'</td>'
            +'</tr>';
            });
            trHtml+='<tr style="font-weight:bold;">'
            +'<td>TOTAL</td>'
            +'<td></td>'
            +'<td></td>'
            +'<td>'+parseFloat(total_pcs).toFixed(2)+'</td>'
            +'<td>'+parseFloat(total_gwt).toFixed(3)+'</td>'
            +'</tr>';
            $('#branch_transfer_table_download_pending > tbody').html(trHtml);
        }
        
        if(approved_pending.length>0)
        {
            var total_pcs=0;
            var total_gwt=0;
            var total_nwt=0;
            var trHtml='';
            
            $.each(approved_pending,function(key,items){
            var app_branch=$('#id_branch').val();
            var dashboard_bt_approval=base_url+'index.php/admin_ret_reports/dashboard_branchtransfer/'+from_date+'/'+to_date+'/1/'+app_branch+'/'+items.product_id;
            total_pcs+=parseFloat(items.tot_pcs);
            total_gwt+=parseFloat(items.tot_gwt);
            trHtml+='<tr>'
            +'<td><a href='+dashboard_bt_approval+' target="_blank">'+items.product_name+'</td>'
            +'<td>'+items.from_branch_name+'</td>'
            +'<td>'+items.to_branch_name+'</td>'
            +'<td>'+items.tot_pcs+'</td>'
            +'<td>'+items.tot_gwt+'</td>'
            +'</tr>';
            });
            trHtml+='<tr style="font-weight:bold;">'
            +'<td>TOTAL</td>'
            +'<td></td>'
            +'<td></td>'
            +'<td>'+parseFloat(total_pcs).toFixed(2)+'</td>'
            +'<td>'+parseFloat(total_gwt).toFixed(3)+'</td>'
            +'</tr>';
            $('#branch_transfer_table_approved_pending > tbody').html(trHtml);
        }
        $("div.overlay").css("display", "none"); 	
    },
    error:function(error)  			
    {	
    $("div.overlay").css("display", "none"); 				
    }					     
    });
}


function get_approval_type()
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
	     url:base_url+ "index.php/admin_ret_dashboard/get_approval?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 type:"POST",
			 cache:false,
			  success:function(data){
						 console.log(data);
						 var dashboard_contract = base_url+'index.php/admin_ret_catalog/karigar_approval/list';
						 var bt_transfer = base_url+'index.php/admin_ret_brntransfer/branch_transfer/approval_list';
                    		 $("#contact_price").html("-");
							 $("#bt_approve").html("-");
							 $("#bt_download").html("-");
            					let price = data.status.contract_price_count;
								let branch= data.branch_status.branch_transfer_count;
								let download=data.download_status.branch_download_count;
								//alert(download);
            					$("#contact_price").html('<a href='+dashboard_contract +' target="_blank">'+price+ '</a>');
								$("#bt_approve").html('<a href='+bt_transfer +' target="_blank">'+branch+'</a>');
								$("#bt_download").html(download);
            				
            				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	 
	});
}

function get_contract_pricing()
{
    $("div.overlay").css("display", "block"); 
	my_Date = new Date();
	$.ajax({
		      url:base_url+ "index.php/admin_ret_dashboard/get_contract_approval?nocache=" + my_Date.getUTCSeconds(),
			 dataType:"JSON",
			 type:"POST",
			 cache:false,
			  success:function(data){

				console.log(data);
				if(data.approval_status!=null && data.approval_status.length>0){
				$.each(data.approval_status, function (key,item){

				var dashboard_approved = base_url+'index.php/admin_ret_reports/dashboard_contractprice/list/1';
				var dashboard_hold = base_url+'index.php/admin_ret_catalog/karigar_approval/list';
				var dashboard_rejected = base_url+'index.php/admin_ret_reports/dashboard_contractprice/list/2';
					$("#contact_approved").html("-");
					$("#contract_hold").html("-");
					$("#contract_rejected").html("-");

					   $("#contact_approved").html('<a href='+dashboard_approved +' target="_blank">'+item.approved+ '</a>');
					   $("#contract_hold").html('<a href='+dashboard_hold +' target="_blank">'+item.hold+'</a>');
					   $("#contract_rejected").html('<a href='+dashboard_rejected +' target="_blank">'+item.rejected+'</a>');
					});
				}

				$("div.overlay").css("display", "none"); 
			  },
			  error:function(error)  
			  {
				 $("div.overlay").css("display", "none"); 
			  }	
				
			});


}