<?php
    include_once $model."sysRosModel.class.php";
    $mod = $_GET['mod'];
    //
    $rosInfo = new sys_ros();
    $sysRos = new sysRos();
    //
    if($mod == 'addRos'){
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."add_ros.html";
        include_once $view."public/footer.html";
    }elseif($mod == 'doAddRos'){
        $params = $_POST;
        foreach($params as $k=>$v){
            if(!$v){
                $res_arr = array('status'=>'error','msg'=>'信息不能为空！');
                exit(json_encode($res_arr));
            }
        }

        //
        $rosInfo->ip_main = $params['ip_main'];
        $rosInfo->ip_second = $params['ip_second'];
        $rosInfo->gateway = $params['gateway'];
        $rosInfo->mask = $params['mask'];
        $rosInfo->account = $params['account'];
        $rosInfo->passwd = $params['password'];
        $rosInfo->port = $params['port'];
        $rosInfo->config = $params['config'];
        $rosInfo->code_conf = $params['code'];
        $rosInfo->remark = $params['remark'];

        $res = $sysRos->addSysRos($rosInfo);
        if($res){
            $res_arr = array('status'=>'success','msg'=>'添加成功！');
            exit(json_encode($res_arr));
        }else{
            $res_arr = array('status'=>'fail','msg'=>'添加失败！');
            exit(json_encode($res_arr));
        }

    }elseif($mod == 'editRos'){
        $id = $_GET['id'];
        $res = $sysRos->getSysRosById($id);
        if($res){
            include_once $view."public/header.html";
            include_once $view."public/nav.html";
            include_once $view."edit_ros.html";
            include_once $view."public/footer.html";
        }else{
            exit('No Data.');
        }

    }elseif($mod == 'doEditRos'){
        $params = $_POST;
        foreach($params as $k=>$v){
            if(!$v){
                $res_arr = array('status'=>'error','msg'=>'信息不能为空！');
                exit(json_encode($res_arr));
            }
        }

        $rosInfo->id = $_GET['id'];
        $rosInfo->ip_main = $params['ip_main'];
        $rosInfo->ip_second = $params['ip_second'];
        $rosInfo->gateway = $params['gateway'];
        $rosInfo->mask = $params['mask'];
        $rosInfo->account = $params['account'];
        $rosInfo->passwd = $params['password'];
        $rosInfo->port = $params['port'];
        $rosInfo->config = $params['config'];
        $rosInfo->code_conf = $params['code'];
        $rosInfo->remark = $params['remark'];
        $res = $sysRos->updateSysRos($rosInfo);
        if($res){
            $res_arr = array('status'=>'success','msg'=>'修改成功！');
            exit(json_encode($res_arr));
        }else{
            $res_arr = array('status'=>'fail','msg'=>'修改失败！');
            exit(json_encode($res_arr));
        }
    }elseif($mod == 'deleteRos'){
        $id = $_POST['id'];
        $res = $sysRos->delSysRosById($id);
        if($res){
            $res_arr = array('status'=>'success','msg'=>'删除成功！');
            exit(json_encode($res_arr));
        }else{
            $res_arr = array('status'=>'fail','msg'=>'删除失败！');
            exit(json_encode($res_arr));
        }
    }elseif($mod == 'exec'){
        $id = $_GET['id'];
        $res = $sysRos->getSysRosById($id);
        if($res){
            $code = $res['code_conf'];
            //生成rsc文件
            $dir = dirname(__DIR__);
            $filename = $dir.'/rosfiles/'.date('YmdHis',time()).'.rsc';
            $file = fopen($filename,'w');
            fwrite($file,$code);
            fclose($file);
            //执行拷贝
//            exec($dir."/script/scp.exp 22222 ".$filename." admin@120.194.14.117:/ ffy0720@2016 ffy0313..",$out,$return);
            
        }else{
            $res_arr = array('status'=>'error','msg'=>'未找到该条记录！');
            exit(json_encode($res_arr));
        }
    }else{
        $res = $sysRos->getAllSysRos();

        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."ros_list.html";
        include_once $view."public/footer.html";
    }
?>