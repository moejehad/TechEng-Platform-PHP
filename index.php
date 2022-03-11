<?php 

ob_start();

session_start();

$pageTitle = 'Tech & Eng';
 
include 'init.php';

/*
report();
*/

?>

<div class="home">
    
<?php include 'includes/templeats/nav.php';?>
    
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 text text-center">
                <h1 class="wow slideInUp" data-wow-delay="0.1s">كورسات مجانية في الهندسة والتكنولوجيا</h1>
                <h5 class="wow slideInUp" data-wow-delay="0.2s">منصة المبدعين في الوطن العربي  , ابدأ وتعلم الآن</h5>
                <div class="bt">
                    <a class="btn btn-info user wow fadeIn" data-wow-delay="0.3s" href="register" target="_blank">مستخدم جديد</a>
                    <a class="btn btn-danger sos wow fadeIn" data-wow-delay="0.3s" href="society">المجتمع</a>
                </div>
            </div>
            
            <div class="image col-xl-6 col-lg-6 col-md-12 text-center wow fadeIn">
                <img src="layout/imgs/logo.png" alt="Logo" />
            </div>
        </div>
    </div>
</div>

<section class="sections">
    <div class="container">
        <div class="row">
            
            <div class="col-xs-6 col-lg-6 col-md-12 wow fadeInDown" data-wow-delay="0.4s">
                <div class="item">
                    <div class="icon Eng">
                        <img src="layout/imgs/robot.png" alt="Eng" width="50" />
                    </div>
                    <div class="content">
                        <h1> الهندسة </h1>
                        <p> نتيح لك في قسم الهندسة مجموعة من الكورسات المتخصصة في انظمة الحاسوب والالكترونيات التي تساعدك على البدء والتعلم في مجال الهندسة </p>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-6 col-lg-6 col-md-12 wow fadeInDown" data-wow-delay="0.6s">
                <div class="item">
                    <div class="icon Tech">
                        <img src="layout/imgs/Tech.png" alt="Tech" width="70"/>
                    </div>
                    <div class="content">
                        <h1> تكنولوجيا المعلومات  </h1>
                        <p> نتيح لك في قسم تكنولوجيا المعلومات مجموعة من الكورسات التي تساعدك على البدء والتعلم والعمل في المجال كــ Freelancer </p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="futures">
    <div class="container">
        
        <h2 class="top-title wow fadeInUp" data-wow-delay="0.2s">مميزات المنصة</h2>
        
        <div class="row">
            
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="0.4s">
                <div class="f-item">
                    <div class="image">
                        <img src="layout/imgs/mortarboard.png" alt="Free" />
                    </div>
                    <div class="content">
                        <h4>كورسات مجانية</h4>
                        <p>نوفر لك جميع الكورسات بشكل مجاني في منصتنا بدون اي اشتراك او رسوم </p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="0.6s">
                <div class="f-item">
                    <div class="image">
                        <img src="layout/imgs/checklist.png" alt="Work" />
                    </div>
                    <div class="content">
                        <h4>التطبيق العملي</h4>
                        <p> من خلال التطبيق العملي لما تعلمته نعمل على تثبيت المعلومات والاستفادة منها بأكبر قدر</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="0.8s">
                <div class="f-item">
                    <div class="image">
                        <img src="layout/imgs/instruction.png" alt="Learn" />
                    </div>
                    <div class="content">
                        <h4>التعليم النظري</h4>
                        <p>نقدر اهمية المادة النظرية للمتعلم لتكون مرجع له يوجد بها شرح مفصل للتطبيقات العملية</p>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</section>

<section class="team">
    <div class="container">
        
        <h2 class="top-title text-center wow fadeInUp" data-wow-delay="0.2s">فريقنا</h2>

        <div class="row">
            
            <div class="col-xs-3 col-lg-3 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="0.4s">
                <div class="person">
                    <div class="personImg">
                        <img class="rounded-circle" src="layout/imgs/moe.jpg" alt="Person" width="50" />
                    </div>
                    <div class="caption">
                        <a href="#">محمد جهاد</a>
                        <p> Web Developer </p>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-3 col-lg-3 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="0.6s">
                <div class="person">
                    <div class="personImg">
                        <img class="rounded-circle" src="layout/imgs/ahmed.jpg" alt="Person" width="50" />
                    </div>
                    <div class="caption">
                        <a href="#">أحمد صالح </a>
                        <p> Electronics Specialist </p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-xs-3 col-lg-3 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="0.8s">
                <div class="person">
                    <div class="personImg">
                        <img class="rounded-circle" src="layout/imgs/moe.jpg" alt="Person" width="50" />
                    </div>
                    <div class="caption">
                        <a href="#">محمد جهاد</a>
                        <p> Web Developer </p>
                    </div>
                </div>
            </div>
            
            
            
            <div class="col-xs-3 col-lg-3 col-md-6 col-sm-12 wow fadeInDown" data-wow-delay="1s">
                <div class="person">
                    <div class="personImg">
                        <img class="rounded-circle" src="layout/imgs/ahmed.jpg" alt="Person" width="50" />
                    </div>
                    <div class="caption">
                        <a href="#">أحمد صالح </a>
                        <p> Electronics Specialist </p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

    
<section class="blog">
    <div class="container">
        <div class="row">
            <div class="top col-12 wow fadeInUp" data-wow-delay="0.2s">
                <h2 class="top-title">المدونة</h2>
                <a href="blog" class="btn btn-info"> المزيد من التدوينات </a>
            </div>
            
            <?php 
    
            $stmt = $con->prepare("SELECT * FROM blog ORDER BY id DESC LIMIT 2");

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

<div class="youtube">
    <div class="container">
        <div class="row">
            
            <div class="content col-xs-6 col-md-6 col-sm-12">
                <h3 class="wow fadeInUp" data-wow-delay="0.2s">تابعنا على اليوتيوب</h3>
                <span class="wow fadeInUp" data-wow-delay="0.4s"> العديد من الكورسات والتقارير والمراجعات تجدونها في قناة Tech &amp; Eng على اليوتيوب </span>
            </div>
            
            <div class="link col-md-6 col-md-offset-2">
            <a class="btn wow fadeInUp" data-wow-delay="0.2s" href="https://www.youtube.com/c/TECHENG" target="_blank"><i class="fab fa-youtube"></i> شاهد قناتنا على يوتيوب</a>
            </div>
            
        </div>
    </div>
</div>

</div>
<?php

include $tpl . 'footer.php';

ob_end_flush();

?>