<?php
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model.'serverModel.class.php';
	$mod=$_GET['mod'];
	if($mod=='add'){
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."add_server.html";
		include_once $view."public/footer.html";
	}elseif($mod=='doadd'){
		$server=new serverModel();
		foreach($_POST as $key=>$val){
			$server->$key=$val;
		}
		$server->add_server();
		$arr_res = array("status"=>"ok","msg"=>"添加成功");
		echo json_encode($arr_res);
		exit;
	}elseif($mod=='del'){
		$server=new serverModel();
		$result=$server->del_by_id($_POST['id']);
		if($result==false){
			$arr_res = array("status"=>"error","msg"=>"未找到指定信息");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"ok","msg"=>"删除成功");
			echo json_encode($arr_res);
			exit;
		}
	}elseif($mod=='edit'){
		$server=new serverModel();
		$result=$server->get_by_id($_GET['id']);
		if(!$result){
			exit('未找到指定信息！');
		}
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."edit_server.html";
		include_once $view."public/footer.html";
	}elseif($mod=='save'){
		$server=new serverModel();
		foreach($_POST as $key=>$val){
			$server->$key=$val;
		}
		$result=$server->save_by_id($_GET['id']);
		if($result==false){
			$arr_res = array("status"=>"error","msg"=>"未找到指定信息");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"ok","msg"=>"保存成功");
			echo json_encode($arr_res);
			exit;
		}

	}else{
		
		$server=new serverModel();
		$result=$server->get_all();
//		var_dump($result);exit;
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."server_list.html";
		include_once $view."public/footer.html";
	}

?>