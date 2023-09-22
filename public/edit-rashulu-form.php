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
	$sql = "select id,name from rashulu_tab order by id asc";
	$db->sql($sql);
	$category_data = $db->getResult();
	$sql = "select * from grahalu_submenu";
	$db->sql($sql);
	$subcategory = $db->getResult();

if (isset($_POST['btnEdit'])) {


	$title = $db->escapeString(($_POST['title']));
	$description = $db->escapeString(($_POST['description']));

	$error = array();

	

   
   
   if (!empty($title) && !empty($description)) {
				$sql_query = "UPDATE rashulu_tab SET title='$title',description='$description' WHERE id =$ID";
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
				for ($i = 0; $i < count($_POST['title1']); $i++) {
					$rashulu_tab_id = $db->escapeString(($_POST['rashulu_tab_variant_id'][$i]));
					$title1 = $db->escapeString(($_POST['title1'][$i]));
					$description1 = $db->escapeString(($_POST['description1'][$i]));
					$sql = "UPDATE rashulu_tab_variant SET title1='$title1',description1='$description1' WHERE id =$rashulu_tab_id";
					$db->sql($sql);

				}
				if (
					isset($_POST['insert_title1']) && isset($_POST['insert_description1'])
				) {
					for ($i = 0; $i < count($_POST['insert_title1']); $i++) {
						$title1 = $db->escapeString(($_POST['insert_title1'][$i]));
						$description1 = $db->escapeString(($_POST['insert_description1'][$i]));
						if (!empty($title1) || !empty($description1)) {
							$sql = "INSERT INTO rashulu_tab_variant (rashulu_tab_id,title1,description1) VALUES('$ID','$title1','$description1')";
							$db->sql($sql);

						}
					}
				}
					$error['update_grahalutab'] = " <section class='content-header'><span class='label label-success'>updated Successfully</span></section>";
			} else {
				$error['update_grahalutab'] = " <span class='label label-danger'>Failed to update</span>";
			}
			}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM rashulu_tab WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

$sql_query = "SELECT * FROM rashulu_tab_variant WHERE rashulu_tab_id =" . $ID;
$db->sql($sql_query);
$resslot = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "rashulu_tab.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Rashulu & Nakshathramulu aantey amiti <small><a href='rashulu.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Rashulu & Nakshathramulu aantey amiti</a></small></h1>
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
				<form id="edit_rashulu_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
                    <div class="row">
							    <div class="form-group">
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Title</label><i class="text-danger asterik">*</i>
										<input type="text" class="form-control" name="title" value="<?php echo $res[0]['title']; ?>">
									 </div>
									 <div class="col-md-4">
										<label for="exampleInputEmail1">Description</label><i class="text-danger asterik">*</i>
										<textarea type="text" rows="2" class="form-control" name="description"><?php echo $row['description'] ?></textarea>
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
									    <input type="hidden" class="form-control" name="rashulu_tab_variant_id[]" id="rashulu_tab_variant_id" value='<?= $row['id']; ?>' />
									    <div class="col-md-4">
											<div class="form-group packate_div">
												<label for="exampleInputEmail1">title1</label> <i class="text-danger asterik">*</i>
												<input type="text" class="form-control" name="title1[]" value="<?php echo $row['title1'] ?>" />
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group packate_div">
												<label for="exampleInputEmail1">description1</label> <i class="text-danger asterik">*</i>
												<textarea type="text" rows="2" class="form-control" name="description1[]"><?php echo $row['description1'] ?></textarea>
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
				$(wrapper).append('<div class="row"><div class="col-md-4"><div class="form-group"><label for="title1">title1</label>' +'<input type="text" class="form-control" name="insert_title1[]" /></div></div>'+'<div class="col-md-4"><div class="form-group"><label for="description1">description1</label>'+'<textarea type="text" rows="2" class="form-control" name="insert_description1[]"></textarea></div></div>'+'<div class="col-md-1" style="display:grid;"><label>Tab</label><a class="remove text-danger" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
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
                var id = $(this).closest('div.row').find("input[id='rashulu_tab_variant_id']").val();
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
