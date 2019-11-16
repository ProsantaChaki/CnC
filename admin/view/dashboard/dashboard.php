<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
$user_name = $_SESSION['user_name'];

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");

?>
<div class="x_panel">
	<h2>Dashboard</h2>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2>Latest Orders</h2>
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
                <select size="1" style="width: 56px;padding: 6px;" id="order_Table_length" name="order_Table_length" aria-controls="order_Table">
                    <option value="50" selected="selected">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                 </select> 
                 Post
             </label>
         </div>
         <div class="dataTables_filter" id="order_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_order_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_order_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="order_Table" name="table_records" class="table table-bordered  responsive-utilities jambo_table table-striped  table-scroll ">
            <thead >
                <tr class="headings">
                    <th class="column-title" width="8%">Order No</th>
                    <th class="column-title" width="15%">Customer</th>
                    <th class="column-title" width="">Product</th>
                    <th class="column-title" width="14%">Order Date</th> 
                    <th class="column-title" width="14%">Delivery Date</th> 
                    <th class="column-title" width="7%">Payment Status</th> 
                    <th class="column-title" width="7%">Order Status</th> 
					<th class="column-title no-link last" width="5%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="order_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div>
        <div id="order_Table_div">
            <div class="dataTables_info" id="order_Table_info">Showing <span id="from_to_limit"></span> of  <span id="total_record"></span> entries</div>
            <div class="dataTables_paginate paging_full_numbers" id="order_Table_paginate">
            </div> 
        </div>  
    </div>
</div>

<!-- Start Order details -->
<div class="modal fade booktable" id="order_modal" tabindex="-2" role="dialog" aria-labelledby="booktable">
	<div class="modal-dialog" role="document" style="width:80% !important">
		<div class="modal-content">
			<div class="modal-body">
				<div id="order-div">
					<div class="title text-center">
						<h3 class="text-coffee center"><img src="../images/logo.png" alt=""></h3>
						<h4 class="text-coffee center">Order No # <span id="ord_title_vw"></span></h4>
					</div>
					<div class="done_registration ">							    
						<div class="doc_content">
							<div class="col-md-12">
								<div class="col-md-6">
									<h4>Order Details:</h4>				
									<div class="byline">
										<span id="ord_date"></span><br/> 
										<span id="dlv_date"></span> <br/> 
										<span id="dlv_ps"></span> <br/> 
										<span id="dlv_pm"></span>
									</div>	
								</div>
								<div class="col-md-6" style="text-align:right">
									<h4>Customer Details:</h4> 								
									<address id="customer_detail_vw">
									</address>
								</div>
							</div>
							<div id="ord_detail_vw"> 
								<table class="table table-bordered" >
									<thead>
										<tr>
											<th align="center">Product</th>
											<th width="18%" align="center">Size</th>
											<th width="10%" align="center">Quantity</th>
											<th width="18%" style="text-align:right">Rate</th>                           
											<th width="18%"  style="text-align:right">Total</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								<p>Note: <span id="note_vw"></span></p>
								<p>Print Time : <?php echo date("Y-m-d h:m:s"); ?></p>
								<br />
								<p style="font-weight:bold; text-align:center">Thank you. Hope we will see you soon </p>
							</div> 
						</div>									
					</div>							
				</div>
				<div style="text-align:center"><button type="button" class="btn btn-warning" id="order_print"><i class="fa fa-lg fa-print"></i></button></div>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="modal_doc_id" />
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>		
<!-- End order -->

