<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {

        $date= $db->escapeString($_POST['date']);
        $year= $db->escapeString($_POST['year']);
        $season = $db->escapeString($_POST['season']);
        $week = $db->escapeString($_POST['week']);
        $error = array();

        
     
        if (empty($date)) {
            $error['date'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($year)) {
            $error['year'] = " <span class='label label-danger'>Required!</span>";
        }
       
        if (empty($season)) {
            $error['season'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($week)) {
            $error['week'] = " <span class='label label-danger'>Required!</span>";
        }
       


        if ( !empty($date)  && !empty($year) && !empty($season)&& !empty($week))
        {
                $sql_query = "INSERT INTO season (date,season,year,week)VALUES('$date','$season','$year','$week')";
                $db->sql($sql_query);
                $result = $db->getResult();
                if (!empty($result)) {
                    $result = 0;
                } else {
                    $result = 1;
                }
    
                if ($result == 1) {
                    
                    $error['add_season'] = "<section class='content-header'>
                                                    <span class='label label-success'> Added Successfully</span> </section>";
                } else {
                    $error['add_season'] = " <span class='label label-danger'>Failed</span>";
                }
                }
            }
    ?>
<section class="content-header">
    <h1>Add<small><a href='date.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back</a></small></h1>

    <?php echo isset($error['add_season']) ? $error['add_season'] : ''; ?>
    <hr />
    </section>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_seson_form" method="post" enctype="multipart/form-data">
                <div class="box-body">
                           <div class="row">
                                <div class="form-group">
                                     <div class="col-md-6">
                                            <label for="exampleInputEmail1">Date</label> <i class="text-danger asterik">*</i><?php echo isset($error['date']) ? $error['date'] : ''; ?>
                                            <input type="date" class="form-control" name="date" required>
                                    </div>
                                </div>
                            </div>
                             <br>
                             <div class="row">
                                <div class="form-group">
                                     <div class="col-md-4">
                                            <label for="exampleInputEmail1">year</label> <i class="text-danger asterik">*</i><?php echo isset($error['year']) ? $error['year'] : ''; ?>
                                            <input type="text" class="form-control" name="year" >
                                    </div>
                                     <div class="col-md-4">
                                            <label for="exampleInputEmail1">Season</label> <i class="text-danger asterik">*</i><?php echo isset($error['season']) ? $error['season'] : ''; ?>
                                            <input type="text" class="form-control" name="season" >
                                    </div>
                                     <div class="col-md-4">
                                            <label for="exampleInputEmail1">Week</label> <i class="text-danger asterik">*</i><?php echo isset($error['week']) ? $error['week'] : ''; ?>
                                            <input type="text" class="form-control" name="week" >
                                    </div>
                                </div>
                            </div>
                  
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_abdhikam_form').validate({

        ignore: [],
        debug: false,
        rules: {
            month: "required",
            title="required",
            description="required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var max_fields = 8;
        var wrapper = $("#packate_div");
        var add_button = $(".add_packate_variation");

        var x = 1;
        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row"><div class="col-md-3"><div class="form-group"><label for="date_month">Telugu Date & Month</label>' +'<input type="text" class="form-control" name="date_month[]" /></div></div>' + '<div class="col-md-4"><div class="form-group"><label for="description">Description</label>'+'<textarea type="text" row="2" class="form-control" name="description[]"></textarea></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Tab</label><a class="remove" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
            }
            else{
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

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>

<?php $db->disconnect(); ?>