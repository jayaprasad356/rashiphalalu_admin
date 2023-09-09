<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
include_once('../includes/variables.php');
$db = new Database();
$db->connect();

if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}

if (isset($_GET['table']) && $_GET['table'] == 'season') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE id like '%" . $search . "%' OR title like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `season` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM season " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-date.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-date.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['year'] = $row['year'];
        $tempRow['season'] = $row['season'];
        $tempRow['date'] = $row['date'];
        $tempRow['week'] = $row['week'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'daily_horoscope') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE id like '%" . $search . "%' OR date like '%" . $search . "%' OR rasi like '%" . $search . "%' OR description like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `daily_horoscope` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM daily_horoscope " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-daily_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-daily_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['date'] = $row['date'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['description'];
        // $tempRow['lucky_number'] = $row['lucky_number'];
        // $tempRow['lucky_color'] = $row['lucky_color'];
        // $tempRow['treatment'] = $row['treatment'];
        // $tempRow['health'] = $row['health'];
        // $tempRow['wealth'] = $row['wealth'];
        // $tempRow['family'] = $row['family'];
        // $tempRow['things_love'] = $row['things_love'];
        // $tempRow['profession'] = $row['profession'];
        // $tempRow['married_life'] = $row['married_life'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'weekly_horoscope') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE id like '%" . $search . "%' OR rasi like '%" . $search . "%' OR year like '%" . $search . "%' OR month like '%" . $search . "%' OR description like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `weekly_horoscope` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM weekly_horoscope " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a href="edit-weekly_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-weekly_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['title'] = $row['title'];
        $tempRow['week'] = $row['week'];
        $tempRow['year'] = $row['year'];
        $tempRow['month'] = $row['month'];
        $tempRow['description'] = $row['description'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'monthly_horoscope') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE id like '%" . $search . "%' OR rasi like '%" . $search . "%' OR year like '%" . $search . "%' OR month like '%" . $search . "%' OR description like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `monthly_horoscope` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM monthly_horoscope " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-monthly_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-monthly_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['title'] = $row['title'];
        $tempRow['year'] = $row['year'];
        $tempRow['month'] = $row['month'];
        $tempRow['description'] = $row['description'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'yearly_horoscope') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE id like '%" . $search . "%' OR rasi like '%" . $search . "%' OR year like '%" . $search . "%' OR title like '%" . $search . "%' OR description like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `yearly_horoscope` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM yearly_horoscope " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-yearly_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-yearly_horoscope.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['year'] = $row['year'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['description'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'panchangam') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE id like '%" . $search . "%' OR date like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `panchangam`";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM panchangam " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-panchangam.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-panchangam.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['date'] = $row['date'];
        $tempRow['sunrise'] = date('h:i a', strtotime($row['sunrise']));
        $tempRow['sunset'] = date('h:i a', strtotime($row['sunset']));
      
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
//grahalu sbmenu table goes here
if (isset($_GET['table']) && $_GET['table'] == 'guru_graham') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= " WHERE gs.id LIKE '%" . $search . "%' OR gs.name LIKE '%" . $search . "%' OR g.name LIKE '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(g.id) AS total FROM guru_graham_tab g LEFT JOIN guru_graham_tab_variant gt ON g.id = gt.guru_graham_tab_id";
    $db->sql($sql);
    $res = $db->getResult();
    
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT g.id AS id, g.*, gt.title, gt.description AS guru_graham_tab_variant_title FROM guru_graham_tab g LEFT JOIN guru_graham_tab_variant gt ON g.id = gt.guru_graham_tab_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a href="edit-guru_graham.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= '<a class="text text-danger" href="delete-guru_graham.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['year'] = $row['year'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['guru_graham_tab_variant_title'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }

    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
//grahalu sbmenu table goes here
if (isset($_GET['table']) && $_GET['table'] == 'shani_graham') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= " WHERE gs.id LIKE '%" . $search . "%' OR gs.name LIKE '%" . $search . "%' OR g.name LIKE '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(s.id) AS total FROM shani_graham_tab s LEFT JOIN shani_graham_tab_variant st ON s.id = st.shani_graham_tab_id";
    $db->sql($sql);
    $res = $db->getResult();
    
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT s.id AS id, s.*, st.title, st.description AS shani_graham_tab_variant_title FROM shani_graham_tab s LEFT JOIN shani_graham_tab_variant st ON s.id = st.shani_graham_tab_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a href="edit-shani_graham.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= '<a class="text text-danger" href="delete-shani_graham.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['year'] = $row['year'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['shani_graham_tab_variant_title'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }

    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
//grahalu sbmenu table goes here
if (isset($_GET['table']) && $_GET['table'] == 'rahu_ketu_graham') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';

    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= " WHERE gs.id LIKE '%" . $search . "%' OR gs.name LIKE '%" . $search . "%' OR g.name LIKE '%" . $search . "%'";
    }

    $sql = "SELECT COUNT(r.id) AS total FROM rahu_ketu_graham_tab r LEFT JOIN rahu_ketu_graham_tab_variant rt ON r.id = rt.rahu_ketu_graham_tab_id";
    $db->sql($sql);
    $res = $db->getResult();
    
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT r.id AS id, r.*, rt.title, rt.description AS rahu_ketu_graham_tab_variant_title FROM rahu_ketu_graham_tab r LEFT JOIN rahu_ketu_graham_tab_variant rt ON r.id = rt.rahu_ketu_graham_tab_id " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = '<a href="edit-rahu_ketu_graham.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= '<a class="text text-danger" href="delete-rahu_ketu_graham.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';

        $tempRow['id'] = $row['id'];
        $tempRow['year'] = $row['year'];
        $tempRow['rasi'] = $row['rasi'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['rahu_ketu_graham_tab_variant_title'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }

    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
$db->disconnect();
