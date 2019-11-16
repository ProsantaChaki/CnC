
<?php include('includes/header.php');
 if(!isset($_GET['product_id']) || $_GET['product_id']=="") { ob_start(); header("Location:error.php"); exit();}
 
 $product_id = $_GET['product_id'];
 $product_infos = $dbClass->getSingleRow("select * from products where product_id = $product_id");
 $product_size_rate = $dbClass->getResultList("select pr.id, s.name, pr.rate from product_rate pr left join size s on s.id=pr.size_id where pr.product_id = $product_id");
 $product_images =  $dbClass->getResultList("select product_image from  product_image where product_id=$product_id");
 $product_ingredients =  $dbClass->getResultList("select i.name , i.photo from product_ingredient pin left join ingredient i on i.id=pin.ingredient_id where product_id=$product_id");
 $product_reviews = $dbClass->getResultList("select * from product_review where product_id = $product_id");
 $product_reviews_total = $dbClass->getSingleRow("select count(id) total from product_review where product_id = $product_id"); 
 $tags_arr = explode(',',$product_infos['tags']);


 ?>                    
 <!-- Start Main -->
       <main>
            <div class="main-part">
                <section class="home-icon shop-single pad-bottom-remove">
                    <div class="icon-default">
                        <img src="images/scroll-arrow.png" alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="slider slider-for slick-shop">
								<?php
									$thums_image_str = "";																				
									foreach ($product_images as $row){
										extract($row);
									?>
										<div>
											<img src="admin/images/product/<?php echo $product_image; ?>" alt="">
										</div>
									<?php
										$thums_image_str .= "<div><img src='admin/images/product/thumb/$product_image'></div>";
									}
									?>
                                </div>
                                <div class="slider slider-nav slick-shop-thumb">
                                    <?php echo $thums_image_str; ?>                                   
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
								<div id="added_to_cart_message"></div>
                                <h4 class="text-coffee"><?php echo $product_infos['name']; ?></h4>								  
                                <div class="star-review-collect">
                                    <div class="star-rating">
                                        <span class="star-rating-customer" style="width: 100%">
                                        </span>
                                    </div>
                                    <a href="#" class="review-text"><?php echo $product_reviews_total['total']; ?> customer review</a>
                                </div>
                                <p><?php echo $product_infos['details']; ?></p>
								
								<?php
									$option_str = "";
									$i=1;
									$first_id = 0; 
									foreach($product_size_rate as $row){
										extract($row);
										if($i==1){
											$price_str = "<span id='rate_h3'>$rate</span>";
											$first_id = $id;
										}
										$option_str .= "<option style='padding-top:5px; padding-bottom:5px;' value='$id' onclick='set_price($id, ".'"'.$rate.'"'.")'><p>$name</p></option>";
										$i++;
									}
								?>
								<input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>"  />
								<input type="hidden" id="pr_size_id" name="pr_size_id" value="<?php echo $first_id; ?>"  />
                                <h3 class="text-coffee">Tk.&nbsp;<?php echo $price_str; ?> </h3>
								<div class="price-textbox ">
									<select class="form-control  dropdown-custom" id="pr_varient" name="pr_varient">
										<?php echo $option_str; ?>									
									</select>
                                </div>
                                <div class="price-textbox">
                                    <span class="minus-text"><i class="icon-minus" onclick="minus()" id="minus_qty"></i></span>
                                    <input type="text" name="pr_quantity" id="pr_quantity" value="1" pattern="[0-9]">
                                    <span class="plus-text"><i class="icon-plus" onclick="add()" id="add_qty"></i></span>
                                </div>
                                <a href="javascript:void(0)" id="add_to_cart_btn" class="filter-btn btn-large"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Add to Cart</a>
                                <div class="share-tag">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="social-wrap">
                                                <h5>SHARE</h5>
                                                <ul class="social">
                                                    <li class="social-facebook"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                    <li class="social-tweeter"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                    <li class="social-instagram"><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                                    <li class="social-dribble"><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                                                    <li class="social-google"><a href="#"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="tag-wrap">
                                                <h5>TAGS</h5>
													<?php																		
													foreach ($tags_arr as $key=>$val){
														echo "<a href='javascript:void(0)' class='tag-btn'>$val</a>";
													}
													?> 
                                            </div>											
											<div class="tag-wrap">
											   <h5>INGREDIENT</h5>
											   <ul>
												<?php																		
												foreach ($product_ingredients as $row){
													extract($row);
													echo "<li class='col-md-3 col-sm-6 col-xs-6'>".$row['name']."</li>";
												}
												?> 	
												</ul>
											</div>
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Start Tab Part -->
                <section class="default-section comment-review-tab bg-grey v-pad-remove wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="container">
                        <div class="tab-part">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation">
                                    <a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a>
                                </li>
                                <li role="presentation" class="active">
                                    <a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews ( <?php echo $product_reviews_total['total']; ?> )</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane" id="description">
                                    <div class="title text-left">
                                        <h3 class="text-coffee">Description About Product</h3>
                                    </div>
                                    <?php echo $product_infos['details']; ?>
									<br /><br />									
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="reviews">
                                    <!--<div class="title text-center">
                                        <h3 class="text-coffee"><?php echo $product_reviews_total['total']; ?> Comment</h3>
                                    </div>-->
                                    <div class="comment-blog">
										<div id="comment_div">

										</div>
                                        <div class="title text-center">
                                            <h3 class="text-coffee">Leave a Reply</h3>
                                        </div>
                                        <form class="form" method="post" name="review_form" id="review_form">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <textarea placeholder="Comment" name="comment" id="comment" ></textarea>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input name="review_name" id="review_name"  placeholder="Name" type="text">
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input name="review_email" id="review_email" placeholder="Email" type="email">
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="star-review">
                                                        <p>
                                                            <span>Your Rating</span>
                                                            <span class="star-review-customer">
                                                                <a href="javascript:void(0)" onclick="select_star(1)" class="star-1"></a>
                                                                <a href="javascript:void(0)" onclick="select_star(2)" class="star-2"></a>
                                                                <a href="javascript:void(0)" onclick="select_star(3)" class="star-3"></a>
                                                                <a href="javascript:void(0)" onclick="select_star(4)" class="star-4"></a>
                                                                <a href="javascript:void(0)" onclick="select_star(5)" class="star-5"></a>
                                                            </span>
															
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
													<input type="hidden" id="rating_point" name="rating_point" value="1"  />
													<input type="hidden" id="product_id_review" name="product_id_review" value="<?php echo $product_id; ?>"  />
													<div id="review_error" class="text-center" style="display:none"></div>
                                                    <input name="review_submit" id="review_submit"  value="POST COMMENT" class="btn-main" type="submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End Tab Part -->
                <!-- Start Related Product -->
                <section class="related-product wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="container">
                        <div class="build-title">
                            <h3>Related Products</h3>
                        </div>
                        <div class="owl-carousel owl-theme" data-items="4" data-laptop="3" data-tablet="2" data-mobile="1" data-nav="false" data-dots="true" data-autoplay="true" data-speed="1800" data-autotime="5000">
							<?php
								$tag_condition = " where p.product_id != ".$product_id."  ";
								if(!empty($tags_arr)){
									$tag_condition .= " and (";
									foreach ($tags_arr as $key=>$val){
										$tag_condition .= " tags like '%".trim($val)."%' OR";
									}
									$tag_condition = rtrim($tag_condition, ' OR');
									$tag_condition .= " )";
								}																			
								$related_product_info =  $dbClass->getResultList("select p.product_id,p.name,p.code, pm.product_image, round(pr.rate,1) rate, p.category_id, c.name category_name, s.name size_name
																			from products p 
																			left join product_image pm on pm.product_id=p.product_id
																			left join product_rate pr on pr.product_id=p.product_id
																			left join category c on c.id=p.category_id
																			left join size s on s.id=pr.size_id
																			$tag_condition
																			group by p.product_id
																			limit 1,10"
																		);																		
								foreach ($related_product_info as $row){
										extract($row);
								?>
								 <div class="item">
									<div class="related-img">
										<a href="detail-product.php?product_id=<?php echo $product_id; ?>" target="_blank"><img src="admin/images/product/<?php echo $product_image; ?>" alt="" class="circle-round-color "></a>
									</div>
									<div class="related-info">
										<h6><a href="detail-product.php?product_id=<?php echo $product_id; ?>" target="_blank"><?php echo $name .' ('.$size_name.')'; ?></a></h6>
										<h6><a href="detail-product.php?product_id=<?php echo $product_id; ?>" target="_blank"><strong><?php echo number_format($rate,2); ?></strong></a></h6>
									</div>
								</div>			
							<?php
								}
								$error_html= '';
								if(empty($related_product_info)){
									$error_html =
										'<div>
											<div style="text-align:center">
												<h2>There is no related product.</h2>
											</div>
										</div>';
									echo $error_html;
								}						
							?>	
                        </div>
                    </div>
                </section>
                <!-- End Related Product -->
            </div>
        </main>
        <!-- End Main -->
		
