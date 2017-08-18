<?php

class LoginModel{
	
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
    
    //登录
	public function check_agent($user){
		
		try{
			$querystr = "select * from `fin_user` where username = ? and password = ? and status = 1";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> bindParam(1,$user->username,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$user->password,PDO::PARAM_STR);
			$queryobj -> execute();
			$result = $queryobj -> fetch(PDO::FETCH_ASSOC);
			//var_dump($result);exit;
			if($result){
				$user->id = $result['id'];
				$user->username= $result['username'];
				return $result;
			}else{
			
				return false;
			}
			
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
	}
	


}
?>