<?php
/**
 * 一言插入工具
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
    );
    $db = new DB;
    $result = $db->add_hitokoto($array_sentence, 1);
}
