<?php include('includes/header.php'); ?>                    
<!-- Start Main -->
        <main>
            <div class="main-part">
                <!--
                <section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg1.jpg');">
                    <div class="container">
                        <div class="breadcrumb-inner">
                            <h2>Refund Policy </h2> 
                            <a href="index.php">Home</a>
                            <span>Refund Policy</span>
                        </div>
                    </div>
                </section>
                -->
                <!-- Start term condition -->
                <section class="term-condition home-icon">
                    <div class="icon-default">
                        <a href="#"><img src="/images/scroll-arrow.png" alt=""></a>
                    </div>
                    <div class="container">
					    <?php		
							$about_us_result = $dbClass->getSingleRow("select * from web_menu where id=46");
						?>							
                        <div class="col-md-9 col-sm-8 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<div class='terms-left' id='$menu'>							
							   <h5><?php echo $about_us_result['title']; ?></h5>
								<?php echo $about_us_result['description']; ?>
							</div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="terms-right">
                                <ul>
                                    <li ><a href='terms.php'>Terms & Conditions</a></li>
									<li><a href='privacy.php'>Privacy</a></li>
									<li class="active"><a href='refund.php'>Refund Policy</a></li>									
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <!-- End Main -->
<?php include('includes/footer.php'); ?>  
