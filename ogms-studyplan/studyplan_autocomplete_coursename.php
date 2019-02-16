<?php 
include "root.php";
session_start();
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT subs FROM (SELECT courselist.subs, courselist.courseid, courselist.crn, courselist.credit, sch.termid, sch.facultyid
FROM (SELECT concat(Subject,' ',Course) subs, courseid, crn,credit from tbl_course) courselist 
join tbl_schedule sch on sch.courseid= courselist.courseid
where courselist.subs LIKE :prefix AND sch.termid = :termid
group by crn) monTable";
 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':prefix'=> $_REQUEST['term']."%" , ':termid' => $_REQUEST['term_id']));
$retval = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
	$retval[] = $row['subs'];
}


echo(json_encode($retval, JSON_PRETTY_PRINT));
?>