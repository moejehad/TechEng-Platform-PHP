<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'الفيديوهات';
    
include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; ?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
        
    <button type="button" class="add btn btn-primary float-left" data-toggle="modal" data-target="#add"> اضافة فيديو <i class="fa fa-plus"></i> </button>
        
    </div>
    <div class="card-body">
        

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">اضافة فيديو</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <input type="text" name="name" class="form-control" placeholder="العنوان" required />
            <input type="url" name="link" class="form-control" placeholder="الرابط" required />
            
            <select class="form-control" name="course" style="margin-bottom: 20px;height: 45px;" required>
            <option>الكورس</option>
                <?php 
                    $cats = getAllfrom('courses','id');
                    foreach ($cats as $cat){

                       echo "<option value='" . $cat['id'] . "'>" . $cat['name'] . "</option>";
                    }

                ?>
            </select>
            
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
        
        $name          = $_POST['name'];
        $link          = $_POST['link'];
        $course        = $_POST['course']; 
    
        if(empty($name)){
            $formErrors[] = 'يرجى كتابة اسم الفيديو';
        }

        if(empty($link)){

            $formErrors[] = 'يرجى وضع رابط الفيديو';
        }
        
        if(empty($course)){

            $formErrors[] = 'يرجى اختيار الكورس';
        }

        if(empty($formErrors)){

            $stmt = $con->prepare("INSERT INTO videos 
                (name, link, course, date)
                VALUES(:zname, :zlink, :zcourse , now() ) ");

                $stmt->execute(array(

                    'zname'        => $name,
                    'zlink'        => $link,
                    'zcourse'      => $course,


                ));

        $stmt4 = $con->prepare("SELECT * FROM subscriptions ORDER BY id DESC");
                        
        $stmt4->execute();

        $cours = $stmt4->fetchAll();
        
        foreach($cours as $cor){
            
            if($course == $cor['course']){
                                
            $sender = $_SESSION['ID'];
            $receiver = $cor['student'];
            $type = "video";
            $details =  $name;
            $detailsID =  $cor['course'];
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
        }
            header('Location: videos?do=Manage');
            exit();
        }
    
}
        
    $stmt = $con->prepare("SELECT * FROM videos ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
      
        
?>
        
        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>العنوان</td>
            <td>الرابط</td>
            <td>الكورس</td>
            <td>تاريخ النشر</td>
            <td>التحكم</td>
        </tr>

            <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><a href='" . $row['link'] . "' target='_blanck'>" . $row['link'] . "</a></td>";
                
                $userID = $row['course'];        
                $stmt10 = $con->prepare("SELECT * FROM courses WHERE id LIKE '%$userID%' ");
                $stmt10->execute(array($userID));
                $courseInfo = $stmt10->fetch(); 
                
                echo "<td><a href='../course?name=" . str_replace(' ','-',$courseInfo['name']) . "&id=" . $row['course'] ."' target='_blanck'>" . $courseInfo['name'] . "</a></td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>
                <a href='videos?do=Edit&ID=" . $row['id'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a>
                <a href='videos?do=Delete&ID=" . $row['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo "</td>" ;
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    }elseif($do == 'Edit'){ 
        
    $id = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM videos WHERE id = ? LIMIT 1");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
        
    if($stmt->rowCount() > 0){ ?>

    <div class="container">
    <form class="form-horizontal edit" action="?do=Update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="userid" value="<?php echo $id ?>"/>

        <div class="form-group">
            <div class="col-sm-10">
            <input type="text" name="name" value="<?php echo $row['name'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
            <input type="url" name="link" value="<?php echo $row['link'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">                
                <select class="form-control" name="course" style="margin-bottom: 20px;height: 45px;" required>
                <option value="<?php echo $row['course'] ?>">الكورس</option>
                    <?php 
                        $cats = getAllfrom('courses','id');
                        foreach ($cats as $cat){
                            
                           echo "<option value='" . $cat['id'] . "'>" . $cat['name'] . "</option>";
                        }

                    ?>
                </select>
                
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
        $stmt = $con->prepare("SELECT * FROM videos WHERE id = ? LIMIT 1");
        $stmt->execute(array($id));
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM videos WHERE id = :zuser");
            $stmt->bindParam(":zuser", $id);
            $stmt->execute();
            
            header('Location:  videos?do=Manage');
            exit();

        }else {
            
            echo '<div class="alert alert-danger">هذا الفيديو غير موجود</div>';
                    
        }
        
        
    }elseif($do = 'Update'){ 
                
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id             = $_POST['userid'];
            $name           = $_POST['name'];
            $link           = $_POST['link'];            
            $course         = $_POST['course'];            
                
            $stmt = $con->prepare("UPDATE videos SET name = ?, link = ?, course = ? WHERE id = ?");
            
            $stmt->execute(array($name, $link , $course, $id));
        
            header('Location:  videos?do=Edit&ID= ' . $id . ' ');
            exit();
              
            
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