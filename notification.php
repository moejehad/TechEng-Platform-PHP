<?php 

ob_start();

session_start();

if(isset($_SESSION['user'])){

$pageTitle = 'الاشعارات';
 
include 'init.php';

include 'includes/templeats/nav.php';

/*
report();
*/

$user = $_SESSION['Uid'];
    
$stmt = $con->prepare("SELECT * FROM notifications WHERE receiver LIKE '%$user%' ORDER BY id DESC");
                        
$stmt->execute(array($user));
                        
$rows = $stmt->fetchAll();
        
$count = $stmt->rowCount();  

    
?>

<div class="container">

<?php 
    
    if($count > 0){


    $stmt = $con->prepare("UPDATE notifications SET status = ? WHERE receiver = ?");

    foreach($rows as $row){ 

    $stmt->execute(array("read", $user));

    }
    
                    
?>
    
<section class="notification">
        <div class="noti">  
                <div class="row">
                    <?php 
                    
                    foreach($rows as $row){
                        
                    $userID = $row['sender'];        
                    $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
                    $stmt1->execute(array($userID));
                    $sender = $stmt1->fetch();
                    
                    ?>
                    <div class="col-12 item">
                        <div class="user" style="background: url('images/<?php echo $sender['photo']?>') center;background-repeat: no-repeat;background-size: cover;width:55px;height:55px;">
                        </div>
                        <div class="details">
                            <h3>
                                <span><?php echo $sender['username']?></span>
                                <?php if($row['type'] == 'join'){
                                
                                    echo 'قمت بالاشتراك في كورس';
                                }elseif ($row['type'] == 'comment'){
                                    echo 'قام بالتعليق على';
                                }elseif ($row['type'] == 'video'){
                                    echo 'أضاف فيديو';
                                }elseif ($row['type'] == 'event'){
                                    echo 'نشر مناسبة جديدة بعنوان';
                                }?>
                                <a href="<?php if($row['type'] == 'join'){
                                
                                        echo 'course?name=' . str_replace(' ','-',$row['details']) .'&id=' . $row['detailsID'] .' ';
                                    }elseif ($row['type'] == 'comment'){
                                    echo 'question?t='. str_replace(' ','-',$row['details']) . '&id='. $row['detailsID'].' ';
                                    }elseif ($row['type'] == 'video'){
                                        echo 'course?name=' . str_replace(' ','-',$row['details']) .'&id=' . $row['detailsID'] .' ';
                                    }elseif ($row['type'] == 'event'){
                                        echo 'events';
                                    }?> "> <?php echo $row['details']?></a>
                            </h3>
                            <span class="date"><?php echo $row['date']?></span>
                            <span class="date"> | <?php echo $row['time']?></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>        
</section>

<?php
}else {
    echo '<div class="alert alert-info">ليس لديك اشعارات حتى الآن</div>';
    echo '</div>';
} 
}else {
    header('Location: login');
    exit();
}
include $tpl . 'footer.php';

ob_end_flush();

?>