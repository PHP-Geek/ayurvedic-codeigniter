<!DOCTYPE html>
<html>
	<head>
		<title>CI CRUD Generator</title>
		<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/theme-monokai.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/mode-php.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/mode-html.js"></script>
		<style type="text/css" media="screen">
    #ci_controller,
	#ci_model,
	#ci_add_view,
	#ci_edit_view,
	#ci_index_view
	{ 
        height: 300px;
    }
</style>
	</head>
	<body>
		<?php if (isset($tables) && is_array($tables)) { ?>
			<form method="post" action="">
				<table>
					<tr>
						<td>Select Table</td>
						<td>:</td>
						<td>
							<select name="table">
								<?php
								foreach ($tables as $table) {
									echo '<option>' . $table['Tables_in_' . $this->db->database] . '</option>';
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Controller</td>
						<td>:</td>
						<td><input type="text" name="controller" value="" /></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><input type="submit" value="Submit" /></td>
					</tr>
				</table>			
			</form>
		<?php } else { ?>
<div id="ci_controller"><?php echo htmlentities('<?php'); ?>


// Controller : <?php echo $controller; ?>.php

defined('BASEPATH') OR exit('No direct script access allowed');

class <?php echo $controller; ?> extends MY_Controller {

	public $public_methods = array();

	function __construct() {
		parent::__construct();
		$this->load->model('<?php echo $controller; ?>_model');
	}

	function index() {
		parent::allow(array('administrator'));
		$data = array();
		parent::render_view($data);
	}

	function datatable() {
		parent::allow(array('administrator'));
		$this->load->library('Datatables');
		$this->datatables->select('<?php echo implode(', ', array_merge($columns_array, $joined_tables_columns_array)); ?>')->from('<?php echo $table; ?>');
<?php foreach ($joined_tables_array as $key => $joined_table) { ?>
		$this->datatables->join('<?php echo $key; ?>','<?php echo $joined_table; ?>');
<?php } ?>
		$this->datatables->where('<?php echo $table; ?>.<?php echo $controller_lower; ?>_status != -1');
		echo $this->datatables->generate();
	}

	function add() {
		parent::allow(array('administrator'));
		$data = array();
		$this->load->helper('form');
		if ($this->input->post()) {
			$this->load->library('form_validation');
<?php
foreach ($table_structure_array as $column) {
	if ($column['Key'] != 'PRI' &&
			!(
			(strpos($column['Field'], '_slug')) ||
			(strpos($column['Field'], '_status')) ||
			(strpos($column['Field'], '_created')) ||
			(strpos($column['Field'], '_modified'))
			)
	) {
		?>
			$this->form_validation->set_rules('<?php echo $column['Field']; ?>', '<?php echo ucwords(str_replace('_', ' ', $column['Field'])); ?>', 'trim|required');
<?php
	}
}
?>

			$this->form_validation->set_error_delimiters('', '<?php echo htmlentities('<br />') ?>');
			if ($this->form_validation->run()) {
				$time_now = date('Y-m-d H:i:s');
				$<?php echo $controller_lower; ?>_insert_array = array (<?php
foreach ($table_structure_array as $column) {
	if ($column['Key'] != 'PRI' &&
			!(
			(strpos($column['Field'], '_slug')) ||
			(strpos($column['Field'], '_status')) ||
			(strpos($column['Field'], '_created')) ||
			(strpos($column['Field'], '_modified'))
			)
	) { ?>

					'<?php echo $column['Field']; ?>' => $this->input->post('<?php echo $column['Field']; ?>'),<?php
	} else {
		if ((strpos($column['Field'], '_slug')) !== FALSE) {
			?>

					'<?php echo $column['Field']; ?>' => url_title($this->input->post('<?php echo str_replace('_slug', '_name', $column['Field']); ?>'), '-', TRUE),<?php
		}
		if ((strpos($column['Field'], '_status')) !== FALSE) {
			?>

					'<?php echo $column['Field']; ?>' => '1',<?php
		}
		if ((strpos($column['Field'], '_created')) !== FALSE) {
			?>

					'<?php echo $column['Field']; ?>' => $time_now,<?php
		}
	}
}
?>

				);
				if ($this-><?php echo $controller; ?>_model->add($<?php echo $controller_lower; ?>_insert_array)) {
					die('1');
				}
			} else {
				echo validation_errors();
				die;
			}
			die('0');
		}
		parent::render_view($data);
	}

	function edit($<?php echo $columns_array[0]; ?> = 0) {
		parent::allow(array('administrator'));
		if($<?php echo $columns_array[0]; ?> !== 0){
			$data = array();
			$data['<?php echo $controller_lower; ?>_details_array'] = $this-><?php echo $controller; ?>_model->get_<?php echo $controller_lower; ?>_by_id($<?php echo $columns_array[0]; ?>);
			if(count($data['<?php echo $controller_lower; ?>_details_array']) > 0 && $data['<?php echo $controller_lower; ?>_details_array']['<?php echo $controller_lower; ?>_status'] == '1') {
				$this->load->helper('form');
				if ($this->input->post()) {
					$this->load->library('form_validation');
<?php
foreach ($table_structure_array as $column) {
	if ($column['Key'] != 'PRI' &&
			!(
			(strpos($column['Field'], '_slug')) ||
			(strpos($column['Field'], '_status')) ||
			(strpos($column['Field'], '_created')) ||
			(strpos($column['Field'], '_modified'))
			)
	) {
		?>
					$this->form_validation->set_rules('<?php echo $column['Field']; ?>', '<?php echo ucwords(str_replace('_', ' ', $column['Field'])); ?>', 'trim|required');
<?php
	}
}
?>
					
					$this->form_validation->set_error_delimiters('', '<?php echo htmlentities('<br />') ?>');
					if ($this->form_validation->run()) {
						$time_now = date('Y-m-d H:i:s');
						$<?php echo $controller_lower; ?>_edit_array = array (<?php
foreach ($table_structure_array as $column) {
	if ($column['Key'] != 'PRI' &&
			!(
			(strpos($column['Field'], '_slug')) ||
			(strpos($column['Field'], '_status')) ||
			(strpos($column['Field'], '_created')) ||
			(strpos($column['Field'], '_modified'))
			)
	) { ?>

							'<?php echo $column['Field']; ?>' => $this->input->post('<?php echo $column['Field']; ?>'),<?php
	} else {
		if ((strpos($column['Field'], '_slug')) !== FALSE) {
			?>

							'<?php echo $column['Field']; ?>' => url_title($this->input->post('<?php echo str_replace('_slug', '_name', $column['Field']); ?>'), '-', TRUE),<?php
		}
		if ((strpos($column['Field'], '_status')) !== FALSE) {
			?>

							'<?php echo $column['Field']; ?>' => '1',<?php
		}
		if ((strpos($column['Field'], '_modified')) !== FALSE) {
			?>

							'<?php echo $column['Field']; ?>' => $time_now,<?php
		}
	}
}
?>

						);
						if ($this-><?php echo $controller; ?>_model->edit($<?php echo $columns_array[0]; ?>,$<?php echo $controller_lower; ?>_edit_array)) {
							die('1');
						}
					} else {
						echo validation_errors();
						die;
					}
					die('0');
				}
				parent::render_view($data);
				return;
			}
		}
		redirect('<?php echo $controller_lower; ?>','refresh');
	}
	
	function change_status() {
        parent::allow(array('administrator'));
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('<?php echo $columns_array[0]; ?>', '<?php echo ucwords(str_replace('_', ' ', $columns_array[0])); ?>', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('<?php echo $controller_lower; ?>_status', '<?php echo $controller_word; ?> Status', 'trim|required');
            $this->form_validation->set_error_delimiters('', '<?php echo htmlentities('<br />'); ?>');
            if ($this->form_validation->run()) {
                $time_now = date('Y-m-d H:i:s');
                $<?php echo $controller_lower; ?>_edit_array = array(
                    '<?php echo $controller_lower; ?>_status' => ($this->input->post('<?php echo $controller_lower; ?>_status') === 'true') ? '1' : '0',
                    '<?php echo $controller_lower; ?>_modified' => $time_now
                );
                if ($this-><?php echo $controller; ?>_model->edit($this->input->post('<?php echo $columns_array[0]; ?>'), $<?php echo $controller_lower; ?>_edit_array)) {
                    die('1');
                }
            } else {
                echo validation_errors();
                die;
            }
        }
        die('0');
    }

	function delete() {
		parent::allow(array('administrator'));
		if ($this->input->post('<?php echo $columns_array[0]; ?>')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('<?php echo $columns_array[0] ?>', '<?php echo ucwords(str_replace('_', ' ', $columns_array[0])); ?>', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_error_delimiters('', '<?php echo htmlentities('<br />') ?>');
			if ($this->form_validation->run()) {
				$<?php echo $controller_lower; ?>_details_array = $this-><?php echo $controller; ?>_model->get_<?php echo $controller_lower; ?>_by_id($this->input->post('<?php echo $columns_array[0] ?>'));
				if(count($<?php echo $controller_lower; ?>_details_array) > 0) {
					$<?php echo $controller_lower; ?>_edit_array = array(
						'<?php echo $controller_lower; ?>_status' => '-1',
						'<?php echo $controller_lower; ?>_modified' => date('Y-m-d H:i:s')
					);
					if ($this-><?php echo $controller; ?>_model->edit($this->input->post('<?php echo $columns_array[0] ?>'), $<?php echo $controller_lower; ?>_edit_array)) {
						die('1');
					}
				}
			} else {
				echo validation_errors();
				die;
			}
		}
		die('0');
	}

}
</div>
<hr/>
<div id="ci_model"><?php echo htmlentities('<?php'); ?>


// Model : <?php echo $controller; ?>_model.php

defined('BASEPATH') OR exit('No direct script access allowed');

class <?php echo $controller; ?>_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}
	
	function add($<?php echo $controller_lower; ?>_insert_array) {
		if ($this->db->insert('<?php echo $table; ?>', $<?php echo $controller_lower; ?>_insert_array)) {
			return $this->db->insert_id();
		}
		return 0;
	}
	
	function edit($<?php echo $columns_array[0]; ?>, $<?php echo $controller_lower; ?>_edit_array) {
		return $this->db->where('<?php echo $columns_array[0]; ?>', $<?php echo $columns_array[0]; ?>)->update('<?php echo $table; ?>', $<?php echo $controller_lower; ?>_edit_array);
	}
	
	function get_<?php echo $controller_lower; ?>_by_id($<?php echo $columns_array[0]; ?>) {
<?php foreach ($joined_tables_array as $key => $joined_table) { ?>
		$this->db->join('<?php echo $key; ?>', '<?php echo $joined_table; ?>', 'left');
<?php } ?>
		return $this->db->get_where('<?php echo $table; ?>', array('<?php echo $columns_array[0]; ?>' => $<?php echo $columns_array[0]; ?>))->row_array();
	}
	
	function get_all_<?php echo $table; ?>() {
<?php foreach ($joined_tables_array as $key => $joined_table) { ?>
		$this->db->join('<?php echo $key; ?>', '<?php echo $joined_table; ?>', 'left');
<?php } ?>
		return $this->db->get('<?php echo $table; ?>')->result_array();
	}

}
</div>
<hr/>
<div id="ci_index_view"><?php echo htmlentities('<?php'); ?>


// View : <?php echo $controller_lower; ?>/index.php
<?php echo htmlentities('?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>' . $controller_word . ' <small>' . $controller_word . ' Listing</small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">' . $controller_word . '</li>
		</ol>
	</section>
	<section class="content">
		<div class="box">
			<div class="box-body">
				<table id="' . $table . '_datatable" class="table table-bordered table-striped">
					<thead>
                        <tr>');
foreach ($columns_array as $column){
	echo htmlentities("\n\t\t\t\t\t\t\t".'<th>'.  ucwords(str_replace('_', ' ', $column)).'</th>');
}
foreach ($joined_tables_columns_array as $column){
	echo htmlentities("\n\t\t\t\t\t\t\t".'<th>'.  ucwords(str_replace('_', ' ', $column)).'</th>');
}
$deactivate_column = count($columns_array) + count($joined_tables_columns_array);
$status_column = array_search($controller_lower . '_status', $columns_array);
echo htmlentities("\n\t\t\t\t\t\t\t".'<th>Action</th>
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
        var table = $("#' . $table . '_datatable").DataTable({
			"order": [[0, "asc"]],
			"stateSave": false,
			"processing": true,
			"serverSide": true,
			"searchDelay": 1000,
			"responsive": true,
			"lengthMenu": [[10, 20, 50, 100, 200, 500, -1], [10, 20, 50, 100, 200, 500, "All"]],
			"deferRender": true,
			"ajax": {
				"url": base_url + "' . $controller_lower . '/datatable",
				"type": "POST"
			},
			"pagingType": "full_numbers",
			"dom": "<\'row\'<\'col-sm-4\'l><\'col-sm-4 text-center\'B><\'col-sm-4\'f>><\'row\'<\'col-sm-12\'tr>><\'row\'<\'col-sm-5\'i><\'col-sm-7\'p>>",
			"buttons": [
				\'excel\', \'pdf\'
			],
            "columnDefs": [
				{
					"targets": ' . $status_column . ',
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						switch (data[' . $status_column . ']) {
							case "1":
								return \'<div class="text-center"><input onchange="' . $controller_lower . '_status(\'+data[0]+\')" id="' . $controller_lower . '_id_\'+data[0]+\'" type="checkbox" checked="checked" /></div>\';
								break;
							default:
								return \'<div class="text-center"><input onchange="' . $controller_lower . '_status(\'+data[0]+\')" id="' . $controller_lower . '_id_\'+data[0]+\'" type="checkbox" /></div>\';
								break;
						}
					}
				},
				{
					"targets": ' . $deactivate_column . ',
					"sortable": false,
					"searchable": false,
					"data": null,
					"render": function (data, type, full, meta) {
						return \'<a href="<?php echo base_url(); ?>' . $controller_lower . '/edit/\'+data[0]+\'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> <a href="javascript:;" onclick="confirm_delete(\'+data[0]+\');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>\';
					}
				}]
		});
		table.columns().eq(0).each(function (colIdx) {
			var that = table.column(colIdx).header();
			if (!$(that).hasClass("sorting_disabled")) {
				var title = $(that).text();
				$(that).html(title + \'<br><input type="text" class="form-control input-sm" style="width:100%" placeholder="Search \' + title + \'" />\');
			}
			$("input", that).on("click", function (e) {
				e.stopPropagation();
			});
			$("input", that).on("keyup change", function () {
				table.column(colIdx).search(this.value).draw();
			});
		});
	});
	function ' . $controller_lower . '_status(' . $columns_array[0] . '){
		$.post(base_url+"' . $controller_lower . '/change_status",{' . $columns_array[0] . ':' . $columns_array[0] . ',' . $controller_lower . '_status:$("#' . $controller_lower . '_id_"+' . $columns_array[0] . ').is(":checked")}, function(data) {
			if(data === "1"){
				bootbox.alert("' . $controller_word . ' Status Changed Successfully");
			} else if(data === "0"){
				bootbox.alert("Error Updating ' . $controller_word . ' Status !!!");
			} else {
				bootbox.alert(data);
			}
		});
	}
	function confirm_delete(' . $columns_array[0] . '){
		bootbox.confirm("Are you sure you want to proceed ?",function(result){
			if(result){
				$.post(base_url+ "' . $controller_lower . '/delete",{' . $columns_array[0] . ':' . $columns_array[0] . '},function(data){
					if(data === "1"){
						document.location.href = "";
					} else {
						bootbox.alert(data);
					}
				});
			}
		});
	}
</script>'); ?>
</div>
<hr/>
<div id="ci_add_view"><?php echo htmlentities('<?php'); ?>


// View : <?php echo $controller_lower; ?>/add.php
<?php echo htmlentities('?>');?>
<?php echo htmlentities('
<div class="content-wrapper">
    <section class="content-header">
        <h1>Add ' . $controller_word . ' <small>Create New ' . $controller_word . '</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Add ' . $controller_word . '</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add ' . $controller_word . '</h3>
                    </div>
                    <form id="add_' . $table . '_form" role="form" method="post" action="">
                        <div class="box-body">');
foreach($table_structure_array as $column) {
	echo htmlentities('
							<div class="form-group">
                                <label for="' . $column['Field'] . '">' . ucwords(str_replace('_', ' ' , $column['Field'])) . '</label>
                                <input name="' . $column['Field'] . '" type="text" class="form-control" id="' . $column['Field'] . '" placeholder="Enter ' . ucwords(str_replace('_', ' ' , $column['Field'])) . '" value="">
                            </div>');
}
echo htmlentities('
						</div>
                        <div class="box-footer text-right">
							<a href="<?php echo base_url(); ?>' . $controller_lower . '" class="btn btn-default">Cancel</a>
                            <button id="add_'. $table .'_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Add ' . $controller_word . ' <i class="fa fa-chevron-right"></i></button>
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
    $("#add_' . $table . '_button").click(function() {
			$("#add_' . $table . '_form").validate({
			errorElement: "span", errorClass: "help-block",
			rules: {
			');
foreach($columns_array as $column) {
echo htmlentities($column . ': {
					required: true
				},
			');
}
echo htmlentities('},
			messages: {
			');
foreach($columns_array as $column) {
echo htmlentities($column . ': {
					required: "The ' . ucwords(str_replace('_', ' ', $column)) . ' field is required."
				},
			');
}
echo htmlentities('},
			invalidHandler: function (event, validator) {
				show_' . $table . '_error();
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
				$("#add_'. $table .'_button").button("loading");
				$.post("", $("#add_'. $table .'_form").serialize(), function(data) {
					if (data === "1") {
						bootbox.confirm("'. $controller_word .' Added Successfully !!!", function(result) {
							document.location.href = base_url + "' . $controller_lower . '";
						});
					} else if(data === "0"){
						bootbox.alert("Error Saving Data !!!");
					} else {
						bootbox.alert(data);
					}
					$("#add_'. $table .'_button").button("reset");
				});
			}
		});

		function show_' . $table . '_error() {
			$("form#add_' . $table . '_form").before(\'<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error submitting data.</div>\');
		}
    });
</script>'); ?>
</div>
<hr/>
<div id="ci_edit_view"><?php echo htmlentities('<?php'); ?>


// View : <?php echo $controller_lower; ?>/edit.php
<?php echo htmlentities('?>');?>
<?php echo htmlentities('
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit ' . $controller_word . ' <small>Edit ' . $controller_word . '</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit ' . $controller_word . '</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit ' . $controller_word . '</h3>
                    </div>
                    <form id="edit_' . $table . '_form" role="form" method="post" action="">
                        <div class="box-body">');
foreach($table_structure_array as $column) {
	echo htmlentities('
							<div class="form-group">
                                <label for="' . $column['Field'] . '">' . ucwords(str_replace('_', ' ' , $column['Field'])) . '</label>
                                <input name="' . $column['Field'] . '" type="text" class="form-control" id="' . $column['Field'] . '" placeholder="Enter ' . ucwords(str_replace('_', ' ' , $column['Field'])) . '" value="<?php echo $' . $controller_lower . '_details_array[\'' . $column['Field'] . '\']; ?>">
                            </div>');
}
echo htmlentities('
						</div>
                        <div class="box-footer text-right">
							<a href="<?php echo base_url(); ?>' . $controller_lower . '" class="btn btn-default">Cancel</a>
                            <button id="edit_'. $table .'_button" type="submit" class="btn btn-primary" data-loading-text="Please Wait...">Edit ' . $controller_word . ' <i class="fa fa-chevron-right"></i></button>
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
    $("#edit_' . $table . '_button").click(function() {
			$("#edit_' . $table . '_form").validate({
			errorElement: "span", errorClass: "help-block",
			rules: {
			');
foreach($columns_array as $column) {
echo htmlentities($column . ': {
					required: true
				},
			');
}
echo htmlentities('},
			messages: {
			');
foreach($columns_array as $column) {
echo htmlentities($column . ': {
					required: "The ' . ucwords(str_replace('_', ' ', $column)) . ' field is required."
				},
			');
}
echo htmlentities('},
			invalidHandler: function (event, validator) {
				show_' . $table . '_error();
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
				$("#edit_'. $table .'_button").button("loading");
				$.post("", $("#edit_'. $table .'_form").serialize(), function(data) {
					if (data === "1") {
						bootbox.confirm("'. $controller_word .' Edited Successfully !!!", function(result) {
							document.location.href = base_url + "' . $controller_lower . '";
						});
					} else if(data === "0"){
						bootbox.alert("Error Saving Data !!!");
					} else {
						bootbox.alert(data);
					}
					$("#edit_'. $table .'_button").button("reset");
				});
			}
		});

		function show_' . $table . '_error() {
			$("form#edit_' . $table . '_form").before(\'<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error submitting data.</div>\');
		}
    });
</script>'); ?>
</div>
<script>
	var editor1 = ace.edit("ci_controller");
	editor1.setTheme("ace/theme/monokai");
	editor1.getSession().setMode("ace/mode/php");
	
	var editor2 = ace.edit("ci_model");
	editor2.setTheme("ace/theme/monokai");
	editor2.getSession().setMode("ace/mode/php");
	
	var editor3 = ace.edit("ci_index_view");
	editor3.setTheme("ace/theme/monokai");
	editor3.getSession().setMode("ace/mode/php");
	
	var editor4 = ace.edit("ci_add_view");
	editor4.setTheme("ace/theme/monokai");
	editor4.getSession().setMode("ace/mode/php");
	
	var editor5 = ace.edit("ci_edit_view");
	editor5.setTheme("ace/theme/monokai");
	editor5.getSession().setMode("ace/mode/php");
</script>
<?php } ?>
	</body>
</html>