<?php
	require('visitorSessionChecker.php');
	
	$pID=$_GET['id'];
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
  
  <!--jQuery Link-->
  <script src="vendor/jquery/jquery-3.1.1.min.js"></script>
  
  <!--JavaScript Validation link-->
  <script src="js/validationJS.js"></script>

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
  <div class="container col-sm-12">

    <!-- Header with Background Image -->
    <header class="dash">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
          </div>
        </div>
      </div>
    </header>
	
	
	<!--Main Content-->
	<div class="container col-sm-10">
		<br/>
		<h1>Full Post Details</h1>
		<div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="sitterSearch.php"> Sitter Search</a> &raquo;
			<a class="BreadEff" href="viewPostDetails.php">Post Details</a>
	    </div>
		<br/>
	
		<?php
			//get postID from global
			global $pID; 
			
			//declare variables to store stuff
			$pCode="";
			$pricing=0.0;
			$desc="";
			$date="";
			$sName="";
			$fName="";
			$lName="";
			$email="";
			$pNum="";
			$dAvail="";
			$imgName="";
			
			//do query with postID to display all of the post details
			//make connection to database
			require('dbConnect.php');
			
			//create sql query to pull basic post information
			if($stmt=mysqli_prepare($mysqli, 
			"SELECT tblserviceposting.postCode, tblserviceposting.pricing, tblserviceposting.description, tblserviceposting.dateMade, 
			tblservice.serviceName, tblvisitor.firstname, tblvisitor.lastname, tblvisitor.email, tblsitter.phoneNumber
			FROM tblserviceposting, tblservice, tblpostcreation, tblvisitor, tblsitter
			WHERE tblserviceposting.postID=tblpostcreation.postID
			AND tblpostcreation.serviceID=tblservice.serviceID
			AND tblpostcreation.userID=tblsitter.userID
			AND tblsitter.userID=tblvisitor.userID
			ANd tblserviceposting.postID=?")){
				//bind parameters
				mysqli_stmt_bind_param($stmt, "i", $pID);
				
				if(mysqli_stmt_execute($stmt)){
					
					mysqli_stmt_bind_result($stmt, $pCode, $pricing, $desc, $date, $sName, $fName, $lName, $email, $pNum);
					
					if(mysqli_stmt_fetch($stmt)){
						
						echo"
						<div class='col-sm-12'>
							<div class='card container-fluid'>
								<div class='card-body'>
									<h1 class='card-title'>$sName, $pCode</h1>
									<h2 class='card-title'>Sitter Name: $fName $lName</h2>
									<h4 class='card-title'>Basic Information:</h4>
									<h5 class='card-title'>About Me:</h5>
									<p class='card-text'>$desc</p>
									<hr/>
									<h5 class='card-title'>My Details:</h5>
									<p class='card-text'>Price per Hour: $$pricing.00</p>
									<p class='card-text'>Phone: $pNum</p>
									<p class='card-text'>Email: $email</p>
									<p class='card-text'>Date made: $date</p>
									<hr/>
						";
					}//end of if
					
				}else{
					echo"<h4>An error occured with the view, please contact an administrator for assistance</h4>";
				}
			}//end of stmt
			
			//do query to show availability
			require('dbConnect.php');
			
			if($stmt=mysqli_prepare($mysqli, 
			"SELECT tblavailability.daysAvailable
			FROM tblavailability
			WHERE tblavailability.postID=?")){
				//bind stuff
				mysqli_stmt_bind_param($stmt, "i", $pID);
				
				if(mysqli_stmt_execute($stmt)){
					
					mysqli_stmt_bind_result($stmt, $dAvail);
						echo"<h4 class='card-title'>Available Days:</h4>";
					while(mysqli_stmt_fetch($stmt)){
						echo"
							<p class='card-text'>$dAvail</p>
						";
					}//end of while loop
				}else{
					echo"<p class='error'>A database error occured while trying to display this. Please contact an administrator for assistance.</p>";
				}
			}//end of if-stmt
			
			//do query to check if post has images and if it does echo them out. 
			require('dbConnect.php');
			
			if($stmt=mysqli_prepare($mysqli, 
			"SELECT tblimages.imageName
			FROM tblimages
			WHERE tblimages.postID=?")){
				
				//bind stuff
				mysqli_stmt_bind_param($stmt, "i", $pID);
				
				if(mysqli_stmt_execute($stmt)){
					
					mysqli_stmt_store_result($stmt);
					
					mysqli_stmt_bind_result($stmt, $imgName);
					
					if(mysqli_stmt_num_rows($stmt)>=1){
						
						
						echo"<hr/><h4 class='card-title'>Uploaded Images:</h4>";
						
						while(mysqli_stmt_fetch($stmt)){
							echo"
							
							<img src='uploads/$imgName' style='width:200px; height:200px;' alt='uploaded picture'/>
							
							";
						}//end of while
						
					}else{
						
						echo"<hr/><p>This sitter has not uploaded any images.</p>";
					}
					
				}else{
					echo"<p class='error'>A database error occured while trying to display this. Please contact an administrator for assistance.</p>";
				}
				
			}//end of if-stmt
			
			
			
			echo"		</div>
					</div>
				</div>
			<br/>";
		?>
	
		</div>
	</div><!--End of main div-->
	
	
 <!-- /.row -->
 
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
