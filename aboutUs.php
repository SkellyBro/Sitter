<?php
$pos="";
session_start();

?>
<!DOCTYPE html>
<html lang="zxx">

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
  <br/>
   <br/>
    <br/>
	 <br/>
  <div class="container col-lg-12">
  
   <!-- Header with Background Image -->
    <header class="aboutUs">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
          </div>
        </div>
      </div>
    </header>
	
	<div class="col-lg-1"></div>
	
	<!--Login Form-->
	<br/>
	<div class="container col-lg-10">
		<div class="row">
		 <div class="col-lg-7">
          <h1>About Us</h1>
		  <div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="aboutUs.php"> About Us</a>
	    </div>
		<br/>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A deserunt neque tempore recusandae animi soluta quasi? Asperiores rem dolore eaque vel, porro, soluta unde debitis aliquam laboriosam. Repellat explicabo, maiores!</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis optio neque consectetur consequatur magni in nisi, natus beatae quidem quam odit commodi ducimus totam eum, alias, adipisci nesciunt voluptate. Voluptatum.</p>
        </div>
		
			<div class="col-sm-5">
				<div>
					<div class="card">
						<img class="card-img-top" src="images/plantsitter2.jpeg" alt="Image of a man taking care of a plant">
					</div>
				</div>
			</div>
		</div>
	<br/>
	
	
	<div class="row">
		<div class="col-sm-5">
				<div>
					<div class="card">
						<img class="card-img-top" src="images/sitter4.jpg" alt="Image of a woman and a girl playing with blocks">
					</div>
				</div>
			</div>
	
		 <div class="col-lg-7">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A deserunt neque tempore recusandae animi soluta quasi? Asperiores rem dolore eaque vel, porro, soluta unde debitis aliquam laboriosam. Repellat explicabo, maiores!</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis optio neque consectetur consequatur magni in nisi, natus beatae quidem quam odit commodi ducimus totam eum, alias, adipisci nesciunt voluptate. Voluptatum.</p>
		  
		   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A deserunt neque tempore recusandae animi soluta quasi? Asperiores rem dolore eaque vel, porro, soluta unde debitis aliquam laboriosam. Repellat explicabo, maiores!</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis optio neque consectetur consequatur magni in nisi, natus beatae quidem quam odit commodi ducimus totam eum, alias, adipisci nesciunt voluptate. Voluptatum.</p>
        </div>
		
			
	</div>
	<br/>
	
	
	
	
	
	</div>

 <!-- /.row -->

	<div class="col-sm-1"></div>
 
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
