<?php
// View : inventory/index.php
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Inventory <small>Inventory Listing</small> <a class="btn btn-primary" href="<?php echo base_url(); ?>inventory/add">Add Inventory</a></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Inventory</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <table id="inventory_datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Inventory Id</th>
                            <th>Product Name</th>
                            <th>Factory</th>
                            <th>Product Quantity</th>
                            <th>Product Price</th>
                            <th>Inventory Created</th>
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
        var table = $("#inventory_datatable").DataTable({
            "order": [[0, "asc"]],
            "stateSave": false,
            "processing": true,
            "serverSide": true,
            "searchDelay": 1000,
            "lengthMenu": [[10, 20, 50, 100, 200, 500, -1], [10, 20, 50, 100, 200, 500, "All"]],
            "ajax": {
                "url": base_url + "inventory/datatable",
                "type": "POST"
            },
            "pagingType": "full_numbers",
            "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": [
                'excel', 'pdf'
            ],
            "columnDefs": [
                {
                    "targets": 0,
                    "sortable": false,
                    "searchable": false,
                    "visible": false
                }]
        });
    });
</script>