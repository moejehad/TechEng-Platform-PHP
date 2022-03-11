<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'الأعضاء';
    
include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; ?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body">
        
<?php        
    if($do == 'Manage'){ 
        
    $stmt = $con->prepare("SELECT * FROM users WHERE status != 1  ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
        
?>


        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>الرقم</td>
            <td>الاسم</td>
            <td>البريد الإلكتروني</td>
            <td> التحكم </td>
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>
                <a href='members?do=Edit&ID=" . $row['id'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a>
                <a href='members?do=Delete&ID=" . $row['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo "</td>" ;
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    }elseif($do == 'Edit'){ 
        
    $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        
    $stmt = $con->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ ?>

    <div class="container">
    <form class="form-horizontal edit" action="?do=Update" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>"/>

        <div class="form-group">
            <div class="col-sm-10">
            <input type="text" name="username" value="<?php echo $row['username'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
            <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-10">
            <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
            <input type="password" name="newpassword" autocomplete="new-password" class="form-control" placeholder="كلمة المرور"/>
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
            
                echo '<div class="alert alert-danger">لا يوجد مستخدم بهذا الإسم</div>';
            
            echo "</div>";
        }
    
        
        
    }elseif($do == 'Delete'){
                

        $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        $stmt = $con->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute(array($userid));
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM users WHERE id = :zuser");
            $stmt->bindParam(":zuser", $userid);
            $stmt->execute();
            
            header('Location:  members?do=Manage');
            exit();

        }else {
            
            echo '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
                    
        }
        
        
    }elseif($do = 'Update'){ 
                
        echo "<div class='container'>";
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $id      = $_POST['userid'];
            $user    = $_POST['username'];
            $email   = $_POST['email'];            
            $pass= empty($_POST['newpassword']) ?  $_POST['oldpassword'] :  sha1($_POST['newpassword']);
            
            
            $formErros = array();
            
            if(strlen($user) < 6 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أكثر من 6 حروف';
            }
            if(strlen($user) > 20 ){
                
                $formErros[] =  'يجب أن يكون إسم المستخدم أقل من 20 حروف';
            }
            
            if(empty($user)){
                
                $formErros[] =  'الرجاء ملئ اسم المستخدم';
            }
            
            if(empty($email)){
                
                $formErros[] = 'الرجاء ملئ البريد الإلكتروني';
            }
            
            foreach($formErros as $error){
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
             
            if(empty($formErros)){
                
                $stmt2 = $con->prepare("SELECT * FROM users WHERE email = ? AND id != ? ");
                
                $stmt2->execute(array($email, $id));
                
                $count = $stmt2->rowCount();
                
                if ($count == 1){
                    
                    $theMsg =  '<div class="alert alert-danger">عذرا , هذا المستخدم موجود</div>';
                                        
                }else {
                    
                      $stmt = $con->prepare("UPDATE users SET email = ?, username = ?, password = ? WHERE id = ?");
            
                      $stmt->execute(array($email, $user , $pass, $id));
            
                      header('Location:  members?do=Edit&ID= ' . $id . ' ');
                      exit();
                    
                }
                
            }
            

            
        }else{
            
            echo '<div class="alert alert-danger">عذرا , لا تستطيع تصفح هذه الصفحة </div>';
            
        }
            
            echo "</div>";
        
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