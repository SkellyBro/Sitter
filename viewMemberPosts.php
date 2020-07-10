<?php
	require('sitterSessionChecker.php');
	
	$feedback="";
	$count=0;
	$imageCount=0;
	$success="";
	//start of delete post code
		
	if(isset($_POST['pID'])){
		//get ID
		$deleteID=$_POST['pID'];
		
		//check to see if there are images to delete and delete them
		imageCheck($deleteID);
		
		//delete images
		if($imageCount!=0){
			deleteImages($deleteID);
		}
		
		//delete ternary insert
		delTern($deleteID);
		
		//delete availabiility 
		delAvail($deleteID);
		
		if($count==0){
			delPost($deleteID);
		}
		
	}//end of delete isset
	
	function delAvail($dID){
		global $feedback;
		global $count; 
		
		require('dbConnect.php');
		
		//create sql string to delete availabiility
		if($stmt=mysqli_prepare($mysqli, "DELETE FROM tblavailability WHERE tblavailability.postID=?")){
			mysqli_stmt_bind_param($stmt, "i", $dID);
			
			if(mysqli_stmt_execute($stmt)){
				return true; 
			}else{
				$count++;
				$feedback.="<p>an error occured with the deletion of your date availability, please contact an administrator for assistance</p>";
				return false;
			}
		}//end of if-stmt
	}//end of delAvail
	
	function imageCheck($dID){
		global $imageCount; 
		//make connection to dbConnect
		require('dbConnect.php');
		
		//create sql to check if there are files to delete
		if($stmt=mysqli_prepare($mysqli, 
		"SELECT * FROM tblimages WHERE tblimages.postID=?")){
			mysqli_stmt_bind_param($stmt, "i", $dID);
			
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				$imageCount=mysqli_stmt_num_rows($stmt);
				$feedback.="$imageCount";
				return true;
			}else{
				return false; 
			}
		}//end of if-stmt
	}//end of function imageCheck
	
	function delPost($dID){
		global $feedback;
		global $count; 
		global $success;
		
		//make connection to db
		require('dbConnect.php');
		
		//create sql to delete the post
		if($stmt=mysqli_prepare($mysqli, 
		"DELETE FROM tblserviceposting WHERE tblserviceposting.postID=?")){
			mysqli_stmt_bind_param($stmt, "i", $dID);
			
			if(mysqli_stmt_execute($stmt)){
				$success="<p>Post successfully deleted!</p>";
			}else{
				$count++;
				$feedback.="<p>Post could not be deleted, please contact an administrator for assistance.</p>";
				printf("Error #%d: %s.\n", mysqli_stmt_errno($stmt), mysqli_stmt_error($stmt));
			}
		}//end of if-stmt
	}//end of function delPost
	
	function delTern($dID){
		global $feedback; 
		global $count;
		
		//make connection to db
		require('dbConnect.php');
		
		//create sql to delete the ternary
		if($stmt=mysqli_prepare($mysqli, 
		"DELETE FROM tblpostcreation WHERE tblpostcreation.postID=?")){
			mysqli_stmt_bind_param($stmt, "i", $dID);
			
			if(mysqli_stmt_execute($stmt)){
				return true; 
			}else{
				$count++;
				$feedback.="<p>An error occured with the delete, please contact an administrator for assistance</p>";
			}
		}//end of if-stmt
	}//end of function delTern
	
	function deleteImages($deleteID){
		global $feedback;
		global $count; 
		//make connection to database
		require('dbConnect.php');
		
		//delete image files first
		if($stmt=mysqli_prepare($mysqli, 
		"DELETE FROM tblimages WHERE tblimages.postID=?")){
			//bind variable for the delete
			mysqli_stmt_bind_param($stmt, "i", $deleteID);
			
			//execute the statement
			if(mysqli_stmt_execute($stmt)){
				return true; 
			}else{
				$count++;
				$feedback.="<p>Something went wrong with the delete, please contact an administrator for assistance</p>";
			}
		}//end of stmt-if
	}//end of function delete images
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
      <a class="navbar-brand logo" href="sitterDash.php"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
         <li class="nav-item active">
            <a class="nav-link" href="sitterDash.php">Home
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
	
	
	<!--Main Content-->
	<div class="container col-sm-10">
	
	<br/>
		<h1>All Service Posts</h1>
		<div>
			<a class="BreadEff" href="sitterDash.php"> Dashboard</a> &raquo;
			<a class="BreadEff" href="viewMemberPosts.php"> Service Posts</a>
	    </div>
		<br/>
		<h6>You can view all of your service posts and manage them all from here.</h6>
		
		<?php
		//php feedback code
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
		
		
		//php to query and echo out all the service posts made by a user. 
		
		//get session variables
		if(isset($_SESSION)){
			$uName=$_SESSION['uName'];
		}
		
		//initalize global variables
		$pID=0; 
		$pCode="";
		$pricing=0.0; 
		$desc="";
		$sName="";
		$date="";
		
		//make database connection
		require("dbConnect.php");
		
		//create sql query
		if($stmt=mysqli_prepare($mysqli, 
		"SELECT tblserviceposting.postID, tblserviceposting.postCode, tblserviceposting.pricing, tblserviceposting.description, tblservice.serviceName, tblserviceposting.dateMade
		FROM tblserviceposting, tblservice, tblpostcreation, tblvisitor
		WHERE tblserviceposting.postID=tblpostcreation.postID
		AND tblpostcreation.serviceID=tblservice.serviceID
		AND tblpostcreation.userID= tblvisitor.userID
		AND tblvisitor.username=?
		GROUP BY tblserviceposting.postID")){
			mysqli_stmt_bind_param($stmt, "s", $uName);
			
			if(mysqli_stmt_execute($stmt)){
			
				mysqli_stmt_store_result($stmt);
					echo"<p>". mysqli_stmt_num_rows($stmt). " service post(s) found</p>";
				
				mysqli_stmt_bind_result($stmt, $pID, $pCode, $pricing, $desc, $sName, $date);
				
				//create table head
				echo"
				<div class='table-responsive'>
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>
									Post ID
								</th>
								<th>
									Post Code
								</th>
								<th>
									Service Name
								</th>
								<th>
									Pricing
								</th>
								<th>
									Description
								</th>
								<th>
									Date
								</th>
								<th>
									Edit
								</th>
								<th>
									Delete
								</th>
							</tr>
						</thead>
						<tbody>";
					//do stuff with the resultset
					while(mysqli_stmt_fetch($stmt)){
					echo"
						<tr>
							<td>$pID</td>
							<td>$pCode</td>
							<td>$sName</td>
							<td>$pricing</td>
							<td>$desc</td>
							<td>$date</td>
							<td>
							
								<a class='btn btn-link' href='editPost.php?id=$pID'>Edit</a>
							
							</td>
							<td>
								<form method='post' action='viewMemberPosts.php'>
								<input type='hidden' name='pID' value='$pID'/>
								<button onclick='return confirmation()' class='btn btn-link form-control' 
								name='delete' >Delete</button>
								</form>
							
							</td>
						</tr>
					";
				}//end of while
				echo"</tbody></table></div>";
			}//end of execute if statement
			
		}//end of if-stmt
		
		?>
	<br/>
	<br/>
	<br/>
	</div>
	</div><!--End of main div-->
	
	
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
