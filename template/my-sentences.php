<?php
/**
 * 用户的句子(sentences of user)
 * 
 */
if(!is_user_login())
header('Location: /?login');

get_header('我的句子');

//get sentences
$db = new DB;
$user_sentences = $db->get_user_sentences($_SESSION['userinfo']['id']);

$cat = $db->get_option_value('cat');
$cat = json_decode($cat,true);

//output
echo '<table border="1"><tbody><tr><td>ID</td><td>句子</td><td>分类</td></tr>';
foreach($user_sentences as $key => $value)://第一种
    echo '<tr><td>'.$key.'</td><td>'.$value['content'].'</td><td>'.$cat[$value['cat']].'</td></tr>';
endforeach;
    reset($user_sentences);
echo '</tbody></table>';

get_footer();