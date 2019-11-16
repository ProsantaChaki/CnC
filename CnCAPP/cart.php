<?php include('includes/header.php'); 
	//var_dump($_SESSION);die;
?>                    
 <!-- Start Main -->
        <main>
            <div class="main-part">
                <!-- 
                <section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg1.jpg');">
                    <div class="container">
                        <div class="breadcrumb-inner">
                            <h2>SHOP CART</h2>
                            <a href="index.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </section>
				-->
                <!-- End Breadcrumb Part -->
                <section class="home-icon shop-cart bg-skeen">
                    <div class="icon-default icon-skeen">
                        <img src="images/scroll-arrow.png" alt="">
                    </div>
                    <div class="container" id="product_container">
					    <div class="checkout-wrap wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <ul class="checkout-bar">
                                <li class="active">Shopping Cart</li>
                                <li>Checkout</li>
                                <li>Order Complete</li>
                            </ul>
                        </div>
						<?php
						if(!isset($_SESSION['cart']) || empty($_SESSION['cart']))$cart = array();
						else 													 $cart = $_SESSION['cart'];
						
						if(count($cart)>0){
						?>
                        <div class="shop-cart-list wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<form class="form" method="post" name="cart_detail" id="cart_detail">
								<table class="shop-cart-table">
										<thead>
											<tr>
												<th>PRODUCT</th>
												<th>PRICE</th>
												<th>QUANTITY</th>
												<th>TOTAL</th>
											</tr>
										</thead>
										<tbody>
										<?php
										//var_dump($_SESSION);//die;
										$cart_total = 0;
										foreach($cart as $key=>$product){
											$cart_total += $product['product_total'];
											echo "
											<tr id='tr_$key'>
												<td>
													<div class='product-cart'>
														<img class='cart_product_image round-color' src='admin/images/product/thumb/".$product['product_image']."' alt=''>
													</div>
													<div class='product-cart-title'>
														<span>".$product['product_name']." (".$product['size'].") </span>
													</div>
												</td>
												<td>
													<strong>".$product['discounted_rate']."</strong>
													<!--<del>$5400.00</del>-->
												</td>
												<td>
													<div class='price-textbox'>
														<span class='minus-text'><i class='icon-minus' onclick='minusProd(".'"'.$key.'"'.")' ></i></span>
														<input type='hidden' name='cart_key[]' value='".$key."'  />
														<input name='quantity[]' id='quantity_$key' placeholder='1' type='text' value='".$product['quantity']."'>
														<span class='plus-text'><i class='icon-plus' onclick='addProd(".'"'.$key.'"'.")'></i></span>
													</div>
												</td>
												<td>
													".number_format($product['product_total'],2)."
												</td>
												<td class='shop-cart-close'><i class='icon-cancel-5' onclick='deleteProductFromCart(".'"'.$key.'"'.")'></i></td>
											</tr>										
											";
										}
										$cupon_total = 0;
										if(isset($_SESSION['total_discounted_amount'])) $cupon_total = $_SESSION['total_discounted_amount'];
										?>                                    
										</tbody>
								</table>
								
								<div class="product-cart-detail">
									<div class="cupon-part">
										<input type="text" name="cupon_code" id="cupon_code" placeholder="Cupon Code">
									</div>
									<a href="javascript:void(0)" class="btn-medium btn-dark-coffee" id="apply_cupon">Apply Coupon</a>
									<input name="update_cart" id="update_cart"  value="UPDATE CART" class="btn-medium btn-skin pull-right" type="submit">
								</div>
							</form>
                        </div>
                        <div class="cart-total wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="cart-total-title">
                                <h5>CART TOTALS</h5>
                            </div>
                            <div class="product-cart-total">
                                <small>Total products</small>
								
                                <span id="cart_total"><?php echo number_format($cart_total,2); ?></span>
                            </div>
                            <div class="product-cart-total" id="discount">
                                <small >Total Discount</small>
                                <span id="discount_total"><?php echo number_format($cupon_total,2); ?></span>
                            </div>
                            <div class="grand-total">
                                <h5>TOTAL <span id="grand_total"><?php echo number_format(($cart_total-$cupon_total),2); ?></span></h5>
                            </div>
                            <div class="proceed-check">
                                <a href="checkout.php" class="btn-primary-gold btn-medium">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
						<?php
						}
						else{
							echo "<div class='alert alert-danger center' style='width:100%; min-height:100px'>There is no product in your cart</div>";
						}
						?>
                    </div>
                </section>
            </div>
        </main>
        <!-- End Main -->
		
