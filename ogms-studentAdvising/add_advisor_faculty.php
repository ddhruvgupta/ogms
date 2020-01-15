<!--
1. Check how many advisors the student has
2. if <2 continue else return to view page. show alert that user already has 2 advisors
3. display name and then give drop down for Advisor options
-->

<?php
session_start();
//code from huafu to check if code is running on local machine or server

if (isset($_SERVER['HTTP_HOST']))
{
    if($_SERVER['HTTP_HOST'] == "localhost")
    {
        require_once "connection.php";
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
        define("ROOT",$root."/student/ogms/public_html");
        $root = ROOT;


        require_once "connection.php";
    }
    else
    {
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
        //db connection on server
        //include($root.'/osms.dbconfig.inc');
        include "pdo_connection_server.php";
    }
}
else
{
    $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
}

if(  isset($_SESSION['user']['name'])  ){


  $user_email = $_SESSION['user']['email'];
	
//retrieve list of faculty / possible advisors
  $sql = "select FirstName,LastName,email from tbl_faculty_info where email = :email";
  $statement = $pdo->prepare($sql);
  $statement->execute([':email'=>$user_email]);
	$faculty = $statement->fetch(PDO::FETCH_ASSOC);
	$fname = $faculty['FirstName'];
	$lname = $faculty['LastName'];
	$email = $faculty['email'];
	




//In case someone comes directly to this page,
//confirm that user has less that 2 advisors or return to student page.


//Handling form submission


//handling the case where the user decides to cancel the advisor submission

$form = "<form method='post'>
<div class='form-group'>
  <label for='email'>Student Email: </label>
  <input type='text' name='email' size='30' >
  </div>

<div class='form-group'>
    <input type='submit' name='search' value='Search'>
    <input type='submit' name='cancel' value='Cancel'>
</div>
</form>";


if(isset($_POST['search'])){
	//retrieve user details from students table
  $sql ="select FirstName,LastName, pantherid from tbl_student_info where email = :email";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':email'=>$_POST['email']));
  $student_record = $statement->fetch(PDO::FETCH_ASSOC);
  
  $form2 = "<form method='post'>
<div class='form-group'>
  <label for='fname'>First Name: </label>";
  $form2.= $student_record['FirstName'];
  $form2.="
</div>
<div class='form-group'>
  <label for='lname'>Last Name: </label>";
  $form2.= $student_record['LastName'];
  $form2.="</div>
<div class='form-group'>
  <label for='lname'>Panther ID: </label>";
  $form2.= $student_record['pantherid'];
  $form2.= "</div>
<div class='form-group'>
  <label for='adv_select'>Advisor: </label>";
  $form2.= $fname.' '.$lname;
$form2.="</div>
</form>";

}

}

?>

<html>
<body>
<?php 

echo $form;

?>

</body>
</html>