<?php

/**
 * 
 * 
 */

require '../load.php';

$counter = array(
    'index' => '2019-08-03',
    'api' => '2019-08-03',
    'hit' => get_data_value('all_accesses'),
    'speed_5min' => null,
    'sys_hitokoto_number' => get_hitokoto_number('0'),
    'user_hitokoto_number' => get_hitokoto_number()-get_hitokoto_number('0'),
);
header('Content-Type: application/json');
echo json_encode($counter, true);
