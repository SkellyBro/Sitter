<?php
	
	//Load Composer's autoloader
	require('phpmailer/PHPMailerAutoload.php');
	
	if(isset($_POST['submit'])){
		//set up global feedback variables
		$count=0; 
		$feedback="";
		$success="";
		$userID=0;
		
		//get data from post
		$uName=$_POST['uName'];
		$fName=$_POST['fName'];
		$lName=$_POST['lName'];
		$email=$_POST['email'];
		$pass=$_POST['password'];
		$cpass=$_POST['cpassword'];
		$captcha=$_POST['captcha_code'];
		
		//hard coded database values
		//set account status to false
		$accStatus=0; 
		//set position to 1
		$pos=1;
		//get date
		$date=date("Y-m-d");
		//create random number to use as verification code
		$vCode=rand(10,100000);
		
		//validation method
		validate($uName, $fName, $lName, $email, $pass, $cpass, $captcha);
		
		//sanitize 
		sanitize($uName, $fName, $lName);
		
		//check to ensure that the entered username is unique
		userNameCheck($uName);
		
		//check to ensure that the entered email is unique
		emailCheck($email);
		
		//check to ensure no errors are present
		if($count==0){
			
			//method to insert into the database
			insert($uName, $fName, $lName, $email, $pass, $accStatus, $vCode, $pos);
			
			//method to get the id of the inserted user
			getID($email, $pass);
			
			//method to insert user into tblconsumer
			insertConsumer($userID, $date, $fName, $lName, $vCode, $email);
			
			$success.="<br/> You will be redirected to the account verification screen shortly.";
			header('refresh:5;url=accVerification.php');
		}//end of count
		
		
	}//end of isset
	
	function emailActivation($fName, $lName, $email, $vCode){
		//write code to construct and send email
		global $feedback;
		global $count; 
		global $success;
		
		//start email code
		/*
		Code adapted from: https://github.com/PHPMailer/PHPMailer
		Code accessed on: 19 Mar 2019
		Code Author: Brent R. Matzelle
		*/
								
			$mail= new PHPMailer();

			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecture = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '587';
			$mail->SMTPSecure = 'tls';
			$mail->isHTML();
			$mail->Username='deonarineryan9@gmail.com';
			$mail->Password= 'k!ngl!0n_213';
			$mail->SetFrom('no-reply@UrbanSitter.com');
			$mail->Subject='UrbanSitter NoReply';
			$mail->Body= "Hello $fName $lName, <br/>
				Thank you for registering with UrbanSitter! Please see your activation code and a link to the activation page below! <br/>
				
				Your verification code is: $vCode <br/>
				
				<br/>
				Kind Regards, <br/>
				UrbanSitter Staff";
			$mail->AddAddress($email);
			
			//send the message, check for errors
				if (!$mail->send()) {
					$feedback.= "Mailer Error: " . $mail->ErrorInfo;
				} else {
					$success.="<br/>Verification Email Sent!";
					//Section 2: IMAP
					//Uncomment these to save your message in the 'Sent Mail' folder.
					#if (save_mail($mail)) {
					#    echo "Message saved!";
					#}
				}
	}//end of function emailActivation
	
	function getID($e, $p){
		//make calls to global variables
		global $count;
		global $feedback;
		global $userID;
		
		//include database connection
		include('dbConnect.php');
		
		//build sql query
		if($stmt =mysqli_prepare($mysqli, 
		"SELECT tblVisitor.userID FROM tblVisitor WHERE tblVisitor.email=? and tblVisitor.password=?")){
			//bind entered parameters to mysqli statement
			 mysqli_stmt_bind_param($stmt, "ss", $e, md5($p));
			 
			 //execute the stmt
			 mysqli_stmt_execute($stmt);
			 
			 //bind results of query
			 mysqli_stmt_bind_result($stmt, $userID);

			 //echo results of query
			 if(mysqli_stmt_fetch($stmt))
			 {	 
				  return true;
			 }else{
				 $count++;
				 $feedback.="</br>Verification code does not exist.";
				 return false;
			 }
		}//end of select check
	}//end of getID
	
	//function to check entered userNameCheck
	function userNameCheck($uName){
		global $count; 
		global $feedback;
		
		require("dbConnect.php");
		//do check here
		
		if($stmt =mysqli_prepare($mysqli, 
		"SELECT * FROM tblVisitor WHERE tblVisitor.username=?")){
			//bind entered parameters to mysqli statement
			 mysqli_stmt_bind_param($stmt, "s", $uName);
			 
			 //execute the stmt
			 mysqli_stmt_execute($stmt);

			 //echo results of query
			 if(mysqli_stmt_fetch($stmt))
			 {	 
				 $count++;
				 $feedback.="</br>Username already chosen, please enter another username.";
				 return false;
			 }else{
				 return true;
			 }
		}//end of select check
	}//end of userNameCheck
	
	//function to check entered userNameCheck
	function emailCheck($email){
		global $count; 
		global $feedback;
		
		require("dbConnect.php");
		//do check here
		
		if($stmt =mysqli_prepare($mysqli, 
		"SELECT * FROM tblVisitor WHERE tblVisitor.email=?")){
			//bind entered parameters to mysqli statement
			 mysqli_stmt_bind_param($stmt, "s", $email);
			 
			 //execute the stmt
			 mysqli_stmt_execute($stmt);

			 //echo results of query
			 if(mysqli_stmt_fetch($stmt))
			 {	 
				 $count++;
				 $feedback.="</br>Email already exists in database.";
				 return false;
			 }else{
				 return true;
			 }
		}//end of select check
	}//end of userNameCheck
	
	//funciton to insert into consumser table
	function insertConsumer($userID, $date, $fName, $lName, $vCode, $email){
		global $feedback; 
		global $count; 
		global $success; 
		
		require('dbConnect.php');
		
		//prepare sql statement
		if($stmt=mysqli_prepare($mysqli, 
		"INSERT INTO tblConsumer(userID, consumerRegDate) VALUES(? ,?)")){
			//bind parametersto SQL object
			mysqli_stmt_bind_param($stmt, "is", $userID, $date);
			//Execute statement object and check if successful
			if(mysqli_stmt_execute($stmt)){
				$success.= "<br/>Registration Successful!";
				
				//send studet the email for verification
				if(emailActivation($fName, $lName, $email, $vCode)){
					$success.="<br/> Verification email sent!";
					
				}
				
				return true;
			
			}else{
				$feedback.= "<br/>Registration Unsuccessful consumer insert failed. Please contact site administrators for assistance. Err1";
				$count++;
				return false;
			}//end of feedback if else 
			
		}//end of sql query
	}//end of function insertConsumer
	
	//function to insert into database
	function insert($uName, $fName, $lName, $email, $password, $accStatus, $vCode, $pos){
		global $feedback; 
		global $count; 
		global $success; 
		
		//connect to db server and select db
	require("dbConnect.php");
	
	//prepare sql insert statement
	if ($stmt = mysqli_prepare($mysqli,
			"INSERT INTO tblVisitor(firstname, lastname, email, password, username, vCode, accStatus, position)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?)")){
			
			//Bind parameters to SQL Statement Object
			mysqli_stmt_bind_param($stmt, "sssssiii", $fName, $lName, $email, md5($password), $uName, $vCode, $accStatus, $pos);
			
			//Execute statement object and check if successful
			if(mysqli_stmt_execute($stmt)){
				return true;
			
			}else{
				$feedback.= "<br/>Registration Unsuccessful, insert failed. Please contact site administrators for assistance.";
				$count++;
				return false;
			}//end of feedback if else 
		
		}//end mysqli prepare statement
	}//end of insert function
	
	//function to sanitize data
	function sanitize($uN, $fN, $lN){
		//sanitize form data
		$uN= filter_var($uN, FILTER_SANITIZE_STRING);
		$fN= filter_var($fN, FILTER_SANITIZE_STRING);
		$lN= filter_var($lN, FILTER_SANITIZE_STRING);
		
		//include escape string function here, this uses the mysqli escape string to prevent special characters from being entered into the db
		escapeString($uN);
		escapeString($fN);
		escapeString($lN);
		
	}//end of sanitize
	
	//function to escape any special characters from entered user data
	function escapeString($val){

		//include database connections
		include('dbConnect.php');
		
		//sanitize data going into MySQL
		$val= mysqli_real_escape_string($mysqli, $val);
		return $val;

	}//end of sanitizeData
	
	
	//function to validate data
	function validate($u, $f, $l, $e, $p, $cp, $capt){
		global $count; 
		global $feedback; 
		
		//username validation
		if($u=="" || $u==null){
			$count++;
			$feedback.="<br/>You must enter a username!";
		}
		
		if(strlen($u)<2 || strlen($u)>25){
			$count++;
			$feedback.="<br/>Your username must be between 2-25 characters!";
		}
		
		if(!preg_match("/^[\w]+$/", $u)){
			$count++;
			$feedback.="<br/>Your username cannot contain special characters!";
		}//end of username validation
		
		//firstname validation
		if($f=="" || $f==null){
			$count++;
			$feedback.="<br/>You must enter a first name!";
		}
		
		if(strlen($f)<2 || strlen($f)>25){
			$count++;
			$feedback.="<br/>Your first name must be between 5-15 characters!";
		}
		
		//code adapted from https://stackoverflow.com/questions/23476532/check-if-string-contains-only-letters-in-javascript
		//accessed 01 July 2017		
		
		if(!ctype_alpha($f)){
			$count++;
			$feedback.="<br/>Your first name can only contain letters!";
		}//end of firstname validation
		
		//lastname validation
		if($l=="" || $l==null){
			$count++;
			$feedback.="<br/>You must enter a last name!";
		}
		
		if(strlen($l)<2 || strlen($l)>25){
			$count++;
			$feedback.="<br/>Your last name must be between 5-15 characters!";
		}
		
		if(!ctype_alpha($l)){
			$count++;
			$feedback.="<br/>Your last name can only contain letters!";
		}//end of firstname validation
		
		//email validation
		if($e=="" || $e==null){
			$count++;
			$feedback.="<br/> Email Required!";
		}
		
		if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
			$count++;
            $feedback.= "<br/> Invalid email format"; 
        }
		
		/*
		Code adapted from: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
		Code Author: rnevius
		Accessed on: 28 Feb 2019. 
		*/
		
		if(!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',$e)){
			$count++;
			$feedback.="<br/> Invalid email format";
		}//end of email validation
		
		//password validation
		if($p=="" || $p==null){
			$count++;
			$feedback.="<br/> Password Required";
		}
		
		if(strlen($p)<8){
			$count++;
			$feedback.="<br/> Your password must be more than 8 characters";
		}
		
		//confirm password validation
		if($cp=="" || $cp==null){
			$count++;
			$feedback.="<br/> Confirm Password Required";
		}
		
		if(strcmp($p, $cp)!==0){
			$count++;
			$feedback.="<br/> Passwords are not identical"; 
		}//end of confirm password validation
		
		//captcha validation
		if($capt=="" || $capt==null){
			$count++;
			$feedback.="<br/> You must complete the captcha";
		}else{
			valCaptcha($capt);
		}
		
	}//end of function validate
	
	/*
	PHP CAPTCHA Validation Code
	Code adapted from: https://www.phpcaptcha.org/
	@copyright 2013 Drew Phillips
	@author Drew Phillips <drew@drew-phillips.com>
	@version 3.5.1 (June 21, 2013)
	@package securimage
	*/
	function valCaptcha($capt){
		global $feedback;
		global $count; 
		//create a captcha function
		include_once('securimage/securimage.php');
		
		$securimage = new Securimage();
		
		if ($securimage->check($capt) == false) {
			// the code was incorrect
			$count++;
			$feedback.= "<br/>Incorrect CAPTCHA! Please try again.";
		  
		}
	}//end of valCaptcha
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
            <a class="nav-link" href="sitterSearch.php">Sitter Search</a>
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
    <header class="registration">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
          </div>
        </div>
      </div>
    </header>
	
	<div class="col-sm-1"></div>
	
	<!--Login Form-->
	<div class="container col-sm-10">
	<br/>
	<h1>Registration</h1>
	
	 <!--Breadcrumb Links-->
		 <div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="registration.php"> Registration</a>
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
	
	 <form name="reg" class="form-horizontal" method="post" action="registration.php" onsubmit="return registrationVal(this)">
	 
		<div class="form-group"> 
			<label class="control-label">Username:</label>
		 <div class="col-sm-10">

			<input type="text" class="form-control" name="uName" id="uName" aria-labelledby="uName"/> 
		 </div>
		 <span id="user_err"></span>
		</div>
		
		<div class="form-group"> 
			<label class="control-label">Firstname:</label>
		 <div class="col-sm-10">

			<input type="text" class="form-control" name="fName" id="fName" aria-labelledby="fName" /> 
		 </div>
		 <span id="fname_err"></span>
		</div>
		
		<div class="form-group"> 
			<label class="control-label">Lastname:</label>
		 <div class="col-sm-10">

			<input type="text" class="form-control" name="lName" id="lName" aria-labelledby="lName"/> 
		 </div>
		 <span id="lname_err"></span>
		</div>

		<div class="form-group"> 
			<label class="control-label">Email:</label>
		 <div class="col-sm-10">

			<input type="email" class="form-control" name="email" id="email" aria-labelledby="email"/> 
		 </div>
		 <span id="email_err"></span>
		</div>

		<div class="form-group">
			<label class="control-label">Password:</label>
		 <div class="col-sm-10">
			<input type="password" class="form-control" name="password" id="pass" aria-labelledby="pass"/> 
		 </div>
		 <span id="password_err"></span>
		</div>
		
		<div class="form-group">
			<label class="control-label">Confirm Password:</label>
		 <div class="col-sm-10">
			<input type="password" class="form-control" name="cpassword" id="cpass" aria-labelledby="cpass"/> 
		 </div>
		 <span id="cpass_err"></span>
		</div>
		
		<!--Word CAPTCHA HTML-->
		<!--
		Code adapted from: https://www.phpcaptcha.org/
		@copyright 2013 Drew Phillips
		@author Drew Phillips <drew@drew-phillips.com>
		@version 3.5.1 (June 21, 2013)
		@package securimage
		-->
		<div>
			<label class="control-label">Word Captcha:</label>
		 <div class="col-sm-10">
			
			<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" /> 
			<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a> 
			
			<p> Type the characters seen in the field below:</p> 
			<input type="text" class="form-control" name="captcha_code" id="c_code" aria-labelledby="c_code"/>
			
		 </div>
		 <span id="captcha_err"></span>
		</div>
		<br/>
		
		 <div class="col-sm-10">
			<input type="submit" class="btn btn-primary form-control brown" name="submit" value="Register"/>
		</div>
		</form>
		<br/>
		
	</div>
	
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
