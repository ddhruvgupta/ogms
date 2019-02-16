<?php 
include "root.php";

// Check that PantherID-TermID combination is unique in AJAX before passing control to this module

// Variables for tbl_student_studyplan
$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
$role = $_SESSION['user']['role'];  //Admin / Faculty / Student / Staff


// TODO: get information of current user 
$sql="select * from (select PantherID,FirstName,LastName,email from tbl_student_info
union 
select PantherID,FirstName,LastName,email from tbl_excel_info) as all_students 
where PantherID = :pid
group by PantherID";
$statement = $pdo->prepare($sql);
$statement->execute( array(':pid' => $user_pantherid ));
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Insert into tbl_student_studyplan

$statement = $pdo->prepare('INSERT INTO tbl_student_studyplan (pantherid,firstname,lastname,termid)
	VALUES (:pid, :fname, :lname, :tid)');

$statement->execute( array(':pid' => $user_pantherid , 
	':fname' => $user['FirstName'],
	':lname' => $user['LastName'],
	':tid' => $_POST['term']
));

// Variables for tbl_student_studyplan_classes
$profile_id = $pdo->lastInsertID();
$_POST['p'] = $profile_id;

$sql = 'INSERT INTO tbl_student_studyplan_classes (studyplanid,rank,course,schedule, CRN, credits)
VALUES (:spid, :rank, :course, :schedule, :CRN, :credits)';



// Insert into tbl_student_studyplan_classes

for($i=1; $i<=6;$i++){
	if(isset($_POST['course'.$i])){
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(':spid' => $profile_id,
			':rank' => $i,
			':course' => $_POST['course'.$i],
			':schedule' => $_POST['schedule'.$i],
			':CRN' => $_POST['CRN'.$i],
			':credits' => $_POST['credit'.$i]
		));
	}
}

// Return Control

$_SESSION['success'] = 'Record Successfully Inserted';
header('location: studentstudyplan.php');
return;

?>