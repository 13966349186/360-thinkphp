<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
	protected $tableName="User";
	protected $patchValidate=true;
	protected $_validate=array(
 			array('password','/\w{6,15}/','密码格式错误'),
 			array('phone','/^1\d{9}$/','电话格式错误'),
 			array('qq','/^\d{5,10}$/','qq价格格式错误'),
			array('email','/^\w+@\w+(((.)com)|((.)com(.)cn))$/','email格式错误')
	);
			
}