<?php
class rosConfig{

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
    public function addRosConf($rosInfo){
        try{
            $querystr = "INSERT INTO `sys_ros_conf` VALUES ('',?,?,?,?)";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$rosInfo->name,PDO::PARAM_STR);
            $queryobj -> bindParam(2,$rosInfo->type,PDO::PARAM_STR);
            $queryobj -> bindParam(3,$rosInfo->code,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$rosInfo->remark,PDO::PARAM_STR);
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

    //查询所有ROS配置信息
    public function getAllRosConf(){
        try{
            $sql = "select * from `sys_ros_conf` order by `id` desc ";
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

    //根据ID查询ROS配置信息
    public function getRosConfById($id){
        try{
            $sql = "select * from `sys_ros_conf` where id= ?";
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

    //修改ROS配置
    public function updateRosConf($rosInfo){
        try{
            $querystr = "UPDATE `sys_ros_conf` SET `name`=?,`type`=?,`code`=?,`remark`=? WHERE `id`=?";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$rosInfo->name,PDO::PARAM_STR);
            $queryobj -> bindParam(2,$rosInfo->type,PDO::PARAM_STR);
            $queryobj -> bindParam(3,$rosInfo->code,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$rosInfo->remark,PDO::PARAM_STR);
            $queryobj -> bindParam(5,$rosInfo->id,PDO::PARAM_INT);
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

    //根据ID删除ROS配置信息
    public function delRosConfById($id){
        try{
            $sql = "delete from `sys_ros_conf` where id= ?";
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

//
}
?>