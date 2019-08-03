<?php

/**
 * 
 * 
 */

require '../load.php';

$counter = array(
    'index' => null,
    'api' => null,
    'hit' => null,
    'speed' => null,
    'number' => null,
    'number_uid' => null,
);
header('Content-Type: application/json');
echo json_encode($counter, true);
