<?php
/// Project:	Student-Advisor Relationship management
/// Class:	  Faculty view- Add advisor
/// <summary>
/// This page is used to generate a page to assign a student to an adivisor.
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
require "security.php";

$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
//include $root.'/authenticate.php';
include 'student_table.php';


if(isset($_POST['logout']) ){
  header("location:logout.php");
  return;
}

if(isset($_POST['add_advisor']) ){
  /*the user will select the add button for a user from the table generated in student_table.php
  the post request will contain the panther ID of the student who is being chosen
  check the number of advisors that he student already has ... if number of advisors < 2
  then add the user to the student_advising table
  */ 


  $sql = "select count(*) count from tbl_student_advising where pantherid = :pantherid";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':pantherid'=>$_POST['pantherid']));
  $row = $statement->fetch(PDO::FETCH_ASSOC);
  $count = $row['count'];

  if($count >=2){
    $_SESSION['error'] = "Student already has 2 advisors - please delete an existing advisor";
    header("location:newStudent.php");
    return;
  }else{
   $_SESSION['student']['pid'] = $_POST['pantherid'];

    header("Location: NewAdvisor.php?pid=".$_POST['pantherid']);
    return;
  }

  
}


?>
<html lang="en">
<!-- Header -->
<?php if($_SERVER['HTTP_HOST'] != "localhost"){ include $root.'/links/header.php'; }  ?>
<!-- /#Header -->
<body>
<!-- Navigation -->
<?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/UI/staff/staffmenu.php'; } ?>
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
				          
                  
                echo $table;
                ?>


        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- FooterLinks -->
<?php
include $root.'/links/footerLinks.php';
?>
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
