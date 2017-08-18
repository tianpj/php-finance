<?php
	if($_SESSION['id']){
		header("location: index.php");
	}

	include_once $model."loginModel.class.php";
	$mod = $_GET["mod"];
	//$id = $_SESSION["id"];
	
	if($mod == "dologin"){
		
		$user = new user();
		$user->username = trim($_POST["username"]);
		$user->password =  md5(trim($_POST["password"]));
		
		
		$agent = new LoginModel();
		$res = $agent->check_agent($user);
		//var_dump($res);exit;
		
		if($res){
			$_SESSION["id"] = $res['id'];
			$_SESSION["name"] = $res['username'];
			
			$result_arr = array("status"=>"ok","msg"=>"登录成功");
			echo json_encode($result_arr);
			exit;
		}else{
			$result_arr = array("status"=>"failed","msg"=>"登录失败");
			echo json_encode($result_arr);
			exit;
		}
		
	}else{
		if(!empty($id)){
			include_once $viewdir."public/header.html";
			include_once $viewdir."public/nav.html";
			include_once $viewdir."public/content.html";
			include_once $viewdir."public/footer.html";
		}else{		
			include_once $viewdir."login.html";
		}
	}

?>