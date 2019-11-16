<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(87) != 1){
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
        <h2>Product Sell Report</h2>
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
					<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>	
					<div class="form-group col-md-4 col-sm-4 col-xs-6">
						<button type="button" class="btn btn-primary btn-sm" id="today">Today</button>
						<button type="button" class="btn btn-primary btn-sm" id="thisMonth">This Month</button>
						<button type="button" class="btn btn-primary btn-sm" id="thisYear">This Year</button>
					</div>
				</div><br/>
				<div class="row">
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Category</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<select class="form-control" name="category_option" id="category_option">
						</select>
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Product Name</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control" type="text" name="product_name" id="product_name"/> 
						<input type="hidden" name="product_id" id="product_id"/> 
					</div>
				</div><br/>
				<div class="row">
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Start Date</label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<input type="text" id="start_date" name="start_date" class="form-control date-picker"/>
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">End Date</label>	
					<div class="form-group col-md-3 col-sm-3 col-xs-6">
						<input type="text" id="end_date" name="end_date" class="form-control date-picker"/>
					</div>
				</div><br/>
				<div style="text-align:center">					
					<div class="col-md-7 col-sm-7 col-xs-12" style="text-align:right">
						<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i> Report</button>                        
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12">
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
	
	$('.date-picker').datepicker({
		singleDatePicker: true,
		dateFormat: "yy-mm-dd"
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
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();	
		
		$.ajax({
			url: project_url+"controller/reportController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "productSellReport",
				product_id: product_id,
				product_name: product_name,
				category_name: category_name,
				category_id: category_id,
				start_date: start_date,
				end_date: end_date
			},
			success: function(data) {
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				var html = "";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					if(category_id != 0) 							serach_areas += "Category: "+category_name+" <br>";		
					if(product_name != '' && product_id !="") 		serach_areas += "Product: "+product_name+" <br>";			
					if(start_date != '')  							serach_areas += "Start Date: "+start_date+" <br>";	
					if(end_date != '')  							serach_areas += "End Date: "+end_date+" <br>";	
					
											
					html +='<button class="no-print" onclick="window.print()">Print</button><div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Cakencookie</h2><h4 style="text-align:center">Product Sell Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
				
						html +='<table width="100%" cellpadding="10" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:left">Id</th><th style="text-align:left">Product</th><th style="text-align:center">Quantity</th></tr></thead><tbody>';
						$.each(data.records, function(i,data){
							//alert(data)	
							html += "<tr>";		
							html +="<td style='text-align:left'>"+data.product_id+"</td>";	 
							html +="<td style='text-align:left'>"+data.p_name+"</td>";	 
							html +="<td style='text-align:center'>"+data.quantity+"</td>";
							html += '</tr>'; 
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";		
					}
					WinId = window.open("", "Product Sell Report","width=750,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
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
	
	//current date calculation
	var date = new Date();	
	var year = date.getFullYear();
	var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
	
	if((lastDay.getMonth() + 1) < 10){
		var lmonth = "0"+(lastDay.getMonth() + 1);
	}else{
		lmonth = lastDay.getMonth() + 1;
	}
	//alert(lmonth)
	var ldays = (lastDay.getFullYear() + '-' + (lmonth) + '-' + lastDay.getDate());

	if((firstDay.getDate()) < 10){
		var lday = "0"+(firstDay.getDate());
	}else{
		lday = firstDay.getDate();
	}
	var fdays = (lastDay.getFullYear() + '-' + (lmonth) + '-' + lday);
	
	$('#today').click(function(){		
		$("#start_date").val(year + '-' + (lmonth) + '-' +date.getDate());
		$("#end_date").val(year + '-' + (lmonth) + '-' + date.getDate());
		load_product_grid("Print");
	});	 
	
	$('#thisMonth').click(function(){		
		$("#start_date").val(fdays);
		$("#end_date").val(ldays);
		load_product_grid("Print");
	});	
	
	$('#thisYear').click(function(){
		$("#start_date").val(year+"-01-01");
		$("#end_date").val(year+"-12-31");
		load_product_grid("Print");
	});
	
	
	clear_form = function clear_form(){			 
		$('#product_id').val('');
		$("#product_name").val('');
	}
	
});
<!-- ------------------------------------------end --------------------------------------->




</script>