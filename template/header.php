<!DOCTYPE HTML>
<html>
<head>
<title><?php global $title;echo $title; ?></title>
</head>
<body>
<p>这是头部</p>
<p>用户名：<?php if(!empty($_SESSION['userinfo']))echo $_SESSION['userinfo']['username']?></p>