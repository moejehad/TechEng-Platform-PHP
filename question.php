<?php 

ob_start();

session_start();
   
$pageTitle = str_replace('-',' ',$_GET['t']);
 
include 'init.php';

include 'includes/templeats/nav.php';
    
$quas = $_GET['id'];

$stmt = $con->prepare("SELECT * FROM society WHERE id LIKE '%$quas%'");
                        
$stmt->execute(array($quas));
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    
if($count > 0){

$userID = $row['userID'];        
$stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
$stmt1->execute(array($userID));
$user = $stmt1->fetch();
    
$stmt2 = $con->prepare("UPDATE society SET counter = counter+1 WHERE id = ?");                   
$stmt2->execute(array($row['id']));
    

    
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $comment         = $_POST['comment'];
        $target          = 'sosiety'; 
        $targetID        = $row['id']; 
        $user            = $_SESSION['Uid'];
         
        if(!empty($comment)){
        $stmt = $con->prepare("INSERT INTO comments 
        (comment, target, targetID, user , date)
        VALUES(:zcom , :ztar, :ztarID, :zuser , now() ) ");

        $stmt->execute(array(

            'zcom'        => $comment,
            'ztar'        => $target,
            'ztarID'      => $targetID,
            'zuser'       => $user

        ));
          
        if($_SESSION['Uid'] != $row['userID']){            
            $sender = $_SESSION['Uid'];
            $receiver = $row['userID'];
            $type = "comment";
            $details =  $row['title'];
            $detailsID =  $row['id'];
            $status = "unread";

            $stmt = $con->prepare("INSERT INTO notifications 
            (sender , receiver , details , detailsID , type , status,  date , time)
            VALUES(:Zsender , :Zreceiver, :Zdetails , :ZdetailsID , :Ztype , :Zstatus , now() , now() ) ");

            $stmt->execute(array(

                'Zsender'      => $sender,
                'Zreceiver'    => $receiver,
                'Zdetails'     => $details,
                'ZdetailsID'   => $detailsID,
                'Ztype'        => $type,
                'Zstatus'      => $status            

            ));
        }
            
        header('Location: question?t= ' . str_replace(' ','-',$row['title']) .  '&id=' . $targetID . ' ');
        exit();
        }else {
            $error = '<h6 class="alert alert-danger">يرجى اضافة رد<h6>';
        }
    }

    
?>

<section class="question">
    <div class="container">
        <div class="row">            
            <div class="col-xl-10 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5><?php echo $row['title'] ?></h5>
                        <ul class="meta">
                            <li><i class="fa fa-user"></i> <?php echo $user['username'] ?></li>
                            <li><i class="fa fa-bars"></i><?php echo $row['type'] ?></li>
                        </ul>
                    </div>
                    <div class="card-body"><?php echo $row['content'] ?></div>
                </div>

                <?php

                $stmtC = $con->prepare("SELECT * FROM comments WHERE targetID LIKE '%$quas%' ");

                $stmtC->execute(array($quas ));

                $comments = $stmtC->fetchAll();
                
                $count = $stmtC->rowCount();  
    
                if($count > 0){
                ?>
                <div class="col-12 all-comments card shadow-sm">
                     <div class="card-body">
                        <?php foreach($comments as $comment){ 
                            $userID = $comment['user'];        
                            $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
                            $stmt1->execute(array($userID));
                            $userInfo = $stmt1->fetch();
                    
                         ?>
                            <div class="comment">
                                <div class="row">
                                    <div class="col-xl-1 col-lg-2 col-md-3">
                                        <div class="rounded-circle userImg" style="background: url('images/<?php echo $userInfo['photo'] ?>') center;background-size: cover;height: 50px;width: 50px;float: right;"></div>
                                    </div>
                                    <div class="col-xl-11 col-lg-10 col-md-9">
                                        <div class="content">
                                            <h5><?php echo $userInfo['username'] ?></h5>
                                            <p><?php echo $comment['comment'] ?></p>
                                            <span><?php echo $comment['date'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         <?php }?>
                    </div>
                </div>
                <?php } ?>
                
                
                <div class="col-12 add-comment card shadow-sm">
                    <div class="card-body">
                        <h5>إضافة رد</h5>
                        <?php 
                        if(isset($error)){
                            echo $error;
                        }
                        if(isset($_SESSION['user'])){ ?>
                         <form action="" method="POST">
                            <textarea rows="5" class="form-control" name="comment"></textarea>
                            <input type="submit" class="btn btn-info" value="اضافة"/>
                        </form>
                        <?php }else { ?>
                        <h5>تستطيع اضافة رد بعد تسجيل الدخول</h5>
                        <a class="btn btn-info" href="login">تسجيل الدخول</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-12">
                <div class="card shadow-sm">
                    <img src="layout/imgs/ad.png" />
                </div>
            </div>
        </div>
    </div>
</section>

<?php
 
}else {
    echo '<div class="container text-center">';
    echo '<div class="alert alert-danger">لا يوجد سؤال بهذا العنوان</div>';
    echo '</div>';
}

include $tpl . 'footer.php';

ob_end_flush();

?>