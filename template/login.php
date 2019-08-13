<?php
/**
 * 登录相关
 *
 */

if (!defined('DIR'))exit('非法访问');

if (is_user_login()) {
    header('Location: /index.php');
    exit;
}

//判断是否为登录页面提交的表单
if (isset($_POST['loginpage_check']) ? $_POST['loginpage_check'] : null == 1) {
    require( DIR . '/core/class/passhash.class.php');
    //获取提交的用户名
    $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : null;
    //获取提交的密码
    $user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : null;
    //判断提交的数据是否为空
    if (!empty($user_login) && !empty($user_pass)) {
        //非空输出
        $user_info = get_userinfo_by_user_login($user_login);
        if (!empty($user_info)) {
            if (PassHash::check_password($user_info['user_pass'], $user_pass)) {
                //验证用户名和密码成功后
                $_SESSION['userinfo'] = array(
                    'userid' => $user_info['uid'],
                    'user_login' => $user_info['user_login'],
                    'display_name' => $user_info['display_name'],
                );
                header('Location: /index.php');
            } else {
                echo '契约错误';
            }

        } else {
            echo '<script>alert("契约不存在<_<");</script>';
        }
    } else {
        echo '<script>alert("信息不能为空");</script>';
    }

}

get_header('登录');
?>
<p>登录页面</p>
<form method="post" action="">
    <p><label>登录名：<input type="text" name="user_login" required></label></p>
    <p><label>密码：<input type="password" name="user_pass" required></p>
    <p><input name="remember" type="checkbox">记住登录(暂无用)</p>
    <input type="submit" value="提交">
    <input name="loginpage_check" type="hidden" value="1">
</form>
没有契约？<a href="/register<?php echo URL_NAME;?>" >签一个吧</a>
<?php
get_footer();?>