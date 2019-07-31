<?php
/**
 * API
 * 
 */

//计时开始
runtime();

require_once '../load.php';

$cat = isset($_GET['cat']) ? $_GET['cat'] : null;
$userid = isset($_GET['userid']) ? $_GET['userid'] : null;
$charset = isset($_GET['charset']) ? $_GET['charset'] : null;
$encode = isset($_GET['encode']) ? $_GET['encode'] : null;
$fun = isset($_GET['fun']) ? $_GET['fun'] : null;
$length = isset($_GET['length']) ? $_GET['length'] : null;

if (!empty($cat) && !empty($userid)) {
    $hitokoto = get_rand_hitokoto('cat-userid', $cat, $userid);
} elseif (!empty($cat)) {
    $hitokoto = get_rand_hitokoto('cat', $cat);
} elseif (!empty($userid)) {
    $hitokoto = get_rand_hitokoto('userid', $userid);
} else {
    $hitokoto = get_rand_hitokoto();
}

if ($charset != 'utf-8' && $charset != 'gbk') {
    $charset = 'utf-8';
}

switch ($encode) {
    case 'js':
        $content_type = 'text/javascript';
        $hitokoto = 'function hitokoto(){document.write("<span class=' . "'hitokoto' title='分类：" . $hitokoto['cat'] . ' 出自：' . $hitokoto['source'] . ' 投稿：湘竹枫绫 @ ' . $hitokoto['date'] . "'>" . $hitokoto['content'] . '</span>");}';
        break;
    case 'jsc':
        $content_type = 'text/javascript';
        $hitokoto = $fun . '(' . json_encode($hitokoto) . ');';
        break;
    case 'json':
        $content_type = 'application/json';        
        //计时结束.
        $hitokoto['use_time'] = runtime(1);
        $hitokoto = json_encode($hitokoto);
        break;
    default:
        $content_type = 'text/plain';
        if ($length != null) {
            $hitokoto = subtext($hitokoto['content'], $length);
        } else {
            $hitokoto = $hitokoto['content'];
        }

        break;
}

header('Access-Control-Allow-Origin: *');
header("Content-type: $content_type;charset=$charset");

echo $hitokoto;
 
function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length) {
        return mb_substr($text, 0, $length, 'utf8') . '...';
    } else {
        return $text;
    }

}

//计时函数 
function runtime($mode=0) {
 static $t; 
 if(!$mode) { 
  $t = microtime();
  return;
 } 
 $t1 = microtime(); 
 list($m0,$s0) = explode(" ",$t); 
 list($m1,$s1) = explode(" ",$t1); 
 return sprintf("%.3f ms",($s1+$m1-$s0-$m0)*1000);
}