<?php include_once("include/confg.php");?>
<?php session_start(); ?>
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
	$title = '';
	$password='';
	$deadline='';

    if(isset($_POST['addTask'])){
		$title = $_POST['title'];
		$empID=$_POST['empID'];
        $deadline=$_POST['deadline'];
        $dateTask= date("Y-m-d");
        if(empty($title)){
			$msg= '<div class="alert alert-danger" role="alert">الرجاء ادخال اسم المهمة</div>';
        }elseif(empty($empID)){
            $msg= '<div class="alert alert-danger" role="alert">الرجاء إسناد المهمة</div>';
        }elseif(empty($deadline)){
            $msg= '<div class="alert alert-danger" role="alert">الرجاء إدخال تاريخ انتهاء </div>';
        }else{
            
            $employess = mysqli_query($conn , "SELECT * FROM `users`  WHERE '$_SESSION[id]' = `user_id` ");
            $empCreated = mysqli_fetch_assoc($employess);
            $empCreatedID = $empCreated['user_id'];
            $organ_id = $empCreated['organ_id']; 
        

            $sql = mysqli_query($conn , "SELECT * FROM `users` where `user_id` = '$empID' ");
            $user = mysqli_fetch_assoc($sql);
            $empRes = $user['empName'];
        
        
            $title = $_POST['title'];
            $empID=$_POST['empID'];
            $deadline=$_POST['deadline'];
            $insert = mysqli_query($conn, "INSERT INTO `Tasks` (`title` ,`empRes`, `deadline`,`organ_id`,`empID`, `status`,`createdBy`, `dateTask`) 
            VALUES ('$title','$empRes','$deadline','$organ_id','$empID', 'not started', '$empCreatedID', '$dateTask' )");

            $tasks = mysqli_query($conn , "SELECT * FROM `tasks`  WHERE '$title' = `title` ");
            $task = mysqli_fetch_assoc($tasks);
            $taskID = $task['task_id'];

            $insert2 = mysqli_query($conn, "INSERT INTO `taskrecord` (`task_id` ,`empRes`, `dateRecord`, `status`, `deadline`)
            VALUES ('$taskID','$empRes' , '$dateTask', 'not started', '$deadline')");
            
            //get organ id to update task column
        

            $select_taskNo = mysqli_query($conn , "SELECT  `taskNo` FROM `organization`  WHERE '$organ_id' = `organ_id` ");
            $organ_task_no = mysqli_fetch_assoc($select_taskNo);
            $taskNo= $organ_task_no['taskNo'];
            $taskNo++;

            $update_one ="UPDATE `organization` SET `taskNo`='$taskNo'
            WHERE `organ_id`='$organ_id' ";
            $update1_sql = mysqli_query($conn , $update_one);
            
            if(isset($insert2)){
				$msg= '<div class="alert alert-success" role="alert"> تم إضافة المهمة بنجاح</div>';
				echo '<meta http-equiv="refresh" content="3; \'addTask.php\'">';
            }
        }
    }
?>

    <article class="col-lg-9" >
    <div class="row">
        <div class="col-md-8">		
            <?php echo $msg; ?>
                <div class="panel panel-info">
                    <div class="panel-heading">إضافة مهمة جديدة</div>
                        <div class="panel-body">
                            <form action="" method="post" class="form-horizontal">
                                <div class="form-group">
                                    
                                    <div class="col-sm-8">
                                        <input type="text" name="title" class="form-control" placeholder="أدخل عنوان المهمة"/>
                                    </div>
                                </div>

                                <div class="input-group">
                                <label>إسناد المهمة إلى</label>
                                <select name="empID" >
                                <?php
                                $users = mysqli_query($conn , "SELECT * FROM `users` ORDER BY `user_id` DESC");
                                    $num = 1;
                                    while($user = mysqli_fetch_assoc($users)){
                                        if($user['role']=='user'){
                                        ?>
                                        <option value="<?=$user["user_id"];?>" title="<?=$user["empName"];?>"><?=$user["empName"];?>"</option>                           
                                        <?php
                                        }
                                        $num++;
                                    }?>
                                </select>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <label>تاريخ انتهاء المهمة</label>
                                        <input type="date" name="deadline" class="form-control" placeholder="تاريخ انتهاء المهمة"/>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <input type="submit" name="addTask" class="btn btn-info" value="إضافة مهمة"/>
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