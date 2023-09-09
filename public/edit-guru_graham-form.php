<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    // $ID = "";
    return false;
    exit(0);
}
	$category_data = array();
	$sql = "select id,name from guru_graham order by id asc";
	$db->sql($sql);
	$category_data = $db->getResult();
	$sql = "select * from grahalu_submenu";
	$db->sql($sql);
	$subcategory = $db->getResult();

if (isset($_POST['btnEdit'])) {


	$year = $db->escapeString(($_POST['year']));
	$rasi = $db->escapeString(($_POST['rasi']));

	$error = array();

	

   
   
   if (!empty($year) && !empty($rasi)) {
				$sql_query = "UPDATE guru_graham_tab SET year='$year',rasi='$rasi' WHERE id =$ID";
				$db->sql($sql_query);
				$res = $db->getResult();
				$update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1)
			{
				for ($i = 0; $i < count($_POST['title']); $i++) {
					$guru_graham_tab_id = $db->escapeString(($_POST['guru_graham_tab_variant_id'][$i]));
					$title = $db->escapeString(($_POST['title'][$i]));
					$description = $db->escapeString(($_POST['description'][$i]));
					$sql = "UPDATE guru_graham_tab_variant SET title='$title',description='$description' WHERE id =$guru_graham_tab_id";
					$db->sql($sql);

				}
				if (
					isset($_POST['insert_title']) && isset($_POST['insert_description'])
				) {
					for ($i = 0; $i < count($_POST['insert_title']); $i++) {
						$title = $db->escapeString(($_POST['insert_title'][$i]));
						$description = $db->escapeString(($_POST['insert_description'][$i]));
						if (!empty($title) || !empty($description)) {
							$sql = "INSERT INTO guru_graham_tab_variant (guru_graham_tab_id,title,description) VALUES('$ID','$title','$description')";
							$db->sql($sql);

						}
					}
				}
					$error['update_grahalutab'] = " <section class='content-header'><span class='label label-success'>Grahalu Tab updated Successfully</span></section>";
			} else {
				$error['update_grahalutab'] = " <span class='label label-danger'>Failed to update</span>";
			}
			}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM guru_graham_tab WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

$sql_query = "SELECT * FROM guru_graham_tab_variant WHERE guru_graham_tab_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "guru_graham_tab.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Guru Graham Tab<small><a href='guru_graham.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Guru Graham Tab</a></small></h1>
	<small><?php echo isset($error['update_grahalutab']) ? $error['update_grahalutab'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-10">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div>
				<div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>
				
				<!-- /.box-header -->
				<!-- form start -->
				<form id="edit_daily_horoscope_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					<div class="row">
                                <div class="form-group">
                                    <div class='col-md-6'>
                                    <label for="">Year</label> <i class="text-danger asterik">*</i>
                                        <select id='year' name="year" class='form-control' required>
                                            <option value="">Select Year</option>
                                                <?php
                                                $sql = "SELECT * FROM `year_count`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
													 <option value='<?= $value['year'] ?>' <?= $value['year']==$res[0]['year'] ? 'selected="selected"' : '';?>><?= $value['year'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class='col-md-6'>
                                        <label for="">Rasi</label> <i class="text-danger asterik">*</i>
                                        <select id='rasi' name="rasi" class='form-control' required>
                                            <option value="">Select</option>
                                                <?php
                                                $sql = "SELECT * FROM `rasi_names`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
													 <option value='<?= $value['rasi'] ?>' <?= $value['rasi']==$res[0]['rasi'] ? 'selected="selected"' : '';?>><?= $value['rasi'] ?></option>
                                            <?php } ?>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <br>
						   <div id="variations">
							<?php
							$i=0;
							foreach ($resslot as $row) {
								?>
								<div id="packate_div">
									<div class="row">
									    <input type="hidden" class="form-control" name="guru_graham_tab_variant_id[]" id="guru_graham_tab_variant_id" value='<?= $row['id']; ?>' />
									    <div class="col-md-4">
											<div class="form-group packate_div">
												<label for="exampleInputEmail1">title</label> <i class="text-danger asterik">*</i>
												<input type="text" class="form-control" name="title[]" value="<?php echo $row['title'] ?>" />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group packate_div">
												<label for="exampleInputEmail1">description</label> <i class="text-danger asterik">*</i>
												<textarea type="text" rows="2" class="form-control" name="description[]"><?php echo $row['description'] ?></textarea>
											</div>
										</div>

										<?php if ($i == 0) { ?>
												<div class='col-md-1'>
													<label>Tab</label>
													<a id="add_packate_variation" title='Add variation' style='cursor: pointer;color:white;'><button class="btn btn-warning">Add more</button></a>
												</div>
											<?php } else { ?>
												<div class="col-md-1">
													<label>Tab</label>
													<a class="remove_variation text-danger" data-id="data_delete" title="Remove variation of panchangam" style="cursor: pointer;color:white;"><button class="btn btn-danger">Remove</button></a>
												</div>
											<?php } ?>
									</div>
								</div>
								<?php $i++; 
							} ?> 
						
						</div>
						<!-- /.box-body -->
                       
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>					
					</div>
				</form>
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 7;
        var wrapper = $("#packate_div");
        var add_button = $("#add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
				$(wrapper).append('<div class="row"><div class="col-md-4"><div class="form-group"><label for="title">title</label>' +'<input type="text" class="form-control" name="insert_title[]" /></div></div>'+'<div class="col-md-4"><div class="form-group"><label for="description">description</label>'+'<textarea type="text" rows="2" class="form-control" name="insert_description[]"></textarea></div></div>'+'<div class="col-md-1" style="display:grid;"><label>Tab</label><a class="remove text-danger" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
            } else {
                alert('You Reached the limits')
            }
        });


        $(wrapper).on("click", ".remove", function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
            x--;
        })
    });
</script>
<script>
    $(document).on('click', '.remove_variation', function() {
        if ($(this).data('id') == 'data_delete') {
            if (confirm('Are you sure? Want to delete this row')) {
                var id = $(this).closest('div.row').find("input[id='grahalu_tab_variant_id']").val();
                $.ajax({
                    url: 'public/db-operation.php',
                    type: "post",
                    data: 'id=' + id + '&delete_variant=1',
                    success: function(result) {
                        if (result) {
                            location.reload();
                        } else {
                            alert("Variant not deleted!");
                        }
                    }
                });
            }
        } else {
            $(this).closest('.row').remove();
        }
    });
</script>
<script>
     $(document).on('change', '#grahalu_id', function() {
        $.ajax({
            url: 'public/db-operation.php',
            method: 'POST',
            data: 'grahalu_id=' + $('#grahalu_id').val() + '&find_grahalusubcategory=1',
            success: function(data) {
                $('#subcategory_id').html("<option value=''>---Select Subcategory---</option>" + data);
            }
        });
    });
</script>