<?php include('includes/footer.php'); ?>  

<script>
// ----------------------------code for single item page ------------------------




// add to cart for detail product page
$('#add_to_cart_btn').click(function(){	
	var product_id = $('#product_id').val();
	var quantity = $('#pr_quantity').val();
	var size_rate_id = $('#pr_size_id').val();

	$.ajax({
		url: "includes/controller/ecommerceController.php",
		dataType: "json",
		type: "post",
		async:false,
		data: {
			q: "addToCart",
			product_id:product_id, 
			quantity:quantity,
			size_rate_id:size_rate_id
		},
		success: function(data) {
			if(!jQuery.isEmptyObject(data.records)){
				var html = '';
				var total = 0;
				var sub_total = 0;
				var count =0
				$.each(data.records, function(i,datas){ 
					sub_total += parseFloat(datas.discounted_rate)*(datas.quantity);
					html += '<div class="cart-item"><div class="cart-item-left"><img src="admin/images/product/'+datas.product_image+'" alt=""></div><div class="cart-item-right"><h6>'+datas.product_name+'</h6><span> '+datas.discounted_rate+' * '+datas.quantity+' = '+sub_total+'</span></div><span class="delete-icon" onclick="deleteProduct('+"'"+datas.cart_key+"'"+')"></span></div>';
					count++;
					total += sub_total ; 
				});
				total = total.toFixed(2);
				html += '<div class="subtotal"><div class="col-md-6 col-sm-6 col-xs-6"><h6>Subtotal :</h6></div><div class="col-md-6 col-sm-6 col-xs-6"><span>Tk '+total+'</span></div></div>';
				html  += '<div class="cart-btn"><a href="cart.php" class="btn-main checkout">VIEW ALL</a><a href="checkout.php" class="btn-main checkout">CHECK OUT</a></div>';  
				$('#total_product_in_cart').html(count);
				success_or_error_msg('#added_to_cart_message','info',"Added to cart" ,"#added_to_cart_message");	
				
			}
			else{
				$('#total_product_in_cart').html(0);
				html = "<h6>You have no items in your cart</h6>";
			}
			$('#cart_div').html(html);			
		}
	});		
})



