<?php

/**
 * 一言插入工具（insert）
 * 
 */

if (!defined('DIR'))
    exit('非法访问');

$file = DIR . "/data/hitokoto.txt";
if (file_exists($file)) {
    $file = fopen($file, "r") or exit("Unable to open file!");
    //Output a line of the file until the end is reached
    //feof() check if file read end EOF
    $log = '';
    $i = 0;
    while (!feof($file)) {
        //fgets() Read row by row
        $hitokoto = fgets($file);
        echo $i++.'---->'.$hitokoto.'<br />';
        $array_sentence = array(
            'content' => $hitokoto,
            'cat' => 'f',
            'catname' => '来源网络-待补充',
            'source' => '来源网络-待补充',
            'author' => '来源网络-待补充',
            'date' => '2019-08-12 00:00:00',
            'user_id' => 0,
        );
        //exit($array_sentence['date']);
        if(!check_hitokoto_similarity($hitokoto))
            add_hitokoto($array_sentence);
    }
    fclose($file);
    return $log;
}


exit;

//$content = file_get_contents(DIR.'/data/hitokoto - chinese.json');
$content = file_get_contents(DIR . '/data/lp_hitokoto.json');

$content = json_decode($content, true);
//var_dump($content);
//exit;
foreach ($content as $key => $value) {
    echo $value['id'] . '--->' . $value['hitokoto'] . '<br />';
    # code...
    $array_sentence = array(
        'content' => $value['hitokoto'],
        'cat' => $value['cat'],
        'catname' => $value['catname'],
        'source' => $value['source'],
        'author' => $value['author'],
        'date' => date('Y-m-d H:i:s', $value['date']),
        'user_id' => 0,
    );
    //exit($array_sentence['date']);
    if(!check_hitokoto_similarity($value['hitokoto']))
    add_hitokoto($array_sentence);
}
