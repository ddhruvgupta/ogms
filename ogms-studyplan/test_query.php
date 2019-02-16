<?php 
include "connection.php";


$_POST['supervisor'] = 'aashok@gsu.edu';
$_POST['first_name'] =  'Jillian';
$_POST['last_name'] = 'Jones';
$_POST['PantherID'] = 1165291;
$_POST['student_email'] = 'cfrederick1@student.gsu.edu';
$_POST['degree'] = 'MS';
$_POST['enrollment'] ='Full-Time';
$_POST['appointment'] = 'Full';
$_POST['position'] = 'GRA';
$_POST['term'] ='Spring';
$_POST['year'] =2012;
$_POST['total_fte'] =40;
$_POST['add'] = TRUE;
$_POST['pos_title_1'] = 'fdfdf';
$_POST['fte_1'] =23;
$_POST['speedtype1'] =  '2323';
$_POST['total_comp_1'] = 3232;
$_POST['per_month_comp_1'] = 23;
$_POST['start_date_1'] = '2018-11-01';
$_POST['end_date_1'] = '2018-11-01';
$_POST['waiver'] = 'full';
$_POST['total_comp'] = 12;


print_r($_POST);
// print $_POST['supervisor'] ;
// echo $_POST['first_name'] ;
// echo $_POST['last_name'] ;
// echo $_POST['PantherID'] ;
// echo $_POST['student_email'];
// echo $_POST['degree'] ;
// echo $_POST['enrollment'];
// echo $_POST['appointment'] ;
// echo $_POST['position'] ;
// echo $_POST['term'] ;
// echo $_POST['year'] ;
// echo $_POST['total_fte'] ;
// echo $_POST['add'];
// echo $_POST['pos_title_1'] ;
// echo $_POST['fte_1'] ;
// echo $_POST['speedtype1'];
// echo $_POST['total_comp_1'] ;
// echo $_POST['per_month_comp_1'] ;
// echo $_POST['start_date_1'] ;
// echo $_POST['end_date_1'];
// echo $_POST['waiver'];
// echo $_POST['total_comp'] ;




$sql = "INSERT INTO tbl_personnel_action 
(supervisor_email,
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
                    waiver,
                     total_comp) 
VALUES (
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
               :waiver,
                :total_comp)";

 $statement = $pdo->prepare($sql);

echo('<br><br>');
print_r($statement);
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
 	                    ':waiver'=>$_POST['waiver'],
 	                     ':total_comp'=>$_POST['total_comp']
 	                 ));

?>