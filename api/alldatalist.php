<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');
$db = new Database();
$db->connect();


$sql = "SELECT * FROM `guru_graham_tab`";
$db->sql($sql);
$res = $db->getResult();
$rows = array();
$temp = array();
foreach ($res as $row) {
    $temp['id'] = $row['id'];
    $temp['year'] = $row['year'];
    $temp['rasi'] = $row['rasi']; 
    $rows[] = $temp;
}
$response['success'] = true;
$response['message'] = "Guru Graham Listed Successfullty";
$response['guru_graham_tab_list'] = $rows;

unset($temp);
$sql = "SELECT * FROM `guru_graham_tab_variant`";
$db->sql($sql);
$res = $db->getResult();
$rows = array();
$temp = array();
foreach ($res as $row) {
    $temp['id'] = $row['id'];
    $temp['guru_graham_tab_id'] = $row['guru_graham_tab_id'];
    $temp['title'] = $row['title'];
    $temp['description'] = $row['description'];
    $rows[] = $temp;
}
$response['guru_graham_tab_list'] = $rows;
unset($temp);
?>