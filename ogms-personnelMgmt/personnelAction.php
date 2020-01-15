<?php 
session_start();
include "root.php";
include "bootstrap.php";

$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
$role = $_SESSION['user']['role'];  //Admin / Faculty / Student / Staff

$form = "";


//retrieve list of faculty / possible advisors

if($role == 'Admin'){
  $sql = "select FirstName,LastName,email from tbl_faculty_info";
  $statement = $pdo->prepare($sql);
  $statement->execute();
} else{
  $sql = "select FirstName,LastName,email from tbl_faculty_info where email = :email";
  $statement = $pdo->prepare($sql);
  $statement->execute(array(':email'=>$user_email));
}


//create dropdown list with factulty names
$select_supervisor = "<select name='supervisor' id='supervisor'>";
// $select_supervisor .="<option value=''>--Please Select--</option>";

$selected = ' ';
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

//choose supervisor
  if($user_email == $row['email'])
    $selected = ' selected';
  else
    $selected = ' ';
  

  $select_supervisor.="<option value=".$row['email'].$selected.">".$row['LastName'].", ".$row['FirstName']."</option>";
}

$select_supervisor .= "</select>";  


$sql="select * from (select PantherID,FirstName,LastName,email from tbl_student_info
union 
select PantherID,FirstName,LastName,email from tbl_excel_info) as all_students 
group by PantherID";
$statement = $pdo->prepare($sql);
$statement->execute();

$student_select = "<select name='student' id='student'>";
while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
  $student_select.="<option value=".$row['PantherID'].$selected." first_name='".$row['FirstName']."' last_name='".$row['LastName']."' email='".$row['email']."'>".$row['LastName'].", ".$row['FirstName']."</option>";
}
$student_select.="</select>";

if(isset($_POST['cancel'])){
  header('location: index.php');
  return;
}

if(isset($_POST['submit'])){

  $sql = "INSERT INTO tbl_personnel_action (
  supervisor_email,
  first_name,
  last_name,
  PantherID,
  student_email,
  degree,
  enrollment,
  appointment,
  position,
  term,
  year,
  total_FTE,
  additional_appointments,
  pos_title_1,
  FTE_1,
  speedtype_1,
  comp_1,
  per_month_comp_1,
  start_date_1,
  end_date_1,
  pos_title_2,
  FTE_2,
  speedtype_2,
  comp_2, 
  per_month_comp_2,
  start_date_2,
  end_date_2,
  pos_title_3,
  FTE_3,
  speedtype_3,
  comp_3,
  per_month_comp_3,
  start_date_3,
  end_date_3,
  waiver,
  total_comp) VALUES (
  :supervisor_email,
  :first_name,
  :last_name,
  :PantherID,
  :student_email,
  :degree,
  :enrollment,
  :appointment,
  :position,
  :term,
  :year,
  :total_FTE,
  :additional_appointments,
  :pos_title_1,
  :FTE_1,
  :speedtype_1,
  :comp_1,
  :per_month_comp_1,
  :start_date_1,
  :end_date_1,
  :pos_title_2,
  :FTE_2,
  :speedtype_2,
  :comp_2,
  :per_month_comp_2,
  :start_date_2,
  :end_date_2,
  :pos_title_3,
  :FTE_3,
  :speedtype_3,
  :comp_3,
  :per_month_comp_3,
  :start_date_3,
  :end_date_3,
  :waiver,
  :total_comp)";



  $statement = $pdo->prepare($sql);

  $statement->execute(array(
    ':supervisor_email'=>$_POST['supervisor'],
    ':first_name'=>$_POST['first_name'],
    ':last_name'=>$_POST['last_name'],
    ':PantherID'=>$_POST['PantherID'],
    ':student_email'=>$_POST['student_email'],
    ':degree'=>$_POST['degree'], 
    ':enrollment'=>$_POST['enrollment'],
    ':appointment'=>$_POST['appointment'],
    ':position'=>$_POST['position'],
    ':term'=>$_POST['term'],
    ':year'=>$_POST['year'],
    ':total_FTE'=>$_POST['total_fte'],
    ':additional_appointments'=>$_POST['add'],
    ':pos_title_1'=>$_POST['pos_title_1'],
    ':FTE_1'=>$_POST['fte_1'],
    ':speedtype_1'=>$_POST['speedtype1'],
    ':comp_1'=>$_POST['total_comp_1'],
    ':per_month_comp_1'=>$_POST['per_month_comp_1'],
    ':start_date_1'=>$_POST['start_date_1'],
    ':end_date_1'=>$_POST['end_date_1'],
    ':pos_title_2'=>$_POST['pos_title_2'],
    ':FTE_2'=>$_POST['fte_2'],
    ':speedtype_2'=>$_POST['speedtype2'],
    ':comp_2'=>$_POST['total_comp_2'],
    ':per_month_comp_2'=>$_POST['per_month_comp_2'],
    ':start_date_2'=>$_POST['start_date_2'],
    ':end_date_2'=>$_POST['end_date_2'],
    ':pos_title_3'=>$_POST['pos_title_3'],
    ':FTE_3'=>$_POST['fte_3'],
    ':speedtype_3'=>$_POST['speedtype3'],
    ':comp_3'=>$_POST['total_comp_3'],
    ':per_month_comp_3'=>$_POST['per_month_comp_3'],
    ':start_date_3'=>$_POST['start_date_3'],
    ':end_date_3'=>$_POST['end_date_3'],
    ':waiver'=>$_POST['waiver'], 
    ':total_comp'=>$_POST['total_comp']
  ));

