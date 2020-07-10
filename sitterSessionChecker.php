<?php
    session_start();
	if($_SESSION['pos']!="2"){
		
		Header("Location:login.php?feedback=You must be a logged in sitter to access this page...");
		
	}
?>