<?php include('includes/footer.php'); ?>  

<script>


$('#apply_cupon').click(function(){	
	var cupon_code = $('#cupon_code').val();
	if(cupon_code !=""){
		$.ajax({
			url: "includes/controller/ecommerceController.php",
			type:'POST',
			async:false,
			data: "q=apply_cupon&cupon_code="+cupon_code,
			success: function(data){
				/*if($.trim(data) == 1)*/
				location.reload();
			 }	
		});
	}
})

// send mail if forget password
$('#update_cart').click(function(event){	
	event.preventDefault();
	var formData = new FormData($('#cart_detail')[0]);
	formData.append("q","update_cart");
	$.ajax({
		url: "includes/controller/ecommerceController.php",
		type:'POST',
		data:formData,
		async:false,
		cache:false,
		contentType:false,processData:false,
		success: function(data){
			if(data==1)  location.reload();	
		 }	
	});
})
	
function deleteProductFromCart(cart_key){
	$.ajax({
		url: "includes/controller/ecommerceController.php",
		dataType: "json",
		type: "post",
		async:false,
		data: {
			q: "removeFromCart",
			cart_key:cart_key
		},
		success: function(data) {
			$('#tr_'+cart_key).remove();
			if(!jQuery.isEmptyObject(data.records)){
				var html = '';
				var total = 0;
				var sub_total = 0;
				var count =0				
				$.each(data.records, function(i,datas){ 
					sub_total += parseFloat(datas.discounted_rate)*(datas.quantity);
					html += '<div class="cart-item"><div class="cart-item-left"><img src="admin/images/product/'+datas.product_image+'" alt=""></div><div class="cart-item-right"><h6>'+datas.product_name+'</h6><span> '+datas.discounted_rate+' * '+datas.quantity+' = '+sub_total+'</span></div><span class="delete-icon" onclick="deleteProductFromCart('+"'"+datas.cart_key+"'"+')"></span></div>';
					count++;
					total += sub_total ; 
				});
				//var cupon_amount = datas.cupon_amount;
				//if()
				total = total.toFixed(2);			
				$('#cart_total').html(total);
				$('#discount_total').html(total);
				$('#grand_total').html(total);
				
				html += '<div class="subtotal"><div class="col-md-6 col-sm-6 col-xs-6"><h6>Subtotal :</h6></div><div class="col-md-6 col-sm-6 col-xs-6"><span>Tk '+total+'</span></div></div>';
				html  += '<div class="cart-btn"><a href="cart.php" class="btn-main checkout">VIEW ALL</a><a href="checkout.php" class="btn-main checkout">CHECK OUT</a></div>';  
				$('#total_product_in_cart').html(count);
			}
			else{
				html = "<div class='alert alert-danger center' style='width:100%; min-height:100px'>There is no product in your cart</div>";
				$('#product_container').html(html);
			}			
		}
	});	
}	

function addProd(cart_key){
	var qty = parseFloat($('#quantity_'+cart_key).val());
	$('#quantity_'+cart_key).val(qty+1);
}

function minusProd(cart_key){
	var qty = parseFloat($('#quantity_'+cart_key).val());
	if(qty>1)  $('#quantity_'+cart_key).val(qty-1);
}
	
</script>
