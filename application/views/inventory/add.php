<style>
    .select2-selection {
        min-height:34px !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Inventory <small>Create New Inventory</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Add Inventory</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add Inventory</h3>
                    </div>
                    <form id="add_inventory_form" role="form" method="post" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inventory_from_users_id">Factory</label>
                                <select name="inventory_from_users_id" class="form-control" id="inventory_from_users_id" data-placeholder="Select Factory">
                                    <option></option>
                                    <?php foreach ($factory_users_details_array as $factory_user_details) { ?>
                                        <option value="<?php echo $factory_user_details['user_id']; ?>"><?php echo $factory_user_details['user_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control" id="category_id" data-placeholder="Select Category">
                                    <option></option>
                                    <?php foreach ($categories_details_array as $category_details) { ?>
                                        <option value="<?php echo $category_details['category_id']; ?>"><?php echo $category_details['category_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select name="product_id" class="form-control" id="product_id" data-placeholder="Select Product">
                                    <option></option>
                                </select>
                            </div>  
                              <div class="form-group">
                                <label for="inventory_description">Description</label> (optional)
                                <input name="inventory_description" type="text" class="form-control" placeholder="Enter Description">
                            </div>
                            <div class="form-group">
                                <label for="inventory_product_quantity">Product Quantity</label>
                                <input name="inventory_product_quantity" type="number" class="form-control" id="inventory_product_quantity" placeholder="Enter Inventory Product Quantity" value="">
                            </div>
                            <div class="form-group">
                                <label for="inventory_product_price">Product Price</label>
                                <input name="inventory_product_price" type="text" class="form-control" id="inventory_product_price" placeholder="Enter Inventory Product Price" value="">
                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <a href="<?php echo base_url(); ?>inventory" class="btn btn-default">Cancel</a>
                            <button id="add_inventory_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Add Inventory <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script type="text/javascript">
    $('select').select2();
    $("#add_inventory_button").click(function () {
        $("#add_inventory_form").validate({
            errorElement: "span", errorClass: "help-block pull-right",
            rules: {
                inventory_from_users_id: {
                    required: true
                },
                category_id: {
                    required: true
                },
                product_id: {
                    required: true
                },
                inventory_product_quantity: {
                    required: true,
                    number: true
                },
                inventory_product_price: {
                    required: true
                },
            },
            messages: {
                inventory_from_users_id: {
                    required: "Please select Factory"
                },
                category_id: {
                    required: "Please select Category"
                },
                product_id: {
                    required: "Please select Product"
                },
                inventory_product_quantity: {
                    required: "The Product Quantity field is required"
                },
                inventory_product_price: {
                    required: "The Product Price field is required"
                },
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
                $("#add_inventory_button").button("loading");
                $.post("", $("#add_inventory_form").serialize(), function (data) {
                    if (data === "1") {
                        bootbox.confirm("Inventory Added Successfully !!!", function (result) {
                            document.location.href = base_url + "inventory";
                        });
                    } else if (data === "0") {
                        bootbox.alert("Error Saving Data !!!");
                    } else {
                        bootbox.alert(data);
                    }
                    $("#add_inventory_button").button("reset");
                });
            }
        });
    });
    $("#category_id").change(function () {
        $.post(base_url + 'inventory/get_product_by_category_id', {category_id: $(this).val()}, function (data) {
            $('#product_id').empty().append("<option></option>").select2({allowClear: true});
            for (var i = 0; i < data.length; i++) {
                $('#product_id').append('<option value="' + data[i].product_id + '">' + data[i].product_name + '</option>');
            }
        });
    });
</script>