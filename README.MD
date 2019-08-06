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


## 在线体验
https://hitokoto.jysafe.cn

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
