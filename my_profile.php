<?php
session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);
    $student_data = retrieve_student_data($con);
    
    $pk = $student_data['email'];

    if(isset($student_data['nickname'])){
      $nickname = $student_data['nickname'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
      $nickname = $_POST['nickname'];

      if(!empty($nickname)){
        $query = "UPDATE students SET nickname ='$nickname' WHERE email ='$pk'"; 
        mysqli_query($con, $query);  //execute query
      }
    }

    if(empty($nickname)){
      $nickname = "User";
    }
?>

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

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<link href="style2.css" rel="stylesheet" type="text/css"/>

  <script>
    $(document).ready(function(){
      $("#nickname_field").hide();
      $("button.edit").click(function(){
        $("#nickname_field").toggle();
      });

      /*$("#nickname_field").keypress(function(event) {
          if (event.key === "Enter") {
            $('#nickname_text').text($("#nickname_field").val());
          }
      });
      */

      $('form').each(function() {
        $(this).find('input').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                this.form.submit();
            }
        });

        $(this).find('input[type=submit]').hide();
      });
    });
  </script>
	<title>My Profile</title>
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
        <li class="nav-item">
          <a class="nav-link" href="evaluation.php">Evaluation</a>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown active">
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
<div class="container bg-1">
  <h4>Student Information</h4>
  <div class="card bg-light shadow-sm">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <h5 class="card-title font-weight-bold">Nickname</h5>
          <p class="card-text" id="nickname_text"><?php echo $nickname; ?></p>
        </div>
        <div class="col d-flex align-items-center justify-content-end">
          <button class="edit btn btn-link">Edit</button>
          <form name="nicknameBox" method="POST">
            <input type="text" id="nickname_field" class="form-control ml-2" placeholder="New nickname" name="nickname">
            <input type="submit">
          </form>
        </div>
      </div>
      <h5 class="card-title font-weight-bold mt-3">Name</h5>
      <p class="card-text"><?php echo $student_data['studentName']; ?></p>
      <h5 class="card-title font-weight-bold mt-3">College</h5>
      <p class="card-text"><?php echo $student_data['college']; ?></p>
      <h5 class="card-title font-weight-bold">Degree Program</h5>
      <p class="card-text"><?php echo $student_data['degree']; ?></p>
      <h5 class="card-title font-weight-bold">Year Level</h5>
      <p class="card-text"><?php echo $student_data['year']; ?></p>
      <h5 class="card-title font-weight-bold">Student Number</h5>
      <p class="card-text"><?php echo $student_data['studentNumber']; ?></p>
      <h5 class="card-title font-weight-bold">SAIS Number</h5>
      <p class="card-text"><?php echo $student_data['saisNumber']; ?></p>
      <h5 class="card-title font-weight-bold">Email</h5>
      <p class="card-text"><?php echo $user_data['email']; ?></p>
    </div>
  </div>
</div>
<div class="container mt-5 mb-5">
  <h4>Term Information</h4>
  <div class="card bg-light shadow-sm">
    <ul>
      <?php

          $courses = $student_data['courses']; //1,2,3,4,5
          $courseData = explode(",", trim($courses)); //[0] => 1, [1] => 2, etc
          $courseLength = str_replace(',', '', $courses); //12345
          for ($i=0; $i < strlen($courseLength); $i++) {
            $course_data = retrieve_course_data($con,$courseData[$i]); 
            $course_title = $course_data['courseName'];
            $course_prof = $course_data['professorName'];
            echo "<li>
                    <h5 class='card-title font-weight-bold mt-3'>".$course_title."</h5>
                    <p class='card-text'>".$course_prof."</p>
                  </li>";
          }
      ?>
    </ul>
  </div>
</div>

</body>
</html>