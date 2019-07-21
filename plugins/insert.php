<?php
/**
 * 一言插入工具
 * 
 */

 if (!defined('DIR'))
 exit('error');

$content = file_get_contents(DIR.'/step/hitokoto - chinese.json');
$content = json_decode($content,true);
