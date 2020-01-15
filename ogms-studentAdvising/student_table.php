<?php
/**
@author Dhruv dgupta

@Description
This Page will let a logged in user look at their advisors.
The user will be able to request upto two advisors on their profile.
If 2 advisors are assigned, the option to add an advisor will be hidden.
*/

//code from huafu to check if code is running on local machine or server

date_default_timezone_set("America/New_York");

include "root.php";



// require_once "bootstrap.php";


$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
$role = $_SESSION['user']['role'];  //Admin / Faculty / Student / Staff
$_SESSION['count_advisors']=0;

//get user details

if(isset($user_pantherid)){

  // Display any alerts



  //user logs in and views the user summary

  $sql="select PantherID,FirstName, LastName , email
  from tbl_student_info
  where status = 'active'";
  
  $statement = $pdo->prepare($sql);
  $statement->execute([':advisor_email'=>$user_email]);



//create table for display
  $table = "<table width='100%' class='table table-striped table-bordered table-hover' id='term-view'>";
  $table.= "
  <thead>
  <tr>
  <b>
  <th>Panther ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Email</th>
  <th>Alter</th>
  </b>
  </tr>
  </thead>";

  $table.= "<tbody>";

  while($row = $statement->fetch(PDO::FETCH_ASSOC)){
    $table.="<tr>";
    $table.= "<td>".$row['PantherID']."</td>";
    $table.= "<td>".$row['FirstName']."</td>";
    $table.= "<td>".$row['LastName']."</td>";
    $table.= "<td>".$row['email']."</td>";


    $table.="<td>

    <form method='post'>
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='submit' name='add_advisor' value='Add'>
    </form>
    </td>
    ";


    $table.= "</tr>";
    
  }
  $table.= "</tbody></table>";

   // echo $table;



} else{
  die("ACCESS DENIED");
}

?>

<script type="text/javascript" src="delete.js"></script>
