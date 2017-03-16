<style>
    .select2-selection {
        min-height:34px !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Inventory <small>Edit Inventory</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Inventory</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Inventory</h3>
                    </div>
                    <form id="edit_inventory_form" role="form" method="post" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inventory_from_users_id">Factory</label>
                                <select name="inventory_from_users_id" class="form-control" id="inventory_from_users_id" data-placeholder="Select Factory">
                                    <option></option>
                                    <?php foreach ($factory_users_details_array as $factory_user_details) { ?>
                                        <option value="<?php echo $factory_user_details['user_id']; ?>"<?php echo $inventory_details_array['inventory_from_users_id'] == $factory_user_details['user_id'] ? " selected='selected'" : ""; ?>><?php echo $factory_user_details['user_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control" id="category_id" data-placeholder="Select Category">
                                    <option></option>
                                    <?php foreach ($categories_details_array as $category_details) { ?>
                                        <option value="<?php echo $category_details['category_id']; ?>"<?php echo $category_details['category_id'] == $inventory_details_array['categories_id'] ? " selected='selected'" : ""; ?>><?php echo $category_details['category_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select name="product_id" class="form-control" id="product_id" data-placeholder="Select Product">
                                    <option></option>
                                    <?php foreach ($products_details_array as $product_details) { ?>
                                        <option value="<?php echo $product_details['product_id']; ?>"<?php echo $product_details['product_id'] == $inventory_details_array['products_id'] ? " selected='selected'" : ""; ?>><?php echo $product_details['product_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>   
                            <div class="form-group">
                                <label for="inventory_product_quantity">Inventory Product Quantity</label>
                                <input name="inventory_product_quantity" type="text" class="form-control" id="inventory_product_quantity" placeholder="Enter Inventory Product Quantity" value="<?php echo $inventory_details_array['inventory_product_quantity']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inventory_product_price">Inventory Product Price</label>
                                <input name="inventory_product_price" type="text" class="form-control" id="inventory_product_price" placeholder="Enter Inventory Product Price" value="<?php echo $inventory_details_array['inventory_product_price']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="inventory_created">Inventory Created</label>
                                <input name="inventory_created" type="text" class="form-control" id="inventory_created" placeholder="Enter Inventory Created" value="<?php echo $inventory_details_array['inventory_created']; ?>">
                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <a href="<?php echo base_url(); ?>inventory" class="btn btn-default">Cancel</a>
                            <button id="edit_inventory_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Edit Inventory <i class="fa fa-chevron-right"></i></button>
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
    $("#edit_inventory_form").validate({
        errorElement: "span", errorClass: "help-block",
        rules: {
            inventory_id: {
                required: true
            },
            products_id: {
                required: true
            },
            inventory_from_users_id: {
                required: true
            },
            inventory_to_users_id: {
                required: true
            },
            inventory_product_quantity: {
                required: true
            },
            inventory_product_price: {
                required: true
            },
            inventory_created: {
                required: true
            },
        },
        messages: {
            inventory_id: {
                required: "The Inventory Id field is required."
            },
            products_id: {
                required: "The Products Id field is required."
            },
            inventory_from_users_id: {
                required: "The Inventory From Users Id field is required."
            },
            inventory_to_users_id: {
                required: "The Inventory To Users Id field is required."
            },
            inventory_product_quantity: {
                required: "The Inventory Product Quantity field is required."
            },
            inventory_product_price: {
                required: "The Inventory Product Price field is required."
            },
            inventory_created: {
                required: "The Inventory Created field is required."
            },
        },
        invalidHandler: function (event, validator) {
            show_inventory_error();
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
            $("#edit_inventory_button").button("loading");
            $.post("", $("#edit_inventory_form").serialize(), function (data) {
                if (data === "1") {
                    bootbox.confirm("Inventory Edited Successfully !!!", function (result) {
                        document.location.href = base_url + "inventory";
                    });
                } else if (data === "0") {
                    bootbox.alert("Error Saving Data !!!");
                } else {
                    bootbox.alert(data);
                }
                $("#edit_inventory_button").button("reset");
            });
        }
    });

</script>