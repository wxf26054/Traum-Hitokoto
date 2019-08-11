<?php

/**
 * 数据库操作
 *
 */

//创建用户
function create_user($user_info)
{
    $db = new DB;
    $array_userinfo = array(
        'user_login' => $user_info['user_login'],
        'display_name' => $user_info['display_name'],
        'user_email' => $user_info['user_email'],
        'user_pass' => $user_info['user_pass'],
    );
    $result = $db->insert_array('users', $array_userinfo);
    if (!$result) {
        echo $db->error();
        exit;
    }
    $db->close();
    return $result;
}

//根据用户名获取用户信息
function get_userinfo_by_user_login($user_login)
{
    $db = new DB;
    $sql = "SELECT * FROM `users` WHERE `user_login` LIKE '$user_login'";
    $result =  $db->query($sql);
    $user_info = $db->fetch($result);
    $db->close();
    return $user_info;
}

//根据 用户id 获取用户信息
function get_userinfo_by_user_id($user_id)
{
    $db = new DB;
    $sql = "SELECT * FROM `users` WHERE `uid` LIKE '$user_id'";
    $result =  $db->query($sql);
    $user_info = $db->fetch($result);
    $db->close();
    return $user_info;
}

//检查用户是否存在
function check_user($user_login, $user_pass)
{
    $db = new DB;
    $sql = "SELECT * FROM `users` WHERE `user_login` LIKE '$user_login' AND `user_pass` LIKE '$user_pass'";
    $result = $db->query($sql);
    $id = $db->fetch($result)['id'];
    $db->close();
    return $id;
}

//添加hitokoto
function add_hitokoto($array_hitokoto)
{
    $db = new DB;
    if ($array_hitokoto['date'] != null)
        $sql = "INSERT INTO `hitokoto` (`id`, `content`, `cat`, `source`, `user_id`, `author`, `date`) VALUES (NULL, '" . $array_hitokoto['content'] . "', '" . $array_hitokoto['cat'] . "', '" . $array_hitokoto['source'] . "', '" . $array_hitokoto['user_id'] . "', '" . $array_hitokoto['author'] . "', '" . $array_hitokoto['date'] . "');";
    else
        $sql = "INSERT INTO `hitokoto` (`id`, `content`, `cat`, `source`, `user_id`, `author`) VALUES (NULL, '" . $array_hitokoto['content'] . "', '" . $array_hitokoto['cat'] . "', '" . $array_hitokoto['source'] . "', '" . $array_hitokoto['user_id'] . "', '" . $array_hitokoto['author'] . "');";

    $result = $db->insert($sql);
    $db->close();
    return $result;
}

//取得指定页数的用户的hitokoto
function get_user_hitokoto_by_page($userid, $page)
{
    $db = new DB;
    $sql = "SELECT * FROM `hitokoto` WHERE `user_id` LIKE '$userid' LIMIT " . 10 * ($page - 1) . ",10";
    $result =  $db->query($sql);
    if (!$result)
        return false;
    $array_content = array();
    $id = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $array_content[$id++] = $row;
    }
    mysqli_free_result($result);
    $db->close();
    return $array_content;
}

//获取数据库中指定  option name  的值
function get_option_value($option_name)
{
    $db = new DB;
    $sql = "SELECT `option_value` FROM `options` WHERE `option_name` LIKE '$option_name'";
    $result = $db->fetch($db->query($sql));
    $db->close();
    return $result['option_value'];
}

//获取数据库中指定  data name  的值
function get_data_value($data_name)
{
    $db = new DB;
    $sql = "SELECT `data_value` FROM `data` WHERE `data_name` = '$data_name'";
    $result = $db->fetch($db->query($sql));
    $db->close();
    return $result['data_value'];
}

//删除指定id的hitokoto
function delete_sentence($id)
{
    $db = new DB;
    $sql = "DELETE FROM `hitokoto` WHERE `hitokoto`.`id` = $id";
    $result =  $db->query($sql);
    $db->close();
    return $result;
}

