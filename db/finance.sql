-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-12-19 18:01:55
-- 服务器版本: 5.5.52-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `finance`
--

-- --------------------------------------------------------

--
-- 表的结构 `faq_group`
--

CREATE TABLE IF NOT EXISTS `faq_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(100) DEFAULT NULL COMMENT '问题类别',
  `parent_id` int(11) DEFAULT NULL COMMENT '上级ID',
  `path` varchar(255) DEFAULT '' COMMENT '类别路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `faq_question`
--

CREATE TABLE IF NOT EXISTS `faq_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL COMMENT '类别ID',
  `path` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='问答表' AUTO_INCREMENT=1;

--
-- 转存表中的数据 `faq_question`
--

-- --------------------------------------------------------

--
-- 表的结构 `fin_alipay`
--

CREATE TABLE IF NOT EXISTS `fin_alipay` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '支付宝编号',
  `trade_id` varchar(255) NOT NULL DEFAULT '' COMMENT '交易号',
  `order_id` varchar(255) NOT NULL DEFAULT '' COMMENT '商户订单号',
  `create_time` datetime DEFAULT NULL COMMENT '交易创建时间',
  `pay_time` datetime DEFAULT NULL COMMENT '付款时间',
  `mod_time` datetime DEFAULT NULL COMMENT '最近修改时间',
  `trade_source` varchar(255) DEFAULT NULL COMMENT '交易来源地',
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `trader` varchar(255) DEFAULT NULL COMMENT '交易对方',
  `goods_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `money` float(7,2) DEFAULT NULL COMMENT '金额',
  `in_out` varchar(255) DEFAULT NULL COMMENT '收支',
  `trade_status` varchar(255) DEFAULT NULL COMMENT '交易状态',
  `service_charge` float(7,2) DEFAULT NULL COMMENT '服务费',
  `refund` float(7,2) DEFAULT NULL COMMENT '退款',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `fund_status` varchar(255) DEFAULT NULL COMMENT '资金状态',
  `account` varchar(255) DEFAULT NULL COMMENT '支付宝数据来源',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='导入支付宝' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `fin_finance`
--

CREATE TABLE IF NOT EXISTS `fin_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '财务编号',
  `money` int(11) NOT NULL COMMENT '金额',
  `source` int(11) NOT NULL COMMENT '来源',
  `purpose` int(11) NOT NULL COMMENT '用途',
  `type` varchar(30) NOT NULL COMMENT '类型',
  `f_time` int(5) NOT NULL DEFAULT '0' COMMENT '时间',
  `desc` text NOT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='财务信息详情表' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `fin_pur`
--

CREATE TABLE IF NOT EXISTS `fin_pur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pur_type` varchar(255) DEFAULT NULL,
  `pur_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `fin_purpose`
--

CREATE TABLE IF NOT EXISTS `fin_purpose` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT '用途编号',
  `type` varchar(255) NOT NULL DEFAULT '1' COMMENT '所属类型',
  `purpose` varchar(255) NOT NULL COMMENT '使用用途',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='财务用途表' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `fin_source`
--

CREATE TABLE IF NOT EXISTS `fin_source` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT '来源编号',
  `source` varchar(30) NOT NULL COMMENT '来源',
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '状态1正常 2不显示',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='财务来源信息表' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `fin_user`
--

CREATE TABLE IF NOT EXISTS `fin_user` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `username` varchar(18) NOT NULL COMMENT '管理员姓名',
  `password` varchar(50) NOT NULL COMMENT '管理员密码',
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '管理员状态1正常，2锁定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员登录表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fin_user`
--

INSERT INTO `fin_user` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sys_ros`
--

CREATE TABLE IF NOT EXISTS `sys_ros` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `ip_main` varchar(50) DEFAULT NULL COMMENT '主ip',
  `ip_second` text COMMENT '附加ip',
  `gateway` varchar(20) DEFAULT NULL COMMENT '网关',
  `mask` varchar(20) DEFAULT NULL COMMENT '掩码',
  `account` varchar(20) DEFAULT NULL COMMENT '帐号',
  `passwd` varchar(20) DEFAULT NULL COMMENT '密码',
  `port` varchar(10) DEFAULT NULL COMMENT '端口',
  `config` tinyint(3) DEFAULT NULL COMMENT '配置类型：1.固定IP；2.动态IP；3.混合IP',
  `code_conf` text COMMENT '配置脚本',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ros表' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `sys_ros_conf`
--

CREATE TABLE IF NOT EXISTS `sys_ros_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '配置名称',
  `type` varchar(20) DEFAULT NULL COMMENT '配置类型',
  `code` text COMMENT '配置脚本',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ros配置表' AUTO_INCREMENT=1 ;



--
-- 表的结构 `sys_server`
--

CREATE TABLE IF NOT EXISTS `sys_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user` varchar(255) DEFAULT NULL COMMENT '所属人',
  `node` varchar(255) DEFAULT NULL COMMENT '地区',
  `cpu` varchar(255) DEFAULT NULL COMMENT 'CPU数',
  `memory` varchar(255) DEFAULT NULL COMMENT '内存',
  `disk` varchar(255) DEFAULT NULL COMMENT '硬盘',
  `line_width` varchar(255) DEFAULT NULL COMMENT '带宽',
  `ip` varchar(255) DEFAULT NULL COMMENT '主IP',
  `sec_ip` varchar(255) DEFAULT NULL COMMENT '附加IP',
  `open_time` datetime DEFAULT NULL COMMENT '开通时间',
  `end_time` varchar(255) DEFAULT NULL COMMENT '到期时间',
  `impi_dress` varchar(255) DEFAULT NULL COMMENT 'IMPI地址',
  `impi_account` varchar(255) DEFAULT NULL COMMENT 'IMPI帐号',
  `impi_pass` varchar(255) DEFAULT NULL COMMENT 'IMPI密码',
  `sys_type` varchar(255) DEFAULT NULL COMMENT '系统类型',
  `account` varchar(255) DEFAULT NULL COMMENT '默认帐号',
  `pass` varchar(255) DEFAULT NULL COMMENT '默认密码',
  `des` text COMMENT '备注',
  `old_sec_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='服务器信息表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `sys_server`
--
 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
