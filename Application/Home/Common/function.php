<?php
function getTypeByStr(){
	$htmlStr="";
	//获取第一级
	$type=M('type');
	$typeOneArr=$type->where("fid=0")->select();
	foreach($typeOneArr as $v1){
		//拼字符串
		$htmlStr.="<h2> <a target=\"_blank\" href=\"".U("Product/lister",array('id'=>$v1['id']))."\"> {$v1['typename']}</a></h2>";
		//马上找一级的子
		$typeTwoArr=$type->where("fid={$v1['id']}")->select();
		foreach($typeTwoArr as $v2){
			$htmlStr.="<div class=\"h2_cat\" onmouseover=\"this.className='h2_cat active_cat'\" onmouseout=\"this.className='h2_cat'\">
					<h3>
<div class=\"xianzhi\">
<a target=\"_blank\" href=\"".U('Product/lister',array('tstr'=>"-".$v1['id']."-".$v2['id']."-"))."\">{$v2['typename']}</a> <span class=\"des\"></span>
</div>
</h3>
<div class=\"h3_cat\">
<div class=\"shadow\">
<div class=\"shadow_border\">
<ul>
					";
			//获取第三级
			$typeThreeArr=$type->where("fid={$v2['id']}")->select();
			foreach($typeThreeArr  as $v3){
				$htmlStr.="<li><a target=\"_blank\" href=\"".U('Product/lister',array('tstr'=>"-".$v1['id']."-".$v2['id']."-".$v3['id']."-"))."\">{$v3['typename']}</a></li>";
			}
			$htmlStr.="</ul></div></div></div></div>";

		}
	}
	return $htmlStr;
}