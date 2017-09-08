<?php
namespace Admin\Controller;
class ProductController extends BaseController{
	function add(){
		$type=D("Type");
		$arr=$type->getTypeByStr();
		$brandArr=M('Brand')->select();
		$this->assign('brandjsonstr',json_encode($brandArr));
		$this->assign('optionStr',$arr);
		$this->display();
	}
	function save(){
		//产品信息写表
		$product=D("Product");
		$_POST['addtime']=time();
		$re=$product->data($_POST)->add();
		if($re){
			//图片信息写表
			//保存图片
			$upload=new \Think\Upload();
			$upload->autoSub=false;
			$upload->mimes=array('image/png','image/gif','image/jpeg');
			$upload->rootPath="./Public/";
			$upload->savePath="Upload/Product/";
			$imageArr=$upload->upload();
			$productimage=M("Productimage");
			foreach($imageArr as $v){
				$productimage->data(array('productid'=>$re,'imagename'=>$v['savename']))->add();
			}
			$this->success("产品添加成功",U("Product/oper"));
		}else{
			$this->success("产品添加失败",U("Product/oper"));
		}
	}
	function getbrhand(){
	$typestr=$_POST['typestr'];
	preg_match("/^-(\d+)/",$typestr,$arr);
	$typeid=$arr[1];
	$brand=M('Brand');
	$brandArr=$brand->where("typeid=$typeid")->select();
	
	//回传字符串 option
	$optionStr="";
	foreach($brandArr as $v){
		$optionStr.="<option value='{$v['id']}'>{$v['brandname']}</option>";
	}
	echo $optionStr;
	}
	//@retrun 无用
	function gg($v){
		$dd=M("Type")->where("fid=$v")->select();
		if($dd){
			foreach ($dd as $vv){
				$f[]=$vv['id'];
			}
		}else{
			var_dump($f);exit;
		}
	}
	function oper(){
		$n=M('Product');
		$d=$n->count();
		$num=4;
		$page=new \Think\Page($d,$num);
		$pagesize=$page->show();
		$first=$page->firstRow;
		$arr=$n->field("p.*,b.brandname")->limit($first,$num)->alias('p')->join("gm_brand as b on p.brandid=b.id")->select();
		$productimage=M("Productimage");
		foreach($arr as $k=>$v){
			$productid=$v['id'];
			
			$typestr=$v['typestr'];
			$str=$this->typeidToStr($typestr);
			$arr[$k]['typestr']=$str;
			
			$imageArr=$productimage->where("productid=$productid")->find();
			if($imageArr){
				$arr[$k]['imagename']=$imageArr['imagename'];
			}else{
				$arr[$k]['imagename']="NULL";
			}
		}
		$this->assign('fy',$pagesize);
		$this->assign('arr',$arr);
		$this->display();
	}
	function typeidToStr($typestr){
		$typestr=trim($typestr,'-');
		$typeArr=explode('-', $typestr);
		$typeid=$typeArr['0'];
		$type=M("Type")->where("id=$typeid")->find();
		return $type['typename'];
	}
	
	

	
	
}