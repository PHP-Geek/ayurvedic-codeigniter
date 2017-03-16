<div class="content-wrapper">
    <section class="content-header">
        <h1>Factory <small>Factory</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Factory</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Factory</h3>
                    </div>
                    <form id="save_users_form" role="form" method="post" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="user_name">Name</label>
                                <input name="user_name" type="text" class="form-control" id="user_name" placeholder="Enter Name" value="<?php echo isset($user_details_array['user_name']) ? $user_details_array['user_name'] : ""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_address">Address</label>
                                <input name="user_address" type="text" class="form-control" id="user_address" placeholder="Enter Address" value="<?php echo isset($user_details_array['user_address']) ? $user_details_array['user_address'] : ""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input name="user_email" type="text" class="form-control" id="user_email" placeholder="Enter Email" value="<?php echo isset($user_details_array['user_email']) ? $user_details_array['user_email'] : ""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_contact">Contact</label>
                                <input name="user_contact" type="text" class="form-control" id="user_contact" placeholder="Enter Contact" value="<?php echo isset($user_details_array['user_contact']) ? $user_details_array['user_contact'] : ""; ?>">
                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <a href="<?php echo base_url(); ?>user" class="btn btn-default">Cancel</a>
                            <button id="save_users_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Save <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
<script type="text/javascript">
    $("#save_users_button").click(function () {
        $("#save_users_form").validate({
            errorElement: "span", errorClass: "help-block",
            rules: {
                user_name: {
                    required: true
                },
                user_email: {
                    required: true
                },
                user_contact: {
                    required: true
                },
                user_address: {
                    required: true
                }
            },
            messages: {
                user_name: {
                    required: "The User Name field is required."
                },
                user_email: {
                    required: "The User Email field is required."
                },
                user_contact: {
                    required: "The User Contact field is required."
                },
                user_address: {
                    required: "The User Address field is required."
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
                $("#save_users_button").button("loading");
                $.post("", $("#save_users_form").serialize(), function (data) {
                    if (data === "1") {
                        bootbox.confirm("Factory saved Successfully !!!", function (result) {
                            document.location.href = base_url + "list_factory";
                        });
                    } else if (data === "0") {
                        bootbox.alert("Error Saving Factory !!!");
                    } else {
                        bootbox.alert(data);
                    }
                    $("#save_users_button").button("reset");
                });
            }
        });
    });
</script>