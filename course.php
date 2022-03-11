<?php 

ob_start();

session_start();

$pageTitle = 'كورس ' . str_replace('-',' ',$_GET['name']);
 
include 'init.php';

include 'includes/templeats/nav.php';

$id = $_GET['id'];

$stmt = $con->prepare("SELECT * FROM courses WHERE id LIKE '%$id%' ORDER BY id DESC");
                        
$stmt->execute(array($id));
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    
if($count > 0){
        
/*
report();
*/

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $course          = $row['id'];
        $student         = $_SESSION['Uid']; 
                                                           
        $stmt = $con->prepare("INSERT INTO subscriptions 
        (course, student , date)
        VALUES(:zcourse , :zstudent, now() ) ");

        $stmt->execute(array(

            'zcourse'         => $course,
            'zstudent'        => $student

        ));
          
        $sender = $_SESSION['Uid'];
        $receiver = $_SESSION['Uid'];
        $type = "join";
        $details =  $row['name'];
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
     
     
        header('Location: course?name=' . str_replace(' ','-',$row['name']) .'&id=' . $row['id'] .' ');
        exit();
                
}
    
?>


<section class="course">
    <div class="top col-12 text-right">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-md-12">
                    <h1 class="title" >كورس <?php echo $row['name'] ?> </h1>
                    <h5> <?php echo $row['shortDes'] ?> </h5>
                    <p class="author">مقدم الدورة : <span><?php echo $row['author'] ?> </span></p>
                    
                    <?php 
                    
                if(isset($_SESSION['user'])){

                    $stmt3 = $con->prepare("SELECT * FROM subscriptions WHERE course LIKE '%$id%' ");

                    $stmt3->execute(array($id));

                    $equal = $stmt3->fetch();
                    
                    if($equal['course'] === $id && $equal['student'] === $_SESSION['Uid']){ ?>
                       
                    <button class="btn btn-light">مشترك مسبقاً</button>
                    <?php }else { ?>
                    <form action="course?name=<?php echo str_replace(' ','-',$row['name'])?>&id=<?php echo $row['id'] ?>" method="post">
                    <input type="submit" class="btn btn-light" value="اشتراك">
                    </form>
                    <?php } 
                }else {
                    echo '<a href="login"><button class="btn btn-light">اشتراك</button></a>';
                }?>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="courseImg" style="background:url('images/<?php echo $row['img'] ?>') center; width: 100%;height:220px;background-size:cover;position: absolute;margin-top:-20px;">
                    </div>
                </div>
            </div>
        </div>             
    </div>
    
    <div class="container">
        <div class="content col-12">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12">
                    <h4>ماذا ستتعلم في هذا الكورس ؟ </h4>
                    <div class="card">
                        <div class="card-body"><?php echo $row['description'] ?></div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-2 col-md-12">
                    <div class="about-author">
                        <div class="imag" style="background: url('images/431488037_IMG_20190529_233927_145.jpg') center;background-repeat: no-repeat;background-size: cover;height: 100px;width: 100px;">
                        </div>
                        <h3>Moe Jehad</h3>
                        <p>Web Developer - UX &amp; UI Desinger</p>
                    </div>
                </div>
                
                <?php 
                if(isset($_SESSION['user'])){
                    if($equal['course'] == $id && $equal['student'] == $_SESSION['Uid']){                                     
                        $user = $_GET['id'];

                        $stmt = $con->prepare("SELECT * FROM videos WHERE course LIKE '%$user%' ");

                        $stmt->execute(array($user));

                        $courseInfo = $stmt->fetchAll();
                ?>
                <div class="col-12">
                    
                    <div class="accordion" id="accordionExample275">
                    
                    <?php foreach($courseInfo as $cInfo){ ?>
                      <div class="card z-depth-0 bordered">
                        <div class="card-header" id="heading<?php echo $cInfo['id']?>">
                          <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $cInfo['id']?>"
                              aria-expanded="true" aria-controls="collapse<?php echo $cInfo['id']?>">
                             <?php echo $cInfo['name']?>
                            </button>
                          </h5>
                        </div>
                        <div id="collapse<?php echo $cInfo['id']?>" class="collapse" aria-labelledby="heading<?php echo $cInfo['id']?>"
                          data-parent="#accordionExample275">
                          <div class="card-body">
                            
                              <iframe width="100%" height="500" src="<?php echo $cInfo['link']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                              
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    </div>
                    
                </div>
                <?php }else {
                    echo '<div class="col-12 alert alert-info text-center">قم بالاشتراك في الكورس حتى تظهر لك الفيديوهات</div>';
                } }else {
                    echo '<div class="col-12 alert alert-info text-center">قم بالاشتراك في الكورس حتى تظهر لك الفيديوهات</div>';
                }?>
            </div>
        </div>
    </div>
</section>


<?php

}

include $tpl . 'footer.php';

ob_end_flush();

?>