<div class="x_panel">
    <div class="x_title">
        <h2>Order Vs Payment</h2>
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
                <select size="1" style="width:70px;padding: 6px;" id="order_payment_Table_length" name="order_payment_Table_length" aria-controls="order_payment_Table">
                    <option value="50" selected="selected">10000</option>
                 </select> 
                 Post
             </label>
         </div>
		 
         <div class="dataTables_filter" id="order_payment_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_order_payment_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_order_payment_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="order_payment_Table" name="table_records" class="table table-bordered responsive-utilities jambo_table table-striped table-scroll">
            <thead>
                <tr class="headings">
                    <th class="column-title" width="8%">Order No</th>
                    <th class="column-title" width="15%">Customer</th>
                    <th class="column-title" width="10%">Order Date</th> 
                    <th class="column-title" width="11%">Delivery Date</th> 
                    <th class="column-title" width="7%">Payment Status</th> 
                    <th class="column-title" width="7%">Order Status</th> 
                    <th class="column-title" width="10%">Order Amount</th> 
					<th class="column-title" width="7%">Delivery Charge</th> 
                    <th class="column-title" width="10%">Paid Amount</th> 
                    <th class="column-title" width="10%">Balance</th> 
					<th class="column-title no-link last" width="5%"><span class="nobr"></span></th>	
                </tr>
            </thead>
            <tbody id="order_payment_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div> 
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2>Top Ordered Customer</h2>
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
                <select size="1" style="width:70px;padding: 6px;" id="topCustomer_Table_length" name="topCustomer_Table_length" aria-controls="topCustomer_Table">
                    <option value="50" selected="selected">50</option>
                 </select> 
                 Post
             </label>
         </div>
		 
         <div class="dataTables_filter" id="topCustomer_Table_filter">         
			<div class="input-group">
                <input class="form-control" id="search_topCustomer_field" style="" type="text">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary has-spinner" id="search_topCustomer_button">
                     <span class="spinner"><i class="fa fa-spinner fa-spin fa-fw "></i></span>
                     <i class="fa  fa-search "></i>
                    </button> 
                </span>
            </div>
       </div>
       <div style="height:250px; width:100%; overflow-y:scroll">
        <table id="topCustomer_Table" name="table_records" class="table table-bordered responsive-utilities jambo_table table-striped table-scroll">
            <thead>
                <tr class="headings">
                    <th class="column-title" width="30%">Name</th>
                    <th class="column-title" width="20%">Email</th>
                    <th class="column-title" width="20%">Mobile No</th> 
                    <th class="column-title" width="15%">Status</th> 
                    <th class="column-title" width="15%">Total Order</th>
					<th class="column-title no-link last" width="5%"><span class="nobr"></span></th>					
                </tr>
            </thead>
            <tbody id="topCustomer_table_body" class="scrollable">              
                
            </tbody>
        </table>
        </div> 
    </div>
</div>

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


<!-- ------------------------------------------Start --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;	
	load_order = function load_order(search_txt){
		$("#search_order_button").toggleClass('active');
		var order_Table_length = parseInt($('#order_Table_length').val());
		var ad_product_name = $("#ad_product_name").val();	
		var ad_order_date = $("#ad_order_date").val();	
		var ad_delivery_date = $("#ad_delivery_date").val();	
		var ad_product_id = $("#ad_product_id").val();	
		var ad_is_payment = $("input[name=ad_is_payment]:checked").val();
		var ad_is_order = $("input[name=ad_is_order]:checked").val();
		
		$.ajax({
			url: project_url+"controller/orderController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "grid_data",
				ad_order_date: ad_order_date,
				ad_delivery_date: ad_delivery_date,
				ad_product_name: ad_product_name,
				ad_product_id: ad_product_id,
				ad_is_payment: ad_is_payment,
				ad_is_order: ad_is_order,
				search_txt: search_txt,
				limit:order_Table_length,
				page_no:current_page_no
			},
			success: function(data) {				
				//for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, order_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#order_Table tbody tr').remove();
				$("#search_order_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					//create and set grid table row
					var colums_array=["order_id*identifier*hidden","invoice_no","customer_name","p_name","order_date","delivery_date","payment_status_text","order_status_text","order_noticed*hidden","order_id*hidden"];
					//first element is for view , edit condition, delete condition
					//"all" will show /"no" will show nothing
					var condition_array=["all","","", "","",""];
					//create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					//cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"order","order_Table", 0);
					//show the showing no of records and paging for records 
					$('#order_Table_div').show();					
					//code for dynamic pagination 				
					paging(total_pages, current_page_no, "order_Table" );					
				}
				//if the table has no records / no matching records 
				else{
					grid_has_no_result("order_Table",8);
				}
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_order_field").val();
			load_order(search_txt)
		}
	}	
	// function after click search button 
	$('#search_order_button').click(function(){
		var search_txt = $("#search_order_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_order(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_order_field').keypress(function(event){
		var search_txt = $("#search_order_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_order(search_txt)
		}
	})
	// load data initially on page load with paging
	load_order("");

});
<!-- ------------------------------------------end --------------------------------------->

