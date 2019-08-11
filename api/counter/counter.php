<?php
function counter(){
	$numUrl = "./counter.txt";
	$host_URL = "./host.txt";
	$everydayUrl ="./everyday.txt";
	$everyhourUrl = "./everyhour.txt";

	$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
	if($referer != null)
		$now_referer_host = parse_url($referer)['host'];
	else
		$now_referer_host = $_SERVER['HTTP_HOST'];

	$nowTime = $_SERVER['REQUEST_TIME'];
	$counter = explode(';',file_get_contents($numUrl)); //总访问量
	$counter[0] = (int)$counter[0];	

	$array_host_url = explode(';',file_get_contents($host_URL));
	$everyDay = explode(';',file_get_contents($everydayUrl));
	$everyHour = explode(';',file_get_contents($everyhourUrl));

	$flag = 0;
	$add = 0;
	$length = empty($array_host_url[0]) ? 0:count($array_host_url);
	date_default_timezone_set("PRC") ;	//设置时区
	$hour = date("H",$nowTime);

	//echo $hour;
	for($i = 0 ; $i < $length ;$i += 2){
		if($array_host_url[$i] == $now_referer_host){
			$flag = 1;   //这个ip出现过
			if($nowTime - $array_host_url[$i+1] > 3600){  //距离上次访问超过1个小时
				$counter[0]++;
				$add = 1;
				$array_host_url[$i+1] = $nowTime;
				for($j = 0;$j < 48;$j+=2){
					if($everyHour[$j]==$hour){
						$everyHour[$j+1] = (int)$everyHour[$j+1];
						$everyHour[$j+1] ++ ;
					}
				}
			}
		}
	}

	if($flag == 0){  //这个ip第一次出现
		$array_host_url[$i] = $now_referer_host;
		$array_host_url[$i+1] = $nowTime;
		$counter[0]++;
		for($j = 0;$j < 48;$j+=2){
			if($everyHour[$j]==$hour){
				$everyHour[$j+1] = (int)$everyHour[$j+1];
				$everyHour[$j+1] ++ ;
			}
		}
	}
	$length = empty($everyDay[0]) ? 0:count($everyDay);

	$today = date("Y-m-d", $nowTime);
	$first = 1;  //今日第一个访问
	$todayLog = 0 ; 
	if($add||$flag ==0){
		for($i = 0; $i<$length;$i+=2){
			if($everyDay[$i]==$today){
				$everyDay[$i+1] = (int)$everyDay[$i+1];
				$everyDay[$i+1]++;
				$todayNum = $everyDay[$i+1];
				$first = 0;
			}
		} 
		if($first){
			$everyDay[$i] = $today;
			$everyDay[$i+1] = 1;
			$todayNum = 1;
		}

	}else{
		for($i = 0; $i<$length;$i+=2){
			if($everyDay[$i]==$today){
				$todayLog = 1;
				$todayNum = $everyDay[$i+1];
			}
		}
		if($todayLog == 0){
			$todayNum = 1;   
		}
	}
	$totalNum = $counter[0];
	file_put_contents($numUrl, implode(";", $counter));
	file_put_contents($host_URL, implode(";", $array_host_url));
	file_put_contents($everydayUrl, implode(";", $everyDay));
	file_put_contents($everyhourUrl, implode(';', $everyHour));
	$result = array($totalNum , $todayNum);
	return $result;
}

function showEveryday(){
	$everydayUrl ="./everyday.txt";
	$everyDay = explode(';',file_get_contents($everydayUrl));
	$length = empty($everyDay[0]) ? 0:count($everyDay);
	for($i = 0;$i<$length;$i+=2){
		echo $everyDay[$i].":";
		echo $everyDay[$i+1]."<br/>";
	}
}

function showEveryhour(){
	$everyhourUrl = "./everyhour.txt";
	$everyHour = explode(';',file_get_contents($everyhourUrl));
	for($i = 0;$i<48;$i+=2){
		echo $everyHour[$i]."-".$everyHour[($i+2)%48].':';
		echo $everyHour[$i+1]."<br/>";
	}
}
