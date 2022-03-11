<?php 

ob_start();

session_start();

if(isset($_SESSION['Admin'])){

$pageTitle = 'المجتمع';
    
include "init.php"; 
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; ?>
    

<div class="card general">
    <div class="card-header">
        <?php echo $pageTitle ;?>
    </div>
    <div class="card-body">
        
<?php        
    if($do == 'Manage'){ 
        
    $stmt = $con->prepare("SELECT * FROM society ORDER BY id DESC");
                        
    $stmt->execute();
                        
    $rows = $stmt->fetchAll();
        
?>


        <table class="main-table manage-members text-center table table-bordered">
        <tr class="head">
            <td>المستخدم</td>
            <td>العنوان </td>
            <td>التفاصيل</td>
            <td>القسم</td>
            <td>المشاهدات</td>
            <td> التحكم </td>
        </tr>
            
          <?php 
            
            foreach($rows as $row){
                
                echo "<tr>";
                
                $userID = $row['userID'];        
                $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
                $stmt1->execute(array($userID));
                $userInfo = $stmt1->fetch();
                                
                echo "<td>" . $userInfo['username'] . "</td>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['content'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "<td>" . $row['counter'] . "</td>";
                echo "<td>
                <a href='sosiety?do=Delete&ID=" . $row['id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo "</td>" ;
                echo "</tr>";
                
            }
            
            ?>  
                        
        </table>

 
<?php
    }elseif($do == 'Delete'){
                

        $userid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']):0;
        $stmt = $con->prepare("SELECT * FROM society WHERE id = ? LIMIT 1");
        $stmt->execute(array($userid));
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){ 
            
            $stmt = $con->prepare("DELETE FROM society WHERE id = :zuser");
            $stmt->bindParam(":zuser", $userid);
            $stmt->execute();
            
            header('Location:  sosiety?do=Manage');
            exit();

        }else {
            
            echo '<div class="alert alert-danger">هذا المستخدم غير موجود</div>';
                    
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