<?php
include_once $modeldir."pageModel.class.php";
class QuestionModel{

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


    //添加
    public function addQuestion($faqInfo){
        try{
            $querystr = "INSERT INTO `faq_question` VALUES ('',?,?,?,?)";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$faqInfo->group_id,PDO::PARAM_INT);
            $queryobj -> bindParam(2,$faqInfo->path,PDO::PARAM_STR);
            $queryobj -> bindParam(3,$faqInfo->title,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$faqInfo->content,PDO::PARAM_STR);
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

    //查询所有
    public function getAllQuestion(){
        try{
            $sql = "select * from `faq_question` order by `id` desc ";
            //
            $page = new PageModel($sql,15);
            $sql = $page -> sqlquery();
            //
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

    //根据ID查询信息
    public function getQuestionById($id){
        try{
            $sql = "select * from `faq_question` where `id` = ?";
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
    //根据分类ID查询信息
    public function getQuestionByGroup($groupid){
        try{
            $sql = "select * from `faq_question` where `group_id` = ?";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindValue(1,$groupid,PDO::PARAM_INT);
            $queryobj -> execute();
            $result = $queryobj -> fetchAll(PDO::FETCH_ASSOC);
            if($result){
                return array('result'=>$result);
            }else{
                return false;
            }

        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    //根据分类查询信息
    public function getQuestionByPath($groupid,$path){
        try{
            $sql = "select * from `faq_question` where `group_id` = ? or `path` like ?";
            $sqlstr = "select * from `faq_question` where `group_id` = $groupid or `path` like '%".$path."%'";
            $page = new PageModel($sqlstr,15);
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindValue(1,$groupid,PDO::PARAM_INT);
            $queryobj -> bindValue(2,'%'.$path.'%',PDO::PARAM_STR);
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

    //修改
    public function updateQuestion($faqInfo){
        try{
            $querystr = "UPDATE `faq_question` SET `group_id`=?,`title`=?,`content`=? where `id` = ?";
            $queryobj = $this->db->prepare($querystr);
            $queryobj -> bindParam(1,$faqInfo->group_id,PDO::PARAM_INT);
            $queryobj -> bindParam(2,$faqInfo->title,PDO::PARAM_STR);
            $queryobj -> bindParam(3,$faqInfo->content,PDO::PARAM_STR);
            $queryobj -> bindParam(4,$faqInfo->id,PDO::PARAM_INT);
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
    public function delQuestionById($id){
        try{
            $sql = "delete from `faq_question` where `id`= ?";
            $queryobj = $this->db->prepare($sql);
            $queryobj -> bindValue(1,$id,PDO::PARAM_INT);
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