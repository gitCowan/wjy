set charset utf8;
CREATE TABLE `wp_accountinfo` (
  `aid` int(50) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `balance` double(24,2) DEFAULT '0.00' COMMENT '账号余额',
  `frozen` double(255,0) DEFAULT NULL COMMENT '冻结金额',
  `pwd` varchar(50) DEFAULT NULL COMMENT '交易密码',
  PRIMARY KEY (`aid`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=221 DEFAULT CHARSET=utf8;
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('197','298','560565.70','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('198','303','271841.30','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('199','290','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('200','292','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('201','295','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('202','294','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('203','305','49927.50','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('204','302','44180.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('205','299','49490.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('206','302','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('207','306','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('208','309','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('209','312','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('210','311','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('211','315','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('212','316','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('213','314','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('214','317','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('215','313','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('216','319','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('217','320','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('218','318','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('219','321','0.00','','');
insert into `wp_accountinfo`(`aid`,`uid`,`balance`,`frozen`,`pwd`) values('220','323','0.00','','');
CREATE TABLE `wp_api` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `cid` varchar(8) DEFAULT NULL,
  `price` varchar(10) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `code` char(100) DEFAULT NULL,
  `high` char(100) DEFAULT NULL COMMENT '最高',
  `open` char(100) DEFAULT NULL COMMENT '今开',
  `low` char(100) DEFAULT NULL COMMENT '最低',
  `close` char(100) DEFAULT NULL COMMENT '昨开',
  `diff` char(50) DEFAULT NULL,
  `diffRate` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`) USING BTREE,
  KEY `code` (`code`) USING BTREE,
  KEY `time` (`time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12587987 DEFAULT CHARSET=utf8;
CREATE TABLE `wp_apiss` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `cid` varchar(8) DEFAULT NULL,
  `price` varchar(10) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `code` char(100) DEFAULT NULL,
  `high` char(100) DEFAULT NULL COMMENT '最高',
  `open` char(100) DEFAULT NULL COMMENT '今开',
  `low` char(100) DEFAULT NULL COMMENT '最低',
  `close` char(100) DEFAULT NULL COMMENT '昨开',
  `diff` char(50) DEFAULT NULL,
  `diffRate` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48133 DEFAULT CHARSET=utf8;
CREATE TABLE `wp_balance` (
  `bpid` int(11) NOT NULL AUTO_INCREMENT,
  `bptype` varchar(255) DEFAULT NULL COMMENT '收支类型',
  `bptime` int(20) DEFAULT NULL COMMENT '操作时间',
  `bpprice` double DEFAULT NULL COMMENT '收支',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `uid` int(11) DEFAULT NULL,
  `isverified` int(11) DEFAULT NULL COMMENT '判断申请是否通过，0未通过，1通过',
  `cltime` int(20) DEFAULT NULL COMMENT '审核时间',
  `bpno` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`bpid`)
) ENGINE=MyISAM AUTO_INCREMENT=1839 DEFAULT CHARSET=utf8;
insert into `wp_balance`(`bpid`,`bptype`,`bptime`,`bpprice`,`remarks`,`uid`,`isverified`,`cltime`,`bpno`) values('1838','充值','1490775412','100','开始充值','313','','','1490775412524');
insert into `wp_balance`(`bpid`,`bptype`,`bptime`,`bpprice`,`remarks`,`uid`,`isverified`,`cltime`,`bpno`) values('1837','充值','1490775145','30000','开始充值','305','','','1490775145575');
insert into `wp_balance`(`bpid`,`bptype`,`bptime`,`bpprice`,`remarks`,`uid`,`isverified`,`cltime`,`bpno`) values('1836','充值','1490772040','100','开始充值','314','','','1490772040565');
CREATE TABLE `wp_bankinfo` (
  `bid` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '绑定',
  `bankname` varchar(20) NOT NULL COMMENT '所属银行',
  `province` varchar(20) NOT NULL COMMENT '省份',
  `city` varchar(20) NOT NULL COMMENT '城市',
  `branch` varchar(20) NOT NULL COMMENT '支行名',
  `banknumber` varchar(20) NOT NULL COMMENT '银行卡号',
  `busername` varchar(20) NOT NULL COMMENT '姓名',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
CREATE TABLE `wp_bournal` (
  `bno` varchar(100) NOT NULL COMMENT '提现/充值编号',
  `btype` varchar(20) DEFAULT NULL COMMENT '银行名称',
  `btime` int(20) DEFAULT NULL COMMENT '操作时间',
  `bprice` double(20,2) DEFAULT NULL COMMENT '提现/充值金额',
  `uid` int(20) DEFAULT NULL COMMENT '持卡人名称',
  `username` varchar(20) DEFAULT NULL COMMENT '用户名',
  `isverified` int(10) DEFAULT NULL,
  `balance` double(20,2) DEFAULT '0.00' COMMENT '账户余额'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `wp_catproduct` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `myat` double(11,1) DEFAULT '10.0' COMMENT '点差*',
  `myatjia` double(11,2) DEFAULT '0.00' COMMENT '点差+',
  `ask` double(11,2) DEFAULT '0.00' COMMENT '现在的价格',
  `high` double(11,2) DEFAULT '0.00' COMMENT '最高',
  `low` double(11,2) DEFAULT '0.00' COMMENT '最低',
  `open` double(11,2) DEFAULT '0.00' COMMENT '今开',
  `close` double(11,2) DEFAULT '0.00' COMMENT '昨收',
  `eidtime` int(20) DEFAULT NULL COMMENT '更新时间',
  `title` varchar(50) DEFAULT NULL,
  `unit` char(100) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('15','AG','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','XAG','','0');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('26','Gold','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','XAU','','0');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('28','WTI','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','CONO','','0');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('30','比特币','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','BIT','','0');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('39','英镑美元','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','GBPUSD','','1');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('41','美元日元','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','USDJPY','','1');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('42','欧元美元','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','EURUSD','','1');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('43','澳元美元','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','AUDUSD','','1');
insert into `wp_catproduct`(`cid`,`cname`,`myat`,`myatjia`,`ask`,`high`,`low`,`open`,`close`,`eidtime`,`title`,`unit`,`status`) values('44','美元瑞士法郎','10.0','0.00','0.00','0.00','0.00','0.00','0.00','','USDCHF','','0');
CREATE TABLE `wp_commission` (
  `comid` int(11) NOT NULL AUTO_INCREMENT,
  `ustyle` int(11) DEFAULT '0' COMMENT '状态，0显示，1是不显示',
  `rebate` double(11,2) DEFAULT NULL COMMENT '佣金',
  `cotime` int(20) DEFAULT NULL COMMENT '提现时间',
  `uid` int(11) DEFAULT NULL COMMENT '提线人id',
  PRIMARY KEY (`comid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `wp_diymen_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `keyword` varchar(256) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
insert into `wp_diymen_class`(`id`,`token`,`pid`,`title`,`keyword`,`is_show`,`sort`,`url`) values('17','','17','会员','','0','1','http://www.lihaijun8888.com/index.php/Home/User/memberinfo.html');
insert into `wp_diymen_class`(`id`,`token`,`pid`,`title`,`keyword`,`is_show`,`sort`,`url`) values('15','','0','交易','','0','3','http://www.lihaijun8888.com/index.php/Home/Detailed/dtrading.html');
insert into `wp_diymen_class`(`id`,`token`,`pid`,`title`,`keyword`,`is_show`,`sort`,`url`) values('14','','0','首页','','0','4','http://www.lihaijun8888.com/index.php/Home/Index/index.html');
CREATE TABLE `wp_diymen_zhifu_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `keyword` varchar(256) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
CREATE TABLE `wp_experience` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `eprice` int(11) DEFAULT NULL,
  `limittime` int(11) DEFAULT '0' COMMENT '时限',
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
insert into `wp_experience`(`eid`,`eprice`,`limittime`) values('16','100','3');
insert into `wp_experience`(`eid`,`eprice`,`limittime`) values('17','100','3');
CREATE TABLE `wp_experienceinfo` (
  `exid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `eid` int(11) DEFAULT NULL,
  `exgtime` int(20) DEFAULT NULL COMMENT '领卷时间',
  `endtime` int(30) DEFAULT NULL COMMENT '过期时间',
  `getstyle` int(11) DEFAULT NULL COMMENT '状态',
  `getway` varchar(50) DEFAULT NULL COMMENT '获得途径',
  PRIMARY KEY (`exid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('2','12','2','1487555487','1488419487','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('3','12','3','1487555531','1488419531','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('4','12','3','1487555602','1488419602','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('5','12','3','1487555609','1488419609','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('6','12','3','1487555616','1488419616','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('7','12','3','1487555623','1488419623','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('8','12','3','1487555631','1488419631','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('9','12','4','1487555750','1488419750','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('10','12','4','1487555757','1488419757','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('11','12','4','1487555767','1488419767','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('12','12','4','1487555783','1488419783','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('13','12','4','1487555790','1488419790','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('14','12','4','1487555798','1488419798','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('15','12','4','1487555805','1488419805','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('16','12','4','1487555812','1488419812','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('17','12','4','1487555818','1488419818','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('18','12','4','1487556973','1488420973','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('19','12','4','1487556979','1488420979','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('20','22','5','1487560504','1488424504','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('21','22','3','1487560511','1488424511','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('22','22','4','1487560519','1488424519','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('23','25','5','1487560528','1488424528','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('24','25','3','1487560541','1488424541','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('25','25','4','1487560549','1488424549','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('26','12','1','1487592781','1488456781','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('27','49','6','1490247721','1490420521','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('28','49','8','1490247768','1490334168','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('29','49','8','1490247962','1490334362','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('30','303','9','1490696949','1490783349','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('31','303','10','1490697053','1490783453','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('32','303','10','1490697149','1490783549','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('33','303','10','1490697155','1490783555','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('34','303','10','1490750348','1490836748','0','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('35','298','13','1490753011','1491185011','1','后台发放');
insert into `wp_experienceinfo`(`exid`,`uid`,`eid`,`exgtime`,`endtime`,`getstyle`,`getway`) values('36','298','14','1490753074','1491012274','0','后台发放');
CREATE TABLE `wp_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jno` varchar(255) NOT NULL COMMENT '日志编号',
  `uid` int(11) DEFAULT NULL,
  `jtype` varchar(255) DEFAULT NULL COMMENT '操作类型，建仓，平仓',
  `jtime` int(20) DEFAULT NULL COMMENT '操作时间',
  `jincome` double(255,2) DEFAULT NULL COMMENT '收支金额',
  `number` int(11) DEFAULT NULL COMMENT '手数',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注：',
  `balance` double(255,2) DEFAULT NULL COMMENT '记录当时用户余额',
  `jstate` int(11) DEFAULT NULL COMMENT '0亏损，1盈利',
  `jusername` varchar(20) DEFAULT NULL COMMENT '用户名',
  `jostyle` int(11) DEFAULT NULL COMMENT '0涨，1跌',
  `juprice` double(11,2) DEFAULT NULL COMMENT '产品单价',
  `jfee` double(11,1) DEFAULT NULL COMMENT '手续费',
  `jbuyprice` double(11,2) DEFAULT NULL COMMENT '进仓价',
  `jsellprice` double(11,2) DEFAULT NULL COMMENT '平仓价',
  `jaccess` double(11,2) DEFAULT NULL COMMENT '出入金额',
  `jploss` double(11,2) DEFAULT NULL COMMENT '盈亏金额',
  `oid` int(10) DEFAULT NULL COMMENT '订单id',
  `pid` int(10) DEFAULT NULL COMMENT '代理商客户',
  `storage` double(11,2) DEFAULT NULL COMMENT '储仓费',
  `explain` char(50) DEFAULT NULL,
  `type` int(1) DEFAULT NULL COMMENT '1自动 2手动 3一键 4后台 ',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2486 DEFAULT CHARSET=utf8;
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2404','1490668843985','298','建仓','1490668843','600.00','3','美汇英镑','9400.00','0','﹍Mr.王℡','1','200.00','60.0','1.26','','-600.00','','1206','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2405','1490668960485','298','平仓','1490668960','540.00','3','美汇英镑','9940.00','0','﹍Mr.王℡','1','200.00','60.0','1.26','1.26','540.00','0.00','1206','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2406','1490669045531','298','建仓','1490669045','1000.00','5','美汇英镑','8940.00','0','﹍Mr.王℡','1','200.00','100.0','1.26','','-1000.00','','1207','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2407','1490669383559','298','平仓','1490669383','700.00','5','美汇英镑','9640.00','0','﹍Mr.王℡','1','200.00','100.0','1.26','1.26','700.00','-200.00','1207','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2408','1490669401579','298','建仓','1490669401','200.00','1','美汇英镑','9440.00','0','﹍Mr.王℡','1','200.00','20.0','1.26','','-200.00','','1208','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2409','1490670178505','298','平仓','1490670178','20.00','1','美汇英镑','9460.00','0','﹍Mr.王℡','1','200.00','20.0','1.26','1.26','20.00','-160.00','1208','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2415','1490686081495','298','建仓','1490686081','200.00','1','美汇英镑','9260.00','0','﹍Mr.王℡','0','200.00','0.0','1.26','','-200.00','','1212','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2416','1490686106975','298','平仓','1490686106','205.00','1','美汇英镑','9465.00','1','﹍Mr.王℡','0','200.00','20.0','1.26','1.26','205.00','25.00','1212','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2417','1490686234974','298','建仓','1490686234','200.00','1','美汇英镑','9265.00','0','﹍Mr.王℡','1','200.00','0.0','1.26','','-200.00','','1213','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2418','1490686469535','298','平仓','1490686469','20.00','1','美汇英镑','9285.00','0','﹍Mr.王℡','1','200.00','20.0','1.26','1.26','20.00','-160.00','1213','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2419','1490686968565','298','建仓','1490686968','200.00','1','美汇英镑','9085.00','0','﹍Mr.王℡','0','200.00','0.0','1.26','','-200.00','','1214','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2420','1490687156524','298','平仓','1490687156','20.00','1','美汇英镑','9105.00','0','﹍Mr.王℡','0','200.00','20.0','1.26','1.26','20.00','-160.00','1214','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2473','1490767710101','302','平仓','1490767710','0.00','10','美元英镑','44180.00','0','','0','100.00','200.0','123994.00','123911.00','0.00','-800.00','1239','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2422','1490690141100','305','建仓','1490690141','200.00','1','美汇英镑','49800.00','0','吴洋','1','200.00','0.0','1.26','','-200.00','','1216','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2423','1490690155985','305','平仓','1490690155','205.00','1','美汇英镑','50005.00','1','吴洋','1','200.00','20.0','1.26','1.26','205.00','25.00','1216','','','平仓','2');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2475','1490769124525','299','建仓','1490769124','1000.00','10','美元英镑','49000.00','0','幕慕墓幕','1','100.00','200.0','123905.00','','-1000.00','','1242','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2425','1490692991102','298','建仓','1490692991','200.00','1','美汇英镑','8405.00','0','﹍Mr.王℡','0','200.00','0.0','125880.00','','-200.00','','1217','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2426','1490693008489','298','平仓','1490693008','20.00','1','美汇英镑','8425.00','0','﹍Mr.王℡','0','200.00','20.0','125880.00','125875.00','20.00','-160.00','1217','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2474','1490768043985','298','建仓','1490768043','1000.00','10','美元英镑','560665.70','0','﹍Mr.王℡','1','100.00','200.0','123907.00','','-1000.00','','1241','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2428','1490694754504','298','建仓','1490694754','100.00','1','美元英镑','561286.70','0','﹍Mr.王℡','0','100.00','0.0','125666.00','','-100.00','','1218','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2429','1490694823554','298','平仓','1490694823','0.00','1','美元英镑','561286.70','0','﹍Mr.王℡','0','100.00','20.0','125666.00','125649.00','0.00','-80.00','1218','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2430','1490694871559','298','建仓','1490694871','100.00','1','美元英镑','561186.70','0','﹍Mr.王℡','0','100.00','0.0','125637.00','','-100.00','','1219','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2431','1490695193579','298','建仓','1490695193','1000.00','10','欧元美元','560186.70','0','﹍Mr.王℡','1','100.00','0.0','108582.00','','-1000.00','','1220','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2432','1490695225571','298','建仓','1490695225','800.00','8','美元日元','559386.70','0','﹍Mr.王℡','1','100.00','0.0','110699.00','','-800.00','','1221','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2433','1490695509531','302','建仓','1490695509','500.00','5','美元英镑','49500.00','0','大卿                  ','0','100.00','0.0','125659.00','','-500.00','','1222','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2434','1490695596991','302','平仓','1490695596','420.00','5','美元英镑','49920.00','0','大卿                  ','0','100.00','100.0','125659.00','125667.00','420.00','20.00','1222','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2435','1490695785579','302','建仓','1490695785','1000.00','10','美元英镑','48920.00','0','大卿                  ','0','100.00','0.0','125656.00','','-1000.00','','1223','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2436','1490695932999','298','平仓','1490695932','872.00','8','美元日元','560258.70','1','﹍Mr.王℡','1','100.00','160.0','110699.00','110670.00','872.00','232.00','1221','','','平仓','4');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2437','1490695943555','298','平仓','1490695943','129.00','1','美元英镑','560387.70','1','﹍Mr.王℡','0','100.00','20.0','125637.00','125686.00','129.00','49.00','1219','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2438','1490695943555','298','平仓','1490695943','570.00','10','欧元美元','560828.70','0','﹍Mr.王℡','1','100.00','200.0','108582.00','108605.00','570.00','-230.00','1220','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2439','1490696146509','302','平仓','1490696146','1190.00','10','美元英镑','50110.00','1','大卿                  ','0','100.00','200.0','125656.00','125695.00','1190.00','390.00','1223','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2440','1490696207102','298','建仓','1490696207','100.00','1','美元英镑','560857.70','0','﹍Mr.王℡','1','100.00','0.0','125699.00','','-100.00','','1224','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2441','1490696234971','302','建仓','1490696234','2000.00','20','美元英镑','48110.00','0','大卿                  ','1','100.00','0.0','125708.00','','-2000.00','','1225','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2442','1490696256485','305','建仓','1490696256','100.00','1','美元英镑','49905.00','0','吴洋','1','100.00','0.0','125707.00','','-100.00','','1226','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2443','1490696448489','302','建仓','1490696448','1000.00','10','美元英镑','47110.00','0','大卿                  ','0','100.00','0.0','125709.00','','-1000.00','','1227','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2444','1490696485539','302','建仓','1490696485','2000.00','20','美元英镑','45110.00','0','大卿                  ','0','100.00','0.0','125727.00','','-2000.00','','1228','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2445','1490696809575','302','建仓','1490696809','3000.00','30','美元英镑','42110.00','0','大卿                  ','0','100.00','0.0','125677.00','','-3000.00','','1229','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2481','1490772730975','298','平仓','1490772730','0.00','1','澳元美元','560565.70','0','﹍Mr.王℡','1','100.00','20.0','76408.00','76492.00','0.00','-80.00','1244','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2482','1490774882505','305','建仓','1490774882','100.00','1','美元日元','49986.50','0','吴洋','1','100.00','20.0','111115.00','','-100.00','','1245','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2483','1490775305575','305','平仓','1490775305','0.00','1','美元日元','49986.50','0','吴洋','1','100.00','20.0','111115.00','111198.00','0.00','-80.00','1245','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2484','1490775862545','305','建仓','1490775862','100.00','1','美元日元','49886.50','0','吴洋','0','100.00','20.0','111133.00','','-100.00','','1246','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2485','1490776225495','305','平仓','1490776225','41.00','1','美元日元','49927.50','0','吴洋','0','100.00','20.0','111133.00','111094.00','41.00','-39.00','1246','','','平仓','2');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2452','1490698245535','305','建仓','1490698245','0.00','0','美元英镑','49905.00','0','吴洋','1','0.00','0.0','125615.00','','0.00','','1234','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2453','1490698345571','302','平仓','1490698345','0.00','20','美元英镑','42110.00','0','大卿                  ','0','100.00','400.0','125727.00','125557.00','0.00','-1600.00','1228','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2454','1490698348994','302','平仓','1490698348','0.00','10','美元英镑','42110.00','0','大卿                  ','0','100.00','200.0','125709.00','125550.00','0.00','-800.00','1227','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2455','1490698718101','302','平仓','1490698718','0.00','30','美元英镑','42110.00','0','大卿                  ','0','100.00','600.0','125677.00','125516.00','0.00','-2400.00','1229','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2456','1490699093539','302','平仓','1490699093','3070.00','20','美元英镑','45180.00','1','大卿                  ','1','100.00','400.0','125708.00','125561.00','3070.00','1470.00','1225','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2472','1490754484525','298','平仓','1490754484','0.00','1','美元日元','561665.70','0','﹍Mr.王℡','0','100.00','0.0','111285.00','111200.00','0.00','0.00','1240','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2478','1490769520485','299','平仓','1490769520','830.00','10','美元英镑','49490.00','0','幕慕墓幕','0','100.00','200.0','123897.00','123900.00','830.00','30.00','1243','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2479','1490770210505','298','建仓','1490770210','100.00','1','澳元美元','560565.70','0','﹍Mr.王℡','1','100.00','20.0','76408.00','','-100.00','','1244','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2480','1490770784489','298','平仓','1490770784','0.00','10','美元英镑','560565.70','0','﹍Mr.王℡','1','100.00','200.0','123907.00','123989.00','0.00','-800.00','1241','','','平仓','1');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2461','1490704744564','305','平仓','1490704744','0.00','0','美元英镑','49905.00','0','吴洋','1','100.00','0.0','125615.00','125512.00','0.00','0.00','1234','','','平仓','2');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2462','1490704750101','305','平仓','1490704750','181.50','1','美元英镑','50086.50','1','吴洋','1','100.00','20.0','125707.00','125504.00','181.50','101.50','1226','','','平仓','2');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2463','1490751049579','298','建仓','1490751049','900.00','9','美元英镑','559957.70','0','﹍Mr.王℡','0','100.00','180.0','124059.00','','-900.00','','1237','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2476','1490769245100','299','平仓','1490769245','660.00','10','美元英镑','49660.00','0','幕慕墓幕','1','100.00','200.0','123905.00','123919.00','660.00','-140.00','1242','','','平仓','3');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2477','1490769453100','299','建仓','1490769453','1000.00','10','美元英镑','48660.00','0','幕慕墓幕','0','100.00','200.0','123897.00','','-1000.00','','1243','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2466','1490752389535','298','平仓','1490752389','926.50','1','美元英镑','560884.20','1','﹍Mr.王℡','1','100.00','20.0','125699.00','124006.00','926.50','846.50','1224','','','平仓','4');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2467','1490752392569','298','平仓','1490752392','481.50','9','美元英镑','561365.70','0','﹍Mr.王℡','0','100.00','180.0','124059.00','124006.00','481.50','-238.50','1237','','','平仓','4');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2468','1490752426974','298','建仓','1490752426','1000.00','10','美元英镑','560365.70','0','﹍Mr.王℡','0','100.00','200.0','124005.00','','-1000.00','','1238','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2469','1490752510101','302','建仓','1490752510','1000.00','10','美元英镑','44180.00','0','大卿                  ','0','100.00','200.0','123994.00','','-1000.00','','1239','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2470','1490753050975','298','建仓','1490753050','100.00','1','美元日元','560265.70','0','﹍Mr.王℡','0','100.00','0.0','111285.00','','-100.00','','1240','','','','');
insert into `wp_journal`(`id`,`jno`,`uid`,`jtype`,`jtime`,`jincome`,`number`,`remarks`,`balance`,`jstate`,`jusername`,`jostyle`,`juprice`,`jfee`,`jbuyprice`,`jsellprice`,`jaccess`,`jploss`,`oid`,`pid`,`storage`,`explain`,`type`) values('2471','1490753308991','298','平仓','1490753308','1300.00','10','美元英镑','561665.70','1','﹍Mr.王℡','0','100.00','200.0','124005.00','124056.00','1300.00','500.00','1238','','','平仓','1');
CREATE TABLE `wp_managerinfo` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `poid` int(11) DEFAULT NULL COMMENT '持仓人',
  `coid` int(11) DEFAULT NULL COMMENT '平仓人',
  `mname` varchar(255) DEFAULT NULL COMMENT '法人名字',
  `brokerid` varchar(255) DEFAULT NULL COMMENT '法人代表身份证',
  `photoid` varchar(255) DEFAULT NULL COMMENT '会员资质',
  `Pscale` char(20) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('1','98','','','李海源','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('2','70','','','孟伟','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('3','65','','','王永斌','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('4','120','','','发发','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('5','22','','','尹熙梦','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('6','27','','','宋益州','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('7','116','','','苏凯旋','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('8','15','','','徐丹莉','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('9','139','','','杨姣','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('10','173','','','李晓娟','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('11','24','','','王凯成','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('12','25','','','白万嘉','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('13','57','','','陈松','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('14','112','','','魏前坤','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('15','35','','','尚广龙','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('16','175','','','李梅华','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('17','111','','','张瑞娜','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('18','109','','','张健','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('19','228','','','陈鹏','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('20','176','','','1333929770','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('21','49','','','吴洋','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('22','303','','','郭昊','','','');
insert into `wp_managerinfo`(`mid`,`uid`,`poid`,`coid`,`mname`,`brokerid`,`photoid`,`Pscale`) values('23','314','','','王小龙','','','');
CREATE TABLE `wp_message` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(50) DEFAULT NULL,
  `pswd` char(50) DEFAULT NULL,
  `yu` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `wp_message`(`id`,`account`,`pswd`,`yu`) values('1','qianse1688_SHPYJT','Tch88666','9667');
CREATE TABLE `wp_newsclass` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fclass` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
insert into `wp_newsclass`(`fid`,`fclass`) values('1','最新资讯');
insert into `wp_newsclass`(`fid`,`fclass`) values('2','财经要闻');
insert into `wp_newsclass`(`fid`,`fclass`) values('3','系统公告');
CREATE TABLE `wp_newsinfo` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `ntitle` varchar(255) DEFAULT NULL COMMENT '标题',
  `ncontent` text COMMENT '内容',
  `ncover` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `ncategory` int(11) DEFAULT NULL COMMENT '新闻分类id',
  `ntime` int(20) DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
insert into `wp_newsinfo`(`nid`,`ntitle`,`ncontent`,`ncover`,`ncategory`,`ntime`) values('11','巴克莱：天然气将在下半年显著上涨 大宗商品面临供应中断风险','据彭博，巴克莱在1月5日发布的最新报告中指出，2017年大宗商品投资者需要时刻警惕意外的发生。报告中强调，基于委瑞内拉极大可能会违约、智利将陷入暴乱以及中美或会打响贸易战，无论是原材料市场、能源市场还是贵金属市场，都面临着供应与需求双中断的可能。

同时，巴克莱特别提到了天然气，该行认为，天然气价格在2017年下半年将会显著上涨，但是如果美国与墨西哥爆发全面贸易战，使得美国对墨西哥的天然气出口价格过高，可能会利空天然气。同时巴克莱认为，铜以及铁矿石将回归公允价值。



巴克莱银行分析师Michael Cohen以及Dane Davis强调，民粹主义和贸易保护主义政策等新政治方向有可能扰乱全球对各种商品供给和需求的假设。基于大宗商品供应中断风险的可能性很高，因此他们看到2017年大宗商品的上行风险正在增加。

另外，得益于能源市场的反弹以及投资者对特朗普上台和英国脱欧等意外事件的反应，2016年大宗商品的年回报率创下自2010年最大。巴克莱认为，今年市场应该会再次迎接“惊喜”行情，而政治事件对资产价格的影响将等同于经济增速对其的影响。

巴克莱强调，大宗商品市场的黑天鹅事件很可能以不同的形式出现，市场或会需要数年来消化，又或者资产价格会立即做出反应。而中国、俄罗斯、中东以及土耳其问题将会增加2017年大宗商品市场的复杂性。毕竟，除了供需关系会发生急剧变化外，商品的运输交通一旦受阻，也会使资产价格骤变。

另外，能源市场在2017年仍将会首当其冲，美国与伊朗的问题在今年的风险事件中也位于榜首。不可否认，倘若特朗普果真撕毁了伊朗核协议无疑对油价是一个极度利好因素，不过对于稳定油市平衡并不是一件好事。但巴克莱相信，特朗普在上台后的措辞将会比竞选演讲时温和。

最后，巴克莱认为中国经济增速放缓将会引起连锁反应。倘若这个全球最主要的大宗商品消费国无法抵御外界政策的变动，无疑将对原油、天然气、贵金属以及各种原材料价格形成致命打击。','2017-01-05/586e324f001ad.jpg','1','1483616847');
insert into `wp_newsinfo`(`nid`,`ntitle`,`ncontent`,`ncover`,`ncategory`,`ntime`) values('10','白银市场将迎来巨震','金银网11月7日讯，虽然美国联邦储备已经暗示会在下个月加息，但美国大选的变数出现依然对美元形成了较大冲击。市场普遍认为如果特朗普当选，白银等金银将受到较大支撑，但希拉里当选则不会对银价形成有效提振，不过摩根大通经济学家则指出，实际上，无论特朗普还是希拉里当选，对于白银来述其实都是利于多头。

本周白银市场最重要的事件便是美国大选。11月8日，美国大选将开始。就在一周之前，在总统辩论中远远好于特朗普的希拉里，还被认为是胜算满满的。选举的结果只在于希拉里能以多少胜率赢得选举。但是FBI突然宣布重启调查邮件门，大选再生变数。美股受影响已经多天连续下探，美指也继续下挫，白银等金银一度大涨逾3%后小幅度回落。本周总统选举正式开始，各位投资者做好准备，感受白银市场的剧烈震动吧。','2016-11-29/583d339a4e9ab.jpg','2','1480405914');
insert into `wp_newsinfo`(`nid`,`ntitle`,`ncontent`,`ncover`,`ncategory`,`ntime`) values('12','金上金：返佣公告','因系统原因3月6号休市一天给广大用户造成不变为此交易中心做出以下返佣标准
交易手续费金额大于10000元即可申请返佣
10000元-20000元  10%
20001元-30000元  20%
30001元-40000元  30%
40001元-50000元  40%
50001元以上金额   50%

活动时间：2017年3月7号-2017年3月31号
每个标准不可叠加领取，只可领取一次','2017-03-07/58be2e182fe89.jpg','3','1488858648');
insert into `wp_newsinfo`(`nid`,`ntitle`,`ncontent`,`ncover`,`ncategory`,`ntime`) values('13','欧银联袂非农 美联储决议前上演最后疯狂','在经过了上周美联储官员轮番鹰派言论的“轰炸”之后，本周金融市场可能又将迎来动荡的一周。经济数据方面，包括非农、ADP等美国重磅就业报告将出炉，可能对美联储3月是否加息产生决定性影响；而央行方面，欧洲央行和澳洲联储都将公布利率决议，尤其是欧银决议，德拉基讲话几乎每次都会令市场遭遇“惊涛骇浪”，本周可能也会如此。在下周美联储即将公布备受关注的利率决议之前，本周金融市场可能上演“最后的疯狂”。非农领衔重磅就业数据

本周将有多份美国就业数据出炉，其中ADP私营就业部门报告将于周三(3月8日)公布，而美国劳工部的非农就业报告定于3月10日出炉，数据可能给美联储行动提供更加充足的理由。一周初请失业金人数已在上月末降至近44年最低水平，显示美国就业市场进一步收紧。

2月非农就业报告定于北京时间周五21:30出炉。彭博调查显示，目前，市场预期美国2月非农就业人数增加19.0万人，前值为增加22.7万人；预期失业率自4.8%降至4.7%。

除了就业增幅变动之外，投资者也将关注薪资指标，其可能影响通胀表现。调查显示，2月小时薪资月率料上升0.3%，年率上升2.8%，分别高于前值的上升0.1%和上升2.5%。

在通胀走高之际，强劲的就业增长可能导致就业市场过热，美联储青睐的通胀指标目前已处于联储官员12月预测的今年通胀区间的高端。

美国1月份非农就业人数新增22.7万，失业率增加至4.8%。经济学家们原本预计2月就业人数增加17万，失业率仍维持在4.7%。

3月14-15日美联储(FED)就将召开利率会议，即将出炉的2月非农就业报告会是影响美联储利率决定的一大关键因素。

美联储主席耶伦(Janet Yellen)上周五表示，只要经济继续如预期般改善，美联储本月加息是合适的。

耶伦讲话前，近期已经有多位美联储官员发表了鹰派讲话，巩固了美联储在3月15日下次会议上加息的可能性。根据CME Group的FedWatch工具，期货交易商现在预期美联储3月加息的机率为86%。

除了非农，定于周三的“小非农”ADP就业数据可能成为周五非农报告的预演。

ADP报告显示，1月新增就业人数24.6万，远高于12月的15.1万。这些数据表明，继2016年下半年的不温不火时期之后，就业加速增长。

此外，周四还将公布初请失业金数据。美国初请失业金人数已经降至44年低位，刷新1973年3月以来新低，表明美国就业市场处于或接近充分就业状态。

美国至2月25日当周初请失业金人数为22.3万，好于预期的24.3万和前值24.4万。美国至2月25日当周初请失业金人数创44年以来最低，且已连续104周维持在30万人以下，这显示劳动力市场进一步收紧；加之此前数据显示通胀上升，这可能会让美联储在3月份的会议上加息。

欧洲央行决议

北京时间周四20:45，欧洲央行(ECB)将公布利率决议；北京时间周四21:30，欧洲央行行长德拉基(Mario Draghi)将召开新闻发布会。

欧洲央行在1月会议上维持基准利率不变，符合预期。该行还决定维持购债刺激计划不变。欧洲央行行长德拉基表示，欧元区经济走强，但仍然脆弱，需要更多反弹时间。

路透调查结果显示，分析师一致预期欧洲央行将保持政策不变。路透撰文称，在距离法国和荷兰大选只有几周的情况下，欧洲央行不会急着添乱，因此届时可能只会认可强劲的增长数据，避免发出任何可能助长民粹主义势力的政策暗示。

欧洲央行行长德拉基可能避免讨论缩减购债，甚至反驳一些利率决策者要求调整政策指引的呼吁，不再提及可能进一步降息。市场几乎已经排除了降息的可能。

彭博经济学家撰文称，欧洲央行行长德拉基未来一周将成为关注焦点，但他的语调应该不会有什么意外。鉴于基础通胀低迷，欧洲央行可能会维持刺激措施。

欧洲央行上次会议的纪要显示，央行官员们对于经济的走向感到满意，不急于逆转货币刺激。

彭博经济学家预计，欧洲央行在此次会议上还将延续类似的立场，短期不会有政策变化。只有当核心通胀开始走强时，欧洲央行才会开始谈论缩减QE，相关声明在9月份之前都不太可能出炉。”

澳洲联储决议

上周五公布的一份路透调查显示，澳洲联储(RBA)本周几乎肯定会维持指标利率在1.5%的纪录低位不变。此前该联储已经暗示年内或许不会调整政策。

澳洲联储正监控房地产投资者近期贷款增长情况以及更多有关经济表现的数据以决定下一步行动。

澳洲联储在2月会议上将官方现金利率维持在1.5%不变，符合市场预期。一些经济学家认为，澳洲联储下一步将是加息，而其他人则表示由于通胀处于相对低位，其仍有降息空间。

根据路透调查，尽管大多数受访者预计，今年澳洲利率前景稳定，但有12位受访者认为联储在12月前至少会再降息一次，另外有4位分析师则预计该联储有可能会加息一次。

有人士指出，澳洲联储周二可能暗示，鉴于上季度经济反弹令人信服、大宗商品出口增长和家庭债务水平强劲上升，政策放松周期已结束','2017-03-07/58be2f5a688c3.jpg','2','1488858970');
CREATE TABLE `wp_order` (
  `oid` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '商品编号',
  `pid` int(11) NOT NULL COMMENT '产品ID',
  `ostyle` int(12) NOT NULL DEFAULT '0' COMMENT '0涨 1跌，',
  `buytime` int(20) DEFAULT NULL COMMENT '建仓',
  `onumber` int(20) DEFAULT NULL COMMENT '手数',
  `selltime` int(20) DEFAULT '0' COMMENT '平仓',
  `ostaus` int(11) DEFAULT NULL COMMENT '0交易，1平仓',
  `buyprice` char(20) NOT NULL,
  `sellprice` char(20) NOT NULL DEFAULT '0.00',
  `endprofit` int(11) DEFAULT '0' COMMENT '止盈',
  `endloss` int(11) DEFAULT '0' COMMENT '止亏',
  `fee` double(11,1) DEFAULT NULL COMMENT '手续费',
  `eid` int(11) NOT NULL COMMENT '体验卷状态',
  `orderno` varchar(40) DEFAULT NULL COMMENT '订单编号',
  `ptitle` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `commission` double(255,1) DEFAULT '0.0' COMMENT '佣金',
  `ploss` double(255,1) DEFAULT '0.0' COMMENT '盈亏',
  `display` int(11) DEFAULT '0' COMMENT '0,可查询，1不可查询',
  PRIMARY KEY (`oid`,`ostyle`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `ostaus` (`ostaus`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1247 DEFAULT CHARSET=utf8;
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1206','298','122','1','1490668843','3','1490668960','1','1.25635','1.2564','1','80','60.0','0','1490668843985','美汇英镑','9940.0','0.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1207','298','122','1','1490669045','5','1490669383','1','1.2562','1.25628','1','80','100.0','0','1490669045531','美汇英镑','9640.0','-200.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1208','298','122','1','1490669401','1','1490670178','1','1.2563','1.2567','1','80','20.0','0','1490669401579','美汇英镑','9460.0','-160.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1209','303','122','0','1490671645','1','1490679870','1','1.25655','1.25623','1','80','20.0','0','1490671645100','美汇英镑','9820.0','-160.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1210','303','122','1','1490679999','1','1490684433','1','1.25608','1.25644','1','80','20.0','0','1490679999102','美汇英镑','9140.0','-160.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1211','303','123','1','1490680057','1','1490691061','1','110.621','110.704','1','80','50.0','0','1490680057575','美元日元','9589.2','-0.8','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1212','298','122','0','1490686081','1','1490686106','1','1.25719','1.25724','1','80','20.0','0','1490686081495','美汇英镑','9465.0','25.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1213','298','122','1','1490686234','1','1490686469','1','1.25702','1.25736','1','80','20.0','0','1490686234974','美汇英镑','9285.0','-160.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1214','298','122','0','1490686968','1','1490687156','1','1.25746','1.2571','1','80','20.0','0','1490686968565','美汇英镑','9105.0','-160.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1215','298','123','0','1490689985','1','1490694147','1','110.665','110687','1','80','20.0','0','1490689985499','美元日元','561386.7','552881.7','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1216','305','122','1','1490690141','1','1490690155','1','1.25827','1.25822','1','80','20.0','0','1490690141100','美汇英镑','50005.0','25.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1217','298','122','0','1490692991','1','1490693008','1','125880','125875','1','80','20.0','0','1490692991102','美汇英镑','8425.0','-160.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1218','298','122','0','1490694754','1','1490694823','1','125666','125649','1','80','20.0','0','1490694754504','美元英镑','561286.7','-80.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1219','298','122','0','1490694871','1','1490695943','1','125637','125686','1','80','20.0','0','1490694871559','美元英镑','560387.7','49.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1220','298','124','1','1490695193','10','1490695943','1','108582','108605','1','80','200.0','0','1490695193579','欧元美元','560828.7','-230.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1221','298','123','1','1490695225','8','1490695932','1','110699','110670','1','80','160.0','0','1490695225571','美元日元','560258.7','232.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1222','302','122','0','1490695509','5','1490695596','1','125659','125667','1','80','100.0','0','1490695509531','美元英镑','49920.0','20.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1223','302','122','0','1490695785','10','1490696146','1','125656','125695','1','80','200.0','0','1490695785579','美元英镑','50110.0','390.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1224','298','122','1','1490696207','1','1490752389','1','125699','124006','1','80','20.0','0','1490696207102','美元英镑','560884.2','846.5','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1225','302','122','1','1490696234','20','1490699093','1','125708','125561','1','80','400.0','0','1490696234971','美元英镑','45180.0','1470.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1226','305','122','1','1490696256','1','1490704750','1','125707','125504','1','80','20.0','0','1490696256484','美元英镑','50086.5','101.5','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1227','302','122','0','1490696448','10','1490698348','1','125709','125550','1','80','200.0','0','1490696448489','美元英镑','42110.0','-800.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1228','302','122','0','1490696485','20','1490698345','1','125727','125557','1','80','400.0','0','1490696485539','美元英镑','42110.0','-1600.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1229','302','122','0','1490696809','30','1490698718','1','125677','125516','1','80','600.0','0','1490696809575','美元英镑','42110.0','-2400.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1230','303','122','1','1490697070','1','1490697119','1','125625','125825','1','80','0.0','1','1490697070101','美元英镑','9589.2','0.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1231','303','122','1','1490697676','30','1490697731','1','125669','125644','1','80','600.0','0','1490697676995','美元英镑','9364.2','375.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1232','303','122','1','1490697739','30','1490752377','1','125637','124006','1','80','600.0','0','1490697739985','美元英镑','-335057.3','24465.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1241','298','122','1','1490768043','10','1490770784','1','123907','123989','1','80','200.0','0','1490768043985','美元英镑','560565.7','-800.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1234','305','122','1','1490698245','0','1490704744','1','125615','125512','1','80','0.0','0','1490698245535','美元英镑','49905.0','0.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1235','303','122','1','1490699981','1','1490700003','1','125617','125600','1','80','20.0','0','1490699981100','美元英镑','561852.7','8.5','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1236','303','122','1','1490700077','72','1490752380','1','125596','124000','1','80','1440.0','0','1490700077100','美元英镑','-271841.3','57456.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1237','298','122','0','1490751049','9','1490752392','1','124059','124006','1','80','180.0','0','1490751049579','美元英镑','561365.7','-238.5','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1238','298','122','0','1490752425','10','1490753308','1','124005','124056','50','20','200.0','0','1490752425571','美元英镑','561665.7','500.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1239','302','122','0','1490752510','10','1490767710','1','123994','123911','1','80','200.0','0','1490752510101','美元英镑','44180.0','-800.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1240','298','123','0','1490753050','1','1490754484','1','111285','111200','1','80','0.0','1','1490753050975','美元日元','561665.7','0.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1242','299','122','1','1490769124','10','1490769245','1','123905','123919','1','80','200.0','0','1490769124525','美元英镑','49660.0','-140.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1243','299','122','0','1490769453','10','1490769520','1','123897','123900','1','80','200.0','0','1490769453100','美元英镑','49490.0','30.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1244','298','125','1','1490770210','1','1490772730','1','76408','76492','1','80','20.0','0','1490770210505','澳元美元','560565.7','-80.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1245','305','123','1','1490774882','1','1490775305','1','111115','111198','1','80','20.0','0','1490774882505','美元日元','49986.5','-80.0','0');
insert into `wp_order`(`oid`,`uid`,`pid`,`ostyle`,`buytime`,`onumber`,`selltime`,`ostaus`,`buyprice`,`sellprice`,`endprofit`,`endloss`,`fee`,`eid`,`orderno`,`ptitle`,`commission`,`ploss`,`display`) values('1246','305','123','0','1490775862','1','1490776225','1','111133','111094','1','80','20.0','0','1490775862545','美元日元','49927.5','-39.0','0');
CREATE TABLE `wp_pay` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `partner` varchar(200) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pid` varchar(100) DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `appid` varchar(100) DEFAULT NULL,
  `appsecret` varchar(100) DEFAULT NULL,
  `zfopen` int(10) DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
insert into `wp_pay`(`id`,`type`,`key`,`partner`,`name`,`email`,`pid`,`status`,`appid`,`appsecret`,`zfopen`) values('2','beecloud','','','在线支付','','','0','','','1');
insert into `wp_pay`(`id`,`type`,`key`,`partner`,`name`,`email`,`pid`,`status`,`appid`,`appsecret`,`zfopen`) values('3','Wxpay','334021f6ab4b09005c4934ca34015c52','','微信支付','','1438841102','0','wxff97fce93192a170','f52a1dc3109755c5a33689b0e0e91818','2');
insert into `wp_pay`(`id`,`type`,`key`,`partner`,`name`,`email`,`pid`,`status`,`appid`,`appsecret`,`zfopen`) values('1','wanjio','O9aX9jvn4eqRYjXQ4la5HleHFuBILr','','万嘉支付','','10144','1','','','2');
CREATE TABLE `wp_pay_copy` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `key` varchar(50) DEFAULT NULL,
  `partner` varchar(200) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('1','wechat','223','22','微信支付','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('2','alipay','3313','331','支付宝','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('3','tenpay','2233','22','财付通','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('4','palpay','2233','22','贝宝','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('5','yeepay','2233','22','易付宝','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('6','kuaiqian','2233','22','快钱','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('7','unionpay','2233','22','银联','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('8','aliwappay','2233','22','支付宝手机','');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('11','Wxpay','22333','22','微信支付','33333');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('9','ytfpay','bb','cc','云通付','hhgg');
insert into `wp_pay_copy`(`id`,`type`,`key`,`partner`,`name`,`email`) values('10','beecloud','gg','gg','beecloud','gg');
CREATE TABLE `wp_productinfo` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `ptitle` varchar(255) DEFAULT NULL COMMENT '标题',
  `cid` int(11) DEFAULT NULL COMMENT '产品分类id',
  `uprice` double DEFAULT NULL,
  `feeprice` double DEFAULT NULL,
  `wave` double DEFAULT NULL COMMENT '产品波动',
  `company` varchar(255) DEFAULT NULL COMMENT '单位',
  `patx` double(11,0) DEFAULT '0' COMMENT '点差乘',
  `patj` double(11,0) DEFAULT '0' COMMENT '点差加',
  `num` int(11) DEFAULT NULL COMMENT '总手数',
  PRIMARY KEY (`pid`),
  KEY `cid` (`cid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('113','WTI 1000桶','28','5000','600','3500','1000桶','0','0','50');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('112','WTI 100桶','28','500','70','350','100桶','0','0','50');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('111','WTI 10桶','28','50','8','35','10桶','0','0','50');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('110','Gold 3kg','26','8500','850','350','3kg','0','0','50');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('109','Gold 1kg','26','3000','300','300','1kg','0','0','50');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('108','Gold 200g','26','600','60','20','200g','0','0','50');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('122','美元英镑','39','100','20','1','','0','0','200');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('123','美元日元','41','100','20','1','','0','0','200');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('124','欧元美元','42','100','20','1','','0','0','200');
insert into `wp_productinfo`(`pid`,`ptitle`,`cid`,`uprice`,`feeprice`,`wave`,`company`,`patx`,`patj`,`num`) values('125','澳元美元','43','100','20','1','','0','0','200');
CREATE TABLE `wp_tc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `tc` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
insert into `wp_tc`(`id`,`name`,`tc`) values('3','第一等级','0');
insert into `wp_tc`(`id`,`name`,`tc`) values('4','第二等级','0');
insert into `wp_tc`(`id`,`name`,`tc`) values('7','第三等级','0');
CREATE TABLE `wp_userinfo` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `upwd` varchar(50) DEFAULT NULL,
  `utel` varchar(50) DEFAULT NULL,
  `utime` int(20) DEFAULT NULL COMMENT '注册时间',
  `agenttype` int(20) DEFAULT '0' COMMENT '0普通客户，1申请经纪人中，2经纪人',
  `otype` int(11) NOT NULL DEFAULT '0' COMMENT '0普通会员,2会员单位,1经纪人,3超级管理员',
  `ustatus` int(11) NOT NULL DEFAULT '0' COMMENT '0正常状态，1冻结状态，',
  `oid` int(11) DEFAULT NULL COMMENT '直接上级ID',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `portrait` varchar(255) DEFAULT NULL COMMENT '头像',
  `lastlog` int(20) DEFAULT NULL COMMENT '最后登录时间',
  `managername` varchar(255) DEFAULT NULL COMMENT '上线用户名',
  `comname` varchar(120) DEFAULT NULL COMMENT '公司名称',
  `comqua` varchar(50) DEFAULT NULL COMMENT '公司资质',
  `rebate` varchar(11) DEFAULT NULL COMMENT '返点',
  `feerebate` varchar(11) DEFAULT NULL COMMENT '手续费返点',
  `usertype` int(11) DEFAULT '0' COMMENT '0不是微信用户。1是微信用户',
  `wxtype` int(11) DEFAULT '0' COMMENT '1表示微信还没注册，0微信已注册成会员。',
  `openid` varchar(5000) NOT NULL COMMENT '存微信用户的id',
  `nickname` varchar(255) DEFAULT NULL COMMENT '用户昵称',
  `pid` varchar(100) DEFAULT NULL,
  `cid` text,
  `vid` char(100) DEFAULT NULL COMMENT '代理商的uid',
  PRIMARY KEY (`uid`),
  KEY `utel` (`utel`) USING BTREE,
  KEY `oid` (`oid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=325 DEFAULT CHARSET=utf8;
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('1','admin','ca1f4cb1414c2354fb76b060d4201947','15221606964','0','0','3','0','0','','','1494385030','','','','','','0','0','','','','','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('305','吴洋','e10adc3949ba59abbe56e057f20f883e','18337170257','1490673421','0','0','0','303','','http://wx.qlogo.cn/mmopen/k2PIoSvsUibIWUaLenUGzJCAOHkt4YNwKvjxflMOCgzdFNryUdSBDLHfEyAwYQltpzicicXPzr18Z32OiaYWsOfLwOEhMyFibcAy6/0','1490776207','guohao','','','','','0','0','oiotsw-PTfrzYZYuRADp44oa--Gk','','','|290|303|305|','303');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('306','','','','1490683328','0','0','0','','','http://wx.qlogo.cn/mmopen/k2PIoSvsUibIWUaLenUGzJCX2ouPvzywDl585VOWBoib3FKtIbv6yopUfY4XIXBY1Iyymj79n0gSVT69dibBvgwlnfdW99icxHxa/0','','','','','','','0','0','oiotswztwADhyzrrtEIfOPpigr2w','','','|306|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('307','123456','e10adc3949ba59abbe56e057f20f883e','13014698996','1490701146','0','3','0','','','','','','','','','','0','0','','','','','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('309','八角任万博','e10adc3949ba59abbe56e057f20f883e','18236981601','1490752132','0','0','0','','','http://wx.qlogo.cn/mmopen/GKicibg7WOUicBobg3rNZO2JKRkPcicwsCWZC3ld44dlu6DqVsGxawavpr1O6mTdHMicyGtegkaVVES7uSg6pQpvzYliaxFdSzLm2M/0','','','','','','','0','0','oiotsw-b6wBQswXGJCccUzedEr_Y','','','|309|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('312','苦行僧','21218cca77804d2ba1922c33e0151105','15837196816','1490770163','0','0','0','','','http://wx.qlogo.cn/mmopen/k2PIoSvsUibJQSC2L4AH4UnXhEuwjNgibOpxTtia2CBFrUzTPibYqQTEDg5pr0VgtMTDlNxL4IpqVvJtPYic4Uia4ObzRABlyrqR71/0','','','','','','','0','0','oiotsw5cWx0O30rjLGEFFPKx1Evw','','','|312|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('313','月亮的心','e40f01afbb1b9ae3dd6747ced5bca532','17083800957','1490771771','0','0','0','','','http://wx.qlogo.cn/mmopen/Ib5852jAybibsfTz0EUfnEibRSHf6jAcYgkdGcpf5iaarxRUk0ghPuiaCh2D4w91cwdTf6B6gFyucudJgwXhtw7z7y608nSNPkyp/0','','','','','','','0','0','oiotsww-rAixW7L19TYZDGkOHI8E','','','|313|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('314','ABCDEFJ','e10adc3949ba59abbe56e057f20f883e','15538253855','1490771880','1','0','0','','','http://wx.qlogo.cn/mmopen/Q3auHgzwzM651ib9MadPVspOdMLUW50IJzG4ic2Ufh23Dcqb556yibayzibfOpRzPCAphggRMLlJtCn5ZR3ZpK3mPA/0','','','','','','','0','0','oiotswyigGT5jHWKAsmrOnZG-PCU','','','|314|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('315','天空','21218cca77804d2ba1922c33e0151105','13788900795','1490771880','0','0','0','','','http://wx.qlogo.cn/mmopen/PiajxSqBRaEJDtS3THlu5DUpnow2AAAL7icTJ6SM1vwOIMmD6nzJYhT08Y1OTiaicY0GqdytkgbFNRZ69lphMbmGjQ/0','','','','','','','0','0','oiotsw8LSQlhz3hTnCtz1GhEqqRc','','','|315|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('316','弄 啥 嘞！！','e10adc3949ba59abbe56e057f20f883e','18338780053','1490771920','0','0','0','','','http://wx.qlogo.cn/mmopen/S0jgt6SniaXDYzfwQfD4preA5WNDN4WicVzdmricnw0eKNR1mZMGASoTVwQEDchPiak8pibYV0lGVWpdBGWhjaLmvMaJicSPsQbLWn/0','','','','','','','0','0','oiotsw3v1q654b8Z7x8Dpwse_auM','','','|316|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('317','小小','d4716046d2fc49822d7a1c70934602f0','15890062473','1490771988','0','0','0','','','http://wx.qlogo.cn/mmopen/GKicibg7WOUicBobg3rNZO2JExlia1cQs6wlp3D6IfnhVxny0Hn7OUeqL0N5jBL0KRHQ4wSqBank0cpqr8YmBw9l3vkaJfQCvFFc/0','','','','','','','0','0','oiotsw1G8T1e7ERB0paKdL3BoC_g','','','|317|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('318','生如慧花。','d39a20e84daed00abea63259c676cb70','18530043177','1490772076','0','0','0','','','http://wx.qlogo.cn/mmopen/GKicibg7WOUicANmR4ibcyNRISRX5VRKgVjUoBcCKC2FulTr2gBh1p8c5JbzNbEMB2235r9Tvu1cxibharR2XtptCjK95FVJJkFOM/0','','','','','','','0','0','oiotsw_HZdNwN6wQbBdc2hUAJc7Q','','','|318|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('319','知足','0927c84691abe7bdbd833fd25c105cfd','18236743697','1490772120','0','0','0','','','http://wx.qlogo.cn/mmopen/S0jgt6SniaXDYzfwQfD4prTFEtu1ibVwkibrKuSuPLo8U0kosrtuLb7AFLHxxyWX4NwL1Gw7ZCScW8RQzIN5QGQv1ibzNoW5bslZ/0','','','','','','','0','0','oiotsw0jZsorjLGsB7oqkX1yCGpE','','','|319|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('320','安然','21218cca77804d2ba1922c33e0151105','15038321445','1490772120','0','0','0','','','http://wx.qlogo.cn/mmopen/k2PIoSvsUibIWUaLenUGzJGVhjDQ55EJ9kFlSXf0BoKYSYd35ib4kdGf4DXMjfpBGIW8F3Oa9Qj2qicicmDXMnYZ5Tm7anUhtkZib/0','','','','','','','0','0','oiotswwybE08ZqqlKw4POEXayy78','','','|320|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('321','佳佳','21218cca77804d2ba1922c33e0151105','15138998154','1490772227','0','0','0','','','http://wx.qlogo.cn/mmopen/II99RgDv5IPjeicesv263RlPCHIQGuOUTP5ibKqGojuYicdiaw9SPG5lbZhx5zshJcUZFiaakJboSV6BM3j7BfwmnvzqVSOLKaaUx/0','','','','','','','0','0','oiotsw9Glx8sC6dlYN8h3ZHboRNM','','','|321|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('323','月半小夜曲','452f66932e86eef3999c3d1b7baa4d4c','15886338189','1490775970','0','0','0','','','http://wx.qlogo.cn/mmopen/Q3auHgzwzM7s6c1E7icQgbV9T7icZJ4FE5AL0QGNVhZjictibzwqOYm5BEYxHkZ3KSxsssmB6IQ7tVvP9bXYCuoSceY4rIdSXvQdulcDGKzeOOI/0','','','','','','','0','0','oiotsw-7l-zDma2hsx8XglHaK96Y','','','|323|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('324','弄 啥 嘞！！','','','1490777615','0','0','0','','','http://wx.qlogo.cn/mmopen/dctt0KJuEV7xTf5MbITF92A5NZa1lBqh3CO0OE5T4SbTUD751ib6FtPHOkaImlb2aqlkmjRjTOYiciacjzz97rvVKHiaPjM4Sugc/0','','','','','','','0','0','oiotswzXxtoEL6ONGDI_O1RHV2ek','','','|324|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('290','八角任万博','','','1490239767','0','0','0','','','http://wx.qlogo.cn/mmopen/c3zO2jmxOibxvTFkU5R73CScCiaehliciaOAIRgBntIweUoBxPZWuEtLWd9ZTsr6icdfWemHeQbwUkJGI093NbvugibjVhbTybTFme/0','','','','','','','0','0','o24hbv1dQuCYnzZ3JF0eGeGRSO4A','','','|290|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('310','大卿                        ','','','1490768544','0','0','0','','','http://wx.qlogo.cn/mmopen/Q3auHgzwzM4r6LUC30lNhVNDJ5Lco10U8sFezMbHnibJPD8gDAhy1EeqWyo5Fl9KM54pRyjPrMWkYVm1fGJRBJw/0','','','','','','','0','0','oiotswwOC_Rc1qQJ3U01fKL8CGCM','','','|310|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('292','、会当凌绝顶','','','1490254870','0','0','0','290','','http://wx.qlogo.cn/mmopen/c3zO2jmxOibxvTFkU5R73CZ1FnBnF19YDWfVJlot4Vq0SBzkZJPdzQnVbY8Mibf4GcBY3psCXD5eicFicfnv8iaUZ7yzlUmlp7qv6/0','','八角任万博','','','','','0','0','o24hbv-cU8-_UGL90n-qhl5boUMs','','','|292|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('303','guohao','e10adc3949ba59abbe56e057f20f883e','18237837598','1490671563','2','1','0','290','','http://wx.qlogo.cn/mmopen/Ib5852jAyb99PITwrmIRdCtAegJ3LMvBAE5XTok4N1s6KuNzHKsaNXGLPqvuicduiarsYZ2xXw3Jm9tw1WjhXMsw/0','1490759081','八角任万博','','','','','0','0','oiotsw2DvoEJ5CGWNn_Vc92yQvr4','','','|290|303|','303');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('294','wxjdr','e10adc3949ba59abbe56e057f20f883e','15889918044','1490365441','0','0','0','290','','http://wx.qlogo.cn/mmopen/1xRAoic6MhEh2jWBqVPBBvxOQefXmIyVBpEfcqOC7OEA7909rClKcicRhqEk3DR5k5Fz56RWlR6p1xmTH7Zdibibic4xSJD7E3YXj/0','','八角任万博','','','','','0','0','o24hbv5RMQsjjWiuKV-05eyOpfNA','','','|294|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('295','宝宝妈','7b30d28510419245ac19260b32b74a57','15072698202','1490446427','0','0','0','290','','http://wx.qlogo.cn/mmopen/1xRAoic6MhEhib0W5XCpgjApzfiaJawKYmeyRBu6xyg8OUicyawLhu2wMl8tWkBjLo499ztVA6Mm1b9A4JZD2JtY8VibsSRic9vwbS/0','','八角任万博','','','','','0','0','o24hbv6MkRzB0s76O8qj8dS5uIAE','','','|295|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('296','凉城空心°','','','1490469562','0','0','0','','','http://wx.qlogo.cn/mmopen/c3zO2jmxOibxvTFkU5R73CXcoMJV9zlSUp0XpqFWmUv5waUWiaX3VhkBOfRCwDU4yZdJ9teZwyeqBdXGDbCb9Zuy1cjhic77ztw/0','','','','','','','0','0','o24hbvyWoHN0WB5eSn5d4YVAZczM','','','|296|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('298','﹍Mr.王℡','21218cca77804d2ba1922c33e0151105','13633713536','1490599725','0','0','0','0','','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDLQJQlkckXcMnM3YQqnPrVY28MjfbBs9c60V0BrefjpMRF8slTYT0KlfiabzqAW69ojPEGdUBzORg/0','','','','','','','0','0','oiotsw3SAXV2pJFY9lTU1YPdoePY','','','|298|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('299','幕慕墓幕','e86caa3e61ce9ec8169caf01e38e1a2d','18530817515','1490606305','0','0','0','0','','http://wx.qlogo.cn/mmopen/k2PIoSvsUibLl7CGRoGpIM1UfSWX0pdPqnaHdD6VsHfN5lTXUCyFmLtibpWhC0kcjXFzdMDicafLDh0ibSdEPvjthQ/0','','','','','','','0','0','oiotsw6jDth2L8hlq_CGGKsIfuxc','','','|299|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('300','桃白白','f259c687d68c7d4ea14ea7b50396dbf0','18137879222','1490606331','0','0','0','','','http://wx.qlogo.cn/mmopen/ajNVdqHZLLBzJxSCiaTl3yFJo0gbQfDhRE5hgFpzJwLgaeCpJicwXdrNPGhtn1lK1TAKryyL8VWgib5eNHZfPYxTQ/0','','','','','','','0','0','oiotswyeiI0kB8EKhQ7A6HxSoEHw','','','|300|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('301','旅行','5d2b64cd9d4a2601de0ec1672918ca34','13607660623','1490611043','0','0','0','','','http://wx.qlogo.cn/mmopen/ajNVdqHZLLCldB097Ya94yVdbicKoRfWibuZ0rKZJxXXZKqHpOytDFsnzGt7untmZZvMNLVDsOp7YCFudK1BWfew/0','','','','','','','0','0','oiotsw4zESIboD5A0x7SBBREV8Cg','','','|301|','');
insert into `wp_userinfo`(`uid`,`username`,`upwd`,`utel`,`utime`,`agenttype`,`otype`,`ustatus`,`oid`,`address`,`portrait`,`lastlog`,`managername`,`comname`,`comqua`,`rebate`,`feerebate`,`usertype`,`wxtype`,`openid`,`nickname`,`pid`,`cid`,`vid`) values('311','枫','e10adc3949ba59abbe56e057f20f883e','15378783016','1490769351','0','0','0','','','http://wx.qlogo.cn/mmopen/PiajxSqBRaELB8qMUwPPR9XJIE77mEUvYc9tooY72LfhcyuhJicic3GNgialBrtPZFW0xKGSHpuLocZ8ysf9Cvs6lw/0','','','','','','','0','0','oiotsw5DemDw7EdA1tXho34vas1c','','','|311|','');
CREATE TABLE `wp_wap_log` (
  `out_trade_no` int(7) NOT NULL AUTO_INCREMENT,
  `money` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `callback` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `param` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`out_trade_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `wp_webconfig` (
  `id` int(11) NOT NULL,
  `isopen` int(11) DEFAULT '0' COMMENT '0开启，1关闭',
  `webname` char(20) DEFAULT NULL COMMENT '网站名称',
  `onelevel` char(20) DEFAULT NULL,
  `twolevel` char(20) DEFAULT NULL,
  `Pscale` char(20) DEFAULT NULL,
  `begintime` int(20) DEFAULT NULL COMMENT '休市开始时间',
  `endtime` int(20) DEFAULT NULL COMMENT '休市结束时间',
  `notice` char(100) DEFAULT NULL COMMENT '公告',
  `isnotice` int(10) DEFAULT '0' COMMENT '0开启，1关闭',
  `title` char(200) DEFAULT NULL,
  `pic` varchar(500) DEFAULT NULL,
  `tpl` varchar(20) DEFAULT NULL,
  `day` int(10) DEFAULT '0',
  `hour` int(10) DEFAULT '0',
  `minute` int(10) DEFAULT '0',
  `storage` double(11,2) DEFAULT NULL COMMENT '储仓费',
  `code` char(225) DEFAULT NULL COMMENT '支付公众号二维码',
  `zfopen` int(1) DEFAULT '1' COMMENT '0开启，1关闭',
  `kpan` char(2) DEFAULT NULL,
  `gpan` char(2) DEFAULT NULL,
  `endloss` int(3) DEFAULT '80',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `wp_webconfig`(`id`,`isopen`,`webname`,`onelevel`,`twolevel`,`Pscale`,`begintime`,`endtime`,`notice`,`isnotice`,`title`,`pic`,`tpl`,`day`,`hour`,`minute`,`storage`,`code`,`zfopen`,`kpan`,`gpan`,`endloss`) values('1','1','恒金商城','0.2','0.1','0','','','大家好','0','5555','555','2','300','24','0','0.00','','2','7','4','80');
CREATE TABLE `wp_wechat` (
  `wcid` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) DEFAULT NULL COMMENT 'AppID(应用ID)',
  `appsecret` varchar(255) DEFAULT NULL COMMENT 'AppSecret(应用密钥)',
  `wxname` varchar(255) DEFAULT NULL COMMENT '公众号名称',
  `wxlogin` varchar(255) DEFAULT NULL COMMENT '微信原始账号',
  `wxurl` varchar(255) DEFAULT NULL COMMENT 'url服务器地址',
  `token` varchar(255) DEFAULT NULL COMMENT '令牌',
  `encodingaeskey` varchar(255) DEFAULT NULL COMMENT '消息加密解密秘钥',
  `parterid` int(11) DEFAULT NULL COMMENT '微信商户账号',
  `parterkey` varchar(255) DEFAULT NULL COMMENT '32位密码',
  `content` varchar(800) DEFAULT NULL,
  PRIMARY KEY (`wcid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `wp_wechat`(`wcid`,`appid`,`appsecret`,`wxname`,`wxlogin`,`wxurl`,`token`,`encodingaeskey`,`parterid`,`parterkey`,`content`) values('3','wx337cf4c7dd381103','1a47302711c43e1f55070c4262e1bd55','恒金商城','gh','http://www.210s.cn/','Weiyi','xHd1n60aIIz1zuIG76tK6k1qunf6N350t82hWhEcy7q','0','0','欢迎您的加入！');
CREATE TABLE `wp_wechat_zhifu` (
  `wcid` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) DEFAULT NULL COMMENT 'AppID(应用ID)',
  `appsecret` varchar(255) DEFAULT NULL COMMENT 'AppSecret(应用密钥)',
  `wxname` varchar(255) DEFAULT NULL COMMENT '公众号名称',
  `wxlogin` varchar(255) DEFAULT NULL COMMENT '微信原始账号',
  `wxurl` varchar(255) DEFAULT NULL COMMENT 'url服务器地址',
  `token` varchar(255) DEFAULT NULL COMMENT '令牌',
  `encodingaeskey` varchar(255) DEFAULT NULL COMMENT '消息加密解密秘钥',
  `parterid` int(11) DEFAULT NULL COMMENT '微信商户账号',
  `parterkey` varchar(255) DEFAULT NULL COMMENT '32位密码',
  `content` varchar(800) DEFAULT NULL,
  PRIMARY KEY (`wcid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `wp_wechat_zhifu`(`wcid`,`appid`,`appsecret`,`wxname`,`wxlogin`,`wxurl`,`token`,`encodingaeskey`,`parterid`,`parterkey`,`content`) values('3','','','','','','Weiyi','','0','0','');
