<?php

/**
 * Test file
 * 
 */
require '../load.php';

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if ($referer != null)
    $visitor = parse_url($referer)['host'];
else
    $visitor = $_SERVER['HTTP_HOST'];

$visit_time = $_SERVER['REQUEST_TIME'];
visit_record($visitor, $visit_time);

$one_min = visit_read(60);

header('Content-Type: application/json');
echo json_encode($one_min, true);
