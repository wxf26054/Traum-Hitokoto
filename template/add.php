<?php
/**
 * 句子添加模块(the module of adding sentence)
 * 
 */
if(!is_user_login())
header('Location:/?login');

get_header('添加句子');

//获取句子(get sentence)
$sentence = isset($_POST['sentence'])?$_POST['sentence']:null;

//检查必要参数（Check the necessary parameters）
if(isset($_POST['add-sentence'])?$_POST['add-sentence']:null == 1 && !empty($sentence))
{
    //添加句子(add sentence)
    $db = new DB;
    $userid = $_SESSION['userinfo']['id'];
    $result = $db->add_sentence($sentence,$userid);
    if($result)
    echo 'Success';
    else echo 'failed';
}
?>
<p>这里是添加句子</p>
你的句子：
<form method="post" action="/?add">
    <input type="text" name="sentence" onblur="if(this.value=='')this.value='呐，知道么，樱花飘落的速度，是每秒五厘米哦~';" onfocus="if(this.value=='呐，知道么，樱花飘落的速度，是每秒五厘米哦~')this.value='';" value="呐，知道么，樱花飘落的速度，是每秒五厘米哦~">
    <input type="submit" value="提交">
    <input type="hidden" name="add-sentence" value="1">
</form>
<br />
<?php
get_footer();