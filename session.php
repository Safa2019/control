<?php 
	session_start();
	include_once("include/confg.php");
	if(isset($_SESSION['id'])){
		// $sql = mysqli_query($conn , "SELECT * FROM `users` WHERE `user_id`='$_SESSION[id]' AND `role`='admin' OR 'writer'");
		// if(mysqli_num_rows($sql) != 1){
		// 	header("Location:homeControlPage.php");
		// }	
		if( $_SESSION['role']=='admin'){
			header("Location:homeControlPage.php");
		}else{
			header("Location:homePage.php");
		}		
	}else{
		header("Location:index.php");

	}
	
	
?>