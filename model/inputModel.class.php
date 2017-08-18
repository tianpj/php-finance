<?php
include_once $modeldir."pageModel.class.php";
class inputModel{

	private $db;
    /**
     * 构析函数
     */
    public function __construct()
    {
        try {
            $this->db = new PDO(PDO_DSN, PDO_USER, PDO_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
//			var_dump($this->db);
        }
        catch(PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function __destruct()
   	{
       $this->db = null; // Release db connection
   	}

    private function handleException($e)
    {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    //录入信息
	public function add_input($finance){
		try{
			$querystr = "INSERT INTO `fin_finance` VALUES ('',?,?,?,?,?,?)";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$finance->money,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$finance->source,PDO::PARAM_STR);
			$queryobj -> bindParam(3,$finance->purpose,PDO::PARAM_STR);
			$queryobj -> bindParam(4,$finance->type,PDO::PARAM_STR);
			$queryobj -> bindParam(5,$finance->f_time,PDO::PARAM_STR);
			$queryobj -> bindParam(6,$finance->desc,PDO::PARAM_STR);
			$queryobj -> execute();
			if($queryobj->rowCount() !== false){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}

	//查询录入信息
	public function sel_list(){
		try{
			$sql = "select * from `fin_finance` order by `f_time` desc ";
			$page = new PageModel($sql,10);
			$sql = $page -> sqlquery();

			$queryobj = $this->db->prepare($sql);
			$queryobj -> execute();
			$pagelist = $page -> set_page_info();
			$pagenum = $page->datanum;
			$result = $queryobj -> fetchAll();

			if($result){
				$res_arr = array("result"=>$result,"pagelist"=>$pagelist,"pagenum"=>$pagenum);
				return $res_arr;
			}else{
				return false;
			}

    	}catch(PDOException $e){
    		die($e->getMessage());
    	}
	}

	//查询单个信息
	public function sel_fin($id){
		try{
			$sql = "select * from `fin_finance` where id=".$id;
			$queryobj = $this->db->prepare($sql);
			$queryobj -> execute();
			$result = $queryobj -> fetch();
			if($result){
				return $result;
			}else{
				return false;
			}

    	}catch(PDOException $e){
    		die($e->getMessage());
    	}
	}

	//修改录入信息edit_input

	public function edit_input($finance){

		//var_dump($finance);exit;
		try{

			$querystr = "UPDATE `fin_finance` SET `money`=?,`source`=?,`purpose`=?,`type`=?,`f_time`=?,`desc`=? WHERE id=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$finance->money,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$finance->source,PDO::PARAM_STR);
			$queryobj -> bindParam(3,$finance->purpose,PDO::PARAM_STR);
			$queryobj -> bindParam(4,$finance->type,PDO::PARAM_STR);
			$queryobj -> bindParam(5,$finance->f_time,PDO::PARAM_STR);
			$queryobj -> bindParam(6,$finance->desc,PDO::PARAM_STR);
			$queryobj -> bindParam(7,$finance->id,PDO::PARAM_STR);
			$queryobj -> execute();
			if($queryobj->rowCount() !== false){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}


}
?>