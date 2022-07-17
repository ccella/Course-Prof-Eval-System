<?php
session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

    //get all courses from table
    $query = "SELECT * FROM `professors` WHERE 1";
    $queryEval = "SELECT * FROM `evaluations` WHERE 1";
    $professor_results = mysqli_query($con, $query);
    $prof_eval = mysqli_query($con,$queryEval);

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

  <!-- Fontawesome ICONS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <style>
  <?php include "style2.css" ?>
  </style>

  <script>
    $(document).ready(function(){
      $('#comment_field').hide();
    });
  </script>

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
        <li class="nav-item">
          <a class="nav-link" href="admin_index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_course_search.php">Course Search</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="prof_search.php">Prof Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Navbar END -->

  <!-- Search bar START -->
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="search_bar" id="search_bar" method="GET">  
    <div class="search-container shadow">
      <div class="input-group bg-1">
        <input type="text" class="form-control" name="search" placeholder="Professor Code">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit" name="search_bar" style="background-color: #FF4B2B;">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </div>
  </form>
  <!-- Search bar --> 
 
  <div class="container p-5 my-3 bg-light text-dark text-center rounded shadow-sm">
    <div class="container-fluid bg-info p-2 shadow rounded">
       <h5 class="text-white font-weight-bold p-2">Summary of Professor Evaluations</h5>
  </div>
  <br>
 
  <?php

    if($_SERVER['REQUEST_METHOD'] == "GET"){

      if (isset($_GET['search_bar'])) 
      {
        //if user searched a course
        $search_query = $_GET['search'];
        $count_q1 = 0;
        $count_q2 = 0;
        $count_q3 = 0;
        $count_q4 = 0;
        $count_q5 = 0;
        $count_q6 = 0;
        $count_q7 = 0;
        $count_q8 = 0;
        $count_q9 = 0;
        $count_q10 = 0;
        $count_q11 = 0;
        $count_q12 = 0;
        $count_q13 = 0;
        $count_q14 = 0;
        $count_q15 = 0;
        $comment1 = "";
        $comment2 = "";
        $count_entries = 0;

        //sanitize user input
        $search_query = trim($search_query);

        if(!empty($search_query))
        {
          $match = false;
          //if course is found
          if($professor_results && mysqli_num_rows($professor_results) > 0)
          {
            while($row = mysqli_fetch_assoc($professor_results))
            {
              if($row['professorCode'] == $search_query) //match
              { 
                $professorCode = $row['professorCode'];
                $_SESSION['professorCode'] = $row['professorCode'];  //set session var for course code
                if(!$match){
                echo "<h5 class='font-weight-bold'>Professor Name</h5><h5>".$row['professorName']."</h5>";
                echo "<h5 class='font-weight-bold'>Professor Code</h5><h5>".$row['professorCode']."</h5>";
                }
                $match = true; 
                //break; //escape loop    
              }
            }
          }

          if(!$match) 
          {
            die("<div class='alert alert-warning text-center'>
                    <p>No Professor matches Code!</p>
             </div>");
          } 

        if($prof_eval && mysqli_num_rows($prof_eval) > 0){
            $match_eval = false;
            while($row = mysqli_fetch_assoc($prof_eval)){
              if($row['professorCode'] == $professorCode){
                $count_q1 = $count_q1 + (int)$row['profEval'][0];
                $count_q2 = $count_q2 + (int)$row['profEval'][2];
                $count_q3 = $count_q3 + (int)$row['profEval'][4];
                $count_q4 = $count_q4 + (int)$row['profEval'][6];
                $count_q5 = $count_q5 + (int)$row['profEval'][8];
                $count_q6 = $count_q6 + (int)$row['profEval'][10];
                $count_q7 = $count_q7 + (int)$row['profEval'][12];
                $count_q8 = $count_q8 + (int)$row['profEval'][14];
                $count_q9 = $count_q9 + (int)$row['profEval'][16];
                $count_q10 = $count_q10 + (int)$row['profEval'][18];
                $count_q11 = $count_q11 + (int)$row['profEval'][20];
                $count_q12 = $count_q12 + (int)$row['profEval'][22];
                $count_q13 = $count_q13 + (int)$row['profEval'][24];
                $count_q14 = $count_q14 + (int)$row['profEval'][26];
                $count_q15 = $count_q15 + (int)$row['profEval'][28];

                $com = (string)$row['profEval'];
                $temp1 = substr($com, 30);
                $pos1 = strrpos($temp1, ",");
                if(strtolower(substr($temp1, 0, $pos1)) != "none"){
                  $comment1 = $comment1 . substr($temp1, 0, $pos1) . "<br>";
                }

                $temp2 = substr($com, (31 + $pos1));
                if(strtolower($temp2) != "none"){
                  $comment2 = $comment2 . $temp2 . "<br>";
                }

                $count_entries = $count_entries + 1;
                $match_eval = true;
              }
            }
          }

        if(!$match_eval){
          die("<div class='mt-5 alert alert-warning text-center'>
                  <p>No evaluations yet!</p>
           </div>");
        }
            echo "<br>";
            echo"<div class='mb-2'>
                  <span class='reviewCount'>
                    <h5><mark>Number of evaluations: ".$count_entries."</mark></h5>
                  </span>
                 </div>";

            //Print Summary for Question 1
            echo '<div class="container row justify-content-center mx-auto pl-1 pr-1 w-75">
            <div class="container-fluid text-center col-12 bg-warning"> <h5 class="mt-2">';
            echo  "1. Explains the objectives, expectations & various requirements of the course.";
            echo  '</div></div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:'; 
            echo ($count_q1/($count_entries*5))*100; echo '%"></div>
                <div class="rate-stars"></div>
            </div>'; 
            echo '<span class="reviewScore">'; 
            echo substr($count_q1/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 2
            echo '<div class="container row justify-content-center mx-auto mt-2 pl-1 pr-1 w-75">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">';
            echo "2. Encourages students to think critically and/or creatively.</p>";
            echo '</div></div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q2/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div></div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q2/$count_entries,0,3);
            echo '</span>';

            //Print Summary for Question 3
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">3. Communicates clearly.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q3/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">';
            echo substr($count_q3/$count_entries,0,3);
            echo '</span>';

            //Print Summary for Question 4
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">4. Answers students’ questions clearly and adequately.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q4/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">';
            echo substr($count_q4/$count_entries,0,3);
            echo '</span>';

            //Print Summary for Question 5
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">5. Is able to help students understand complex ideas related to the subject matter.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q5/($count_entries*5))*100;
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">';
            echo substr($count_q5/$count_entries,0,3);
            echo '</span>';

            //Print Summary for Question 6
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">6. Uses engaging and helpful learning exercises/activities.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q6/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q6/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 7
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">7. Relates the subject matter to issues and developments in the discipline and/or real-life concerns.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q7/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q7/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 8
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">8. Encourages students to participate in discussions/activities.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q8/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q8/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 9
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">9. Makes himself/herself available for consultation.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q9/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q9/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 10
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">10. Encourages students to express their ideas & viewpoints.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q10/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q10/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 11
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">11. Communicates/interacts with students in a positive way.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q11/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q11/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 12
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">12. Shows respect for student diversity & individual differences.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q12/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q12/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 13
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">13. Makes full use of the required hours for learning.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q13/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q13/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 14
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">14. Provides fair & timely feedback on student performance.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q14/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q14/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Question 15
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">15. Uses clear criteria to evaluate student performance.</p>
            </div>
            </div>';
            echo '<div style="margin-top: 10px">
                <div class="result-container">
                <div class="rate-bg" style="width:';
            echo ($count_q15/($count_entries*5))*100; 
            echo '%"></div>
                <div class="rate-stars"></div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo substr($count_q15/$count_entries,0,3); 
            echo '</span>';

            //Print Summary for Part 2.1
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">1. In relation to your learning experience in this class, what does your teacher do that you find very helpful/effective?</p>
            </div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo $comment1; 
            echo '</span>';

            //Print Summary for Part 2.2
            echo '<div class="container row justify-content-center mx-auto mt-2 w-75 pl-1 pr-1">
            <div class="container-fluid text-center col-12 bg-warning">
                <h5 class="mt-2">2. How do you think can the teaching in this class be improved to enhance your learning experience?</p>
            </div>
            </div>';
            echo '<span class="reviewScore">'; 
            echo $comment2; 
            echo '</span>';

            //show comment box
            // echo "<script>
            //         $(document).ready(function(){
            //           $('#comment_field').show();
            //         });
            //       </script>";

            
            // $query = "SELECT * FROM `comments` WHERE  = '$courseCode'";
            // $comment_results = mysqli_query($con, $query);


            //   if($comment_results && mysqli_num_rows($comment_results) > 0)
            //   {
            //     echo "<br><br><h4 class = 'text-left'>Comments</h4>";

            //     while($row = mysqli_fetch_assoc($comment_results))
            //     {
            //       $user = $row['saisNumber'];
            //       //get nickname of user based on saisNumber
            //       $query = "SELECT * FROM `students` WHERE saisNumber = '$user'";
            //       $student_results = mysqli_query($con, $query);
            //       $student_row = mysqli_fetch_assoc($student_results);
            //       $nickname = $student_row['nickname'];

            //       //get comment data from comments table based on current row
            //       $retrieved_comment = $row['comment_text'];
            //       $date = $row['date'];

            //       //display comments
            //       //check if user is the one that made the comment
            //       $student_email = $student_row['email'];
            //       $user_email = $user_data['email'];
            //       $style = "style='display: none;'";

            //       if ($student_email == $user_email) {
            //         $_SESSION['retrieved_comment'] = $retrieved_comment; //set for posssible deletion
            //         $style = "";
            //       }

            //       echo "<div class='media border p-3 mb-1'>
            //               <div class='media-body text-left'>
            //                 <h5>".$nickname."<small><i> Commented on ".$date."</i></small></h5>
            //                 <p>".$retrieved_comment."</p>
            //               </div>
            //               <div class='col d-flex align-items-start justify-content-end'>
            //                 <button class='btn btn-link text-danger' data-toggle='modal' data-target='#deleteAlert' id='modalTrigger'".$style.">Delete</button>
            //               </div>
            //             </div>";

            //       //show delete notification modal on button click
            //       echo "<div class='modal fade in' id='deleteAlert' tabindex='-1' role='dialog' aria-labelledby='deleteNotifModal' aria-hidden='true'>
            //               <div class='modal-dialog modal-dialog-centered' role='document'>
            //                 <div class='modal-content'>
            //                   <div class='modal-header bg-danger'>
            //                     <h5 class='modal-title text-white font-weight-bold' id='exampleModalLongTitle'>Warning!</h5>
            //                   </div>
            //                   <div class='modal-body'>
            //                     Are you sure you want to delete that comment?
            //                   </div>
            //                   <div class='modal-footer mx-auto'>
            //                     <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
            //                     <form method='POST'>
            //                       <button type='submit' class='btn btn-danger' name='delete_comment'>Delete</button>
            //                     </form>
            //                   </div>
            //                 </div>
            //               </div>
            //             </div>";
     
            //     }
      
          // } 
        } else //if empty
        {
          die("<div class='alert alert-warning text-center'>
                  <p>Please enter a course!</p>
                </div>");
        }
      }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST") 
    {
      //delete comment
      if(isset($_POST["delete_comment"]) && isset($_SESSION['retrieved_comment'])){
        $retrieved_comment = mysqli_real_escape_string($con, $_SESSION['retrieved_comment']);
        $query = "DELETE FROM comments WHERE comment_text = '$retrieved_comment'";
        mysqli_query($con, $query);
        echo "<div class='alert alert-success'>
                Comment deleted
              </div>";
        unset($_SESSION['retrieved_comment']);
      }

      if(isset($_POST['commentBox']))
      {
        //if user commented
        $user_comment = mysqli_real_escape_string($con, $_POST['user_comment']); //escape special characters
        
         if(empty($user_comment)){
          $user_comment = "";
        }
         //get saisNumber of current user based on email
        $user_email = $user_data['email'];
        $query = "SELECT * FROM `students` WHERE email = '$user_email'";
        $result = mysqli_query($con, $query);
        $user_row = mysqli_fetch_assoc($result);
        $saisNumber = $user_row['saisNumber'];
        if (isset($_SESSION['courseCode'])) {
          $courseCode = $_SESSION['courseCode'];
        }
        /*
        echo "email: ".$user_email."<br>";
        echo "SAIS: ".$saisNumber."<br>";
        echo "Course code: ".$courseCode."<br>";
        echo "Comment: ".$user_comment."<br>";
        echo $_SERVER['REQUEST_URI'];
        */

        if(!empty($user_comment))
        {
          $current_date = date("Y/m/d");
          $query = "INSERT INTO `comments`(`saisNumber`, `courseCode`, `comment_text`, `date`) VALUES ('$saisNumber','$courseCode','$user_comment','$current_date')"; 
          $result = mysqli_query($con, $query);  //execute query  
          //$url = "?search=."History+10."&search_bar="; 

          if(!$result){
            die("<div class='alert alert-danger'>
                    <strong>Error!</strong> Unable to post comment
                  </div>");
          }

          echo"<div class='alert alert-success'>
              You have posted a comment on <strong>".$courseCode."</strong>
            </div>";
        }
        else {
          die("ERROR! Something went wrong");
        }
      }
    } 

  ?>

    <br><br>
    <form action="<?php echo $_SERVER['REQUEST_URI']?>" name="commentBox" method="POST">
      <input type="text" id="comment_field" class="form-control w-50" placeholder="Write a comment..." name="user_comment">
      <input type="submit" name="commentBox" style="display: none;">
    </form>
  </div>

</body>
</html>