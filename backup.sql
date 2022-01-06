DROP TABLE admin_tbl;

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_password` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO admin_tbl VALUES("1","admin","pass");
INSERT INTO admin_tbl VALUES("2","admin","admin");



DROP TABLE admission_tbl;

CREATE TABLE `admission_tbl` (
  `admission_id` int(11) NOT NULL AUTO_INCREMENT,
  `admission_fee` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `submit_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`admission_id`),
  KEY `student_id` (`student_id`),
  KEY `admission_tbl_ibfk_2` (`session_id`),
  CONSTRAINT `admission_tbl_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admission_tbl_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO admission_tbl VALUES("1","3200","35","112","1","10-04-2019");
INSERT INTO admission_tbl VALUES("2","3200","26","113","0","09-04-2019");
INSERT INTO admission_tbl VALUES("3","3500","25","114","1","10-04-2019");
INSERT INTO admission_tbl VALUES("4","3000","25","115","1","10-04-2019");
INSERT INTO admission_tbl VALUES("5","798","25","116","1","10-04-2019");
INSERT INTO admission_tbl VALUES("6","988","25","117","1","10-04-2019");
INSERT INTO admission_tbl VALUES("7","988","25","118","1","10-04-2019");
INSERT INTO admission_tbl VALUES("8","988","25","119","1","10-04-2019");
INSERT INTO admission_tbl VALUES("9","988","25","120","1","10-04-2019");
INSERT INTO admission_tbl VALUES("10","988","25","121","1","10-04-2019");
INSERT INTO admission_tbl VALUES("11","988","25","122","1","10-04-2019");
INSERT INTO admission_tbl VALUES("12","988","25","123","1","10-04-2019");
INSERT INTO admission_tbl VALUES("24","76678","25","135","1","23-09-2019");
INSERT INTO admission_tbl VALUES("25","87","37","136","0","");
INSERT INTO admission_tbl VALUES("26","80","34","137","1","16-07-2019");
INSERT INTO admission_tbl VALUES("27","20","34","138","1","16-07-2019");
INSERT INTO admission_tbl VALUES("32","3500","29","125","1","24-10-2019");
INSERT INTO admission_tbl VALUES("34","3500","29","131","0","");
INSERT INTO admission_tbl VALUES("35","3000","35","139","0","");
INSERT INTO admission_tbl VALUES("36","98","36","140","0","");
INSERT INTO admission_tbl VALUES("37","879","36","141","0","");
INSERT INTO admission_tbl VALUES("38","2500","35","142","0","");



DROP TABLE diploma_tbl;

CREATE TABLE `diploma_tbl` (
  `diploma_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `recived_ref_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nic` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`diploma_id`),
  KEY `student_id` (`student_id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `diploma_tbl_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `diploma_tbl_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO diploma_tbl VALUES("18","1","25","64","ALi","khan","08-04-2019");
INSERT INTO diploma_tbl VALUES("19","1","25","65","lsl","983292373287","13-04-2019");
INSERT INTO diploma_tbl VALUES("20","0","25","66","","","");
INSERT INTO diploma_tbl VALUES("21","0","25","67","","","");
INSERT INTO diploma_tbl VALUES("22","0","25","68","","","");
INSERT INTO diploma_tbl VALUES("23","0","25","69","","","");
INSERT INTO diploma_tbl VALUES("24","0","25","70","","","");
INSERT INTO diploma_tbl VALUES("25","0","25","71","","","");
INSERT INTO diploma_tbl VALUES("26","1","25","72","knkljsa","78978879","13-04-2019");
INSERT INTO diploma_tbl VALUES("27","0","26","77","","","");
INSERT INTO diploma_tbl VALUES("28","0","26","78","","","");
INSERT INTO diploma_tbl VALUES("29","0","26","85","","","");
INSERT INTO diploma_tbl VALUES("30","0","26","113","","","");
INSERT INTO diploma_tbl VALUES("31","0","29","125","","","");
INSERT INTO diploma_tbl VALUES("32","0","29","126","","","");



DROP TABLE dmc_tbl;

CREATE TABLE `dmc_tbl` (
  `dmc_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `recived_ref_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nic` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`dmc_id`),
  KEY `student_id` (`student_id`),
  KEY `session_id` (`session_id`),
  KEY `semester_id` (`semester_id`),
  CONSTRAINT `dmc_tbl_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dmc_tbl_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dmc_tbl_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semester_tbl` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO dmc_tbl VALUES("19","1","25","64","khan","15607-66567889-9","02-04-2019","3");
