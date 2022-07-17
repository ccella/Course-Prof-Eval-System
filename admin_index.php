<?php
session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

    if(empty($nickname)){
      $nickname = "Admin";
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
    <a class="navbar-brand pl-1 logo" href="admin_index.php">COURPES</a>
    <div class="navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="admin_index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_course_search.php">Course Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="prof_search.php">Prof Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Navbar END -->
	<div style="padding: 10px; margin-top: 15vh; background-color: #B3E5FC;">
	  <h1 class="text-center" style="font-size: 40px;">Hello, <?php echo $nickname; ?></h1>
	  <p class="text-center">This is the Home page</p>
	</div>

</body>
</html>