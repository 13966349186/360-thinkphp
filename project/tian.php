<?php
	if(empty($_POST["name"])){
		exit("充值失败");
}
    $host = "http://saweather.market.alicloudapi.com";
    $path = "/area-to-id";
    $method = "GET";
    $appcode = "9fc80b985c154212b3b548de576891c2";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    $querys =$_POST["name"];
	$querys="area=$querys";
    $bodys = "";
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $d=json_decode(curl_exec($curl));
  $tq=$d->showapi_res_body->list;
  foreach($tq as $v){
echo "<pre>";  
var_dump($v->area);
  }
?>