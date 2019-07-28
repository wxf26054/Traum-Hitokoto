<?php

/**
 * 数据库操作
 *
 */
//include 'class/db.mysqli.class.php';
function creat_user($username, $password)
{
    $db = new DB;
    $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')";
    $result = $db->query($sql);
    $db->close();
    return $result;
}

function get_userid_by_username($username)
{
    $db = new DB;
    $sql = "SELECT * FROM `users` WHERE `username` LIKE '$username'";
    $result =  $db->query($sql);
    $id = $db->fetch($result)['id'];
    $db->close();
    return $id;
}

function check_user($username, $password)
{
    $db = new DB;
    $sql = "SELECT * FROM `users` WHERE `username` LIKE '$username' AND `password` LIKE '$password'";
    $result = $db->query($sql);
    $id = $db->fetch($result)['id'];
    $db->close();
    return $id;
}

function add_hitokoto($array_hitokoto, $userid)
{
    $db = new DB;
    if ($array_hitokoto['date'] != null)
        $sql = "INSERT INTO `hitokoto` (`id`, `content`, `cat`, `source`, `userid`, `author`, `date`) VALUES (NULL, '" . $array_hitokoto['content'] . "', '" . $array_hitokoto['cat'] . "', '" . $array_hitokoto['source'] . "', '$userid', '" . $array_hitokoto['author'] . "', '" . $array_hitokoto['date'] . "');";
    else
        $sql = "INSERT INTO `hitokoto` (`id`, `content`, `cat`, `source`, `userid`, `author`) VALUES (NULL, '" . $array_hitokoto['content'] . "', '" . $array_hitokoto['cat'] . "', '" . $array_hitokoto['source'] . "', '$userid', '" . $array_hitokoto['author'] . "');";

    $result = $db->insert($sql);
    $db->close();
    return $result;
}

function get_user_sentences($userid, $page)
{
    $db = new DB;
    $sql = "SELECT * FROM `hitokoto` WHERE `userid` LIKE '$userid' LIMIT " . 10 * ($page - 1) . ",10";
    $result =  $db->query($sql);
    if(!$result)
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

function get_option_value($option_name)
{
    $db = new DB;
    $sql = "SELECT `option_value` FROM `options` WHERE `option_name` LIKE '$option_name'";
    $result = $db->fetch($db->query($sql));
    $db->close();
    return $result['option_value'];
}

function delete_sentence($id)
{
    $db = new DB;
    $sql = "DELETE FROM `hitokoto` WHERE `hitokoto`.`id` = $id";
    $result =  $db->query($sql);
    $db->close();
    return $result;
}

function get_number_sentences($userid)
{
    $db = new DB;
    $sql = "SELECT COUNT(*) FROM `hitokoto` WHERE `userid` = '$userid'";
    $result = array();
    $result = $db->fetch($db->query($sql));
    $db->close();
    return $result['COUNT(*)'];
}

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

function get_hitokoto_by_id($hitokoto_id)
{
    $db = new DB;
    $sql = "SELECT * FROM `hitokoto` WHERE `userid` LIKE '" . $_SESSION['userinfo']['userid'] . "' AND `id` LIKE '$hitokoto_id'";
    $result =  $db->query($sql);
    $array_content = array();
    $array_content = $db->fetch($result);
    mysqli_free_result($result);
    $db->close();
    return $array_content;
}

function update_hitokoto($new_hitokoto)
{
    $db = new DB;
    $sql = "UPDATE `hitokoto` SET `content` = '" . $new_hitokoto['content'] . "', `cat` = '" . $new_hitokoto['cat'] . "', `source` = '" . $new_hitokoto['source'] . "' WHERE `hitokoto`.`id` = " . $new_hitokoto['id'];
    $result =  $db->query($sql);
    $db->close();
    return $result;
}
