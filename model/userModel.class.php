<?php

class userModel{
	
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
    
	//查找用户名
	public function selPwd(){
		
		//var_dump($source);exit;
		try{
			$querystr = "select * from  `fin_user` where id=1";
			$queryobj = $this->db->prepare($querystr);	
			$queryobj -> execute();
			$result = $queryobj -> fetch(PDO::FETCH_ASSOC);
			if($result){
                return $result;
            }else{
                return false;
            }
			
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
	}
	//修改密码用户名
	public function upadtePwd($username,$password,$id){
		try{
			$querystr = "update `fin_user` set `username` =?,`password`=? where `id`=?";	
			$queryobj = $this->db->prepare($querystr);	
			$queryobj -> bindParam(1,$username,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$password,PDO::PARAM_STR);
			$queryobj -> bindParam(3,$id,PDO::PARAM_INT);
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