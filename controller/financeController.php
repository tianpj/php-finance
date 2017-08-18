<?php 
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model."analysisModel.class.php";
	include_once $model."configModel.class.php";
	$type=$_GET['type'];
	$date=$_GET['date'];
	$analysis = new analysisModel();
	if(in_array($type, array('出账','进账','退款'))){
		$result=$analysis->getdata($type,$date);
		$config = new configModel();
		$source = $config -> sel_source();
		$purpose = $config -> sel_purpose();
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."financeA.html";
		include_once $view."public/footer.html";
	}else{
		$result=$analysis->getdata2($type,$date);
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."financeB.html";
		include_once $view."public/footer.html";
	}
	
	
?>
