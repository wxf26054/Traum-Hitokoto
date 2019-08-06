<?php if (!defined('DIR')) exit('非法访问'); 

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset='utf-8' />
    <title><?php echo $title . '|Hitokoto/ヒトコト'; ?></title>
    <script src="//upcdn.b0.upaiyun.com/libs/jquery/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />
</head>

<body>
    <p>
        <a href="/">茵蒂克丝</a>|<a href="/add<?php echo URL_NAME; ?>">添加句子</a>|<a href="/my_hitokoto<?php echo URL_NAME; ?>">我的句子</a>|<a href="/doc<?php echo URL_NAME; ?>">API文档</a>|<a href="/update_log<?php echo URL_NAME; ?>">更新记录</a>
        <?php
        if (empty($_SESSION['userinfo']))
            echo '未<a href="/login' . URL_NAME . '" >登录</a>';
        else
            echo '欢迎' . $_SESSION['userinfo']['display_name'] . '  <a href="/logout' . URL_NAME . '" >登出</a>';
        ?>
    </p>