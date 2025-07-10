var path =  url_params();
var ctrl_page = path.route.split('/');
$(document).ready(function() 
 
{	
   
 
if($('#branch_set').val()==1  ){		
 get_branchname();			
 }	
var line = new Morris.Line

		({   
			element: 'rate-chart',    
			resize: true,    
			data: getRateData(),    
			xkey: 'updatetime',    
			ykeys: ['rate'],    
			labels: ['Gold 22ct'],    
			lineColors: ['#efefef'],   
			lineWidth: 2,   
			hideHover: 'auto',    
			gridTextColor: "#fff",    
			gridStrokeWidth: 0.4,   
			pointSize: 4,    
			pointStrokeColors: ["#efefef"],    
			gridLineColor: "#efefef",    
			gridTextFamily: "Open Sans",    
			gridTextSize: 10  
			
		});				
			
	});	
			
function getRateData()
{
	var data = "";       
	$.ajax({           
				type: 'GET',            
				url: base_url+'index.php/rate/ajax/weekstat',            
				dataType: 'json',           
				async: false,                       
				data: {},           
				success: function (result) {               
									data = result;                           
									},           
				error: function (xhr, status, error) 
				{                
				console.log(error);           
				}        
			
			});         
			return data;
}

    function get_branchname(){	
     	$(".overlay").css('display','block');	
     	$.ajax({		
         	type: 'GET',		
         	url: base_url+'index.php/branch/branchname_list',		
         	dataType:'json',		
         	success:function(data){		
         		$('#branch_select').append(						
            	 	$("<option selected></option>")						
            	 	.attr("value", 0)						  						  
            	 	.text('All' )
						
            	 	);			  	   
        	 	$.each(data, function (key, item) {					  				  			   		
            	 	$('#branch_select').append(						
            	 	$("<option></option>")						
            	 	.attr("value", item.id_branch)						  						  
            	 	.text(item.name )						  					
            	 	);			   											
             	});						
             	$("#branch_select").select2({			    
            	 	placeholder: "Select branch name",			    
            	 	allowClear: true		    
             	});				
             	$("#branch_select").select2("val",(branch_id!=''?branch_id:0));	
             	$(".overlay").css("display", "none");			
         	}	
        }); 
    }

$('#branch_select').select2().on("change", function(e) { 
	if(this.value!='')
	{   
		  

		$("#id_branch").val(this.value);    
		var id_branch=$("#id_branch").val(); 
		  
	
		getindex();  
			
	}
	else
	{   
	$("#id_branch").val('');       
	}
});
	
	
	function getindex()
	{        
		$("div.overlay").css("display", "block"); 
		var id_branch=$("#id_branch").val();               
		$.ajax({                          
		type: "POST",                          
		url: base_url+"index.php/admin_dashboard/dashboard",                         
		data: {'id_branch':id_branch},                             
		sync:false,						  						  
		dataType: 'json',                          
		success: function(response)
		{         
				//payments
				
				
				
		   $("#test").text(response.payment.month.paid);
		   $("#tot_pay").text(response.payment.all_pay.paid);
		   $("#t_paid").text(response.payment.today.paid);
		   $("#y_paid").text(response.payment.yesterday.paid);
		   $("#tw_paid").text(response.payment.week.paid);
		   $("#tm_paid").text(response.payment.month.paid);
		   $("#awaiting").text(response.payment.awaiting.awtng_count);
		   $("#thr_a").text(response.payment.admin_paid.joined_thro);
		   $("#thr_w").text(response.payment.web_paid.joined_thro);
		   $("#thr_m").text(response.payment.mob_paid.joined_thro);
		   //acounts
		   $("#wk_reg").text(response.account.wk_reg);
		   $("#yes_reg").text(response.account.yes_reg);
		   $("#m_reg").text(response.account.m_reg);
		   $("#today_reg").text(response.account.today_reg);
		   $("#all_acc").text(response.account.all_reg);
		   $("#all_reg").text(response.account.all_reg);
		   $("#mob_reg").text(response.account.mob.joined_thro);
		   $("#w_reg").text(response.account.web.joined_thro);
		   $("#a_reg").text(response.account.admin.joined_thro);
		   $("#acc_wo_pay").text(response.account.acc_wo_pay);
			//inter wallet 
		   $("#t_trans").text(response.inter_wallet.t_trans);
		   $("#t_redeem_trans").text(response.inter_wallet.t_redeem_trans);
		   $("#y_trans").text(response.inter_wallet.y_trans);
		   $("#y_redeem_trans").text(response.inter_wallet.y_redeem_trans);
		   $("#tw_trans").text(response.inter_wallet.tw_trans);
		   $("#tw_redeem_trans").text(response.inter_wallet.tw_redeem_trans);
		   $("#tm_trans").text(response.inter_wallet.tm_trans);
		   $("#tm_redeem_trans").text(response.inter_wallet.tm_redeem_trans);
			//closed
			  $("#closed").text(response.closed);
			  $("#renewal").text(response.renewal);
			  $("#two_pending").text(response.two_pending);
			  $("#one_pending").text(response.one_pending);
		 		//existing		
			$("#e_all_reg").text(response.existing_request.all_reg);
			$("#total_request").text(response.existing_request.total_request);
			$("#exiting_processing").text(response.existing_request.exiting_processing);
			$("#exiting_approved").text(response.existing_request.exiting_approved);
			$("#exiting_rejected").text(response.existing_request.exiting_rejected);
				$("div.overlay").css("display", "none"); 
		},
			  error:function(error)  
				{
					$("div.overlay").css("display", "none"); 
				}	
	}); 
	}                        