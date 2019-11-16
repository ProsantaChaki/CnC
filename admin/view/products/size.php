<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(61) != 1 ){
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
        <h2>Size List</h2>
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
                <select size="1" style="width: 56px;padding: 6px;" id="size_Table_length" name="size_Table_length" aria-controls="size_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="size_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_size_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_size_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="size_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title" width="">Size</th>
                    <th class="column-title" width="20%">Code</th> 
					<th class="column-title no-link last" width="10%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="size_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="size_Table_div">
            <div class="dataTables_info" id="size_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="size_Table_paginate">
            </div> 
        </div>  
    </div>
</div>
<?php if($dbClass->getUserGroupPermission(58) == 1){ ?>
<div class="x_panel size_entry_cl">
    <div class="x_title">
        <h2>Size Name Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST"  id="size_form" name="size_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-6">Name<span class="required">*</span></label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input type="text" id="size_name" name="size_name" class="form-control col-lg-12"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4 col-sm-4 col-xs-6">Code</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input type="text" id="size_code" name="size_code" class="form-control col-lg-12"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="ln_solid"></div>
				<label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
				<div class="col-md-3 col-sm-3 col-xs-12">
					 <input type="hidden" id="size_id" name="size_id" />    
					 <button  type="submit" id="save_size" class="btn btn-success">Save</button>                    
					 <button type="button" id="clear_button"  class="btn btn-primary">Clear</button>                         
				</div>
				 <div class="col-md-5 col-sm-5 col-xs-12">
					<div id="form_submit_error" class="text-center" style="display:none"></div>
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
	
});
<!-- ------------------------------------------end --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;	
	load_size = function load_size(search_txt){
		$("#search_size_button").toggleClass('active');
		var size_Table_length = parseInt($('#size_Table_length').val());		
		$.ajax({
			url: project_url+"controller/sizeController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				limit:size_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				if(data.entry_status==0){
					$('.size_entry_cl').hide();
				}
				//for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, size_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#size_Table tbody tr').remove();
				$("#search_size_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					//create and set grid table row
					var colums_array=["id*identifier*hidden","name","code"];
					//first element is for view , edit condition, delete condition
					//"all" will show /"no" will show nothing
					var condition_array=["","","update_status", "1","delete_status","1"];
					//create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					//cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"size","size_Table", 0);
					//show the showing no of records and paging for records 
					$('#size_Table_div').show();					
					//code for dynamic pagination 				
					paging(total_pages, current_page_no, "size_Table" );					
				}
				//if the table has no records / no matching records 
				else{
					grid_has_no_result("size_Table",4);
				}
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_size_field").val();
			load_size(search_txt)
		}
	}	
	// function after click search button 
	$('#search_size_button').click(function(){
		var search_txt = $("#search_size_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_size(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_size_field').keypress(function(event){
		var search_txt = $("#search_size_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_size(search_txt)
		}
	})
	// load data initially on page load with paging
	load_size("");
	
	//insert size
	$('#save_size').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#size_form')[0]);
		formData.append("q","insert_or_update");
		//validation 
		if($.trim($('#size_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',not_input_insert_title_ln,"#size_name");			
		}
		else{
			$.ajax({
				url: project_url+"controller/sizeController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_size').removeAttr('disabled','disabled');
					
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_size("");
						clear_form();
					}
				 }	
			});
			
		}	
	})
	
	//edit size
	edit_size = function edit_size(size_id){
		$.ajax({
			url: project_url+"controller/sizeController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_size_details",
				size_id: size_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){

						$('#size_name').val(data.name);
						$('#size_id').val(data.id);
						$('#size_code').val(data.code);

						$('#save_size').html('Update');
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
						$( "#toggle_form" ).trigger( "click" );	
					});				
				}
			}
		});	
	}
	
	delete_size = function delete_size(size_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: project_url+"controller/sizeController.php",
				type:'POST',
				async:false,
				data: "q=delete_size&size_id="+size_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_size("");
					}
					else{
						success_or_error_msg('#page_notification_div',"danger","Not Deleted...");						
					}
				 }	
			});
		} 	
	}
	
	clear_form = function clear_form(){			 
		$('#size_id').val('');
		$("#size_form").trigger('reset');
		$('#save_size').html('Save');
	}
	
	$('#clear_button').click(function(){
		clear_form();
	});
	
});


</script>