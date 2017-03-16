<?php

// View : category/edit.php
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Category <small>Edit Category</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Category</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Category</h3>
                    </div>
                    <form id="edit_categories_form" role="form" method="post" action="">
                        <div class="box-body">
							<div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input name="category_name" type="text" class="form-control" id="category_name" placeholder="Enter Category Name" value="<?php echo $category_details_array['category_name']; ?>">
                            </div>
						</div>
                        <div class="box-footer text-right">
							<a href="<?php echo base_url(); ?>configuration/category" class="btn btn-default">Cancel</a>
                            <button id="edit_categories_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Edit Category <i class="fa fa-chevron-right"></i></button>
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
    $("#edit_categories_button").click(function() {
			$("#edit_categories_form").validate({
			errorElement: "span", errorClass: "help-block",
			rules: {
			category_name: {
					required: true
				}
			},
			messages: {
			category_name: {
					required: "The Category Name field is required."
				}
			},
			invalidHandler: function (event, validator) {
				show_categories_error();
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
				$("#edit_categories_button").button("loading");
				$.post("", $("#edit_categories_form").serialize(), function(data) {
					if (data === "1") {
						bootbox.confirm("Category Edited Successfully !!!", function(result) {
							document.location.href = base_url + "configuration";
						});
					} else if(data === "0"){
						bootbox.alert("Error Saving Data !!!");
					} else {
						bootbox.alert(data);
					}
					$("#edit_categories_button").button("reset");
				});
			}
		});

		function show_categories_error() {
			$("form#edit_categories_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error submitting data.</div>');
		}
    });
</script>