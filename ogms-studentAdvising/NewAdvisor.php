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
include 'add_advisor.php';
include 'test.php';

$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
//include $root.'/authenticate.php';

if(isset($_GET['pid'])){
    // $user_name = $_SESSION['user']['name'] ;
    // $user_email = $_SESSION['user']['mail'] ;
    $user_pantherid = $_GET['pid'] ;
    $_SESSION['student']['pid']= $user_pantherid;
}

function countAdvisors($value){
   if($_SERVER['HTTP_HOST'] == "localhost")
    {    include "connection.php";
}else {
    include "pdo_connection_server.php";
} 
$sql = "Select count(*) count from tbl_student_advising where pantherid = :pantherid";
$statement = $pdo->prepare($sql);
$statement->execute(array(':pantherid'=>$value)); 
$row = $statement->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];

if($count>=2 && !isset($_GET['sno'])){
    //sno is to handle the editing case, if sno is set then the check for advisor count can be skipped
 return 0;
} else return 1;

}


if ( isset($_POST['add']) && !isset($_GET['advisor_email']) ) {
    //$_GET['email'] is only set when editing

    if(countAdvisors($user_pantherid)==1){

        date_default_timezone_set("America/New_York");
        $date = date("Y/m/d h:i:s a");
        $sql = "insert into tbl_student_advising (pantherid,Advisor_email,lastModified)
        values (:pantherid,:email,:lastModified);";
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':pantherid'=>$user_pantherid,':email'=>$_POST['advisor'],':lastModified'=>$date));
        header("Location: newStudent.php");
        return;
    } elseif(countAdvisors($user_pantherid)==0){
       $_SESSION['error']='Already have 2 advisors';
       header("Location: newStudent.php");
       return;
   }

}elseif( isset($_POST['add']) && isset($_GET['advisor_email']) ){
    //this handles the editing scenario
    date_default_timezone_set("America/New_York");
    $date = date("Y/m/d h:i:s a");
    $sql = "update tbl_student_advising
    set Advisor_email = :email,
    lastModified = :lastModified,
    status = 'pending' 
    where sno = :sno";
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':email'=>$_POST['advisor'],':lastModified'=>$date,':sno'=>$_GET['sno']));
    

    header("Location: newStudent.php");
    return;
}

if ( isset($_POST['cancel'] ) ) {
  header("Location: newStudent.php");
  return;
}




?>
<html lang="en">
<!-- Header -->
<?php
if($_SERVER['HTTP_HOST'] != "localhost"){
    include $root.'/links/header.php';
}

?>
<!-- /#Header -->
<body>
    <!-- Navigation -->
    <?php
    if($_SERVER['HTTP_HOST'] != "localhost"){
        include $root.'/UI/staff/staffmenu.php';
    }
    ?>
    <!-- /#Navigation -->

    <!-- wrapper -->
    <div id="wrapper">
        <!-- page-wrapper -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Welcome <?php echo $user_name?></h4>
                    <h1 class="page-header">Select a new advisor</h1>
                    <span id="response"></span>
                    <?php echo $form;?>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- FooterLinks -->
    <?php
    if($_SERVER['HTTP_HOST'] != "localhost"){
        include $root.'/links/footerLinks.php';
    }
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
