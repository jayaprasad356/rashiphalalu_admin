<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$date = new DateTime;
$date->format('h:i:s a');

?>
<?php
if (isset($_POST['btnAdd'])) {

        $date = $db->escapeString(($_POST['date']));
        $sunrise= $db->escapeString($_POST['sunrise']);
        $sunset = $db->escapeString($_POST['sunset']);
        $month_week = $db->escapeString($_POST['month_week']);
        $year_name = $db->escapeString($_POST['year_name']);
        $masam = $db->escapeString($_POST['masam']);
        $ayanam_ruthuvu = $db->escapeString($_POST['ayanam_ruthuvu']);
        $thidhi = $db->escapeString($_POST['thidhi']);
        $nakshatram = $db->escapeString($_POST['nakshatram']);
        $yogam = $db->escapeString($_POST['yogam']);
        $karanam = $db->escapeString($_POST['karanam']);
        $rahu_kalam = $db->escapeString($_POST['rahu_kalam']);
        $yama_gandam = $db->escapeString($_POST['yama_gandam']);

        
        if (empty($date)) {
            $error['date'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($sunrise)) {
            $error['sunrise'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($sunset)) {
            $error['sunset'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($month_week)) {
            $error['month_week'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($year_name)) {
            $error['year_name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($masam)) {
            $error['masam'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($ayanam_ruthuvu)) {
            $error['ayanam_ruthuvu'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($thidhi)) {
            $error['thidhi'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($nakshatram)) {
            $error['nakshatram'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($yogam)) {
            $error['yogam'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($karanam)) {
            $error['karanam'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($rahu_kalam)) {
            $error['rahu_kalam'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($yama_gandam)) {
            $error['yama_gandam'] = " <span class='label label-danger'>Required!</span>";
        }
        // if (empty($hc1)) {
        //     $error['hc1'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc2)) {
        //     $error['hc2'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc3)) {
        //     $error['hc3'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc4)) {
        //     $error['hc4'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc5)) {
        //     $error['hc5'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc6)) {
        //     $error['hc6'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc7)) {
        //     $error['hc7'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc8)) {
        //     $error['hc8'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc9)) {
        //     $error['hc9'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc10)) {
        //     $error['hc10'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc11)) {
        //     $error['hc11'] = " <span class='label label-danger'>Required!</span>";
        // }
        // if (empty($hc12)) {
        //     $error['hc12'] = " <span class='label label-danger'>Required!</span>";
        // }



       
       
       if (!empty($date) && !empty($sunrise) && !empty($sunset) && !empty($month_week) && !empty($year_name) && !empty($masam) && !empty($ayanam_ruthuvu)  && !empty($thidhi) && !empty($nakshatram) && !empty($yogam) && !empty($karanam)) {
         
            $sql = "SELECT * FROM panchangam WHERE date = '$date'";
            $db->sql($sql);
            $res = $db->getResult();
            $num = $db->numRows($res);
            if ($num >= 1){   
                $error['add_panchangam'] = " <span class='label label-danger'>Panchangam already in this date</span>";
            }
            else{
                $sql_query = "INSERT INTO panchangam (date,sunrise,sunset,month_week,year_name,masam,ayanam_ruthuvu,thidhi,nakshatram,yogam,karanam,rahu_kalam,yama_gandam) VALUES ('$date','$sunrise','$sunset','$month_week','$year_name','$masam','$ayanam_ruthuvu','$thidhi','$nakshatram','$yogam','$karanam','$rahu_kalam','$yama_gandam')";
                $db->sql($sql_query);
                $result = $db->getResult();
                if (!empty($result)) {
                    $result = 0;
                } else {
                    $result = 1;
                }
    
                if ($result == 1) {
                    // $sql = "SELECT id FROM panchangam ORDER BY id DESC LIMIT 1";
                    // $db->sql($sql);
                    // $res = $db->getResult();
                    // $panchangam_id = $res[0]['id'];
                    // for ($i = 0; $i < count($_POST['title']); $i++) {
        
                    //     $title = $db->escapeString(($_POST['title'][$i]));
                    //     $description = $db->escapeString(($_POST['description'][$i]));
                    //     $sql = "INSERT INTO panchangam_variant (panchangam_id,title,description) VALUES('$panchangam_id','$title','$description')";
                    //     $db->sql($sql);
                    //     $panchangam_variant_result = $db->getResult();
                    // }
                    // if (!empty($panchangam_variant_result)) {
                    //     $panchangam_variant_result = 0;
                    // } else {
                    //     $panchangam_variant_result = 1;
                    // }
                    
                    $error['add_panchangam'] = "<section class='content-header'>
                                                    <span class='label label-success'>Panchangam Added Successfully</span> </section>";
                } else {
                    $error['add_panchangam'] = " <span class='label label-danger'>Failed</span>";
                }
                }
                
            }

        }
?>
<section class="content-header">
    <h1>Add Daily Panchangam <small><a href='panchangam.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Daily Panchangam</a></small></h1>

    <?php echo isset($error['add_panchangam']) ? $error['add_panchangam'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_product" method="post" enctype="multipart/form-data">
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
                                            <label for="exampleInputEmail1">Month - Week</label> <i class="text-danger asterik">*</i><?php echo isset($error['month_week']) ? $error['month_week'] : ''; ?>
                                            <input type="text" class="form-control" name="month_week" >
                                    </div>
                                     <div class="col-md-4">
                                            <label for="exampleInputEmail1">Year Name</label> <i class="text-danger asterik">*</i><?php echo isset($error['year_name']) ? $error['year_name'] : ''; ?>
                                            <input type="text" class="form-control" name="year_name" >
                                    </div>
                                     <div class="col-md-4">
                                            <label for="exampleInputEmail1">Masam</label> <i class="text-danger asterik">*</i><?php echo isset($error['masam']) ? $error['masam'] : ''; ?>
                                            <input type="text" class="form-control" name="masam" >
                                    </div>
                                </div>
                            </div>
                             <br>
                             <div class="row">
                                <div class="form-group">
                                     <div class="col-md-4">
                                            <label for="exampleInputEmail1">Ayanam - Ruthuvu</label> <i class="text-danger asterik">*</i><?php echo isset($error['ayanam_ruthuvu']) ? $error['ayanam_ruthuvu'] : ''; ?>
                                            <input type="text" class="form-control" name="ayanam_ruthuvu">
                                    </div>
                                </div>
                            </div>
                             <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Sunrise</label> <i class="text-danger asterik">*</i><?php echo isset($error['sunrise']) ? $error['sunrise'] : ''; ?>
                                            <input type="text" class="form-control" name="sunrise" required>
                                    </div>
                                    <div class="col-md-4">
                                            <label for="exampleInputEmail1">Sunset</label> <i class="text-danger asterik">*</i><?php echo isset($error['sunset']) ? $error['sunset'] : ''; ?>
                                            <input type="text" class="form-control" name="sunset" required>
                                    </div>

                                 </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                            <label for="exampleInputEmail1">Thidhi</label> <i class="text-danger asterik">*</i><?php echo isset($error['thidhi']) ? $error['thidhi'] : ''; ?>
                                            <input type="text" class="form-control" name="thidhi">
                                    </div>
                                    <div class="col-md-3">
                                            <label for="exampleInputEmail1">Nakshatram</label> <i class="text-danger asterik">*</i><?php echo isset($error['nakshatram']) ? $error['nakshatram'] : ''; ?>
                                            <input type="text" class="form-control" name="nakshatram">
                                    </div>
                                    <div class="col-md-3">
                                            <label for="exampleInputEmail1">Yogam</label> <i class="text-danger asterik">*</i><?php echo isset($error['yogam']) ? $error['yogam'] : ''; ?>
                                            <input type="text" class="form-control" name="yogam">
                                    </div>
                                    <div class="col-md-3">
                                            <label for="exampleInputEmail1"> Karanam</label> <i class="text-danger asterik">*</i><?php echo isset($error['karanam']) ? $error['karanam'] : ''; ?>
                                            <input type="text" class="form-control" name="karanam">
                                    </div>
                                 </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                   <div class="col-md-3">
                                            <label for="exampleInputEmail1"> Rahu Kalam</label> <i class="text-danger asterik">*</i><?php echo isset($error['rahu_kalam']) ? $error['rahu_kalam'] : ''; ?>
                                            <input type="text" class="form-control" name="rahu_kalam">
                                    </div>
                                    <div class="col-md-3">
                                            <label for="exampleInputEmail1"> Yama Gandam</label> <i class="text-danger asterik">*</i><?php echo isset($error['yama_gandam']) ? $error['yama_gandam'] : ''; ?>
                                            <input type="text" class="form-control" name="yama_gandam">
                                    </div>
                                   
                                 </div>
                            </div>
                            <br>
                         
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
    $('#add_panchangam').validate({

        ignore: [],
        debug: false,
        rules: {
            date: "required",
            sunrise: "required",
            sunset: "required",
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
                $(wrapper).append('<div class="row"><div class="col-md-4"><div class="form-group"><label for="title">Title</label>' +'<input type="text" class="form-control" name="title[]" required /></div></div>' + '<div class="col-md-4"><div class="form-group"><label for="description">Description</label>'+'<textarea type="text" row="2" class="form-control" name="description[]" required></textarea></div></div>'+'<div class="col-md-1" style="display: grid;"><label>Tab</label><a class="remove" style="cursor:pointer;color:white;"><button class="btn btn-danger">Remove</button></a></div>'+'</div>');
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