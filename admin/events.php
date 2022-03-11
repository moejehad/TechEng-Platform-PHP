<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'الفعاليات';
    
include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; ?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
        
    <button type="button" class="add btn btn-primary float-left" data-toggle="modal" data-target="#add"> اضافة فعالية <i class="fa fa-plus"></i> </button>
        
    </div>
    <div class="card-body">
        

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اضافة فعالية</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="img" class="form-control" />
            <input type="text" name="name" class="form-control" placeholder="اسم الفعالية" />
            <input type="text" name="address" class="form-control" placeholder="العنوان" />
            <input type="text" name="time" class="form-control" placeholder="الوقت" />
            <input type="date" name="date" class="form-control" placeholder="التاريخ" />
            <textarea rows="3" name="description" class="form-control" placeholder="وصف"></textarea> 
            <input type="submit" class="btn btn-info btn-block" value="اضافة"/> 
        </form>
      </div>
    </div>
  </div>
</div>
        
        
<?php        
    if($do == 'Manage'){ 
        
    $formErrors = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $ImgName = $_FILES['img']['name'];
        $ImgSize = $_FILES['img']['size'];
        $ImgTmp = $_FILES['img']['tmp_name'];
        $ImgType = $_FILES['img']['type'];
            
        $ImgAllowedExtension = array("jpeg", "jpg","png","gif");
        
        
        $name          = $_POST['name'];
        $address       = $_POST['address'];
        $time          = $_POST['time']; 
        $date          = $_POST['date']; 
        $description   = $_POST['description']; 

        if(empty($formErrors)){
                           
            if(!empty($ImgName)){
            
                move_uploaded_file($ImgTmp, '../images/' . $ImgName );
                    
                $stmt = $con->prepare("INSERT INTO event 
                (name, description ,img , address , time , date)
                VALUES(:zname , :zdesc, :zimg, :zadd , :ztime , :zdate ) ");

                $stmt->execute(array(

                    'zname'      => $name,
                    'zdesc'      => $description,
                    'zimg'       => $ImgName,
                    'zadd'       => $address,
                    'ztime'      => $time,
                    'zdate'      => $date


                ));
                
                
                $stmt4 = $con->prepare("SELECT id FROM users");
                        
                $stmt4->execute();

                $users = $stmt4->fetchAll();

                foreach($users as $user){

                    $sender = $_SESSION['ID'];
                    $receiver = $user['id'];
                    $type = "event";
                    $details =  $name;
                    $detailsID =  '';
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

                }
                
          
                header('Location: events?do=Manage');
                exit();
                
                }
          
        }
    
}
        
    $stmt = $con->prepare("SELECT * FROM event ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
    
        
?>


        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>الصورة</td>
            <td>الاسم</td>
            <td>وصف</td>
            <td>العنوان</td>
            <td>الوقت </td>
            <td>التاريخ </td>
            <td> التحكم </td>
        </tr>

            <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                
                echo "<td><img src='../images/" . $row['img'] . " ' width='40' /></td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>
                <a href='event?ID=" . $row['id'] . "' class='btn btn-success'>الحضور</a>
                <a href='events?do=Edit&ID=" . $row['id'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a>
                <a href='events?do=Delete&ID=" . $row['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo "</td>" ;
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    }elseif($do == 'Edit'){ 
        
    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM event WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
        
    if($stmt->rowCount() > 0){ ?>

    <div class="container">
    <form class="form-horizontal edit" action="?do=Update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="userid" value="<?php echo $id ?>"/>

        <div class="form-group">
            <div class="col-sm-10 text-center">
                <?php if(!empty($row['img'])){ ?>
                <img src="../images/<?php echo $row['img'] ?>" width="100" />
                <a href="events?do=DeleteImg&ID=<?php echo $row['id'] ?>">حذف</a>
                <input class="hide" type="file" name="photo" value="<?php echo $row['img'] ?>" />
                
                <?php }else { ?>
                    <label>رفع صورة</label>
                    <input type="file" name="photo" class="form-control" required />
                  <?php } ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
            <input type="text" name="name" value="<?php echo $row['name'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
            <input type="text" name="address" value="<?php echo $row['address'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
                <input type="text" name="date" value="<?php echo $row['date'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
                <input type="text" name="time" value="<?php echo $row['time'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
                <textarea name="description" class="form-control" required="required"><?php echo $row['description'] ?></textarea>
            </div>
        </div>
            
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-center">
            <input type="submit" value="حفظ" class="btn btn-primary btn-block"/>
            </div>
        </div>
        
    </form>   
</div>
        
    <?php 
                                 
    }else {
            
            echo "<div class='container'>";
            
                echo '<div class="alert alert-danger">لا يوجد كورس بهذا الاسم</div>';
            
            echo "</div>";
        }
    
        
        
    }elseif($do == 'Delete'){
                

        $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        $stmt = $con->prepare("SELECT * FROM event WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM event WHERE id = :zuser");
            $stmt->bindParam(":zuser", $id);
            $stmt->execute();
            
            header('Location:  events?do=Manage');
            exit();

        }else {
            
            echo '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
                    
        }
        
        
    }elseif($do == 'DeleteImg'){
                            
            $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
            $stmt = $con->prepare("UPDATE event SET img = ? WHERE id = ?");
            
            $stmt->execute(array("", $id));
        
            header('Location:  events?do=Edit&ID= ' . $id . ' ');
            exit();
        
        
    }elseif($do = 'Update'){ 
                
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id             = $_POST['userid'];
            $name           = $_POST['name'];
            $address        = $_POST['address'];            
            $date           = $_POST['date'];            
            $time           = $_POST['time'];            
            $description           = $_POST['description'];            
            
            $ImgName = $_FILES['photo']['name'];
            $ImgSize = $_FILES['photo']['size'];
            $ImgTmp = $_FILES['photo']['tmp_name'];
            $ImgType = $_FILES['photo']['type'];
            
            $ImgAllowedExtension = array("jpeg", "jpg","png","gif");
            
            
            if(!empty($ImgName)){
            
            move_uploaded_file($ImgTmp, '../images/' . $ImgName );
                
            $stmt = $con->prepare("UPDATE event SET name = ?, description = ?, img = ? , address = ? , time = ? , date = ? WHERE id = ?");
            
            $stmt->execute(array($name , $description, $ImgName , $address, $time , $date , $id));
        
            header('Location:  events?do=Edit&ID= ' . $id . ' ');
            exit();
              
            }
            
        }else{
            
            echo '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة </div>';
            
        }
            
        
    }

    echo '</div>';
    echo '</div>';
    
    include $tpl . 'footer.php';

} else {
    
    header('Location: index.php');
    
    exit();
}

ob_end_flush();

?>