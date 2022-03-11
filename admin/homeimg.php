<?php 

ob_start();

session_start();

$pageTitle = 'upload image';
 
include 'init.php';

$stmt = $con->prepare("SELECT * FROM imags");
                        
$stmt->execute();
                        
$row = $stmt->fetch();
        
$count = $stmt->rowCount();  
    

$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $Img   = $_FILES['img'];
    
        $ImgName    = $_FILES['img']['name'];
        $ImgSize    = $_FILES['img']['size'];
        $ImgTmp     = $_FILES['img']['tmp_name'];
        $ImgType    = $_FILES['img']['type'];
        $ImgAllowedExtension = array("jpeg", "jpg","png","gif");

        if($ImgSize > 4194304){

             $formErros[] = 'يجب أن يكون حجم الصورة أقل من 4 ميغابايت';
        }
    
        if(empty($Img)){
            echo 'please ypload your image';
        }

      if(empty($formErros)){
            
            move_uploaded_file($ImgTmp, '' . $ImgName );
                         
            $stmt = $con->prepare("INSERT INTO imags 
            (name, type ,date)
            VALUES(:zname , :ztype, now()) ");
            
            $stmt->execute(array(
                'zname'    => $ImgName,
                'ztype'    => "index"
            ));
            
            header('Location:  '. $_SERVER['PHP_SELF'] );

            exit();
            
        }else {
          
          echo $formErros;
      }   
}

?>

<section class="gallery">
    <div class="container">
        <div class="top" style="margin:30px 0;">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <div class="input-group input-group-sm mb-3">
                    <input style="height:40px;" type="file" name="img" class="btn btn-light form-control"/>
                    <div class="input-group-prepend">
                      <input type="submit" class="form-control btn btn-info" 
                    value="<?php if(isset($_GET['lang'])){
                    if($_GET['lang'] = 'ar'){ echo 'رفع' ;
                    } }else {echo 'Upload' ;}?>"/>  
                    </div>
                </div>
            </form>
        </div>

<?php if($count > 0){ 
        
$getImg = $con->prepare("SELECT * FROM imags ORDER BY id DESC");
    
$getImg->execute();
    
$info = $getImg->fetchAll();
    
?>
        
<div class="container gallery-container">
    <div class="tz-gallery">
        <div class="row mb-3">
            <?php foreach($info as $infoI){ ?>
            <?php if($infoI['type'] != 'photo' && $infoI['type'] != 'video'){ ?>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="card">
                    <div width="100%" class="img" style="background-image:url(<?php echo $infoI['name'] ?>);height: 250px;width: 100%;background-position: center;background-size: cover;"></div>
                </div>
            <a href="<?php echo $_SERVER['PHP_SELF'] . "?do=Delete&ID=" . $infoI['id']?>" class="btn btn-danger">Delete</a>
            </div>

            <?php } } ?>
        </div>
  
    </div>
  
</div>
     

<?php 
    
if(isset($_GET['do'])){
    $do = $_GET['do'];
    $id = $_GET['ID'];
    if($do = "delete"){
        
        $stmt = $con->prepare("SELECT * FROM imags WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();

        if($stmt->rowCount() > 0){ 

            $stmt = $con->prepare("DELETE FROM imags WHERE id = :zuser");
            $stmt->bindParam(":zuser", $id);
            $stmt->execute();

            header('Location:  '. $_SERVER['PHP_SELF'] . ' ');

            exit();
        }else {
            header('Location:  '. $_SERVER['PHP_SELF'] . ' ');

            exit();
        }        
        
    }else{
        header('Location:  '. $_SERVER['PHP_SELF'] . ' ');

        exit();
    }
    
    
} 
    
}else {
        
    echo '<div class="no-photo alert alert-danger">No photos uploaded yet</div>';

}
echo '</div>';
echo '</section>';
                  
include $tpl . 'footer.php';

ob_end_flush();

?>