<?php
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
$id = isset($_GET['id']) ? $_GET['id'] : null;

$db = new DB;

//处理action
if (!empty($action) && $id != null) {
    switch ($action) {
        case 'delete':
            $result = $db->delete_sentence($id);
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

//get sentences
$user_sentences = $db->get_user_sentences($_SESSION['userinfo']['id'], $page);

//get the number of sentences
$sentence_number = $db->get_number_sentences($_SESSION['userinfo']['id']);
//目的：求总页数，只要有余数就进一
//[总页数 + (总记录数/每页最大记录数)的最大余数]%每页最大记录数
$total_page = ($sentence_number + 9) % 10;

$cat = $db->get_option_value('cat');
$cat = json_decode($cat, true);

//output
echo '<table border="1"><tbody><tr><td>序号</td><td>句子</td><td>分类</td><td>操作</td></tr>';

foreach ($user_sentences as $key => $value):
    echo '<tr><td>' . $key . '</td><td>' . $value['content'] . '</td><td>' . $cat[$value['cat']] . '</td><td><a href="/?my-sentences&action=delete&id=' . $value['id'] . '" >删除</a></td></tr>';
endforeach;
reset($user_sentences);
echo '</tbody></table>';

if ($page != 1) {
    echo '<a href="/?my-sentences&page=' . ($page - 1) . '">上一页</a>';
}
for ($i = 1; $i <= $total_page; $i++) {
    if ($i != $page) {
        echo '&nbsp;<a href="/?my-sentences&page=' . $i . '">' . $i . '</a>&nbsp;';
    } else {
        echo $i;
    }
}
if ($page != $total_page) {
    echo '<a href="/?my-sentences&page=' . ($page + 1) . '">下一页</a>';
}

get_footer();
