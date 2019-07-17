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
            die('Could not connect: ' . mysqli_error());
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
        return $result;
    }

    public function get_id($username){
        $sql = "SELECT * FROM `users` WHERE `username` LIKE '$username'";
        $result = $this->query($sql);
        $id = mysqli_fetch_array($result)['id'];
        return $id;
    }

    public function check_user($username, $password){
        $sql = "SELECT * FROM `users` WHERE `username` LIKE '$username' AND `password` LIKE '$password'";
        $result = $this->query($sql);
        $id = mysqli_fetch_array($result)['id'];
        if(!empty($id))
        return true;
        else 
        return false;
    }
}
