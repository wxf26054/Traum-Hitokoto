<?php
/**
 * 数据库操作
 *
 */

class DB
{
    public function connection()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error($conn));
        }
        mysqli_set_charset($conn, DB_CHARSET);
        return $conn;
    }

    public function query($sql){
        $conn = $this->connection();
        $retval = mysqli_query($conn,$sql );
        if(! $retval )
        {
            die('数据库查询失败: ' . mysqli_error($conn));
        }
        return $retval;
    }

    public function creat_user($username, $password){
        $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')";
        $result = $this->query($sql);
        mysqli_close($this->connection());
        return $result;
    }

    public function get_userid_by_username($username){
        $sql = "SELECT * FROM `users` WHERE `username` LIKE '$username'";
        $result = $this->query($sql);
        $id = mysqli_fetch_assoc($result)['id'];
        mysqli_close($this->connection());
        return $id;
    }

    public function check_user($username, $password){
        $sql = "SELECT * FROM `users` WHERE `username` LIKE '$username' AND `password` LIKE '$password'";
        $result = $this->query($sql);
        $id = mysqli_fetch_assoc($result)['id'];
        mysqli_close($this->connection());
        return $id;
    }

    public function add_hitokoto($array_hitokoto,$userid){
        $conn = $this->connection();
        $sql = "INSERT INTO `hitokoto` (`id`, `content`, `cat`, `source`, `userid`, `author`, `date`) VALUES (NULL, '" . $array_hitokoto['content'] . "', '" . $array_hitokoto['cat'] . "', '" . $array_hitokoto['source'] . "', '$userid', '" . $array_hitokoto['author'] . "', '" . $array_hitokoto['date'] . "');";
        $retval = mysqli_query($conn,$sql );
        if(! $retval )
        {
            die('数据库查询失败: ' . mysqli_error($conn));
        }
        $tetval =  mysqli_query($conn,'SELECT LAST_INSERT_ID()');
        if(! $retval )
        {
            die('数据库查询失败: ' . mysqli_error($conn));
        }
        $result = mysqli_fetch_assoc($tetval);
        mysqli_close($conn);
        return $result;
    }

    public function get_user_sentences($userid, $page){
        $sql = "SELECT * FROM `hitokoto` WHERE `userid` LIKE '$userid' LIMIT " . 10*($page-1) . ",10";
        $result = $this->query($sql);
        $array_content = array();
        $id = 0;
        while($row = mysqli_fetch_assoc($result)){
            $array_content[$id++] = $row;
        }
        mysqli_free_result($result);
        mysqli_close($this->connection());
        return $array_content;
    }

    public function get_option_value($option_name){
        $sql = "SELECT `option_value` FROM `options` WHERE `option_name` LIKE '$option_name'";
        $result = mysqli_fetch_assoc($this->query($sql));
        mysqli_close($this->connection());
        return $result['option_value'];
    }

    public function delete_sentence($id){
        $sql = "DELETE FROM `hitokoto` WHERE `hitokoto`.`id` = $id";
        $result = $this->query($sql);
        mysqli_close($this->connection());
        return $result;
    }

    public function get_number_sentences($userid){
        $sql = "SELECT COUNT(*) FROM `hitokoto` WHERE `userid` = '$userid'"; 
        $result = array();
        $result = mysqli_fetch_assoc($this->query($sql));
        mysqli_close($this->connection());
        return $result['COUNT(*)'];
    }

    public function get_similar_sentence($keyword){
        $sql = "SELECT * FROM `hitokoto` WHERE `content` LIKE '%$keyword%' ";
        $query = $this->query($sql);
        $result = array();
        $i = 0;
        while($value = mysqli_fetch_assoc($query)){
            $result[$i++] = $value;
        }
        mysqli_close($this->connection());
        return $result;
    }

    public function get_hitokoto_by_id($hitokoto_id){
        $sql = "SELECT * FROM `hitokoto` WHERE `userid` LIKE '". $_SESSION['userinfo']['userid'] ."' AND `id` LIKE '$hitokoto_id'";
        $result = $this->query($sql);
        $array_content = array();
        $array_content = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($this->connection());
        return $array_content;
    }

    public function update_hitokoto($new_hitokoto){
        $sql = "UPDATE `hitokoto` SET `content` = '".$new_hitokoto['content']."', `cat` = '".$new_hitokoto['cat']."', `source` = '".$new_hitokoto['source']."' WHERE `hitokoto`.`id` = ".$new_hitokoto['id'];
        $result = $this->query($sql);
        mysqli_close($this->connection());
        return $result;
    }
}
