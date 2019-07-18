<?php
/**
 * 一言项目
 * 
 * 2019年7月13日 19点17分
 * 
 */
require( dirname( __FILE__ ) . '/load.php' );

if(isset($_GET['login'])){
    require 'template/login.php';
    exit;
}

if(isset($_GET['register'])){
    require 'template/register.php';
    exit;
}

if(isset($_GET['logout'])){
    require 'template/logout.php';
    exit;
}

if(isset($_GET['add'])){
    require 'template/add.php';
    exit;
}

require 'template/index.php';