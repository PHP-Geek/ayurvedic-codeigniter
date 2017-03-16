<style>
	.smallwidth{
		min-width:80px;
	}
	.medwidth {
        min-width: 120px;
    }
    .largewidth {
        min-width: 300px;
    }
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Products <a href="<?php base_url(); ?>add_product" class="btn btn-info" >Add Product</a>
        </h1> 
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Products</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body ">
				<table id="products_datatable" class="table table-bordered table-striped">
					<thead>
                        <tr>
							<th class="smallwidth">Product Id</th>
							<th class="medwidth">Categories Name</th>
							<th class="medwidth">Product Name</th>
							<th class="largewidth">Product Description</th>
							<th class="smallwidth">Product Is Display</th>
							<th class="largewidth">Product Image</th>
							<th class="smallwidth">Product Quantity</th>
							<th class="smallwidth">Product Sale Price</th>
							<th class="smallwidth">Product Status</th>
							<th class="medwidth">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
				</table>
            </div>
        </div>
    </section>
</div>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<script type="text/javascript">
    $(function () {
        var table = $("#products_datatable").DataTable({
			"order": [[0, "asc"]],
			"serverSide": true,
			"scrollX": true,
			"searchDelay": 1000,
			"lengthMenu": [[10, 20, 50, 100, 200, 500, -1], [10, 20, 50, 100, 200, 500, "All"]],
			"ajax": {
				"url": base_url + "configuration/product_datatable",
				"type": "POST"
			},
			"pagingType": "full_numbers",
			"dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
			"buttons": [
				'excel', 'pdf'
			],
            "columnDefs": [
            	{
					"targets": 5,
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						return '<img class="img-responsive" src="'+base_url+'uploads/'+ data[5]+'">';
					}
				},
				{
					"targets": 4,
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						switch (data[4]) {
							case "1":
								return '<div class="text-center"><input onchange="product_display_status('+data[0]+')" id="product_display_id_'+data[0]+'" type="checkbox" checked="checked" /></div>';
								break;
							default:
								return '<div class="text-center"><input onchange="product_display_status('+data[0]+')" id="product_display_id_'+data[0]+'" type="checkbox" /></div>';
								break;
						}
					}
				},
				{
					"targets": 8,
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						switch (data[8]) {
							case "1":
								return '<div class="text-center"><input onchange="product_status('+data[0]+')" id="product_id_'+data[0]+'" type="checkbox" checked="checked" /></div>';
								break;
							default:
								return '<div class="text-center"><input onchange="product_status('+data[0]+')" id="product_id_'+data[0]+'" type="checkbox" /></div>';
								break;
						}
					}
				},
				{
					"targets": 9,
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						return '<a href="<?php echo base_url(); ?>configuration/edit_product/'+data[0]+'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a href="javascript:;" onclick="confirm_delete('+data[0]+');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>';
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

	function product_status(product_id){
		$.post(base_url+"configuration/product_status",{product_id:product_id,product_status:$("#product_id_"+product_id).is(":checked")}, function(data) {
			if(data === "1"){
				bootbox.alert("Products Status Changed Successfully");
			} else if(data === "0"){
				bootbox.alert("Error Updating Products Status !!!");
			} else {
				bootbox.alert(data);
			}
		});
	}

	function product_display_status(product_id){
		$.post(base_url+"configuration/product_display_status",{product_id:product_id,products_display_status:$("#product_display_id_"+product_id).is(":checked")}, function(data) {
			if(data === "1"){
				bootbox.alert("Products Status Changed Successfully");
			} else if(data === "0"){
				bootbox.alert("Error Updating Products Status !!!");
			} else {
				bootbox.alert(data);
			}
		});
	}

	function confirm_delete(product_id){
		bootbox.confirm("Are you sure you want to proceed ?",function(result){
			if(result){
				$.post(base_url+ "configuration/delete_product",{product_id:product_id},function(data){
					if(data === "1"){
						document.location.href = "";
					} else {
						bootbox.alert(data);
					}
				});
			}
		});
	}
</script>