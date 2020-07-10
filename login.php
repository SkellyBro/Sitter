<?php
	if(isset($_POST['submit'])){
		//global variables
		$feedback="";
		$count=0;
		$position=0; 
		$uID=0;
		$fName="";
		$lName="";
		$accStatus=0;
		
		//posted variables
		$uName=$_POST['uName'];
		$password=$_POST['password'];

		
		//function to validate the entered information 
		validate($uName, $password);
		
		//function to sanitize the entered information from special characters
		sanitize($uName, $password);
		
		if($count==0){
			authenticate($uName, $password);
			
			if($accStatus==1){
			
			//do check for remember me
			 if(isset($_POST['remMe'])){
				createCookie($uName, $position);
			}//end of checkbox isset
			
			if($position==1){
				session_start();
				$_SESSION['uName']=$uName;
				$_SESSION['uID']=$uID;
				$_SESSION['pos']=$position;
				$_SESSION['fName']=$fName; 
				$_SESSION['lName']=$lName; 
				header('Location:index.php');
			}else{
				session_start();
				$_SESSION['uName']=$uName;
				$_SESSION['uID']=$uID;
				$_SESSION['pos']=$position;
				$_SESSION['fName']=$fName; 
				$_SESSION['lName']=$lName; 
				header('Location:sitterDash.php');
			}
			
			}else{
				$count++;
				$feedback.="<p>You must verify your account before logging in. You will be redirected to the Account Verification screen shortly.</p>";
				header( "refresh:5;url=accVerification.php" );
			}
		}//end of count check	
	}//end of isset
	
	function authenticate($u, $p){
		//make call to global variables
		global $feedback;
		global $count; 
		global $position;
		global $uID;
		global $fName; 
		global $lName; 
		global $accStatus;
		
		//make connection to database
		include('dbConnect.php');
		
		//create sql query
		if($stmt=mysqli_prepare($mysqli,
		"SELECT tblVisitor.position, tblVisitor.userID, tblVisitor.firstName, tblVisitor.lastName, tblVisitor.accStatus
		FROM tblVisitor 
		WHERE tblVisitor.username=? 
		AND tblVisitor.password=?")){
			//bind entered parameters to mysqli statement
			 mysqli_stmt_bind_param($stmt, "ss", $u, md5($p));
			 
			 //execute the stmt
			 mysqli_stmt_execute($stmt);
			 
			 //bind results of query
			 mysqli_stmt_bind_result($stmt, $position, $uID, $fName, $lName, $accStatus);

			 //echo results of query
			 if(mysqli_stmt_fetch($stmt))
			 {	 
				 return true;
			 }else{
				 $count++;
				 $feedback.="</br>Invalid Credentials. Please ensure you have verified your account via your email.";
				 return false;
			 }
		}//end of sql query
	}//end of authenticate
	
	//function to create a cookie on the user's machine to store user information
	function createCookie($uName, $pos){
		//define the duration for keeping the cookie on the user's machine
		define("DURATION", 60 * 60 * 24 * 5);
		
		//set cookie
		setcookie("uName", $uName, time() + DURATION);
		setcookie("pos", $pos, time() + DURATION);
	}//end of createCookie
	
	function escapeString($val){
		$val= filter_var($val, FILTER_SANITIZE_STRING);

		//include php code

		include('dbConnect.php');
		//sanitize data going into MySQL

		$val= mysqli_real_escape_string($mysqli, $val);
		return $val;
	}//end of function escapeString
	
	function sanitize($u, $p){
		//sanitize form data
		$u= filter_var($u, FILTER_SANITIZE_STRING);
		$p= filter_var($p, FILTER_SANITIZE_STRING);
		
		//include escape string function here, this uses the mysqli escape string to prevent special characters from being entered into the db
		escapeString($u);
		escapeString($p);
	}//end of function sanitize
	
	function validate($u, $p){
		global $feedback; 
		global $count; 
		
		//username validation
		if($u=="" || $u==null){
			$count++;
			$feedback.="<br/>You must enter a username!";
		}
		
		if(strlen($u)<2 || strlen($u)>25){
			$count++;
			$feedback.="<br/>Your username must be between 2-25 characters!";
		}
		
		//password validation
		if($p=="" || $p==null){
			$count++;
			$feedback.="<br/> Password Required";
		}
		
		if(strlen($p)<8){
			$count++;
			$feedback.="<br/> Your password must be more than 8 characters";
		}
	}
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
    <header class="login">
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
	<h1>Login</h1>
	<div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="login.php"> Login</a>
	    </div>
		<br/>
	
		 <?php 
			global $feedback; 
			global $remMe;
			
	         if($feedback != ""){
		 
		     echo "<div class= 'alert alert-danger'>"; 
		       if ($count == 1) echo "<strong>$count error found.</strong>";
			   if ($count > 1) echo "<strong>$count errors found.</strong>";
		     echo "$feedback
			   </div>";
			}
	 
	 ?>
	 
	 <h6>Please note that this site makes use of Cookies to keep track of your information for the purpose of improving your user experience. To learn more about our
	 Cookie policy click <a href="#">here.</a></h6>
	
	 <form name="login" class="form-horizontal" method="post" action="login.php" onsubmit="return loginVal(this)">
		
		<?php
		if(isset($_COOKIE['uName'])){
			
			$storedUser=$_COOKIE['uName'];
			echo"<div class='form-group'> 
				<label class='control-label'>Username:</label>
			 <div class='col-sm-10'>

				<input type='text' class='form-control' name='uName' id='uName' aria-labelledby='Username' value='$storedUser'/> 
			 </div>
			 <span id='email_err'></span>
			</div>";
			
		}else{
			echo"<div class='form-group'> 
				<label class='control-label'>Username:</label>
			 <div class='col-sm-10'>

				<input type='text' class='form-control' name='uName' id='uName' aria-labelledby='uName'/> 
			 </div>
			 <span id='email_err'></span>
			</div>";
		}
		?>
		

		<div class="form-group">
			<label class="control-label">Password:</label>
		 <div class="col-sm-10">
			<input type="password" class="form-control" name="password" id="password" aria-labelledby="password"/> 
		 </div>
		 <span id="password_err"></span>
		</div>
		
		<hr/>
		<div class="checkbox">
		 <label>Remember Me </label>
		 <input type="checkbox" name="remMe" value="">
		</div>
		

		 <div class="col-sm-10">
			<input type="submit" class="btn btn-primary form-control submit" name="submit" value="Login"/>
		</div>
		</form>
		<br/>
		
		<a href="registration.php">Not a member? Register here!</a>
		<br/>
		<br/>
		<a href="accVerification.php">Already registered and want to verify your account? Click here!</a>
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
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
