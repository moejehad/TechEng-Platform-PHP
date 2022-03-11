<?php 

ob_start();

session_start();

if(isset($_SESSION['user'])){
   
$pageTitle = 'الصفحة الشخصية';
 
include 'init.php';

include 'includes/templeats/nav.php';

$id = $_SESSION['Uid'];

$stmt = $con->prepare("SELECT * FROM users WHERE id LIKE '%$id%' ");
                        
$stmt->execute(array($id));
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    
if($count > 0){
   
$do = isset($_GET['do']) ? $_GET['do'] : 'View' ;
    
/*
report();
*/

?>


<section class="member">
        <div class="cover">
                <div class="container">
                    <div class="row">
                        <?php if($do == 'View'){  ?>
                        <div class="col-xl-2 col-md-6 col-sm-12">
                            <?php if(!empty($row['photo'])){?>
                            <div class="user-img" style="background:url('images/<?php echo $row['photo']?>') center;height: 120px;width: 120px;background-size: cover;" title="<?php echo $row['username']?>"></div>
                            <?php }else { ?>
                            <div class="user-img" style="background:url('layout/imgs/user.png') center;height: 120px;width: 120px;background-size: cover;" title="<?php echo $row['username']?>"></div>
                            <?php } ?>
                        </div>
                        <div class="col-xl-8 col-md-6 col-sm-12">
                            <div class="info">
                            <h3 class="username"><?php echo $row['username']?></h3>

                                <nav class="navbar navbar-expand-lg navbar-light">
                                  <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav">
                                      <li class="nav-item ">
                                        <a class="nav-link" href="?do=Edit">حسابي</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" data-toggle="modal" data-target="#myCourse">كورساتي</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" data-toggle="modal" data-target="#myQas">أٍسئلتي</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="logout">تسجيل خروج</a>
                                      </li>
                                      </ul>
                                  </div>
                                </nav>
                                
                            </div>
                        </div>
                        <div class="col-md-2 hidden-xs hidden-sm"></div>
                        
                        <div class="modal fade" id="myQas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body">
                                <?php 
    
                                $id = $_SESSION['Uid'];
                                                
                                $stmt = $con->prepare("SELECT * FROM society WHERE userID LIKE '%$id%' ORDER BY id DESC");
                        
                                $stmt->execute();

                                $rows = $stmt->fetchAll();  
                                  
                                $count = $stmt->rowCount();  
    
                                if($count > 0){
                                    
                                foreach($rows as $row){
                                    
                                ?>
                                  <a href="question?t=<?php echo str_replace(' ','-',$row['title'])?>&id=<?php echo $row['id']?>"><?php echo $row['title']?></a>
                                  <p><i class="fa fa-eye"></i> <?php echo $row['counter']?> مشاهدة</p>
                                <?php } }else {
                                 echo 'لم تقم بنشر شئ في المجتمع'; 
                                }?>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        
                         <div class="modal fade" id="myCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body">
                                <?php 
    
                                $id = $_SESSION['Uid'];
                                                
                                $stmt = $con->prepare("SELECT * FROM subscriptions WHERE student LIKE '%$id%' ORDER BY id DESC");
                        
                                $stmt->execute();

                                $rows = $stmt->fetchAll();  
                                  
                                $count = $stmt->rowCount();  
    
                                if($count > 0){
                                    
                                foreach($rows as $row){
                                    
                                    $courseID = $row['course'];

                                    $stmt = $con->prepare("SELECT * FROM courses WHERE id LIKE '%$courseID%' ");

                                    $stmt->execute();

                                    $course = $stmt->fetch();  
                                    
                                ?>
                                  <div class="course">
                                     <a href="course?name=<?php echo str_replace(' ','-',$course['name'])?>&id=<?php echo $course['id'] ?>"><?php echo $course['name']?></a>
                                  </div>
                                <?php } }else {
                                 echo 'لم تقم بالاشتراك في كورسات'; 
                                }?>
                              </div>
                            </div>
                          </div>
                        </div>
                        
<?php }elseif($do == 'Edit'){ ?>
                        
        <div class="col-12 text-center">
            <h3>تعديل بيانات الحساب</h3>
        </div>
                        
        </div>
    </div>
</div>
            
                <div class="container">                        
                    <form action="?do=Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="userid" value="<?php echo $row['id'] ?>"/>
                       
                        <div class="row">
                            <div class="image col-xl-6 col-md-12">
                                <a class="upload btn btn-primary" href="Photo"> <i class="fa fa-upload"></i>  تحميل صورة شخصية </a>
                            </div>
                            
                            <div class="col-xl-6 col-md-12">
                                <label>الاسم</label>
                                <input type="text" name="name" value="<?php echo $row['username'] ?>" class="form-control" required/>
                            </div>
                        
                            <div class="col-xl-6 col-md-12">
                                <label>البريد الإلكتروني</label>
                                <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" readonly />
                            </div>
                            
                            <div class="col-xl-6 col-md-12">
                                <label>كلمة المرور</label>
                                <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
                                <input type="password" name="pass" class="form-control" placeholder="كلمة المرور (اتركه فارغ اذا لم ترغب في تغيرها )" />
                            </div>
                            
                            <div class="col-12 text-center">
                            <input type="submit" value="حفظ" class="form-control btn btn-primary btn-block"/>
                            </div>

                        </div>
                        </form> 
                    </div>    
<?php }elseif($do = 'Update'){ 
                
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id             = $_POST['userid'];
            $name           = $_POST['name'];
            $email          = $_POST['email'];                     
            $pass = empty($_POST['pass']) ?  $_POST['oldpassword'] :  sha1($_POST['pass']);        
            
    
                
            $stmt = $con->prepare("UPDATE users SET email = ?, username = ? , password = ? WHERE id = ?");
            
            $stmt->execute(array($email , $name , $pass, $id));
        
            header('Location:  member?do=Edit ');
            exit();
              
            
        }else{
            
            echo '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة </div>';
            
        }
            
        
    } ?>
                    
</section>


<?php
 
}else {
    echo 'لا يوجد مستخدم بهذا الاسم';
}

include $tpl . 'footer.php';

}else {
    header('Location: login');
    exit();
}
ob_end_flush();

?>