<?php

/**
 * API文档页面
 */
if (!defined('DIR')) {
    exit('非法访问');
}

get_header('API文档');

//获取分类并转为数组(get category and transform to array)
$cat = get_option_value('cat');
$array_cat = json_decode($cat, true);
?>

<div>
    <div>
        <form>
            cat:
            <select name="cat">
                <option value="" selected="selected">任意</option>
                <?php
                foreach ($array_cat as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
                ?>
            </select>&nbsp;
            charset:
            <select name="charset">
                <option value="utf-8" selected="selected">utf-8</option>
                <option value="gbk">gbk</option>
            </select>&nbsp;
            length:
            <input type="text" maxlength="3" name="length" value="50" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" style="width:50px;">&nbsp;
            encode:
            <select name="encode">
                <option value="json" selected="selected">json</option>
                <option value="js">js</option>
                <option value="jsc">jsc</option>
                <option value="">无</option>
            </select>&nbsp;
            fun:
            <input type="text" name="fun" value="sync" style="width:70px;">&nbsp;
            User ID:
            <select id="id_select" name="user_id" onChange="selectOnChangeFunc()">
                <option value="" selected="selected">随机</option>
                <option value="0">系统收录</option>
                <option value="1">用户一言</option>
                <option value="" class="cls_option_defined">---自定义---</option>
            </select>&nbsp;
            <input type="number" id="id_input" class="cls_input" value="可选择也可自定义输入" oninput = "value=value.replace(/[^\d]/g,'')" >
            <input type="button" value="确定" onclick="get()">
        </form>
    </div>
    <div>
        <p>
            <input type="text" name="code" style="width:100%;">
        </p>
        <iframe id="hitokoto" frameborder=0 marginheight=0 marginwidth=0 seamless="seamless" style="width:100%; height: 120px; overflow-x:hidden; overflow-y:auto;" src=""></iframe>
    </div>
</div>

<script>
    var i = 0;

    function GetQueryString(name) {
        var reg = new RegExp("(^|[&?])" + name + "=([^&]*)(&|$)");
        var r = (document.getElementsByName("code")[0].value).substr(1).match(reg);
        if (r != null) {
            return unescape(r[2]);
        } else {
            return null;
        }
    }

    function get() {
        var cat = GetQueryString('cat');
        var charset = GetQueryString('charset');
        var length = GetQueryString('length');
        var encode = GetQueryString('encode');
        var fun = GetQueryString('fun');
        var user_id = GetQueryString('user_id');
        if (i == 1) {
            console.log("请求：/api/\n" + "参数：cat=" + cat + " charset=" + charset + " length=" + length + " encode=" + encode + " fun=" + fun + " user_id=" + user_id + "\n" + "返回：" + document.getElementById('hitokoto').contentWindow.document.getElementsByTagName('pre')[0].innerHTML);
        } else {
            i = 1;
        }
        document.getElementById("hitokoto").src = (document.getElementsByName("code")[0].value = "<?php echo API_DOMAIN; ?>/?cat=" + document.getElementsByName("cat")[0].value + "&charset=" + document.getElementsByName("charset")[0].value + "&length=" + document.getElementsByName("length")[0].value + "&encode=" + document.getElementsByName("encode")[0].value + "&fun=" + document.getElementsByName("fun")[0].value + "&user_id=" + document.getElementsByName("user_id")[0].value) + "&iframe=true";
    }

    function selectOnChangeFunc() {
            document.getElementById('id_input').value = document.getElementById('id_select').options[document.getElementById('id_select').selectedIndex].value;
        }
</script>
<?php
get_footer();
