<?php
    session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

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

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style2.css">
  <link rel="stylesheet" type="text/css" href="star_rating.css">

  <script type="text/javascript">
    $(window).on('load', function() {
        $('#modalTrigger').click();
    });
  </script>
	<title>Home</title>
</head>
<body>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submitAlert" id="modalTrigger" style="display: none;">
  Launch demo modal
</button>
  <!-- Modal -->
  <div class="modal fade in" id="submitAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title text-white font-weight-bold" id="exampleModalLongTitle">Success!</h5>
        </div>
        <div class="modal-body">
          You have finished evaluating a form.
        </div>
        <div class="modal-footer mx-auto">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='index.php'">Go to Home</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href='evaluation.php'">Evaluate another form</button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>