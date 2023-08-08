

<meta charset="utf-8" />
<?php
	$host= 'localhost';
	$username= 'root';
	$password='';
	$db_name='ctrlSys';
	
	$conn= mysqli_connect($host,$username,$password,$db_name);
			mysqli_set_charset($conn,"utf8");
			
			if(!$conn){
				
				echo mysqli_connect_error("خطأ في الاتصال") . mysqli_connect_errno();

			
			}
			
			function close_db(){
			global $conn;
			mysqli_close($conn);}

?>