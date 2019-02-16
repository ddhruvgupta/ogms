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


$sql="select * from tbl_personnel_action where PantherID= :PantherID and term =:term";
$statement = $pdo->prepare($sql);
$statement->execute( array(':PantherID' => $_SESSION['post']['PantherID'],':term' => $_SESSION['post']['term'] ));



if(isset($_POST['cancel'])){
  header('location: index.php');
  return;
}

while($row = $statement->fetch(PDO::FETCH_ASSOC)){
   $supervisor_email = $_SESSION['post']['supervisor_email'];
  $first_name = $_SESSION['post']['first_name'];
  $last_name = $_SESSION['post']['last_name'];
  $PantherID = $_SESSION['post']['PantherID'];
  $student_email = $_SESSION['post']['student_email'];
  $degree = $_SESSION['post']['degree'];
  $enrollment = $_SESSION['post']['enrollment'];
  $appointment = $_SESSION['post']['appointment'];
    $position = $_SESSION['post']['position'];
  $term = $_SESSION['post']['term'];
    $year = $_SESSION['post']['year'];
  $total_FTE = $_SESSION['post']['total_FTE'];
  $additional_appointments = $_SESSION['post']['additional_appointments'];
  $pos_title_1 = $_SESSION['post']['pos_title_1'];
  $FTE_1 = $_SESSION['post']['FTE_1'];
  $speedtype_1 = $_SESSION['post']['speedtype_1'];
  $comp_1 = $_SESSION['post']['comp_1'];
  $per_month_comp_1 = $_SESSION['post']['per_month_comp_1'];
  $start_date_1 = $_SESSION['post']['start_date_1'];
  $end_date_1 = $_SESSION['post']['end_date_1'];
  $pos_title_2 = $_SESSION['post']['pos_title_2'];
  $FTE_2 = $_SESSION['post']['FTE_2'];
  $speedtype_2 = $_SESSION['post']['speedtype_2'];
  $comp_2 = $_SESSION['post']['comp_2'];
  $per_month_comp_2 = $_SESSION['post']['per_month_comp_2'];
  $start_date_2 = $_SESSION['post']['start_date_2'];
  $end_date_2 = $_SESSION['post']['end_date_2'];
  $pos_title_3 = $_SESSION['post']['pos_title_3'];
  $FTE_3 = $_SESSION['post']['FTE_3'];
  $speedtype_3 = $_SESSION['post']['speedtype_3'];
  $comp_3 = $_SESSION['post']['comp_3'];
  $per_month_comp_3 = $_SESSION['post']['per_month_comp_3'];
  $start_date_3 = $_SESSION['post']['start_date_3'];
  $end_date_3 = $_SESSION['post']['end_date_3'];
  $waiver = $_SESSION['post']['waiver'];
  $total_comp = $_SESSION['post']['total_comp'];
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

<?php  if($_SERVER['HTTP_HOST'] != "localhost"){ include $root.'/links/header.php';} ?>
</head>
<body>
  <?php  if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/UI/staff/staffmenu.php';}  ?>

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
          <?php if(isset($supervisor)) echo ("value = ".$supervisor." ");?>
        </div>
        <div class='form-group'>
          <h3>Student Information</h3>
          <label for='student'>Student: </label> <!-- insert faculty name -->
          <?php if(isset($student)) echo "value = ".$student." ";?>
        </br>
        <label for='PantherID'>Panther ID:</label>
        <input type="textbox" name="PantherID" id="PantherID" <?php if(isset($PantherID) echo "value = ".$PantherID;." ")?> readonly>
      </br>
      <label for='student_email'>Student Email:</label>
      <input type="textbox" name="student_email" id="student_email" <?php if(isset($student_email) echo "value = ".$student_email;." ")?> readonly>
      <input type='hidden' id='first_name' name='first_name' <?php if(isset($first_name) echo "value = ".$first_name;." ")?> >
      <input type='hidden' id='last_name' name='last_name' <?php if(isset($last_name) echo "value = ".$last_name;)?> >

    </br></br>

    <label for="degree">Degree Program:</label>
    <input type="textbox" name="degree" id="degree" <?php if(isset($degree) echo "value = ".$degree;." ")?> readonly>
    


    <label for="enrollment">Enrollment Status:</label>
    <input type="textbox" name="enrollment" id="enrollment" <?php if(isset($enrollment) echo "value = ".$enrollment." ";)?> readonly>


  </div>
  <div class='form-group'>
    <h3>Appointment</h3>
    <label for='appointment'>Appointment: </label>
    <input type="textbox" name="appointment" id="appointment" <?php if(isset($appointment) echo "value = ".$appointment." ";)?> readonly>


    <label for='position'>Position: </label>
    <input type="textbox" name="position" id="position" <?php if(isset($position) echo "value = ".$position." ";)?> readonly>

    <br>

    <label for='term'>Term: </label>
    <input type="textbox" name="term" id="term" <?php if(isset($term) echo "value = ".$term." ";)?> readonly>

    <label for='year'>Year: </label>
    <input type="textbox" name="year" id="year" <?php if(isset($year) echo "value = ".$year." ";)?> readonly>



    <label for='total_fte'>Total FTE: </label>
    <input type="textbox" name="total_fte" id="total_fte" <?php if(isset($total_fte) echo "value = ".$total_fte." ";)?> readonly>

    <br>

    <label for='add'>Additional Appointments: </label>
    <input type="textbox" name="add" id="add" <?php if(isset($add) echo "value = ".$add." ";)?> readonly>

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
          <td>
            <input type="textbox1" name="fte_1" id="fte_1" <?php  if(isset($fte_1) echo "value = ".$fte_1." ";)?> readonly>
          </td>

          <td><input type="textbox1" name="speedtype1" id="speedtype1" <?php  if(isset($speedtype1) echo "value = ".$speedtype1." ";)?> readonly>
          </td>
          <td>
            <input type="textbox1" name="total_comp_1" id="total_comp_1" <?php if(isset($total_comp_1) echo "value = ".$total_comp_1." ";)?> readonly>
          </td>
          <td>
            <input type="textbox1" name="per_month_comp_1" id="per_month_comp_1" <?php if(isset($per_month_comp_1) echo "value = ".$per_month_comp_1." ";)?> readonly>
          </td>
          <td>

            <input type="textbox1" name="start_date_1" id="start_date_1" <?php if(isset($start_date_1) echo "value = ".$start_date_1." ";)?> readonly>

          </td>
          <td>
            <input type="textbox1" name="end_date_1" id="end_date_1" <?php if(isset($end_date_1) echo "value = ".$end_date_1." ";)?> readonly>
          </td>
        </tr>

        <tr>
          <td><input type="textbox" name="pos_title_2" id="pos_title_2">
            <input type="textbox1" name="pos_title_2" id="pos_title_2" <?php if(isset($pos_title_2) echo "value = ".$pos_title_2." ";)?> readonly>
          </td>
          <td><input type="textbox1" name="fte_2" id="fte_2" <?php if(isset($fte_2) echo "value = ".$fte_2." ";)?> readonly></td>

          <td><input type="textbox1" name="speedtype2" id="speedtype2" <?php if(isset($speedtype2) echo "value = ".$speedtype2." ";)?> >
        </td>
          <td><input type="textbox" name="total_comp_2" id="total_comp_2" class="comp" 
            <?php if(isset($speedtype2) echo "value = ".$speedtype2." ";)?> readonly></td>

          <td><input type="textbox" name="per_month_comp_2" id="per_month_comp_2"
            <?php if(isset($per_month_comp_2) echo "value = ".$per_month_comp_2." ";)?> readonly></td>
          <td><input type="Date" name="start_date_2" id="start_date_2"
            <?php if(isset($start_date_2) echo "value = ".$start_date_2." ";)?> readonly></td>
          <td><input type="Date" name="end_date_2" id="end_date_2"
            <?php if(isset($end_date_2) echo "value = ".$end_date_2." ";)?> readonly></td>
        </tr>

        <tr>
          <td><input type="textbox" name="pos_title_3" <?php if(isset($pos_title_3) echo "value = ".$pos_title_3." ";)?> readonly></td>
          <td><input type="textbox" name="fte_3" <?php if(isset($fte_3) echo "value = ".$fte_3." ";)?> readonly></td>

          <td><input type="textbox" name="speedtype3" id="speedtype3" <?php if(isset($speedtype3) echo "value = ".$speedtype3." ";)?> readonly></td>
          <td><input type="textbox" name="total_comp_3" id="total_comp_3" class="comp" 
            <?php if(isset($total_comp_3) echo "value = ".$total_comp_3." ";)?> readonly></td>

          <td><input type="textbox" name="per_month_comp_3" id="per_month_comp_3"
            <?php if(isset($per_month_comp_3) echo "value = ".$per_month_comp_3." ";)?> readonly></td>
          <td><input type="Date" name="start_date_3" id="start_date_3"
            <?php if(isset($start_date_3) echo "value = ".$start_date_3." ";)?> readonly></td>
          <td><input type="Date" name="end_date_3" id="end_date_3"
            <?php if(isset($end_date_3) echo "value = ".$end_date_3." ";)?> readonly></td>
        </tr>

      </tbody>
    </table>
  </div>

  <div class='form-group'>
    <h3>Compensation</h3>

    <label for="waiver">Waiver: </label>
    <input type="textbox" name="waiver" id="waiver"
            <?php if(isset($waiver) echo "value = ".$waiver." ";)?> readonly>


    <label for="total_comp">Total Compensation</label>
    <input type="textbox" name="total_comp" id="total_comp" <?php if(isset($total_comp) echo "value = ".$total_comp." ";)?> readonly>

  </div>


<!--   <input type="submit" name="submit" value="submit">
  <input type="submit" name="cancel" value="cancel"> -->
</form>
</div>
</div>
</div>
<?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/links/footerLinks.php';  } ?>
</body>
</html>