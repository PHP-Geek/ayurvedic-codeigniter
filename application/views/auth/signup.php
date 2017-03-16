<body class="register-page">
    <div class="register-box">
        <div class="register-logo">
			<br/>
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url() . 'assets/img/logo.png'; ?>"/></a>
        </div>
        <div class="register-box-body" id="user_register_form_div">
            <p class="register-box-msg"><?php echo $title; ?></p>
            <form id="user_register_form" action="" method="post" role="form">
				<div class="form-group has-feedback">
                    <input name="user_name" type="text" class="form-control" placeholder="Enter Your Name"/>
				</div>
				<div class="form-group has-feedback">
                    <input name="user_email" type="text" class="form-control" placeholder="Enter Your Email"/>
				</div>
                <div class="form-group has-feedback">
					<div class="input-group">
						<input name="user_login_password" id="user_login_password" type="password" class="form-control" placeholder="Enter Your Password"/>
						<span class="input-group-addon"><a id="toggle_password" href="javascript:;">Hide</a></span>
					</div>
				</div>				
                <div class="row">
                    <div class="col-xs-8">
                        <a href="<?php echo base_url(); ?>login">Login</a>
                    </div>
                    <div class="col-xs-4">
                        <button id="user_register_button" type="submit" class="btn btn-primary btn-block btn-flat">Sign Up <i class="fa fa-chevron-right" data-loading-text="Please Wait..."></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
	<script type="text/javascript">
		$("#toggle_password").click(function () {
			if ($("#user_login_password").attr('type') === 'text') {
				$("#user_login_password").attr('type', 'password');
				$(this).html('Show');
			} else {
				$("#user_login_password").attr('type', 'text');
				$(this).html('Hide');
			}
		});
		$("#user_register_form").validate({
			errorElement: 'span', errorClass: 'help-block pull-right',
			rules: {
				user_name: {
					required: true
				},
				user_email: {
					required: true,
					email: true,
					remote: {
						url: base_url + 'auth/validate_email',
						type: 'post'
					}
				},
				user_login_password: {
					required: true,
					minlength: 5
				}
			},
			messages: {
				user_name: {
					required: "The Name field is required"
				},
				user_email: {
					required: "The Email field is required",
					email: "Email must be valid",
					remote: "Email is already in use"
				},
				user_login_password: {
					required: "The Password field is required.",
					minlength: "The Password field must be at least {0} characters in length."
				}
			},
			highlight: function (element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			},
			success: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
				$(element).closest('.form-group').children('span.help-block').remove();
			},
			errorPlacement: function (error, element) {
				error.appendTo(element.closest('.form-group'));
			},
			submitHandler: function (form) {
				$(".alert-danger").remove();
				$("#user_register_button").button('loading');
				$.post(base_url + 'auth/signup', $('#user_register_form').serialize(), function (data) {
					if (data == '1') {
						bootbox.alert("You have been registered successfuly", function () {
							document.location.href = base_url + 'login';
						});
					} else if (data === '0') {
						bootbox.alert("Error in adding user!!!");
					} else {
						bootbox.alert(data);
					}
					$("#user_register_button").button('reset');
				});
			}
		});

	</script>