// send mail if forget password
$('#review_submit').click(function(event){	
	event.preventDefault();
	var formData = new FormData($('#review_form')[0]);
	formData.append("q","insert_review");
	if($.trim($('#comment').val()) == ""){
		success_or_error_msg('#review_error','danger',"Please enter comment" ,"#comment");			
	}
	else if($.trim($('#review_name').val()) == ""){
		success_or_error_msg('#review_error','danger',"Please enter your name","#review_name");			
	}
	else if($.trim($('#review_email').val()) == ""){
		success_or_error_msg('#review_error','danger',"Please enter your email address","#review_email");			
	}
	else{
		$.ajax({
			url: "includes/controller/productController.php",
			type:'POST',
			data:formData,
			async:false,
			cache:false,
			contentType:false,processData:false,
			success: function(data){
				if($.isNumeric(data)==true && data==2){
					success_or_error_msg('#review_error',"danger","Sorry review not saved. Please try later. ","#comment" );			
				}
				else if($.isNumeric(data)==true && data==1){
					success_or_error_msg('#review_error','success',"Saved successfuly",".comment-blog");
					load_review();
				}
			 }	
		});
	}	
})


function load_review(){
	// fetch all the  reviews
	var product_id = $('#product_id').val();
	$.ajax({
		url: "includes/controller/productController.php",
		dataType: "json",
		type: "post",
		async:false,
		data: {
			q: "get_comments",
			product_id:product_id
		},
		success: function(data) {
			if(!jQuery.isEmptyObject(data.records)){
				var html = '';
				$.each(data.records, function(i,datas){ 
					rating_point = parseFloat(datas.review_point)*20;			
					html += '<div class="comment-inner-list"><div class="comment-info"><h5>'+datas.review_by_name+'</h5><span class="comment-date">'+datas.r_date+'</span><div class="star-rating"><span class="star-rating-customer" style="width:'+rating_point+'%;"></span></div><br /><p>'+datas.review_details+'</p></div></div>';
				});
			}
			else
				html = "There is no comments.";
			
			$('#comment_div').html(html);
			
		}
	});	
}



function set_price(id, rate){	
	$('#pr_size_id').val(id);
	$('#rate_h3').html(rate);

}

function add(){
	var qty = parseFloat($('#pr_quantity').val());
	$('#pr_quantity').val(qty+1);
}

function minus(){
	var qty = parseFloat($('#pr_quantity').val());
	if(qty>1) $('#pr_quantity').val(qty-1);
}


function select_star(no){	
	$('.star-'+no).css('background:rgba(0, 0, 0, 0) url("../images/star.png") repeat-x scroll left -32px;')
	$('#rating_point').val(no);
}


load_review();

//---------------------------------------------------------------------------------
	
</script>
