<?php
/**
@author Dhruv Gupta

@Description
This Page will let a logged in user look at their advisors.
The user will be able to request upto two advisors on their profile.
If 2 advisors are assigned, the option to add an advisor will be hidden.
*/



date_default_timezone_set("America/New_York");


include "root.php";

// require_once "bootstrap.php";


$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
$role = $_SESSION['user']['role'];  //Admin / Faculty / Student / Staff
$_SESSION['count_advisors']=0;

//get user details




  // Display any alerts



  //user logs in and views the user summary
if ($role=='Student'){

  $sql="select info.PantherID,info.FirstName, info.LastName , advising.advisor_email,
  advising.status, advising.lastModified, advising.SNo, fac.FirstName afname, fac.LastName alname
  from tbl_student_advising advising 
  join tbl_student_info info on advising.pantherid = info.PantherID
  left join tbl_excel_info excel on excel.PantherID = advising.pantherid 
  join tbl_faculty_info fac on fac.email = advising.advisor_email 
  where advising.pantherid = :pantherid;";
  $statement = $pdo->prepare($sql);
  $statement->execute([':pantherid'=>$user_pantherid]);

}elseif($role=='Admin'){
  $sql="select info.PantherID,info.FirstName, info.LastName , advising.advisor_email,
  advising.status, advising.lastModified, advising.SNo, fac.FirstName afname, fac.LastName alname
  from tbl_student_advising advising 
  join tbl_student_info info on advising.pantherid = info.PantherID
  left join tbl_excel_info excel on excel.PantherID = advising.pantherid 
  join tbl_faculty_info fac on fac.email = advising.advisor_email";
  $statement = $pdo->prepare($sql);
  $statement->execute();
}elseif($role=='Faculty'){
  $sql="select info.PantherID,info.FirstName, info.LastName , advising.advisor_email,
  advising.status, advising.lastModified, advising.SNo, fac.FirstName afname, fac.LastName alname
  from tbl_student_advising advising 
  join tbl_student_info info on advising.pantherid = info.PantherID
  left join tbl_excel_info excel on excel.PantherID = advising.pantherid 
  join tbl_faculty_info fac on fac.email = advising.advisor_email
  where advising.advisor_email = :advisor_email";

  $statement = $pdo->prepare($sql);
  $statement->execute([':advisor_email'=>$user_email]);
}


//create table for display
$table = "<table width='100%' class='table table-striped table-bordered table-hover' id='term-view'>";
$table.= "
<thead>
<tr>
<b>
<th>Panther ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Advisor</th>
<th>Status</th>
<th>Alter</th>
<th>Last Update</th>
</b>
</tr>
</thead>";

$table.= "<tbody>";

while($row = $statement->fetch(PDO::FETCH_ASSOC)){
  $table.="<tr>";
  $table.= "<td>".$row['PantherID']."</td>";
  $table.= "<td>".$row['FirstName']."</td>";
  $table.= "<td>".$row['LastName']."</td>";
  $table.= "<td>".$row['afname'].' '.$row['alname']."</td>";
  $table.= "<td>".$row['status']."</td>";

  if($role== 'Student' &&  $row['status'] =='pending'){
    $table.="

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='hidden' id='advisor_email' name='advisor_email' value={$row['advisor_email']} >
    <input type='submit' name='edit' value='Edit'>
    </form>

    <td>
    <form method='post' >
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='submit' name='del' value='Delete' onclick='confirm_delete(); return true;'>
    </form>



    </td>
    ";
  } elseif($role== 'Student' &&  $row['status'] =='approved'){
    $table.="<td></td>";

  }elseif($role== 'Student' &&  $row['status'] =='rejected'){
    $table.="<td></td>";

  }elseif (($role == 'Admin' || $role == 'Staff' ) &&  $row['status'] =='pending') {
    $table.="<td>
    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='hidden' id='advisor_email' name='advisor_email' value={$row['advisor_email']} >
    <input type='submit' name='edit' value='Edit'>
    </form>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='submit' name='del' value='Delete' onclick='confirm_delete(); return true;'>
    </form>

    </br>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='approve' value='Approve'>
    </form>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='reject' value='Reject'>
    </form>



    </td>";
  }elseif (($role == 'Admin' || $role == 'Staff' ) &&  $row['status'] =='approved') {
    //admin has ability to create update delete

    $table.="<td>
    
    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='hidden' id='advisor_email' name='advisor_email' value={$row['advisor_email']} >
    <input type='submit' name='edit' value='Edit'>
    </form>


    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='submit' name='del' value='Delete' onclick='confirm_delete(); return true;'>
    </form>


    </br>
    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='reject' value='Reject'>
    </form>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='graduate' value='Graduate'>
    </form>

    </td>";


  }elseif (($role == 'Admin' || $role == 'Staff'  ) &&  $row['status'] =='graduated') {
    $table.="<td>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='hidden' id='advisor_email' name='advisor_email' value={$row['advisor_email']} >
    <input type='submit' name='edit' value='Edit'>
    </form>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='submit' name='del' value='Delete' onclick='confirm_delete(); return true;'>
    </form>


    </td>";


  }elseif (($role == 'Admin' || $role == 'Staff' ) &&  $row['status'] =='rejected') {
    $table.="
    <td>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='hidden' id='advisor_email' name='advisor_email' value={$row['advisor_email']} >
    <input type='submit' name='edit' value='Edit'>
    </form>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='hidden' id='pantherid' name='pantherid' value={$row['PantherID']} >
    <input type='submit' name='del' value='Delete' onclick='confirm_delete(); return true;'>
    </form>

    </br>
    
    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='approve' value='Approve'>
    </form>



    </td>";


  }elseif ( $role == 'Faculty' ) {
//Faculty to only have ability to alter status of the request.

    if($row['status'] =='pending'){
     $table.="<td>
     <form method='post'>
     <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
     <input type='submit' name='approve' value='Approve'>
     </form>

     <form method='post'>
     <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
     <input type='submit' name='reject' value='Reject'>
     </form>

     <form method='post'>
     <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
     <input type='submit' name='graduate' value='Graduate'>
     </form>
     </td>";

   } elseif($row['status'] =='approved'){
    //approved request can be changed to rejected or graduated
    $table.="<td><form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='reject' value='Reject'>
    </form>

    <form method='post'>
    <input type='hidden' id='sno' name='sno' value={$row['SNo']} >
    <input type='submit' name='graduate' value='Graduate'>
    </form>
    </td>";

  } elseif($row['status'] =='rejected'){
    $table.="<td></td>";
  }elseif($row['status'] =='graduated'){
    $table.="<td></td>";
  }


}

$table.= "<td>".$row['lastModified']."</td>";

$table.= "</tr>";
$_SESSION['count_advisors']+=1;
}
$table.= "</tbody></table>";

   // echo $table;

?>

<script type="text/javascript" src="delete.js"></script>
