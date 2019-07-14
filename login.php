<?php
/**
 * 登录相关
 *
 */
$title = '登录';
require_once 'load.php';
get_header();

if (is_user_login()) {
    echo '已登陆';
} else {
    if (isset($_POST['login']) ? $_POST['login'] : null == 1) {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if (!empty($username) && !empty($password)) {
            $db = new DB;
            $id = $db->get_id($username);
            if (!empty($id)) {
                $result = $db->check_user($username, $password);
                if ($result) {
                    echo '登录处理';
                    //验证用户名和密码成功后
                    $_SESSION['userinfo'] = array(
                        'id' => $id,
                        'username' => $username,
                    );
                    
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

    ?>
<p>登录页面</p>
<form method="post" action="login.php">
    <p><label>账号：<input type="text" name="username"></label></p>
    <p><label>密码：<input type="password" name="password"></p>
    <p><input name="remember" type="checkbox">记住登录(暂无用)</p>
    <input type="submit" value="提交">
    <input name="login" type="hidden" value="1">
</form>

<?php }
get_footer();?>