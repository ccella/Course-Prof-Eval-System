<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
        //if user commented
        //get saisNumber of current user based on email
        
        $comment = $_POST['toDelete'];
        echo "Comment: ".$comment;
        /*
        $user_email = $user_data['email'];
        $query = "SELECT `saisNumber` FROM `students` WHERE email = '$user_email'";
        $saisNumber = mysqli_query($con, $query);
        if(!empty($user_comment))
        {
          $query = "INSERT INTO `comments`(`saisNumber`, `courseCode`, `comment_text`) VALUES ('$saisNumber','$courseCode','$user_comment')"; 
          mysqli_query($con, $query);  //execute query
        }

        
        //redirect to course search
        header("Location: course_search.php");
        die;   
        */
}

?>