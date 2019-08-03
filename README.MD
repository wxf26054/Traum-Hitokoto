# 一言项目

## 描述
 动漫也好、小说也好、网络也好，不论在哪里，我们总会看到有那么一两个句子能穿透你的心。我们把这些句子汇聚起来，形成一言网络，以传递更多的感动。如果可以，我们希望我们没有停止服务的那一天。

简单来说，一言指的就是一句话，可以是动漫中的台词，也可以是网络上的各种小段子。
或是感动，或是开心，有或是单纯的回忆。来到这里，留下你所喜欢的那一句句话，与大家分享，这就是一言存在的目的。*

*:本段文本源自hitokoto.us. 


1.采用php+mysql

2.支持用户系统

3.可添加、删除句子

4.支持API

5.以上功能正在增加以及完善中

<h3>食用方法</h3>
<p><code>GET https://api.hitokoto.jysafe.cn/</code></p>
<h3>参数说明</h3>
<table border="1">
    <thead>
        <tr>
            <th>参数名</th>
            <th>含义</th>
            <th>默认</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>cat</td>
            <td><code>string</code> 指定 hitokoto 的分类</td>
            <td>任意分类</td>
        </tr>
        <tr>
            <td>charset</td>
            <td><code>string</code> 返回字符集，支持 gbk/utf-8</td>
            <td>utf-8</td>
        </tr>
        <tr>
            <td>length</td>
            <td><code>int</code> 返回一句话的长度限制，超出则打断并添加省略号</td>
            <td>不限制</td>
        </tr>
        <tr>
            <td>encode</td>
            <td><code>string</code> 返回数据格式</td>
            <td>json</td>
        </tr>
        <tr>
            <td>fun</td>
            <td><code>string</code> 异步调用时，指定 CallBack 的函数名</td>
            <td>无</td>
        </tr>
        <tr>
            <td>source</td>
            <td><code>int</code> 值为 0 获取「系统收录」，为 用户ID 获取「指定用户的一言」</td>
            <td>随机选择</td>
        </tr>
    </tbody>
</table>
<h4>分类说明</h4>
<table border="1">
    <thead>
        <tr>
            <th>参数值</th>
            <th>含义</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>a</td>
            <td>Anime - 动画</td>
        </tr>
        <tr>
            <td>b</td>
            <td>Comic - 漫画</td>
        </tr>
        <tr>
            <td>c</td>
            <td>Game - 游戏</td>
        </tr>
        <tr>
            <td>d</td>
            <td>Novel - 小说</td>
        </tr>
        <tr>
            <td>e</td>
            <td>原创</td>
        </tr>
        <tr>
            <td>f</td>
            <td>来自网络</td>
        </tr>
        <tr>
            <td>g</td>
            <td>其他</td>
        </tr>
    </tbody>
</table>
<h4>数据格式说明</h4>
<table border="1">
    <thead>
        <tr>
            <th>参数值</th>
            <th>含义</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>json</td>
            <td>返回 JSON 格式数据</td>
        </tr>
        <tr>
            <td>js</td>
            <td>返回函数名为 <code>hitokoto</code> 的 JavaScript 脚本，用于同步调用</td>
        </tr>
        <tr>
            <td>jsc</td>
            <td>返回指定 CallBack 函数名的 JavaScript 脚本，可用于异步调用</td>
        </tr>
        <tr>
            <td>空</td>
            <td>返回纯文本</td>
        </tr>
    </tbody>
</table>
<h4>测试</h4>
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
            <option id="rand" value="" selected="selected">随机</option>
            <option id="sys" value="0">系统收录</option>
            <option id="custom" value="" class="cls_option_defined">---自定义---</option>
        </select>&nbsp;
        <input type="number" id="id_input" value="可选择也可自定义输入" oninput="selectOnChangeFunc();" hidden>
        <input type="button" value="确定" onclick="get()">
    </form>
</div>
<div>
    <p>
        <input type="text" name="code" style="width:100%;">
    </p>
    <iframe id="hitokoto" frameborder=0 marginheight=0 marginwidth=0 seamless="seamless" style="width:100%; height: 120px; overflow-x:hidden; overflow-y:auto;" src=""></iframe>
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
        if (document.getElementById('id_select').options[document.getElementById('id_select').selectedIndex].id == "custom") {
            document.getElementById('id_input').hidden = false;
            document.getElementById('id_select').options[document.getElementById('id_select').selectedIndex].value = document.getElementById('id_input').value;
        } else document.getElementById('id_input').hidden = true;
    }
</script>