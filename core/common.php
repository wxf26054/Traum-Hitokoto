<?php

//调用数据库信息
require_once 'database.php';
//调用数据库处理函数库
require_once 'database_query.php';

function get_header($title = '一言')
{
    require DIR . '/template/header.php';
}

function get_footer()
{
    require DIR . '/template/footer.php';
}

function is_user_login(){
    if(empty($_SESSION['userinfo']) || empty($_SESSION['userinfo']['id'])){
        //未登录，引导登录
        return false;
      }else
       return true;
}

function loginOut(){
    unset($_SESSION['userinfo']);
    // header('Location : /index.php');
}
