<?php 

ob_start();

session_start();

if(isset($_SESSION['user'])){
   
$pageTitle = 'رفع صورة شخصية';
 
include 'init.php';

include 'includes/templeats/nav.php';

$id = $_SESSION['Uid'];

$stmt = $con->prepare("SELECT * FROM users WHERE id LIKE '%$id%' ");
                        
$stmt->execute(array($id));
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    
if($count > 0){

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;


?>

<section class="member">
    <div class="cover">
        <div class="container">
            <div class="text-center">
                <h3>رفع صورة شخصية</h3>
            </div>
        </div>
    </div>
    
    <div class="container">
        <?php if($do == 'Manage'){  ?>
        <form action="?do=Upload" method="POST" enctype="multipart/form-data">
            <?php if(!empty($row['photo'])){ ?>
            
            <div class="image text-center">
                <div class="user-img" style="background:url('images/<?php echo $row['photo'] ?>') center;height: 100px;width: 100px;background-size: cover;margin:auto;" title="<?php echo $row['username']?>"></div>
                <div class="delet">
                    <a href="Photo?do=DeleteImg">حذف</a>
                </div>
                <input class="hide" type="file" name="photo" value="<?php echo $row['photo'] ?>" />
            </div>   
            
            <?php }else { ?>
            <label>رفع صورة</label>
            <input type="file" name="photo" class="form-control" required /> 
            <input type="submit" value="رفع" class="btn btn-primary btn-block form-control"/>
            <?php } ?>
        </form>
        <?php }elseif($do == 'DeleteImg'){
                                    
            $stmt = $con->prepare("UPDATE users SET photo = ? WHERE id = ?");
            
            $stmt->execute(array("", $row['id']));
        
            header('Location:  Photo');
            exit();
        
        
        }elseif($do = 'Upload'){ 
        
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $ImgName = $_FILES['photo']['name'];
            $ImgSize = $_FILES['photo']['size'];
            $ImgTmp = $_FILES['photo']['tmp_name'];
            $ImgType = $_FILES['photo']['type'];
            
            $ImgAllowedExtension = array("jpeg", "jpg","png","gif");
            
            if(!empty($ImgName)){
            
                $Img = rand(0, 1000000000) . '_' . $ImgName;

                move_uploaded_file($ImgTmp, 'images/' . $Img );

                $stmt = $con->prepare("UPDATE users SET photo = ? WHERE id = ?");

                $stmt->execute(array($Img , $row['id']));

                header('Location:  Photo ');
                exit();
            }
        }else{

                echo '<div class="alert alert-danger">عذرا , لا تستطيع زيارة هذه الصفحة </div>';

        }
                
        
        }?>
    </div>
</section>

<?php
 
}else {
    echo 'لا يوجد مستخدم بهذا الاسم';
}

include $tpl . 'footer.php';

}else {
    header('Location: login?source=member');
    exit();
}
ob_end_flush();

?>