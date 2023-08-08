<?php
  
   include_once('confg.php');
   session_start();
   
   

  if(isset($_POST['login_btn'])){
 
	
	$user = stripcslashes(mysqli_real_escape_string($conn,$_POST['user']));
	$password = $_POST['password'];
			
	if((!empty($user)) && (!empty($_POST['password'])) ){

		$sql = mysqli_query($conn, " SELECT * FROM `users` WHERE `username` = '$user' OR `email` ='$user'  AND  `password` ='$password' ");	
		
		if(mysqli_num_rows($sql) !=1){
			 echo '<div class="alert alert-danger" role="alert">اسم الدخول او كلمة المرور غير صحيحة </div>';
			
		}else{
		    $user = mysqli_fetch_assoc($sql);
		    $_SESSION['id'] = $user['user_id'];
			$_SESSION['user'] = $user['username'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['date'] = $user['reg_date'];
			$_SESSION['role'] = $user['role'];
			$_SESSION['organ_id'] = $user['organ_id'];
			$_SESSION['empName'] = $user['empName'];
			echo '<div class="alert alert-success" role="alert">تم سجيل الدخول </div>';
			echo '<meta http-equiv="refresh" content="0.5; \'..\session.php\'  " />';

		}
	
	
    }
 } 

?>
