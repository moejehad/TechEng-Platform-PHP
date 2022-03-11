<?php 

ob_start();

session_start();

$pageTitle =  str_replace('-',' ',$_GET['name']);
 
include 'init.php';

include 'includes/templeats/nav.php';

$id = $_GET['id'];

$stmt = $con->prepare("SELECT * FROM event WHERE id LIKE '%$id%' ORDER BY id DESC");
                        
$stmt->execute(array($id));
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    
if($count > 0){
        
/*
report();
*/
    
$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $event    = $_GET['id'];
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];

        if(empty($name)){

            $formErrors[] = 'يرجى كتابة اسمك';

        }

        if(empty($email)){

            $formErrors[] = 'يرجى كتابة بريدك الإلكتروني';

        }
    
        if(empty($phone)){

            $formErrors[] = 'يرجى كتابة رقم هاتفك';

        }
    
        if(empty($formErros)){
                    
            $stmt = $con->prepare("INSERT INTO attend 
            (event , name,email, phone , date )
            VALUES(:zevent , :zname, :zmail , :zphone , now() ) ");

            $stmt->execute(array(

                'zevent'      => $event,
                'zname'       => $name,
                'zmail'       => $email,
                'zphone'      => $phone

            ));

           $success = 'تم الارسال بنجاح ';
            
      }
    
}

?>


<section class="event">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <img src="images/<?php echo $row['img'] ?> " alt="<?php echo $row['name'] ?>" title="<?php echo $row['name'] ?>" width="100%" />
                </div>
                <div class="col-xl-6 col-md-12">
                    <?php 
                    if(isset($success)){
                        echo '<div class="alert alert-success">' . $success . '</div>';
                    }
                    
                    ?>
                    <h4 class="title" >كورس <?php echo $row['name'] ?> </h4>
                    <h5><i class="fa fa-map-pin"></i> <?php echo $row['address'] ?> </h5>
                    <span class="date"><i class="fa fa-calendar"></i> <span><?php echo $row['date'] ?> </span></span>
                    <span class="time"><i class="fa fa-clock"></i> <span><?php echo $row['time'] ?> </span></span>
                    <p><?php echo $row['description'] ?></p>
                    <?php if(isset($_SESSION['user'])){ ?>
                        
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      حضور
                    </button>
                    
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">الرجاء تعبئة بياناتك </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="event?name=<?php echo str_replace(' ','-',$row['name'])?>&id=<?php echo $row['id'] ?>" method="POST">
                                <input type="text" name="name" class="form-control" placeholder="الاسم كامل" required />
                                <input type="email" name="email" class="form-control" placeholder="البريد الالكتروني" required />
                                <input type="text" name="phone" class="form-control" placeholder="رقم الهاتف" required />
                                <input type="submit" class="form-control btn btn-block" value="ارسال" />
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <?php }else {
                        echo '<a href="login" class="btn btn-info">حضور</a>';
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