<?php

/**
 * 编辑页面
 */
if (!defined('DIR')) {
    exit('非法访问');
}

//是否登录
if (!is_user_login()) {
    header('Location:/login' . URL_NAME );
}

get_header('编辑');

$hitokoto_id = isset($_GET['hitokoto_id']) ? $_GET['hitokoto_id'] : null;
if (!empty($hitokoto_id)) {

    //获取分类并转为数组(get category and transform to array)
    $option_cat = get_option_value('cat');
    $array_cat = json_decode($option_cat, true);

    $hitokoto = get_hitokoto_by_id($hitokoto_id);

    if($hitokoto['user_id'] == 0 && $_SESSION['userinfo']['userid'] == 1)
    {
        $hitokoto['user_id'] = 1;
    }

    if ($hitokoto['user_id'] != $_SESSION['userinfo']['userid']) {
        echo '一言很是生气地说道：哼！你不是我的的主人！';
    } else {
        $check_string = isset($_POST['update_hitokoto']) ? $_POST['update_hitokoto'] : null;
        if ($check_string == 1) {
            //修改
            $hitokoto_content = isset($_POST['hitokoto_content']) ? $_POST['hitokoto_content'] : null;
            $hitokoto_cat = isset($_POST['hitokoto_cat']) ? $_POST['hitokoto_cat'] : null;
            $hitokoto_source = isset($_POST['hitokoto_source']) ? $_POST['hitokoto_source'] : null;
            if (!empty($hitokoto_content) && !empty($hitokoto_cat) && !empty($check_string)) {
                $hitokoto_new = array(
                    'id' => $hitokoto_id,
                    'content' => $hitokoto_content,
                    'cat' => $hitokoto_cat,
                    'source' => $hitokoto_source,
                );
                $find = check_hitokoto_similarity($hitokoto_content);
                if ($find && $find['id'] != $hitokoto_id) {
                    echo '发现相似度极高的其它句子!不予添加！！！<br />' . 'ID:' . $find['id'] . ' => ' . $find['content'] . '&nbsp;&nbsp;&nbsp;&nbsp;相似度' . $find['percent'] . '%<br />';
                } else {
                    $result = update_hitokoto($hitokoto_new);
                    if ($result) {
                        echo '修改成功';
                    } else {
                        echo '修改失败';
                    }
                }
            }
            //第二次请求
            $hitokoto = get_hitokoto_by_id($hitokoto_id);
        }
        ?>
        <form method="post">
            <input type="text" name="hitokoto_content" value="<?php echo $hitokoto['content']; ?>">
            <select name="hitokoto_cat">
                <?php
                foreach ($array_cat as $key => $value) {
                    if ($key == $hitokoto['cat']) {
                        echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                    } else {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
                ?>
            </select>
            <input type="text" name="hitokoto_source" value="<?php echo $hitokoto['source']; ?>">
            <input type="hidden" name="update_hitokoto" value="1">
            <input type="submit" value="修改">
        </form>
    <?php
    }
} else {
    echo '参数错误';
}

get_footer();
