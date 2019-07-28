<?php
//MySQL、MySQLi、SQLite 三合一数据库操作类
if (!defined('IN_CRONLITE')) exit();

$nomysqli = false;

if (defined('SQLITE') == true) {
	require_once 'db.sqlite.class.php';
} elseif (extension_loaded('mysqli') && $nomysqli == false) {
	require_once 'db.mysqli.class.php';
} else {
	// we use the old mysql
	require_once 'db.mysql.class.php';
}
