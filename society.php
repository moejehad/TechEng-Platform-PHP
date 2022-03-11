<?php 

ob_start();

session_start();

$pageTitle = 'المجتمع';
 
include 'init.php';

include 'includes/templeats/nav.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'View' ;

/*
report();
*/
if($do == 'View'){
    
$stmt = $con->prepare("SELECT * FROM society ORDER BY id DESC");
                        
$stmt->execute();
                        
$rows = $stmt->fetchAll();
        
$count = $stmt->rowCount();  
    
if($count > 0){
    
?>

<section class="sosiety">
    <div class="container">
        <div class="row">
            
            <div class="top col-12">
                <h1 class="title wow slideInUp float-right" data-wow-delay="0.1s">المجتمع</h1>
                <button type="button" class="btn btn-info wow slideInUp float-left" data-wow-delay="0.3s" data-toggle="modal" data-target="#add">
                  أضف سؤال 
                </button>
            </div>
            <?php if(isset($_SESSION['user'])){ ?>
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة سؤال</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="?do=add" method="POST">
                        <input class="form-control" type="text" name="title" placeholder="عنوان السؤال" required />
                        <select class="form-control" name="type" required>
                            <option value="تصميم">تصميم </option> 
                            <option value="برمجة">برمجة</option>
                            <option value="ذكاء اصطناعي">ذكاء اصطناعي</option>
                        </select>
                        <textarea rows="4" class="form-control" name="content" placeholder="محتوي السؤال" required></textarea>
                        
                        <div class="u-margin-bottom u-checkbox">
                            <label for="confirm">
                                <input name="confirm" id="confirm" type="checkbox" value="0" required>
                                <span>راجعت محتوى السؤال وهو لا يخالف</span>
                                <a href="/terms" target="_blank" class="u-clr--primary"> شروط المنصة</a>
                            </label>
                        </div>
                        
                        <input type="submit" class="form-control btn btn-primary btn-block" value="اضافة"/>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php } else { ?>
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">                     
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة سؤال</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h5>يجب عليك تسجيل الدخول لطرح سؤال في المجتمع </h5>
                      <a class="form-control btn btn-primary" href="login">تسجيل دخول</a>
                  </div>
                </div>
              </div>
            </div>    
            <?php } ?>
        <div class="qustions col-12">
            <?php foreach($rows as $row){ 
                $userID = $row['userID'];        
                $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
                $stmt1->execute(array($userID));
                $user = $stmt1->fetch();
                ?>
                <div class="qus wow slideInUp" data-wow-delay="0.1s">
                        <div class="row">
                            <div class="col-xl-10 col-md-12 about">
                                <h5><img class="img-responsive rounded-circle" src="images/<?php echo $user['photo']?>" width="30" height="30" /> 
                                    <?php echo $user['username']?> <span> <i class="fa fa-calendar"></i> <?php  echo $row['date']?> </span> </h5>
                                <a href="question?t=<?php echo str_replace(' ','-',$row['title'])?>&id=<?php echo $row['id']?>"><?php echo $row['title']?></a>
                                <p class="btn btn-info"><?php echo $row['type']?></p>
                            </div>
                            <div class="col-xl-2 col-md-12 views">
                                <span><?php echo $row['counter']?></span>
                                <span>مشاهدات</span>
                            </div>
                        </div>
                    </div>
                <?php } }else {echo '<div class="alert alert-danger">لم يتم اضافة أي سؤال بعد</div>';} ?>
                </div>
        </div>
    </div>
</section>

<?php }elseif($do == 'add'){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $title           = $_POST['title'];
        $type            = $_POST['type']; 
        $content         = $_POST['content']; 
        $term            = $_POST['confirm']; 
                                                           
        $stmt = $con->prepare("INSERT INTO society 
        (userID, title, type, content , term , date)
        VALUES(:zuser , :ztitle, :ztype, :zcontent , :zconfirm , now() ) ");

        $stmt->execute(array(

            'zuser'         => $_SESSION['Uid'],
            'ztitle'        => $title,
            'ztype'         => $type,
            'zcontent'      => $content,
            'zconfirm'      => $term


        ));
          
        header('Location: society');
        exit();
                
    }
          
}

include $tpl . 'footer.php';

ob_end_flush();

?>