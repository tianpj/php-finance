<?php
	if(!$_SESSION['id']){
		header("location: index.php");
	}
	include_once $model."configModel.class.php";
	include_once $model."inputModel.class.php";

	$mod = $_GET['mod'];
	if($mod == "add_input"){
		$finance = new finance();
		$finance ->money = $_POST['money'];
		$finance ->source = $_POST['source'];
		$finance ->purpose = $_POST['purpose'];
		$finance ->type = $_POST['type'];
		$finance ->f_time =strtotime($_POST['time']);
		$finance -> desc = $_POST['describe'];
		$input = new inputModel();
		$res = $input ->add_input($finance);
		if($res){
			$arr_res = array("status"=>"ok","msg"=>"录入成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"录入失败");
			echo json_encode($arr_res);
			exit;
		}
	}elseif($mod =="sel_list"){

		$input = new inputModel();
		$result =$input ->sel_list();

		$config = new configModel();
		$source = $config -> sel_source();
		$purpose = $config -> sel_purpose();
		//var_dump($result);exit;
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."input_list.html";
		include_once $view."public/footer.html";
	}elseif($mod =="edit_fin"){

		$id = $_GET['id'];
		$input = new inputModel();
		$result =$input ->sel_fin($id);

		$config = new configModel();
		$source = $config -> sel_source();
		$purpose = $config -> sel_purpose();

		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."edit_input.html";
		include_once $view."public/footer.html";
	}elseif($mod == "edit_input"){

		$finance = new finance();
		$finance -> id = $_POST['id'];
		$finance ->money = $_POST['money'];
		$finance ->source = $_POST['source'];
		$finance ->purpose = $_POST['purpose'];
		$finance ->type = $_POST['type'];
		$finance ->f_time = strtotime($_POST['time']);
		$finance -> desc = $_POST['describe'];
		$input = new inputModel();
		$res = $input ->edit_input($finance);

		if($res){
			$arr_res = array("status"=>"ok","msg"=>"修改成功");
			echo json_encode($arr_res);
			exit;
		}else{
			$arr_res = array("status"=>"failed","msg"=>"修改失败");
			echo json_encode($arr_res);
			exit;
		}
	}elseif($mod == "findpur"){
		$config = new configModel();
		$result=$config->findpur($_POST['type']);
		$html="<label>用途：&nbsp;&nbsp;</label>";
		foreach($result as $r){
			$html.="<label class='am-radio-inline'><input type='radio' value='".$r['id']."' name='purpose' onclick='showpurpose(this)'/>".$r['purpose']."</label>";
		}

		$arr_res = array("status"=>"ok","msg"=>$html);
		echo json_encode($arr_res);
		exit;
	}elseif($mod == "findpurpose"){
		$config = new configModel();
		$result=$config->findpurpose($_POST['type']);
		if(!empty($result)){
			$html="<label>详细用途：&nbsp;&nbsp;</label><select id='doc-ta-1'>";
			foreach($result as $r){
				/*$html.="<label class='am-radio-inline'><input type='radio' value='".$r['pur_name']."' name='purpose' onclick='showpurpose(this)'>".$r['pur_name']."</label>";*/
				$html.="<option value='".$r['pur_name']."'>".$r['pur_name']."</option>";
			}
			$html.="</select>";
		}else{
			$html="<label for='doc-ta-1'>详细用途</label><textarea rows='5' id='doc-ta-1'></textarea>";
		}

		$arr_res = array("status"=>"ok","msg"=>$html);
		echo json_encode($arr_res);
		exit;
	}else{
		$config = new configModel();
		$source = $config -> sel_source();
		$purpose = $config -> sel_purpose();
		include_once $view."public/header.html";
		include_once $view."public/nav.html";
		include_once $view."input.html";
		include_once $view."public/footer.html";
	}



?>