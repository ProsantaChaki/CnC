<?php include('includes/header.php'); 

if(!isset($_SESSION['customer_id']) && $_SESSION['customer_id']!=""){ ob_start(); header("Location:error.php"); exit();}
$customer_info = $dbClass->getSingleRow("select * from customer_infos where customer_id=".$_SESSION['customer_id']);
$customer_id = $_SESSION['customer_id'];

//var_dump($customer_info);

$order_id = '';
if(isset($_GET['order_id']) && $_GET['order_id']!="") $order_id =  $_GET['order_id'];

//var_dump($customer_info);
?>                    
<!-- Start Main -->
        <main>
            <div class="main-part">
                <!-- Start Breadcrumb Part -->
                <section class="breadcrumb-part" data-stellar-offset-parent="true" data-stellar-background-ratio="0.5" style="background-image: url('images/banner8.jpg');">
                    <div class="container">
                        <div class="breadcrumb-inner">
                            <h2><span style='color:#8c5d2d'>Wellcome</span><br> <?php echo $customer_info['full_name']; ?></h2>
                            <a href="index.php">Home</a>
                            <span>My Acount</span>
                        </div>
                    </div>
                </section>
                <!-- End Breadcrumb Part -->
                <!-- Start term condition -->
                <section class="term-condition home-icon">
                    <div class="icon-default">
                        <a href="#"><img src="images/scroll-arrow.png" alt=""></a>
                    </div>
                    <div class="container">
                        <div class="col-md-9 col-sm-8 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
							<div class="team-single-info" style="margin: 10px 0 !important;">
								<div class="row main_content">

								</div>
							</div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="terms-right account-menu">
                                <ul >
                                   <li class='sub-menu  profile active'><a href='javascript:void(0)' onclick="show_my_accounts('profile' ,''); load_customer_profile();	">Profile</a></li>
								   <li class="sub-menu orders"><a  href='javascript:void(0)'  onclick="show_my_accounts('orders', '')">Orders</a></li>
								   <li class="sub-menu tracking"><a href='javascript:void(0)'  onclick="show_my_accounts('tracking', '')">Order Tracking</a></li>
								   <li class="sub-menu logout"><a href='logout.php'>Logout</a></li>
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
	var customer_id = "<?php echo $customer_id; ?>";
	var order_id = "<?php echo $order_id; ?>";
	
	show_my_accounts = function show_my_accounts(page_name, order_id){
		$(".sub-menu").removeClass('active');
		if(page_name == 'tracking'){
			$('.main_content').load(page_name+'.php?order_id='+order_id);
		}
		else{
			$('.main_content').load(page_name+'.php');
		}
		$("."+page_name).addClass('active');	
	};
	
	show_my_accounts('profile',order_id)
	
	$(document).on('click','#track_btn', function(){
		if($.trim($('#order_tracking_number').val()) == ""){
			return false;		
		}
		else{ 
			order_no = $.trim($('#order_tracking_number').val());
			$.ajax({
				url: "includes/controller/productController.php",
				dataType: "json",
				type: "post",
				async:false,
				data: {
					q: "getOrder_status",
					order_tracking_number:order_no
				},
				success: function(data){
					if(!jQuery.isEmptyObject(data.records)){
						$.each(data.records, function(i,datas){ 
							
							var li=""; var message = "";
							if(datas.order_status == 3){
								li = "<li class='done-proceed'>Order Placed</li><li class='done-proceed'>Payment</li><li class='done-proceed'>Order Received</li><li class='done-proceed'>Ready</li><li class='done-proceed'>Delivered</li>";
								message = "You have received your order! Have fun";	
							}
							else if(datas.order_status == 2){
								li = "<li class='done-proceed'>Order Placed</li><li class='done-proceed'>Payment</li><li class='done-proceed'>Order Received</li><li class='done-proceed'>Ready</li><li >Delivered</li>";
								message = "Your order is ready for delevery/pickup";	
							}
							else if(datas.order_status == 1 && datas.payment_status == 1 ){
								li = "<li class='done-proceed'>Order Placed</li><li>Payment</li><li >Order Received</li><li >Ready</li><li >Delivered</li>";
								message = "Your had ordered only but didn't made the payment. So please pay now ";	
							}
							else if(datas.order_status == 1 && datas.payment_status == 2   && datas.order_noticed == 1){
								li = "<li class='done-proceed'>Order Placed</li><li class='done-proceed'>Payment</li><li >Order Received</li><li>Ready</li><li >Delivered</li>";
								message = "Your payment is successfully completed, we have not received that yet though ";	
							}
							else if(datas.order_status == 1 && datas.payment_status == 2   && datas.order_noticed == 2){
								message = "We have received your order, hope will delevery on time";	
								li = "<li class='done-proceed'>Order Placed</li><li class='done-proceed'>Payment</li><li class='done-proceed'>Order Received</li><li>Ready</li><li >Delivered</li>";
							}
							$('#order_status_li').html(li);
							$('#order_status_message').html(message);							
						})
					}
				 }	
			});			
		}	
	})	
	
	if(order_id != ''){
		show_my_accounts('tracking',order_id);
	}
	

	
	
</script>
