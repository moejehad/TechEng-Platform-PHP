<?php 

ob_start();

session_start();

$pageTitle =  str_replace('-',' ',$_GET['title']);
 
include 'init.php';

include 'includes/templeats/nav.php';

$id = $_GET['id'];

$stmt = $con->prepare("SELECT * FROM blog WHERE id LIKE '%$id%' ");
                        
$stmt->execute(array($id));
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    
if($count > 0){
        
/*
report();
*/

$userID = $row['user'];        
$stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
$stmt1->execute(array($userID));
$userInfo = $stmt1->fetch();                      
?>


<section class="artical">
    
    <div class="top text-center" style="background: url('images/<?php echo $row['img']?>') center;background-repeat: no-repeat;background-size: cover;">
        <div class="container">
            <h1 class="title wow slideInUp" data-wow-delay="0.1s"><?php echo $row['title']?></h1>
            <p class="wow slideInUp" data-wow-delay="0.3s"> <?php echo $userInfo['username']?> | <?php echo $row['date']?> </p>
        </div>
    </div>
    
        <div class="container">
            <div class="row">
                
                <div class="col-12 text">
                    <p><?php echo $row['text']?></p>
                </div>
            </div>
        </div>             
</section>


<?php

}else {
   header('Location: 404');
    exit();
}

include $tpl . 'footer.php';

ob_end_flush();

?>