$_SESSION['insert'] = "Successfully Inserted";
header('location: personnelAction.php');
return;


}

?>

<html>
<head>


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
 <script type="text/javascript">
  $(document).ready(function() {                                       
    $("#student").live("change", function() {
      $("#PantherID").val($(this).find("option:selected").attr("value"));
    })
  });   
</script>


<!-- JavaScript code to update email address after user selection -->
<script type="text/javascript">
  $(document).ready(function() {                                       
    $("#student").live("change", function() {

      $("#student_email").val($(this).find("option:selected").attr("email"));

    })
  });   
</script>

<!-- JavaScript code to update firstname and last name after user selection -->
<script type="text/javascript">
  $(document).ready(function() {                                       
    $("#student").live("change", function() {
      $("#first_name").val($(this).find("option:selected").attr("first_name"));
    })
  });   
</script>

<script type="text/javascript">
  $(document).ready(function() {                                       
    $("#student").live("change", function() {
      $("#last_name").val($(this).find("option:selected").attr("last_name"));
    })
  });   
</script>

<script type="text/javascript">
  $(document).ready(function() {                                       
    var sum = 0;
// iterate through each td based on class and add the values
$(".comp").live("change",function() {

  var value = $(this).val();
    // add only if the value is number
    
    if(!isNaN(value) && value.length != 0) {
      sum += parseFloat(value);
    }
    $("#total_comp").val(sum);
    
  });
});   
</script>

<?php if($_SERVER['HTTP_HOST'] != "localhost"){ include $root.'/links/header.php';} ?>
</head>
<body>
  <?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/UI/staff/staffmenu.php';}  ?>

  <div id="container">
    <!-- page-wrapper -->
    <div id="page-wrapper" class="col">
      <!-- <div class="row">
      -->
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
      ?>

      <form method="POST">
        <div class='form-group'>
          <h3>Requestor</h3>
          <label>Supervisor: </label> <!-- insert faculty name -->
          <?php echo $select_supervisor;?>
        </div>
        <div class='form-group'>
          <h3>Student Information</h3>
          <label for='student'>Student: </label> <!-- insert faculty name -->
          <?php echo $student_select;?>
        </br>
        <label for='PantherID'>Panther ID:</label>
        <input type="textbox" name="PantherID" id="PantherID" readonly>
      </br>
      <label for='student_email'>Student Email:</label>
      <input type="textbox" name="student_email" id="student_email" readonly>
      <input type='hidden' id='first_name' name='first_name' value="" >
      <input type='hidden' id='last_name' name='last_name' value="" >

    </br></br>

    <label for="degree">Degree Program:</label>
    <select name="degree" id="degree">
      <option value="">Choose One</option>
      <option value="MS">MS</option>
      <option value="PhD">PhD</option>
    </select>


    <label for="enrollment">Enrollment Status:</label>
    <select name="enrollment" id="enrollment">
      <option value="">Choose One</option>
      <option value="Full-Time">Full-Time</option>
      <option value="Part-Time">Part-Time</option>
    </select>

  </div>
  <div class='form-group'>
    <h3>Appointment</h3>
    <label for='appointment'>Appointment: </label>
    <select name="appointment" id="appointment">
      <option value="Full">Full Appointment</option>
      <!-- <option value="PT">Part-Time</option> -->
    </select>

    <label for='position'>Position: </label>
    <select name="position" id="position">
      <option value="GRA">Graduate Research Assistant</option>
      <option value="GAA">Graduate Administrative Assistant</option>
      <option value="GCA">Graduate Computing Assistant</option>
      <option value="GTAA">Graduate Teaching Assistant, Level A</option>
      <option value="GTAB">Graduate Teaching Assistant, Level B</option>

    </select>

    <br>

    <label for='term'>Term: </label>
    <select name="term" id="term">
      <option value="Fall">Fall</option>
      <option value="Spring">Spring</option>
      <option value="Summer">Summer</option>
    </select>

    <label for='year'>Year: </label>
    <input list="year" name="year">
    <datalist id="year">
      <?php 
      $right_now = getdate();
      $this_year = $right_now['year'];
      $start_year = 2010;
      while ($start_year <= $this_year+1) {
        echo "<option value={$start_year} >{$start_year}</option>";
        $start_year++;
      }
      ?>
    </datalist>
  </input>


  <label for='total_fte'>Total FTE: </label>
  <input list="total_fte" name="total_fte">
  <datalist id="total_fte">
    <?php 

    for($i=50;$i>=0;$i=$i-5) {
      $j= $i/2.5;
      echo "<option value={$i}>{$i}% - {$j} hrs</option>";
      $start_year++;
    }
    ?>
  </datalist>
