<?php include('includes/header.php'); 
$no_item =0;
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) $no_item =1;
$cart = $_SESSION['cart'];

$class= "";
$is_logged_in = 0;
if($is_logged_in_customer != ""){  $class= " hide"; $is_logged_in = 1;}
?> 
 <!-- Start Main -->
        <main>
            <div class="main-part">
                <section class="home-icon shop-cart bg-skeen">
                    <div class="icon-default icon-skeen">
                        <img src="images/scroll-arrow.png" alt="">
                    </div>
                    <div class="container">
                        <div class="checkout-wrap wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <ul class="checkout-bar">
                                <li class="done-proceed">Shopping Cart</li>
                                <li class="active">Checkout</li>
                                <li>Order Complete</li>
                            </ul>
                        </div>
                        <div class="row">
							<form method="post" name="checkout-form" id="checkout-form"> 						
								<div class="col-md-7 col-sm-7 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
									<div class="shop-checkout-left">
										<div class="logged_in_already center <?php echo $class; ?>">
											<h6>You must have to login or register if you are new customer. </h6>
											<br />
											<button class="button-default btn-large btn-primary-gold" data-toggle="modal" data-target="#loginModal" >LOGIN</button> 
											<br /><br />
											<h4 class="center">OR</h4>
											<button class="button-default btn-large btn-primary-gold" data-toggle="modal" data-target="#registerModal" >REGISTER</button> 
											<br />											
											<br />
											
											<!--
											<form class="register-form" method="post" name="register-form" id="register-form"> 
												<div class="row">
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="cust_name" id="cust_name" placeholder="Name" class="input-fields" required>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="cust_username" id="cust_username" placeholder="User Name" class="input-fields" required>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="email" name="cust_email" id="cust_email" placeholder="Email address" class="input-fields" required>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="password" name="cust_password" id="cust_password" placeholder="Password" class="input-fields" required>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="password" name="cust_conf_password" id="cust_conf_password"  placeholder="Confirm Password" class="input-fields" required>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="number" name="cust_contact" id="cust_contact" pattern="[0-9]{11}" placeholder="Contact No" class="input-fields" required>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="cust_address" id="cust_address" placeholder="Address" class="input-fields" >
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12">												
														<div id="registration_submit_error" class="text-center" style="display:none"></div>
														<input type="submit" name="submit" id="register_submit" class="button-default button-default-submit" value="Register now">
													</div>
												</div>
											</form										
											<p>By clicking on “Register Now” button you are accepting the <a  href="terms.php">Terms &amp; Conditions</a></p>
											-->
													
										</div>
										<hr>
										<input type="hidden" id="islogged_in" name="islogged_in" value="<?php echo $is_logged_in; ?>" />
										<div class="col-md-12 col-sm-12 col-xs-12">
											<h6>Delevery/Shipping Details</h6>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<br />
											<label> Please select pickup/delevery date and time </label>
											<input type="text" name="pickup_date_time" id="pickup_date_time" placeholder="Pickup/Delevery date and time" class="input-fields date-picker" required>
										</div>									
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label><input type="radio" name="delevery_type" value="1" id="delevery_type_takeout" checked>Takeout  </label>
											<label><input type="radio" name="delevery_type" value="2" id="delevery_type_delevery">Delivery </label>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-1 hide" id="takeout_div">
											<label> You need to select an outlet   </label>
											<select class="form-control" id="select_outlet" name="select_outlet">
											<?php
												$outlet_infos = $dbClass->getResultList("select id,outlet_name,address,mobile,incharge_name,`status` from outlets o where status=1");
												$i=1;
												foreach($outlet_infos as $row){
													extract($row);
													echo "<option style='padding-top:5px; padding-bottom:5px;' value='$id' ><p>$outlet_name ($address)</p></option>";
													$i++;
												}
											?>							
											</select>	
											<br />
										</div>
										<div class="col-md-12 col-sm-12 col-xs-1 hide " id="delevery_div">
											<label> Please select delivery area  </label>
											<select class="form-control" id="select_delevery" name="select_delevery" >
											<?php
												$delevery_charge_infos = $dbClass->getResultList("select id,type,rate,`status` from delivery_charge  where status=1");
												$i=1;
												foreach($delevery_charge_infos as $row){
													extract($row);
													echo "<option style='padding-top:5px; padding-bottom:5px;' value='$id' ><p>$type >> $rate</p></option>";
													$i++;
												}
											?>
											</select>
											<input type="hidden" id="delevery_charge_rate" name="delevery_charge_rate" value="0" />
											<br />
											<br />
											<textarea placeholder="Delevery Address" name="delivery_address" id="delivery_address"></textarea>
										</div>									
										<div class="col-md-12 col-sm-12 col-xs-12">
											<br />
											<textarea placeholder="Order Notes" name="secial_notes" id="secial_notes"></textarea>
										</div>									
										<div class="col-md-12 col-sm-12 col-xs-12 shop-checkout-box">
											<h5>Payment Methods</h5>
											<label><input type="radio" name="payment_type" value="1" id="bkash_payment">bkash</label>&nbsp;&nbsp;
											<label><input type="radio" name="payment_type" value="2"  id="rocket_payment">Rocket</label>&nbsp;&nbsp;
											<label><input type="radio" name="payment_type" value="3"  id="rocket_payment">Cash On Delevery</label>
											<p>After send your money enter the reference no </p>
											<input type="text" name="reference_no" id="reference_no" placeholder="Reference Number" class="input-fields" required>
											<div class="checkout-button">
												<div id="logn_reg_error" class="text-center" style="display:none"></div>
												<input type="submit" name="submit" id="checkout_submit" class="button-default btn-large btn-primary-gold" value="PROCEED TO PAYMENT">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-5 col-sm-5 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
									<div class="shop-checkout-right">
										<div class="shop-checkout-box">
											<h5>YOUR ORDER</h5>
											<div class="shop-checkout-title">
												<h6>PRODUCT <span>TOTAL</span></h6>
											</div>
											<div class="shop-checkout-row">
											<?php
											//var_dump($_SESSION);//die;
											$cart_total = 0;
											foreach($cart as $key=>$product){
												$cart_total += $product['product_total'];
												echo " <p><span>".$product['product_name']." (".$product['size'].")</span>".$product['quantity']."*".$product['discounted_rate']."<small>".number_format($product['product_total'],2)."</small></p>";
											}
											$cupon_total = 0;
											if(isset($_SESSION['total_discounted_amount'])) $cupon_total = $_SESSION['total_discounted_amount'];
											?>
											</div>
											<div class="checkout-total">
												<h6>DISCOUNT <small><?php echo number_format($cupon_total,2); ?></small></h6>
											</div>
											<div class="checkout-total hide" id="delevery_charge_amt_div">
												<h6>DELEVERY CHARGE <small id="delevery_charge_amt">0</small></h6>
											</div>
											<hr>
											<!--<div class="checkout-total">
												<h6>CART SUBTOTAL <small><?php echo number_format(($cart_total-$cupon_total),2); ?></small></h6>
											</div>
											<div class="checkout-total">
												<h6>SHIPPING <small>Free Shipping</small></h6>
											</div>-->
											<div class="checkout-total">
												<input type="hidden" id="original_grand_total"   name="grand_total" value="<?php echo ($cart_total-$cupon_total); ?>" />
												<input type="hidden" id="grand_total"   name="grand_total" value="<?php echo ($cart_total-$cupon_total); ?>" />
												<h6>ORDER TOTAL <small class="price-big" id="grand_total_amt"><?php echo number_format(($cart_total-$cupon_total),2); ?></small></h6>
											</div>
										</div>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <!-- End Main -->
