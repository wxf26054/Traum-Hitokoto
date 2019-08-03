<?php

/**
 * 一言添加模块(the module of adding hitokoto)
 *
 */

if (!defined('DIR')) {
    exit('非法访问');
}

if (!is_user_login()) {
    header('Location:/login' . URL_NAME );
}

get_header('添加句子');

//获取一言(get hitokoto)
$hitokoto_content = isset($_POST['hitokoto_content']) ? $_POST['hitokoto_content'] : null;
$hitokoto_cat = isset($_POST['hitokoto_cat']) ? $_POST['hitokoto_cat'] : null;
$source = isset($_POST['source']) ? ($_POST['source'] == '来源' ? null : $_POST['source']) : null;

//检查必要参数（Check the necessary parameters）
if (isset($_POST['addpage_check']) ? $_POST['addpage_check'] : null == 1 && !empty($hitokoto_content) && !empty($hitokoto_cat)) {
    $find = check_hitokoto_similarity($hitokoto_content);
    //找到就添加，否则输出相似度（Add it if found, otherwise output similarity）
    if (!$find) {
        $array_hitokoto = array(
            'content' => $hitokoto_content,
            'cat' => $hitokoto_cat,
            'source' => $source,
            'author' => null,
            'date' => null,
            'user_id' => $_SESSION['userinfo']['userid'],
        );
        //添加一言(add hitokoto)
        $result = add_hitokoto($array_hitokoto);
        if ($result) {
            echo '添加成功！ID：' . $result;
        } else {
            echo 'failed';
        }
    } else {
        echo '发现相似度极高的句子!不予添加！！！<br />' . 'ID:' . $find['id'] . ' => ' . $find['content'] . '&nbsp;&nbsp;&nbsp;&nbsp;相似度' . $find['percent'] . '%<br />';
    }
}

//获取分类并转为数组(get category and transform to array)
$option_cat = get_option_value('cat');
$array_cat = json_decode($option_cat, true);

?>
<p>这里是添加句子</p>
你的句子：
<form method="post" action="/add.air">
    <input type="text" name="hitokoto_content" onblur="if(this.value=='')this.value='呐，知道么，樱花飘落的速度，是每秒五厘米哦~';" onfocus="if(this.value=='呐，知道么，樱花飘落的速度，是每秒五厘米哦~')this.value='';" value="呐，知道么，樱花飘落的速度，是每秒五厘米哦~">
    <select name="hitokoto_cat">
        <?php
        foreach ($array_cat as $key => $value) {
            echo '<option value="' . $key . '">' . $value . '</option>';
        }
        ?>
    </select>
    <input type="text" name="source" onblur="if(this.value=='')this.value='来源';" onfocus="if(this.value=='来源')this.value='';" value="来源">
    <input type="submit" value="添加">
    <input type="hidden" name="addpage_check" value="1">
</form>
<br />
<?php
get_footer();
