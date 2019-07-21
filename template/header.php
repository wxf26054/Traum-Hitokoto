<!DOCTYPE HTML>
<html>
<head>
<meta charset='utf-8' />
<title><?php echo $title; ?></title>
</head>
<body>
<p>
<a href="/" >首页</a>|<a href="/?add" >添加句子</a>|<a href="/?my-sentences" >我的句子</a>
<?php 
if(empty($_SESSION['userinfo']))
echo '未<a href="/?login" >登录</a>';
else
echo '欢迎'.$_SESSION['userinfo']['username'].'  <a href="/?logout" >登出</a>';
?>
</p>