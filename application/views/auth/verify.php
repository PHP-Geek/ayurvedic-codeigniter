<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
			<br/>
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url() . 'assets/img/logo.png'; ?>"/></a>
        </div>
        <div class="login-box-body" id="user_login_form_div">
            <p class="login-box-msg">Account Verification</p>
			<?php if (isset($success_message)) { ?>
				<div class="alert alert-success" role="alert">
					<?php echo $success_message; ?>
				</div>
			<?php } else { ?>
				<div class="alert alert-danger" role="alert">
					Invalid Link
				</div>
			<?php } ?>
        </div>
    </div>