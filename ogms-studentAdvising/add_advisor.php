<!--
1. Check how many advisors the student has
2. if <2 continue else return to view page. show alert that user already has 2 advisors
3. display name and then give drop down for Advisor options
-->

<?php

require "security.php";
include "root.php";


//code from huafu to check if code is running on local machine or server





if($_SESSION['user']['role']=='Student'){
  $user_pantherid = $_SESSION['user']['pid'];
}else{
  $user_pantherid = $_SESSION['student']['pid'];
}



//retrieve user details from students table
$sql ="select FirstName,LastName from tbl_student_info where pantherid = :pantherid";
$statement = $pdo->prepare($sql);
$statement->execute(array(':pantherid'=>$user_pantherid));
$row = $statement->fetch(PDO::FETCH_ASSOC);
$fname = $row['FirstName'];
$lname = $row['LastName'];

//retrieve list of faculty / possible advisors
$sql = "select FirstName,LastName,email from tbl_faculty_info";
$statement = $pdo->prepare($sql);
$statement->execute();



//create dropdown list with factulty names
$select ="<option value=''>--Please Select--</option>";

$selected = ' ';
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
  if(isset($_GET['advisor_email'])){
        //choose the right advisor if in the edit mode
    if($_GET['advisor_email'] == $row['email'])
      $selected = ' selected';
    else
      $selected = ' ';
  }

  $select.="<option value=".$row['email'].$selected.">".$row['LastName'].", ".$row['FirstName']."</option>";
}


//In case someone comes directly to this page,
//confirm that user has less that 2 advisors or return to student page.




//Handling form submission


//handling the case where the user decides to cancel the advisor submission

$form = "<form method='post'>
<div class='form-group'>
<label for='fname'>First Name: </label>";
$form.= $fname;
$form.="
</div>
<div class='form-group'>
<label for='lname'>Last Name: </label>";
$form.= $lname;
$form.="</div>
<div class='form-group'>
<label for='lname'>Panther ID: </label>";
$form.= $user_pantherid;
$form.= "</div>
<div class='form-group'>
<label for='adv_select'>Advisor: </label>
<select name='advisor' id='adv_select";
$form.= $select;
$form.="</select>
</div>
<div class='form-group'>
<input type='submit' name='add' value='Add'>
<input type='submit' name='cancel' value='Cancel'>
</div>
</form>";



?>
