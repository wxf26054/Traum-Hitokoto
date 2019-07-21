<?php

$str = '天空是连着的，如果我们也能各自发光的话，无论距离有多远，都能看到彼此努力的身影。';

var_dump(preg_split('/(?<!^)(?!$)/u', $str));
function mb_str_split($str, $count){
    $leng = strlen($str)/3;     //中文长度
    $arr = array();
    for ($i=0; $i < $leng; $i+=$count) {
        $arr[] = mb_substr($str, $i, $count);
    }
    return $arr;
}
var_dump(mb_str_split($str,3));