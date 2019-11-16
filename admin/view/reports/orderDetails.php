<?php
session_start();
include '../../includes/static_text.php';
include("../../dbConnect.php");
include("../../dbClass.php");
$dbClass = new dbClass;
$user_type = $_SESSION['user_type'];

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header("Location:".$activity_url."../view/login.php");
else if($dbClass->getUserGroupPermission(84) != 1){
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
        <h2>Order Details Report</h2>
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
					<label class="control-label col-md-2 col-sm-2 col-xs-6" style="text-align:right">Order No<span class="required">*</span></label>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<input class="form-control input-sm" type="text" name="order_no" id="order_no"/> 
						<input type="hidden" name="order_id" id="order_id"/> 
					</div>
					<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>	
					<button type="button" class="btn btn-warning" id="adv_search_print"><i class="fa fa-lg fa-print"></i> Report</button>
					<label class="control-label col-md-1 col-sm-1 col-xs-6"></label>
				</div><br/>
				<div style="text-align:center">				
					<div id="ad_form_submit_error" class="text-center" style="display:none"></div>
				</div>
			</div>
		</div>
		<!-- Adnach search end -->
		 
    </div>
</div>


<!-- Start Order details -->
<div class="modal fade booktable" id="order_modal" tabindex="-2" role="dialog" aria-labelledby="booktable">
	<div class="modal-dialog" role="document" style="width:70% !important">
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
										<span id="dlv_date"></span> 
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
	
	$("#order_no").autocomplete({
		search: function() {
		},
		source: function(request, response) {
			$.ajax({
				url: project_url+'controller/reportController.php',
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "order_no_info",
					term: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 3,
		select: function(event, ui) { 
			var order_id = ui.item.id;
			$(this).next().val(order_id);
		}
	});
	
});
<!-- ------------------------------------------end --------------------------------------->



<!-- ------------------------------------------Start --------------------------------------->
$(document).ready(function () {	
		
	load_data = function load_data(search_txt){
		
		var order_id = $("#order_id").val();
		var order_no = $("#order_no").val();		
		
		if($.trim($('#order_id').val()) == ""){
			success_or_error_msg('#ad_form_submit_error','danger','Please Insert Order No',"#order_no");			
		}
		else{
			$.ajax({
				url: project_url+"controller/reportController.php",
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "orderReport",
					order_no: order_no,
					order_id: order_id
				},
				success: function(data) {
					var todate = "<?php echo date("Y-m-d"); ?>";
					var user_name =  "<?php echo $user_name; ?>";
					var html = "";
					if($.trim(search_txt) == "Print"){
						var serach_areas= "";				
						$('#ord_detail_vw>table>tbody').html('');						
						if(!jQuery.isEmptyObject(data.records)){
							$.each(data.records, function(i,data){
								$('#ord_title_vw').html(data.invoice_no);
								$('#ord_date').html("Ordered time: "+data.order_date);
								$('#dlv_date').html("Delivery time: "+data.delivery_date);
								$('#customer_detail_vw').html(" "+data.customer_name+"<br/><b>Mobile:</b> "+data.customer_contact_no+"<br/><b>Address:</b> "+data.customer_address);
								$('#note_vw').html(data.remarks);
								
								var order_tr = "";
								var order_total = 0;
								order_infos	 = data.order_info;
								var order_arr = order_infos.split(',');
								$.each(order_arr, function(i,orderInfo){
									var order_info_arr = orderInfo.split('#');
									var total = ((parseFloat(order_info_arr[6])*parseFloat(order_info_arr[7])));
									order_tr += '<tr><td>'+order_info_arr[2]+'</td><td align="left">'+order_info_arr[4]+'</td><td align="center">'+order_info_arr[7]+'</td><td align="right">'+order_info_arr[6]+'</td><td align="right">'+total.toFixed(2)+'</td></tr>';
									order_total += total;
								});	
								var total_order_bill = parseFloat(order_total)-parseFloat(data.discount_amount);
								var total_paid = data.total_paid_amount;
								order_tr += '<tr><td colspan="4" align="right" ><b>Total Product Bill</b></td><td align="right"><b>'+order_total.toFixed(2)+'</b></td></tr>';
								order_tr += '<tr><td colspan="4" align="right" ><b>Discount Amount</b></td><td align="right"><b>'+data.discount_amount+'</b></td></tr>';
								order_tr += '<tr><td colspan="4" align="right" ><b>Total Order Bill</b></td><td align="right"><b>'+total_order_bill.toFixed(2)+'</b></td></tr>';	
								order_tr += '<tr><td colspan="4" align="right" ><b>Delivery Charge</b></td><td align="right"><b>'+data.delivery_charge+'</b></td></tr>';	
								order_tr += '<tr><td colspan="4" align="right" ><b>Total Paid</b></td><td align="right"><b>'+total_paid+'</b></td></tr>';		
								order_tr += '<tr><td colspan="4" align="right" ><b>Balance</b></td><td align="right"><b>'+((total_order_bill+parseFloat(data.delivery_charge))-total_paid).toFixed(2)+'</b></td></tr>';							
								$('#ord_detail_vw>table>tbody').append(order_tr);
							});								
						} 
					}					
				}
			});
			$('#order_modal').modal();
		}
			
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

	//print advance search data
	$('#adv_search_print').click(function(){
		load_data("Print");
	});
	
});
<!-- ------------------------------------------end --------------------------------------->




</script>