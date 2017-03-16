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
        <h1>Edit Product <small>Edit Product</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Product</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Product</h3>
                    </div>
                    <form id="edit_products_form" role="form" method="post" action="">
                        <div class="box-body">
                        	<div class="form-group">
                                <label for="categoryname">Categories Name</label> 
                                <select class="form-control" name="category_id"  data-placeholder="Select category">
	                                <option></option>
	                                <?php 
	                                	foreach($category_details_array as $category){
	                                		?>
	                                		<option value="<?php echo $category['category_id']; ?>" <?php echo ($category['category_id']==$product_details_array['categories_id'])?'selected="selected"':'';?>><?php echo $category['category_name'] ?></option>
	                                <?php }
	                                ?>
                                </select>
                            </div>							
							<div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input name="product_name" type="text" class="form-control" id="product_name" placeholder="Enter Product Name" value="<?php echo $product_details_array['product_name']; ?>">
                            </div>
							<div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea name="product_description" class="form-control" id="product_description" placeholder="Enter Product Description"><?php echo $product_details_array['product_description']; ?></textarea>                                
                            </div>
                            <div class="form-group">
							    <label for="product_image">Product Display</label><br>
							    <input type="checkbox" name="product_is_display"  id="product_is_display" value="1" <?php echo ($product_details_array['product_is_display']=='1')?'checked':'' ;?> > ( select if you want display product on front end )   
							</div>	
							<div class="form-group">
                                <label for="product_sale_price">Product Sale Price</label>
                                <input name="product_sale_price" type="text" class="form-control" id="product_sale_price" placeholder="Enter Product Sale Price" value="<?php echo $product_details_array['product_sale_price']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Image</label>
                                <input type="hidden" name="product_image_file_name" id="product_image_file_name" value="<?php echo $product_details_array['product_image']; ?>">
                                <div id="product_image_container" class="text-center">
                                	<a href="javascript:;" class="text-primary" title="upload file" id="product_image"><i class='fa fa-upload'></i> Upload Product image</a>
                                </div>
                                <div class="product_image_preview">	                                
                                	<img src="<?php echo base_url();?>uploads/<?php echo $product_details_array['product_image']; ?>" class="img-responsive">
                                </div>                                
                            </div>
						</div>
                        <div class="box-footer text-right">
							<a href="<?php echo base_url(); ?>configuration/product" class="btn btn-default">Cancel</a>
                            <button id="edit_products_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Edit Product <i class="fa fa-chevron-right"></i></button>
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
	$('select').select2({allowClear: true});
    $("#edit_products_button").click(function() {
			$("#edit_products_form").validate({
			errorElement: "span", errorClass: "help-block",
			ignore:false,
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
			invalidHandler: function (event, validator) {
				show_products_error();
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
				$.post("", $("#edit_products_form").serialize(), function(data) {
					if (data === "1") {
						bootbox.confirm("Product Edited Successfully !!!", function(result) {
							document.location.href = base_url + "configuration/product";
						});
					} else if(data === "0"){
						bootbox.alert("Error Saving Data !!!");
					} else {
						bootbox.alert(data);
					}
					$("#edit_products_button").button("reset");
				});
			}
		});

		function show_products_error() {
			$("form#edit_products_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error submitting data.</div>');
		}
    });

    var photo_uploader = new plupload.Uploader({
		runtimes: 'html5,flash,html4',
		browse_button: "product_image",
		container: "product_image_container",
		url: base_url + 'configuration/upload_files',
		chunk_size: '1mb',
		unique_names: true,
		multi_selection: false,		
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
					$('#product_image_container').block({
						message: '<img src="' + base_url + 'assets/img/loading.gif" />'});
				}, 1);
			},
			FileUploaded: function (up, file) {
				$('.product_image_preview').html('<div class="product_image_div center-block"><a class="cross_div pull-right" onclick="remove_file();"><i class="fa fa-times-circle"></i></a><img src = "' + base_url + 'uploads/' + file.target_name + '" class="img-responsive"></div>');
                $('#product_image_file_name').val(file.target_name);
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
    
    function remove_file(){
        $('.product_image_preview').html('');
        $('#product_image_file_name').val('');
    }
</script>