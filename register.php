<?php
/**
 * 注册相关
 *
 */
$title = '签订契约';
require_once 'load.php';

//注册处理
if (isset($_POST['register_check']) ? $_POST['register_check'] : null == 1) {
    if (isset($_POST['contract']) ? $_POST['contract'] : null == 'on') {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $repassword = isset($_POST['repassword']) ? $_POST['repassword'] : null;

        if (!empty($username) && !empty($password) && !empty($repassword)) {
            if ($password == $repassword) {
                $db = new DB;
                $id = $db->get_id($username);
                if (empty($id)) {
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

get_header();

?>
<p>注册页面</p>

<form method="post" action="register.php">
    <p><label>账号：<input type="text" name="username"></label></p>
    <p><label>密码：<input type="password" name="password"></label></p>
    <p><label>确认密码：<input type="password" name="repassword"></label></p>
    <p><input name="contract" type="checkbox">已经阅读并同意<a href="">《契约》</a></p>
    <input type="submit" value="签订契约">
    <input type="hidden" name="register_check" value="1">
</form>

<?php get_footer();?>