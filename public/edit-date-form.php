<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_GET['id'])) {
    $ID = $db->escapeString($fn->xss_clean($_GET['id']));
} else {
    // $ID = "";
    return false;
    exit(0);
}

if (isset($_POST['btnUpdate'])) {
    $error = array();
    $date= $db->escapeString($_POST['date']);
    $year= $db->escapeString($_POST['year']);
    $season= $db->escapeString($_POST['season']);
    $week= $db->escapeString($_POST['week']);
    if (!empty($date) && !empty($year) && !empty($season) && !empty($week))
     { 
        $sql = "UPDATE season SET date='$date',year='$year',season='$season',week='$week' WHERE id = '$ID'";
        $db->sql($sql);
        $result = $db->getResult();
        if (!empty($result)) {
            $result = 0;
        } else {
            $result = 1;
        }

        if ($result == 1) {
            
            $error['update_season'] = "<section class='content-header'>
                                            <span class='label label-success'> Updated Successfully</span> </section>";
        } else {
            $error['update_season'] = " <span class='label label-danger'>Failed</span>";
        }
        }
    }

$data = array();

$sql_query = "SELECT * FROM `season` WHERE id = '$ID'";
$db->sql($sql_query);
$res = $db->getResult();

?>
<section class="content-header">
    <h1>Edit<small><a href='date.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back</a></small></h1>
    <?php echo isset($error['update_season']) ? $error['update_season'] : ''; ?>

</section>
<section class="content">
<div class="row">
		<div class="col-md-12">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div>
				<div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>
				
				<!-- /.box-header -->
				<!-- form start -->
				<form id="edit_date_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						   <div class="row">
							    <div class="form-group">
									<div class='col-md-6'>
									          <label for="exampleInputEmail1">Date</label> <i class="text-danger asterik">*</i>
											  <input type="date" class="form-control" name="date" value="<?php echo $res[0]['date']; ?>">
									</div>
								</div>
						   </div>
						   <br>
						   <div class="row">
								<div class="form-group">
									<div class='col-md-4'>
											<label for="exampleInputEmail1">Year</label> <i class="text-danger asterik">*</i>
											<input type="text" class="form-control" name="year" value="<?php echo $res[0]['year']; ?>">
									</div>
									<div class='col-md-4'>
											<label for="exampleInputEmail1">Season</label> <i class="text-danger asterik">*</i>
											<input type="text" class="form-control" name="season" value="<?php echo $res[0]['season']; ?>">
									</div>
									<div class='col-md-4'>
											<label for="exampleInputEmail1">Week</label> <i class="text-danger asterik">*</i>
											<input type="text" class="form-control" name="week" value="<?php echo $res[0]['week']; ?>">
									</div>
								</div>
						   </div>
						   <br>

                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                    </div>

                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>