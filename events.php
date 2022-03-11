<?php 

ob_start();

session_start();

$pageTitle = 'الفعاليات';
 
include 'init.php';

include 'includes/templeats/nav.php';

$stmt = $con->prepare("SELECT * FROM event ORDER BY id DESC");
                        
$stmt->execute();
                        
$rows = $stmt->fetchAll();
        
$count = $stmt->rowCount();  
    
if($count > 0){
    
/*
report();
*/

?>
<section class="events">
        <div class="row">
            <div class="top col-12">
                <div class="container">
                <h1 class="title wow slideInUp" data-wow-delay="0.1s">الفعاليات وورش العمل </h1>
                <p class="wow slideInUp" data-wow-delay="0.3s"> تجدون في هذا القسم جميع الفعاليات وورش العمل القادمة وكافة الفعاليات والتدريبات التي تم تنفيذها سابقاً </p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <?php foreach($rows as $row){ ?>
                    <div class="col-xl-4 col-md-6 col-sm-12 wow slideInUp" data-wow-delay="0.4s">
                        <div class="card shadow-sm">
                        <div class="card-img-top" style="background:url('images/<?php echo $row['img'] ?>') center; background-size :cover;height:300px;">
                        </div>
                          <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name'] ?></h5>
                            <p class="card-text"><i class="fa fa-calendar"></i> <?php echo $row['date'] ?> <i class="fa fa-clock"></i> <?php echo $row['time'] ?></p>
                            <a href="event?name=<?php echo str_replace(' ','-',$row['name'])?>&id=<?php echo $row['id'] ?>" class="btn btn-primary">المزيد</a>
                          </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
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