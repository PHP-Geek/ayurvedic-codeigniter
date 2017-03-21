<style>
    .select2-selection.select2-selection--single,.select2-container--default {    	
        min-height:34px !important;
    }
    .select2-container.select2-allowclear {
        width:130px;		
    }
    .select2-container {
        width:100% !important;
    }
    .select2-selection.select2-selection--single,.select2-container--default {    	
        padding-left:0px !important;
    }
    .help-block{
        color:#dd4b39;
    }
    .cross_div {
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Product <small>Product</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Product</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Product</h3>
                    </div>
                    <form id="edit_products_form" role="form" method="post" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="categoryname">Categories Name</label> 
                                <select class="form-control" name="category_id"  data-placeholder="Select category">
                                    <option></option>
                                    <?php
                                    foreach ($category_details_array as $category) {
                                        ?>
                                        <option value="<?php echo $category['category_id']; ?>"<?php echo (isset($product_details_array['categories_id']) && $category['category_id'] == $product_details_array['categories_id']) ? ' selected="selected"' : ''; ?>><?php echo $category['category_name'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>							
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input name="product_name" type="text" class="form-control" id="product_name" placeholder="Enter Product Name" value="<?php echo isset($product_details_array['product_name']) ? $product_details_array['product_name'] : ""; ?>">
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea name="product_description" class="form-control" id="product_description" placeholder="Enter Product Description"><?php echo isset($product_details_array['product_description']) ? $product_details_array['product_description'] : ""; ?></textarea>                                
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Display</label><br>
                                <input type="checkbox" name="product_is_display"  id="product_is_display" value="1" <?php echo (isset($product_details_array['product_is_display']) && $product_details_array['product_is_display'] == '1') ? 'checked' : ''; ?> > ( select if you want display product on front end )   
                            </div>	
                            <hr/>
                            <h3>Product Sale Price</h3>
                            <?php
                            if (isset($product_quantities_details_array) && count($product_quantities_details_array) > 0) {
                                foreach ($product_quantities_details_array as $key => $product_quantity_details) {
                                    ?>
                                    <div class="clone_component">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="product_quantity_volume">Volume</label><br>
                                                    <input type="text" name="product_quantity_volume[]" class="form-control" placeholder="Volume" value="<?php echo $product_quantity_details['product_quantity_volume']; ?>">     
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="unit_id">Unit</label><br>
                                                    <select name="unit_id[]" data-placeholder="Unit">
                                                        <option></option>
                                                        <?php foreach ($units_array as $unit) { ?>
                                                            <option value="<?php echo $unit['unit_id']; ?>" <?php echo ($unit['unit_id'] == $product_quantity_details['units_id']) ? 'selected="selected"' : ''; ?>><?php echo $unit['unit_title']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="product_quantity_price">Price (in rupees)</label><br>
                                                    <input type="text" class="form-control" name="product_quantity_price[]" placeholder="Price" value="<?php echo $product_quantity_details['product_quantity_price']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-right">
                                                    <?php if ($key == count($product_quantities_details_array) - 1) { ?>
                                                        <a class="clone_component_button" href="javascript:;" onclick="clone_component(this);"><i class="fa fa-plus-circle"></i> Add more quantites</a>
                                                    <?php } else { ?>
                                                        <a class="clone_component_button" href="javascript:;" onclick="clone_component(this);" style="display: none"><i class="fa fa-plus-circle"></i> Add more quantities</a>
                                                    <?php } ?>
                                                    <?php if (count($product_quantities_details_array) === 1) { ?>
                                                        <a class="remove_component_button" href="javascript:;" onclick="remove_component(this);" style="display:none"><i class="fa fa-minus-circle"></i> Remove</a>
                                                    <?php } else { ?>
                                                        <a class="remove_component_button" href="javascript:;" onclick="remove_component(this);"><i class="fa fa-minus-circle"></i> Remove</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="clone_component">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="product_quantity_volume">Volume</label><br>
                                                <input type="text" class="form-control" name="product_quantity_volume[]" placeholder="Volume" value="">     
                                            </div>
                                            <div class="col-md-3">
                                                <label for="unit_id">Unit</label><br>
                                                <select name="unit_id[]" data-placeholder="Unit">
                                                    <option></option>
                                                    <?php foreach ($units_array as $unit) { ?>
                                                        <option value="<?php echo $unit['unit_id']; ?>"><?php echo $unit['unit_title']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="product_quantity_price">Price (in rupees)</label><br>
                                                <input type="text" class="form-control" name="product_quantity_price[]" placeholder="Price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-right">
                                                <a href="javascript:;" class="clone_component_button" onclick="clone_component(this);"><i class="fa fa-plus-circle"></i> Add more quantities</a>
                                                <a class="remove_component_button" href="javascript:;" onclick="remove_component(this);" style="display:none"><i class="fa fa-minus-circle"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <hr/>
                            <div class="form-group">
                                <label for="product_image">Product Image</label> (max 2 images)
                                <div id="product_image_container" class="text-center">
                                    <a href="javascript:;" class="text-primary" title="upload file" id="product_image"<?php echo (!isset($product_details_array['product_image_2']) || $product_details_array['product_image_2'] == "") ? "" : " style='display:none;'"; ?>><i class='fa fa-upload'></i> Upload Product image</a>
                                </div>
                                <div class="product_image_preview">
                                    <?php if (isset($product_details_array['product_image_1']) && is_file(FCPATH . 'uploads/products' . date('/Y/m/d/H/i/s/', strtotime($product_details_array['product_created'])) . $product_details_array['product_image_1'])) { ?>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a title="remove image" class="pull-right remove_image_button" onclick="remove_file(); $(this).parent().remove();" style="cursor:pointer">
                                                    <i class="fa fa-2x fa-times-circle"></i>
                                                </a>
                                                <input type="hidden" name="product_images[]" value="<?php echo $product_details_array['product_image_1']; ?>">
                                                <img alt="" class="img img-responsive center-block" src="<?php echo base_url() . 'uploads/products' . date('/Y/m/d/H/i/s/', strtotime($product_details_array['product_created'])) . $product_details_array['product_image_1'] ?>" />
                                            </div>
                                        </div>       
                                        <?php
                                    }
                                    if (isset($product_details_array['product_image_2']) && is_file(FCPATH . 'uploads/products' . date('/Y/m/d/H/i/s/', strtotime($product_details_array['product_created'])) . $product_details_array['product_image_2'])) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <a title="remove image" class="pull-right remove_image_button" onclick="remove_file(this, 2);" style="cursor:pointer">
                                                    <i class="fa fa-2x fa-times-circle"></i>
                                                </a>
                                                <input type="hidden" name="product_images[]" value="<?php echo $product_details_array['product_image_2']; ?>">
                                                <img alt="" class="img img-responsive center-block" src="<?php echo base_url() . 'uploads/products' . date('/Y/m/d/H/i/s/', strtotime($product_details_array['product_created'])) . $product_details_array['product_image_2'] ?>" />
                                            </div>
                                        </div>       
                                    <?php } ?>
                                </div>
                            </div>                                
                        </div>
                        <div class="box-footer text-right">
                            <a href="<?php echo base_url(); ?>configuration/list_product" class="btn btn-default">Cancel</a>
                            <button id="edit_products_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Save Product <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/plupload/js/plupload.full.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
                                                $('select').select2();
                                                $("#edit_products_button").click(function () {
                                                    $("#edit_products_form").validate({
                                                        errorElement: "span", errorClass: "help-block",
                                                        ignore: false,
                                                        rules: {
                                                            category_id: {
                                                                required: true
                                                            },
                                                            product_name: {
                                                                required: true
                                                            },
                                                            product_description: {
                                                                required: true
                                                            },
                                                            product_image: {
                                                                required: true
                                                            },
                                                            product_sale_price: {
                                                                required: true
                                                            },
                                                        },
                                                        messages: {
                                                            category_id: {
                                                                required: "Category name is required."
                                                            },
                                                            product_name: {
                                                                required: "The Product Name field is required."
                                                            },
                                                            product_description: {
                                                                required: "The Product Description field is required."
                                                            },
                                                            product_image: {
                                                                required: "The Product Image field is required."
                                                            },
                                                            product_sale_price: {
                                                                required: "The Product Sale Price field is required."
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
                                                            $("#edit_products_button").button("loading");
                                                            $.post("", $("#edit_products_form").serialize(), function (data) {
                                                                if (data === "1") {
                                                                    bootbox.alert("Product saved Successfully !!!", function (result) {
                                                                        document.location.href = base_url + "configuration/list_product";
                                                                    });
                                                                } else if (data === "0") {
                                                                    bootbox.alert("Error Saving Data !!!");
                                                                } else {
                                                                    bootbox.alert(data);
                                                                }
                                                                $("#edit_products_button").button("reset");
                                                            });
                                                        }
                                                    });
                                                });

                                                var photo_uploader = new plupload.Uploader({
                                                    runtimes: 'html5,flash,html4',
                                                    browse_button: "product_image",
                                                    container: "product_image_container",
                                                    url: base_url + 'configuration/upload_files',
                                                    chunk_size: '1mb',
                                                    unique_names: true,
                                                    multi_selection: true,
                                                    max_file_count: 2,
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
                                                                up.settings.max_file_count = up.settings.max_file_count - files.length;
                                                                $('#product_image_container').block({
                                                                    message: '<img src="' + base_url + 'assets/img/loading.gif" />'});
                                                            }, 1);
                                                            if (up.settings.max_file_count == 1) {
                                                                $('#product_image').hide();
                                                            }
                                                        },
                                                        FilesRemoved: function (up, files) {
                                                            if (up.files.length <= 2) {
                                                                up.settings.max_file_count++;
                                                                $('#product_image').fadeIn("slow");
                                                            }
                                                        },
                                                        FileUploaded: function (up, file) {
                                                            $('.product_image_preview').append('<div class="row"><div class="col-md-6 col-md-offset-3"><a title="remove image" class="pull-right remove_image_button" onclick="remove_file(); $(this).parent().remove();" style="cursor:pointer"><i class="fa fa-2x fa-times-circle"></i></a><input type="hidden" name="product_images[]" value="' + file.target_name + '"><img alt="" class="img img-responsive center-block" src="' + base_url + 'uploads/' + file.target_name + '" /></div></div>');
                                                        },
                                                        UploadComplete: function () {
                                                            $('#product_image_container').unblock();
                                                        },
                                                        Error: function (up, err) {
                                                            $('#profile_container').unblock();
                                                            bootbox.alert(err.message);
                                                        }
                                                    }
                                                });
                                                photo_uploader.init();
                                                function remove_file(instance, module) {
                                                    if (module != "") {
                                                        $(instance).parent().remove();
                                                        if (photo_uploader.settings.max_file_count == 2) {
                                                            photo_uploader.settings.max_file_count = photo_uploader.settings.max_file_count - 1;
                                                        } else {
                                                            photo_uploader.settings.max_file_count = photo_uploader.settings.max_file_count + 1;
                                                        }
                                                        $('#product_image').fadeIn("slow");
                                                    } else {
                                                        photo_uploader.removeFile(photo_uploader.files[0]);
                                                    }

                                                }

                                                function clone_component(t) {
                                                    var tr = $(t).closest('.clone_component');
                                                    tr.find('select').each(function (i, o) {
                                                        $(o).select2('destroy');
                                                    });
                                                    var clone = tr.clone();
                                                    clone.find('input,select').val('');
                                                    tr.after(clone);
                                                    $('select').select2();
                                                    clone.find('.quarry-div select').empty().append('<option></option>');
                                                    if ($('.clone_component').length !== 1) {
                                                        $('.remove_component_button').show();
                                                    }
                                                    $(t).hide();
                                                }
                                                function remove_component(t) {
                                                    if ($('.clone_component').length !== 1) {
                                                        $(t).closest('.clone_component').remove();
                                                        if ($('.clone_component').length === 1) {
                                                            $('.remove_component_button').hide();
                                                        }
                                                    } else {
                                                        $('.remove_component_button').hide();
                                                    }
                                                    $('.clone_component_button').eq(($('.clone_component').length - 1)).show();
                                                }
</script>
