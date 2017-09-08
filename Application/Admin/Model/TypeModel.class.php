<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model{
	protected $_validate=array(
			array('typename','require','分类名称不能为空'),
			array('typename','2,20','字的个数不能超过20',0,'length'),
			array('typename','','分类名称已经被使用',0,'unique'),
		);
	function getType($fid=0,$num=1,$arr=0){
		$opt1=$this->where("fid=$fid")->select();
		$option="";
		$strGang=str_repeat('—', $num);
		$num++;
		foreach ($opt1 as $v){
			if($v['id']==$arr){
			$option .='<option selected="selected" value='.$v['id'].'>'.$strGang.$v["typename"].'</option>';			
			}else{
			$option .='<option value='.$v['id'].'>'.$strGang.$v["typename"].'</option>';
			}
	 $optionSon=$this->getType($v['id'],$num,$arr);
			$option .=$optionSon;
		}
		return $option;
	}
	function getTypeByTr($fid=0,$num=0){
		$opt1=$this->where("fid=$fid")->select();
		$options="";
		$strGang=str_repeat('—', $num);
		$num++;
		foreach ($opt1 as $v){
			$options .='<tr>';
			$options .="<th>".$v['id']."</th>";
			$options .="<th>".$strGang.$v['typename']."</th>";
			$options .="<th><a href=\"update/id/{$v['id']} \"/>修改</a>&nbsp;&nbsp;<a href=\"delete/id/{$v['id']} \"/>删除</a></th>";
			$options .="</tr>";
			//$option .='<p value='.$v['id'].'>'.$strGang.$v["typename"].'</p>';
			 $optionSon=$this->getTypeByTr($v['id'],$num);
			$options .=$optionSon;
		}
		return $options;
	}
	function getTypeByStr($fid=0,$num=0,$arr=0,$fstr=""){
		$opt1=$this->where("fid=$fid")->select();
		$option="";      $str="";
		$strGang=str_repeat('—', $num);
		$num++;
		foreach ($opt1 as $v){
			if($v['id']==$arr){
			$option .='<option selected="selected" value='.$fstr.'-'.$v['id'].'>'.$strGang.$v["typename"].'</option>';			
			}else{
$option .='<option value='.$fstr.'-'.$v['id'].'>'.$strGang.$v["typename"].'</option>';
			$str =$fstr.'-'.$v['id'];			

		} $optionSon=$this->getTypeByStr($v['id'],$num,$arr,$str);
			$option .=$optionSon;
		}
		return $option;
	}
	
	
	
	
	
	
}