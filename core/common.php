<?php

//调用数据库信息
require_once 'database.php';
//调用数据库处理函数库
require_once 'database_query.php';

function get_header($title = '一言')
{
    require DIR . '/template/header.php';
}

function get_footer()
{
    require DIR . '/template/footer.php';
}

function is_user_login()
{
    if (empty($_SESSION['userinfo']) || empty($_SESSION['userinfo']['userid'])) {
        //未登录，引导登录
        return false;
    } else {
        return true;
    }

}

function loginOut()
{
    unset($_SESSION['userinfo']);
    // header('Location : /index.php');
}

function mb_str_split($str, $count)
{
    $leng = strlen($str) / 3; //中文长度
    $arr = array();
    for ($i = 0; $i < $leng; $i += $count) {
        $arr[] = mb_substr($str, $i, $count);
    }
    return $arr;
}

function check_hitokoto_similarity($hitokoto)
{
    $db = new DB;
    //检查相似度，将句子按3个字一组分割(包括标点符号)
    $aray_split_sentence = mb_str_split($hitokoto, 3);
    foreach ($aray_split_sentence as $value1) {
        $result = $db->get_similar_sentence($value1);
        foreach ($result as $key => $value) {
            //similar_text() 函数计算比较两个字符串的相似度
            similar_text($hitokoto, $value['content'], $percent);
            //相似度大于50为找到[Similarity greater than 50 is found]
            if ($percent > 50) {
                return 'ID:' . $value['id'] . ' => ' . $value['content'] . '&nbsp;&nbsp;&nbsp;&nbsp;相似度' . $percent . '%<br />';
            }
        }
    }
    return false;
}
