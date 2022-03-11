<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'المدونة';
    
include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; ?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
        
    <button type="button" class="add btn btn-primary float-left" data-toggle="modal" data-target="#add"> اضافة تدوينة <i class="fa fa-plus"></i> </button>
        
    </div>
    <div class="card-body">
        

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اضافة تدوينة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="img" class="form-control" />
            <input type="text" name="title" class="form-control" placeholder="عنوان التدوينة" />
            <textarea rows="10" name="text" class="form-control" placeholder="النص"></textarea> 
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
        
        
        $title          = $_POST['title'];
        $text           = $_POST['text'];
        $user           = $_SESSION['ID'];

        if(empty($formErrors)){
                           
            if(!empty($ImgName)){
            
                move_uploaded_file($ImgTmp, '../images/' . $ImgName );
                    
                $stmt = $con->prepare("INSERT INTO blog 
                (title, text ,img , user , date)
                VALUES(:ztitle , :ztext, :zimg, :zuser , now() ) ");

                $stmt->execute(array(

                    'ztitle'      => $title,
                    'ztext'       => $text,
                    'zimg'        => $ImgName,
                    'zuser'       => $user,

                ));
          
                header('Location: blog?do=Manage');
                exit();
                
                }
          
        }
    
}
        
    $stmt = $con->prepare("SELECT * FROM blog ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
    
        
?>


        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>الصورة</td>
            <td>العنوان</td>
            <td>النص</td>
            <td>الناشر </td>
            <td>التاريخ </td>
            <td> التحكم </td>
        </tr>

            <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                
                echo "<td><img src='../images/" . $row['img'] . " ' width='40' /></td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['text'] . "</td>";
                
                $userID = $row['user'];        
                $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
                $stmt1->execute(array($userID));
                $userInfo = $stmt1->fetch(); 
                
                echo "<td>" . $userInfo['username'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>
                <a href='blog?do=Edit&ID=" . $row['id'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a>
                <a href='blog?do=Delete&ID=" . $row['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo "</td>" ;
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    }elseif($do == 'Edit'){ 
        
    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM blog WHERE id = ? LIMIT 1");
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
                <a href="blog?do=DeleteImg&ID=<?php echo $row['id'] ?>">حذف</a>
                <input class="hide" type="file" name="photo" value="<?php echo $row['img'] ?>" />
                
                <?php }else { ?>
                    <label>رفع صورة</label>
                    <input type="file" name="img" class="form-control" required />
                  <?php } ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
            <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-sm-10">
                <textarea rows="10" name="text" class="form-control" required="required"><?php echo $row['text'] ?></textarea>
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
        $stmt = $con->prepare("SELECT * FROM blog WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM blog WHERE id = :zuser");
            $stmt->bindParam(":zuser", $id);
            $stmt->execute();
            
            header('Location:  blog?do=Manage');
            exit();

        }else {
            
            echo '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
                    
        }
        
        
    }elseif($do == 'DeleteImg'){
                            
            $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
            $stmt = $con->prepare("UPDATE blog SET img = ? WHERE id = ?");
            
            $stmt->execute(array("", $id));
        
            header('Location:  blog?do=Edit&ID= ' . $id . ' ');
            exit();
        
        
    }elseif($do = 'Update'){ 
                
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id             = $_POST['userid'];
            $title          = $_POST['title'];
            $text           = $_POST['text'];            
            
            $ImgName = $_FILES['img']['name'];
            $ImgSize = $_FILES['img']['size'];
            $ImgTmp  = $_FILES['img']['tmp_name'];
            $ImgType = $_FILES['img']['type'];
            
            $ImgAllowedExtension = array("jpeg", "jpg","png","gif");
            
            
            if(!empty($ImgName)){
            
            move_uploaded_file($ImgTmp, '../images/' . $ImgName );
                
            $stmt = $con->prepare("UPDATE blog SET title = ?, text = ?, img = ? , WHERE id = ?");
            
            $stmt->execute(array($title , $text, $ImgName , $id));
        
            header('Location:  blog?do=Edit&ID= ' . $id . ' ');
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
    
    header('Location: index');
    
    exit();
}

ob_end_flush();

?>