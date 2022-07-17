<!DOCTYPE html>
<html>
<head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Fontawesome ICONS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style2.css">
  <link rel="stylesheet" type="text/css" href="star_rating.css">

  <script>
    $(document).ready(function(){
      $('#modalButton').hide();

      /*
      $("#submit").click(function(){
          $("#modalButton").click(); 
          return false;
      });
      */

      //trigger when form is submitted
      /*
      $("#evaluation_form").submit(function(e){
          $('#submitAlert').modal('show');
          return true;
      });
      */

      $("#course_select").click(function() {
          let prof_and_course = `${$('#course_select').val()}`;
          //prof_and_course = prof_and_course.replace(/\s/g,'')
          let fields = prof_and_course.split('-');
          let prof = fields[0];
          let course = fields[1];
          if (prof && course) {
            $('#selected_course').text($('#course_select option:selected').text()); //currently evaluating
            $('#course_prof').text(`(${prof})`); //currently evaluating
            $("#course_prof_text_field").attr("placeholder", prof); //professor to evaluate
          }
      });
    });
  </script>
	<title>Home</title>
</head>
<body>

  <!-- Navbar START -->
  <nav class="navbar navbar-expand-sm navbar-dark fixed-top pt-3 pb-3 nav-color">
    <!-- Brand -->
    <img src="https://www.seekpng.com/png/full/188-1882776_form-icon-form-icon-png.png" alt="form-logo" id="form-img" style="width: 2.5%; height: auto;">
    <a class="navbar-brand pl-1 logo" href="index.php">COURPES</a>
    <div class="navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="course_search.php">Course Search</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="evaluation.php">Evaluation</a>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            My Profile
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="my_profile.php">View My Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Navbar END -->
   
  <?php
    session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);
    $student_data = retrieve_student_data($con);

    if (condition) {
      # code...
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //something was posted
        $form_data = "";
        $studentNum = $student_data['studentNumber']; //send
        $hiddenFormData = $_POST['course_select'];
        if (empty($hiddenFormData)) {
          die("<br><br><br><br><div class='mt-5 alert alert-warning text-center'>
                <p><strong>Error!</strong> Please select a course</p>
              </div>");
        }
        $courseData = explode("-", trim($hiddenFormData));
        $courseProf = $courseData[0];
        $courseTitle = $courseData[1];
        $courseID = $courseData[2];
        $profEntry = retrieve_prof_data($con,$courseProf);
        $profCode = $profEntry['professorCode']; //send
        $courseEntry = retrieve_course_data($con,$courseID);
        $courseCode = $courseEntry['courseCode']; //send

        $profEval = "";
        for ($i=1; $i <= 17; $i++) { 
          $response = $_POST['question'.$i];
          if(!isset($response)){
            die("<br><br><br><br><strong>Error!</strong> A response is empty in prof eval");
          } else {
            $profEval = $profEval.$response.",";
          }
        }
        $profEval = substr($profEval, 0, -1);

        $courseEval = "";
        for ($i=18; $i <= 23; $i++) { 
          $response = $_POST['question'.$i];
          //die("question no. ".$i."<br>".$response);
          if(empty($response)){
            die("br><br><br><br><strong>Error!</strong> A response is empty in course eval");
          } else {
            $courseEval = $courseEval.$response.",";
          }
        }
        $courseEval = substr($courseEval, 0, -1);
        
        /*
        $form_data .= $studentNum.",";
        $form_data .= $profCode.",";
        $form_data .= $courseCode.",";
        $form_data .= $profEval.",";
        $form_data .= $courseEval;
        */

        $query = "INSERT INTO `evaluations`(`studentNumber`, `courseCode`, `professorCode`, `profEval`, `courseEval`) VALUES ('$studentNum','$courseCode','$profCode','$profEval','$courseEval')"; 
        mysqli_query($con, $query);  //insert form data to table

        $evaluations = $student_data['evaluations'];
        $evaluatedPos = strpos($evaluations,strval((int)$courseID)); //find 1st occurence of courseID(course) in evaluation field
        $evaluations = str_replace($evaluations[$evaluatedPos],$evaluations[$evaluatedPos] * -1,$evaluations);

        $pk = $student_data['email'];
        $query = "UPDATE students SET evaluations = '$evaluations' WHERE email = '$pk'";
        mysqli_query($con, $query);

        //$_SESSION['form_submitted'] = "OK";

        //refresh page
        //echo "<meta http-equiv='refresh' content='0'>";
        
        //load modal
        header("Location: redirect.php");
  
    }

  ?>

  <!-- FORM START -->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()" name="evaluation_form" id="evaluation_form" method="POST">  
  <div class="row">
    <div class="col-md-auto">
      <div class="dropdown bg-1 pt-1 pl-2">
        <div class="form-group">
          <label for="course_select"><p class="ml-1" style="font-size: 1.25rem;">Course to evaluate</p></label>
          <select class="form-control" id="course_select" name="course_select">
            <option class="dropdown-item" value="" selected="true" disabled><p>-- SELECT A COURSE --</p></option>
            <?php

              $courses = $student_data['courses']; //1,2,3,4,5
              $courseData = explode(",", trim($courses)); //[0] => 1, [1] => 2, etc
              $courseLength = str_replace(',', '', $courses); //12345
              //$courses = str_replace(' ', '', $courses);
              $evaluations = $student_data['evaluations']; //1,2,3,4,5
              $evaluationData = explode(",", trim($evaluations)); //[0] => 1, [1] => 2, etc
              //$evaluations = str_replace(' ', '', $evaluations);
              for ($i=0; $i < strlen($courseLength); $i++) {
                if ($courseData[$i] == $evaluationData[$i]) {
                  $course_data = retrieve_course_data($con,$courseData[$i]); 
                  $course_title = $course_data['courseName'];
                  $course_prof = $course_data['professorName'];
                  $course_id = $course_data['id'];
                  echo "<option class='dropdown-item' value='".$course_prof." - ".$course_title." - ".$course_id."']'>".$course_title."</option>";
                }
              }

            ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-auto">
      <div class="dropdown bg-1 pt-1 pl-2">
        <div class="form-group">
          <label for="course_select"><p class="ml-1" style="font-size: 1.25rem;">Professor to evaluate</p></label>
            <input class="form-control" id="course_prof_text_field" type="text" placeholder="" readonly>
        </div>
      </div>
    </div>
    <div class="col d-flex justify-content-end">
      <div class="container d-flex justify-content-end align-items-end">
        <h5 class="font-weight-bold mb-4">Currently evaluating: </h5>
        <h5 class="ml-1 mb-4" id="selected_course">None</h5>
        <h5 class="ml-1 mb-4" id="course_prof"></h5>
      </div>
    </div>
  </div>  
	
<div class="container mt-4 text-center">
  <h2>Evaluation Form</h2>
  <br>

    <div class="container form-container bg-red-orange p-2 shadow rounded">
       <h6 class="text-white font-weight-bold p-2">STUDENT EVALUATION FOR TEACHING EFFECTIVENESS Part 1</h6>
    </div>
    <div class="container-fluid form-container bg-light p-2 shadow rounded">
      <p class="font-italic">
        Please answer the following questions using the following legend:  
      </p>
      <p>1 = strongly disagree</p>
      <p>5 = strongly agree</p>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-12" style="background-color:orange;"><p class="font-weight-bold pt-2">In this class the teacher...</p></div>
        <div class="col-6"></div>
        <!--<div class="col" style="background-color:pink;"><pre class="font-weight-bold pt-2 mr-4 pr-3">1      2      3      4     5    NA</pre></div> -->
        <div class="col mt-2"><p class="mr-4 font-weight-bold">1</p></div>
        <div class="col mt-2"><p class="mr-4 font-weight-bold">2</div>
        <div class="col mt-2"><p class="mr-4 font-weight-bold">3</div>
        <div class="col mt-2"><p class="mr-4 font-weight-bold">4</div>
        <div class="col mt-2"><p class="mr-3 font-weight-bold">5</div>
        <div class="col mt-2"><p class="mr-4 font-weight-bold">NA</div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">1. Explains the objectives, expectations & various requirements of the course.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question1" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question1" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question1" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question1" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question1" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question1" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">2. Encourages students to think critically and/or creatively.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question2" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question2" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question2" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question2" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question2" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question2" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">3. Communicates clearly.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question3" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question3" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question3" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question3" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question3" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question3" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">4. Answers students’ questions clearly and adequately.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question4" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question4" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question4" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question4" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question4" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question4" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">5. Is able to help students understand complex ideas related to the subject matter.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question5" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question5" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question5" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question5" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question5" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question5" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">6. Uses engaging and helpful learning exercises/activities.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question6" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question6" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question6" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question6" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question6" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question6" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">7. Relates the subject matter to issues and developments in the discipline and/or real-life concerns.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question7" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question7" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question7" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question7" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question7" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question7" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">8. Encourages students to participate in discussions/activities.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question8" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question8" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question8" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question8" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question8" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question8" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">9. Makes himself/herself available for consultation.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question9" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question9" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question9" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question9" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question9" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question9" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">10. Encourages students to express their ideas & viewpoints.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question10" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question10" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question10" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question10" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question10" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question10" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">11. Communicates/interacts with students in a positive way.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question11" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question11" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question11" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question11" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question11" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question11" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">12. Shows respect for student diversity & individual differences.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question12" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question12" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question12" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question12" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question12" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question12" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">13. Makes full use of the required hours for learning.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question13" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question13" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question13" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question13" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question13" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question13" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-light">
          <p class="mt-2 text-justify">14. Provides fair & timely feedback on student performance.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question14" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question14" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question14" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question14" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question14" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question14" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="col-6 bg-gray">
          <p class="mt-2 text-justify">15. Uses clear criteria to evaluate student performance.</p>
        </div>
        <div class="form-check form-check-inline col" >
          <input type="radio" name="question15" id="inlineRadio1" value="1" class="mx-auto" required>
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question15" id="inlineRadio2" value="2" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question15" id="inlineRadio3" value="3" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question15" id="inlineRadio1" value="4" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question15" id="inlineRadio2" value="5" class="mx-auto">
        </div>
        <div class="form-check form-check-inline col">
          <input type="radio" name="question15" id="inlineRadio3" value="0" class="mx-auto">
        </div>
      </div>
    </div>

    <div class="container form-container bg-red-orange mt-3 p-2 shadow rounded">
      <h6 class="text-white font-weight-bold p-2">STUDENT EVALUATION FOR TEACHING EFFECTIVENESS Part 2</h6>
    </div>
    <div class="container-fluid form-container bg-light p-2 shadow rounded">
      <p class="font-italic">
        Please also answer the following questions:  
      </p>
      <div class="form-group">
        <p class="text-justify ml-3 mr-3">1. In relation to your learning experience in this class, what does your teacher do that you find very helpful/effective?</p>
        <input type="text" class="form-control ml-3 w-75" placeholder="Enter text here" name="question16" required>
      </div>
      <div class="form-group">
        <p class="text-justify ml-3 mr-3">2. How do you think can the teaching in this class be improved to enhance your learning experience?</p>
        <input type="text" class="form-control ml-3 w-75" placeholder="Enter text here" name="question17" required=>
      </div>
    </div>

    <!-- COURSE EVALUATION -->
    <div class="container form-container bg-red-orange mt-3 p-2 shadow rounded">
      <h6 class="text-white font-weight-bold p-2">COURSE EVALUATION</h6>
    </div>
    <div class="container-fluid form-container bg-light p-2 shadow rounded">
      <p class="font-italic">
        Please answer the following questions regarding the course:  
      </p>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="container-fluid text-center col-12 bg-orange">
          <p class="mt-2">Before and After Student Interest Towards the Course</p>
        </div>
      </div>
      <div class="row">
        <div class="col d-flex align-items-center justify-content-center ml-2">
          <p class="font-weight-bold">Before</p>
        </div>
        <div class="col-6">
          <div class="container d-flex justify-content-center">
            <div class="row">
              <div class="col-md-12">
                <div class="stars">
                  <input class="star star-5 form-check" id="star-5" type="radio" name="question18" value="5"/> <label class="star star-5" for="star-5"></label> 
                  <input class="star star-4 form-check" id="star-4" type="radio" name="question18" value="4"/> <label class="star star-4" for="star-4"></label> 
                  <input class="star star-3 form-check" id="star-3" type="radio" name="question18" value="3"/> <label class="star star-3" for="star-3"></label> 
                  <input class="star star-2 form-check" id="star-2" type="radio" name="question18" value="2"/> <label class="star star-2" for="star-2"></label> 
                  <input class="star star-1 form-check" id="star-1" type="radio" name="question18" value="1"/> <label class="star star-1" for="star-1"></label> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="margin-top: -5vh;">
        <div class="col d-flex align-items-center justify-content-center ml-2">
          <p class="font-weight-bold">After</p>
        </div>
        <div class="col-6">
          <div class="container d-flex justify-content-center">
            <div class="row">
              <div class="col-md-12">
                <div class="stars">
                  <input class="star star-5 form-check" id="star2-5" type="radio" name="question19" value="5"/> <label class="star star2-5" for="star2-5"></label> 
                  <input class="star star-4 form-check" id="star2-4" type="radio" name="question19" value="4"/> <label class="star star-4" for="star2-4"></label> 
                  <input class="star star-3 form-check" id="star2-3" type="radio" name="question19" value="3"/> <label class="star star-3" for="star2-3"></label> 
                  <input class="star star-2 form-check" id="star2-2" type="radio" name="question19" value="2"/> <label class="star star-2" for="star2-2"></label> 
                  <input class="star star-1 form-check" id="star2-1" type="radio" name="question19" value="1"/> <label class="star star-1" for="star2-1"></label> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="container-fluid text-center col-12 bg-orange">
          <p class="mt-2">Course Difficulty</p>
        </div>
      </div>
      <div class="stars">
        <input class="star star-5 form-check" id="star3-5" type="radio" name="question20" value="5"/> <label class="star star3-5" for="star3-5"></label> 
        <input class="star star-4 form-check" id="star3-4" type="radio" name="question20" value="4"/> <label class="star star3-4" for="star3-4"></label> 
        <input class="star star-3 form-check" id="star3-3" type="radio" name="question20" value="3"/> <label class="star star3-3" for="star3-3"></label> 
        <input class="star star-2 form-check" id="star3-2" type="radio" name="question20" value="2"/> <label class="star star3-2" for="star3-2"></label> 
        <input class="star star-1 form-check" id="star3-1" type="radio" name="question20" value="1"/> <label class="star star3-1" for="star3-1"></label> 
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="container-fluid text-center col-12 bg-orange">
          <p class="mt-2">Course Enjoyment</p>
        </div>
      </div>
      <div class="stars">
        <input class="star star-5 form-check" id="star4-5" type="radio" name="question21" value="5"/> <label class="star star4-5" for="star4-5"></label> 
        <input class="star star-4 form-check" id="star4-4" type="radio" name="question21" value="4"/> <label class="star star4-4" for="star4-4"></label> 
        <input class="star star-3 form-check" id="star4-3" type="radio" name="question21" value="3"/> <label class="star star4-3" for="star4-3"></label> 
        <input class="star star-2 form-check" id="star4-2" type="radio" name="question21" value="2"/> <label class="star star4-2" for="star4-2"></label> 
        <input class="star star-1 form-check" id="star4-1" type="radio" name="question21" value="1"/> <label class="star star4-1" for="star4-1"></label> 
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="container-fluid text-center col-12 bg-orange">
          <p class="mt-2">Time Alloted for Course (Activities, Assignments, Studying, etc.)</p>
        </div>
      </div>
      <div class="stars">
        <input class="star star-5 form-check" id="star5-5" type="radio" name="question22" value="5"/> <label class="star star5-5" for="star5-5"></label> 
        <input class="star star-4 form-check" id="star5-4" type="radio" name="question22" value="4"/> <label class="star star5-4" for="star5-4"></label> 
        <input class="star star-3 form-check" id="star5-3" type="radio" name="question22" value="3"/> <label class="star star5-3" for="star5-3"></label> 
        <input class="star star-2 form-check" id="star5-2" type="radio" name="question22" value="2"/> <label class="star star5-2" for="star5-2"></label> 
        <input class="star star-1 form-check" id="star5-1" type="radio" name="question22" value="1"/> <label class="star star5-1" for="star5-1"></label> 
      </div>
      <div class="container row justify-content-center mx-auto pl-1 pr-1">
        <div class="container-fluid text-center col-12 bg-orange">
          <p class="mt-2 red">Schedule Insights</p>
        </div>
      </div>
      <div class="stars">
        <input class="star star-5 form-check" id="star6-5" type="radio" name="question23" value="5"/> <label class="star star6-5" for="star6-5"></label> 
        <input class="star star-4 form-check" id="star6-4" type="radio" name="question23" value="4"/> <label class="star star6-4" for="star6-4"></label> 
        <input class="star star-3 form-check" id="star6-3" type="radio" name="question23" value="3"/> <label class="star star6-3" for="star6-3"></label> 
        <input class="star star-2 form-check" id="star6-2" type="radio" name="question23" value="2"/> <label class="star star6-2" for="star6-2"></label> 
        <input class="star star-1 form-check" id="star6-1" type="radio" name="question23" value="1"/> <label class="star star6-1" for="star6-1"></label> 
      </div>
    
    </div>

    <button type="submit" id="submit" data-toggle="modal" data-target="#submitAlert" class="btn btn-primary bg-red-orange mt-3 mb-3">Submit</button>
  </form>
</div>

<script type="text/javascript">
    function validateForm() {
      var i;
      for (i = 18; i <= 23; i++) {
        var x = document.forms["evaluation_form"][`question${i}`].value;
        if (x == "") {
          alert("Missing input on course evaluation proper");
          return false;
        }
      }
    }
</script>

</body>
</html>