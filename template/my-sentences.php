<?php
/**
 * 用户的句子(sentences of user)
 *
 */
if (!is_user_login()) {
    header('Location: /?login');
}

get_header('我的句子');

$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

$db = new DB;

//处理action
if (!empty($action) && $id != null) {
    switch ($action) {
        case 'delete':
            $result = $db->delete_sentence($id);
            if($result) 
            echo '删除成功'; 
            else 
            echo '删除失败';
            break;
        default:
            break;
    }
}

//get sentences
$user_sentences = $db->get_user_sentences($_SESSION['userinfo']['id']);

$cat = $db->get_option_value('cat');
$cat = json_decode($cat, true);

//output
echo '<table border="1"><tbody><tr><td>序号</td><td>句子</td><td>分类</td><td>操作</td></tr>';

foreach ($user_sentences as $key => $value): 
    echo '<tr><td>' . $key . '</td><td>' . $value['content'] . '</td><td>' . $cat[$value['cat']] . '</td><td><a href="/?my-sentences&action=delete&id=' . $value['id'] . '" >删除</a></td></tr>';
endforeach;
reset($user_sentences);
echo '</tbody></table>';

get_footer();