//获取(指定用户的) hitokoto 数量
function get_hitokoto_number($userid = null)
{
    $db = new DB;
    $sql = "SELECT COUNT(*) FROM `hitokoto`";
    if ($userid != null) $sql .= "WHERE `user_id` = $userid";
    $result = array();
    $result = $db->fetch($db->query($sql));
    $db->close();
    return $result['COUNT(*)'];
}

//使用部分字词获取相似hitokoto
function get_similar_sentence($keyword)
{
    $db = new DB;
    $sql = "SELECT * FROM `hitokoto` WHERE `content` LIKE '%$keyword%' ";
    $query =  $db->query($sql);
    $result = array();
    $i = 0;
    while ($value = $db->fetch($query)) {
        $result[$i++] = $value;
    }
    $db->close();
    return $result;
}

//根据 hitokoto id 获取hitokoto的数据
function get_hitokoto_by_id($hitokoto_id)
{
    $db = new DB;
    $sql = "SELECT * FROM `hitokoto` WHERE `id` = $hitokoto_id";
    $result =  $db->query($sql);
    $array_content = array();
    $array_content = $db->fetch($result);
    mysqli_free_result($result);
    $db->close();
    return $array_content;
}

//Update hitokoto
function update_hitokoto($new_hitokoto)
{
    $db = new DB;
    $sql = "UPDATE `hitokoto` SET `content` = '" . $new_hitokoto['content'] . "', `cat` = '" . $new_hitokoto['cat'] . "', `source` = '" . $new_hitokoto['source'] . "' WHERE `hitokoto`.`id` = " . $new_hitokoto['id'];
    $result =  $db->query($sql);
    $db->close();
    return $result;
}

//record visit event
function visit_record($visitor, $visit_time)
{
    //delete out date data
    delete_outdate_visit();


    $db = new DB;
    $array_visit = array(
        'visitor' => $visitor,
        'visit_time' => $visit_time,
    );

    $result = $db->insert_array('visit', $array_visit);
    if ($result) {
        $db->close();
        return true;
    } else
        exit($db->error());
}

//in $in_time seconds.
function visit_read($in_time)
{
    $time = $_SERVER['REQUEST_TIME'] - $in_time;
    $db = new DB;
    $query = $db->query("SELECT * FROM `visit` WHERE `visit_time` > $time ");
    $visitor = array();
    while ($fetch = $db->fetch($query)) {
        //统计
        if (isset($visitor[$fetch['visitor']])) {
            $visitor[$fetch['visitor']]['times']++;
        } else {
            $visitor[$fetch['visitor']] = array('times' => 1);
        }
    }

    //今天的全部请求数
    $all_hit = $db->count('SELECT count(*) FROM `visit` WHERE `visit`.`visit_time` > ' . ($_SERVER['REQUEST_TIME'] - 86400));

    $result = array(
        'visit_details' => $visitor,
        'all_hit' => $all_hit,
    );
    return $result;
}

//删除今天零点之前的数据(Delete data older than 00:00:00 today)
function delete_outdate_visit()
{
    $db = new DB;
    $sql = 'DELETE FROM `visit` WHERE `visit`.`visit_time` < ' . strtotime(date('Y-m-d', time()));;
    $result = $db->query($sql);
    if (!$result)
        exit($db->error());
    $db->close();
    return true;
}

function allow_visitor($visitor)
{
    if ($visitor == '直接访问' || is_visitor_vip($visitor))
        return true;
    $db = new DB;
    $sql = "SELECT count(*) FROM `visit` WHERE `visit`.`visitor` = '$visitor' AND `visit`.`visit_time` > " . ($_SERVER['REQUEST_TIME'] - 60);
    $count = $db->count($sql);
    if ($count <= get_option_value('visit_times_minute'))
        return true;
    else
        return false;
}

function is_visitor_vip($visitor)
{
    
    $db = new DB;
    $sql = "SELECT COUNT(*) FROM `user_meta` WHERE `user_meta`.`meta_key` = 'whitelist' AND `user_meta`.`meta_value` = '$visitor'";
    if ($db->count($sql))
        return true;
    else
        return false;
}
