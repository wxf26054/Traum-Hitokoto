<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title; ?></title>
</head>
<body>
<p>这是头部</p>
<p>
<?php 
if(empty($_SESSION['userinfo']))
echo '未登录';
else
echo '用户名：'.$_SESSION['userinfo']['username'];
?>
</p>