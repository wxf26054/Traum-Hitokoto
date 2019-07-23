<?php

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

    public function query($sql)
    {
        $conn = $this->connection();
        $retval = mysqli_query($conn, $sql);
        if (!$retval) {
            die('数据库查询失败: ' . mysqli_error($conn));
        }
        return $retval;
    }

    public function get_hitokoto_num($type = null, $value1 = null, $value2 = null)
    {
        switch ($type) {
            case 'cat':
                $sql = "";
                break;
            case 'userid':
                $sql = "";
                break;
            case 'cat-userid':
                $sql = "";
                break;
        }
    }

    public function get_rand_hitokoto($type = null, $value1 = null, $value2 = null)
    {
        switch ($type) {
            case 'cat':
                $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE cat = '$value1'";
                break;
            case 'userid':
                $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE userid = '$value2'";
                break;
            case 'cat-userid':
                $sql_count = "SELECT COUNT(*) FROM hitokoto WHERE cat = '$value1' AND userid = '$value2'";
                break;
            default:
                $sql_count = "SELECT COUNT(*) FROM hitokoto";
                break;
        }
        $num = mysqli_fetch_assoc($this->query($sql_count))['COUNT(*)'];

        $rand_id = mt_rand(1,$num);
        
        switch ($type) {
            case 'cat':
                $sql = "SELECT id FROM hitokoto WHERE cat = '$value1'";
                break;
            case 'userid':
                $sql = "SELECT id FROM hitokoto WHERE userid = '$value2'";
                break;
            case 'cat-userid':
                $sql = "SELECT id FROM hitokoto WHERE cat = '$value1' AND userid = '$value2'";
                break;
            default:
                $sql = "SELECT id FROM hitokoto";
                break;
        }
        $get_id = $this->query($sql);
        $i = 0;
        $array_id = array();
        while ($row = mysqli_fetch_assoc($get_id)){
            $array_id[++$i] = $row['id'];
        }
        $sql = "SELECT * FROM hitokoto WHERE id = $array_id[$rand_id]";
        $this->query("UPDATE hitokoto set accesses=accesses+1 where id = $array_id[$rand_id]");
        $result = mysqli_fetch_assoc($this->query($sql));
        mysqli_close($this->connection());
        return $result;
    }
}
