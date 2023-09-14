<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('Asia/Kolkata');

include_once('../includes/crud.php');
$db = new Database();
$db->connect();

$sql = "SELECT * FROM `yearly_horoscope`";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if($num>=1){
        $rows = array();
        $temp = array();
        foreach ($res as $row) {
            $id = $row['id'];
            $temp['id'] = $row['id'];
            $temp['rasi'] = $row['rasi'];
            $temp['main_title'] = $row['main_title'];
            $temp['main_description'] = $row['main_description'];
            $temp['year'] = $row['year'];
            $temp['adhayam'] = $row['adhayam'];
            $temp['vyayam'] = $row['vyayam'];
            $temp['rajapujyam'] = $row['rajapujyam'];
            $temp['aavamanam'] = $row['aavamanam'];
            $temp['title'] = $row['title'];
            $temp['description'] = $row['description'];
            $temp['janma_nama_nakshathram'] = $row['janma_nama_nakshathram'];
            $temp['janma_nama_nakshathram_title1'] = $row['janma_nama_nakshathram_title1'];
            $temp['janma_nama_nakshathram_title2'] = $row['janma_nama_nakshathram_title2'];
            $temp['janma_nama_nakshathram_title3'] = $row['janma_nama_nakshathram_title3'];
            $temp['janma_nama_nakshathram_title4'] = $row['janma_nama_nakshathram_title4'];
            $temp['janma_nama_nakshathram_description1'] = $row['janma_nama_nakshathram_description1'];
            $temp['janma_nama_nakshathram_description2'] = $row['janma_nama_nakshathram_description2'];
            $temp['janma_nama_nakshathram_description3'] = $row['janma_nama_nakshathram_description3'];
            $temp['janma_nama_nakshathram_description4'] = $row['janma_nama_nakshathram_description4'];
            $temp['graha_dhashakalamu'] = $row['graha_dhashakalamu'];
 
            $sql = "SELECT * FROM `yearly_horoscope_variant` WHERE yearly_horoscope_id = '$id'";
            $db->sql($sql);
            $res = $db->getResult();
            $temp['yearly_horoscope_variant'] = $res;
            $rows[] = $temp;
        }
        $response['success'] = true;
        $response['message'] = "Yearly Horoscope Listed Successfully";
        $response['data'] = $rows;
        print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Data Not Found";
    print_r(json_encode($response));
}


?>