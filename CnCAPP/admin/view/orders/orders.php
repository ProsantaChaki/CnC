<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(77) != 1 ){
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
        <h2>Order</h2>
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
						<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Product</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input class="form-control input-sm" type="text" name="ad_product_name" id="ad_product_name"/> 
							<input type="hidden" name="ad_product_id" id="ad_product_id"/> 
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
					</div><br/>
                    <div class="row">
						<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Order Date</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input class="form-control input-sm ad-date-picker" type="text" name="ad_order_date" id="ad_order_date"/>  
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Delivery Date</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input class="form-control input-sm ad-date-picker" type="text" name="ad_delivery_date" id="ad_delivery_date"/>  
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
					</div><br/>
					<div class="row">
						<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
						<label class="control-label col-md-2 col-sm-1 col-xs-6" style="text-align:right">Payment Status</label>
						<div class="col-md-3 col-sm-3 col-xs-6">
							<input type="radio" class="flat_radio" name="ad_is_payment" id="ad_is_payment" value="2"/> Paid
							<input type="radio" class="flat_radio" name="ad_is_payment" id="ad_is_payment" value="1"/> Not paid
							<input type="radio" class="flat_radio" name="ad_is_payment" id="ad_is_payment" value="0" checked="CHECKED"/> All
						</div>
						<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Order Status</label>
						<div class="col-md-4 col-sm-4 col-xs-8">
							<input type="radio" class="flat_radio" name="ad_is_order" id="ad_is_order" value="1"/> Ordered
							<input type="radio" class="flat_radio" name="ad_is_order" id="ad_is_order" value="2"/> Ready
							<input type="radio" class="flat_radio" name="ad_is_order" id="ad_is_order" value="3"/> Picked
							<input type="radio" class="flat_radio" name="ad_is_order" id="ad_is_order" value="0" checked="CHECKED"/> All
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
					<th class="column-title no-link last" width="10%"><span class="nobr"></span></th>	
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

<?php if($dbClass->getUserGroupPermission(74) == 1){ ?>
<div class="x_panel order_entry_cl">
    <div class="x_title">
        <h2>Order Entry</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li>
				<a class="collapse-link" id="toggle_form"><i class="fa fa-chevron-down"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="iniial_collapse">		
		<form method="POST" id="order_form" name="order_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
			<div class="row">
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6"></label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<button id="order_status_option" type="button" style="min-width:60px" class="btn btn-success btn-lg disabled">Ordered</button>
						<input type="hidden" id="order_status_id" name="order_status_id" value="1" />
						<button class="btn btn-primary btn-xs dropdown-toggle" style="width:120px" type="button" id="dropdown_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Change Status
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdown_status">
							<li id="order_ready"><a href="javascript:void(0)" onclick="update_order_status(2)">Ready</a></li>
							<li id="order_picked"><a href="javascript:void(0)" onclick="update_order_status(3)">Picked</a></li>
						</ul>
					</div>
				</div>	
			</div> 
			<d0iv class="row">
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Customer<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<input type="text" id="customer_name" name="customer_name" class="form-control col-lg-12"/>
						<input type="hidden" id="customer_id" name="customer_id"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Delivery Date<span class="required">*</span></label>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="text" id="delivery_date" name="delivery_date" class="date-picker form-control col-lg-12"/>
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Order Date<span class="required">*</span></label>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="text" id="order_date" name="order_date" class="date-picker form-control col-lg-12"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Delivery Type<span class="required">*</span></label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<select class="form-control delivery_option" name="delivery_option" id="delivery_option">
							<option value='1'>Takeout</option>
							<option value='2'>Delivery</option>
						</select>
					</div>	
					<div id="delivery_outlet">
						<label class="control-label col-md-2 col-sm-2 col-xs-6">Outlet<span class="required">*</span></label>
						<div class="col-md-4 col-sm-4 col-xs-6">
							<select class="form-control" name="outlet_option" id="outlet_option">
							</select>
						</div>		
					</div>		
				</div>	
				<div class="form-group" id="delivery_option_list_div" style="display:none">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Delivery Option<span class="required">*</span></label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<select class="form-control delivery_option_list" name="delivery_option_list" id="delivery_option_list">
	
						</select>
					</div>			
				</div>	
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Order Products</label>
					<div class="table-responsive">
						<table class="table table-bordered" id="orderTable">
							<thead>
								<tr>
									<th width="15%">Category</th>
									<th width="15%">Product</th>
									<th width="15%">Size</th>
									<th width="15%">Rate</th>
									<th width="15%">Quantity</th>
									<th width="15%">Total</th>
									<th width="5%"><button id='addRow' type='button' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-plus'></span></button></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
							<tfoot>
								
							</tfoot>
						</table>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Coupon</label>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="text" id="coupon_name" name="coupon_name" class="form-control col-lg-12"/>
						<input type="hidden" id="coupon_type" name="coupon_type"/>
						<input type="hidden" id="coupon_amount" name="coupon_amount"/>
					</div>
					<button type="button" id="apply_button"  class="btn btn-info">Apply</button> 
				</div>
				<div class="form-group" id="delivery_address" style="display:none">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Delivery Address<span class="required">*</span></label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<input type="text" id="address" name="address" class="form-control col-lg-12"/>
					</div>					
				</div>	
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Payment Method</label>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<select class="form-control" name="payment_option" id="payment_option">
							<option value='0' selected >Select Option</option>
							<option value='1'>bKash</option>
							<option value='2'>Rocket</option>
							<option value='3'>Cash On Delevary</option>
						</select>
					</div>
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Payment Reference No</label>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="text" id="payment_referance_no" name="payment_referance_no" class="form-control col-lg-12"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Payment Status<span class="required">*</span></label>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<select class="form-control" name="payment_status" id="payment_status">
							<option value='1'>Not Paid</option>
							<option value='2'>Paid</option>
						</select>
					</div>		
					<label class="control-label col-md-2 col-sm-2 col-xs-6">Paid Amount</label>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<input type="text" id="total_paid_amount" name="total_paid_amount" class="form-control col-lg-12"/>
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">Remarks</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<input  type="hidden"   id="order_id"    name="order_id" />
						<textarea rows="2" cols="100" id="remarks" name="remarks" class="form-control col-lg-12"></textarea> 
					</div>
				</div> 					
			</div>			
			<div class="form-group">	
				<div class="ln_solid"></div>
				<div class="col-md-7 col-sm-7 col-xs-12" style="text-align:right">					   				 
					 <button type="submit" id="save_order"   class="btn btn-success">Save</button>                    
					 <button type="button" id="clear_button" class="btn btn-primary">Clear</button> 
					 <button type="button" id="show_invoice" class="btn btn-info">Invoice </button> 	
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
	
	$('.ad-date-picker').datepicker({
		singleDatePicker: true,
		dateFormat: "yy-mm-dd"
	});
	
	$('#show_invoice').hide();
	
	$('#delivery_date').val('');
	
	$('#order_form').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});	
	
	$('.flat_radio').iCheck({
		//checkboxClass: 'icheckbox_flat-green'
		radioClass: 'iradio_flat-green'
	});
	
	$("#ad_product_name").autocomplete({
		search: function() {

		},
		source: function(request, response) {
			$.ajax({
				url: project_url+'controller/orderController.php',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "ad_product_info",
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
});
<!-- ------------------------------------------end --------------------------------------->

	
<!-- ------------------------------------------Start--------------------------------------->
$(document).ready(function () {		
	
	$("#customer_name").autocomplete({
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: project_url+'controller/orderController.php',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "customer_info",
					term: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 3,
		select: function(event, ui) { 
			var item_id = ui.item.id;
			$(this).next().val(item_id);
		}
	});
	
	$("#coupon_name").autocomplete({
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: project_url+'controller/orderController.php',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "coupon_info",
					term: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 3,
		select: function(event, ui) { 
			var type = ui.item.id;
			$(this).next().val(type);
			var rate = ui.item.rate;
			$('#coupon_amount').val(rate);
		}
	});
	
	
	load_outlets = function load_outlets(){
		$.ajax({
			url: project_url+"controller/orderController.php",
			dataType: "json",
			type: "post",
			async:false,
			data:{
				q: "view_outlets",
			},
			success: function(data){
				var option_html = "";
				$('#category_option').after().html("");
				option_html += '<option value="0">Select Outlet to takeway/Delevery</option>';
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){  
						option_html += '<option value="'+data.id+'">'+data.address+'</option>';
					});
				}
				$('#outlet_option').after().html(option_html);
			}
		});
	}
	
	load_outlets();
	
	$('#delivery_outlet').show();
	
		
	var total_product_amount 	= 0.00;
	var delivery_charge_amount 	= 0.00;
	var tax_amount 				= 0.00;
	var coupon_amount 			= 0.00;
	var total_paid_amount 		= 0.00;
	var grand_total_amount 		= 0.00;	
	
	//Global Veriable declaration 	
	calculate_total_bill = function calculate_total_bill(){
		$("#orderTable > tfoot").html(''); 
		var html_tfoot = '';
		grand_total_amount = ((parseFloat(total_product_amount)+parseFloat(delivery_charge_amount)+parseFloat(tax_amount)))-(parseFloat(coupon_amount));
		html_tfoot += '<tr><td colspan="5" align="right"><b>Total Product Amount</b></td><td align="right"><input type="hidden" id="total_product_amount" name="total_product_amount" value="'+total_product_amount+'"><b>'+total_product_amount+'</b></td></tr>';
		html_tfoot += '<tr><td colspan="5" align="right"><b>Delivery Charge</b></td><td align="right"><input type="hidden" id="delivery_charge_amount" name="delivery_charge_amount" value="'+delivery_charge_amount+'"><b>'+delivery_charge_amount+'</b></td></tr>';
		html_tfoot += '<tr><td colspan="5" align="right"><b>Discount Amount</b></td><td align="right"><input type="hidden" id="coupon_amount" name="coupon_amount" value="'+coupon_amount+'"><b>'+coupon_amount+'</b></td></tr>';
		html_tfoot += '<tr><td colspan="5" align="right"><b>Tax Amount</b></td><td align="right"><input type="hidden" id="tax_amount" name="tax_amount" value="'+tax_amount+'"><b>'+tax_amount+'</b></td></tr>';
		html_tfoot += '<tr><td colspan="5" align="right"><b>Grand Total Amount</b></td><td align="right"><input type="hidden" id="grand_total_amount" name="grand_total_amount" value="'+grand_total_amount+'"><b>'+grand_total_amount+'</b></td></tr>';
		
		$("#orderTable > tfoot").html(html_tfoot); 
	}
	

	$('#apply_button').click(function(){
		var c_type = $('#coupon_type').val();
		var c_amount = $('#coupon_amount').val();
		if(c_type ==""){
			success_or_error_msg('#form_submit_error','danger','Please Select Coupon',"#coupon_name");
		}else if(c_type == 1){
			//alert(c_amount);
			coupon_amount = c_amount;
		}else if(c_type == 2){
			coupon_amount = (parseFloat(total_product_amount)*(parseFloat(c_amount)/100));
		}
		calculate_total_bill();
	});
	
	<!-- delivery option on change -->
	$("#delivery_option").change(function(){
		$('#outlet_option').val(0);
		var option_html = '';	
		if($(this).val() == 2){
			//$('#delivery_outlet').hide();
			$('#delivery_address').show();
			$.ajax({
				url: project_url+"controller/orderController.php",
				dataType: "json",
				type: "post",
				async:false,
				data:{
					q: "view_delivery_list",
				},
				success: function(data){
					if(!jQuery.isEmptyObject(data.records)){
						$('#delivery_option_list_div').show();
						$.each(data.records, function(i,data){  
							//alert(data.id)
							option_html += '<option value="'+data.id+'">'+data.type+' >> '+data.rate+'</option>';
						});
					}
					$('#delivery_option_list').after().html(option_html);
					
					var delivery_charge = $('#delivery_option_list :selected').text();
					var delivery_charge_arr = delivery_charge.split(' >> ');
					delivery_charge_amount = delivery_charge_arr[1];
					calculate_total_bill(); 
					//$("#orderTable > tfoot").after().append('<tr><td colspan="5" style="text-align:right"><b>Dalivery Charge</b></td><td align="right" ><input type="hidden" class="delivery_charge" value="'+delivery_charge_arr[1]+'"><b>'+delivery_charge_arr[1]+'</b></td></tr>'); 
				}
			});		
			
		}
		else if($(this).val() == 1){
			//$("#orderTable > tfoot > tr").next().html('');
			$('#delivery_outlet').show();
			$('#delivery_address').hide(); 
			$('#delivery_option_list').after().html('');
			$('#delivery_option_list_div').hide();
			
			delivery_charge_amount = 0.00;
		
			calculate_total_bill();
		}
		else{
			$('#delivery_outlet').hide();
			$('#delivery_address').hide();
		}
	});
	
	$("#delivery_option_list").change(function(){
		var delivery_charge = $('#delivery_option_list :selected').text();
		var delivery_charge_arr = delivery_charge.split(' >> ');
		delivery_charge_amount = delivery_charge_arr[1];
		calculate_total_bill();
	}); 
	
	
	// add group row
	$('#addRow').click(function(){	
		
		$('#orderTable > tbody').append("<tr><td><input type='text' name='category_name[]' required class='form-control col-lg-12 category_name'/><input type='hidden' class='category_id' name='category_id[]'/></td><td><input type='text' name='product_name[]' class='form-control col-lg-12 product_name'/><input type='hidden' name='product_id[]' class='product_id'/></td><td><input type='text' name='size_name[]' required class='size_name form-control col-lg-12'/><input type='hidden' name='size_rate_id[]' class='size_rate_id'/></td><td><input type='text' name='rate[]' readonly value='0.00' required class='form-control col-lg-12 text-right rate'/></td><td><input type='text' name='quantity[]' class='form-control col-lg-12 quantity' value='1' /></td><td><input type='text' name='total[]' value = '0.00' required class='form-control col-lg-12 text-right total' readonly='readonly'/></td><td><span class='input-group-btn'><button type='button' class='btn btn-danger btn-xs remove_row'><span class='glyphicon glyphicon-minus'></span></button></span></td></tr>");
		//$('#orderTable > tfoot > tr ').next().html('');
		
		
		$('.remove_row').click(function(){
			$(this).parent().parent().parent().remove();
			
			var total_order_product_amount = 0;
			$("#orderTable>tbody>tr").each(function(){					
				var total = $(this).find('.total').val();
				total_order_product_amount += parseFloat(total);
			})
			
			total_product_amount = total_order_product_amount;
			
			calculate_total_bill();
		});
		
		
		$(".category_name").autocomplete({
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
		
		$(".product_name").autocomplete({
			search: function() {
				category_id  = $(this).parent().prev().find('.category_id').val();
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
		
		$(".size_name").autocomplete({
			search: function() {
				product_id  = $(this).parent().prev().find('.product_id').val();
				//alert(product_id)
			},
			source: function(request, response) {
				$.ajax({
					url: project_url+'controller/orderController.php',
					dataType: "json",
					type: "post",
					async:false,
					data: {
						q: "size_rate_info",
						term: request.term,
						product_id: product_id
					},
					success: function(data) {
						response(data);
					}
				});
			},
			minLength: 3,
			select: function(event, ui) { 
				var size_rate_id = ui.item.id;
				var rate  = ui.item.rate;  
				$(this).next().val(size_rate_id);			
				$(this).parent().siblings().find('.rate').val(rate);	
				
				var quantity = $(this).parent().siblings().siblings().find('.quantity').val();
				$(this).parent().next().next().next().find('.total').val(parseInt(rate)*quantity);	
				
				var total_order_product_amount=0;
				$("#orderTable>tbody>tr").each(function(){					
					var total = $(this).find('.total').val();
					total_order_product_amount += parseFloat(total);
				})
				
				total_product_amount = total_order_product_amount;
				
				calculate_total_bill();

			} 			
		});
		
		var total_order_product_amount = 0;
		$("#orderTable>tbody>tr").each(function(){					
			var total = $(this).find('.total').val();
			total_order_product_amount += parseFloat(total);
		})
		
		total_product_amount = total_order_product_amount;
		
		calculate_total_bill();
		
		$('.quantity').focusout(function(e) {
			var quantity = $(this).val();
			//alert(quantity)
			var rate = $(this).parent().siblings().find('.rate').val();
			$(this).parent().next().find('.total').val(parseInt(rate)*quantity);
			
			var total_order_product_amount = 0;
			$("#orderTable>tbody>tr").each(function(){					
				var total = $(this).find('.total').val();
				total_order_product_amount += parseFloat(total);
			})
			total_product_amount = total_order_product_amount;

			calculate_total_bill();

		});	
	});	

	$("#addRow" ).trigger("click" );	
	

	$('.quantity').focusout(function(e) {
        var quantity = $(this).val();
		//alert(quantity)
        var rate = $(this).parent().siblings().find('.rate').val();
		$(this).parent().next().find('.total').val(parseInt(rate)*quantity);
		
		var total_order_product_amount = 0;	
		$("#orderTable>tbody>tr").each(function(){					
			var total = $(this).find('.total').val();
			total_order_product_amount += parseFloat(total);
		})
		total_product_amount = total_order_product_amount;
		
		calculate_total_bill();
    });
	
	
	update_order_status = function update_order_status(status_id){	
		var order_id = $('#order_id').val();
		var url = project_url+"controller/orderController.php";
		$.ajax({
			url: url,
			type:'POST',
			async:false,
			data:{
				q: "update_order_status",
				order_id:order_id,
				status_id:status_id
			},
			success: function(data){
				if(data==1){
					if(status_id==2){
						$('#order_status_option').html("Ready");
						$('#order_status_id').val(2);
						$('#order_ready').hide();
					}
					else if(status_id==3){
						$('#order_status_option').html("Picked");
						$('#order_status_id').val(3);
						$('#order_ready').hide();
						$('#order_picked').hide();
						$('#show_invoice').show();
						$('#save_order').attr('disabled','disabled');
					}
				}	
			 }	
		});	
	}
	
	if($('#payment_status').val()== 2){
		var total_paid_amount = $('.total_order_bill').val();
		$('#total_paid_amount').val(parseFloat(total_paid_amount));
		//alert(2)
	}

	
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
				var todate = "<?php echo date("Y-m-d"); ?>";
				var user_name =  "<?php echo $user_name; ?>";
				var html = "";
				if($.trim(search_txt) == "Print"){
					var serach_areas= "";
					if(ad_product_name != '')  	serach_areas += "Product Name: "+ad_product_name+" <br>";	
					if(ad_order_date != '')  	serach_areas += "Order Date: "+ad_order_date+" <br>";	
					if(ad_delivery_date != '')  serach_areas += "Delivery Date: "+ad_delivery_date+" <br>";	
					if(ad_is_payment == 2)  	serach_areas += "Paid <br>";	
					if(ad_is_payment == 1)  	serach_areas += "Not Paid <br>";	
					if(ad_is_order == 1)    	serach_areas += "Ordered <br>";	
					if(ad_is_order == 2)  	    serach_areas += "Ready <br>";	
					if(ad_is_order == 3)  	    serach_areas += "Picked <br>";	
					
					/*<button class="no-print" onclick="window.print()">Print</button>*/
					
					html +='<button class="no-print" onclick="window.print()">Print</button><div width="100%"  style="text-align:center"><img src="'+employee_import_url+'/images/logo.png" width="80"/></div><h2 style="text-align:center">Cakencookie</h2><h4 style="text-align:center">Order Information Report</h4><table width="100%"><tr><th width="60%" style="text-align:left"><small>'+serach_areas+'</small></th><th width="40%"  style="text-align:right"><small>Printed By: '+user_name+', Date:'+todate+'</small></th></tr></table>';
					
					if(!jQuery.isEmptyObject(data.records)){
				
						html +='<table width="100%" cellpadding="10" border="1px" style="margin-top:10px;border-collapse:collapse"><thead><tr><th style="text-align:center">Order No</th><th style="text-align:center">Customer</th><th style="text-align:center">Product</th><th style="text-align:center">Order Date</th><th style="text-align:center">Delivery Date</th><th style="text-align:center">Payment Status</th><th style="text-align:center">Order Status</th></tr></thead><tbody>';
		
						$.each(data.records, function(i,data){
							//alert(data)	
							html += "<tr>";		
							html +="<td style='text-align:left'>"+data.invoice_no+"</td>";			
							html +="<td style='text-align:left'>"+data.customer_name+"</td>";
							var name = data.p_name;
							var pname = name.replace(", ", "</br>");
							html +="<td style='text-align:left'>"+pname+"</td>";
							html +="<td style='text-align:left'>"+data.order_date+"</td>";
							html +="<td style='text-align:left'>"+data.delivery_date+"</td>";	
							html +="<td style='text-align:center'>"+data.payment_status_text+"</td>";	
							html +="<td style='text-align:center'>"+data.order_status_text+"</td>";	
							html += '</tr>'; 
						});
						html +="</tbody></table>"
					}
					else{
						html += "<table width='100%' border='1px' style='margin-top:10px;border-collapse:collapse'><tr><td><h4 style='text-align:center'>There is no data.</h4></td></tr></table>";		
					}
					WinId = window.open("", "Order Report","width=1150,height=800,left=50,toolbar=no,menubar=YES,status=YES,resizable=YES,location=no,directories=no, scrollbars=YES"); 
					WinId.document.open();
					WinId.document.write(html);
					WinId.document.close();
				}
				else{
					if(data.entry_status==0){
						$('.order_entry_cl').hide();
					}
					//for  showing grid's no of records from total no of records 
					show_record_no(current_page_no, order_Table_length, data.total_records )
					
					var total_pages = data.total_pages;	
					var records_array = data.records;
					$('#order_Table tbody tr').remove();
					$("#search_order_button").toggleClass('active');
					if(!jQuery.isEmptyObject(records_array)){
						//create and set grid table row
						var colums_array=["order_id*identifier*hidden","invoice_no","customer_name","p_name","order_date","delivery_date","payment_status_text","order_status_text"];
						//first element is for view , edit condition, delete condition
						//"all" will show /"no" will show nothing
						var condition_array=["all","","update_status", "1","delete_status","1"];
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
	
	//advance search
	$('#adv_search_button').click(function(){
		load_order("Advance_search");
	});
	
	//print advance search data
	$('#adv_search_print').click(function(){
		load_order("Print");
	});
	
	//insert order
	$('#save_order').click(function(event){  
		event.preventDefault();
		var formData = new FormData($('#order_form')[0]);
		formData.append("q","insert_or_update");
		
		//validation 
		if($.trim($('#customer_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Select Customer Name',"#customer_name");			
		}
		else if($.trim($('.category_id').val()) == "" ){
			success_or_error_msg('#form_submit_error','danger','Please Select Category',".category_name");			
		}
		else if($.trim($('.product_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Select Product Name',".product_name");			
		}
		else if($.trim($('.size_rate_id').val()) == ""){
			success_or_error_msg('#form_submit_error','danger','Please Select Product Size',".size_name");			
		}
		else if($.trim($('#delivery_option').val()) == "1" && $.trim($('#outlet_option').val()) == "0"){ 
 			success_or_error_msg('#form_submit_error','danger',"Please Select Outlet","#outlet_option");		
		}
		else if($.trim($('#delivery_option').val()) == "0" && $.trim($('#address').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert Address","#address");		
		}
		else{
			$.ajax({
				url: project_url+"controller/orderController.php",
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,
				processData:false,
				success: function(data){
					$('#save_order').removeAttr('disabled','disabled');
					
					if($.isNumeric(data)==true && data>0){
						success_or_error_msg('#form_submit_error',"success","Save Successfully");
						load_order("");
						clear_form();
					}
				 }	
			});
			
		}	
	})
	
	view_order = function view_order(order_id){	
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
						order_tr += '<tr><td colspan="4" align="right" ><b>Total Product Bill</b></td><td align="right"><b>'+order_total.toFixed(2)+'</b></td></tr>';
						order_tr += '<tr><td colspan="4" align="right" ><b>Discount Amount</b></td><td align="right"><b>'+data.discount_amount+'</b></td></tr>';
						order_tr += '<tr><td colspan="4" align="right" ><b>Delivery Charge</b></td><td align="right"><b>'+data.delivery_charge+'</b></td></tr>';
						order_tr += '<tr><td colspan="4" align="right" ><b>Total Order Bill</b></td><td align="right"><b>'+total_order_bill.toFixed(2)+'</b></td></tr>';				
						
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
	
	//edit order
	edit_order = function edit_order(order_id){
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
				//alert('Noticed Successfully');
			}	
		});
		
		$('#delivery_address').hide();
		//$('#delivery_outlet').hide();	
		$('#order_id').val(order_id);

		
		$('#orderTable > tbody').html("");
		
		$.ajax({
			url: project_url+"controller/orderController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_order_details",
				order_id: order_id
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){
						
						total_product_amount 	= data.total_order_amt;
						delivery_charge_amount 	= data.delivery_charge;
						tax_amount 				= data.tax_amount;
						coupon_amount 			= data.discount_amount;
						coupon_name 			= data.cupon_id;
						coupon_id 				= data.cupon_id;
						total_paid_amount 		= data.total_paid_amount;
						grand_total_amount 		= data.total_paid_amount;
						
						$('#coupon_name').val(coupon_name);
						$('#coupon_id').val(coupon_id);
						
						if(data.order_status==1){
							$('#order_status_option').html("Ordered");
							$('#order_status_id').val(1);
							$('#order_ready').show();
							$('#order_picked').show();
						}
						if(data.order_status==2){
							$('#order_status_option').html("Ready");
							$('#order_status_id').val(2);
							$('#order_ready').hide();
						}
						else if(data.order_status==3){
							$('#order_status_option').html("Picked");
							$('#order_status_id').val(3);
							$('#order_ready').hide();
							$('#order_picked').hide();
							$('#save').attr('disabled','disabled');
							$('#show_invoice').show();
						}
						
						$('#customer_name').val(data.customer_name);
						$('#customer_id').val(data.customer_id);
						$('#order_date').val(data.order_date);
						$('#delivery_date').val(data.delivery_date);
						$('#delivery_option').val(data.delivery_type);
						$('#outlet_option').val(data.outlet_id);
						var option_html = '';	
						if(data.delivery_type == 2){
							//$('#delivery_outlet').hide();
							$('#delivery_address').show();
							$.ajax({
								url: project_url+"controller/orderController.php",
								dataType: "json",
								type: "post",
								async:false,
								data:{
									q: "view_delivery_list",
								},
								success: function(data){
									if(!jQuery.isEmptyObject(data.records)){
										$('#delivery_option_list_div').show();
										$.each(data.records, function(i,data){  
											//alert(data.id)
											option_html += '<option value="'+data.id+'">'+data.type+' >> '+data.rate+'</option>';
										});
									}
									$('#delivery_option_list').after().html(option_html);
								}
							});
							$('#address').val(data.address);
							$('#delivery_option_list').val(data.delivery_charge_id)

						}
						else if(data.delivery_type == 1){
							$('#delivery_outlet').show();
							$('#delivery_address').hide(); 
							$('#delivery_option_list').after().html('');
							$('#delivery_option_list_div').hide();

						}
						else{
							$('#delivery_outlet').hide();
							$('#delivery_address').hide();
						}						
							
						$('#remarks').val(data.remarks);	
						if(data.payment_method_id == 0 || data.payment_method_id == null){
							$('#payment_option').val(0);	
						}
						else{
							$('#payment_option').val(data.payment_method_id);	
						}	
						
	
						$('#payment_referance_no').val(data.payment_reference_no);							
						$('#payment_status').val(data.payment_status);
						$('#total_paid_amount').val(data.total_paid_amount);
						
						
						order_infos	 = data.order_info;
						var order_arr = order_infos.split(',');
		
						$.each(order_arr, function(i,orderInfo){
							var order_info_arr = orderInfo.split('#');
							var total = ((parseFloat(order_info_arr[6])*parseFloat(order_info_arr[7])));
							$('#orderTable > tbody').append("<tr><td><input type='text' name='category_name[]' value='"+order_info_arr[0]+"' required class='form-control col-lg-12 category_name'/><input type='hidden' class='category_id' name='category_id[]' value='"+order_info_arr[1]+"'/></td><td><input type='text' name='product_name[]' class='form-control col-lg-12 product_name' value='"+order_info_arr[2]+"'/><input type='hidden' name='product_id[]' class='product_id' value='"+order_info_arr[3]+"'/></td><td><input type='text' name='size_name[]' value='"+order_info_arr[4]+"' required class='size_name form-control col-lg-12'/><input type='hidden' name='size_rate_id[]' value='"+order_info_arr[4]+"' class='size_rate_id'/></td><td><input type='text' name='rate[]' readonly value='"+order_info_arr[6]+"' required class='form-control col-lg-12 text-right rate'/></td><td><input type='text' name='quantity[]' class='form-control col-lg-12 quantity' value='"+order_info_arr[7]+"' /></td><td><input type='text' name='total[]' value='"+total+"' required class='form-control col-lg-12 text-right total' readonly='readonly'/></td><td><span class='input-group-btn'><button type='button' class='btn btn-danger btn-xs remove_row'><span class='glyphicon glyphicon-minus'></span></button></span></td></tr>");
							//order_total += parseFloat(total);
						});	
						
						var total_order_product_amount = 0;
						$("#orderTable>tbody>tr").each(function(){					
							var total = $(this).find('.total').val();
							total_order_product_amount += parseFloat(total);
						})						
						total_product_amount = total_order_product_amount;
						calculate_total_bill();						
						$('.remove_row').click(function(){
							$(this).parent().parent().parent().remove();
							
							var total_order_product_amount = 0;
							$("#orderTable>tbody>tr").each(function(){					
								var total = $(this).find('.total').val();
								total_order_product_amount += parseFloat(total);
							})
							
							total_product_amount = total_order_product_amount;
							
							calculate_total_bill();
							
						});
						
						$(".category_name").autocomplete({
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
						
						$(".product_name").autocomplete({
							search: function() {
								category_id  = $(this).parent().prev().find('.category_id').val();
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
						
						$(".size_name").autocomplete({
							search: function() {
								product_id  = $(this).parent().prev().find('.product_id').val();
								//alert(product_id)
							},
							source: function(request, response) {
								$.ajax({
									url: project_url+'controller/orderController.php',
									dataType: "json",
									type: "post",
									async:false,
									data: {
										q: "size_rate_info",
										term: request.term,
										product_id: product_id
									},
									success: function(data) {
										response(data);
									}
								});
							},
							minLength: 3,
							select: function(event, ui) { 
								var size_rate_id = ui.item.id;
								var rate  = ui.item.rate;  
								$(this).next().val(size_rate_id);			
								$(this).parent().siblings().find('.rate').val(rate);	
								
								var quantity = $(this).parent().siblings().siblings().find('.quantity').val();
								$(this).parent().next().next().next().find('.total').val(parseInt(rate)*quantity);	
								
								var total_order_product_amount=0;
								$("#orderTable>tbody>tr").each(function(){					
									var total = $(this).find('.total').val();
									total_order_product_amount += parseFloat(total);
								})
								
								total_product_amount = total_order_product_amount;
								
								calculate_total_bill();
							} 			
						});
					
						$('.quantity').focusout(function(e) {
							var quantity = $(this).val();
							//alert(quantity)
							var rate = $(this).parent().siblings().find('.rate').val();
							$(this).parent().next().find('.total').val(parseInt(rate)*quantity);
							
							var total_order_product_amount = 0;
							$("#orderTable>tbody>tr").each(function(){					
								var total = $(this).find('.total').val();
								total_order_product_amount += parseFloat(total);
							})
							total_product_amount = total_order_product_amount;

							calculate_total_bill();

						});				
					});				
				}
								
				$('#save_order').html('Update');
				
				// to open submit post section
				if($.trim($('#toggle_form i').attr("class"))=="fa fa-chevron-down")
				$( "#toggle_form" ).trigger( "click" );	
			}
		});	
	}
	
	$('#show_invoice').click(function(){
		order_id = $('#order_id').val();
		view_order(order_id);
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


</script>