INSERT INTO dmc_tbl VALUES("20","1","25","65","Khan","15607-78312872-9","02-04-2019","3");
INSERT INTO dmc_tbl VALUES("21","1","25","66","nnmj","89879878789","13-04-2019","3");
INSERT INTO dmc_tbl VALUES("22","0","25","67","","","","3");
INSERT INTO dmc_tbl VALUES("23","0","25","68","","","","3");
INSERT INTO dmc_tbl VALUES("24","0","25","69","","","","3");
INSERT INTO dmc_tbl VALUES("25","0","25","70","","","","3");
INSERT INTO dmc_tbl VALUES("26","0","25","71","","","","3");
INSERT INTO dmc_tbl VALUES("27","0","25","72","","","","3");
INSERT INTO dmc_tbl VALUES("28","0","26","77","","","","3");
INSERT INTO dmc_tbl VALUES("29","0","26","78","","","","3");
INSERT INTO dmc_tbl VALUES("30","0","26","85","","","","3");
INSERT INTO dmc_tbl VALUES("31","0","26","113","","","","3");
INSERT INTO dmc_tbl VALUES("32","0","29","125","","","","3");
INSERT INTO dmc_tbl VALUES("33","0","29","126","","","","3");
INSERT INTO dmc_tbl VALUES("35","0","29","131","","","","2");
INSERT INTO dmc_tbl VALUES("36","0","29","132","","","","2");
INSERT INTO dmc_tbl VALUES("37","1","29","133","Khan","15607-66567889-9","15-07-2019","2");
INSERT INTO dmc_tbl VALUES("50","0","29","132","","","","2");
INSERT INTO dmc_tbl VALUES("51","0","29","133","","","","2");
INSERT INTO dmc_tbl VALUES("52","0","29","132","","","","3");
INSERT INTO dmc_tbl VALUES("53","0","29","133","","","","3");
INSERT INTO dmc_tbl VALUES("54","0","29","131","","","","2");
INSERT INTO dmc_tbl VALUES("55","1","29","131","Khan","15607-66567889-9","15-07-2019","3");
INSERT INTO dmc_tbl VALUES("56","0","29","134","","","","2");
INSERT INTO dmc_tbl VALUES("57","0","25","135","","","","2");
INSERT INTO dmc_tbl VALUES("58","0","37","136","","","","2");
INSERT INTO dmc_tbl VALUES("59","0","25","135","","","","3");
INSERT INTO dmc_tbl VALUES("60","0","34","137","","","","2");
INSERT INTO dmc_tbl VALUES("61","0","34","138","","","","2");
INSERT INTO dmc_tbl VALUES("62","0","29","134","","","","3");
INSERT INTO dmc_tbl VALUES("63","0","35","139","","","","2");
INSERT INTO dmc_tbl VALUES("64","0","36","140","","","","2");
INSERT INTO dmc_tbl VALUES("65","0","36","141","","","","2");
INSERT INTO dmc_tbl VALUES("66","0","35","142","","","","2");
INSERT INTO dmc_tbl VALUES("67","0","25","121","","","","3");
INSERT INTO dmc_tbl VALUES("68","0","25","122","","","","3");
INSERT INTO dmc_tbl VALUES("69","0","25","123","","","","3");



DROP TABLE dynamic_fee_tbl;

