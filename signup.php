
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>

<?php
session_start();

    include("connections.php");
    include("functions.php");

    if(isset($_SESSION['error']))
    {
      if($_SESSION['error'] == "invalid_email")
      {
        echo "<div class='alert alert-danger'>
                          <strong>Error!</strong> Invalid email format 
                      </div>";
        unset($_SESSION['error']);
      }
    }

    if(isset($_SESSION['error']))
    {
        if($_SESSION['error'] == "email_taken")
      {
        echo "<div class='alert alert-warning'>
                          <strong>Warning!</strong> This email is already in use 
                      </div>";
        unset($_SESSION['error']);
      }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //something was posted
        $email = $_POST['email'];
        $password = $_POST['psw'];

        if(!empty($email) && !empty($password))
        {
            //check if valid email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "invalid_email";
                header('Location: '.$_SERVER['PHP_SELF']);
                die;
            } 

            //check if email is already in db
            $check = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
            $select = mysqli_query($con, $check);
            if(mysqli_num_rows($select)) {
                $_SESSION['error'] = "email_taken";
                header('Location: '.$_SERVER['PHP_SELF']);
                die;
            }
            //save to db
            $user_id = random_num(20);
            $query = "INSERT INTO users (user_id, email, password) VALUES ('$user_id', '$email', '$password')";
            mysqli_query($con, $query);  //execute query
            //redirect to login
            $_SESSION['account_creation'] = "OK";
            header("Location: login.php");
            die;

        } else {
            echo "<div class='alert alert-danger'>
                        <strong>Error!</strong> Please enter valid information
                  </div>";
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Sign Up</title>
</head>
<body>
    <form name="myForm" id="signup-form" onsubmit="return validateForm()" method="POST">
      <div class="container">
        <h1 style="padding-top: 20px">Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
        
        <div class="clearfix">
            <button type="button" class="cancelbtn" onclick="window.location.href='login.php';">Cancel</button>
            <button type="submit" class="signupbtn">Sign Up</button>
        </div>
      </div>
    </form>

<script type="text/javascript">
    function validateForm() {
      var x = document.forms["myForm"]["psw"].value;
      var y = document.forms["myForm"]["psw-repeat"].value;
      if (x != y) {
            alert("Passwords do not match");
            return false;
        }
    }
</script>

</body>
</html>