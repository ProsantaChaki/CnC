<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(73) != 1 ){
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
        <h2>Outlets</h2>
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
                <select size="1" style="width: 56px;padding: 6px;" id="outlets_Table_length" name="outlets_Table_length" aria-controls="outlets_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="outlets_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_outlets_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_outlets_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="outlets_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title"></th>
                    <th class="column-title" width="15%">Outlet Name</th>
                    <th class="column-title" width="15%">Incharge Name</th>
                    <th class="column-title" width="">Address</th>
                    <th class="column-title" width="10%">Longitud</th>
                    <th class="column-title" width="10%">Latitude</th>
                    <th class="column-title" width="12%">Mobile No</th>
                    <th class="column-title" width="8%">Status</th> 
					<th class="column-title no-link last" width="8%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="outlets_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="outlets_Table_div">
            <div class="dataTables_info" id="outlets_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="outlets_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<?php if($dbClass->getUserGroupPermission(70) == 1){ ?>
<div class="x_panel outlets_entry_cl">
    <div class="x_title">
        <h2>Outlet Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST"  id="outlets_form" name="outlets_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Outlet Name</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="outlet_name" name="outlet_name" class="form-control col-lg-12"/>
						</div>
					</div>						
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Incharge Name</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="incharge_name" name="incharge_name" class="form-control col-lg-12"/>
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Address</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="address" name="address" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Latitude</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="latitude" name="latitude" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Longitud</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="longitud" name="longitud" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Mobile No</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" id="mobile_no" name="mobile_no" class="form-control col-lg-12"/>
						</div>
					</div>				
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-6" for="name">Is Active</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="checkbox" id="is_active" name="is_active" checked='checked' class="form-control col-lg-12"/>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<img src="<?php echo $activity_url ?>images/no_image.png" width="70%" height="70%" class="img-thumbnail" id="outlets_img">
					<input type="file" name="outlets_image_upload" id="outlets_image_upload"> 
					<small style="color:red">Image size should be (4:3 ratio) and size under 3mb. </small>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-6"></label>
				<div class="col-md-3 col-sm-3 col-xs-12">
					 <input type="hidden" id="outlets_id" name="outlets_id" />    
					 <button  type="submit" id="save_outlets" class="btn btn-success">Save</button>                    
					 <button type="button" id="clear_button"  class="btn btn-primary">Clear</button>                         
				</div>
				 <div class="col-md-6 col-sm-6 col-xs-12">
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

	//datepicker
	$('.date-picker').daterangepicker({
		singleDatePicker: true,
		calender_style: "picker_3",
		locale: {
			  format: 'YYYY-MM-DD',
			  separator: " - ",
		}
	});

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
	$('#outlets_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
});

<!-- ------------------------------------------end --------------------------------------->

<!-- ------------------------------------------start --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;	
	load_outletss = function load_outletss(search_txt){
		$("#search_outlets_button").toggleClass('active');
		var outlets_Table_length = parseInt($('#outlets_Table_length').val());		
		$.ajax({
			url: project_url+"controller/outletsController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				search_txt: search_txt,
				limit:outlets_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				if(data.entry_status==0){
					$('.outlets_entry_cl').hide();
				}
				// for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, outlets_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#outlets_Table tbody tr').remove();
				$("#search_outlets_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					// create and set grid table row
					var colums_array=["image*image*"+project_url,"id*identifier*hidden","outlet_name","incharge_name","address","longitud","latitude","mobile","status_text"];
					// first element is for view , edit condition, delete condition
					// "all" will show /"no" will show nothing
					var condition_array=["","","all", "","",""];
					// create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					// cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"outlets","outlets_Table", 0);
					// show the showing no of records and paging for records 
					$('#outlets_Table_div').show();					
					// code for dynamic pagination 				
					paging(total_pages, current_page_no, "outlets_Table" );					
				}
				// if the table has no records / no matching records 
				else{
					grid_has_no_result( "outlets_Table",9);
				}
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_outlets_field").val();
			load_outletss(search_txt)
		}
	}	
	// function after click search button 
	$('#search_outlets_button').click(function(){
		var search_txt = $("#search_outlets_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_outletss(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_outlets_field').keypress(function(event){
		var search_txt = $("#search_outlets_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_outletss(search_txt)
		}
	})
	// load data initially on page load with paging
	load_outletss("");
	
});

<!-- ------------------------------------------end --------------------------------------->


<!-- ------------------------------------------start --------------------------------------->
$(document).ready(function () {		
	//insert outlets
	$('#save_outlets').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#outlets_form')[0]);
		formData.append("q","insert_or_update");
		//validation 
		if($.trim($('#address').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Insert Address',"#address");			
		}		
		else if($.trim($('#mobile_no').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Insert Mobile Number',"#mobile_no");			
		}
		else{
			$.ajax({
				url: project_url+"controller/outletsController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_outlets').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_outletss("");
						clear_form();
					}
				 }	
			});
			
		}	
	})
	//edit outlets
	edit_outlets = function edit_outlets(outlets_id){
		$.ajax({
			url: project_url+"controller/outletsController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_outlets_details",
				outlets_id: outlets_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						//alert(data.status)
						var master_id = data.id;
						$('#outlet_name').val(data.outlet_name);
						$('#incharge_name').val(data.incharge_name);
						$('#address').val(data.address);
						$('#mobile_no').val(data.mobile);
						$('#outlets_id').val(data.id);
						$('#latitude').val(data.latitude);
						$('#longitud').val(data.longitud);
						
						if(data.status==1){
							$('#is_active').iCheck('check');
						}
						else if(data.status==0){
							$('#is_active').iCheck('uncheck');
						}
						
						if(data.image == ""){
							$('#outlets_img').attr("src",project_url+'images/no_image.png');
						}else{
							$('#outlets_img').attr("src",project_url+data.image);
						}
						$('#outlets_img').attr("width", "70%","height","70%");
						
						$('#save_outlets').html('Update');
						
						// to open submit post section
						if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
						$( "#toggle_form" ).trigger( "click" );	
					});				
				}
			}
		});	
	}
	
	clear_form = function clear_form(){			 
		$('#outlets_id').val('');
		$("#outlets_form").trigger('reset');
		$('#outlets_img').attr("src",project_url+"images/no_image.png");
		$('#outlets_img').attr("width", "70%","height","70%");
		$('#outlets_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
		$('#save_outlets').html('Save');
	}
	
	$('#clear_button').click(function(){
		clear_form();
	});
	
});





</script>