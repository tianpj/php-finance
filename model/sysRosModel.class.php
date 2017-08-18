<?php
class sysRos{

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


    //添加ROS配置信息
    //id,ip_main,ip_second,account,passwd,port,config,code_conf,remark
    public function addSysRos($rosInfo){
        try{
            $querystr = "INSERT INTO `sys_ros` VALUES ('',?,?,?,?,?,?,?,?)";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$rosInfo->ip_main,PDO::PARAM_STR);
            $queryobj -> bindParam(2,$rosInfo->ip_second,PDO::PARAM_STR);
            $queryobj -> bindParam(3,$rosInfo->gateway,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$rosInfo->mask,PDO::PARAM_STR);
            $queryobj -> bindParam(5,$rosInfo->account,PDO::PARAM_STR);
            $queryobj -> bindParam(6,$rosInfo->passwd,PDO::PARAM_STR);
            $queryobj -> bindParam(7,$rosInfo->port,PDO::PARAM_STR);
            $queryobj -> bindParam(8,$rosInfo->remark,PDO::PARAM_STR);
            $queryobj -> execute();
            if($queryobj->rowCount() > 0 ){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

    }

    //查询所有ROS信息
    public function getAllSysRos(){
        try{
            $sql = "select * from `sys_ros` order by `id` desc ";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> execute();
            $result = $queryobj -> fetchAll(PDO::FETCH_ASSOC);
            if($result){
                return $result;
            }else{
                return false;
            }

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //根据ID查询ROS信息
    public function getSysRosById($id){
        try{
            $sql = "select * from `sys_ros` where id= ?";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindParam(1,$id,PDO::PARAM_INT);
            $queryobj -> execute();
            $result = $queryobj -> fetch(PDO::FETCH_ASSOC);
            if($result){
                return $result;
            }else{
                return false;
            }

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //修改ROS
    public function updateSysRos($rosInfo){
        try{
            //id,ip_main,ip_second,account,passwd,port,config,code_conf,remark
            $querystr = "UPDATE `sys_ros` SET `ip_main`=?,`ip_second`=?,`gateway`=?,`mask`=?,`account`=?,`passwd`=?,`port`=?,`remark`=? WHERE `id`=?";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$rosInfo->ip_main,PDO::PARAM_STR);
            $queryobj -> bindParam(2,$rosInfo->ip_second,PDO::PARAM_STR);
            $queryobj -> bindParam(3,$rosInfo->gateway,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$rosInfo->mask,PDO::PARAM_STR);
            $queryobj -> bindParam(5,$rosInfo->account,PDO::PARAM_STR);
            $queryobj -> bindParam(6,$rosInfo->passwd,PDO::PARAM_STR);
            $queryobj -> bindParam(7,$rosInfo->port,PDO::PARAM_STR);
            $queryobj -> bindParam(8,$rosInfo->remark,PDO::PARAM_STR);
            $queryobj -> bindParam(9,$rosInfo->id,PDO::PARAM_INT);
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

    //根据ID删除ROS信息
    public function delSysRosById($id){
        try{
            $sql = "delete from `sys_ros` where id= ?";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindParam(1,$id,PDO::PARAM_INT);
            $queryobj -> execute();
            if($queryobj->rowCount()>0){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function ipRandom($param){
        //IP段
        $ipsection = array('24'=>'253','26'=>'61','27'=>'29','28'=>'13','29'=>'5');
        //
        $str_arr = explode(',',$param);
        //
        foreach($str_arr as $k=>$v){
            $section = substr($v,strrpos($v,'/')+1,2);
            if(!in_array($section,array_keys($ipsection))){
                $sec[] = $v;
            }
        }
        $res = "";
        if(!empty($sec)){
            foreach($sec as $v){
                $res .= $v;
            }
            $result =array("status"=>"error","msg"=>"IP段".$v."设置错误！","info"=>"");
            exit(json_encode($result));
        }
        foreach($str_arr as $key=>$val){
            $str = substr($val,0,strrpos($val,'.'));
            $ipsec = substr($val,strrpos($val,'/')+1,2);
            $start = substr($val,strrpos($val,'.')+1,2);
            foreach($ipsection as $k=>$v){
                if($k==$ipsec){
                    if($k=='24'){
                        for($i=2;$i<=$v+1;$i++){
                            $res_arr[] = "\"".$str.".".$i."\";";
                        }
                    }else{
                        for($i=$start+2;$i<=$start+$v+1;$i++){
                            $res_arr[] = "\"".$str.".".$i."\";";
                        }
                    }
                }
            }
        }
        shuffle($res_arr);
        $res_str = '';
        foreach($res_arr as $k=>$v){
            $res_str .= $v;
        }
        return  ":set Addresses {".$res_str."};";
    }

//
}
?>