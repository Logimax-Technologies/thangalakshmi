/*
--Created by VijayKumar--
-- Created on 05-01-22--
--Worked on new flow section transfer tags
*/

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
	 	case 'ret_section_transfer':
			switch(ctrl_page[2]) {
				case 'list':				 	
                    
                    get_ActiveSections();

				break;
		}
	}
	
});




$('#branch_select').on('change',function(key,items)
{
    if(this.value!='')
    {
        get_ActiveSections(this.value);
    }
})


function get_ActiveSections(id_branch)
{
	$("#select_frm_section option").remove();
    $("#select_to_section option").remove();
    my_Date = new Date();
    $.ajax({
        type: 'POST',
        url: base_url+"index.php/admin_ret_catalog/get_sectionBranchwise?nocache=" + my_Date.getUTCSeconds(),
		data:{'id_branch':id_branch},
        dataType:'json',
        success:function(data){
            $.each(data,function(key, item){
                $("#select_frm_section,#select_to_section").append(
                    $("<option></option>")
                    .attr("value",item.id_section)
                    .text(item.section_name)
                );
            });
			$('#select_frm_section').select2({
				placeholder:"Select From Section",
				allowClear: true
			});

            $('#select_to_section').select2({
				placeholder:"Select To Section",
				allowClear: true
			});
            
			$("#select_frm_section").select2("val","");

            $("#select_to_section").select2("val","");
            
			$(".overlay").css("display","none");
        }
    })
}




$('#section_tag_search').on('click',function()    
{
    
    if($('#branch_select').val()==null && $('#branch_filter').val()==undefined)   // condition to check whether branch is selected.
    {
        $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+'Select Branch..'});

        $('#select_to_section').focus();
    }
    /*else if($('#select_frm_section').val()=="" || $('#select_frm_section').val()==null)   // condition to check whether section is selected.
    {
        $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+'Select Section..'});
    }*/
    else
    {
        getSectionTags();

    }
});



function getSectionTags()   // Function that gets tag Section Wise 
{
    //$('#section_trans_list > tbody').empty();
    $(".overlay").css("display", "block");
    my_Date = new Date();
    $.ajax({
        type: 'POST',
        url: base_url+"index.php/admin_ret_section_transfer/ret_section_transfer/getSectionTags?nocache=" + my_Date.getUTCSeconds(),
        dataType:'json',
        data: ({'id_branch':($('#branch_filter').val()!='' && $('#branch_filter').val()!=undefined ? $('#branch_filter').val(): $("#branch_select").val()),'id_section':$('#select_frm_section').val(),'tag_code':$('#tag_code').val(),'old_tag_id':$('#tag_code_old').val(),'est_no':$('#est_no').val()}),
        success:function(data)
        {
            var list=data;
            console.log(list);

            console.log((list!=null && list.length > 0));

            if(list!=null && list.length > 0)
            {
                var html="";
                $.each(list,function(key,val)
                {
                    var allow_submit = true;

                    $('#section_trans_list > tbody > tr').each(function(idx, row){
                        if(val.tag_id==$(this).find('.tag_id').val())
                        {
                            $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+'Tag Already Exists..'});
                            allow_submit=false;
                        }
                    });
                    if(allow_submit)
                    {
                        
                        html+='<tr>'+
                            '<td><input type="checkbox" name="tag_id[]" class="tag_id" value='+val.tag_id+'></td>'+
                            '<td><input type="hidden" name="id_branch[]" class="id_branch" value='+val.id_branch+'>'+val.branch_name+'</td>'+
                            '<td><input type="hidden" name="tag_code[]" class="tag_code" value='+val.tag_code+'>'+val.tag_code+'</td>'+
                            '<td><input type="hidden" name="old_tag_id[]" class="old_tag_id" value='+val.old_tag_id+'>'+val.old_tag_id+'</td>'+
                            '<td><input type="hidden" name="frm_id_section[]" class="frm_id_section" value='+val.id_section+'>'+val.section_name+'</td>'+
                            '<td><input type="hidden" name="pro_id[]" class="pro_id" value='+val.product_id+'>'+val.product_name+'</td>'+
                            '<td><input type="hidden" name="piece[]" class="piece" value='+val.piece+'>'+val.piece+'</td>'+
                            '<td><input type="hidden" name="gross_wt[]" class="gross_wt" value='+val.gross_wt+'>'+val.gross_wt+'</td>'+
                            '<td><input type="hidden" name="net_wt[]" class="net_wt" value='+val.net_wt+'>'+val.net_wt+'</td>'+
                        '</tr>';             
                    }
                });

                if($('#section_trans_list > tbody  > tr').length>0)
                {
                    $('#section_trans_list > tbody > tr:first').before(html);
                }else{
                    $('#section_trans_list tbody').append(html);
                }
   
                $('#tag_code').val("");   
                $('#tag_code_old').val("");
                $('#est_no').val("");
                $('#select_frm_section').select2('val',""); 
                
                calculateSectiontotal();
            
            }
            else
            {
                $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+'No Record Found..'});
                
            }
            $(".overlay").css("display", "none");
        
        },
        error:function(error)  
        {
        $("div.overlay").css("display", "none");
        }
    });

}

