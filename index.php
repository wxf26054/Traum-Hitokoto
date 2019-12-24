<?php
/**
 * 一言项目
 *
 * 2019年11月16日 21点39分
 *
 */
$urlarr = parse_url($_SERVER["REQUEST_URI"]);

require dirname(__FILE__) . '/load.php';

$start = new DB();
$start->close();

captcha_init();

//URL处理
switch ($urlarr['path']) {
    case '/login' . URL_NAME:
        require 'template/login.php';
        exit;
        break;
    case '/register' . URL_NAME:
        require 'template/register.php';
        exit;
        break;
    case '/logout' . URL_NAME:
        require 'template/logout.php';
        exit;
        break;
    case '/add' . URL_NAME:
        require 'template/add.php';
        exit;
        break;
    case '/edit' . URL_NAME:
        require 'template/edit.php';
        exit;
        break;
    case '/my_hitokoto' . URL_NAME:
        require 'template/my_hitokoto.php';
        exit;
        break;
    case '/doc' . URL_NAME:
        require 'template/doc.php';
        exit;
        break;
    case '/add' . URL_NAME:
        require 'template/add.php';
        exit;
        break;
    case '/update_log' . URL_NAME:
        require 'template/update_log.php';
        exit;
        break;
    case '/plugin' . URL_NAME:
        switch ($_GET['plugin']) {
            case 'insert':
                require 'plugins/insert.php';
                exit;
                break;
            default:
                require 'plugins/index.php';
                exit;
                break;
        }
        break;
    default:
        require 'template/index.php';
        break;
}
