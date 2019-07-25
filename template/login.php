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
if (isset($_POST['login']) ? $_POST['login'] : null == 1) {
    //获取提交的用户名
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    //获取提交的密码
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    //判断提交的数据是否为空
    if (!empty($username) && !empty($password)) {
        //非空输出
        $db = new DB;
        $user_id = $db->get_userid_by_username($username);
        if (!empty($user_id)) {
            $result = $db->check_user($username, $password);
            if (!empty($result)) {
                //验证用户名和密码成功后
                $_SESSION['userinfo'] = array(
                    'userid' => $user_id,
                    'username' => $username,
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
<form method="post" action="?login">
    <p><label>账号：<input type="text" name="username"></label></p>
    <p><label>密码：<input type="password" name="password"></p>
    <p><input name="remember" type="checkbox">记住登录(暂无用)</p>
    <input type="submit" value="提交">
    <input name="login" type="hidden" value="1">
</form>
没有契约？<a href="/?register" >签一个吧</a>
<?php
get_footer();?>