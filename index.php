<?php
	include_once('common/common.php');
	
	$action=$_GET['action'];
	$allowaction=array('login','logout','config','input','import','analysis','finance','edit','server','sysRos','rosConfig','configExec','ipRandom','faq');
	
	if(in_array($action, $allowaction)){
		
		include_once($control.$action.'Controller.php');

	}else{
		
        include_once($control."defaultController.php");
		
	}















	?>