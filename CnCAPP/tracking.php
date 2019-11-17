<?php 
$order_id = "";
if(isset($_GET['order_id']) && $_GET['order_id']!="") $order_id =  $_GET['order_id'];
?>

<h6 class="center">Track your order by Order Tracking Number</h6>
<hr>
<div class="form-group">
	<div class="col-md-8">
		<input type="text"  class="form-control col-lg-12" id="order_tracking_number" placeholder="Order Tracking Number" value="<?php echo $order_id; ?>">
	</div>
	<div class="col-md-4">
		 <button type="submit" class="btn-black view" id="track_btn">Track Your Order</button>
	</div>
</div>
<section class="home-icon shop-cart bg-skeen">
	<div class="container" style="max-width:100%">
		<div class="checkout-wrap checkout-wrap-more wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
			<ul class="checkout-bar" id="order_status_li">
			</ul>
		</div>
		<div class="track-oder wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
			<div class="track-oder-inner">
				<div class="clock-track-icon">
					<img src="/images/clock-icon.png" alt="">
				</div>
				<div class="track-status">
					<h3><b id="order_status_message"></b></h3>
				</div>
			</div>
		</div>
	</div>
</section>


<script>
	$('#track_btn').trigger('click');
</script>