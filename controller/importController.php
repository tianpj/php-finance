<?php
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model."ExcelModel.class.php";
	include_once $model."configModel.class.php";
	$mod = $_GET['mod'];
	if($mod == "doExcel"){
		$excel = new Excel();
		$res = $excel -> input_file();
		if($res){
			$res_arr = array("status"=>"success","msg"=>"导入成功！");
			echo json_encode($res_arr);
		}else{
			$res_arr = array("status"=>"failed","msg"=>"导入失败！");
			echo json_encode($res_arr);
		}
	}else{
		$source = new configModel();
		$res= $source->sel_source();
//		var_dump($res);exit;
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."import.html";
		include_once $view."public/footer.html";
	}
?>