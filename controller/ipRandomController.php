<?php
    include_once $model."sysRosModel.class.php";
    include_once$model.'routeros_api.class.php';
    $mod = $_GET['mod'];
    //
    $sysRos = new sysRos();
    $ros = new RouterosAPI();
    //
    if($mod == 'getIpOthers'){ //附加IP
        $id = $_POST['id'];
        $res = $sysRos -> getSysRosById($id);
        if($res){
            $str_arr = explode(',',$res['ip_second']);
            foreach($str_arr as $k=>$v){
//                $str .= substr($v,0,strrpos($v,'.'))."<br/>";
                $str .= $v."<br/>";
            }
            echo $str;
        }else{
            exit('');
        }
    }elseif($mod == 'getIpRandom'){ //打乱IP
        $id = $_POST['id'];
        $res = $sysRos -> getSysRosById($id);
        if($res){
            $res_str = $sysRos->ipRandom($res['ip_second']);
            echo $res_str;
        }else{
            exit('');
        }
    }elseif($mod == 'doIpRandom'){
        $rosid = $_POST['rosid'];
        $rosInfo = $sysRos -> getSysRosById($rosid);
        if($rosInfo){
            //
            $rosip = $rosInfo['ip_main'];
            $rosname = $rosInfo['account'];
            $rospass = $rosInfo['passwd'];
            $rosport = $rosInfo['port'];
            $code = $sysRos->ipRandom($rosInfo['ip_second']);
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
                            $res_arr = array('status'=>'failed','msg'=>'执行失败！','info'=>$info_e);
                            exit(json_encode($res_arr));
                        }
                    }else{
                        $res_arr = array('status'=>'failed','msg'=>'拷贝失败！','info'=>'');
                        exit(json_encode($res_arr));
                    }
                }else{
                    $res_arr = array('status'=>'failed','msg'=>'设置ssh端口失败！','info'=>'');
                    exit(json_encode($res_arr));
                }
            }else{
                $res_arr = array('status'=>'failed','msg'=>'ROS连接失败！','info'=>'');
                exit(json_encode($res_arr));
            }

        }else{
            $res_arr = array('status'=>'failed','msg'=>'ROS或配置信息未找到！','info'=>'');
            exit(json_encode($res_arr));
        }
    }else{
        $resRos = $sysRos -> getAllSysRos();
        include_once $view."public/header.html";
        include_once $view."public/nav.html";
        include_once $view."ip_random.html";
        include_once $view."public/footer.html";
    }
?>