<?php

/**
 * API文档页面
 */
if (!defined('DIR')) {
    exit('非法访问');
}

get_header('API文档');

//获取分类并转为数组(get category and transform to array)
$option_cat = get_option_value('cat');
$array_cat = json_decode($option_cat, true);
?>
<link rel="stylesheet" type="text/css" href="assets/css/github-markdown.css" />

<div class="markdown-body">
    <blockquote class="update">
        本页面更新：<span id="index">读取中…</span><br>
        api更新：<span id="api">读取中…</span><br>
        系统收录：<span id="sys_hitokoto_number">读取中…</span>&nbsp;用户添加：<span id="user_hitokoto_number">读取中…</span>
    </blockquote>
    <p>问题/反馈：me # jysafe.cn<br>
        调用超过 <b><span id="hit"> -- </span></b> 次<br>
        过去的 5 分钟内每分钟调用大约 <b><span id="speed_5min"> -- </span></b> 次</p>
    <h3>食用方法</h3>
    <p><code>GET https://api.hitokoto.jysafe.cn/</code></p>
    <h3>参数说明</h3>
    <table>
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
    <table>
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
    <table>
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

    function Ajax(type, url, data, success, failed) {
        // 创建ajax对象
        var xhr = null;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else {
            xhr = new ActiveXObject('Microsoft.XMLHTTP')
        }

        var type = type.toUpperCase();
        // 用于清除缓存
        var random = Math.random();

        if (typeof data == 'object') {
            var str = '';
            for (var key in data) {
                str += key + '=' + data[key] + '&';
            }
            data = str.replace(/&$/, '');
        }

        if (type == 'GET') {
            if (data) {
                xhr.open('GET', url + '?' + data, true);
            } else {
                xhr.open('GET', url + '?t=' + random, true);
            }
            xhr.send();

        } else if (type == 'POST') {
            xhr.open('POST', url, true);
            // 如果需要像 html 表单那样 POST 数据，请使用 setRequestHeader() 来添加 http 头。
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(data);
        }

        // 处理返回数据
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    success(xhr.responseText);
                } else {
                    if (failed) {
                        failed(xhr.status);
                    }
                }
            }
        }
    }

    Ajax( //Ajax(type, url, data, success, failed)
        'get',
        '<?php echo API_DOMAIN; ?>/counter.php',
        '',
        function(data) {
            data = JSON.parse(data);
            document.getElementById("index").innerHTML = data.index;
            document.getElementById("api").innerHTML = data.api;
            document.getElementById("hit").innerHTML = data.hit;
            document.getElementById("speed_5min").innerHTML = data.speed_5min;
            document.getElementById("sys_hitokoto_number").innerHTML = data.sys_hitokoto_number;
            document.getElementById("user_hitokoto_number").innerHTML = data.user_hitokoto_number;
        },
        function(error) {
            var spans = document.getElementsByClassName("update")[0].getElementsByTagName("span");
            for (var i = 0; i < spans.length; i++) {
                spans[i].innerHTML = "读取失败";
            }
        });
</script>
<?php
get_footer();
