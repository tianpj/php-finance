<?php

class analysisModel{

	private $db;
    /**
     * 构析函数
     */
    public function __construct()
    {
        try {
            $this->db = new PDO(PDO_DSN, PDO_USER, PDO_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
//			var_dump($this->db);
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

    //查询总计金额
	public function sel_money($days){
		try{
			$dates_arr=array();
			//进账初始化
			$in_money_arr=array();
			//出账初始化
			$out_money_arr=array();
			//退款初始化
			$return_money_arr=array();
			//支付宝入款初始化
			$aliin_money_arr=array();
			//支付宝出款初始化
			$aliout_money_arr=array();
			//支付宝待收款初始化
			$aliwait_money_arr=array();
			for($i=$days-1;$i>=0;$i--){
				//时间
				$day=date('Y-m-d',time()-$i*24*3600);
				$dates_arr[]=$day;
				$btime=strtotime($day);
				$etime=$btime+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				//支付宝入款统计
				$aliin_money_query="select sum(money) as in_money  from `fin_alipay` where fund_status='已收入' and trade_status='交易成功' and pay_time between '".$alibtime."' and '".$alietime."'";
				$aliin_money = $this->db->prepare($aliin_money_query);
				$aliin_money -> execute();
				$aliin_money_res = $aliin_money -> fetch(PDO::FETCH_ASSOC);
				if($aliin_money_res['in_money']==null){
					$aliin_money_arr[]='0';
				}else{
					$aliin_money_arr[]=$aliin_money_res['in_money'];
				}
				//支付宝出款统计
				$aliout_money_query="select sum(money) as out_money  from `fin_alipay` where fund_status='已支出' and pay_time between '".$alibtime."' and '".$alietime."'";
				$aliout_money = $this->db->prepare($aliout_money_query);
				$aliout_money -> execute();
				$aliout_money_res = $aliout_money -> fetch(PDO::FETCH_ASSOC);
				if($aliout_money_res['out_money']==null){
					$aliout_money_arr[]='0';
				}else{
					$aliout_money_arr[]=$aliout_money_res['out_money'];
				}
				//支付宝待收款统计
				$aliwait_money_query="select sum(money) as wait_money  from `fin_alipay` where fund_status='待收入' and pay_time between '".$alibtime."' and '".$alietime."'";
				$aliwait_money = $this->db->prepare($aliwait_money_query);
				$aliwait_money -> execute();
				$aliwait_money_res = $aliwait_money -> fetch(PDO::FETCH_ASSOC);
				if($aliwait_money_res['wait_money']==null){
					$aliwait_money_arr[]='0';
				}else{
					$aliwait_money_arr[]=$aliwait_money_res['wait_money'];
				}

				//进账统计
				$in_money_query="select sum(money) as in_money  from `fin_finance` where type='进账' and f_time>=".$btime." and f_time<=".$etime;
				$in_money = $this->db->prepare($in_money_query);
				$in_money -> execute();
				$in_money_res = $in_money -> fetch(PDO::FETCH_ASSOC);
				if($in_money_res['in_money']==null){
					$in_money_arr[]='0';
				}else{
					$in_money_arr[]=$in_money_res['in_money'];
				}
				//出账统计
				$out_money_query="select sum(money) as out_money  from `fin_finance` where type='出账' and f_time>=".$btime." and f_time<=".$etime;
				$out_money = $this->db->prepare($out_money_query);
				$out_money -> execute();
				$out_money_res = $out_money -> fetch(PDO::FETCH_ASSOC);
				if($out_money_res['out_money']==null){
					$out_money_arr[]='0';
				}else{
					$out_money_arr[]=$out_money_res['out_money'];
				}
				//退款统计
				$return_money_query="select sum(money) as return_money  from `fin_finance` where type='退款' and f_time>=".$btime." and f_time<=".$etime;
				$return_money = $this->db->prepare($return_money_query);
				$return_money -> execute();
				$return_money_res = $return_money -> fetch(PDO::FETCH_ASSOC);
				if($return_money_res['return_money']==null){
					$return_money_arr[]='0';
				}else{
					$return_money_arr[]=$return_money_res['return_money'];
				}

			}
			//日期转化JS数组
			$dates='[';
			foreach($dates_arr as $k){
				$dates.='"'.$k.'",';
			}
			$dates=substr($dates,0,strlen($dates)-1)."]";
			//支付宝入款进账金额转化JS数组
			$aliin_moneys='[';
			foreach($aliin_money_arr as $ai_m){
				$aliin_moneys.=$ai_m.',';
			}
			$aliin_moneys=substr($aliin_moneys,0,strlen($aliin_moneys)-1)."]";
			//支付宝出款进账金额转化JS数组
			$aliout_moneys='[';
			foreach($aliout_money_arr as $ao_m){
				$aliout_moneys.=$ao_m.',';
			}
			$aliout_moneys=substr($aliout_moneys,0,strlen($aliout_moneys)-1)."]";
			//支付宝待入款进账金额转化JS数组
			$aliwait_moneys='[';
			foreach($aliwait_money_arr as $aw_m){
				$aliwait_moneys.=$aw_m.',';
			}
			$aliwait_moneys=substr($aliwait_moneys,0,strlen($aliwait_moneys)-1)."]";
			//进账金额转化JS数组
			$in_moneys='[';
			foreach($in_money_arr as $i_m){
				$in_moneys.=$i_m.',';
			}
			$in_moneys=substr($in_moneys,0,strlen($in_moneys)-1)."]";
			//出账金额转化JS数组
			$out_moneys='[';
			foreach($out_money_arr as $o_m){
				$out_moneys.=$o_m.',';
			}
			$out_moneys=substr($out_moneys,0,strlen($out_moneys)-1)."]";
			//退款金额转化JS数组
			$return_moneys='[';
			foreach($return_money_arr as $r_m){
				$return_moneys.=$r_m.',';
			}
			$return_moneys=substr($return_moneys,0,strlen($return_moneys)-1)."]";
			$result=array(
				"aliin_money"=>$aliin_moneys,
				"aliout_money"=>$aliout_moneys,
				"aliwait_money"=>$aliwait_moneys,
				"in_money"=>$in_moneys,
				"out_money"=>$out_moneys,
				"return_money"=>$return_moneys,
				"date"=>$dates
			);

			//var_dump($result);exit;


			return $result;
		}catch(PDOException $e){
			echo $e->getMessage();
		}


	}

	public function pie($type){

		try{
			if($type=='day'){
				$btime=strtotime(date("Y-m-d",time()));
				$etime=$btime+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				$title='每日分析';
			}elseif($type=='week'){
				$now=strtotime(date("Y-m-d",time()));
				$btime=$now-24*3600*6;
				$etime=$now+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				$title='每周分析';
			}elseif($type=='month'){
				$now=strtotime(date("Y-m-d",time()));
				$btime=$now-24*3600*30;
				$etime=$now+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				$title='每月分析';
			}elseif($type=='tmonth'){
				$now=strtotime(date("Y-m-d",time()));
				$btime=$now-24*3600*90;
				$etime=$now+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				$title='季度分析';
			}elseif($type=='hyear'){
				$now=strtotime(date("Y-m-d",time()));
				$btime=$now-24*3600*180;
				$etime=$now+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				$title='半年分析';
			}elseif($type=='year'){
				$now=strtotime(date("Y-m-d",time()));
				$btime=$now-24*3600*365;
				$etime=$now+24*3600-1;
				$alibtime=date("Y-m-d H:i:s",$btime);
				$alietime=date("Y-m-d H:i:s",$etime);
				$title='每年分析';
			}
			//获取支付宝收款金额
			$ali_in_str="select sum(money) as in_money from `fin_alipay` where fund_status='已收入' and pay_time between '".$alibtime."' and '".$alietime."'";
			$ali_in = $this->db->prepare($ali_in_str);
			$ali_in -> execute();
			$ali_in_res = $ali_in -> fetch(PDO::FETCH_ASSOC);
			if($ali_in_res['in_money']==null){
					$ali_inmoney=0;
				}else{
					$ali_inmoney=$ali_in_res['in_money'];
				}
			//获取支付宝出款金额
			$ali_out_str="select sum(money) as out_money from `fin_alipay` where fund_status='已支出' and pay_time between '".$alibtime."' and '".$alietime."'";
			$ali_out = $this->db->prepare($ali_out_str);
			$ali_out -> execute();
			$ali_out_res = $ali_out -> fetch(PDO::FETCH_ASSOC);
			if($ali_out_res['out_money']==null){
					$ali_outmoney=0;
				}else{
					$ali_outmoney=$ali_out_res['out_money'];
				}
			//获取支付宝待收入金额
			$ali_wait_str="select sum(money) as wait_money from `fin_alipay` where fund_status='待收入' and pay_time between '".$alibtime."' and '".$alietime."'";
			$ali_wait = $this->db->prepare($ali_wait_str);
			$ali_wait -> execute();
			$ali_wait_res = $ali_wait -> fetch(PDO::FETCH_ASSOC);
			if($ali_wait_res['wait_money']==null){
					$ali_waitmoney=0;
				}else{
					$ali_waitmoney=$ali_wait_res['wait_money'];
				}
			//获取进账金额
			$in_money_str="select sum(money) as in_money  from `fin_finance` where type='进账' and f_time>=".$btime." and f_time<=".$etime;
			$in_money = $this->db->prepare($in_money_str);
			$in_money -> execute();
			$in_money_res = $in_money -> fetch(PDO::FETCH_ASSOC);
			if($in_money_res['in_money']==null){
				$inmoney=0;
			}else{
				$inmoney=$in_money_res['in_money'];
			}
			//获取出账金额
			$out_money_str="select sum(money) as out_money  from `fin_finance` where type='出账' and f_time>=".$btime." and f_time<=".$etime;
			$out_money = $this->db->prepare($out_money_str);
			$out_money -> execute();
			$out_money_res = $out_money -> fetch(PDO::FETCH_ASSOC);
			if($out_money_res['out_money']==null){
				$outmoney=0;
			}else{
				$outmoney=$out_money_res['out_money'];
			}
			//获取退款金额
			$return_money_str="select sum(money) as return_money  from `fin_finance` where type='退款' and f_time>=".$btime." and f_time<=".$etime;
			$return_money = $this->db->prepare($return_money_str);
			$return_money -> execute();
			$return_money_res = $return_money -> fetch(PDO::FETCH_ASSOC);
			if($return_money_res['return_money']==null){
				$returnmoney=0;
			}else{
				$returnmoney=$return_money_res['return_money'];
			}
			$result=array(
			"ali_inmoney"=>$ali_inmoney,
			"ali_outmoney"=>$ali_outmoney,
			"ali_waitmoney"=>$ali_waitmoney,
			"inmoney"=>$inmoney,
			"outmoney"=>$outmoney,
			"returnmoney"=>$returnmoney,
			"title"=>$title
			);

			//var_dump($result)	;exit;
			return $result;



		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function getdays(){

		try{
			//获取支付宝导入最早时间
			$querystr1 ="select pay_time from `fin_alipay` where trade_status='交易成功' order by pay_time asc limit 0 ,1";
			$queryobj1 = $this->db->prepare($querystr1);
			$queryobj1 -> execute();
			$result1 = $queryobj1 -> fetch(PDO::FETCH_ASSOC);
			$mintime1= strtotime(date("Y-m-d",strtotime($result1['pay_time'])));
			//获取手动录入最早时间
			$querystr2 ="select f_time from `fin_finance` order by f_time asc limit 0,1";
			$queryobj2 = $this->db->prepare($querystr2);
			$queryobj2 -> execute();
			$result2 = $queryobj2 -> fetch(PDO::FETCH_ASSOC);
			$mintime2= strtotime(date('Y-m-d',$result2['f_time']));
			//比较最早时间并赋值
			if($mintime1<$mintime2){
				$mintime=$mintime1;
			}else{
				$mintime=$mintime2;
			}
			$time=strtotime(date('Y-m-d',time()));
			//计算距今多少天数
			$days=($time-$mintime)/86400+1;
			return $days;
		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function getdata($type,$date){

		try{
			$btime=strtotime($date);
			$etime=$btime+24*3600-1;
			$querystr ="select * from `fin_finance` where type='".$type."' and f_time>=".$btime." and f_time<=".$etime." order by f_time asc";
			$queryobj = $this->db->prepare($querystr);
			$queryobj -> execute();
			$result = $queryobj -> fetchAll(PDO::FETCH_ASSOC);
			return $result;


		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}
	public function getdata2($type,$date){

	try{
		$btime=strtotime($date);
		$etime=$btime+24*3600-1;
		$alibtime=date("Y-m-d H:i:s",$btime);
		$alietime=date("Y-m-d H:i:s",$etime);
		if($type=='支付宝入款'){
			$type='已收入';
		}elseif($type=='支付宝出款'){
			$type='已支出';
		}else{
			$type='待收入';
		}
		$sql="select * from `fin_alipay` where fund_status='".$type."' and pay_time between '".$alibtime."' and '".$alietime."' order by pay_time asc";
		$obj=$this->db->prepare($sql);
		$obj->execute();
		$result=$obj->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}catch(PDOException $e){
		echo $e->getMessage();
	}

}




}
?>