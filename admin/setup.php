<!DOCTYPE html>
<html>
    <head>
        <title>Setup Website</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../layout/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="layout/css/style.css">
        <link rel="icon" type="image/png" href="">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport' />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    
    <body class="admin">
        
<?php 

session_start();

include "connect.php"; 

$stmt1 = $con->prepare("SELECT * FROM website");
                        
$stmt1->execute(array($user));
                        
$rows = $stmt1->fetch();
        
$count = $stmt1->rowCount(); 
      
if($count > 0 ){
        
    header('Location: index.php ');
    exit();
}else if ($count == 0) {
       
$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $username   = $_POST['Admin'];
        $email      = $_POST['email'];
        $password   = $_POST['pass'];
        $password2  = $_POST['confirm'];
    
    
        if(isset($username)){

            $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

            if(strlen($filterdUser) < 5){

                $formErrors[] = 'Must be more than 6 char';
            }
        }



        if(isset($password) && isset($password2)){


            if(empty($password)){

                $formErrors[] = 'You should fill Password ';

            }


            if(sha1($password) !== sha1($password2)){

                $formErrors[] = 'Password does not match';

            }

        }



        if(isset($email)){

            $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

            if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true ) {

                $formErrors[] = 'Email is incorrect';
            }
        }



      if(empty($formErros)){
                    
                if(sha1($password) == sha1($password2)){                        
                $stmt = $con->prepare("INSERT INTO website 
                (username, email, password, date)
                VALUES(:zuser, :zmail, :zpass , now()) ");

                $stmt->execute(array(

                    'zuser'    => $username,
                    'zmail'    => $email,
                    'zpass'    => sha1($password)


                ));

                header('Location: index.php ');
                exit();

                    }
                }
    
}
    
        

?>


<div class="setup-page">
    <div class="container">
    
    <form class="shadow setup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <?php if(!empty($formErrors)){ 

            foreach($formErrors as $error){

                echo '<div class="alert alert-danger">' . $error . '</div><br>';
            }


     } ?>
        
        <h4 class="text-center">Setup Website</h4>
            <div class="row">
                <div class="col-xl-6 col-sm-12">
                    <input class="form-control" type="text" name="Admin" placeholder="Username" required/>
                    <input class="form-control" type="email" name="email" placeholder="Email" required/>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <input class="form-control" required type="password" name="pass" placeholder="Password"/>
                    <input class="form-control" type="password" name="confirm" placeholder="Confirm Password" required/>
                </div>
            </div>
            <input class="btn btn-primary btn-block" type="submit" value="Save"/>
    </form>
        
</div>
    
</div>
    <script type="text/javascript" src="../layout/js/jquery.js"></script>
    <script type="text/javascript" src="../layout/js/bootstrap.min.js"></script>
    <?php } ?>
    </body>
</html>