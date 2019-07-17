<?php
/**
 * 一言项目
 * 
 * 2019年7月13日 19点17分
 * 
 */
require( dirname( __FILE__ ) . '/load.php' );
//require( dirname( __FILE__ ) . '/template/index.php' );

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

require 'template/index.php';