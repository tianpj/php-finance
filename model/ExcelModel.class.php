<?php
	//引入PHPExcel类
	require_once $modeldir."PHPExcel.php";
	require_once $modeldir."PHPExcel/IOFactory.php";
	require_once $modeldir."PHPExcel/Reader/Excel5.php";
	require_once $modeldir."PHPExcel/Reader/Excel2007.php";
	//
class Excel{
	
	private $db;
	
	public function __construct(){
        try {
            $this->db = new PDO(PDO_DSN, PDO_USER, PDO_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
        }
        catch(PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function __destruct(){
       $this->db = null; 
   	}
	
	public function input_file(){
		//获取上传的文件
		$file = $_FILES['excel'];
		$account = $_POST['account'];
//		var_dump($account);exit;
		//文件上传路径
		$filePath = "upload/";
		//
		if(!$file['error']){
			//获取文件类型
			$fileType = strtolower(substr($file['name'],strrpos($file['name'],".")+1));
//			var_dump($fileType);exit;
			//支持的文件格式
			$type_arr = array("xlsx","xls","csv");
			//判断文件类型
			if(in_array($fileType,$type_arr)){
				//新的文件名
				$newFile = time().rand(1,9999).".".$fileType;
				//上传文件到指定目录
				if(move_uploaded_file($file['tmp_name'], $filePath.$newFile)){
					//创建Reader对象
					if($fileType=="csv"){
						$objReader = PHPExcel_IOFactory::createReader('CSV')->setInputEncoding('GBK');
					}else{						
						$objReader = PHPExcel_IOFactory::createReader('excel2007');
					}
	//				var_dump($objReader);exit;
					//加载文件
					$objExcel = $objReader->load($filePath.$newFile);
					//获取sheet对象
					$sheet = $objExcel -> getSheet(0);
					//获取总行数
					$rows = $sheet -> getHighestRow();
					//获取总列数
					$cols = $sheet -> getHighestColumn();
					//从第二行开始，逐行读取
					for($i=2; $i<=$rows; $i++){
						$str = "";
						for($j='A'; $j<=$cols; $j++){
							$str .= $objExcel -> getActiveSheet() -> getCell("$j$i") ->getValue()."@@";
						}
						$str_arr = explode("@@", $str);
						$res = $this->check_data($str_arr[1]);
//						var_dump($res);exit;
						if($res){
							$sql = "update `fin_alipay` set `trade_id`=?,`order_id`=?,`create_time`=?,`pay_time`=?,`mod_time`=?,`trade_source`=?,`type`=?,`trader`=?,`goods_name`=?,`money`=?,`in_out`=?,`trade_status`=?,`service_charge`=?,`refund`=?,`remark`=?,`fund_status`=?,`account`=? where `order_id`=?";
							$queryobj = $this -> db ->prepare($sql);
							$queryobj -> bindValue(1,$str_arr[0],PDO::PARAM_STR);
							$queryobj -> bindValue(2,$str_arr[1],PDO::PARAM_STR);
							$queryobj -> bindValue(3,$str_arr[2],PDO::PARAM_STR);
							$queryobj -> bindValue(4,$str_arr[3],PDO::PARAM_STR);
							$queryobj -> bindValue(5,$str_arr[4],PDO::PARAM_STR);
							$queryobj -> bindValue(6,$str_arr[5],PDO::PARAM_STR);
							$queryobj -> bindValue(7,$str_arr[6],PDO::PARAM_STR);
							$queryobj -> bindValue(8,$str_arr[7],PDO::PARAM_STR);
							$queryobj -> bindValue(9,$str_arr[8],PDO::PARAM_STR);
							$queryobj -> bindValue(10,$str_arr[9],PDO::PARAM_INT);
							$queryobj -> bindValue(11,$str_arr[10],PDO::PARAM_STR);
							$queryobj -> bindValue(12,$str_arr[11],PDO::PARAM_STR);
							$queryobj -> bindValue(13,$str_arr[12],PDO::PARAM_INT);
							$queryobj -> bindValue(14,$str_arr[13],PDO::PARAM_INT);
							$queryobj -> bindValue(15,$str_arr[14],PDO::PARAM_STR);
							$queryobj -> bindValue(16,$str_arr[15],PDO::PARAM_STR);
							$queryobj -> bindValue(17,$account,PDO::PARAM_STR);
							$queryobj -> bindValue(18,$str_arr[1],PDO::PARAM_STR);
//							var_dump($queryobj);exit;
						}else{
							$sql = "insert into `fin_alipay` values('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$queryobj = $this -> db ->prepare($sql);
							$queryobj -> bindValue(1,$str_arr[0],PDO::PARAM_STR);
							$queryobj -> bindValue(2,$str_arr[1],PDO::PARAM_STR);
							$queryobj -> bindValue(3,$str_arr[2],PDO::PARAM_STR);
							$queryobj -> bindValue(4,$str_arr[3],PDO::PARAM_STR);
							$queryobj -> bindValue(5,$str_arr[4],PDO::PARAM_STR);
							$queryobj -> bindValue(6,$str_arr[5],PDO::PARAM_STR);
							$queryobj -> bindValue(7,$str_arr[6],PDO::PARAM_STR);
							$queryobj -> bindValue(8,$str_arr[7],PDO::PARAM_STR);
							$queryobj -> bindValue(9,$str_arr[8],PDO::PARAM_STR);
							$queryobj -> bindValue(10,$str_arr[9],PDO::PARAM_INT);
							$queryobj -> bindValue(11,$str_arr[10],PDO::PARAM_STR);
							$queryobj -> bindValue(12,$str_arr[11],PDO::PARAM_STR);
							$queryobj -> bindValue(13,$str_arr[12],PDO::PARAM_INT);
							$queryobj -> bindValue(14,$str_arr[13],PDO::PARAM_INT);
							$queryobj -> bindValue(15,$str_arr[14],PDO::PARAM_STR);
							$queryobj -> bindValue(16,$str_arr[15],PDO::PARAM_STR);
							$queryobj -> bindValue(17,$account,PDO::PARAM_STR);
						}
						$queryobj -> execute();
						$res = $queryobj -> rowCount();
					}
					if($res !== false){
						unlink($filePath.$newFile);
						return true;
					}else{
						return false;
					}
				}else{
					exit("文件上传失败！");
				}
			}else{
				exit("只支持xlsx、xls、csv格式的Excel文件！");
			}
		}else{
			exit("文件上传错误！");
		}
	}

	public function check_data($order){
		
		try{
			$sql = "select * from `fin_alipay` where `order_id` = ?";
			$sqlobj = $this->db -> prepare($sql);
			$sqlobj -> bindValue(1,$order,PDO::PARAM_STR);
			$sqlobj -> execute();
			$res = $sqlobj ->fetch(PDO::FETCH_ASSOC);
			if($res){
				return true;
			}else{
				return false;
			}
		}catch(PDOException $e){
			exit($e -> getMessage());
		}
		
	}
//	
}
?>