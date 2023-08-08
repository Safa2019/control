

<?php

include_once('confg.php');
session_start();
ob_start();

if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$email = $_POST['email'];
	$manager = $_POST['manager'];
	$organ = $_POST['organ'];
	$date= date("Y-m-d");
	$empName=$_POST['empName'];
	
	if( (!empty($username)) && (!empty($email)) && (!empty($manager)) &&  (!empty($organ)) && (!empty($_POST['password']))){
	
	
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				
				echo '<div class="alert alert-danger" role="alert">البريد الالكتروني غير صحيح </div>';
				
				
			}else{
				
				$sql_organ = mysqli_query($conn, "SELECT `organ_name` FROM `organization` WHERE `organ_name` = '$organ' ");		
				$sql_email = mysqli_query($conn,"SELECT `email` FROM `users` WHERE `email` = '$email'");
				$sql_username = mysqli_query($conn,"SELECT `username` FROM `users` WHERE `username` = '$username'");
				
				if(mysqli_num_rows($sql_organ) > 0 ){					   
					echo '<div class="alert alert-danger" role="alert">عذراَ،اسم المنظمة مسجل بالفعل </div>';
				}else if(mysqli_num_rows($sql_email) > 0 ){					   
					echo '<div class="alert alert-danger" role="alert">عذرا، البريد الالكتروني مسجل بالفعل</div>';	
				}else if(mysqli_num_rows($sql_username) > 0 ){					   
					echo '<div class="alert alert-danger" role="alert">عذرا، اسم المستخدم مسجل بالفعل</div>';					   
				}else{ 
					$password = $_POST['password'];
					//insert into organization table
					$insert1 = "INSERT INTO `organization` (`organ_name` ,`manager`, `empNo`, `date_reg`) 
					VALUES ('$organ','$manager',1,'$date');" ;
					$insert_sql1 = mysqli_query($conn,$insert1);
					//retrieve id 
					$organs = mysqli_query($conn , "SELECT * FROM `organization`  WHERE '$organ' = `organ_name` ");
					$organ_row = mysqli_fetch_assoc($organs);
					$organ_id = $organ_row['organ_id'];
				
					//insert user
					$insert2 = "INSERT INTO `users` (`username` ,`email`, `password`,`reg_date`,`role`,`organ_id`, `manager`, `empName`) 
					VALUES ('$username','$email','$password','$date','admin','$organ_id','$manager', '$empName');" ;

					
					$insert_sql2 = mysqli_query($conn,$insert2);
					
					if(isset($insert_sql1 ) && isset($insert_sql1 )){
											
						$user_info = mysqli_query($conn,"SELECT * FROM `users` WHERE `username` = '$username' ");
						$user = mysqli_fetch_assoc($user_info);
						$_SESSION['id'] = $user['user_id'];
						$_SESSION['user'] = $user['username'];
						$_SESSION['email'] = $user['email'];
						$_SESSION['date'] = $user['reg_date'];
						$_SESSION['role'] = $user['role'];
						$_SESSION['manager'] = $user['manager'];
						$_SESSION['organ_id'] = $user['organ_id'];
						$_SESSION['empName'] = $user['empName'];
						echo '<div class="alert alert-success" role="alert">تم تسجيلك بنجاح جاري تحويلك للصفحة الرئيسية</div>';
						echo '<meta http-equiv="refresh" content="2; \'../homeControlPage.php\'  " />';
						
						
							
						
					}
					
				
				
				
			}
		
		}
	
	}

}

?>