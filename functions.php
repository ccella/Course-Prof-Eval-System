<?php

function check_login($con){
	if(isset($_SESSION['user_id']))
	{
		$id = $_SESSION['user_id'];
		$query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;
}

function retrieve_student_data($con){
	if(isset($_SESSION['pk']))
	{
		$email = $_SESSION['pk'];
		$query = "SELECT * FROM students WHERE email = '$email' LIMIT 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{
			$student_data = mysqli_fetch_assoc($result);
			return $student_data;
		}

		die("No result found in student db");
	}

	//error
	die("Could not retrieve student data");
}

function retrieve_course_data($con, $id){
	if(isset($_SESSION['pk']))
	{
		$query = "SELECT * FROM courses WHERE ID = '$id' LIMIT 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{
			$course_data = mysqli_fetch_assoc($result);
			return $course_data;
		}

		die("<br><br><br><br>No course result found in db");
	}

	//error
	die("<br><br><br><br>Could not retrieve course data");
}

function retrieve_prof_data($con, $profName){
	if(isset($_SESSION['pk']))
	{
		$query = "SELECT * FROM professors WHERE professorName = '$profName' LIMIT 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{
			$prof_data = mysqli_fetch_assoc($result);
			return $prof_data;
		}

		die("No prof result found in db");
	}

	//error
	die("Could not retrieve course data");
}

function random_num($length){
	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4, $length);

	for ($i = 0; $i < $len; $i++) 
	{ 
		$text .= rand(0,9);

	}

	return $text;
}

?>