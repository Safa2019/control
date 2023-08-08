<?php 
session_start(); 
include_once("include/confg.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Control System</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid" dir= "rtl">
        <a class="navbar-brand" href="#">نظام الرقابة الداخلي</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <?php
                $sql = mysqli_query($conn , "SELECT * FROM `users` u WHERE '$_SESSION[id]' = u.user_id ");
                $user = mysqli_fetch_assoc($sql);
                echo '
                <a class="nav-link active" aria-current="page" href="#"> أهلا  '.$user['empName'].'</a>';?>
            </li>

            <li class="nav-item">
            <?php
            echo '
            <a class="nav-link" href="signout.php?id" '.$_SESSION['id'].' ">تسجيل الخروج</a>
            ';
            ?>
            </li>
        </ul>
        <form class="d-flex" style= "   display: flex!important;
                                        gap: 10px;
                                        margin-right: 200px;
                                        margin-top: 20px;
                                        margin-left:-200px;
                                        justify-content: flex-end;">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">بحث</button>
        </form>
        </div>
    </div>
</nav>

<section class="container-fluid" dir="rtl" style="margin-top:30px;">
    <div class="row">
    <aside class="col-lg-3" >
		<div class="list-group">
        <a href="homeControlPage.php" class="list-group-item"> <i class="fas fa-eye"></i> الإجمالي</a>
        <a href="employees.php" class="list-group-item"><i class="fa fa-user "></i> موظف جديد </a>
        <a href="addTask.php" class="list-group-item"><i class="fa fa-file "></i> مهمة جديدة</a>
        <a href="tasks.php" class="list-group-item"><i class="fas fa-archive"></i> جميع المهام</a>
        <a href="taskRecord.php" class="list-group-item"><i class="fa fa-book	"></i> سجل المهمة</a>
		</div>
	</aside>


<?php 

// variable declaration
    $msg='';
	$username = '';
	$email    = '';
	$password='';
    $reg_date=date("Y-m-d");
	$role='user';
    $empName='';

    
    $sql = mysqli_query($conn , "SELECT * FROM `users` u WHERE '$_SESSION[id]' = u.user_id ");
    $user = mysqli_fetch_assoc($sql);
    $organ_id = $user['organ_id'];
    $manager=$user['manager'];

    if(isset($_POST['addEmp'])){
		$username = $_POST['username'];
		$password=$_POST['password'];
        $empName=$_POST['empName'];
        $email = $_POST['email'];
        if(empty($username)){
			$msg= '<div class="alert alert-danger" role="alert">الرجاء ادخال اسم المستخدم</div>';
        }elseif(empty($password)){
            $msg= '<div class="alert alert-danger" role="alert">الرجاء ادخال كلمة المرور</div>';
        }elseif(empty($empName)){
            $msg= '<div class="alert alert-danger" role="alert">الرجاء إدخال اسم الموظف</div>';
        }elseif(empty($email)){
            $msg= '<div class="alert alert-danger" role="alert">الرجاء إدخال البريد الالكتروني </div>';       
        }else{
            //////////////////////////////////////////
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){				
				echo '<div class="alert alert-danger" role="alert">البريد الالكتروني غير صحيح </div>';	
			}else{					
				$sql_email = mysqli_query($conn,"SELECT `email` FROM `users` WHERE `email` = '$email'");
				$sql_username = mysqli_query($conn,"SELECT `username` FROM `users` WHERE `username` = '$username'");
				
				if(mysqli_num_rows($sql_email) > 0 ){					   
					$msg= '<div class="alert alert-danger" role="alert">عذرا، البريد الالكتروني مسجل بالفعل</div>';	
				}else if(mysqli_num_rows($sql_username) > 0 ){					   
					$msg= '<div class="alert alert-danger" role="alert">عذرا، اسم المستخدم مسجل بالفعل</div>';					   
				}else{ 
            
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $empName = $_POST['empName'];
                    $email = $_POST['email'];
                        
                    $insert1 = mysqli_query($conn, "INSERT INTO `users` (`username` ,`email`, `password` ,`reg_date`,`role`,`organ_id`,`manager`,`empName`) 
                    VALUES ('$username','$email','$password','$reg_date','user','$organ_id',' $manager','$empName')");

                    $select_empNo = mysqli_query($conn , "SELECT  `empNo` FROM `organization`  WHERE '$organ_id' = `organ_id` ");
                    $organ_emp_no = mysqli_fetch_assoc($select_empNo);
                    $empNo= $organ_emp_no['empNo'];
                    $empNo++;

                    $update_one ="UPDATE `organization` SET `empNo`='$empNo'
                    WHERE `organ_id`='$organ_id' ";
                    $update1_sql = mysqli_query($conn , $update_one);

                    if(isset($insert1) && isset($update1_sql)){
                        $msg= '<div class="alert alert-success" role="alert"> تم إضافة الموظف بنجاح</div>';
                        echo '<meta http-equiv="refresh" content="3; \'employees.php\'">';
                    }
                }
            }
        }
    }
?>
<article class="col-lg-9" >
    <div class="row">
        <div class="col-md-8">		
            <?php echo $msg; ?>
                <div class="panel panel-info">
                    <div class="panel-heading">إضافة موظف جديد</div>
                        <div class="panel-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    
                                    <div class="col-sm-8">
                                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="ادخل اسم المستخدم"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                
                                    <div class="col-sm-8">
                                        <input type="text" name="empName" class="form-control" value="<?php echo $empName; ?>" placeholder="أدخل اسم الموظف "/>
                                    </div>
                                </div>

                                
                                <div class="form-group">            
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="أدخل البريد الالكتروني  "/>
                                    </div>
                                </div>

                                <div class="form-group">
                            
                                    <div class="col-sm-8">
                                        <input type="password" name="password" class="form-control" placeholder="ادخل كلمة المرور"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <input type="submit" name="addEmp" class="btn btn-info" value="إضافة موظف"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</article>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>