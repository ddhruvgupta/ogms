<?php
if (isset($_SERVER['HTTP_HOST']))
{
    if($_SERVER['HTTP_HOST'] == "localhost")
    {
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
        define("ROOT",$root."/student/ogms/public_html");
        $root = ROOT;
    }
    else
    {
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
    }
}
else
{
    $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
}
session_start();
$user_name = $_SESSION['user']['name'] ;
$user_email = $_SESSION['user']['mail'] ;
$user_pantherid = $_SESSION['user']['pid'] ;
//include $root.'/authenticate.php';
include($root.'/osms.dbconfig.inc');
$error_message = "";
$counter = 0;

$mysqli = new mysqli($hostname,$username, $password,$dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>
<?php
//connect to database
$db=$mysqli;


?>


<?php
    if(isset($_SESSION['message']))
    {
         echo "<div id='error_msg'>".$_SESSION['message']."</div>";
         unset($_SESSION['message']);
    }
?>
<div>
    <a href="studyplanregister.php">Add New Study Plan</a><br>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body"  style="overflow:auto">
                <table width="100%" class="table table-striped table-bordered table-hover" id="studyplan-view">
                    <thead>
                    <!-- Head -->
                    <tr>
                        <th>StudyplanID</th><th>PantherID</th><th>Name</th><th>TermID</th><th>TermName</th><th>Course</th><th>CourseName</th><th>Update</th><th>Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                            <?php
                                $sql="  select
                                        st.Studyplanid as id,
                                        st.PantherID as pantherid,
                                        CONCAT(coalesce(stn.FirstName,' '),' ',coalesce(stn.LastName,' ')) as studentname,
                                        st.Termid as termid,
                                        te.Term as termname,
                                        st.Course1id as course1id,
                                        co1.CRN as  course1name,
                                        st.Course2id as course2id,
                                        co2.CRN as  course2name,
                                        st.Course3id as course3id,
                                        co3.CRN as  course3name,
                                        st.Course4id as course4id,
                                        co4.CRN as  course4name,
                                        st.Course5id as course5id,
                                        co5.CRN as  course5name,
                                        st.Course6id as course6id,
                                        co6.CRN as  course6name
                                         from tbl_studyplan as st
                                        inner join tbl_student_info as stn on stn.PantherID = st.PantherID
                                        INNER JOIN tbl_term as te on te.Termid = st.Termid
                                        LEFT JOIN tbl_course as co1 on co1.Courseid = st.Course1id
                                        LEFT JOIN tbl_course as co2 on co2.Courseid = st.Course2id
                                        LEFT JOIN tbl_course as co3 on co3.Courseid = st.Course3id
                                        LEFT JOIN tbl_course as co4 on co4.Courseid = st.Course4id
                                        LEFT JOIN tbl_course as co5 on co5.Courseid = st.Course5id
                                        LEFT JOIN tbl_course as co6 on co6.Courseid = st.Course6id
                                ";
                                //echo $sql;
                            $result = mysqli_query($db, $sql);
                    //        echo $result;
                            //        if ($result) {
                            //            echo 'Test delete tbl_student_info Success';
                            //        } else {
                            //            echo 'Test delete tbl_student_info fail';
                            //            echo("Error description: " . mysqli_error($db));
                            //        }
                            while($row=mysqli_fetch_assoc($result))//将result结果集中查询结果取出一条
                            {

                                $course1id=$row["course1id"];
                                $course1name=$row["course1name"];
                                $course2id=$row["course2id"];
                                $course2name=$row["course2name"];
                                $course3id=$row["course3id"];
                                $course3name=$row["course3name"];
                                $course4id=$row["course4id"];
                                $course4name=$row["course4name"];
                                $course5id=$row["course5id"];
                                $course5name=$row["course5name"];
                                $course6id=$row["course6id"];
                                $course6name=$row["course6name"];
                    //            echo $row["id"];
                    //            echo implode(",", $row);
                    //            echo $row["course2name"];
                    //            echo $course3name;
                    //            echo $course4name;
                    //            echo $course5name;
                    //            echo $course6name;
                                $Isadd=false;
                                if(empty($course1id) and empty($course2id) and empty($course3id) and empty($course4id) and empty($course5id) and empty($course6id)) {
                                    echo '<tr><td>' . $row["id"] .
                                        '</td><td>' . $row["pantherid"] .
                                        '</td><td>' . $row["studentname"] .
                                        '</td><td>' . $row["termid"] .
                                        '</td><td>' . $row["termname"] .
                                        '</td><td>' .
                                        '</td><td>' .
                                        '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                }
                                else{
                                    if(!empty($course1id)) {
                                        if ($Isadd == false) {
                                            echo '<tr><td>' . $row["id"] .
                                                '</td><td>' . $row["pantherid"] .
                                                '</td><td>' . $row["studentname"] .
                                                '</td><td>' . $row["termid"] .
                                                '</td><td>' . $row["termname"] .
                                                '</td><td>' . $course1id .
                                                '</td><td>' . $course1name .
                                                '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                            $Isadd=true;
                                        }
                                        else
                                        {
                                            echo '<tr><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' . $course1id .
                                                '</td><td>' . $course1name .
                                                '</td><td></td><td></td></tr>';
                                        }
                                    }
                                    if(!empty($course2id)) {
                                        if ($Isadd == false) {
                                            echo '<tr><td>' . $row["id"] .
                                                '</td><td>' . $row["pantherid"] .
                                                '</td><td>' . $row["studentname"] .
                                                '</td><td>' . $row["termid"] .
                                                '</td><td>' . $row["termname"] .
                                                '</td><td>' . $course2id .
                                                '</td><td>' . $course2name .
                                                '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                            $Isadd=true;
                                        }
                                        else
                                        {
                                            echo '<tr><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' . $course2id .
                                                '</td><td>' . $course2name .
                                                '</td><td></td><td></td></tr>';
                                        }
                                    }
                                    if(!empty($course3id)) {
                                        if ($Isadd == false) {
                                            echo '<tr><td>' . $row["id"] .
                                                '</td><td>' . $row["pantherid"] .
                                                '</td><td>' . $row["studentname"] .
                                                '</td><td>' . $row["termid"] .
                                                '</td><td>' . $row["termname"] .
                                                '</td><td>' . $course3id .
                                                '</td><td>' . $course3name .
                                                '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                            $Isadd=true;
                                        }
                                        else
                                        {
                                            echo '<tr><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' . $course3id .
                                                '</td><td>' . $course3name .
                                                '</td><td></td><td></td></tr>';
                                        }
                                    }
                                    if(!empty($course4id)) {
                                        if ($Isadd == false) {
                                            echo '<tr><td>' . $row["id"] .
                                                '</td><td>' . $row["pantherid"] .
                                                '</td><td>' . $row["studentname"] .
                                                '</td><td>' . $row["termid"] .
                                                '</td><td>' . $row["termname"] .
                                                '</td><td>' . $course4id .
                                                '</td><td>' . $course4name .
                                                '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                            $Isadd=true;
                                        }
                                        else
                                        {
                                            echo '<tr><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' . $course4id .
                                                '</td><td>' . $course4name .
                                                '</td><td></td><td></td></tr>';
                                        }
                                    }
                                    if(!empty($course5id)) {
                                        if ($Isadd == false) {
                                            echo '<tr><td>' . $row["id"] .
                                                '</td><td>' . $row["pantherid"] .
                                                '</td><td>' . $row["studentname"] .
                                                '</td><td>' . $row["termid"] .
                                                '</td><td>' . $row["termname"] .
                                                '</td><td>' . $course5id .
                                                '</td><td>' . $course5name .
                                                '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                            $Isadd=true;
                                        }
                                        else
                                        {
                                            echo '<tr><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' . $course5id .
                                                '</td><td>' . $course5name .
                                                '</td><td></td><td></td></tr>';
                                        }
                                    }
                                    if(!empty($course6id)) {
                                        if ($Isadd == false) {
                                            echo '<tr><td>' . $row["id"] .
                                                '</td><td>' . $row["pantherid"] .
                                                '</td><td>' . $row["studentname"] .
                                                '</td><td>' . $row["termid"] .
                                                '</td><td>' . $row["termname"] .
                                                '</td><td>' . $course6id .
                                                '</td><td>' . $course6name .
                                                '</td><td><a href="studyplanregister.php?id= ' . $row["id"] . '" >Update</a></td><td><a href="studyplanremove.php?id=' . $row["id"] . ' "\">Remove</a></td></tr>';
                                            $Isadd=true;
                                        }
                                        else
                                        {
                                            echo '<tr><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' .
                                                '</td><td>' . $course6id .
                                                '</td><td>' . $course6name .
                                                '</td><td></td><td></td></tr>';
                                        }
                                    }

                                }
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
