<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(88) != 1){
?> 
	<div class="x_panel">
		<div class="alert alert-danger" align="center">You Don't Have permission of this Page.</div>
	</div>
	<?php 
} 
else{
	$user_name = $_SESSION['user_name'];
	?>
	
<div class="x_panel">
    <div class="x_title">
        <h2>Custom Order</h2>
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
                <select size="1" style="width: 56px;padding: 6px;" id="custom_Table_length" name="custom_Table_length" aria-controls="custom_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="custom_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_custom_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_custom_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="custom_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead>
                <tr class="headings">
					<th class="column-title" width="5%"></th>
                    <th class="column-title" width="15%">Name</th>
                    <th class="column-title" width="30%">Details</th>
					<th class="column-title" width="15%">Delivery Date</th>
                    <th class="column-title" width="10%">Email</th>
                    <th class="column-title" width="10%">Contact No</th>
					<th class="column-title" width="8%">Status</th>
                    <th class="column-title no-link last" width="100"><span class="nobr"></span></th>
                </tr>
            </thead>
            <tbody id="custom_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="custom_Table_div">
            <div class="dataTables_info" id="custom_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="custom_Table_paginate">
            </div> 
        </div>  
    </div>
</div>
<?php if($dbClass->getUserGroupPermission(89) == 1){ ?>
<div class="x_panel custom_entry_cl">
    <div class="x_title">
        <h2>Order Edit</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">
        <br />             
		<form id="custom_form" name="custom_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Name<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="custom_name" name="custom_name" required class="form-control col-lg-12"/>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" for="name">Delivery Date</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="delivery_date" name="delivery_date" class="form-control col-lg-12 date-picker"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Cake Weight<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<select class="form-control" name="cake_weight" id="cake_weight">
								<option value='0'>Select Option</option>
								<option value='1'>1 KG</option>
								<option value='2'>2 KG</option>
								<option value='3'>3 KG</option>
								<option value='4'>4 KG</option>
								<option value='5'>5 KG</option>
							</select>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" for="name">Cake Tyre</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<select class="form-control delivery_option" name="cake_tyre" id="cake_tyre">
								<option value='0'>Select Option</option>
								<option value='1'>1</option>
								<option value='2'>2</option>
								<option value='3'>3</option>
								<option value='4'>4</option>
								<option value='5'>5</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Contact No<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="text" id="contact_no" name="contact_no" required class="form-control col-lg-12"/>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Email</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="email" id="email" name="email" class="form-control col-lg-12"/>
						</div>
					</div>						
					<div class="form-group"> 
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Details</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<textarea rows="2" cols="100" id="details" name="details" class="form-control col-lg-12"></textarea> 
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Remarks</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<textarea rows="2" cols="100" id="remarks" name="remarks" class="form-control col-lg-12"></textarea> 
						</div>
					</div>
					<div class="ln_solid"></div>
				</div>
				<div class="col-md-3">
					<img src="<?php echo $activity_url ?>images/no_image.png" width="70%" height="70%" class="img-thumbnail" id="custom_img">
					<input type="file" name="custom_image_upload" id="custom_image_upload"> 
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<input type="hidden" id="custom_id" name="custom_id" />    
					<button type="submit" id="save_custom_info" class="btn btn-success">Save</button>                                    
					<button type="button" id="clear_button" class="btn btn-primary">Clear</button>                         
				</div>
				 <div class="col-md-7 col-sm-7 col-xs-12">
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
	var user_type = "<?php echo $user_type; ?>";
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
	
	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		/*autoUpdateInput: false,*/
		calender_style: "picker_3",
		timePicker:true,
		locale: {
			format: 'YYYY-MM-DD h:mm',
			separator: " - ",
		}
	});

});
<!-- ------------------------------------------end --------------------------------------->


