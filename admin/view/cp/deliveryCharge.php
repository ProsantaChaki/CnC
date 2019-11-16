<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(97) != 1 ){
?> 
	<div class="x_panel">
		<div class="alert alert-danger" align="center">You Don't Have permission of this Page.</div>
	</div>
	<?php 
}
else{
?>


<div class="x_panel">
    <div class="x_title">
        <h2>Delivery Charge</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
		<div id="page_notification_div" class="text-center" style="display:none"></div>
    	<div class="dataTables_length">
        	<label>Show 
                <select size="1" style="width: 56px;padding: 6px;" id="delivery_Table_length" name="delivery_Table_length" aria-controls="delivery_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="delivery_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_delivery_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_delivery_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="delivery_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title" width="50%">Type</th>
                    <th class="column-title" width="20%">Rate</th> 
                    <th class="column-title" width="20%">Status</th> 
					<th class="column-title no-link last" width="10%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="delivery_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="delivery_Table_div">
            <div class="dataTables_info" id="delivery_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="delivery_Table_paginate">
            </div> 
        </div>  
    </div>
</div>
<?php if($dbClass->getUserGroupPermission(94) == 1){ ?>
<div class="x_panel activity_entry_cl">
    <div class="x_title">
        <h2>Delivery Charge Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST"  id="delivery_form" name="delivery_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-12">	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Type</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="delivery_type" name="delivery_type" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Rate</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="rate" name="rate" class="form-control col-lg-12"/>
						</div>
					</div>				
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6" for="name">Is Active</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="checkbox" id="is_active" name="is_active" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							 <input type="hidden" id="delivery_id" name="delivery_id" />    
							 <button  type="submit" id="save_delivery" class="btn btn-success">Save</button>                    
							 <button type="button" id="clear_button"  class="btn btn-primary">Clear</button>                         
						</div>
						 <div class="col-md-7 col-sm-7 col-xs-12">
							<div id="form_submit_error" class="text-center" style="display:none"></div>
						 </div>
					</div>
				</div>
			</div>
		</form>  
    </div>
</div>
<?php 
		}
	} 
?>
<script src="js/customTable.js"></script> 
<script>
//------------------------------------- general & UI  --------------------------------------
/*
develped by @momit
=>load grid with paging
=>search records
*/
$(document).ready(function () {	
	// close form submit section onload page
	var x_panel = $('#iniial_collapse').closest('div.x_panel');
	var button = $('#iniial_collapse').find('i');
	var content = x_panel.find('div.x_content');
	content.slideToggle(200);
	(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
	(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
	button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
	setTimeout(function () {
		x_panel.resize();
	}, 50);

	// collaps button function
	$('.collapse-link').click(function () {
		var x_panel = $(this).closest('div.x_panel');
		var button = $(this).find('i');
		var content = x_panel.find('div.x_content');
		content.slideToggle(200);
		(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
		(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
		button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
		setTimeout(function () {
			x_panel.resize();
		}, 50);
	})

	// icheck for the inputs
	$('#delivery_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
	$('#is_active').iCheck('check');
});
<!-- ------------------------------------------end --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;	
	load_deliverys = function load_deliverys(search_txt){
		$("#search_delivery_button").toggleClass('active');
		var delivery_Table_length = parseInt($('#delivery_Table_length').val());		
		$.ajax({
			url: project_url+"controller/deliveryController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				limit:delivery_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				// for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, delivery_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#delivery_Table tbody tr').remove();
				$("#search_delivery_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					// create and set grid table row
					var colums_array=["id*identifier*hidden","type","rate","status_text"];
					// first element is for view , edit condition, delete condition
					// "all" will show /"no" will show nothing
					var condition_array=["","","update_status", "1","delete_status","1"];
					// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					// cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"delivery","delivery_Table", 0);
					// show the showing no of records and paging for records 
					$('#delivery_Table_div').show();					
					// code for dynamic pagination 				
					paging(total_pages, current_page_no, "delivery_Table" );					
				}
				// if the table has no records / no matching records 
				else{
					grid_has_no_result( "delivery_Table",4);
				}
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_delivery_field").val();
			load_deliverys(search_txt)
		}
	}	
	// function after click search button 
	$('#search_delivery_button').click(function(){
		var search_txt = $("#search_delivery_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_deliverys(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_delivery_field').keypress(function(event){
		var search_txt = $("#search_delivery_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_deliverys(search_txt)
		}
	})
	// load data initially on page load with paging
	load_deliverys("");
	
	
	//insert delivery
	$('#save_delivery').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#delivery_form')[0]);
		formData.append("q","insert_or_update");
		//validation 
		if($.trim($('#delivery_type').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Type Name","#delivery_type");			
		}
		else if($.trim($('#rate').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Rate","#rate");			
		}
		else{
			$.ajax({
				url: project_url+"controller/deliveryController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_delivery').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_deliverys("");
						clear_form();
					}
				 }	
			});
			
		}	
	})
	
	//edit delivery
	edit_delivery = function edit_delivery(delivery_id){
		$.ajax({
			url: project_url+"controller/deliveryController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_delivery_details",
				delivery_id: delivery_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						//alert(data.status)
						var master_id = data.id;
						$('#delivery_type').val(data.type);
						$('#rate').val(data.rate);
						$('#delivery_id').val(data.id);
						if(data.status==1){
							$('#is_active').iCheck('check');
						}
						if(data.status==0){
							$('#is_active').iCheck('uncheck');
						}
						$('#save_delivery').html('Update');
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
						$( "#toggle_form" ).trigger( "click" );	
					});				
				}
			}
		});	
	}
	
	delete_delivery = function delete_delivery(delivery_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: project_url+"controller/deliveryController.php",
				type:'POST',
				async:false,
				data: "q=delete_delivery&delivery_id="+delivery_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_deliverys("");
						clear_form();
					}
					else{
						success_or_error_msg('#page_notification_div',"danger","Not Deleted...");						
					}
				 }	
			});
		} 	
	}
	
	clear_form = function clear_form(){			 
		$('#delivery_id').val('');
		$("#delivery_form").trigger('reset');
		$('#delivery_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$('#save_delivery').html('Save');
		$('#is_active').iCheck('check');
	}
	
	$('#clear_button').click(function(){
		clear_form();
	});
	
});





</script>