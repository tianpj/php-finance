<?php

	date_default_timezone_set('PRC');

	//配置数据库信息
	define("PDO_DSN", "mysql:host=127.0.0.1;dbname=finance;");
	define("PDO_USER", "root");
	define("PDO_PASS", "");


	//定义文件路径
	$control = "./controller/";
	$view = "./view/";
	$model = "./model/";
	$public = "./public/";


	//财务信息详情表
	class finance{
		public $id = "";
		public $money = "";
		public $source = "";
		public $purpose = "";
		public $type = "";
		public $f_time = "";
		public $desc = "";
	}


	//财务用途表
	class purpose{

		public $id = "";
		public $purpose = "";
		public $status = "";

	}

	//财务来源表
	class source{

		public $id = "";
		public $source = "";
		public $status = "";

	}

	class user{
		public $id = "";
		public $username = "";
		public $password = "";
		public $status = "";
	}

	class sys_ros{

		public $id = "";
		public $ip_main = "";
		public $ip_second = "";
		public $gateway = "";
		public $mask = "";
		public $account = "";
		public $passwd = "";
		public $port = "";
		public $config = "";
		public $code_conf = "";
		public $remark = "";
	}
	
	class ros_conf{

		public $id = "";
		public $name = "";
		public $type = "";
		public $code = "";
		public $remark = "";

	}
	
	class faq_group{
		public $id = "";
		public $group = "";
		public $parent_id = "";
		public $path = "";
	}

	class faq_question{
		public $id = "";
		public $group_id = "";
		public $path = "";
		public $title = "";
		public $content = "";
	}
//
?>