<?php
/**
 * API
 */
require_once '../core/database.php';
require_once 'api_db_query.php';

$db = new DB;
$cat = isset($_GET['cat']) ? $_GET['cat'] : null;
$userid = isset($_GET['userid']) ? $_GET['userid'] : null;

if (!empty($cat) && !empty($userid)) {
    $hitokoto = $db->get_rand_hitokoto('cat-userid', $cat, $userid);
} elseif (!empty($cat)) {
    $hitokoto = $db->get_rand_hitokoto('cat', $cat);
} elseif (!empty($userid)) {
    $hitokoto = $db->get_rand_hitokoto('userid', $userid);
}else{
    $hitokoto = $db->get_rand_hitokoto();
}

//header('Content-type: application/json');
echo json_encode($hitokoto);
