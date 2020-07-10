<?php
$pos="";
session_start();

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
      <a class="navbar-brand logo" href="index.php"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home
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
            <a class="nav-link" href="sitterSearch.php">Sitter Search</a>
          </li>
        
		  <?php 
			  if(isset($_SESSION['pos'])){
				$pos=$_SESSION['pos'];
				if($pos==1){
					  echo"
						<li class='nav-item'>
							<a class='nav-link' href='sitterRegistration.php'>Register as a Sitter</a>
						</li>
						<li class='nav-item'>
							<a class='nav-link' href='logout.php'>Logout</a>
						</li>
					  
					  ";//end of echo
				}//end of pos if
			}else{
					 echo"
						 <li class='nav-item'>
							<a class='nav-link' href='registration.php'>Registration</a>
						  </li>
						   <li class='nav-item'>
							<a class='nav-link' href='login.php'>Login</a>
						  </li>
						";//end of echo
				}//end of else
		  ?>
		  
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container col-lg-12">
	
    <!-- Jumbotron Header -->
    <header class="jumbotron my-4">
      <h1 class="display-3" style="color: #fff;">Urban Sitter</h1>
      <p class="lead">The site where you can find a sitter for any and all of your needs!</p>
      <a href="sitterSearch.php" class="btn btn-primary btn-lg">Browse Sitters!</a>
    </header>
	
	  <?php
		if(isset($_SESSION['pos'])){
			$fName=$_SESSION['fName'];
			$lName=$_SESSION['lName'];
			
			echo"
				<div class='col-lg-12'>
				
					<h2>Hi, $fName $lName! Welcome to the UrbanSitter website!</h2>
					
				</div>
			";
		}
	
	
	?>
	
	<div class="col-lg-12">
	<h3>Preview our Range of Sitters:</h3>
	</div>
    <!-- Page Features -->
    <div class="row text-center col-lg-12">

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="images/sitter1.jpg" alt="An image of a woman with a baby in her lap">
          <div class="card-body">
            <h4 class="card-title">Babysitters</h4>
            <p class="card-text">We have a host of well qualified babysitters!</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="images/petsitter.jpg" alt="An image of a woman with a dog">
          <div class="card-body">
            <h4 class="card-title">Petsitters</h4>
            <p class="card-text">We understand how important your pets can be, and so do these petsitter!</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="images/housesitter.jpeg" alt="An image of two people holding a toy house in their hands">
          <div class="card-body">
            <h4 class="card-title">Housesitters</h4>
            <p class="card-text">Going on vacation? These well qualified housesitters will hold down the fort!</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="images/plantsitter.jpg" alt="An image of a man holding several small plants on a platform">
          <div class="card-body">
            <h4 class="card-title">Plantsitters</h4>
            <p class="card-text">Plants need attention too! These plantsitters have thumbs so green they're emerald!</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary">Find Out More!</a>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

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
