<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'الكورسات';
    
include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; ?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
        
    <button type="button" class="add btn btn-primary float-left" data-toggle="modal" data-target="#add"> اضافة كورس <i class="fa fa-plus"></i> </button>
        
    </div>
    <div class="card-body">
        

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اضافة كورس</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="img" class="form-control" />
            <input type="text" name="name" class="form-control" placeholder="اسم الكورس" />
            <input type="text" name="short" class="form-control" placeholder="وصف صغير" />
            <input type="text" name="author" class="form-control" placeholder="مقدم الدورة" />
            <textarea rows="3" name="description" class="form-control" placeholder="وصف مفصل"></textarea> 
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
        $short         = $_POST['short'];
        $author        = $_POST['author']; 
        $description   = $_POST['description']; 
    
        if(empty($name)){
            $formErrors[] = 'يرجى كتابة اسم الكورس';
        }

        if(empty($short)){

            $formErrors[] = 'يرجى كتابة وصف صغير الكورس';
        }
        
        if(empty($author)){

            $formErrors[] = 'يرجى كتابة اسم مقدم الكورس';
        }
        
        if(empty($description)){

            $formErrors[] = 'يرجى كتابة وصف مفصل الكورس';
        }

        if(empty($ImgName)){

            $formErrors[] = 'يرجى اضافة صورة';
        }

        if(empty($formErrors)){
                           
                if(!empty($ImgName)){
            
                move_uploaded_file($ImgTmp, '../images/' . $ImgName );
                    
                $stmt = $con->prepare("INSERT INTO courses 
                (img, name, shortDes, description , author , date)
                VALUES(:zimg , :zname, :zshort, :zdesc , :zauthor , now() ) ");

                $stmt->execute(array(

                    'zimg'         => $ImgName,
                    'zname'        => $name,
                    'zshort'       => $short,
                    'zdesc'        => $description,
                    'zauthor'      => $author


                ));
          
                header('Location: courses?do=Manage');
                exit();
                
                }
          
        }
    
}
        
    $stmt = $con->prepare("SELECT * FROM courses ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
    
        
?>
        
        <a href="videos" class="btn btn-primary">الفيديوهات</a>
        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>الصورة</td>
            <td>الاسم</td>
            <td>مقدم الكورس</td>
            <td>وصف صغير</td>
            <td>وصف مفصل</td>
            <td> التحكم </td>
        </tr>

            <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                
                echo "<td><img src='../images/" . $row['img'] . " ' width='40' /></td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['author'] . "</td>";
                echo "<td>" . $row['shortDes'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>
                <a href='courses?do=Edit&ID=" . $row['id'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a>
                <a href='courses?do=Delete&ID=" . $row['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo "</td>" ;
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    }elseif($do == 'Edit'){ 
        
    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM courses WHERE id = ? LIMIT 1");
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
                <a href="courses?do=DeleteImg&ID=<?php echo $row['id'] ?>">حذف</a>
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
            <input type="text" name="shortDes" value="<?php echo $row['shortDes'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
                <input type="text" name="author" value="<?php echo $row['author'] ?>" class="form-control" required="required"/>
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
        $stmt = $con->prepare("SELECT * FROM courses WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM courses WHERE id = :zuser");
            $stmt->bindParam(":zuser", $id);
            $stmt->execute();
            
            header('Location:  courses?do=Manage');
            exit();

        }else {
            
            echo '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
                    
        }
        
        
    }elseif($do == 'DeleteImg'){
                            
            $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
            $stmt = $con->prepare("UPDATE courses SET img = ? WHERE id = ?");
            
            $stmt->execute(array("", $id));
        
            header('Location:  courses?do=Edit&ID= ' . $id . ' ');
            exit();
        
        
    }elseif($do = 'Update'){ 
                
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id             = $_POST['userid'];
            $name           = $_POST['name'];
            $short          = $_POST['shortDes'];            
            $author         = $_POST['author'];            
            $description    = $_POST['description'];            
            
            $ImgName = $_FILES['photo']['name'];
            $ImgSize = $_FILES['photo']['size'];
            $ImgTmp = $_FILES['photo']['tmp_name'];
            $ImgType = $_FILES['photo']['type'];
            
            $ImgAllowedExtension = array("jpeg", "jpg","png","gif");
            
            
            if(!empty($ImgName)){
            
            move_uploaded_file($ImgTmp, '../images/' . $ImgName );
                
            $stmt = $con->prepare("UPDATE courses SET img = ? , name = ?, shortDes = ?, author = ? , description = ? WHERE id = ?");
            
            $stmt->execute(array($ImgName , $name, $short , $author, $description, $id));
        
            header('Location:  courses?do=Edit&ID= ' . $id . ' ');
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