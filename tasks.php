<?php include_once("include/confg.php");
    session_start(); 
    $msg = '';
	if(isset($_GET['delete'])){
        $sql = mysqli_query($conn , "SELECT * FROM `users` u WHERE '$_SESSION[id]' = u.user_id ");
        $user = mysqli_fetch_assoc($sql);
        $organ_id = $user['organ_id'];

		$sql = mysqli_query($conn, "DELETE FROM `tasks` WHERE `task_id` ='$_GET[delete]'");

        $select_taskNo = mysqli_query($conn , "SELECT  `taskNo` FROM `organization`  WHERE '$organ_id' = `organ_id` ");
        $organ_task_no = mysqli_fetch_assoc($select_taskNo);
        $taskNo= $organ_task_no['taskNo'];
        $taskNo--;

        $update_one ="UPDATE `organization` SET `taskNo`='$taskNo'
        WHERE `organ_id`='$organ_id' ";
        $update1_sql = mysqli_query($conn , $update_one);
			
		if(isset($sql)){
			$msg = '<div class="alert alert-success" role="alert"> تم حذف المهمة بنجاح</div>';
			}
	}
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

<article class="col-lg-9" >
		<hr/>
		<div class="row">
            <div class="col-md-12">	
                <div class="panel panel-info">
                    <div class="panel-heading"><b>المهام</b></div><br>
                        <table class="table table-hover">
                            <thead>
                                <tr>		
                                    <th>#</th>
                                    <th>عنوانها</th>
                                    <th>الموظف المسؤول</th>
                                    <th>عدد الأيام المتبقية</th>
                                    <th>حالتها</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $tasks = mysqli_query($conn , "SELECT * FROM `tasks` WHERE '$_SESSION[organ_id]' = `organ_id`");
                                    $num = 1;
                                    while($task = mysqli_fetch_assoc($tasks)){
                                        $future = strtotime($task['deadline']);
                                        $now = time();
                                        $timeleft = $future-$now;
                                        $daysleft = round((($timeleft/24)/60)/60);
                                        if( $daysleft<0){
                                            $daysleft=0; 
                                        }
                                        echo '
                                        <tr>
                                            <td>'.$num.'</td>
                                            <td>'.$task['title'].'</td>
                                            <td>'.$task['empRes'].'</td>
                                            <td>'. $daysleft.' يوم </td>
                                            <td>'.$task['status'].'</td>
                                            <td><a href="editTask.php?task='.$task['task_id'].'" class="btn btn-warning btn-xs">تعديل</a></td>
                                            <td><a href="tasks.php?delete='.$task['task_id'].'" class="btn btn-danger btn-xs">حذف</a></td>
                                        </tr>';
                                        
                                        $num++;
                                    }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</article>

</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>