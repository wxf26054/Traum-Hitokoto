<?php
//MySQL、MySQLi 二合一数据库操作类
if (!defined('DIR')) exit();

if (extension_loaded('mysqli')) {
	require_once 'db.mysqli.class.php';
} else {
	// we use the old mysql
	require_once 'db.mysql.class.php';
}
