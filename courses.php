<?php 

ob_start();

session_start();

$pageTitle = 'الكورسات';
 
include 'init.php';

include 'includes/templeats/nav.php';


$stmt = $con->prepare("SELECT * FROM courses ORDER BY id DESC");
                        
$stmt->execute();
                        
$rows = $stmt->fetchAll();
        
$count = $stmt->rowCount();  
    
if($count > 0){
        
/*
report();
*/

?>


<section class="courses">
    <div class="container">
        <div class="row">
            <div class="top col-12 text-center">
                <h1 class="title wow slideInUp" data-wow-delay="0.1s">كورسات Tech &amp; Eng </h1>
                <h5 class="wow slideInUp" data-wow-delay="0.3s"> نقدم لك العديد من الكورسات التي توفر المعرفة والمهارات التي تساعدك على بداية حياتك في أحد المجالين </h5>
            </div>
            
            <?php foreach($rows as $row){ ?>
            <div class="col-xs-6 col-lg-6 col-md-12 wow slideInUp" data-wow-delay="0.4s">
                <a href="course?name=<?php echo str_replace(' ','-',$row['name'])?>&id=<?php echo $row['id'] ?>">
                <div class="course blue">
                    <div class="courseImage" style="background:url('images/<?php echo $row['img'] ?>') center; background-size :cover;">
                    </div>
                    <div class="content">
                        <h1> <?php echo $row['name'] ?> </h1>
                        <p> <?php echo $row['shortDes'] ?> </p>
                    </div>
                </div>
                </a>
            </div>
            <?php } ?>
            
        </div>
    </div>
</section>


<?php

}else {
    echo '<div class="alert alert-danger">لم يتم اضافة كورسات بعد</div>';
}

include $tpl . 'footer.php';

ob_end_flush();

?>