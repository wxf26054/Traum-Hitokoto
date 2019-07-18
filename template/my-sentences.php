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
$result = $db->get_user_sentences($_SESSION['userinfo']['id']);

//output
foreach($result as $key => $value)://第一种
    echo $key.".".$value['content']."<br/>";
endforeach;
    reset($result);

get_footer();