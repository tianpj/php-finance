<?php
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model."analysisModel.class.php";
	$mod=$_GET['mod'];
	if($mod == "sel_time"){
		$type=$_GET['type'];
		$analysis = new analysisModel();
		$days = $analysis -> getdays();
		$result = $analysis -> sel_money($days);
		$result2=$analysis -> pie($type);
		$title='数据统计';
		$aliin_money=$result['aliin_money'];
		$aliout_money=$result['aliout_money'];
		$aliwait_money=$result['aliwait_money'];
		$in_money=$result['in_money'];
		$out_money=$result['out_money'];
		$return_money=$result['return_money'];
		$date=$result['date'];
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."analysis.html";
		include_once $view."public/footer.html";
	}else{
		$type='day';
		$analysis = new analysisModel();
		$days = $analysis -> getdays();
		$result = $analysis -> sel_money($days);
		$result2=$analysis -> pie($type);
		$title='数据统计';
		$aliin_money=$result['aliin_money'];
		$aliout_money=$result['aliout_money'];
		$aliwait_money=$result['aliwait_money'];
		$in_money=$result['in_money'];
		$out_money=$result['out_money'];
		$return_money=$result['return_money'];
		$date=$result['date'];

		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."analysis.html";
		include_once $view."public/footer.html";
	}

?>






