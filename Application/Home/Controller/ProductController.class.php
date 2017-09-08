<?php
namespace Home\Controller;
class ProductController extends HomeController {
		function lister(){
			$order="id desc";
		if(isset($_GET['orderfield']) && !empty($_GET['orderfield'])){
			if(isset($_GET['ordertype']) && !empty($_GET['ordertype'])){
				$order=$_GET['orderfield']." ".$_GET['ordertype'];
					}else{
					$order=$_GET['orderfield']." desc";
							}
				}
		$product=D("Product");
		if(isset($_GET['id'])){
			$id=$_GET['id'];
			$where="typestr like '-{$id}%'";
			$tishiStr="<a href=\"\psd1702/CDTP/index.php/Home/Index/index\">首页</a>".typeidToStrByA($id); 
		}else if(isset($_GET['tstr'])){
			$tstr=$_GET['tstr'];
			$where="typestr like '{$tstr}%'";
			$tishiStr="<a href=\"\psd1702/CDTP/index.php/Home/Index/index\">首页</a> ".typeidToStrByA($tstr);
		}
		else{
			$where="";
			$tishiStr="<a href=\"\psd1702/CDTP/index.php/Home/Index/index\">首页</a>";
		}  
		$num=$product->where($where)->count();
		$pageSize=3;
		$page=new \Think\Page($num,$pageSize);
		$start=$page->firstRow;
		$arr=$product->where($where)
					 ->order($order)
					 ->limit("$start,$pageSize")
					 ->select();

		$productiamge=M("Productimage");
		foreach($arr as $k=>$v){
			$productId=$v['id'];
			$imageArr=$productiamge->where("productid=$productId")->find();
		if($imageArr){
				$arr[$k]['imagename']=$imageArr['imagename'];
			}else{
				$arr[$k]['imagename']="NULL";
			}
		} 
		$htmlStr=getTypeByStr();
		$this->assign('htmlStr',$htmlStr);
		$this->assign('tishiStr',$tishiStr);
		$this->assign('arr',$arr);
		$this->assign('num',$num);
		$this->assign('pagestr',$page->show());
		$this->display();
}
		function detail(){
			//接收产品pid
		$pid=(int)$_GET['pid'];
		//获取pid对应的产品记录
		$product=D('Product');
		
		$pArr=$product->alias('p')
					  ->join("gm_brand as b on p.brandid=b.id")
					  ->field("p.*,b.brandname")
					  ->where("p.id=$pid")
					  ->find();
		//从记录中，获取typestr
		$typestr=$pArr['typestr'];
		
		//根据typestr，获取面包屑字符串
		$tishiStr=typeidToStrByA($typestr);
	//	var_dump($expression);
		//给模板传记录，面包屑字符串
		$this->assign('tishiStr',"<a href=\"/project/\">首页</a> ".$tishiStr);
		$this->assign('pArr',$pArr);
		//获取产品图片，传到模板上
		$image=M('Productimage');
		$imageArr=$image->where("productid=$pid")->select();
		$this->assign('imageArr',$imageArr);
		$htmlStr=getTypeByStr();
		$this->assign('htmlStr',$htmlStr);
		//实现导航选中
		preg_match("/^>(\d+)/",$typestr,$typestrArr);
		$id=$typestrArr[1];
		$this->assign('headerTypeId',$id);
		
		$this->display();
		}
		




















}