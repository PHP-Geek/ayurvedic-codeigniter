(function () {
    $("#user_login_form").validate({
        errorElement: 'span', errorClass: 'help-block pull-right',
        rules: {
            user_email: {
                required: true,
            },
            user_login_password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            user_email: {
                required: "The Email field is required",
                email: "Email must be valid"
            },
            user_login_password: {
                required: "The Password field is required",
                minlength: "The Password field must be at least {0} characters in length"
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
            $("#user_login_button").button('loading');
            $.post(base_url + 'auth/login', {'user_login': btoa(btoa($.trim($("#user_login").val()))), 'user_login_password': btoa(btoa(md5(md5($.trim($("#user_login_password").val()).toLowerCase()))))}, function (data) {
                if (data == '1') {
                    bootbox.alert("You have been logged in successfuly", function () {
                        document.location.href = base_url + 'dashboard';
                    });
                } else if (data === '0') {
                    bootbox.alert("Error in logging!!!");
                } else {
                    bootbox.alert(data);
                }
                $("#user_login_button").button('reset');
            });
        }
    });
}());