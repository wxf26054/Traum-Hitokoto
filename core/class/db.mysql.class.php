<?php

class DB
{
    var $link = null;

    function __construct()
    {

        $this->link = @mysql_connect(DB_HOST . ':' . DB_PORT, DB_USER, DB_PASS);

        if (!$this->link) die('Connect Error (' . mysql_errno() . ') ' . mysql_error());

        mysql_select_db(DB_NAME, $this->link) or die(mysql_error($this->link));

        mysql_query("set sql_mode = ''");
        //字符转换，读库
        mysql_query("set character set 'utf8'");
        //写库
        mysql_query("set names 'utf8'");

        return true;
    }
    function fetch($q)
    {
        return mysql_fetch_assoc($q);
    }
    function get_row($q)
    {
        $result = mysql_query($q, $this->link);
        return mysql_fetch_assoc($result);
    }
    function count($q)
    {
        $result = mysql_query($q, $this->link);
        $count = mysql_fetch_array($result);
        return $count[0];
    }
    function query($q)
    {
        return mysql_query($q, $this->link);
    }
    function escape($str)
    {
        return mysql_real_escape_string($str, $this->link);
    }
    function affected()
    {
        return mysql_affected_rows($this->link);
    }
    function insert($q)
    {
        if (mysql_query($q, $this->link))
            return mysql_insert_id($this->link);
        return false;
    }
    function insert_array($table, $array)
    {
        $q = "INSERT INTO `$table`";
        $q .= " (`" . implode("`,`", array_keys($array)) . "`) ";
        $q .= " VALUES ('" . implode("','", array_values($array)) . "') ";

        if (mysql_query($q, $this->link))
            return mysql_insert_id($this->link);
        return false;
    }
    function error()
    {
        $error = mysql_error($this->link);
        $errno = mysql_errno($this->link);
        return '[' . $errno . '] ' . $error;
    }
    function close()
    {
        $q = mysql_close($this->link);
        return $q;
    }
}
