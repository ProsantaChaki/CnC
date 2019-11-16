<?php 
include('includes/header.php'); 
?>


<!-- Start Main -->
<main>
	<div class="main-part">
		<!-- Start Contact Part -->
		<section class="default-section contact-part home-icon">
			<div class="icon-default">
				<img src="images/scroll-arrow.png" alt="">
			</div>
			<div class="container">
				<div class="title text-center">
					<h2 class="text-coffee">Contact Us</h2>
					<h6 class="heade-xs">We highly appreciate you to contact with us</h6>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
						<h5 class="text-coffee">Leave us a Message</h5>
						<p>Please ask any of your queries, we will response very soon. </p>
						<form class="form" method="post" name="contact-form"  id="contact-form" border='1'>
							<div class="alert-container"></div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label>Name *</label>
									<input name="first_name" id="first_name" type="text" required>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label>Email *</label>
									<input name="email"  id="email" type="email" required>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label>Mobile No *</label>
									<input name="mobile" id="mobile" type="text" required>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label>Subject *</label>
									<input name="subject" id="subject" type="text" required>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label>Your Message *</label>
									<textarea name="message" id="message"  required></textarea>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div id="contact_submit_error" class="text-center" style="display:none"></div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input name="submit" id="contact_submit" value="SEND MESSAGE" class="btn-black pull-right send_message" type="submit">
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
								<h3 class="text-primary co-title">Our Address</h3>
								<?php
							
									$outlet_result = $dbClass->getResultList("select * from outlets where status=1");
									foreach ($outlet_result as $row){
										extract($row);								
										?>
										<address>
											<b><?php echo $outlet_name; ?></b><br>
											<?php echo $address; ?><br>
											<a href="#"><b>Mobile:</b><?php echo $mobile; ?></a><br>						
										</address>					
										<?php
									}
								?>						
					<!--	<h5 class="text-coffee">Opening Hours</h5>
						<ul class="time-list">
							<li><span class="week-name">Monday</span> <span>10-12 PM</span></li>
							<li><span class="week-name">Tuesday</span> <span>10-12 PM</span></li>
							<li><span class="week-name">Wednesday</span> <span>10-12 PM</span></li>0
							<li><span class="week-name">Thursday</span> <span>10-12 PM</span></li>
							<li><span class="week-name">Friday</span> <span>10-12 PM</span></li>
							<li><span class="week-name">Saturday</span> <span>10-12 PM</span></li>
							<li><span class="week-name">Sunday</span> <span>4-12 PM</span></li>
						</ul>-->
					</div>
				</div>
			</div>
		</section>
		<!-- End Contact Part -->
		<section class="contact-map">
			<div class="map-outer">
				<iframe src="https://www.google.com/maps/d/embed?mid=1yLqCYuceQlMCtPjEOOGDa2hnIzubMMnE&hl=en" width="100%" height="480"></iframe>
			</div>
		</section>
	</div>
</main>
<?php include('includes/footer.php'); ?>  
