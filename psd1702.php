<?php
define("TOKEN","11");
require 'wx/Weixin.class.php';
$weixin=new Weixin('wx061eef133c8b5b3b','d4624c36b6795d1d99dcf0547af5443d');
//$weixin->valid();
//接收post数据
$xml=$GLOBALS['HTTP_RAW_POST_DATA'];
if(!empty($xml)){
	$xmlObj=simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	if(is_object($xmlObj)){
		//获取类型
		$eventType=$xmlObj->Event;
		$content=file_get_contents("./paicuo.txt");
		file_put_contents("./paicuo.txt", $content."\n\r".$xml);
		if($eventType=='subscribe'){//有人关注我们了
			$toUserName=$xmlObj->ToUserName;
			$fromUserName=$xmlObj->FromUserName;//用户openid
			//获取用户信息
			$accesstoken=getAccessToken('wx061eef133c8b5b3b','d4624c36b6795d1d99dcf0547af5443d');
			//获取用户的开放id
			$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accesstoken}&openid={$fromUserName}&lang=zh_CN";
			$userinfo=$weixin->myCurl($url);
			$path="./psd1702/userinfo.txt";
			if(is_file($path)){
				$oldContent=file_get_contents($path);
				$content=$oldContent."\n\r".$userinfo;
			}else{
				$content=$userinfo;
			}
			file_put_contents($path, $content);
			//回复一个文本消息
			$returnXml="<xml>

<ToUserName><![CDATA[%s]]></ToUserName>

<FromUserName><![CDATA[%s]]></FromUserName>

<CreateTime>%s</CreateTime>

<MsgType><![CDATA[text]]></MsgType>

<Content><![CDATA[%s]]></Content>

</xml>";
			
			$t=time();
			$xmlContent=printf($returnXml,$fromUserName,$toUserName,$t,"哥，你来了！");	
			file_put_contents("./jieguo.txt", $xmlContent);
			echo $xmlContent;
		}
	}
}
function getAccessToken($appid,$appsecret){
	//判断存放令牌的文件是否存在，
	$path="./psd1702/accesstoken.txt";
	if(is_file($path)){
		//是否过期
		$mtime=filemtime($path);//文件的更新时间 modify
		if(time()-$mtime<7200){//没有过期
			$content=file_get_contents($path);
			$arr=json_decode($content,true);
			$accesstoken=$arr['access_token'];
			return $accesstoken;
		}
	}
	//获取令牌
	$weixin=new Weixin($appid,$appsecret);
	$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	$jsonStr=$weixin->myCurl($url);
	//写文件
	file_put_contents($path,$jsonStr);
	$arr=json_decode($jsonStr,true);
	$accesstoken=$arr['access_token'];
	return $accesstoken;
}











