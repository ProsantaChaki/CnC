<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(65) != 1 ){
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
        <h2>Product Grid</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
		<div id="page_notification_div" class="text-center" style="display:none"></div>
		
		<!-- Advance Search Div-->
		<div class="x_panel">
			<div class="row">
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a class="collapse-link-adv" id="toggle_form_ad"><b><small class="text-primary">Advance Search & Report</small></b><i class="fa fa-chevron-down"></i></a>
					</li>
				</ul>
			</div>
			<div class="x_content adv_cl" id="iniial_collapse_adv">
				<div class="row advance_search_div alert alert-warning">
                    <div class="row">
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Category</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input class="form-control input-sm" type="text" name="ad_category_name" id="ad_category_name"/> 
							<input type="hidden" name="ad_category_id" id="ad_category_id"/>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Product</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input class="form-control input-sm" type="text" name="ad_product_name" id="ad_product_name"/> 
							<input type="hidden" name="ad_product_id" id="ad_product_id"/> 
						</div>
					</div><br/>
					<div class="row">
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Availability</label>	
						<div class="form-group col-md-3 col-sm-3 col-xs-6">
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="1"/> Yes
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="0" /> No
							<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="2" checked="CHECKED"/> All
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Rate</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input type="radio" class="flat_radio" name="is_rate" id="is_rate" value="1"/> Yes
							<input type="radio" class="flat_radio" name="is_rate" id="is_rate" value="0" checked="CHECKED"/> No
						</div>
					</div><br/>
					<div style="text-align:center">					
						<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right">
							<button type="button" class="btn btn-info" id="adv_search_button"><i class="fa fa-lg fa-search"></i></button>
							<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i></button>                        
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div id="ad_form_submit_error" class="text-center" style="display:none"></div>
						</div>
					</div>
				</div> 
			</div>
		</div>
		<!-- Advance search end -->
		
    	<div class="dataTables_length">
        	<label>Show 
                <select size="1" style="width: 56px;padding: 6px;" id="product_Table_length" name="product_Table_length" aria-controls="product_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="product_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_product_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_product_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="product_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title" width="15%">Product Name</th>
                    <th class="column-title" width="15%">Category Name</th> 
                    <th class="column-title" width="">Details</th> 
                    <th class="column-title" width="20%">Rate</th> 
                    <th class="column-title" width="10%">Availability</th> 
					<th class="column-title no-link last" width="10%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="product_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="product_Table_div">
            <div class="dataTables_info" id="product_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="product_Table_paginate">
            </div> 
        </div>  
    </div>
</div>
<?php if($dbClass->getUserGroupPermission(62) == 1){ ?>
<div class="x_panel product_entry_cl">
    <div class="x_title">
        <h2>Product Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST" id="product_form" name="product_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Product Name<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" id="product_name" name="product_name" class="form-control col-lg-12"/>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Product Code<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" id="product_code" name="product_code" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Details</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<textarea rows="2" cols="100" id="details" name="details" class="form-control col-lg-12"></textarea> 
						</div>
					</div> 
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Category<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<select class="form-control" name="category_option" id="category_option">
							</select>
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Feature Image</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="file" name="feature_image_upload" id="feature_image_upload" class="form-control input-sm col-md-6 col-xs-12"> 
						</div>					
					</div>		
					<div class="form-group">	
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Tags</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<input type="text" id="tag" name="tag" class="form-control col-lg-12"/>
						</div>
					</div>	
					<div id="file_div" class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Image<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-12" id="first_section">	              
							<div class="input-group" >
								<input name="attached_file[]" class="form-control input-sm col-md-6 col-xs-12 attached_file"  type="file" />
								<span class="input-group-btn">
									<button type="button" class="btn btn-primary btn-sm" id="add_file_row"><span class="glyphicon glyphicon-plus"></span></button> 
								</span>
							</div>    
							<small style="color:red">Image size should be (2:2 ratio) and size under 3mb. </small><br>							
						</div>
						<input type="text" class="tags form-control col-lg-12 hide" name="uploded_files" id="uploded_files" value=""/>
					</div>
					<div class="form-group">	
						<label class="control-label col-md-2 col-sm-2 col-xs-6" >Availability</label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<input type="checkbox" id="is_active" name="is_active" checked="checked" class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group" id="image_div"></div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Ingredient</label>
						<div id="ingredient_select" class="col-md-10 col-sm-10 col-xs-12"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Rate Info</label>
						<div class="table-responsive col-md-10 col-sm-10 col-xs-12">
							<table class="table table-bordered" id="rateTable">
								<thead>
									<tr>
										<th width="">Size</th>
										<th width="">Rate</th>
										<th width="6%"><button id='addRateRow' type='button' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-plus'></span></button></th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>	
			</div>
			
			<div class="form-group">	
				<div class="ln_solid"></div>
				<div class="col-md-7 col-sm-7 col-xs-12" style="text-align:right">
					 <input type="hidden" id="product_id" name="product_id" />    
					 <button type="submit" id="save_product" class="btn btn-success">Save</button>                    
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
	
	// close form submit section onload page
	var x_panel = $('#iniial_collapse_adv').closest('div.x_panel');
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
	$('.collapse-link-adv').click(function (){
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
	
	$('#product_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
	
	$("#ad_category_name").autocomplete({
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: project_url+'controller/orderController.php',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "category_info",
					term: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 3,
		select: function(event, ui) { 
			var id = ui.item.id;
			$(this).next().val(id);
		}
	});
	
	$("#ad_product_name").autocomplete({
		search: function() {
			category_id  = $('#ad_category_id').val();
			if(category_id == ""){
				success_or_error_msg('#ad_form_submit_error','danger','Please Select Category',"#ad_category_name");
			}
		},
		source: function(request, response) {
			$.ajax({
				url: project_url+'controller/orderController.php',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "product_info",
					term: request.term,
					category_id: category_id
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 3,
		select: function(event, ui) { 
			var id = ui.item.id;
			$(this).next().val(id);
		}
	});
	
	// add file row
	$('#add_file_row').click(function(){
		$('#first_section').children('div:last').after("<div class='input-group' id='first_file'><input name='attached_file[]' class='form-control input-sm col-md-6 col-xs-12' type='file'><span class='input-group-btn'><button type='button' class='btn btn-danger btn-sm remove_me'  ><span class='glyphicon glyphicon-minus'></span></button></span></div> ");
		$('.remove_me').click(function(){
			$(this).parent().parent().remove();
		});		
	});
	
	$('#addRateRow').click(function(){	
		$('#rateTable > tbody').append("<tr><td><input type='text' name='size[]' required class='form-control col-lg-12 size'/><input type='hidden' name='size_id[]' class='form-control col-lg-12 size_id'/></td></td><td><input type='text' name='rate[]' required class='form-control col-lg-12 text-right rate'/></td><td><span class='input-group-btn'><button type='button' class='btn btn-danger btn-xs remove_row'><span class='glyphicon glyphicon-minus'></span></button></span></td></tr>");
		
		$('.remove_row').click(function(){
			$(this).parent().parent().parent().remove();
		});		
		
		$(".size").autocomplete({
			search: function() {
			},
			source: function(request, response) {
				$.ajax({
					url: project_url+'controller/productController.php',
					dataType: "json",
					type: "post",
					async:false,
					data: {
						q: "size_info",
						term: request.term
					},
					success: function(data) {
						response(data);
					}
				});
			},
			minLength: 2,
			select: function(event, ui) { 
				var item_id = ui.item.id;
				$(this).next().val(item_id);
			}
		});
		
	});	
	
	$( "#addRateRow" ).trigger( "click" );
	
	load_category = function load_category(){
		$.ajax({
			url: project_url+"controller/productController.php",
			dataType: "json",
			type: "post",
			async:false,
			data:{
				q: "view_category",
			},
			success: function(data){
				var option_html = "";
				$('#category_option').after().html("");
				option_html += '<option value="0">Select Option ..</option>';
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){  
						option_html += '<option value="'+data.id+'">'+data.category_name+'</option>';
					});
				}
				$('#category_option').after().html(option_html);
			}
		});
	}
	
	load_ingredient = function load_ingredient(){
		$.ajax({
			url: project_url+"controller/productController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_ingredient"
			},
			success: function(data) {	
				if(!jQuery.isEmptyObject(data.records)){
					var html = '<table class="table table-bordered jambo_table"><thead><tr class="headings"><th class="column-title text-center" class="col-md-8 col-sm-8 col-xs-8">Ingredients</th><th class="col-md-2 col-sm-2 col-xs-12"><input type="checkbox" id="check-all" class="tableflat">Select All</th></tr></thead>';
						$.each(data.records, function(i,datas){ 			
							 html += '<tr><td colspan="2">';
							 $.each(datas.module_group, function(i,module_group){ 
								module_group_arr = module_group.split("*");	
								html += '<div class="col-md-3" ><input type="checkbox" name="ingredient[]"  class="tableflat"  value="'+module_group_arr[0]+'"/> '+module_group_arr[1]+'</div>';								
							 });
							html += '</td></tr>';
							
						});
					html +='</table>';	
				}
				$('#ingredient_select').html(html);
				$('#product_form').iCheck({
						checkboxClass: 'icheckbox_flat-green',
						radioClass: 'iradio_flat-green'
				});									
				
				$('#product_form input#check-all').on('ifChecked', function () {
					//alert('check');
					$("#product_form .tableflat").iCheck('check');
				});
				
				$('#product_form input#check-all').on('ifUnchecked', function () {
					//alert('ucheck');
					$("#product_form .tableflat").iCheck('uncheck');
				});
			}
		});
	}
	
	load_category();
	load_ingredient();

});
<!-- ------------------------------------------end --------------------------------------->
$(document).ready(function () {	
	
	var current_page_no=1;	
	$('.adv_cl').hide();
	
	load_product = function load_product(search_txt){
		
		$("#search_product_button").toggleClass('active');
		var product_Table_length = parseInt($('#product_Table_length').val());	
		
		var ad_category_name = $("#ad_category_name").val();	
		var ad_category_id = $("#ad_category_id").val();	
		var ad_product_name = $("#ad_product_name").val();	
		var ad_product_id = $("#ad_product_id").val();	
		var is_active_status = $("input[name=is_active_status]:checked").val();		
		var is_rate = $("input[name=is_rate]:checked").val();		
		
		$.ajax({
			url: project_url+"controller/productController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				ad_category_name: ad_category_name,
				ad_category_id: ad_category_id,
				ad_product_name:ad_product_name,
				ad_product_id:ad_product_id,
				is_active_status:is_active_status,
				is_rate:is_rate,
				search_txt: search_txt,
				limit:product_Table_length,
				page_no:current_page_no
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				var html = "";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					if(is_active_status == 1)  	serach_areas += "Available <br>";
					if(is_active_status == 0)  	serach_areas += "Not-Available <br>";
					if(ad_category_id != '')  	serach_areas += "Category Name: "+ad_category_name+" <br>";
					if(ad_product_id != '')  	serach_areas += "Product Name: "+ad_product_name+" <br>";	
					/*<input name="print" type="button" value="Print" id="printBTN" onClick="printpage();" />*/
					
					html +='<div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Cakencookie</h2><h4 style="text-align:center">Product Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
						if(is_rate == 1){
							html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:center">Product</th><th style="text-align:center">Category</th><th style="text-align:center">Details</th><th style="text-align:center">Rate</th></tr></thead><tbody>';
						}
						else{
							html +='<table width="100%" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:center">Product</th><th style="text-align:center">Category</th><th style="text-align:center">Details</th></tr></thead><tbody>';
						}
						$.each(data.records, function(i,data){  
							html += "<tr>";				
							html +="<td style='text-align:left'>"+data.name+"</td>";
							html +="<td style='text-align:left'>"+data.category_head_name+"</td>";
							html +="<td style='text-align:left'>"+data.details+"</td>";
							if(is_rate == 1){
								var s_rate = data.p_rate;
								var p_rate = s_rate.replace(",", "</br>");
								html +="<td style='text-align:center'>"+p_rate+"</td>";	
							}
							html += '</tr>';
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";		
					}
					WinId = window.open("", "Product Report","width=950,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					if(data.entry_status==0){
						$('.product_entry_cl').hide();
					}
					//for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, product_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#product_Table tbody tr').remove();
					$("#search_product_button").toggleClass('active');
					if(!jQuery.isEmptyObject(records_array)){
						//create and set grid table row
						var colums_array=["product_id*identifier*hidden","name","category_head_name","details","p_rate","active_status"];
						//first element is for view , edit condition, delete condition
						//"all" will show /"no" will show nothing
						var condition_array=["","","update_status", "1","delete_status","1"];
						//create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
						//cauton: not posssible to use multiple grid in same page					
						create_set_grid_table_row(records_array,colums_array,condition_array,"product","product_Table", 0);
						//show the showing no of records and paging for records 
						$('#product_Table_div').show();					
						//code for dynamic pagination 				
						paging(total_pages, current_page_no, "product_Table" );					
					}
					//if the table has no records / no matching records 
					else{
						grid_has_no_result("product_Table",6);
					}
				}	
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_product_field").val();
			load_product(search_txt)
		}
	}	
	// function after click search button 
	$('#search_product_button').click(function(){
		var search_txt = $("#search_product_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_product(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_product_field').keypress(function(event){
		var search_txt = $("#search_product_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_product(search_txt)
		}
	})
	// load data initially on page load with paging
	load_product("");
	
	//advance search
	$('#adv_search_button').click(function(){
		load_product("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_product("Print");
	});
	

});
<!-- ------------------------------------------end --------------------------------------->


<!-- ------------------------------------------ start --------------------------------------->
$(document).ready(function () {		
	
	//insert product
	$('#save_product').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#product_form')[0]);
		formData.append("q","insert_or_update");
		//validation 
		if($.trim($('#product_name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Insert Product Name',"#product_name");			
		}
		else if($.trim($('#product_code').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Insert Product Code',"#product_code");			
		}
		else if($.trim($('#category_option').val()) == "0"){
			success_or_error_msg('#form_submit_error','danger',"Please Select Category","#category_option");			
		}
		else if($.trim($('.attached_file').val()) == "" && $.trim($('#product_id').val())==""){
			success_or_error_msg('#form_submit_error','danger',"Please Add Photo","#.attached_file");			
		}
		else if($.trim($('.size_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select Size",".size");			
		}
		else if($.trim($('.rate').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please select Rate",".rate");			
		}
		else{
			$.ajax({
				url: project_url+"controller/productController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
					$('#save_product').removeAttr('disabled','disabled');
					
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_product("");
						clear_form();
					}
				}	
			});
			
		}	
	})
	
	//edit product
	edit_product = function edit_product(product_id){
		$('#product_id').val(product_id);
		$('.img_label').after('');
		$('#rateTable > tbody').html('');
		$('#ingredient_select').html('');
		$.ajax({
			url: project_url+"controller/productController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_product_details",
				product_id: product_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						$('#product_name').val(data.name);
						$('#product_code').val(data.code);
						$('#details').val(data.details);
						$('#category_option').val(data.category_id);
						$('#tag').val(data.tags);	
						
						if(data.availability==1){
							$('#is_active').iCheck('check'); 
						}else{
							$('#is_active').iCheck('uncheck'); 
						}
						
						//size & rate 
						var size_rate = data.p_rate.split(",");
						var i = 0;
						for(i;i<size_rate.length;i++){
							var s_r = size_rate[i].split("*");
							$('#rateTable > tbody').append("<tr><td><input type='text' name='size[]' value ='"+s_r[1]+"' required class='form-control col-lg-12 size'/><input type='hidden' name='size_id[]' value ='"+s_r[0]+"' class='form-control col-lg-12 size_id'/></td></td><td><input type='text' name='rate[]' value ='"+s_r[2]+"' required class='form-control col-lg-12 text-right rate'/></td><td><span class='input-group-btn'><button type='button' class='btn btn-danger btn-xs remove_row'><span class='glyphicon glyphicon-minus'></span></button></span></td></tr>");
							
							$('.remove_row').click(function(){
								$(this).parent().parent().parent().remove();
							});		
							
							$(".size").autocomplete({
								search: function() {
								},
								source: function(request, response) {
									$.ajax({
										url: project_url+'controller/productController.php',
										dataType: "json",
										type: "post",
										async:false,
										data: {
											q: "size_info",
											term: request.term
										},
										success: function(data) {
											response(data);
										}
									});
								},
								minLength: 2,
								select: function(event, ui) { 
									var item_id = ui.item.id;
									$(this).next().val(item_id);
								}
							});
							
						}	
					});				
				}
				
				$('#image_div').html('<label class="control-label col-md-2 col-sm-2 col-xs-12 img_label"></label>');	
				if(!jQuery.isEmptyObject(data.attachment)){
					attachement_html   = '<div class="col-md-12">';
					$.each(data.attachment, function(i,data){				
						if($.trim(data) != ""){
							attachement_html   += '<div class="col-md-2 text-center"><img src="'+project_url+"images/product/thumb/"+$.trim(data.product_image)+'" class="img-thumbnail"><button type="button" class="btn btn-danger btn-xs remove_img" onclick="delete_gallary_image('+data.img_id+','+product_id+')"><span class="glyphicon glyphicon-remove"></span></button></div>';
							$('.remove_img').click(function(){
								$(this).parent().parent().remove();
							});	
						}						
					});
					attachement_html   += '</div>';
					$('.img_label').after(attachement_html);	
				}
				
				
				if(!jQuery.isEmptyObject(data.ingredient)){
					var html = '<table class="table table-bordered jambo_table"><thead><tr class="headings"><th class="column-title text-center" class="col-md-8 col-sm-8 col-xs-8">Ingredients</th><th class="col-md-2 col-sm-2 col-xs-12"><input type="checkbox" id="check-all" class="tableflat">Select All</th></tr></thead>';
						$.each(data.ingredient, function(i,datas){ 			
							 html += '<tr><td colspan="2">';
							 $.each(datas.detail, function(i,detail){ 
								detail_arr = detail.split("*");
								if(detail_arr[2]==1){
									html += '<div class="col-md-3" ><input type="checkbox" name="ingredient[]"  class="tableflat" checked="checked" value="'+detail_arr[0]+'"/> '+detail_arr[1]+'</div>';									
								}else{
									html += '<div class="col-md-3" ><input type="checkbox" name="ingredient[]"  class="tableflat"  value="'+detail_arr[0]+'"/> '+detail_arr[1]+'</div>';							
								}	
							 });
							html += '</td></tr>';
							
						});
					html +='</table>';	
				}
				
				$('#ingredient_select').html(html);
				
				$('#product_form').iCheck({
						checkboxClass: 'icheckbox_flat-green',
						radioClass: 'iradio_flat-green'
				});									
				
				$('#product_form input#check-all').on('ifChecked', function () {
					//alert('check');
					$("#product_form .tableflat").iCheck('check');
				});
				
				$('#product_form input#check-all').on('ifUnchecked', function () {
					//alert('ucheck');
					$("#product_form .tableflat").iCheck('uncheck');
				}); 
				
				
				$('#save_product').html('Update');
				// to open submit post section
				if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
				$( "#toggle_form" ).trigger( "click" );	
			}
		});	
	}
	
	delete_gallary_image = function delete_gallary_image(img_id, product_id){
		var url = project_url+"controller/productController.php";
		$.ajax({
			url: url,
			type:'POST',
			async:false,
			data: "q=delete_attached_file&img_id="+img_id,
			success: function(data){
				if($.isNumeric(data)==true && data>0){
					success_or_error_msg('#form_submit_error',"success","Deleted Successfully");
					//clear_form();
				}
				else{
					success_or_error_msg('#form_submit_error',"danger","Not Deleted...");						
				}
			 }	
		});
	}
	
	delete_product = function delete_product(product_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: project_url+"controller/productController.php",
				type:'POST',
				async:false,
				data: "q=delete_product&product_id="+product_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_product("");
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
		$('#product_id').val('');
		$("#product_form").trigger('reset');
		$("input[name='attached_file[]']:gt(0)").parent().remove();
		$('#image_div').html('');
		load_category();
		load_ingredient();
		
		$('#rateTable > tbody').html('');
		$( "#addRateRow" ).trigger( "click" );
		
		$('#product_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
	
		$("#product_form .tableflat").iCheck('uncheck');
		$('#save_product').html('Save');
	}
	
	$('#clear_button').click(function(){
		clear_form();
	});
	
});


</script>