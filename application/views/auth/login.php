<!-- PAGE-CONTENT START -->
<section class="page-content">
    <!-- PAGE-BANNER START -->
    <div class="page-banner-area  margin-bottom-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-banner-menu">
                        <h2 class="page-banner-title">Login</h2>
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PAGE-BANNER END -->
    <!-- LOGIN-AREA START -->
    <div class="lognin-area">
        <div class="container">
            <div class="row">
                <!-- Registered-Customers Start -->
                <div class="col-md-6">
                    <form method="post" id="user_login_form">
                        <div class="registered-customers">
                            <h2 class="login-title">REGISTERED CUSTOMERS</h2>
                            <div class="registered">
                                <p>If you have an account with us, Please log in.</p>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_login" id="user_login" placeholder="Email Address" />
                                </div>
                                <div class="form-group">
                                    <input type="password" name="user_login_password" id="user_login_password" class="form-control" placeholder="Password" />
                                </div>
                                <p><label class="forgot"><a href="#">Forgot your password?</a></label></p>
                                <input type="submit" class="custom-submit-2" id="user_login_button" value="login" />
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Registered-Customers End -->
                <div class="col-md-6">
                    <form action="#">
                        <div class="new-customers">
                            <h2 class="login-title">NEW CUSTOMERS</h2>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="custom-form" placeholder="First Name" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="custom-form" placeholder="Last Name" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" class="custom-form" placeholder="Address" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <select class="custom-select custom-form">
                                        <option>City</option>
                                        <option>Dhaka</option>
                                        <option>New York</option>
                                        <option>London</option>
                                        <option>Melbourne</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select class="custom-select custom-form">
                                        <option>Country</option>
                                        <option>Bangladesh</option>
                                        <option>United States</option>
                                        <option>United Kingdom</option>
                                        <option>Australia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="custom-form" placeholder="Phone Number" />
                                </div>
                                <div class="col-sm-6">
                                    <select class="custom-select custom-form">
                                        <option>Post Code</option>
                                        <option>012345</option>
                                        <option>0123456</option>
                                        <option>01234567</option>
                                        <option>012345678</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input class="custom-form" type="text" placeholder="Email" name="email" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input class="custom-form" type="password" placeholder="Password" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input class="custom-form" type="password" placeholder="Confirm Password" />
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked" name="create-account"/>
                                    Sign up for our newsletter!
                                </label>
                                <label>
                                    <input type="checkbox" name="billing-address"/>
                                    Receive special offers from our partners!
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="submit" class="custom-form custom-submit no-margin" value="register" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="submit" class="custom-form custom-submit no-margin" value="clear" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN-AREA END -->

    <!-- BRAND-LOGO-AREA END -->
</section>
<!-- PAGE-CONTENT END -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>    
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>   
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.3.0/js/md5.min.js"></script>  
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Base64/1.0.0/base64.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom/login.signup.js"></script>