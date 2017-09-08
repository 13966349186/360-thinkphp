<?php
namespace Home\Controller;
class CartController extends HomeController{
	function checkout(){
		if(isset($_COOKIE['userid'])){
			//呈现购物信息
			$sum=0;
			if(isset($_COOKIE['cart'])){
				$arr=unserialize($_COOKIE['cart']);
				$product=D('Product');
				$image=M("productimage");
				$newArr=array();
					
				foreach($arr as $k=>$v){//$k---pid  $v---num
					//找图片
					$imageArr=$image->where("productid=$k")->find();
					if($imageArr){
						$imagename=$imageArr['imagename'];
					}else{
						$imagename="no_picture.gif";
					}
					//根据产品id，获取产品的信息，算出总价
					$productArr=$product->where("id=$k")->find();
					if($v>=$productArr['jiannum']){
						$endPrice=$productArr['jianprice'];
					}else{
						$endPrice=$productArr['userprice'];
					}
					$zong=$endPrice*$v;
					$sum+=$zong;
					$newArr[]=array(
							'id'=>$productArr['id'],
							'title'=>$productArr['title'],
							'price'=>$endPrice,
							'zong'=>$zong,
							'buynum'=>$v,
							'imagename'=>$imagename
					);
				}
		
				$this->assign('arr',$newArr);
			}
			$this->assign('sum',$sum);
			//呈现购物信息
				
				
			$this->display();
		}else{
			$this->error("请登录",U("User/login",array('s'=>1)),3);
		}
		
	}
	function add(){
	$pid=intval($_GET['pid']);
	$num=(int)$_GET['num'];
	if($pid){
			if(isset($_COOKIE['cart'])){
				$arr=unserialize($_COOKIE['cart']);
				if(isset($arr[$pid])){
					$arr[$pid]+=$num;
				}else{
					$arr[$pid]=$num;
				}
			}else{
				$arr=array($pid=>$num);	
			}setcookie("cart",serialize($arr),time()+24*60,'/');
		
	}$this->redirect("Cart/index");
	
}	function index(){
	if(isset($_COOKIE['cart'])){
		$arr=unserialize($_COOKIE['cart']);
		$product=M("Product");
		$image=M("productimage");
						foreach ($arr as $k=>$v){
							$imageArr=$image->where("productid=$k")->find();
						if($imageArr){
							$imagename=$imageArr['imagename'];
						}else{
							$imagename="NULL";
						}
	$productArr=$product->where("id=$k")->find();
	if($v>=$productArr['jiannum']){
		$endPrice=$productArr['jianprice'];
	}else{
		$endPrice=$productArr['userprice'];
	}
	$zong=$endPrice*$v;
	$sum+=$zong;
	$newArr[]=array(
	'id'=>$productArr['id'],
	'title'=>$productArr['title'],
	'price'=>$endPrice,
	'zong'=>$zong,
	'buynum'=>$v,
	'imagename'=>$imagename
	);		
							
	}
						}	
		
		$this->assign('sum',$sum);			
		$this->assign('arr',$newArr);
		$this->display();	

	
}	function del(){
	$pid=$_GET['pid'];
	$cartArr=unserialize($_COOKIE['cart']);
	unset($cartArr[$pid]);
	setcookie('cart',serialize($cartArr),time()+24*60,'/');
	$this->redirect("Cart/index");
}
	function update(){
		$arr=$_POST['goods_number'];
		setcookie('cart',serialize($arr),time()+24*60,'/');
		$this->redirect("Cart/index");
	}
	function clear(){
	setcookie('cart','',time()-1,'/');
		$this->redirect("Cart/index");
	}
}