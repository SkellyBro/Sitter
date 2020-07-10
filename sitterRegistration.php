<?php
	require('visitorSessionChecker.php');
	
	//creat global variables
	$feedback; 
	$count=0; 
	$success="";
	
	$date=date("Y-m-d");
	
	if(isset($_POST['submit'])){
		//get variables sent by the post
		$agree=$_POST['agree'];
		$pNum=$_POST['pNum'];
		$exp=$_POST['exp'];
		
		//validate and sanitize entered information
		validate($agree, $pNum, $exp);
		
		//sanitize entered information
		sanitize($pNum, $exp);
		
		//insert into database
		if($count==0){
			if(isset($_SESSION['uID'])){
				$uID=$_SESSION['uID'];
			}
			
			sitterInsert($uID, $date, $pNum, $exp);
			deleteVistor($uID);
			updatePostion($uID);
			
			//hardcode the new position so the session checkers don't disrupt anything
			$_SESSION['pos']=2;
			
			/*
			Code adapted from: https://stackoverflow.com/questions/6119451/page-redirect-after-certain-time-php
			Code accessed on: 1 April 2019
			Code Author: Teneff
			
			*/
			header( "refresh:5;url=sitterDash.php" );
		}//end of count
		
	}//end of isset
	
	function deleteVistor($uID){
		global $feedback;
		global $count; 
		global $success; 
		
		//make connection to database
		require('dbConnect.php');
		
		//make sql string
		if($stmt=mysqli_prepare($mysqli, 
		"DELETE FROM tblConsumer WHERE userID=?")){
			mysqli_stmt_bind_param($stmt,"i", $uID);
			
			//execute stmt
			if(mysqli_stmt_execute($stmt)){
				$success.="<p>Consumer status deleted! You are now a Sitter!</p>";
			}else{
				$feedback.="<p>Consumer status could not be deleted, please contact an administrator for assistance.</p>";
				printf("Error #%d: %s.\n", mysqli_stmt_errno($stmt), mysqli_stmt_error($stmt));
				$count++;
				return false; 
			}//end of else
		}//end of if-stmt
	}//end of function deleteVistor
	
	function escapeString($val){
		$val= filter_var($val, FILTER_SANITIZE_STRING);

		//include php code

		include('dbConnect.php');
		//sanitize data going into MySQL

		$val= mysqli_real_escape_string($mysqli, $val);
		return $val;
	}//end of function escapeString
	
	function sanitize($pNum, $exp){
		//sanitize form data
		$pNum= filter_var($pNum, FILTER_SANITIZE_STRING);
		$exp= filter_var($exp, FILTER_SANITIZE_STRING);
		
		//include escape string function here, this uses the mysqli escape string to prevent special characters from being entered into the db
		escapeString($pNum);
		escapeString($exp);
	}//end of sanitize
	
	//function to insert user data into the database
	function sitterInsert($uID, $date, $pNum, $exp){
		//call global variables
		global $feedback;
		global $count;
		global $success;
		
		//make connection to database
		require('dbConnect.php');
		
		if($stmt=mysqli_prepare($mysqli, 
		"INSERT INTO tblsitter VALUES(?, ?, ?, ?)")){
			mysqli_stmt_bind_param($stmt, "isis", $uID, $date, $pNum, $exp);
			
			//execute stmt
			if(mysqli_stmt_execute($stmt)){
				$success.="<p>Sitter registration complete!<p>";
			}else{
				$feedback.="<p>Registration failed, please contact an administrator for assistance.</p>";
				printf("Error #%d: %s.\n", mysqli_stmt_errno($stmt), mysqli_stmt_error($stmt));
				$count++;
				return false; 
			}//end of else
		}//end of if-stmt
	}//end of sitterInsert
	
	function updatePostion($uID){
		global $success;
		global $feedback;
		global $count; 
		
		//connect to database
		require('dbConnect.php');
		
		//create sql string
		if($stmt=mysqli_prepare($mysqli, 
		"UPDATE tblVisitor SET position=2 WHERE userID=?")){
			//bind stuff
			mysqli_stmt_bind_param($stmt, "i", $uID);
			
			if(mysqli_stmt_execute($stmt)){
				$success.="<p>Your position has been updated, you will be re-directed to the sitter dashboard in 5 seconds.</p>";
			}else{
				$feedback.="<p>Your position could not be updated, please contact an administrator for assistance.</p>";
				$count++;
			}
		}//end of if-stmt
	}//end of updatePostion
	
	function validate($agree, $pNum, $exp){
		global $feedback;
		global $count; 
		
		if($agree=="" || $agree==null){
			$feedback.="<p>You must agree to the terms of service!</p>";
			$count++;
		}
		
		//phone number validation
		if($pNum=="" || $pNum==null){
			$feedback.="<p>You must enter a phone number</p>";
			$count++;
		}
		
		if(strlen($pNum)<7){
			$feedback.="<p>Your phone number must have more than 7 characters</p>";
			$count++;
		}
		
		if(strlen($pNum)>15){
			$feedback.="<p>Your phone number cannot be more than 15 characters</p>";
			$count++;
		}
		
		if(!ctype_digit($pNum)){
			$count++;
			$feedback.="<p>Your phone number can only contain numbers</p>";
		}
		
		//experience validation
		if($exp=="" || $exp==null){
			$feedback.="<p>You must enter some of your experience!</p>";
			$count++;
		}
		
		if(strlen($exp)>500){
			$feedback.="<p>Your experience cannot be more than 500 characters</p>";
			$count++;
		}
		
		
	}//end of function validate
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
		<h1>Sitter Registration</h1>
		 <div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="sitterRegistration.php"> Sitter Registration</a>
	    </div>
		<br/>
		<h6>You can register as a sitter using the form below! Please note that once you register as a sitter your account will be converted to a sitter account.
		Therefore if you wish to request the services of others in the future you may need to make a new account with the site. We apologize for any inconvenience this may cause, 
		however this is something we will fix in future releases of the UrbanSitter website.</h6>
		
		 <?php 
			//feedback code
			global $feedback; 
			global $success;
			
	         if($feedback != ""){
		 
		     echo "<div class= 'alert alert-danger'>"; 
		       if ($count == 1) echo "<strong>$count error found.</strong>";
			   if ($count > 1) echo "<strong>$count errors found.</strong>";
		     echo "$feedback
			   </div>";
			}//end of feedback
			
			if($success != ""){
		 
		     echo "<div class= 'alert alert-success'>"; 
		     echo "$success
			   </div>";
			}//end of feedback
			
	 ?>
		
		<form name="sReg" action="sitterRegistration.php" method="post" onsubmit="return sitterRegVal(this)" class="form-horizontal">
		
		<div class="form-group"> 
			<label class="control-label">Phone Number:(Cell or Landline)</label>
		 <div class="col-sm-10">

			<input type="text" class="form-control" name="pNum" id="phonenumber" aria-labelledby="phonenumber" /> 
		 </div>
		 <span id="pNum_err"></span>
		</div>
		
		<div class="form-group green-border-focus">
		<label class="control-label">Your Experience:</label>
			<div class="col-sm-10">
				

				<textarea class="form-control" name="exp" id="exp"  rows="3" placeholder="Let us know a bit of our sitting experience here so we can get an idea of your abilities!" 
				aria-labelledby="exp"></textarea>
				
			</div>
			<span id="exp_err"></span>
		</div>
		
		<hr/>
		<div>
			<div class="checkbox">
			 <label>I agree to the <a href="aboutUs.php">terms of service</a></label>
			 <input type="checkbox" name="agree" value="Yes">
			</div>
		<span id="agree_err"></span>
		</div>
		<br/>
		<div class="col-sm-10">
			<input type="submit" class="btn btn-primary form-control" name="submit" value="Submit"/>
		</div>
		</form>
		<br/>
		</div>
	</div><!--End of main div-->
	
	
 <!-- /.row -->
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; UrbanSitter 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
