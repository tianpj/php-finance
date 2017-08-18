<?php
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model."configModel.class.php";

	$mod = $_GET['mod'];
	if( $mod == "sel_source"){

		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."add_source.html";
		include_once $view."public/footer.html";

	}elseif( $mod == "sel_purpose" ){

		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."add_purpose.html";
		include_once $view."public/footer.html";

	}elseif( $mod == "sel_pur" ){
		$config = new configModel();
		$purpose = $config -> sel_purpose();

		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."add_pur.html";
		include_once $view."public/footer.html";
	}elseif( $mod == "add_source" ){

		$source = $_POST['source'];
		$config = new configModel();
		$res = $config ->add_source($source);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"添加成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"添加失败");
			echo json_encode($arr_res);
			exit;
		}

	}elseif( $mod == "add_purpose" ){
		$config = new configModel();
		$res = $config ->add_purpose($_POST['purpose'],$_POST['purposetype']);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"添加成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"添加失败");
			echo json_encode($arr_res);
			exit;
		}
	}elseif( $mod == "add_pur" ){
		$config = new configModel();
		$res = $config ->add_pur($_POST['purpose'],$_POST['purtype']);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"添加成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"添加失败");
			echo json_encode($arr_res);
			exit;
		}
	}elseif($mod == "del_purpose"){
		$id = $_GET['id'];

		$config = new configModel();
		$res = $config ->del_purpose($id);

		if($res){
			header("location: index.php?action=config");
		}
	}elseif($mod == "del_pur"){
		$id = $_GET['id'];
		$config = new configModel();
		$res = $config ->del_pur($id);

		if($res){
			header("location: index.php?action=config");
		}
	}elseif($mod == "del_source"){
		$id = $_GET['id'];

		$config = new configModel();
		$res = $config ->del_source($id);
		if($res){
			header("location: index.php?action=config");
		}
	}elseif($mod == "edit_source"){
		$source = new source();
		$source -> id = $_POST['id'];
		$source ->source = $_POST['source'];

		$config  = new configModel();
		$res = $config -> edit_source($source);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"修改成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"修改失败");
			echo json_encode($arr_res);
			exit;
		}
	}elseif($mod == "edit_purpose"){
		$purpose = new purpose();
		$purpose -> id = $_POST['id'];
		$purpose ->purpose = $_POST['purpose'];

		$config  = new configModel();
		$res = $config -> edit_purpose($purpose);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"修改成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"修改失败");
			echo json_encode($arr_res);
			exit;
		}
	}elseif($mod == "edit_pur"){
		$purpose = new purpose();
		$purpose ->id = $_POST['id'];
		$purpose ->pur_name = $_POST['pur_name'];
		$config  = new configModel();
		$res = $config -> edit_pur($purpose);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"修改成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"修改失败");
			echo json_encode($arr_res);
			exit;
		}
	}else{
		$config = new configModel();
		$source = $config -> sel_source();
		$purpose = $config -> sel_purpose();
		$pur = $config -> sel_pur();

		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."config.html";
		include_once $view."public/footer.html";
	}



?>