<div class="col-md-4 col-sm-5 col-xs-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
	<div class="team-single-left">
		<div class="team-single-blog " style="margin: 0px 0 !important;" >
			<img id="customer_img" alt="">
		</div>
	</div>
</div>
<div class="col-md-8 col-sm-7 col-xs-12 wow fadeInDown main_content" data-wow-duration="1000ms" data-wow-delay="300ms">
	<div class="team-single-right">
		<h3 id='customer_name'></h3>
		<h6 >Customer Id # <span id='customer_id' ></span> </h6>
		<h6 >Customer Status : <span id='customer_status' ></span> </h6>
		<p>Contact No: <a href="#" id="contact_no"></a>
		<br> E-mail: <a href="#" id="email"></a></p>
		<p > Address: <span id="address"></span></p>
	</div>
	<br /><br />
	<a href='javascript:void(0)'  onclick="show_my_accounts('update-profile'); set_customer_data();" class="btn-medium btn-skin pull-left">Update your information</a>
</div>

<script>

//-------------------------------------------------------------------------

$(document).ready(function () {	
	load_customer_profile = function load_customer_profile(){
		$('#is_active_home_page_div').hide();
		$.ajax({
			url:"includes/controller/ecommerceController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_customer_details",
				customer_id: customer_id,
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){ 				
						$('#customer_id').html(data.customer_id);
						$('#customer_name').html(data.full_name);
						$('#contact_no').html(data.contact_no);
						$('#email').html(data.email);
						$('#address').html(data.address);
						$('#customer_status').html(data.status_text);
						
						if(data.photo == ""){
							$('#customer_img').attr("src",'admin/images/no_image.png');
						}else{
							$('#customer_img').attr("src","admin/"+data.photo);
						}
						$('#customer_img').attr("width", "70%","height","70%");
					});
					
				}
			}
		});
	}	
	load_customer_profile();	

set_customer_data = function set_customer_data(){
		$('#is_active_home_page_div').hide();
		$.ajax({
			url:"includes/controller/ecommerceController.php",
			dataType: "json",
			type: "post",
			async:false,
			data: {
				q: "get_customer_details",
				customer_id: customer_id,
			},
			success: function(data){
				if(!jQuery.isEmptyObject(data.records)){
					$.each(data.records, function(i,data){ 				
						$('#customer_id').val(data.customer_id);
						$('#customer_name').val(data.full_name);
						$('#contact_no').val(data.contact_no);
						$('#email').val(data.email);
						$('#age').val(data.age);
						$('#address').val(data.address);
						$('#is_active').val(data.status);
						
						if(data.photo == ""){
							$('#customer_img').attr("src",'admin/images/no_image.png');
						}else{
							$('#customer_img').attr("src","admin/"+data.photo);
						}
						$('#customer_img').attr("width", "70%","height","70%");
						
						$(".profile").addClass('active');	
						
						$('#save_customer_info').click(function(event){	
							event.preventDefault();
							var formData = new FormData($('#customer_form')[0]);
							formData.append("q","insert_or_update");
							if($.trim($('#customer_name').val()) == ""){
								success_or_error_msg('#form_submit_error','danger',"Please Insert Name","#customer_name");			
							}
							else if($.trim($('#contact_no').val()) == ""){
								success_or_error_msg('#form_submit_error','danger',"Please Insert Contact No","#contact_no");			
							}
							else if($.trim($('#address').val()) == ""){
								success_or_error_msg('#form_submit_error','danger',"Please Insert Address","#address");			
							}
							else if($.trim($('#passport').val()) == "" && $.trim($('#new_passport').val()) != ""){
								success_or_error_msg('#form_submit_error','danger',"Please Insert old password","#password");			
							}	
							else if($.trim($('#passport').val()) != "" && $.trim($('#new_passport').val()) == ""){
								success_or_error_msg('#form_submit_error','danger',"Please Insert new password","#new_password");			
							}								
							else{
							//	$('#save_customer_info').attr('disabled','disabled');

								
								$.ajax({
									url: 'includes/controller/ecommerceController.php',
									type:'POST',
									data:formData,
									async:false,
									cache:false,
									contentType:false,processData:false,
									success: function(data){
										$('#save_customer_info').removeAttr('disabled','disabled');
										
										if($.isNumeric(data)==true && data==5){
											success_or_error_msg('#form_submit_error',"danger","Please Insert Unique Identy No","#nid_no" );			
										}
										else if($.isNumeric(data)==true && data>0){
											success_or_error_msg('#form_submit_error',"success","Save Successfully");
											show_my_accounts('update-profile'); 
											set_customer_data();
										}
										else{
											if(data == "img_error")
												success_or_error_msg('#form_submit_error',"danger",not_saved_msg_for_img_ln);
											else	
												success_or_error_msg('#form_submit_error',"danger","Not Saved...");												
										}
									 }	
								});
							}	
						})	
					
						//alert('i am here');
						//$( ".datepicker" ).datepicker();
						$( ".datepicker" ).datepicker({
							dateFormat: "yy-mm-dd"
						});
					
					});
				}
			}
		});
	}		
});
</script>
