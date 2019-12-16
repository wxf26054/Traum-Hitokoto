<?php

/**
 * 更新日志
 * 
 */
if (!defined('DIR')) exit('非法访问');
get_header('更新记录');
?>
<link rel="stylesheet" href="../assets/css/timeline.css">
<style>
    p {
        color: #fff;
        font-size: 15px;
        text-shadow: 0 0 10px #529DFF;
    }
</style>
    <div class="wrap about_page" id="wrap">
        <div class="wrapper">
            <div class="header">
                <div class="head">

                    <div class="logo_box">
                        <h1 class="hide_txt"><a href="#" title="Hitokoto/ヒトコト">Hitokoto/ヒトコト<img src="https://www.jysafe.cn/assets/images/LOGO.png" alt="祭夜blog"></a></h1>
                    </div>
                    <div class="nav_box">
                        <ul class="nav_list" id="nav_list">
                            <li><a href="javascript:void(0);" onclick="play()" id="playbtn" class="btn_sound"></a></li>
                            
                            <li><a href="https://hitokoto.jysafe.cn/">官网</a></li>
                        </ul>
                        <span class="ic_line" id="h_line"></span>
                    </div>
                </div>
            </div>
            <div class="events_sec" id="events_sec">
                <div class="content">
                    <h3 class="hide_txt png">hitokoto.jysafe.cn</h3>
                    <div class="events_list">
                        <span class="ic_time png"></span>
                        <ul>
                            <!--1-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-07-14规划一言项目的开发。</strong></p>
                            </li>
                            <!--2-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-07-16初步建立登录注册页面。</strong></p>
                            </li>
                            <!--3-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-07-17完善注册与登录功能。</strong></p>
                            </li>
                            <!--4-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-07-18增加了一些基础页面文件。</strong></p>
                            </li>
                            <!--5-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-07-19设计实现一言的删除与动态分类功能。</strong></p>
                            </li>
                            <!--6-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-07-20增加我的一言页面内容分页功能。</strong></p>
                            </li>
                            <!--7-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-07-21增加提交一言时的查重处理</strong></p>
                            </li>
                            <!--8-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-07-24初步实现API功能。</strong></p>
                            </li>
                            <!--9-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-07-26实现页面伪静态。</strong></p>
                            </li>
                            <!--10-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-07-31整合API功能，增加返回分类名。</strong></p>
                            </li>
                            <!--11-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-08-02优化用户系统。</strong></p>
                            </li>
                            <!--12-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-08-03完善文档。</strong></p>
                            </li>
                            <!--13-->
                            <li class="left_li">
                                <span class="ic_events"><i class="png"></i></span>
                                <p class="txt_events"><strong>2019-08-05添加统计功能。</strong></p>
                            </li>
                            <!--14-->
                            <li class="right_li">
                                <span class="ic_events png"></span>
                                <p class="txt_events"><strong>2019-08-11增加限制请求功能，提升安全性，修复问题。</strong></p>
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
                        <p>前路虽漫漫，吾等不怕难。有求必有应，质量准过关。自是高人助，</p>
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
        var url = ["/assets/audio/wispering - 天ノ弱 piano ver.mp3"];
        var num = GetRandomNum(0, url.length - 1);
        document.getElementById("audios").src = "http://" + location.host + url[num];

        function GetRandomNum(Min, Max) {
            var Range = Max - Min;
            var Rand = Math.random();
            return (Min + Math.round(Rand * Range));
        }

        function play() {
            var div = document.getElementById('playbtn');
            var obj = document.getElementById("audios");
            if (obj.paused) {
                obj.play();
                div.setAttribute("class", "btn_sound");
            } else {
                obj.pause();
                div.setAttribute("class", "btn_sound btn_no_sound");
            }

        }
    </script>
    <script src="../assets/js/canvas-nest.min.js"></script>
    <?php get_footer(); ?>