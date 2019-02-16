<?php 
include "root.php";
session_start();
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT crn FROM (SELECT courselist.subs, courselist.courseid, courselist.crn, courselist.credit, sch.termid, sch.facultyid
FROM (SELECT concat(Subject,' ',Course) subs, courseid, crn,credit from tbl_course) courselist 
join tbl_schedule sch on sch.courseid= courselist.courseid
where courselist.subs LIKE :prefix AND sch.termid = :termid AND sch.scheduleid = :sid) monTable
limit 1";
 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':prefix'=> $_REQUEST['course_name'] , ':termid' => $_REQUEST['term_id'], 
	':sid' => $_REQUEST['scheduleid']));
$retval = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
	$retval[] = $row['crn'];
}

echo(json_encode($retval, JSON_PRETTY_PRINT));
?>