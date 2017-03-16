<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/css/Jcrop.min.css" />
<style type="text/css">
	#change_profile_image{
		position: absolute;
		right: 10px;
	}
	.modal-dialog{
		max-width: 330px;
	}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Profile <small>edit profile</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Profile</li>
        </ol>
    </section>
    <section class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile" id="profile_container">
						<a id="change_profile_image" href="javascript:;" class="btn btn-sm btn-default"><i class="fa fa-image"></i> Edit</a>
						<img class="profile-user-img img-responsive img-circle" src="<?php
						if ($_SESSION['user']['user_profile_image'] !== '' && file_exists(FCPATH . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created'])) . $_SESSION['user']['user_profile_image'])) {
							echo base_url() . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created'])) . $_SESSION['user']['user_profile_image'];
						} else {
							echo base_url() . 'assets/img/profile.png';
						}
						?>" alt="User profile picture">
						<h3 class="profile-username text-center"><?php echo $_SESSION['user']['user_name']; ?></h3>
						<p class="text-muted text-center"><?php echo $_SESSION['user']['group_name']; ?></p>
						<p class="text-center">
							<a href="<?php echo base_url(); ?>user/change_password" class="btn bg-green">Change Password</a>
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit User</h3>
                    </div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<form id="edit_user_form" role="form" method="post" action="">
									<div class="form-group">
										<label for="user_login">Username</label>
										<input name="user_login" type="text" class="form-control" placeholder="Enter Username" value="<?php echo $user_details_array['user_login']; ?>">
									</div>
									<div class="form-group">
										<label for="user_name">Name</label>
										<input name="user_name" type="text" class="form-control" placeholder="Enter Name" value="<?php echo $user_details_array['user_name']; ?>">
									</div>
									<div class="form-group">
										<label for="user_email">Email</label>
										<input name="user_email" type="text" class="form-control" placeholder="Enter Email" value="<?php echo $user_details_array['user_email']; ?>">
									</div>
									<div class="form-group">
										<label for="user_contact">Contact</label>
										<input name="user_contact" type="text" class="form-control" placeholder="Enter Contact" value="<?php echo $user_details_array['user_contact']; ?>">
									</div><br>
									<div class="form-group text-right">
										<a href="<?php echo base_url(); ?>dashboard" class="btn btn-default">Cancel</a>
										<button id="edit_user_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Update <i class="fa fa-chevron-right"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
    </section>
</div>
<div id="profile_image_modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<img id="user_profile_image" src="<?php
				if ($_SESSION['user']['user_profile_image'] !== '' && file_exists(FCPATH . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created'])) . $_SESSION['user']['user_profile_image'])) {
					echo base_url() . 'uploads/users/profiles' . date('/Y/m/d/H/i/s/', strtotime($_SESSION['user']['user_created'])) . $_SESSION['user']['user_profile_image'];
				} else {
					echo base_url() . 'assets/img/profile.png';
				}
				?>" />
				<div id="user_profile_image_coords" class="hidden"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="document.location.reload();">Cancel</button>
				<button type="button" class="btn btn-primary" onclick="change_user_profile_image();" >Update</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/2.0.4/js/Jcrop.min.js"></script>
<script>
					$("#edit_user_form").validate({
						errorElement: "span", errorClass: "help-block pull-right",
						rules: {
							user_login: {
								required: true
							},
							user_name: {
								required: true
							},
							user_email: {
								required: true,
								email: true
							},
							user_contact: {
								required: true
							}
						},
						messages: {
							user_login: {
								required: "The User Name field is required."
							},
							user_name: {
								required: "The Name field is required."
							},
							user_email: {
								required: "The Email field is required",
								email: "Email must be valid"
							},
							user_contact: {
								required: "The Contact field is required."
							}
						},
						highlight: function (element) {
							$(element).closest(".form-group").addClass("has-error");
						},
						unhighlight: function (element) {
							$(element).closest(".form-group").removeClass("has-error");
						},
						success: function (element) {
							$(element).closest(".form-group").removeClass("has-error");
							$(element).closest(".form-group").children("span.help-block").remove();
						},
						errorPlacement: function (error, element) {
							error.appendTo(element.closest(".form-group"));
						},
						submitHandler: function (form) {
							$(".alert-danger").remove();
							$("#edit_user_button").button("loading");
							$.post("", $("#edit_user_form").serialize(), function (data) {
								if (data > 0) {
									bootbox.confirm("User Updated Successfully !!!", function (result) {
										document.location.href = base_url + 'dashboard';
									});
								} else if (data == 0) {
									bootbox.alert("Error Saving Data !!!");
								} else {
									bootbox.alert(data);
								}
								$("#edit_user_button").button("reset");
							});
						}
					});
					var photo_uploader = new plupload.Uploader({
						runtimes: 'html5,flash,html4',
						browse_button: "change_profile_image",
						container: "profile_container",
						url: base_url + 'user/upload_files',
						chunk_size: '1mb',
						unique_names: true,
						multi_selection: false,
						resize: {
							width: 300,
							height: 300
						},
						flash_swf_url: base_url + 'assets/js/plugins/plupload/js/Moxie.swf',
						silverlight_xap_url: base_url + 'assets/js/plugins/plupload/js/Moxie.xap',
						filters: {
							max_file_size: '10mb',
							mime_types: [
								{title: "Image files", extensions: "jpg,jpeg,png"}
							]
						},
						init: {
							FilesAdded: function (up, files) {
								setTimeout(function () {
									up.start();
									$('#profile_container').block({
										message: '<img src="' + base_url + 'assets/img/loading.gif" />'});
								}, 1);
							},
							FileUploaded: function (up, file) {
								$("#user_profile_image").attr('src', base_url + 'uploads/' + file.target_name);
								$("#profile_image_modal").modal('show');
								$('#user_profile_image').Jcrop({
									aspectRatio: 1,
									setSelect: [50, 50, 200, 200],
									onSelect: updateCoords,
									onChange: updateCoords
								});
							},
							UploadComplete: function () {
								$('#profile_container').unblock();
							},
							Error: function (up, err) {
								$('#profile_container').unblock();
								bootbox.alert(err.message);
							}
						}
					});
					photo_uploader.init();

					function updateCoords(c) {
						$("#user_profile_image_coords").html('{"x":"' + c.x + '", "y":"' + c.y + '", "w":"' + c.w + '", "h":"' + c.h + '", "file":"' + photo_uploader.files[0].target_name + '"}');
					}

					function change_user_profile_image() {
						$.post('', {'user_profile_image': $("#user_profile_image_coords").html()}, function (data) {
							if (data === '1') {
								bootbox.alert('Profile Image Changed.', function () {
									document.location.href = base_url + 'dashboard';
								});
							} else if (data === '0') {
								bootbox.alert('Error Changing Profile Image !!!');
							} else {
								bootbox.alert(data);
							}
						});
					}
</script>