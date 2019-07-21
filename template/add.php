<?php
/**
 * 句子添加模块(the module of adding sentence)
 *
 */
if (!is_user_login()) {
    header('Location:/?login');
}

get_header('添加句子');

//获取句子(get sentence)
$sentence = isset($_POST['sentence']) ? $_POST['sentence'] : null;
$sentence_cat = isset($_POST['sentence_cat']) ? $_POST['sentence_cat'] : null;
$source = isset($_POST['source']) ? ($_POST['source'] == '来源' ? null : $_POST['source']) : null;

$db = new DB;
//检查必要参数（Check the necessary parameters）
if (isset($_POST['add-sentence']) ? $_POST['add-sentence'] : null == 1 && !empty($sentence) && !empty(sentence_type)) {
    //检查相似度，将句子按3个字一组分割(包括标点符号)
    $aray_split_sentence = mb_str_split($sentence, 3);
    //记 $find 初始为false，即没找到
    $find = false;
    foreach ($aray_split_sentence as $value) {
        $result = $db->get_similar_sentence($value);
        foreach ($result as $key => $value) {
            //similar_text() 函数计算比较两个字符串的相似度
            similar_text($sentence, $value['content'], $percent);
            //相似度大于50为找到[Similarity greater than 50 is found]
            if ($percent > 50) {
                $similar_sentence = 'ID:' . $value['id'] . ' => ' . $value['content'] . '&nbsp;&nbsp;&nbsp;&nbsp;相似度' . $percent . '%<br />';
                //找到后记 $find 为true，同时跳出本循环 [Once found, modify the value of $find to true and jump out of this loop.]
                $find = true;
                break;
            }
        }
        //找到直接跳出循环[Once found,jump out of this loop.]
        if ($find) {
            break;
        }
    }
    //找到就添加，否则输出相似度（Add it if found, otherwise output similarity）
    if (!$find) {
        $array_sentence = array(
            'content' => $sentence,
            'cat' => $sentence_cat,
            'source' => $source,
        );
        //添加句子(add sentence)
        $userid = $_SESSION['userinfo']['id'];
        $result = $db->add_sentence($array_sentence, $userid);
        if ($result) {
            echo 'Success';
        } else {
            echo 'failed';
        }
    } else {
        echo '发现相似度极高的句子!不予添加！！！<br />' . $similar_sentence;
    }
}

//获取分类并转为数组(get category and transform to array)
$cat = $db->get_option_value('cat');
$array_cat = json_decode($cat, true);

?>
<p>这里是添加句子</p>
你的句子：
<form method="post" action="/?add">
    <input type="text" name="sentence" onblur="if(this.value=='')this.value='呐，知道么，樱花飘落的速度，是每秒五厘米哦~';" onfocus="if(this.value=='呐，知道么，樱花飘落的速度，是每秒五厘米哦~')this.value='';" value="呐，知道么，樱花飘落的速度，是每秒五厘米哦~">
    <select name="sentence_cat">
        <?php
foreach ($array_cat as $key => $value) {
    echo '<option value="' . $key . '">' . $value . '</option>';
}
?>
    </select>
    <input type="text" name="source" onblur="if(this.value=='')this.value='来源';" onfocus="if(this.value=='来源')this.value='';" value="来源">
    <input type="submit" value="添加">
    <input type="hidden" name="add-sentence" value="1">
</form>
<br />
<?php
get_footer();