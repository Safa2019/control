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

    <article class="col-lg-9">
        <div class="row" style="margin-right: 100px">
            <div class="col-6 col-sm-3 div1">
                <p>عدد الموظفين </p>
                <?php
                    $organs= mysqli_query($conn, "SELECT * FROM `organization` WHERE '$_SESSION[organ_id]' = `organ_id`");
                    $organ= mysqli_fetch_assoc($organs);
                    $empNo = $organ['empNo'];
                    echo $empNo;
                ?>
            </div>

            <div class="col-6 col-sm-3 div2">
                <p>إجمالي المهام</p>
                <?php
                    $organs= mysqli_query($conn, "SELECT * FROM `organization` WHERE '$_SESSION[organ_id]' = `organ_id`");
                    $organ= mysqli_fetch_assoc($organs);
                    $taskNo = $organ['taskNo'];
                    echo $taskNo;
                ?>
            
            </div>

            <div class="col-6 col-sm-3 div5"> 
                <p> مهام لم يتم البدء فيها</p>
                <?php
                    $tasks = mysqli_query($conn , "SELECT * FROM `tasks` WHERE '$_SESSION[organ_id]' = `organ_id` ");
                    $num = 1;
                    $noTaskNotS=0;
                    while($task = mysqli_fetch_assoc($tasks)){
                        if($task['status']=='not started'){
                            $noTaskNotS++;
                        }
                        $num++;
                    }
                echo $noTaskNotS;
                ?> 

            </div> 

            <!-- Force next columns to break to new line -->
            <div class="w-100"></div>

            <div class="col-6 col-sm-3 div3">             
                <p>مهام جاري العمل عليها</p>
                <?php
                    $tasks = mysqli_query($conn , "SELECT * FROM `tasks`  WHERE '$_SESSION[organ_id]' = `organ_id`");
                    $num = 1;
                    $noTaskInProg=0;
                    while($task = mysqli_fetch_assoc($tasks)){
                        if($task['status']=='in progress'){
                            $noTaskInProg++;
                        }
                        $num++;
                    }
                echo $noTaskInProg;
                ?>


            </div>
            <div class="col-6 col-sm-3 div4"> 
            <p> مهام منتهية</p>
                <?php
                    $tasks = mysqli_query($conn , "SELECT * FROM `tasks`  WHERE '$_SESSION[organ_id]' = `organ_id`");
                    $num = 1;
                    $noTaskInC=0;
                    while($task = mysqli_fetch_assoc($tasks)){
                        if($task['status']=='completed'){
                            $noTaskInC++;
                        }
                        $num++;
                    }
                echo $noTaskInC;
                ?>

            </div>

                        
            <div class="col-6 col-sm-3 div4"> 
                <p> مهام مرفوضة</p>
                <?php
                    $tasks = mysqli_query($conn , "SELECT * FROM `tasks` WHERE '$_SESSION[organ_id]' = `organ_id`");
                    $num = 1;
                    $noTaskRefused=0;
                    while($task = mysqli_fetch_assoc($tasks)){
                        if($task['status']=='refused'){
                            $noTaskRefused++;
                        }
                        $num++;
                    }
                echo $noTaskRefused;
                ?>

            </div>

        </div>
    </article>

    <!-- <article class="col-lg-9" >
			<div class="panel panel-info">
            <div class="panel-heading"></div>
            <div class="panel-body">
		
			  	// $sql = mysqli_query($conn , "SELECT * FROM `users` u WHERE '$_SESSION[id]' = u.user_id ");
                // $user = mysqli_fetch_assoc($sql);
                // echo '<h1>اهلا <span style="color: green;">'.$user['username'].' </span></h1>';
                

			</div>
			</div>
	</article> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>