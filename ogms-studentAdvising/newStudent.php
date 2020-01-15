<?php
/// Project:	term
/// Class:	    termviewdashboard
/// <summary>
/// This is the main container and fill the data of teamview
/// </summary>
/// <remarks><para><pre>
/// RevisionHistory:
/// --------------------------------------------------------------------------------
/// Date		Name			Description
/// --------------------------------------------------------------------------------
/// 05/23/2017	HUAFU HU		Initial Creation
/// </pre></para>
/// </remarks>
/// --------------------------------------------------------------------------------

session_start();
require "root.php";
require "test.php";
require "security.php";
include 'student.php';

//get user details
$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
$role = $_SESSION['user']['role'] ;
//include $root.'/authenticate.php';



//check if any post conditions are true
if(isset($_POST['add_advisor']) ){
  if($role == 'Student'){
    header("location:NewAdvisor.php");
    return;
  }else if($role == 'Faculty'){
    header("location:faculty_view_add_advisor.php");
    return;
  } else if($role == 'Admin' || $role == 'Staff'){
    header("location:admin_view_add_advisor.php");
    return;
  }
  
}

if(isset($_POST['edit']) ){
  $_SESSION['student']['pid']=$_POST['pantherid'];
  $req = "location:NewAdvisor.php?pantherid=".$_POST['pantherid']."&sno=".$_POST['sno']."&advisor_email=".$_POST['advisor_email'];
  header($req);
  return;
}

if(isset($_POST['logout']) ){
  header("location:logout.php");
  return;
}

if(isset($_POST['del']) ){
  $sql = "delete from tbl_student_advising where SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':sno'=>$_POST['sno']));

  $_SESSION['error'] = "Successfully  Deleted";
  header("location:newStudent.php");
  return;
}

if(isset($_POST['approve']) ){

  $sql = "update tbl_student_advising SET status='approved' WHERE SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':sno'=>$_POST['sno']));

  date_default_timezone_set("America/New_York");
  $date = date("Y/m/d h:i:s");

  $sql = "update tbl_student_advising SET lastModified=:date WHERE SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':date'=>$date,':sno'=>$_POST['sno']));

  $_SESSION['error'] = "Successfully  Approved";
  header("location:newStudent.php");
  exit;
}

if(isset($_POST['reject']) ){

  $sql = "update tbl_student_advising SET status='rejected' WHERE SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':sno'=>$_POST['sno']));

  date_default_timezone_set("America/New_York");
  $date = date("Y/m/d h:i:s");

  $sql = "update tbl_student_advising SET lastModified=:date WHERE SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':date'=>$date,':sno'=>$_POST['sno']));

  $_SESSION['error'] = "Request Successfully  Rejected";
  header("location:newStudent.php");
  exit;
}

if(isset($_POST['graduate']) ){

  $sql = "update tbl_student_advising SET status='graduated' WHERE SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':sno'=>$_POST['sno']));

  date_default_timezone_set("America/New_York");
  $date = date("Y/m/d h:i:s");

  $sql = "update tbl_student_advising SET lastModified=:date WHERE SNo = :sno";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':date'=>$date,':sno'=>$_POST['sno']));

  $_SESSION['error'] = "Student set to graduated";
  header("location:newStudent.php");
  exit;
}


$add_advisor = "<form method='POST'><input type='submit' name='add_advisor' value='Add Advisor' ></form>";




?>
<html lang="en">
<!-- Header -->
<head>
  <style>
  form{margin: 0; display: inline;}

</style>
</head>
<?php if($_SERVER['HTTP_HOST'] != "localhost"){ include $root.'/links/header.php';} ?>
<!-- /#Header -->
<body>
  <!-- Navigation -->
  <?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/UI/staff/staffmenu.php';}  ?>
  <!-- /#Navigation -->

  <!-- wrapper -->
</br>
</br>
<div id="container">
  <!-- page-wrapper -->
  <div id="page-wrapper" class="col">
    <div class="row">

      <?php

      if(isset($_SESSION['insert']) ){
        $error =  "<div class='col-md-4 col-md-offset-5'><p class='text-success'>".$_SESSION['insert']."</p></div></br>";
        unset($_SESSION['insert']);
      }

      if(isset($_SESSION['error']) ){
        $error =  "<div class='col-md-4 col-md-offset-5'><p class='text-danger'>".$_SESSION['error']."</p></div></br>";
        unset($_SESSION['error']);
      }
      if(isset($error)) echo $error;
      echo '<br/>';
      echo $add_advisor;
      echo $table;
      ?>


    </div>

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- FooterLinks -->
<?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/links/footerLinks.php';  } ?>
<!-- /#FooterLinks -->
</body>
<script src='https://code.jquery.com/jquery-3.3.1.min.js' integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=' crossorigin='anonymous'></script>
<script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

<script type="text/javascript">

  $( document ).ready(function() {
    $(document).ready(function() {
      $('#term-view').DataTable({
        responsive: true

      });

    });
  });

</script>

</html>