<!-- ------------------------------------------Start --------------------------------------->
$(document).ready(function () {	
	view_order = function view_order(order_id){	

		$('.order_id').each(function (){
			if($.trim($(this).html()) == order_id){
				$(this).closest('tr').removeAttr('style');
			}		
		})

		
		$(this).closest('tr').css('background-color','rgb(240, 176, 176)');
		
		//order noticed update
		$.ajax({
			url: project_url+"controller/orderController.php",
			type:'POST',
			async:false,
			dataType: "json",
			data:{
				q: "set_order_notice_details",
				order_id:order_id
			},
			success: function(data){
				//alert('Order Noticed Successfully');
			}	
		});
		
		$('#ord_detail_vw>table>tbody').html('');
		$.ajax({
			url: project_url+"controller/orderController.php",
			type:'POST',
			async:false,
			dataType: "json",
			data:{
				q: "get_order_details",
				order_id:order_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						$('#ord_title_vw').html(data.invoice_no);
						$('#ord_date').html("Ordered time: "+data.order_date);
						$('#dlv_ps').html("Payment Status: "+data.paid_status);
						$('#dlv_pm').html("Payment Method: "+data.payment_method);
						$('#dlv_date').html("Delivery time: "+data.delivery_date);
						$('#customer_detail_vw').html("<b>Name:</b> "+data.customer_name+"<br/><b>Mobile:</b> "+data.customer_contact_no+"<br/><b>Address:</b> "+data.customer_address);
						$('#note_vw').html(data.remarks);
						
						var order_tr = "";
						var order_total = 0;
						order_infos	 = data.order_info;
						var order_arr = order_infos.split(',');
						$.each(order_arr, function(i,orderInfo){
							var order_info_arr = orderInfo.split('#');
							var total = ((parseFloat(order_info_arr[6])*parseFloat(order_info_arr[7])));
							order_tr += '<tr><td>'+order_info_arr[2]+'</td><td align="center">'+order_info_arr[4]+'</td><td align="center">'+order_info_arr[7]+'</td><td align="center">'+order_info_arr[6]+'</td><td align="right">'+total.toFixed(2)+'</td></tr>';
							order_total += total;
						});	
						var total_order_bill = ((parseFloat(order_total)+parseFloat(data.delivery_charge))-parseFloat(data.discount_amount));
						var total_paid = data.total_paid_amount;
						order_tr += '<tr><td colspan="4" align="right" ><b>Total Product Bill</b></td><td align="right"><b>'+order_total.toFixed(2)+'</b></td></tr>';
						order_tr += '<tr><td colspan="4" align="right" ><b>Discount Amount</b></td><td align="right"><b>'+data.discount_amount+'</b></td></tr>';
						order_tr += '<tr><td colspan="4" align="right" ><b>Delivery Charge</b></td><td align="right"><b>'+data.delivery_charge+'</b></td></tr>';
						order_tr += '<tr><td colspan="4" align="right" ><b>Total Order Bill</b></td><td align="right"><b>'+total_order_bill.toFixed(2)+'</b></td></tr>';				
						order_tr += '<tr><td colspan="4" align="right" ><b>Total Paid</b></td><td align="right"><b>'+total_paid+'</b></td></tr>';		
						order_tr += '<tr><td colspan="4" align="right" ><b>Balance</b></td><td align="right"><b>'+(total_order_bill-total_paid).toFixed(2)+'</b></td></tr>';	
						$('#ord_detail_vw>table>tbody').append(order_tr);

					});								
				}
			 }	
		});
		$('#order_modal').modal();
	}
	
	$(document).on('click','#order_print', function(){
		var divContents = $("#order-div").html();
		var printWindow = window.open('', '', 'height=400,width=800');
		printWindow.document.write('<html><head><title>DIV Contents</title>');
		printWindow.document.write('</head><body style="padding:10px">');
		printWindow.document.write('<link href="../plugin/bootstrap/bootstrap.css" rel="stylesheet">');
		printWindow.document.write(divContents);
		printWindow.document.write('</body></html>');
		printWindow.document.close();
		printWindow.print();
	});
	
	delete_order = function delete_order(order_id){
		if (confirm("Do you want to delete the record? ") == true) {
			$.ajax({
				url: project_url+"controller/orderController.php",
				type:'POST',
				async:false,
				data: "q=delete_order&order_id="+order_id,
				success: function(data){
					if($.trim(data) == 1){
						success_or_error_msg('#page_notification_div',"success","Deleted Successfully");
						load_order("");
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
		$('#order_id').val('');
		$('#customer_id').val('');
		$("#order_form").trigger('reset');
		
		load_outlets();
		
		$('#orderTable > tbody').html("");
		$( "#addRow" ).trigger( "click" );
		
		$('#order_form').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});	
	
		$("#order_form .tableflat").iCheck('uncheck');
		$('#save_order').html('Save');
	}
	
	$('#clear_button').click(function(){
		clear_form();
	});
});


<!-- ------------------------------------------Start --------------------------------------->
$(document).ready(function () {	
	var current_page_no=1;
	load_order_payment = function load_order_payment(search_txt){
		$("#search_order_payment_button").toggleClass('active');
		var order_payment_Table_length = parseInt($('#order_payment_Table_length').val());
		
		var start_date = $("#start_date").val();	
		var end_date = $("#end_date").val();
		var ad_is_payment = $("input[name=ad_is_payment]:checked").val();
		var ad_is_order = $("input[name=ad_is_order]:checked").val();
		
		$.ajax({
			url: project_url+"controller/reportController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "orderReport",
				start_date: start_date,
				end_date: end_date,
				ad_is_payment: ad_is_payment,
				ad_is_order: ad_is_order,
				report_type: "order_vs_payment",
				search_txt: search_txt,
				limit:order_payment_Table_length,
				page_no:current_page_no
			},
			success: function(data) {				
				//for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, order_payment_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#order_payment_Table tbody tr').remove();
				$("#search_order_payment_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					//create and set grid table row
					var colums_array=["order_id*identifier*hidden","invoice_no","customer_name","order_date","delivery_date","payment_status_text","order_status_text","total_order_amt","delivery_charge","total_paid_amount","total_balance_amount"];
					//first element is for view , edit condition, delete condition
					//"all" will show /"no" will show nothing
					var condition_array=["","","","","",""];
					//create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					//cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"order_payment","order_payment_Table", 0);
					//show the showing no of records and paging for records 
					$('#order_payment_Table_div').show();					
					//code for dynamic pagination 				
					paging(total_pages, current_page_no, "order_payment_Table" );					
				}
				//if the table has no records / no matching records 
				else{
					grid_has_no_result("order_payment_Table",11);
				}
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_order_payment_field").val();
			load_order_payment(search_txt)
		}
	}	
	// function after click search button 
	$('#search_order_payment_button').click(function(){
		var search_txt = $("#search_order_payment_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_order_payment(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_order_payment_field').keypress(function(event){
		var search_txt = $("#search_order_payment_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_order_payment(search_txt)
		}
	})
	// load data initially on page load with paging
	load_order_payment("");
	
	
	// Top Ordered Customer grid
	load_topCustomer = function load_topCustomer(search_txt){
		$("#search_topCustomer_button").toggleClass('active');
		var topCustomer_Table_length = parseInt($('#topCustomer_Table_length').val());
		
		$.ajax({
			url: project_url+"controller/reportController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "customerReport",
				is_active_status : "2",
				report_type: "grid",
				search_txt: search_txt,
				limit:topCustomer_Table_length,
				page_no:current_page_no
			},
			success: function(data) {				
				//for  showing grid's no of records from total no of records 
				show_record_no(current_page_no, topCustomer_Table_length, data.total_records )
				
				var total_pages = data.total_pages;	
				var records_array = data.records;
				$('#topCustomer_Table tbody tr').remove();
				$("#search_topCustomer_button").toggleClass('active');
				if(!jQuery.isEmptyObject(records_array)){
					//create and set grid table row
					var colums_array=["id*identifier*hidden","full_name","email","contact_no","status_text","no_of_order"];
					//first element is for view , edit condition, delete condition
					//"all" will show /"no" will show nothing
					var condition_array=["","","","","",""];
					//create_set_grid_table_row(records_array,colums_array,int_fields_array, condition_arraymodule_name,table/grid id, is_checkbox to select tr );
					//cauton: not posssible to use multiple grid in same page					
					create_set_grid_table_row(records_array,colums_array,condition_array,"order_payment","topCustomer_Table", 0);
					//show the showing no of records and paging for records 
					$('#order_payment_Table_div').show();					
					//code for dynamic pagination 				
					paging(total_pages, current_page_no, "topCustomer_Table" );					
				}
				//if the table has no records / no matching records 
				else{
					grid_has_no_result("topCustomer_Table",6);
				}
			}
		});	
	}
	// load desire page on clik specific page no
	load_page = function load_page(page_no){
		if(page_no != 0){
			// every time current_page_no need to change if the user change page
			current_page_no=page_no;
			var search_txt = $("#search_topCustomer_field").val();
			load_topCustomer(search_txt)
		}
	}	
	// function after click search button 
	$('#search_topCustomer_button').click(function(){
		var search_txt = $("#search_topCustomer_field").val();
		// every time current_page_no need to set to "1" if the user search from search bar
		current_page_no=1;
		load_topCustomer(search_txt);		
	});
	//function after press "enter" to search	
	$('#search_topCustomer_field').keypress(function(event){
		var search_txt = $("#search_topCustomer_field").val();	
		if(event.keyCode == 13){
			// every time current_page_no need to set to "1" if the user search from search bar
			current_page_no=1;
			load_topCustomer(search_txt)
		}
	})
	// load data initially on page load with paging
	load_topCustomer("");
	
	$('.dataTables_length').hide();
	$('.dataTables_filter').hide();
	
	
	$('.order_noticed').each(function (){
		if($.trim($(this).html()) == 1){
			$(this).closest('tr').css('background-color','rgb(240, 176, 176)');
		}		
	})

});
<!-- ------------------------------------------end --------------------------------------->


</script>