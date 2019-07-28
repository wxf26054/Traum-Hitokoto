<?php

class DB
{
	var $link = null;

	function __construct()
	{
		global $siteurl;
		$this->link = new PDO('sqlite:' . ROOT . 'includes/sqlite/' . DB_SQLITE_FILE . '.db');
		if (!$this->link) die('Connection Sqlite failed.\n');
		return true;
	}

	function fetch($q)
	{
		return $q->fetch();
	}
	function get_row($q)
	{
		$sth = $this->link->query($q);
		return $sth->fetch();
	}
	function count($q)
	{
		$sth = $this->link->query($q);
		return $sth->fetchColumn();
	}
	function query($q)
	{
		return $this->result = $this->link->query($q);
	}
	function affected()
	{
		return $this->result->rowCount();
	}
	function error()
	{
		$error = $this->link->errorInfo();
		return '[' . $error[1] . '] ' . $error[2];
	}
}
