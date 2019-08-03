<?php

/**
 * API
 * 
 */

//计时开始
runtime();

require_once '../load.php';

$cat = isset($_GET['cat']) ? $_GET['cat'] : null;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$charset = isset($_GET['charset']) ? $_GET['charset'] : null;
$encode = isset($_GET['encode']) ? $_GET['encode'] : null;
$fun = isset($_GET['fun']) ? $_GET['fun'] : null;
$length = isset($_GET['length']) ? $_GET['length'] : null;


if ($user_id && empty(get_userinfo_by_user_id($user_id)))
    $hitokoto = array('states' => 'error', 'message' => 'user not found');
else {
    if (!empty($cat) && !empty($user_id)) {
        //获取分类并转为数组(get category and transform to array)
        $cat = get_option_value('cat');
        $array_cat = json_decode($cat, true);
        if(!empty($array_cat[$cat]))
            $hitokoto = get_rand_hitokoto('cat-userid', $cat, $user_id);
        else 
            $hitokoto = array('states' => 'error', 'message' => 'cat not found');
    } elseif (!empty($cat)) {
        //获取分类并转为数组(get category and transform to array)
        $cat = get_option_value('cat');
        $array_cat = json_decode($cat, true);
        if(!empty($array_cat[$cat]))
            $hitokoto = get_rand_hitokoto('cat', $cat);
        else 
            $hitokoto = array('states' => 'error', 'message' => 'cat not found');
    } elseif (!empty($user_id)) {
        $hitokoto = get_rand_hitokoto('userid', $user_id);
    } else {
        $hitokoto = get_rand_hitokoto();
    }
}

if ($charset != 'utf-8' && $charset != 'gbk') {
    $charset = 'utf-8';
}

switch ($encode) {
    case 'js':
        $content_type = 'text/javascript';
        $hitokoto = 'function hitokoto(){document.write("<span class=' . "'hitokoto' title='分类：" . $hitokoto['cat']['name'] . ' 出自：' . $hitokoto['source'] . ' 投稿：' . $hitokoto['author'] . ' @ ' . $hitokoto['date'] . "'>" . $hitokoto['content'] . '</span>");}';
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
function runtime($mode = 0)
{
    static $t;
    if (!$mode) {
        $t = microtime();
        return;
    }
    $t1 = microtime();
    list($m0, $s0) = explode(" ", $t);
    list($m1, $s1) = explode(" ", $t1);
    return sprintf("%.3f ms", ($s1 + $m1 - $s0 - $m0) * 1000);
}
