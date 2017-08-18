<?php

class financeModel{
	
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
	
	//进账
	public function selCome($beginThismonth){
		try{
			$querystr = "select sum(money) as sum from `fin_finance` where type='进账' and f_time > ?";
			$queryobj = $this -> db -> prepare($querystr);
			$queryobj -> bindValue(1,$beginThismonth,PDO::PARAM_STR);
			$queryobj -> execute();
			$res = $queryobj -> fetch(PDO::FETCH_ASSOC);
			if(empty($res['sum'])){
				return '0';
			}else{
				return $res;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
	}
	//出账
	public function selOut($beginThismonth){
		
		//var_dump($source);exit;
		try{
			$querystr = "select sum(money) as sum from `fin_finance` where type='出账' and f_time > ?";
			$queryobj = $this -> db -> prepare($querystr);
			$queryobj -> bindValue(1,$beginThismonth,PDO::PARAM_STR);
			$queryobj -> execute();
			$res = $queryobj -> fetch(PDO::FETCH_ASSOC);
			if(empty($res['sum'])){
				return '0';
			}else{
				return $res;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
	}
	//退款
	public function refund($beginThismonth){
		
		//var_dump($source);exit;
		try{
			$querystr = "select sum(money) as sum from `fin_finance` where type='退款' and f_time > ?";
			$queryobj = $this -> db -> prepare($querystr);
			$queryobj -> bindValue(1,$beginThismonth,PDO::PARAM_STR);
			$queryobj -> execute();
			$res = $queryobj -> fetch(PDO::FETCH_ASSOC);
			if(empty($res['sum'])){
				return '0';
			}else{
				return $res;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		
	}
	
	
	

}
?>