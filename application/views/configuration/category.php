<div class="content-wrapper">
	<section class="content-header">
		<h1>Categories 
		<button class="btn btn-info" id="add_category" data-toggle="modal" data-target="#add_category_modal">Add category</button> </h1>	
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Category</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body">
				<table id="categories_datatable" class="table table-bordered table-striped">
					<thead>
                        <tr>
							<th>Category Id</th>
							<th>Category Name</th>
							<th>Category Status</th>
							<th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
				</table>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Category</h4>
      </div>
      <div class="modal-body">
       <form id="add_categories_form" role="form" method="post" action="">
            <div class="box-body">							
				<div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input name="category_name" type="text" class="form-control" id="category_name" placeholder="Enter Category Name" value="">
                </div>										
			</div>                       
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="add_categories_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Add Category <i class="fa fa-chevron-right"></i></button>        
      </div>
      </form>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
<script type="text/javascript">
    $(function () {
        var table = $("#categories_datatable").DataTable({
			"order": [[0, "asc"]],
			"stateSave": false,
			"processing": true,
			"serverSide": true,
			"searchDelay": 1000,
			"responsive": true,
			"lengthMenu": [[10, 20, 50, 100, 200, 500, -1], [10, 20, 50, 100, 200, 500, "All"]],
			"deferRender": true,
			"ajax": {
				"url": base_url + "configuration/category_datatable",
				"type": "POST"
			},
			"pagingType": "full_numbers",
			"dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
			"buttons": [
				'excel', 'pdf'
			],
            "columnDefs": [
				{
					"targets": 2,
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						switch (data[2]) {
							case "1":
								return '<div class="text-center"><input onchange="category_status('+data[0]+')" id="category_id_'+data[0]+'" type="checkbox" checked="checked" /></div>';
								break;
							default:
								return '<div class="text-center"><input onchange="category_status('+data[0]+')" id="category_id_'+data[0]+'" type="checkbox" /></div>';
								break;
						}
					}
				},
				{
					"targets": 3,
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						return '<a href="<?php echo base_url(); ?>configuration/edit_category/'+data[0]+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a href="javascript:;" onclick="confirm_delete('+data[0]+');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>';
					}
				}]
		});
		table.columns().eq(0).each(function (colIdx) {
			var that = table.column(colIdx).header();
			if (!$(that).hasClass("sorting_disabled")) {
				var title = $(that).text();
				$(that).html(title + '<br><input type="text" class="form-control input-sm" style="width:100%" placeholder="Search ' + title + '" />');
			}
			$("input", that).on("click", function (e) {
				e.stopPropagation();
			});
			$("input", that).on("keyup change", function () {
				table.column(colIdx).search(this.value).draw();
			});
		});
	});    

	function category_status(category_id){
		$.post(base_url+"configuration/change_category_status",{category_id:category_id,category_status:$("#category_id_"+category_id).is(":checked")}, function(data) {
			if(data === "1"){
				bootbox.alert("Category Status Changed Successfully");
			} else if(data === "0"){
				bootbox.alert("Error Updating Category Status !!!");
			} else {
				bootbox.alert(data);
			}
		});
	}
	function confirm_delete(category_id){
		bootbox.confirm("Are you sure you want to proceed ?",function(result){
			if(result){
				$.post(base_url+ "configuration/delete_category",{category_id:category_id},function(data){
					if(data === "1"){
						document.location.href = "";
					} else {
						bootbox.alert(data);
					}
				});
			}
		});
	}


	$("#add_categories_button").click(function() {
			$("#add_categories_form").validate({
			errorElement: "span", errorClass: "help-block",
			rules: {
			category_name: {
					required: true
				},
			category_slug: {
					required: true
				}			
			},
			messages: {
			category_name: {
					required: "The Category Name field is required."
				},
			category_slug: {
					required: "The Category Slug field is required."
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
				$("#add_categories_button").button("loading");
				$.post(base_url+"configuration/add_category", $("#add_categories_form").serialize(), function(data) {
					if (data === "1") {
						bootbox.confirm("Category Added Successfully !!!", function(result) {
							document.location.href = base_url + "configuration/category";
						});
					} else if(data === "0"){
						bootbox.alert("Error Saving Data !!!");
					} else {
						bootbox.alert(data);
					}
					$("#add_categories_button").button("reset");
				});
			}
		});

		function show_categories_error() {
			$("form#add_categories_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error submitting data.</div>');
		}
    });

</script>