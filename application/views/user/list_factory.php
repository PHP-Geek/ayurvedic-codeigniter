<div class="content-wrapper">
    <section class="content-header">
        <h1>Factory <small>Factory Listing</small> <a class="btn btn-primary" href="<?php echo base_url(); ?>factory">Add Factory</a></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Factory</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <table id="inventory_datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Factory Id</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
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
                "url": base_url + "user/factory_datatable",
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
                },
                {
                    "targets": 5,
                    "sortable": false,
                    "searchable": false,
                    "render": function (data, type, full, meta) {
                        switch (data) {
                            case "1":
                                return '<div class="text-center"><input onchange="user_status(' + full[0] + ')" id="user_id_' + data[0] + '" type="checkbox" checked="checked" /></div>';
                                break;
                            default:
                                return '<div class="text-center"><input onchange="user_status(' + full[0] + ')" id="user_id_' + data[0] + '" type="checkbox" /></div>';
                                break;
                        }
                    }
                },
                {
                    "targets": 6,
                    "sortable": false,
                    "searchable": false,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return '<a href="<?php echo base_url(); ?>factory/' + data[0] + '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a href="javascript:;" onclick="confirm_delete(' + data[0] + ');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>';
                    }
                }]
        });
    });
    function user_status(user_id) {
        $.post(base_url + "user/change_status", {user_id: user_id, user_status: $("#user_id_" + user_id).is(":checked")}, function (data) {
            if (data === "1") {
                bootbox.alert("User Status Changed Successfully");
            } else if (data === "0") {
                bootbox.alert("Error Updating User Status !!!");
            } else {
                bootbox.alert(data);
            }
        });
    }
    function confirm_delete(product_id) {
        bootbox.confirm("Are you sure you want to proceed ?", function (result) {
            if (result) {
                $.post(base_url + "products/delete", {product_id: product_id}, function (data) {
                    if (data === "1") {
                        document.location.href = "";
                    } else {
                        bootbox.alert(data);
                    }
                });
            }
        });
    }

</script>