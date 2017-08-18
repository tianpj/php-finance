<?php
include_once $modeldir."pageModel.class.php";
class serverModel{
	public $user;
	public $node;
	public $cpu;
	public $memory;
	public $disk;
	public $line_width;
	public $ip;
	public $sec_ip;
	public $open_time;
	public $end_time;
	public $impi_dress;
	public $impi_account;
	public $impi_pass;
	public $sys_type;
	public $account;
	public $pass;
	public $des;
	public $old_sec_ip;


	private $db;
    /**
     * 构析函数
     */
    public function __construct()
    {
        try {
            $this->db = new PDO(PDO_DSN, PDO_USER, PDO_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
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
	public function add_server(){

		try{
			$sql = "insert into sys_server set user=?,node=?,cpu=?,memory=?,disk=?,line_width=?,ip=?,sec_ip=?,open_time=?,end_time=?,impi_dress=?,impi_account=?,impi_pass=?,sys_type=?,account=?,pass=?,des=?";
			$queryobj = $this->db->prepare($sql);
			$queryobj -> bindParam(1,$this->user,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$this->node,PDO::PARAM_STR);
			$queryobj -> bindParam(3,$this->cpu,PDO::PARAM_STR);
			$queryobj -> bindParam(4,$this->memory,PDO::PARAM_STR);
			$queryobj -> bindParam(5,$this->disk,PDO::PARAM_STR);
			$queryobj -> bindParam(6,$this->line_width,PDO::PARAM_STR);
			$queryobj -> bindParam(7,$this->ip,PDO::PARAM_STR);
			$queryobj -> bindParam(8,$this->sec_ip,PDO::PARAM_STR);
			$queryobj -> bindParam(9,$this->open_time,PDO::PARAM_STR);
			$queryobj -> bindParam(10,$this->end_time,PDO::PARAM_STR);
			$queryobj -> bindParam(11,$this->impi_dress,PDO::PARAM_STR);
			$queryobj -> bindParam(12,$this->impi_account,PDO::PARAM_STR);
			$queryobj -> bindParam(13,$this->impi_pass,PDO::PARAM_STR);
			$queryobj -> bindParam(14,$this->sys_type,PDO::PARAM_STR);
			$queryobj -> bindParam(15,$this->account,PDO::PARAM_STR);
			$queryobj -> bindParam(16,$this->pass,PDO::PARAM_STR);
			$queryobj -> bindParam(17,$this->des,PDO::PARAM_STR);
			$result=$queryobj -> execute();
			if($result){
				return true;
			}else{
				return false;
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function get_all(){

		try{
			$sql = "select * from sys_server where 1=1";
			$page = new PageModel($sql,30);
			$sql = $page -> sqlquery();
			$queryobj = $this->db->prepare($sql);
			$queryobj -> execute();
			$pagelist = $page -> set_page_info();
			$pagenum = $page->datanum;
			$result=$queryobj ->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res_arr = array("result"=>$result,"pagelist"=>$pagelist,"pagenum"=>$pagenum);
				return $res_arr;
			}else{
				return false;
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function get_by_id($id){

		try{
			$sql = "select * from sys_server where id=?";
			$queryobj = $this->db->prepare($sql);
			$queryobj -> bindParam(1,$id,PDO::PARAM_INT);
			$queryobj -> execute();
			$result=$queryobj ->fetch(PDO::FETCH_ASSOC);
			if($result){
				return $result;
			}else{
				return false;
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function del_by_id($id){

		try{
			$sql = "delete from sys_server where id=?";
			$queryobj = $this->db->prepare($sql);
			$queryobj -> bindParam(1,$id,PDO::PARAM_INT);
			$result=$queryobj -> execute();
			if($result){
				return true;
			}else{
				return false;
			}

		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function save_by_id($id){

		try{
			$sql = "update sys_server set user=?,node=?,cpu=?,memory=?,disk=?,line_width=?,ip=?,sec_ip=?,open_time=?,end_time=?,impi_dress=?,impi_account=?,impi_pass=?,sys_type=?,account=?,pass=?,des=?,old_sec_ip=? where id=?";
			$queryobj = $this->db->prepare($sql);
			$queryobj -> bindParam(1,$this->user,PDO::PARAM_STR);
			$queryobj -> bindParam(2,$this->node,PDO::PARAM_STR);
			$queryobj -> bindParam(3,$this->cpu,PDO::PARAM_STR);
			$queryobj -> bindParam(4,$this->memory,PDO::PARAM_STR);
			$queryobj -> bindParam(5,$this->disk,PDO::PARAM_STR);
			$queryobj -> bindParam(6,$this->line_width,PDO::PARAM_STR);
			$queryobj -> bindParam(7,$this->ip,PDO::PARAM_STR);
			$queryobj -> bindParam(8,$this->sec_ip,PDO::PARAM_STR);
			$queryobj -> bindParam(9,$this->open_time,PDO::PARAM_STR);
			$queryobj -> bindParam(10,$this->end_time,PDO::PARAM_STR);
			$queryobj -> bindParam(11,$this->impi_dress,PDO::PARAM_STR);
			$queryobj -> bindParam(12,$this->impi_account,PDO::PARAM_STR);
			$queryobj -> bindParam(13,$this->impi_pass,PDO::PARAM_STR);
			$queryobj -> bindParam(14,$this->sys_type,PDO::PARAM_STR);
			$queryobj -> bindParam(15,$this->account,PDO::PARAM_STR);
			$queryobj -> bindParam(16,$this->pass,PDO::PARAM_STR);
			$queryobj -> bindParam(17,$this->des,PDO::PARAM_STR);
			$queryobj -> bindParam(18,$this->old_sec_ip,PDO::PARAM_STR);
			$queryobj -> bindParam(19,$id,PDO::PARAM_INT);
			$result=$queryobj -> execute();
			if($result){
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