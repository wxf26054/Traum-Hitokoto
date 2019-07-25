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

    //type类型：cat--类别，userid--用户id，cat-userid--类别和用户id
    public function get_rand_hitokoto($type = null, $value1 = null, $value2 = null)
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

        //获取数据总数
        $num = mysqli_fetch_assoc($this->query($sql_count))['COUNT(*)'];

        //获得随机数
        $rand_id = mt_rand(1,$num);
        
        $get_id = $this->query($sql_id);

        //定义初始变量i为0
        $i = 0;
        $array_id = array();

        //把所有数据按从1开始重新编号
        while ($row = mysqli_fetch_assoc($get_id)){
            $array_id[++$i] = $row['id'];
        }
        
        //accesses加1
        $this->query("UPDATE hitokoto set accesses=accesses+1 where id = $array_id[$rand_id]");
        $this->query("UPDATE `data` SET `data_value` = data_value + 1 WHERE `data`.`data_id` = 1 ");

        //根据  取出的随机编号所对应的id  取得数据
        $sql = "SELECT * FROM hitokoto WHERE id = $array_id[$rand_id]";
        $result = mysqli_fetch_assoc($this->query($sql));
        mysqli_close($this->connection());
        return $result;
    }
}
