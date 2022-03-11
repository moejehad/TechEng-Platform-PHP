<!DOCTYPE html>
<html>
    <head>
        <title>لوحة التحكم</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../layout/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="layout/css/style.css">
        <link rel="icon" type="image/png" href="layout/imgs/logo.png">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport' />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    
    <body class="admin">
        
<?php 

session_start();

if(isset($_SESSION['Admin'])){
    header('Location: dashboard');
}

include "connect.php"; 


    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $email = $_POST['email'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);
        

        $stmt = $con->prepare("SELECT id,email,password FROM users WHERE email = ? AND password = ? AND status = ?
        LIMIT 1");
        $stmt->execute(array($email,$hashedPass , 1));
        $row = $stmt->fetch();

        $count = $stmt->rowCount();
        
        if($count > 0){
            
            $_SESSION['Admin'] = $email;

            $_SESSION['ID'] = $row['id'];

            header('Location: dashboard');
            exit();

        }else {

            $error =  'تفقد البريد الإلكتروني او كلمة المرور';
        }

    }
        
?>


<div class="login-page">
    <div class="container">
    
    <form class="shadow-sm login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <?php if(isset($error)){
        echo '<h6 class="alert alert-danger text-right">'. $error . '</h6>';
        }?>
        
        <h4 class="text-center">دخول</h4>
            <input class="form-control" type="email" name="email" placeholder="البريد الإلكتروني" required autocomplete="off"/>
            <input class="form-control" required type="password" name="pass" placeholder="كلمة المرور"/>
        <input class="btn btn-primary btn-block" type="submit" value="دخول"/>
    </form>
        
</div>
    
</div>

    <script type="text/javascript" src="../layout/js/jquery.js"></script>
    <script type="text/javascript" src="../layout/js/bootstrap.min.js"></script>

    </body>
</html>