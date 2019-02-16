<?php 
include "root.php";
session_start();
header('Content-Type: application/json; charset=utf-8');

$sql = "select distinct concat(days,' ',starttime, '-',endtime ) schedule from tbl_schedule where termid = :termid ";
 
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':termid' => $_REQUEST['term_id']	));
$retval = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
	$retval[] = $row['schedule'];
}

echo(json_encode($retval, JSON_PRETTY_PRINT));
?>