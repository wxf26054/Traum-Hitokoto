<?php
//MySQL、MySQLi、SQLite 三合一数据库操作类
if (!defined('DIR')) exit();

if (defined('DB_TYPE') == 'SQLITE') {
	require_once 'db.sqlite.class.php';
} elseif (defined('DB_TYPE') == 'MYSQL') {
	if (extension_loaded('mysqli')) {
		require_once 'db.mysqli.class.php';
	} else {
		// we use the old mysql
		require_once 'db.mysql.class.php';
	}
}
