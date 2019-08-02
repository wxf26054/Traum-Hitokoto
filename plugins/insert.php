<?php
/**
 * 一言插入工具（insert）
 * 
 */

 if (!defined('DIR'))
 exit('非法访问');

$content = file_get_contents(DIR.'/step/hitokoto - chinese.json');
$content = json_decode($content,true);

foreach ($content as $key => $value) {
    # code...
    $array_sentence = array(
        'content' => $value['hitokoto'],
        'cat' => $value['cat'],
        'source' => $value['source'],
        'author' => $value['author'],
        'date' => date('Y-m-d H:i:s',$value['date']),
        'user_id' => 0,
    );
    //exit($array_sentence['date']);
    $result = add_hitokoto($array_sentence);
}