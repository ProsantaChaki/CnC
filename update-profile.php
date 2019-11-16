<h6 class="center">Update your personal informations</h6>
<hr>
<form id="customer_form" name="customer_form" enctype="multipart/form-data" class="form-horizontal form-label-left register-form">   
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-4">Name<span class="required">*</span></label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="text" id="customer_name" name="customer_name" required class="form-control col-lg-12"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-4" for="name">Date Of Birth</label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="text" id="age" name="age" class="form-control col-lg-12 datepicker"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-4">Contact No<span class="required">*</span></label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="text" id="contact_no" name="contact_no" required class="form-control col-lg-12"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-4">Email</label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="email" id="email" name="email" class="form-control col-lg-12"/>
				</div>
			</div>						
			<div class="form-group"> 
				<label class="control-label col-md-4 col-sm-4 col-xs-4" >Address<span class="required">*</span></label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="text" id="address" name="address" required class="form-control col-lg-12" />
				</div>
			</div>	
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-4">Password</label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="password" id="password" name="password" class="form-control col-lg-12"></textarea> 
					<small>First you need to provide your old password</small>
				</div>
				
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-4" >New Password</label>
				<div class="col-md-8 col-sm-8  col-xs-8">
					<input type="password" id="new_password" name="new_password" class="form-control col-lg-12"/>
				</div>
			</div>
			<div class="ln_solid"></div>
		</div>
		<div class="col-md-4">
			<img src="" width="70%" height="70%" class="img-thumbnail" id="customer_img">
			<input type="file" name="customer_image_upload" id="customer_image_upload"> 
		</div>
	</div>
	<div id="form_submit_error" class="text-center" style="display:none"></div>
	<div class="form-group">
		<label class="control-label col-md-4 col-sm-4 col-xs-4"></label>
		<div class="col-md-8 col-sm-8  col-xs-8">
		
			<input type="hidden" id="is_active" name="is_active" />
			<input type="hidden" id="customer_id" name="customer_id" />    
			<button type="submit" id="save_customer_info" class="btn-medium btn-skin pull-left">Update your informations</button>                                           
		</div>
	</div>
</form> 

