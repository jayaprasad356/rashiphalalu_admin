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

$sql = "SELECT jr.*, j.rasi AS rasi FROM janma_rashulu_tab_variant jr
        LEFT JOIN janma_rashulu_tab j ON jr.janma_rashulu_tab_id = j.id";
$db->sql($sql);
$res = $db->getResult();

$response = array(); 

if (!empty($res)) {
    $response['success'] = true;
    $response['message'] = "Janma Rashulu Vati Swabhavalu Variant Listed Successfully";
    $response['data'] = $res;
} else {
    $response['success'] = false;
    $response['message'] = "Data Not Found";
    $response['data'] = array(); 
}

print_r(json_encode($response));
?>
