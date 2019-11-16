<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(85) != 1){
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
        <h2>Product Report</h2>
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
			<div class="row advance_search_div alert alert-warning">
				<div class="row">
					<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Category</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<select class="form-control" name="category_option" id="category_option">
						</select> 
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Product</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control input-sm" type="text" name="product_name" id="product_name"/> 
						<input type="hidden" name="product_id" id="product_id"/> 
					</div>
					<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
				</div><br/>
				<div class="row">
					<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Availability</label>	
					<div class="form-group col-md-3 col-sm-3 col-xs-6">
						<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="1"/> Yes
						<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="0" /> No
						<input type="radio" class="flat_radio" name="is_active_status" id="is_active_status" value="2" checked="CHECKED"/> All
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Rate</label>
					<div class="col-md-3 col-sm-3 col-xs-8">
						<input type="radio" class="flat_radio" name="is_rate" id="is_rate" value="1"/> Yes
						<input type="radio" class="flat_radio" name="is_rate" id="is_rate" value="0" checked="CHECKED"/> No
					</div>
					<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
				</div>
				<br/>
				<div style="text-align:center">	
					<div class="ln_solid"></div>	
					<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right">
						<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i> Report</button>                        
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="ad_form_submit_error" class="text-center" style="display:none"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Adnach search end -->
		 
    </div>
</div>
	
<?php

	} 
?>
<script src="js/customTable.js"></script> 

<script> 
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
	
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
	
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
	
	load_category();
	
	$("#product_name").autocomplete({
		search: function() {
			category_id  = $("#category_option option:selected").val();
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
	
});
<!-- ------------------------------------------end --------------------------------------->



<!-- ------------------------------------------Start --------------------------------------->
$(document).ready(function () {	
		
	load_product_grid = function load_product_grid(search_txt){
		var category_name='';
		var category_id = $("#category_option option:selected").val();
		var category = $("#category_option option:selected").text();
		var category_arr = category.split(' >> ');	
		var category_name = category_arr[1];	
		var product_id = $("#product_id").val();		
		var product_name = $("#product_name").val();		
		var is_active_status = $("input[name=is_active_status]:checked").val();
		var is_rate = $("input[name=is_rate]:checked").val();
		
		$.ajax({
			url: project_url+"controller/reportController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "productReport",
				is_active_status: is_active_status,
				is_rate: is_rate,
				category_id: category_id,
				category_name: category_name,
				product_name: product_name,
				product_id: product_id
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				var html = "";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					
					if(category_id != 0) 							serach_areas += "Category: "+category_name+" <br>";		
					if(product_name != '' && product_id !="") 		serach_areas += "Product: "+product_name+" <br>";		
					if(is_active_status == 1)  						serach_areas += "Active <br>";
					if(is_active_status == 0)  						serach_areas += "In-Active <br>";		
					
											
					html +='<button class="no-print" onclick="window.print()">Print</button><div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Cakencookie</h2><h4 style="text-align:center">Product Wise Order Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%" style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
				
						if(is_rate == 1){
							html +='<table width="100%" cellpadding="10" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:center">Id</th><th style="text-align:center">Product</th><th style="text-align:center">Category</th><th style="text-align:center">Status</th><th style="text-align:center">Details</th><th style="text-align:center">Rate</th></tr></thead><tbody>';		
						}
						else{
							html +='<table width="100%" cellpadding="10" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:center">Id</th><th style="text-align:center">Product</th><th style="text-align:center">Category</th><th style="text-align:center">Status</th><th style="text-align:center">Details</th></tr></thead><tbody>';	
						}
						
						$.each(data.records, function(i,data){
							//alert(data)	
							html += "<tr>";		
							html +="<td style='text-align:left'>"+data.product_id+"</td>";
							html +="<td style='text-align:left'>"+data.name+"</td>";	 
							html +="<td style='text-align:left'>"+data.c_name+"</td>";
							html +="<td style='text-align:left'>"+data.status_text+"</td>";	
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
					WinId = window.open("", "Product Wise Order Report","width=850,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
					clear_form();
				}
				
			}
		});
			
	}

	//print advance search data
	$('#adv_search_print').click(function(){
		load_product_grid("Print");
	});
	
	clear_form = function clear_form(){			 
		$('#product_id').val('');
		$("#product_name").val('');
	}
	
});
<!-- ------------------------------------------end --------------------------------------->




</script>