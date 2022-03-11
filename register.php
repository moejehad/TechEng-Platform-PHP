<?php 

ob_start();

session_start();

if(isset($_SESSION['user'])){
    header('Location: index.php');
}

$pageTitle = 'تسجيل مستخدم جديد';
 
include 'init.php';

include 'includes/templeats/nav.php';

/*
report();
*/

$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $username   = $_POST['name'];
        $password   = $_POST['password'];
        $password2  = $_POST['password2'];
        $email      = $_POST['email'];
    
    
        if(isset($username)){

            $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

            if(strlen($filterdUser) < 5){

                $formErrors[] = 'يجب أن يكون إسم المستخدم أكثر من 6 حروف';
            }
        }



        if(isset($password) && isset($password2)){


            if(empty($password)){

                $formErrors[] = 'يجب وضع كلمة المرور';

            }


            if(sha1($password) !== sha1($password2)){

                $formErrors[] = 'كلمة المرور غير متطابقة';

            }

        }



        if(isset($email)){

            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true ) {

                $formErrors[] = 'البريد الإلكتروني غير صحيح';
            }
        }
    
        if(empty($formErros)){
                
           $check = checkItem("email", "users", $email);
          
                if($check == 1 ){
                    
                    $formErrors[] = ' البريد الإلكتروني مسجل سابقاً ';
                                        
                }else {
                    
                if(sha1($password) == sha1($password2)){                        
                $stmt = $con->prepare("INSERT INTO users 
                (email,username, password, status , date )
                VALUES(:zmail, :zuser , :zpass , :zstatus , now() ) ");

                $stmt->execute(array(

                    'zmail'    => $email,
                    'zuser'    => $username,
                    'zpass'    => sha1($password),
                    'zstatus'  => 0


                ));

                 header('Location: login ');

                 exit();


                }
            
        }   
      }
    
}
?>

<div class="home">

    <div class="register">
        
    <div class="container">
                <form action="register" method="POST" enctype="multipart/form-data">
                    <div class="logo text-center">
                        <img src="layout/imgs/logo.png" alt="logo" title="Tech & Eng" width="110" />
                    </div>                    
                    <?php  
        
                        if(!empty($formErrors)){

                            foreach($formErrors as $error){

                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        }

                    ?>
                    
                    
                    <input type="text" name="name" placeholder="الاسم كامل" class="form-control" />
                    <input type="email" name="email" placeholder="البريد الإلكتروني" class="form-control" />
                    <input type="password" name="password" placeholder="كلمة المرور" class="form-control" />
                    <input type="password" name="password2" placeholder="تأكيد كلمة المرور" class="form-control" />
                    <p class="create text-right">بتسجيلك في المنصة تعتبر موافقاً على سياسة الخصوصية</p>
                    <input type="submit" value="تسجيل" class="btn btn-info btn-block form-control" />
                    <p class="create">تملك حساب بالفعل ؟<a href="login"> دخول </a></p>
                </form>
        </div>
    </div>
    
</div>


<?php

include $tpl . 'footer.php';

ob_end_flush();

?>