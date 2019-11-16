<?php
session_start();
include '../../includes/static_text.php';
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == "") header($activity_url."../view/login.php");
$user_type = $_SESSION['user_type'];
?>
<div class="x_title">
	<h2>Contacts</h2>
	<div class="pull-right">
    <?php 
	if($user_type ==1){
	?>
		<button class="btn btn-primary" id="external_contact" onclick="load_data('external')">External Contact</button>
    <?php
	}
	?>
		<button class="btn btn-primary" id="internal_contact" style="display:none">Internal Contact</button>
		<button class="btn btn-primary" style="display:none" id="add_more">Add More</button>
	</div>
	<div class="clearfix"></div>
</div>

<div class="x_content">
	<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
		<div class="col-md-4 col-sm-4 col-xs-12 form-group pull-left top_search" id="delete_message"></div>
		<div class="col-md-4 col-sm-4 col-xs-12 form-group pull-center top_search">
			<div class="input-group">
				<input type="text" id="input_txt" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" id="search_button" type="button">Go!</button>
				</span>
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right top_search"></div>
	</div>
	<div class="clearfix"></div>
	<div id="contact_wall">
		
	</div>
</div>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="external_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">External Contact</h4>
        </div>
        <div class="modal-body">
          	<form id="external_contact_form" name="external_contact_form" enctype="multipart/form-data" class="form-horizontal form-label-left">   
				<div class="col-md-12">	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Name</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<input type="text" id="name" name="name" required class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Organization</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<input type="text" id="organization" name="organization" required class="form-control col-lg-12" />
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Designation</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<input type="text" id="designation" name="designation" required class="form-control col-lg-12" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Email</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<input type="email" id="email" name="email" required class="form-control col-lg-12"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Mobile No</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<input type="text" id="phone_no" name="phone_no" required class="form-control col-lg-12"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						 <input type="hidden" id="master_id" name="master_id" />    
						 <button  type="submit" id="save_external_contact" class="btn btn-success">Save</button>                    
						 <button type="button" id="clear_button"  class="btn btn-primary">Clear</button>                         
					</div>
					 <div class="col-md-4 col-sm-4 col-xs-12">
						<div id="form_submit_error" class="text-center" style="display:none"></div>
					 </div>
				</div>
			</form> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<script>