CREATE TABLE `dynamic_fee_tbl` (
  `dynamic_fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `dynamic_fee_amount` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`dynamic_fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO dynamic_fee_tbl VALUES("2","900");



DROP TABLE fee_tbl;

CREATE TABLE `fee_tbl` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_amount` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_submit_amount` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `year` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `month` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_date` date DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `fee_sumit_date` date DEFAULT NULL,
  `fine_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fine_amount` int(11) DEFAULT '0',
  PRIMARY KEY (`fee_id`),
  KEY `student_id` (`student_id`),
  KEY `semester_id` (`semester_id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `fee_tbl_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fee_tbl_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semester_tbl` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fee_tbl_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO fee_tbl VALUES("50","800","0","25","64","2019","April","2019-04-02","2","1","2019-04-15","","0");
INSERT INTO fee_tbl VALUES("51","800","0","25","65","2019","April","2019-04-02","2","1","2019-04-17","","0");
INSERT INTO fee_tbl VALUES("52","800","0","25","66","2019","April","2019-04-02","4","1","2019-04-13","Late Fee","100");
INSERT INTO fee_tbl VALUES("53","800","0","25","67","2019","April","2019-04-02","4","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("54","800","0","25","68","2019","April","2019-04-02","4","1","2019-04-13","","0");
INSERT INTO fee_tbl VALUES("55","800","0","25","69","2019","April","2019-04-02","4","1","2019-07-11","Late Fee","150");
INSERT INTO fee_tbl VALUES("56","800","0","25","70","2019","April","2019-04-02","4","1","2019-04-11","","0");
INSERT INTO fee_tbl VALUES("57","800","0","25","71","2019","April","2019-04-02","4","1","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("58","800","0","25","72","2019","April","2019-04-02","4","1","2019-04-20","Late Fee","200");
INSERT INTO fee_tbl VALUES("59","900","0","25","65","2019","March","2019-03-01","4","1","2019-04-17","Late Fee","250");
INSERT INTO fee_tbl VALUES("68","900","0","25","72","2019","March","2019-03-04","4","0","2019-04-13","Late Fee","50");
INSERT INTO fee_tbl VALUES("69","600","0","27","86","2019","April","2019-04-08","2","1","2019-04-08","","0");
INSERT INTO fee_tbl VALUES("70","800","0","34","87","2019","April","2019-04-08","2","1","2019-04-08","","0");
INSERT INTO fee_tbl VALUES("74","800","0","25","120","2019","April","2019-04-10","2","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("75","800","0","25","121","2019","April","2019-04-10","2","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("76","800","0","25","116","2019","April","2019-04-10","2","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("77","800","0","35","91","2019","April","2019-04-10","2","1","2019-04-13","","0");
INSERT INTO fee_tbl VALUES("78","800","0","37","109","2019","April","2019-04-10","2","0","0000-00-00","Late Fee","150");
INSERT INTO fee_tbl VALUES("79","800","0","35","112","2019","April","2019-04-10","2","1","2019-09-23","Late Fee","150");
INSERT INTO fee_tbl VALUES("80","800","0","25","114","2019","April","2019-04-10","2","0","0000-00-00","Late Fee","150");
INSERT INTO fee_tbl VALUES("81","800","0","25","115","2019","April","2019-04-10","2","0","0000-00-00","Late Fee","150");
INSERT INTO fee_tbl VALUES("82","800","0","25","117","2019","April","2019-04-10","2","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("83","800","0","25","118","2019","April","2019-04-10","2","1","2019-09-23","Late Fee","150");
INSERT INTO fee_tbl VALUES("84","800","0","25","119","2019","April","2019-04-10","2","0","2019-04-11","Late Fee","150");
INSERT INTO fee_tbl VALUES("85","800","0","25","122","2019","April","2019-04-10","2","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("86","800","0","25","123","2019","April","2019-04-10","2","1","2019-04-10","","0");
INSERT INTO fee_tbl VALUES("88","1000","0","25","65","2019","January","2019-01-11","4","0","2019-04-17","Late Fee","230");
INSERT INTO fee_tbl VALUES("89","800","0","26","75","2019","April","2019-04-13","3","0","0000-00-00","Late Fee","100");
INSERT INTO fee_tbl VALUES("90","800","0","37","76","2019","April","2019-04-13","3","1","2019-04-15","Late Fee","100");
INSERT INTO fee_tbl VALUES("91","800","0","26","77","2019","April","2019-04-13","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("92","800","0","26","78","2019","April","2019-04-13","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("93","800","0","26","79","2019","April","2019-04-13","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("94","800","0","26","80","2019","April","2019-04-13","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("95","800","0","26","81","2019","April","2019-04-13","2","0","0000-00-00","Late Fee","200");
INSERT INTO fee_tbl VALUES("96","800","0","26","85","2019","April","2019-04-13","2","0","0000-00-00","Late Fee","200");
INSERT INTO fee_tbl VALUES("97","800","0","26","113","2019","April","2019-04-13","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("98","800","0","26","75","2019","July","2019-07-10","3","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("99","800","0","37","76","2019","July","2019-07-10","3","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("100","800","0","26","77","2019","July","2019-07-10","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("101","800","0","26","78","2019","July","2019-07-10","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("102","800","0","26","79","2019","July","2019-07-10","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("103","800","0","26","80","2019","July","2019-07-10","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("104","800","0","26","81","2019","July","2019-07-10","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("105","800","0","26","85","2019","July","2019-07-10","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("106","800","0","26","113","2019","July","2019-07-10","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("107","800","0","25","64","2019","July","2019-07-11","4","1","2019-07-11","","0");
INSERT INTO fee_tbl VALUES("108","800","600","25","65","2019","July","2019-07-11","4","2","2019-07-16","","0");
INSERT INTO fee_tbl VALUES("109","800","0","25","66","2019","July","2019-07-11","4","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("110","800","0","25","67","2019","July","2019-07-11","4","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("111","800","0","25","68","2019","July","2019-07-11","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("112","800","0","25","69","2019","July","2019-07-11","4","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("113","800","0","25","70","2019","July","2019-07-11","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("114","800","0","25","71","2019","July","2019-07-11","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("115","800","0","25","72","2019","July","2019-07-11","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("116","800","0","35","91","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("117","800","0","37","109","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("118","800","0","35","112","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("119","800","0","25","114","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("120","800","0","25","115","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("121","800","0","25","116","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("122","800","0","25","117","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("123","800","0","25","118","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("124","800","0","25","119","2019","July","2019-07-11","2","1","2019-07-11","","0");
INSERT INTO fee_tbl VALUES("125","800","0","25","120","2019","July","2019-07-11","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("126","800","0","25","121","2019","July","2019-07-11","2","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("127","800","0","25","122","2019","July","2019-07-11","2","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("128","800","300","25","123","2019","July","2019-07-11","2","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("129","900","0","34","87","2019","July","2019-07-11","2","1","2019-07-11","","0");
INSERT INTO fee_tbl VALUES("130","800","0","27","86","2019","July","2019-07-11","2","0","0000-00-00","Late Fee","200");
INSERT INTO fee_tbl VALUES("136","900","0","25","64","2019","September","2019-07-11","4","1","2019-07-11","","0");
INSERT INTO fee_tbl VALUES("137","900","0","25","64","2019","October","2019-07-11","4","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("138","900","0","29","125","2019","July","2019-07-11","4","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("139","900","0","29","126","2019","July","2019-07-11","4","1","2019-07-15","","0");
INSERT INTO fee_tbl VALUES("140","900","400","29","134","2019","July","2019-07-15","2","1","2019-07-29","Late Fee","100");
INSERT INTO fee_tbl VALUES("141","900","300","25","135","2019","July","2019-07-15","2","1","2019-09-23","","0");
INSERT INTO fee_tbl VALUES("142","900","300","29","131","2019","July","2019-07-16","3","1","2019-07-16","","0");
INSERT INTO fee_tbl VALUES("143","900","700","29","132","2019","July","2019-07-16","2","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("144","900","0","29","133","2019","July","2019-07-16","2","1","2019-10-24","Late Fee","300");
INSERT INTO fee_tbl VALUES("145","900","50","34","137","2019","July","2019-07-16","2","2","2019-07-16","","0");
INSERT INTO fee_tbl VALUES("146","900","0","34","138","2019","July","2019-07-16","2","0","0000-00-00","","0");
INSERT INTO fee_tbl VALUES("147","800","100","34","137","2019","June","2019-07-16","2","2","2019-07-16","","0");
INSERT INTO fee_tbl VALUES("148","900","","25","65","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("149","900","","25","66","2019","September","2019-09-23","4","1","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("150","900","","25","67","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("151","900","","25","68","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("152","900","","25","69","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("153","900","","25","70","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("154","900","","25","71","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("155","900","","25","72","2019","September","2019-09-23","4","0","","","0");
INSERT INTO fee_tbl VALUES("156","900","","35","91","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("157","900","","37","109","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("158","900","","35","112","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("159","900","","25","114","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("160","900","","25","115","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("161","900","","25","116","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("162","900","","25","117","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("163","900","","25","118","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("164","900","","25","119","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("165","900","","25","120","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("166","900","","25","121","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("167","900","","25","122","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("168","900","","25","123","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("169","900","","25","135","2019","September","2019-09-23","3","0","","","0");
INSERT INTO fee_tbl VALUES("170","900","","37","136","2019","September","2019-09-23","2","0","","","0");
INSERT INTO fee_tbl VALUES("171","900","","26","75","2019","September","2019-09-24","3","0","","","0");
INSERT INTO fee_tbl VALUES("172","900","","37","76","2019","September","2019-09-24","2","0","","","0");
INSERT INTO fee_tbl VALUES("173","900","","26","77","2019","September","2019-09-24","4","0","","","0");
INSERT INTO fee_tbl VALUES("174","900","","26","78","2019","September","2019-09-24","4","0","","","0");
INSERT INTO fee_tbl VALUES("175","900","","26","79","2019","September","2019-09-24","2","0","","","0");
INSERT INTO fee_tbl VALUES("176","900","","26","80","2019","September","2019-09-24","2","0","","","0");
INSERT INTO fee_tbl VALUES("177","900","","26","81","2019","September","2019-09-24","2","0","","","0");
INSERT INTO fee_tbl VALUES("178","900","","26","85","2019","September","2019-09-24","4","0","","","0");
INSERT INTO fee_tbl VALUES("179","900","","26","113","2019","September","2019-09-24","4","0","","","0");
INSERT INTO fee_tbl VALUES("180","900","","25","65","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("181","900","","25","66","2019","October","2019-10-06","4","1","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("182","900","","25","67","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("183","900","","25","68","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("184","900","","25","69","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("185","900","","25","70","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("186","900","","25","71","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("187","900","","25","72","2019","October","2019-10-06","4","0","","","0");
INSERT INTO fee_tbl VALUES("188","900","","35","91","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("189","900","","37","109","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("190","900","","35","112","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("191","900","","25","114","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("192","900","","25","115","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("193","900","","25","116","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("194","900","","25","117","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("195","900","","25","118","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("196","900","","25","119","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("197","900","","25","120","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("198","900","","25","121","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("199","900","","25","122","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("200","900","","25","123","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("201","900","","25","135","2019","October","2019-10-06","3","0","","","0");
INSERT INTO fee_tbl VALUES("202","900","","37","136","2019","October","2019-10-06","2","0","","","0");
INSERT INTO fee_tbl VALUES("203","900","","29","125","2019","October","2019-10-22","4","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("204","900","","29","126","2019","October","2019-10-22","4","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("205","900","","29","131","2019","October","2019-10-22","3","0","","Late Fee","100");
INSERT INTO fee_tbl VALUES("206","900","","29","132","2019","October","2019-10-22","2","0","2019-10-24","Late Fee","100");
INSERT INTO fee_tbl VALUES("207","900","","29","133","2019","October","2019-10-22","2","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("208","900","200","29","134","2019","October","2019-10-22","2","2","2019-10-28","","0");
INSERT INTO fee_tbl VALUES("209","800","","29","131","2019","January","2019-10-22","3","0","","","0");
INSERT INTO fee_tbl VALUES("210","800","","29","131","2019","Febuary","2019-10-22","3","0","","Late Fee","400");
INSERT INTO fee_tbl VALUES("211","800","","29","131","2019","March","2019-10-22","3","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("212","800","","29","131","2019","April","2019-10-22","3","1","2019-10-24","","0");
INSERT INTO fee_tbl VALUES("213","800","","29","131","2019","May","2019-10-22","3","0","","","0");
INSERT INTO fee_tbl VALUES("214","800","","29","126","2019","January","2019-10-24","4","0","","","0");
INSERT INTO fee_tbl VALUES("215","800","","29","126","2019","Febuary","2019-10-24","4","0","","Late Fee","400");
INSERT INTO fee_tbl VALUES("216","800","","29","126","2019","March","2019-10-24","4","0","","","0");
INSERT INTO fee_tbl VALUES("217","800","","29","131","2019","September","2019-10-28","3","1","2019-10-28","","0");
INSERT INTO fee_tbl VALUES("218","200","","29","132","2019","September","2019-10-28","2","0","","Late Fee","100");
INSERT INTO fee_tbl VALUES("219","900","500","25","64","2020","February","2020-02-13","4","2","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("220","900","","25","65","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("221","900","","25","66","2020","February","2020-02-13","4","1","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("222","900","","25","67","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("223","900","","25","68","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("224","900","","25","69","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("225","900","","25","70","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("226","900","","25","71","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("227","900","","25","72","2020","February","2020-02-13","4","0","","","0");
INSERT INTO fee_tbl VALUES("228","900","","35","91","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("229","900","","37","109","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("230","900","","35","112","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("231","900","","25","114","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("232","900","","25","115","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("233","900","","25","116","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("234","900","","25","117","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("235","900","","25","118","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("236","900","","25","119","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("237","900","","25","120","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("238","900","","25","121","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("239","900","","25","122","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("240","900","500","25","123","2020","February","2020-02-13","2","2","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("241","900","","25","135","2020","February","2020-02-13","3","0","","","0");
INSERT INTO fee_tbl VALUES("242","900","","37","136","2020","February","2020-02-13","2","0","","","0");
INSERT INTO fee_tbl VALUES("243","800","","25","64","2020","March","2020-02-13","4","1","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("244","800","","25","64","2020","April","2020-02-13","4","1","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("245","800","","25","64","2020","May","2020-02-13","4","1","2020-02-13","","0");
INSERT INTO fee_tbl VALUES("246","800","","25","64","2020","June","2020-02-13","4","1","2020-02-13","","0");



DROP TABLE fine_tbl;

CREATE TABLE `fine_tbl` (
  `fine_id` int(11) NOT NULL AUTO_INCREMENT,
  `fine_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fine_amount` int(5) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`fine_id`),
  KEY `student_id` (`student_id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `fine_tbl_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fine_tbl_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO fine_tbl VALUES("1","Exam Fee","500","125","29","1");
INSERT INTO fine_tbl VALUES("2","Exam Fee","500","126","29","1");
INSERT INTO fine_tbl VALUES("3","Exam Fee","500","131","29","1");
INSERT INTO fine_tbl VALUES("5","Exam Fee","500","133","29","1");
INSERT INTO fine_tbl VALUES("6","Exam Fee","500","134","29","0");
INSERT INTO fine_tbl VALUES("7","Tution Fee","300","125","29","1");
INSERT INTO fine_tbl VALUES("8","Tution Fee","300","126","29","1");
INSERT INTO fine_tbl VALUES("9","Tution Fee","300","131","29","1");
INSERT INTO fine_tbl VALUES("10","Tution Fee","300","132","29","1");
INSERT INTO fine_tbl VALUES("11","Tution Fee","300","133","29","1");
INSERT INTO fine_tbl VALUES("12","Tution Fee","300","134","29","1");
INSERT INTO fine_tbl VALUES("13","Exam Fee","1000","137","34","0");
INSERT INTO fine_tbl VALUES("14","Exam Fee","1000","138","34","0");
INSERT INTO fine_tbl VALUES("15","exam fee late","200","125","29","0");
INSERT INTO fine_tbl VALUES("17","exam fee late","200","131","29","1");
INSERT INTO fine_tbl VALUES("18","exam fee late","200","132","29","0");
INSERT INTO fine_tbl VALUES("19","exam fee late","200","133","29","0");
INSERT INTO fine_tbl VALUES("20","exam fee late","200","134","29","0");
INSERT INTO fine_tbl VALUES("21","diploma fee","100","125","29","0");
INSERT INTO fine_tbl VALUES("22","diploma fee","100","126","29","0");
INSERT INTO fine_tbl VALUES("23","diploma fee","100","131","29","1");
INSERT INTO fine_tbl VALUES("24","diploma fee","100","132","29","0");
INSERT INTO fine_tbl VALUES("25","diploma fee","100","133","29","0");
INSERT INTO fine_tbl VALUES("26","diploma fee","100","134","29","0");



DROP TABLE registration_card_tbl;

CREATE TABLE `registration_card_tbl` (
  `reg_card_id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_card_status` tinyint(2) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`reg_card_id`),
  KEY `student_id` (`student_id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `registration_card_tbl_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `registration_card_tbl_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO registration_card_tbl VALUES("3","1","25","64","02-04-2019");
INSERT INTO registration_card_tbl VALUES("4","1","25","65","02-04-2019");
INSERT INTO registration_card_tbl VALUES("5","1","25","66","02-04-2019");
INSERT INTO registration_card_tbl VALUES("6","1","25","67","02-04-2019");
INSERT INTO registration_card_tbl VALUES("7","1","25","68","02-04-2019");
INSERT INTO registration_card_tbl VALUES("8","1","25","69","02-04-2019");
INSERT INTO registration_card_tbl VALUES("9","1","25","70","02-04-2019");
INSERT INTO registration_card_tbl VALUES("10","1","25","71","02-04-2019");
INSERT INTO registration_card_tbl VALUES("11","1","25","72","02-04-2019");
INSERT INTO registration_card_tbl VALUES("14","1","26","75","02-04-2019");
INSERT INTO registration_card_tbl VALUES("15","0","37","76","");
INSERT INTO registration_card_tbl VALUES("16","0","26","77","");
INSERT INTO registration_card_tbl VALUES("17","1","26","78","02-04-2019");
INSERT INTO registration_card_tbl VALUES("18","0","26","79","");
INSERT INTO registration_card_tbl VALUES("19","0","26","80","");
INSERT INTO registration_card_tbl VALUES("20","1","26","81","02-04-2019");
INSERT INTO registration_card_tbl VALUES("24","0","26","85","");
INSERT INTO registration_card_tbl VALUES("25","0","27","86","");
INSERT INTO registration_card_tbl VALUES("26","0","34","87","");
INSERT INTO registration_card_tbl VALUES("30","1","35","91","09-04-2019");
INSERT INTO registration_card_tbl VALUES("50","0","37","109","");
INSERT INTO registration_card_tbl VALUES("53","0","35","112","");
INSERT INTO registration_card_tbl VALUES("54","0","26","113","");
INSERT INTO registration_card_tbl VALUES("55","0","25","114","");
INSERT INTO registration_card_tbl VALUES("56","0","25","115","");
INSERT INTO registration_card_tbl VALUES("57","0","25","116","");
INSERT INTO registration_card_tbl VALUES("58","0","25","117","");
INSERT INTO registration_card_tbl VALUES("59","0","25","118","");
INSERT INTO registration_card_tbl VALUES("60","0","25","119","");
INSERT INTO registration_card_tbl VALUES("61","0","25","120","");
INSERT INTO registration_card_tbl VALUES("62","0","25","121","");
INSERT INTO registration_card_tbl VALUES("63","0","25","122","");
INSERT INTO registration_card_tbl VALUES("64","0","25","123","");
INSERT INTO registration_card_tbl VALUES("66","1","29","125","11-07-2019");
INSERT INTO registration_card_tbl VALUES("67","0","29","126","");
INSERT INTO registration_card_tbl VALUES("72","0","29","131","");
INSERT INTO registration_card_tbl VALUES("73","0","29","132","");
INSERT INTO registration_card_tbl VALUES("74","0","29","133","");
INSERT INTO registration_card_tbl VALUES("75","0","29","134","");
INSERT INTO registration_card_tbl VALUES("76","0","25","135","");
INSERT INTO registration_card_tbl VALUES("77","1","37","136","13-02-2020");
INSERT INTO registration_card_tbl VALUES("78","0","34","137","");
INSERT INTO registration_card_tbl VALUES("79","0","34","138","");
INSERT INTO registration_card_tbl VALUES("80","0","35","139","");
INSERT INTO registration_card_tbl VALUES("81","0","36","140","");
INSERT INTO registration_card_tbl VALUES("82","0","36","141","");
INSERT INTO registration_card_tbl VALUES("83","0","35","142","");



DROP TABLE semester_tbl;

CREATE TABLE `semester_tbl` (
  `semester_id` int(11) NOT NULL AUTO_INCREMENT,
  `semester_title` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`semester_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO semester_tbl VALUES("2","1st samester");
INSERT INTO semester_tbl VALUES("3","2nd Samester");
INSERT INTO semester_tbl VALUES("4","Pass Out");



DROP TABLE session_tbl;

CREATE TABLE `session_tbl` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_title` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO session_tbl VALUES("25","DIT April-2019 to April-2020");
INSERT INTO session_tbl VALUES("26","April-2020 to April-2021");
INSERT INTO session_tbl VALUES("27","may-2021 to may-2022");
INSERT INTO session_tbl VALUES("29","January-2020 to january-2021");
INSERT INTO session_tbl VALUES("34","test");
INSERT INTO session_tbl VALUES("35","new");
INSERT INTO session_tbl VALUES("36","good");
INSERT INTO session_tbl VALUES("37","miscellaneous");



DROP TABLE student_info;

CREATE TABLE `student_info` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_fname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_mobile` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  KEY `semester_id` (`semester_id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semester_tbl` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_info_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `session_tbl` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO student_info VALUES("64","Kish Fawad","ferhez gar","malakand","2147483647","4","25");
INSERT INTO student_info VALUES("65","Kaleem","Ali","swat","2147483647","4","25");
INSERT INTO student_info VALUES("66","Naeem","Jalal","kabel","2147483647","4","25");
INSERT INTO student_info VALUES("67","Saleem","Bazir lah","kostan get","2147483647","4","25");
INSERT INTO student_info VALUES("68","shahil","zahid","gogdara","376476545","4","25");
INSERT INTO student_info VALUES("69","Zabbir","shahalam","ghaligai","328773443","4","25");
INSERT INTO student_info VALUES("70","zubair","munair","kabel","2147483647","4","25");
INSERT INTO student_info VALUES("71","Malakand khan","bazari khan","malakand","237673464","4","25");
INSERT INTO student_info VALUES("72","Ali","khan","swat","2147483647","4","25");
INSERT INTO student_info VALUES("75","Hassan Saeed","saeed u din","rang mohala","384297478","3","26");
INSERT INTO student_info VALUES("76","kashif","Khan","bacha saib cham","8732734","2","37");
INSERT INTO student_info VALUES("77","Umar","shina","Amankot","384328734","4","26");
INSERT INTO student_info VALUES("78","Umar","shina","Amankot","384328734","4","26");
INSERT INTO student_info VALUES("79","Abdullah","Khan zada","Navi kelai","378237644","2","26");
INSERT INTO student_info VALUES("80","Rashid","khan","banr","2147483647","2","26");
INSERT INTO student_info VALUES("81","Atta Ullah","Saif Ullah","Islampur","2147483647","2","26");
INSERT INTO student_info VALUES("85","Khan","Bacha","swat","983127327","4","26");
INSERT INTO student_info VALUES("86","Ali","khan","swat","874328734","2","27");
INSERT INTO student_info VALUES("87","Jan Khan","Baba","mingora","34839248","2","34");
INSERT INTO student_info VALUES("91","Fawad","Khan","amankot","2147483647","2","35");
INSERT INTO student_info VALUES("109","Khan Ali","Baba","Islampur","9224328","2","37");
INSERT INTO student_info VALUES("112","Naveed","Khan","mardan","3828327","2","35");
INSERT INTO student_info VALUES("113","khan","Baba","swat","92988232","4","26");
INSERT INTO student_info VALUES("114","khan","jan","swat","9090990","2","25");
INSERT INTO student_info VALUES("115","jkajkd","klsad","kjl","89897","2","25");
INSERT INTO student_info VALUES("116","jklsad","j","klj","897","2","25");
INSERT INTO student_info VALUES("117","wa","dsa","kj","0","2","25");
INSERT INTO student_info VALUES("118","wa","dsa","kj","0","2","25");
INSERT INTO student_info VALUES("119","wa","dsa","kj","0","2","25");
INSERT INTO student_info VALUES("120","wa","dsa","kj","0","2","25");
INSERT INTO student_info VALUES("121","wa","dsa","kj","0","3","25");
INSERT INTO student_info VALUES("122","wa","dsa","kj","0","3","25");
INSERT INTO student_info VALUES("123","wa","dsa","kj","0","3","25");
INSERT INTO student_info VALUES("125","AliKhan","gul Khan","swat","99887768","4","29");
INSERT INTO student_info VALUES("126","Jan","Mana","swat","988789","4","29");
INSERT INTO student_info VALUES("131","Ihsan","khan","swat","873467","3","29");
INSERT INTO student_info VALUES("132","Hassan","jan","swat","34873346","3","29");
INSERT INTO student_info VALUES("133","Kashif","Gul","Swat","378356","3","29");
INSERT INTO student_info VALUES("134","test","test","test","92988232","3","29");
INSERT INTO student_info VALUES("135","test","test","test","7665","3","25");
INSERT INTO student_info VALUES("136","test","test","test","8787","2","37");
INSERT INTO student_info VALUES("137","hi","hi","hi","90","2","34");
INSERT INTO student_info VALUES("138","hi","hi","hi","898","2","34");
INSERT INTO student_info VALUES("139","Attaullah","khan","swat","2147483647","2","35");
INSERT INTO student_info VALUES("140","j","ljk","lkj","98","2","36");
INSERT INTO student_info VALUES("141","dsjk","jhk","hjk","87667","2","36");
INSERT INTO student_info VALUES("142","New Student","Khan","New One","03441897099","3","35");



