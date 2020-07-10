<?php
	require('sitterSessionChecker.php');
	
	$pID=$_GET['id'];
	
	//create global variables to display stuff in the forms
	$sID=0; 
	$sName="";
	$feedback="";
	$success="";
	$count=0; 
	
	//create global variables to capture stuff
	$sittingType=0; 
	$posCode="";
	$availability=array();
	$pricing=0; 
	$pDesc="";
	$uID=0;
	
	//create random number to append to the names of the files
	$random=rand(10,100000);
	
	if(isset($_POST['submit'])){
		//get variables from post
		$posCode=$_POST['pCode'];
		$sittingType=$_POST['sitterType'];
		$availability=$_POST['dAvail'];
		$pricing=$_POST['price'];
		$pDesc=$_POST['eDesc'];
		$pID=$_POST['pID'];
		
		
		//validate and sanitize entered information
		validate($posCode, $sittingType, $availability, $pricing, $pDesc);
		
		//sanitize form fields
		sanitize($posCode, $sittingType, $availability, $pricing, $pDesc);
		
		
		if($count==0){
			updatePost($pID, $posCode, $pricing, $pDesc);
		}//end of if-check
		
		if($count==0){
			deleteAvail($pID);
		}
		
		insertDays($pID, $availability);
		
		if($count==0){
			updateTernary($pID, $sittingType);
		}
		
	}//end of post info update isset
	
	if(isset($_POST['submitImage'])){
		//function to save entered images
		$pID=$_POST['pID'];
		
		validateImages();
		
		if(count($_FILES['fileUpload']['name'])>=2){	
			if($count==0){
				deleteImages($pID);
				saveImages($pID);
			}
		}//end if
	}//end of submitImage isset
	
	//function to delete all images for a single post
	function deleteImages($pID){
		global $feedback;
		global $count; 
		
		//make connection to database
		require('dbConnect.php');
		
		//create sql string
		if($stmt=mysqli_prepare($mysqli, 
		"DELETE FROM tblimages WHERE postID=?")){
			//bind variables
			mysqli_stmt_bind_param($stmt, "i", $pID);
			
			if(mysqli_stmt_execute($stmt)){
				return true; 
			}else{
				$count++;
				$feedback.="<p>An error occured with the deletion of your old images. Please contact an administrator for assistance.</p>";
				return false; 
			}
		}//end of if-stmt
	}//end of deleteImages function
	
	function escapeString($val){
		$val= filter_var($val, FILTER_SANITIZE_STRING);

		//include php code

		include('dbConnect.php');
		//sanitize data going into MySQL

		$val= mysqli_real_escape_string($mysqli, $val);
		return $val;
	}//end of function escapeString
	
	//function to delete the existing availbility in the database for a specific date and re-enter the new availability
	//This had to be done to prevent possible complications using an update query on a many to one database table.
	function deleteAvail($pID){
		global $feedback;
		global $count; 
		
		//make connection to database
		require('dbConnect.php');
		
		//create sql string to delete all availability for the postID
		if($stmt=mysqli_prepare($mysqli, "DELETE FROM tblavailability WHERE postID=?")){
			//bind parameters
			mysqli_stmt_bind_param($stmt, "i", $pID);
			
			//execute mysqli statement
			if(mysqli_stmt_execute($stmt)){
				return true;
			}else{
				$feedback.="<br/> An error occured. Please contact an administrator for assitance.";
				$count++;
				return false;
			}//end of execute
		}//end of if-stmt
	}//end of deleteAvail
	
	function insertDays($pID, $availability){
		//get global variables to do stuff, I'm so tired of looking at code. 
		global $feedback; 
		global $count; 
		global $success;
		
		//find length of array
		$len=count($availability);
		
		for($i=0; $i<$len; $i++){
			
			$dA=$availability[$i];

		//make connection to db
		require('dbConnect.php');
			if($stmt=mysqli_prepare($mysqli,
			"INSERT INTO tblavailability(postID, daysAvailable) VALUES(?, ?)")){
				//bind variables
				
				mysqli_stmt_bind_param($stmt, "is", $pID, $dA);
				
				//execute stmt
				if(mysqli_stmt_execute($stmt)){
					$success.="<p>Availablility updated!</p>";
				}else{
					printf("Error #%d: %s.\n", mysqli_stmt_errno($stmt), mysqli_stmt_error($stmt));
					$feedback.="<p>Availability not entered into database. Please contact an administrator for assitance.</p>";
					$count++;
				}
			}//end of if-stmt
		}//end of for loop
	}//end of function insertDays
	
	function updateTernary($pID, $sType){
		global $feedback;
		global $count; 
		global $success;
		
		//make connection to database
		require('dbConnect.php');
		
		//create sql string
		if($stmt=mysqli_prepare($mysqli, 
		"UPDATE tblpostcreation SET serviceID=? WHERE postID=?")){
			//bind variables
				
				mysqli_stmt_bind_param($stmt, "ii", $sType, $pID);
				
				//execute stmt
				if(mysqli_stmt_execute($stmt)){
					$success.="<p>Service posting updated!</p>";
				}else{
					$feedback.="<p>Availability not entered into database. Please contact an administrator for assitance.</p>";
					$count++;
				}
		}//end of if-stmt
	}//end of updateTernary
	
	function updatePost($pID, $pC, $pricing, $pDesc){
		global $feedback;
		global $count;
		
		//make connection to db
		require('dbConnect.php');
		
		//create sql string
		if($stmt=mysqli_prepare($mysqli, 
		"UPDATE tblserviceposting SET postCode=?, pricing=?, description=? WHERE postID=?")){
			//bind entered parameters to mysqli statement
			mysqli_stmt_bind_param($stmt, "sdsi", $pC, $pricing, $pDesc, $pID);
			
			//execute mysqli statement
			if(mysqli_stmt_execute($stmt)){
				return true;
			}else{
				$feedback.="<br/> An error occured. Please contact an administrator for assitance.";
				$count++;
				return false;
			}//end of execute
		}//end of if-stmt
	}//end of function updatePost
	
	function sanitize($pC, $sT, $dA, $p, $eD){
		//sanitize form data
		$pC= filter_var($pC, FILTER_SANITIZE_STRING);
		$sT= filter_var($sT, FILTER_SANITIZE_STRING);
		$dA= filter_var($dA, FILTER_SANITIZE_STRING);
		$p= filter_var($p, FILTER_SANITIZE_STRING);
		$eD= filter_var($eD, FILTER_SANITIZE_STRING);
		
		//include escape string function here, this uses the mysqli escape string to prevent special characters from being entered into the db
		escapeString($pC);
		escapeString($sT);
		escapeString($dA);
		escapeString($p);
		escapeString($eD);
	}//end of sanitize
	
	function saveImages($pID){
		global $feedback; 
		global $count; 
		global $success; 
		global $random;
		
		//connect to db server and select db
		require("dbConnect.php");
		
		//code adapted from: https://www.youtube.com/watch?v=DL8LT8beVU0
		//code author: 616jk
		//accessed on: 29/03/2019
		for($i=0; $i<count($_FILES['fileUpload']['name']); $i++)
		{
			
			if((($_FILES['fileUpload']['type'][$i] == 'image/jpg')||
			($_FILES['fileUpload']['type'][$i] == 'image/jpeg')||
			($_FILES['fileUpload']['type'][$i] == 'image/pjpeg')||
			($_FILES['fileUpload']['type'][$i] == 'image/bmp')||
			($_FILES['fileUpload']['type'][$i] == 'image/png'))
			&&
			($_FILES['fileUpload']['size'][$i]<1000000))
			{
				$uploadedFile = $_FILES['fileUpload']['name'][$i]."(".$_FILES['fileUpload']['type'][$i].",".ceil($_FILES['fileUpload']['size'][$i]/1024).")Kb"."<br />";
			}
				move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i],'uploads/'.$random.$_FILES['fileUpload']['name'][$i]);

			$imageName= $random.$_FILES['fileUpload']['name'][$i];
			
			//store filename in database
			if ($stmt = mysqli_prepare($mysqli,
				"INSERT INTO tblimages(imageName, postID)
				VALUES(?, ?)")){
				
				//Bind parameters to SQL Statement Object
				mysqli_stmt_bind_param($stmt, "si", $imageName, $pID);
				
				//Execute statement object and check if successful
				if(mysqli_stmt_execute($stmt)){
					$success.= "<p>Attached Images Saved Successfully!</p>";
				
				}else{
					$feedback= "<br/>Images Saved Unsuccessfully. Please contact a technician.";
					$count++;
				}//end of feedback if else 
				
			}//end mysqli prepare statement
		}//end of for loop
	}//end of function save images
	
	function validate($pC, $sT, $dA, $p, $eD){
		global $feedback; 
		global $count; 
		
		//start of post code validation
		if($pC=="" || $pC==null){
			$count++;
			$feedback.="<br/> You must enter a post code!";
		}
		
		if(!ctype_alpha($pC)){
			$count++;
			$feedback.="<br/> Your post code can only contain letters!";
		}
		
		if(strlen($pC)>4){
			$count++;
			$feedback="<br/> Your post code cannot be more than 4 characters!";
		}//end of post code validation
		
		//start of sitterType validation
		if($sT=="" || $sT==null){
			$count++;
			$feedback.="<br/> You must select a sitter type!";
		}//end of sitterType validation
		
		//start of daysAvailable validation
		if(!$dA){
			$count++;
			$feedback.="<br/> You must enter the days you are available!";
		}//end of days available validation
		
		//price validation
		if($p==0 || $p==null){
			$count++;
			$feedback.="<br/> You must enter your hourly rate!";
		}
		
		if(!ctype_digit($p)){
			$count++;
			$feedback.="<br/> You must enter a digit as your rate!";
		}//end of price validation
		
		if($eD=="" || $eD==null){
			$count++;
			$feedback.="You must enter your extra details to let users know about the services you intent to provide!";
		}
		
		if(strlen($eD)>1000){
			$count++;
			$feedback.="Your description cannot be more than 1000 characters!";
		}
	}//end of function validate
	
	function validateImages(){
		global $feedback;
		global $count; 
		
		//file validation
		
		if(count($_FILES['fileUpload']['name'])>5){
			$feedback.="<br/> You can only attach 5 images";
			$count++;
		}
		
		if(count($_FILES['fileUpload']['name'])<2){
			$feedback.="<br/> You must attach atleast 2 images";
			$count++;
		}
		
		if(count($_FILES['fileUpload']['name'])>=2){
			//code adapted from:https://www.w3schools.com/php/php_file_upload.asp
			//accessed on: 26/03/2019
			$allowed =  array('jpeg', 'png', 'jpg', 'bmp', 'pjpeg', 'JPEG', 'PNG', 'JPG', 'BMP', 'PJPEG');
			
			for($i=0; $i<count($_FILES['fileUpload']['name']); $i++)
			{
			$path = $_FILES['fileUpload']['name'][$i];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
				if(!in_array($ext,$allowed)){
					$feedback.="<br/> Image uploaded is not of type: .jpg, .jpeg, .bmp, .pjpeg or .png";
					$count++;
				}//end of if
			}//end of loop
		}//end fo else-if
	}//end of function validateImages
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
		<h1>Post Edit</h1>
		<div>
			<a class="BreadEff" href="sitterDash.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="viewMemberPosts.php"> View Member Posts</a> &raquo;
			<a class="BreadEff" href="editPost.php"> Edit Post</a>
			
	    </div>
		<br/>
		<h6>You can edit your existing posts using this form! Please ensure the information you enter is factual and honest so consumers can have confidence in 
		requesting your services!</h6>
		<h3>Post Details:</h3>
		<?php
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
		
			<?php
			
				//get passed id and do query to pull of the the post information
				global $pID; 
				
				//declare variables for the query
				$postCode="";
				$pricing=0.0;
				$desc="";
				$sType="";
				$sDAvail=array();
				$rows="";
				$serviceID=0;
				$avail="";
				//make connection to database
				require('dbConnect.php');
				
				//create sql query for text form fields
				if($stmt=mysqli_prepare($mysqli, 
				"SELECT DISTINCT tblserviceposting.postCode, tblserviceposting.pricing, tblserviceposting.description, tblservice.serviceName, tblservice.serviceID
				FROM tblserviceposting, tblpostcreation, tblservice
				WHERE tblserviceposting.postID= tblpostcreation.postID
				AND tblpostcreation.serviceID=tblservice.serviceID
				AND tblserviceposting.postID=?
				")){
					//bind parameters for the query
					mysqli_stmt_bind_param($stmt, "i", $pID);
					
					//execute query
					if(mysqli_stmt_execute($stmt)){
						
						//bind results to variables
						mysqli_stmt_bind_result($stmt, $postCode, $pricing, $desc, $sType, $serviceID);
						
						//create form
						if(mysqli_stmt_fetch($stmt)){
							
							echo"<form name='pCreate' action='editPost.php' method='post' class='form-horizontal' onsubmit='return postVal(this)'>
							
							<fieldset>
							<legend>Location and Type of Sitter:</legend>
							<!--Post code form field-->
							<div class='form-group'> 
								<label class='control-label'>Post Code:</label>
							 <div class='col-sm-10'>

								<input type='text' class='form-control' name='pCode' id='pCode' aria-labelledby='pCode' value='$postCode'/> 
							 </div>
							 <span id='pcode_err'></span>
							</div>
							<!--Sitting Type Form Field-->
							";
							
							
							//This php script is for a database select to pull values from the tblServices table to populate a select box. 
							//call global variables
							global $sID; 
							global $sName; 
							//make connection to database
							require('dbConnect.php');
							
							//create sql string
							if($stmt=mysqli_prepare($mysqli, 
							"SELECT * FROM tblService")){
								//execute mysqli-stmt
								mysqli_stmt_execute($stmt);
								
								//bind results from stmt execution
								mysqli_stmt_bind_result($stmt, $sID, $sName);
								
								//echo start of select box
								echo"<div class='form-group'>
										<label class='control-label'>Sitting Type:</label>
										<div class='col-sm-10'>
										<select class='form-control' name='sitterType' id='sitterType' aria-labelledby='sitterType'>";
								
								//fetch results and display in selectbox
								while(mysqli_stmt_fetch($stmt)){
									//this echo contains the actual stmt records echoed out as html
									echo"
										<option value='$sID'>$sName</option>
									";//end of echo
								}//end of while
								//this echo contains the ending of the select box
								echo"<option value='$serviceID' selected>$sType</option>
											</select>
										</div>
										<span id='sitter_err'></span>
									</div>";
							}//end of mysqli-stmt
							
							//this php script is to help with populating the checkboxes 
							require('dbConnect.php');
							
							/*
							Okay, so the reference list for those 4 lines of code is massive. 
							
							Original Idea: 
							Code Adapted from: https://stackoverflow.com/questions/34448794/showing-checked-checkbox-from-database-for-editing
							Code Author: Rajdeep Paul
							Code Accessed on: 31 Mar 2019
							
							Code Troubleshooting:
							Code Adapted from: https://stackoverflow.com/questions/38919714/using-bind-param-with-mysqli-query
							Code Author:Barmar
							Code Accessed on: 31 Mar 2019
							
							Code Change from stock SQL to MySQLi with prepared statements
							Code Adapted from: https://stackoverflow.com/questions/17013426/prepared-statements-fetch-assoc-php-mysqli
							Code Author: Your Common Sense 
							Code Accessed on: 31 Mar 2019
							
							*/
							
							$stmt= mysqli_prepare($mysqli, "SELECT daysAvailable FROM tblavailability WHERE tblavailability.postID=?");
							mysqli_stmt_bind_param($stmt, "i", $pID);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_bind_result($stmt, $avail);
							//$result=$stmt->get_result();
							while(mysqli_stmt_fetch($stmt)){
								$sDAvail[]=$avail;
							}
						
							
						echo"	
							
						</fieldset>
						
						<fieldset>
							<legend>Day Availability and Pricing:</legend>
							<!--Availability Checkboxes-->
							<div class='form-group'>
							<label class='control-label'>Day Availability:</label>
							<br/>
							<div class='col-sm-10'>
								<div> <label class='control-label'>
									Monday:
										<input type='checkbox' name='dAvail[]' value='Monday' id='Monday' "; if(in_array("Monday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Monday'/>
									</label>
								</div>
								
								<div> <label class='control-label'>
									Tuesday:
										<input type='checkbox' name='dAvail[]' value='Tuesday' id='Tuesday' "; if(in_array("Tuesday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Tuesday'/>
									</label>
								</div>
								
								<div> <label class='control-label'>
									Wednesday:
										<input type='checkbox' name='dAvail[]' value='Wednesday' id='Wednesday'"; if(in_array("Wednesday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Wednesday'/>
									</label>
								</div>
								
								<div> <label class='control-label'>
									Thursday:
										<input type='checkbox' name='dAvail[]' value='Thursday' id='Thursday'"; if(in_array("Thursday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Thursday'/>
									</label>
								</div>
								
								<div> <label class='control-label'>
									Friday:
										<input type='checkbox' name='dAvail[]' value='Friday' id='Friday'"; if(in_array("Friday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Friday'/>
									</label>
								</div>
								
								<div> <label class='control-label'>
									Saturday:
										<input type='checkbox' name='dAvail[]' value='Saturday' id='Saturday'"; if(in_array("Saturday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Saturday'/>
									</label>
								</div>
								
								<div> <label class='control-label'>
									Sunday:
										<input type='checkbox' name='dAvail' value='Sunday' id='Sunday'"; if(in_array("Sunday", $sDAvail)){ echo " checked=\"checked\""; } echo" aria-labelledby='Sunday'/>
									</label>
								</div>
								<span id='avail_err'></span>
							</div>
							<br/>
							<!--Prices-->
							<div class='form-group'>
								<div class='col-sm-10'>
									<label class='form-control' for='price'>Price per Hour: $
											<input type='number' name='price' id='price' value='$pricing' min='10' max='1000' aria-labelledby='price'/> per hour.
									</label>
									<span id='price_err'></span>
								</div>
							</div>
							</div>
						</fieldset>	
						
						<fieldset>
							<legend>Extra Information:</legend>
							<!--Extra Details-->
							
							<!--
								Code Adapted from: https://mdbootstrap.com/components/bootstrap-textarea/
								Code Author: mdbootstrap.com
								Code Accessed On: 01/03/2019
							-->

							<div class='form-group green-border-focus'>
									<div class='col-sm-10'>
										<label class='control-label'>Personal Description:</label>

										<textarea class='form-control' name='eDesc' id='eDesc' rows='3' aria-labelledby='eDesc'>$desc</textarea>
										<span id='desc_err'></span>
									</div>
							</div>
							</fieldset>
							 <div class='col-sm-10'>
								 <input type='hidden' name='pID' value=$pID>
								<input type='submit' class='btn btn-primary form-control' name='submit' value='Edit Details'/>
							</div>
							<br/>
							
				</form><hr/>";
			}//end of fetch
		}//end of execute

	}//end of if-stmt
	
			echo"
			<h3>Post Images:</h3>
					<h6>You're free to re-upload your images here! Using this function will delete all existing images and upload your selected images to take their place, 
					please be mindful of this when you upload your images through here.</h6>
			";
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
						
						
						echo"<h4 class='card-title'>Your Uploaded Images:</h4>";
						
						while(mysqli_stmt_fetch($stmt)){
							echo"
							
							<img src='uploads/$imgName' style='width:200px; height:200px;' alt='uploaded picture'/>
							
							";
						}//end of while
						
					echo"
					<br/>
					<br/>
					<h4>Reupload Images Here:</h4>
					 <form class='form-horizontal' method='post' action='editPost.php' enctype='multipart/form-data'>
						<div class='form-group'> 
						<label class='control-label'>Select Images to Upload (Optional, 2 min, 5 max):</label>
							<div class='col-sm-10'>
								<!--Code Adapted from:http://www.javascripthive.info/php/php-multiple-files-upload-validation/-->
								<!--Accessed on: 26/11/2017-->
								<input type='file' class='form-control' name='fileUpload[]' id='fileUpload' aria-labelledby='fileUpload' multiple/> 
							</div>
						</div>
						 <div class='col-sm-10'>
						<input type='hidden' name='pID' value=$pID>
						<input type='submit' class='btn btn-primary form-control' name='submitImage' value='Re-Upload Images'/>
						</div>
					 </form>
					 <br/>
						";
						
					}else{
						
						echo"<hr/><p>This post has no uploaded images.</p>";
					}
					
				}else{
					echo"<p class='error'>A database error occured while trying to display this. Please contact an administrator for assistance.</p>";
				}
				
			}//end of if-stmt
			
			
			 ?>
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
