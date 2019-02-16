<?php 
session_start();
include "root.php";
// include "bootstrap.php";
include "jquery.php";

$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
$role = $_SESSION['user']['role'];  //Admin / Faculty / Student / Staff

$form = "";



// TODO: get information of current user 
$sql="select * from (select PantherID,FirstName,LastName,email from tbl_student_info
union 
select PantherID,FirstName,LastName,email from tbl_excel_info) as all_students 
where PantherID = :pid
group by PantherID";
$statement = $pdo->prepare($sql);
$statement->execute( array(':pid' => $user_pantherid ));
$user = $statement->fetch(PDO::FETCH_ASSOC);

// TODO: get list of terms and create drop down widget
$term_widget = "<select name='term' id='term_id'>";
$sql = "SELECT * FROM tbl_term ORDER BY Termid desc";
$statement = $pdo->prepare($sql);
$statement->execute();
while($term_info = $statement->fetch(PDO::FETCH_ASSOC)){
  $term_widget .= "<option value={$term_info['Termid']}>{$term_info['Term']}</option>";
}
$term_widget .="</select>";


if(isset($_POST['cancel'])){
  header('location: index.php');
  return;
}

// TODO: update submit functions
if(isset($_POST['submit'])){
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


}


?>

<html>
<head>



  <?php if($_SERVER['HTTP_HOST'] != "localhost"){ include $root.'/links/header.php';} ?>
</head>
<body>
  <?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/UI/staff/staffmenu.php';}  ?>

  <div id="container">
    <!-- page-wrapper -->
    <div id="page-wrapper" class="col">
      <!-- <div class="row">
      -->
      <?php include "flashmessages.php";?>

      <form method="POST">
       <p>
        <label for='name'>Name: </label>
        <input type="textbox" name="name" id="name" <?php echo "value = '{$user['FirstName']} {$user['LastName']}' readonly"; ?>  >
      </p>

      <p>
        <label for='pantherid'>Panther ID: </label>
        <input type="textbox" name="pantherid" id="pantherid" <?php echo "value = '{$user['PantherID']}' readonly"; ?>  >
      </p>

      <p>
        <label for='term'>Term: </label>
        <?php echo $term_widget; ?>
      </p>
      <p>
        Course: <input type="submit" id="add_course" value="+">
        <p>
          <div id="course_fields">
            <table class='table table-striped table-bordered table-hover' id="tbl_course">
              <thead>
                <tr>
                  <th>Course</th>
                  <th>Schedule</th>
                  <th>CRN</th> 
                  <th>Credits</th>                      
                  <tr>
                  </thead>
                  <tbody id='tbl'>

                  </tbody>
                </table>
              </div>
            </p>
          </p>
          <p>
            <input type="submit" name="submit" value="submit">
            <input type="submit" name="cancel" value="cancel">
          </p>

        </form>
      </div>
    </div>
  </div>
  <?php if($_SERVER['HTTP_HOST'] != "localhost"){include $root.'/links/footerLinks.php';  } ?>
  <script type="text/javascript">
    countCourses = 0;

    $(document).ready(function(){
      window.console && console.log("Current courses -"+countCourses);
      $('#add_course').click(function(event){
        event.preventDefault();
        if(countCourses >=6){
          alert("Maximum Course Load Reached");
          return;
        }
        countCourses++;
        window.console && console.log("Adding course -"+countCourses);
        
        $('#tbl').append("<tr id='"+countCourses+"'><td><input type='text' name='course"+countCourses+"' id='course"+countCourses+"' value='' class='course_name'></td> </td><td><select name='schedule"+countCourses+"' id='schedule"+countCourses+"' class='Schedule' ></select></td><td><input type='text' name='CRN"+countCourses+"'  id='CRN"+countCourses+"' class='CRN' value='' maxlength='5'></td><td><input type='text' name='credit"+countCourses+"' id='credit"+countCourses+"' class='credit' value='' ></td></tr>");

        $('.course_name').autocomplete({
          // test = $(this).attr("id");
          // console.log(test);
          source: function(request, response) {
            $.ajax({
              url: "studyplan_autocomplete_coursename.php",
              dataType: "json",
              data: {
                term : request.term,
                term_id : $("#term_id").val()
              },
              success: function(data) {
                response(data);
                // console.log(data);

              }
            });
          },
          min_length: 3
        });

        $(".course_name").on("change", function(e) {

          $.ajax({
            url: "studyplan_autocomplete_schedule.php",
            dataType: "json",
            data: {
              "term_id" : $("#term_id").val(),
              course_name : this.value
            },
            success: function(response) {
              var len = response.length;
              console.log(length);

              for( var i = 0; i<len; i++){
                var id = response[i]['scheduleid'];
                var name = response[i]['schedule'];
                $(e.target.parentElement.parentElement).find('.Schedule').append("<option value='"+id+"'>"+name+"</option>");
              }

              if(len == 0){
                ajaxCall2(e);
              }
            }
          });

        });



        function ajaxCall2(e){
          $.ajax({
            url: "studentstudyplan_autocomplete_schedule_noncsc.php",
            dataType: "json",

            data: {                    
              term_id : $("#term_id").val()
            },

            success: function(result){
             for( var i = 0; i<result.length; i++){                
              var name = result[i];
              $(e.target.parentElement.parentElement).find('.Schedule').append("<option value='"+i+"'>"+name+"</option>");
            }
          }
        })
        };

//Uptdate CRN
$(".Schedule").on("click", function(e) {

  $.ajax({
    url: "studyplan_autocomplete_crn.php",
    dataType: "json",
    data: {
      "term_id" : $("#term_id").val(),
      course_name : $(e.target.parentElement.parentElement).find('.course_name').val(),
      "scheduleid" : this.value
                //$(e.target.parentElement.parentElement).find('.Schedule').children(":selected").attr("value")
              },
              success: function(response) {
                $(e.target.parentElement.parentElement).find('.crn').val(response);
                console.log( response.length);

              }
            });

});

//End CRN Update        

});
    });
  </script>
</body>
</html>