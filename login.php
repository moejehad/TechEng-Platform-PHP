<?php 

ob_start();

session_start();

if(isset($_SESSION['user'])){
    header('Location: index');
}

$pageTitle = 'تسجيل دخول';
 
include 'init.php';

include 'includes/templeats/nav.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hashedPass = sha1($pass);
    
    
    $stmt = $con->prepare("SELECT
    id, email,password 
    FROM 
    users 
    WHERE email = ? 
    AND 
    password = ?
    ");
    
    $stmt->execute(array($email,$hashedPass));
    
    $get = $stmt->fetch();
        
    $count = $stmt->rowCount();
    
    if($count > 0){
         
        $_SESSION['user'] = $email;
        
        $_SESSION['Uid'] = $get['id'];
             
        header('Location: member ');
        exit();
        
    }else{
        
        $error =  'الرجاء التأكد من إسم المستخدم أو كلمة المرور';
    }
    
    
}


/*
report();
*/

?>

<div class="home">

    <div class="register">
        
    <div class="container">
                <form action="login" method="POST">
                    <div class="logo text-center">
                        <img src="layout/imgs/logo.png" alt="logo" title="Tech & Eng" width="110" />
                    </div>
                    
                    <?php  
        
                        if(isset($error)){
                             echo '<div class="alert alert-danger">' . $error . '</div>';
                        }

                    ?>
                    
                    
                    <input type="email" name="email" placeholder="البريد الإلكتروني" class="form-control" />
                    <input type="password" name="password" placeholder="كلمة المرور" class="form-control" />
                    <p class="forget" ><a href="forgetPassword">نسيت كلمة المرور ؟</a></p>
                    <input type="submit" value="تسجيل دخول" class="btn btn-info btn-block form-control" />
                    <p class="create">لا تملك حساب ؟ <a href="register">سجل الآن</a></p>
                </form>
        </div>
    </div>
    
</div>


<?php

include $tpl . 'footer.php';

ob_end_flush();

?>