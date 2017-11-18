<?php  
//include_once dirname(__FILE__)."/httpsqs_client.php"; 
require_once __DIR__ . '/vendor/autoload.php';
use Httpsqs\HttpsqsClient as httpsqs;    
//$httpsqs = new httpsqs($host, $port, $auth, $charset);
$httpsqs = new httpsqs("192.168.2.129", 1218, "mypass123", "utf-8");  
while(true) {  
  //$result = $httpsqs->gets($name);
  $result = $httpsqs->gets("queue_A");
  if($result != false){
	  $pos = $result["pos"]; //当前队列消息的读取位置点  
	  $data = $result["data"]; //当前队列消息的内容  
	  if ($data != "HTTPSQS_GET_END" && $data != "HTTPSQS_ERROR") {  
		//...去做应用操作...
		
		//应用操作异常,1、记录pos点队列日志 2、将失败日志入队列B
		$result_b = $httpsqs->put("queue_B", $data); 
		if($result_b == false){
			//将队列记入日志，并管理员处理
		}
	  } else {  
		sleep(1); //暂停1秒钟后，再次循环  
	  }
  }
}