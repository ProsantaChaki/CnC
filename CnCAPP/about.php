<?php include('includes/header.php'); ?>                    
<!-- Start Main -->
        <main>
            <div class="main-part">
                <!-- 
                <section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg2.jpg');">
                    <div class="container">
                        <div class="breadcrumb-inner">
                            <h2>About Cakencookie</h2>
                            <a href="index.php">Home</a>
                            <span>About Us</span>
                        </div>
                    </div>
                </section>
                 -->
                <!-- Start term condition -->
                <section class="term-condition home-icon">
                    <div class="icon-default">
                        <a href="#"><img src="images/scroll-arrow.png" alt=""></a>
                    </div>
                    <div class="container">
					    <?php
							$li_str  = "";
							$div_str = "";
							$i 		 = 0;
							
							$about_us_result = $dbClass->getResultList("select * from web_menu where parent_menu_id=28");
							foreach ($about_us_result as $row){
								extract($row);								
								if($i == 0) $class = "class='active'";
								else 		    $class = "";
								
								$li_str  .= "<li $class><a href='#$menu'>$title</a></li>";	
								$div_str .= "<div class='terms-left margin-top-20' id='$menu'>							
											   <h5>$title</h5>
												$description
											</div>";	
								$i++;								
							}
						?>							
                        <div class="col-md-9 col-sm-8 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<?php echo $div_str; ?>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="terms-right">
                                <ul>
                                    <?php echo $li_str; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- end term condition -->
				<section class="chef-part home-icon home-small-pad wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="container">
                        <div class="build-title">
                            <h2>Our outlets </h2>
                            <h6>Take a look at out branches</h6>
                        </div>
						
						<div class="service-track">
                            <div class="row">
								<?php
							
									$outlet_result = $dbClass->getResultList("select * from outlets where status=1");
									foreach ($outlet_result as $row){
										extract($row);								
										?>
										<div class="col-md-3 col-sm-6 col-xs-12">
											<div class="service-track-inner btn-shadow">
												<div class="service-track-info">
													<img src="admin/<?php echo $image; ?>" alt="">
												</div>
												<div class="service-track-overlay banner-bg" data-background="images/hover-img1.png">      
													<h5><?php echo $outlet_name; ?></h5>
													<span><?php echo $address; ?></span>
												</div>
											</div>
										</div> 
										<?php
									}
								?>
						
							
							 
                            </div>
                        </div>	
					</div>
				</section>
				<section class="chef-part home-icon home-small-pad wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="icon-default">
                        <img src="images/icon11.png" alt="">
                    </div>
                    <div class="container">
                        <div class="build-title">
                            <h2>Our Awesome Team</h2>
                            <h6>Meet Professional Cook Team</h6>
                        </div>
						<div class="service-port odd wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
										<img src="images/team1.jpg" alt="" class="round-color border-1px">
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
										<img src="images/team2.jpg" alt="" class="round-color border-1px">
								</div>
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
