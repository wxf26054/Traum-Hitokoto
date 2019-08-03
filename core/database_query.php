<?php

/**
 * 数据库操作
 *
 */
//include 'class/db.mysqli.class.php';

//创建用户
function create_user($user_info)
{
    $db = new DB;
    $sql = "INSERT INTO `users` (`user_login`, `user_nickname`, `user_email`, `user_pass`) VALUES ('" . $user_info['user_login'] . "', '" . $user_info['user_nickname'] . "', '" . $user_info['user_email'] . "', '" . $user_info['user_pass'] . "')";
    $result = $db->query($sql);
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
    $sql = "SELECT * FROM `users` WHERE `id` LIKE '$user_id'";
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
    while ($value = mysqli_fetch_assoc($query)) {
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

//更新hitokoto
function update_hitokoto($new_hitokoto)
{
    $db = new DB;
    $sql = "UPDATE `hitokoto` SET `content` = '" . $new_hitokoto['content'] . "', `cat` = '" . $new_hitokoto['cat'] . "', `source` = '" . $new_hitokoto['source'] . "' WHERE `hitokoto`.`id` = " . $new_hitokoto['id'];
    $result =  $db->query($sql);
    $db->close();
    return $result;
}