<?php include('includes/footer.php'); ?>  



<script>

if(<?php echo $no_item; ?> == 1){
	window.location = 'index.php' ;
}

//datepicker
$('.date-picker').daterangepicker({
	singleDatePicker: true,
/*	autoUpdateInput: false,*/
	calender_style: "picker_3",
	timePicker:true,
	locale: {
		  format: 'YYYY-MM-DD h:mm',
		  separator: " - ",
	}
});
$('.date-picker').val("");


// send mail if forget password
$('#checkout_submit').click(function(event){		
	event.preventDefault();
	delevery_type = $("[name='delevery_type']:checked").val();
	payment_type  = $("[name='payment_type']:checked").val();		
	var formData = new FormData($('#checkout-form')[0]);
	formData.append("q","checkout");
	if($.trim($('#islogged_in').val()) == "0"){		
		success_or_error_msg('#logn_reg_error','danger',"You must have to login or register if you are new customer. ","#forget_email");			
	}
	else if($.trim($('#pickup_date_time').val()) == ""){		
		success_or_error_msg('#logn_reg_error','danger',"You must enter the delevery/pickup date time. ","#pickup_date_time");			
	}
	else if( delevery_type== 2 && $('#delivery_address').val() == ""){		
		success_or_error_msg('#logn_reg_error','danger',"You must enter the delevery address. ","#delivery_address");			
	}
	else if((payment_type == 1 || payment_type == 2) && $('#reference_no').val() == ""){		
		success_or_error_msg('#logn_reg_error','danger',"You must enter the reference number. ","#reference_no");			
	}
	else{
		$.ajax({
			url: "includes/controller/ecommerceController.php",
			type:'POST',
			data:formData,
			async:false,
			cache:false,
			contentType:false,processData:false,
			success: function(data){
				if(data==0){
					success_or_error_msg('#logn_reg_error',"danger","Order Faild. please check your information properly","#checkout_submit" );			
				}
				else{
					 window.location = "completed.php?complete=success&order_id="+$.trim(data);
				}
			 }	
		});
	}	
})



$("[name='delevery_type']").change(function(){ 
	var type = $(this).val();
	if(type==1){
		$('#takeout_div').removeClass('hide');
		$('#delevery_div').addClass('hide');
		
		$('#delevery_charge_amt_div').addClass('hide');
		delevery_charge_amt = $('#delevery_charge_rate').val();
		alert(delevery_charge_amt)
		$('#delevery_charge_rate').val(0);
		$('#delevery_charge_amt').html(0);
		
		var grand_total = parseFloat($('#original_grand_total').val());
		$('#grand_tota').val(grand_total);
		$('#grand_total_amt').html(grand_total);
		
	}
	else if(type==2){
		$('#delevery_div').removeClass('hide');
		$('#takeout_div').addClass('hide');
		$('#select_delevery').trigger('change');
	}
}) 

	
$('#select_delevery').change(function(){	
	var type = $('#select_delevery option:selected').text();
	var type_arr = type.split('>>');
	var delevery_charge = parseFloat($.trim(type_arr[1]));

	$('#delevery_charge_rate').val(delevery_charge);
	$('#delevery_charge_amt').html(delevery_charge.toFixed(2));
	$('#delevery_charge_amt_div').removeClass('hide');
		
	var grand_total = parseFloat($('#original_grand_total').val());
		grand_total = grand_total+delevery_charge;

	$('#grand_total').val(grand_total);
	$('#grand_total_amt').html(grand_total.toFixed(2));
	
})

</script>
