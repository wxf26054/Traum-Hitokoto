<?php
/**
 * Test file
 * 
 */

 
$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
$referer_host = parse_url($referer)['host'];
echo $referer_host;
exit;