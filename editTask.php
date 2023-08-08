<?php include_once("include/confg.php");
    session_start(); ?>
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
    $msg='';

    if(isset($_POST['edit-task'])){
        $title = $_POST['title'];
        $deadline = $_POST['deadline'];
        $status= $_POST['status']; 
        $empID= $_POST['empID'];  
        $dateRecord= date("Y-m-d");

        $sql = mysqli_query($conn , "SELECT * FROM `users` u WHERE '$empID' = u.user_id");
        $user = mysqli_fetch_assoc($sql);
        $empRes= $user['empName']; 
            
        $insert ="UPDATE `tasks` SET `title`='$title', `empRes`='$empRes' ,`deadline`='$deadline', `empID`='$empID',`status`='$status' 
        WHERE `task_id`='$_GET[task]' ";
        $inser_sql = mysqli_query($conn , $insert);

        $tasks = mysqli_query($conn , "SELECT * FROM `tasks`  WHERE '$title' = `title` ");
        $task = mysqli_fetch_assoc($tasks);
        $taskID = $task['task_id'];

        $insert2 = mysqli_query($conn, "INSERT INTO `taskrecord` (`task_id` ,`empRes`, `dateRecord`,`status`,`deadline`)
        VALUES ('$taskID','$empRes', '$dateRecord', '$status', '$deadline' )");
        if(isset($inser_sql)){
            $msg= '<div class="alert alert-success" role="alert">تم تحديث البيانات بنجاح , جاري تحويلك للصفحة </div>';
            echo '<meta http-equiv="refresh" content="3; \'tasks.php\'">';
        }
    }
?>

    <article class="col-lg-9" >
        <div class="row">
            <div class="col-md-1"></div>	
                <div class="col-md-10">
                <?php 
                    echo $msg;
                    $get_tasks= mysqli_query($conn ,"SELECT * FROM `tasks` WHERE `task_id` ='$_GET[task]'");
                    $task = mysqli_fetch_assoc($get_tasks);                
                ?>
                <div class="panel panel-info" >
                <div class="panel-heading"><b>  تعديل المهمة  </b><?php echo $task['title']; ?></div>
                
                    <div class="panel-body"> 
                            <form action="" method="post" class="form-horizontal" >
                            <div class="form-group">
                            <label for="username" class="col-sm-2 control-label" >عنوان المهمة </label></br>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="title" id="username" value="<?php echo $task['title'] ;?>" placeholder="ادخل عنوان ">
                            </div>
                            </div>

                            <div class="form-group">
                            <label for="empName" class="col-sm-2 control-label" >تاريخ الانتهاء</label></br>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="deadline" id="username" value="<?php echo $task['deadline'] ;?>" placeholder="ادخل تاريخ الانتهاء">
                            </div>
                            </div>

                            <div class="input-group">
                                <label>إسناد المهمة إلى</label>
                                <select name="empID" >                                              
                            
                                <?php
                                    $num = 1;
                                    $users = mysqli_query($conn , "SELECT * FROM `users` WHERE '$_SESSION[organ_id]' = `organ_id` ");
                                    while($user = mysqli_fetch_assoc($users)){
                                    
                                ?>
                                        <option value="<?=$user["user_id"];?> " title="<?=$user["empName"];?>"><?=$user["empName"];?>"</option>                           
                                        <?php                                       
                                        $num++;
                                    }?>
                                </select>
                            </div>

                            <div class="form-group">
							<label for="role" class="col-sm-2 control-label"> حالتها :</label>
							<div class="col-sm-3">
                            <select class="form-control" name="status" id="role" value="" >
                            <option value="<?php echo $task['status'];  ?>" ><?php echo $task['status'];  ?></option>
                            <option value="in progress" >in progress</option>
                            <option value="not started" >not started</option>
                            <option value="completed" >completed</option>
                            <option value="refused" >refused</option>
                            </select>
							</div>
						</div>
                    
                        
                            
                            <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="edit-task" class="btn btn-danger">تعديل</button>
                            </div>
                            </div>
                        </form>
                    
                    </div>
                </div>
            </div>
            
        </div>
		
	</article>
</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>