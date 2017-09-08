<?php
namespace Admin\Controller;
class TypeController extends BaseController {
	function add(){
			$type=D('Type');
		if($_POST){
			if($type->create()){
				$type->add();
				$this->success("添加成功",U("Type/oper"));
				exit();
			}else{
				$message=$type->getError();
				$this->error($message,U('Type/add'));
				exit();
			}
		}
		$optionSTr=$type->getType();
		$this->assign("optionstr",$optionSTr);
		$this->display();
	}
	function oper(){
		$type=D('type');
		$arr=$type->where("fid=0")->select();
		$this->assign('arr',$arr);
		$this->display();
	}
	function getson(){
		$type=D('type');
		$fid=$_GET['fid'];
		$num=$_GET['num'];
		$arr=$type->where("fid=$fid")->select();
		$html="";
		$strGang=str_repeat("--",$num);
		$num++;
		foreach($arr as $v){
			$html .="
		<tr id=\"tr_{$v['id']}\">
		<td>{$v['id']}</td>
		<td><a href=\"javascript:getSon({$v['id']},$num);\">$strGang{$v['typename']}</a></td>
		<td><a href=\"update/id/{$v['id']}\">修改</a>&nbsp;&nbsp;<a href=\"delete/id/{$v['id']}\">删除</a></td>
		</tr> ";
		}
		$reArr=array('html'=>$html,'sonid'=>$arr);
		echo json_encode($reArr);
	}
	function lister(){
		$type=D("Type");
		$optionSTr=$type->getTypeByTr();
		$this->assign("trstr",$optionSTr);
		$this->display();
	}
	function update(){
		$id=$_GET['id'];
		$type=D("Type");
		$arr=$type->where("id=$id")->find();
		$optionSTr=$type->getType(0,1,$arr['fid']);
		$this->assign("optionstr",$optionSTr);
		$this->assign('arr',$arr);
		$this->display();
	}
	function delete(){
		$id=$_GET['id'];
		$type=D("Type");
		
		$del=$type->delete($id);
		if($del){
			$this->success("删除成功",U("Type/oper"));
		}else{
			$this->error("删除失败",U("Type/oper"));
		}
		
	}
	
	
	
	
	
	
}