<?php

class configModel{

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

	//查找来源
	public function sel_source(){

		//var_dump($source);exit;
		try{
			$querystr = "select * from  `fin_source`";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> execute();
			$result = $queryobj -> fetchAll();

			if($result){
                return $result;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	//查找用途
	public function sel_purpose(){

		try{
			$querystr = "select * from  `fin_purpose` order by type";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> execute();
			$result = $queryobj -> fetchAll();

			if($result){
                return $result;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	//查找用途详情
	public function sel_pur(){
		try{
			$querystr = "select * from  `fin_pur` order by pur_type";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> execute();
			$result = $queryobj -> fetchAll();

			if($result){
                return $result;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	//根据类型查找用途
	public function findpur($type){
		try{
			$querystr = "select * from  `fin_purpose` where type=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj->bindValue(1,$type,PDO::PARAM_STR);
			$queryobj -> execute();
			$result = $queryobj -> fetchAll(PDO::FETCH_ASSOC);
			if($result){
                return $result;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}


	}
	//根据用途查找详细用途
	public function findpurpose($type){
		try{
			$querystr = "select * from `fin_pur` where pur_type=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj->bindValue(1,$type,PDO::PARAM_STR);
			$queryobj -> execute();
			$result = $queryobj -> fetchAll(PDO::FETCH_ASSOC);
			if($result){
                return $result;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}


	}


    //增加来源
	public function add_source($source){

		//var_dump($source);exit;
		try{
			$querystr = "INSERT INTO `fin_source`( `source`) VALUES (?)";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$source,PDO::PARAM_STR);
			//var_dump($querystr);exit;
			$queryobj -> execute();
			if($queryobj->rowCount() > 0){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}

	//增加用途
	public function add_purpose($purpose,$type){

		try{
			$querystr = "INSERT INTO `fin_purpose`( `purpose`,`type`) VALUES (?,?)";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$purpose,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$type,PDO::PARAM_STR);
			$queryobj -> execute();

			if($queryobj->rowCount() > 0){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	//增加详细用途
	public function add_pur($purpose,$type){

		try{
			$querystr = "INSERT INTO `fin_pur`( `pur_name`,`pur_type`) VALUES (?,?)";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$purpose,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$type,PDO::PARAM_STR);
			$queryobj -> execute();

			if($queryobj->rowCount() > 0){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}

	//删除用途del_purpose

	public function del_purpose($id){

		try{
			$querystr = "DELETE FROM `fin_purpose` WHERE id=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$id,PDO::PARAM_INT);
			$queryobj -> execute();

			if($queryobj->rowCount() > 0){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	//删除详细用途del_pur

	public function del_pur($id){

		try{
			$querystr = "DELETE FROM `fin_pur` WHERE id=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$id,PDO::PARAM_INT);
			$queryobj -> execute();

			if($queryobj->rowCount() > 0){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}


	//删除来源 del_source
	public function  del_source($id){

		try{
			$querystr = "DELETE FROM `fin_source` WHERE id=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$id,PDO::PARAM_INT);
			$queryobj -> execute();

			if($queryobj->rowCount() > 0){
                return true;
            }else{
                return false;
            }


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}

	//修改来源 edit_source

	public function  edit_source($source){

		try{
			$querystr = "update `fin_source` set `source` =?  where `id`=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$source->source,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$source->id,PDO::PARAM_INT);
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


//修改用途
	public function  edit_purpose($purpose){
		try{
			$querystr = "update `fin_purpose` set `purpose` =?  where `id`=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$purpose->purpose,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$purpose->id,PDO::PARAM_INT);
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
	//修改详细用途
	public function  edit_pur($purpose){
		try{
			$querystr = "update `fin_pur` set `pur_name` =?  where `id`=?";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$purpose->pur_name,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$purpose->id,PDO::PARAM_INT);
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