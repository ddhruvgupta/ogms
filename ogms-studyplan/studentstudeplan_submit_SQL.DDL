CREATE TABLE tbl_student_studyplan (
studyplanid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
pantherid INT(11),
firstname VARCHAR(100),
lastname VARCHAR(100),
termid 	INT(11)
);

ALTER TABLE tbl_student_studyplan ADD UNIQUE( pantherid, termid);

CREATE TABLE tbl_student_studyplan_classes (
studyplanid INT(6) UNSIGNED,
rank INT(6) UNSIGNED,
course VARCHAR(100),
schedule VARCHAR(100),
CRN 	INT(6),
credits INT(2));
CONSTRAINT  FK_studyplanid FOREIGN KEY (studyplanid) 
REFERENCES tbl_student_studyplan(studyplanid)
);

ALTER TABLE `tbl_student_studyplan_classes` ADD INDEX(`studyplanid`);

ALTER TABLE `tbl_student_studyplan_classes` ADD CONSTRAINT `FK_studyplan_id` FOREIGN KEY (`studyplanid`) REFERENCES `tbl_student_studyplan`(`studyplanid`) ON DELETE CASCADE ON UPDATE CASCADE;