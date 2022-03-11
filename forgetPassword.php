<?php 

ob_start();

session_start();

if(isset($_SESSION['user'])){
    header('Location: index');
}

$pageTitle = 'نسيت كلمة المرور ';
 
include 'init.php';

include 'includes/templeats/nav.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $email = $_POST['email'];
    
    
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
                    <input type="submit" value="استرجاع الكلمة" class="btn btn-info btn-block form-control" />
                    <p class="create"> <a href="login">تسجيل دخول </a></p>
                </form>
        </div>
    </div>
    
</div>


<?php

include $tpl . 'footer.php';

ob_end_flush();

?>