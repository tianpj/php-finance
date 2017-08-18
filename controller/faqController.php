<?php
    include_once $model."groupModel.class.php";
    include_once $model."questionModel.class.php";
    $mod = $_GET['mod'];
    //
    $groupInfo = new faq_group();
    $questionInfo = new faq_question();
    //
    $group = new GroupModel();
    $question = new QuestionModel();
    if($mod == 'addGroup'){
        $res = $group -> getAllGroupNoPage();
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."add_group.html";
        include_once $view."public/footer.html";

    }elseif($mod == 'doAddGroup'){
        $params = $_POST;
        foreach($params as $k=>$v){
            if(!$k){
                exit(json_encode(['status'=>'error','msg'=>'参数不能为空！']));
            }
        }
//        var_dump($params);exit;
        if($params['path']=='selecttip'){
            $groupInfo -> parent_id = 0;
            $groupInfo -> path = '';
        }else{
            $id = substr($params['path'],strrpos($params['path'],',')+1);
            $groupInfo -> parent_id = $id;
            $groupInfo -> path = $params['path'];
        }
        $groupInfo -> group = $params['group'];
        $check = $group -> getGroupByName($params['group']);
        if($check){
            exit(json_encode(['status'=>'failed','msg'=>'该分类已存在！']));
        }
        $res = $group -> addGroup($groupInfo);
        if($res){
            exit(json_encode(['status'=>'success','msg'=>'添加成功！']));
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'添加失败！']));
        }

    }elseif($mod == 'manageGroup'){
        $res = $group -> getAllGroup();
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."group_list.html";
        include_once $view."public/footer.html";

    }elseif($mod == 'editGroup'){
        $id = $_GET['id'];
        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
            exit('参数错误！');
        }
//        $res = $group -> getAllGroup();
        $res_group = $group -> getGroupById($id);
        if(!$res_group){
            exit('未找到该条记录！');
        }
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."edit_group.html";
        include_once $view."public/footer.html";
    }elseif($mod == 'doEditGroup'){
        $group_id = $_GET['id'];

        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($group_id, FILTER_VALIDATE_INT, $int_options)){
            exit(json_encode(['status'=>'error','msg'=>'参数错误！']));
        }
        $params = $_POST;
        foreach($params as $k=>$v){
            if(!$k){
                exit(json_encode(['status'=>'error','msg'=>'参数不能为空！']));
            }
        }
        //
        $groupInfo->id = $group_id;
        $groupInfo->group = $params['group'];
        //
        $res_rec = $group->getGroupById($group_id);
        if($res_rec){
            $groupInfo->parent_id = $res_rec['parent_id'];
            $groupInfo->path = $res_rec['path'];
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'未找到该条记录！']));
        }

        $result = $group -> updateGroup($groupInfo);
        if($result){
            exit(json_encode(['status'=>'success','msg'=>'更新成功！']));
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'更新失败！']));
        }

    }elseif($mod == 'deleteGroup'){
        $id = $_POST['id'];
        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
            exit(json_encode(['status'=>'error','msg'=>'参数错误！']));
        }
        $checkQues = $question -> getQuestionByGroup($id);
        if($checkQues){
            exit(json_encode(['status'=>'failed','msg'=>'该分类下有文章，不可删除！']));
        }
        $checkGroup = $group -> getGroupByPath(','.$id);
        if($checkGroup){
            exit(json_encode(['status'=>'failed','msg'=>'该分类下有子分类，不可删除！']));
        }
        $res = $group -> delGroupById($id);
        if($res){
            exit(json_encode(['status'=>'success','msg'=>'删除成功！']));
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'删除失败！']));
        }

    }elseif($mod == 'addQuestion'){
        $res = $group -> getAllGroupNoPage();
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."add_question.html";
        include_once $view."public/footer.html";
    }elseif($mod == 'doAddQuestion'){
        $params = $_POST;
        foreach($params as $v){
            if(!$v){
                exit(json_encode(['status'=>'error','msg'=>'参数不能为空！']));
            }
        }
        $group_id = substr($params['group_id'],strrpos($params['group_id'],',')+1);
        $questionInfo -> group_id = $group_id;
        $questionInfo -> path = $params['group_id'];
        $questionInfo -> title = $params['title'];
        $questionInfo -> content = $params['content'];
        $res = $question -> addQuestion($questionInfo);
        $check = $group -> getGroupById($group_id);
        if(!$check){
            exit(json_encode(['status'=>'error','msg'=>'分类不存在！']));
        }
        if($res){
            exit(json_encode(['status'=>'success','msg'=>'添加成功！']));
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'添加失败！']));
        }
    }elseif($mod == 'editQuestion'){
        $id = $_GET['id'];
        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
            exit('参数错误！');
        }
        $res = $group -> getAllGroupNoPage();
        $res_ques = $question -> getQuestionById($id);
        if(!$res){
            exit('未找到该条记录！');
        }

        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."edit_question.html";
        include_once $view."public/footer.html";

    }elseif($mod == 'doEditQuestion'){
        $id = $_GET['id'];
        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
            exit('参数错误！');
        }
        $params = $_POST;
        foreach($params as $v){
            if(!$v){
                exit(json_encode(['status'=>'error','msg'=>'参数不能为空！']));
            }
        }
        $questionInfo -> id = $id;
        $questionInfo -> group_id = $params['group_id'];
        $questionInfo -> title = $params['title'];
        $questionInfo -> content = $params['content'];
        $res = $question -> updateQuestion($questionInfo);
        if($res){
            exit(json_encode(['status'=>'success','msg'=>'更新成功！']));
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'更新失败！']));
        }

    }elseif($mod == 'showFaqDetail'){
        $id = $_GET['id'];
        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
            exit('参数错误！');
        }
        $res = $question -> getQuestionById($id);
        $res_group = $group -> getAllGroupNoPage();
        if(!$res){
            exit('未找到该条记录！');
        }
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."show_faqDetail.html";
        include_once $view."public/footer.html";


    }elseif($mod == 'deleteQuestion'){
        $id = $_POST['id'];
        $int_options = array('options'=>array('min_range'=>1));
        if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
            exit(json_encode(['status'=>'error','msg'=>'参数错误！']));
        }
        $res = $question -> delQuestionById($id);
        if($res){
            exit(json_encode(['status'=>'success','msg'=>'删除成功！']));
        }else{
            exit(json_encode(['status'=>'failed','msg'=>'删除失败！']));
        }
    }elseif($mod == 'showFaqByGroup'){
        $param = $_POST['param'];
        $id = substr($param,strrpos($param,',')+1);

        if(empty($id)){
            $res = $question -> getAllQuestion();
            $res_group = $group -> getAllGroupNoPage();
        }else{
            $int_options = array('options'=>array('min_range'=>1));
            if(!filter_var($id, FILTER_VALIDATE_INT, $int_options)){
                exit('参数错误！');
            }
            $check = $group -> getGroupById($id);
            if(!$check){
                exit('未查询到该分类！');
            }
            $res = $question -> getQuestionByPath($id,$param);
            $res_group = $group -> getAllGroupNoPage();
        }

        include_once $view."showFaqByGroup.html";
    }else{
        $res = $question -> getAllQuestion();
        $res_group = $group -> getAllGroupNoPage();

        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."faq_list.html";
        include_once $view."public/footer.html";
    }
?>