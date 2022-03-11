<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'Setting';
    
include "init.php"; 

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

if($do == 'Manage'){ 
             
$stmt = $con->prepare("SELECT * FROM text");
                        
$stmt->execute();
                        
$rows = $stmt->fetchAll();
    
        
?>



<div class="card attend">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body text">
            <?php foreach($rows as $row){?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>?do=Update" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Website Name</label>
                    <input type="text" name="website" class="form-control" value="<?php echo $row['website'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Groom Name</label>
                    <input type="text" name="groom" class="form-control" value="<?php echo $row['groom'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>اسم العريس</label>
                    <input type="text" name="groomAr" class="form-control" value="<?php echo $row['groomAr'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Brdie Name</label>
                    <input type="text" name="bride" class="form-control" value="<?php echo $row['bride'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>إسم العروس</label>
                    <input type="text" name="brideAr" class="form-control" value="<?php echo $row['brideAr'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $row['date'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>التاريخ</label>
                    <input type="text" name="dateAr" class="form-control" value="<?php echo $row['dateAr'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Index Text</label>
                    <textarea class="form-control" name="main"><?php echo $row['main'];?></textarea>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>نص الصفحة الرئيسية</label>
                    <textarea class="form-control" name="mainAr"><?php echo $row['mainAr'];?></textarea>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Hotel Name</label>
                    <input type="text" name="hotelName" class="form-control" value="<?php echo $row['hotelName'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Hotel Location</label>
                    <input type="text" name="hotelLoc" class="form-control" value="<?php echo $row['hotelLoc'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Hotel Email</label>
                    <input type="email" name="hotelEmail" class="form-control" value="<?php echo $row['hotelEmail'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Hotel Phone</label>
                    <input type="text" name="hotelPhone" class="form-control" value="<?php echo $row['hotelPhone'];?>" />
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12">
                    <label>Booking Link</label>
                    <input type="url" name="Booking" class="form-control" value="<?php echo $row['Booking'];?>" />
                </div>
            </div>
            <input type="submit" class="form-control btn btn-info" value="Update"/>
            </form>
            <a class="btn btn-info" href="homeimg.php">Upload Home Image</a>
            <?php } ?>
    </div>
    
</div>


    

<?php
}elseif($do = 'Update'){ 
            
        
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        
            $website = $_POST['website'];     
            $groom = $_POST['groom'];     
            $groomAr = $_POST['groomAr'];     
            $bride = $_POST['bride'];     
            $brideAr = $_POST['brideAr'];     
            $date  = $_POST['date'];     
            $dateAr  = $_POST['dateAr'];     
            $main  = $_POST['main'];     
            $mainAr  = $_POST['mainAr'];     
            $hotelName  = $_POST['hotelName'];     
            $hotelLoc  = $_POST['hotelLoc'];     
            $hotelEmail  = $_POST['hotelEmail'];     
            $hotelPhone  = $_POST['hotelPhone'];     
            $Booking  = $_POST['Booking'];     
                    
            $stmt = $con->prepare("UPDATE text SET  website = ?, groom = ? , groomAr = ? , bride = ? , brideAr = ? , date = ? , dateAr = ? , main = ? , mainAr = ? , hotelName = ? , hotelLoc = ? , hotelEmail = ? , hotelPhone = ? , Booking = ?");
            
            $stmt->execute(
                array(
                    $website,
                    $groom,
                    $groomAr,
                    $bride ,
                    $brideAr ,
                    $date , 
                    $dateAr , 
                    $main ,
                    $mainAr ,
                    $hotelName ,
                    $hotelLoc ,
                    $hotelEmail , 
                    $hotelPhone,
                    $Booking
                ));
            
            header('Location:  '. $_SERVER['PHP_SELF'] . '?do=Manage');
    
            exit();
        }else{
            
            header('Location:  '. $_SERVER['PHP_SELF'] . '?do=Manage');
    
            exit();
            
        }
            
        
    }elseif($do = 'add'){ 
            
        
        echo 'googd';
            
        
    }
     
    include $tpl . 'footer.php';

} else {
    
    header('Location: index.php');
    
    exit();
}

ob_end_flush();

?>