$('#select_all').click(function(event)     // Select All checkbox click function
{
    $("tbody tr td input[type='checkbox']").prop('checked', $(this).prop('checked'));
	event.stopPropagation();

    calculateSectiontotal();
});


$(document).on('click',".tag_id", function(){
    calculateSectiontotal();
});	


function calculateSectiontotal()
{
    var tot_pcs = 0;
    var tot_gwt = 0;
    var tot_nwt = 0;
    $("#section_trans_list input[type=checkbox]:checked").each(function () { 
        var row = $(this).closest('tr'); 
        tot_pcs = tot_pcs + (isNaN(row.find('td:eq(6) .piece').val() ) ? 0 : parseFloat(row.find('td:eq(6) .piece').val())); 
        tot_gwt = tot_gwt + (isNaN( row.find('td:eq(7) .gross_wt').val() ) ? 0 : parseFloat(row.find('td:eq(7) .gross_wt').val()));
        tot_nwt = tot_nwt + (isNaN( row.find('td:eq(8) .net_wt').val() ) ? 0 :parseFloat(row.find('td:eq(8) .net_wt').val())) ;             
    });  
    $(".pcs").html(tot_pcs);
    $(".grs_wt").html(parseFloat(tot_gwt).toFixed(3));
    $(".net_wt").html(parseFloat(tot_nwt).toFixed(3));

}



$('#section_transfer').on('click',function()   // Transfer Section button 
{
    
    if($('#select_to_section').val()=="" || $('#select_to_section').val()==null)  // condition to check transfer to section is selected.
    {
        $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+'Select Transfer To Section..'});

        $('#select_to_section').focus();
    }
    else
    {
        var SectionTagData = [];  
       
        $("#section_trans_list tbody tr").each(function (index, value) 
        {
            var row = $(this).closest('tr'); 

            if(row.find("input[name='tag_id[]']:checked").is(":checked"))  // whether checkbox is selected
			{
                SectionTagData.push({"tag_id":row.find('.tag_id').val(),"id_branch":row.find('.id_branch').val(),"trans_from_section":row.find('.frm_id_section').val(),"pcs":row.find('.piece').val(),"grs_wt":row.find('.gross_wt').val(),"net_wt":row.find('.net_wt').val()});
               
            }
        
        });

        
        if(SectionTagData.length>0)
        {
            add_to_trans(SectionTagData);
        }
        else
        {
            $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+'Please select tag code to proceed..'});
        }
    }
    
});


function add_to_trans(trans_data)
{
    console.log("trans_data : " , trans_data);

    $(".overlay").css("display", "block");		

    var postData = {};

    var branch = $('#branch_filter').val()!='' && $('#branch_filter').val()!=undefined ? $('#branch_filter').val(): $("#branch_select").val();

    console.log(branch);

    var transfer_to_section = $('#select_to_section').val();

    console.log('transfer_to_section',transfer_to_section);

    postData={'trans_data':trans_data,'trans_to_section':transfer_to_section,'id_branch':branch};

    console.log('postData',postData);

    $.ajax({
        type:'POST',
        url : base_url + 'index.php/admin_ret_section_transfer/ret_section_transfer/save',		
	 	dataType : 'json',		
	 	data : postData,
        success : function(data)
        {
            console.log(data.status);
            if(data.status)
            {
                    $.toaster({ priority : 'success', title : 'Warning!', message : ''+"</br>"+data.message});
            }
            else
            {
                $.toaster({ priority : 'danger', title : 'Warning!', message : ''+"</br>"+data.message});
                
            }

            window.location.reload();

        }

    })
    $(".overlay").css("display", "none");		

}