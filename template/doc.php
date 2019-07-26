<?php
/**
 * API文档页面
 */
if (!defined('DIR')) {
    exit('非法访问');
}

get_header('API文档');
?>

<div>
    <div>
        <form>
            cat:
            <select name="cat">
                <option value="" selected="selected">任意</option>
                <option value="a">Anime - 动画</option>
                <option value="b">Comic - 漫画</option>
                <option value="c">Game - 游戏</option>
                <option value="d">Novel - 小说</option>
                <option value="e">原创</option>
                <option value="f">来自网络</option>
                <option value="g">其他</option>
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
            source:
            <select name="source">
                <option value="" selected="selected">随机</option>
                <option value="0">系统收录</option>
                <option value="1">我的一言</option>
            </select>&nbsp;
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
    function GetQueryString(name){
        var reg = new RegExp("(^|[&?])"+ name +"=([^&]*)(&|$)");
        var r = (document.getElementsByName("code")[0].value).substr(1).match(reg);
        if(r!=null){
            return  unescape(r[2]);
        }else{
            return null;
        }
    }
    function get(){
        var cat = GetQueryString('cat');
        var charset = GetQueryString('charset');
        var length = GetQueryString('length');
        var encode = GetQueryString('encode');
        var fun = GetQueryString('fun');
        var source = GetQueryString('source');
        if (i == 1){
            console.log("请求：/api/\n" + "参数：cat=" + cat + " charset=" + charset + " length=" + length + " encode=" + encode + " fun=" + fun + " source=" + source + "\n" + "返回：" + document.getElementById('hitokoto').contentWindow.document.getElementsByTagName('pre')[0].innerHTML);
        }else{
            i = 1;
        }
        document.getElementById("hitokoto").src = (document.getElementsByName("code")[0].value = "/api/?cat=" + document.getElementsByName("cat")[0].value +"&charset=" + document.getElementsByName("charset")[0].value +"&length=" +  document.getElementsByName("length")[0].value + "&encode=" + document.getElementsByName("encode")[0].value + "&fun=" + document.getElementsByName("fun")[0].value + "&source=" + document.getElementsByName("source")[0].value) + "&iframe=true";
    }
</script>
<?php
get_footer();