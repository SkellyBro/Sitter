<?php
    session_start();
	if($_SESSION['pos']!="1"){
		
		Header("Location:login.php?feedback=You must be a logged visitor to access this page...");
	}
?>