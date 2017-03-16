Dear <b><?php echo $user_name; ?></b>,
<p>
    Congratulations, you are now registered with us.<br/><br/>
	You are just a step behind to get started.<br/>
	Please verify your email by clicking the link below :
</p>
<p style="text-align: center">
	<a style="font-weight: bold" href="<?php echo base_url(); ?>auth/verify/<?php echo $user_id . '/' . $user_security_hash; ?>" style="margin: 0 auto">Verify Email Address</a>
</p>