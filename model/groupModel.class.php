<?php
include_once $modeldir.'pageModel.class.php';
class GroupModel{

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


    //添加分类
    public function addGroup($groupInfo){
        try{
            $querystr = "INSERT INTO `faq_group` VALUES ('',?,?,?)";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$groupInfo->group,PDO::PARAM_STR);
            $queryobj -> bindParam(2,$groupInfo->parent_id,PDO::PARAM_INT);
            $queryobj -> bindParam(3,$groupInfo->path,PDO::PARAM_STR);
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

    //查询所有分类
    public function getAllGroup(){
        try{
            $sql = "select *,concat(path,',',id) as fullpath from `faq_group` order by `fullpath` asc";
            $page = new PageModel($sql,15);
            $sql = $page -> sqlquery();
            $queryobj = $this->db->prepare($sql);
            $queryobj -> execute();
            $pagelist = $page -> set_page_info();
            $result = $queryobj -> fetchAll(PDO::FETCH_ASSOC);
            if($result){
                return array('result'=>$result,'pagelist'=>$pagelist);
            }else{
                return false;
            }

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    //查询所有分类
    public function getAllGroupNoPage(){
        try{
            $sql = "select *,concat(path,',',id) as fullpath from `faq_group` order by `fullpath` asc";

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

    //根据ID查询信息
    public function getGroupById($id){
        try{
            $sql = "select * from `faq_group` where id= ?";
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

    //根据ID查询信息
    public function getGroupByPath($path){
        try{
            $sql = "select * from `faq_group` where `path` like ?";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindValue(1,'%'.$path.'%',PDO::PARAM_STR);
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


    //根据名称查询信息
    public function getGroupByName($group){
        try{
            $sql = "select * from `faq_group` where `group`= ?";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindParam(1,$group,PDO::PARAM_STR);
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

    //修改分类
    public function updateGroup($groupInfo){
        try{
            $querystr = "UPDATE `faq_group` SET `group`=?,`parent_id`=?,`path`=? where `id`=?";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$groupInfo->group,PDO::PARAM_STR);
            $queryobj -> bindParam(2,$groupInfo->parent_id,PDO::PARAM_INT);
            $queryobj -> bindParam(3,$groupInfo->path,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$groupInfo->id,PDO::PARAM_INT);
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

    //根据ID删除分类
    public function delGroupById($id){
        try{
            $sql = "delete from `faq_group` where id= ?";
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