<?php include('includes/header.php');
if(!isset($_SESSION['customer_id']) && $_SESSION['customer_id']!="" && $_GET['order_id']!=""){ ob_start(); header("Location:error.php"); exit();}
//var_dump($customer_info);
?>                    
 <!-- Start Main -->
<main>
	<div class="main-part">
		<!--
		<section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/breadbg1.jpg');">
			<div class="container">
				<div class="breadcrumb-inner">
					<h2>ORDER COMPLETE</h2>
					<a href="index.php">Home</a>
					<span>Shop</span>
				</div>
			</div>
		</section>
		 -->
		<section class="home-icon shop-cart bg-skeen wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
			<div class="icon-default icon-skeen">
				<img src="/images/scroll-arrow.png" alt="">
			</div>
			<div class="container">
				<div class="checkout-wrap">
					<ul class="checkout-bar">
						<li class="done-proceed">Shopping Cart</li>
						<li class="done-proceed">Checkout</li>
						<li class="active done-proceed">Order Complete</li>
					</ul>
				</div>
				<?php 
				if(isset($_GET['complete']) && $_GET['complete']=='success'){
				?>
					<div class="order-complete-box">
						<img src="/images/complete-sign.png" alt="">
						<p>Thank you for ordering our food. You will receive a confirmation email shortly. your order referenced id #<b><?php echo $_GET['order_id']; ?></b>
						<br> Now check a Food Tracker progress with your order.</p>
						<a href="account.php?order_id=<?php echo $_GET['order_id']; ?>" class="btn-medium btn-primary-gold btn-large">Go To Food Tracker</a>
						<br /><br />
						<button type="button" class="btn btn-warning"  onclick="view_order('<?php echo $_GET['order_id']; ?>')" id=""><i class="fa fa-lg fa-print"> &nbsp; Print order #<?php echo $_GET['order_id']; ?></i></button>
						
					</div>
				<?php
				}
				else{
					?>
					<div class="order-complete-box">
						<h2 class="danger">!!!SORRY. Your order is not placed. Please contact with our support team</h2>
					</div>
					<?php
				}
				?>
			</div>
		</section>
	</div>
</main>
<?php include('includes/footer.php'); ?>  
		
