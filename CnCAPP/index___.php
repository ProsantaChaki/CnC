<?php 
	include('includes/header.php');
?>
	<!-- Start Main -->
	<main>
		<div class="main-part">
			<!-- Start Slider Part -->
			<section class="home-slider">
				<div class="tp-banner-container">
					<div class="tp-banner">
						<ul>						
						<?php 
							$banner_info =  $dbClass->getResultList("select id,title,text,photo,status from banner_image where status=1  order by id desc limit 1,2");
							foreach ($banner_info as $banner){
								extract($banner);				
								echo '<li data-transition="zoomout" data-slotamount="2" data-masterspeed="1000" data-thumb="" data-saveperformance="on" data-title="Slide">
										<img src="/images/dummy.png" alt="slider" data-lazyload="admin/'.$photo.'" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
										<!-- LAYERS -->
										<div class="tp-caption very_large_text" data-x="center" data-hoffset="0" data-y="250" data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;" data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="1000" data-start="500" data-easing="Back.easeInOut" data-endspeed="300">WE’RE CAKENCOOKIE 
										</div>
										<!-- LAYERS -->
										<div class="tp-caption medium_text" data-x="center" data-hoffset="0" data-y="340" data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;" data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="1000" data-start="500" data-easing="Back.easeInOut" data-endspeed="300">Savory/Pastry/Cake/Coffee/Cookies/Bread
										</div>
										<!-- LAYERS -->
										<div class="tp-caption" data-x="center" data-hoffset="0" data-y="425" data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;" data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" data-speed="1000" data-start="500" data-easing="Back.easeInOut" data-endspeed="300"><a href="shop.php" class="button-white">Explore NOW</a>
										</div>
									</li>';
								}
							?>
						</ul>
					</div>
				</div>
			</section>
			<!-- End Slider Part -->
			<!-- Start Welcome Part -->
			<section id="reach-to" class="welcome-part home-icon">
				<div class="icon-default">
					<a href="#reach-to" class="scroll"><img src="/images/scroll-arrow.png" alt=""></a>
				</div>
				<div class="container">
					<div class="build-title">
						<h2>Welcome To Cakencookie</h2>
						<h6><?php echo $subtitle; ?></h6> 
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<?php echo $about_us; ?>
						
							<p><a href="about.php" class="btn-black">LEARN MORE</a></p>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
							<img src="/images/home1-about.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="float-main">
					<div class="icon-top-left">
						<img src="/images/icon1.png" alt="">
					</div>
					<div class="icon-bottom-left">
						<img src="/images/icon7.png" alt="">
					</div>
					<div class="icon-top-right">
						<img src="/images/icon8.png" alt="">
					</div>
					<div class="icon-bottom-right">
						<img src="/images/icon9.png" alt="">
					</div>
				</div>
			</section>
			<!-- End Welcome Part -->
			<!-- Start Dishes Part -->
			<section class="dishes banner-bg invert invert-black home-icon wow fadeInDown" style="background-color:#3b2413" data-wow-duration="1000ms" data-wow-delay="300ms">
				<div class="icon-default icon-black">
					<img src="/images/icon5.png" alt="">
				</div>
				<div class="container">
					<div class="build-title">
						<h2>We are best for</h2>
						<h6><?php echo $why_we_best; ?></h6>
					</div>
					<div class="slider multiple-items">					
					<?php						
						$product_info =  $dbClass->getResultList("select p.product_id,p.name,p.code, round(pr.rate,1) rate, p.category_id, c.name category_name, s.name size_name, feature_image
																	from products p 
																	left join product_rate pr on pr.product_id=p.product_id
																	left join category c on c.id=p.category_id
																	left join size s on s.id=pr.size_id
																	where p.availability=1 and  p.feature_image is not null and  p.feature_image!=''
																	group by p.product_id
																	limit 1, 6");																				
						foreach ($product_info as $row){
							extract($row);
					?>
						<div class="product-blog">
							<img src="/admin/images/product/<?php echo $feature_image; ?>"  alt="" class="circle-round-color ">
							<h6><?php echo $name .'('.$size_name.')'; ?></h6>
							<!--<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames</p> -->
							<!--<del>$ 55.00</del>--><strong class="txt-default"><?php echo number_format($rate,2); ?></strong>
						</div>
					<?php 
						}
					?>
					</div>
				</div>
			</section>
			<!-- End Dishes Part -->
			<!-- Start Menu Part -->
			<section class="special-menu bg-skeen home-icon wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
				<div class="icon-default icon-skeen">
					<img src="/images/icon6.png" alt="">
				</div>
				<div class="container">
					<div class="build-title">
						<h2>Our Special Menu</h2>
						<h6><?php echo $special_menu; ?></h6> 
					</div>
					<div class="menu-wrapper">
						<div class="portfolioFilter">
							<div class="portfolioFilter-inner">
								<a href="javascript:;" data-filter="*" class="current">All</a>
								
								<?php
								$category_info = $dbClass->getResultList("select * from category where status=1 and id in(10,11,14,17,18) order by id desc");										
									foreach ($category_info as $row){
										extract($row);						
										echo "<a style='text-transform:uppercase' href='javascript:;' data-filter='.$name'>$name</a>";	
									}
								?>
							</div>
						</div>
						<div class="portfolioContainer row">
								<?php
									$cate_array = array(10,11,14,17,18);
									foreach($cate_array as $key=>$category_id)
									{
										/*$hot_item = $dbClass->getResultList("
										select distinct(od.product_id) , p.product_id, p.name, p.code, p.details, c.id category_id, p.availability,
										GROUP_CONCAT(r.size_id,'*',s.name,'*',r.discounted_rate) p_rate, tags 
										from 
										order_details od
										LEFT JOIN products p on od.product_id=p.product_id
										LEFT JOIN product_rate r on r.product_id = p.product_id
										LEFT JOIN category c on c.id = p.category_id
										LEFT JOIN size s on s.id = r.size_id
										where category_id=17 
										order by p.product_id limit 0,2	");	*/
										$hot_items = $dbClass->getResultList("
										SELECT distinct(p.product_id) as  product_id , p.name, p.code, p.details, 
										c.id category_id, p.availability, c.name as cat_name, pim.product_image,
											r.discounted_rate as p_rate, tags 
											FROM products p 
											LEFT JOIN product_rate r on r.product_id = p.product_id
											LEFT JOIN category c on c.id = p.category_id
											LEFT JOIN product_image pim on pim.product_id=p.product_id 
											where category_id=$category_id ORDER BY RAND() 	limit 0,2");							
										foreach ($hot_items as $item){
											extract($item);						
											echo "
												<div class='col-md-6 col-sm-6 col-xs-12 isotope-item $cat_name'>
													<div class='menu-list'>
														<span class='menu-list-product'>
															<img class='top_sell_prd' src='admin/images/product/thumb/$product_image' alt=''>
														</span>
														<h5>$name <span>".number_format($p_rate,2)."</span></h5>
														<p>$details</p>
													</div>
												</div>";	
										}
									}
								?>
					
						</div>
						<div class="btn-outer">
							<a href="shop.php" class="btn-main btn-shadow">Explore Full Menu</a>
						</div>
					</div>
				</div>
				<div class="float-main">
					<div class="icon-top-left">
						<img src="/images/icon15.png" alt="">
					</div>
					<div class="icon-bottom-left">
						<img src="/images/icon24.png" alt="">
					</div>
					<div class="icon-top-right">
						<img src="/images/icon26.png" alt="">
					</div>
					<div class="icon-bottom-right">
						<img src="/images/icon27.png" alt="">
					</div>
				</div>
			</section>
			<!-- End Menu Part -->              

			<!-- Start Feature list -->
			 <section class="food-hours home-icon wow fadeInDown" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" data-wow-duration="1000ms" data-wow-delay="300ms">
				<div class="icon-default icon-gold">
					<img src="/images/icon19.png" alt="">
				</div>
				<div class="container">
					<div class="build-title">
						<h2>Speciality</h2>
						<h6><?php echo $feature; ?></h6>
					</div>
					<div class="row center">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="feature-list-icon">
								<div class="feature-icon-table">
									<img src="/images/img17.png" alt="">
								</div>
							</div>
							<h5><?php echo $dbClass->getTitle(51); ?></h5>
							<p><?php echo $dbClass->getDescription(51); ?></p>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="feature-list-icon">
								<div class="feature-icon-table">
									<img src="/images/img18.png" alt="">
								</div>
							</div>
							<h5><?php echo $dbClass->getTitle(52); ?></h5>
							<p><?php echo $dbClass->getDescription(52); ?></p>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="feature-list-icon">
								<div class="feature-icon-table">
									<img src="/images/img19.png" alt="">
								</div>
							</div>
							<h5><?php echo $dbClass->getTitle(53); ?></h5>
							<p><?php echo $dbClass->getDescription(53); ?></p>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="feature-list-icon">
								<div class="feature-icon-table">
									<img src="/images/img20.png" alt="">
								</div>
							</div>
							<h5><?php echo $dbClass->getTitle(54); ?></h5>
							<p><?php echo $dbClass->getDescription(54); ?></p>
						</div>
					</div>
				</div>
			</section>
			<!-- End Feature list -->
			<!-- Start Instagram -->
			<section class="instagram-main home-icon wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
				<div class="container">
					<div class="build-title">
						<h2>#Cakencookie</h2>
						<h6>Enjoyed your food at Cakencookie? Share your moments with us.</h6>
					</div>
				</div>
				<div class="gallery-slider">
					<div class="owl-carousel owl-theme" data-items="6" data-laptop="5" data-tablet="4" data-mobile="1" data-nav="true" data-dots="false" data-autoplay="true" data-speed="2000" data-autotime="3000">
						<?php								
							$img_info =  $dbClass->getResultList("select id, img.title, img.attachment from gallary_images img order by id desc limit 1, 10");																				
							foreach ($img_info as $row){
								extract($row);
						?>
						<div class="item">
							<a href="admin/document/gallary_attachment/<?php echo $attachment; ?>" class="magnific-popup">
								<img src="admin/document/gallary_attachment/thumb/<?php echo $attachment; ?>" alt="" class="animated">
								<div class="gallery-overlay">
									<div class="gallery-overlay-inner">
										<i class="fa fa-instagram" aria-hidden="true"></i>
									</div>
								</div>
							</a>
						</div>					
						<?php
							}
						?>
					</div>
				</div>
			</section>
			<!-- End Instagram -->
		</div>
	</main>
	<!-- End Main -->
		
<?php 
include('includes/footer.php');
?>