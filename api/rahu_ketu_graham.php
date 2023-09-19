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

$sql = "SELECT * FROM `rahu_ketu_graham_tab`";
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
        $temp['year'] = $row['year'];

        $sql = "SELECT * FROM `rahu_ketu_graham_tab_variant` WHERE rahu_ketu_graham_tab_id = '$id'";
        $db->sql($sql);
        $res = $db->getResult();
        $temp['rahu_ketu_graham_tab_variant'] = $res;
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "Rahu Ketu Graham List Successfullty";
    $response['data'] = $rows;
    print_r(json_encode($response));

}


?>