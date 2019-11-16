<?php

/**
 * 统计
 * 
 */

require '../load.php';

$counter = array(
    'index' => '2019-08-05',
    'api' => '2019-08-05',
    'hit' => get_data_value('all_accesses'),
    'speed_5min' => visit_read(300)['all_hit'],
    'sys_hitokoto_number' => get_hitokoto_number('0'),
    'user_hitokoto_number' => get_hitokoto_number()-get_hitokoto_number('0'),
    'min' => visit_read(60)['visit_details'],
    'day' => visit_read(86400)['visit_details'],
);

header('Content-Type: application/json');
echo json_encode($counter, true);