//------------------------------------- grid table codes --------------------------------------
/*
develped by @momit
=>load grid with paging
=>search records
*/
$(document).ready(function (){	
	// initialize page no to "1" for paging
	var current_page_no=1;	
	
	$('.custom_entry_cl').hide();
	
	load_data = function load_data(search_txt){
		$("#search_custom_button").toggleClass('active');		 
		var custom_Table_length =parseInt($('#custom_Table_length').val());
			
		$.ajax({
			url: project_url+"controller/customController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				limit:custom_Table_length,
				page_no:current_page_no
			},
			success: function(data){
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
/* 				
				if(data.entry_status==0){
					$('.custom_entry_cl').hide();
				} */
				// for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, custom_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#custom_Table tbody tr').remove();
				//$("#search_custom_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					// create and set grid table row
					var colums_array=["cc_image*image*"+project_url,"id*identifier*hidden","cc_name","cc_details","cc_delevery_date","cc_email","cc_mobile*center","status_text"];
					// first element is for view , edit condition, delete condition
					// "all" will show /"no" will show nothing
					var condition_array=["","","update_status", "1","delete_status","1"];
					// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					// cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"custom","custom_Table", 0);
					// show the showing no of records and paging for records 
					$('#custom_Table_div').show();					
					// code for dynamic pagination 				
					paging(total_pages, current_page_no, "custom_Table" );					
				}
				// if the table has no records / no matching records 
				else{
					grid_has_no_result( "custom_Table",8);
				}
				$("#search_custom_button").toggleClass('active');			
			}
		});	
	}
	
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_custom_field").val();
			load_data(search_txt)
		}
	}	
	// function after click search button 
	$('#search_custom_button').click(function(){
		var search_txt = $("#search_custom_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_data(search_txt)
		// if there is lot of data and it tooks lot of time please add the below condition
		/*
		if(search_txt.length>3){
			load_data(search_txt)	
		}
		*/
	});
	//function after press "enter" to search	
	$('#search_custom_field').keypress(function(event){
		var search_txt = $("#search_custom_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_data(search_txt)
			// if there is lot of data and it tooks lot of time please add the below condition
			/*
			if(search_txt.length>3){
				load_data(search_txt,1)	
			}*/
		}
	})
	
	// load data initially on page load with paging
	load_data("");
});


<!-- ------------------------------------------end --------------------------------------->


<!-- -------------------------------Form related functions ------------------------------->

/*
develped by @momit
=>form submition for add/edit
=>clear form
=>load data to edit
=>delete record
=>view 
*/
$(document).ready(function () {		
	var url = project_url+"controller/customController.php";	
	
	// save and update for public post/notice
	$('#save_custom_info').click(function(event){		
		event.preventDefault();
		var formData = new FormData($('#custom_form')[0]);
		formData.append("q","insert_or_update");
		if($.trim($('#custom_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Name","#custom_name");			
		}
		else if($.trim($('#contact_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Contact No","#contact_no");			
		}		
		else{
		//	$('#save_custom_info').attr('disabled','disabled');
			
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_custom_info').removeAttr('disabled','disabled');
					
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Update Successfully");
						load_data("");
						clear_form();
					}
					else{
						if(data == "img_error")
							success_or_error_msg('#form_submit_error',"danger",not_saved_msg_for_img_ln);
						else	
							success_or_error_msg('#form_submit_error',"danger","Not Saved...");												
					}
				 }	
			});
		}	
	})

	
	// clear function to clear all the form value
	clear_form = function clear_form(){			 
		$('#custom_id').val('');
		$("#custom_form").trigger('reset');		
		$('#custom_img').attr("src",project_url+"images/no_image.png");
		$('#custom_img').attr("width", "70%","height","70%");
		$('#img_url_to_copy').val("");
		$("#custom_form .tableflat").iCheck('uncheck');
		$('#save_custom_info').html('Save');	
	}
	
	// on select clear button 
	$('#clear_button').click(function(){
		clear_form();
	});
	
	
	delete_custom = function delete_custom(custom_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: url,
				type:'POST',
				async:false,
				data: "q=delete_custom&custom_id="+custom_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_data("");
					}
					else{
						success_or_error_msg('#page_notification_div',"danger","Not Deleted...");						
					}
				 }	
			});
		} 	
	}
	
	
	edit_custom = function edit_custom(custom_id){
		$.ajax({
			url: url,
			type:'POST',
			async:false,
			dataType: "json",
			data:{
				q: "set_order_notice_details",
				custom_id:custom_id
			},
			success: function(data){
				load_data("");
			}	
		});		
		$('.custom_entry_cl').show();
		$.ajax({
			url: url,
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_custom_details",
				custom_id: custom_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){ 
						clear_form();					
						$('#custom_id').val(data.id);
						$('#custom_name').val(data.cc_name);
						$('#delivery_date').val(data.cc_delevery_date);
						$('#cake_tyre').val(data.cc_cake_tyre);
						$('#cake_weight').val(data.cc_cake_weight);
						$('#contact_no').val(data.cc_mobile);
						$('#email').val(data.cc_email);
						$('#details').val(data.cc_details);
						$('#remarks').val(data.remarks);

						if(data.cc_image == ""){
							$('#custom_img').attr("src",project_url+'images/no_image.png');
						}else{
							$('#custom_img').attr("src",data.cc_image);
						}
						$('#custom_img').attr("width", "70%","height","70%");
						
						
						//change button value 
						$('#save_custom_info').html('Verified');
						
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
							$( "#toggle_form" ).trigger( "click" );						
					});
					
				}
			}	
		});			
	}				
	
});


<!-- ------------------------------------------end --------------------------------------->
</script>