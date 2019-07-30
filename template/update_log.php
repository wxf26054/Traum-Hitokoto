<?php
/**
 * 更新日志
 * 
 */
if (!defined('DIR'))exit('非法访问');
get_header('更新记录');
?>
<link rel="stylesheet" href="../assets/css/timeline.css">
<style>
p{
color:#fff;
font-size:15px;
text-shadow: 0 0 10px #529DFF;
}
</style>
</head>
<body>
<div class="wrap about_page" id="wrap">
  <div class="wrapper">
    <div class="header">
      <div class="head">
	  
        <div class="logo_box"><h1 class="hide_txt"><a href="#" title="祭夜blog">祭夜blog<img src="https://jycdn.g9shose.com/assets/images/LOGO.png" alt="祭夜blog"></a></h1></div>
          <div class="nav_box">
            <ul class="nav_list" id="nav_list">
		 <li><a href="javascript:void(0);" onclick="play()" id="playbtn" class="btn_sound"></a></li>
		 <li><a href="http://qianc.me">主页</a></li>
		 <li><a href="">官网</a></li>
            </ul>
            <span class="ic_line" id="h_line"></span>
          </div>
      </div>
    </div>
    <div class="events_sec" id="events_sec">
      <div class="content">
        <h3 class="hide_txt png">blog.qianc.me</h3>
        <div class="events_list">
          <span class="ic_time png"></span>
          <ul>
		<li class="right_li">
		<span class="ic_events png"></span>
		<p class="txt_events"><strong>2016.1.1祭夜blog正式起步。</strong></p>
		</li>
		<li class="left_li">
		<span class="ic_events"><i class="png"></i></span>
		<p class="txt_events"><strong>中间跌宕起伏</strong></p>
		</li>
		<li class="right_li">
		<span class="ic_events png"></span>
		<p class="txt_events"><strong>2016.x.x日使用云落的Git主题。</strong></p>
		</li>
		<li class="left_li">
		<span class="ic_events"><i class="png"></i></span>
		<p class="txt_events"><strong>2017.1.30日生日当天发布个人第一款汉化插件。</strong></p>
		</li>
		<li class="right_li">
		<span class="ic_events png"></span>
		<p class="txt_events"><strong>2017.1.31日决定动手修改Git主题</strong></p>
		</li>
		<li class="left_li">
		<span class="ic_events"><i class="png"></i></span>
		<p class="txt_events"><strong>2017.2.1日将主题灯箱更换为highslide。</strong></p>
		</li>
		<li class="right_li">
		<span class="ic_events png"></span>
		<p class="txt_events"><strong>2017.2.4日将时间轴引入主题模板。</strong></p>
		</li>
		<li class="left_li">
		<span class="ic_events"><i class="png"></i></span>
		<p class="txt_events"><strong>2017.2.5日将前端用户中心由v1.0更换至v1.2。</strong></p>
		</li>
		<li class="right_li">
		<span class="ic_events png"></span>
		<p class="txt_events"><strong>2017.2.5日添加萌萌哒浮动小人一只，<br>code from<a href="https://myhloli.com/hitokoto.html" color="red">萝莉社</a></a></strong></p>
		</li>
		<li class="left_li">
		<span class="ic_events"><i class="png"></i></span>
		<p class="txt_events"><strong>2017.6.7日更改右下角回到顶部功能。</strong></p>
		</li>
		
          </ul>
          <span class="ic_arr png"></span>
        </div>
      </div>
    </div>
    
    <div class="wage_sec" id="wage_sec">
      <div class="content"><br>
        <h3 class="tt_bg">网站介绍</h3>
		<center>

<p>前路虽漫漫，祭夜不怕难。有求必有应，质量准过关。自是高人助，</p>
<p>远望俯平川。天地感其善，鬼神器之酸。昔日不忘恩，今朝永为伴。</p>
<br><br><br>
		</center>
		<br><br><br>
      </div>
    </div>
    </div>
  </div>

<audio id="audios" controls="true" autoplay="autoplay" class="audio" style="display:none;"></audio>

<script>
var url=["400-10056128.cos.myqcloud.com/1.mp3","400-10056128.cos.myqcloud.com/1.mp3"];
var num = GetRandomNum(0,url.length-1);   
document.getElementById("audios").src="http://"+url[num];
function GetRandomNum(Min,Max)
{
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}   

function play(){
var div = document.getElementById('playbtn'); 
var obj=document.getElementById("audios");
if(obj.paused){
obj.play();
div.setAttribute("class", "btn_sound"); 
}else{
obj.pause();
div.setAttribute("class", "btn_sound btn_no_sound"); 
}

}
</script>
<script src="../assets/js/canvas-nest.min.js"></script>
<?php get_footer();?>