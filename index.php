<?php
session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);
    $student_data = retrieve_student_data($con);

    if(isset($student_data['nickname'])){
      $nickname = $student_data['nickname'];
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
	
	<link href="style2.css" rel="stylesheet" type="text/css"/>
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
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="course_search.php">Course Search</a>
        </li>
        <li class="nav-item">
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
	<div style="padding: 10px; margin-top: 15vh; background-color: #B3E5FC;">
	  <h1 class="text-center" style="font-size: 40px;">Hello, <?php echo $nickname; ?></h1>
	  <p class="text-center">Welcome to the Course/Professor Evaluation System</p>
	</div>
	<br><br>
	<div class="container w-50">
		<div class="card bg-light shadow-sm pl-4 pb-3">
			<h5 class="card-title font-weight-bold mt-3 text-center">Courses to Evaluate</h5>
			  <?php

		        $courses = $student_data['courses']; //1,2,3,4,5
		        $courseData = explode(",", trim($courses)); //[0] => 1, [1] => 2, etc
          		$courseLength = str_replace(',', '', $courses); //12345
          		$evaluations = $student_data['evaluations']; //1,2,3,4,5
              	$evaluationData = explode(",", trim($evaluations)); //[0] => 1, [1] => 2, etc
		        for ($i=0; $i < strlen($courseLength); $i++) {
		        	$status = "Pending";
		        	$badge = "badge-warning";
		          	if ($courseData[$i] != $evaluationData[$i]) {
	                  	$status = "Completed";
	                  	$badge = "badge-success";
	                }
	                $course_data = retrieve_course_data($con,$courseData[$i]); 
		            $course_title = $course_data['courseName'];
		            $course_prof = $course_data['professorName'];
		            $course_id = $course_data['id'];
		                echo "<div class='d-flex align-items-center justify-content-center'>
								<p class='card-text mt-3'>".$course_title." (".$course_prof.")"."</p>
								<span class='badge badge-pill ".$badge." ml-1'>".$status."</span>
							  </div>";
	              }

		      ?>
	    </div>
	</div>

</body>
</html>