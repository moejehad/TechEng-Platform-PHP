<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'Profile';
    
include "init.php"; 

$stmt = $con->prepare("SELECT * FROM website");
                        
$stmt->execute();
                        
$row = $stmt->fetch();
 
    
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $email = $_POST['email'];
    if(empty($_POST['password'])){
        $password = $row['password'];
    }else {
        $password = sha1($_POST['password']);
    }
    $stmt = $con->prepare("UPDATE website SET email = ?, password = ?");
            
    $stmt->execute(array($email, $password));
                            
    header('Location:  profile.php');
    
    exit();
    
}
?>



<div class="card profile">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body">
        <div class="img text-center">
            <img width="100" src="https://scontent-vie1-1.cdninstagram.com/vp/910e76f1301bba0f5c659611b3e94f0e/5D0566F1/t51.2885-19/44884218_345707102882519_2446069589734326272_n.jpg?_nc_ht=scontent-vie1-1.cdninstagram.com" alt="Admin"/>
        </div>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <input class="form-control" name="email" type="email" value="<?php echo $row['email'] ?>" />
            <input class="form-control" name="password" type="password" placeholder="Enter new Password"/>
            <input type="submit" value="Save" class="btn btn-primary btn-block"/>
        </form>
    </div>
    
</div>


    

<?php
     
    include $tpl . 'footer.php';

} else {
    
    header('Location: index.php');
    
    exit();
}

ob_end_flush();

?>