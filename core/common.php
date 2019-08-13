<?php

//调用数据库信息
require_once 'config.php';
//调用数据库处理函数库
require_once 'class/db.class.php';
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

//检查相似度
function check_hitokoto_similarity($hitokoto)
{
    //检查相似度，将句子按3个字一组分割(包括标点符号)
    $aray_split_sentence = mb_str_split($hitokoto, 3);
    foreach ($aray_split_sentence as $value1) {
        $result = get_similar_sentence($value1);
        foreach ($result as $key => $value) {
            //similar_text() 函数计算比较两个字符串的相似度
            similar_text($hitokoto, $value['content'], $percent);
            //相似度大于50为找到[Similarity greater than 50 is found]
            if ($percent > 50) {
                $value['percent'] = $percent;
                return $value;
            }
        }
    }
    return false;
}

//根据条件随机获取hitokoto
function get_rand_hitokoto($type = null, $value1 = null, $value2 = null)
{
    $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE ";
    $sql_id = "SELECT id FROM hitokoto WHERE ";
    
    //判断请求类型
    switch ($type) {
        case 'cat':
            $sql_count .= "cat = '$value1'";
            $sql_id .= "cat = '$value1'";
            break;
        case 'userid':
            $sql_count .= "userid = '$value1'";
            $sql_id .= "userid = '$value1'";
            break;
        case 'cat-userid':
            $sql_count .= "cat = '$value1' AND userid = '$value2'";
            $sql_id .= "cat = '$value1' AND userid = '$value2'";
            break;
        default:
            $sql_count = "SELECT COUNT(*) FROM hitokoto";
            $sql_id = "SELECT id FROM hitokoto";
            break;
    }

    $db = new DB;

    //获取数据总数
    $query_num = $db->query($sql_count);
    if ($query_num) {
        $num = $db->fetch($query_num)['COUNT(*)'];
    } else {
        return array('states' => 'error', 'message' => 'this user don`t have any hitokoto');
    }

    //根据总数获得一个随机数
    $rand_id = mt_rand(1, $num);

    $get_id = $db->query($sql_id);

    //定义初始变量i为0
    $i = 0;
    $array_id = array();

    //把所有数据按从1开始重新编号
    while ($row = $db->fetch($get_id)) {
        $array_id[++$i] = $row['id'];
    }

    //accesses追加1
    //$db->query("UPDATE hitokoto set accesses=accesses+1 where id = $array_id[$rand_id]");     //用于检测算法的随机性
    $db->query("UPDATE `data` SET `data_value` = data_value + 1 WHERE `data`.`data_name` = 'all_accesses' ");
    $db->close();

    //根据  取出的随机编号所对应的id  取得数据
    
    $result = get_hitokoto_by_id($array_id[$rand_id]);

    $result['states'] = 'success';
    return $result;
}