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

function get_rand_hitokoto($type = null, $value1 = null, $value2 = null)
    {
        //判断请求类型
        switch ($type) {
            case 'cat':
                $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE cat = '$value1'";
                $sql_id = "SELECT id FROM hitokoto WHERE cat = '$value1'";
                break;
            case 'userid':
                $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE userid = '$value1'";
                $sql_id = "SELECT id FROM hitokoto WHERE userid = '$value1'";
                break;
            case 'cat-userid':
                $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE cat = '$value1' AND userid = '$value2'";
                $sql_id = "SELECT id FROM hitokoto WHERE cat = '$value1' AND userid = '$value2'";
                break;
            default:
                $sql_count = "SELECT COUNT(*) FROM hitokoto";
                $sql_id = "SELECT id FROM hitokoto";
                break;
        }

        $db = new DB;

        //获取数据总数
        $num = $db->fetch($db->query($sql_count))['COUNT(*)'];

        //获得随机数
        $rand_id = mt_rand(1,$num);
        
        $get_id = $db->query($sql_id);

        //定义初始变量i为0
        $i = 0;
        $array_id = array();

        //把所有数据按从1开始重新编号
        while ($row = $db->fetch($get_id)){
            $array_id[++$i] = $row['id'];
        }
        
        //accesses加1
        $db->query("UPDATE hitokoto set accesses=accesses+1 where id = $array_id[$rand_id]");
        $db->query("UPDATE `data` SET `data_value` = data_value + 1 WHERE `data`.`data_id` = 1 ");

        //根据  取出的随机编号所对应的id  取得数据
        $sql = "SELECT * FROM hitokoto WHERE id = $array_id[$rand_id]";
        $result = $db->fetch($db->query($sql));
        $db->close();
        return $result;
    }