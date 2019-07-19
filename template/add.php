<?php
/**
 * 句子添加模块(the module of adding sentence)
 * 
 */
if(!is_user_login())
header('Location:/?login');

get_header('添加句子');

//获取句子(get sentence)
$sentence = isset($_POST['sentence']) ? $_POST['sentence'] : null;
$sentence_cat = isset($_POST['sentence_cat']) ? $_POST['sentence_cat'] : null;

$db = new DB;
//检查必要参数（Check the necessary parameters）
if(isset($_POST['add-sentence'])?$_POST['add-sentence']:null == 1 && !empty($sentence) && !empty(sentence_type))
{
    $array_sentence = array(
        'content' => $sentence,
        'cat' => $sentence_cat,
    );
    //添加句子(add sentence)
    $userid = $_SESSION['userinfo']['id'];
    $result = $db->add_sentence($array_sentence,$userid);
    if($result)
    echo 'Success';
    else echo 'failed';
}

//获取分类并转为数组(get category and transform to array)
$cat = $db->get_option_value('cat');
$array_cat = json_decode($cat,true);

?>
<p>这里是添加句子</p>
你的句子：
<form method="post" action="/?add">
    <input type="text" name="sentence" onblur="if(this.value=='')this.value='呐，知道么，樱花飘落的速度，是每秒五厘米哦~';" onfocus="if(this.value=='呐，知道么，樱花飘落的速度，是每秒五厘米哦~')this.value='';" value="呐，知道么，樱花飘落的速度，是每秒五厘米哦~">
    <select name="sentence_cat">
        <?php
        foreach($array_cat as $key => $value){
            echo '<option value="'.$key.'">'.$value.'</option>';
        }
        ?>
    </select>
    <input type="submit" value="添加">
    <input type="hidden" name="add-sentence" value="1">
</form>
<br />
<?php
get_footer();