<?php
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model."configModel.class.php";
	include_once $model."userModel.class.php";
	$user = new userModel();
	$mod = $_GET['mod'];
	if($mod == "editPwd"){
		$id = $_POST['id'];
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$res = $user -> upadtePwd($username,$password,$id);
		if($res){
			$arr['msg']='修改成功';
			$arr['status']='ok';
			exit(json_encode($arr));
		}else{

			$arr['msg']='修改失败';
			$arr['status']='fail';
			exit(json_encode($arr));
		}
	}

	
	$result = $user -> selPwd();
	include_once $view."public/header.html";
	include_once $view."public/nav.html";
	include_once $view."editpwd.html";
	include_once $view."public/footer.html";

?>