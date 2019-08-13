<?php

/**
 * 注册相关（Register）
 *
 */
if (!defined('DIR')) exit('非法访问');

if (is_user_login()) {
    header('Location:/index.php');
}

//注册处理,判断数据是否来源注册页面
if (isset($_POST['register_check']) ? $_POST['register_check'] : null == 1) {
    require( DIR . '/core/class/passhash.class.php');
    //是否同意契约
    if (isset($_POST['contract']) ? $_POST['contract'] : null == 'on') {
        //验证码正误判断
        //if (security_question_validate()) {
            //获取信息
            $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : null;
            $display_name = isset($_POST['display_name']) ? $_POST['display_name'] : null;
            $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : null;
            $user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : null;
            $user_repass = isset($_POST['user_repass']) ? $_POST['user_repass'] : null;

            //判断信息是否为空
            if (!empty($user_login) && !empty($user_pass) && !empty($user_repass)) {
                //判断密码与确认密码是否相同
                if ($user_pass == $user_repass) {
                    $user_pass = PassHash::hash($user_pass);
                    //向数据库增加信息
                    if (!is_user_registered($user_login)) {
                        $user_info = array(
                            'user_login' => $user_login,
                            'display_name' => $display_name,
                            'user_email' => $user_email,
                            'user_pass' => $user_pass,
                        );
                        $result = create_user($user_info);
                        if ($result)
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
        /*} else {
            echo '验证码错误';
        }*/
    } else {
        echo '<script>alert("阁下还未同意契约书");</script>';
    }
}

get_header('注册');

?>
<p>注册页面</p>

<form method="post">
    <p><label>登录名：<input type="text" name="user_login" required></label></p>
    <p><label>昵称：<input type="text" name="display_name" required></label></p>
    <p><label>Email：<input type="text" name="user_email" required></label></p>
    <p><label>密码：<input type="password" name="user_pass" required></label></p>
    <p><label>确认密码：<input type="password" name="user_repass" required></label></p>
    <?php //add_security_question(); ?>
    <p><input name="contract" type="checkbox" required>已经阅读并同意<a href="">《契约》</a></p>
    <input type="submit" value="申请契约">
    <input type="hidden" name="register_check" value="1">
</form>

已经有契约了？<a href="/login<?php echo URL_NAME;?>">登录一下吧</a>
<?php get_footer(); ?>