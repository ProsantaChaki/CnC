<?php include('includes/header.php'); ?>                    
 <!-- Start Main -->
        <main>
            <div class="main-part">
                <!-- 
                <section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg2.jpg');">
                    <div class="container">
                        <div class="breadcrumb-inner">
                            <h2>SHOP</h2>
                            <a href="index.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </section>
                 -->
                <section class="home-icon blog-main-section shop-page">
                    <div class="icon-default">
                        <img src="images/scroll-arrow.png" alt="">
                    </div>
                    <div class="container">
                        <div class="portfolioFilter category">
                            <div class="portfolioFilter-inner bg-skeen">
								<?php
									$category = "";
									if(isset($_GET['category'])) $category = $_GET['category'];
									
									$page = 1;
									if(isset($_GET['page'])) $page = $_GET['page'];
									if($page==1) $prev_page = 1;
									else 		 $prev_page = $page-1;
									
									$limit_to = ($page-1)*12;
									$limit_from = $page*12;
									
									$count = 0;									
									$category_info = $dbClass->getResultList("select * from category where status=1");										
									foreach ($category_info as $row){
										extract($row);
										$active_class = "";
										if($category == "" && $count==0){
											$active_class = "current";
											$active_category = $id;
										}	
										else if($category !="" && $category == $id) {
											$active_class = "current";
											$active_category = $category;
										}						
										echo "<a class='uppercase $active_class'  href='shop.php?category=$id'>$name</a>";	
										$count++;
									}
								?>	
                            </div>
                        </div>
                        <div class="portfolioContainer row" >	
							<div class="swin-sc swin-sc-product products-02 col-md-12">
								<div class="products nav-slider col-md-12">						
								<?php	
									$product_info =  $dbClass->getResultList("select p.product_id,p.name,p.code, pm.product_image, round(pr.rate,1) rate, p.category_id, c.name category_name, s.name size_name
																				from products p 
																				left join product_image pm on pm.product_id=p.product_id
																				left join product_rate pr on pr.product_id=p.product_id
																				left join category c on c.id=p.category_id
																				left join size s on s.id=pr.size_id
																				where p.availability=1 and  p.category_id=$active_category
																				group by p.product_id
																				limit $limit_to, $limit_from"
																			);																				
									foreach ($product_info as $row){
											extract($row);
									?>
									<div class="col-md-3 col-sm-6 col-xs-12">
									  <div class="blog-item item swin-transition">
										<div class="block-img"><img src="admin/images/product/thumb/<?php echo $product_image; ?>"  alt="" class="img img-responsive round-color">
										  <div class="block-circle price-wrapper"><span class="price woocommerce-Price-amount amount"><span class="price-symbol"></span><?php echo number_format($rate,2); ?></span></div>
										  <div class="group-btn">
											<a href="javascript:void(0)" class="swin-btn btn-link"><i class="icons fa fa-link"></i></a>
											<a href="detail-product.php?product_id=<?php echo $product_id; ?>" target="_blank" class="swin-btn btn-add-to-card"><i class="fa fa-shopping-basket"></i></a>
											<a href="detail-product.php?product_id=<?php echo $product_id; ?>" target="_blank" class="swin-btn btn-add-to-card"><i class="fa fa-eye"></i></a>
										  </div>
										</div>
										<div class="block-content center">
										<strong class="txt-default"> <a href="detail-product.php?product_id=<?php echo $product_id; ?>" target="_blank"><?php echo $name .'('.$size_name.')'; ?></a></strong>
										  <div class="product-info">
											<ul class="list-inline">
											  <li class="author"><span><?php echo $category_name; ?></span><span class="text"></span></li>
											  <li class="rating"><a href="javascript:void(0)"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></a></li>
											</ul>
											
										  </div>
										</div>
									  </div>
									</div>			
								<?php
									}
									$error_html= '';
									if(empty($product_info)){
										$error_html =
											'<div>
												<div class="alert alert-warning" style="text-align:center">
													<h2>There is no product in this catrgory.</h2>
												</div>
											</div>';
										echo $error_html;
									}						
								?>
								</div>
							</div>
                        </div>
						<div class="gallery-pagination">
							<div class="gallery-pagination-inner">
								<ul>
									<li><a href='shop.php?category=<?php echo $_GET['category']; ?>&page=<?php echo $prev_page; ?>'class="pagination-prev"><i class="icon-left-4"></i> <span>Prev page</span></a></li>
									<?php
										$img_info =  $dbClass->getSingleRow("select count(p.product_id) total_product
																				from products p 
																				where p.availability=1 and  p.category_id='".$active_category."' order by p.product_id desc");									
										$total_page = ceil($img_info['total_product']/12);
										for($ppage=1; $ppage<=$total_page; $ppage++){
											$class= "";
											if($page == $ppage)	$class= "active";
											echo "<li class='$class'><a href='shop.php?category=$active_category&page=$ppage'><span>$ppage</span></a></li>";
										}
										if($page==$total_page) $next_page = $total_page;
										else 		 	  	   $next_page = $page+1;
										
									?>	  
									<li><a href='shop.php?category=<?php echo $_GET['category']; ?>&page=<?php echo $next_page; ?>'class="pagination-next"><span>Next page</span><i class="icon-right-4"></i></a></li>
								</ul>
							</div>
						</div>
                    </div>
                </section>
            </div>
        </main>
        <!-- End Main -->
		
<?php include('includes/footer.php'); ?>  

<script>
	
</script>
