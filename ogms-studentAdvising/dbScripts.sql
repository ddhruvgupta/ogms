CREATE TABLE tbl_student_advising (
SNo INT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
pantherid INT UNSIGNED not NULL,
Advisor_email VARCHAR(128),
status enum('pending','approved','rejected','graduated') DEFAULT 'pending',
dt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


insert into tbl_student_advising (pantherid,firstName,lastName,status) values (900806428,'dhruv','gupta','NA');

student_id - faculty email - when_updated - who_updated
