<?php
    include_once $model."sysRosModel.class.php";
    include_once $model."rosConfigModel.class.php";
    include_once$model.'routeros_api.class.php';

    $mod = $_GET['mod'];
    //
    $sysRos = new sysRos();
    $rosConf = new rosConfig();
    $ros = new RouterosAPI();
    //
    if($mod == 'confExec'){
        $rosid = $_POST['rosid'];
        $confid = $_POST['confid'];
        $rosInfo = $sysRos -> getSysRosById($rosid);
        $confInfo = $rosConf -> getRosConfById($confid);
        if($rosInfo && $confInfo){
            //
            $rosip = $rosInfo['ip_main'];
            $rosname = $rosInfo['account'];
            $rospass = $rosInfo['passwd'];
            $rosport = $rosInfo['port'];
            $code = $confInfo['code'];
            //连接ROS
            if($ros->connect($rosip,$rosname,$rospass)){
                $res = $ros->comm('/ip/service/getall',array("?name"=>'ssh'));
                $id = $res[0]['.id'];
                $ret = $ros->comm('/ip/service/set',array(".id"=>$id,"port"=>$rosport,"disabled"=>"false"));
                if(empty($ret)){
                    //生成rsc文件
                    $dir = dirname(__DIR__);
                    $dirname = $dir.'/rosfiles';
                    if(!is_dir($dirname)){
                        mkdir($dirname);
                    }
                    $name = date('YmdHis',time());
                    $filename = $dirname.'/'.$name.'.rsc';
                    $file = fopen($filename,'w');
                    fwrite($file,$code);
                    fclose($file);
                    //执行文件拷贝
                    exec($dir."/script/scp.exp $rosport ".$filename." $rosip $rospass",$out_c,$return_c);
                    if(!$return_c){
                        exec($dir."/script/ssh.exp $rosport $rosip $rospass \"/import {$name}.rsc\"",$out_e,$return_e);
                        $info_e = "";
                        foreach($out_e as $oe){
                            $info_e.=$oe."<br/>";
                        }
                        if(!$return_e){
                            $res_arr = array('status'=>'success','msg'=>'执行成功！','info'=>$info_e);
                            exit(json_encode($res_arr));
                        }else{
                            $res_arr = array('status'=>'fail','msg'=>'执行失败！','info'=>$info_e);
                            exit(json_encode($res_arr));
                        }
                    }else{
                        $res_arr = array('status'=>'fail','msg'=>'拷贝失败！');
                        exit(json_encode($res_arr));
                    }
                }else{
                    $res_arr = array('status'=>'fail','msg'=>'设置ssh端口失败！');
                    exit(json_encode($res_arr));
                }
            }else{
                $res_arr = array('status'=>'fail','msg'=>'ROS连接失败！');
                exit(json_encode($res_arr));
            }

        }else{
            $res_arr = array('status'=>'fail','msg'=>'ROS或配置信息未找到！');
            exit(json_encode($res_arr));
        }
    }elseif($mod == 'confSelect'){
        $id = $_POST['id'];
        $res = $rosConf -> getRosConfById($id);
        if($res){
            echo $res['code'];
        }else{
            echo '';
        }
    }else{
        $resRos = $sysRos -> getAllSysRos();
        $resConf = $rosConf ->getAllRosConf();

        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."rosconf_exec.html";
        include_once $view."public/footer.html";
    }
?>