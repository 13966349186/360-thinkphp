<?php
namespace Home\Controller;
class NewsController extends HomeController{
	function detail(){
		//根据文章id,获取文章信息
		$ob=M("news");
		$id=$_GET['id'];
		$arr=$ob->where("id=$id")->find();
		$this->assign('arr',$arr);
		$this->display();//News/d.html
		
	}
	function lister(){
		//根据分类的id，获取分类下的文章数据
		$ob=M('news');
		$fid=$_GET['fid'];
		$arr=$ob->where("n.fid=$fid")
				->order("id desc")
				->limit("0,6")
				->join("left join type as t on t.id=n.typeid")
				->alias('n')
				->field("n.*,t.tname")
				->select();
		$this->assign('arr',$arr);
		$this->display();
	}
}