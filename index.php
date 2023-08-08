
<?php
    session_start();
    include_once('include/confg.php');

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
    <section class="vh-100" dir="rtl">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="img/signupPhoto.JPG" class="img-fluid"
            alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form action="include/login.php" id="login" method="post">
            <div class="divider d-flex align-items-center my-4">
                <p class="text-center fw-bold mx-3 mb-0" style=" font-size: 1.3rem; color: #22296b;">تسجيل الدخول</p>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="text" id="form3Example3" name="user" class="form-control form-control-lg"
                placeholder=" أدخل البريد الالكتروني أو اسم المستخدم" />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
                <input type="password" id="form3Example4" name="password" class="form-control form-control-lg"
                placeholder="أدخل كلمة المرور" />
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <!-- Checkbox -->
                <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                    تذكرني
                </label>
                </div>
                <a href="#!" class="text-body">نسيت كلمة المرور؟</a>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submits" class="btn btn-primary btn-lg" name="login_btn"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">دخول</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">ليس لديك حساب؟ <a href="createAccount.php"
                    class="link-danger">إنشاء حساب</a></p>
            </div>

            </form>
        </div>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
        Copyright © 2020. All rights reserved.
        </div>
        <!-- Copyright -->
    </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>