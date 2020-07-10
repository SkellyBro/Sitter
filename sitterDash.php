<?php

	require('sitterSessionChecker.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Urban Sitter</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/heroic-features.css" rel="stylesheet">

</head>

<body>

   <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand logo" href="#.php"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
           <li class="nav-item active">
            <a class="nav-link" href="#.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aboutUs.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactUs.php">Contact</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<br/>
<br/>
<br/>



  <!-- Page Content -->
  <div class="container col-lg-12">

   <!-- Header with Background Image -->
    <header class="dash">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
          </div>
        </div>
      </div>
    </header>
	
	<div class="row">
	 <!-- Page Features -->
    <div class="col-sm-2">
			<div class="fluid-container">
				<table class="table">
					<tbody>
						<tr>
							<td><h6><a href="sitterDash.php">Dashboard</a></h6></td>
						</tr>

						<tr>
							<td><h6><a href="memberPost.php">Create Sitting Post</a></h6></td>
						</tr>
						
						<tr>
							<td><h6><a href="viewMemberPosts.php">View All Your Posts</a></h6></td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
	


    
	
	<!--Main Container-->
	<div class="container col-sm-10">
	<br/>
	<h1>Sitter Dashboard</h1>
	<?php
	
	if(isset($_SESSION)){
		$fName=$_SESSION['fName'];
		$lName=$_SESSION['lName'];
		echo"<h2>Welcome, $fName $lName.</h2>";
	}
	
	?>
	
	<h6>You can view all and manage all your posts here, and even see anyone who requested your sitting service!</h6>
	
	<!--Do dashboard stuff here-->
	<br/>
	<br/>
	<br/>
	<br/>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
  </div>
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; UrbanSitter 2019</p>
	  <a class="text-center text-white" href="#">Privacy Policy</a>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
