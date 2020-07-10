<?php
session_start();
//output buffers tuff for the cookie thing
ob_start();
$feedback="";
$success="";
$count=0; 
$sID=0;
$sName="";
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
    <!-- Header with Background Image -->
    <header class="search">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
          </div>
        </div>
      </div>
    </header>
	
	
	<!--Login Form-->
	<div class="container col-sm-10">
	<br/>
	<h1>Sitter Search</h1>
	<div>
			<a class="BreadEff" href="index.php"> Homepage</a> &raquo;
			<a class="BreadEff" href="sitterSearch.php"> Sitter Search</a>
	    </div>
		<br/>
		
		<form name="sitSearch" class="horizontal" method="get" action="sitterSearch.php" onsubmit="return valSearch(this)">

		<div class="form-group">

			<?php
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
						<div class='col-sm-12'>
						<select class='form-control' name='sitterType'>";
				
				//fetch results and display in selectbox
				while(mysqli_stmt_fetch($stmt)){
					//this echo contains the actual stmt records echoed out as html
					echo"
						<option value='$sID'>$sName</option>
					";//end of echo
				}//end of while
				//so this is the weird voodoo code that I had to do to get the cookie to stay
					if(isset($_COOKIE['sType'])){
						$sType=$_COOKIE['sType'];
					
						require('dbConnect.php');
						
						if($stmt=mysqli_prepare($mysqli, 
						"SELECT serviceName FROM tblService WHERE serviceID=?")){
							mysqli_stmt_bind_param($stmt, "i", $sType);
							
							//execute mysqli-stmt
							mysqli_stmt_execute($stmt);
							
							//bind results from stmt execution
							mysqli_stmt_bind_result($stmt, $storedName);
							
							if(mysqli_stmt_fetch($stmt)){
							//this echo contains the ending of the select box
							echo"<option value='$sType' selected>$storedName</option>
								</select>
								</div>
								<span id='sitter_err'></span>
							</div>";
							}
					}else{
						echo"<option value='' selected>---</option>
								</select>
							</div>
							<span id='sitter_err'></span>
						</div>";
					}//end of else		
				}//end of cookie stuff
			}//end of mysqli-stmt
		
		//more cookie stuff to ensure that if a cookie isset populate the field with the previously searched critera
		if(isset($_COOKIE['sLoc'])){
			$sLoc=$_COOKIE['sLoc'];
			echo"
			<div class='form-group'>
				<label class='control-label'>Post Code:</label>
				<div class='col-sm-12'>
					<input type='text' class='form-control' name='sLoc' value='$sLoc' placeholder='Enter sitter post code here, example: SF for San Fernando, MY for Mayaro etc.'/> 
				</div>
				<span id='pcode_err'></span>
			</div>";
		}else{
			echo"
			<div class='form-group'>
				<label class='control-label'>Post Code:</label>
				<div class='col-sm-12'>
					<input type='text' class='form-control' name='sLoc' placeholder='Enter sitter post code here, example: SF for San Fernando, MY for Mayaro etc.'/> 
				</div>
				<span id='pcode_err'></span>
			</div>";
		}
		
			
		?>	
			<!--sorting options-->
			<div class="form-group">
			<label class="control-label">Sorting Options:</label>
			<div class="col-sm-12">
				<div class="checkbox">
				 <label>Show Posts with Images Only </label>
				 <input type="checkbox" name="imgOnly" value="true">
				</div>

				<div class="checkbox">
				 <label>Show Posts without Images</label>
				 <input type="checkbox" name="noImg" value="true">
				</div>
				
				<div class="checkbox">
				 <label>Show recent posts </label>
				 <input type="checkbox" name="older" value="true">
				</div>
				
				<div class="checkbox">
				 <label>Show older posts</label>
				 <input type="checkbox" name="recent" value="true">
				</div>
			</div>
			</div>

			<div class="col-sm-12">
			<input type="submit" class="btn btn-sm btn-primary form-control" name="submitSearch"/>
			</div>
		 </div>
		</form>
		
		<?php
			//global variables
			$pID=0; 
			$pCode="";
			$sName="";
			$image="";
			$date="";
			$imgCount=0;
			$desc=""; 
			
			//pagination stuff
			$perpage=0;
			$curpage=0;
			$start=0;
			$endpage=0;
			$startpage=0;
			$previouspage=0;
			$nextpage=0;
			$total_recs=0;
			
			if(isset($_GET['submitSearch'])){
				$sType=$_GET['sitterType'];
				$sLoc=$_GET['sLoc'];
				//validate entered search stuff
				validate($sLoc, $sType);
				
				//sanitize search stuff
				sanitize($sLoc);
				
				if(isset($_GET['img'])){
					$sql=$_GET['sql'];
					searchResults($sType, $sLoc, $sql);
				}elseif(isset($_GET['noImgs'])){
					$sql=$_GET['sql'];
					searchResultsNoImg($sType, $sLoc, $sql);
				}else{
					
				
				
					if($count==0){
						//create cookie to store search criteria
						//I personally don't understand why this is needed, this would get me annoyed personally but aite.
						createCookie($sType, $sLoc);
						
						
						if(isset($_GET['imgOnly'])){
						//do the search and prepare the freaky voodoo code to echo out the weird stuff this assignment wants.
							$sql="SELECT tblserviceposting.postID, tblserviceposting.description, tblserviceposting.postCode, tblservice.serviceName, tblimages.imageName, tblserviceposting.dateMade, COUNT(tblimages.imageName)
							FROM tblserviceposting, tblservice, tblimages, tblpostcreation
							WHERE tblserviceposting.postID=tblimages.postID
							AND tblserviceposting.postID=tblpostcreation.postID
							AND tblpostcreation.serviceID=tblservice.serviceID
							AND tblservice.serviceID= ? 
							AND tblserviceposting.postCode LIKE ?
							GROUP BY tblserviceposting.postID
							HAVING COUNT(tblimages.imageName)>1";
							
							if(isset($_GET['recent'])){
								$sql=$sql." ORDER BY tblserviceposting.dateMade ASC";
								searchResults($sType, $sLoc, $sql);
							}elseif(isset($_GET['older'])){
								$sql=$sql." ORDER BY tblserviceposting.dateMade DESC";
								searchResults($sType, $sLoc, $sql);
							}else{
								searchResults($sType, $sLoc, $sql);
							}
							
						}elseif(isset($_GET['noImg'])){
							$sql="SELECT tblserviceposting.postID, tblserviceposting.description, tblserviceposting.postCode, tblservice.serviceName, tblserviceposting.dateMade
							FROM tblserviceposting, tblservice, tblpostcreation
							WHERE tblserviceposting.postID=tblpostcreation.postID
							AND tblpostcreation.serviceID=tblservice.serviceID
							AND tblserviceposting.postID NOT IN (SELECT tblimages.postID FROM tblimages, tblserviceposting WHERE tblimages.postID=tblserviceposting.postID)
							AND tblservice.serviceID=?
							AND tblserviceposting.postCode LIKE ?
							GROUP BY tblserviceposting.postID";
							
							if(isset($_GET['recent'])){
								$sql=$sql." ORDER BY tblserviceposting.dateMade ASC";
								searchResultsNoImg($sType, $sLoc, $sql);
							}elseif(isset($_GET['older'])){
								$sql=$sql." ORDER BY tblserviceposting.dateMade DESC";
								searchResultsNoImg($sType, $sLoc, $sql);
							}else{
								searchResultsNoImg($sType, $sLoc, $sql);
							}
							
						}else{
							$sql="SELECT tblserviceposting.postID, tblserviceposting.description, tblserviceposting.postCode, tblservice.serviceName, tblimages.imageName, tblserviceposting.dateMade, COUNT(tblimages.imageName)
							FROM tblserviceposting, tblservice, tblimages, tblpostcreation
							WHERE tblserviceposting.postID=tblimages.postID
							AND tblserviceposting.postID=tblpostcreation.postID
							AND tblpostcreation.serviceID=tblservice.serviceID
							AND tblservice.serviceID= ? 
							AND tblserviceposting.postCode LIKE ?
							GROUP BY tblserviceposting.postID
							HAVING COUNT(tblimages.imageName)>1";
							
							if(isset($_GET['recent'])){
								$sql=$sql." ORDER BY tblserviceposting.dateMade ASC";
								searchResults($sType, $sLoc, $sql);
							}elseif(isset($_GET['older'])){
								$sql=$sql." ORDER BY tblserviceposting.dateMade DESC";
								searchResults($sType, $sLoc, $sql);
							}else{
								searchResults($sType, $sLoc, $sql);
							}//end of else
						}//end of else
					}//end of count-if
				}//end of else
			}//end of isset
			
		function createCookie($sType, $sLoc){
			//define the duration for keeping the cookie on the user's machine
		define("DURATION", 60 * 60 * 24 * 5);
		
		//set cookie
		setcookie("sType", $sType, time() + DURATION);
		setcookie("sLoc", $sLoc, time() + DURATION);
		}//end of function createCookie	
			
		//this function peforms the search pulling images and displaying a thumbnail
		function searchResults($sType, $sLoc, $sql){
			global $feedback;
			global $count;
			global $pID;
			global $pCode;
			global $sName;
			global $image;
			global $date;
			global $imgCount;
			global $desc;
			
			global $perpage;
			global $curpage;
			global $start;
			global $endpage;
			global $startpage;
			global $previouspage;
			global $nextpage;
			global $total_recs;
			
			//this put the %'s around the search string for the LIKE SQL keyword
			$searchLocation="%".$sLoc."%";
			
			//make connection to db
			require('dbConnect.php');
			
			/*
			Adapted from:
			http://codingcyber.org/simple-pagination-script-php-mysql-5882/
			Credits:Vivek Vengala
			Accssed on: 31-03-2018
			
			So from here on is the even weirder voodoo code for the pagination
			*/
			
			//this sets the amount of results per page
			$perpage = 1;
			
			//this gets the page # sent by some forms below
			if(isset($_GET['page']) & !empty($_GET['page'])){
				$curpage = $_GET['page'];
				$sql=$_GET['sql'];
				$sType=$_GET['sitterType'];
				$searchLocation=$_GET['searchLocation'];
			}else{
				$curpage = 1;
			}
			$start = ($curpage * $perpage) - $perpage;

			//do sql query to get the length of the resultset
			if($stmt=mysqli_prepare($mysqli, $sql)){
				//bind the stuff for the freaky voodoo
				mysqli_stmt_bind_param($stmt, "is", $sType, $searchLocation);
				
				mysqli_stmt_execute($stmt);
		
				/* store result */
				mysqli_stmt_store_result($stmt);
				echo"<p>". mysqli_stmt_num_rows($stmt). " service post(s) found</p>";
				$total_recs = mysqli_stmt_num_rows($stmt);
			}
			
			//this is to set up the actual buttons to click on for the pagination to work
			$endpage = ceil($total_recs/$perpage);
					$startpage = 1;
					$nextpage = $curpage + 1;
					$previouspage = $curpage - 1;
			
			//query to actually show the results
			//sql2 is an appended version of sql that puts a limit onto the SQL search string so that it only displays results as per the $start and $perpage variables
			$sql2=$sql." LIMIT $start, $perpage";
			//create freaky sql to do the freaky echo for the freaky requirement of the freaky assignment. 
			if($stmt=mysqli_prepare($mysqli, $sql2)){
				//bind the stuff for the freaky voodoo
				mysqli_stmt_bind_param($stmt, "is", $sType, $searchLocation);
				
				if(mysqli_stmt_execute($stmt)){
					echo"<h4>Your Search Results:</h4>";
					
					mysqli_stmt_store_result($stmt);

					mysqli_stmt_bind_result($stmt, $pID, $desc, $pCode, $sName, $image, $date, $imgCount);
					
					if(mysqli_stmt_num_rows($stmt)>=1){
					
						while(mysqli_stmt_fetch($stmt)){?>
							
								<div class='col-sm-12'>
									<div class='card container-fluid'>
										<div class='card-body'>
											<h4 class='card-title'><?php echo"$sName, $pCode"?></h4>
											<img src='uploads/<?php echo"$image"?>' style='width:100px; height:100px; '/>
											<p class='card-text'>Date made: <?php echo"$date"?></p>
											<p class='card-text'><?php echo"$desc"?></p>
											<button class='btn btn-primary form-control'><a class='white' href='viewPostDetails.php?id=<?php echo"$pID"?>'>View Details</a></button>
										</div>
									</div>
								</div>
							<br/>
						<?php
						}//end of while
						echo"
							<nav aria-label='Page navigation'>
						  <ul class='pagination'>";
						  if($curpage != $startpage){
							 /*
						  echo"
							<li class='page-item'>
							  <a class='page-link' href='?page=$startpage' tabindex='-1' aria-label='Previous'>
								<span aria-hidden='true'>&laquo;</span>
								<span class='sr-only'>First</span>
							  </a>
							</li>";*/
							/*this echos out the Start button of the pagination with a form that stores hidden variables
							this and the below forms make use of the 'submitSearch' isset to bypass some php reloading that forces the SQL resultset to be lost
							instead of sending a plain request sending in the stuff for the pagination that would force a reload of the page 
							causing the search data sent in from the 'submitStuff' isset to be lost on page reload, this and the below forms pass EVERYTHING
							back to the 'submitStuff' isset and uses the 'img' hidden field to check which function has to run and allow the pagination to work 
							by passing back all the necessary parameters for the search functions to work.
							
							Remember when I said this was freaky voodoo code? I wasn't joking.*/
							echo"<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$previouspage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='img' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>Start</button>
								</form>";
							} 
							
							if($curpage >= 2){

							echo"<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$previouspage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='img' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>$previouspage</button>
								</form>";
							}
							echo"<li class='page-item active'><a class='page-link' href='#'>$curpage</a></li>";
							
							if($curpage != $endpage){
							;
							echo"<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$nextpage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='img' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>$nextpage</button>
								</form>";

							echo"
							<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$endpage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='img' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>Last</button>
								</form>
							
							";
							}
						  echo"</ul>
						</nav>";
					}else{
						echo"<h5>No results found.</h5>";
					}//end of if-else
				}//end of if-execute
			}//end of ifstmt
		}//end of function searchResults
		
		//this function does the same as the above, just without images.
		function searchResultsNoImg($sType, $sLoc, $sql){
			global $feedback;
			global $count;
			global $pID;
			global $pCode;
			global $sName;
			global $date;
			global $desc;
			
			global $perpage;
			global $curpage;
			global $start;
			global $endpage;
			global $startpage;
			global $previouspage;
			global $nextpage;
			global $total_recs;
			
			$searchLocation="%".$sLoc."%";
			
			//make connection to db
			require('dbConnect.php');
			
				/*
			Adapted from:
			http://codingcyber.org/simple-pagination-script-php-mysql-5882/
			Credits:Vivek Vengala
			Accssed on: 31-03-2018
			*/
			
			$perpage = 3;
			if(isset($_GET['page']) & !empty($_GET['page'])){
				$curpage = $_GET['page'];
				$sql=$_GET['sql'];
				$sType=$_GET['sitterType'];
				$searchLocation=$_GET['searchLocation'];
			}else{
				$curpage = 1;
			}
			$start = ($curpage * $perpage) - $perpage;

			//do sql query to get the length of the resultset
			if($stmt=mysqli_prepare($mysqli, $sql)){
				//bind the stuff for the freaky voodoo
				mysqli_stmt_bind_param($stmt, "is", $sType, $searchLocation);
				
				mysqli_stmt_execute($stmt);
		
				/* store result */
				mysqli_stmt_store_result($stmt);
				echo"<p>". mysqli_stmt_num_rows($stmt). " service post(s) found</p>";
				$total_recs = mysqli_stmt_num_rows($stmt);
			}
			
			$endpage = ceil($total_recs/$perpage);
					$startpage = 1;
					$nextpage = $curpage + 1;
					$previouspage = $curpage - 1;
			
			//query to actually show the results
			$sql2=$sql." LIMIT $start, $perpage";
			
			//create freaky sql to do the freaky echo for the freaky requirement of the freaky assignment. 
			if($stmt=mysqli_prepare($mysqli, $sql2)){
				//bind the stuff for the freaky voodoo
				mysqli_stmt_bind_param($stmt, "is", $sType, $searchLocation);
				
				if(mysqli_stmt_execute($stmt)){
					
					echo"<h4>Your Search Results:</h4>";
					
					mysqli_stmt_store_result($stmt);
					
					mysqli_stmt_bind_result($stmt, $pID, $desc, $pCode, $sName, $date);
					
					if(mysqli_stmt_num_rows($stmt)>=1){
					
						while(mysqli_stmt_fetch($stmt)){
							echo"
								<div class='col-sm-12'>
									<div class='card container-fluid'>
										<div class='card-body'>
											<h4 class='card-title'>$sName, $pCode </h4>
											<p class='card-text'>Date made: $date</p>
											<p class='card-text'>$desc</p>
											<button class='btn btn-primary form-control'><a class='white' href='viewPostDetails.php?id=$pID'>View Details</a></button>
										</div>
									</div>
								</div>
							<br/>
							";
						}//end of while
					echo"
							<nav aria-label='Page navigation'>
						  <ul class='pagination'>";
						  if($curpage != $startpage){
							 /*
						  echo"
							<li class='page-item'>
							  <a class='page-link' href='?page=$startpage' tabindex='-1' aria-label='Previous'>
								<span aria-hidden='true'>&laquo;</span>
								<span class='sr-only'>First</span>
							  </a>
							</li>";*/
							echo"<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$previouspage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='noImgs' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>Start</button>
								</form>";
							} 
							
							if($curpage >= 2){
							//echo"<li class='page-item'><a class='page-link' href='?page=$previouspage'>$previouspage</a></li>";
							echo"<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$previouspage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='noImgs' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>$previouspage</button>
								</form>";
							}
							echo"<li class='page-item active'><a class='page-link' href='#'>$curpage</a></li>";
							
							if($curpage != $endpage){
							//echo"<li class='page-item'><a class='page-link' href='?page=$nextpage&amp;sql=$sql&amp;sType=$sType&amp;searchLocation=$searchLocation'>$nextpage</a></li>";
							echo"<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$nextpage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='noImgs' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>$nextpage</button>
								</form>";
							/*
							echo"<li class='page-item'>
							  <a class='page-link' href='?page=$endpage' aria-label='Next'>
								<span aria-hidden='true'>&raquo;</span>
								<span class='sr-only'>Last</span>
							  </a>
							</li>";*/
							
							echo"
							<form action='sitterSearch.php' method='get'>
								<input type='hidden' name='sitterType' value='$sType'/>
								<input type='hidden' name='sLoc' value='$sLoc'/>
								<input type='hidden' name='sql' value='$sql'/>
								<input type='hidden' name='page' value='$endpage'/>
								<input type='hidden' name='searchLocation' value='$searchLocation'/>
								<input type='hidden' name='noImgs' value=''/>
								<button type='submit' 'class='btn btn-link page-item' 
								name='submitSearch'>Last</button>
								</form>
							
							";
							}
						  echo"</ul>
						</nav>";
					}else{
						echo"<h5>No results found.</h5>";
					}//end of if-else
				}//end of if-execute
			}//end of if-stmt
		}//end of function searchResults
			
		function escapeString($val){
			$val= filter_var($val, FILTER_SANITIZE_STRING);

			//include php code

			include('dbConnect.php');
			//sanitize data going into MySQL

			$val= mysqli_real_escape_string($mysqli, $val);
			return $val;
		}//end of function escapeString	
			
		function validate($sLoc, $sType){
		global $feedback;
		global $count; 
		
			//start of sitterType validation
			if($sType=="" || $sType==null){
				$count++;
				$feedback.="<br/> You must select a sitter type!";
			}//end of sitterType validation
		
			if($sLoc=="" || $sLoc==null){
				$feedback.="<p>You must enter a post code to search for!</p>";
				$count++;		
			}
			
			if(strlen($sLoc)>4){
			$count++;
			$feedback="<br/> Your post code cannot be more than 4 characters!";
		}//end of post code validation
			
			if(!ctype_alpha($sLoc)){
				$count++;
				$feedback.="<p>Your post code can only contain letters!</p>";
			}
			
		}//end of function validate
		
		function sanitize($sLoc){
			//sanitize form data
		$sLoc= filter_var($sLoc, FILTER_SANITIZE_STRING);
		
		//include escape string function here, this uses the mysqli escape string to prevent special characters from being entered into the db
		escapeString($sLoc);
		}//end of function sanitize
			
			//feedback code for errors
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
		
		ob_end_flush();
		?>
		
		
	</div>
	</div>
	
	<br/>
	<br/>
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
