<?php
/**
 * 注册相关（Register）
 *
 */
if (!defined('DIR'))exit('非法访问');

if (is_user_login()) {
    header('Location:/index.php');
}

//注册处理,判断数据是否来源注册页面
if (isset($_POST['register_check']) ? $_POST['register_check'] : null == 1) {
    //是否同意契约
    if (isset($_POST['contract']) ? $_POST['contract'] : null == 'on') {
        //获取信息
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $repassword = isset($_POST['repassword']) ? $_POST['repassword'] : null;

        //判断信息是否为空
        if (!empty($username) && !empty($password) && !empty($repassword)) {
            //判断密码与确认密码是否相同
            if ($password == $repassword) {
                //向数据库增加信息
                $db = new DB;
                $user_id = $db->get_userid_by_username($username);
                if (empty($user_id)) {
                    $result = $db->creat_user($username, $password);
                    if($result)
                    echo '<script>alert("成功签定契约");</script>';
                    else
                    echo '<script>alert("契约创建失败<_<");</script>';
                } else {
                    echo '<script>alert("契约已存在<_<");</script>';
                }
            } else {
                echo '<script>alert("两次密码不同<_<");</script>';
            }
        } else {
            echo '<script>alert("契约条件不具备<_<");</script>';
        }

    } else {
        echo '<script>alert("阁下还未同意契约书");</script>';
    }
}

get_header('注册');

?>
<p>注册页面</p>

<form method="post" action="?register">
    <p><label>账号：<input type="text" name="username"></label></p>
    <p><label>密码：<input type="password" name="password"></label></p>
    <p><label>确认密码：<input type="password" name="repassword"></label></p>
    <p><input name="contract" type="checkbox">已经阅读并同意<a href="">《契约》</a></p>
    <input type="submit" value="申请契约">
    <input type="hidden" name="register_check" value="1">
</form>
已经有契约了？<a href="/?login" >登录一下吧</a>
<?php get_footer();?>