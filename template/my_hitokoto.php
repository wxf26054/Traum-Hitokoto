<?php
 if (!defined('DIR'))exit('非法访问');
/**
 * 用户的句子(sentences of user)
 *
 */
if (!is_user_login()) {
    header('Location: /?login');
}

get_header('我的句子');

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$hitokoto_id = isset($_GET['hitokoto_id']) ? $_GET['hitokoto_id'] : null;

$db = new DB;

//处理action
if (!empty($action) && $hitokoto_id != null) {
    switch ($action) {
        case 'delete':
            $result = $db->delete_sentence($hitokoto_id);
            if ($result) {
                echo '删除成功';
            } else {
                echo '删除失败';
            }

            break;
        default:
            break;
    }
}

//get the number of sentences
$sentence_number = $db->get_number_sentences($_SESSION['userinfo']['userid']);
//目的：求总页数，只要有余数就进一
//[总页数 + (总记录数/每页最大记录数)的最大余数]/每页最大记录数
$total_page = ceil ($sentence_number / 10);
if ($page> $total_page){ // 如果 页数 大于 总页数，就等于总页数
    $page = $total_page;
    }
//get sentences
$user_sentences = $db->get_user_sentences($_SESSION['userinfo']['userid'], $page);

$cat = $db->get_option_value('cat');
$cat = json_decode($cat, true);

//output
echo '<table border="1"><tbody><tr><td>序号</td><td>句子</td><td>来源</td><td>分类</td><td>操作</td></tr>';

foreach ($user_sentences as $key => $value):
    echo '<tr><td>' . $key . '</td><td>' . $value['content'] . '</td><td>' . $value['source'] . '</td><td>' . $cat[$value['cat']] . '</td><td><a href="/edit'.URL_NAME.'?hitokoto_id=' . $value['id'] . '" >编辑</a>|<a href="/my_hitokoto'.URL_NAME.'?action=delete&hitokoto_id=' . $value['id'] . '" >删除</a></td></tr>';
endforeach;
reset($user_sentences);
echo '</tbody></table>';

if ($page != 1) {
    echo '<a href="/my_hitokoto'.URL_NAME.'?page=1">首页</a><a href="/my_hitokoto'.URL_NAME.'?page=' . ($page - 1) . '">上一页</a>';
}
for ($i = 1; $i <= $total_page; $i++) {
    if ($i != $page) {
        if($i > $page - 5 && $i < $page + 5)
        echo '&nbsp;<a href="/my_hitokoto'.URL_NAME.'?page=' . $i . '">' . $i . '</a>&nbsp;';
    } else {
        echo $i;
    }
}
if ($page != $total_page) {
    echo '<a href="/my_hitokoto'.URL_NAME.'?page=' . ($page + 1) . '">下一页</a><a href="/my_hitokoto'.URL_NAME.'?page=' . $total_page . '">尾页</a>';
}

get_footer();