$(function () { 
	var current_page_no=1;
	var user_id = "<?php echo $_SESSION['user_id']; ?>";
	
	$('.collapse-link').click(function () {
		var x_panel = $(this).closest('div.x_panel');
		var button = $(this).find('i');
		var content = x_panel.find('div.x_content');
		content.slideToggle(200);
		(x_panel.hasClass('fixed_height_390') ? x_panel.toggleClass('').toggleClass('fixed_height_390') : '');
		(x_panel.hasClass('fixed_height_320') ? x_panel.toggleClass('').toggleClass('fixed_height_320') : '');
		button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
		setTimeout(function () {
			x_panel.resize();
		}, 50);
	})
	
	
	// save and update for external contacts
	$('#save_external_contact').click(function(event){	
		event.preventDefault();
		var formData = new FormData($('#external_contact_form')[0]);
		formData.append("q","insert_or_update");
		//validation 
		if($.trim($('#name').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',not_input_insert_name_ln,"#name");			
		}
		else if($.trim($('#organization').val()) == ""){
			success_or_error_msg('#form_submit_error','danger',"Please Insert organization Name","#organization"); 
		}
		else{
			$('#save_external_contact').attr('disabled','disabled');
			var url = project_url+"controller/personalController.php";
			$.ajax({
				url: url,
				type:'POST',
				data:formData,
				async:false,
				cache:false,
				contentType:false,processData:false,
				success: function(data){
					$('#save_external_contact').removeAttr('disabled','disabled');
					if($.isNumeric(data)==true && data>0){
						//success_or_error_msg('#form_submit_error',"success",save_success_ln); 
						$('#external_modal').modal('toggle');
						clear_form();
						load_data("external");
					}
					else{	
						success_or_error_msg('#form_submit_error',"danger",not_saved_msg_for_input_ln);												
					}
				 }	
			});
		}	
	})
	
	// clear function to clear all the form value
	clear_form = function clear_form(){			 
		$('#master_id').val('');
		$("#external_contact_form").trigger('reset');
	}
	
	// on select clear button 
	$('#clear_button').click(function(){
		clear_form();
	});
	
	load_data = function load_data(type){
		$('#contact_wall').html("");		
		$.ajax({
			url: project_url+"controller/personalController.php",
			dataType: "json",
			type: "post",
			async:false,
			data:{
				q: "load_contacts",
				contact_type:type
			},
			success: function(data) {
				if(!jQuery.isEmptyObject(data.records)){
					var contact_li = "";
					$.each(data.records, function(i,contact){ 
						//alert(contact.emp_id);
						if(type == "employee"){
							contact_li += '<div class="col-md-4 col-sm-6 col-xs-12 search_div"><div class="well profile_view" style="font-size:12px"><div class="col-sm-12"><h4 class="brief"><i><strong>'+contact.full_name+'</strong></i></h4><div class="left col-xs-9"><h4>'+contact.designation_name+'</h4><p><strong>Department: </strong> '+contact.department_name+'. </p><ul class="list-unstyled"><li><i class="fa fa-mobile"></i> Mobile No: ' +contact.contact_no+' </li><li><i class="fa fa-phone"></i> Office No: ' +contact.office_phone_no+'</li></ul></div><div class="right col-xs-3 text-center"><img src="'+project_url+contact.photo+'" alt="" class="img-circle img-responsive"></div></div></div></div>';	
						}else{
							contact_li += '<div class="col-md-4 col-sm-6 col-xs-12 search_div"><div class="well profile_view" style="font-size:12px"><div class="col-sm-10"><h4 class="brief"><i><strong>'+contact.name+'</strong></i></h4><br/><p><strong>Organization: </strong>'+contact.organization+'</p><p><strong>Designation: </strong> '+contact.designation+'. </p><p><i class="fa fa-envelope"></i><strong> Email: </strong>'+contact.email+'</p><p><i class="fa fa-mobile"></i><strong> Mobile: </strong>'+contact.mobile_no+'</p></div><div class="col-sm-2"><button class="btn btn-primary btn-xs" onclick="edit_external('+contact.id+')" type="button"><i class="fa fa-pencil"></i></button><button class="btn btn-danger btn-xs" onclick="delete_external('+contact.id+')" type="button"><i class="fa fa-trash"></i></button></div></div></div>';	
						}
					});
					$('#contact_wall').html(contact_li);
				}
			}
		});	
	}

	load_data('employee');
});

$('#external_contact').click(function(){
	$('#add_more').show();
	$('#external_contact').hide();
	$('#internal_contact').show();
});

$('#internal_contact').click(function(){
	$('#add_more').hide();
	load_data('employee');
	$('#external_contact').show();
	$('#internal_contact').hide();
});

$('#add_more').click(function(){
	$('#external_modal').modal();
});


//Edit from external contacts
edit_external = function edit_external(id){
	$.ajax({
		url: project_url+"controller/personalController.php",
		dataType: "json",
		type: "post",
		async:false,
		data: {
			q: "get_external_details",
			id: id
		},
		success: function(data){
			if(!jQuery.isEmptyObject(data.records)){
				$.each(data.records, function(i,data){ 
					$('#external_modal').modal();
					clear_form();					
					$('#master_id').val(data.id);
					$('#name').val(data.name);
					$('#organization').val(data.organization);
					$('#designation').val(data.designation);
					$('#phone_no').val(data.mobile_no);	
					$('#email').val(data.email);	
					//change button value 
					$('#save_external_contact').html('Update');					
				});				
			}
		 }	
	});			
}

//Delete from external contacts
delete_external = function delete_external(id){
	if (confirm("Do you want to delete the record? ") == true) {
		$.ajax({
			url: project_url+"controller/personalController.php",
			type:'POST',
			async:false,
			data: "q=delete&id="+id,
			success: function(data){
				if($.trim(data) == 1){
					load_data("external");
				}
				else{
					success_or_error_msg('#delete_message',"danger","Not Deleted...");						
				}
			 }	
		});
	} 	
}



$('#input_txt').keyup(function(){
	var search_string = $(this).val();	
	$(".search_div").css('display','block');		
	$(".search_div:not(:icontains("+search_string+"))").css('display','none');		
});

$.expr[':'].icontains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};

</script>
