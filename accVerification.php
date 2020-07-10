<?php

	if(isset($_POST['submit'])){
		//set error checking variables
		$count=0;
		$feedback="";
		$uName="";
		$position=0;
		$fName="";
		$lName="";
		$uID=0;
		$success="";
		
		$vCode=$_POST['vCode'];
		
		//validate vCode
		validate($vCode);
		
		//sanitize 
		sanitize($vCode);
		
		if($count==0){
			//authenticate vCode, if authenticate returns as true then a session isset and the user redirected to the index, 
			//else the user is redirected to the registration page
			if(authenticate($vCode)){
				session_start();
				$_SESSION['uName']=$uName;
				$_SESSION['uID']=$uID;
				$_SESSION['pos']=$position;
				$_SESSION['fName']=$fName; 
				$_SESSION['lName']=$lName; 
				
				$success.="<p>Account has been verified! You will be logged in and redirected to the homepage shortly.</p>";
				header('refresh:5;url=index.php');
			}else{
				$count++;
				$feedback.="<p>Invalid code entered, you will be redirected to the registration page shortly.</p>";
				header('refresh:5;url=registration.php');
			}
		}
	}//end of isset
	
	//function to authenticate the entered code and redirect users accordingly
	function authenticate($vCode){
		//make calls to global variables
		global $count;
		global $feedback;
		global $uName;
		global $position;
		global $uID; 
		global $fName;
		global $lName;
		
		//include database connection
		include('dbConnect.php');
		
		//build sql query
		if($stmt =mysqli_prepare($mysqli, 
		"SELECT tblVisitor.username, tblVisitor.position, tblVisitor.userID, tblVisitor.firstname, tblVisitor.lastname FROM tblVisitor WHERE tblVisitor.vCode=?")){
			//bind entered parameters to mysqli statement
			 mysqli_stmt_bind_param($stmt, "i", $vCode);
			 
			 //execute the stmt
			 mysqli_stmt_execute($stmt);
			 
			 //bind results of query
			 mysqli_stmt_bind_result($stmt, $uName, $position, $uName, $fName, $lName);

			 //echo results of query
			 if(mysqli_stmt_fetch($stmt))
			 {	 
				  updateStatus($vCode);
				  return true;
			 }else{
				 $count++;
				 $feedback.="</br>Verification code does not exist.";
				 return false;
			 }
		}//end of select check
	}//end of authenticate function
	
	function updateStatus($vCode){
		global $feedback;
		global $count; 
		
		//include database connection
		include('dbConnect.php');
		
		//build sql update query
		if($stmt= mysqli_prepare($mysqli,
		"UPDATE tblVisitor SET tblVisitor.accStatus=1 WHERE tblVisitor.vCode=?")){
			//bind entered parameters to mysqli statement
			mysqli_stmt_bind_param($stmt, "i", $vCode);
			
			//execute mysqli statement
			if(mysqli_stmt_execute($stmt)){
				return true;
			}else{
				$feedback.="<br/> An error occured. Please contact an administrator for assitance.";
				$count++;
				return false;
			}//end of mysqli_stmt_fetch
		}//end of update query
	}//end of function updateStatus
	
	//function to sanitize data
	function sanitize($vC){
		//sanitize form data
		$vC= filter_var($vC, FILTER_SANITIZE_STRING);
		
		//include escape string function here, this uses the mysqli escape string to prevent special characters from being entered into the db
		escapeString($vC);
		
	}//end of sanitize
	
	//function to escape any special characters from entered user data
	function escapeString($val){

		//include database connections
		include('dbConnect.php');
		
		//sanitize data going into MySQL
		$val= mysqli_real_escape_string($mysqli, $val);
		return $val;

	}//end of sanitizeData

	function validate($vC){
		global $count;
		global $feedback; 
		
		if($vC=="" || $vC==null){
			$count++;
			$feedback.="<p>You must enter a code to verify</p>";
		}
		
		if(strlen($vC)<5){
			$count++;
			$feedback.="<p>Your verification code must contain 5 characters. Check the email used for the registration for your verification code!</p>";
		}
		
		if(!ctype_digit($vC)){
			$count++;
			$feedback.="<p>Your verification code can only contain numbers.</p>";
		}
	}//end of validate


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
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactUs.php">Contact</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link" href="registration.php">Registration</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container col-sm-12">

   <!-- Header with Background Image -->
    <br/>
	<br/>
	<br/>
	
	<div class="col-sm-1"></div>
	
	<div class="container col-sm-10">
	<br/>
	<h1>Account Verification</h1>
	 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="registration.php"> Registration</a> &raquo;
			<a class="BreadEff" href="accVerification.php"> Verification</a>
	    </div>
		<br/>
	
	 <?php 
			global $feedback;
			global $count; 
			global $success;
			
	         if($feedback != ""){
		 
		     echo "<div class= 'alert alert-danger'>"; 
		       if ($count == 1) echo "<strong>$count error found.</strong>";
			   if ($count > 1) echo "<strong>$count errors found.</strong>";
		     echo "$feedback
			   </div>";
			}//end of error code
			
			//this is feedback code for success messages
			if($success != ""){
				 echo "<div class= 'alert alert-success'>"; 
				 echo "$success
				   </div>";
			}//end of if statement for error
			
	 
	 ?>
	<p>Please enter the verification code sent to your email address. We apologize for any inconvenience this may cause, however this is a necessary
	precaution.</p>
		<form name="vForm" class="form-horizontal" method="post" action="#" onsubmit="return verify(this)">
		
			<div class="form-group"> 
			<label class="control-label">Verification Code:</label>
				<div class="col-sm-10">

					<input type="text" class="form-control" name="vCode" id="vCode"/> 
				</div>
				<span id="code_err"></span>
			</div>
			
			<div class="col-sm-10">
			<input type="submit" class="btn btn-primary form-control" name="submit" value="Submit"/>
		</div>
		</form>
	</div>
	
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
 <!-- /.row -->

	<div class="col-sm-1"></div>
 
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
