<?php
function typeidToStr($typestr){
	$typestr=trim($typestr,"-");
	$typeArr=explode(">", $typestr);
	$str="";
	$type=M("type");
	foreach ($typeArr as $v){
		$arr=$type->where("id={$v}")->find();
		$str.="&gt;{$arr['typename']}";
	}

	return $str;
}

function typeidToStrByA($typestr){
	if(!preg_match("/^-/", $typestr)){
		$paramArr=array('id'=>$typestr);
	}
	$typestr=trim($typestr,"-");
	$typeArr=explode("-",$typestr);
	$str="";
	$vv="";
	$type=M('type');
	foreach ($typeArr as $v){
if(!isset($paramArr["id"])){
	$vv .='-'.$v;
	$paramArr=array('tstr'=>$vv);
}
	$arr=$type->where("id=$v")->find();
		$str.=" <code>&gt;</code> <a href='".U("Product/lister",$paramArr)."'>{$arr['typename']}</a>";
		}
		return $str;
		
	
}