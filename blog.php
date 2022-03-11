<?php 

ob_start();

session_start();

$pageTitle = 'المدونة';
 
include 'init.php';

include 'includes/templeats/nav.php';

/*
report();
*/

?>

<section class="blogger">
    
    <div class="top text-center">
        <div class="container">
            <h1 class="title wow slideInUp" data-wow-delay="0.1s">المدونة</h1>
            <p class="wow slideInUp" data-wow-delay="0.3s"> مقالات عن الهندسة والتكنولوجيا وريادة الأعمال للمبدعين ومراجعة كل جديد في  التكنولوجيا والهندسة </p>
        </div>
    </div>
            
    <div class="container">
        <div class="row">
            
            <?php 
    
            $stmt = $con->prepare("SELECT * FROM blog ORDER BY id DESC");

            $stmt->execute();

            $rows = $stmt->fetchAll();

            $count = $stmt->rowCount();  

            if($count > 0){

            foreach($rows as $row){
            ?>
            <a href="article?title=<?php echo str_replace(' ','-',$row['title']) ?>&id=<?php echo $row['id']?>">
            <div class="col-xl-6 col-md-12 wow fadeIn" data-wow-delay="0.4s">
                <div class="card">
                    <div class="card-img-top" style="background:url('images/<?php echo $row['img'] ?>') center; width:100%; height:200px; background-size :cover;border-radius :20px;"></div>
                  <div class="card-body">
                    <a href="article?title=<?php echo str_replace(' ','-',$row['title']) ?>&id=<?php echo $row['id']?>" class="card-title"><h5><?php echo $row['title']?></h5></a>
                      <?php 
                        $userID = $row['user'];        
                        $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
                        $stmt1->execute(array($userID));
                        $userInfo = $stmt1->fetch();                      
                      ?>
                    <div class="card-text"><div class="userPhoto" style="background:url('images/<?php echo $userInfo['photo'] ?>') center; width:50px; height:50px; background-size :cover;border-radius :100px;" ></div> <p><?php echo $userInfo['username']?></p> </div>
                  </div>
                </div>
            </div>
            </a>
            <?php } }else {
                
                echo '<div class="alert alert-danger">لم يتم نشر أي مقالة بعد</div>';
            } ?>
            
        </div>
    </div>
            
</section>



<?php

include $tpl . 'footer.php';

ob_end_flush();

?>