</input>

<br>

<label for='add'>Additional Appointments: </label>
<select name="add" id="add">
  <option value=TRUE>Yes</option>
  <option value=FALSE>No</option>
</select>

</div>

<div class='form-group'>
  <h3>Funding</h3>
  <table class='table table-striped table-bordered table-hover' >
    <thead>
      <tr>
        <th>Position Title</th>
        <th>FTE</th>
        <th>Speedtype</th>
        <th>Total Compensation</th>
        <th>Per Month Compensation</th>
        <th>Start Date</th>
        <th>End Date</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="textbox1" name="pos_title_1" id="pos_title_1"></td>
        <td><input list="fte_1" name="fte_1" >
          <datalist id="fte_1">
            <?php 

            for($i=50;$i>=0;$i=$i-5) {
              $j= $i/2.5;
              echo "<option value={$i}>{$i}% - {$j} hrs</option>";
              $start_year++;
            }
            ?>
          </datalist>
        </input></td>

        <td><input type="textbox" name="speedtype1" id="speedtype1"></td>
        <td><input type="textbox" name="total_comp_1" id="total_comp_1" class="comp"></td>
        <td><input type="textbox" name="per_month_comp_1" id="per_month_comp_1"></td>
        <td><input type="Date" name="start_date_1" id="start_date_1"></td>
        <td><input type="Date" name="end_date_1" id="end_date_1"></td>
      </tr>

      <tr>
        <td><input type="textbox" name="pos_title_2" id="pos_title_2"></td>
        <td><input list="fte_2" name="fte_2" >
          <datalist id="fte_2">
            <?php 

            for($i=50;$i>=0;$i=$i-5) {
              $j= $i/2.5;
              echo "<option value={$i}>{$i}% - {$j} hrs</option>";
              $start_year++;
            }
            ?>
          </datalist>
        </input></td>

        <td><input type="textbox" name="speedtype2" id="speedtype2"></td>
        <td><input type="textbox" name="total_comp_2" id="total_comp_2" class="comp"></td>
        <td><input type="textbox" name="per_month_comp_2" id="per_month_comp_2"></td>
        <td><input type="Date" name="start_date_2" id="start_date_2"></td>
        <td><input type="Date" name="end_date_2" id="end_date_2"></td>
      </tr>

      <tr>
        <td><input type="textbox" name="pos_title_3"></td>
        <td><input list="fte_3" name="fte_3" >
          <datalist id="fte_3">
            <?php 

            for($i=50;$i>=0;$i=$i-5) {
              $j= $i/2.5;
              echo "<option value={$i}>{$i}% - {$j} hrs</option>";
              $start_year++;
            }
            ?>
          </datalist>
        </input></td>

        <td><input type="textbox" name="speedtype3" id="speedtype3"></td>
        <td><input type="textbox" name="total_comp_3" id="total_comp_3" class="comp"></td>
        <td><input type="textbox" name="per_month_comp_3" id="per_month_comp_3"></td>
        <td><input type="Date" name="start_date_3" id="start_date_3"></td>
        <td><input type="Date" name="end_date_3" id="end_date_3"></td>
      </tr>

    </tbody>
  </table>
</div>

<div class='form-group'>
  <h3>Compensation</h3>

  <label for="waiver">Waiver: </label>
  <select name="waiver" id="waiver">
    <option value="full">Full tuition waiver</option>
    <option value="partial">Partial (50%) tuition waiver</option>
  </select>


  <label for="total_comp">Total Compensation</label>
  <input type="textbox" name="total_comp" id="total_comp" readonly>

</div>


<input type="submit" name="submit" value="submit">
<input type="submit" name="cancel" value="cancel">
</form>
</div>
</div>
</div>
<?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/links/footerLinks.php';  } ?>
</body>
</html>