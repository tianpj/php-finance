<?php
	include_once $model."financeModel.class.php";
	$id = $_SESSION["id"];
	$finance = new financeModel();
	if(empty($id)){
		include_once($view.'login.html');
	}else{
		$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
		$come = $finance -> selCome($beginThismonth);
		$out = $finance -> selOut($beginThismonth);
		$refund = $finance -> refund($beginThismonth);
		$sum = $come['sum']-$out['sum']-$refund['sum'];
		include_once($view."public/header.html");
		include_once($view."public/nav.html");
		include_once($view."public/content.html");
		include_once($view."public/footer.html");
	}
