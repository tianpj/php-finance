<?php
include_once $model."rosConfigModel.class.php";
$mod = $_GET['mod'];
//
$confInfo = new ros_conf();
$rosConf = new rosConfig();
//
if($mod == 'addRosConf'){
    include_once $view."public/header.html";
    include_once $view."public/nav.html";
    include_once $view."add_rosconf.html";
    include_once $view."public/footer.html";
}elseif($mod == 'doAddRosConf'){
    $params = $_POST;
    foreach($params as $k=>$v){
        if(!$v){
            $res_arr = array('status'=>'error','msg'=>'信息不能为空！');
            exit(json_encode($res_arr));
        }
    }

    //
    $confInfo->name = $params['name'];
    $confInfo->type = $params['type'];
    $confInfo->code = $params['code'];
    $confInfo->remark = $params['remark'];

    $res = $rosConf->addRosConf($confInfo);
    if($res){
        $res_arr = array('status'=>'success','msg'=>'添加成功！');
        exit(json_encode($res_arr));
    }else{
        $res_arr = array('status'=>'fail','msg'=>'添加失败！');
        exit(json_encode($res_arr));
    }

}elseif($mod == 'editRosConf'){
    $id = $_GET['id'];
    $res = $rosConf->getRosConfById($id);
    if($res){
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."edit_rosconf.html";
        include_once $view."public/footer.html";
    }else{
        exit('No Data.');
    }

}elseif($mod == 'doEditRosConf'){
    $params = $_POST;
    foreach($params as $k=>$v){
        if(!$v){
            $res_arr = array('status'=>'error','msg'=>'信息不能为空！');
            exit(json_encode($res_arr));
        }
    }

    $confInfo->id = $_GET['id'];
    $confInfo->name = $params['name'];
    $confInfo->type = $params['type'];
    $confInfo->code = $params['code'];
    $confInfo->remark = $params['remark'];
    $res = $rosConf->updateRosConf($confInfo);
    if($res){
        $res_arr = array('status'=>'success','msg'=>'修改成功！');
        exit(json_encode($res_arr));
    }else{
        $res_arr = array('status'=>'fail','msg'=>'修改失败！');
        exit(json_encode($res_arr));
    }
}elseif($mod == 'deleteRosConf'){
    $id = $_POST['id'];
    $res = $rosConf->delRosConfById($id);
    if($res){
        $res_arr = array('status'=>'success','msg'=>'删除成功！');
        exit(json_encode($res_arr));
    }else{
        $res_arr = array('status'=>'fail','msg'=>'删除失败！');
        exit(json_encode($res_arr));
    }
}else{
    $res = $rosConf->getAllRosConf();

    include_once $view."public/header.html";
    include_once $view."public/nav.html";
    include_once $view."rosconf_list.html";
    include_once $view."public/footer.html";
}
?>