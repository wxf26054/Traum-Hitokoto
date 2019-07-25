<?php
/**
 * API
 */
require_once '../core/database.php';
require_once 'api_db_query.php';

$db = new DB;
$cat = isset($_GET['cat']) ? $_GET['cat'] : null;
$userid = isset($_GET['userid']) ? $_GET['userid'] : null;
$charset = isset($_GET['charset']) ? $_GET['charset'] : null;
$encode = isset($_GET['encode']) ? $_GET['encode'] : null;
$fun = isset($_GET['fun']) ? $_GET['fun'] : null;
$length = isset($_GET['length']) ? $_GET['length'] : null;

if (!empty($cat) && !empty($userid)) {
    $hitokoto = $db->get_rand_hitokoto('cat-userid', $cat, $userid);
} elseif (!empty($cat)) {
    $hitokoto = $db->get_rand_hitokoto('cat', $cat);
} elseif (!empty($userid)) {
    $hitokoto = $db->get_rand_hitokoto('userid', $userid);
} else {
    $hitokoto = $db->get_rand_hitokoto();
}

if ($charset != 'utf-8' && $charset != 'gbk') {
    $charset = 'utf-8';
}

function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length) {
        return mb_substr($text, 0, $length, 'utf8') . '...';
    } else {
        return $text;
    }

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

header("Content-type: $content_type;charset=$charset");

echo $hitokoto;
