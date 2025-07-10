var path =  url_params();
var ctrl_page = path.route.split('/');
var required_otp_approval = 1;

$(document).ready(function() {
	
	$('#day_close').on('click',function(){
		
		var proceed = confirm("Are you sure do you want to Day Close ?");
		if (proceed == true) {
		   $("div.overlay").css("display", "block"); 
		   $('#day_close').prop("disabled",true);
		   $('#day_close').prop("value","Processing..");
		   dayClose(); 
		}
		
	});
	
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/required_otp_approval',
		  dataType: 'json',
		  success: function(data) { 
		  		console.log(data);   
				required_otp_approval = data.otp_required;
				console.log(required_otp_approval);
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  }	 
    });

});

function dayClose(){ 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/dayClose',
		  dataType: 'json',
		  success: function(data) { 
		  	$("div.overlay").css("display", "block"); 
		  	$('#day_close').prop("disabled",false);
		  	if(data.status){
				//partlySold();
				$.toaster({ priority : 'success', title : 'Day Close', message : ''+"</br>"+data.message });
		    	/*stock_balance();
		    	old_metal_stock_balance();
		    	sales_return_stock_balance();
		    	partly_sale_stock_balance();
		    	bullion_purchase_stock_balance();
		    	stock_balance_packaging_items();
		    	stock_balance_nt();*/
		    	$("div.overlay").css("display", "none"); 
			}else{
				alert(data.message);
				$("div.overlay").css("display", "none"); 
			} 
		  },
	  	  error:function(error)  
		  { 
		  	 $('#day_close').prop("disabled",false);
		  	 console.log(error); 
		  }	 
    });
}

function partlySold(){ 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/partly_sold',
		  dataType: 'json',
		  success: function(data) { 
		  	console.log("Partly Sold" );
		  	console.log(data);
		  },
	  	  error:function(error)  
		  {
			 console.log("Partly Sold Error" );
		  	 console.log(error); 
		  }	 
    });
}

function stock_balance(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/stock_balance',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);    
		  		
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
		     //stock_balance_nt();
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}

function old_metal_stock_balance(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/old_metal_stock_balance',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);  
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}

function sales_return_stock_balance(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/sales_return_stock_balance',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);    
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}

function partly_sale_stock_balance(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/partly_sale_stock_balance',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);    
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}

function bullion_purchase_stock_balance(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/bullion_purchase_stock_balance',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);   
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}

function stock_balance_nt(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/stock_balance_nontag',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);    
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}


function stock_balance_packaging_items(){ 
    $("div.overlay").css("display", "block"); 
	$.ajax({
		  type: 'POST',
		  url:  base_url+'index.php/admin_ret_services/stock_balance_packaging_items',
		  dataType: 'json',
		  success: function(data) { 
			    console.log("Stock Balance" );
		  		console.log(data);    
		  		$("div.overlay").css("display", "none"); 
		  },
	  	  error:function(error)  
		  {
			 console.log("Stock Balance Error" );
		  	 console.log(error); 
		  	 $("div.overlay").css("display", "none"); 
		  }	 
    });
}


//Image Compression

$('#order_images_new').on('change',function(){
	validateOrderImages();
});



function validateOrderImages()
{
		var preview = $('#order_images');
		var files   = event.target.files;

		 for (var i = 0; i < files.length; i++) 
		 {
			    const compress           = new Compress();
				
			    const product_images     = [files[i]]; 
 
			    compress.compress(product_images, {
				size: 4, // the max size in MB, defaults to 2MB
				quality: 0.75, // the quality of the image, max is 1,
				maxWidth: 1920, // the max width of the output image, defaults to 1920px
				maxHeight: 1920, // the max height of the output image, defaults to 1920px
				resize: true // defaults to true, set false if you do not want to resize the image width and height
			  }).then((results) => {
				 
					const output = results[0];
					total_files.push(output);
					const file   = Compress.convertBase64ToFile(output.data, output.ext);
					 if(output.endSizeInMb < 2)
							  {
								  img_resource.push({"src":output.prefix +output.data,'name':output.alt,'is_default':"0"});
							 }
							  else
							  {
								     alert('File size cannot be greater than 1 MB');
									 files[i] = "";
									 return false;
							  }
					  });				
		  }
		  setTimeout(function(){
			var resource = [];
			resource     = img_resource;
			var image_details=[];
					$.each(resource,function(key,item){		 
						if(item)		  
						{		
							var div = document.createElement("div");
							
							div.setAttribute('class','col-md-3 images'); 
							
							div.setAttribute('id','order_img_'+key); 
							
							param = {"key":key};
							
							div.innerHTML+="<div class='form-group'><div class='image-input image-input-outline' id='kt_image_4'><div class='image-input-wrapper'><a onclick='remove_order_images("+JSON.stringify(param)+")'><i class='fa fa-trash'></i>Delete</a><img class='thumbnail' src='" + item.src + "'" + "style='width: 115px;height: 115px;'/></div></div>";
							preview.append(div);	
							image_details.push(item);
					  }	
					});	
					localStorage.setItem('img_details',JSON.stringify(image_details));
		  },3000);
		  
}

function remove_order_images(param)
{
	localStorage.removeItem("img_details");
	$('#order_img_'+param.key).remove();
	img_resource.splice(param.key,1);
	localStorage.setItem('img_details',JSON.stringify(img_resource));
	console.log(localStorage);
}

//Image Compression