<?php
session_start();

    include("connections.php");
    include("functions.php");

    if(isset($_SESSION['account_creation']))
    {
      if($_SESSION['account_creation'] == "OK")
      {
        echo "<div class='alert alert-success'>
                          <strong>Success!</strong> You have created a new account 
                      </div>";
        unset($_SESSION['account_creation']);
      }
    }
  

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //remove all previous echoes
        ob_end_clean();

        //something was posted
        $email = $_POST['email'];
        $password = $_POST['psw'];

        if(!empty($email) && !empty($password))
        {

            //read from db 
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1"; 
            $result = mysqli_query($con, $query);  //execute query

            if($result)//check if email is valid
            {
                if($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);

                    if($user_data['password'] == $password)//check if password is valid
                    {
                        //successful login
                        $_SESSION['user_id'] = $user_data['user_id'];
                        $_SESSION['pk'] = $email;

                        //check if admin
                        if($email == "admin@up.edu.ph")
                        {
                          header("Location: admin_index.php");
                          die;
                        }
                        header("Location: index.php");
                        die;
                    }
                }
            }

            echo "<div class='alert alert-danger'>
                        <strong>Error!</strong> Wrong email or password
                    </div>";

        } else {
            echo "Please enter valid information!";
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>

    <div class="container" id="container">
      <div class="form-container log-in-container">
        <form name="myForm" id="login-form" method="POST">
          <h1>Login</h1>
          <input type="text" placeholder="Enter Email" name="email" required>
          <input type="password" placeholder="Enter Password" name="psw" required>
          <button>Log In</button>
          
          <!--
          <center>
            <p>Don't have an account?<br>
              <a href="signup.php">Sign Up</a> here.</p>
          </center>
          -->
          
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-right">
            <h1>COURPES</h1>
            <h5>Course/Professor Evaluation System</h5>
            <img src="https://www.seekpng.com/png/full/188-1882776_form-icon-form-icon-png.png" alt="form-logo" id="form-img">
          </div>
        </div>
      </div>
    </div>

</body>
</html>
