<?php
if (!defined('DIR')) {
    exit('非法访问');
}

get_header();
?>
<div id="hitokoto">『Loading...』</div>
<script type="text/javascript">
    var i = 0;

    function getColor() {
        i++;
        switch (i) {
            case 1:
                return "#CC0000";
            case 2:
                return "#9999CC";
            case 3:
                return "#CC3366";
            case 4:
                return "#669999";
            case 5:
                return "#FFCC00";
            case 6:
                return "#00CCCC";
            case 7:
                return "#CC00CC";
            default:
                return "black"
        }
    }

    function colorful() {
        var o = document.getElementById('hitokoto');
        o.style.color = getColor();
        if (i == 7) i = 0;
        setTimeout('colorful()', 1500)
    }
    colorful();
    var i = 1;
    var hitokoto = function() {
        var $hitokoto = document.querySelector('#hitokoto');
        if (i == 1) {
            $hitokoto.innerHTML = '『少女祈祷中...』';
        }
        var request = new XMLHttpRequest();
        request.open('GET', '/api/?charset=utf-8&encode=json', true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                var data = JSON.parse(request.responseText);
                $hitokoto.innerHTML = '『 ' + data.content + '』'
            } else {
                $hitokoto.innerHTML = '『一言异常了呢』'
            }
        };
        request.onerror = function() {
            $hitokoto.innerHTML = '『一言异常了呢』'
        };
        request.send()
        setTimeout('hitokoto()', 5000)
    };
    hitokoto()
</script>
<?php
get_footer();
